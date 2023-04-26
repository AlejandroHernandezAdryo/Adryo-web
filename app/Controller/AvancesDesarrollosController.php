<?php
App::uses('AppController', 'Controller');
/**
 * Cargos Controller
 *
 * @property Cargo $Cargo
 * @property PaginatorComponent $Paginator
 */
class AvancesDesarrollosController extends AppController {

    public function add(){
        if ($this->request->is('post')){
            $this->request->data['AvancesDesarrollo']['user_id']=$this->Session->read('Auth.User.id');
            $this->request->data['AvancesDesarrollo']['fecha']=date("Y-m-d H:i:s");
            $this->AvancesDesarrollo->create();
            if ($this->AvancesDesarrollo->save($this->request->data)){
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('Se ha agregado exitsamente el Avance de Obra', 'default', array(), 'm_success');
                return $this->redirect(array('action'=>'view','controller'=>'desarrollos',$this->request->data['AvancesDesarrollo']['desarrollo_id']));
            }else{
                $this->Session->setFlash('', 'default', array(), 'success');
                $this->Session->setFlash('No se ha podido agregar el Avance de Obra', 'default', array(), 'm_error');
            }
        }
    }

}

?>