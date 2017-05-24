<?php
App::uses('AppHelper', 'View/Helper');

class AclHelper extends AppHelper {
	public $helpers = array('Html','Session');

	public function link($title, $url = null, $options = array(), $confirmMessage = false) {
		$link = '';
		$controller = (!empty($url['controller']))?$url['controller']:((isset($this->request->data['auth_controller']))?$this->request->data['auth_controller']:'');
		$action = (!empty($url['action']))?$url['action']:((isset($this->request->data['auth_action']))?$this->request->data['auth_action']:'');
		$plugin = (!empty($url['plugin']))?$url['plugin']:((isset($this->request->data['auth_plugin']))?$this->request->data['auth_plugin']:'');

		if ($this->check($controller,$action,$plugin) == true){
			$link = $this->Html->link($title, $url, $options, $confirmMessage);
		}

		return $link;
	}

	public function check($controller,$action,$plugin = ''){
		
		//return true;

		$strAction = 'controllers';
		if (!empty($plugin)){
			$strAction .= '/'.$plugin;
		}
		$strAction .= '/'.$controller;
		$strAction .= '/'.$action;

		$allow = false;
		if ($this->Session->check('auth_user')){
			$user = $this->Session->read('auth_user');
			
			
			$privilege = ClassRegistry::getObject('Privilege');
			
			$pGroup = $privilege['Privilege']['permissions']['group'];
			$acos = $privilege['Privilege']['acos'];
			if (!empty($acos[$strAction])){
				if (!empty($user['Group'])){
					foreach ($user['Group'] as $group) {
						if (!empty($pGroup[$group['id']])){
							if (!empty($pGroup[$group['id']][$acos[$strAction]]) && (int)$pGroup[$group['id']][$acos[$strAction]] == 1){
								$allow = true;
								break;
							}

						}
					}
				}
			}
				
			$pUser = $privilege['Privilege']['permissions']['user'];
			if (!empty($acos[$strAction])){
				if (!empty($user['User'])){
					if (!empty($pUser[$user['User']['id']])){
						if (!empty($pUser[$user['User']['id']][$acos[$strAction]]) && (int)$pUser[$user['User']['id']][$acos[$strAction]] == 1){
							$allow = true;
						}
							
					}
				}
			}
		}

		return $allow;
	}
}