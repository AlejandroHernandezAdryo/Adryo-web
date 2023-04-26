<?php
App::uses('AppModel', 'Model');
/**
 * Cliente Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class Publicidad extends AppModel {

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
        //public $virtualFields = array('nombre_completo' => 'CONCAT(Cliente.nombre," ",Cliente.apellido_paterno," ",Cliente.apellido_materno)');
	public $displayField = 'nombre';

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'user_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
		),
                'Inmueble' => array(
                    'className' => 'Inmueble',
                    'foreignKey' => 'inmueble_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
		),
                'Desarrollo' => array(
                    'className' => 'Desarrollo',
                    'foreignKey' => 'desarrollo_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
		),
                'DicLineaContacto' => array(
                    'className' => 'DicLineaContacto',
                    'foreignKey' => 'dic_linea_contacto_id',
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

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Lead' => array(
			'className' => 'Lead',
			'foreignKey' => 'cliente_id',
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
                'Agenda' => array(
			'className' => 'Agenda',
			'foreignKey' => 'cliente_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => 'Agenda.id DESC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
                'LogCliente' => array(
			'className' => 'LogCliente',
			'foreignKey' => 'cliente_id',
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
