<?= $this->Html->css(
        array(
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/chosen/css/chosen',
            'pages/form_elements',

            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
            
        ),
        array('inline'=>false))
?>
<?php 
    $date_current = date('Y-m-d');
    $date_oportunos = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
    $date_tardios = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
    $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));
?>
<?php if ($this->Session->read('Permisos.Group.id')==1){?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-plus"></i>
                    Asignar Desarrollo a Equipo de Trabajo
                </h4>
            </div>
            <?= $this->Form->create('GruposUsuario',array('url'=>array('action'=>'asignar','controller'=>'GruposUsuarios')))?>
            <div class="modal-body">
                
                <div class="input-group">
                    
                    <div class="col-md-12 m-t-20">
                        <label for="DesarrolloDesarrolloId">Desarrollo a Asignar</label>
                        <select class="form-control chzn-select" name="data[GruposUsuario][desarrollo_id]" id="GruposUsuarioDesarrolloId">
                            
                                <?php foreach ($desarrollos as $desarrollo):?>
                                    <option value="<?= $desarrollo['Desarrollo']['id'] ?>" style="font-style: oblique"><?= $desarrollo['Desarrollo']['nombre']?></option>
                                <?php endforeach; ?>
                            
                        </select>
                    </div>
                    
                    
                    
                    <div class="checkbox radio_Checkbox_size4 col-lg-12 m-t-20">
                        <label>
                            <?= $this->Form->input('is_private', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            Marcar como Desarrollo Privado (Sólo lo podrá este equipo y sus miembros)
                        </label>
                    </div>
                    <?= $this->Form->hidden('grupo_id',array('value'=>$grupo['GruposUsuario']['id']))?>
                </div>
                <!-- /input-group -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-bullseye"></i>
                    Asignar Desarrollo
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-plus"></i>
                    Reasignar Desarrollo a Otro Equipo de Trabajo
                </h4>
            </div>
            <?= $this->Form->create('GruposUsuario',array('url'=>array('action'=>'reasignar','controller'=>'GruposUsuarios')))?>
            <div class="modal-body">
                <div class="row">
                    <?= $this->Form->input('grupos_usuario_id',array('empty'=>'Equipos de trabajo','class'=>'form-control chzn-select','type'=>'select','div'=>'col-md-12 m-t-15 input-group','options'=>$grupos,'label'=>'Seleccionar nuevo equipo para desarrollo',))?>    
                    <?= $this->Form->hidden('desarrollo_id',array('id'=>'desarrolloid'))?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-bullseye"></i>
                    Reasignar Desarrollo
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<?php }?>

<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-lg-6 col-md-4 col-sm-4">
          <h4 class="nav_top_align">
            <i class="fa fa-users"></i> Equipo: <?= $grupo['GruposUsuario']['nombre_grupo']?>
          </h4>
          <h4><b>Descripción: </b><?= $grupo['GruposUsuario']['descripcion']?></h4>
      </div>
    </div>
  </header>
  <div class="outer">
      <div class="inner bg-light lter bg-container">
      

        <div class="row">
            <div class="col-sm-8 col-lg-8">
                <div class="card mt-2">
                <div class="card-header bg-blue-is">
                    INTEGRANTES DEL EQUIPO                    
                </div>
                <div class="card-block" style="height: 400px;overflow-y: scroll;">
                    <div class="col-sm-12">
                        <div class="widget_section section_border">
                            <div class="user-name bg-primary" style="background-color: #08A5B3 !important">
                                <h3 class="text-center text-white p-t-25">Adminstrador de grupo</h3>
                                <h4 class="text-center text-white"><?= $grupo['Administrador']['nombre_completo']?></h4>
                                <small><?= $grupo['Administrador']['correo_electronico']?></small>
                            </div>
                            <div class="text-xs-center">
                                <?= $this->Html->image($grupo['Administrador']['foto'],array('class'=>'img-fluid avatar_wid','alt'=>'Fotografía Asesor'))?>
                                
                            </div>
                            <?= $this->Html->link('<button class="btn btn-success m-t-15">Ver Detalle</button>',array('controller'=>'users','action'=>'view',$grupo['Administrador']['id']),array('escape'=>false))?>
                        </div>
                    </div>
                    <?php foreach ($users_custom as $user):?>
                    <div class="col-xs-12 col-lg-4 m-t-35">
                        <div class="widget_section section_border">
                            <?php
                                if ($user['status'] == 1) {
                                    $bg_color = "#08A5B3";
                                }else{
                                    $bg_color = "#FF4C26";
                                }
                            ?>
                            <div class="user-name bg-primary" style="background-color: <?= $bg_color; ?> !important">
                                <h4 class="text-center text-white p-t-25"><?= $user['nombre_completo']?></h4>
                                <?= $user['correo_electronico']?>
                                
                            </div>
                            <div class="text-xs-center user-body">
                                <?php
                                    $foto = '';
                                    $extencion = substr($user['foto'], -3);
                                    switch ($extencion) {
                                        case 'jpg':
                                        case 'JPG':
                                        case 'png':
                                        case 'PNG':
                                        case 'peg':
                                        case 'PEG':
                                            $foto = $user['foto'];
                                            break;
                                        default:
                                            $foto = 'user_no_photo.png';
                                            break;
                                    }
                                ?>
                                <?php echo $this->Html->image($foto ,array('class'=>'img-fluid avatar_wid','alt'=>'Fotografía Asesor')); ?>
                            </div>
                            <?= $this->Html->link('<button class="btn btn-success m-t-15">Ver Detalle</button>',array('controller'=>'users','action'=>'view',$user['id']),array('escape'=>false))?>
                            
                            <div style="background-color: #4a4949 !important; padding-top: 15px;" class="mt-1">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <h4 class="text-white"><?= $user['oportunos']?></h4>
                                        <p class="text-white">OP</p>
                                    </div>
                                    <div class="col-xs-3">
                                        <h4 class="text-white"><?= $user['tardios']?></h4>
                                        <p class="text-white">TA</p>
                                    </div>
                                    <div class="col-xs-3">
                                        <h4 class="text-white"><?= $user['no_atendidos']?></h4>
                                        <p class="text-white">NA</p>
                                    </div>
                                    <div class="col-xs-3">
                                        <h4 class="text-white"><?= $user['por_reasignar']?></h4>
                                        <p class="text-white">PR</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 text-white">
                                        Total de clientes
                                        <span><?= $user['oportunos'] + $user['tardios'] + $user['no_atendidos'] + $user['por_reasignar'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-4">
                <div class="card mt-2">
                <div class="card-header bg-blue-is">
                    DESARROLLOS DEL EQUIPO
                    <?php if ($this->Session->read('Permisos.Group.id')==1){?>
                    <div style="float: right">
                            <?= $this->Html->link('<button class="btn btn-success">Asignar Desarrollo</button>',"#",array('data-toggle'=>"modal",'data-target'=>"#myModal",'id'=>"target-modal",'escape'=>false))?>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-block" style="height: 400px;overflow-y: scroll;">
                    <div class="col-sm-12">
                    <?php 
                        foreach($grupo['Desarrollo'] as $desarrollo):
                    ?>
                        <div class="col-lg-6 m-t-15">
                            <div class="m-t-10 col-lg-12">
                                <div style="height:150px;background-image: url('<?= $desarrollo['FotoDesarrollo'][0]['ruta'] ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover;">
                                </div>
                                <div style="height:40px">
                                    <?= $this->Html->link($desarrollo['nombre'],array('controller'=>'desarrollos','action'=>'view',$desarrollo['id']))?>
                                </div>
                            </div>
                            <div class="row">
                            <div class="m-t-10 col-lg-12">
                                <div class="col-xs-6 col-lg-6">
                                    <?php echo $this->Form->postLink('<button class="btn btn-danger">Quitar</button>', array('controller' => 'grupos_usuarios', 'action' => 'desasignar', $desarrollo['id'], $grupo['GruposUsuario']['id']), array('escape' => false,'style'=>'color:red'), __('Desea quitar este desarrollo de este equipo de trabajo?', $desarrollo['id'])); ?>
                                </div>
                                <?php $desarrollo_id = $desarrollo ['id']?>
                                <div class="col-xs-6 col-lg-6">
                                    <?= $this->Html->link('<button class="btn btn-warning">Reasignar</button>',"#",array('onclick'=>"javascript:setId($desarrollo_id)",'data-toggle'=>"modal",'data-target'=>"#myModal2",'id'=>"target-modal",'escape'=>false))?>
                                </div>
                            </div>
                            </div>
                        <script>
                            function setId(id_desarrollo){
                                document.getElementById('desarrolloid').value=id_desarrollo;
                            }
                        </script>
                    </div>
                    <?php
                        endforeach; 
                    ?>
                    </div>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="card mt-2">
                <div class="card-header bg-blue-is">
                    LISTA DE CLIENTES DEL EQUIPO
                </div>
                <div class="card-block">
                    <div class="col-sm-12 m-t-35">
                        <table id="sample_1" class="table table-sm" id="table-cartera-clientes">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Estatus</th>
                                <th>Nombre</th>
                                <th>Inmueble/Desarrollo origen</th>
                                <th>Correo electrónico</th>
                                <th>Ultimo seg</th>
                                <th>Asesor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes_equipo as $cliente):?>

                            <tr>
                                <?php 
                                if ($cliente['temperatura']    == 1){$temp = 'F'; $class_temp = 'bg_frio'; $name_temp = 'Frio';}
                                elseif($cliente['temperatura'] == 2){$temp = 'T'; $class_temp = 'bg_tibio'; $name_temp = 'Tibio';}
                                elseif($cliente['temperatura'] == 3){$temp = 'C'; $class_temp = 'bg_caliente'; $name_temp = 'Caliente';}
                                elseif($cliente['temperatura'] == 4){$temp = 'V'; $class_temp = 'bg_venta'; $name_temp = 'Venta';}
                                else{$temp =''; $class_temp = ''; $name_temp = '';}

                                if ($cliente['last_edit'] <= $date_current.' 23:59:59' && $cliente['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
                                elseif($cliente['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
                                elseif($cliente['last_edit'] < $date_tardios.' 23:59:59' && $cliente['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
                                elseif($cliente['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                                else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}

                                if ($cliente['status'] == 'Activo venta') {$status_cliente = 'Venta';}
                                else{$status_cliente = $cliente['status'];}

                                ?>
                                <td><small><span class="<?= $class_temp ?>"><?= $temp; ?></span><span class="text_hidden"><?= $name_temp; ?></span></small></td>
                                <td><small><span class="<?= $class_at ?>"><?= $at; ?></span><span class="text_hidden"><?= $name_at; ?></span></small></td>
                                <td><?= $status_cliente ?></td>
                                <td>
                                <?= $this->Html->link(rtrim($cliente['nombre']), array('controller' => 'clientes', 'action' => 'view', $cliente['id'])) ?>
                                </td>
                                <td>
                                <?= rtrim($cliente['desarrollo']). rtrim($cliente['inmueble']) ?>
                                </td>
                                <td>
                                <?= rtrim($cliente['correo_electronico']) ?>
                                </td>
                                <td>
                                <?= date('Y-m-d', strtotime($cliente['last_edit'])) ?>
                                </td>
                                <td>
                                <?= $this->Html->link(rtrim($cliente['asesor']), array('controller' => 'users', 'action' => 'view', $cliente['asesor_id'])) ?>
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
</div>

<?php 
    echo $this->Html->script([
       
        //'/vendors/chosen/js/chosen.jquery',
        //'/vendors/bootstrap-switch/js/bootstrap-switch.min',
        //'pages/form_elements',
        
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

<?php

$this->Html->scriptStart(array('inline' => false));

?>

'use strict';
$(document).ready(function () {

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

    

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
                filename: 'ClientList',
                class : 'excel',
                charset: 'utf-8',
                bom: true
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

<?php $this->Html->scriptEnd();

?>