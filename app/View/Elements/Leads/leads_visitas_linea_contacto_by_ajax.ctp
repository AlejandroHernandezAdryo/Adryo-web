<style>
    #grafica_visitas_linea_contacto{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
		CLIENTES POR MEDIO DE PROMOCIÓN, VISITAS  E INVERSIÓN EN PUBLICIDAD
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_visitas_linea_contacto" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="leads_venta_periodo_tiempo"></small>
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
  function graficaVisitasLineaContacto( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "leads", "action" => "grafica_visitas_linea_contacto")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
        success: function ( response ) {
        	var maximaInversion = 0;
        	var maximaVisita    = 0;
			var InversionTotal  = 0;
			var cantidadTotal   = 0;
			var visitasTotal    = 0;
			var maximoLead      = 0;
			for (let i in response){
            	response[i].leads  = parseInt(response[i].leads);
            	response[i].inversion = parseInt(response[i].inversion);
            	response[i].visitas   = parseInt(response[i].visitas);
				if(maximaInversion<response[i].inversion){
					maximaInversion=response[i].inversion
				}
				if(maximoLead<response[i].leads){
					maximoLead=response[i].leads;
				}
				if (maximaVisita<response[i].visitas) {
					maximaVisita=response[i].visitas;
				}
				InversionTotal += response[i].inversion;
				cantidadTotal  += response[i].leads;
				visitasTotal   += response[i].visitas;
        	}
			document.getElementById("leads_venta_periodo_tiempo").innerHTML =rangoFechas;
			if (maximoLead==0) {
				maximoLead=10;
			}
			if (maximoLead<maximaVisita) {
				maximoLead=maximaVisita;
			}
			if (maximaInversion==0) {
				maximaInversion=10
			}
        	drawGraficaVisitasLineaContacto( response,maximaInversion,InversionTotal,cantidadTotal,visitasTotal, maximoLead );
           
        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });
    

  }
	function drawGraficaVisitasLineaContacto(response,maximaInversion,InversionTotal,cantidadTotal,visitasTotal, maximoLead){
		am5.ready(function () {
			var root = am5.Root.new("grafica_visitas_linea_contacto");
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
				categoryField: "medio",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min         : 0,
				max			: (maximoLead)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Clientes y Visitas",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*1.4,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "#");
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "Inversión",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Clientes : ${cantidadTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "leads",
				categoryXField        : "medio",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Lead')?>")); 
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
  				name: `Visitas: ${visitasTotal}`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "visitas",
  				categoryXField: "medio",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]: {valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Visita')?>")); 
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
					name               : `Inversión: $ ${InversionTotal}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "inversion",
					categoryXField     : "medio",
					stroke			   : am5.color("<?= $this->Session->read('colores.Inversion')?>"),
					tooltip            : am5.Tooltip.new(root, {
						pointerOrientation: "horizontal",
						labelText         : "[bold]{name}[/]:$ {valueY}"
					})
				})
			);

			series2.strokes.template.setAll({
				strokeWidth  : 3,
				templateField: "strokeSettings"
			});
			
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Inversion')?>"));
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
						text: "{valueYWorking.formatNumber('#,###')}",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            			centerY: am5.p100,
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