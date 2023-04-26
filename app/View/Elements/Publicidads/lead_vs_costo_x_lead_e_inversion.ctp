<?php 
    $max_m1_6_1 = 0;
    $max_m1_6_2 = 0;
    $max_m1_6_3 = 0;
    foreach ($arreglo_grafica_m1_6 as $data){ 
        $max_m1_6_1 += $data['leads'];
        $max_m1_6_2 += $data['cxlead'];
        $max_m1_6_3 += $data['inversion'];
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
                <div id="lead_vs_costo_x_lead_e_inversion" class="grafica no-imprimir"></div>
                <div id="lead_vs_costo_x_lead_e_inversion_print" class="grafica imprimir"></div>
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
        ['Medio', 'Total Leads <?= number_format($max_m1_6_1,0)?>', {role: 'annotation'}, 'Costo Unitario x medio $ <?= number_format($max_m1_6_2,0)?>', {role: 'annotation'}, 'Total gasto (Miles de pesos) <?= number_format($max_m1_6_3/1000)?>', {role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_6) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_6 as $data):?>
                ['<?=$data['medio']?>', <?=$data['leads']?>, <?=$data['leads']?>, <?=$data['cxlead']?>,<?=$data['cxlead']?>, <?=$data['inversion']?>, <?=$data['inversion']?> ],
            <?php endforeach; ?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $max_m1_6_1 + 5 ?>,
           // title: 'Leads',
         }, 
         {
            minValue: 0,
            maxValue: <?= $max_m1_6_2 + 100 ?>,
            // title: '% de Meta cumplido',
         }
     ],
    series: {
        0: { // Leads
            type: "bars",
            targetAxisIndex: 0,
            color: "orange",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        1: { // Costo x Medio
            type: "bars",
            targetAxisIndex: 0,
            color: "purple",
            annotations: {
                textStyle: {
                    color: 'black',
                }
            }
        },
        2: {  // Tot Gasto
            type: "bars",
            targetAxisIndex: 1,
            color: "#FF9218",
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

    var chart = new google.visualization.ComboChart(document.getElementById('lead_vs_costo_x_lead_e_inversion'));
    var chart_div = document.getElementById('lead_vs_costo_x_lead_e_inversion_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
    chart.draw(data, options);
}
</script>