<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class DesarrollosUser extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'user_id';

	public $belongsTo = array(
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'Desarrollo' => array(
			'className'  => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		)
	);
}
