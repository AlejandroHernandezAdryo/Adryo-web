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
            Total Activos: <span id="totalClientesActivos"></span>
            Total: <span id="totalClientes"></span>
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
				let Total=0;
				let totalClientesActivos=0;
				let totalClientesTemporal=0;
				let totalClientesInactivo=0;
				let maxiActivos=0;
				let maxiTemporal=0;
				let maxiInactivo=0;
				let max=0;
				for (let i in response){
					response[i].activos  = parseInt(response[i].activos);
					response[i].temporal = parseInt(response[i].temporal);
					response[i].Inactivo = parseInt(response[i].Inactivo);
					Total += response[i].activos + response[i].temporal +  response[i].Inactivo;
					totalClientesActivos  += response[i].activos ;
					totalClientesTemporal += response[i].temporal ;
					totalClientesInactivo += response[i].Inactivo ;
					if(maxiActivos < response[i].activos){
						maxiActivos = response[i].activos;
					}
					if(maxiTemporal < response[i].temporal){
						maxiTemporal = response[i].temporal;
					}
					if(maxiInactivo < response[i].Inactivo){
						maxiInactivo = response[i].Inactivo;
					}
        		}
				if (maxiActivos < maxiInactivo ) {
					max = maxiInactivo ;
				}
				document.getElementById("graficas_clientes_status_asesoresperiodo_tiempo").innerHTML =rangoFechas;
				document.getElementById("totalClientes").innerHTML =Total;
				document.getElementById("totalClientesActivos").innerHTML =totalClientesActivos;
				// console.log(response);
				drawClienteGrupoStatus( response, Total, max, totalClientesActivos,totalClientesTemporal,totalClientesInactivo );
			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
	}
   // Es el metodo de la grafica.
	function drawClienteGrupoStatus(  response, Total, max, totalClientesActivos,totalClientesTemporal,totalClientesInactivo  ) {
    	am5.ready(function () {
			var root = am5.Root.new("graficas_clientes_status_asesores");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			root.interfaceColors.set("grid", am5.color('#bababa'));
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX      : true,
				panY      : true,
				wheelY    : "zoomX",
				wheelX    : "panX",
				pinchZoomX:  true
			}));
			var cursor      = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineY.set("visible", false);
			var xRenderer   = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation    : -90,
				centerY     : am5.p50,
				centerX     : am5.p100,
				paddingRight: 15
			});
			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation: 0.3,
				categoryField: "user_name",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min   		: 0,
				max         : (max)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Activos e Inactivos Temporales",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				renderer    : paretoAxisRenderer,
				min         : 0,
				max         : (max)*1.2,
				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "#");
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "Inactivos Defenitivos",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Activos : ${totalClientesActivos}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "activos",
				categoryXField        : "user_name",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Activo')?>")); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
						centerY: am5.p100,
						populateText: true
					})
				});
			})
			
			//
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
				name: `Inactivos Temporales:  ${totalClientesTemporal}`,
				xAxis: xAxis,
				yAxis: paretoAxis,
				valueYField: "temporal",
					categoryXField: "user_name",
					sequencedInterpolation: true,
				tooltip: am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]:{valueY}"
				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.InactivoTemporal')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#,###')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
						centerY: am5.p100,
						populateText: true
					})
				});
			});
			//
			var series2 = chart.series.push(am5xy.ColumnSeries.new(root, {
			name: `Inactivos definitivos: ${totalClientesInactivo}`,
			xAxis: xAxis,
			yAxis: yAxis,
			valueYField: "Inactivo",
				categoryXField: "user_name",
				sequencedInterpolation: true,
			tooltip: am5.Tooltip.new(root, {
				labelText: "[bold]{name}[/]:{valueY}"
			})
			}));
			series2.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series2.set("fill", am5.color("<?= $this->Session->read('colores.InactivoDefinitivo')?>")); 
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#,###')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
						centerY: am5.p100,
						populateText: true
					})
				});
			});
			
			chart.set("cursor", am5xy.XYCursor.new(root, {}));
			var legend = chart.children.push(
				am5.Legend.new(root, {
					centerX: am5.p50,
					x      : am5.p50
				})
			);
			legend.data.setAll(chart.series.values);
			chart.appear(1000, 100);
			series.appear();	
			series1.appear();
			series2.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
			series2.data.setAll(data);
		});
  	}
</script>