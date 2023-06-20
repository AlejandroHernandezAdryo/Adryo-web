<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller log_validation
 *
 * @property Validation $Validation
 * @property PaginatorComponent $Paginator
 */
class LogSubValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}