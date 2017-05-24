<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {
	
	public $name = 'Pages';
	
	public function home() {
		$this->set('title_for_layout', __('Build easily applications in WPF, Windows 10 UWP and Xamarin Forms.'));
		
		if (!isset($this->request->params['language'])) {
			$language_default = Configure::read('language_default');
			$language_default = $language_default['alias']; // ex: pt
			$this->redirect(array('language' => $language_default));
		}		
	}
	
	public function documentation() {
		$this->set('title_for_layout', __('Documentation Prism for Xamarin'));
	}
	
	public function learn() {
		$this->set('title_for_layout', __('Learn Prism for Xamarin'));
	}
	
	public function discuss() {
		$this->set('title_for_layout', __('Discuss about Prism for Xamarin'));
	}
	
}