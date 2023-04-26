<?php 
    $total_venta = 0;
    $objetivo_acumulado = 0;
    foreach ($ventas_vs_metas as $venta): 
        $total_venta += $venta[0]['venta_mes'];
        $objetivo_acumulado += $venta[0]['objetivo_ventas'];
    endforeach;
    $var1 = 0;
    $var2 = 0;
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-calendar"></i> META VS. VENTAS
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%; height: 350px">
        <div class="row">
            <div class="col-sm-12">
                <div id="metas_ventas_desarrollo" style="width: 80%; min-height: 300px;"></div>
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
        ['Month', 'Meta <?= number_format($objetivo_acumulado,0)?>', {role: 'annotation'}, 'Ventas <?= number_format($total_venta,0)?>', {role: 'annotation'}, 'Cumplido <?= number_format($total_venta/$objetivo_acumulado*100,1)?>%'],
        
        <?php if( empty($ventas_vs_metas) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php $porcentaje = 0; ?>
            <?php foreach ($ventas_vs_metas as $venta):?>
                ['<?= $venta[0]['periodo']?>', <?= $venta[0]['objetivo_ventas']?>, <?= $venta[0]['objetivo_ventas'] ?>, <?= $venta[0]['venta_mes']?>,<?= $venta[0]['venta_mes']?>, <?php $porciento_grafica = ($venta[0]['venta_mes']/$venta[0]['objetivo_ventas'])*100; echo $porciento_grafica;  ?> ],
                <?php
                    if( $venta[0]['venta_mes'] > $var1 ){
                        $var1 = $venta[0]['venta_mes'];
                    }
                    if( $porciento_grafica > $var2 ){
                        $var2 = $porciento_grafica;
                    }
                ?>
            <?php endforeach;?>
        <?php endif; ?>

     ]);

    var options = {
    // title : 'Metas Vs Ventas por mes',
    //             vAxis: {title: 'Monto $'},
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

    var chart = new google.visualization.ComboChart(document.getElementById('metas_ventas_desarrollo'));
    chart.draw(data, options);
}
</script>