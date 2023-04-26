<style>
    #grafica_clientes_asignados{
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
              no hay datos jaja

            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
    <div class="card-header bg-blue-is cursor"  data-toggle='modal'>
        CLIENTES ASIGNADOS POR MES 
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="grafica_clientes_asignados" class="grafica"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="grafica_clientes_asignados_periodo_tiempo"></small>
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
    
    function graficaClientesAsignados( rangoFechas, cuentaId, desarrolloId ,asesorId ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "asignacion_clientes_asesor")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            success: function ( response ) {

              document.getElementById("grafica_clientes_asignados_periodo_tiempo").innerHTML =rangoFechas;
              var asignadosTotal=0;
              var maxAsignados=0;
              var max=0;
              for (let i in response){
                response[i].asignados  = parseInt(response[i].asignados);
                asignadosTotal 	   += response[i].asignados;
                if(maxAsignados<response[i].asignados){
                  maxAsignados=response[i].asignados;
                }
              }
              if (maxAsignados==0) {
                maxAsignados=5
              }
                drawGraficaClientesAsignados( response,asignadosTotal,maxAsignados );

            },
            error: function ( err ){
            console.log( err.responseText );
            }
        });
    
    }
    function drawGraficaClientesAsignados( response,asignadosTotal,maxAsignados ) {
    	am5.ready(function () {
			var root = am5.Root.new("grafica_clientes_asignados");
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
			root.interfaceColors.set("grid", am5.color('#bababa'));
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
				categoryField: "fecha",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        		min: 0,
				max: (maxAsignados)*1.3,
				maxDeviation: 0.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			var data = response;
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `asignados: ${asignadosTotal} `,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "asignados",
				categoryXField        : "fecha",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
                    labelText: "{categoryX}: venta {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color('#bffa77')); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : " {valueY}",
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