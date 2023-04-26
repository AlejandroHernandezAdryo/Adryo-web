
<div class="card">
    <div class="card-header bg-blue-is">
        Motivos de Reasignación de clientes
        <span style="float:right">
            Total: <span id="sumatoria_razones_reasignaciones"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%; height: 250px;">
      <div class="row">
        <div class="col-sm-12">
          <div id="grafica_motivos_reasignacion_clientes" style="width:80%"></div>
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
    google.charts.setOnLoadCallback(motivosReasignacionClientes);

function motivosReasignacionClientes(){
  var data = google.visualization.arrayToDataTable([
    ["Motivo", "Clientes"],

    <?php
    $total = 0;
    if( empty( $motivos_reasignaciones ) ){
      echo '[" ", 0]';
    } else {
        foreach( $motivos_reasignaciones as $motivo){
          echo "[ '".$motivo['reasignacions']['motivo_cambio']."(".$motivo[0]['reasignaciones'].")', ".$motivo[0]['reasignaciones']."],";
          $total += $motivo[0]['reasignaciones'];
        }
      }
    ?>

  ]);

  // var options = {
  //   height: 300,
  //   backgroundColor:'transparent',
  //   legend: {
  //     textStyle:{
  //       color   :'#000',
  //       fontSize: 14,
  //     }
  //   },
  //   pieStartAngle: 135,
  //   titleTextStyle:{
  //     color    :'#FFFFFF',
  //     fontSize : 14,
  //     textAlign: 'center',
  //   },
  //   bar: {groupWidth: "95%"},
  //   slices: {
  //     0: { color: '#ceeefd' },
  //     1: { color: '#6bc7f2' },
  //     2: { color: '#f4e6c5' },
  //     3: { color: '#f0ce7e' },
  //     4: { color: '#f08551' },
  //     5: { color: '#ee5003' },
  //     6: { color: '#3ed21f' },
  //   },
  //   hAxis: {
  //     textStyle:{color: '#FFFFFF'}
  //   },
  //   vAxis: {
  //     textStyle:{color: '#FFFFFF'}
  //   },
  // };

  var options = {
    chartArea:{left:0,top:0,width:'100%',height:'400'},
    legend:{position: 'right', textStyle: {fontSize: 11}},
  };

  //var chart = new google.visualization.PieChart(document.getElementById('grafica_motivos_reasignacion_clientess'));
  var chart = new google.visualization.PieChart(document.getElementById('grafica_motivos_reasignacion_clientes'));
  chart.draw(data, options);
}
document.getElementById("sumatoria_razones_reasignaciones").innerHTML = '<?= number_format($total); ?>';

</script>