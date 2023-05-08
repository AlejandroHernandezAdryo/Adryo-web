<?php
App::uses('AppModel', 'Model');

class LogPago extends AppModel {
    

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
		),

		'Cotizacion' => array(
			'className' => 'Cotizacion',
			'foreignKey' => 'cotizacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OperacionesInmueble' => array(
			'className' => 'OperacionesInmueble',
			'foreignKey' => 'operaciones_inmueble_id',
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


	public $hasMany = array(
        'Cotizacion' => array(
			'className' => 'Cotizacion',
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
        
    
    );

}