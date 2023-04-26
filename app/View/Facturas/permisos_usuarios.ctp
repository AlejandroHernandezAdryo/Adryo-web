<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',

            // Chozen select
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/fileinput/css/fileinput.min',
                      
        ),
        array('inline'=>false))
?>
<style>
    .chosen-container {
        width: 100% !important;
        top: -5px;
        /*height: 24px;*/
    }

    .chosen-single,
    .chosen-container {
        height: calc(2.5rem - 2px);
    }

</style>
<?= $this->Form->create('ValidacionCategoria')?>
<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    Configuración de proceso de validación
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12">
                            <i class="fa fa-cogs"></i>Configuración de permisos de categoria <?= $this->Html->link($categoria['Categoria']['nombre'], array('controller'=>'desarrollos', 'action'=>'configuracion', $desarrollo_id), array('style'=>'color: white; text-decoration: underline;')) ?>
                            <?= $this->Form->submit('Guardar Cambios', array('class'=>'btn btn-success text-white float-lg-right')) ?>
                        </div>
                    </div>
                </div>
                <div class="card-block mt-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row" style="border-bottom: 1px solid gray; padding-bottom: 10px">
                                <div class="col-md-12" style="height:250px">
                                    <?= $this->Form->input('desarrollo_id', array('id'=>'desarrollos','multiple'=>'multiple','label'=>array('text'=>'Desarrollo(s) al que aplica la regla'),'class'=>'form-control','options'=>$desarrollos, 'style'=>"width:75%")); ?>
                                    <button type="button" class="seleccionar_todos btn btn-primary select">Todos</button>
                                </div>
                            </div>
                            <script>
                                function showNext(i) {
                                    document.getElementById('row' + i).style.display = "";
                                }

                            </script>
                            <?php 
                                for($i=0;$i<10;$i++){
                                    if (isset($categoria['ValidacionCategoria'][$i])){
                            ?>
                            <div class="row" id="row<?= $i?>" style="border-bottom: 1px solid gray; padding-bottom: 10px">
                                <div class="col-md-5">
                                    <?= $this->Form->input('validador_user_id'.$i, array('value'=>$categoria['ValidacionCategoria'][$i]['user_id'],'label'=>'Usuario Verificador '.($i+1),'class'=>'form-control chzn-select', 'empty'=>'Seleccione una opción', 'options'=>$usuarios)); ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $this->Form->input('monto_maximo'.$i, array('value'=>$categoria['ValidacionCategoria'][$i]['monto_maximo'],'label'=>'Autorización a partir del monto','class'=>'form-control', 'placeholder'=>'Monto máximo')); ?>
                                </div>
                                <div class="col-md-2">
                                    <?php 
                                                if ($i<10){
                                                    echo $this->Html->link('<i class="fa fa-plus"></i>',"javascript:showNext($i+1)",array('escape'=>false));
                                                }
                                            ?>
                                </div>
                            </div>
                            <?php 
                                    }else{
                                        $invisible = "display:none";
                                        if ($i==0){
                                            $invisible = "";
                                        }
                            ?>
                            <div class="row" id="row<?= $i?>" style="<?= $invisible?>; border-bottom: 1px solid gray; padding-bottom: 10px">
                                <div class="col-md-5">
                                    <?= $this->Form->input('validador_user_id'.$i, array('label'=>'Usuario Verificador '.($i+1),'class'=>'form-control chzn-select', 'empty'=>'Seleccione una opción', 'options'=>$usuarios)); ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $this->Form->input('monto_maximo'.$i, array('label'=>'Autorización a partir del monto','class'=>'form-control', 'placeholder'=>'Monto máximo')); ?>
                                </div>
                                <div class="col-md-2">
                                    <?php 
                                                if ($i<10){
                                                    echo $this->Html->link('<i class="fa fa-plus"></i>',"javascript:showNext($i+1)",array('escape'=>false));
                                                }
                                            ?>
                                </div>
                            </div>
                            <?php 
                                    }
                            ?>
                            <?php }?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?= $this->Form->input('pago_user_id', array('id'=>'pagos','label'=>'Usuarios Autorizados para efectuar pagos','class'=>'form-control chzn-select', 'multiple'=>'multiple','empty'=>'Seleccione una opción', 'options'=>$usuarios)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla de puntos de revisión de facturas -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Form->hidden('categoria_id',array('value'=>$categoria['Categoria']['id']))?>
<?= $this->Form->end()?>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
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

        // Chosen
        '/vendors/chosen/js/chosen.jquery',
        
    ], array('inline'=>false));
?>

<script>
    'use strict';

    function showmonto() {
        if (document.getElementById('ValidacionCategoriaEstado').value == 2) {
            document.getElementById('input-monto-maximo').style.display = '';
        } else {
            document.getElementById('input-monto-maximo').style.display = 'none';
        }
    }

    $(document).ready(function() {

        // Chosen
        $(".hide_search").chosen({
            disable_search_threshold: 10
        });
        $(".chzn-select, #desarrollos").chosen({
            allow_single_deselect: true
        });
        $('#desarrollos').val([<?= substr($categoria['Categoria']['desarrollo_id'],1,-1)?>]);
        $('#desarrollos').trigger("chosen:updated");
        $('#pagos').val([<?= substr($pagos,0,-1)?>]);
        $('#pagos').trigger("chosen:updated");
        $(".chzn-select-deselect,#select2_sample").chosen();

        $('.seleccionar_todos').each(function(index) {
            console.log(index);
            $(this).on('click', function() {
                console.log($(this).parent().find('option').text());
                $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
            });
        });

        TableAdvanced.init();
        $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
        $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

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

    });

    var TableAdvanced = function() {
        // ===============table 1====================
        var initTable1 = function() {
            var table = $('.dataTablesAi');
            /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
            /* Set tabletools buttons and button container */
            table.DataTable({
                dom: 'Bflr<"table-responsive"t>ip',
                order: [3, 'asc'],
                buttons: [{
                        extend: 'csv',
                        text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                        filename: 'Proveedores',
                        class: 'excel',
                    },
                    {
                        extend: 'print',
                        text: '<i class="fa  fa-print"></i> Imprimir',
                        filename: 'Proveedores',
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

</script>
