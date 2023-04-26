<?php
App::uses('AppModel', 'Model');
/**
 * Factura Model
 *
 * @property Proveedor $Proveedor
 * @property Pago $Pago
 */
class Factura extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'referencia';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Proveedor' => array(
			'className' => 'Proveedor',
			'foreignKey' => 'proveedor_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Desarrollo' => array(
			'className' => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
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
		),
        'Venta' => array(
			'className' => 'Venta',
			'foreignKey' => 'venta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Validador' => array(
			'className' => 'User',
			'foreignKey' => 'aut_pendiente',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cargado' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Categoria' => array(
			'className' => 'Categoria',
			'foreignKey' => 'categoria_id',
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
		'Documentos' => array(
			'className' => 'DocsFactura',
			'foreignKey' => 'factura_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Pagos' => array(
			'className' => 'Transaccion',
			'foreignKey' => 'factura_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'ValidacionFactura' => array(
			'className' => 'ValidacionFacturas',
			'foreignKey' => 'factura_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => 'ValidacionFactura.orden ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
