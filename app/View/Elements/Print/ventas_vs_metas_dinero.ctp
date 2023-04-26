<?php 
    $total_venta        = 0;
    $objetivo_acumulado = 0;
    $porcentaje         = 0;
    $titulo_total_venta = 0;

    foreach ($ventas_vs_metas_2 as $venta): 
        $total_venta        += $venta[0]['venta_mes']/1000000;
        $objetivo_acumulado += $venta[0]['objetivo_ventas']/1000000;
        $titulo_total_venta += number_format($venta[0]['venta_mes']/1000000,1);
    endforeach;

    if ($objetivo_acumulado!=0){
        $porcentaje = $total_venta/$objetivo_acumulado;
    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-calendar"></i> META VS. VENTAS ($ MONTO EN MDP)
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%; height: 350px">
        <div class="row">
            <div class="col-sm-12">
                <div id="metas_ventas_desarrollo_2" style="width: 80%; min-height: 300px;"></div>
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
        ['Month', 'Meta <?= number_format($objetivo_acumulado,0)?>', {role: 'annotation'}, 'Ventas <?= $titulo_total_venta ?> (MDP)', {role: 'annotation'}, 'Cumplido <?= number_format($porcentaje*100,0)?>%'],
        
        <?php if( empty($ventas_vs_metas_2) ): ?>
            ['', 0,0,0,0,0]
        <?php else: ?>
            <?php 
                foreach ($ventas_vs_metas_2 as $venta):
                    $porcentaje = 0;
                    $venta_mes = number_format($venta[0]['venta_mes']/1000000,1);
                    $objetivo_mes = number_format($venta[0]['objetivo_ventas']/1000000,1);
                    if($objetivo_mes == 0){
                        $porcentaje = 0;
                    }else{
                        $porcentaje = ($venta_mes/$objetivo_mes)*100;
                    }
                    // $porcentaje = ($venta_mes==0 ? 0 : );
            ?>
            ['<?= $venta[0]['periodo']?>', <?= $objetivo_mes?>,<?= $objetivo_mes?>, <?= $venta_mes?>, <?= $venta_mes ?>, <?= $porcentaje ?> ],
            <?php endforeach;?>
        <?php endif; ?>

     ]);

    var options = {
     vAxes: 
     [
         {
            minValue: 0,
            title: 'Meta / $ Monto (MDP )',
         }, 
         {
            minValue: 0,
            maxValue: 100,
            title: '% de Meta cumplido',
         }
     ],
     hAxis: {
         title: 'Periodo',
        //  titleTextStyle: {color: 'grey'},
        textStyle : {
            fontSize: 13,
            // fontName: 'Poppins',
        },
    },
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
            color: "#70AD47",
        },
        2: {  // % de cumplimiento
            type: "line",
            targetAxisIndex: 1,
            color: "#ED7D31"
        },
    },   
    annotations: {
        alwaysOutside: true,
    },
    legend:{
      textStyle:{
        fontSize: 13,
        fontName: 'Poppins',
        color: '#282828'
      }
    },
};

    var chart = new google.visualization.ComboChart(document.getElementById('metas_ventas_desarrollo_2'));
    chart.draw(data, options);
}
</script>