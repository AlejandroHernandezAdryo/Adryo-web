<div class="row mt-2">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header bg-blue-is d-flex justify-content-between align-middle">
				<span><b>Históricos de gestión</b></span>
				<span style="float:right">
					Total Leads Historico:<span id="totalLeadsHistorico"></span>
				</span>
			</div>
			<div class="card-block">
				<div class="row">
					<div class="col-sm-12 table-responsive">
						<div class="row p-1">
							<div class="col-sm-12 col-lg-3 mt-1">
								<div class="card-xxs br-05 ">
									<div class="card-block text-sm-center p-1 indicadores">
										<div class="d-flex justify-content-between mb-2 align-middle text-icon">
											<span><small class="small_text">Inversión Total</small></span>
                                            <?= $this->Html->image('mk_icons/trending-up.png', array('class' => 'img-icon' )); ?>   
										</div>
										<div>
											<h4 class="colorH4"><span id="inversionHistorico"></span></h4>
										</div>
										<div class="number">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-3 mt-1">
								<div class="card-xxs br-05 ">
									<div class="card-block text-sm-center p-1 indicadores">
										<div class="d-flex justify-content-between mb-2 align-middle text-icon">
											<span><small class="small_text">Inversión promedio por lead</small></span>
                                            <?= $this->Html->image('mk_icons/stats-chart.png', array('class' => 'img-icon' )); ?>   
										</div>
										<div>
											<h4 class="colorH4"><span id="costoXLeadsHistorico"></span></h4>
										</div>
										<div class="number">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-3 mt-1">
								<div class="card-xxs br-05 ">
									<div class="card-block text-sm-center p-1 indicadores">
										<div class="d-flex justify-content-between mb-2 align-middle text-icon">
											<span><small class="small_text">Ventas (monto)</small></span>
                                            <?= $this->Html->image('mk_icons/DollarCircleFilled.png', array('class' => 'img-icon' )); ?>   
										</div>
										<div>
											<h4 class="colorH4"><span id="ventaMontoHistorico"></span></h4>
										</div>
										<div class="number">
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-3 mt-1">
								<div class="card-xxs br-05 ">
									<div class="card-block text-sm-center p-1 indicadores">
										<div class="d-flex justify-content-between mb-2 align-middle text-icon">
											<div><small class="small_text">Unidades vendidas</small></div>
                                            <?= $this->Html->image('mk_icons/document-text.png', array('class' => 'img-icon' )); ?>   
										</div>
										<div>
											<h4 class="colorH4"><span id="ventaHistorico"></span></h4>
										</div>
										<div class="number">
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

<script>
    function indicadoresHistoricoSeleccionado (  rangoFechas, medioId,  desarrolloId, cuentaId  ) {
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "leads", "action" => "indicadores_historico_seleccionado")); ?>',
            cache: false,
            data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
            dataType: 'json',
            success: function ( response ) {
				document.getElementById("totalLeadsHistorico").innerHTML =response[0]['leads'];
				document.getElementById("inversionHistorico").innerHTML =response[0]['inversion'];
				document.getElementById("ventaHistorico").innerHTML =response[0]['ventas_unidades'];
				document.getElementById("costoXLeadsHistorico").innerHTML =response[0]['costo_leads'];
				document.getElementById("ventaMontoHistorico").innerHTML =response[0]['ventas_monto'];
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
    }
</script>
