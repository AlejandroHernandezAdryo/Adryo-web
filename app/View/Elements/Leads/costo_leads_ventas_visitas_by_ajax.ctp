<style>
    #grafica_costo_leads_ventas_visitas_costoXlead{
        width: 100%;
        height: 500px;
    }
		
</style>
<div class="modal fade" id="">
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
                leads de los desarrollos seleccionados y visitas
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
    CITAS, VISITAS Y VENTAS POR MEDIO DE PROMOCIÓN  <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
            <div id="grafica_costo_leads_ventas_visitas_costoXlead"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="costo_leads_ventas_visitas_costoXlead_periodo_tiempo"></small>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
  function gradicaCostoLeadsVisitasVentasDesarrollos(rangoFechas, medioId,  desarrolloId, cuentaId  ){
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "leads", "action" => "costo_leads_ventas_visitas")); ?>',
      cache: false,
      data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
      dataType: 'json',
      success: function ( response ) {
        var maximaCitas       = 0;
        var inversionTotal        = 0;
        var visitasTotal          = 0;
        var ventasTotal           = 0;
        var citastotales = 0;
        var maximovisitas       = 0;
        for (let i in response){      
          response[i].visitas       = parseInt(response[i].visitas);
          response[i].ventas       = parseInt(response[i].ventas);
          response[i].citas = parseInt(response[i].citas);
          response[i].inversion   = parseInt(response[i].inversion);
          if(maximaCitas<response[i].citas){
            maximaCitas = response[i].citas;
          }
          if(maximovisitas<response[i].visitas){
            maximovisitas = response[i].visitas;
          }
          visitasTotal  += response[i].visitas;
          ventasTotal  += response[i].ventas;
		  citastotales +=response[i].citas;
        }
        document.getElementById("costo_leads_ventas_visitas_costoXlead_periodo_tiempo").innerHTML =rangoFechas;
        if(maximovisitas==0){
          maximovisitas=10;
        }
        if (maximaCitas==0) {
			maximaCitas=10;
        }
		// costoTotalXleadsTotal =
		// console.log(response);
        drawGradicaCostoLeadsVisitasVentasDesarrollos( response,visitasTotal, maximovisitas,ventasTotal, citastotales, maximaCitas );
			},//0: {medio: 'Facebook', costoXleads: 238.09523809524, visitas: '3', ventas: 0, inversion: '15000'}
			error: function ( err ){
			  console.log( err.responseText );
			}
		});
  }
  
  function drawGradicaCostoLeadsVisitasVentasDesarrollos(response,visitasTotal, maximovisitas,ventasTotal, citastotales, maximaCitas ) {
    am5.ready(function () {
			var root = am5.Root.new("grafica_costo_leads_ventas_visitas_costoXlead");
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
				max			:(maximovisitas)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Citas y Visitas",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaCitas)*1.3,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "#");
			paretoAxis.children.push(
				am5.Label.new(root, {
					rotation: -90,
					text: "Ventas",
					y: am5.p50,
					centerX: am5.p50
				})
			);

			var series3 = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Citas : ${citastotales}`,
				xAxis                 : xAxis,
				yAxis                 : paretoAxis,
				valueYField           : "citas",
				categoryXField        : "medio",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series3.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series3.set("fill", am5.color("<?= $this->Session->read('colores.Cita')?>")); 
			series3.bullets.push(function () {
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
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Visitas : ${visitasTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "visitas",
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
			series.set("fill", am5.color("<?= $this->Session->read('colores.Visita')?>")); 
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
  				name: `Ventas: ${ventasTotal}`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "ventas",
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
			// var series2 = chart.series.push(
			// 	am5xy.LineSeries.new(root, {
			// 		// name               : `Costo X Lead:$ ${costoTotalXleadsTotal}`,
			// 		name               : `Costo X Lead`,
			// 		xAxis              : xAxis,
			// 		yAxis              : paretoAxis,
			// 		valueYField        : "costoXleads",
			// 		categoryXField     : "medio",
			// 		tooltip            : am5.Tooltip.new(root, {
			// 			pointerOrientation: "horizontal",
			// 			labelText         : "[bold]{name}[/]:$ {valueY}"
			// 		})
			// 	})
			// );
            // //2950a8
			// series2.strokes.template.setAll({
			// 	strokeWidth  : 3,
			// 	templateField: "strokeSettings"
			// });
			// series2.data.setAll(data);
			// series2.bullets.push(function () {
			// 	return am5.Bullet.new(root, {
			// 		sprite      : am5.Circle.new(root, {
			// 			strokeWidth: 3,
			// 			stroke     : series2.get("stroke"),
			// 			radius     : 5,
			// 			fill       : root.interfaceColors.get("background")
			// 		})
			// 	});
			// });
			// chart.set("cursor", am5xy.XYCursor.new(root, {}));
			// series2.bullets.push(function () {
			// 	return am5.Bullet.new(root, {
			// 		locationY: 1,
			// 		sprite   : am5.Label.new(root, {
			// 			text    : "{valueYWorking.formatNumber('#.')}",
			// 			fill        : am5.color(0x000000),
			// 			centerX: am5.p50,
            // 			centerY: am5.p100,
			// 			populateText: true
			// 		})
			// 	});
			// })
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
			series3.appear();
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
			series3.data.setAll(data);
	  });
  }
</script>