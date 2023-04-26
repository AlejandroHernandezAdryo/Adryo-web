<?php 
    $total_venta = 0;
    $objetivo_acumulado = 0;
    $inicio_periodo = 0;
    $fin_periodo = 0;
    foreach ($kpi_arreglo_anual as $periodo): 
        if ($inicio_periodo == 0){
            $inicio_periodo = $periodo['periodo'];
        }
        $total_venta += $periodo['ventas_q'];
        $objetivo_acumulado += $periodo['objetivo_q'];
        $fin_periodo = $periodo['periodo'];
    endforeach;
    $var1 = 0;
    $var2 = 0;
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-calendar"></i> META VS. VENTAS (ÚLTIMO AÑO)
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="metas_ventas_anual_desarrollo" class="grafica no-imprimir"></div>
                <div id="metas_ventas_anual_desarrollo_print" class="grafica imprimir"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12"><small><?= 'INFORMACIÓN DEL'. $inicio_periodo." al ".$fin_periodo ?></small></div>
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
google.charts.setOnLoadCallback(drawVentasMetas);

function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Meta <?= number_format($objetivo_acumulado,0)?>', {role: 'annotation'}, 'Ventas <?= number_format($total_venta,0)?>', {role: 'annotation'}, 'Cumplido <?= number_format($total_venta/$objetivo_acumulado*100,1)?>%'],
        
        <?php if( empty($kpi_arreglo_anual) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php $porcentaje = 0; ?>
            <?php foreach ($kpi_arreglo_anual as $periodo):?>
                <?php
                    $porciento_grafica = 0;
                    if( !empty($periodo['ventas_q']) OR !empty( $periodo['objetivo_q'] ) ){
                        $porciento_grafica = ($periodo['ventas_q']/$periodo['objetivo_q'])*100;
                    }
                ?>
                ['<?= $periodo['periodo']?>', <?= $periodo['objetivo_q']?>, <?= $periodo['objetivo_q'] ?>, <?= $periodo['ventas_q']?>,<?= $periodo['ventas_q']?>, <?= $porciento_grafica ?> ],
                <?php
                    if( $periodo['ventas_q'] > $var1 ){
                        $var1 = $periodo['ventas_q'];
                    }
                    if( $porciento_grafica > $var2 ){
                        $var2 = $porciento_grafica;
                    }
                ?>
            <?php endforeach;?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            title: 'Unidades',
            maxValue: <?= $var1 + 5 ?>,
         }, 
         {
            minValue: 0,
            maxValue: <?= $var2 + 100 ?>,
            title: '% de Meta cumplido',
         }
     ],
     hAxis: {title: 'Periodo'},
    series: {
        0: { // Meta
            type: "bars",
            targetAxisIndex: 0,
            color: "#BFFA77",
            annotations: {
                textStyle: {
                    color: '#616161',
                }
            }
        },
        1: { // Real
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47"
        },
        2: {  // % de cumplimiento
            type: "line",
            targetAxisIndex: 1,
            color: "#ED7D31"
        },
    },   
    backgroundColor:'transparent',
    legend:{
      textStyle:{
          fontSize: 13
      }
    },
    titleTextStyle:{
        fontSize: 16
    },
    annotations: {
        alwaysOutside: true,
    },
};

    var chart = new google.visualization.ComboChart(document.getElementById('metas_ventas_anual_desarrollo'));
    var chart_div = document.getElementById('metas_ventas_anual_desarrollo_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
  chart.draw(data, options);
    chart.draw(data, options);
}
</script>