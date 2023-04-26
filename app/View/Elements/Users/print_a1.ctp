<div>
    <table style="width: 100%;">
        <tr>
            <td style="width:25%; text-align:left"><img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" style="width:150px"></td>
            <td style="width:50%; text-align:center">
              <h1 class="text-sm-center text-black">Reporte de Asesor: <?= $asesor['User']['nombre_completo'] ?></h1>
                  <?php 
                    $roles = array(
                      1 => 'Superadministrador',
                      2 => 'Gerente',
                      3 => 'Asesor'
                    );
                  ?>                                           
                  <div class="text-lg-center" style="font-size: 1rem; text-align:center">
                    <p><b style="font-size:14px">Periodo del: <?= $periodo_reporte ?></b></p>
                    <p><b>Proyectos Asignados: </b> <?= (empty($desarrollos_asignados[0][0]['asignados']) ? '' : $desarrollos_asignados[0][0]['asignados'] ) ?></p>
                    <p><b>Fecha de Ingreso: </b><?= date("d/M/Y",strtotime($asesor['User']['created']))?></p>
                    <p><b>Rol: </b><?= $roles[$asesor['Rol'][0]['cuentas_users']['group_id']]?></p>
                  </div>
            </td>
            <td style="width:25%; text-align:right"><?= $this->Html->image($asesor['User']['foto'],array('height'=>'150px'))?>/td>
        </tr>
    </table>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_estatus') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_atencion') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_distribucion_inactivos') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/clientes_distribucion_inactivos_temporales') ?> 
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_temperatura') ?>
</div>

<div class="m-t-25">
  <div class="col-lg-6">
    <?= $this->element('Events/eventos_cards_reporte'); ?>
  </div>
  <div class="col-lg-6">
    <?= $this->element('Events/eventos_cards_acumulados'); ?>
  </div>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/asignaciones_mes') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_distribucion_desarrollos') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Users/asignados_vs_reasignados') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/motivos_reasignacion') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/ventas_vs_metas') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/ventas_vs_metas_dinero') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Desarrollos/visitas_vs_ventas') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Users/contactos_vs_visitas') ?> 
</div>

<div class="m-t-25 salto">
  <div class="titulo_bloque"><i class="fa fa-money"></i> Listado de Ventas (<?= $periodo_reporte ?>)</div>
  <div class="row">
    <div class="col-sm-12 col-lg-6">
      Total monto $: <span id="ra_tot_monto_venta"></span>
    </div>
    <div class="col-sm-12 col-lg-6">
      Total unidades: <span id="ra_tot_unidades_venta"> <?= $ra_tot_unidades_venta = count($lista_ventas); ?> - U </span>
    </div>
  </div>
  <table style="width: 100%;">
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
      $ra_tot_monto_venta =0;
      foreach ($lista_ventas as $venta_global):
        if($venta_global['Venta']['tipo_operacion'] == 'Venta'){$op = 'V'; $class_op = 'bg_venta'; $name_op = 'Venta';}
        else{$op = 'R'; $class_op = 'bg_renta'; $name_op = 'Renta';}
    ?>
      <tr>
          <td class="text-sm-center"><small><span class="<?= $class_op ?>"><?= $op ?></span></small><span class="text_hidden"><?= $name_op ?></span></td>
          <td>
              <?php echo $venta_global['Inmueble']['titulo'] ?>
          <td>
              <?php echo $venta_global['Cliente']['nombre']; ?>
          </td>
          <td><?= date('d/M/Y', strtotime($venta_global['Venta']['fecha'])) ?></td>
          <td class="text-xs-right">$ <?= number_format($venta_global['Venta']['precio_cerrado']) ?></td>
      </tr>
      <?php $ra_tot_monto_venta += $venta_global['Venta']['precio_cerrado']; ?>
    <?php endforeach ?>
      
    </tbody>
  </table>
</div>
<script>
  document.getElementById("ra_tot_monto_venta").innerHTML = '<?= number_format($ra_tot_monto_venta); ?>';
</script>