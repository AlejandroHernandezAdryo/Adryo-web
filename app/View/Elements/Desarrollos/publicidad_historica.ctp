<?php 
  $total = 0;
  if( !empty($inversion_publicidad) ){
    
    foreach( $inversion_publicidad as $inversion ) {
      $total += $inversion[0]['inversion'];
    }

  }
?>
<div class="card">
    <div class="card-header bg-blue-is">
        INVERSIÓN HISTÓRICA EN PUBLICIDAD
    </div>

    <div class="card-block">
        <div class="row">
            <div class="col-sm-12">
                <div id="inversion_historica_grafica" style="width: 100%; min-height:300px;"></div>
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
      ['Linea de contacto', 'Inversión  $ <?= number_format($total) ?>', {role: 'annotation'}],
      <?php if( empty($inversion_publicidad) ): ?>
        ['', 0, 0]
      <?php else: ?>
        <?php foreach($inversion_publicidad as $inversion): ?>
          ['<?= $inversion['dic_linea_contactos']['linea_contacto'] ?>', <?= $inversion[0]['inversion'] ?>, <?= $inversion[0]['inversion'] ?>],
        <?php endforeach; ?>
      <?php endif; ?>
      
   ]);

 var options = {
    annotations: {
      alwaysOutside: true
    },
    hAxis: {title: 'Linea de contacto',textStyle:{color: '#616161'},titleTextStyle:{color: '#616161'},},
    height: 300,
    series: {
        0: {
            //Objetivo
            type: "bars",
            targetAxisIndex: 0,
            color: "purple",
            annotations: {
                textStyle: {
                    color: '#616161',
                }
            }
        },
    },
    backgroundColor:'transparent',
    legend:{
      position: "top",
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

 var chart = new google.visualization.ComboChart(document.getElementById('inversion_historica_grafica'));
 chart.draw(data, options);

}
</script>