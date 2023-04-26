<?= $this->Html->css('/vendors/select2/css/select2.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/scroller.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/dataTables.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('pages/dataTables.bootstrap',array('inline'=>false)) ?>
<?= $this->Html->css('pages/tables',array('inline'=>false)) ?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Lista de ventas
                        </h4>
                    </div>
                    
                </div>
            </header>
            
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <?= $this->Form->create('Cuenta')?>
            <div class="card">
                
                <div class="card-block">
                    <div style="margin-top: 55px;">
                    
                        <table id="kpi_desarrollos" class="table display" >
                            <thead>
                                <tr>
                                    <th>Tipo operación</th>
                                    <th>Propiedad</th>
                                    <th>Cliente</th>
                                    <th>Linea de contacto</th>
                                    <th>Asesor</th>
                                    <th>Fecha operación</th>
                                    <th>Precio de venta</th>
                                    <?php if ($this->Session->read('Permisos.Group.id')==1){?>
                                    <th class="finanzas">Generar Programación de Pagos</th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($ventas_generales as $venta_global):
                                    if($venta_global['Venta']['tipo_operacion'] == 'Venta'){$op = 'V'; $class_op = 'bg_venta'; $name_op = 'Venta';}
                                    else{$op = 'R'; $class_op = 'bg_renta'; $name_op = 'Renta';}
                                ?>
                                <tr>
                                    <td class="text-sm-center"><small><span class="<?= $class_op ?>"><?= $op ?></span></small><span class="text_hidden"><?= $name_op ?></span></td>
                                    <td>
                                        <?php if ($this->Session->read('Permisos.Group.dr') == 1): ?>
                                        <ins>
                                            <?php 
                                                if( $this-> Session->read('Permisos.Group.id') == 5 ) {
                                                    echo $this->Html->link($venta_global['Inmueble']['referencia'], '#', array('class' => 'disabled'));
                                                }else {
                                                    echo $this->Html->link($venta_global['Inmueble']['referencia'], array('controller'=>'inmuebles', 'action'=>'view_tipo', $venta_global['Inmueble']['id']));
                                                }
                                            ?>
                                        </ins>
                                        <?php else: ?>
                                        <?php echo $venta_global['Inmueble']['referencia'] ?>
                                        <?php endif; ?>
                                    </td>
                                    
                                    
                                    <td>
                                        <?php if ($this->Session->read('Permisos.Group.dr') == 1): ?>
                                            <ins>
                                                <?= $this->Html->link($venta_global['Cliente']['nombre'], array('controller'=>'clientes', 'action'=>'view', $venta_global['Cliente']['id'])) ?>
                                            </ins>
                                        <?php else: ?>
                                            <?php echo $venta_global['Cliente']['nombre']; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?= $venta_global['Cliente']['DicLineaContacto']['linea_contacto'] ?>
                                    </td>
                                    
                                    <td>
                                        <?php if ($this->Session->read('Permisos.Group.dr') == 1): ?>
                                          <ins>
                                                <?php 
                                                    if( $this-> Session->read('Permisos.Group.id') == 5 ) {
                                                        echo $this->Html->link($venta_global['User']['nombre_completo'], '#', array('class' => 'disabled'));
                                                    }else {
                                                        echo $this->Html->link($venta_global['User']['nombre_completo'], array('controller'=>'users', 'action'=>'view', $venta_global['User']['id']));
                                                    }
                                                ?>
                                          </ins>
                                        <?php else: ?>
                                          <?php echo $venta_global['User']['nombre_completo']; ?>
                                        <?php endif; ?>
                                    </td>

                                    <td><?= date('Y-m-d', strtotime($venta_global['Venta']['fecha'])) ?></td>
                                    <td class="text-xs-right">$ <?= number_format($venta_global['Venta']['precio_cerrado'], 2) ?></td>
                                    <?php if ($this->Session->read('Permisos.Group.id')==1): ?>
                                        <td class="text-sm-center finanzas">
                                          <?php 
                                          if (sizeof($venta_global['Facturas'])>0){
                                              echo $this->Html->link('<i class="fa fa-eye fa-x2"></i>', array('controller'=>'aportacions', 'action'=>'ver_plan_pagos', $venta_global['Venta']['id']), array('escape'=>false)); 
                                          }else{
                                              echo $this->Html->link('<i class="fa fa-file-o fa-x2"></i>', array('controller'=>'facturas', 'action'=>'add_factura_cliente', $venta_global['Venta']['id']), array('escape'=>false)); 
                                          }
                                          ?>
                                        </td>
                                    <?php endif; ?>

                                </tr>
                            
                                <?php endforeach ?>
                            </tbody>
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
    $('#kpi_desarrollos thead tr').clone(true).appendTo( '#kpi_desarrollos thead' );
        $('#kpi_desarrollos thead tr:eq(1) th').each( function (i) {
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


    var table_kpidesarrollos = $('#kpi_desarrollos').DataTable({
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
                filename: 'KPI_Desarrollos',
                charset: 'utf-8',
                bom: true
            },
            {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                className: 'btn-secondary',
                filename: 'KPI_Desarrollos'
            },
        ]
    });

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

});
    

</script>