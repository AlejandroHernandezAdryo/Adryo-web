<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class CuentaBancariaDesarrollo extends AppModel {

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
	public $displayField = 'cuenta_bancaria_id';

/**
 * Validation rules
 *
 * @var array
 */
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Desarrollo' => array(
			'clasName'  => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'Inmueble' => array(
			'clasName'  => 'Inmueble',
			'foreignKey' => 'inmueble_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'CuentasBancarias' => array(
			'clasName'  => 'Banco',
			'foreignKey' => 'cuenta_bancaria_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		)
	);
}
