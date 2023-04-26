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

<div class="modal fade" id="">
  <div class="modal-dialog modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
    
      <div class="modal-header bg-blue-is">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
          <h4 class="modal-title">&nbsp;&nbsp; Información de la grafica.</h4>
      </div> <!-- Modal Header -->

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <p>
              <i class="fa fa-exclamation-triangle text-danger"></i>
              Esta grafica esta enfocada a la tabla de clientes inactivos, 
              los filtros estan enfocados en la fecha de creación de los clientes
              y por desarrollo.

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
		  LISTADO DE LEADS DUPLICADOS<!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12 mt-5">
          <!-- Tabla de clientes -->
          <table class="table table-striped table-no-bordered table-hover table-sm" id="sample_1"> </table>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id=""></small>
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
  // Metodo para la tabla de clientes C:\xampp\htdocs\cake\cakephp\app\View\Elements\Leads\tabla_clientes_leads_duplicados_by_ajax.ctp
  function tablaClientesLeadsDuplicados(  rangoFechas, medioId,  desarrolloId, cuentaId  ){
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "leads", "action" => "tabla_clientes_leads_duplicados")); ?>',
      cache: false,
      data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
      dataType: 'json',
      success: function ( response ) {
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
        // console.log(response);

      },
      error: function ( err ){
        console.log( err.responseText );
      }
    });
  }

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




    $( document ).ready(function() {
        TableAdvanced.init();

    });
</script>