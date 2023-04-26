<?php
  // Definición de las variables
  // para el calculo de los datos
  $tot_ar_aisgnados         = 0;
  $tot_ar_reasignados_mas   = 0;
  $tot_ar_reasignados_menos = 0;
  $tot_ar_total             = 0;

  if( !empty($asingados_reasignados) ){
    
    foreach($asingados_reasignados as $periodo){
        
      $tot_ar_aisgnados         += $periodo['asignados_actuales'];
      $tot_ar_reasignados_mas   += $periodo['asignados'];
      $tot_ar_reasignados_menos += $periodo['reasignados'];
      $tot_ar_total             += $periodo['asignados_actuales'] + $periodo['asignados'] - $periodo['reasignados'];
  
    };

  }

?>
<style>
  .legend{
    display: inline-block;
    margin: 5px;
    font-size: 1.1rem;
  }

  #cuadro_ar__asignados {
    width: 30px;
    height: 12px;
    background-color: #033280;
    display: inline-block;
  }
  #cuadro_ar__reasignados_mas {
    width: 30px;
    height: 12px;
    background-color: #04660c;
    display: inline-block;
  }
  #cuadro_ar__reasignados_menos {
    width: 30px;
    height: 12px;
    background-color: #66040e;
    display: inline-block;
  }
  #cuadro_ar__total {
    width: 30px;
    height: 12px;
    background-color: #02a119;
    display: inline-block;
  }

</style>
<div class="card">
    <div class="card-header bg-blue-is">
        Clientes Asignados Vs Reasignados
    </div>

    <div class="card-block" style="width: 100%; height: 375px">
        <div class="row">
            <div class="col-sm-12">
                <div id="graficas_asginados_reasignados" style="width: 80%; min-height:300px;"></div>
            </div>
            <div class="col-sm-12 m-t-35 periodo_tiempo">
              <small><?= $periodo_tiempo ?></small>
            </div>
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
    google.charts.setOnLoadCallback(graficaAsginadosReasignados);

    
    function graficaAsginadosReasignados(){
      var data = google.visualization.arrayToDataTable([
        ['Periodo', 'Asignados <?= number_format($tot_ar_aisgnados,0)?> ', {role: 'annotation'}, 'Reasignados(+) <?= number_format($tot_ar_reasignados_mas,0)?> ', {role: 'annotation'}, 'Reasignados(-) <?= number_format($tot_ar_reasignados_menos,0)?>', {role: 'annotation'}, 'Total <?= number_format($tot_ar_total,0)?>', {role: 'annotation'}],
        <?php if( empty($asingados_reasignados) ): ?>
          ['', 0,0,0,0,0,0]
        <?php else: ?>
          <?php  foreach($asingados_reasignados as $periodo): ?>
            ['<?= $periodo['periodo'] ?>', <?= $periodo['asignados_actuales'] ?>, <?= $periodo['asignados_actuales'] ?>, <?= $periodo['asignados'] ?>, <?= $periodo['asignados'] ?>, <?= $periodo['reasignados'] ?>, <?= $periodo['reasignados'] ?>,<?= ($periodo['asignados_actuales'] + $periodo['asignados']-$periodo['reasignados']) ?>, <?= ($periodo['asignados_actuales'] + $periodo['asignados'] - $periodo['reasignados']) ?>],
          <?php endforeach; ?>
        <?php endif; ?>
        
    ]);
   
   
        
    var classicOptions = {
      series: {
        0: {color: "#033280"},
        1: {color: "#04660c"},
        2: {color: "#66040e"},
        3: {color: "#02a119"},
      
      },
      chartArea: {width: '100%'},
      legend: { position:'bottom' }
  };

  var classicChart = new google.visualization.ColumnChart(document.getElementById('graficas_asginados_reasignados'));
  classicChart.draw(data, classicOptions);
}
</script>