<?php 
    $max_m1_1 = 0;
    $max_m1_2 = 0;
    $max_m1_3 = 0;
    foreach ($arreglo_grafica_m1_2 as $venta){ 
        $max_m1_1 += $venta['leads'];
        $max_m1_2 += $venta['ventas'];
        $max_m1_3 += $venta['inversion'];
    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            TOTAL DE LEADS VS VENTAS E INVERSIÓN POR MEDIO DE PROMOCIÓN
        </div>
    </div>
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="metas_ventas_desarrollo" class="grafica no-imprimir"></div>
                <div id="metas_ventas_desarrollo_print" class="grafica imprimir"></div>
            </div>
        </div>
        <div class="row">
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
google.charts.setOnLoadCallback(drawVentasMetas);

function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Leads', 'Leads <?= number_format($max_m1_1,0)?>', {role: 'annotation'}, 'Ventas <?= number_format($max_m1_2,0)?>', {role: 'annotation'}, 'Inversión (Miles de pesos) <?= number_format($max_m1_3/1000,0)?>', {role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_2) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_2 as $data):?>
                ['<?=$data['medio']?>', <?=$data['leads']?>, <?=$data['leads']?>, <?=$data['ventas']?>,<?=$data['ventas']?>, <?=$data['inversion']?>, <?=$data['inversion']?> ],
            <?php endforeach; ?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $max_m1_1 + 5 ?>,
             title: 'Leads y Ventas',
         }, 
         {
            minValue: 0,
            maxValue: <?= $max_m1_2 + 100 ?>,
             title: 'Inversión',
         }
     ],
    series: {
        0: { // Meta
            type: "bars",
            targetAxisIndex: 0,
            color: "orange",
            annotations: {
                textStyle: {
                    color: '#676666',
                }
            }
        },
        1: { // Real
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47",
            annotations: {
                textStyle: {
                    color: '#676666',
                }
            }
        },
        2: {  // % de cumplimiento
            type: "bars",
            targetAxisIndex: 1,
            color: "purple",
            annotations: {
                textStyle: {
                    color: '#676666',
                }
            }
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

    var chart = new google.visualization.ComboChart(document.getElementById('metas_ventas_desarrollo'));
    var chart_div = document.getElementById('metas_ventas_desarrollo_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
    chart.draw(data, options);
}
</script>