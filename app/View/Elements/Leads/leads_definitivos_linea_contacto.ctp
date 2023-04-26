<style>
    #grafica_definitivos_linea_contacto{
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
              Esta grafica esta enfocada a la tabla de clientes inactivos, 
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
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
		CLIENTES INACTIVOS DEFINITIVOS POR MEDIO DE PROMOCIÓN VS INVERSIÓN EN PUBLICIDAD
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_definitivos_linea_contacto" class="grafica no-imprimir"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="leads_definitivos_linea_contacto_periodo_tiempo"></small>
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
  function graficaDefinitivosLineaContacto( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "leads", "action" => "grafica_definitivos_linea_contacto")); ?>',
      cache: false,
      data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
      dataType: 'json',
      success: function ( response ) {
        var maximaInversion = 0;
        var InversionTotal  = 0;
        var cantidadTotal   = 0;
        var maximoLead      = 0;
        for (let i in response){
          response[i].leads  = parseInt(response[i].leads);
          response[i].inversion = parseInt(response[i].inversion);
          if(maximaInversion<response[i].inversion){
            maximaInversion=response[i].inversion
          }
          if(maximoLead<response[i].leads){
              maximoLead=response[i].leads;
          }
            InversionTotal += response[i].inversion;
            cantidadTotal  += response[i].leads;
        }
        document.getElementById("leads_definitivos_linea_contacto_periodo_tiempo").innerHTML =rangoFechas;
        if (maximoLead==0) {
            maximoLead=10
        }
        if (maximaInversion==0) {
            maximaInversion=10
        }
          drawDefinitivosLineaContacto( response,maximaInversion,InversionTotal,cantidadTotal, maximoLead );
        
      },
      error: function ( err ){
        console.log( err.responseText );
      }
    });
  }
  function drawDefinitivosLineaContacto(response,maximaInversion,InversionTotal,cantidadTotal, maximoLead){
		am5.ready(function () {
			var root = am5.Root.new("grafica_definitivos_linea_contacto");
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
				max: (maximoLead)*1.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Clientes Inacativos",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*2,
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
				name                  : `Clientes Inactivos Definitivos: ${cantidadTotal}`,
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
			
			series.set("fill", am5.color('#555555')); 
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
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `Inversión      :$ ${InversionTotal}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "inversion",
					categoryXField     : "medio",
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
			xAxis.data.setAll(data);
			series.data.setAll(data);
			
		});
  }
</script>
