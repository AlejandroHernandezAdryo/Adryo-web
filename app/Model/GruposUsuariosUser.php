<?php
App::uses('AppModel', 'Model');
/**
 * DocumentosUser Model
 *
 * @property User $User
 */
class GruposUsuariosUser extends AppModel {

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
		'GruposUsuario' => array(
			'className' => 'GruposUsuario',
			'foreignKey' => 'grupos_usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
                
	);
        
}
