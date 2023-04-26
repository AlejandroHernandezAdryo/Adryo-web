<?= $this->Html->css('/vendors/select2/css/select2.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/scroller.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/dataTables.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('pages/dataTables.bootstrap',array('inline'=>false)) ?>
<?= $this->Html->css('pages/tables',array('inline'=>false)) ?>

<div class="container">
    <div class="inner">

        <div class="card mt-5">
            <div class="card-header bg-blue-is">
                Creación de cliente CSV
            </div>
            <?= $this->Form->create('Clientes', array('type' => 'file')) ?>
                <div class="card-block">

                    <div class="row mt-1">
                        <?= $this->Form->input('propiedad',
                            array(
                                'label'   => array('text'=>'Forma de contacto*', 'id'=>'ClienteDicLineaContactoIdLabel', 'class'=>'fw-700'),
                                'div'     => 'col-sm-12 col-md-6',
                                'class'   => 'form-control chzn-select',
                                'type'    => 'select',
                                'empty'   => 'Seleccionar desarrollo' ,
                                'options' => $list_desarrollos,
                                'style'   => 'text-transform: uppercase;',
                                'required'
                            )
                        )?>

                        <?= $this->Form->input('dic_linea_contacto_id',
                            array(
                                'label'   => array('text'=>'Forma de contacto*', 'id'=>'ClienteDicLineaContactoIdLabel', 'class'=>'fw-700'),
                                'div'     => 'col-sm-12 col-md-6',
                                'class'   => 'form-control chzn-select',
                                'type'    => 'select',
                                'empty'   => 'Seleccionar la forma de contacto' ,
                                'options' => $list_linea_contactos,
                                'style'   => 'text-transform: uppercase;',
                                'required'
                            )
                        )?>

                    </div>

                    <div class="row">
                        <?=
                            $this->Form->input('user_id',
                                array(
                                    'label'=>array('text' => 'Agente Comercial*', 'class' => 'fw-700', 'id' => 'ClienteUserIdLabel'),
                                    'div' => 'col-sm-12 col-md-6',
                                    'class'=>'form-control chzn-select',
                                    'empty'=>'SIN AGENTE ASIGNADO',
                                    'options' => $list_users
                                )
                            );
                        ?>

                        <?= $this->Form->input('dic_tipo_cliente_id',
                            array(
                                'label'    => array('text'=>'Tipo de cliente*', 'id'=>'ClienteDicTipoClienteIdLabel', 'class'=>'fw-700'),
                                'div'      => 'col-sm-12 col-md-6',
                                'class'    => 'form-control chzn-select',
                                'type'     => 'select',
                                'empty'    => 'Seleccionar el tipo de cliente',
                                'options'  => $list_tipos_cliente,
                                'style'    => 'text-transform: uppercase;',
                                'required' => true
                            )
                        )?>

                    </div>

                    <div class="row">
                        <?= $this->Form->input('archivo', array(
                                'class' => 'form-control',
                                'type'  => 'file',
                                'div'   => 'col-sm-12'
                            )
                        ) ?>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <?= $this->Form->submit('Cargar archivo', array('class' => 'btn btn-primary float-right')); ?>
                </div>
            <?= $this->Form->end(); ?>
        </div>

        <div class="card mt-5">
            <div class="card-block">
            
                <!-- <table id="list_clientes_csv" class="table display" >
                    <thead>
                        <tr>
                            <th>Cliente id</th>
                            <th>Status de cliente</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Fecha de creación</th>
                            <th>Seguimiento</th>
                            <th>Desarrollo de interes</th>
                            <th>Linea de contacto</th>
                            <th>Asesor</th>
                            <th>Tipo de cliente</th>
                            <th>Cuenta</th>
                            <th>Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach( $clientes as $cliente ): ?>
                            <tr>
                                <td><?= $cliente['cliente_id'] ?></td>
                                <td><?= $client_validate[$cliente['status_cliente']] ?></td>
                                <td><?= $cliente['nombre'] ?></td>
                                <td><?= $cliente['email'] ?></td>
                                <td><?= $cliente['telefono'] ?></td>
                                <td><?= $cliente['created'] ?></td>
                                <td><?= $cliente['seguimiento'] ?></td>
                                <td><?= $list_desarrollos[$cliente['propiedad']] ?></td>
                                <td><?= $list_linea_contactos[$cliente['dic_linea_contacto_id']] ?></td>
                                <td><?= $list_users[$cliente['user_id']] ?></td>
                                <td><?= $list_tipos_cliente[$cliente['dic_tipo_cliente_id']] ?></td>
                                <td><?= $this->Session->read('CuentaUsuario.Cuenta.razon_social') ?></td>
                                <td><?= $cliente['cliente'] ?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table> -->

                <pre>
                    <?=
                        print_r($clientes);
                    ?>
                </pre>

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
$(document).ready(function () {

    // Duplicar el encabezado de la tabla Cotizaciones para la busqueda por columna
    $('#list_clientes_csv thead tr').clone(true).appendTo( '#list_clientes_csv thead' );
        $('#list_clientes_csv thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if (table_kpidesarrollos.column(i).search() !== this.value ) {
                    table_kpidesarrollos
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
    });
    
    var table_kpidesarrollos = $('#list_clientes_csv').DataTable({
        dom: 'Bflr<"table-responsive"t>ip',
        orderCellsTop: true,
        autoWidth: true,
        columnDefs: [
            {targets: 0, width: '40px'},
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
            infoEmpty:      "0 registros",
        },
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                class : 'excel',
                className: 'btn-secondary',
                filename: 'list_clientes_csv',
                charset: 'utf-8',
                bom: true
            },
            {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                className: 'btn-secondary',
                filename: 'list_clientes_csv'
            },
        ]
    });

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

});
    

</script>