<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class LogCliente extends AppModel {

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
	public $displayField = 'mensaje';

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
            'Cliente' => array(
                'className' => 'Cliente',
                'foreignKey' => 'cliente_id',
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
            'Event' => array(
                'className' => 'Event',
                'foreignKey' => 'event_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            
		
	);

}
