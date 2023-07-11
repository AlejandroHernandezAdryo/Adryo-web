<?= $this->Html->css(
    array(

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
<!-- Modal cliente detalle -->
<div class="modal fade" id="modal_detalle_cliente">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title">&nbsp;&nbsp; Detalle del cliente</h4>
            </div> <!-- Modal Header -->

            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <table id="table-client-info">
                            <tbody>
                                <tr>
                                    <td class="seccion-titulo">Correo Electrónico:</td>
                                    <td id="info_correo" ></td>
                                </tr>
                                <tr>
                                    <td class="seccion-titulo">Teléfono:</td>
                                    <td id="info_telefono"></td>
                                </tr>
                                <tr>
                                    <td class="seccion-titulo">Fecha Ultimo seguimiento:</td>
                                    <td id="info_last_edit"></td>
                                </tr>
                                <tr>
                                    <td class="seccion-titulo">Estatus:</td>
                                    <td id="info_status"></td>
                                </tr>
                                <tr>
                                    <td colspan ="2" class="seccion-titulo">Comentario cambio de etapa: </td>
                                </tr>
                                <tr>
                                    <td colspan="2" id="info_comentario"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="seccion-titulo">Últimos 5 seguimientos:</td>
                                </tr>
                                    <td colspan="2" id="info_seguimiento"></td>
                                <tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
                      <button type="button" class="btn btn-success float-right" onclick="submitFormClientDelete();">Aceptar</button>
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
          <div class="modal-header bg-blue-is">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1">
                  <i class="fa fa-search"></i>
                  Búsqueda Avanzada de Clientes
              </h4>
          </div>
          <?= $this->Form->create('Cliente',array('url'=>array('action'=>'index')))?>
          <div class="modal-body">
              <div class="row">
                  <div class="col-xl-4">
                      <?= $this->Form->label('nombreCliente','Nombre de Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('nombre',array('class'=>'form-control','placeholder'=>'Nombre Cliente','div'=>'col-lg-8','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('correoElectronico','Correo Electrónico', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('correo_electronico',array('class'=>'form-control','placeholder'=>'Correo Electrónico','div'=>'col-lg-8','label'=>false, 'type' => 'email')); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('telefono','Teléfono', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('telefono',array('class'=>'form-control','placeholder'=>'Teléfono','div'=>'col-lg-8','label'=>false,)); ?>
              </div>

              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('rango_fechas','Fecha de creación', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('rango_fechas',array('name'=>'date_created','class'=>'form-control date_range','div'=>'col-lg-8','label'=>false, 'placeholder'=>'dd/mm/YYYY - dd/mm/YYYY', 'autocomplete'=>'off')); ?>
              </div>

              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('rango_fechas','Fecha Ult Seguimiento', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('rango_fechas',array('id'=>'date_last_edit','name'=>'date_last_edit','class'=>'form-control date_range','div'=>'col-lg-8','label'=>false, 'placeholder'=>'dd/mm/YYYY - dd/mm/YYYY', 'autocomplete'=>'off')); ?>
              </div>
              <!--Rogue  -->
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('rango_fechas','Fecha etapa', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('rango_fechas',array('id'=>'date_etapa','name'=>'date_etapa','class'=>'form-control date_range','div'=>'col-lg-8','label'=>false, 'placeholder'=>'dd/mm/YYYY - dd/mm/YYYY', 'autocomplete'=>'off')); ?>
              </div>
              <!--  -->
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('tipo_clientes','Tipo Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('tipos_clientes',array('type'=>'select','options'=>$tipos_cliente,'empty'=>'Todos los tipos de Cliente','class'=>'form-control chzn-select','placeholder'=>'Teléfono','div'=>'col-lg-8','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?php $status = array('Activo'=>'Activo','Inactivo'=>'Inactivo definitivo', 'Inactivo temporal'=>'Inactivo temporal'); ?>
                      <?= $this->Form->label('status_cliente','Estatus', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('estatus_cliente',array('type'=>'select','options'=>$status,'empty'=>'Todos los estatus de Cliente','class'=>'form-control chzn-select','div'=>'col-lg-8','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('etapa_cliente','Etapa del Cliente', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('etapa_cliente',array('type'=>'select','options'=>$estados,'empty'=>'Todas las etapas del cliente','class'=>'form-control chzn-select uppercase', 'div'=>'col-lg-8','label'=>false,)); ?>
              </div>
              <div class="row mt-1">
                  <div class="col-xl-4">
                      <?= $this->Form->label('formas_contacto','Formas de contacto', array('class' => 'form-control-label')); ?>
                  </div>
                  <?= $this->Form->input('forma_contacto',array('type'=>'select','options'=>$linea_contactos,'empty'=>'Todas las forma de contacto de Cliente','class'=>'form-control chzn-select', 'div'=>'col-lg-8','label'=>false,)); ?>
              </div>
              
              <?php if( $this->Session->read('Permisos.Group.call') == 1 ): ?>
              
                <div class="row mt-1">
                    <div class="col-xl-4">
                        <?= $this->Form->label('asesor','Asesor', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('asesor',array('type'=>'select','options'=>$users,'empty'=>'Todos los asesores','class'=>'form-control chzn-select', 'div'=>'col-lg-8','label'=>false)); ?>
                </div>

              <?php endif; ?>


            <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                
                <div class="row mt-1">
                    <div class="col-xl-4">
                        <?= $this->Form->label('inmueble_id','Inmuebles', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select', 'empty'=>'Todos los inmuebles','class'=>'form-control disabled','div'=>'col-lg-8','label'=>false )); ?>
                </div>


            <?php else: ?>
                <div class="row mt-1">
                    <div class="col-xl-4">
                        <?= $this->Form->label('inmueble_id','Inmuebles', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select','options'=>$list_inmuebles,'empty'=>'Todos los inmuebles','class'=>'form-control chzn-select','div'=>'col-lg-8','label'=>false )); ?>
                </div>
            <?php endif; ?>

            <div class="row mt-1">
                <div class="col-xl-4">
                    <?= $this->Form->label('desarrollo_id','Desarrollos', array('class' => 'form-control-label')); ?>
                </div>
                <?= $this->Form->input('desarrollo_id',array('type'=>'select','options'=>$list_desarrollos,'empty'=>'Todos los desarrollos','class'=>'form-control chzn-select','div'=>'col-lg-8','label'=>false )); ?>
            </div>

            <div class="row mt-1">
                <div class="col-xl-4">
                    <?= $this->Form->label('status_atencion','Estatus de atención', array('class' => 'form-control-label')); ?>
                </div>
                <?= $this->Form->input('status_atencion',array('type'=>'select','options'=>$status_atencion_clientes,'empty'=>'Todos los estatus de atención','class'=>'form-control chzn-select','id'=>'roberto','div'=>'col-lg-8','label'=>false )); ?>
            </div>

          </div>


          <div class="modal-footer">
            <!-- customer_filter -->
            <?= $this->Form->button('Realizar Búsqueda', array(
                'class'   => 'btn btn-success float-xs-right',
                'id'      => 'searchFilteringClient',
                'onclick' => 'customer_filter();',
                'type'    => 'button'
            )); ?>

          </div>

          <?= $this->Form->end()?>
      </div>
  </div>
</div>

<div id="content" class="bg-container">
    
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Lista de clientes
                </h4>
            </div>
            <div class="col-sm-12 col-lg-6">
                <?= $this->Html->link('Agregar cliente', array('controller' => 'clientes', 'action' => 'add'), array('escape' => false, 'class' => 'btn btn-success btn-sm float-xs-right mt-1')); ?>
            </div>
            
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            
                            <div class="row mt-2">
                                <div class="col-sm-12">
                                    <?= $this->Form->button('Búsqueda avanzada', array('class'=>'btn btn-link float-right', 'data-target' => '#myModal', 'data-toggle' => 'modal')); ?>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-12 mt-5">
                                    <!-- Tabla de clientes -->
                                    <table class="table table-striped table-no-bordered table-hover table-sm" id="sample_1"> </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php 
    echo $this->Html->script([

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
        'form',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',

        '/vendors/chosen/js/chosen.jquery',
        
    ], array('inline'=>false));
?>

<script>

    'use strict';

    // Datos para la tabla
    
    
    // Metodo para la tabla de clientes.
    var TableAdvanced = function() {
        // ===============table 1====================
        var initTable1 = function() {
            var table = $('#sample_1');
            table.DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: [ 3 ],
                        visible: false,
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
                columns: [

                    { title: "<i class='fa fa-circle'></i>" },
                    { title: "<i class='fa fa-filter'></i>" },
                    { title: "E.A" },
                    { title: "Id Cliente" },
                    { title: "Nombre" },
                    { title: "Desarrollo/Inmueble" },
                    { title: "Forma de contacto" },
                    
                    { title: "Correo eléctronico" },
                    { title: "Teléfono" },

                    { title: "Fecha de creación" },
                    { title: "Fecha ult. seg" },
                    { title: "Asesor" },
                    { title: "<i class='fa fa-eye'></i>" },
                    <?php if( $this->Session->read('Permisos.Group.ce') == 1 ): ?>
                        { title: "<i class='fa fa-edit'></i>" },
                    <?php endif; ?>
                    <?php if( $this->Session->read('Permisos.Group.cd') == 1 ): ?>
                        { title: "<i class='fa fa-trash'></i>" },
                    <?php endif; ?>
                    
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
            table = $('#sample_1').DataTable({
                'destroy': true,
                'paging': false,
                'lengthChange': true,
                'searching': false,
                'ordering': true,
                'info': true,
                'autoWidth': true                            
            });
            
            var tableWrapper = $('#list_clientes_all_wrapper');
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

    function modal_comentario( idCliente ) {

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "detalle_comentario")); ?>/' + idCliente ,
            cache: false,
            success: function ( response ) {
                
                document.getElementById("info_comentario").innerHTML  = response.comentario_completo;
                document.getElementById("info_seguimiento").innerHTML = response.ultimos_seguimientos;
                document.getElementById("info_telefono").innerHTML    = response.telefono;
                document.getElementById("info_correo").innerHTML      = response.correo;
                document.getElementById("info_last_edit").innerHTML   = response.last_edit;
                document.getElementById("info_status").innerHTML      = response.status;
                $("#modal_detalle_cliente").modal('show');

            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });
        
    }

    function customer_filter() {
        // Rogue
        // Datos para la tabla
        $.ajax({
            url  : '<?php echo Router::url(array("controller" => "clientes", "action" => "listado_clientes_json")); ?>',
            type : "POST",
            data : $("#ClienteIndexForm").serialize(),
            cache: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
                console.log($('#roberto').val());
            },
            success: function ( response ) {

                $('#sample_1').dataTable().fnClearTable();
                $('#sample_1').dataTable().fnDestroy();

                $('#sample_1').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 3 ],
                            visible: false,
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

                $("#overlay").fadeOut();
            },

            error: function(jqXHR, status, error){
                // error: function(error){
                    
                //     console.log( error.responseText );
                    
                // }
                // error: function ( response ){
                console.log( error );
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al consultar los clientes con estos filtros.';
                $("#overlay").fadeOut();
            }
        });
        
        // Ocultamos el modal del filtro del cliente.
        $('#myModal').modal('hide');

    }

    function ClienteDelete(id){
        $("#modal_cliente_delete").modal('show')
        document.getElementById("ClienteId").value = id;
    }

    function submitFormClientDelete() {
        $("#ClienteDeleteMasterForm").submit();
        $("#modal_cliente_delete").modal('hide');
    }

    // Actualización del campo de etapas desde la base de datos.
    function titleRow(){
        $('#ClienteEtapaCliente').empty().append('<option value="">Todas las etapas del cliente</option>');

        $.ajax({
            type: "GET",
            url: '<?php echo Router::url(array("controller" => "DicEmbudoVentas", "action" => "view_etapas")); ?>/'+<?= $this->Session->read('CuentaUsuario.Cuenta.id');?>,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                // $("#overlay").fadeIn();
            },
            success: function ( response ) {
                $.each(response, function(key, value) {
                    $('<option>').val('').text('select');
                    $('<option>').val(key).text(key + '.- '+ value).appendTo($("#ClienteEtapaCliente"));
                });
                
                // Actualización de chosen
                $('.chzn-select').trigger('chosen:updated');
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
        
    }
    
    
    $( document ).ready(function() {
        
        // Titulo de las etapas.
        titleRow();

        $("#overlay").fadeIn();

        TableAdvanced.init();

        $(".hide_search").chosen({disable_search_threshold: 10});
        $(".chzn-select").chosen({allow_single_deselect: true});
        $(".chzn-select-deselect,#select2_sample").chosen();

        $('.date_range').daterangepicker({
            orientation: 'auto top',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar'
            }
        });
        $('.date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            return false;
        });

        $('.date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            return false;
        });
        // 
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "listado_clientes_json")); ?>',
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
            
                $('#sample_1').dataTable().fnClearTable();
                $('#sample_1').dataTable().fnDestroy();

                $('#sample_1').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 3 ],
                            visible: false,
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
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa  fa-print"></i> Imprimir',
                            filename: 'ClientList',
                        },
                    ]
                
                });
                $("#overlay").fadeOut();
            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
            }
        });
        // 

    });




</script>