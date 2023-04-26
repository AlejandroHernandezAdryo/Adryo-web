<?php
App::uses('AppModel', 'Model');
/**
 * DocumentosUser Model
 *
 * @property User $User
 */
class GruposUsuario extends AppModel {

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
	public $displayField = 'nombre_grupo';

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
		'Administrador' => array(
			'className' => 'User',
			'foreignKey' => 'administrador_id',
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
        
        public $hasAndBelongsToMany = array(
            'Usuarios'=>array(
                'className' => 'User',
                'joinTable' => 'grupos_usuarios_users',
                'foreignKey' => 'grupos_usuario_id',
                'associationForeignKey' => 'user_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'grupos_usuarios_users'
            ),
            
        );
        
        public $hasMany = array(
            'Desarrollo' => array(
                'className' => 'Desarrollo',
                'foreignKey' => 'grupos_usuario_id',
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
