<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * 
 *
 * @property LogClienteValidationsController $LogClienteValidations
 * @property PaginatorComponent $Paginator
 */
class LogClienteValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}