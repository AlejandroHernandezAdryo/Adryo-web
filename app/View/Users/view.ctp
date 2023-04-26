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
?>
<style>
  .table-sm-height{
    min-height: 220px;
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

<?= $this->Element('Users/add') ?>
<?= $this->Element('Users/edit') ?>

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
                    <?= $user['User']['nombre_completo'].' | '.$user['Grupo']['nombre'] ?>
                  </div>
                  <div class="col-sm-12 col-lg-6" style="text-align: right;">

                  <?=
                    $this->Html->link('<i class="fa fa-edit fa-lg"></i>','#',array('escape'=>false, 'class'=>'float-lg-right text-white', 'onclick' => 'edit_user_modal('.$user['User']['id'].')'));
                  ?>
                  
                  </div>
                  <div class="col-sm-12 col-lg-6">
                    <?php 
                      if ($this->Session->read('Permisos.Groups.ue') == 1) {
                        echo $this->Html->link('<i class="fa fa-edit fa-lg"></i>',array('controller'=>'users','action'=>'edit',$user['User']['id']),array('escape'=>false, 'class'=>'float-lg-right text-white'));
                      }
                    ?>
                  </div>
                </div>
              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-sm-12 col-lg-4 mt-2">
                    <?= $this->Html->image($user['User']['foto'],array('style'=>'width: 100%;height: auto;max-width: 100%;max-height: 400px;','class'=>'admin_img_width','alt'=>'Fotografía Usuario'))?>
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
                            <td>Opcionador</td>
                            <td>
                                <span>
                                    <?php
                                        if ($user['CuentasUser']['opcionador'] == 0) {echo "No"; }
                                        else{echo "Si";}
                                    ?>
                                    
                                </span></td>
                        </tr>
                        <tr>
                            <td>Tipo usuario</td>
                            <td><span><?= $user['Grupo']['nombre'] ?></span></td>
                        </tr>
                        <tr>
                            <td>Puesto</td>
                            <td><span><?= $user['CuentasUser']['puesto'] ?></span></td>
                        </tr>
                        <tr>
                            <td>Unidad de Venta</td>
                            <td>
                                <?php $unidad = array(''=>'sin definir', 1=>'Monto', 2=>'Unidades')?>
                                <span><?= $unidad[$user['CuentasUser']['unidad_venta']] ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Objetivo de ventas (Monto) <?php echo $meses_format[date('m')]; ?></td>
                            <td>
                                <span><?= '$ '.number_format($user['CuentasUser']['ventas_mensuales']) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Objetivo de ventas (Cantidad) <?php echo $meses_format[date('m')]; ?></td>
                            <td>
                                <span><?= number_format($user['CuentasUser']['ventas_mensuales_q'],0) ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Acceso a Módulo de Finanzas</td>
                            <td>
                                <span><?= $user['CuentasUser']['finanzas']==1?"Si":"No"?></span>
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
              </div>
            </div>
          </div>
        </div>
        <!-- Row datos generales -->

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
                      <td class="text-lg-right"><?= number_format($user['CuentasUser']['ventas_mensuales'],0)?></td>
                    </tr>
                    <tr>
                      <td onclick="tot_clientes();" class="pointer">
                        <input type="checkbox" class="hidden" id="check-master-tot-clientes" checked>
                        <i class="fa fa-plus pointer" id="icon-master-tot-clientes"></i> 
                        Total de clientes <?= $meses_format[date('m')]?>
                      </td>
                      <td class="text-float-right">
                        <?= 
                          $user['User']['ClientesMes']['QActivos'] + 
                          $user['User']['ClientesMes']['QInactivosTemp'] + 
                          $user['User']['ClientesMes']['QInactivosDef'];
                        ?>
                      </td>
                    </tr>
                    <tr class="tr-display-plus hidden">
                      <td style="padding-left: 18px;">
                        Total de clientes <ins class="pointer" onclick="info_clientes(1);">activos<i class="fa fa fa-question-circle-o"></i></ins>
                      </td>
                      <td class="text-float-right">
                        <?= $user['User']['ClientesMes']['QActivos'] ?>
                      </td>
                    </tr>
                    <tr class="tr-display-plus hidden">
                      <td style="padding-left: 18px;">
                        Total de clientes <ins  class="pointer" onclick="info_clientes(2);">inactivos temporales <i class="fa fa fa-question-circle-o"></i></ins>
                      </td>
                      <td class="text-float-right">
                        <?= $user['User']['ClientesMes']['QInactivosTemp'] ?>
                      </td>
                    </tr>
                    <tr class="tr-display-plus hidden">
                      <td style="padding-left: 18px;">
                        Total de clientes <ins class="pointer" onclick="info_clientes(3);">inactivos definitivos <i class="fa fa fa-question-circle-o"></i></ins>
                      </td>
                      <td class="text-float-right">
                        <?= $user['User']['ClientesMes']['QInactivosDef'] ?>
                      </td>
                    </tr>
                    <tr>
                      <td>Unidades Vendidas <?= $meses_format[date('m')]?></td>
                      <td class="text-lg-right"><?= $q_ventas_mes ?></td>
                    </tr>
                    <tr>
                      <td>Total de ventas <?= $meses_format[date('m')] ?></td>
                      <td class="text-lg-right"><?= number_format($monto_ventas_mes,2)?></td>
                    </tr>
                    <tr>
                      <td>Promedio $ por unidad</td>
                      <td class="text-lg-right">
                        <?php
                          if ($q_ventas_mes > 0){
                              echo "$".number_format(($monto_ventas_mes/$q_ventas_mes),2);
                          }else{
                              echo "$0.00";
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>% de cunplimiento meta</td>
                      <td class="text-lg-right">
                        <?php echo $user['CuentasUser']['ventas_mensuales'] != 0 ? round(($monto_ventas_mes/($user['CuentasUser']['ventas_mensuales']) * 100), 2) : "0" ?>%
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
                INDICADORES ACUMULADOS AL <?= date('Y'); ?>
              </div>
              <div class="card-block">
                <div class="table-responsive table-sm-height">
                  <table class="table table-sm mt-1">
                    <tr>
                      <td>Meta ventas <?= date('Y'); ?></td>
                      <td class="text-lg-right"> $ <?= number_format($user['CuentasUser']['ventas_mensuales']*date('n'),0)?> </td>
                    </tr>
                    <tr>
                          <td onclick="tot_clientes_anio();" class="pointer">
                            <input type="checkbox" class="hidden" id="check-master-tot-clientes-anio" checked>
                            <i class="fa fa-plus pointer" id="icon-master-tot-clientes-anio"></i> 
                            Total de clientes al <?= date('Y') ?>
                          </td>
                          <td class="text-float-right">
                            <?= 
                              $user['User']['ClientesAcumulado']['QActivos'] + 
                              $user['User']['ClientesAcumulado']['QInactivosTemp'] + 
                              $user['User']['ClientesAcumulado']['QInactivosDef'];
                            ?>
                          </td>
                        </tr>
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes al <ins class="pointer" onclick="info_clientes(1);">activos <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $user['User']['ClientesAcumulado']['QActivos'] ?>
                          </td>
                        </tr>
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes al <ins class="pointer" onclick="info_clientes(2);">inactivos temporales <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $user['User']['ClientesAcumulado']['QInactivosTemp'] ?>
                          </td>
                        </tr>
                        <tr class="tr-display-plus-anio hidden">
                          <td style="padding-left: 18px;">
                            Total de clientes al <ins class="pointer" onclick="info_clientes(3);">inactivos definitivos <i class="fa fa-question-circle-o"></i></ins>
                          </td>
                          <td class="text-float-right">
                            <?= $user['User']['ClientesAcumulado']['QInactivosDef'] ?>
                          </td>
                        </tr>
                    <tr>
                      <td>Total de unidades vendidas <?= date('Y'); ?></td>
                      <td class="text-lg-right"><?= $q_ventas_acumulado ?></td>
                    </tr>
                    <tr>
                      <td>Total de ventas <?= date('Y'); ?></td>
                      <td class="text-lg-right">$ <?= number_format($monto_ventas_acumulado,0)?></td>
                    </tr>
                    <tr>
                      <td>Promedio de $ por unidad</td>
                      <td class="text-lg-right">$<?php echo $q_ventas_acumulado != 0 ? number_format($monto_ventas_acumulado/$q_ventas_acumulado,0):"0"?></td>
                    </tr>
                    <tr>
                      <td>% de cumplimiento meta</td>
                      <td class="text-lg-right">
                        <?php echo $user['CuentasUser']['ventas_mensuales'] != 0 ? round(($monto_ventas_acumulado/($user['CuentasUser']['ventas_mensuales']*date('n')) * 100), 2) : "0" ?>%
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Segunda fila, indicadores de desempeño -->
  
        <!-- ESTATUS GENERAL DE MIS CLIENTES -->
        <div class="row"> 
          <div class="col-sm-12 mt-1">
            <?= $this->Element('Clientes/clientes_estatus_by_ajax') ?>
          </div>
        </div>

          <!-- ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS  -->
          <div class="row mt-1 salto">
                  <div class="col-sm-12 mt-1">
                    <?= $this->Element('Clientes/clientes_activos_atencion_by_ajax') ?>
                  </div>
                </div>

        <!-- ETAPAS DE CLIENTES ACTIVOS AL (FECHA DEL ÚLTIMO DÍA DEL PERIODO SOLICITADO) -->
        <div class="row mt-1 salto">
          <div class="col-sm-12">
            <?= $this->Element('Clientes/clientes_activos_etapa_by_ajax') ?>
          </div> 
        </div>  


        <!-- Tarjetas de proximos eventos y ultimas 10 actividades -->
        <?php if (empty($this->Session->read('Desarrolladores'))): ?>
          <div class="row">
            <div class="col-sm-12 col-lg-6">
              <div class="card mt-2">
                <div class="card-header bg-blue-is">
                  
                  Próximos Eventos (15 días)
                  <span class="float-xs-right">
                      <small style="text-transform: uppercase;">
                          <i class=" fa fa-home"></i> Cita
                          <i class=" fa fa-check-circle"></i> Visita
                      </small>
                  </span>

                </div>
                <div class="card-block">
                
                  <div class="feed"style="overflow-y: scroll; height:215px !important">
                    <?= $this->element('Events/eventos_proximos'); ?>
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
                                  <font color="black"><?= $log['LogCliente']['mensaje']." acción realizada para el cliente ".$log['Cliente']['nombre']?></font>
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
        <?php endif ?>

      <!-- META VS. VENTAS ($ MONTO EN MDP) -->
      <div class="row mt-1 salto"> 
                  <div class="col-sm-12 mt-1">
                    <!-- ok -->
                    <?= $this->Element('Desarrollos/desarrollo_ventas_metas_by_ajax') ?>
                  </div>
                </div>
            
            
                <!-- VENTAS EN UNIDADES Y MONTO EN MDP -->
                <div class="row mt-1 salto">
                  <div class="col-sm-12">
                    <!-- ok -->
                    <?= $this->Element('Desarrollos/desarrollo_ventas_metas__dinero_by_ajax') ?>
                  </div>
                </div> 
        
              
            <!-- CLIENTES POR MEDIO DE PROMOCIÓN, VENTAS E INVERSIÓN EN PUBLICIDAD -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
                <!-- ok -->
								<?= $this->Element('Leads/user_leads_ventas_linea_contacto_by_ajax') ?>
							</div>
						</div>
        <!-- <div class="row mt-1">
          <div class="col-sm-12">
            <?= $this->Element('Clientes/clientes_linea_contacto') ?>
          </div>
        </div> -->

        <!-- Tabla de ventas generales -->
        <div class="row">
          <div class="col-sm-12">
            <div class="card mt-2">
              <div class="card-header bg-blue-is">
                <i class="fa fa-dollar"></i> Tabla de ventas generales
              </div>
              <div class="card-block">

                <div class="row">
                  <div class="col-sm-12 col-lg-6">
                    Total monto $: <span id="view_tot_monto_venta"></span>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                    Total unidades: <span id="view_tot_unidades_venta"> <?= $view_tot_unidades_venta = count($user['User']['Venta']); ?> - U </span>
                  </div>
                </div>

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
                          foreach ($user['User']['Venta'] as $venta_global):
                            if($venta_global['tipo_operacion'] == 'Venta'){$op = 'V'; $class_op = 'bg_venta'; $name_op = 'Venta';}
                            else{$op = 'R'; $class_op = 'bg_renta'; $name_op = 'Renta';}
                        ?>

                            <tr>
                                <td data-search="<?= $name_op ?>"><small><span class="<?= $class_op ?>"><?= $op ?></span></small><span</td>
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
                                <td><?= date('Y-m-d', strtotime($venta_global['fecha'])) ?></td>
                                <td class="text-xs-right">$ <?= number_format($venta_global['precio_cerrado']) ?></td>
                            </tr>
                            <?php $view_tot_monto_venta += $venta_global['precio_cerrado']; ?>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ./Tabla de ventas generales -->

        <!-- Cartera de clientes -->
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
                              <th>Etapa</th>
                              <th>E.A</th>
                              <th>Estatus</th>
                              <th>Nombre</th>
                              <th>Desarrollo/Inmueble</th>
                              <th>Fecha de creación</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($user['User']['Cliente'] as $cliente):?>

                          <tr>
                            <?php 
                              switch($cliente['etapa']){
                                case 1:
                                  $c_etapa = 'estado1';
                                break;
                                case 2:
                                  $c_etapa = 'estado2';
                                break;
                                case 3:
                                  $c_etapa = 'estado3';
                                break;
                                case 4:
                                  $c_etapa = 'estado4';
                                break;
                                case 5:
                                  $c_etapa = 'estado5';
                                break;
                                case 6:
                                  $c_etapa = 'estado6';
                                break;
                                case 7:
                                  $c_etapa = 'estado7';
                                break;
                              }

                              if ($cliente['last_edit'] <= $date_current.' 23:59:59' && $cliente['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
                              elseif($cliente['last_edit'] < $date_oportunos.' 23:59:59' && $cliente['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
                              elseif($cliente['last_edit'] < $date_tardios.' 23:59:59' && $cliente['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
                              elseif($cliente['last_edit'] < $date_no_atendidos.' 23:59:59' && $cliente['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                              else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}


                            ?>
                            <td><small class="chip <?= $c_etapa ?>"><?= $cliente['etapa'] ?><small></td>
                            <td data-search="<?= $name_at; ?>"><small><span class="<?= $class_at ?>"><?= $at; ?></span></small></td>
                            <td><?= $cliente['status'] ?></td>
                            <td>
                              <?= $this->Html->link(rtrim($cliente['nombre']), array('controller' => 'clientes', 'action' => 'view', $cliente['id'])) ?>
                            </td>
                            <td>
                              <?= empty($cliente['Desarrollo']['nombre']) ? '' : rtrim($cliente['Desarrollo']['nombre']) ?>
                              <?= empty($cliente['Inmueble']['titulo']) ? '' : rtrim($cliente['Inmueble']['titulo']) ?>
                            </td>
                            <td>
                              <?= date('Y-m-d', strtotime($cliente['created'])) ?>
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
        <!-- ./Cartera de clientes -->

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
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js'

    ], array('inline'=>false));
?>
<script>
  'use strict';

document.getElementById("view_tot_monto_venta").innerHTML = '<?= number_format($view_tot_monto_venta); ?>';

$(document).ready(function () {
  let user_id = "<?=$user['User']['id']?>"; 
  let log_user = "<?=$user['User']['created']?>"; 
  let last_log = "<?=$user['User']['last_login']?>"; 
  let dataRange =  "<?= date('d-m-Y', strtotime(  $fecha_primer_cleinte['Cliente']['created']  )) .' - '.date('d-m-Y') ?>";
  let cuenta_id=<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')?>;

  console.log(cuenta_id);
  console.log(user_id);
  console.log(dataRange);
  graficaClientesEstatus (dataRange, 0, 0, user_id);
  graficaClientesEtapa( dataRange, 0, 0, user_id );
  graficaClientesActivos( dataRange, 0, 0, user_id );

  graficaClientesActivos( dataRange, 0, 0, user_id );

  graficaVentasMetasDesarrollo( dataRange, <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, user_id );
  graficaVentasMetasMontoDesarrollo( dataRange, <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, user_id );
  gradicaLeadsVentasInversionUSER( dataRange, cuenta_id, 0, user_id );
  
  window.setInterval(function(){
      $('#myModal').modal('hide');
      $("#overlay").fadeOut();
    },7000);
});

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

// tablas
var table = $('#table_v_general').DataTable( {
  dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  orderCellsTop: true,
  autoWidth: true,
  columnDefs: [
      {targets: 0, width: '40px'},
  ],
  language: {
      sSearch: "Buscador",
      lengthMenu: '_MENU_ registros por página',
      info: 'Mostrando _TOTAL_ registro(s)',
      infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
      emptyTable: "Sin información",
      paginate: {
          previous: 'Anterior',
          next: 'Siguiente'
      },
  },
  lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
  buttons: [
      {
          extend: 'excel',
          text: '<i class="fa  fa-file-excel-o"></i> Exportar',
          class : 'excel',
          className: 'btn-secondary',
          charset: 'utf-8',
          bom: true
      },
      {
          extend: 'print',
          text: '<i class="fa  fa-print"></i> Imprimir',
          className: 'btn-secondary',
      },
  ]
});

var table2 = $('#table-cartera-clientes').DataTable( {
  dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
  orderCellsTop: true,
  autoWidth: true,
  columnDefs: [
      {targets: 0, width: '40px'},
  ],
  language: {
      sSearch: "Buscador",
      lengthMenu: '_MENU_ registros por página',
      info: 'Mostrando _TOTAL_ registro(s)',
      infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
      emptyTable: "Sin información",
      paginate: {
          previous: 'Anterior',
          next: 'Siguiente'
      },
  },
  lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
  buttons: [
      {
          extend: 'excel',
          text: '<i class="fa  fa-file-excel-o"></i> Exportar',
          class : 'excel',
          className: 'btn-secondary',
          charset: 'utf-8',
          bom: true
      },
      {
          extend: 'print',
          text: '<i class="fa  fa-print"></i> Imprimir',
          className: 'btn-secondary',
      },
  ]
});


</script>