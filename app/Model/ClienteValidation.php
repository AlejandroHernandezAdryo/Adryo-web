<?php
App::uses('AppModel', 'Model');

class ClienteValidation extends AppModel {
    public $hasMany = array(
        'Validation' => array(
            'className' => 'validacion_id',
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