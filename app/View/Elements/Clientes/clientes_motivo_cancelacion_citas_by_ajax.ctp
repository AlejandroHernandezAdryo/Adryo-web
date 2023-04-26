<!-- Modal para la informacion de la grafica. -->
<div class="modal fade" id="modal_info_clientes_estatus">
  <div class="modal-dialog modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
    
      <div class="modal-header bg-blue-is">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
          <h4 class="modal-title">&nbsp;&nbsp; Información de la grafica.</h4>
      </div> <!-- Modal Header -->

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <p>
              <i class="fa fa-exclamation-triangle text-danger"></i>
              Esta grafica esta enfocada a la tabla de clientes, 
              los filtros estan enfocados en la fecha de creación de los clientes
              y por desarrollo.

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor" data-target='#modal_info_clientes_estatus' data-toggle='modal'>
    RAZONES DE CANCELACIO DE CITAS <i class='fa fa-exclamation-triangle fa-x2'></i>
        <span style="float:right">
            Clientes oportunos + Clientes tardios: <span id=''></span>
            Total: <span id=""></span>
        </span> 
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="cliente_motivo_cancelacion_cita" class="grafica no"></div>
         
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="cliente_estatus_periodo_tiempo"></small>
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
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawClienteMotiviCancelacion);
    // Se mandan a llamar los datos para la grafica
    function graficaMotivoCancelacionCita( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "grafica_cita_cancelada")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
              //drawClienteMotiviCancelacion( response );
              console.log(response);
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }
    // Es el metodo de la grafica.
    function drawClienteMotiviCancelacion( dataResult ) {
        <?php $total=0;?>
      var data = google.visualization.arrayToDataTable([
        ["Motivo Inactivación", "Cantidad"],
        <?php
          if( $total==0 ){
            echo "['Sin información - (0)', 100],";
          } 
        ?>
      ]);

      var options = {
        chartArea:{left:0,top:'30',width:'100%',height:'300'},
        legend:{position: 'right', textStyle: {fontSize: 14, color: '#4b4b4b'}},
        height: 350,
        widht: '100%',
        pieHole: 0.6,
        pieStartAngle: 100,
        pieSliceText: 'value',
      };

      //var chart = new google.visualization.PieChart(document.getElementById('grafica_inactivos_clientes'));
      var chart = new google.visualization.PieChart(document.getElementById('cliente_motivo_cancelacion_cita'));
      var chart_div = document.getElementById('cliente_motivo_cancelacion_cita_print');
          // Wait for the chart to finish drawing before calling the getImageURI() method.
          google.visualization.events.addListener(chart, 'ready', function () {
            //chart_div.innerHTML = '<img src="' + chart.getImageURI() + '" style="width:100%">';
            //console.log(chart_div.innerHTML);
          });
      chart.draw(data, options);
    }
</script>