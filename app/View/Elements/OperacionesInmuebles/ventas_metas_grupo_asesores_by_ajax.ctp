<style>
    #metas_ventas_grupo_asesores{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor" data-toggle='modal'>
		META VS VENTAS (EN UNIDADES)
		<!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="metas_ventas_grupo_asesores" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="metas_ventas_grupo_asesores_periodo_tiempo"></small>
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
    function graficaVentasMetasGrupoAsesoresUnidades( rangoFechas, cuentaId, desarrolloId ,asesorId ){ 
          $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "grafica_ventas_mentas_grupo_asesores")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
			beforeSend: function () {
            	$("#overlay").fadeIn();
        	},
            success: function ( response ) {
				let objetivo  = 0;
				let ventasmes = 0;
				let cumplido  = 0;
				for (let i in response ){
					response[i].cumplido_unidades = parseInt(response[i].cumplido_unidades);
                	response[i].meta_unidades     = parseInt(response[i].meta_unidades);
                	response[i].venta_unidades    = parseInt(response[i].venta_unidades);
					objetivo   += response[i].meta_unidades;
					ventasmes  += response[i].venta_unidades;
            	}

				if(objetivo==0){
					cumplido=0
				}else{
					cumplido=((ventasmes/objetivo)*100);
				}
				cumplido = cumplido.toFixed(2);
				document.getElementById("metas_ventas_grupo_asesores_periodo_tiempo").innerHTML =rangoFechas;
                drawVentasMetasGrupoAsesoresUnidades(response,ventasmes,objetivo,cumplido);
            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    }

    function drawVentasMetasGrupoAsesoresUnidades(response,ventasmes,objetivo,cumplido){

		// Validacion de max monto de % de cumplimiento
		var maxCumplido = 0;

		for( let i in response ){
			if(maxCumplido<response[i].cumplido_unidades){
				maxCumplido = response[i].cumplido_unidades;
			}
		}

        am5.ready(function () {
			var root = am5.Root.new("metas_ventas_grupo_asesores");
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
				maxDeviation: 0,
				categoryField: "asesor",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0,
        		min: 0,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Metas/ Ventas (unidades)",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : maxCumplido * 1.4,
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
				name                  : `Metas: ${objetivo} (unidades)`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "meta_unidades",
				categoryXField        : "asesor",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}: Meta {valueY} (uni)"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Objetivo.unidad')?>")); 
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
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Venta: ${ventasmes} (unidades)`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "venta_unidades",
  				categoryXField: "asesor",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
                    labelText: "{categoryX}: vendidas {valueY} (uni)"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.')}",
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
					valueYField        : "cumplido_unidades",
					categoryXField     : "asesor",
					tooltip            : am5.Tooltip.new(root, {
						pointerOrientation: "horizontal",
						labelText         :"% De cumplimiento: {valueY}%"
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
						populateText: true
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
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
		});    
    }
</script>