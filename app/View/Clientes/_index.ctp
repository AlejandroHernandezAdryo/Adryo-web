
<?php
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
        array('inline'=>true))
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

    .seccion-titulo {
        font-size: 1.1rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
    }
    .list-number li {
        list-style: decimal;
    }
</style>
<!-- Modal cliente detalle -->
<div class="modal fade" id="modal_detalle_cliente">
    <div class="modal-dialog modal-dialog">
      <div class="modal-content">
      
        <div class="modal-header bg-blue-is">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
            <h4 class="modal-title">&nbsp;&nbsp; Detalle del cliente</h4>
        </div> <!-- Modal Header -->

        <div class="modal-body">

            <div class="info">
                <div id="comentario_completo">
                    <div class="seccion-titulo">Comentario completo: </div>
                    <div id="info_comentario"></div>
                </div>

                <div id="ultimos_3_seguimientos">
                    <div class="seccion-titulo">Ultimos 3 seguimientos</div>
                    <div id="info_seguimiento"></div>
                </div>
            </div>

        
            <div class="modal-footer mt-3">
                <?= $this->Form->button('Cerrar', array('class'=>'btn btn-danger pull-left', 'data-dismiss' => 'modal')); ?>
            </div>

        </div>

      </div>
    </div>
</div>



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
                                    <?php if( $this-> Session->read('Permisos.Group.id') == 5 ): ?>
                                        <a  href="#" class="btn btn-link float-right btn-labeled disabled">
                                            <span class="btn-label btn-label-tr"><i class="fa fa-search fa-1x"></i></span> Búsqueda Avanzada
                                        </a>
                                    <?php else: ?>
                                        <a  href="#" class="btn btn-link float-right btn-labeled" data-toggle="modal" data-target="#myModal">
                                            <span class="btn-label btn-label-tr"><i class="fa fa-search fa-1x"></i></span> Búsqueda Avanzada
                                        </a>
                                    <?php endif; ?>

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
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',

        // Chozen select
        // 'pages/form_elements',
        // '/vendors/chosen/js/chosen.jquery',
        'form',
        
    ], array('inline'=>true));
?>

<script>


// Metodo para el modal de mostrar comentario.
function modal_comentario( idCliente ) {
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "detalle_comentario")); ?>/' + idCliente ,
        cache: false,
        success: function ( response ) {

            document.getElementById("info_comentario").innerHTML = response.comentario_completo;
            document.getElementById("info_seguimiento").innerHTML = response.ultimos_seguimientos;
            $("#modal_detalle_cliente").modal('show');
        }
    });
    
}


'use strict';
$(document).ready(function () {
    // Chozen select
    // $(".hide_search").chosen({disable_search_threshold: 10});
    // $(".chzn-select").chosen({allow_single_deselect: true});
    // $(".chzn-select-deselect,#select2_sample").chosen();

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

            echo '[';
                echo $cliente['etapa'];
                echo $cliente['atencion'];
                echo $cliente['status'];
                echo $cliente['nombre_cliente'];
                echo $cliente['prop_interes'];
                echo $cliente['email'];
                echo $cliente['telefono'];
                echo $cliente['linea_contacto'];
                echo $cliente['tipo_cliente'];
                echo $cliente['fecha_creacion'];
                echo $cliente['ultima_edicion'];
                echo $cliente['comentario_corto'];
                echo $cliente['comentario_largo'];
                echo $cliente['seguimieto'];
                echo $cliente['nombre_asesor'];
                echo $cliente['edicion'];
                echo $cliente['eliminar'];
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
                { title: "Etapa"},
                { title: "E.A" },
                { title: "Estatus cliente" },
                { title: "Nombre" },
                { title: "Inmueble/Desarrollo origen" },
                { title: "Correo electrónico" },
                { title: "Teléfono" },
                { title: "Forma contacto" },
                { title: "Tipo cliente" },
                { title: "Fecha creación" },
                { title: "Ultimo seg" },
                { title: "Comentario" },
                { title: "Comentario completo", visible: false },
                { title: "Ultimos 5 seguimientos", visible: false },
                // { title: "Ultimos 3 seguimientos", visible: false },
                { title: "Asesor" },
                // { title: "Comentario" },
                <?php if ($this->Session->read('Permisos.Group.ce')): ?>
                    { title: "<i class='fa fa-edit'></i>" },
              	<?php elseif( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                    { title: "<i class='fa fa-edit'></i>" },
              	<?php endif; ?>
              	<?php if ($this->Session->read('Permisos.Group.cd')): ?>
                    { title: "<i class='fa fa-trash'></i>" },
                <?php elseif( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                    { title: "<i class='fa fa-trash'></i>" },
              	<?php endif; ?>
            ],
            dom: 'Bflr<"table-responsive"t>ip',
            <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
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
            <?php else: ?>
                buttons: [
                {
                    extend: 'csv',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar como CSV',
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
            <?php endif; ?>
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


function myFunction(id){
    // alert('el id es '+id);
    $("#modal_cliente_delete").modal('show')
    document.getElementById("ClienteId").value = id;
}

function buttonClienteDeleteMasterForm() {
    $("#ClienteDeleteMasterForm").submit();
    $("#modal_cliente_delete").modal('hide');
}
    
</script>