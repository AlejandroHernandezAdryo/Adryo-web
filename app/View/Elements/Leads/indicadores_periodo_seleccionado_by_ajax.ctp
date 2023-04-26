<!-- <style>
	
</style> -->
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header bg-blue-is d-flex justify-content-between align-middle">
				<div col-sm-12>
					<span class="title_card">Indicadores de gestión</span>
						<!-- <span style="float:right" >
							Total Leads Periodo: <span id="totalLeads"></span>
						</span> -->
					</div>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<div class="row p-1">
							<div class="col-sm-12" style="display:flex;flex-wrap:wrap;justify-content:space-evenly;column-gap:8px;">

								<!-- card Total de leads -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/data_total.png', array('class' => 'img-icon', 'style' => 'height:30px;width:30px;color:#376D6C !important;' )); ?>   
										</div>
										<div class="text-center mb-1">
											<p class="numbers_cards" id="totalLeads"></p>
										</div>
										<div class="text-center">
											<span>Total de leads</span>
										</div>
									</div>
								</div>
								<!-- card Inversión total -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/currency_exchange.png', array('class' => 'img-icon', 'style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center mb-1">
											<p class="numbers_cards" id="inversionPeriodo"></p>
										</div>
										<div class="text-center">
											<span>Inversión total</span>
										</div>
									</div>
								</div>
								<!-- card promedio de leads -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/price_check.png', array('class' => 'img-icon','style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center">
											<h4><span class="numbers_cards" id="promedioLeadsPeriodo"></span></h4>
										</div>
										<div class="text-center">
											<span>Promedio mensual de leads</span>
										</div>
									</div>
								</div>
								<!-- card costo promedio por lead -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/data_usage.png', array('class' => 'img-icon','style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center">
											<h4><span class="numbers_cards" id="costoXLeadsPeriodo"></span></h4>
										</div>
										<div class="text-center">
											<span>Costo promedio por lead</span>
										</div>
									</div>
								</div>
								<!-- card inversion promedio mensual -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/legend_toggle.png', array('class' => 'img-icon', 'style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center">
											<h4><span class="numbers_cards" id="inversionPromedioPeriodo"></span></h4>
										</div>
										<div class="text-center">
											<span>Inversión promedio mensual</span>
										</div>
									</div>
								</div>
								<!-- card unidades vendidas -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1  indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/dots.png', array('class' => 'img-icon','style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center">
											<h4><span class="numbers_cards" id="unidadesVendidasPeriodo"></span></h4>
										</div>
										<div class="text-center">
											<span>Unidades vendidas</span>
										</div>
									</div>
								</div>
								<!-- card Ventas (monto) -->
								<div class="card-xxs br-05 mb-1" style="width:300px;">
									<div class="card-block p-1 indicadores" style="height:100%">
										<div class="mb-1">
											<?= $this->Html->image('mk_icons/data_saver_on.png', array('class' => 'img-icon','style' => 'height:30px;width:30px;' )); ?>   
										</div>
										<div class="text-center">
											<h4><span class="numbers_cards" id="ventaMontoPeriodo"></span></h4>
										</div>
										<div class="text-center">
											<span>Ventas (monto)</span>
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

    '/vendors/chosen/js/chosen.jquery',
    'pages/form_elements',

    'form',
  ], array('inline'=>false));
?>
<script>
    function indicadoresPeriodoSeleccionado (  rangoFechas, medioId,  desarrolloId, cuentaId  ) {
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "leads", "action" => "indicadores_periodo_seleccionado")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
            dataType: 'json',
            success: function ( response ) {
				document.getElementById("totalLeads").innerHTML               = response[0]['leads'];
				document.getElementById("inversionPeriodo").innerHTML         = response[0]['inversion'];
				document.getElementById("inversionPromedioPeriodo").innerHTML = response[0]['inversio_mensual'];
				document.getElementById("costoXLeadsPeriodo").innerHTML       = response[0]['costo_leads'];
				document.getElementById("ventaMontoPeriodo").innerHTML        = response[0]['ventas_monto'];
				document.getElementById("promedioLeadsPeriodo").innerHTML     = response[0]['promedio_leads'];
				document.getElementById("unidadesVendidasPeriodo").innerHTML  = response[0]['ventas_unidades'];
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
    }
</script>