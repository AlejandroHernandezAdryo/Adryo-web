<?php 
    $total_clientes = 0;
    if(!empty($clientes_asignados)){
        
        foreach ($clientes_asignados as $asignado): 
            $total_clientes += $asignado[0]['asignados'];
        endforeach;

    }
?>

<div class="card">
    <div class="card-header bg-blue-is">
        <div class="row">
            <div class="col-sm-12">
            <i class="fa fa-users"></i> CLIENTES ASIGNADOS POR MES
        </div>
    </div>
    </div>

    <div class="card-block" style="width: 100%; height: 330px">
        <div class="row">
            <div class="col-sm-12">
                <div id="clientes_asignados_mes" style="width: 80%; min-height: 300px;"></div>
            </div>
            <div class="col-sm-12 m-t-35 periodo_tiempo">
              <small><?= $periodo_tiempo ?></small>
            </div>
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
google.charts.setOnLoadCallback(drawAsignacionMes);

function drawAsignacionMes(){
    var data = google.visualization.arrayToDataTable([
        ['Periodo', '<?= number_format($total_clientes,0)?> Asignaciones', {role: 'annotation'}],
        
        <?php if( empty($clientes_asignados) ): ?>
            ['', 0,0]
        <?php else: ?>
            <?php foreach ($clientes_asignados as $asignado):?>
                ['<?= $asignado[0]['periodo']?>', <?= $asignado[0]['asignados']?>, <?= $asignado[0]['asignados'] ?>],
            <?php endforeach;?>
        <?php endif; ?>

     ]);

    var options = {
        
        vAxes: 
        [
            {
                minValue: 0,
                title: 'Clientes',
            }, 
        ],
        hAxis: {title: 'Periodo'},
        series: {
            0: { // Meta
                type: "bars",
                targetAxisIndex: 0,
                color: "#BFFA77"
            },
        },   
        backgroundColor:'transparent',
        legend:{
            position: 'top',
            textStyle:{
                fontSize: 13
            }
        },
        titleTextStyle:{
            fontSize: 11
        },
        chartArea: {width: '90%'},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('clientes_asignados_mes'));
    chart.draw(data, options);
}
</script>