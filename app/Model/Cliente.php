<?php
App::uses('AppModel', 'Model');
/**
 * Cliente Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class Cliente extends AppModel {

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
        //public $virtualFields = array('nombre_completo' => 'CONCAT(Cliente.nombre," ",Cliente.apellido_paterno," ",Cliente.apellido_materno)');
	public $displayField = 'nombre';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombre' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                
                'dic_linea_contacto_id' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
                
                'propiedades' => array(
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
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'Inmueble' => array(
			'className'  => 'Inmueble',
			'foreignKey' => 'inmueble_id',
			'conditions' => '',
			'fields'     => 'Inmueble.titulo',
			'order'      => ''
		),
		'Desarrollo' => array(
			'className'  => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
			'conditions' => '',
			'fields'     => 'Desarrollo.nombre',
			'order'      => ''
		),
		'DicTipoCliente' => array(
			'className'  => 'DicTipoCliente',
			'foreignKey' => 'dic_tipo_cliente_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'DicEtapa' => array(
			'className'  => 'DicEtapa',
			'foreignKey' => 'dic_etapa_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
		'DicLineaContacto' => array(
			'className'  => 'DicLineaContacto',
			'foreignKey' => 'dic_linea_contacto_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lead' => array(
			'className' => 'Lead',
			'foreignKey' => 'cliente_id',
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
        'Agenda' => array(
			'className' => 'Agenda',
			'foreignKey' => 'cliente_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Agenda.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Top5' => array(
			'className' => 'Agenda',
			'foreignKey' => 'cliente_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Top5.id DESC',
			'limit' => '5',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
        'LogCliente' => array(
			'className' => 'LogCliente',
			'foreignKey' => 'cliente_id',
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
		'EtapaActiva' => array(
			'className' => 'LogClientesEtapa',
			'foreignKey' => 'cliente_id',
			'dependent' => false,
			'conditions' => array('EtapaActiva.status' => 'Activo'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'LogEtapasCliente' => array(
			'className' => 'LogClientesEtapa',
			'foreignKey' => 'cliente_id',
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
		'Facturas' => array(
			'className' => 'Factura',
			'foreignKey' => 'cliente_id',
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
		'Cotizaciones' => array(
			'className' => 'Cotizacion',
			'foreignKey' => 'cliente_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ' id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'MisOperaciones' => array(
			'className'    => 'OperacionesInmueble',
			'foreignKey'   => 'cliente_id',
			'dependent'    => false,
			'conditions'   => array('MisOperaciones.status' => 'Activo'),
			'fields'       => '',
			'order'        => '',
			'limit'        => '',
			'offset'       => '',
			'exclusive'    => '',
			'finderQuery'  => '',
			'counterQuery' => '',
		),
	);

}
