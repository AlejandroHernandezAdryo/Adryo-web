<?php 
  echo $this->Html->css(
    array(
      // Tablas
      'pages/tables',

      // Calendario
      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
      '/vendors/jquery-tagsinput/css/jquery.tagsinput',
      '/vendors/daterangepicker/css/daterangepicker',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      '/vendors/bootstrap-switch/css/bootstrap-switch.min',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/datetimepicker/css/DateTimePicker.min',
      '/vendors/j_timepicker/css/jquery.timepicker',
      // '/vendors/clockpicker/css/jquery-clockpicker',
      'pages/colorpicker_hack',
      // 'pages/general_components',

      // Datatables
      '/vendors/select2/css/select2.min',
      '/vendors/datatables/css/scroller.bootstrap.min',
      '/vendors/datatables/css/colReorder.bootstrap.min',
      '/vendors/datatables/css/dataTables.bootstrap.min',
      'pages/dataTables.bootstrap',

    ),
    array('inline'=>false)); 
?>
<style>
  .img-circle{
    border-radius: 30px;
  }
  .c-pointer{cursor: pointer;}
  .card{
    border-radius: 3px !important;
  }
  .success_bg_dark {
    background: #009973;
  }
  .hidden{
    display: none;
    transition:All 0.5s linear;
    -webkit-transition:All 0.5s linear;
    -moz-transition:All 0.5s linear;
    -o-transition:All 0.5s linear;
  }
  .show{
    display: table-row;
    transition:All 0.5s linear;
    -webkit-transition:All 0.5s linear;
    -moz-transition:All 0.5s linear;
    -o-transition:All 0.5s linear;
  }
  tr:hover{
    background: #E9E9E9;
    transition:All 0.5s linear;
    -webkit-transition:All 0.5s linear;
    -moz-transition:All 0.5s linear;
    -o-transition:All 0.5s linear;
  }
</style>

<!-- Modales de información -->
<div class="modal fade" id="modal_clientes">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <div class="swal2-icon swal2-error animate-error-icon" style="display: block;"><span class="x-mark animate-x-mark"><span class="line left"></span><span class="line right"></span></span></div>
                </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div id="mensaje_clientes">
                  
                </div>
              </div>
            </div>
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>



<div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1" style="color:black">
                    <i class="fa fa-search"></i>
                    Crear mensaje general
                </h4>
            </div>
            <?= $this->Form->create('Mensaje',array('url'=>array('action'=>'add','controller'=>'mensajes')))?>
            <div class="modal-body">
                <div class="input-group">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="mensaje" class="form-control-label">Mensaje</label>
                    </div>
                    <?= $this->Form->input('mensaje',array('type'=>'textarea','class'=>'form-control','placeholder'=>'Mensaje','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    
                    <div class="col-lg-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Vigencia del mensaje</label>
                    </div>
                    <?= $this->Form->input('ff',array('class'=>'form-control calendario','placeholder'=>'dd-mm-yyyy','div'=>'col-md-9 m-t-15','label'=>false,))?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-search"></i>
                    Crear Mensaje
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-sm-12 col-lg-8">
        <h3 class="nav_top_align text-white">
          <i class="fa fa-dashboard"></i> Tablero
        </h3>
        <p class="text-white">
          Bienvenido(a) a Inmosystem <?= $this->Session->read('Auth.User.nombre_completo')?>
        </p>
      </div>
      <!-- <div class="col-sm-12 col-lg-4">
        <?php
          echo $this->Form->create('users');
            echo $this->Form->input('rango_fechas', array('class'=>'form-control', 'div'=>False, 'label'=>array('class'=>'text-white'), 'id'=>'date_range', 'placeholder'=>'dd/mm/YYYY - dd/mm/YYYY'));
          echo $this->Form->end();
        ?>
      </div> -->
    </div>
  </header>
  <div class="outer">
    <div class="inner lter bg-container">
      <div class="row mt-2" id="informacion-user">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-block">
              <div class="row">
                <div class="col-sm-12">
                  <pre>
                    <?php
                      // print_r($data_clientes_temp);
                      // echo "<br>";
                      // print_r($this->Session->read('Desarrollador'));
                    ?>
                  </pre>
                </div>
              </div>
              <div class="row m-t-30"> 
                <div class="col-sm-12 col-lg-6">
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr style="background: #034575;">
                          <th colspan="2" class="text-center text-white" style="font-size: 1.2rem !important; font-weight: 500 !important;">Indicadores de desempeño <?= $meses_esp[date('m')]; ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Última sesión</td>
                          <td class="text-float-right"><?= date('d', strtotime($this->Session->read('Auth.User.last_login'))).'-'.$meses_esp[date('m', strtotime($this->Session->read('Auth.User.last_login')))].'-'.date('Y', strtotime($this->Session->read('Auth.User.last_login')));?></td>
                        </tr>
                        <tr>
                          <td>Meta de venta <?= $meses_esp[date('m')]; ?></td>
                          <td class="text-float-right">$ <?= number_format($meta_mes); ?></td>
                        </tr>
                        <tr>
                          <td onclick="tot_clientes();" class="pointer">
                            <input type="checkbox" class="hidden" id="check-master-tot-clientes" checked>
                            <i class="fa fa-plus pointer" id="icon-master-tot-clientes"></i> 
                            Total de clientes <?= $meses_esp[date('m')] ?>
                          </td>
                          <td class="text-float-right"><?php $total = $data_clientes_status_mes['activos'] + $data_clientes_status_mes['ventas'] + $data_clientes_status_mes['inactivos_temp'] + $data_clientes_status_mes['inactivos_def']; echo $total; ?></td>
                        </tr>
                        <tr class="tr-display-plus hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins class="pointer" onclick="info_clientes(1);">activos<i class="fa fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status_mes['activos'] ?>
                          </td>
                        </tr>
                        <tr class="tr-display-plus hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins  class="pointer" onclick="info_clientes(2);">inactivos temporales <i class="fa fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status_mes['inactivos_temp'] ?>
                          </td>
                        </tr>
                        <!-- <tr class="tr-display-plus hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins>activos venta</ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status_mes['ventas'] ?>
                          </td>
                        </tr> -->
                        <tr class="tr-display-plus hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins class="pointer" onclick="info_clientes(3);">inactivos definitivos <i class="fa fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status_mes['inactivos_def'] ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Unidades vendidas <?= $meses_esp[date('m')] ?></td>
                          <td class="text-float-right"><?= $unidades_venta_actual; ?></td>
                        </tr>
                        <tr>
                          <td>Total de ventas <?= $meses_esp[date('m')] ?></td>
                          <td class="text-float-right">$ <?= number_format($monto_venta_actual); ?></td>
                        </tr>
                        <tr>
                          <td>Promedio $ por unidad <?= $meses_esp[date('m')] ?></td>
                          <td class="text-float-right">$ <?= number_format($promedio_costo_unidad_mes); ?></td>
                        </tr>
                        <tr>
                          <td>% de cumplimiento meta <?= $meses_esp[date('m')] ?></td>
                          <td class="text-float-right"><?= round(number_format($cumplimiento_mes), 2); ?>%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr style="background: #043559;">
                          <th colspan="2" class="text-center text-white" style="font-size: 1.2rem !important; font-weight: 500 !important;">Indicadores acumulados <?= date('Y'); ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td colspan="2" style="height: 28px;"></td>
                        </tr>
                        <tr>
                          <td>Meta de venta <?= date('Y'); ?></td>
                          <td class="text-float-right">$ <?= number_format($meta_anio); ?></td>
                        </tr>
                        <tr>
                          <td onclick="tot_clientes_anio();" class="pointer">
                            <input type="checkbox" class="hidden" id="check-master-tot-clientes-anio" checked>
                            <i class="fa fa-plus pointer" id="icon-master-tot-clientes-anio"></i> 
                            Total de clientes <?= date('Y') ?>
                          </td>
                          <td class="text-float-right"><?= $data_clientes_status['activos'] + $data_clientes_status['inactivos_temp'] + $data_clientes_status['ventas'] + $data_clientes_status['inactivos_def']; ?></td>
                        </tr>
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins class="pointer" onclick="info_clientes(1);">activos <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status['activos'] ?>
                          </td>
                        </tr>
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins class="pointer" onclick="info_clientes(2);">inactivos temporales <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status['inactivos_temp'] ?>
                          </td>
                        </tr>
                        <!-- <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins>activos venta</ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status['ventas'] ?>
                          </td>
                        </tr> -->
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes <ins class="pointer" onclick="info_clientes(3);">inactivos definitivos <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $data_clientes_status['inactivos_def'] ?>
                          </td>
                        </tr>
                        <tr>
                          <td>Unidades vendidas <?= date('Y') ?></td>
                          <td class="text-float-right"><?= $unidades_venta_anual; ?></td>
                        </tr>
                        <tr>
                          <td>Total de ventas <?= date('Y') ?></td>
                          <td class="text-float-right">$ <?= number_format($monto_venta_anual); ?></td>
                        </tr>
                        <tr>
                          <td>Promedio $ por unidad <?= date('Y') ?></td>
                          <td class="text-float-right">$ <?= number_format($promedio_costo_unidad_anual); ?></td>
                        </tr>
                        <tr>
                          <td>% de cumplimiento meta <?= date('Y') ?></td>
                          <td class="text-float-right"><?= round(($cumplimiento_anual), 1); ?>%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- Primer fila ./End row #informacion-user-->
      <div class="row" id="StatusYTemp">
          <div class="col-sm-12 col-lg-7">
            <div class="card mt-2">
              <div class="card-header bg-white">
                ESTATUS GENERAL DE MIS CLIENTES
              </div>
              <div class="card-block">
                <div id="grafica_estatus_general_clientes" style="width: 100%; height: 300px;"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-5">
            <div class="card mt-2">
              <div class="card-header bg-white">
                <div class="row">
                  <div class="col-sm-12 col-lg-8">
                    <i class="fa  fa-bar-chart-o"></i> TEMPERATURA DE CLIENTES
                  </div>
                  <div class="col-sm-12 col-lg-4 text-xs-right">
                    Total: <?php $sum_temp = $data_clientes_temp['frios'] + $data_clientes_temp['tibios'] + $data_clientes_temp['calientes'] + $data_clientes_temp['ventas']; echo $sum_temp; ?>
                  </div>
                </div>
              </div>
              <div class="card-block">
                <?php if ($sum_temp == 0): ?>
                  <div class="col-sm-12"> <span style="height: 300px; font-size: 1.2rem; color: #C6C6C6;" class="flex-center">Aun no hay clientes.</span></div>
                <?php else: ?>
                  <div id="grafica_clientes" style="width: 100%; min-height: 300px;"></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div> <!-- Segunda fila ./End row #StatusYTemp -->

        <div class="row" id="clientesAtencion">
          <div class="col-sm-12">
            <div class="card mt-1">
              <div class="card-header bg-white">
                <div class="row">
                  <div class="col-sm-12 col-lg-8">
                    <i class="fa fa-calendar"></i> ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
                  </div>
                  <div class="col-sm-12 col-lg-4 text-xs-right">
                    Total: <?= $data_clientes_atencion['oportunos'] + $data_clientes_atencion['tardios'] + $data_clientes_atencion['no_atendidos'] + $data_clientes_atencion['por_reasignar']/* + $data_clientes_atencion['inactivos_temp']*/ ?>
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="grafica_atencion_clientes" style="width: 100%; height: 300px;"></div>
              </div>
            </div>
          </div>
        </div> <!-- Tercer fila ./End row #clientesAtencion -->
        
        <?php if (empty($this->Session->read('Desarrollador.DesarrollosUser.desarrollo_id'))): ?>
          <div class="row">
            <div class="col-sm-12 col-lg-6">
              <div class="card mt-2" style="min-height: 300px;">
                <div class="card-header bg-white">
                  <div class="row">
                    <div class="col-xs-6 col-lg-6">
                      Mensajes de gerencia
                    </div>
                    <?php if ($this->Session->read('Permisos.Group.id')!=3): ?>
                      <div class="col-xs-6 col-lg-6 text-xl-right text-xs-right">
                        <?= $this->Html->link('<i class="fa fa-plus fa-lg"></i>','#',array('data-target'=>"#mensaje",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','title'=>'Escribir Mensaje','escape'=>false));?>
                      </div>
                    <?php endif ?>
                  </div>
                </div>
                <div class="card-block" style="overflow-y: scroll; height:300px !important; background-image: url('../img/fondo_trans.png'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                  <div class="row">
                    <div class="col-sm-12">
                      <ul style="margin: 0px; padding: 0px;">
                        <?php foreach ($mensajes as $mensaje):?>
                        <li style="list-style: none;">
                          <div class="row mt-1">
                            <div class="col-xs-3 col-lg-2">
                              <?php echo $this->Html->image($mensaje['Created']['foto'], array('class'=>'img-circle img-bordered-sm img-fluid'))?>
                            </div>
                            <div class="col-sm-12 col-lg-10">
                              <div class="row">
                                <div class="col-sm-12">
                                  <ins>
                                    <?php echo $this->Html->link($mensaje['Created']['nombre_completo'],array('action'=>'view','controller'=>'users',$mensaje['Created']['id']))?>
                                  </ins>
                                </div>
                                <div class="col-sm-12">
                                  <?php echo $mensaje['Mensaje']['mensaje']?>
                                </div>
                                <div class="col-sm-12">
                                  <i style="font-size: .9rem;"><?php echo date("d/M/Y", strtotime($mensaje['Mensaje']['creation_date']))?></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <hr class="mt-1">
                        <?php endforeach;?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-lg-6">
              <div class="card mt-2" style="min-height: 300px;">
                <div class="card-header bg-white">
                  eventos activos
                </div>
                <div class="card-block" style="overflow-y: scroll; height:300px !important; background-image: url('../img/fondo_trans.png'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                  <div class="row">
                    <div class="col-sm-12">
                      <?php foreach ($eventos as $proximo):?>
                        <?php
                            if (!isset($proximo['Event']['inmueble_id'])) {
                                $inmueble_id = 0;
                              }else{
                                $inmueble_id = $proximo['Event']['inmueble_id'];
                              }

                              if (!isset($proximo['Event']['desarrollo_id'])) {
                                $desarrollo_id = 0;
                              }else{
                                $desarrollo_id = $proximo['Event']['desarrollo_id'];
                              }
                        ?>

                        <div class="mt-1">
                          <div class="tag tag-pill tag-primary float-xs-right">
                            <a  href="#" data-toggle="modal" data-target="#myModal2" id="target-modal" onclick="editEvent(
                                <?= $proximo['Event']['id'].
                                    ",'".$proximo['Event']['nombre_evento']."'".
                                    ",'".$proximo['Event']['direccion']."'".
                                    ",'".date('d-m-Y',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                    ",'".date('H',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                    ",'".date('i',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                    ",'".date('d-m-Y', strtotime($proximo['Event']['fecha_fin']))."'".
                                    ",'".date('H', strtotime($proximo['Event']['fecha_fin']))."'".
                                    ",'".date('i',  strtotime($proximo['Event']['fecha_fin']))."'".
                                    ",".$proximo['Event']['cliente_id'].
                                    ",".$inmueble_id.
                                    ",".$desarrollo_id.
                                    ",".$proximo['Event']['color']

                                ?>
                            )" title ="Editar evento" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                          </div>
                          <div class="tag tag-pill tag-danger float-xs-right"><?= $this->Html->link('<i class="fa fa-close"></i>',array('controller'=>'events','action'=>'cerrar',$proximo['Event']['id'],3),array('escape'=>false, 'title'=>'Da clic si el evento se ha cancelado', 'data-toggle'=>'tooltip'))?></div>
                          <div class="tag tag-pill tag-success float-xs-right"><?= $this->Html->link('<i class="fa fa-check"></i>',array('controller'=>'events','action'=>'cerrar',$proximo['Event']['id'],2),array('escape'=>false, 'title'=>'Da clic si el evento se ha registrado con exito', 'data-toggle'=>'tooltip'))?></div>
                          <div class="tag tag-pill tag-primary float-xs-right"><?= date('d/M/Y \a \l\a\s H:i',  strtotime($proximo['Event']['fecha_inicio']))?></div>
                          <?= $proximo['Event']['nombre_evento']?><br>
                          <hr class="mt-1">
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- Octaba fila - Mensajes gerenciales y eventos proximos -->
        <?php endif ?>

        <div class="row" id="metaVentasMes">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-white">
                <div class="row">
                  <div class="col-sm-12">
                    <i class="fa fa-calendar"></i> Meta de ventas del mes
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="grafica_metas_ventas" style="width: 100%; min-height:300px;"></div>
              </div>
            </div>
          </div>
        </div> <!-- Cuarta fila ./End row #metaVentasMes -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-white">
                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                    <i class="fa fa-calendar"></i> Metas vs Ventas por mes
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="metasventas" style="width: 100%; min-height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>

        <?php if (empty($this->Session->read('Desarrollador'))): ?>
          <div class="row">
            <div class="col-sm-12 col-lg-6">
              <div class="card mt-1" style="min-height: 300px;">
                <div class="card-header success_bg_dark text-white">
                  Desarrollos nuevos
                </div>
                <div class="card-block" style="overflow-y: scroll; height:300px !important;">
                  <div class="row">
                    <?php if (empty($desarrollos_nuevos)): ?>
                      <div class="col-sm-12"> <span style="height: 241px; font-size: 1.2rem; color: #C6C6C6;" class="flex-center">No hay nuevos desarrollos por el momento.</span></div>
                    <?php else: ?>
                    <div class="col-sm-12">
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <?php foreach ($desarrollos_nuevos as $desarrollos): ?>
                              <tr>
                                <td style="width: 100px;">
                                  <?= $this->Html->link($this->Html->image($desarrollos['FotoDesarrollo'][0]['ruta'], array('class'=>'img-fluid')), array('controller'=>'desarrollos', 'action'=>'view', $desarrollos['Desarrollo']['id']), array('escape'=>false)); ?>
                                </td>
                                <td>
                                  <?= $this->Html->link($desarrollos['Desarrollo']['nombre'], array('controller'=>'desarrollos', 'action'=>'view', $desarrollos['Desarrollo']['id'])); ?>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-12 col-lg-6">
              <div class="card mt-1" style="min-height: 300px;">
                <div class="card-header success_bg_dark text-white">
                  Inmuebles nuevos
                </div>
                <div class="card-block" style="overflow-y: scroll; height:300px !important;">
                  <div class="row">
                    <?php if (empty($propiedades_nuevas)): ?>
                      <div class="col-sm-12"> <span style="height: 241px; font-size: 1.2rem; color: #C6C6C6;" class="flex-center">No hay nuevas propiedades por el momento.</span></div>
                    <?php else: ?>
                        <div class="col-sm-12">
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <?php foreach ($propiedades_nuevas as $inmuebles): ?>
                                  <tr>
                                    <td style="width: 100px">
                                      <?= $this->Html->link($this->Html->image($inmuebles['foto_inmuebles']['ruta'], array('class'=>'img-fluid')), array('controller'=>'inmuebles', 'action'=>'view', $inmuebles['inmuebles']['id']), array('escape'=>false)); ?>
                                    </td>
                                    <td>
                                      <?= $this->Html->link($inmuebles['inmuebles']['titulo'], array('controller'=>'inmuebles', 'action'=>'view', $inmuebles['inmuebles']['id'])); ?>
                                    </td>
                                  </tr>
                                <?php endforeach ?>
                              </thead>
                            </table>
                          </div>
                        </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- Desarrollos e inmuebles nuevos -->
        <?php endif ?>



        <div class="row">
        <div class="col-sm-12 mt-2">
          <div class="card">
            <div class="card-header" style="background: transparent !important; font-size: 1.2rem;">
              Cambios de precios en Propiedades
            </div>
            <div class="card-block" style="overflow-y: scroll; height:300px !important;">
              <div class="row mt-1">
                <div class="col-sm-12">
                  <!-- <div class="table-responsive"> -->
                    <table class="table" id="example1">
                      <thead>
                        <tr>
                          <th>Imagen</th>
                          <th>Propiedad</th>
                          <th>Precio anterior</th>
                          <th>Precio nuevo</th>
                          <th>Variación</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($precios_inmuebles as $precio):?>
                          <?php
                            $last_price = sizeof($precio['Precio'])-2;
                            $final_price = sizeof($precio['Precio'])-1;
                          ?>
                          <tr>
                            <td style="width: 100px;"><?= $this->Html->image($precio['FotoInmueble'][0]['ruta'], array('class'=>'img-fluid')); ?></td>
                            <td>
                              <?= $this->Html->link($precio['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$precio['Inmueble']['id']))?>
                            </td>
                            <td>
                              <font style="color: red; text-decoration: line-through">
                                <b>
                                  $<?= number_format($precio['Precio'][$last_price]['precio'],2)?>
                                </b>
                              </font>
                            </td>
                            <td>
                              <b>$<?= number_format($precio['Precio'][$final_price]['precio'],2)?></b>&nbsp;
                            </td>
                            <td class="text-center">
                              <?php if ($precio['Precio'][$final_price]['precio']<$precio['Precio'][$last_price]['precio']){?>
                              <i class="fa fa-arrow-circle-o-down fa-2x"></i>
                              <?php }else{?>
                              <i class="fa fa-arrow-circle-o-up fa-2x"></i>
                              <?php } ?>
                            </td>
                          </tr>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  <!-- </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> <!-- ./End row cambio de precios en propiedades -->

      <div class="row">
        <div class="col-sm-12">
          <div class="card mt-1">
            <div class="card-header bg-white">
              Mapeo de Desarrollos
            </div>
            <div class="card-block">
              <div id="map" style="width: 100%; height: 400px;" class="mt-1"></div>
            </div>
          </div>
        </div>
      </div> <!-- ./End row Google maps -->
      

    </div> <!-- /inner lter bg-container -->
  </div>
</div>
<?php 
  echo $this->Html->script([
    'components',
    'custom',
    // Graficas de Google
    'https://www.gstatic.com/charts/loader.js',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyDOf3eYcnrP8hgEx5_914fUwMR1NCyQPfw',

    // Calendario 
    '/vendors/jquery.uniform/js/jquery.uniform',
    '/vendors/inputlimiter/js/jquery.inputlimiter',
    '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
    '/vendors/jquery-tagsinput/js/jquery.tagsinput',
    '/vendors/validval/js/jquery.validVal.min',
    '/vendors/inputmask/js/jquery.inputmask.bundle',
    '/vendors/moment/js/moment.min',
    '/vendors/daterangepicker/js/daterangepicker',
    '/vendors/datepicker/js/bootstrap-datepicker.min',
    '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
    '/vendors/bootstrap-switch/js/bootstrap-switch.min',
    '/vendors/autosize/js/jquery.autosize.min',
    '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
    '/vendors/jasny-bootstrap/js/inputmask',
    '/vendors/datetimepicker/js/DateTimePicker.min',
    '/vendors/j_timepicker/js/jquery.timepicker.min',
    '/vendors/clockpicker/js/jquery-clockpicker.min',
    'form',
    // 'pages/datetime_piker',

    // Datatables
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
    'pages/simple_datatables',

  ], array('inline'=>false));
?>

<script>
// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(ClienteStatusGeneral);                  // Grafica de status de clientes
google.charts.setOnLoadCallback(drawClientes);                          // Temperatura de clientes
google.charts.setOnLoadCallback(atencionClientes);                      // Estado de los clientes
google.charts.setOnLoadCallback(metas_ventas);            // Metas de venta al mes

google.charts.setOnLoadCallback(drawVentasMetas);             // Metas vs Ventas

// Grafica de status de clientes
function ClienteStatusGeneral(){
  var data = google.visualization.arrayToDataTable([
      ["Estado", "Cantidad", { role: "style" } ],
      ["ACTIVO", <?= $data_clientes_status['activos'] ?>, "#BF9000"],
      ["INACTIVO TEMPORAL", <?= $data_clientes_status['inactivos_temp'] ?>, "#7F6000"],
      // ["ACTIVO VENTA", <?= $data_clientes_status['ventas'] ?>, "#70AD47"],
      ["INACTIVO DEFINITIVO", <?= $data_clientes_status['inactivos_def'] ?>, "#000000"],
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
                     { calc: "stringify",
                       sourceColumn: 1,
                       type: "string",
                       role: "annotation" },
                     2]);

    var options = {
      // title: "Estatus de atención a clientes",
      height: 300,
      titleTextStyle:{
      color:'#616161',
      fontSize: 14,
      textAlign: 'center',
      },
      backgroundColor:'transparent',
      bar: {groupWidth: "95%"},
      legend: { position: "none" },
      hAxis: {
          textStyle:{color: '#616161'}
      },
      vAxis: {
          textStyle:{color: '#616161'}
      }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("grafica_estatus_general_clientes"));
    chart.draw(view, options);
}

function drawClientes(){
  var data = google.visualization.arrayToDataTable([
    ["Temperatura", "Cantidad"],
    ["Fríos", <?= $data_clientes_temp['frios']?>],
    ["Tibios", <?= $data_clientes_temp['tibios']?>],
    ["Calientes", <?= $data_clientes_temp['calientes']?>],
    // ["Venta", <?= $data_clientes_temp['ventas']?>],
  ]);

  var options = {
    // height: 300,
    backgroundColor:'transparent',
    legend: {
      textStyle:{
        color   :'#000',
        fontSize: 14,
      }
    },
    pieStartAngle: 135,
    titleTextStyle:{
      color    :'#FFFFFF',
      fontSize : 14,
      textAlign: 'center',
    },
    bar: {groupWidth: "95%"},
    slices: {
      0: { color: '#5B9BD5' },
      1: { color: '#FFC000' },
      2: { color: '#C00000' },
      3: { color: '#70AD47' }
    },
    hAxis: {
      textStyle:{color: '#FFFFFF'}
    },
    vAxis: {
      textStyle:{color: '#FFFFFF'}
    },
  };

  var chart = new google.visualization.PieChart(document.getElementById('grafica_clientes'));
  chart.draw(data, options);
}

function atencionClientes(){
  var data = google.visualization.arrayToDataTable([
      ["Estado", "Cantidad", { role: "style" } ],
      ["Oportuna (Día 1 al <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')?>)", <?= $data_clientes_atencion['oportunos']?>, "#1F4E79"],
      ["Tardía (Día <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')?>)", <?= $data_clientes_atencion['tardios']?>, "#7030A0"],
      ["No Atendidos (Día <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?>)", <?= $data_clientes_atencion['no_atendidos']?>, "#DA19CA"],
      ["Por Reasignar (+<?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?> días)", <?= $data_clientes_atencion['por_reasignar']?>, "#7F7F7F"],
      // ["Clientes inactivo temporal", <?= $data_clientes_atencion['inactivos_temp'] ?>, "#B58800"],
  ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
     { calc: "stringify",
       sourceColumn: 1,
       type: "string",
       role: "annotation" },
     2]);

  var options = {
      title: "",
      height: 300,
      titleTextStyle:{
      fontSize: 12
  },
      backgroundColor:'transparent',
      bar: {groupWidth: "100%"},
      legend: { position: "none" },
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("grafica_atencion_clientes"));
  chart.draw(view, options);
}





// Mapa de ubicaciones de propiedades
var locations = [
  <?php 
        foreach ($ubicaciones_d as $ubicacion):
            $coordenadas = explode(",",$ubicacion['Desarrollo']['google_maps']);
        ?>
        
  ['<?= $ubicacion['Desarrollo']['nombre']?>', <?= $coordenadas[0]?>, <?= $coordenadas[1]?>],
  <?php
    endforeach;
   ?>  
];

var map = new google.maps.Map(document.getElementById('map'), {
  zoom: 6,
  center: new google.maps.LatLng(23.266721, -105.677918),
  mapTypeId: google.maps.MapTypeId.ROADMAP
});

var infowindow = new google.maps.InfoWindow();

var marker, i;

var image = {
  url: '<?= Router::url('/img/pin-desarrollos-v3.png', true); ?>',
  // This marker is 20 pixels wide by 32 pixels high.
  size: new google.maps.Size(40,45),
  // The origin for this image is (0, 0).
  // origin: new google.maps.Point(0, 0),
  // The anchor for this image is the base of the flagpole at (0, 32).
  // anchor: new google.maps.Point(0, 32)
};

for (i = 0; i < locations.length; i++) {  
  marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map,
    title:locations[i][0],
    icon: image,
  });

  google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
      infowindow.setContent(locations[i][0]);
      infowindow.open(map, marker);
    }
  })(marker, i));
}


function tot_clientes(){
  //check-master-tot-clientes
  if (document.getElementById("check-master-tot-clientes").checked == true){
    $('.tr-display-plus').removeClass('hidden');
    $('.tr-display-plus').addClass('show');
    $('#icon-master-tot-clientes').removeClass('fa-plus');
    $('#icon-master-tot-clientes').addClass('fa-minus');
    document.getElementById("check-master-tot-clientes").checked = false;
  }else{
    $('.tr-display-plus').removeClass('show');
    $('.tr-display-plus').addClass('hidden');
    $('#icon-master-tot-clientes').removeClass('fa-minus');
    $('#icon-master-tot-clientes').addClass('fa-plus');
    document.getElementById("check-master-tot-clientes").checked = true;
  }
}

function tot_clientes_anio(){
  //check-master-tot-clientes
  if (document.getElementById("check-master-tot-clientes-anio").checked == true){
    $('.tr-display-plus-anio').removeClass('hidden');
    $('.tr-display-plus-anio').addClass('show');
    $('#icon-master-tot-clientes-anio').removeClass('fa-plus');
    $('#icon-master-tot-clientes-anio').addClass('fa-minus');
    document.getElementById("check-master-tot-clientes-anio").checked = false;
  }else{
    $('.tr-display-plus-anio').removeClass('show');
    $('.tr-display-plus-anio').addClass('hidden');
    $('#icon-master-tot-clientes-anio').removeClass('fa-minus');
    $('#icon-master-tot-clientes-anio').addClass('fa-plus');
    document.getElementById("check-master-tot-clientes-anio").checked = true;
  }
}

// Funciones de información.

function info_clientes(id){
  
  $("#modal_clientes").modal('show')
  let div = document.getElementById("mensaje_clientes");
  if (id == 1) { // Clientes Activos
    div.innerHTML = "<strong>Cliente Activo:</strong> Cliente vigente a partir de que le sea asignado un asesor, integra los clientes que han comprado al menos una propiedad (Activo venta).";
  }
  if (id == 2) { // Clientes inactivos temporales
    div.innerHTML = "<strong>Cliente Inactivo Temporal:</strong> Cliente en baja temporal por motivos señalados por el cliente y mantiene el interés en comprar o rentar una propiedad.";
  }
  if (id == 3) { // Clientes inactivos definitivos
    div.innerHTML = "<strong>Cliente Inactivos:</strong> Cliente de baja definitiva por razones diversas (compró/rentó otra propiedad, declinó su interés, no se le atendió en tiempo, etc.).";
  }
}


function metas_ventas() {
  var data = google.visualization.arrayToDataTable([
    ['Ventas', 'Q Ventas'],
    ['Objetivo de ventas',     <?= $meta_mes?>],
    ['Ventas Alcanzadas',      <?= $monto_venta_actual?>],
    
  ]);

  var options = {
    title: 'Meta de cumplimiento de venta de <?= date('M-Y'); ?>: $<?= number_format($meta_mes,0)?>',
    // is3D: true,
    height: 300,
    titleTextStyle:{
      fontSize: 16
    },
    pieHole: 0.2,
    // pieSliceText: 'label',
    slices: {
      0: {
        color: '#BFFA77',
        textStyle:{color: '#323232'}
      },
      1: { color: '#70AD47' }
    },
    backgroundColor:'transparent',
    legend:{
        textStyle:{
           fontSize: 13
        }
    },
  };

  var chart = new google.visualization.BarChart(document.getElementById('grafica_metas_ventas'));
  chart.draw(data, options);
}

function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Meta', 'Ventas', '% Cumplido'],
        <?php foreach ($ventas_grafica as $venta): ?>
            <?php
                if ($meta_mes != 0) {
                    $var1 = ($venta[0]['sum(precio_cerrado)']/$meta_mes)*100;
                }
            ?>
            <?php $maximo += $venta[0]['sum(precio_cerrado)']; ?>
            ['<?= $venta[0]['mes']?>', <?= $meta_mes?>, <?= $venta[0]['sum(precio_cerrado)']?>, <?= $var1 ?>],
        <?php endforeach;?>
     ]);

    var options = {
    // title : 'Metas Vs Ventas por mes',
    //             vAxis: {title: 'Monto $'},
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $meta_mes?>,
            title: 'Monto $',
         }, 
         {
            minValue: 0,
            maxValue: 100,
            title: '% de Meta complido',
         }
     ],
     hAxis: {title: 'Periodo'},
    //             seriesType: 'bars',
    // height: 300,
    //series: {},
    //             series: {
    //                0: {
    //                    targetAxisIndex: 0 // use the left axis
    //                },
    //                1: {
    //                    targetAxisIndex: 1 // use the right axis
    //                },
    //                2: {type: 'line'}
    //            },
    series: {
        0: { // Meta
            type: "bars",
            targetAxisIndex: 0,
            color: "#BFFA77"
        },
        1: { // Real
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47"
        },
        2: {  // % de cumplimiento
            type: "line",
            targetAxisIndex: 1,
            color: "#ED7D31"
        },
    },   
    backgroundColor:'transparent',
    legend:{
      textStyle:{
          
          fontSize: 13
      }
    },
    titleTextStyle:{
        fontSize: 16
    },
};

    var chart = new google.visualization.ComboChart(document.getElementById('metasventas'));
    chart.draw(data, options);
}

$(document).ready(function () {
  // Calendario
  $('.calendario').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"bottom"
  });

  // Rango de fechas
  $('#date_range').daterangepicker({
    orientation:"bottom",
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

});
</script>
