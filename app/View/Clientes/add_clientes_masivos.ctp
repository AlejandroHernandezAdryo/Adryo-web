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
<div id="content" class="bg-container">
    
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    Carga de Clientes forma masiva
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
                            <?= $this->Form->create( 'OperacionesCSV', array('type' => 'file') ) ?>
                                <div class="row">
                                    <?= $this->Form->input('file', array(
                                        'div' => 'col-sm-12',
                                        'type' => 'file'
                                    )) ?>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $this->Form->submit('Cargar archivo', array('class' => 'btn btn-primary btn-block'));  ?>
                                    </div>
                                </div>

                            <?= $this->Form->end() ?>
                            <?= $this->Form->create( 'Cliente' ) ?>
                                    <div class="table-responsive">
                                        <table class="table" id="TableVentasMasivass">
                                            <thead>
                                                <tr>
                                                    <th>nombre</th>
                                                    <th>telefono1</th>
                                                    <th>correo</th>
                                                    <th>Fecha de creacion </th>
                                                    <th>desarollo ID</th>
                                                    <th>medio ID</th>
                                                    <!-- <th>Escrituracion</th>
                                                    <th>Inmueble ID</th>  -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 0; ?>
                                                <?php foreach( $response['data'] as $row ): ?>
                                                    
                                                    <?php $newData[0] = explode(',', $row); ?>
                                                    <tr>
                                                        
                                                    <?php foreach( $newData as $venta ): ?>
                                                        
                                                        <td>
                                                            <?= $this->Form->input('nombre', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                'value' => $venta[1],
                                                                'name' => 'data[Cliente]['.$i.'][nombre]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('telefono1', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                'value' => $venta[2],
                                                                'name' => 'data[Cliente]['.$i.'][telefono1]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('correo', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                'value' => $venta[3],
                                                                'name' => 'data[Cliente]['.$i.'][correo]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('fecha', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                'value' => $venta[4],
                                                                'name' => 'data[Cliente]['.$i.'][fecha]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('desarollo', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                'options' => $desarrollos,
                                                                'value' => $venta[5],
                                                                'name' => 'data[Cliente]['.$i.'][desarollo]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('medio', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                // 'options' => $dic_linea_contacto,
                                                                'value' => $venta[6],
                                                                // 'value' => $dic_linea_contacto,
                                                                'name' => 'data[Cliente]['.$i.'][medio]'
                                                            )) ?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->input('tipo', array(
                                                                'label' => false,
                                                                'class' => 'form-control',
                                                                'div'   => 'col-sm-12',
                                                                // 'options' => $dic_linea_contacto,
                                                                'value' => $tipo_cliente,
                                                                // 'value' => $dic_linea_contacto,
                                                                'name' => 'data[Cliente]['.$i.'][tipo]'
                                                            )) ?>
                                                        </td>
                                                    <?php $i++ ; ?>
                                                    <?php endforeach;?>
    
                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= $this->Form->submit('Guardar', array('class' => 'btn btn-primary btn-block')); ?>
                                        </div>
                                    </div>
                                <?= $this->Form->end() ?>
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

    $(document).on("submit", "#ClienteAddClientesMasivosForm", function (event) {
        $("#overlay").fadeIn();
        event.preventDefault();
        $.ajax({
            url        : '<?php echo Router::url(array('action'=>'f_add_Cliente','controller'=>'Clientes')); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                // event.preventDefault();
                
                console.log( response );
                // location.reload();

            },
            error: function ( response ) {
                console.log( response.responseText );
            },
        });
    });

    // Metodo para la tabla de clientes.
    var TableAdvanced = function() {
        // ===============table 1====================
        var tableVentasMasivas = function() {
            var table = $('#TableVentasMasivas');
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
                tableVentasMasivas();
                
            }
        };
    }();

    $( document ).ready(function() {

        TableAdvanced.init();

    });


</script>