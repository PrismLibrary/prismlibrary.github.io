<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

class AccessDeniedController extends AuthAclAppController{
	var $layout = 'default';

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	public function index(){
		App::uses('User', 'AuthAcl.Model');
		$userModel = new User();
		$user = $this->Auth->user();
		
		if (!empty($user)){
			$user = $userModel->find('first',array('conditions' => array('id' => $user['id'])));
			$this->Session->write('auth_user',$user);
				
			$this->request->data['auth_plugin'] = $this->plugin;
			$this->request->data['auth_controller'] = $this->name;
			$this->request->data['auth_action'] = $this->action;
		}

		$this->set('login_user',$this->Auth->user());
	}
}