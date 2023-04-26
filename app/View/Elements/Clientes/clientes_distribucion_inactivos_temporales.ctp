
<?php
  $total = 0;
  foreach( $inactivos_temporal_distribucion as $inactivoTemp){
    $total += $inactivoTemp;
  }
?>
<div class="card">
    <div class="card-header bg-blue-is">
        RAZONES DE INACTIVACIÓN TEMPORAL DE CLIENTES
        <span style="float:right">
            Total: <span id="sumatorioDistribucionInactivosTemporales"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%; height: 420px;">
      <div class="row">
        <div class="col-sm-12">
          <div id="grafica_distribucion_inactivos_temporales" class="grafica no-imprimir"></div>
          <div id="grafica_distribucion_inactivos_temporales_print" class="grafica imprimir"></div>
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
    google.charts.setOnLoadCallback(inactivos_clientes);

function inactivos_clientes(){
  var data = google.visualization.arrayToDataTable([
    ["Motivo Inactivación", "Cantidad"],
    <?php
    if( $total==0 ){
      echo "['Sin información - (0)', 100],";
    } else {
        foreach( $inactivos_temporal_distribucion as $key=>$inactivo){
          echo "[ '".$key." (".$inactivo.")', ".$inactivo."],";
        }
        if (isset($clientes_anuales) && $clientes_anuales[2][0]['total_clientes'] >= $total){
          $clientes_inactivos_temp = $clientes_anuales[2][0]['total_clientes'] - $total;
          echo "[ 'Sin Razón registrada (".$clientes_inactivos_temp.")', ".$clientes_inactivos_temp."],";
          $total = $clientes_inactivos_temp + $total;
        }
      }
    ?>

  ]);

  var options = {
    chartArea:{left:0,top:'30',width:'100%',height:'300'},
    legend:{position: 'right', textStyle: {fontSize: 14, color: '#4b4b4b'}},
    height: 350,
    widht: '100%',
    pieHole: 0.6,
    pieStartAngle: 100,
    pieSliceText: 'value',
  };

  //var chart = new google.visualization.PieChart(document.getElementById('grafica_inactivos_clientes'));
  var chart = new google.visualization.PieChart(document.getElementById('grafica_distribucion_inactivos_temporales'));
  var chart_div = document.getElementById('grafica_distribucion_inactivos_temporales_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
  chart.draw(data, options);
}
document.getElementById("sumatorioDistribucionInactivosTemporales").innerHTML = '<?= number_format($total); ?>';

</script>