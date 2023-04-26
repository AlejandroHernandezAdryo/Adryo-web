<?php
    $total_venta = 0;
    $objetivo_acumulado = 0;
    foreach ($kpi_arreglo as $asesor):
        $total_venta += $asesor['ventas_monto'];
        $objetivo_acumulado += $asesor['objetivo_monto'];
    endforeach;
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-calendar"></i> META VS. VENTAS (MONTO)
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="metas_ventas_desarrollo_2" class="grafica no-imprimir"></div>
                <div id="metas_ventas_desarrollo_2_print" class="grafica imprimir"></div>
            </div>
        </div>
        <div class="row">
            <small><?= $periodo_tiempo ?></small>
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
google.charts.setOnLoadCallback(drawVentasMetasMonto);

function drawVentasMetasMonto(){
    var data = google.visualization.arrayToDataTable([
        ['Asesor', 'Meta <?= number_format($objetivo_acumulado/1000000,1)?>','Venta <?= number_format($total_venta/1000000,1)?>','% Cumplimiento <?= number_format(($total_venta/$objetivo_acumulado)*100,2)?>']
        <?php
            foreach($kpi_arreglo as $asesor){
                echo ",['".$asesor['asesor']."',".$asesor['objetivo_monto'].",".$asesor['ventas_monto'].",".($asesor['objetivo_monto']==0 ? 0 : $asesor['ventas_monto']/$asesor['objetivo_monto']*100)."]";
            }
        ?>
     ]);

    var options = {
    // title : 'Metas Vs Ventas por mes',
    //             vAxis: {title: 'Monto $'},

     hAxis: {
         title: 'Asesor',
         textStyle : {
             fontSize: 10 // or the number you want
         }
     },
    //             seriesType: 'bars',
    // height: 300,
    //series: {},
    //             series: {
    //                0: {
    //                    targetAxisIndex: 0 // use the left axis
    //                },
    //                1: {
    //                    targetAxisIndex: 1 // use the right axis
    //                },
    //                2: {type: 'line'}
    //            },
    series: {
        0: { // Meta
            type: "bars",
            targetAxisIndex: 0,
            color: "#BFFA77",
            annotations: {
                textStyle: {
                    color: '#616161',
                    fontSize: 12
                }
            }
        },
        1: { // Real
            type: "bars",
            targetAxisIndex: 0,
            color: "#70AD47",
            fontSize: 12
        },
        2: {  // % de cumplimiento
            type: "line",
            targetAxisIndex: 1,
            color: "#ED7D31",
            fontSize: 12
        },
    },
    backgroundColor:'transparent',
    legend:{
      textStyle:{
          fontSize: 12
      }
    },
    titleTextStyle:{
        fontSize: 16
    },
    annotations: {
        alwaysOutside: true,
    },
};

    var chart = new google.visualization.ComboChart(document.getElementById('metas_ventas_desarrollo_2'));
    var chart_div = document.getElementById('metas_ventas_desarrollo_2_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
  chart.draw(data, options);
    chart.draw(data, options);
}
</script>