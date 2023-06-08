<?= $this->Html->css(
    array(
        '/vendors/select2/css/select2.min',
        '/vendors/datatables/css/scroller.bootstrap.min',
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        '/vendors/j_timepicker/css/jquery.timepicker',
        '/vendors/datetimepicker/css/DateTimePicker.min',
        '/vendors/clockpicker/css/jquery-clockpicker',
        'pages/colorpicker_hack',
        'custom'
        //'pages/form_elements'
    ),
    array('inline'=>false));
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="modal fade" id="delete_task">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action' => 'registrar_llamada', $cliente['Cliente']['id']))); ?>
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
            <h4 class="modal-title">Eliminar tarea</h4>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div style="display:flex;gap:16px;" class="card-block">
                        <div style="background-color:#F2D3D1;border-radius:100%;padding:4px;height: 30px;width: fit-content;display: flex;justify-content: center;align-items: center;">
                            <i class="fa fa-trash" style="color:red;"></i>
                        </div>
                        <div>
                            <p>
                                Una vez eliminada la tarea no se podrá recuperar la información.
                            </p>
                        </div>
                        <!-- <label for="mensaje">Mensaje <small class="text-light">(Máximo 250 caracteres.)</small></label>
                        <?= $this->Form->textarea('mensaje', array('class'=>'form-control textarea', 'maxlength'=>250)); ?> -->
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <?= $this->Html->link('Eliminar',array('controller'=>'desarrollos','action'=>'add_tarea',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-danger float-xs-right', 'style' => 'margin-left:8px;'))?>
                <?= $this->Html->link('Cancelar',array(), array('class' => 'btn btn-primary-o float-xs-right', 'style' => 'margin-left:8px;', 'data-dismiss' => 'modal'))?>
                <!-- <button type="button" class="btn btn-primary-o float-xs-right" data-dismiss="modal">Salir</button> -->
                <!-- <button type="submit" class="btn btn-success">Registrar</button> -->
            </div>
        </div>
    <?= $this->Form->end(); ?>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Crear tarea 
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block">
                    <!-- Información superior -->
                    <div class="card-block" style="background-color:#f5f5f5 !important;border-radius:8px; padding:16px 0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12 col-lg-4 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control disabled',
                                        'div'         => false,
                                        'placeholder' => 'Escribe un nombre para el proceso',
                                        'label'       => 'Nombre de proceso'
                                    )) ?>
                                </div> 
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control  disabled',
                                        'div'         => false,
                                        'placeholder' => 'Selecciona etapa',
                                        'label'       => 'Etapa <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona la etapa <br> Esta es la etapa en la que se iniciará el proceso." data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                                        'options'     =>  array(
                                            '5' => 'Etapa 5',
                                            '6' => 'Etapa 6',
                                            '7' => 'Etapa 7',
                                        )
                                    )) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12 col-lg-4 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control',
                                        'div'         => false,
                                        'placeholder' => 'Escribe un nombre para la tarea',
                                        'label'       => 'Nombre de la tarea'
                                    )) ?>
                                </div> 
                                <!-- <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Buscador',
                                        'label'       => 'Duración en horas',
                                        'options'     =>  array(
                                            '1' => '1 hrs',
                                            '2' => '2 hrs',
                                            '3' => '3 hrs',
                                            '4' => '4 hrs',
                                            '5' => '5 hrs',
                                            '6' => '6 hrs',
                                            '7' => '7 hrs',
                                            '8' => '8 hrs',
                                            '9' => '9 hrs',
                                            '10' => '10 hrs',
                                            '11' => '11 hrs',
                                            '12' => '12 hrs',
                                            '13' => '13 hrs',
                                            '14' => '14 hrs',
                                            '15' => '15 hrs',
                                            '16' => '16 hrs',
                                            '17' => '17 hrs',
                                            '18' => '18 hrs',
                                            '19' => '19 hrs',
                                            '20' => '20 hrs',
                                            '21' => '21 hrs',
                                            '22' => '22 hrs',
                                            '23' => '23 hrs',
                                            '24' => '24 hrs',
                                        )
                                    )) ?>
                                </div> -->
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Buscador',
                                        'label'       => 'Documentación',
                                        'options'     => array(
                                            'empty' => 'Elige una opción',
                                            '1' => 'Si',
                                            '2' => 'No',
                                        )
                                    )) ?>
                                </div>
                                <!-- <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Buscador',
                                        'label'       => 'Validación',
                                        'options'     => array(
                                            'empty' => 'Elige una opción',
                                            '1' => 'Si',
                                            '2' => 'No',
                                        )
                                    )) ?>
                                </div> -->
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Buscador',
                                        // $this->Html->link('<i class="fa fa-exchange"></i>', '', array('escape' => false, 'data-toggle' => 'modal', 'data-target' => '#changeOfAdviser'));
                                        'label'       => 'Perfil <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona el perfil <br> Es el perfil que esta asociado con esta tarea.<br>Puedes crear nuevos permisos y modificarlos desde <a>panel de control</a>" data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                                        'options'     => array(
                                            'empty' => 'Elige una opción',
                                            '1' => 'Option 1',
                                            '2' => 'Option 2',
                                            '3' => 'Option 3'
                                        )
                                    )) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-1">
                            <button class="btn btn-primary float-right">
                                Agregar
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-5 col-sm-12">
                        <table class="table table-striped" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Tarea
                                    </th>
                                    <th>
                                        Etapa
                                    </th>
                                    <!-- <th>
                                        Duración
                                    </th> -->
                                    <th >
                                        Documentación
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <!-- $this->Html->link('<i class="fa fa-exchange"></i>', '', array('escape' => false, 'data-toggle' => 'modal', 'data-target' => '#changeOfAdviser')); -->
                                        <?= $this->Html->link('<i class="fa fa-edit" style="color:#215D9C;margin-left:8px;"></i>', '',array('escape' => false, 'controller'=>'desarrollos','action'=>'edit_proceso',$desarrollo['Desarrollo']['id']))?>
                                        <?= $this->Html->link('<i class="fa fa-trash" style="color:#215D9C;margin-left:8px;"></i>',array(),array('escape' => false, 'style'=>'margin-left: 5px;', 'id'=>'delete_task', 'data-toggle'=>'modal', 'data-target'=>'#delete_task'))?>
                                    </td>
                                    <td>
                                        Validar RFC
                                    </td>
                                    <td>
                                        5
                                    </td>
                                    <!-- <td>
                                        20hrs
                                    </td> -->
                                    <td>
                                        Cedula de identificación fiscal
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    

</script>