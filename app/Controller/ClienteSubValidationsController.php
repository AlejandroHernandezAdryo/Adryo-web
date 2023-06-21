<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * 
 *
 * @property ClienteSubValidations $ClienteSubValidations
 * @property PaginatorComponent $Paginator
 */
class ClienteSubValidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}