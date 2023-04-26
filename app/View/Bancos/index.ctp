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
    display: block;
    height: 30px;
}
</style>
<div class="modal fade" id="newCtaBanco" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-user-plus"></i>
                  Agregar nueva cuenta bancaria
              </h4>
          </div>
          <?= $this->Form->create('Banco',array('url'=>array('action'=>'add')))?>
          <?= $this->Form->hidden('redirect', array('value'=>1)) ?>
          <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.Cuenta.id'))) ?>
          <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Nombre de la cuenta*') ?>
                </div>
                <?= $this->Form->input('nombre_cuenta', array('maxlength'=>30,'class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Tipo de la cuenta*') ?>
                </div>
                <?= $this->Form->input('tipo', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'type'=>'select', 'options'=>$tipo_cuenta, 'empty'=>'Seleccione un tipo de cuenta', 'required'=>true)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Nombre del Banco*') ?>
                </div>
                <?= $this->Form->input('nombre_banco', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false, 'style'=>'text-transform: uppercase;')) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Numero de cuenta*') ?>
                </div>
                <?= $this->Form->input('numero_cuenta', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Clabe') ?>
                </div>
                <?= $this->Form->input('clabe', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'maxlength'=>30,)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Titular') ?>
                </div>
                <?= $this->Form->input('titular', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Direccion') ?>
                </div>
                <?= $this->Form->input('direccion', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'maxlength'=>300, 'type'=>'text')) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('saldo inicial*') ?>
                </div>
                <?= $this->Form->input('saldo_inicial', array('class'=>'form-control', 'div'=>'col-sm-12 col-lg-8', 'required'=>true, 'label'=>false)) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Estatus') ?>
                </div>
                <?= $this->Form->input('status', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'type'=>'select', 'options'=>$status, 'empty'=>'Seleccione una opción')) ?>
            </div>
            <div class="row mt-1">
                <div class="col-sm-12 col-lg-4">
                    <?= $this->Form->label('Desarrollo relacionado') ?>
                </div>
                <?= $this->Form->input('desarrollo_id', array('class'=>'form-control chzn-select', 'div'=>'col-sm-12 col-lg-8', 'label'=>false, 'type'=>'select', 'options'=>$desarrollos, 'empty'=>'Seleccione una opción', 'multiple'=>true)) ?>
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
<div class="modal fade" id="modal_cuenta_delete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center" style="color: black;">
                        ¿ Esta seguro que desea dar de BAJA esta cuenta bancaria ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('CuentaDelete', array('url'=>array('controller'=>'Bancos', 'action'=>'status_update')));
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('status', array('value'=>'3'));
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
                    <i class="fa fa-users"></i>
                    Cuentas bancarias
                </h4>
            </div>
            <div class="col-sm-12 col-lg-6">
                <button class="btn btn-success float-right btn-labeled" data-toggle="modal" data-target="#newCtaBanco">
                    Agregar nueva cuenta bancaria.
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
                                <th>Nombre cuenta</th>
                                <th>Titular</th>
                                <th>Tipo</th>
                                <th>Banco</th>
                                <th>N° Cuenta</th>
                                <th>Clabe</th>
                                <th>Desarrollo</th>
                                <th>Saldo</th>
                                <th>Transacciones</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bancos as $banco): ?>
                                    <?php
                                        $depositos_ini = (isset($depositos[$banco['Banco']['id']])?$depositos[$banco['Banco']['id']]:0);
                                        $retiros_ini = isset($retiros[$banco['Banco']['id']])? $retiros[$banco['Banco']['id']]: 0;
                                    ?>
                                    <tr>
                                        <td><?= $this->Html->link($banco['Banco']['nombre_cuenta'], array('controller'=>'bancos', 'action'=>'view', $banco['Banco']['id'])) ?></td>
                                        <td><?= $banco['Banco']['titular'] ?></td>
                                        <td><?= $tipo_cuenta[$banco['Banco']['tipo']] ?></td>
                                        <td><?= $banco['Banco']['nombre_banco'] ?></td>
                                        <td><?= $banco['Banco']['numero_cuenta'] ?></td>
                                        <td><?= $banco['Banco']['clabe'] ?></td>
                                        <td>
                                            <?php foreach($banco['Desarrollo'] as $desarrollo): ?>
                                                <span style="display: inline-block; width: 100%"><?= $desarrollo['nombre']; ?></span>
                                            <?php endforeach ?>
                                        </td>
                                        
                                        <td><?= number_format($banco['Banco']['saldo_inicial']+$depositos_ini-$retiros_ini,2) ?></td>
                                        <td style="text-align:center"><?= $this->Html->link('<i class="fa fa-bars"></i>',array('controller'=>'transaccions','action'=>'transferencia',$banco['Banco']['id']),array('escape'=>false))?></td>
                                        
                                        <td style="text-align:center">
                                            <?php 
                                                if (isset($depositos[$banco['Banco']['id']]) || isset($retiros[$banco['Banco']['id']])){
                                                    echo "";
                                                }else{
                                                    ?>
                                                    <a class='pointer' onclick="myFunction(<?= $banco['Banco']['id'] ?>);"><i class="fa fa-trash fa-x2"></i></a>
                                                    <?php
                                                }
?>                                      </td>
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

        // Chosen select
        // 'pages/form_elements',
        '/vendors/chosen/js/chosen.jquery',
        // 'form',


        
    ], array('inline'=>false));
?>

<script>
    
'use strict';
function myFunction(id){
    $("#modal_cuenta_delete").modal('show')
    document.getElementById("CuentaDeleteId").value = id;
}
$(document).ready(function () {

    $(".number").on({
          "focus": function(event) {
            $(event.target).select();
          },
          "keyup": function(event) {
            $(event.target).val(function(index, value) {
              return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{0})$/, '$1')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
          }
    });

    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();


    
    
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