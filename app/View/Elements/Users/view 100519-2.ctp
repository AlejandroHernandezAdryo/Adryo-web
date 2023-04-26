<?php
    echo $this->Html->css(
      array(

          // data tables
          '/vendors/select2/css/select2.min',
          '/vendors/datatables/css/scroller.bootstrap.min',
          '/vendors/datatables/css/colReorder.bootstrap.min',
          '/vendors/datatables/css/dataTables.bootstrap.min',
          'pages/dataTables.bootstrap',
          
          // Tablas
          'pages/tables',
      ),
      array('inline'=>false)
    );

  // Definición de variables para graficos e información.
  $ventas = 0;
  $q_ventas = 0;
  foreach ($ventas_semanales as $venta) {
      $ventas += $venta['Venta']['precio_cerrado'];
      $q_ventas++;
  }
  $objetivo  = $cuentas_users['CuentasUser']['ventas_mensuales'];
  $pendiente = (($objetivo-$ventas) <= 0 ? 0:$objetivo-$ventas);

  $meses_format = array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');

  $frios      = 0;
  $tibios     = 0;
  $calientes  = 0;
  $temp_venta = 0;
  if ($data_frio > 0) {$frios = $data_frio;}
  if ($data_tibio > 0) {$tibios = $data_tibio;}
  if ($data_caliente > 0) {$calientes = $data_caliente;}
  if ($data_venta > 0) {$temp_venta = $data_venta;}

  $date_current = date('Y-m-d');
  $date_oportunos = date('Y-m-d H:m:s', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_oportuna'), date('Y')));
  $date_tardios = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_atrasados'), date('Y')));
  $date_no_atendidos = $date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - $this->Session->read('Parametros.Paramconfig.sla_no_atendidos'), date('Y')));

  $venta_temp            = $temp_venta;
  $activos               = isset($data_activos[0][0]['COUNT(status)'])?$data_activos[0][0]['COUNT(status)']:0;
  $inactivos_temporal    = isset($data_inactivos_temporal[0][0]['COUNT(status)'])?$data_inactivos_temporal[0][0]['COUNT(status)']:0;
  $inactivos_definitivos = isset($data_inactivos_definitivo[0][0]['COUNT(status)'])?$data_inactivos_definitivo[0][0]['COUNT(status)']:0;
?>

<style>
  .table-sm-height{
    min-height: 220px;
  }
</style>

<!-- Modal delete cliente -->
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
  <header class="head">
    <div class="main-bar row">
      <div class="col-lg-6 col-md-4 col-sm-4">
          <h4 class="nav_top_align">
            <i class="fa fa-user"></i> Perfil de asesor
          </h4>
      </div>
    </div>
  </header>
  <div class="outer">
      <div class="inner bg-light lter bg-container">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
                <div class="card-header bg-blue-is">
                  <div class="row">
                    <div class="col-sm-12 col-lg-6">
                      <?= $user['User']['nombre_completo'].' | '.$cuentas_users['CuentasUser']['puesto'] ?>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                      <?= $this->Html->link('<i class="fa fa-edit fa-lg"></i>',array('controller'=>'users','action'=>'edit',$user['User']['id']),array('escape'=>false, 'class'=>'float-lg-right text-white'))?>
                    </div>
                  </div>
                </div>
              <div class="card-block">
                <!-- Informacion de perfil -->
                <div class="row">
                  <div class="col-sm-12">
                    <?php // print_r($ventas_anuales); // echo $this->element('sql_dump'); ?>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-12 col-lg-4 mt-2">
                    <?= $this->Html->image($user['User']['foto'],array('style'=>'width: auto;height: 250px;','class'=>'admin_img_width','alt'=>'Fotografía Usuario'))?>
                  </div>
                  <div class="col-sm-12 col-lg-8 mt-2">
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <tr>
                            <td>Nombre completo</td>
                            <td>
                                <?= $this->Form->hidden('id',array('value'=>$user['User']['id']))?>
                                <span><?= $user['User']['nombre_completo']; ?></span>
                            </td>
                            
                        </tr>
                        <tr>
                            <td>E-mail</td>
                            <td>
                                <span><?= $user['User']['correo_electronico'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Teléfono 1</td>
                            <td>
                                <span><?= $user['User']['telefono1'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Teléfono 2</td>
                            <td>
                                <span><?= $user['User']['telefono2'] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Opcionador</td>
                            <td>
                                <span>
                                    <?php
                                        if ($cuentas_users['CuentasUser']['opcionador'] == 0) {echo "No"; }
                                        else{echo "Si";}
                                    ?>
                                    
                                </span></td>
                        </tr>
                        <tr>
                            <td>Rol</td>
                            <td><span><?= $groups[$cuentas_users['CuentasUser']['group_id']] ?></span></td>
                        </tr>
                        <tr>
                            <td>Puesto</td>
                            <td><span><?= $cuentas_users['CuentasUser']['puesto'] ?></span></td>
                        </tr>
                        <tr>
                            <td>Unidad de Venta</td>
                            <td>
                                <?php $unidad = array(''=>'sin definir', 1=>'Monto', 2=>'Unidades')?>
                                <span><?= $unidad[$cuentas_users['CuentasUser']['unidad_venta']] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Objetivo de ventas <?php echo $meses_format[date('m')]; ?></td>
                            <td>
                                <span><?= '$ '.number_format($cuentas_users['CuentasUser']['ventas_mensuales']) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Usuario Creado</td>
                            <td><span><?= date('d/M/Y',  strtotime($user['User']['created']))?></span></td>
                        </tr>
                        <tr>
                            <td>Último Acceso</td>
                            <td><span><?= !empty($user['User']['last_login']) ? date('d/M/Y \a \l\a\s H:i:s \h\r\s',  strtotime($user['User']['last_login'])) : ""?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?= $this->Form->hidden('return',array('value'=>1))?>
                            </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- /Informacion de perfil -->
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-lg-6 mt-2">
            <div class="card">
              <div class="card-header bg-blue-is">
                INDICADORES DE DESEMPEÑO <?= $meses_format[date('m')]; ?>
              </div>
              <div class="card-block">
                <div class="table-responsive table-sm-height">
                  <table class="table table-sm mt-1">
                    <tr>
                      <td>Meta de venta <?= $meses_format[date('m')]; ?></td>
                      <td class="text-lg-right"><?= number_format($cuentas_users['CuentasUser']['ventas_mensuales'],0)?></td>
                    </tr>
                    <tr>
                      <td>Total de clientes <?= $meses_format[date('m')]?></td>
                      <td class="text-lg-right"><?= $clientes_mes ?></td>
                    </tr>
                    <tr>
                      <td>Unidades Vendidas <?= $meses_format[date('m')]?></td>
                      <td class="text-lg-right"><?= $q_ventas ?></td>
                    </tr>
                    <!-- <tr>
                      <td>Efectividad de Ventas <?= $meses_format[date('m')] ?></td>
                      <td class="text-lg-right"> <? if($q_ventas != 0 || sizeof($clientes) != 0){ echo number_format((($q_ventas/$count_clientes)*100),2)} else{echo 0;}?> %</td>
                    </tr> -->
                    <tr>
                      <td>Total de ventas <?= $meses_format[date('m')] ?></td>
                      <td class="text-lg-right"><?= number_format($ventas,0)?></td>
                    </tr>
                    <tr>
                      <td>Promedio $ por unidad</td>
                      <td class="text-lg-right">
                        <?php
                          if ($q_ventas > 0){
                              echo "$".number_format(($ventas/$q_ventas),0);
                          }else{
                              echo "$0.00";
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>% de cunplimiento meta</td>
                      <td class="text-lg-right">
                        <?php 
                          if ($q_ventas>0){
                              echo round(($ventas/$cuentas_users['CuentasUser']['ventas_mensuales'])*100, 2)."%";
                          }else{
                              echo "0%";
                          }
                        ?>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-6 mt-2">
            <div class="card">
              <div class="card-header bg-blue-is">
                INDICADORES ACOMULADOS <?= date('Y'); ?>
              </div>
              <div class="card-block">
                <div class="table-responsive table-sm-height">
                  <table class="table table-sm mt-1">
                    <tr>
                      <td>Meta ventas <?= date('Y'); ?></td>
                      <td class="text-lg-right"> $ <?= number_format($cuentas_users['CuentasUser']['ventas_mensuales']*date('n'),0)?> </td>
                    </tr>
                    <tr>
                      <td>Total de clientes <?= date('Y'); ?></td>
                      <td class="text-lg-right"> <?= $clientes_anual ?></td>
                    </tr>
                    <tr>
                      <td>Total de unidades vendidas <?= date('Y'); ?></td>
                      <td class="text-lg-right"><?= $inmuebles_anuales ?></td>
                    </tr>
                    <tr>
                      <td>Total de ventas <?= date('Y'); ?></td>
                      <td class="text-lg-right">$ <?= number_format($ventas_anuales[0][0]['sum(precio_cerrado)'],0)?></td>
                    </tr>
                    <tr>
                      <td>Promedio de $ por unidad</td>
                      <td class="text-lg-right">$<?php echo $inmuebles_anuales != 0 ? number_format($ventas_anuales[0][0]['sum(precio_cerrado)']/$inmuebles_anuales,0):"0"?></td>
                    </tr>
                    <tr>
                      <td>% de cumplimiento meta</td>
                      <td class="text-lg-right">
                        <?php echo $cuentas_users['CuentasUser']['ventas_mensuales'] != 0 ? round(($ventas_anuales[0][0]['sum(precio_cerrado)']/($cuentas_users['CuentasUser']['ventas_mensuales']*date('n')) * 100), 2) : "0" ?>%
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /fila 2 -->

        <div class="row">
          <div class="col-sm-12 col-lg-7">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                ESTATUS GENERAL DE MIS CLIENTES
              </div>
              <div class="card-block">
                <div id="grafica_estatus_general_clientes" style="width: 100%; height: 300px;"></div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-5">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <div class="row">
                  <div class="col-sm-12 col-lg-8">
                    <i class="fa  fa-bar-chart-o"></i> TEMPERATURA DE CLIENTES
                  </div>
                  <div class="col-sm-12 col-lg-4 text-xs-right">
                    Total: <?php echo $frios + $tibios + $calientes + $temp_venta; ?>
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="grafica_clientes" style="width: 100%; min-height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Fila 3 -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-1">
              <div class="card-header bg-blue-is">
                <div class="row">
                  <div class="col-sm-12 col-lg-8">
                    <i class="fa fa-calendar"></i> ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
                  </div>
                  <div class="col-sm-12 col-lg-4 text-xs-right">
                    Total: <?= $oportunos + $tardios + $no_atendidos + $por_reasignar + $inactivos_temporal ?>
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="grafica_tipos_clientes" style="width: 100%; height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- Fila 4 -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <div class="row">
                  <div class="col-sm-12">
                    <i class="fa fa-calendar"></i> Meta de ventas del mes
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div id="donutchart" style="width: 100%; min-height:300px;"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
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
        <!-- /Fila 5 -->


        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                origen de clientes / ventas <?= $meses_format[date('m')]. ' '. date('Y'); ?>
              </div>
              <div class="card-block">
                <div id="origen_cientes_ventas" style="width: 100%; min-height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Fila 6 -->
        
        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                Histórico contactos / Ventas / Gasto <?= date('Y'); ?>
              </div>
              <div class="card-block">
                <div id="meses" style="width: 100%; min-height: 300px;"></div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Fila 7 -->

        
        <div class="row">
          <div class="col-sm-12 col-lg-6">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-calendar"></i> Próximos eventos
              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-sm-12">
                    <div id="calendar_mini" class="bg-primary"></div>
                      <div class="list-group" style="overflow-y: scroll; height:215px !important">
                        <?php foreach ($eventos as $proximo):?>
                        <a href="#" class="list-group-item calendar-list">
                          <div class="tag tag-pill tag-primary float-xs-right"><?= date('d/M/Y \a \l\a\s H:i',  strtotime($proximo['Event']['fecha_inicio']))?></div>
                          <?= $proximo['Event']['nombre_evento']?>
                        </a>
                        <?php endforeach; ?>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-lg-6">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-pencil"></i> Últimas 10 Actividades
              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="feed" style="overflow-y: scroll; height:215px !important">
                      <ul>
                        <?php
                            $estilos=array(
                                0 =>'fa-dot-circle-o',
                                1 =>'fa-plus',
                                2 => 'fa-pencil',
                                3 =>'fa-phone',
                                4 =>'fa-phone'
                                );
                        ?>
                        <?php
                          foreach($logs as $log):
                            switch ($log['LogCliente']['accion']) {
                              case 0:
                                $icono = 'fa-dot-circle-o';
                                break;
                              case 1:
                                $icono = 'fa-plus';
                                break;
                              case 2:
                                $icono = 'fa-pencil';
                                break;
                              case 3:
                                $icono = 'fa-phone';
                                break;
                              case 4:
                                $icono = 'fa-dot-circle-o';
                                break;
                              default:
                                $icono = 'fa-dot-circle-o';
                                break;
                            }
                        ?>
                        <li style="list-style: none;" class="mt-1">
                            <p>
                              <span><i class="fa <?= $icono ?>"></i></span>
                                <?php // $log['LogCliente']['accion']; ?>
                                <font color="black"><?= $log['LogCliente']['mensaje']." accion realizada para el cliente ".$log['Cliente']['nombre']?></font>
                                <br>
                                Acción asignada a:
                                <strong><?= $log['User']['nombre_completo']?></strong>
                                <br>
                                <i><?= date('d/m/Y',  strtotime($log['LogCliente']['datetime']))?></i>
                            </p>
                        </li>
                        <li style="list-style: none;">
                          <hr>
                        </li>
                        <?php endforeach;?>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /Fila 6 -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-dollar"></i> Tabla de ventas generales
              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-sm-12 mt-3">
                    <table class="table table-sm" id="table_v_general">
                      <thead>
                        <tr>
                          <td>Tipo operación</td>
                          <td>Propiedad</td>
                          <td>Cliente</td>
                          <td>Fecha operación</td>
                          <td>Monto compra</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach ($ventas_generales as $venta_global):
                            if($venta_global['Venta']['tipo_operacion'] == 'Venta'){$op = 'V'; $class_op = 'bg_venta'; $name_op = 'Venta';}
                            else{$op = 'R'; $class_op = 'bg_renta'; $name_op = 'Renta';}
                        ?>

                            <tr>
                                <td><small><span class="<?= $class_op ?>"><?= $op ?></span></small><span class="text_hidden"><?= $name_op ?></span></td>
                                <td>
                                    <ins>
                                        <?= $this->Html->link($venta_global['Inmueble']['titulo'], array('controller'=>'inmuebles', 'action'=>'view', $venta_global['Inmueble']['id'])) ?>
                                    </ins>
                                </td>
                                <td>
                                    <ins>
                                        <?= $this->Html->link($venta_global['Cliente']['nombre'], array('controller'=>'clientes', 'action'=>'view', $venta_global['Cliente']['id'])) ?>
                                    </ins>
                                </td>
                                <td><?= date('Y-m-d', strtotime($venta_global['Venta']['fecha'])) ?></td>
                                <td class="text-xs-right">$ <?= number_format($venta_global['Venta']['precio_cerrado']) ?></td>
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
        <!-- /Fila 7 -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-users"></i> Cartera de Clientes
              </div>
              <div class="card-block">
                <div class="row mt-3">
                  <div class="col-sm-12">
                    <table class="table table-sm" id="table-cartera-clientes">
                      <thead>
                          <tr>
                              <th></th>
                              <th></th>
                              <th>Estatus</th>
                              <th>Nombre</th>
                              <th>Inmueble/Desarrollo origen</th>
                              <th>Correo electrónico</th>
                              <th>Teléfono</th>
                              <th>Forma contacto</th>
                              <th>Tipo cliente</th>
                              <th>Etapa</th>
                              <th>Fecha creación</th>
                              <th>Ultimo seg</th>
                              <th>Asesor</th>
                              <!-- <th>Comentario</th> -->
                              <?php if ($this->Session->read('Permisos.Group.ce')): ?>
                              <th><i class='fa fa-edit'></i></th>
                              <?php endif; ?>
                              <?php if ($this->Session->read('Permisos.Group.cd')): ?>
                              <th><i class='fa fa-trash'></i></th>
                              <?php endif; ?>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($clientes as $cliente):?>

                          <tr>
                            <?php 
                              if ($cliente['Cliente']['temperatura']    == 1){$temp = 'F'; $class_temp = 'bg_frio'; $name_temp = 'Frio';}
                              elseif($cliente['Cliente']['temperatura'] == 2){$temp = 'T'; $class_temp = 'bg_tibio'; $name_temp = 'Tibio';}
                              elseif($cliente['Cliente']['temperatura'] == 3){$temp = 'C'; $class_temp = 'bg_caliente'; $name_temp = 'Caliente';}
                              elseif($cliente['Cliente']['temperatura'] == 4){$temp = 'V'; $class_temp = 'bg_venta'; $name_temp = 'Venta';}
                              else{$temp =''; $class_temp = ''; $name_temp = '';}

                              if ($cliente['Cliente']['last_edit'] <= $date_current.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
                              elseif($cliente['Cliente']['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
                              elseif($cliente['Cliente']['last_edit'] < $date_tardios.' 23:59:59' && $cliente['Cliente']['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
                              elseif($cliente['Cliente']['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['Cliente']['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                              else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}

                              if ($cliente['Cliente']['status'] == 'Activo venta') {$status_cliente = 'Venta';}
                              else{$status_cliente = $cliente['Cliente']['status'];}

                            ?>
                            <td><small><span class="<?= $class_temp ?>"><?= $temp; ?></span><span class="text_hidden"><?= $name_temp; ?></span></small></td>
                            <td><small><span class="<?= $class_at ?>"><?= $at; ?></span><span class="text_hidden"><?= $name_at; ?></span></small></td>
                            <td><?= $status_cliente ?></td>
                            <td>
                              <?= $this->Html->link(rtrim($cliente['Cliente']['nombre']), array('controller' => 'clientes', 'action' => 'view', $cliente['Cliente']['id'])) ?>
                            </td>
                            <td>
                              <?= rtrim($cliente['Desarrollo']['nombre']). rtrim($cliente['Inmueble']['titulo']) ?>
                            </td>
                            <td>
                              <?= rtrim($cliente['Cliente']['correo_electronico']) ?>
                            </td>
                            <td>
                              <?= rtrim($cliente['Cliente']['telefono1']) ?>
                            </td>
                            <td>
                              <?= $cliente['DicLineaContacto']['linea_contacto'] ?>
                            </td>
                            <td>
                              <?= $cliente['DicTipoCliente']['tipo_cliente'] ?>
                            </td>
                            <td>
                              <?= $cliente['DicEtapa']['etapa'] ?>
                            </td>
                            <td>
                              <?= date('Y-m-d', strtotime($cliente['Cliente']['created'])) ?>
                            </td>
                            <td>
                              <?= date('Y-m-d', strtotime($cliente['Cliente']['last_edit'])) ?>
                            </td>
                            <td>
                              <?= $this->Html->link(rtrim($cliente['User']['nombre_completo']), array('controller' => 'users', 'action' => 'view', $cliente['User']['id'])) ?>
                            </td>
                            <td>
                              <?=  $this->Html->link('<i class="fa fa-edit"></i>', array('action'=>'edit', $cliente['Cliente']['id']), array('escape'=>false,'target'=>'_blank'))?>
                            </td>
                            <td>
                              <a class="c_pointer"  onclick="myFunction(<?= $cliente['Cliente']['id'] ?>);"><i class="fa_fa_trash"></i></a>
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
        <!-- /Fila 8 -->

        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-dollar"></i> Oportunidades de Venta
              </div>
              <div class="card-block">
                <div class="row mt-3">
                  <div class="col-sm-12">
                    <table class="table table-sm data-table-class">
                      <thead>
                        <tr>
                          <th>Cliente</th>
                          <th>Propiedad / Desarrollo</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($leads as $lead):?>
                          <tr>
                            <td><?php echo $this->Html->link($lead['Cliente']['nombre'], array('action'=>'view', $lead['Cliente']['id'],'controller'=>'clientes'),array('target'=>'_blank'))?></td>
                            <td>
                                <?php 
                                if ($lead['Inmueble']['titulo']==null){
                                    echo $this->Html->link($lead['Desarrollo']['nombre'],array('action'=>'view','controller'=>'desarrollos',$lead['Desarrollo']['id']));
                                }else{
                                    echo $this->Html->link($lead['Inmueble']['titulo'],array('action'=>'view','controller'=>'inmuebles',$lead['Inmueble']['id']));
                                }
                                ?>
                            </td>
                            <td ><?php echo $lead['Lead']['status']?></td>
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
        <!-- /Fila 9  -->
      </div>
  </div>
</div>


<?php 
    echo $this->Html->script([
        'components',
        'custom',
        // Graficas de Google
        'https://www.gstatic.com/charts/loader.js',

        // Data tables
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
        // 'pages/datatable',

    ], array('inline'=>false));
?>
<script>
  'use strict';
$(document).ready(function() {
    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');
});
var TableAdvanced = function() {
    // ===============table 1====================
    var initTable1 = function() {
        var table = $('.data-table-class');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            // order: [[10, "desc"]],
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
    // ===============table 1===============

    // ===============table 1====================
    var initTable2 = function() {
        var table = $('#table_v_general');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[3, "Desc"]],
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
    // ===============table 1===============

    // ===============table 1====================
    var initTable3 = function() {
        var table = $('#table-cartera-clientes');
        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
        /* Set tabletools buttons and button container */
        table.DataTable({
            // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            order: [[10, "Desc"]],
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
    // ===============table 1===============
    
    return {
        //main function to initiate the module
        init: function() {
            if (!jQuery().dataTable) {
                return;
            }
            initTable1();
            initTable2();
            initTable3();
        }
    };
}();

// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart']});

// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawClientes);                // Temperatura de clientes
google.charts.setOnLoadCallback(drawTiposClientes);           // Estado de los clientes
google.charts.setOnLoadCallback(drawChart);                   // Metas de venta al mes
google.charts.setOnLoadCallback(drawVentasMetas);             // Metas vs Ventas
google.charts.setOnLoadCallback(ClienteStatusGeneral);        // Estatus clientes
google.charts.setOnLoadCallback(drawClientesLineasContacto);  // Origen clientes ventas mes
google.charts.setOnLoadCallback(drawMeses);

function drawClientes(){
    var data = google.visualization.arrayToDataTable([
          ["Temperatura", "Cantidad"],
          ["Frios", <?= $frios?>],
          ["Tibios", <?= $tibios?>],
          ["Calientes", <?= $calientes?>],
          ["Venta", <?= $temp_venta?>],
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

function drawTiposClientes(){
    var data = google.visualization.arrayToDataTable([
        ["Estado", "Cantidad", { role: "style" } ],
        ["Oportuna (Día 1 al <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')?>)", <?= $oportunos?>, "#1F4E79"],
        ["Tardía (Día <?= $this->Session->read('Parametros.Paramconfig.sla_oportuna')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')?>)", <?= $tardios?>, "#7030A0"],
        ["No Atendidos (Día <?= $this->Session->read('Parametros.Paramconfig.sla_atrasados')+1?> al <?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?>)", <?= $no_atendidos?>, "#DA19CA"],
        ["Por Reasignar (+<?= $this->Session->read('Parametros.Paramconfig.sla_no_atendidos')?> días)", <?= $por_reasignar?>, "#7F7F7F"],
        ["Clientes inactivo temporal", <?= $inactivos_temporal ?>, "#B58800"],
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
    var chart = new google.visualization.ColumnChart(document.getElementById("grafica_tipos_clientes"));
    chart.draw(view, options);
}


function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Ventas', 'Q Ventas'],
      ['Objetivo de ventas',     <?= $pendiente?>],
      ['Ventas Alcanzadas',      <?= $ventas?>],
      
    ]);

    var options = {
      title: 'Meta de ventas del mes: $<?= number_format($objetivo,0)?>',
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

    var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
    chart.draw(data, options);
}

<?php
    $maximo = '0';
    $var1   = '0';
?>
function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Meta', 'Ventas', '% Cumplido'],
        <?php foreach ($ventas_grafica as $venta): ?>
            <?php
                if ($cuentas_users['CuentasUser']['ventas_mensuales'] != 0) {
                    $var1 = ($venta[0]['sum(precio_cerrado)']/$cuentas_users['CuentasUser']['ventas_mensuales'])*100;
                }
            ?>
            <?php $maximo += $venta[0]['sum(precio_cerrado)']; ?>
            ['<?= $venta[0]['mes']?>', <?= $cuentas_users['CuentasUser']['ventas_mensuales']?>, <?= $venta[0]['sum(precio_cerrado)']?>, <?= $var1 ?>],
        <?php endforeach;?>
     ]);

    var options = {
    // title : 'Metas Vs Ventas por mes',
    //             vAxis: {title: 'Monto $'},
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $cuentas_users['CuentasUser']['ventas_mensuales']?>,
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

// Grafica de status de clientes
function ClienteStatusGeneral(){
  var data = google.visualization.arrayToDataTable([
      ["Estado", "Cantidad", { role: "style" } ],
      ["ACTIVO", <?= $activos ?>, "#BF9000"],
      ["INACTIVO TEMPORAL", <?= $inactivos_temporal ?>, "#7F6000"],
      ["ACTIVO VENTA", <?= $venta_temp ?>, "#70AD47"],
      ["INACTIVO DEFINITIVO", <?= $inactivos_definitivos ?>, "#000000"],
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

function drawClientesLineasContacto(){
  var data = google.visualization.arrayToDataTable([
      ['Forma de Contacto', 'Contactos','Ventas','Inversión'],
      <?php foreach ($clientes_linea_contacto as $clc):?>
          ['<?= $lineas_contacto[$clc['clientes']['dic_linea_contacto_id']]?>',<?=$clc[0]['count(*)']?>,<?= (isset($arreglo_vm[$clc['clientes']['dic_linea_contacto_id']]) ? $arreglo_vm[$clc['clientes']['dic_linea_contacto_id']] : 0) ?>,<?= (isset($arreglo_im[$clc['clientes']['dic_linea_contacto_id']]) ? $arreglo_im[$clc['clientes']['dic_linea_contacto_id']] : 0) ?>],
      <?php endforeach;?>
   ]);

 var options = {
   vAxes: 
   [
       
       {
           title: 'Contactos',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }, 
       {
           minValue: 0,
           maxValue: 11000,
           title: 'Inversión',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }
   ],
   hAxis: {title: 'Linea de contacto',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'},},
   height: 300,
   series: {
          0: {
              //Objetivo
              type: "bars",
              targetAxisIndex: 0,
              color: "orange"
          },
          1: {
              //Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          2: { 
            //% de cumplimiento
              type: "line",
              targetAxisIndex: 1,
              color: "#12f7ff"
          },
      },   
   backgroundColor:'transparent',
   legend:{
        textStyle:{
            color:'#616161',
            fontSize: 13
        }
    },
  titleTextStyle:{
      color:'#616161',
      fontSize: 16
    },
   
 };

 var chart = new google.visualization.ComboChart(document.getElementById('origen_cientes_ventas'));
 chart.draw(data, options);

}

function drawMeses(){
  var data = google.visualization.arrayToDataTable([
      ['Mes', 'Contactos','Ventas','Inversión'],
      <?php foreach ($meses as $mes):?>
          ['<?= $mes?>',<?= $arreglo_cm[$mes]?>,<?= isset($ventas_mes[$mes]) ? $ventas_mes[$mes] : 0?>,<?= isset($arreglo_inversionm[$mes]) ? $arreglo_inversionm[$mes] : 0?>],
      <?php endforeach;?>
   ]);

 var options = {
   // title : 'Histórico contactos / Ventas / Gasto',
//             vAxis: {title: 'Monto $'},
   vAxes: 
   [
       
       {
           title: 'Contactos',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
           
       }, 
       {
           minValue: 0,
           maxValue: 11000,
           title: 'Inversión',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }
   ],
   hAxis: {title: 'Periodo',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'}},
//             seriesType: 'bars',
   height: 300,
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
          0: { //Objetivo
              type: "bars",
              targetAxisIndex: 0,
              color: "orange"
          },
          1: { //Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          2: {  //% de cumplimiento
              type: "line",
              targetAxisIndex: 1,
              color: "#12f7ff"
          },
      },   
   backgroundColor:'transparent',
   legend:{
        textStyle:{
            color:'#616161',
            fontSize: 13
        }
    },
  titleTextStyle:{
      color:'#616161',
      fontSize: 16
    },
  
  
   
 };

 var chart = new google.visualization.ComboChart(document.getElementById('meses'));
 chart.draw(data, options);

}

function myFunction(id){
    $("#modal_cliente_delete").modal('show')
    document.getElementById("ClienteId").value = id;
}
</script>