<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
/**
 * Group Model
 *
*/
class Setting extends AuthAclAppModel {
	public $primaryKey = 'setting_key';

	public $general_validate = array(
		'email_address' => array(
			'required' => array(
				'rule' => array('notEmpty'),
				'message' => 'Digite o e-mail.'
			),
			'email' => array(
				'rule' => array('email'),
				'message' => 'Digite um endere&ccedil;o de e-mail v&aacute;lido..'
			)
		)
	);
}