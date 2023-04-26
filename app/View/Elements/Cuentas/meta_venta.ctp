<div class="card">
    <div class="card-header bg-blue-is">
         META VS. VENTAS DEL MES 
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_metas_ventas" style="width: 100%; min-height:300px;"></div>
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

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(metas_ventas);


function metas_ventas() {
  var data = google.visualization.arrayToDataTable([
    ['Ventas', 'Q Ventas', { role: "style" }],
    ['Objetivo de ventas',     <?= $objetivo_venta_mensual[0]['objetivos_ventas_cuentas']['monto'] ?>, "#BFFA77"],
    ['Ventas Alcanzadas',      <?= $unidades_monto_venta_mensual['0']['0']['monto_venta'] ?>,"#70AD47"],
    
  ]);

  var options = {
    title: 'Meta de venta <?= $mes_actual ?>: $<?= number_format($objetivo_venta_mensual[0]['objetivos_ventas_cuentas']['monto'] ,0 )?>',
    height: 300,
    titleTextStyle:{
      fontSize: 16
    },
    pieHole: 0.2,
    series: {
      0: {
        color: '#BFFA77',
        textStyle:{color: '#323232'},
      },
      1: {
        color: '#70AD4',
      }
    },
    
    hAxis: {
      minValue: 0,
      maxValue: <?= $objetivo_venta_mensual[0]['objetivos_ventas_cuentas']['monto'] ?>,
    },

    backgroundColor:'transparent',
    legend:{
        textStyle:{
           fontSize: 13
        }
    },
  };

  var chart = new google.visualization.BarChart(document.getElementById('grafica_metas_ventas'));
  chart.draw(data, options);
}
</script>