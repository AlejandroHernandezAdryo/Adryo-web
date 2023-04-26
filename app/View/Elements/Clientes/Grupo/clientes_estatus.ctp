<?php
    $total = 0;
    foreach ($clientes_anuales_reporte as $registro){
        $total += $registro['status']['Activo'];
        $total += $registro['status']['Inactivo'];
        $total += $registro['status']['Inactivo temporal'];
    }
?>
<div class="card">
    <div class="card-header bg-blue-is">
        ESTATUS GENERAL DE CLIENTES POR ASESOR
        <span style="float:right">
            Total: <span id="sumatorioClientesEstatus"><?= number_format($total,0) ?></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_estatus_general_clientes" class="grafica no-imprimir"></div>
          <div id="grafica_estatus_general_clientes_print" class="grafica imprimir"></div>
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
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(ClienteStatusGeneral);  // Grafica de status de clientes

    function ClienteStatusGeneral(){
      var data = google.visualization.arrayToDataTable([
          ["Asesor","Activo", "Inactivo Definitivo", "Inactivo Temporal"]
          <?php
              foreach ( $clientes_anuales_reporte as $registro){
                echo ",['".$registro['asesor']."',".$registro['status']['Activo'].",".$registro['status']['Inactivo'].",".$registro['status']['Inactivo temporal']."]";
              }
          ?>

        ]);

      var view = new google.visualization.DataView(data);
      var options = {
            legend: { position: "none" },
            width: '100%',
            chartArea: {left: '15%'},
            bar: {groupWidth: "90%"},
            vAxis: {
                textStyle:{
                    fontSize: 13,
                    color: 'black'
                }
            },

            series: {
              0: { // Meta
                  type: "bars",
                  targetAxisIndex: 0,
                  color: "#BF9000",
                  annotations: {
                      textStyle: {
                          color: '#BF9000',
                      }
                  }
              },
              1: { // Real
                  type: "bars",
                  targetAxisIndex: 0,
                  color: "black"
              },
              2: {  // % de cumplimiento
                  type: "bars",
                  targetAxisIndex: 1,
                  color: "#7F6000"
              },
          },
            annotations: {
                alwaysOutside: true,
            }
        };

      var chart = new google.visualization.BarChart(document.getElementById("grafica_estatus_general_clientes"));
      var chart_div = document.getElementById('grafica_estatus_general_clientes_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
          chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
          console.log(chart_div.innerHTML);
        });
      chart.draw(view, options);
      google.visualization.events.addListener(chart, 'select', selectStatus);

      function selectStatus(){
        var selection = chart.getSelection();

        if (selection[0].row == 0) {
          console.log('Seleccionaste los Activos');
        }
        if (selection[0].row == 2) {
          console.log('Seleccionaste los Inactivos Temporales');
        }
        if (selection[0].row == 3) {
          console.log('Seleccionaste los Inactivos');
        }
      }
    }
</script>