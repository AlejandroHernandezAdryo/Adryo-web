<div>
    <table style="width: 100%;">
        <tr>
            <td style="width:25%; text-align:left"><img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" style="width:150px"></td>
            <td style="width:50%; text-align:center">
              <?php if (isset($desarrollo)){?>
                <h1 class="titulo">
                  Reporte de Desarrollo: <?= $desarrollo['Desarrollo']['nombre']?>
                </h1>
              <?php } else if (isset($cluster)){?>
                <h1 class="titulo">
                  Reporte de Cluster: <?= $cluster['Cluster']['nombre']?>
                </h1>
                <p style="text-align:center">
                <b>Desarrollos:</b><br>
                <?php foreach($cluster['Desarrollos'] as $desarro){
                    echo $desarro['nombre'].", ";
                  }?>
                </p>
              <?php }?>
                <p>
                  <b>Periodo del: <?= $periodo_reporte ?></b>
                </p>
            </td>
            <td style="width:25%; text-align:right"><?= $this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'],array('height'=>'150px'))?></td>
        </tr>
    </table>
</div>

<?php if (isset($desarrollo)){?>
  <div class="m-t-60">
    <div class="titulo_bloque"><i class="fa fa-building"></i> Datos Generales</div>
    <table>
      <tbody>
          <tr>
              <td>
                <b>Total desarrollo: </b>
              </td>
              <td class="text-sm-right">
                <?= sizeof($desarrollo['Propiedades'])?> / $<?= number_format(($n_bloqueadas_precios[0][0]['total_inmuebles']+$n_liberadas_precios[0][0]['total_inmuebles']+$n_recervadas_precios[0][0]['total_inmuebles']+$n_contrato_precios[0][0]['total_inmuebles']+$n_escrituracion_precios[0][0]['total_inmuebles']+$n_baja_precios[0][0]['total_inmuebles']),0)?>
              </td>
              <td style="padding-left: 5em;">
                <b>Fecha de inicio de comercialización: </b>
              </td>
              <td class="text-sm-right">
                <?= $desarrollo['Desarrollo']['fecha_liberacion']==null || $desarrollo['Desarrollo']['fecha_liberacion'] == '1969-12-31' ? "Sin Fecha" : date("d/m/Y",strtotime($desarrollo['Desarrollo']['fecha_liberacion'])) ?>
              </td>
          </tr>
          <tr>
              <td>
                <b>Total Disponible:  </b>
              </td>
              <td class="text-sm-right">
                <?= sizeof($desarrollo['Disponibles'])?> / $<?= number_format($n_liberadas_precios[0][0]['total_inmuebles'],0)?>
              </td>
              <td style="padding-left: 5em;">
                <b>Fecha de inicio de obra: </b>
              </td>
              <td class="text-sm-right">
                <?= $desarrollo['Desarrollo']['fecha_inicio_obra']==null || $desarrollo['Desarrollo']['fecha_inicio_obra'] == '1969-12-31' ? "Sin Fecha" : date("d/m/Y",strtotime($desarrollo['Desarrollo']['fecha_inicio_obra'])) ?>
              </td>
          </tr>
          <tr>
              <td>
                <b>% de Ventas: </b>
              </td>
              <td class="text-sm-right">
                <?= number_format(($n_recervadas_precios[0][0]['n_inmuebles']+$n_contrato_precios[0][0]['n_inmuebles']+$n_escrituracion_precios[0][0]['n_inmuebles'])/sizeof($desarrollo['Propiedades'])*100,2)?>%</b>  
              </td>
              <td style="padding-left: 5em;">
                <b>Fecha Estimada Fin de Obra: </b> 
              </td>
              <td class="text-sm-right">
                <?= $desarrollo['Desarrollo']['fecha_fin_obra']==null || $desarrollo['Desarrollo']['fecha_fin_obra'] == '1969-12-31' ? 'Sin Fecha' : date("d/m/Y",strtotime($desarrollo['Desarrollo']['fecha_fin_obra']))?>  
              </td>
          </tr>
          <tr>
              <td>
                <b>% de Construcción: </b>
              </td>
              <td class="text-sm-right">
                <?= (empty($desarrollo['AvancesConstruccion'][0]['porcentaje_construccion']) ? 'Sin Fecha' : number_format($desarrollo['AvancesConstruccion'][0]['porcentaje_construccion'],2))  ?>%  
              </td>
              <td style="padding-left: 5em;">
                <b>Fecha Real Fin de Obra: </b>  
              </td>
              <td class="text-sm-right">
                <?= $desarrollo['Desarrollo']['fecha_real_fin_obra']==null || $desarrollo['Desarrollo']['fecha_real_fin_obra'] == '1969-12-31' ? 'Sin Fecha' : date("d/m/Y",strtotime($desarrollo['Desarrollo']['fecha_real_fin_obra']))?>  
              </td>
          </tr>
          <tr>
              <td colspan="2"></td>
              <td style="padding-left: 5em;">
                <b>Fecha de inicio de Escrituración: </b>  
              </td>
              <td class="text-sm-right">
                <?= $desarrollo['Desarrollo']['fecha_inicio_escrituracion']==null || $desarrollo['Desarrollo']['fecha_inicio_escrituracion'] == '1969-12-31' ? 'Sin Fecha' : date("d/m/Y",strtotime($desarrollo['Desarrollo']['fecha_inicio_escrituracion'])) ?>
              </td>
          </tr>
          
      </tbody>
    </table>
  </div>
<?php } ?>

<div class="m-t-25">
  <div class="titulo_bloque">
    <i class="fa fa-building"></i> Estatus general de propiedades históricos acumulados al día <?= date('d/m/Y')?>
  </div>
    <div class="row" style="background-color: #D1D1D1; margin: 5px; border-radius: 5px; text-transform: uppercase; font-weight: 600;">
      <div class="col-sm-6">
        Total de Unidades:
        <?= number_format($n_bloqueadas_precios[0][0]['n_inmuebles'] +
          $n_liberadas_precios[0][0]['n_inmuebles'] +
          $n_recervadas_precios[0][0]['n_inmuebles'] +
          $n_contrato_precios[0][0]['n_inmuebles'] +
          $n_escrituracion_precios[0][0]['n_inmuebles'] +
          $n_baja_precios[0][0]['n_inmuebles'])
        ?>
      </div>
      <div class="col-sm-6">
        Total en Cantidad (MDP)
        <?= number_format(
          $n_bloqueadas_precios[0][0]['total_inmuebles'] +
          $n_liberadas_precios[0][0]['total_inmuebles'] +
          $n_recervadas_precios[0][0]['total_inmuebles'] +
          $n_contrato_precios[0][0]['total_inmuebles'] +
          $n_escrituracion_precios[0][0]['total_inmuebles'] +
          $n_baja_precios[0][0]['total_inmuebles']
        )?>
      </div>
    </div>
    <div class="row mt-1">
      <div class="col-sm-4 col-lg-2 text-center">

          <div class="col-sm-12">
            Bloqueados
          </div>
          <div class="col-sm-12 number chips chips-bloqueados">
            <?= $n_bloqueadas_precios[0][0]['n_inmuebles'] ?> U 
          </div>
          <div class="col-sm-12 number chips chips-bloqueados mt-1">
            <?= "$".number_format($n_bloqueadas_precios[0][0]['total_inmuebles'])?>
          </div>
          
      </div>

      <div class="col-sm-4 col-lg-2 text-center">
        <div class="col-sm-12">
          Libres
        </div>
        <div class="col-sm-12 number chips chips-libres">
          <?= $n_liberadas_precios[0][0]['n_inmuebles'] ?> U
        </div>
        <div class="col-sm-12 number chips chips-libres mt-1">
          <?= "$".number_format($n_liberadas_precios[0][0]['total_inmuebles'])?>
        </div>
      </div>

      <div class="col-sm-4 col-lg-2 text-center">
        <div class="col-sm-12">
          Reservados
        </div>
        <div class="col-sm-12 number chips chips-reservas">
          <?= $n_recervadas_precios[0][0]['n_inmuebles'] ?> U
        </div>
        <div class="col-sm-12 number chips chips-reservas mt-1">
          <?= "$".number_format($n_recervadas_precios[0][0]['total_inmuebles'])?>
        </div>
      </div>
      
      <div class="col-sm-4 col-lg-2 text-center">
        <div class="col-sm-12">
          Contrato
        </div>
        <div class="col-sm-12 number chips chips-contratos">
          <?= $n_contrato_precios[0][0]['n_inmuebles'] ?> U
        </div>
        <div class="col-sm-12 number chips chips-contratos mt-1">
          <?= "$".number_format($n_contrato_precios[0][0]['total_inmuebles'])?>
        </div>
      </div>
      
      <div class="col-sm-4 col-lg-2 text-center">
        <div class="col-sm-12">
          Escrituración
        </div>
        <div class="col-sm-12 number chips chips-escrituraciones">
          <?= $n_escrituracion_precios[0][0]['n_inmuebles'] ?> U
        </div>
        <div class="col-sm-12 number chips chips-escrituraciones mt-1">
          <?= "$".number_format($n_escrituracion_precios[0][0]['total_inmuebles'])?>
        </div>
      </div>
      <div class="col-sm-4 col-lg-2 text-center">
        <div class="col-sm-12">
          Baja
        </div>
        <div class="col-sm-12 number chips chips-bajas">
          <?= $n_baja_precios[0][0]['n_inmuebles'] ?> U
        </div>
        <div class="col-sm-12 number chips chips-bajas mt-1">
          <?= "$".number_format($n_baja_precios[0][0]['total_inmuebles'])?>
        </div>
      </div>

    </div>
</div>

<div class="m-t-25">
  <div class="row mt-1">
    <div class="col-lg-6">
      <?= $this->element('Events/eventos_cards_reporte'); ?>
    </div>
    <div class="col-lg-6">
      <?= $this->element('Events/eventos_cards_acumulados'); ?>
    </div>
  </div>
</div>


<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_estatus') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/clientes_atencion') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_distribucion_inactivos') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_distribucion_inactivos_temporales') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/clientes_temperatura') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/ventas_vs_metas') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/ventas_vs_metas_dinero') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Ventas/ventas_acumuladas_asesores') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/ventas_acumuladas_dinero_q') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Clientes/clientes_linea_contacto') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Clientes/clientes_linea_contacto_visitas') ?>
</div>

<div class="m-t-25 salto">
  <?= $this->Element('Desarrollos/visitas_vs_ventas') ?>
</div>

<div class="m-t-25">
  <?= $this->Element('Desarrollos/publicidad_historica') ?>
</div>

<div class="m-t-25 salto">
  <div class="titulo_bloque">
    <i class="fa fa-building"></i> Listado de Ventas (<?= $periodo_reporte ?>)
  </div>
  <div class="row">
    <div class="col-sm-12 col-lg-6">
      Total monto $: <span id="rd_tot_monto_venta"></span>
    </div>
    <div class="col-sm-12 col-lg-6">
      Total unidades: <span id="rd_tot_unidades_venta"> <?= $rd_tot_unidades_venta = count($lista_ventas); ?> - U </span>
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
        $rd_tot_monto_venta=0;
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
      <?php $rd_tot_monto_venta += $venta_global['Venta']['precio_cerrado']; ?>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<script>
  document.getElementById("rd_tot_monto_venta").innerHTML = '<?= number_format($rd_tot_monto_venta); ?>';
</script>