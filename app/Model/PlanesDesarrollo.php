<?php
App::uses('AppModel', 'Model');
/**
 * Lead Model
 *
 * @property Cliente $Cliente
 * @property Inmueble $Inmueble
 * @property Agenda $Agenda
 */
class PlanesDesarrollo extends AppModel {

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
	public $displayField = 'alias';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Desarrollo' => array(
			'className' => 'Desarrollo',
			'foreignKey' => 'desarrollo_id',
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
	

}
