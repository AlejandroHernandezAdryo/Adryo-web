<?php
    $total_visitas = 0; $total_inversion = 0; $maximo_registro_visitas = 0; $contactos = 0;
    foreach($visitas_linea_contacto_arreglo as $cliente):
        $total_visitas += $cliente['visitas'];
        $total_inversion += $cliente['inversion'];
        $contactos += $cliente['cantidad'];
    endforeach;
?>


<div class="card">
    <div class="card-header bg-blue-is">
        LEADS POR MEDIO DE PROMOCIÓN, VISITAS  E INVERSIÓN EN PUBLICIDAD        
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="grafica_visitas_lineas_contacto" style="width: 100%; min-height:600px;"></div>
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
    google.charts.setOnLoadCallback(graficaVisitasLineasContacto);


    function graficaVisitasLineasContacto(){
      var data = google.visualization.arrayToDataTable([
          ['Linea de contacto', 'Leads <?= number_format($contactos) ?>', {role: 'annotation'}, 'Visitas <?= $total_visitas?>', {role: 'annotation'},'Inversión en Publicidad $ <?= number_format($total_inversion) ?>'],
          <?php if( empty($visitas_linea_contacto_arreglo) ): ?>
            ['', 0,0,0,0,0]
          <?php else: ?>
            <?php  foreach($visitas_linea_contacto_arreglo as $cliente): ?>
              ['<?= $cliente['canal'] ?>', <?= $cliente['cantidad'] ?>, <?= $cliente['cantidad'] ?>, <?= $cliente['visitas'] ?>, <?= $cliente['visitas'] ?>, <?= $cliente['inversion'] ?>],
              <?php
                if( $maximo_registro_visitas > $cliente['cantidad'] ){
                  $maximo_registro_visitas = $cliente['cantidad'];
                }
                
              ?>
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
            1: {targetAxisIndex: 0, color: "#7CC3C4"},
            2: {type:'line',targetAxisIndex: 1, color: "purple"},
          },
          vAxes: {
            // Adds titles to each axis.
            0: {
              title: 'Registros / Visitas',
              textStyle:{color: '#616161', fontSize: 10,},
              titleTextStyle:{color: '#616161'},
            },
            1: {
              title: 'Inversión'
            },
          },
          hAxis: { 
            slantedText: true, 
            slantedTextAngle: 60,
            maxTextLines: 3,
            textStyle: {
              fontSize: 11,
            }
        },
        annotations: {
          alwaysOutside: true
        },
      };

 var classicChart = new google.visualization.ColumnChart(document.getElementById('grafica_visitas_lineas_contacto'));
 classicChart.draw(data, classicOptions);

}
</script>