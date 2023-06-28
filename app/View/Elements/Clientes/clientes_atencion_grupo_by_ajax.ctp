<style>
		#graficas_clientes_atencion_asesores{
  		width: 100%;
  		height: 500px;
		}
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
		ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
        <span style="float:right">
            Total: <span id="atenciontaltaclientes"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
    	<div class="row">
        	<div class="col-sm-12" >
        		<div id="graficas_clientes_atencion_asesores" ></div>
        	</div>
        	<div class="col-sm-12 m-t-35">
        		<small id="graficas_clientes_atencion_asesores_periodo_tiempo"></small>
        	</div>
    	</div>
    </div>
</div>


<?php
  echo $this->Html->script([
    'components',
    'custom',


	], array('inline'=>false));
?>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>

  // Se mandan a llamar los datos para la grafica
	function clientesAtencionClientes( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
		$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_atencion_grupo")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
			dataType: 'json',

			success: function ( response ) {
				
				let Total=0;
				let TotalOportunos=0;
				let TotalTardios=0;
				let TotalNo_atendido=0;
				let TotalReasignar=0;
				let maxioportunos=0;
				let maxitardios=0;
				let maxino_atendido=0;
				let maxino_reasignar=0;
				let max1=0;
				let max2=0;
				let maximo=0;
				for (let i in response){
					response[i].oportunos  = parseInt(response[i].oportunos);
					response[i].tardios  = parseInt(response[i].tardios);
					response[i].no_atendido  = parseInt(response[i].no_atendido);
					response[i].reasignar  = parseInt(response[i].reasignar);
					Total            += response[i].oportunos + response[i].tardios +  response[i].no_atendido + response[i].reasignar ;
					TotalOportunos   += response[i].oportunos ;
					TotalTardios     += response[i].tardios;
					TotalNo_atendido += response[i].no_atendido ;
					TotalReasignar   += response[i].reasignar ;
					if(maxioportunos < response[i].oportunos){
						maxioportunos = response[i].oportunos;
					}
					if(maxitardios < response[i].tardios){
						maxitardios = response[i].tardios;
					}
					if(maxino_atendido < response[i].no_atendido){
						maxino_atendido = response[i].no_atendido;
					}
					if(maxino_reasignar < response[i].reasignar){
						maxino_reasignar = response[i].reasignar;
					}
        		}
				if ( maxioportunos < maxitardios ) {
					max1 = maxitardios ;
				}
				if ( maxino_atendido < maxino_reasignar ) {
					max2 = maxino_reasignar ;
				}
				if ( max1 < max2 ) {
					maximo = max2 ;
				}else{
					maximo=max1
				}
				document.getElementById("graficas_clientes_atencion_asesores_periodo_tiempo").innerHTML =rangoFechas;
				document.getElementById("atenciontaltaclientes").innerHTML =Total;
				
				// console.log('caca');
				// console.log(response,  Total, max );
				// console.log('caca');
				
				drawClientesAtencionGrupoAsesores(response,  Total, maximo, TotalOportunos, TotalTardios ,TotalNo_atendido, TotalReasignar);
			},
			error: function ( err ){
			console.log( err.responseText );
			}
		});
	}
   // Es el metodo de la grafica.
	function drawClientesAtencionGrupoAsesores(response,  Total, maximo, TotalOportunos, TotalTardios ,TotalNo_atendido, TotalReasignar) {
    	am5.ready(function () {
			var root = am5.Root.new("graficas_clientes_atencion_asesores");
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
				max         : (maximo)*1.3,
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
				max         : (maximo)*1.2,
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
				name                  : `Clientes oportunos : ${TotalOportunos}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "oportunos",
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
			series.set("fill", am5.color("<?= $this->Session->read('colores.Oportuno')?>")); 
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
				name: `Clientes Tardios:  ${TotalTardios}`,
				xAxis: xAxis,
				yAxis: paretoAxis,
				valueYField: "tardios",
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
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Tardio')?>")); 
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
				name: ` Cliente No Atendido: ${TotalNo_atendido}`,
				xAxis: xAxis,
				yAxis: yAxis,
				valueYField: "no_atendido",
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
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Noatendido')?>")); 
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

			var series3 = chart.series.push(am5xy.ColumnSeries.new(root, {
				name: ` Cliente Reasignar: ${TotalReasignar}`,
				xAxis: xAxis,
				yAxis: yAxis,
				valueYField: "reasignar",
				categoryXField: "user_name",
				sequencedInterpolation: true,
				tooltip: am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]:{valueY}"
				})
			}));
			series3.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series3.set("fill", am5.color("<?= $this->Session->read('colores.PorReasignar')?>")); 
			series3.bullets.push(function () {
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
			series3.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
			series2.data.setAll(data);
			series3.data.setAll(data);
		});
  	}
</script>