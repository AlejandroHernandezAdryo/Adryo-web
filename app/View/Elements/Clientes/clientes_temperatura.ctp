
<div class="card">
    <div class="card-header bg-blue-is">
        ETAPAS DE CLIENTES ACTIVOS A LA FECHA <?= !empty($fecha_final) ? date('d/m/Y',  strtotime($fecha_final)) : "" ?>
        <span style="float:right">
            Total: <span id="sumatorioClientesTemperatura"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_temperatura_clientes" class="grafica no-imprimir"></div>
                <div id="grafica_temperatura_clientes_print" class="grafica imprimir"></div>
            </div>
            <div class="col-sm-12 mt-2 periodo_tiempo" >
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
    google.charts.load('current', {'packages':['corechart','bar']});
    google.charts.setOnLoadCallback(temperatura_clientes);

function temperatura_clientes(){
  var data = google.visualization.arrayToDataTable([
    ["Etapa", "Cantidad",{ role: 'style' },{role: 'annotation'}],

    <?php
        $ctotal = 0; $c1 = 0 ; $c2 = 0 ; $c3 = 0 ; $c4 = 0 ; $c5 = 0 ; $c6 = 0 ; $c7 = 0 ;
        foreach( $temperatura_clientes as $temperaturas ){
            switch( $temperaturas['clientes']['etapa'] ) {
                case 1:
                    $c1 += $temperaturas['0']['sumatorio'];
                    
                break;
                case 2:
                    $c2 += $temperaturas['0']['sumatorio'];
                    
                break;
                case 3:
                    $c3 += $temperaturas['0']['sumatorio'];
                    
                break;
                case 4:
                    $c4 += $temperaturas['0']['sumatorio'];
                    
                break;
                case 5:
                    $c5 += $temperaturas['0']['sumatorio'];
                    
                break;
                case 6:
                    $c6 += $temperaturas['0']['sumatorio'];  
                    
                break;
                case 7:
                    $c7 += $temperaturas['0']['sumatorio'];  
                    
                break;
            }
            $ctotal = $ctotal+ $temperaturas['0']['sumatorio'];
        }
        echo "[ 'Interés Preliminar', ".$c1.", '#ceeefd',".$c1." ],";
        echo "[ 'Comunicación Abierta', ".$c2.",'#6bc7f2' ,".$c2." ],";
        echo "[ 'Precalificación', ".$c3.",'#f4e6c5',".$c3."  ],";
        echo "[ 'Visita', ".$c4.",'#f0ce7e' ,".$c4." ],";
        echo "[ 'Análisis de Opciones', ".$c5.",'#f08551' ,".$c5." ],";
        echo "[ 'Validación de Recursos', ".$c6.",'#ee5003' ,".$c6." ],";
        echo "[ 'Cierre', ".$c7.",'#3ed21f' ,".$c7." ],";
    ?>

  ]);

  var options = {
    legend: { position: "none" },
    width: '100%',
    height: 300,
    chartArea: {left: '15%'},
    bar: {groupWidth: "90%"},
    vAxis: {
      textStyle:{
        fontSize: 13,
        color: '#4b4b4b'
      }
    },
    annotations: {
      alwaysOutside: true,
    }
  };

  //var chart = new google.visualization.PieChart(document.getElementById('grafica_temperatura_clientes'));
  var chart = new google.visualization.BarChart(document.getElementById('grafica_temperatura_clientes'));
  var chart_div = document.getElementById('grafica_temperatura_clientes_print');
  // Wait for the chart to finish drawing before calling the getImageURI() method.
  google.visualization.events.addListener(chart, 'ready', function () {
          chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
          console.log(chart_div.innerHTML);
        });
  chart.draw(data, options);
  google.visualization.events.addListener(chart, 'select', selectTem);

  function selectTem(){
    var selection = chart.getSelection();
    // console.log(selection[0].row);

    if (selection[0].row == 0) {
      console.log('Seleccionaste los Frios');
    }
    if (selection[0].row == 1) {
      console.log('Seleccionaste los Tibios');
    }
    if (selection[0].row == 2) {
      console.log('Seleccionaste los Calientes');
    }
  }
}
document.getElementById("sumatorioClientesTemperatura").innerHTML = '<?= number_format($ctotal); ?>';

</script>