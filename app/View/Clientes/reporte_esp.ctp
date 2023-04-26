<?php
    $date_current = date('Y-m-d');
    $date_oportunos = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));
?>
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
            //'pages/form_elements'

            // buttons 
            '/vendors/Buttons/css/buttons.min',
            'pages/buttons',

            'components',
            'custom',
        ),
        array('inline'=>false))
?>
<style>
    .text-center{text-align: center;}
    .m-t-50{margin-top: 60px;}
    .c_pointer{cursor: pointer;}
    .float-right{float: right;}
    .text-black{color: #525252;}
    .btn-link{background: transparent; border-color: #DADADA !important; border-radius: 5px;}
    .btn-link:hover{border-color: #DADADA; background: #F3F3F3;}
    .btn-label-tr{background: transparent;}
</style>
<!-- Modal delete -->
<div class="modal fade" id="modal_cliente_delete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Esta seguro que desea ELIMINAR este cliente ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('Cliente', array('url'=>array('controller'=>'Clientes', 'action'=>'delete_master')));
                echo $this->Form->input('id');
            ?>
            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>
<!-- Modal search advance -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-search"></i>
                  Búsqueda Avanzada de Clientes
              </h4> -->
          </div>
          <?= $this->Form->create('Cliente',array('url'=>array('action'=>'index')))?>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xl-3">
                      <?= $this->Form->label('nombreUsuario','Nombre de Usuario', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('nombre',array('class'=>'form-control','placeholder'=>'Nombre Cliente','div'=>'col-xl-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('correoElectronico','Correo Electrónico', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('correo_electronico',array('class'=>'form-control','placeholder'=>'Correo Electrónico','div'=>'col-xl-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('telefono','Teléfono', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('telefono',array('class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-xl-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('tipo_clientes','Tipo Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('tipos_clientes',array('type'=>'select','options'=>$tipos_cliente,'empty'=>'Todos los tipos de Cliente','class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-md-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?php $status = array('Activo'=>'Activo','Inactivo'=>'Inactivo','Activo venta'=>'Activo venta', 'Inactivo temporal'=>'Inactivo temporal'); ?>
                      <?= $this->Form->label('status_cliente','Estatus', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('estatus_cliente',array('type'=>'select','options'=>$status,'empty'=>'Todos los estatus de Cliente','class'=>'form-control','div'=>'col-md-9 m-t-15','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?php $temperatura = array(1=>'Frío',2=>'Tibio',3=>'Caliente'); ?>
                      <?= $this->Form->label('temperatus','Temperatura', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('temperatura',array('type'=>'select','options'=>$temperatura,'empty'=>'Todas las Temperaturas','class'=>'form-control','div'=>'col-md-9 m-t-15','label'=>false,)); ?>
              </div>

              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('etapa_cliente','Etapa del Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('etapa_cliente',array('class'=>'form-control','placeholder'=>'Etapa del Cliente','div'=>'col-xl-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('formas_contacto','Formas de contacto', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('forma_contacto',array('type'=>'select','options'=>$linea_contactos,'empty'=>'Todas las forma de contacto de Cliente','class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-md-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('asesor','Asesor', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('asesor',array('type'=>'select','options'=>$users,'empty'=>'Todas los asesores','class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-md-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('rango_fechas','Rango de Fechas', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('rango_fechas',array('id'=>'date_range','name'=>'date_range','class'=>'form-control','div'=>'col-md-9','label'=>false,)); ?>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                  Cerrar
                  <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                  <i class="fa fa-search"></i>
                  Realizar Búsqueda
              </button>
          </div>
          <?= $this->Form->end()?>
      </div>
  </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-md-4 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Lista de clientes 
                </h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                              <div class="col-sm-12 mt-3">
                                <a  href="#" class="btn btn-link btn-xs float-right btn-labeled" data-toggle="modal" data-target="#myModal">
                                  <span class="btn-label btn-label-tr"><i class="fa fa-search fa-1x"></i></span> Búsqueda Avanzada
                                </a>
                              </div>
                                <div class="col-sm-12 mt-3">
                                    <table class="table table-striped table-bordered table-hover table-sm" id="sample_1">
                                    </table>
                                </div>
                            </div>
                            <!-- Tabla de clientes -->
                        </div>
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
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>

<script>
'use strict';
$(document).ready(function () {

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    $('[data-toggle="popover"]').popover();

    $('#date_range').daterangepicker({
        orientation:"bottom",
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        return false;
    });

    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        return false;
    });

});

var dataSet = [
    <?php
        foreach ($clientes as $cliente) {
            $id_cliente   = $cliente['Cliente']['id'];
            $id_asesor    = $cliente['User']['id'];
            $ruta_cliente = Router::url('/clientes/view/'.$id_cliente, true);
            $ruta_edit    = Router::url('/clientes/edit/'.$id_cliente, true);
            $ruta_trash   = Router::url('/clientes/delete/'.$id_cliente, true);
            $ruta_asesor  = Router::url('/users/view/'.$id_asesor, true);

            if ($cliente['Cliente']['temperatura'] == 1) {$temp = 'F'; $class_temp = 'bg_frio'; $name_temp = 'Frio';}
            elseif($cliente['Cliente']['temperatura'] == 2){$temp ='T'; $class_temp = 'bg_tibio'; $name_temp = 'Tibio';}
            elseif($cliente['Cliente']['temperatura'] == 3){$temp ='C'; $class_temp = 'bg_caliente'; $name_temp = 'Caliente';}
            elseif($cliente['Cliente']['temperatura'] == 4){$temp ='V'; $class_temp = 'bg_venta'; $name_temp = 'Venta';}
            else{$temp =''; $class_temp = ''; $name_temp = '';}

            if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
            elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
            elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
            elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
            else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}

            if ($cliente['Cliente']['status'] == 'Activo venta') {$status_cliente = 'Venta';}
            else{$status_cliente = $cliente['Cliente']['status'];}
            echo '[';
                echo '"<small class='."$class_temp".'>'.$temp.'</small> <span class='."text_hidden".'>'.$name_temp.'</span>",';
                echo '"<small class='."$class_at".'>'.$at.'</small> <span class='."text_hidden".'>'.$name_at.'</span>",';
                echo '"'.$status_cliente.'",';
                echo '"<a target='."_Blanck".' href='."$ruta_cliente".'>'.rtrim($cliente['Cliente']['nombre']).'</a>",';
                echo '"'.rtrim($cliente['Desarrollo']['nombre']). rtrim($cliente['Inmueble']['titulo']).'",';
                echo '"'.rtrim($cliente['Cliente']['correo_electronico']).'",';
                echo '"'.rtrim($cliente['Cliente']['telefono1']).'",';
                echo '"'.$cliente['DicLineaContacto']['linea_contacto'].'",';
                echo '"'.$cliente['DicTipoCliente']['tipo_cliente'].'",';
                echo '"'.$cliente['DicEtapa']['etapa'].'",';
                echo '"'.date('Y-m-d', strtotime($cliente['Cliente']['created'])).'",';
                echo '"'.date('Y-m-d', strtotime($cliente['Cliente']['last_edit'])).'",';
                echo '"<a target='."_Blanck".' href='."$ruta_asesor".'>'.rtrim($cliente['User']['nombre_completo']).'</a>",';
                if ($this->Session->read('Permisos.Group.ce')) {
                  echo '"<a target='."_Blanck".' href='."$ruta_edit".'><i class='."fa_fa_edit".'></i></a>",';
                }
                if ($this->Session->read('Permisos.Group.cd')) {
                  echo '"<a class='."c_pointer".' target='."_Blanck".' onclick='."myFunction($id_cliente);".'><i class='."fa_fa_trash".'></i></a>"';
                }
            echo '],';
        }
    ?>
]
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            // processing: true,
            // serverSide: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[10, "desc"]],
            data: dataSet,
            columns: [
                { title: "" },
                { title: "" },
                { title: "Estatus" },
                { title: "Nombre" },
                { title: "Inmueble/Desarrollo origen" },
                { title: "Correo electrónico" },
                { title: "Teléfono" },
                { title: "Forma contacto" },
                { title: "Tipo cliente" },
                { title: "Etapa" },
                { title: "Fecha creación" },
                { title: "Ultimo seg" },
                { title: "Asesor" },
                // { title: "Comentario" },
                <?php if ($this->Session->read('Permisos.Group.ce')): ?>
                { title: "<i class='fa fa-edit'></i>" },
                <?php endif; ?>
                <?php if ($this->Session->read('Permisos.Group.cd')): ?>
                { title: "<i class='fa fa-trash'></i>" },
                <?php endif; ?>
            ],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'ClientList',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientList',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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


function myFunction(id){
    // alert('el id es '+id);
    $("#modal_cliente_delete").modal('show')
    document.getElementById("ClienteId").value = id;
}
    
</script>