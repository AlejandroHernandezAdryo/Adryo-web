<?php
App::uses('AppModel', 'Model');

class Validation extends AppModel {
    
    public $hasMany = array(
		'SubValidation' => array(
			'className' => 'SubValidation',
			// 'foreignKey' => '',
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