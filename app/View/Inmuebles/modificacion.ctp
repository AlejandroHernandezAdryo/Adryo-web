<?php
$disposicion = array('Frente'=>'Frente','Medio'=>'Medio','Interior'=>'Interior');
$orientacion =  array('Norte'=>'Norte','Sur'=>'Sur','Este'=>'Este','Oeste'=>'Oeste','Sureste'=>'Sureste','Suroeste'=>'Suroeste','Noreste'=>'Noreste','Noroeste'=>'Noroeste');
$estado = array('Nuevo'=>'Nuevo','Excelente'=>'Excelente','Bueno'=>'Bueno','Regular'=>'Regular','Malo'=>'Malo','Remodelado'=>'Remodelado','Para Remodelar'=>'Para Remodelar');
// echo $this->Form->input('estado',array('options'=>$estado,'class'=>'form-control','div' => 'form-group col-md-4'));

echo $this->Html->css(
        array(
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
            
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
            // '/vendors/clockpicker/css/jquery-clockpicker',
            'pages/colorpicker_hack'
            //'pages/form_elements'
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Modificación de Inventario</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <pre>
                                <?php /*print_r($desarrollo);*/ ?>
                            </pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <h3><?= $this->Html->link($desarrollo['Desarrollo']['nombre'],array('controller'=>'desarrollos','action'=>'view',$desarrollo['Desarrollo']['id']))?></h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <!-- <div class="table-responsive"> -->
                                  <table class="table table-hover table-bordered" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Referencia</th>
                                                <th>Titulo</th>
                                                <th>Precio Venta</th>
                                                <th>Precio Renta</th>
                                                <th>Sup. Hab</th>
                                                <th>Sup. No Hab</th>
                                                <th>Sup. total</th>
                                                <th>Disposicion</th>
                                                <th>Orientacion</th>
                                                <th>Nivel</th>
                                                <th>Habitaciones</th>
                                                <th>Baños</th>
                                                <th>Medios Baños</th>
                                                <th>Est. Techados</th>
                                                <th>Est. Descubiertos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 0; foreach ($tipos as $tipo):  $count++;?>
                                                <tr>
                                                    <td>
                                                        <?= $this->Form->hidden('id', array('value'=>$tipo['Inmueble']['id'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][id]')); ?>

                                                        <?= $this->Form->input('liberada', array('id'=>'liberada'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"liberada",'.$count.')','value'=>$tipo['Inmueble']['liberada'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][liberada]', 'type'=>'select', 'label'=>False, 'options'=>$array_options_liberada, 'style'=>'width: 110px; height: 15px !important;'));?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('referencia', array('id'=>'referencia'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"referencia",'.$count.')','value'=>$tipo['Inmueble']['referencia'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][referencia]', 'style'=>'width: 250px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('titulo', array('id'=>'titulo'.$count,'class'=>'form-control', 'value'=>$tipo['Inmueble']['titulo'], 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"titulo",'.$count.')','name'=>'data[InmuebleTipo]['.$count.'][Inmueble][titulo]', 'style'=>'width: 250px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('precio', array('id'=>'precio'.$count,'class'=>'form-control', 'value'=>$tipo['Inmueble']['precio']==""?0:$tipo['Inmueble']['precio'], 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"precio",'.$count.')','name'=>'data[InmuebleTipo]['.$count.'][Inmueble][precio]', 'style'=>'width: 80px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('precio_2', array('id'=>'precio_2'.$count,'class'=>'form-control', 'value'=>$tipo['Inmueble']['precio_2']==""?0:$tipo['Inmueble']['precio_2'], 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"precio_2",'.$count.')','name'=>'data[InmuebleTipo]['.$count.'][Inmueble][precio_2]', 'style'=>'width: 70px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('construccion', array('id'=>'construccion'.$count,'class'=>'form-control', 'value'=>$tipo['Inmueble']['construccion']==""?0:$tipo['Inmueble']['construccion'], 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"construccion",'.$count.')','name'=>'data[InmuebleTipo]['.$count.'][Inmueble][construccion]', 'style'=>'width: 80px;', 'label'=>False)); ?>
                                                        
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('construccion_no_habitable', array('id'=>'construccion_no_habitable'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"construccion_no_habitable",'.$count.')','value'=>$tipo['Inmueble']['construccion_no_habitable']==""?0:$tipo['Inmueble']['construccion_no_habitable'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][construccion_no_habitable]', 'style'=>'width: 80px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?php $total =  $tipo['Inmueble']['construccion_no_habitable'] + $tipo['Inmueble']['construccion']; echo $total;?>
                                                    </td>

                                                    
                                                    <td><?= $this->Form->input('disposicion',array('id'=>'disposicion'.$count,'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][disposicion]','onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"disposicion",'.$count.')','options'=>$disposicion,'class'=>'form-control', 'label'=>False, 'value' => $tipo['Inmueble']['disposicion'], 'style'=>'height: 15px !important;')); ?></td>
                                                    <td><?= $this->Form->input('orientacion',array('id'=>'orientacion'.$count,'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][orientacion]','onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"orientacion",'.$count.')','options'=>$orientacion,'class'=>'form-control', 'label'=>False, 'value' => $tipo['Inmueble']['orientacion'], 'style'=>'height: 15px !important;')); ?></td>


                                                    <td>
                                                        <?= $this->Form->input('nivel_propiedad', array('id'=>'nivel_propiedad'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"nivel_propiedad",'.$count.')','value'=>$tipo['Inmueble']['nivel_propiedad']==""?0:$tipo['Inmueble']['nivel_propiedad'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][nivel_propiedad]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('recamaras', array('id'=>'recamaras'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"recamaras",'.$count.')','value'=>$tipo['Inmueble']['recamaras']==""?0:$tipo['Inmueble']['recamaras'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][recamaras]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('banos', array('id'=>'banos'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"banos",'.$count.')','value'=>$tipo['Inmueble']['banos']==""?0:$tipo['Inmueble']['banos'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][banos]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('medio_banos', array('id'=>'medio_banos'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"medio_banos",'.$count.')','value'=>$tipo['Inmueble']['medio_banos']==""?0:$tipo['Inmueble']['medio_banos'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][medio_banos]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('estacionamiento_techado', array('id'=>'estacionamiento_techado'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"estacionamiento_techado",'.$count.')','value'=>$tipo['Inmueble']['estacionamiento_techado']==""?0:$tipo['Inmueble']['estacionamiento_techado'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][estacionamiento_techado]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                    <td>
                                                        <?= $this->Form->input('estacionamiento_descubierto', array('id'=>'estacionamiento_descubierto'.$count,'class'=>'form-control', 'onchange'=>'javascript:updateCampo('.$tipo['Inmueble']['id'].',"estacionamiento_descubierto",'.$count.')','value'=>$tipo['Inmueble']['estacionamiento_descubierto']==""?0:$tipo['Inmueble']['estacionamiento_descubierto'], 'name'=>'data[InmuebleTipo]['.$count.'][Inmueble][estacionamiento_descubierto]', 'style'=>'width: 30px;', 'label'=>False)); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                    <div class="row mt-2">
                                        <div class="col-sm-12">
                                            <?= $this->Html->link('Guardar información',array('controller'=>'desarrollos','action'=>'view',$desarrollo['Desarrollo']['id']),array('class'=>'btn btn-success'))?>
                                        </div>
                                    </div>
                            <script>
                                function updateCampo(id_inmueble,campo,row){
                                    var dataString = "id="+id_inmueble+"&campo="+campo+"&value="+document.getElementById(campo+row).value;
                                    //var dataString = 'marca='+ marca+'&anio='+anio;
                                    $.ajax({
                                        type: "POST",
                                        url: '<?php echo Router::url(array("controller" => "inmuebles", "action" => "update_ajax"), TRUE); ?>' ,
                                        data: dataString,
                                        cache: false,
                                    });
                                }
                            </script>
                            <!-- </div> -->
                        </div>
                    </div>
                    <!-- End row table -->
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
        /*'/vendors/datatables/js/dataTables.colReorder.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/datatable',*/
//        'pages/advanced_tables'
    ], array('inline'=>false));
?>


<script>
'use strict';
$(document).ready(function () {

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
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            paging: false,
            buttons: [
                
                
                
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