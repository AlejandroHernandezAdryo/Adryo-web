<?php
App::uses('AppModel', 'Model');
/**
 * Categoria Model
 *
 * @property Proyecto $Proyecto
 * @property Factura $Factura
 * @property ValidacionCategorium $ValidacionCategorium
 */
class Categoria extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
    public $displayField = 'nombre';
    


	//The Associations below have been created with all possible keys, those that are not needed can be removed

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
		),
                'DicFactura' => array(
			'className' => 'DicFactura',
			'foreignKey' => 'dic_factura_id',
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
	public $hasMany = array(
		'Factura' => array(
			'className' => 'Factura',
			'foreignKey' => 'categoria_id',
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
		'ValidacionCategoria' => array(
			'className' => 'ValidacionCategoria',
			'foreignKey' => 'categoria_id',
			'dependent' => false,
			'conditions' => 'ValidacionCategoria.estado = 2',
			'fields' => '',
			'order' => 'ValidacionCategoria.orden ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
                'ValidacionPago' => array(
			'className' => 'ValidacionCategoria',
			'foreignKey' => 'categoria_id',
			'dependent' => false,
			'conditions' => 'estado = 3',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
