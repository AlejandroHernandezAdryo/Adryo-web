<?php
  $tot_ventas = 0; $tot_visitas = 0;
  $var1 = 0; $var2 = 0;
  if( !empty($ventas_vs_visitas) ){
    
    foreach($ventas_vs_visitas as $venta){
      $tot_ventas += $venta['venta_mes_q'];
      $tot_visitas += $venta['visitas'];
    }

  }
?>
<style>
  #recuadro_naranja{
    width: 30px;
    height: 10px;
    background-color: #7CC3C4;
    display: inline-block;
  }
  #recuadro_verde{
    width: 30px;
    height: 10px;
    background-color: #5AB032;
    display: inline-block;
  }
  .fs-1{
    font-size: 1.2rem;
  }
</style>

<div class="card">
    <div class="card-header bg-blue-is">
      Ventas vs Visitas
    </div>
    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="graficas_ventas_visitas"></div>
                
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
    google.charts.setOnLoadCallback(graficaVentasVentas);

    
    function graficaVentasVentas(){
      var data = google.visualization.arrayToDataTable([
          ['Periodo', 'Ventas - <?= $tot_ventas ?>', {role: 'annotation'}, 'Visitas - <?= $tot_visitas ?>', {role: 'annotation'}],
          <?php if( empty($ventas_vs_visitas) ): ?>
            ['', 0,0,0,0]
          <?php else: ?>
            <?php foreach($ventas_vs_visitas as $venta): ?>
              ['<?= $venta['periodo'] ?>', <?= $venta['venta_mes_q'] ?>, <?= $venta['venta_mes_q'] ?>, <?= $venta['visitas'] ?>, <?= $venta['visitas'] ?>],
              <?php
                  if( $venta['venta_mes_q'] > $var1 OR $venta['visitas'] > $var1 ){
                      $var1 = $venta['visitas'];
                  }
              ?>
            <?php endforeach; ?>
          <?php endif; ?>
      ]);
   
   
        
        var classicOptions = {
          vAxes: 
          [
            {
              minValue: 0,
              title: 'Ventas / Visitas',
            },
          ],
          height:300,
          series: {
            0: {color: "#70AD47"},
            1: {color: "#7CC3C4"},
          },
          legend: { position: "top" },
          annotations: {
            alwaysOutside: true
          },
        };


  var classicChart = new google.visualization.ColumnChart(document.getElementById('graficas_ventas_visitas'));
  classicChart.draw(data, classicOptions);

}


</script>