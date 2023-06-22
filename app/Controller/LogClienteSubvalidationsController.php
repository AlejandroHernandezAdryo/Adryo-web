<!-- LogClienteSubvalidationController -->


<?php
App::uses('AppController', 'Controller');
App::uses('HttpSocket', 'Network/Http');

/**
 * 
 *
 * @property LogClienteSubvalidations $LogClienteSubvalidations
 * @property PaginatorComponent $Paginator
 */
class LogClienteSubvalidationsController extends AppController {


    public $components = array('Paginator' );

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow(array(''));
      
    }

}