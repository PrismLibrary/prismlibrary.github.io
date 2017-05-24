<?php
App::uses('PermissionsController', 'AuthAcl.Controller');

/**
 * PermissionsController Test Case
 *
 */
class PermissionsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.auth_acl.permission',
		'plugin.auth_acl.aro',
		'plugin.auth_acl.aco'
	);

}
