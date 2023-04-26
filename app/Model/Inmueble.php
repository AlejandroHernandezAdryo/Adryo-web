<?php
App::uses('AppModel', 'Model');
/**
 * Inmueble Model
 *
 * @property Asesor $Asesor
 * @property Lead $Lead
 */
class Inmueble extends AppModel {

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
	public $displayField = 'referencia';

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
            'Opcionador' => array(
                'className' => 'User',
                'foreignKey' => 'opcionador_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'TipoPropiedad' => array(
                'className' => 'DicTipoPropiedad',
                'foreignKey' => 'dic_tipo_propiedad_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'TipoAnuncio' => array(
                'className' => 'DicTipoAnuncio',
                'foreignKey' => 'dic_tipo_anuncio_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'Cuenta' => array(
                'className' => 'Cuenta',
                'foreignKey' => 'cuenta_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FotoInmueble' => array(
			'className' => 'FotoInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'FotoInmueble.orden ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Lead' => array(
			'className' => 'Lead',
			'foreignKey' => 'inmueble_id',
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
		'Log' => array(
			'className' => 'LogInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Log.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Mails' => array(
			'className' => 'LogInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => array('Mails.accion'=>5),
			'fields' => 'Count(*) AS mails',
			'order' => 'Mails.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		'Citas' => array(
			'className' => 'LogInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => array('Citas.accion'=>6),
			'fields' => 'Count(*) AS citas',
			'order' => 'Citas.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Visitas' => array(
			'className' => 'LogInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => array('Visitas.accion'=>7),
			'fields' => 'Count(*) AS visitas',
			'order' => 'Visitas.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Precio' => array(
			'className' => 'Precio',
			'foreignKey' => 'inmueble_id',
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
		'Publicidad' => array(
			'className' => 'Publicidad',
			'foreignKey' => 'inmueble_id',
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
		'Venta' => array(
			'className' => 'Venta',
			'foreignKey' => 'inmueble_id',
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
		'DocumentosUser' => array(
			'className' => 'DocumentosUser',
			'foreignKey' => 'inmueble_id',
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
		'OperacionesInmueble' => array(
			'className' => 'OperacionesInmueble',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => array('OperacionesInmueble.status' => 'Activo'),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Evento' => array(
			'className' => 'Event',
			'foreignKey' => 'inmueble_id',
			'dependent' => false,
			'conditions' => array(
				'fecha_inicio >= CURDATE()',
				'fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)',
				'Evento.status'      => 1,
                'Evento.tipo_evento' => 1,
			),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		
	);

}
