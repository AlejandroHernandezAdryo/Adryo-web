<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class Cotizacion extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $belongsTo = array(
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
		'Asesor' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}


