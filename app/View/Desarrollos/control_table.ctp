<?= $this->Html->css(
    array(
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        '/vendors/datatables/css/scroller.bootstrap.min',
        'pages/tables',
        '/vendors/select2/css/select2.min',
        
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/datepicker/css/bootstrap-datepicker.min',

        // Chozen select
        '/vendors/chosen/css/chosen',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/fileinput/css/fileinput.min',
        // Calendario
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


                    
    ),
    array('inline'=>false))
?>
<style>
    textarea{
        overflow:hidden;
        display:block;
        min-height: 30px;
    }
    .chosen-container {
        width: 100% !important;
        display: block;
        height: 30px;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="modal_edit_validacion">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <?= $this->Form->create('EditValidacions', array('type'=>'file'))?>
            <div class="modal-header">
                Edicion de la Tarea
            </div>
            <div class="modal-body">
                <div class="row mt-1">
                
                    <?=
                        $this->Form->input('nombre',
                            array(
                                'label'   => 'Nombre',
                                'div'     => 'col-sm-12 col-lg-6 mt-1',
                                'class'   => 'form-control',
                                // 'readonly' => true,
                                'id' => 'nombre',
                            )
                        );
                    ?>
                    
                    <?= 
                        $this->Form->input('etapa_inicio', array(
                            'div'     => 'col-sm-12 col-lg-6 mt-1',
                            'class'   => 'form-control',
                            'placeholder' => 'Selecciona etapa',
                            'id' => 'etapa_inicio',
                            'label'       => 'Etapa <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona la etapa <br> Esta es la etapa en la que se iniciará el proceso." data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                            'options'     =>  array(
                                '5' => 'Etapa 5',
                                '6' => 'Etapa 6',
                                '7' => 'Etapa 7',
                            )
                        )) 
                    ?>
                    <?= 
                        $this->Form->input('status', array(
                            'div'     => 'col-sm-12 col-lg-6 mt-1',
                            'label'   => 'Estatus',
                            'class'   => 'form-control',
                            'id' => 'status',
                            'placeholder' => 'Activar o Desactivar',
                            // 'label'       => 'Etapa <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona la etapa <br> Esta es la etapa en la que se iniciará el proceso." data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                            'options'     =>  array(
                                '0' => 'Inactivo',
                                '1' => 'Activo',
                               
                            )
                        )) 
                    ?>
                    <?php 
                    echo $this->Form->hidden('validacion_id', array('id'=>'validacion_id', 'value'=>'validacion_id')); 
                     ?>
                </div>
                <div class="row mt-1">
                    <div class="col-sm-12">

                        <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Aceptar</button>
                        <button type="button" class="btn btn-primary-o float-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
            </div>
        <?= $this->Form->end(); ?>
    </div>
</div>
<!-- Modal -->

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Procesos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <?php  if ($validation == 0):?>
                <!-- Información superior -->
                    <div class="row mt-3" >
                        <div class="col-sm-12 text-sm-center">
                            <h2 class="text-black" style="text-transform:none !important;font-style: normal;font-weight: 700;font-size: 30px;line-height: 36px;"><b>No tienes procesos creados</b></h2>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-sm-center">
                            <?= $this->Html->image('img/flujo-de-trabajo-1.png', array('class' => 'img-fluid')); ?>
                        </div>
                    </div>
                <!-- <div class="row mt-1" > -->
                    <div class="mt-1">
                        <h2 class="text-black text-center" style="text-transform:none !important;font-style: normal;font-weight: 500;font-size: 26px;line-height: 31px;">
                            Crea un nuevo proceso
                            <br>
                                o
                            <br>
                            continua con el flujo normal de
                            <b>
                                Adryo
                            </b>
                        </h2>
                    </div>
                <!-- </div> -->
                <div class="mt-1" style="width: 315px;margin:0 auto;">
                    <div class="text-sm-center" style="display: flex;align-items: center;justify-content: space-between;">
                        <?= $this->Html->link('Conoce el proceso de Adryo',array('controller'=>'desarrollos','action'=>'inicio_proceso'))?>
                        <?= $this->Html->link('Crear Proceso',array('controller'=>'desarrollos','action'=>'proceso_tabla'), array('class' => 'btn btn-primary'))?>
                        <!-- <a href="">Conoce el proceso de <b>Adryo</b></a>
                        <button class="btn btn-primary">Crear Proceso</button> -->
                    </div>
                </div>
            <?php else: ?>

                <div class="card mt-1" id="inventory-detail">
                    <div class="card-block">
                        <!-- Información superior -->
                        <div class="card-block" style="background-color:#f5f5f5 !important;border-radius:8px; padding:16px 0;">
                            <?= $this->Form->create('Validations', array('type'=>'file'))?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-12 col-lg-4 mt-2">
                                            <?= $this->Form->input('name_proceso', array(
                                                'class'       => 'form-control',
                                                'div'         => false,
                                                'placeholder' => 'Escribe un nombre para el proceso',
                                                'label'       => 'Nombre de proceso',
                                                'required'     => true,
                                            )) ?>
                                        </div> 
                                        <div class="col-sm-12 col-lg-2 mt-2">
                                            <?= $this->Form->input('etapa_inicio', array(
                                                'class'       => 'form-control select',
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
                                        <div class="col-sm-12 col-lg-4 mt-2">
                                            <?= $this->Form->input('orden', array(
                                                'pattern'=> '[0-9]+',
                                                'class'       => 'form-control',
                                                'div'         => false,
                                                'placeholder' => 'Escribe un orden para el proceso',
                                                'label'       => 'Orden de proceso (solo números)',
                                                'required'     => true,
                                            )) ?>
                                        </div> 
                                        <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                        <?= $this->Form->hidden('user_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.user_id'))); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-1">
                                    <!-- <?= $this->Html->link('Guardar', array(), array('escape' => false, 'class' => 'btn btn-primary', 'style'=>'margin-left: 5px;float:right;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?> -->
                                    <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Guardar</button>
                                </div>
                            <?= $this->Form->end(); ?>
                        </div>
                        
                    </div>
                </div>
                <div class="mt-5 col-sm-12">
                            <table class="table table-striped" id="sample_1">
                            
                            </table>
                        </div>
            <?php endif; ?>
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
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>

<script>

    function uploadFac(id){
        let valiadacion_id = id;
        $("#modal_edit_validacion").modal('show')
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "Validations", "action" => "view_edit_validacion")); ?>",
            data: {api_key: 'api_key', valiadacion_id:valiadacion_id },
            dataType: "Json",
            success: function (response) {
                // console.log(response);
                for (let i in response) {
                    $("#nombre").val( response[i].nombre);
                    $("#status").val( response[i].status);
                    $("#etapa_inicio").val( response[i].etapa_id);
                    $("#validacion_id").val( response[i].id);

                }
            }
        });
    }
    function activarDesactivar(id){
        let validacionId = id;
        console.log(validacionId);
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "Validations", "action" => "activar_desactivar")); ?>",
            data: {api_key: 'api_key', validacionId:validacionId },
            dataType: "Json",
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                window.location.reload();

            }
        });
    }

    $(document).ready(function () {
        let cuenta_id=<?=$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');?>;
        console.log(cuenta_id);
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "Validations", "action" => "view")); ?>",
            data: {cuenta_id: cuenta_id },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#sample_1').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 7 ],
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

    $(document).on("submit", "#ValidationsControlTableForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "Validations", "action" => "add")); ?>',
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
                console.log(response);
            },
            error: function ( response ) {
                console.log(response);
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
        });
    });

    // EditValidacions
    $(document).on("submit", "#EditValidacionsControlTableForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "Validations", "action" => "edit_validacion")); ?>',
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
                console.log(response);
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
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
                        targets: [ 7 ],
                        visible: true,
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
                    { title: "nueva tarea" },                    
                    { title: "editar proceso" },
                    { title: "usuario de creacion" },
                    { title: "etapa" },
                    { title: "nombre del proceso" },
                    { title: "estatus" },
                    { title: "orden" },                    
                    { title: "progreso" },
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