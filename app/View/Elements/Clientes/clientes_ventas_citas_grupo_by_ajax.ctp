<style>
    #clientes_ventas_citas_grupo{
        width: 100%;
        height: 500px;
    }
		
</style>

<div class="card">
    <div class="card-header bg-blue-is cursor">
        TOTAL DE CLIENTES VS CITAS Y VENTAS
		<span style="float:right">
            Total Ventas: <span id="VentasTotales"></span>

            Total Citas: <span id="CitasTotales"></span>
            
			Total Clientes: <span id="ClientesTotales"></span> 
        </span>
		
		
    </div>

    <div class="card-block" style="width: 100%;">
        <div class="row">
            <div class="col-sm-12" >
                <div id="clientes_ventas_citas_grupo" ></div>
            </div>
                <div class="col-sm-12 m-t-35">
                    <small id="clientes_ventas_citas_grupo_periodo_tiempo"></small>
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
    function ClienteVentasCitasGrupoAsesor( rangoFechas, cuentaId, desarrolloId ,asesorId ){
        
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "Clientes", "action" => "clientes_citas_ventas_grupo")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas, cuenta_id: cuentaId,  desarrollo_id: desarrolloId, user_id: asesorId },
            dataType: 'json',
            // beforeSend: function () {
            //     $("#overlay").fadeIn();
            // },
            success: function ( response ) {
				let Total_Clientes=0;
				let Total_ventas=0;
				let Total_citas=0; 
				let maxCitas=0;
				let maxClientes=0;
				let max=0;
				for (let i in response){
					response[i].clientes  = parseInt(response[i].clientes);
					response[i].citas  = parseInt(response[i].citas);
					response[i].ventas  = parseInt(response[i].ventas);
					Total_Clientes += response[i].clientes;
					Total_ventas += response[i].ventas;
					Total_citas += response[i].citas;
					
					if(maxCitas < response[i].citas){
						maxCitas = response[i].citas;
					}
					if(maxClientes < response[i].clientes){
						maxClientes = response[i].clientes;
					}
        		}
				if (maxCitas  < maxClientes ) {
					max = maxClientes ;
				}else{
					max = maxCitas ;
				}
				document.getElementById("clientes_ventas_citas_grupo_periodo_tiempo").innerHTML =rangoFechas;
				document.getElementById("ClientesTotales").innerHTML =Total_Clientes;
				document.getElementById("CitasTotales").innerHTML =Total_citas;
				document.getElementById("VentasTotales").innerHTML =Total_ventas;
               	drawClientesCitasVentasGruposAsesores( response, max, Total_citas,Total_ventas, Total_Clientes);

        	},
            error: function ( err ){
            console.log( err.responseText );
            }
        });
        

    }
    function drawClientesCitasVentasGruposAsesores( response, max, Total_citas,Total_ventas, Total_Clientes) {
		am5.ready(function() {
			var root = am5.Root.new("clientes_ventas_citas_grupo");

			root.setThemes([
			am5themes_Animated.new(root)
			]);

			var chart = root.container.children.push(am5xy.XYChart.new(root, {
			panX: false,
			panY: false,
			wheelX: "panX",
			wheelY: "zoomX",
			layout: root.verticalLayout
			}));

			var legend = chart.children.push(
			am5.Legend.new(root, {
				centerX: am5.p50,
				x: am5.p50
			})
			);

			var data = response;

			var xRenderer = am5xy.AxisRendererX.new(root, {
				cellStartLocation: 0.1,
				cellEndLocation: 0.9
			})

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				categoryField: "user_name",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));

			xRenderer.grid.template.setAll({
				location: 1
			})
			
			xAxis.data.setAll(data);

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min:0,
				max         : (max)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			// var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
			// 	renderer: am5xy.AxisRendererY.new(root, {
			// 		strokeOpacity: 0.1,
				
			// 	})
			// }));

			function makeSeries(name, fieldName) {
				var series = chart.series.push(am5xy.ColumnSeries.new(root, {
					name: name,
					xAxis: xAxis,
					yAxis: yAxis,
					valueYField: fieldName,
					categoryXField: "user_name",
					tooltip : am5.Tooltip.new(root, {
						labelText: "{categoryX}: Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				tooltipText: "{name}, {categoryX}:{valueY}",
				width: am5.percent(90),
				tooltipY: 0,
				strokeOpacity: 0
			});

			series.data.setAll(data);
			series.appear();
			series.bullets.push(function() {
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
			});

			legend.data.push(series);
			}

			makeSeries("Clientes", "clientes");
			makeSeries("Citas", "citas");
			makeSeries("Ventas", "ventas");
			// makeSeries("Reasignar", "reasignar");

			chart.appear(1000, 100);

		}); 
	}
</script>