<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * 
 *
 * @property ClienteValidations $ClienteValidations
 * @property PaginatorComponent $Paginator
 */
class ClienteValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}