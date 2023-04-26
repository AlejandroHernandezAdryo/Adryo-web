<?php
App::uses('AppController', 'Controller');
/**
 * Tickets Controller
 *
 * @property Ticket $Ticket
 * @property PaginatorComponent $Paginator
 */
class CpsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $uses = array('Cp');

        public function beforeFilter() {
            parent::beforeFilter();
        }


    /* -------------------------------------------------------------------------- */
    /*                              Busquedas por CP                              */
    /* -------------------------------------------------------------------------- */
    public function get_estados() {
        header('Content-type: application/json; charset=utf-8');
          
        $resp = $this->Cp->find('list', array(
            'conditions' => array('cp' => $this->request->data['cp']),
            'order' => 'Cp.estado ASC',
            'fields' => array('Cp.estado', 'Cp.estado'),
            'group' => array('Cp.estado'),
        ));

        echo json_encode($resp, true);
        $this->autoRender = false;
	}

    public function get_colonias() {
        $resp = $this->Cp->find('list', array(
            'conditions' => array('cp' => $this->request->data['cp']),
            'order' => 'Cp.colonia ASC',
            'fields' => array('Cp.colonia', 'Cp.colonia'),
        ));

        echo json_encode($resp, true);
        $this->autoRender = false;
	}

    public function get_ciudad() {
        $resp = $this->Cp->find('list', array(
            'conditions' => array('cp' => $this->request->data['cp']),
            'order' => 'Cp.ciudad ASC',
            'fields' => array('Cp.ciudad', 'Cp.ciudad'),
            'group' => array('Cp.ciudad'),
        ));

        echo json_encode($resp, true);
        $this->autoRender = false;
	}

    public function get_delegacion() {
        $resp = $this->Cp->find('list', array(
            'conditions' => array('cp' => $this->request->data['cp']),
            'order' => 'Cp.estado ASC',
            'fields' => array('Cp.municipio', 'Cp.municipio'),
            'group' => array('Cp.municipio'),
        ));

        echo json_encode($resp, true);
        $this->autoRender = false;
	}


    /* -------------------------------------------------------------------------- */
    /*                         Listado de estados en Json                         */
    /* -------------------------------------------------------------------------- */
    function estados_json(){
        header('Content-type: application/json charset=utf-8');
        // Consulta de los estados para agregarlos a un input.
        $estados = $this->Cp->find('list', array(
          'group'  => array('estado'),
          'fields' => array('estado')
        ));
    
        echo json_encode( $estados, true );
        exit();
    
        $this->autoRender = false;
    }

    /* -------------- Listado de alcaldias por busqueda de estados -------------- */
    function alcaldias_json(){
        header('Content-type: application/json charset=utf-8');
        
        $alcaldias = $this->Cp->find('list', array(
          'conditions' => array( 'Cp.estado' => $this->request->data['estado'] ),
          'fields'     => array('municipio'),
          'group'      => array('municipio'),
          'order'      => array('municipio' => 'ASC')
        ));
    
        echo json_encode( $alcaldias, true );
        exit();
    
        $this->autoRender = false;
    }

    /* ------------- Listado de colonias por busqueda de municipios ------------- */
    function colonias_json(){
        header('Content-type: application/json charset=utf-8');
        
        $colonias = $this->Cp->find('list', array(
          'conditions' => array( 'Cp.municipio' => $this->request->data['municipio'] ),
          'fields'     => array('colonia'),
          'group'      => array('colonia'),
          'order'      => array('colonia' => 'ASC')
        ));

        // print_r($colonias);
    
        echo json_encode( $colonias, true );
        exit();
    
        $this->autoRender = false;
    
    }

    function colonias_json_test( $municipio = null ){
        
        $colonias = $this->Cp->find('list', array(
          'conditions' => array( 'Cp.municipio' => $municipio ),
          'fields'     => array('colonia'),
          'group'      => array('colonia'),
          'order'      => array('colonia' => 'ASC')
        ));

        print_r($colonias);
    
    
        $this->autoRender = false;
    
    }
    
}

