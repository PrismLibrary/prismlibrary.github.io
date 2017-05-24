<?php
Router::connect('/', array('controller' => 'pages', 'action' => 'home'));

// Static pages
$pages = array('documentation', 'learn', 'discuss');
foreach ($pages as $page) {
	Router::connect('/' . $page, array('controller' => 'pages', 'action' => $page));

	// With other language
	Router::connect(
		'/:language/' . $page,
		array('controller' => 'pages', 'action' => $page),
		array('language' => '[a-z]{2}')
	);
}


// General language page
Router::connect(
	'/:language',
	array('controller' => 'pages', 'action' => 'home'),
	array('language' => '[a-z]{2}')
);

/**
* Load all plugin routes.  See the CakePlugin documentation on
* how to customize the loading of plugin routes.
*/
CakePlugin::routes();

/**
* Load the CakePHP default routes. Remove this if you do not want to use
* the built-in default routes.
*/
require CAKE . 'Config' . DS . 'routes.php';
