<?php
    App::uses('AppModel', 'Model');

    class LogClientesEtapa extends AppModel {
        
        public $displayField = 'id';

        public $belongsTo = array(
            'Cliente' => array(
                'className'  => 'Cliente',
                'foreignKey' => 'cliente_id',
                'conditions' => '',
                'fields'     => array(
                    'Cliente.id',
                    'Cliente.nombre',
                    'Cliente.created',
                    'Cliente.last_edit',
                    'Cliente.telefono1',
                    'Cliente.correo_electronico',
                    'Cliente.cuenta_id',
                ),
                'order'      => ''
            ),
            'User' => array(
                'className'  => 'User',
                'foreignKey' => 'user_id',
                'conditions' => '',
                'fields'     => 'User.nombre_completo',
                'order'      => ''
            ),
            'Inmueble' => array(
                'className'  => 'Inmueble',
                'foreignKey' => 'inmuble_id',
                'conditions' => '',
                'fields'     => 'Inmueble.referencia',
                'order'      => ''
            ),
            'Desarrollo' => array(
                'className'  => 'Desarrollo',
                'foreignKey' => 'desarrollo_id',
                'conditions' => '',
                'fields'     => 'Desarrollo.nombre',
                'order'      => ''
            ),
            
        );

    }
?>