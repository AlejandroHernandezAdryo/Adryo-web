<?php 
    $maximo = 0;
    $meta_mes = 0;
    $total_venta = 0;
    $total_objetivos = 0;
    foreach ($ventas_vs_metas as $venta): 
        $total_venta += $venta[0]['ventas_mes'];
        $total_objetivos += $venta['cuentas_users']['monto'];
    endforeach;
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-calendar"></i> Meta VS Ventas del mes
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%; height: 430px">
        <div class="row">
            <div class="col-sm-12">
                <div id="metasventas" style="width: 100%; min-height: 300px;"></div>
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
        ['Month', 'Meta Acumulada <?= number_format($total_objetivos,2) ?>', {role: 'annotation'}, 'Ventas <?= number_format($total_venta,2)?>', {role: 'annotation'}, '% Cumplido'],
        
        <?php if( empty($ventas_vs_metas) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php foreach ($ventas_vs_metas as $venta): ?>
            
                <?php $var1 = ($venta[0]['ventas_mes'] / $venta['cuentas_users']['monto']) * 100; ?>
                <?php $maximo += $venta[0]['ventas_mes']; ?>
                <?php $meta_mes += $venta['cuentas_users']['monto']; ?>

                ['<?= $venta[0]['periodo']?>', <?= $venta['cuentas_users']['monto'] ?>, <?= $venta['cuentas_users']['monto'] ?>, <?= $venta[0]['ventas_mes']?>,<?= $venta[0]['ventas_mes']?>, <?= $var1 ?>, ],
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
            maxValue: <?= $meta_mes?>,
            title: 'Monto $',
         }, 
         {
            minValue: 0,
            maxValue: 100,
            title: '% de Meta complido',
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
            color: "#BFFA77"
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
};

    var chart = new google.visualization.ComboChart(document.getElementById('metasventas'));
    chart.draw(data, options);
}
</script>