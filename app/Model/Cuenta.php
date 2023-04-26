<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Agenda $Agenda
 * @property Cliente $Cliente
 */
class Cuenta extends AppModel {

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
	public $displayField = 'nombre_comercial';

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
        
        public $hasMany = array(
            'CuentasUser' => array(
                'className' => 'CuentasUser',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicEtapa' => array(
                'className' => 'DicEtapa',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicTipoCliente' => array(
                'className' => 'DicTipoCliente',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicTipoAnuncio' => array(
                'className' => 'DicTipoAnuncio',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicTipoPropiedad' => array(
                'className' => 'DicTipoPropiedad',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicLineaContactos' => array(
                'className' => 'DicLineaContactos',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'DicEmbudoVenta' => array(
                'className' => 'DicEmbudoVenta',
                'foreignKey' => 'cuenta_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ),
            'Desarrollo' => array(
                    'className' => 'Desarrollo',
                    'foreignKey' => 'cuenta_id',
                    'dependent' => true,
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'limit' => '',
                    'offset' => '',
                    'exclusive' => '',
                    'finderQuery' => '',
                    'counterQuery' => ''
		),
            'Inmuebles' => array(
                    'className' => 'Inmueble',
                    'foreignKey' => 'cuenta_id',
                    'dependent' => true,
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                    'limit' => '',
                    'offset' => '',
                    'exclusive' => '',
                    'finderQuery' => '',
                    'counterQuery' => ''
		),
            'Publicidad' => array(
                    'className' => 'Publicidad',
                    'foreignKey' => 'cuenta_id',
                    'dependent' => true,
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
            
        
        public $belongsTo = array(
            'MailConfig' => array(
                'className' => 'Mailconfig',
                'foreignKey' => 'mailconfig_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
            'Parametros' => array(
                'className' => 'Paramconfig',
                'foreignKey' => 'paramconfig_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ),
		
	);

}
