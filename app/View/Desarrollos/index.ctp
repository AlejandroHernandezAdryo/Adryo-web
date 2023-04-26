<?= $this->Html->css(
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
            '/vendors/clockpicker/css/jquery-clockpicker',
            'pages/colorpicker_hack',
            'custom'
            //'pages/form_elements'
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-building"></i>
                    Lista de desarrollos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-block p-t-25">

                  <!---Contadores Unidades-->

                  <div class="row encabezado-indicador">
                        <div class="col-sm-12 col-lg-6">
                            Total de Desarrollos: <?= count($desarrollos); ?>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <span id="sum_propiedades_q"></span>
                        </div>
                  </div>


                  <div class="row mt-1 mb-1 box">
                      <div class="col-sm-4 col-lg-3 text-center">
                          No Liberado
                          <div class="number chips bg-status-desarrollo-bloqueado">
                              <span id="no_liberado">
                              </span>
                          </div>
                      </div>
                      <div class="col-sm-4 col-lg-3 text-center">
                          En venta
                          <div class="number chips bg-status-desarrollo-venta">
                              <span id="libre">
                              </span>
                          </div>
                      </div>
                      <div class="col-sm-4 col-lg-3 text-center">
                          Vendido
                          <div class="number chips bg-status-desarrollo-vendido">
                              <span id="vendido">
                              </span>
                          </div>
                      </div>
                  </div>
                  <!---Contadores Unidades-->

                    <div class="pull-sm-right">
                        <div class="tools pull-sm-right"></div>
                    </div>
                    <div style="float:right">
                        <?php if (empty($this->Session->read('Desarrollador'))): ?>
                          <a  href="#" class="btn btn-link btn-xs" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-search fa-1x"></i>Búsqueda Avanzada
                          </a>    
                        <?php endif ?>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                      <thead>
                          <tr>
                              <th width="100%">Desarrollos</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $contbloqueados=0;
                        $contventa=0;
                        $contvendido=0;
                        foreach ($desarrollos as $desarrollo):?>
                          <tr>
                            <td>
                              <div>
                                <div class="col-sm-10" style="background: #2e3c54; color: white; padding-top: 5px; padding-bottom: 5px; margin-bottom: 10px; cursor: pointer;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';">
                                  <?php 
                                    echo $this->Html->link($desarrollo['Desarrollo']['nombre'],array('action'=>'view',$desarrollo['Desarrollo']['id']),array('escape'=>false,'style'=>'color:white'));
                                  ?>
                                </div>

                                <?php if ( $this->Session->read('Permisos.Group.de') == 1 ): ?>
                                    <div class="col-sm-1" style="background: #2e3c54; color: white; padding-top: 5px; padding-bottom: 5px; color:white;">
                                        <?php

                                            switch ($desarrollo['Desarrollo']['visible']):

                                            case(0):
                                                echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR EN VENTA','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));

                                                echo $this->Html->link('<i class="fa fa-dollar"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],2),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR VENDIDO','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));
                                                break;

                                            case(1):

                                                echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],0),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR NO LIBERADO','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));

                                                echo $this->Html->link('<i class="fa fa-dollar"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],2),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR VENDIDO','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));
                                                break;

                                            case(2):

                                                echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],0),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR NO LIBERADO','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));

                                                echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR EN VENTA','escape'=>false,'style'=>'color:white;margin-right:5px; float: right'));

                                                break;
                                            endswitch;


                                        ?>
                                    </div>

                                    <?php elseif( $this->Session->read('Permisos.Group.id') == 5 ): ?>

                                        <div class="col-sm-1" style="background: #2e3c54; color: white; padding-top: 5px; padding-bottom: 5px; color:white;">
                                            <?php
                                                
                                                switch ($desarrollo['Desarrollo']['visible']):
                                                case(0):
                                                    
                                                    echo $this->Html->link('<i class="fa fa-check"></i>', '#', array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR EN VENTA','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    
                                                    echo $this->Html->link('<i class="fa fa-dollar"></i>', '#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR VENDIDO','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    break;

                                                case(1):
                                                    
                                                    echo $this->Html->link('<i class="fa fa-pencil"></i>', '#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR NO LIBERADO','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    
                                                    echo $this->Html->link('<i class="fa fa-dollar"></i>', '#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR VENDIDO','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    break;
                                                case(2):
                                                    
                                                    echo $this->Html->link('<i class="fa fa-pencil"></i>', '#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR NO LIBERADO','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    
                                                    echo $this->Html->link('<i class="fa fa-check"></i>', '#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'MARCAR EN VENTA','escape'=>false,'class' => 'cursor-disable','style'=>'color:white;margin-right:5px; float: right'));
                                                    
                                                    break;
                                                endswitch;


                                            ?>
                                        </div>
                                  
                                    <?php else: ?>

                                        <div class="col-sm-1" style="background: #2e3c54; color: white; padding-top: 5px; padding-bottom: 5px; color:white;">&nbsp;</div>

                                    <?php endif; ?>
                              </div>

                              <div>
                                <?php
                                  if (isset($desarrollo['FotoDesarrollo'][0])) {
                                    $image = $desarrollo['FotoDesarrollo'][0]['ruta'];
                                  }else{
                                    $image = "/img/no_photo_inmuebles.png";
                                  }
                                ?>
                                  
                                  <div class="col-lg-2" style="height:150px;background-image: url('<?= Router::url('/',true).$image; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="location.href='<?php echo Router::url('/',true)."desarrollos/view/".$desarrollo['Desarrollo']['id']; ?>';">
                                  </div>
                                  <div class="col-lg-9">
                                  <div class="col-lg-2">
                                    <b>Tipo de Desarrollo: </b><?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?><br>
                                    <b>Torres: </b><?php echo $desarrollo['Desarrollo']['torres']?><br>
                                    <b>Unidades Totales: </b><?php echo $desarrollo['Desarrollo']['unidades_totales']?><br>
                                    <b>Entrega: </b><?php echo ($desarrollo['Desarrollo']['entrega']=="Inmediata" ? $desarrollo['Desarrollo']['entrega'] : date('d/M/Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?><br>
                                    <b>Colonia: </b><?= $desarrollo['Desarrollo']['colonia']?><br>
                                  </div>
                                      <div class="col-lg-5" style="text-align:center">
                                    <div class="row">
                                        <div class=" col-sm-3 col-md-4">
                                            <p><?= $this->Html->image('m2.png',array('width'=>'40%'))?></p>
                                            <p><?= $desarrollo['Desarrollo']['m2_low']?>m<sup>2</sup> <?= ($desarrollo['Desarrollo']['m2_top']!=""||$desarrollo['Desarrollo']['m2_top']!=0 ? "-".$desarrollo['Desarrollo']['m2_top']."m<sup>2</sup>" : "")?></p>
                                        </div>
                                        <div class="col-sm-3 col-md-4">
                                            <p><?= $this->Html->image('recamaras.png',array('width'=>'40%'))?></p>
                                            <p><?= $desarrollo['Desarrollo']['rec_low']?> <?= ($desarrollo['Desarrollo']['rec_top']!=""||$desarrollo['Desarrollo']['rec_top']!=0 ? "-".$desarrollo['Desarrollo']['rec_top'] : "")?></p>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                    <div class="col-sm-3 col-md-4">
                                        <p><?= $this->Html->image('banios.png',array('width'=>'40%'))?></p>
                                        <p><?= $desarrollo['Desarrollo']['banio_low']?> <?= ($desarrollo['Desarrollo']['banio_top']!=""||$desarrollo['Desarrollo']['banio_top']!=0 ? "-".$desarrollo['Desarrollo']['banio_top'] : "")?></p>
                                    </div>
                                    <div class="col-sm-3 col-md-4">
                                        <p><?= $this->Html->image('autos.png',array('width'=>'40%'))?></p>
                                        <p><?= $desarrollo['Desarrollo']['est_low']?> <?= ($desarrollo['Desarrollo']['est_top']!=""||$desarrollo['Desarrollo']['est_top']!=0 ? "-".$desarrollo['Desarrollo']['est_top'] : "")?></p>
                                    </div>
                                    </div>

                                 </div>
                                  <div class="col-lg-3">
                                    <div class="row">
                                      <style>
                                        .status{
                                          border-radius: 5px;
                                          text-align: center; 
                                          -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                                          -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
                                          box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
                                        }
                                      </style>
                                      <?php
                                          switch ($desarrollo['Desarrollo']['visible']){
                                            case 0: //No liberada
                                                echo "<div class='status' style='background-color: #FFFF00; color:#3D3D3D;'>NO LIBERADO</div>";
                                                $contbloqueados++;
                                                break;

                                            case 1: // Libre
                                                echo "<div class='status' style='background-color: rgb(0, 64 , 128); color:white'>EN VENTA</div>";
                                                $contventa++;
                                                break;

                                            case 2:
                                                echo "<div class='status' style='background-color: RGB(116, 175, 76);  color: white;'>VENDIDO</div>";
                                                $contvendido++;
                                                break;
                                          }

                                      ?>

                                      <style>
                                        .rdsociales{
                                          padding: 5px;
                                        }
                                      </style>
                                      <div style="text-align: right">
                                          <?php if (isset($desarrollo['Comercializador']['nombre_comercial'])){?>
                                          <b>Empresa Comercializadora:<?= $desarrollo['Comercializador']['nombre_comercial']?></b>
                                          <?php }?>
                                            <b>Equipo: <?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $desarrollo['EquipoTrabajo']['nombre_grupo'])?></b><br>
                                            <?php if (sizeof($desarrollo['Clusters'])>0){?>
                                            <b>Clusters:</b><br>
                                                <?php 
                                                    foreach($desarrollo['Clusters'] as $cluster):
                                                        echo $cluster['nombre'].", ";
                                                    endforeach;
                                                ?>
                                            <br>
                                          <?php }?>
                                          <b>Privado: <?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?></b><br>
                                        <!-- 
                                            Enlaces para compartir en Redes Sociales.
                                            Facebook:
                                            http://www.facebook.com/sharer.php?u= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI];
                                        -->
                                        <?php
                                          $shared_desarrollo = Router::url('/Desarrollos/detalle/'.$desarrollo['Desarrollo']['id'],true);
                                        ?>
                                        COMPARTIR<br>
                                        
                                        <div style="float:right">
                                        <!-- 
                                            Enlaces para compartir en Redes Sociales.
                                            Facebook:
                                            http://www.facebook.com/sharer.php?u= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI];
                                        -->
                                        <?php
                                          $shared_desarrollo = Router::url('/Desarrollos/detalle/'.$desarrollo['Desarrollo']['id'],true);
                                        ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-facebook fa-lg"></i>',
                                            'http://www.facebook.com/sharer.php?u='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-twitter fa-lg"></i>',
                                            'https://twitter.com/intent/tweet?text='." Les comparto este increíble desarrollo vía @adryo_ai ".$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                        

                                        <?= $this->Html->link(
                                            '<i class="fa fa-linkedin fa-lg"></i>',
                                            'https://www.linkedin.com/shareArticle?url='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                    </div>

                                        <br><br>
                                        DISPONIBLIDAD TOTAL: <?= sizeof($desarrollo['Disponibles'])?>/<?= sizeof($desarrollo['Propiedades'])?>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                            </td>
                          </tr>
                        <?php endforeach;?>    
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                                    <i class="fa fa-search"></i> 
                                    Búsqueda Avanzada de Desarrollos
                                </h4>
                        </div>
                        <?= $this->Form->create('Desarrollo',array('url'=>array('action'=>'index')))?>
                            <div class="modal-body">
                                <div class="input-group">
                                    <div class="col-xl-3 text-xl-left m-t-15">
                                        <label for="nombre_cliente" class="form-control-label">Nombre</label>
                                    </div>
                                    <?= $this->Form->input('nombre',array('class'=>'form-control','placeholder'=>'Nombre Cliente','div'=>'col-md-9 m-t-15','label'=>false,))?>
                                    <div class="col-xl-3 text-xl-left m-t-15">
                                        <label for="correo_electronico" class="form-control-label">Tipo de Desarrollo</label>
                                    </div>
                                    <?php ?>
                                    <?= $this->Form->input('tipo_desarrollo',array('type'=>'select','empty'=>'Todos los tipos','class'=>'form-control','div'=>'col-md-9 m-t-15','label'=>false, 'options'=>array('Horizontal'=>'Horizontal','Vertical'=>'Vertical')))?>
                                    
                                    <!-- /btn-group -->
                                </div>
                                <!-- /input-group -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                                    Cerrar
                                    <i class="fa fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                                    <i class="fa fa-search"></i>
                                    Realizar Búsqueda
                                </button>
                            </div>
                        <?= $this->Form->end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script([

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

document.getElementById("no_liberado").innerHTML  = <?= $contbloqueados ?>;
document.getElementById("libre").innerHTML        = <?= $contventa ?>;
document.getElementById("vendido").innerHTML      = <?= $contvendido ?>;

</script>