<style>
		#grafica_etapa_clientes{
  		width: 100%;
  		height: 500px;
		}
</style>
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
    <div class="card-header bg-blue-is cursor"data-toggle='modal'>
    	ETAPAS DE CLIENTES ACTIVOS <i class='fa fa-exclamation-triangle fa-x2'></i>
        <span style="float:right">
            Total: <span id="totalClientesEtapa"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_etapa_clientes" ></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="cliente_Etapa_periodo_tiempo"></small>
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
  function graficaClientesEtapa( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "grafica_clintes_etapa")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
		beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
			var Total    = 0;
			for (let i in response){
            	response[i].cantidad  = parseInt(response[i].cantidad);
            	Total += response[i].cantidad;
        	}
        	document.getElementById("totalClientesEtapa").innerHTML           = Total;
        	document.getElementById("cliente_Etapa_periodo_tiempo").innerHTML = rangoFechas;
        	//document.getElementById("periodotitulo").innerHTML                = rangoFechas;
			if(Total==0){
            Total=5;
          	}
    		drawClienteEtapa( response, Total );
        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    

  }
  
   // Es el metodo de la grafica.
	function drawClienteEtapa( response, Total ) {
		// am5.ready(function() {
		// 	var root = am5.Root.new("grafica_etapa_clientes");

		// 	root.setThemes([
		// 		am5themes_Animated.new(root)
		// 	]);

		// 	var chart = root.container.children.push(am5percent.SlicedChart.new(root, {
		// 		layout: root.verticalLayout
		// 	}));
		// 	var data = response

		// 	var series = chart.series.push(am5percent.FunnelSeries.new(root, {
		// 		alignLabels: false,
		// 		orientation: "vertical",
		// 		valueField: "cantidad",
		// 		categoryField: "estado"
				
		// 	}));	
			
		// 	series.labels.template.text = "{category}: [bold]{value}[/]";
		// 	series.bullets.push(function () {
		// 		return am5.Bullet.new(root, {
		// 			//locationX: 1,
      	// 			//locationY: 1,
		// 			sprite       : am5.Label.new(root, {
		// 				text        : "{cantidad} ",
		// 				fill        : am5.color(0x000000),
		// 				//centerY: am5.p100,
		// 				populateText: true
		// 			})
		// 		});
		// 	})
		// 	series.data.setAll(response);
		// 	series.appear();

		// 	var legend = chart.children.push(am5.Legend.new(root, {
		// 		centerX: am5.p50,
		// 		x: am5.p50,
		// 		marginTop: 15,
		// 		marginBottom: 15
		// 	}));

		// 	legend.data.setAll(series.dataItems);
		// 	chart.appear(1000, 100);

		// }); // end am5.ready()
    	am5.ready(function() {
			//maybeDisposeRoot("grafica_etapa_clientes");
			var root = am5.Root.new("grafica_etapa_clientes");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			root.interfaceColors.set("grid", am5.color('#bababa'));
			var data = response
			var chart = root.container.children.push(
				am5xy.XYChart.new(root, {
					panX: false,
					panY: false,
					wheelX: "none",
					wheelY: "none",
					
				})
			);

			// Create axes
			// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/

			var yRenderer = am5xy.AxisRendererY.new(root, {});
			yRenderer.grid.template.set("visible", false);

			var yAxis = chart.yAxes.push(
				am5xy.CategoryAxis.new(root, {
					categoryField: "estado",
					renderer: yRenderer,
					//paddingRight:40
				})
			);

			var xRenderer = am5xy.AxisRendererX.new(root, {});
			xRenderer.grid.template.set("strokeDasharray", [3]);

			var xAxis = chart.xAxes.push(
			am5xy.ValueAxis.new(root, {
				min: 0,
				max: (Total)*1.1,
				renderer: xRenderer
			})
			);

			var series = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					xAxis: xAxis,
					yAxis: yAxis,
					valueXField: "cantidad",
					categoryYField: "estado",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{categoryY}: Cantidad {valueX}"
					})
				})
			);


			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			chart.get("colors").set("colors", [
				am5.color(0x57A344),
				am5.color(0x987061),
				am5.color(0xC3A998),
				am5.color(0xF5EBCD),
				am5.color(0xF4E4C5),
				am5.color(0x6BC5F2),
				am5.color(0xCDEEFD),
			]);
			series.columns.template.adapters.add("fill", function (fill, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});

			series.columns.template.adapters.add("stroke", function (stroke, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});
			
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 1,
					sprite       : am5.Label.new(root, {
						text        : "{cantidad} ",
						fill        : am5.color(0x000000),
						centerY: am5.p100,
						populateText: true
					})
				});
			})
			series.data.setAll(data);
			yAxis.data.setAll(data);

			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineX.set("visible", false);
			cursor.lineY.set("visible", false);
			series.appear();
			chart.appear(1000, 100);

		}); // end am5.ready()
  	}
</script>