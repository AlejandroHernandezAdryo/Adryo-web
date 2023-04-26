<?php
    $total = 0;
    foreach ($clientes_atencion_reporte as $registro){
        $total += $registro['oportunos']['cantidad'];
        $total += $registro['tardia']['cantidad'];
        $total += $registro['no_atendidos']['cantidad'];
        $total += $registro['por_reasignar']['cantidad'];
    }
?>
<div class="card">
    <div class="card-header bg-blue-is">
      <div class="row">
        <div class="col-sm-12">
          ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
          <span style="float: right;">Total: <?= number_format($total,0) ?></span>
        </div>
      </div>
    </div>

    <div class="card-block" style="width: 100%">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_clientes_atencion" class="grafica no-imprimir"></div>
                <div id="grafica_clientes_atencion_print" class="grafica imprimir"></div>
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
    google.charts.setOnLoadCallback(atencionClientes);

function atencionClientes(){
  var data = google.visualization.arrayToDataTable([
      ["Asesor","Oportunos", "Tardía", "No Atentidos", "Por Reasignar"]
      <?php
        foreach($clientes_atencion_reporte as $registro){
            echo ",['".$registro['asesor']."',".$registro['oportunos']['cantidad'].",".$registro['tardia']['cantidad'].",".$registro['no_atendidos']['cantidad'].",".$registro['por_reasignar']['cantidad']."]";
        }
      ?>
  ]);

  var view = new google.visualization.DataView(data);

  var options = {
      title: "",
      titleTextStyle:{
        fontSize: 11
      },
      vAxes:
      [
          {
              minValue: 0,
          }
      ],
      hAxis:{
          title: 'Asesor',
          textStyle : {
              fontSize: 10 // or the number you want
          }
      },
      series: {
          0: { // Meta
              type: "bars",
              targetAxisIndex: 0,
              color: "#1F4E79",
          },
          1: { // Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#7030A0"
          },
          2: {  // % de cumplimiento
              type: "bars",
              targetAxisIndex: 1,
              color: "#DA19CA"
          },
          3: {  // % de cumplimiento
              type: "bars",
              targetAxisIndex: 1,
              color: "#7F7F7F"
          },
          4: {  // % de cumplimiento
              type: "bars",
              targetAxisIndex: 1,
              color: "#7F7F7F"
          },
      },
      chartArea:{width:'90%'},
      backgroundColor:'transparent',
      bar: {groupWidth: "50%"},
      legend: { position: "none" },
      annotations: {
        alwaysOutside: true,
      }
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("grafica_clientes_atencion"));
  var chart_div = document.getElementById('grafica_clientes_atencion_print');
      // Wait for the chart to finish drawing before calling the getImageURI() method.
      google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
        console.log(chart_div.innerHTML);
      });
  chart.draw(view, options);
  google.visualization.events.addListener(chart, 'select', selectAtn);

  function selectAtn(){
    var selection = chart.getSelection();
    // console.log(selection[0].row);

    /*for (var i = 0; i < selection.length; i++) {
      var item = selection[i];
      console.log(item);
    }*/
    if (selection[0].row == 0) {
      console.log('Seleccionaste los Oportunos');
    }
    if (selection[0].row == 1) {
      console.log('Seleccionaste los Tardios');
    }
    if (selection[0].row == 2) {
      console.log('Seleccionaste los No atendidos');
    }
    if (selection[0].row == 3) {
      console.log('Seleccionaste los Por Reasignar');
    }
  }

}


</script>