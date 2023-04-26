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
                            Lista de Desarrollos
                        </h4>
                    </div>
                    
                </div>
            </header>
            
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <?= $this->Form->create('Cuenta')?>
            <div class="card">
                <div class="card-header bg-white">
                    <i class="fa fa-building"> </i>Desarrollos
                    <div style="float:right">
                        <?php echo $this->Form->submit('Guardar Cambios',array('class'=>'btn btn-success'))?>
                    </div>
                </div>
                <div class="card-block">
                    <div style="margin-top: 55px;">
                    
                        <table id="kpi_desarrollos" class="table display" >
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Meta ($)</th>
                                <th>Meta (Q)</th>
                                <th>Vigencia</th>
                                <th>Nueva Meta ($)</th>
                                <th>Nueva Meta (Q)</th>
                            </tr>
                            </thead>
                            <tbody>
                            
                            <?php 
                                $i=0;
                                foreach ($desarrollos as $desarrollo):
                                
                                $vencido = (isset($kpi_arreglo[$desarrollo['Desarrollo']['id']]['fin']) && $kpi_arreglo[$desarrollo['Desarrollo']['id']]['fin'] > date("Y-m-d") ? "background-color:green;color:white" : "background-color:red;color:white");
                            ?>
                            <tr>
                                <td><?= $desarrollo['Desarrollo']['nombre']?></td>
                                <td><?= (isset($kpi_arreglo[$desarrollo['Desarrollo']['id']]['monto'])?"$".number_format($kpi_arreglo[$desarrollo['Desarrollo']['id']]['monto'],0):"N/A")?></td>
                                <td><?= (isset($kpi_arreglo[$desarrollo['Desarrollo']['id']]['unidades'])?$kpi_arreglo[$desarrollo['Desarrollo']['id']]['unidades']:"N/A")?></td>
                                <td style="<?= $vencido?>"><?= (isset($kpi_arreglo[$desarrollo['Desarrollo']['id']]['fin'])?date("d/m/Y",strtotime($kpi_arreglo[$desarrollo['Desarrollo']['id']]['fin'])):"N/A")?></td>
                                <td><?php echo $this->Form->input('meta_v'.$i, array('label'=>false,'placeholder'=>'Meta en Pesos'));?></td>
                                <td><?php echo $this->Form->input('meta_q'.$i, array('label'=>false,'placeholder'=>'Meta en Unidades'));?></td>
                                <?php echo $this->Form->hidden('desarrollo_id'.$i,array('value'=>$desarrollo['Desarrollo']['id']));?>
                                <?php echo $this->Form->hidden('registro_id'.$i,array('value'=>(isset($kpi_arreglo[$desarrollo['Desarrollo']['id']]['registro_id'])?$kpi_arreglo[$desarrollo['Desarrollo']['id']]['registro_id']:null)));?>
                            <?php 
                                $i++;
                                endforeach;
                            ?>
                        </tbody>
                        </table>
                        <?php echo $this->Form->hidden('contador',array('value'=>$i));?>
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


    $('#date_range').daterangepicker({
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
    
    $('[data-toggle="popover"]').popover()

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