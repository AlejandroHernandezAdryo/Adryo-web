<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * Clientes Controller log_validation
 *
 * @property LogSubValidations $LogSubValidations
 * @property PaginatorComponent $Paginator
 */
class LogSubValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}