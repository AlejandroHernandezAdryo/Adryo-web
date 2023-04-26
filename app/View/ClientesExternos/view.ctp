<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
            
            // Input para los archivos.
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
                      
        ),
        array('inline'=>false))
?>
<style>
    .text-black{
        color: black;
    }
    .file-caption{
        height: 29px !important;
    }
    .text-lg-right{
        text-align: right;
    }
</style>
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
                echo $this->Form->create('DocDelete', array('url'=>array('controller'=>'docsproveedors', 'action'=>'delete')));
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('proveedor_id', array('value'=>$proveedor['Proveedor']['id']));
                echo $this->Form->hidden('redirect', array('value'=>1));
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
            <?= $this->Form->create('DocsProveedor',array('url'=>array('action'=>'add','controller'=>'docsproveedors', $proveedor['Proveedor']['id']),'class'=>'form-horizontal', 'type'=>'file'))?>
            <?= $this->Form->hidden('redirect', array('value'=>1)); ?>
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
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-user"></i>
                    <?= $this->Html->link('Proveedor', array('action'=>'index'), array('class'=>'text-white')).' - '.$proveedor['Proveedor']['nombre_comercial'] ?>
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="row">
                <div class="col-sm-12 col-lg-8">
                    <div class="card mt-1">
                        <div class="card-header bg-blue-is">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <h4>Información general del proveedor</h4>
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    <h4 class="float-lg-right">
                                        <?= $this->Html->link('Editar', array('action'=>'edit', $proveedor['Proveedor']['id']), array('class'=>'text-white')) ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-block" style="height: 274px;">
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <table class="table table-sm mt-2">
                                        <tbody>
                                            <tr>
                                                <td>Razón social</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['razon_social'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Nombre comercial</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['nombre_comercial'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>RFC</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['rfc'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Dirección</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['direccion'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Teléfono</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['telefono_1'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Correo electrónico</td>
                                                <td class="text-lg-rigth"><?= $proveedor['Proveedor']['email'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                                                <th>Ver</th>
                                                <th>Descargar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proveedor['Documentos'] as $documento): ?>
                                                <tr>
                                                    <td>
                                                        <a target="_BLANCK" href="https://docs.google.com/viewer?url=<?= Router::url($documento['documento'], true)?>"><i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>
                                                        <?= $this->Html->link('<i class="fa fa-download"></i>', $documento['documento'], array('escape'=>false)) ?>
                                                    </td>
                                                    <td>
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
            <!-- ./row información general del proveedor -->

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
                                            <th>Emitir pago</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($proveedor['Facturas'] as $factura): ?>
                                                <tr>
                                                    <td><?= $factura['folio'] ?></td>
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
                                                    <td class="text-sm-center">
                                                        <?php if ($factura['estado'] == 0){
                                                            echo $this->Html->link('<i class="fa fa-money fa-lg"></i>', array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['id']), array('escape'=>false));
                                                        }?>
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

        // Estilo para los arhivos
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function delete_doc(doc_id){
    $("#modal_delete_doc").modal('show');
    document.getElementById("DocDeleteId").value = doc_id;
}
$(document).ready(function () {
    $('[data-toggle="popover"]').popover();

    $("#input-logo").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg", "pdf", "doc", "docx", "xlsx", "xls", "csv"],
        showRemove : true,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        
    });

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

});
    
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('.dataTableClass');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
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