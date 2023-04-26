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
    textarea{
        overflow:hidden;
        display:block;
        min-height: 30px;
    }
    .text-black{
        color: black;
    }
</style>
<div class="modal fade" id="modal_cliente_delete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Esta seguro que desea ELIMINAR este cliente ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('Cliente', array('url'=>array('controller'=>'Clientes', 'action'=>'delete_master')));
                echo $this->Form->input('id');
                echo $this->Form->hidden('redirect', array('value'=>3));
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

<div class="modal fade" id="modalNewTercero">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
            <div class="row">
                <div class="col-sm-12 col-lg-1" style="margin-top: -.8rem;">
                    <a href="#" data-dismiss="modal"><i class="fa fa-close text-danger"></i></a>
                </div>
                <div class="col-sm-12 col-lg-11">
                    <h4 style="margin-top: .6rem;">Agregar nuevo cliente</h4>
                </div>
            </div>
        </div>
        <div class="modal-body">
            <?= $this->Form->create('Cliente',array('url'=>array('action'=>'add_tercero'),'class'=>'form-horizontal login_validator', 'id'=>'form_add_cliente')); ?>
            <div class="row">
                <?= $this->Form->input(
                    'nombre',
                        array(
                            'required' => false,
                            'div'      => 'col-sm-12 col-lg-6',
                            'class'    => 'form-control',
                            'type'     => 'text',
                            'label'    => 'Nombre*',
                            'required' => true
                        )
                )?>
                <?= $this->Form->input(
                    'correo_electronico',
                        array(
                            'label'    => 'Correo Electrónico*',
                            'div'      => 'col-sm-12 col-lg-6',
                            'class'    => 'form-control ',
                            'type'     => 'text',
                            'required' => true
                        )
                    )
                ?>
            </div>
            <div class="row mt-1">
                <?= $this->Form->input(
                    'rfc', 
                        array(
                            'label' => 'RFC',
                            'div'   => 'col-sm-12 col-lg-6',
                            'class' => 'form-control phone',
                            'type'  => 'text',
                            'style' => 'text-transform: uppercase;',
                        )
                    )
                ?>
                <?= $this->Form->input(
                    'telefono1',
                        array(
                            'label'          => array('text'=>'Teléfono 1*', 'id'=>'ClienteTelefono1Label', 'class'=>'fw-700'),
                            'div'            => 'col-sm-12 col-lg-6',
                            'class'          => 'form-control',
                            'type'           => 'tel'
                        )
                    )
                ?>
            </div>
            <div class="row">
                <?= $this->Form->input('comentarios',
                    array(
                        'label'         => 'Comentarios',
                        'div'           => 'col-md-12 m-t-20',
                        'class'         => 'form-control',
                        'maxlength'     => '150',
                        'type'          => 'textarea',
                        'rows'          => '1',
                        'data-min-rows' => '1'
                    )
                )?>

            </div>
            <?php echo $this->Form->hidden('tercero', array('value'=>1))?>
            <?php echo $this->Form->hidden('status', array('value'=>'Activo'))?>
            <?php echo $this->Form->hidden('etapa_comercial', array('value'=>'CRM'))?>
            <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
            <div class="row mt-2">
                <div class="col-sm-12 col-lg-6">
                    <button type="submit" class="btn btn-success">Registrar cliente</button>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Cancelar</button>
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
                    <i class="fa fa-chevron-circle-right"></i>
                    Listado otros clientes
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
                            <button class="btn btn-success btn-sm float-lg-right" data-toggle="modal" data-target="#modalNewTercero">
                                <i class="fa fa-plus"></i>
                            </button>
                            <!-- <span class="float-lg-right" style="margin-right: .2rem;">Nuevo tercero</span> -->
                        </div>
                    </div>
                </div>
                <div class="card-block m-t-35">
                    <div class="card-block p-t-25">
                        <table class="table table-striped table-hover table-sm" id="sample_1" class="m-t-35">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>correo</th>
                                    <th>Teléfono</th>
                                    <th>Fecha de creación</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lista_terceros as $cliente): ?>
                                    <tr>
                                        <td><?= $this->Html->link($cliente['Cliente']['nombre'], array('action'=>'view_tercero', $cliente['Cliente']['id']), array('style'=>'text-decoration: underline;')) ?></td>
                                        <td><?= $cliente['Cliente']['correo_electronico'] ?></td>
                                        <td><?= $cliente['Cliente']['telefono1'] ?></td>
                                        <td><?= date('Y-m-d', strtotime($cliente['Cliente']['created'])) ?></td>
                                        <td>
                                            <a class="pointer" onclick="myFunction(<?= $cliente['Cliente']['id'] ?>);"><i class="fa fa-trash"></i></a>
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
    $("#modal_cliente_delete").modal('show')
    document.getElementById("ClienteId").value = id;
}

$(document).ready(function () {
    $('textarea').each(function () {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

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
            // order: [[ 4, "desc" ]],
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