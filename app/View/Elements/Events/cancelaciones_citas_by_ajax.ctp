<style>
		#cliente_motivo_cancelacion_cita{
  		width: 100%;
  		height: 500px;
		}
</style>
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
    <div class="card-header bg-blue-is cursor" data-toggle='modal'>
        RAZONES DE CANCELACIÓN DE CITAS 
        <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
        <span style="float:right">
            Total: <span id="citasCanceladasT"></span>
        </span> 
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="cliente_motivo_cancelacion_cita"></div>
         
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="cancelacion_cita_periodo_tiempo"></small>
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
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
   
    // Se mandan a llamar los datos para la grafica
  function graficaMotivoCancelacionCita( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "events", "action" => "grafica_cita_cancelada")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {
              var Total    = 0;
			        for (let i in response){
            	  response[i].cantidad  = parseInt(response[i].cantidad);
                response[i].motivo=response[i].motivo/*.replace(/[^a-zA-Z ]/g, "")*/;
            	  Total += response[i].cantidad;
        	    }
              //.replace(/[^a-zA-Z ]/g, "")
              // console.log(response);
        	    document.getElementById("citasCanceladasT").innerHTML =Total;
        	    document.getElementById("cancelacion_cita_periodo_tiempo").innerHTML =rangoFechas;
              drawClienteMotiviCancelacion( response );
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
  }
    // Es el metodo de la grafica.
  function drawClienteMotiviCancelacion( response ) {
      am5.ready(function () {
			var root = am5.Root.new("cliente_motivo_cancelacion_cita");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5percent.PieChart.new(root, {
				layout     : root.verticalLayout,
				innerRadius: am5.percent(50)
			}));
			var series = chart.series.push(am5percent.PieSeries.new(root, {
				name           : "Cancelacion de citas",
				valueField     : "cantidad",
				categoryField  : "motivo",
				legendLabelText: "[{fill}]{category}[/]",
				legendValueText: "[bold {fill}]{value}[/]",
				
			}));
			series.slices.template.set('tooltipText', '{category}: {value}');
			series.labels.template.set('text', '{category}: {value}');
			series.labels.template.set("visible", false);
			series.ticks.template.set("visible", false);
			
			series.labels.template.setAll({
				textType: "circular",
				centerX : 0,
				centerY : 0
			});
			var data = response;
			series.data.setAll(data);
			var legend = chart.children.push(am5.Legend.new(root, {
				centerX     : am5.percent(50),
				x           : am5.percent(50),
				marginTop   : 15,
				marginBottom: 15,
			}));
			legend.data.setAll(series.dataItems);
			series.appear(1000, 100);

		}); 
  }
</script>