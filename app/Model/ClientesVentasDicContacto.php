<?php
App::uses('AppModel', 'Model');
/**
 * Cliente Model
 *
 * @property User $User
 * @property Lead $Lead
 */
class ClientesVentasDicContacto extends AppModel {

/**
 * Use database config
 *
 * @var string

 */
public $useTable = 'clientes';

/**
 * Display field
 *
 * @var string
 */
        //public $virtualFields = array('nombre_completo' => 'CONCAT(Cliente.nombre," ",Cliente.apellido_paterno," ",Cliente.apellido_materno)');
	public $displayField = 'nombre';

/**
 * Validation rules
 *
 * @var array
 */

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
	    'DicLineaContacto' => array(
	        'className' => 'DicLineaContacto',
	        'foreignKey' => 'dic_linea_contacto_id',
	        'conditions' => '',
	        'fields' => '',
	        'order' => ''
	    ) 
	);

	 public $hasAndBelongsToMany = array(
            'Venta'=>array(
                'className' => 'Venta',
                /*'joinTable' => 'cliente_id',*/
                'foreignKey' => 'user_id'
                /*,
                'associationForeignKey' => 'group_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'cuentas_users'*/
            )
        );

}
