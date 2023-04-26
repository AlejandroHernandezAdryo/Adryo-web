<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class Mensaje extends AppModel {

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
	public $displayField = 'mensaje';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'mensaje' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Inmueble' => array(
			'className' => 'Inmueble',
			'foreignKey' => 'inmueble_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Inmueble.referencia ASC'
		),
		'Desarrollo' => array(
			'className' => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'Desarrollo.nombre ASC'
		),
                'Created' => array(
			'className' => 'User',
			'foreignKey' => 'created_by',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'To' => array(
			'className' => 'User',
			'foreignKey' => 'to',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                
	);
}
