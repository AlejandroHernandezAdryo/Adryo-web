<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property SubValidations $SubValidations
 * @property PaginatorComponent $Paginator
 */
class SubValidationsController extends AppController {


    public $components = array('Paginator' );


    public $uses = array(
            'Cliente','Inmueble','Desarrollo',
            'User',
            'Venta','Transaccion', 'Factura','MailConfig', 'Paramconfig', 'Cuenta', 'Cotizacion'
    );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }
    function caca(){
        $reponse='caca';
        echo json_encode( $reponse , true );
        exit();
        $this->autoRender = false; 
    }


}