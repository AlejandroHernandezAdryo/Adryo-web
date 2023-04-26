<?php
App::uses('AppModel', 'Model');




class DicFactura extends AppModel {
	public $displayField = 'nombre';




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
			'conditions' => '',
			'fields' => '',
			'order' => 'ValidacionCategoria.orden ASC',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
}
