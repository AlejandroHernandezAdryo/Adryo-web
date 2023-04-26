<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class Ticket extends AppModel {

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
	public $displayField = 'id';

/**
 * Validation rules
 *
 * @var array
 */
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
        public $belongsTo = array(
		'Desarrollo' => array(
			'className' => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Inmueble' => array(
			'className' => 'Inmueble',
			'foreignKey' => 'inmueble_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}


