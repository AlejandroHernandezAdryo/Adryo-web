<?= $this->Html->css('/vendors/select2/css/select2.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/scroller.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/dataTables.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('pages/dataTables.bootstrap',array('inline'=>false)) ?>
<?= $this->Html->css('pages/tables',array('inline'=>false)) ?>

<?= $this->Element('Users/add') ?>
<?= $this->Element('Users/edit') ?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Lista de Usuarios
                        </h4>
                    </div>
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                        <div class="card-header bg-white">
                            <i class="fa fa-home"> </i> Usuarios Registrados
                            <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>
                                <a  href="#" class="btn btn-primary  float-xs-right" data-toggle="modal" data-target="#modal_add_user"><i class="fa fa-user"></i>
                                    Agregar usuario
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-block">
                            <div style="margin-top: 55px;">
                                <table id="sample_1" class="table display" >
                                    <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Grupo</th>
                                        <th style="display:none">Finanzas</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <?php if ($this->Session->read('Permisos.Group.ue')==1): ?>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                <?php echo "Editar" ?>
                                            </th>
                                        <?php endif; ?>
                                        <?php if ($this->Session->read('Permisos.Group.ud')==1): ?>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">
                                                <?php echo "Deshabilitar/Habilitar" ?>
                                            </th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php foreach ($users as $user):?>
                                    <tr>
                                        <td>
                                            <?php if ($user['User']['status'] == 1): ?>
                                                <span class="chip bg-success">
                                                    <small>
                                                        Activo
                                                    </small>
                                                </span>
                                            <?php else: ?>
                                                <span class="chip bg-danger">
                                                    <small>
                                                        Inactivo
                                                    </small>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= $user['Grupo']['nombre'] ?>
                                        </td>
                                        <td style="display: none">
                                            <?= $boleano[$user['CuentasUser']['finanzas']] ?>
                                        </td>
                                    <td>
                                        <ins>
                                            <?php echo $this->Html->link($user['User']['nombre_completo'], array('action'=>'view', $user['User']['id']), array('escape'=>False, 'style'=>'text-transform: uppercase;')) ?>
                                        </ins>
                                    </td>
                                    <td><?php echo strtoupper($user['User']['correo_electronico'])?></td>
                                    <td><?php echo strtoupper($user['User']['telefono1'])?></td>
                                    <?php if ($this->Session->read('Permisos.Group.ue') == 1){?>
                                        <td style="text-align: center;">

                                            <?=
                                                $this->Html->link('<i class="fa fa-edit fa-lg"></i>','#',array('escape'=>false, 'class'=>'float-lg-right', 'onclick' => 'edit_user_modal('.$user['User']['id'].')'));
                                            ?>

                                        </td>
                                    <?php }?>
                                    <?php if ($this->Session->read('Permisos.Group.ud') == 1 ){?>  
                                          
                                    <td style="text-align: center;">
                                    
                                    <?php
                                        if( $user['User']['status'] == 1 ){
                                            echo "<b>".$this->Form->postLink('<i class="fa fa-close"></i>', array('action' => 'disabled', $user['User']['id']), array('escape'=>false), __('¿Desea deshabilitar este usuario?', $user['User']['id']))."</b>";
                                        }else{
                                            echo "<b>".$this->Form->postLink('<i class="fa fa-check"></i>', array('action' => 'enable', $user['User']['id']), array('escape'=>false), __('¿Desea habilitar este usuario?', $user['User']['id']))."</b>";
                                        }

                                        ?>
                                    </td>
                                    <?php }?>
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

// Tabla
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('#sample_1');
        table.DataTable({
            dom: 'Bflr<"table-responsive"t>ip',
            buttons: [
                {
                extend: 'csv',
                text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                filename: 'UserstList',
                class : 'excel',
                charset: 'utf-8',
                bom: true
                },
                {
                extend: 'print',
                text: '<i class="fa  fa-print"></i> Imprimir',
                filename: 'UsersList',
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