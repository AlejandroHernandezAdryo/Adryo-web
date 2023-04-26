<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class DicLineaContacto extends AppModel {

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
	public $displayField = 'linea_contacto';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
           
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
        public $belongsTo = array(
            'Cuenta' => array(
                'className' => 'Cuenta',
                'foreignKey' => 'cuenta_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            
		
	);

}
