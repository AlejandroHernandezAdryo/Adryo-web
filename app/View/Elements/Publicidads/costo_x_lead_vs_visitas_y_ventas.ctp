<?php 
    $max_m1_5_1 = 0;
    $max_m1_5_2 = 0;
    $max_m1_5_3 = 0;
    foreach ($arreglo_grafica_m1_5 as $data){ 
        $max_m1_5_1 += $data['ventas'];
        $max_m1_5_2 += $data['visitas'];
        $max_m1_5_3 += $data['cxlead'];
    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            COSTO POR LEAD VS VENTAS Y VISITAS POR MEDIO DE PROMOCIÓN
        </div>
    </div>
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="costo_x_lead_vs_visitas_y_ventas" class="grafica no-imprimir"></div>
                <div id="costo_x_lead_vs_visitas_y_ventas_print" class="grafica imprimir"></div>
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
        ['Medio', 'Ventas <?= number_format($max_m1_5_1,0)?>', {role: 'annotation'}, 'Visitas <?= number_format($max_m1_5_2,0)?>', {role: 'annotation'}, 'Costo X Lead (Prom. <?= number_format($max_m1_5_3/sizeof($arreglo_grafica_m1_5),2)?>)', {role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_5) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_5 as $data):?>
                ['<?=$data['medio']?>', <?=$data['ventas']?>, <?=$data['ventas']?>, <?=$data['visitas']?>,<?=$data['visitas']?>, <?=$data['cxlead']?>, <?=$data['cxlead']?> ],
            <?php endforeach; ?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $max_m1_5_1 + 5 ?>,
             title: 'Ventas y Visitas',
         }, 
         {
            minValue: 0,
            maxValue: <?= $max_m1_5_2 + 100 ?>,
             title: 'Costo por Lead',
         }
     ],
    series: {
        0: { // Venta
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        1: { // Visita
            type: "bars",
            targetAxisIndex: 0,
            color: "#7CC3C4",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        2: {  // Costo X Lead
            type: "bars",
            targetAxisIndex: 0,
            color: "#2950A8",
            annotations: {
                textStyle: {
                    color: 'black',
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

    var chart = new google.visualization.ComboChart(document.getElementById('costo_x_lead_vs_visitas_y_ventas'));
    var chart_div = document.getElementById('costo_x_lead_vs_visitas_y_ventas_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
    chart.draw(data, options);
}
</script>