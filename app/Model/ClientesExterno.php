<?php
App::uses('AppModel', 'Model');
/**
 * Cargo Model
 *
 * @property Empresa $Empresa
 * @property ActividadsRelacion $ActividadsRelacion
 * @property Pago $Pago
 */
class ClientesExterno extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre_comercial';


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
/**
 * belongsTo associations
 *
 * @var array
 */

	
/**
 * hasMany associations
 *
 * @var array
 */
public $hasMany = array(
	'Facturas' => array(
		'className' => 'Factura',
		'foreignKey' => 'clientes_externo_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
	),
        'Contactos' => array(
		'className' => 'Contacto',
		'foreignKey' => 'clientes_externo_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
	),
	'Documentos' => array(
		'className' => 'DocsClientesExterno',
		'foreignKey' => 'clientes_externo_id',
		'dependent' => false,
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'limit' => '',
		'offset' => '',
		'exclusive' => '',
		'finderQuery' => '',
		'counterQuery' => ''
	)
	
);
	
}
?>
