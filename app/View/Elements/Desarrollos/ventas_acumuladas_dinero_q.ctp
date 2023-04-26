<?php 
    $total_venta = 0;
    $total_q_ventas = 0;
    foreach($kpi_arreglo as $periodo):
        $total_venta += $periodo['ventas_q'];
        $total_q_ventas += number_format($periodo['ventas_monto']/1000000, 1);
    endforeach;
    $var1 = 0;
    $var2 = 0;
?> 

<div class="card">
    <div class="card-header bg-blue-is">
        VENTAS EN UNIDADES Y MONTO EN MDP
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="graficas_ventas_ventas" ></div>
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
      ['Periodo', 'Unidades - <?= $total_venta ?>', {role: 'annotation'}, 'Monto - <?= $total_q_ventas ?> MDP', {role: 'annotation'}],
      <?php if( empty($kpi_arreglo) ): ?>
        ['', 0,0,0,0]
      <?php else: ?>
        <?php  foreach($kpi_arreglo as $periodo): ?>
          ['<?= $periodo['periodo'] ?>', <?= $periodo['ventas_q'] ?>, <?= $periodo['ventas_q'] ?>, <?= number_format($periodo['ventas_monto']/1000000, 1) ?>, <?= number_format($periodo['ventas_monto']/1000000,1) ?>],
          <?php
              if( $periodo['ventas_q'] > $var1 ){
                  $var1 = $periodo['ventas_q'];
              }
              if( $periodo['ventas_monto'] > $var2 ){
                  $var2 = number_format($periodo['ventas_monto']/1000000,1);
              }
          ?>
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);
   
   
        
        var classicOptions = {
          bar: {groupWidth: "90%"},
          height:300,
          series: {
            0: {targetAxisIndex: 0, color: "#70AD47",annotations: {
                    textStyle: {
                        color: '#616161',
                    }
                }},
            1: {targetAxisIndex: 1, color: "#BFFA77",annotations: {
                    textStyle: {
                        color: '#616161',
                    }
                }},
           
          },
          vAxes: {
            // Adds titles to each axis.
            0: {
              maxValue: <?= $var1 + 1 ?>,
              title: 'Ingresos en (MDP)',

            },
            1: {
              maxValue: <?= $var2 + 1 ?>,
              title: 'Unidades',

            },
          },
          annotations: {
            alwaysOutside: true,
          },
        };

 var classicChart = new google.visualization.ColumnChart(document.getElementById('graficas_ventas_ventas'));
 
 classicChart.draw(data, classicOptions);

}
</script>