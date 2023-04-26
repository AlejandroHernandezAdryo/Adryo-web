
<?php
    $date_current = date('Y-m-d');
    $date_oportunos = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));
    $estados = array(
        1=>'Interés Preliminar',
        2=>'Comunicación Abierta',
        3=>'Precalificación',
        4=>'Visita',
        5=>'Análisis de Opciones',
        6=>'Validación de Recursos',
        7=>'Cierre' 
    );
?>
<?= $this->Html->css(
        array(
            'components',
            'custom',
            
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/colReorder.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',

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

            // buttons 
            '/vendors/Buttons/css/buttons.min',
            'pages/buttons',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',

            
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

    .chosen-container{
      width: 100% !important;
      top: -5px;
      /*height: 24px;*/
    }
    .chosen-single, .chosen-container{
      height: calc(2.5rem - 2px);
    }

    .estado1{
        background-color: #ceeefd;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado2{
        background-color: #6bc7f2;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado3{
        background-color: #f4e6c5;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado4{
        background-color: #f0ce7e;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado5{
        background-color: #f08551;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado6{
        background-color: #ee5003;
        color: white;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }

    .estado7{
        background-color: #3ed21f;
        padding:5px;
        border-radius: 5px;
        font-weight: 700;
        display: flex;
        flex-direction: row;
        align-content:  center;

    }
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
                echo $this->Form->hidden('redirect', array('value'=>1));
            ?>

            <div class="modal-footer">
              <div class="row">
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-success float-right" onclick="buttonClienteDeleteMasterForm();">Aceptar</button>
                  </div>
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
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-search"></i>
                  Búsqueda Avanzada de Clientes
              </h4>
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
                      <?php $status = array('Activo'=>'Activo','Inactivo'=>'Inactivo', 'Inactivo temporal'=>'Inactivo temporal'); ?>
                      <?= $this->Form->label('status_cliente','Estatus', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('estatus_cliente',array('type'=>'select','options'=>$status,'empty'=>'Todos los estatus de Cliente','class'=>'form-control','div'=>'col-md-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('etapa_cliente','Etapa del Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('etapa_cliente',array('type'=>'select','options'=>$estados,'empty'=>'Todas las etapas del cliente','class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-xl-9','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('formas_contacto','Formas de contacto', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('forma_contacto',array('type'=>'select','options'=>$linea_contactos,'empty'=>'Todas las forma de contacto de Cliente','class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-md-9','label'=>false,)); ?>
              </div>
              <div class="row">
                  <div class="col-xl-3">
                      <?= $this->Form->label('asesor','Asesor', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('asesor',array('type'=>'select','options'=>$users,'empty'=>'Todos los asesores','class'=>'form-control chzn-select','placeholder'=>'Teléfono','div'=>'col-md-9','label'=>false)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-3">
                      <?= $this->Form->label('rango_fechas','Rango de Fechas', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('rango_fechas',array('id'=>'date_range','name'=>'date_range','class'=>'form-control','div'=>'col-md-9','label'=>false, 'placeholder'=>'dd/mm/YYYY - dd/mm/YYYY', 'autocomplete'=>'off')); ?>
              </div>

            <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                
                <div class="row mt-1">
                    <div class="col-xl-3">
                        <?= $this->Form->label('inmueble_id','Inmuebles', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select', 'empty'=>'Todos los inmuebles','class'=>'form-control disabled','div'=>'col-xl-9','label'=>false )); ?>
                </div>


            <?php else: ?>
                <div class="row mt-1">
                    <div class="col-xl-3">
                        <?= $this->Form->label('inmueble_id','Inmuebles', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select','options'=>$list_inmuebles,'empty'=>'Todos los inmuebles','class'=>'form-control chzn-select','div'=>'col-xl-9','label'=>false )); ?>
                </div>
            <?php endif; ?>

            <div class="row mt-1">
                <div class="col-xl-3">
                    <?= $this->Form->label('desarrollo_id','Desarrollos', array('class' => 'form-control-label')); ?>
                </div>
                <?= $this->Form->input('desarrollo_id',array('type'=>'select','options'=>$list_desarrollos,'empty'=>'Todos los desarrollos','class'=>'form-control chzn-select','div'=>'col-xl-9','label'=>false )); ?>
            </div>

            <div class="row mt-1">
                <div class="col-xl-3">
                    <?= $this->Form->label('status_atencion','Estatus de atención', array('class' => 'form-control-label')); ?>
                </div>
                <?= $this->Form->input('status_atencion',array('type'=>'select','options'=>$status_atencion_options,'empty'=>'Todos los estatus de atención','class'=>'form-control chzn-select','div'=>'col-xl-9','label'=>false )); ?>
            </div>





          </div>
          <div class="modal-footer">
              
              <button type="submit" class="btn btn-success float-xs-right" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                  Realizar Búsqueda
              </button>

              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                  Cerrar
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
                    Pruebas de APPI de marcado libre
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

                            <?= $access_token ?>
                            
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
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',

        // Chozen select
        // 'pages/form_elements',
        // '/vendors/chosen/js/chosen.jquery',
        'form',
        
    ], array('inline'=>false));
?>

<script>
'use strict';
$(document).ready(function () {
}();

</script>