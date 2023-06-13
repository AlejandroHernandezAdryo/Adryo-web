<?= $this->Html->css(
    array(
        '/vendors/select2/css/select2.min',
        '/vendors/datatables/css/scroller.bootstrap.min',
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        // '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        // '/vendors/datepicker/css/bootstrap-datepicker.min',
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
                                        'label'       => 'Nombre de proceso',
                                        'value'=>$validation['Validation']['validacion_name'],
                                    )) ?>
                                </div> 
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('contador', array(
                                        'class'       => 'form-control  disabled',
                                        'div'         => false,
                                        'placeholder' => 'Selecciona etapa',
                                        'label'       => 'Etapa <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona la etapa <br> Esta es la etapa en la que se iniciará el proceso." data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                                        'value'=>$validation['Validation']['etapa_id'],
                                    )) ?>
                                </div>
                                <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                <?= $this->Form->hidden('user_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.user_id'))); ?>
                                <?= $this->Form->hidden('id', array('value'=>$validation['Validation']['id'])); ?>
                            </div>
                        </div>
                        <?= $this->Form->create('SubValidation', array('type'=>'file'))?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-12 col-lg-4 mt-2">
                                        <?= $this->Form->input('subnombre', array(
                                            'class'       => 'form-control',
                                            'div'         => false,
                                            'required' => true,
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
                                        <?= $this->Form->input('status', array(
                                            'class'       => 'form-control select',
                                            'div'         => false,
                                            'required' => true,
                                            'placeholder' => 'Buscador',
                                            'label'       => 'Documentación',
                                            'options'     => array(
                                                '1' => 'Si',
                                                '0' => 'No',
                                            )
                                        )) ?>
                                    </div>
                                    <div class="col-sm-12 col-lg-2 mt-2">
                                        <?= $this->Form->input('rol', array(
                                            'class'       => 'form-control select',
                                            'div'         => false,
                                            'placeholder' => 'Buscador',
                                            'required' => true,
                                            'type'=>'select',
                                            // 'value' => empty($permisos['Grupo']['id']) ? '' :  $permisos['Grupo']['id'],
                                            // $this->Html->link('<i class="fa fa-exchange"></i>', '', array('escape' => false, 'data-toggle' => 'modal', 'data-target' => '#changeOfAdviser'));
                                            'label'       => 'Perfil <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona el perfil <br> Es el perfil que esta asociado con esta tarea.<br>Puedes crear nuevos permisos y modificarlos desde <a>panel de control</a>" data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                                            'options'     => array(
                                                $roles
                                            )
                                        )) ?>
                                    </div>
                                    <div class="col-sm-12 col-lg-4 mt-2">
                                            <?= $this->Form->input('orden', array(
                                                'pattern'=> '[0-9]+',
                                                'class'       => 'form-control',
                                                'div'         => false,
                                                'placeholder' => 'Escribe un orden para la tarea',
                                                'label'       => 'Orden de la tarea (solo números)',
                                                'required'     => true,
                                            )) ?>
                                        </div> 
                                <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                <?= $this->Form->hidden('validation_id', array('value'=>$validation['Validation']['id'])); ?>
                                <?= $this->Form->hidden('user_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.user_id'))); ?>


                                </div>
                            </div>
                            <div class="col-sm-12 mt-1">
                                <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Agregar</button>
                            </div>
                        <?= $this->Form->end(); ?>

                    </div>
                    
                    <div class="mt-5 col-sm-12">
                        <table class="table table-striped" style="overflow:scroll;" id="sample_1">
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>

<script>

    $(document).on("submit", "#SubValidationAddTareaForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "SubValidations", "action" => "add")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                window.location.reload();
                // console.log(response);
            },
            error: function ( response ) {

                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
        });
    });
    $(document).ready(function () {
        let id=<?=$validation['Validation']['id']?>;
        console.log(id);
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "SubValidations", "action" => "view")); ?>",
            data: {id: id },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                console.log('donde ando');
                $('#sample_1').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 5 ],
                            visible: true,
                            searchable: false
                        },
                    ],
                    language: {
                        sSearch: "Buscador",
                        lengthMenu: '_MENU_ registros por página',
                        info: 'Mostrando _TOTAL_ registro(s)',
                        infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                        emptyTable: "Sin información",
                        paginate: {
                            previous: 'Anterior',
                            next: 'Siguiente'
                        },
                    },
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                            filename: 'ClientList',
                            class : 'excel',
                            charset: 'utf-8',
                            bom: true,
                            // enabled: false,
        
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa  fa-print"></i> Imprimir',
                            filename: 'ClientList',
                        },
                    ]
                });
            }
        });
    });
    var TableAdvanced = function() {
         // ===============table 1====================
        var initTable1 = function() {
            var table = $('#sample_1');
            table.DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: [ 5 ],
                        visible: false,
                        searchable: false
                    },
                ],
                language: {
                    sSearch: "Buscador",
                    lengthMenu: '_MENU_ registros por página',
                    info: 'Mostrando _TOTAL_ registro(s)',
                    infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                    emptyTable: "Sin información.",
                    paginate: {
                        previous: 'Anterior',
                        next: 'Siguiente'
                    },
                },
                columns: [

                    { title: "ver" },
                    { title: "Comprobante" },
                    { title: "Referencia" },
                    { title: "programada de Pago" },
                    { title: "nose" },
                    { title: "estatus" },
                    { title: "orden" },
    
                    
                ],
                dom: 'Bflr<"table-responsive"t>ip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                        filename: 'ClientList',
                        class : 'excel',
                        charset: 'utf-8',
                        bom: true,
                        enabled: false,

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa  fa-print"></i> Imprimir',
                        filename: 'ClientList',
                        enabled: false,
                    },
                ]
            });
            var tableWrapper = $('#sample_1_wrapper');
            tableWrapper.find('.dataTables_length select').select2();
        }
        
        return {
            //main function to initiate the module
            init: function() {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();
                
            }
        };
    }();

</script>