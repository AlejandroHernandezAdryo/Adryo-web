<style>
		#graficas_clientes_status_asesores{
  		width: 100%;
  		height: 500px;
		}
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
		ESTATUS GENERAL DE CLIENTES POR ASESOR
        <span style="float:right">
            Total: <span id=""></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
    	<div class="row">
        	<div class="col-sm-12" >
        		<div id="graficas_clientes_status_asesores" ></div>
        	</div>
        	<div class="col-sm-12 m-t-35">
        		<small id="graficas_clientes_status_asesoresperiodo_tiempo"></small>
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
	function clientesStatusClientes( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_status_grupo")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
			dataType: 'json',

			success: function ( response ) {
				
				
				// drawClienteEtapa( response, Total );
				console.log(response);

			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
	}
   // Es el metodo de la grafica.
	function drawClienteEtapa( response, Total ) {
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
			xRenderer.grid.template.setAll({
				location: 1
			});
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
					clustered: false,
					valueXField: "cantidad",
					categoryYField: "estado",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{categoryY}: Cantidad {valueX}"
					})
				})
			);
			series.columns.template.setAll({
				width: am5.percent(20),
				tooltipY: 0,
				strokeOpacity: 0,
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			
			chart.get("colors").set("colors", [
				am5.color("<?= $this->Session->read('colores.Embudo.etapa7')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa6')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa5')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa4')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa3')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa2')?>"),
				am5.color("<?= $this->Session->read('colores.Embudo.etapa1')?>"),
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
			//
			var series1 = chart.series.push(
				am5xy.ColumnSeries.new(root, {
					xAxis: xAxis,
					yAxis: yAxis,
					clustered: false,
					valueXField: "cantidad7",
					categoryYField: "estado",
					tooltip: am5.Tooltip.new(root, {
						pointerOrientation: "vertical",
						labelText: "{categoryY}: Cantidad {valueX} de otro desarrollo"
					})
				})
			);


			// series1.columns.template.setAll({
			// 	cornerRadiusTL: 5,
			// 	cornerRadiusTR: 5,
			// });
			series1.columns.template.setAll({
				width: am5.percent(50),
				tooltipY: 0,
				strokeOpacity: 0
			});
			// chart.get("colors").set("colors", [
			// 	am5.color("<?= $this->Session->read('colores.Embudo.etapa7')?>"),
			// ]);
			series1.set("fill", am5.color(0xff0000)); 
			// series1.columns.template.adapters.add("fill", function (fill, target) {
			// 	return chart.get("colors").getIndex(series.columns.indexOf(target));
			// });

			// series1.columns.template.adapters.add("stroke", function (stroke, target) {
			// 	return chart.get("colors").getIndex(series.columns.indexOf(target));
			// });
			
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationX: 1,
      				locationY: 0,
					sprite       : am5.Label.new(root, {
						// text        : "{cantidad} ",
						fill        : am5.color(0x000000),
						centerY: am5.p100,
						populateText: true
					})
				});
			})
			
			//
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));

			series.data.setAll(data);
			series1.data.setAll(data);
			yAxis.data.setAll(data);

			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineX.set("visible", false);
			cursor.lineY.set("visible", false);
			series.appear();
			series1.appear();
			chart.appear(1000, 100);

		}); // end am5.ready()
  	}
</script>