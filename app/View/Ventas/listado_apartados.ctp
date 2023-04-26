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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('Desarrollo'); ?>
          <div class="modal-header bg-blue-is">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1">
                  <i class="fa fa-cogs"></i>
                  Parámetros de reporte
              </h4>
          </div>
        <div class="modal-body">
            <div class="row">
                <?= $this->Form->input('rango_fechas', array('class'=>'form-control ', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>
                <div class="col-sm-12 mt-2">
                    <label for="ClientePropiedades" id="ClientePropiedadesInteresLabel" class="fw-700">Propiedades de Interés*</label>
                    <select class="form-control chzn-select required" required="required" name="data[Desarrollo][desarrollo_id]" id="DesarrolloDesarrolloId">
                        <option value="0">Seleccionar un desarrollo o Cluster</option>
                        <optgroup label="DESARROLLOS">
                            <?php foreach ($search_desarollo as $desarollo):?>
                            <option value="D<?= $desarollo['Desarrollo']['id'] ?>" style="font-style: oblique"><?= $desarollo['Desarrollo']['nombre'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
            </div>
          </div>
          <div class="modal-footer mt-3">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
              </button>
              <button type="button" class="btn btn-success float-xs-right" onclick='search_listado()'>
                    Buscar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i>
                    Lista de Apartados 
                </h4>
            </div> 
            <div class="col-sm-12 col-lg-6">
				<?= $this->Html->link('<i class="fa fa-cogs fa-2x"></i> Cambiar Rango de Fechas y Desarrollo', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no-imprimir float-xs-right','style'=>"color:white")) ?>
			</div>
            
        </div>
    </header>   
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <?= $this->Form->create('Cuenta')?>
            <div class="card">
                
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
    
    // $(document).ready(function () {

    //     // Duplicar el encabezado de la tabla Cotizaciones para la busqueda por columna
    //     $('#kpi_desarrollos thead tr').clone(true).appendTo( '#kpi_desarrollos thead' );
    //         $('#kpi_desarrollos thead tr:eq(1) th').each( function (i) {
    //             var title = $(this).text();
    //             $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

    //             $( 'input', this ).on( 'keyup change', function () {
    //                 if (table_kpidesarrollos.column(i).search() !== this.value ) {
    //                     table_kpidesarrollos
    //                         .column(i)
    //                         .search( this.value )
    //                         .draw();
    //                 }
    //             } );
    //     });


    //     var table_kpidesarrollos = $('#kpi_desarrollos').DataTable({
    //         dom: 'Bflr<"table-responsive"t>ip',
    //         orderCellsTop: true,
    //         autoWidth: true,
    //         columnDefs: [
    //             {targets: 0, width: '40px'},
    //         ],
    //         language: {
    //             sSearch: "Buscador",
    //             lengthMenu: '_MENU_ registros por página',
    //             info: 'Mostrando _TOTAL_ registro(s)',
    //             infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
    //             emptyTable: "Sin información",
    //             paginate: {
    //                 previous: 'Anterior',
    //                 next: 'Siguiente'
    //             },
    //             infoEmpty:      "0 registros",
    //         },
    //         lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
    //         buttons: [
    //             {
    //                 extend: 'excel',
    //                 text: '<i class="fa  fa-file-excel-o"></i> Exportar',
    //                 class : 'excel',
    //                 className: 'btn-secondary',
    //                 filename: 'KPI_Desarrollos',
    //                 charset: 'utf-8',
    //                 bom: true
    //             },
    //             {
    //                 extend: 'print',
    //                 text: '<i class="fa  fa-print"></i> Imprimir',
    //                 className: 'btn-secondary',
    //                 filename: 'KPI_Desarrollos'
    //             },
    //         ]
    //     });

    //     TableAdvanced.init();
    //     $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    //     $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

    // });
    let cuenta_id=<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')?>;
    let dia= "<?=date('d-m-Y') ?>";
    $(document).ready(function () {
        
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "ventas", "action" => "listado_apartados")); ?>',
            cache: false,
            data: {
                    dia: dia, 
                    cuenta_id: cuenta_id,  
                },
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
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
                
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
        window.setInterval(function(){
            // $('#modalFilter').modal('hide');
            $("#overlay").fadeOut();
        },1000); 
        $('#date_range').daterangepicker({
            orientation:"bottom",
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
            });
            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            return false;
            });
            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            return false;
            });
            $('.seleccionar_todos').each(function(index) {
            $(this).on('click', function() {
                $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
            });
        });
        $('[data-toggle="popover"]').popover();
    });
    function search_listado() {
        let rango_fechas=  $("#date_range").val();
        let desarrollo_id=  $('#DesarrolloDesarrolloId').val();
        let cuenta_id=<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')?>;

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "ventas", "action" => "listado_apartados")); ?>',
            data: { rango_fechas:rango_fechas, desarrollo_id:desarrollo_id, cuenta_id: cuenta_id},
            cache: false,
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

                    { title: "Tipo De Operacion" },
                    { title: "Propiedad" },
                    { title: "Cliente" },
                    { title: "Linea De Contacto" },
                    { title: "Asesor" },
                    { title: "Fecha de operacion" },
                    { title: "vigenci" },
                    { title: "Apartado" },
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