<?php

class AdminController extends AppController {
	public $components = array(
		'Acl',
		'Auth' => array(
			'authorize' => 'Controller',
			'authenticate' => array(
				'Form' => array(
					'fields' => array(
						'username' => 'user_email',
						'password' => 'user_password'
					),
					'scope' => array('`User`.`user_status`' => 1)
				),
			),
		),
		'Session',
		'Cookie'
	);
	
	public $helpers = array('Html', 'Form', 'Session','AuthAcl.Acl');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login','plugin' =>'auth_acl');
		$this->Auth->loginRedirect = array('controller' => 'auth_acl', 'action' => 'index','plugin'=> 'auth_acl');
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login','plugin'=> 'auth_acl');

		$user = $this->Auth->user();
		if(empty($user)){
			$user = $this->Cookie->read('AutoLoginUser');
			if(!empty($user)){
				$this->Auth->login($user);

			}
		}

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree) && !empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];

						}
					}
				}else{
					$acoController[$obj['Aco']['alias']] = $obj;
				}
			}
		}

		$acos = array();

		foreach($acoController as $controller){
			foreach ($controller['children'] as $action){
				if ($action['Aco']['alias'] == 'isAuthorized') continue;
				$strAction = 'controllers/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
				$acos[$strAction] = $action['Aco']['id'];
			}
		}

		foreach($acoPlugin as $plugin){
			foreach($plugin['children'] as $controller){
				if ($controller['Aco']['alias'] == 'AccessDenied') continue;
				foreach($controller['children'] as $action){
					if ($action['Aco']['alias'] == 'isAuthorized') continue;
					if ($action['Aco']['alias'] == 'login') continue;
					if ($action['Aco']['alias'] == 'logout') continue;
					if ($action['Aco']['alias'] == 'signup') continue;
					if ($action['Aco']['alias'] == 'activate') continue;
					if ($action['Aco']['alias'] == 'editAccount') continue;
					if ($action['Aco']['alias'] == 'resetPassword') continue;
					$strAction = 'controllers/'.$plugin['Aco']['alias'].'/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
					$acos[$strAction] = $action['Aco']['id'];
				}
			}
		}
		
		$privilege = array();
		
		$privilege['Privilege']['acos'] = $acos;

		$this->Acl->Aro->recursive = 1;
		$groupAro = $this->Acl->Aro->find('all',array('conditions'=>array('model' =>'Group')));

		$permissions = array();
		foreach($groupAro as $aro){
			if (!empty($aro['Aco'])){
				foreach($aro['Aco'] as $aco){
					if ($aco['Permission']['_create'] == 1 &&
					$aco['Permission']['_read'] == 1 &&
					$aco['Permission']['_update'] == 1 &&
					$aco['Permission']['_delete'] == 1	){
						$permissions[$aro['Aro']['foreign_key']][$aco['id']] = 1;
					}
				}
			}
		}
		$privilege['Privilege']['permissions']['group'] = $permissions;

		$this->Acl->Aro->recursive = 1;
		$groupAro = $this->Acl->Aro->find('all',array('conditions'=>array('model' =>'User')));

		$permissions = array();
		foreach($groupAro as $aro){
			if (!empty($aro['Aco'])){
				foreach($aro['Aco'] as $aco){
					if ($aco['Permission']['_create'] == 1 &&
					$aco['Permission']['_read'] == 1 &&
					$aco['Permission']['_update'] == 1 &&
					$aco['Permission']['_delete'] == 1	){
						$permissions[$aro['Aro']['foreign_key']][$aco['id']] = 1;
					}
				}
			}
		}
		$privilege['Privilege']['permissions']['user'] = $permissions;
		ClassRegistry::addObject('Privilege', $privilege);

	}

	public function isAuthorized($user = null) {
		App::uses('User', 'AuthAcl.Model');
		App::uses('Group', 'AuthAcl.Model');

		$authFlag = false;
		$this->set('login_user',$user);
		$userModel = new User();
		$group = new Group();
		$rs = $userModel->find('first',array('conditions'=>array('id' => $user['id'])));
		$action = 'controllers';
		if (!empty($this->plugin)){
			$action .= '/'.$this->plugin;
		}
		$action .= '/'.$this->name;
		$action .= '/'.$this->action;
		
		if (!empty($rs['Group'])){
			foreach ($rs['Group'] as $group){
				$authFlag = $this->Acl->check(array('Group' => array('id' => $group['id'])), $action);
				if ($authFlag == true){
					break;
				}
			}
		}
		
		if ($authFlag == false && !empty($user)){
			$authFlag = $this->Acl->check(array('User' => array('id' => $user['id'])), $action);
		}

		if ($authFlag == false && !empty($user)){
			$this->redirect(array($this->params['prefix'] => false, 'controller' => 'accessDenied', 'action' => 'index','plugin' =>'auth_acl'));
		}

		if (!empty($user)){
			$user = $userModel->find('first',array('conditions' => array('id' => $user['id'])));
			$this->Session->write('auth_user',$user);

			$this->request->data['auth_plugin'] = $this->plugin;
			$this->request->data['auth_controller'] = $this->name;
			$this->request->data['auth_action'] = $this->action;
		}
		
		return $authFlag;
	}
}