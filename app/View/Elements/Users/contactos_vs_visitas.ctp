<?php
  $cv_total_visitas   = 0;
  $cv_total_contactos = 0;
?>
<style>
    #recuadro_naranja{
        width: 30px;
        height: 10px;
        background-color: orange;
        display: inline-block;
    }
    #recuadro_verde{
        width: 30px;
        height: 10px;
        background-color: #7CC3C4;
        display: inline-block;
    }
    .fs-1{
        font-size: 1.2rem;
    }
</style>
<div class="card">
    <div class="card-header bg-blue-is">
        Contactos vs Visitas
    </div>

    <div class="card-block">

      <div class="row">
        <div class="col-sm-12 col-lg-6 text-center">
          <span id="recuadro_naranja"></span> Total de Contactos: <span id="cv_total_contactos"></span>
        </div>
        <div class="col-sm-12 col-lg-6 text-center">
          <span id="recuadro_verde"></span> Total de Visitas: <span id="cv_total_visitas"></span>
        </div>
      </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="graficas_contactos_visitas" style="width: 100%; min-height:300px;"></div>
            </div>
            <div class="col-sm-12"><small><?= $periodo_tiempo ?></small></div>
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

  ], array('inline'=>false));
?>

<script>

    google.charts.load('current', {'packages':['corechart','bar']});
    google.charts.setOnLoadCallback(graficaContactosVisitas);

    
    function graficaContactosVisitas(){
  var data = google.visualization.arrayToDataTable([
      ['Periodo', 'Contactos', {role: 'annotation'}, 'Visitas', {role: 'annotation'}],
      <?php if( empty($contactos_vs_visitas) ): ?>
        ['', 0,0,0,0]
      <?php else: ?>
        <?php  foreach($contactos_vs_visitas as $periodo): ?>
          ['<?= $periodo['periodo'] ?>', <?= $periodo['contactos'] ?>, <?= $periodo['contactos'] ?>, <?= $periodo['visitas'] ?>, <?= $periodo['visitas'] ?>],
          <?php 
            $cv_total_visitas  += $periodo['visitas'];
            $cv_total_contactos += $periodo['contactos'];
          ?>
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);
   
   
        
  var classicOptions = {
    vAxes: 
    [
      {
        minValue: 0,
        title: 'Contactos / Visitas',
      }, 
    ],
    height:300,
    series: {
      0: {color: "orange"},
      1: {color: "#7CC3C4"},
    },
    legend: { position: "none" }
  };

  var classicChart = new google.visualization.ColumnChart(document.getElementById('graficas_contactos_visitas'));
  classicChart.draw(data, classicOptions);
  document.getElementById("cv_total_visitas").innerHTML = '<?= $cv_total_visitas ?>';
  document.getElementById("cv_total_contactos").innerHTML = '<?= $cv_total_contactos ?>';

}
</script>