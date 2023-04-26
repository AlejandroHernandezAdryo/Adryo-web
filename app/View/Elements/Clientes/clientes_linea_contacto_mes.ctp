<div class="card">
    <div class="card-header bg-blue-is">
        CLIENTES POR FORMA DE CONTACTO DE <?= ucwords(strftime("%B", strtotime(date("M")))) ?>
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_clientes_lineas_contacto_mes" style="width: 100%; min-height:600px;"></div>
            </div>

            <div class="col-sm-12"><small><?= 'INFORMACIÓN DEL '.date('01-m-Y').' AL '.date('t-m-Y') ?></small></div>
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
    google.charts.setOnLoadCallback(graficaClientesLineasContacto);


    function graficaClientesLineasContacto(){
  var data = google.visualization.arrayToDataTable([
      ['Linea de contacto', 'Contactos <?= number_format($total_clientes_lineas_mes[0][0]['total_registros']) ?>', {role: 'annotation'}],
      <?php if( empty($clientes_lineas_mes) ): ?>
        ['', 0]
      <?php else: ?>
        <?php  foreach($clientes_lineas_mes as $cliente): ?>
          ['<?= $cliente['dic_linea_contactos']['canal'] ?>', <?= $cliente[0]['registros'] ?>, <?= $cliente[0]['registros'] ?>],
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);

 var options = {
  orientation: 'vertical',
  legend: { position: "right" },
  chartArea: {
    width: '60%',
    height: '90%',
    },
    width: '100%',
    top: 0,
    series: {
      0: {targetAxisIndex: 0, color: "orange"},
    },
    vAxes: {
      0: {
        title: 'Línea de contacto',
        textStyle:{
          color: '#616161',
          // fontSize: 9,
        },
        titleTextStyle:{
          color: '#616161'
        },
      },
    },
    hAxis: { 
        slantedText: true, 
        slantedTextAngle: 60,
        maxTextLines: 3,
        textStyle: {
          // fontSize: 14,
        }
    },
  annotations: {
      alwaysOutside: true
    },
  backgroundColor:'transparent',
  titleTextStyle:{
      color:'#616161',
      // fontSize: 16
    },
   
 };

 var chart = new google.visualization.ColumnChart(document.getElementById('grafica_clientes_lineas_contacto_mes'));
 chart.draw(data, options);

}
</script>