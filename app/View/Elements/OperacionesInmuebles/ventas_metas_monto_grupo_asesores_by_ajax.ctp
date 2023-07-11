<style>
    #metas_ventas_monto_grupo_asesores{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor" >
		META VS. VENTAS ($ MONTO EN MDP)
	<!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="metas_ventas_monto_grupo_asesores"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="metas_ventas_monto_grupo_asesores_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
    // Se mandan a llamar los datos para la grafica
  function graficaVentasMetasMontoGrupoAsesores( rangoFechas, cuentaId, desarrolloId ,asesorId ){ 
    $.ajax({
		type: "POST",
		url: '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "grafica_ventas_mentas_grupo_asesores")); ?>',
		cache: false,
		data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
		dataType: 'json',
		success: function ( response ) {
			let montoObjetivo  = 0;
			let montoMes   = 0;
			let ventaMontoTotal = 0;
			let cumplido=0;
			let maxObjetivo=0;
			let max=0;
			for (let i in response){
				response[i].meta_dinero    = parseInt(response[i].meta_dinero);
				response[i].venta_dinero   = parseInt(response[i].venta_dinero);
				response[i].cumplido_monto = parseInt(response[i].cumplido_monto);
				response[i].meta_dinero  = ((response[i].meta_dinero)/1000000);
				response[i].venta_dinero = ((response[i].venta_dinero)/1000000);
				montoObjetivo += response[i].meta_dinero;
				montoMes      += response[i].venta_dinero;
				if(maxObjetivo < response[i].venta_dinero){
					maxObjetivo=response[i].venta_dinero
				}
				if(max<response[i].meta_dinero){
					max=response[i].meta_dinero
				}
			}
			if (max  > maxObjetivo) {
				maxObjetivo=max;
			}
			
			if (montoObjetivo==0) {
				cumplido = 0;
			}else{
				cumplido = ((montoMes/montoObjetivo)*100);
			}
			montoMes = montoMes.toFixed(2);
			cumplido = cumplido.toFixed(2);
            // console.log( response );
			document.getElementById("metas_ventas_monto_grupo_asesores_periodo_tiempo").innerHTML =rangoFechas;
			if (maxObjetivo==0) {
				maxObjetivo=10;
			}
			drawgraficaVentasMetasMontoGrupoAsesores(response, montoObjetivo,montoMes,cumplido,maxObjetivo);
	},
	error: function ( err ){
		console.log( err.responseText );
	}
    });
  }
  function drawgraficaVentasMetasMontoGrupoAsesores(response, montoObjetivo,montoMes, cumplido, maxObjetivo){

	// Validacion de max monto de % de cumplimiento
	let maxCumplido = 0;

	for( let i in response ){
		if(maxCumplido<response[i].cumplido_monto){
			maxCumplido = response[i].cumplido_monto;
		}
	}
	

    am5.ready(function () {
			var root = am5.Root.new("metas_ventas_monto_grupo_asesores");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			root.interfaceColors.set("grid", am5.color('#bababa'));
			//
			root.numberFormatter.setAll({
				numberFormat: "#a",

				// Group only into M (millions), and B (billions)
				bigNumberPrefixes: [
					{ number: 1e6, suffix: "MDP" },
					{ number: 1e9, suffix: "B" }
				],

				// Do not use small number prefixes at all
				smallNumberPrefixes: []
			});

			//
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
				categoryField: "asesor",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min         : 0,
				max         : (maxObjetivo)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Metas/ Ventas Monto",
					y: am5.p50,
					centerX: am5.p50
				})
			);

			var data = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : maxCumplido * 1.5,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "% De cumplimiento",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			paretoAxis.set("numberFormat", "#");
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `ventas monto objetivo:$ ${montoObjetivo} MDP`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "meta_dinero",
				categoryXField        : "asesor",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}:Meta ${valueYWorking.formatNumber('#.# a')} monto"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			
			series.set("fill", am5.color("<?= $this->Session->read('colores.Objetivo.monto')?>")); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.# a')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `ventas monto:$  ${montoMes} MDP`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "venta_dinero",
  				categoryXField: "asesor",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
                    labelText: "{categoryX}:Venta ${valueYWorking.formatNumber('#.# a')} monto"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.monto')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.# a')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
						populateText: true
					})
				});
			});
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `% De cumplimiento: ${cumplido}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "cumplido_monto",
					categoryXField     : "asesor",
					tooltip            : am5.Tooltip.new(root, {
						pointerOrientation: "horizontal",
						labelText         :" % De cumpllimiento: {valueY}"
					})
				})
			);

			series2.strokes.template.setAll({
				strokeWidth  : 3,
				templateField: "strokeSettings"
			});
			series2.data.setAll(data);
			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					sprite      : am5.Circle.new(root, {
						strokeWidth: 3,
						stroke     : series2.get("stroke"),
						radius     : 5,
						fill       : root.interfaceColors.get("background")
					})
				});
			});
			chart.set("cursor", am5xy.XYCursor.new(root, {}));

			series2.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite   : am5.Label.new(root, {
						text    : "{valueYWorking.formatNumber('#.')}",
						fill    : root.interfaceColors.get("alternativeText"),
						centerY : 0,
						centerX : am5.p50,
						fill    : am5.color(0x000000),
						populateText: true,
					})
				});
			})
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
			series2.appear(1000);
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
	});    
  }
</script>