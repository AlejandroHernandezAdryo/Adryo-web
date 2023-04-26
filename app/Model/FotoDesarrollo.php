<?php
App::uses('AppModel', 'Model');
/**
 * FotoDesarrollo Model
 *
 * @property Desarrollo $Desarrollo
 */
class FotoDesarrollo extends AppModel {

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
	public $displayField = 'ruta';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'desarrollo_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ruta' => array(
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
		'Desarrollo' => array(
			'className' => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
