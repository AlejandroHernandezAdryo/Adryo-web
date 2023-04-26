<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
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

            // Calendario
            '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            'pages/colorpicker_hack',
            
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
                      
        ),
        array('inline'=>false))
?>
<style>
    textarea{
        overflow:hidden;
        display:block;
        min-height: 30px;
    }
    .chosen-container {
        width: 100% !important;
        display: block;
        height: 30px;
    }
    .error{
        width: 100%;
        text-align: center;
        color: red;
    }
</style>
<div class="modal fade" id="modalNewCluster">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-blue-is">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel1">
                Agregar Cluster
            </h4>

        </div>

        <?= $this->Form->create('Cluster', array('url'=>array('action'=>'addCluster', 'controller'=>'desarrollos'))) ?>
        <div class="modal-body">
            <div id="body-factura">
                
                <div Class="row mt-1">
                    <?= $this->Form->input('nombre', array('class'=>'form-control', 'div'=>'col-sm-12', 'label'=>'Nombre del Cluster*', 'required'=>true)) ?>
                </div>

                <div Class="row mt-1">
                    <?= $this->Form->input('desarrollo_id', Array('id'=>'desarrollo','multiple'=>'multiple','class'=>'form-control chzn-select', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Ningún desarrollo', 'options'=>$desarrollos, 'label'=>'Desarrollo al que pertenece el gasto*', 'required'=>true)) ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success float-xs-right" id="boton_submit">
                Crear cluster
            </button>

            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                Cerrar
            </button>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
</div>

<div class="modal fade" id="editCluster">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-blue-is">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel1">
                Editar Cluster
            </h4>

        </div>

        <?= $this->Form->create('Cluster', array('url'=>array('action'=>'editCluster', 'controller'=>'desarrollos'))) ?>
        <div class="modal-body">
            <div id="body-factura">
                
                <div Class="row mt-1">
                    <?= $this->Form->hidden('id',array('id'=>'editId'))?>
                    <?= $this->Form->input('nombre', array('id'=>'editNombre','class'=>'form-control', 'div'=>'col-sm-12', 'label'=>'Nombre del Cluster*', 'required'=>true)) ?>
                </div>

                <div Class="row mt-1">
                    <?= $this->Form->input('desarrollo_id', Array('id'=>'editDesarrollo','multiple'=>'multiple','class'=>'form-control chzn-select', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Ningún desarrollo', 'options'=>$desarrollos, 'label'=>'Desarrollo al que pertenece el gasto*', 'required'=>true)) ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success float-xs-right" id="boton_submit">
                Modificar cluster
            </button>

            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                Cerrar
            </button>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
</div>



<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-building"></i>
                    Listado de Clusters
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php //if (sizeof($categorias)>0){ ?>
                            <button class="btn btn-success btn-sm float-lg-right" data-toggle="modal" data-target="#modalNewCluster">
                                Crear Cluster
                            </button>
                            <?php //}?>
                        </div>
                    </div>
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block p-t-25">
                        <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-35">
                            <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Desarrollos en Cluster</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($clusters as $cluster): ?>
                                    <tr>
                                        <td><?= $cluster['Cluster']['nombre'] ?></td>
                                        <td>
                                            <?php
                                                $desarrollo_str = ""; 
                                                foreach($cluster['Desarrollos'] as $desarrollo):
                                                    $desarrollo_str =$desarrollo_str.$desarrollo['nombre'].", ";
                                                endforeach;
                                                echo substr($desarrollo_str,0,-2);
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php
                                                
                                                    echo $this->Html->link('<i class="fa fa-edit"></i>',"javascript:editCluster(".$cluster['Cluster']['id'].")",array('escape'=>false));
                                                
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <?php
                                                
                                                    echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'desarrollos','action' => 'deleteCluster', $cluster['Cluster']['id']), array('escape'=>false, 'confirm'=>__('Desea eliminar este cluster', $cluster['Cluster']['id'])));
                                                
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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

        // Calendario
        '/vendors/moment/js/moment.min',
        '/vendors/datepicker/js/bootstrap-datepicker.min',

        // Chosen select
        // 'pages/form_elements',
        '/vendors/chosen/js/chosen.jquery',
        // 'form',
        
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',


        
    ], array('inline'=>false));
?>

<script>
    
'use strict';

function editCluster(id){
    if (id){
        var dataString = 'id='+ id;
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Desarrollos", "action" => "getClusterDetails")); ?>' ,
            data: dataString,
            cache: false,
            success: function(html) {
                document.getElementById('editId').value = html.id;
                document.getElementById('editNombre').value = html.nombre;
                var desarrollos = html.desarrollos.split(",");
                $('#editDesarrollo').val(desarrollos).trigger('chosen:updated');
                $("#editCluster").modal();
                
            } 
        });
    }
}


$(document).ready(function () {
    
    $("#desarrollo").on('change',function() {
        var desarrollo_id = $(this).val();
        //$("#categoria").find('option').remove();
        $("#categoria").empty();
        if (desarrollo_id) {
            var dataString = 'desarrollo_id='+ desarrollo_id;
            var newOption = $('<option value="1">test</option>');
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "facturas", "action" => "getValidaciones")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    $.each(html, function(key, value) {              
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#categoria"));
                    });
                      
                      $('#categoria').trigger("chosen:updated");
                } 
            });
        }
    });

    $("#folio").on('change',function() {
        var folio = $(this).val();
        if (folio) {
            var dataString = 'folio='+ folio;
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "facturas", "action" => "getFolio")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    if (html.respuesta==1){
                        $("#mensaje_error_div").show();
                        $("#boton_submit").hide();   
                    }else{
                        $("#mensaje_error_div").hide();
                        $("#boton_submit").show();
                    }
                } 
            });
        }
    });

    
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();


    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
    
    
    $('[data-toggle="popover"]').popover()

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[ 3, "desc" ]],
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'Proveedores',
                class : 'excel',
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'Proveedores',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        //tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
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