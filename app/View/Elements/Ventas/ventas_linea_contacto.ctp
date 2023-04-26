<div class="card">
    <div class="card-header bg-blue-is">
        MONTO DE VENTAS VS LÍNEA DE CONTACTO    
        <span style="float:right"> $ <?= number_format($total_venta_linea_contacto[0][0]['venta_total']) ?> </span>
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_ventas_linea_contacto" style="width: 100%; min-height:300px;"></div>
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

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(graficaClientesLineasContacto);


    function graficaClientesLineasContacto(){
  var data = google.visualization.arrayToDataTable([
      ['Linea de contacto', '$ Cantidad'],
      <?php  foreach($venta_linea_contacto as $cliente): ?>
        ['<?= $cliente['dic_linea_contactos']['canal'] ?>', <?= $cliente[0]['ventas'] ?>],
      <?php endforeach; ?>
   ]);

 var options = {
   vAxes: 
   [
       
       {
           title: '$ Cantidad',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }, 
       {
           minValue: 0,
           maxValue: 11000,
           title: 'Inversión',
           textStyle:{color: '#616161'},
           titleTextStyle:{color: '#616161'},
       }
   ],
   hAxis: {title: 'Linea de contacto',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'},},
   height: 300,
   series: {
          0: {
              //Objetivo
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          1: {
              //Real
              type: "bars",
              targetAxisIndex: 0,
              color: "#70AD47"
          },
          2: { 
            //% de cumplimiento
              type: "line",
              targetAxisIndex: 1,
              color: "#12f7ff"
          },
      },   
   backgroundColor:'transparent',
   legend:{
        textStyle:{
            color:'#616161',
            fontSize: 13
        }
    },
  titleTextStyle:{
      color:'#616161',
      fontSize: 16
    },
   
 };

 var chart = new google.visualization.ComboChart(document.getElementById('grafica_ventas_linea_contacto'));
 chart.draw(data, options);

}
</script>