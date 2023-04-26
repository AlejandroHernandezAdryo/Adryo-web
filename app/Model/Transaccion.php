<?php
App::uses('AppModel', 'Model');
/**
 * Cargo Model
 *
 * @property Empresa $Empresa
 * @property ActividadsRelacion $ActividadsRelacion
 * @property Pago $Pago
 */
class Transaccion extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'referencia';


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
/**
 * belongsTo associations
 *
 * @var array
 */
public $belongsTo = array(
	'CuentaBancaria' => array(
		'className' => 'Banco',
		'foreignKey' => 'cuenta_bancaria_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	)
);
	
/**
 * hasMany associations
 *
 * @var array
 */

public $hasMany = array(
	'DocumentosPago' => array(
		'className' => 'DocsTransaccion',
		'foreignKey' => 'transaccions_id',
		'conditions' => '',
		'fields' => '',
		'order' => ''
	)
);
	
}
?>
