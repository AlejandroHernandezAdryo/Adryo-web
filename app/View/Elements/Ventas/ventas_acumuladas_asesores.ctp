<?php 
    $total_venta = 0;
    $total_q_ventas = 0;
    foreach($ventas_asesores_arreglo as $venta):
        $total_venta += $venta['venta_v']/1000000;
        $total_q_ventas += $venta['venta_q'];
    endforeach;
    $var1 = 0;
    $var2 = 0;
?> 

<div class="card">
    <div class="card-header bg-blue-is">
        Ventas Por asesor
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_ventas_asesor" style="width: 100%; min-height:600px;"></div>
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
    google.charts.setOnLoadCallback(graficaVentasAsesor);

    
    function graficaVentasAsesor(){
  var data = google.visualization.arrayToDataTable([
      ['Asesor', 'Ventas (Monto): $<?= number_format($total_venta,1)?> MDP', {role: 'annotation'}, 'Ventas (Unidades): <?= $total_q_ventas?>', {role: 'annotation'}],
      <?php if( empty($ventas_asesores_arreglo) ): ?>
        ['', 0,0,0,0]
      <?php else: ?>
        <?php  foreach($ventas_asesores_arreglo as $venta): ?>
          <?php $total_venta += $venta['venta_v']?>
          ['<?= $venta['asesor'] ?>', <?= number_format($venta['venta_v']/1000000,1) ?>, <?= number_format($venta['venta_v']/1000000,1) ?>, <?= $venta['venta_q'] ?>, <?= $venta['venta_q'] ?>],
          <?php
              if( $venta['venta_v'] > $var1 ){
                  $var1 = $venta['venta_v']/1000000;
              }
              if( $venta['venta_q'] > $var2 ){
                  $var2 = $venta['venta_q'];
              }
          ?>
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);
   
   
        
        var classicOptions = {
          orientation: 'vertical',
          legend: { position: "right" },
          chartArea: {
            width: '60%',
            height: '90%',
          },
          width: '100%',
          top: 0,
          series: {
            0: {targetAxisIndex: 0, color: "#BFFA77",annotations: {
                    textStyle: {
                        color: '#616161',
                    }
                }},
            1: {targetAxisIndex: 1, color: "#70AD47",annotations: {
                    textStyle: {
                        color: '#616161',
                    }
                }},
          },
          vAxes: {
            // Adds titles to each axis.
            0: {
              minValue: 0,
              title: 'Asesores',
              textStyle:{
                color: '#616161',
                fontSize: 9
              },
              titleTextStyle:{color: '#616161'}
              },
          },
          hAxis: { 
              slantedText: true, 
              slantedTextAngle: 60,
              maxTextLines: 3,
              textStyle: {
                fontSize: 10,
              }
          },
          annotations: {
            alwaysOutside: true,
          },
        };

 var classicChart = new google.visualization.ColumnChart(document.getElementById('grafica_ventas_asesor'));
 classicChart.draw(data, classicOptions);

}
</script>