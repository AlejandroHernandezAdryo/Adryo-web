<?php 
    $total_venta = 0;
    $total_q_ventas = 0;
    foreach($ventas_vs_ventas as $venta):
        $total_venta += $venta[0]['venta_mes_q'];
        $total_q_ventas += number_format($venta[0]['venta_mes_dinero']/1000000, 1);
    endforeach;
    $var1 = 0;
    $var2 = 0;
?> 

<div class="card">
    <div class="card-header bg-blue-is">
        Ventas (Unidades y Monto en MDP )
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="graficas_ventas_ventas" style="width: 80%; min-height:300px;"></div>
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
      <?php if( empty($ventas_vs_ventas) ): ?>
        ['', 0,0,0,0]
      <?php else: ?>
        <?php  foreach($ventas_vs_ventas as $venta): ?>
          ['<?= $venta[0]['periodo'] ?>', <?= $venta[0]['venta_mes_q'] ?>, <?= $venta[0]['venta_mes_q'] ?>, <?= number_format($venta[0]['venta_mes_dinero']/1000000, 1) ?>, <?= number_format($venta[0]['venta_mes_dinero']/1000000,1) ?>],
          <?php
              if( $venta[0]['venta_mes_q'] > $var1 ){
                  $var1 = $venta[0]['venta_mes_q'];
              }
              if( $venta[0]['venta_mes_dinero'] > $var2 ){
                  $var2 = number_format($venta[0]['venta_mes_dinero']/1000000,1);
              }
          ?>
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);
   
   
        
        var classicOptions = {
          bar: {groupWidth: "90%"},
          height:300,
          series: {
            0: {targetAxisIndex: 0, color: "orange"},
            1: {targetAxisIndex: 1, color: "#70AD47"},
           
          },
          vAxes: {
            // Adds titles to each axis.
            0: {
              maxValue: <?= $var1 + 1 ?>,
              title: 'Ingresos en (MDP)',
              textStyle:{color: '#616161'
              },
              titleTextStyle:{
                color: '#616161'
                }
            },
            1: {
              maxValue: <?= $var2 + 1 ?>,
              title: 'Unidades'
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