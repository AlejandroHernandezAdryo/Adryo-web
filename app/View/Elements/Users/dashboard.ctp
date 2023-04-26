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
      'pages/colorpicker_hack',

      // Datatables
      '/vendors/select2/css/select2.min',
      '/vendors/datatables/css/scroller.bootstrap.min',
      '/vendors/datatables/css/colReorder.bootstrap.min',
      '/vendors/datatables/css/dataTables.bootstrap.min',
      'pages/dataTables.bootstrap',
        
      'pages/widgets',

    ),
    array('inline'=>false)); 
?>

<style>
  .success_bg_dark {background: #009973;}
</style>
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-sm-12 col-lg-8">
        <h3 class="nav_top_align text-white">
          <i class="fa fa-dashboard"></i> Tablero
        </h3>
        <p class="text-white">
          Bienvenido(a) a Adryo <?= $this->Session->read('Auth.User.nombre_completo')." ".date('d/M/Y H:i:s')?>
        </p>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner lter bg-container">
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-block">
              <div class="row">
                
                <div class="col-sm-12 col-lg-6">
                  <?= $this->Element('Cuentas/indicadores_mensuales') ?>
                </div>

                <div class="col-sm-12 col-lg-6">
                  <?= $this->Element('Cuentas/indicadores_anuales') ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Row, indicadores de desempeño -->
      <?= $this->element('Cuentas/kpi_cards'); ?>
      
      <div class="row mt-1"> 
        <div class="col-sm-12">
          <?= $this->element('Cuentas/eventos_kpis'); ?>
        </div>
      </div>


      <div class="row mt-1">
        <div class="col-sm-12 col-lg-12">
          <?= $this->Element('Clientes/clientes_estatus') ?>
        </div>
      </div>

      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_atencion') ?>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 mt-1">
          <?= $this->Element('Clientes/clientes_temperatura') ?>
        </div>
      </div>
      <!-- Grafica de atencion de clientes -->

      <div class="row mt-1">
        <div class="col-sm-12 col-lg-6">
          <?= $this->Element('Users/mensajes_gerenciales') ?>
        </div>

        <div class="col-sm-12 col-lg-6">
          <div class="card" style="min-height: 300px;">
            <div class="card-header bg-blue-is">
              Próximos eventos (15 días).
              <span class="float-xs-right">
                <small style="text-transform: uppercase;">
                  <i class=" fa fa-home"></i> Cita
                  <i class=" fa fa-phone"></i> Llamada
                  <i class=" fa fa-envelope"></i> Correo
                  <i class=" fa fa-check-circle"></i> Visita
                </small>
              </span>

            </div>
            <div class="card-block" style="overflow-y: scroll; height:300px !important; background-image: url('../img/fondo_trans.png'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
              <?= $this->element('Events/eventos_proximos'); ?>
            </div>
          </div>
        </div>
      </div>
      <!-- Mensajes gerenciales y proximos eventos --> 
      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Desarrollos/ventas_vs_metas') ?>
        </div>
      </div>

      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Desarrollos/ventas_vs_metas_dinero') ?>
        </div>
      </div>
      

      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto_mes') ?>
        </div>
      </div>
      
      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto') ?>
        </div>
      </div>
      
      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Clientes/clientes_linea_contacto_visitas') ?>
        </div>
      </div>

      

<!--      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Ventas/ventas_linea_contacto') ?>
        </div>
      </div>

      <div class="row mt-1">
        <div class="col-sm-12">
          <?= $this->Element('Ventas/n_ventas_linea_contacto') ?>
        </div>
      </div>-->







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
                    <div class="table-responsive" style="overflow-x: hidden">
                      <table class="table">
                        <tbody>
                          <?php foreach ($desarrollos_nuevos as $desarrollo): ?>
                            <tr>
                                <td style="width: 100px;height: 100px;background-size: cover;background-image: url('..<?= $desarrollo['FotoDesarrollo'][0]['ruta']?>')"></td>
                                <td>
                                    <b><?= $this->Html->link($desarrollo['Desarrollo']['nombre'], array('controller'=>'desarrollos', 'action'=>'view', $desarrollo['Desarrollo']['id'])); ?></b>
                                    <div class='row'>
                                        <div class=" col-sm-12 col-md-12">
                                            <table style='width:100%'>
                                                <tr>
                                                    <th style="width:25%"><?= $this->Html->image('m2.png',array('width'=>'40%'))?></th>
                                                    <th style="width:25%"><?= $this->Html->image('recamaras.png',array('width'=>'40%'))?></th>
                                                    <th style="width:25%"><?= $this->Html->image('banios.png',array('width'=>'40%'))?></th>
                                                    <th style="width:25%"><?= $this->Html->image('autos.png',array('width'=>'40%'))?></th>
                                                </tr>
                                                <tr>
                                                    <td><?= $desarrollo['Desarrollo']['m2_low']?>m<sup>2</sup> <?= ($desarrollo['Desarrollo']['m2_top']!=""||$desarrollo['Desarrollo']['m2_top']!=0 ? "-".$desarrollo['Desarrollo']['m2_top']."m<sup>2</sup>" : "")?></td>
                                                    <td><?= $desarrollo['Desarrollo']['rec_low']?> <?= ($desarrollo['Desarrollo']['rec_top']!=""||$desarrollo['Desarrollo']['rec_top']!=0 ? "-".$desarrollo['Desarrollo']['rec_top'] : "")?></td>
                                                    <td><?= $desarrollo['Desarrollo']['banio_low']?> <?= ($desarrollo['Desarrollo']['banio_top']!=""||$desarrollo['Desarrollo']['banio_top']!=0 ? "-".$desarrollo['Desarrollo']['banio_top'] : "")?></td>
                                                    <td><?= $desarrollo['Desarrollo']['est_low']?> <?= ($desarrollo['Desarrollo']['est_top']!=""||$desarrollo['Desarrollo']['est_top']!=0 ? "-".$desarrollo['Desarrollo']['est_top'] : "")?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
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
                        <div class="table-responsive" style="overflow-x: hidden">
                          <table class="table">
                            <thead>
                              <?php $id = 0;?>
                              <?php foreach ($propiedades_nuevas as $inmuebles): ?>
                                <?php if ($id != $inmuebles['inmuebles']['id']){?>
                                <tr>
                                    <td style="width: 100px;height: 100px;background-size: cover;background-image: url('..<?= $inmuebles['foto_inmuebles']['ruta']?>')"></td>
                                    <td>
                                        <b><?= $this->Html->link($inmuebles['inmuebles']['titulo'], array('controller'=>'inmuebles', 'action'=>'view', $inmuebles['inmuebles']['id'])); ?></b>
                                        <div class='row'>
                                            <div class=" col-sm-12 col-md-12">
                                                <table style='width:100%'>
                                                    <tr>
                                                        <th style="width:25%"><?= $this->Html->image('m2.png',array('width'=>'40%'))?></th>
                                                        <th style="width:25%"><?= $this->Html->image('recamaras.png',array('width'=>'40%'))?></th>
                                                        <th style="width:25%"><?= $this->Html->image('banios.png',array('width'=>'40%'))?></th>
                                                        <th style="width:25%"><?= $this->Html->image('autos.png',array('width'=>'40%'))?></th>
                                                    </tr>
                                                    <tr>
                                                        <td><?= intval($inmuebles['inmuebles']['construccion'])+intval($inmuebles['inmuebles']['construccion_no_habitable'])."m2"?> </td>
                                                        <td><?= intval($inmuebles['inmuebles']['recamaras'])?> </td>
                                                        <td><?= intval($inmuebles['inmuebles']['banos'])+intval($inmuebles['inmuebles']['medio_banos'])?> </td>
                                                        <td><?= intval($inmuebles['inmuebles']['estacionamiento_techado'])+intval($inmuebles['inmuebles']['estacionamiento_descubierto'])?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php $id = $inmuebles['inmuebles']['id'];}?>
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
        <div class="col-sm-12">
          <div class="card mt-1">
            <div class="card-header bg-blue-is">
              Mapeo de Desarrollos
            </div>
            <div class="card-block">
              <div id="map" style="width: 100%; height: 400px;" class="mt-1"></div>
            </div>
          </div>
        </div>
      </div> <!-- ./End row Google maps -->


    </div>
  </div>
</div>



<?php 
  echo $this->Html->script([
    'components',
    'custom',
    // Graficas de Google
    'https://www.gstatic.com/charts/loader.js',
    'https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0',

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
  size: new google.maps.Size(40,45),
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

</script>