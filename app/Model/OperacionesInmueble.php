<?php
App::uses('AppModel', 'Model');
/**
 * Agenda Model
 *
 * @property User $OperacionesInmueble
 * @property Lead $Lead
 */
class OperacionesInmueble extends AppModel {

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
		),

		'Cotizacion' => array(
			'className' => 'Cotizacion',
			'foreignKey' => 'cotizacion_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public $hasMany = array(
        'Documentos' => array(
            'className'    => 'DocsCliente',
            'foreignKey'   => 'operacion_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
		'LogPago' => array(
            'className' => 'LogPago',
            'foreignKey' => 'operaciones_inmueble_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
