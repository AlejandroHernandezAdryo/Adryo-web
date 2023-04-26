<?php
App::uses('AppModel', 'Model');

class ExtrasDesarrollo extends AppModel {

	public $displayField = 'nombre';

    public $belongsTo = array(
        'Desarrollo' => array(
            'className' => 'Desarrollo',
            'foreignKey' => 'desarrollo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public $hasAndBelongsToMany = array(
        'Cotizaciones'=>array(
            'className' => 'Cotizacion',
            'joinTable' => 'cotizaciones_extras',
            'foreignKey' => 'extras_desarrollo_id',
            'associationForeignKey' => 'cotizacion_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'with' => 'cotizaciones_extras'
        ),

    );

}

