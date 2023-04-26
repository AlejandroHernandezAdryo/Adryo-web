<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class Venta extends AppModel {

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
	public $displayField = 'fecha';

/**
 * Validation rules
 *
 * @var array
 */
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
                
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public $hasMany = array(
		'Facturas' => array(
			'className' => 'Factura',
			'foreignKey' => 'venta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                
	);
}

