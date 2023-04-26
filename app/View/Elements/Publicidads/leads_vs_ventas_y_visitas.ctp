<?php 
    $max_m1_3_1 = 0;
    $max_m1_3_2 = 0;
    $max_m1_3_3 = 0;
    foreach ($arreglo_grafica_m1_3 as $data){ 
        $max_m1_3_1 += $data['ventas'];
        $max_m1_3_2 += $data['visistas'];
        $max_m1_3_3 += $data['leads'];
    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            TOTAL DE LEADS VS VENTAS Y VISITAS POR MEDIO DE PROMOCIÓN
        </div>
    </div>
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="leads_vs_ventas_y_visitas" class="grafica no-imprimir"></div>
                <div id="leads_vs_ventas_y_visitas_print" class="grafica imprimir"></div>
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
        ['Ventas', 'Ventas <?= number_format($max_m1_3_1,0)?>', {role: 'annotation'}, 'Visitas <?= number_format($max_m1_3_2,0)?>', {role: 'annotation'}, 'Leads <?= number_format($max_m1_3_3)?>', {role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_3) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_3 as $data):?>
                ['<?=$data['medio']?>', <?=$data['ventas']?>, <?=$data['ventas']?>, <?=$data['visistas']?>,<?=$data['visistas']?>, <?=$data['leads']?>, <?=$data['leads']?> ],
            <?php endforeach; ?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $max_m1_3_1 + 5 ?>,
             title: 'Ventas y Visitas',
         }, 
         {
            minValue: 0,
            maxValue: <?= $max_m1_3_2 + 100 ?>,
             title: 'Leads',
         }
     ],
    series: {
        0: { // Ventas
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        1: { // Visitas
            type: "bars",
            targetAxisIndex: 0,
            
            color: "#7CC3C4",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        2: {  // Leads
            type: "bars",
            targetAxisIndex: 1,
            color: "orange",
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

    var chart = new google.visualization.ComboChart(document.getElementById('leads_vs_ventas_y_visitas'));
    var chart_div = document.getElementById('leads_vs_ventas_y_visitas_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
    chart.draw(data, options);
}
</script>