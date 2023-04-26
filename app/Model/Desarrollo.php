<?php
App::uses('AppModel', 'Model');
/**
 * Desarrollo Model
 *
 * @property DesarrolloInmueble $DesarrolloInmueble
 */
class Desarrollo extends AppModel {

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
	public $displayField = 'nombre';

/**
 * Validation rules
 *
 * @var array
 */
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
    public $hasMany = array(
        'Facturas' => array(
            'className' => 'Factura',
            'foreignKey' => 'desarrollo_id',
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
        'Categoria' => array(
            'className' => 'Categoria',
            'foreignKey' => 'desarrollo_id',
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
        'FotoDesarrollo' => array(
            'className' => 'FotoDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => 'FotoDesarrollo.tipo_archivo = 1',
            'fields' => '',
            'order' => 'FotoDesarrollo.orden ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FotoDesarrolloQ' => array(
            'className' => 'FotoDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => 'FotoDesarrolloQ.tipo_archivo = 1',
            'fields' => 'count(*)',
            'order' => 'FotoDesarrolloQ.orden ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Planos' => array(
            'className' => 'FotoDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => 'Planos.tipo_archivo = 2',
            'fields' => '',
            'order' => 'Planos.orden ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'PlanosQ' => array(
            'className' => 'FotoDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => 'PlanosQ.tipo_archivo = 2',
            'fields' => 'count(*)',
            'order' => 'PlanosQ.orden ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Lead' => array(
            'className' => 'Lead',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
            'group'=>'Lead.cliente_id',
        ),
        'DocumentosUser' => array(
            'className' => 'DocumentosUser',
            'foreignKey' => 'desarrollo_id',
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
        'Mensaje' => array(
            'className' => 'Mensaje',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => 'Mensaje.expiration_date >= CURDATE()',
            'fields' => '',
            'order' => 'Mensaje.expiration_date ASC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Evento' => array(
            'className' => 'Event',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => array('fecha_inicio >= CURDATE()', 'fecha_inicio <= DATE_ADD(CURDATE(), INTERVAL 15 DAY)'),
            'fields' => '',
            'order' => '',
            'limit' => '15',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Log' => array(
            'className' => 'LogDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'Log.id DESC',
            'limit' => '5',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Publicidad' => array(
            'className' => 'Publicidad',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => array('fecha_inicio' => 'DESC'),
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ObjetivoAplicable' => array(
            'className' => 'ObjetivosVentasDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'fecha DESC',
            'limit' => '1',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'AvancesConstruccion' => array(
            'className' => 'AvancesDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'fecha DESC',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'UltimoAvance' => array(
            'className' => 'AvancesDesarrollo',
            'foreignKey' => 'desarrollo_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'id DESC',
            'limit' => '1',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'PlanesPago' => array(
            'className' => 'PlanesDesarrollo',
            'foreignKey' => 'desarrollo_id',
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
        'CuentasBancarias' => array(
            'className'    => 'CuentasBancariasDesarrollo',
            'foreignKey'   => 'desarrollo_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
        'Extras' => array(
            'className'    => 'ExtrasDesarrollo',
            'foreignKey'   => 'desarrollo_id',
            'dependent'    => false,
            'conditions'   => '',
            'fields'       => '',
            'order'        => '',
            'limit'        => '',
            'offset'       => '',
            'exclusive'    => '',
            'finderQuery'  => '',
            'counterQuery' => ''
        ),
    );
    
    public $belongsTo = array(
        'Cuenta' => array(
            'className' => 'Cuenta',
            'foreignKey' => 'cuenta_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            ),
        'EquipoTrabajo' => array(
            'className' => 'GruposUsuario',
            'foreignKey' => 'grupos_usuario_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            ),
        'Comercializador' => array(
            'className' => 'Cuenta',
            'foreignKey' => 'comercializador_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
            ),
	);
    
    public $hasAndBelongsToMany = array(
            'Propiedades'=>array(
                'className' => 'Inmueble',
                'joinTable' => 'desarrollo_inmuebles',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'inmueble_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'desarrollo_inmuebles'
            ),
            
            'Disponibles'=>array(
                'className' => 'Inmueble',
                'joinTable' => 'desarrollo_inmuebles',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'inmueble_id',
                'unique' => true,
                'conditions' => 'inmueble_id IN (SELECT id FROM inmuebles WHERE liberada = 1)',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'desarrollo_inmuebles'
            ),
            'Apartadas'=>array(
                'className' => 'Inmueble',
                'joinTable' => 'desarrollo_inmuebles',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'inmueble_id',
                'unique' => true,
                'conditions' => 'inmueble_id IN (SELECT id FROM inmuebles WHERE liberada = 2)',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'desarrollo_inmuebles'
            ),
            'Vendidas'=>array(
                'className' => 'Inmueble',
                'joinTable' => 'desarrollo_inmuebles',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'inmueble_id',
                'unique' => true,
                'conditions' => 'inmueble_id IN (SELECT id FROM inmuebles WHERE liberada = 3 OR liberada = 4)',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'desarrollo_inmuebles'
            ),
            'Interesados'=>array(
                'className' => 'Cliente',
                'joinTable' => 'leads',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'cliente_id',
                'unique' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'finderQuery' => '',
                'with' => 'leads'
            ),
            'Clusters'=>array(
                'className' => 'Cluster',
                'joinTable' => 'desarrollos_clusters',
                'foreignKey' => 'desarrollo_id',
                'associationForeignKey' => 'cluster_id',
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
