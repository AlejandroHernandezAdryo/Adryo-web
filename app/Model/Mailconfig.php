<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class Mailconfig extends AppModel {

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
 * hasMany associations
 *
 * @var array
 */
        
        /*public $hasAndBelongsToMany = array(
            'Cuenta'=>array(
                'className' => 'Cuenta',
                'joinTable' => 'cuentas_users',
                'foreignKey' => 'user_id',
                'associationForeignKey' => 'cuenta_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => ''
            )
        );*/

}
