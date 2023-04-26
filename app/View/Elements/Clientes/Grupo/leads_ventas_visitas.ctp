
<div class="card">
    <div class="card-header bg-blue-is">
        TOTAL DE LEADS VS VENTAS Y VISITAS
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_leads_ventas_visitas" class="grafica no-imprimir"></div>
          <div id="grafica_leads_ventas_visitas_print" class="grafica imprimir"></div>
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
    google.charts.setOnLoadCallback(VentasLeadsVisitas);  // Grafica de status de clientes

    function VentasLeadsVisitas(){
      var data = google.visualization.arrayToDataTable([
          ["Asesor","Leads", "Ventas", "Visitas"]
          <?php
              foreach ( $ventas_leads_reporte as $registro){
                echo ",['".$registro['asesor']."',".$registro['leads'].",".$registro['ventas'].",".$registro['visitas']."]";
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
                    color: '#4b4b4b'
                }
            },
          series: {
              0: { // Meta
                  type: "bars",
                  targetAxisIndex: 0,
                  color: "orange",
              },
              1: { // Real
                  type: "bars",
                  targetAxisIndex: 0,
                  color: "#70AD47"
              },
              2: {  // % de cumplimiento
                  type: "bars",
                  targetAxisIndex: 1,
                  color: "blue"
              },
          },
            annotations: {
                alwaysOutside: true,
            }
        };

      var chart = new google.visualization.BarChart(document.getElementById("grafica_leads_ventas_visitas"));
      var chart_div = document.getElementById('grafica_leads_ventas_visitas_print');
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