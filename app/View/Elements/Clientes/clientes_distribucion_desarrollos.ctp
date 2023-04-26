
<div class="card">
    <div class="card-header bg-blue-is">
        CLIENTES ASIGNADOS POR DESARROLLO O PROPIEDAD
        <span style="float:right">
            Total: <span id="sumatoriaClientesPorProyecto"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_distribucion_clientes_proyecto"></div>
            </div>
            <div class="col-sm-12 mt-3 periodo_tiempo">
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

  $ctotal = 0;
?>

<script>
    google.charts.load('current', {'packages':['corechart','bar']});
    google.charts.setOnLoadCallback(dist_clientes_desarrollos);

function dist_clientes_desarrollos(){
  var data = google.visualization.arrayToDataTable([
    ["Desarrollo", "Clientes", {role: 'annotation'},],

    <?php
    if( empty($clientes_asignados_desarrollos ) ){
      echo '[" ", 0,0]';
    } else {
        foreach( $clientes_asignados_desarrollos as $proyecto){
          echo "[ '".$proyecto['desarrollos']['nombre']." - (".$proyecto[0]['clientes'].")',".$proyecto[0]['clientes'].",".$proyecto[0]['clientes']."],";
          $ctotal += $proyecto[0]['clientes'];
        }
    }
    ?>

  ]);
  
  var options = {
    bars: 'horizontal',
    hAxis: {
      format: 'decimal',
      title: 'Clientes',
      minValue: 0
    },
    vAxis: {
      title: 'Desarrollo',
      fontSize: 5,
      textStyle:{
        fontSize: 9
      }
    },
    height: 300,
    colors: ['#6b8abf'],
    legend:{
      position: 'none',
      textStyle:{
          fontSize: 5
      }
    },
  };

  //var chart = new google.visualization.PieChart(document.getElementById('grafica_distribucion_clientes_proyecto'));
  var chart = new google.charts.Bar(document.getElementById('grafica_distribucion_clientes_proyecto'));
  chart.draw(data, options);
  google.visualization.events.addListener(chart, 'select', selectTem);

}
document.getElementById("sumatoriaClientesPorProyecto").innerHTML = '<?= number_format($ctotal); ?>';

</script>

