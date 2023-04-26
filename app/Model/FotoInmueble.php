<?php
App::uses('AppModel', 'Model');
/**
 * FotoInmueble Model
 *
 * @property Inmueble $Inmueble
 */
class FotoInmueble extends AppModel {

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
	public $displayField = 'id';

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
		'Inmueble' => array(
			'className' => 'Inmueble',
			'foreignKey' => 'inmueble_id',
			'conditions' => '',
			'fields' => '',
			'order' => 'FotoInmueble.orden ASC'
		)
	);
}
