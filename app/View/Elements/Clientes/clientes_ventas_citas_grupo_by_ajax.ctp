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
		am5.ready(function () {
			var root = am5.Root.new("clientes_ventas_citas_grupo");
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
				categoryField: "asesor",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				min   		: 0,
				max         : (max)*1.1,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			yAxis.children.unshift(
				am5.Label.new(root, {
					rotation: -90,
					text: "Clientes y Citas",
					y: am5.p50,
					centerX: am5.p50
				})
			);
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				renderer    : paretoAxisRenderer,
				min         : 0,
				max         : (max)*1.1,
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
					
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `Clientes : ${Total_Clientes}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "clientes",
				categoryXField        : "asesor",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color("<?= $this->Session->read('colores.Cliente')?>")); 
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
				name: `Citas:  ${Total_citas}`,
				xAxis: xAxis,
				yAxis: paretoAxis,
				valueYField: "citas",
					categoryXField: "asesor",
					sequencedInterpolation: true,
				tooltip: am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]:{valueY}"
				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color("<?= $this->Session->read('colores.Cita')?>")); 
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
			name: `Ventas: ${Total_ventas}`,
			xAxis: xAxis,
			yAxis: yAxis,
			valueYField: "ventas",
				categoryXField: "asesor",
				sequencedInterpolation: true,
			tooltip: am5.Tooltip.new(root, {
				labelText: "[bold]{name}[/]:{valueY}"
			})
			}));
			series2.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series2.set("fill", am5.color("<?= $this->Session->read('colores.Ventas.unidad')?>")); 
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
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series1.data.setAll(data);
			series2.data.setAll(data);
		});		
	}
</script>