<?php
App::uses('AppModel', 'Model');
/**
 * Cargo Model
 *
 * @property Empresa $Empresa
 * @property ActividadsRelacion $ActividadsRelacion
 * @property Pago $Pago
 */
class Cluster extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre';


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
/**
 * belongsTo associations
 *
 * @var array
 */

	
/**
 * hasMany associations
 *
 * @var array
 */
public $hasAndBelongsToMany = array(
    'Desarrollos'=>array(
        'className' => 'Desarrollo',
        'joinTable' => 'desarrollos_clusters',
        'foreignKey' => 'cluster_id',
        'associationForeignKey' => 'desarrollo_id',
        'unique' => true,
        'conditions' => '',
        'fields' => '',
        'order' => '',
        'limit' => '',
        'offset' => '',
        'finderQuery' => '',
        'with' => 'desarrollos_clusters'
    )
);
	
}
?>
