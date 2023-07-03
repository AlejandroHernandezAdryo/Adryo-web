<?php
App::uses('AppModel', 'Model');

class SubValidation extends AppModel {
    
    public $belongsTo = array(
		'Validation' => array(
			'className'  => 'Validation',
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