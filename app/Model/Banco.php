<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class Banco extends AppModel {

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
	public $displayField = 'nombre_cuenta';
	public $useTable = 'cuentas_bancarias';

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
	public $hasMany = array(
		'Transaccions' => array(
			'className' => 'Transaccion',
			'foreignKey' => 'cuenta_bancaria_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'Retiros' => array(
			'className' => 'Transaccion',
			'foreignKey' => 'cuenta_bancaria_id',
			'conditions' => 'tipo_transaccion = 2',
			'fields' => 'SUM(monto) as retiros',
			'order' => ''
		),
                'Depositos' => array(
			'className' => 'Transaccion',
			'foreignKey' => 'cuenta_bancaria_id',
			'conditions' => 'tipo_transaccion = 1',
			'fields' => 'SUM(monto) as depositos',
			'order' => ''
		)
	);
	
	public $hasAndBelongsToMany = array(
            'Desarrollo'=>array(
                'className' => 'Desarrollo',
                'joinTable' => 'cuenta_bancaria_desarrollos',
                'foreignKey' => 'cuenta_bancaria_id',
                'associationForeignKey' => 'desarrollo_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'cuenta_bancaria_desarrollos'
            ),
        );    
}
