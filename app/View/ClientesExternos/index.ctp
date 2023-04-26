<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
                      
        ),
        array('inline'=>false))
?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar nuevo Cliente
              </h4>
          </div>
          <?= $this->Form->create('ClientesExterno',array('url'=>array('action'=>'add')))?>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Razon social') ?>
                </div>
                <?= $this->Form->input('razon_social', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Nombre comercial*') ?>
                </div>
                <?= $this->Form->input('nombre_comercial', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'required'=>true)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('RFC') ?>
                </div>
                <?= $this->Form->input('rfc', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'style'=>'text-transform: uppercase;')) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Dirección') ?>
                </div>
                <?= $this->Form->input('direccion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Teléfono 1') ?>
                </div>
                <?= $this->Form->input('telefono_1', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Teléfono 2') ?>
                </div>
                <?= $this->Form->input('telefono_2', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Email') ?>
                </div>
                <?= $this->Form->input('email', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="submit" class="btn btn-success pull-left">
                    <i class="fa fa-plus"></i>
                    Agregar
              </button>
          </div>
          <?= $this->Form->end()?>
      </div>
  </div>
</div>

<!-- Modal para eliminar proveedor -->
<div class="modal fade" id="modal_provedor_delete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center" style="color: black;">
                        ¿ Esta seguro que desea ELIMINAR este cliente ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('ClientesExterno', array('url'=>array('controller'=>'ClientesExterno', 'action'=>'delete')));
                echo $this->Form->hidden('id');
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

<div id="content" class="bg-container">
    <header class="head mt-2">
        <div class="main-bar row">
            <div class="col-sm-12 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-user"></i>
                    Otros Clientes
                </h4>
            </div>
            <div class="col-sm-12 col-lg-6">
                <button class="btn btn-success float-right btn-labeled" data-toggle="modal" data-target="#myModal">
                    Agregar nuevo cliente
                </button>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
                        <div class="card-block m-t-35">
                            <div class="card-block p-t-25">
                                <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                    <thead>
                                    <tr>
                                        <th>Razón Social</th>
                                        <th>Nombre comercial</th>
                                        <th>RFC</th>
                                        <th>Dirección</th>
                                        <th>Telefono 1</th>
                                        <th>Telefono 2</th>
                                        <th>Email</th>
                                        <th>Eliminar</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($clientes as $cliente):?>

                                    <tr>
                                        <td ><?= $this->Html->link($cliente['ClientesExterno']['razon_social'],array('action'=>'edit', $cliente['ClientesExterno']['id']))?></td>
                                        <td ><?= $this->Html->link($cliente['ClientesExterno']['nombre_comercial'], array('action'=>'edit', $cliente['ClientesExterno']['id']))?></td>
                                        <td style="text-transform:uppercase"><?= substr($cliente['ClientesExterno']['rfc'],2)?></td>
                                        <td ><?= $cliente['ClientesExterno']['direccion']?></td>
                                        <td ><?= $cliente['ClientesExterno']['telefono_1']?></td>
                                        <td ><?= $cliente['ClientesExterno']['telefono_2']?></td>
                                        <td ><?= $cliente['ClientesExterno']['email']?></td>
                                        <td>
                                            <a class='pointer' onclick="myFunction(<?= $cliente['ClientesExterno']['id'] ?>);">
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
        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function myFunction(id){
    $("#modal_provedor_delete").modal('show')
    document.getElementById("ProveedorDeleteId").value = id;
}
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