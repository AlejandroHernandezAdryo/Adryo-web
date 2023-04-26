<style>
    #grafica_leads_inversion_costoXlead{
        width: 100%;
        height: 500px;
    }
		
</style>
<div class="card">
    <div class="card-header bg-blue-is cursor">
	Total de leads, costo por lead e inversión en publicidad por  medio de promoción  <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="grafica_leads_inversion_costoXlead"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="leads_inversion_costoXlead_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
	function gradicaLeadsCostoInversionDesarrollos(rangoFechas, medioId,  desarrolloId, cuentaId  ){
    	$.ajax({
			type: "POST",
			url: '<?php echo Router::url(array("controller" => "leads", "action" => "grafica_costo_inversion_desarrollos")); ?>',
			cache: false,
			data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
			dataType: 'json',
			success: function ( response ) {
				var maximaInversion       = 0;
				var inversionTotal        = 0;
				var cantidadTotal         = 0;
				var costoTotalXleadsTotal = 0;
				var maximoCostoLead       = 0;
				var maximoLead			  =0;
				for (let i in response){      
					response[i].leads       = parseInt(response[i].leads);
					response[i].costoXleads = parseInt(response[i].costoXleads);
					response[i].inversion   = parseInt(response[i].inversion);
					if(maximaInversion<response[i].inversion){
						maximaInversion = response[i].inversion;
					}
					if(maximoCostoLead<response[i].costoXleads){
						maximoCostoLead = response[i].costoXleads;
					}
					if(maximoLead<response[i].leads){
						maximoLead = response[i].leads;
					}
					inversionTotal += response[i].inversion;
					cantidadTotal  += response[i].leads;
				}
				document.getElementById("leads_inversion_costoXlead_periodo_tiempo").innerHTML =rangoFechas;
				if(maximoCostoLead==0 || maximoCostoLead<maximoLead){
					maximoCostoLead=maximoLead;
				}
				if (maximaInversion==0) {
					maximaInversion=10;
				}
				costoTotalXleadsTotal     = (inversionTotal/ cantidadTotal);  
				costoTotalXleadsTotal = costoTotalXleadsTotal.toFixed(2);
				drawGradicaLeadsCostoInversionDesarrollos( response,maximaInversion,inversionTotal,cantidadTotal,costoTotalXleadsTotal, maximoLead);
			},
			error: function ( err ){
				console.log( err.responseText );
			}
		});
  	}
  
	function drawGradicaLeadsCostoInversionDesarrollos( response,maximaInversion,inversionTotal,cantidadTotal,costoTotalXleadsTotal, maximoLead ) {
    	am5.ready(function () {
			var root = am5.Root.new("grafica_leads_inversion_costoXlead");
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
				max:(maximoLead)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Leads ",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*1.2,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat",'#,###');
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "Inversión y Costo X Leads",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Leads : ${cantidadTotal}`,
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
  				name: `Costo X Leads:$ ${costoTotalXleadsTotal}`,
  				xAxis: xAxis,
  				yAxis: paretoAxis,
  				valueYField: "costoXleads",
  				categoryXField: "medio",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]:{valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.CostoXLead')?>")); 
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
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `Inversión:$ ${inversionTotal}`,
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
			series2.data.setAll(data);
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Inversion')?>"));
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