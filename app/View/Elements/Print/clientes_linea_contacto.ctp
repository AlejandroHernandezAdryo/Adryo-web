<?php
    $total_ventas = 0;
    foreach($ventas_linea_contacto_arreglo as $cliente):
        $total_ventas += $cliente['ventas'];
    endforeach;
    $visitas = 0;
?>

<div class="card">
    <div class="card-header bg-blue-is">
        CONTACTOS POR MEDIO DE PROMOCIÓN VS VENTAS
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_clientes_lineas_contacto" style="width: 80%;min-height:600px;"></div>
            </div>
            <div class="col-sm-12"><small><?= $periodo_tiempo ?></small></div>
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
      ['Linea de contacto', 'Contactos <?= number_format($total_clientes_lineas[0][0]['total_registros']) ?>', {role: 'annotation'}, 'Ventas <?= $total_ventas?>', {role: 'annotation'},'Inversión en Publicidad'],

      <?php if( empty($ventas_linea_contacto_arreglo) ): ?>
        ['', 0,0,0,0,0]
      <?php else: ?>
        <?php  foreach($ventas_linea_contacto_arreglo as $cliente): ?>
          ['<?= $cliente['canal'] ?>', <?= $cliente['cantidad'] ?>, <?= $cliente['cantidad'] ?>, <?= $cliente['ventas'] ?>, <?= $cliente['ventas'] ?>,<?= $cliente['inversion']; ?>],
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);
   
   
        
  var classicOptions = {
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
      1: {targetAxisIndex: 0, color: "#70AD47"},
      2: {type: 'line', targetAxisIndex: 1, color: "purple"},
    },
    vAxes: {
      0: {
        title: 'Registros / Ventas',
        textStyle:{color: '#616161', fontSize: 10,},
        titleTextStyle:{
          color: '#616161'
        },
      },
      1: {title: 'Inversión'},
    },
    hAxis: { 
        slantedText: true, 
        slantedTextAngle: 60,
        maxTextLines: 3,
        textStyle: {
          fontSize: 10,
        }
    },
    annotations: {
      alwaysOutside: true
    },
  };

 var classicChart = new google.visualization.ColumnChart(document.getElementById('grafica_clientes_lineas_contacto'));
 classicChart.draw(data, classicOptions);

}
</script>