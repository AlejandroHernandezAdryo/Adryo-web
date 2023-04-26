<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class Reasignacion extends AppModel {

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
		'AsesorOriginal' => array(
			'className' => 'User',
			'foreignKey' => 'asesor_original',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'AsesorNuevo' => array(
			'className' => 'User',
			'foreignKey' => 'asesor_nuevo',
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

