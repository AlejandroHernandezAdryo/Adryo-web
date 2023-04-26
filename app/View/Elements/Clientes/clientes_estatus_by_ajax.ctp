<style>
	#statusClientesTotales{
  	width: 100%;
  	height: 500px;
	}
</style>


<div class="card">
    <div class="card-header bg-blue-is cursor">
        ESTATUS GENERAL DE CLIENTES 
        <!-- <i class='fa fa-exclamation-triangle fa-x2'></i> -->
        <span style="float:right">
            Clientes Act + Clientes IT: <span id='totalClientesEstatusListado'></span>
            Total: <span id="totalClientesEstatus"></span>
        </span>
    </div>

    <div class="card-block" style="width: 100%;">
      <div class="row">
        <div class="col-sm-12" >
          <div id="statusClientesTotales"></div>
        </div>
        <div class="col-sm-12 m-t-35">
          <small id="cliente_estatus_periodo_tiempo"></small>
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
  //Se mandan a llamar los datos para la grafica
  // $(document).ready(function () {
  //   graficaClientesEstatus();
  // });
  function graficaClientesEstatus( rangoFechas, cuentaId, desarrolloId ,asesorId ){
    
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "grafica_clientes_estatus")); ?>',
        cache: false,
        data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
        dataType: 'json',
        // beforeSend: function () {
        //     $("#overlay").fadeIn();
        // },
        success: function ( response ) {
          var clientesActivos = 0;
          var clientesTemporales  = 0;
          var activosTemporales   = 0;
          var Total = 0;
			    for (let i in response){
            response[i].cantidad  = parseInt(response[i].cantidad);
            if (response[i].estado=="Activos") {
              clientesActivos +=response[i].cantidad;
            }
            if (response[i].estado=="Inactivos temporal") {
              clientesTemporales +=response[i].cantidad;
            }
            activosTemporales =clientesActivos+clientesTemporales;
            Total += response[i].cantidad;
        	}
          document.getElementById("totalClientesEstatusListado").innerHTML =activosTemporales;
          document.getElementById("totalClientesEstatus").innerHTML =Total;
          document.getElementById("cliente_estatus_periodo_tiempo").innerHTML =rangoFechas;
          if(Total==0){
            Total=5;
          }
       
          drawClientesEstatus( response,Total );
          
          
        },
        error: function ( err ){
          console.log( err.responseText );
        }
    });

  }
  
  // Es el metodo de la grafica.
  function drawClientesEstatus( response, Total ) {
    am5.ready(function() {
      let maybeDisposeRoot = (divId) => {
        am5.array.each(am5.registry.rootElements, function (root) {
          if (root.dom.id == divId) {
            root.dispose();
          }
        });
      };
  
      maybeDisposeRoot('statusClientesTotales');
      var root = am5.Root.new("statusClientesTotales");
      root.container.children.clear();
			root.setThemes([
				am5themes_Animated.new(root)
			]);
      
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX      : true,
				panY      : true,
				wheelX    : "panX",
				pinchZoomX: true
			}));
      root.interfaceColors.set("grid", am5.color('#bababa'));
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			  cursor.lineY.set("visible", false);
			var xRenderer = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation    : -90,
				centerY     : am5.p50,
				centerX     : am5.p100,
				paddingRight: 15
			});

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation : 0,
				categoryField: "estado",
				renderer     : xRenderer,
				tooltip      : am5.Tooltip.new(root, {})
			}));

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0,
        min: 0,
        max: Total *1.4,
				renderer    : am5xy.AxisRendererY.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
			}));
      
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name				  : `Clientes Totales : ${Total}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "cantidad",
				categoryXField        : "estado",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "{categoryX}: Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
      chart.get("colors").set("colors", [
       
        am5.color("<?= $this->Session->read('colores.Activo')?>"),
        am5.color("<?= $this->Session->read('colores.InactivoTemporal')?>"),
        am5.color( "<?= $this->Session->read('colores.InactivoDefinitivo')?>"),
      ]);
			series.columns.template.adapters.add("fill", function (fill, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});

			series.columns.template.adapters.add("stroke", function (stroke, target) {
				return chart.get("colors").getIndex(series.columns.indexOf(target));
			});
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{cantidad} ",
						fill        : am5.color(0x000000),
						centerX: am5.p50,
            centerY: am5.p100,
						populateText: true
					})
				});
			})
      
			var data = response;
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series.appear(1000);
			chart.appear(1000, 100);
		});
  }

  // Metodo para restar dias
  function restarDias(fecha, dias){
    fecha.setDate(fecha.getDate() - dias);

    let day = fecha.getDate();
    let month = fecha.getMonth() + 1;
    let year = fecha.getFullYear();

    fecha = year + '-' + month + '-' + day;


    return fecha;
  }

  // Metodo para formatear la fecha en dm/m/Y
  function fechaformatoDMYHoy(){
    let date = new Date()

    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    
    fecha = year + '-' + month + '-' + day;

    return fecha;
    
  }

</script>