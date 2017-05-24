<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

class SettingsController extends  AuthAclAppController{
	var $uses = array('AuthAcl.Group','AuthAcl.Setting');
	
	public function admin_index(){
		$this->request->data['Setting']['setting_key'] = sha1('general');

		$setting = $this->Setting->find('first',array('conditions' => array('setting_key' => $this->request->data['Setting']['setting_key'])));
		if (!empty($setting)){
			$data = unserialize($setting['Setting']['setting_value']);
			if (!empty($data)){
				$this->request->data = am($this->request->data,$data);
			}
		}

		$groups = $this->Group->find('list');
		$this->set('groups',$groups);
	}

	public function admin_email($type = 'new_user'){
		$this->autoRender = false;
		if ($type == 'new_user'){
			$this->request->data['Setting']['setting_key'] = sha1('new_user');
			$setting = $this->Setting->find('first',array('conditions' => array('setting_key' => $this->request->data['Setting']['setting_key'])));
			if (!empty($setting)){
				$data = unserialize($setting['Setting']['setting_value']);
				if (!empty($data)){
					$this->request->data = am($this->request->data,$data);
				}
			}
			$this->render('admin_new_user');
		}else if ($type == 'reset_password'){
			$this->request->data['Setting']['setting_key'] = sha1('reset_password');
			$setting = $this->Setting->find('first',array('conditions' => array('setting_key' => $this->request->data['Setting']['setting_key'])));
			if (!empty($setting)){
				$data = unserialize($setting['Setting']['setting_value']);
				if (!empty($data)){
					$this->request->data = am($this->request->data,$data);
				}
			}
			$this->render('admin_reset_password');
		}

	}

	public function admin_save(){
		$this->autoRender = false;
		$var = array();
		$var['error'] = 0;
		$setting = array();
		$setting['Setting']['setting_key'] = $this->request->data['Setting']['setting_key'];
		$setting['Setting']['setting_value'] = serialize(array('Setting' =>$this->request->data['Setting']));

		if (sha1('general') == $this->request->data['Setting']['setting_key']){
			$setting['Setting']['email_address'] = $this->request->data['Setting']['email_address'];
			$this->Setting->validate = $this->Setting->general_validate;
		}

		if (!$this->Setting->save($setting)){
			$errors = $this->Setting->validationErrors;
			$var['error'] = 1;
			$var['error_message'] = $errors['email_address'][0]; 	
		}
		
		echo json_encode($var);
	}

}