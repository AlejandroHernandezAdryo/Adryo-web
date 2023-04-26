<?php
  $name_status_cliente = array(
    'Activo'            => 'Activo',
    'Inactivo'          => 'Inactivo definitivo',
    'Inactivo temporal' => 'Inactivo temporal'
  );
  $max_value    = 0;
  $tot_clientes = 0;
?>
<div class="card">
    <div class="card-header bg-blue-is">
        ESTATUS GENERAL DE MIS CLIENTES
        <span style="float:right">
            Total: <span id="sumatorioClientesEstatus"><?= ( !empty(number_format($total_clientes_anuales[0][0]['total_clientes_anuales'])) ? number_format($total_clientes_anuales[0][0]['total_clientes_anuales']) : 0) ?></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12">
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
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(ClienteStatusGeneral);  // Grafica de status de clientes

    function ClienteStatusGeneral(){
      var data = google.visualization.arrayToDataTable([
          ["Estado", "Cantidad", { role: "style" } ],
          <?php
            if( empty( $clientes_anuales ) ) {
              echo '[" ", 0, " "]';
            }else{
              foreach ( $clientes_anuales as $clientes_anuales_grafica ){
                switch( $clientes_anuales_grafica['Cliente']['status'] ) {
                  case 'Activo':
                      $color = "#BF9000";
                      $cliente_estatus = $name_status_cliente[$clientes_anuales_grafica['Cliente']['status']];
                  break;
                  case 'Inactivo':
                      $color = "#000000";
                      $cliente_estatus = $name_status_cliente[$clientes_anuales_grafica['Cliente']['status']];
                      // $max_value += $clientes_anuales_grafica['0']['total_clientes'];
                      $tot_clientes ++ ;
                  break;
                  case 'Inactivo temporal':
                      $color = "#7F6000";
                      $cliente_estatus = $name_status_cliente[$clientes_anuales_grafica['Cliente']['status']];
                  break;
                }
                $max_value += $clientes_anuales_grafica[0]['TotalClientes'];
                echo '["'.$cliente_estatus.'", '.$clientes_anuales_grafica[0]['TotalClientes'].', "'.$color.'"],';
              }
            }
          ?>

        ]);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                      { calc: "stringify",
                        sourceColumn: 1,
                        type: "string",
                        role: "annotation" },
                      2]);

      var options = {
        // title: "Estatus de atención a clientes",
        chartArea:{
          width:'90%',
          // height: '500'
        },
        bar: {
          groupWidth: "60%"
        },
        hAxis: {
          textStyle:{color: '#616161'},
        },
        vAxis: {
          textStyle:{color: '#616161'}
        },
        legend: {position: 'none'},
        vAxes: 
        [
            {
                minValue: 0,
                maxValue: <?= ( $max_value ); ?> ,
            }
        ],
        annotations: {
          alwaysOutside: true,
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById("grafica_estatus_general_clientes"));
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