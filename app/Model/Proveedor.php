<?php
App::uses('AppModel', 'Model');
/**
 * Cargo Model
 *
 * @property Empresa $Empresa
 * @property ActividadsRelacion $ActividadsRelacion
 * @property Pago $Pago
 */
class Proveedor extends AppModel {

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
		'foreignKey' => 'proveedor_id',
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
		'foreignKey' => 'proveedor_id',
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
		'className' => 'DocsProveedor',
		'foreignKey' => 'proveedors_id',
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
