<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
*/
class AppController extends Controller {
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		
		
		// LANGUAGE
		
		$languageTmp;
		
		// Se acessar URL sem idioma
		if ($this->params['language'] == '' || $this->params['language'] == NULL) {
			$language_default = Configure::read('language_default');
			$languageTmp = $language_default['alias']; // ex: en
		} else {
			$languageTmp = $this->params['language']; // ex: jp
		}
		
		$languageExists = false;
		
		// Scans the array until it finds the language which user is
		foreach (Configure::read('languages') as $language) {
			if ($language['alias'] == $languageTmp) {
				$currentLanguage = $language;
				$languageExists = true;
			}
		}
		
		// If user tries to access a language does not exist (core.php)
		if (!($languageExists)) {
			$this->redirect(array('plugin' => false, 'controller' => 'pages', 'action' => 'home'));
		}
		
		$this->Session->write('Config.language', $currentLanguage['locale']);
		
		$this->current_language = $currentLanguage['alias'];
		$this->set('current_language', $this->current_language);
		
		// END LANGUAGE
		
		
		
		//$this->Auth->allow();
		//$this->Auth->allow("*");
	}

}