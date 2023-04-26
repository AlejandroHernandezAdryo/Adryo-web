<?php 
    $max_m1_4_1     = 0;
    $max_m1_4_2 = 0;
    foreach($arreglo_grafica_m1_4 as $data ){
        // if($max_m1_4_1 > $data['leads']){
            $max_m1_4_1 += $data['leads'];
        // }
        // if($max_m1_4_2 > $data['inversion']){
            $max_m1_4_2 += $data['cxlead'];
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
                <div id="lead_vs_tot_leads_x_medio" class="grafica no-imprimir"></div>
                <div id="lead_vs_tot_leads_x_medio_print" class="grafica imprimir"></div>
            </div>
            <div class="col-sm-12 periodo_tiempo"><small><?= $periodo_tiempo ?></small></div>
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
        ['Desarrollo', 'LEAD <?= $max_m1_4_1 ?>', {role: 'annotation'}, 'COSTO X LEAD (Prom. <?= number_format($max_m1_4_2/sizeof($arreglo_grafica_m1_4), 2) ?>)',{role: 'annotation'}],
        
        <?php if( empty($arreglo_grafica_m1_4) ): ?>
            ['', 0,0],
        <?php else: ?>
            <?php foreach ($arreglo_grafica_m1_4 as $data): ?>
                ["<?= $data['medio']?>", <?= $data['leads'] ?>, <?= $data['leads'] ?>, <?= $data['cxlead'] ?>, <?= $data['cxlead'] ?>],
            <?php endforeach;?>
        <?php endif; ?>
     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            title: 'Leads',
         }, 
         {
            minValue: 0,
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
    }
};

    var chart = new google.visualization.ComboChart(document.getElementById('lead_vs_tot_leads_x_medio'));
    var chart_div = document.getElementById('lead_vs_tot_leads_x_medio_print');
    // Wait for the chart to finish drawing before calling the getImageURI() method.
    google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
    chart.draw(data, options);
}
</script>