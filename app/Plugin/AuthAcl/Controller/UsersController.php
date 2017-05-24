<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AuthAclAppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('admin_logout');
		$this->Auth->allow('admin_signup');
		$this->Auth->allow('admin_activate');
		$this->Auth->allow('admin_resetPassword');
		$this->Auth->allow('admin_signupcomplete');
		$this->Auth->allow('admin_activecomplete');
	}

	public function admin_index(){
		if ($this->request->isAjax()){
			$this->layout = null;
		}

		if ($this->request->isGet()){
			if (!empty($this->request->named['filter'])){
				$filter = array();
				$filter['User']['filter'] = $this->request->named['filter'];
				if (!empty($this->request->params['named']['page'])){
					$filter['User']['page'] = $this->request->named['page'];
				}else{
					$filter['User']['page'] = 1;
				}
				$this->request->data = am($this->request->data,$filter);
			}else{
				$filter = array();
				$filter['User'] = $this->Cookie->read('srcPassArg');
				if (!empty($filter['User'])){
					$this->request->data = am($this->request->data,$filter);
				}
			}
		}

		$passArg = array();
		$conditions = array();
		if (!empty($this->data['User']) && !empty($this->data['User']['filter'])){
			$conditions = array('OR' => array(' user_email LIKE '  => '%'.trim($this->data['User']['filter']).'%',
					' user_name LIKE '  => '%'.trim($this->data['User']['filter']).'%'
					));
					$passArg = $this->data['User'];
		}
		if (!empty($this->request->params['named']['page'])){
			$passArg['page'] = $this->request->params['named']['page'];
		}else{
			if (!empty($this->request->data['User']['page'])){
				$this->request->params['named']['page'] = $this->request->data['User']['page'];
			}
		}

		//$paginate = array('limit' => 2);
		$paginate = array();

		if (!empty($conditions)){
			$paginate['conditions'] = $conditions;
		}
		$this->paginate = $paginate;

		$this->set('passArg',$passArg);

		if (!empty($passArg)){
			$this->Cookie->write('srcPassArg',$passArg);
		}

		$this->set('auth_user',$this->Auth->user());

		$this->set('users', $this->paginate());
	}
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__(utf8_encode('Usuário inválido')));
		}
		$this->set('user', $this->User->read(null, $id));
	}
	/**
	 * add method
	 *
	 * @return void
	 */
	public function admin_add() {
		$errors = array();
		if ($this->request->is('post')) {
			$this->User->create();
			if (isset($this->request->data['User']['id'])){
				unset($this->request->data['User']['id']);
			}
			if ($this->User->save($this->request->data)) {
				$this->Cookie->delete('srcPassArg');
				$strAction = "controllers/AuthAcl/users/editAccount";
				$this->Acl->allow($this->User, $strAction);
				
				$strAction = "controllers/AuthAcl/AuthAcl/index";
				$this->Acl->allow($this->User, $strAction);
				
				$this->redirect(array('action' => 'index'));
			} else {
				$errors = $this->User->validationErrors;


			}
		}
		$this->set('errors',$errors);
		$groups = $this->User->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_edit($id = null) {
		if ($this->request->is('get')){
			$this->Session->write('update_user_id',$id);
		}
		
		$this->User->id = $id;
		$auth_user = $this->Auth->user();
		$errors = array();
		unset($this->User->validate['user_password']['required']);
		unset($this->User->validate['user_confirm_password']['required']);

		if (!$this->User->exists()) {
			throw new NotFoundException(__(utf8_encode('Usuário inválido')));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Session->read('update_user_id') != $id){
				throw new NotFoundException(__(utf8_encode("Não tente invadir")));
			}
			
			if (empty($this->request->data['User']['user_password'])){
				unset($this->request->data['User']['user_password']);
				unset($this->User->validate['user_confirm_password']['checkPassword']);
			}
			$user_email = $this->request->data['User']['user_email'];
			unset($this->request->data['User']['user_email']);
			unset($this->User->validate['user_email']);
			if ($auth_user['id'] == $id){
				unset($this->request->data['User']['user_status']);
			}
			if (isset($this->request->data['User']['id'])){
				unset($this->request->data['User']['id']);
			}
			if ($this->User->save($this->request->data)) {
				$this->redirect(array('action' => 'index'));
			} else {
				$this->request->data['User']['user_email'] = $user_email;
				$errors = $this->User->validationErrors;
			}
		} else {
			$this->request->data = am($this->request->data,$this->User->read(null, $id));
			unset($this->request->data['User']['user_password']);
		}
		$this->set('errors',$errors);
		$groups = $this->User->Group->find('list');
		$this->set('auth_user',$auth_user);
		$this->set(compact('groups'));
	}

	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function admin_delete($id = null) {
		$this->autoRender = false;
		$authUser = $this->Auth->user();
		if ($this->request->is('post') && $this->request->isAjax() && $authUser['id'] != $id) {
			$this->User->id = $id;
			if ($this->User->exists()) {
				$this->User->delete();
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	public function admin_editAccount($id = null) {
		
		$id = $this->Auth->user('id');
		$this->User->id = $id;
		$errors = array();
		
		unset($this->User->validate['user_password']['required']);
		unset($this->User->validate['user_confirm_password']['required']);
		unset($this->request->data['Group']);
		unset($this->request->data['User']['user_status']);
		
		if (!$this->User->exists()) {
			throw new NotFoundException(__(utf8_encode('Usuário inválido')));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			if (empty($this->request->data['User']['user_password'])){
				unset($this->request->data['User']['user_password']);
				unset($this->User->validate['user_confirm_password']['checkPassword']);
			}
			
			$user_email = $this->request->data['User']['user_email'];
			unset($this->request->data['User']['user_email']);
			unset($this->User->validate['user_email']);
			
			if (isset($this->request->data['User']['id'])){
				unset($this->request->data['User']['id']);
			}
			
			if ($this->User->save($this->request->data)) {
				
				// Recupera dados do usuário para atualizar a variável que mostra nome no administrativo
				$recupera = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $this->User->id)));
				
				// Reescreve a session
				$this->Session->write('Auth.User', $recupera['User']);
				
				$this->redirect(array('plugin' => 'auth_acl', 'controller' => 'auth_acl', 'action' => 'index'));
			} else {
				$this->request->data['User']['user_email'] = $user_email;
				$errors = $this->User->validationErrors;
			}
		} else {
			$this->request->data = am($this->request->data,$this->User->read(null, $id));
			unset($this->request->data['User']['user_password']);
		}
		
		$this->set('errors',$errors);
	}

	public function admin_login() {
		$this->layout = 'admin_login';
		$this->Session->delete('auth_user');
		App::uses('Setting', 'AuthAcl.Model');
		$Setting = new Setting();
		$error = null;

		$general = $Setting->find('first',array('conditions' => array('setting_key' => sha1('general'))));
		if (!empty($general)){
			$general = unserialize($general['Setting']['setting_value']);
		}

		$this->set('general',$general);

		$user = $this->Auth->user();
		if(!empty($user)){
			$this->redirect($this->Auth->redirect());
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				if ((int)$this->request->data['User']['remember_me'] == 0){
					$this->Cookie->delete('AutoLoginUser');
				}else{
					$this->Cookie->write('AutoLoginUser', $this->Auth->user(), true, '+2 weeks');
				}
				$this->redirect($this->Auth->redirect());
			} else {
				$error = __('Nome de usu&aacute;rio ou senha incorretos.');
			}
		}
		$this->set('error',$error);
	}

	public function admin_logout() {
		$this->autoRender = false;
		//$this->Session->setFlash('Good-Bye');
		$this->Session->delete('auth_user');
		$this->Cookie->delete('AutoLoginUser');
		$this->redirect($this->Auth->logout());
	}

	public function admin_changeStatus(){
		$this->autoRender = false;
		$authUser = $this->Auth->user();
		if ($this->request->isAjax() && $authUser['id'] != $this->request->data['User']['id']){
			$user = $this->User->read(null, $this->request->data['User']['id']);
			$this->request->data['User'] = am($user['User'],$this->request->data['User']);
			unset($this->request->data['User']['user_password']);
			$this->request->data['User']['user_code'] = '';
			$this->User->data = $this->request->data;
			$this->User->save($this->request->data,false);
		}
	}

	public function admin_resetPassword($code = null){
		$this->layout = 'admin_login'; 
		
		App::uses('Setting', 'AuthAcl.Model');
		$Setting = new Setting();

		$general = $Setting->find('first',array('conditions' => array('setting_key' => sha1('general'))));
		if (!empty($general)){
			$general = unserialize($general['Setting']['setting_value']);
		}
		if (isset($general['Setting']) && (int)$general['Setting']['disable_reset_password'] == 1){
			exit;
		}

		App::uses('CakeEmail', 'Network/Email');
		App::import('Vendor', 'AuthAcl.functions');
		$this->autoRender = false;
		if ($this->request->isAjax() && $code == null){
			$var = array();
			$sendLink = true;
			$user = $this->User->find('first',array('conditions' => array('user_email' => $this->request->data['User']['user_email'],
					'user_status' => 1)));
			if (!empty($user)){
				if (!empty($user['User']['user_code'])){
					$aryCode = explode('-', $user['User']['user_code']);
					if ($user['User']['user_code'] != sha1('reset_password'.$user['User']['user_email'].$aryCode[1]).'-'.$aryCode[1]){
						$sendLink = false;
					}
				}
			}else{
				$sendLink = false;
			}
			if ($sendLink == true){
				$time = time();
				$code = sha1('reset_password'.$user['User']['user_email'].$time).'-'.$time;

				$user['User']['user_code'] = $code;
				unset($user['User']['user_password']);
				unset($user['User']['modified']);
				if (isset($user['Group'])){
					unset($user['Group']);
				}
				if ($this->User->save($user,false)){

					$resetPasswordEmail = $Setting->find('first',array('conditions' => array('setting_key' => sha1('reset_password'))));
					if (!empty($resetPasswordEmail)){
						$resetPasswordEmail = unserialize($resetPasswordEmail['Setting']['setting_value']);
					}

					$email = new CakeEmail();
					$email->config('default');
					$email->from(array($general['Setting']['email_address'] => __('Por favor n&atilde;o responda')));
					$email->to($user['User']['user_email']);
					$email->subject($resetPasswordEmail['Setting']['request_subject']);

					$body = $resetPasswordEmail['Setting']['request_body'];

					$siteAddress = siteURL().$this->webroot;
					$resetLink = siteURL().$this->webroot."auth_acl/users/resetPassword/".$code;

					$body = str_replace('{site_address}', $siteAddress, $body);
					$body = str_replace('{user_name}', $user['User']['user_name'], $body);
					$body = str_replace('{user_email}', $user['User']['user_email'], $body);
					$body = str_replace('{reset_link}', $resetLink, $body);

					$email->send($body);
				}else{
					$sendLink = false;
				}
			}

			if ($sendLink == true){
				$var['send_link'] = 1;
			}else{
				$var['send_link'] = 0;
			}

			echo json_encode($var);
		}else{
			if ($this->request->isPost()){
				$errors = array();
				$resetFlag = false;
				$this->User->recursive = 0;
				$user = $this->User->find('first',array('conditions' => array('user_code' => $this->request->data['User']['code'],
					'user_status' => 1)));
				if (!empty($user)){
					if (!empty($user['User']['user_code'])){
						$aryCode = explode('-', $user['User']['user_code']);
						if ($user['User']['user_code'] == sha1('reset_password'.$user['User']['user_email'].$aryCode[1]).'-'.$aryCode[1]){
							if (time() - $aryCode[1] < 24*60*60){
								$user['User']['user_code'] = null;
								$user['User']['user_password'] = $this->request->data['User']['user_password'];
								$user['User']['user_confirm_password'] = $this->request->data['User']['user_confirm_password'];
								unset($user['User']['modified']);

								$this->User->validate = $this->User->reset_password_validate;
								if ($this->User->save($user)){

									$resetPasswordEmail = $Setting->find('first',array('conditions' => array('setting_key' => sha1('reset_password'))));
									if (!empty($resetPasswordEmail)){
										$resetPasswordEmail = unserialize($resetPasswordEmail['Setting']['setting_value']);
									}

									$email = new CakeEmail();
									$email->config('default');
									$email->from(array($general['Setting']['email_address'] => __('Por favor n&atilde;o responda')));
									$email->to($user['User']['user_email']);
									$email->subject($resetPasswordEmail['Setting']['success_subject']);

									$body = $resetPasswordEmail['Setting']['success_body'];

									$siteAddress = siteURL().$this->webroot;

									$body = str_replace('{site_address}', $siteAddress, $body);
									$body = str_replace('{user_name}', $user['User']['user_name'], $body);
									$body = str_replace('{user_email}', $user['User']['user_email'], $body);

									$email->send($body);
									$resetFlag = true;
								}else{
									$errors = $this->User->validationErrors;
								}
							}else{
								$errors['user_code'][] = __('Seu c&oacute;digo para redefinir a senha expirou');
							}
						}
					}
				}else{
					$errors['user_code'][] =  __('Seu c&oacute;digo para redefinir a senha n&atilde;o existe');
				}

				if ($resetFlag == true){
					$this->set('general',$general);
					$this->render('reset_password_success');
				}else{
					$this->set('code',$code);
					$this->set('errors',$errors);
					$this->render('reset_password');
				}
			}else{
				$this->set('code',$code);
				$this->set('errors',array());
				$this->render('reset_password');
			}
		}

	}

	public function admin_signup(){
		$this->layout = 'admin_login';
		App::uses('Setting', 'AuthAcl.Model');
		$Setting = new Setting();

		App::import('Vendor', 'AuthAcl.recaptcha/recaptchalib');
		$errors = array();

		$general = $Setting->find('first',array('conditions' => array('setting_key' => sha1('general'))));
		if (!empty($general)){
			$general = unserialize($general['Setting']['setting_value']);
		}

		if (isset($general['Setting']) && (int)$general['Setting']['disable_registration'] == 1){
			exit;
		}

		$this->set('general',$general);

		$groupDefault = (int) $general['Setting']['default_group'];

		$this->User->validate = $this->User->signup_validate;
		if ($this->request->is('post')) {
			$this->User->create();

			if (isset($general['Setting']) && (int)$general['Setting']['require_email_activation'] == 1){
				$time = time();
				$code = sha1('activate'.$this->request->data['User']['user_email'].$time).'-'.$time;
				$this->request->data['User']['user_code'] = $code;
			}else{
				$this->request->data['User']['user_status'] = 1;
			}

			$group = $this->User->Group->find('first',array('conditions' => array('id' => $groupDefault)));

			if (!empty($group)){
				$this->request->data['Group'] = $group['Group'];
			}

			if ($this->User->saveAssociated($this->request->data)) {

				if (isset($general['Setting']) && (int)$general['Setting']['require_email_activation'] == 1){
					$newUserEmail = $Setting->find('first',array('conditions' => array('setting_key' => sha1('new_user'))));
					if (!empty($newUserEmail)){
						$newUserEmail = unserialize($newUserEmail['Setting']['setting_value']);
					}

					App::uses('CakeEmail', 'Network/Email');
					App::import('Vendor', 'AuthAcl.functions');

					$email = new CakeEmail();
					$email->config('default');
					$email->from(array($general['Setting']['email_address'] => __('Por favor n&atilde;o responda')));
					$email->to($this->request->data['User']['user_email']);
					$email->subject($newUserEmail['Setting']['send_link_subject']);

					$body = $newUserEmail['Setting']['send_link_body'];

					$siteAddress = siteURL().$this->webroot;
					$activationLink = siteURL().$this->webroot."auth_acl/users/activate/".$code;

					$body = str_replace('{site_address}', $siteAddress, $body);
					$body = str_replace('{user_name}', $this->request->data['User']['user_name'], $body);
					$body = str_replace('{user_email}', $this->request->data['User']['user_email'], $body);
					$body = str_replace('{activation_link}', $activationLink, $body);


					$email->send($body);
				}
				
				$strAction = "controllers/AuthAcl/users/editAccount";
				$this->Acl->allow($this->User, $strAction);
				
				$strAction = "controllers/AuthAcl/AuthAcl/index";
				$this->Acl->allow($this->User, $strAction);
				
				$this->Session->write('signup_complete',1);
				
				$this->redirect(array('action' => 'signupcomplete'));
			} else {
				$errors = $this->User->validationErrors;


			}
		}
		$this->set('errors',$errors);
	}
	
	public function admin_signupcomplete(){
		$this->layout = 'admin_login';
		if (!$this->Session->check('signup_complete')){
			$this->redirect(array('action' => 'login'));
		}
		$this->Session->delete('signup_complete');
		
		App::uses('Setting', 'AuthAcl.Model');
		$Setting = new Setting();
		
		$general = $Setting->find('first',array('conditions' => array('setting_key' => sha1('general'))));
		if (!empty($general)){
			$general = unserialize($general['Setting']['setting_value']);
		}
		
		if (isset($general['Setting']) && (int)$general['Setting']['disable_registration'] == 1){
			exit;
		}
		$this->set('general',$general);
		
	}

	public function admin_activate($code = ''){
		App::uses('Setting', 'AuthAcl.Model');
		$Setting = new Setting();
		$this->autoRender = false;
		if ($code != ''){
			$user = $this->User->find('first',array('conditions' => array('user_code'=>$code)));
			if (!empty($user)){
				$ary = explode('-', $code);
				if ($code == sha1('activate'.$user['User']['user_email'].$ary[1]).'-'.$ary[1]){
					$user['User']['user_code'] = null;
					$user['User']['user_status'] = 1;
					unset($user['User']['user_password']);
					unset($user['User']['modified']);
					if (isset($user['Group'])){
						unset($user['Group']);
					}
					if ($this->User->save($user,false)){
						App::uses('CakeEmail', 'Network/Email');
						App::import('Vendor', 'AuthAcl.functions');

						$general = $Setting->find('first',array('conditions' => array('setting_key' => sha1('general'))));
						if (!empty($general)){
							$general = unserialize($general['Setting']['setting_value']);
						}
						$newUserEmail = $Setting->find('first',array('conditions' => array('setting_key' => sha1('new_user'))));
						if (!empty($newUserEmail)){
							$newUserEmail = unserialize($newUserEmail['Setting']['setting_value']);
						}

						$email = new CakeEmail();
						$email->config('default');
						$email->from(array($general['Setting']['email_address'] => __('Por favor n&atilde;o responda')));
						$email->to($user['User']['user_email']);
						$email->subject($newUserEmail['Setting']['activated_subject']);

						$body = $newUserEmail['Setting']['activated_body'];
						$siteAddress = siteURL().$this->webroot;

						$body = str_replace('{site_address}', $siteAddress, $body);
						$body = str_replace('{user_name}', $user['User']['user_name'], $body);
						$body = str_replace('{user_email}', $user['User']['user_email'], $body);

						$email->send($body);
						
						$this->Session->write('active_complete',1);
					}

				}
			}
		}



		$this->redirect(array('action' => 'activecomplete'));

	}
	
	public function admin_activecomplete(){
		$this->layout = 'admin_login';
		if (!$this->Session->check('active_complete')){
			$this->redirect(array('action' => 'login'));
		}
		$this->Session->delete('active_complete');
		
	}
}
