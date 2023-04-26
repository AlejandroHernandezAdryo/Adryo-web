<?php 
    $maxLeads     = 0;
    $maxInversion = 0;
    foreach($arreglo_grafica_m1_1 as $data ){
        // if($maxLeads > $data['leads']){
            $maxLeads += $data['leads'];
        // }
        // if($maxInversion > $data['inversion']){
            $maxInversion += $data['inversion'];
        // }
    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            TOTAL INVERSIÓN EN PUBLICIDAD VS TOTAL DE LEADS POR DESARROLLO(S) SELECCIONADO(S)
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="metasventas" class="grafica no-imprimir"></div>
                <div id="metasventas_print" class="grafica imprimir"></div>
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
google.charts.setOnLoadCallback(drawVentasMetas);

function drawVentasMetas(){
    var data = google.visualization.arrayToDataTable([
        ['Desarrollo', 'Leads <?= $maxLeads ?>', {role: 'annotation'}, 'Inversion (Miles de pesos) <?= number_format($maxInversion / 1000, 0) ?>',{role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_1) ): ?>
            ['', 0,0],
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_1 as $data): ?>
                ["<?= $data['desarrollo']?>", <?= $data['leads'] ?>, <?= $data['leads'] ?>, <?= $data['inversion'] ?>, <?= $data['inversion'] ?>],
            <?php endforeach;?>
        <?php endif; ?>
     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            maxValue: <?= $maxLeads ?>,
            title: 'Leads',
         }, 
         {
            minValue: 0,
            maxValue: <?= $maxInversion ?>,
            title: 'Inversion',
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
        1: {  // Inversion
            type: "bars",
            targetAxisIndex: 1,
            color: "purple",
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

    var chart = new google.visualization.ComboChart(document.getElementById('metasventas'));
    var chart_div = document.getElementById('metasventas_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });

    chart.draw(data, options);

    


}
</script>