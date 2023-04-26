<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class ObjetivosVentasDesarrollo extends AppModel {

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
	public $displayField = 'monto';

/**
 * Validation rules
 *
 * @var array
 */
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
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
		),
	);

}

