<?php
  $total = 0;
  foreach( $inactivos_distribucion as $inactivo){
    $total += $inactivo;
  }
?>
<div class="card">
    <div class="card-header bg-blue-is">
        RAZONES DE INACTIVACIÓN DEFINITIVA DE CLIENTES <?= $this->Html->link('<i class="fa fa-question-circle"></i>','javascript:void(0)',array('escape'=>false,"data-toggle"=>"tooltip", "data-placement"=>"", "title"=>"LA CANTIDAD DE INACTIVOS DEFINITIVOS
PUEDE SER SUPERIOR EN ESTE GRÁFICO
PORQUE UN MISMO CLIENTE EN EL PERIODO
SOLICITADO PUEDE SER INACTIVADO Y
ACTIVADO MÁS DE UNA VEZ, O EL CLIENTE PUDO HABERSE CREADO FUERA DEL PERIODO DEL REPORTE"))?>
        <span style="float:right">
            Total: <span id="sumatorioDistribucionInactivos"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12">
          <div id="grafica_distribucion_inactivos" class="grafica no-imprimir"></div>
          <div id="grafica_distribucion_inactivos_print" class="grafica imprimir"></div>
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
      if( $total <= 0 ){
        echo "['Sin información - (0)', 100],";
      } else {
        foreach( $inactivos_distribucion as $key => $inactivo){
          echo "[ '".$key." - (".$inactivo.")', ".$inactivo."],";
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
  var chart = new google.visualization.PieChart(document.getElementById('grafica_distribucion_inactivos'));
  var chart_div = document.getElementById('grafica_distribucion_inactivos_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
  chart.draw(data, options);
}
document.getElementById("sumatorioDistribucionInactivos").innerHTML = '<?= number_format($total) ?>';

</script>