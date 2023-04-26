<?php
if( $sum_clientes_atencion > 100 ){
  $max_value = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + 300;
}else{
  $max_value = $clientes_oportunos[0][0]['sumatorio'] + $clientes_tardia[0][0]['sumatorio'] + $clientes_reasignar[0][0]['sumatorio'] + 20;

}
?>
<div class="card">
    <div class="card-header bg-blue-is">
      <div class="row">
        <div class="col-sm-12">
          ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
          <span style="float: right;">Total: <?= number_format($sum_clientes_atencion) ?></span>
        </div>
      </div>
    </div>

    <div class="card-block" style="width: 100%; height: 280px;">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_clientes_atencion" style="width:80%"></div>
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
      ["Estado", "Cantidad", { role: "style" } ],
      ["<?= $clientes_oportunos[0][0]['status'] ?>", <?= $clientes_oportunos[0][0]['sumatorio'] ?>, "#1F4E79"],
      ["<?= $clientes_tardia[0][0]['status'] ?>", <?= $clientes_tardia[0][0]['sumatorio'] ?>, "#7030A0"],
      ["<?= $clientes_atrasados[0][0]['status'] ?>", <?= $clientes_atrasados[0][0]['sumatorio'] ?>, "#DA19CA"],
      ["<?= $clientes_reasignar[0][0]['status'] ?>", <?= $clientes_reasignar[0][0]['sumatorio'] ?>, "#7F7F7F"],
      ["<?= $clientes_sin_seguimiento[0][0]['status'] ?>", <?= $clientes_sin_seguimiento[0][0]['sumatorio'] ?>, "#7F7F7F"],
  ]);

  var view = new google.visualization.DataView(data);
  view.setColumns([0, 1,
     { calc: "stringify",
       sourceColumn: 1,
       type: "string",
       role: "annotation" },
     2]);

  var options = {
      title: "",
      titleTextStyle:{
        fontSize: 11
      },
      vAxes: 
      [
          {
              minValue: 0,
              maxValue: <?= $max_value; ?> ,
          }
      ],
      chartArea:{width:'90%'},
      backgroundColor:'transparent',
      bar: {groupWidth: "50%"},
      legend: { position: "none" },
      annotations: {
        alwaysOutside: true,
      }
  };
  var chart = new google.visualization.ColumnChart(document.getElementById("grafica_clientes_atencion"));
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