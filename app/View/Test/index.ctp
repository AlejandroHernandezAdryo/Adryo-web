<?php 
  echo $this->Html->css(
    array(
        // Calendario
      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
      '/vendors/jquery-tagsinput/css/jquery.tagsinput',
      '/vendors/daterangepicker/css/daterangepicker',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      '/vendors/bootstrap-switch/css/bootstrap-switch.min',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/j_timepicker/css/jquery.timepicker',
      '/vendors/datetimepicker/css/DateTimePicker.min',
    ),
    array('inline'=>false)); 
?>
<head>
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <style>
		#chartdiv,#ventasLineaContacto,#status,#etapar,#statusr,#inactivacionDefinitiva,#inactivacionTemporal,#cancelacionesClientes{
  		width: 100%;
  		height: 500px;
		}
</style>
</head>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('User'); ?>
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-calendar"></i>
                  Fechas para reportes
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
            	<div class="col-sm-12">
            		<?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>
            	</div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
              </button>
              <button type="button" class="btn btn-success pull-left" id="submit-btn">
                    <i class="fa fa-search"></i>
                    Buscar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-xs-12">
                <h4 class="nav_top_align">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    CharrJS
                </h4>
            
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="row">
                <div class="col-sm-12 col-lg-12 mt-2">
                    <div class="card">
					<div class="card-header no-imprimir" style="background-color: #2e3c54; color:white;">
						<div class="row">
							<div class="col-sm-12 col-lg-6">
								<h3 class="text-white">reporte de clientes</h3>
							</div>
							<div class="col-sm-12 col-lg-6 text-lg-right">
                				<?= $this->Html->link('<i class="fa fa-calendar fa-2x"></i> Cambiar Rango de Fechas', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no-imprimir','style'=>"color:white")) ?>	
							</div>
						</div>
					</div>
					<div class="row">
							<div class="col-sm-12 col-lg-3 mt-1">
								<img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" class="img-fluid logo-printer">
                                                                
							</div>
							<div class="col-sm-12 col-lg-6 mt-1" style="text-align: center">
								<h1 class="text-sm-center text-black">Reporte de Estatus de Clientes C1</h1>
                  					<b id="periodoReporte" style="font-size:14px"> </b>
                  					<p class="text-lg-center" style="font-size: 1rem;">
									<?= $this->Session->read('CuentaUsuario.Cuenta.razon_social') ?>
									<br>
									<?= $this->Session->read('CuentaUsuario.Cuenta.direccion') ?>
									<br>
									<?= $this->Session->read('CuentaUsuario.Cuenta.telefono_1') ?>
									<br>
									<?= $this->Html->link($this->Session->read('CuentaUsuario.Cuenta.pagina_web'), 'http://'.$this->Session->read('CuentaUsuario.Cuenta.pagina_web'), array('target'=>'_blank')) ?>
								</p>
							</div>
						</div>
                        <div class="card-header bg-blue-is">
                        ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
                        </div>
                        <div class="card-block">
                                <div class="row mt-1"> 
                                    <div class="col-sm-12">
                                        <div class="card-block">
                                            <div class="row mt-1"> 
                                                <div class="col-sm-12">
                                                <div id="chartdiv"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>         
                            <div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        LEADS POR MEDIO DE PROMOCIÓN, VENTAS E INVERSIÓN EN PUBLICIDAD
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="ventasLineaContacto"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							 <div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="status"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        ETAPA DE  CLIENTES ACTIVOS
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="etapar"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        ETAPA DE  CLIENTES ACTIVOS
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="statusr"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        	RAZON DE INACTIVACION DEFINITIVA DE  CLIENTES
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="inactivacionDefinitiva"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        	RAZON DE INACTIVACION TEMPORAL DE  CLIENTES
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="inactivacionTemporal"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
							<div class="row mt-1">
                            	<div class="col-sm-12">
                            		<div class="card">
                            			<div class="card-header bg-blue-is">
                                        	RAZON DE INACTIVACION TEMPORAL DE  CLIENTES
                            			</div>
                            			<div class="card-block">
                            				<div class="row mt-1">
                            					<div class="col-sm-12">
                            						<div class="card-block">
                            							<div class="row mt-1">
                            								<div class="col-sm-12">
                            								<div id="cancelacionesClientes"></div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                        </div>
                    </div>
                </div>
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

    // Calendario
    '/vendors/jquery.uniform/js/jquery.uniform',
	'/vendors/inputlimiter/js/jquery.inputlimiter',
	'/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
	'/vendors/jquery-tagsinput/js/jquery.tagsinput',
	'/vendors/validval/js/jquery.validVal.min',
	'/vendors/inputmask/js/jquery.inputmask.bundle',
	'/vendors/moment/js/moment.min',
	'/vendors/daterangepicker/js/daterangepicker',
	'/vendors/datepicker/js/bootstrap-datepicker.min',
	'/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
	'/vendors/bootstrap-switch/js/bootstrap-switch.min',
	'/vendors/autosize/js/jquery.autosize.min',
	'/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
	'/vendors/jasny-bootstrap/js/inputmask',
	'/vendors/datetimepicker/js/DateTimePicker.min',
	'/vendors/j_timepicker/js/jquery.timepicker.min',
	'/vendors/clockpicker/js/jquery-clockpicker.min',

	'form',

  ], array('inline'=>false));
?>
<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>


<!-- Chart code -->
<script>
	$('#submit-btn').on('click', function() {
	 	var dataString = document.getElementById('date_range').value;
		get_ventas_linea_contacto_arreglo(dataString);
		get_fecha_reporte_inicial(dataString);
	});
	

	$(document).ready(function () {
		var dataString = "<?= '2020-01-01 '.date('Y-m-d') ?>";

		get_fecha_reporte_inicial( dataString );
		get_ventas_linea_contacto_arreglo(dataString);

	});

	function get_fecha_reporte_inicial(dataString){
		$.ajax({
			type    : "POST",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_fecha_reporte_inicial")); ?>",
			cache   : false,
			data	: {rango_fechas: dataString},
			dataType: "json",
			success: function (response) {
				$('#periodoReporte').html('Periodo del: ' + response);
			}
		});
	}
	//
	$(document).ready(function () {
		$('#date_range').daterangepicker({
			orientation: "bottom",
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
		$('#date_range').on('apply.daterangepicker', function (ev, picker) {
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
			return false;
		});

		$('#date_range').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			return false;
		});

	});
	
	function get_ventas_linea_contacto_arreglo(dataString){
		console.log(dataString);
		$.ajax({
  			type   : "POST",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_ventas_linea_contacto_arregloR")); ?>",
  			data   : {rango_fechas: dataString},
			dataType: "json",
  			cache  : false,
  			success: function(response){
				var maximaInversion = 0;
				var InversionTotal  = 0;
				var cantidadTotal   = 0;
				var ventaTotal      = 0;
				for (let i in response){
                	response[i].cantidad  = parseInt(response[i].cantidad);
                	response[i].inversion = parseInt(response[i].inversion);
                	response[i].ventas    = parseInt(response[i].ventas);
					if(maximaInversion<response[i].inversion){
						maximaInversion=response[i].inversion
					}
					InversionTotal += response[i].inversion;
					cantidadTotal  += response[i].cantidad;
					ventaTotal     += response[i].ventas;
            	}
                publicidad_invercion_ventas(response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal);
				console.log(response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal);  
  			} 
		});
	}
			
	// $(document).ready(function () {
  	//     $.ajax({
  	// 	    type    : "GET",
    //         url     :  "<?php //echo Router::url(array("controller" => "clientes", "action" => "get_ventas_linea_contacto_arregloR")); ?>",
    //         cache   : false,
	// 		//data	: $("#rango_fechas")"data",
	// 		dataType: "json",
  	// 	    success : function (response) {
	// 			var maximaInversion = 0;
	// 			var InversionTotal  = 0;
	// 			var cantidadTotal   = 0;
	// 			var ventaTotal      = 0;
	// 			for (let i in response){
    //             	response[i].cantidad  = parseInt(response[i].cantidad);
    //             	response[i].inversion = parseInt(response[i].inversion);
    //             	response[i].ventas    = parseInt(response[i].ventas);
	// 				if(maximaInversion<response[i].inversion){
	// 					maximaInversion=response[i].inversion
	// 				}
	// 				InversionTotal += response[i].inversion;
	// 				cantidadTotal  += response[i].cantidad;
	// 				ventaTotal     += response[i].ventas;
    //         	}
    //             publicidad_invercion_ventas(response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal);
                
    //         },
  	// 	    error: function (response) {
  	// 		    console.log(response.responseText);
  	// 	    },
    //     });
	// });
	$(document).ready(function () {
  	    $.ajax({
  		    type    : "GET",
            url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_visitas_linea_contacto_arregloR")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
  		    success : function (response) {
				var maximaInversion = 0;
				var InversionTotal  = 0;
				var cantidadTotal   = 0;
				var visitasTotal    = 0;
				for (let i in response){
                	response[i].cantidad  = parseInt(response[i].cantidad);
                	response[i].inversion = parseInt(response[i].inversion);
                	response[i].visitas   = parseInt(response[i].visitas);
					if(maximaInversion<response[i].inversion){
						maximaInversion=response[i].inversion
					}
					InversionTotal += response[i].inversion;
					cantidadTotal  += response[i].cantidad;
					visitasTotal   += response[i].visitas;
            	}
				publicidad_invercion_visitas(response,maximaInversion,InversionTotal,cantidadTotal,visitasTotal)
            },
  		    error: function (response) {
  			    console.log(response.responseText);
  		    },
        });
	});
	$(document).ready(function () {
  	    $.ajax({
  		    type    : "GET",
            url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_clientes_statusR")); ?>",
            cache   : false,
			//data	: "data",
			dataType: "json",
  		    success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				estatus_atencion_clientes_activos(response,cantidadTotal);
            },
  		    error: function (response) {
  			    console.log(response.responseText);
  		    },
        });
	});
	$(document).ready(function () {
		$.ajax({
			type    : "GET",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_grafica_etapas_clientes")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
			success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				grafica_etapas_clientes(response,cantidadTotal);
			},
			error: function (response) {
  			    console.log(response.responseText);
  		    },
		});
	});
	$(document).ready(function () {
		$.ajax({
			type    : "GET",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_grafica_status_ac")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
			success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				grafica_status_clientes(response,cantidadTotal)
			},
			error: function (response) {
  			    console.log(response.responseText);
  		    },
		});
	});
	$(document).ready(function () {
		$.ajax({
			type    : "GET",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_grafica_cliente_inectivacion_definitiva")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
			success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				grafica_cliente_inectivacion_definitiva(response);
			},
			error	:function (response) {
  			    console.log(response.responseText);
  		    },
		});
	});
	$(document).ready(function () {
		$.ajax({
			type    : "GET",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_grafica_cliente_inectivacion_temporales")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
			success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				grafica_cliente_inectivacion_temporales(response);
			},
			error	:function (response) {
  			    console.log(response.responseText);
  		    },
		});
	});
	$(document).ready(function () {
		$.ajax({
			type    : "GET",
			url     : "<?php echo Router::url(array("controller" => "clientes", "action" => "get_grafica_cancelacion")); ?>",
			cache   : false,
			//data	: "data",
			dataType: "json",
			success : function (response) {
				var cantidadTotal=0;
				for (let i in response){
					cantidadTotal +=response[i].cantidad;
            	}
				grafica_cancelacion(response);
			},
			error	:function (response) {
  			    console.log(response.responseText);
  		    },
		});
	});
	
	function publicidad_invercion_ventas(response,maximaInversion,InversionTotal,cantidadTotal,ventaTotal){
		am5.ready(function () {
			var root = am5.Root.new("ventasLineaContacto");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
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
				categoryField: "canal",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*2,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "'$'#");
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `leads : ${cantidadTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "cantidad",
				categoryXField        : "canal",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color('#F1B156')); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : root.interfaceColors.get("alternativeText"),
						centerY     : 0,
						centerX     : am5.p50,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Ventas: ${ventaTotal}`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "ventas",
  				categoryXField: "canal",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]:{valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color('#8EB36C')); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.')}",
						fill: root.interfaceColors.get("alternativeText"),
						centerY: 0,
						centerX: am5.p50,
						populateText: true
					})
				});
			});
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `inversion:$ ${InversionTotal}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "inversion",
					categoryXField     : "canal",
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
	function publicidad_invercion_visitas(response,maximaInversion,InversionTotal,cantidadTotal,visitasTotal){
		am5.ready(function () {
			var root = am5.Root.new("chartdiv");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
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
				categoryField: "canal",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));
			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			var data               = response;
			var paretoAxisRenderer = am5xy.AxisRendererY.new(root, {opposite:true});
			var paretoAxis         = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  				renderer    : paretoAxisRenderer,
  				min         : 0,
  				max         : (maximaInversion)*2,
  				strictMinMax: true
			}));
			paretoAxisRenderer.grid.template.set("forceHidden", true);
			paretoAxis.set("numberFormat", "'$'#");
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name                  : `leads : ${cantidadTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "cantidad",
				categoryXField        : "canal",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "[bold]{name}[/]: {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series.set("fill", am5.color('#F1B156')); 
			series.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY    : 1,
					sprite       : am5.Label.new(root, {
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : root.interfaceColors.get("alternativeText"),
						centerY     : 0,
						centerX     : am5.p50,
						populateText: true
					})
				});
			})
			var series1 = chart.series.push(am5xy.ColumnSeries.new(root, {
  				name: `Visitas: ${visitasTotal}`,
  				xAxis: xAxis,
  				yAxis: yAxis,
  				valueYField: "visitas",
  				categoryXField: "canal",
				sequencedInterpolation: true,
  				tooltip: am5.Tooltip.new(root, {
    				labelText: "[bold]{name}[/]: {valueY}"
  				})
			}));
			series1.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
			series1.set("fill", am5.color('#99C6C7')); 
			series1.bullets.push(function () {
				return am5.Bullet.new(root, {
					locationY: 1,
					sprite: am5.Label.new(root, {
						text: "{valueYWorking.formatNumber('#.')}",
						fill: root.interfaceColors.get("alternativeText"),
						centerY: 0,
						centerX: am5.p50,
						populateText: true
					})
				});
			});
			var series2 = chart.series.push(
				am5xy.LineSeries.new(root, {
					name               : `inversion      :$ ${InversionTotal}`,
					xAxis              : xAxis,
					yAxis              : paretoAxis,
					valueYField        : "inversion",
					categoryXField     : "canal",
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
	function estatus_atencion_clientes_activos(response,cantidadTotal) {
		am5.ready(function () {
			var root = am5.Root.new("status");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX: true,
				panY: true,
				wheelX: "panX",
				wheelY: "zoomX",
				pinchZoomX: true
			}));
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineY.set("visible", false);
			var xRenderer = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation: -90,
				centerY: am5.p50,
				centerX: am5.p100,
				paddingRight: 15
			});

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation: 0.3,
				categoryField: "status",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				renderer: am5xy.AxisRendererY.new(root, {})
			}));
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name:`Status : ${cantidadTotal}`,
				xAxis: xAxis,
				yAxis: yAxis,
				valueYField: 'cantidad',
				sequencedInterpolation: true,
				categoryXField:	'status' ,
				tooltip: am5.Tooltip.new(root, {
					labelText: "{categoryX}:Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
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
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : root.interfaceColors.get("alternativeText"),
						centerY     : 0,
						centerX     : am5.p50,
						populateText: true
					})
				});
			})
			var data=response;
			xAxis.data.setAll(data);
			series.data.setAll(data);
			series.appear(1000);
			chart.appear(1000, 100);

		}); 
	}
	function grafica_etapas_clientes(response,cantidadTotal) {
		am5.ready(function () {
			var root = am5.Root.new("etapar");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX: true,
				panY: true,
				wheelX: "panX",
				wheelY: "zoomX",
				pinchZoomX: true
			}));
			var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
			cursor.lineY.set("visible", false);
			var xRenderer = am5xy.AxisRendererX.new(root, {
				minGridDistance: 30
			});
			xRenderer.labels.template.setAll({
				rotation: -90,
				centerY: am5.p50,
				centerX: am5.p100,
				paddingRight: 15
			});

			var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
				maxDeviation: 0.3,
				categoryField: "etapa",
				renderer: xRenderer,
				tooltip: am5.Tooltip.new(root, {})
			}));

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				renderer: am5xy.AxisRendererY.new(root, {})
			}));
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name: `Etapa : ${cantidadTotal}`,
				xAxis: xAxis,
				yAxis: yAxis,
				valueYField: "cantidad",
				sequencedInterpolation: true,
				categoryXField: "etapa",
				tooltip: am5.Tooltip.new(root, {
					labelText: "{categoryX}: Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
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
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : root.interfaceColors.get("alternativeText"),
						centerY     : 0,
						centerX     : am5.p50,
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
	function grafica_status_clientes(response,cantidadTotal) {
		am5.ready(function () {
			var root = am5.Root.new("statusr");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5xy.XYChart.new(root, {
				panX      : true,
				panY      : true,
				wheelX    : "panX",
				wheelY    : "zoomX",
				pinchZoomX: true
			}));
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
				maxDeviation : 0.3,
				categoryField: "status",
				renderer     : xRenderer,
				tooltip      : am5.Tooltip.new(root, {})
			}));

			var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
				maxDeviation: 0.3,
				renderer    : am5xy.AxisRendererY.new(root, {})
			}));
			var series = chart.series.push(am5xy.ColumnSeries.new(root, {
				name				  : `Status : ${cantidadTotal}`,
				xAxis                 : xAxis,
				yAxis                 : yAxis,
				valueYField           : "cantidad",
				categoryXField        : "status",
				sequencedInterpolation: true,
				tooltip               : am5.Tooltip.new(root, {
					labelText: "{categoryX}: Cantidad {valueY}"
				})
			}));

			series.columns.template.setAll({
				cornerRadiusTL: 5,
				cornerRadiusTR: 5
			});
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
						text        : "{valueYWorking.formatNumber('#.')}",
						fill        : root.interfaceColors.get("alternativeText"),
						centerY     : 0,
						centerX     : am5.p50,
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
	function grafica_cliente_inectivacion_definitiva(response) {
		am5.ready(function () {
			var root = am5.Root.new("inactivacionDefinitiva");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5percent.PieChart.new(root, {
				layout     : root.verticalLayout,
				innerRadius: am5.percent(50)
			}));
			var series = chart.series.push(am5percent.PieSeries.new(root, {
				name           : "inectivos definitivos",
				valueField     : "cantidad",
				categoryField  : "razon",
				legendLabelText: "[{fill}]{category}[/]",
				legendValueText: "[bold {fill}]{value}[/]",
				
			}));
			series.slices.template.set('tooltipText', '{category}: {value}');
			series.labels.template.set('text', '{category}: {value}');
			series.labels.template.set("visible", false);
			series.ticks.template.set("visible", false);
			
			series.labels.template.setAll({
				textType: "circular",
				centerX : 0,
				centerY : 0
			});
			var data = response;
			series.data.setAll(data);
			var legend = chart.children.push(am5.Legend.new(root, {
				centerX     : am5.percent(50),
				x           : am5.percent(50),
				marginTop   : 15,
				marginBottom: 15,
			}));
			legend.data.setAll(series.dataItems);
			series.appear(1000, 100);

		}); 
	}
	function grafica_cliente_inectivacion_temporales(response) {
		am5.ready(function () {
			var root = am5.Root.new("inactivacionTemporal");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5percent.PieChart.new(root, {
				layout: root.verticalLayout,
				innerRadius: am5.percent(50)
			}));
			var series = chart.series.push(am5percent.PieSeries.new(root, {
				name: "inectivos temporales",
				valueField: "cantidad",
				categoryField: "razon",
				legendLabelText: "[{fill}]{category}[/]",
				legendValueText: "[bold {fill}]{value}[/]",
				alignLabels: false,

			}));
			series.slices.template.set('tooltipText', '{category}: {value}');
			series.labels.template.set('text', '{category}: {value}');
			series.labels.template.set("visible", false);
			series.ticks.template.set("visible", false);

			series.labels.template.setAll({
				textType: "circular",
				centerX: 0,
				centerY: 0
			});
			var data = response;
			series.data.setAll(data);
			var legend = chart.children.push(am5.Legend.new(root, {
				centerX: am5.percent(50),
				x: am5.percent(50),
				marginTop: 15,
				marginBottom: 15,
			}));
			legend.data.setAll(series.dataItems);
			series.appear(1000, 100);

		}); // end am5.ready()
	}
	function grafica_cancelacion(response){
		am5.ready(function () {
			var root = am5.Root.new("cancelacionesClientes");
			root.setThemes([
				am5themes_Animated.new(root)
			]);
			var chart = root.container.children.push(am5percent.PieChart.new(root, {
				layout: root.verticalLayout,
				innerRadius: am5.percent(50)
			}));
			var series = chart.series.push(am5percent.PieSeries.new(root, {
				name: "cancelacion",
				valueField: "cantidad",
				categoryField: "razon",
				legendLabelText: "[{fill}]{category}[/]",
				legendValueText: "[bold {fill}]{value}[/]",
				alignLabels: false,

			}));
			series.slices.template.set('tooltipText', '{category}: {value}');
			series.labels.template.set('text', '{category}: {value}');
			series.labels.template.set("visible", false);
			series.ticks.template.set("visible", false);

			series.labels.template.setAll({
				textType: "circular",
				centerX: 0,
				centerY: 0
			});
			var data = response;
			series.data.setAll(data);
			var legend = chart.children.push(am5.Legend.new(root, {
				centerX: am5.percent(50),
				x: am5.percent(50),
				marginTop: 15,
				marginBottom: 15,
			}));
			legend.data.setAll(series.dataItems);
			series.appear(1000, 100);

		}); // end am5.ready()	
	}
</script>







