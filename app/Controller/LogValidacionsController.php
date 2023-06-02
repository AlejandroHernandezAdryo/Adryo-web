<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property Validation $Validation
 * @property PaginatorComponent $Paginator
 */
class ValidationsController extends AppController {


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

}