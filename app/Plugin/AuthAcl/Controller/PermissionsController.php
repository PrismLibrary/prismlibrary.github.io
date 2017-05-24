<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');
App::import('Vendor', 'AuthAcl.functions');
/**
 * Permissions Controller
 *
*/
class PermissionsController extends AuthAclAppController {
	var $uses = array('AuthAcl.Group','AuthAcl.User');
	public $components = array('Acl');
	
	public function admin_index(){
		if ($this->request->isAjax()){
			$this->layout = null;
		}
		$groups = $this->Group->find('list');
		$this->set('groups',$groups);

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}

						}
					}
				} else {
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$this->set('acoController',$acoController);
		$this->set('acoPlugin',$acoPlugin);

		$this->Acl->Aro->recursive = 1;
		$groupAro = $this->Acl->Aro->find('all',array('conditions'=>array('model' =>'Group')));
		
		$permissions = array();
		foreach($groupAro as $aro){
			if (!empty($aro['Aco'])){
				foreach($aro['Aco'] as $aco){
					if (
						$aco['Permission']['_create'] == 1 &&
						$aco['Permission']['_read'] == 1 &&
						$aco['Permission']['_update'] == 1 &&
						$aco['Permission']['_delete'] == 1
					) {
						$permissions[$aro['Aro']['foreign_key']][$aco['id']] = 1;
					} else {
						$permissions[$aro['Aro']['foreign_key']][$aco['id']] = 0;
					}
				}
			}
		}

		$this->set('permissions',$permissions);
	}

	public function admin_user(){
		if ($this->request->isAjax()){
			$this->layout = null;
		}
		if ($this->request->isGet()){
			if (!empty($this->request->named['filter'])){
				$filter = array();
				$filter['Permission']['filter'] = $this->request->named['filter'];
				if (!empty($this->request->params['named']['page'])){
					$filter['Permission']['page'] = $this->request->named['page'];
				}else{
					$filter['Permission']['page'] = 1;
				}
				$this->request->data = am($this->request->data,$filter);
			}else{
				$filter = array();
				$filter['Permission'] = $this->Cookie->read('srcPassArg');
				if (!empty($filter['Permission'])){
					$this->request->data = am($this->request->data,$filter);
				}
			}
		}
		
		$passArg = array();
		$conditions = array();
		if (!empty($this->data['Permission']) && !empty($this->data['Permission']['filter'])){
			$conditions = array('OR' => array(' user_email LIKE '  => '%'.trim($this->data['Permission']['filter']).'%',
					' user_name LIKE '  => '%'.trim($this->data['Permission']['filter']).'%'
					));
			$passArg = $this->data['Permission'];
		}
		if (!empty($this->request->params['named']['page'])){
			$passArg['page'] = $this->request->params['named']['page'];
		}else{
			if (!empty($this->request->data['Permission']['page'])){
				$this->request->params['named']['page'] = $this->request->data['Permission']['page'];
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

		$this->set('users', $this->paginate('User'));
	}

	public function admin_userPermission($userId = ''){
		if ($this->request->isAjax()){
			$this->layout = null;
		}
		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}
						}
					}
				}else{
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$user = $this->User->find('first',array('conditions'=>array('id'=>$userId)));

		$this->Acl->Aro->recursive = 1;
		$userAro = $this->Acl->Aro->find('all',array('conditions'=>array('model' =>'User','foreign_key' => $userId)));

		$permissions = array();
		foreach($userAro as $aro){
			if (!empty($aro['Aco'])){
				foreach($aro['Aco'] as $aco){
					if ($aco['Permission']['_create'] == 1 &&
							$aco['Permission']['_read'] == 1 &&
							$aco['Permission']['_update'] == 1 &&
							$aco['Permission']['_delete'] == 1	){

						$permissions[$userId][$aco['id']] = 1;
					}else{
						$permissions[$userId][$aco['id']] = 0;
					}
				}
			}
		}

		$this->set('permissions',$permissions);
		$this->set('user',$user);
		$this->set('acoController',$acoController);
		$this->set('acoPlugin',$acoPlugin);
	}
	
	public function admin_syncAco(){
		$this->autoRender = false;
		App::uses('AclExtrasShell', 'AuthAcl.Console/Command');
		$aclExtraShell = new AclExtrasShell();
		$aclExtraShell->startup();
		$aclExtraShell->aco_sync();
	}
	
	public function admin_allow(){
		$this->autoRender = false;
		$groupId = $this->request->data['groupId'];
		$actionId = $this->request->data['actionId'];
		$actions = '';
		$parents = $this->Acl->Aco->getPath($actionId,array('alias'));
		
		if (count($parents) > 0){
			$action = array();
			foreach ($parents as $p){
				$action[] = $p['Aco']['alias'];
			}
			$actions = implode('/', $action);
		}
		
		$group = $this->Group;
		$group->id = $groupId;
		$this->Acl->allow($group, $actions);
	}

	public function admin_userAllow(){
		$this->autoRender = false;
		$userId = $this->request->data['userId'];
		$actionId = $this->request->data['actionId'];
		$actions = '';
		$parents = $this->Acl->Aco->getPath($actionId,array('alias'));
		if (count($parents) > 0){
			$action = array();
			foreach ($parents as $p){
				$action[] = $p['Aco']['alias'];
			}
			$actions = implode('/', $action);
		}

		$user = $this->User;
		$user->id = $userId;
		$this->Acl->allow($user, $actions);
	}

	public function admin_allowAll(){
		$this->autoRender = false;

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}
						}
					}
				}else{
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$groupId = $this->request->data['groupId'];
		$group = $this->Group;
		$group->id = $groupId;

		foreach($acoController as $controller){
			foreach ($controller['children'] as $action){
				if ($action['Aco']['alias'] == 'isAuthorized') continue;
				$strAction = 'controllers/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
				$this->Acl->allow($group, $strAction);

			}

		}

		foreach($acoPlugin as $plugin){
			foreach($plugin['children'] as $controller){
				if ($controller['Aco']['alias'] == 'AccessDenied') continue;
				foreach($controller['children'] as $action){
					if ($action['Aco']['alias'] == 'isAuthorized') continue;
					$strAction = 'controllers/'.$plugin['Aco']['alias'].'/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
					$this->Acl->allow($group, $strAction);
				}
			}
		}

	}

	public function admin_userAllowAll(){
		$this->autoRender = false;

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}

						}
					}
				}else{
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$userId = $this->request->data['userId'];
		$user = $this->User;
		$user->id = $userId;

		foreach($acoController as $controller){
			foreach ($controller['children'] as $action){
				if ($action['Aco']['alias'] == 'isAuthorized') continue;
				$strAction = 'controllers/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
				$this->Acl->allow($user, $strAction);

			}

		}

		foreach($acoPlugin as $plugin){
			foreach($plugin['children'] as $controller){
				if ($controller['Aco']['alias'] == 'AccessDenied') continue;
				foreach($controller['children'] as $action){
					if ($action['Aco']['alias'] == 'isAuthorized') continue;
					$strAction = 'controllers/'.$plugin['Aco']['alias'].'/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
					$this->Acl->allow($user, $strAction);
				}
			}
		}
	}

	public function admin_deny(){
		$this->autoRender = false;
		$groupId = $this->request->data['groupId'];
		$actionId = $this->request->data['actionId'];

		$actions = '';
		$parents = $this->Acl->Aco->getPath($actionId,array('alias'));
		if (count($parents) > 0){
			$action = array();
			foreach ($parents as $p){
				$action[] = $p['Aco']['alias'];
			}
			$actions = implode('/', $action);
		}

		$group = $this->Group;
		$group->id = $groupId;
		$this->Acl->deny($group, $actions);
	}

	public function admin_userDeny(){
		$this->autoRender = false;
		$userId = $this->request->data['userId'];
		$actionId = $this->request->data['actionId'];

		$actions = '';
		$parents = $this->Acl->Aco->getPath($actionId,array('alias'));
		if (count($parents) > 0){
			$action = array();
			foreach ($parents as $p){
				$action[] = $p['Aco']['alias'];
			}
			$actions = implode('/', $action);
		}

		$user = $this->User;
		$user->id = $userId;
		$this->Acl->deny($user, $actions);
	}

	public function admin_denyAll(){
		$this->autoRender = false;

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}

						}
					}
				}else{
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$groupId = $this->request->data['groupId'];
		$group = $this->Group;
		$group->id = $groupId;

		foreach($acoController as $controller){
			foreach ($controller['children'] as $action){
				if ($action['Aco']['alias'] == 'isAuthorized') continue;
				$strAction = 'controllers/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
				$this->Acl->deny($group, $strAction);

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
					$this->Acl->deny($group, $strAction);
				}
			}
		}
	}

	public function admin_userDenyAll(){
		$this->autoRender = false;

		$this->Acl->Aco->recursive = 0;
		$acoTree = $this->Acl->Aco->find('threaded');

		$acoPlugin = array();
		$acoController = array();
		$plugins = CakePlugin::loaded();

		if (!empty($acoTree[0]['children'])){
			foreach($acoTree[0]['children'] as $obj){
				if (in_array($obj['Aco']['alias'], $plugins)){
					$acoPlugin[$obj['Aco']['alias']]['Aco'] = $obj['Aco'];
					$acoPlugin[$obj['Aco']['alias']]['children'] = array();
					if (!empty($obj['children'])){
						foreach ($obj['children'] as $k => $controller){
							$acoPlugin[$obj['Aco']['alias']]['children'][$k]['Aco'] = $controller['Aco'];
							if (checkIsAuthorizedMethod($controller['children'])){
								$acoPlugin[$obj['Aco']['alias']]['children'][$k]['children'] = $controller['children'];
							}

						}
					}
				}else{
					if (checkIsAuthorizedMethod($obj['children'])){
						$acoController[$obj['Aco']['alias']] = $obj;
					}
				}
			}
		}

		$userId = $this->request->data['userId'];
		$user = $this->User;
		$user->id = $userId;

		foreach($acoController as $controller){
			foreach ($controller['children'] as $action){
				if ($action['Aco']['alias'] == 'isAuthorized') continue;
				$strAction = 'controllers/'.$controller['Aco']['alias'].'/'.$action['Aco']['alias'];
				$this->Acl->deny($user, $strAction);

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
					$this->Acl->deny($user, $strAction);
				}
			}
		}
	}
	
}