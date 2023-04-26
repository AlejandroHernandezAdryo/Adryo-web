
<?php
  $total = 0;
  foreach( $inactivos_temporal_distribucion as $inactivoTemp){
    $total += $inactivoTemp['cantidad'];
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
          <div id="grafica_distribucion_inactivos_temporales" style="width:80%"></div>
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
        foreach( $inactivos_temporal_distribucion as $inactivo){
          echo "[ '".$inactivo['label']." (".$inactivo['cantidad'].")', ".$inactivo['cantidad']."],";
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
    slices: {
      0: { color: '#c2a056', textStyle: {fontSize: 14, color: '#efefef'} },
      1: { color: '#56c26a', textStyle: {fontSize: 14, color: '#efefef'} },
      2: { color: '#5678c2', textStyle: {fontSize: 14, color: '#efefef'} },
      3: { color: '#c256ae', textStyle: {fontSize: 14, color: '#efefef'} },
      4: { color: 'red', textStyle: {fontSize: 14, color: '#efefef'} },
    },
  };

  //var chart = new google.visualization.PieChart(document.getElementById('grafica_inactivos_clientes'));
  var chart = new google.visualization.PieChart(document.getElementById('grafica_distribucion_inactivos_temporales'));
  chart.draw(data, options);
}
document.getElementById("sumatorioDistribucionInactivosTemporales").innerHTML = '<?= number_format($total); ?>';

</script>