<?= $this->Html->css(
    array(
        
        '/vendors/fullcalendar/css/fullcalendar.min',
        'pages/calendar_custom',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        
        '/vendors/chosen/css/chosen',
        
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        '/vendors/datatables/css/colReorder.bootstrap.min',
        
        'pages/form_elements',
        
        'pages/form_layouts',

        // Input para los archivos.
        '/vendors/fileinput/css/fileinput.min',
    ),
    array('inline'=>false))
    ?>
<style>
    /*.card-block > .row > .col-sm-12{
        margin-top: 5rem;
    }*/
    .file-caption{
        height: 29px !important;
    }
</style>
<!-- Modal para eliminar proveedor -->
<div class="modal fade" id="modal_delete_cotacto">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center" style="color: black;">
                        ¿ Esta seguro que desea ELIMINAR este proveedor ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('ContactoDelete', array('url'=>array('controller'=>'Contactos', 'action'=>'delete')));
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('proveedor_id', array('value'=>$proveedor['Proveedor']['id']));
                echo $this->Form->hidden('redirect', array('value'=>0));
            ?>
            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal_delete_doc">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center" style="color: black;">
                        ¿ Estas seguro de eliminar este documento ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('DocDelete', array('url'=>array('controller'=>'DocsProveedors', 'action'=>'delete')));
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('proveedor_id', array('value'=>$proveedor['Proveedor']['id']));
                echo $this->Form->hidden('redirect', array('value'=>0));
            ?>
            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="button" class="btn btn-primary float-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="contactos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog" style="max-width:900px !important">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-user"></i>
                    Crear Contacto
                </h4>
            </div>
            <?= $this->Form->create('Contacto',array('url'=>array('action'=>'add','controller'=>'Contactos'),'class'=>'form-horizontal'))?>
            <div class="modal-body">
                <div class="form-group row">
                    <?= $this->Form->input('nombre',array('label'=>'Nombre de Contacto','class'=>'form-control','placeholder'=>'Nombre Completo','div'=>'col-md-6'))?>
                	<?= $this->Form->input('puesto',array('label'=>'Puesto','class'=>'form-control','placeholder'=>'Puesto','div'=>'col-md-6'))?>
                	<?= $this->Form->input('telefono_1',array('label'=>'Teléfono 1','class'=>'form-control','div'=>'col-md-6'))?>
                	<?= $this->Form->input('telefono_2',array('label'=>'Teléfono 2','class'=>'form-control','div'=>'col-md-6'))?>
                	<?= $this->Form->input('email',array('label'=>'Correo Electrónico','class'=>'form-control','placeholder'=>'Correo Electrónico','div'=>'col-md-6'))?>
                	<?= $this->Form->input('cumpleanos',array('label'=>'Cumpleaños','class'=>'form-control fecha','type'=>'text','div'=>'col-md-6', 'placeholder'=>'dd-mm-YYYY'))?>
                	<?= $this->Form->hidden('proveedor_id',array('value'=>$proveedor['Proveedor']['id']))?>
                    <?= $this->Form->hidden('url',array('value'=>3))?>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Crear Contacto
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<div class="modal fade" id="add_doc" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-docs"></i>
                    Subir documentos para el proveedor
                </h4>
            </div>
            <?= $this->Form->create('DocsProveedor',array('url'=>array('action'=>'add','controller'=>'DocsProveedors', $proveedor['Proveedor']['id']),'class'=>'form-horizontal', 'type'=>'file'))?>
            <?= $this->Form->hidden('redirect', array('value'=>0)); ?>
            <div class="modal-body">
                <div class="row">
                    <dv class="col-sm-12">
                        <input id="input-logo" name="data[DocsProveedor][docs][]" type="file" class="file-loading" multiple="multiple" accept=".jpg, .png,.jpeg, .pdf, .doc, .docx, .xlsx, .xls, .csv">
                    </dv>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-plus"></i>
                    Subir documentos
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>


<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h4 class="nav_top_align">
                    <i class="fa fa-edit"></i>
                    Editar Información del Proveedor
                </h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="card mt-1">
                        <div class="card-header bg-blue-is">
                            <i class="fa fa-user"> </i> Información General
                        </div>
                        <div class="card-block">
                            <?= $this->Form->create('Proveedor',array('url'=>array('action'=>'edit'),'class'=>'form-horizontal'))?>
                        	<div class="row mt-2">
                                <?= $this->Form->input('id')?>
                                <?= $this->Form->input('razon_social',array('disabled'=>'disabled','class'=>'form-control','div'=>'col-sm-12 col-md-6','label'=>'Razón Social'))?>
                                <?= $this->Form->input('nombre_comercial',array('class'=>'form-control','div'=>'col-sm-12 col-md-6','label'=>'Nombre Comercial'))?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('direccion',array('class'=>'form-control','div'=>'col-sm-12 col-md-12','label'=>'Dirección'))?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('telefono_1',array('class'=>'form-control','div'=>'col-sm-12 col-md-6','label'=>'Teléfono 1'))?>
                                <?= $this->Form->input('telefono_2',array('class'=>'form-control','div'=>'col-sm-12 col-md-6','label'=>'Teléfono 2'))?>
                            </div>
                            <div class="row mt-1">
                                <?= $this->Form->input('email',array('class'=>'form-control','div'=>'col-sm-12 col-md-6','label'=>'Correo electrónico'))?>
                            </div>
                            <div class="row mt-1">
                                <div class="col-sm-12">
                                    <?php echo $this->Form->button('Modificar Proveedor',array('type'=>'submit','class'=>'btn btn-success btn-block'))?>       
                                </div>
                            </div>
                            <?php echo $this->Form->end()?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4">
                    <div class="card mt-1">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Documentos de proveedor
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <a href="#" class="btn btn-sm btn-primary float-lg-right" data-toggle="modal" data-target="#add_doc"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-block"  style="height: 274px;  overflow-y: scroll;">
                            <div class="row mt-1">
                                <div class="col-sm-12">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Nombre</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proveedor['Documentos'] as $documento): ?>
                                                <tr>
                                                    <td style="width:80%">
                                                        <a target="_BLANCK" href="https://docs.google.com/viewer?url=<?= Router::url($documento['documento'], true)?>"><?= $documento['nombre']?></a>
                                                    </td>
                                                    <td style="width:20%">
                                                        <?= $this->Html->link('<i class="fa fa-download"></i>', $documento['documento'], array('escape'=>false)) ?>
                                                        <a class='pointer' onclick="delete_doc(<?= $documento['id'] ?>)"><i class="fa fa-trash"></i></a>
                                                        
                                                    </td>
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-1">
                        <div class="card-header bg-blue-is">
                            <i class="fa fa-users"> </i> Contactos de Proveedor
                            <div style="float:right">
                                <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#contactos"><i class="fa fa-plus"></i>Agregar Contacto
                                </a>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row" style="margin-top: 5rem;">
                               <div class="col-sm-12">
                                   <table class="table" id="sample_1">
                                        <thead>
                                            <tr>
                                                <th><b>Nombre</b></th>
                                                <th><b>Puesto</b></th>
                                                <th><b>Teléfono 1</b></th>
                                                <th><b>Teléfono 2</b></th>
                                                <th><b>Email</b></th>
                                                <th><b>Cumpleaños</b></th>
                                                <th><b>Editar</b></th>
                                                <th><b>Eliminar</b></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proveedor['Contactos'] as $contacto):?>
                                                <tr>
                                                    <td><?= $contacto['nombre']?></td>
                                                    <td><?=$contacto['puesto']?></td>
                                                    <td><?= $contacto['telefono_1']?></td>
                                                    <td><?= $contacto['telefono_2']?></td>
                                                    <td><?= $contacto['email']?></td>
                                                    <td><?=  ($contacto['cumpleanos'] != '' ? date("d/M/Y",strtotime($contacto['cumpleanos'])) : '') ?></td>
                                                    <td><?php echo $this->Html->link('<i class="fa fa-edit"></i>', array('controller'=>'Contactos','action'=>'edit', $contacto['id']),array('escape'=>false));?></td>
                                                    <td>
                                                        <a class='pointer' onclick="myFunction(<?= $contacto['id'] ?>);">
                                                            <i class="fa fa-trash fa-x2"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                        </tbody>
                                    </table>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mt-2">
                        <div class="card-header bg-blue-is">
                            <h4>Facturas relacionadas</h4>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped table-hover table-sm m-t-35 dataTableClass">
                                        <thead>
                                        <tr>
                                            <th>Folio</th>
                                            <th>Referencia</th>
                                            <th>Fecha de emision</th>
                                            <th>Fecha de pago</th>
                                            <th>Concepto</th>
                                            <th>Total</th>
                                            <th>Estatus</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proveedor['Facturas'] as $factura): ?>
                                                <tr>
                                                    <td><?= $this->Html->link($factura['folio'], array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['id'], 2), array('style'=>'text-decoration: underline')); ?></td>
                                                    <td><?= $factura['referencia'] ?></td>
                                                    <td><?= $factura['fecha_emision'] ?></td>
                                                    <td><?= $factura['fecha_pago'] ?></td>
                                                    <td>
                                                        <?php
                                                            if (strlen($factura['concepto']) >= 45) {
                                                                echo rtrim(substr($factura['concepto'], 0, 45)).'...';
                                                            }else {
                                                                echo $factura['concepto'];
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-xs-right"><?= '$ '.number_format($factura['total']) ?></td>
                                                    <td><?= $status_factura[$factura['estado']] ?></td>
                                                    
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
                
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',
        
        '/vendors/chosen/js/chosen.jquery',
//        'pages/form_elements',

        // Estilo para los arhivos
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
       
        
        
    ], array('inline'=>false));
?>

<script>
'use strict';
$(document).ready(function () {

    $("#input-logo").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg", "pdf", "doc", "docx", "xlsx", "xls", "csv"],
        showRemove : true,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        
    });

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });

	// Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
    // End of chosen

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
  
    $('[data-toggle="popover"]').popover()
    
    

});


function delete_doc(doc_id){
    $("#modal_delete_doc").modal('show');
    document.getElementById("DocDeleteId").value = doc_id;
}
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            "order": [],
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'ClientList',
                class : 'excel',
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientList',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
    }
    
    var initTable2 = function() {
        var table = $('#sample_2');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            "order": [],
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'ClientList',
                class : 'excel',
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'ClientList',
                },
                
                
            ]
        });
        var tableWrapper = $('#sample_2_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
        tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
        
    }
    
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
            initTable2();
        }
    };
}();
function myFunction(id){
    $("#modal_delete_cotacto").modal('show');
    document.getElementById("ContactoDeleteId").value = id;
}
</script>


