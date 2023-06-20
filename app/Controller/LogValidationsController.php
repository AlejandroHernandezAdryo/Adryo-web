<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller
 *
 * @property LogValidations $LogValidations
 * @property PaginatorComponent $Paginator
 */
class LogValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }
  


}