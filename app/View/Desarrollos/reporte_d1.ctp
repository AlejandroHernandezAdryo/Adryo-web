<?php
  $rd_tot_monto_venta = 0;
  $rd_tot_unidades_venta = 0;
  date_default_timezone_set('America/Mexico_City');
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

      '/vendors/chosen/css/chosen',
      '/vendors/fileinput/css/fileinput.min',
      'pages/layouts',

      'pages/widgets',

    ),
    array('inline'=>false));
?>
<style>

  .widget_icon_bgclr {
    height: 100px;

  }

  .chosen-container-multi .chosen-choices {
    border: 1px solid rgba(0, 0, 0, 0.15) !important;
  }
  .chosen-choices{
    height: 75px !important;
    overflow-y: auto !important;
  }

  .chosen-container {
      max-height: 75px;
  }

  .bg-orange{ color: #FFFFFF; background-color: #F68514; }
  .bg-brow{ color: #FFFFFF; background-color: #F1A705; }
  .bg-blue-rey{ color: #FFFFFF; background-color: #2950A8; }
  .bg-blue-ligth{ color: #FFFFFF; background-color: #67A4EA; }
  .bg-grey{ color: #FFFFFF; background-color: #828282; }
  .bg-green{ color: #FFFFFF; background-color: #378B25; }
  .bg-green-ligth{ color: #FFFFFF; background-color: #54AA2D; }

  .bg-orange-o{ color: #FFFFFF; background-color: #F68514; opacity: 0.80;}
  .bg-brow-o{ color: #FFFFFF; background-color: #F1A705; opacity: 0.80;}
  .bg-blue-rey-o{ color: #FFFFFF; background-color: #2950A8; opacity: 0.80;}
  .bg-blue-ligth-o{ color: #FFFFFF; background-color: #67A4EA; opacity: 0.80;}
  .bg-grey-o{ color: #FFFFFF; background-color: #828282; opacity: 0.80;}
  .bg-green-o{ color: #FFFFFF; background-color: #378B25; opacity: 0.80;}
  .bg-green-ligth-o{ color: #FFFFFF; background-color: #54AA2D; opacity: 0.80;}

  .br-05{
    border-radius: 5px !important;
  }
  .card-xxs{
    min-height: 80;
  }
  .card-xs{
    min-height: 120px;
  }
  .chips{
      border-radius: 5px;
      text-align: center;
      -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
      -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
      box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
  }

	.text-black{
		color: black;
	}
	.card:hover{
		box-shadow: none;
	}
	footer{
    padding-top: 20px;
    padding-bottom: 0px;
    margin-bottom: 0px;
  }

  #DesarrolloId_chosen{
    width: 100% !important;
  }

  .tr-secondary-im, #fa-icon-minus-im{
      display: none;
  }
  .tr-secondary-im td{
      padding-left: 7.2%;
  }

	/* Media para no imprimir */
	@media print {
    .col-xs, .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12, .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-xl, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px;
    }
    .text-lg-center{
        text-align:center;
    }
		body {
		  background-image: none;
      font-size: 11px;
      -webkit-print-color-adjust: exact;
		}
		.bg-container {
		    background-color: rgb(255, 255, 255);
		}

    .salto{
            page-break-before: always !important;
        }

		.bg-inner {
		    background-color: rgb(255, 255, 255);
		}
    .no, .no *
    {
        display: none !important;
    }
    .logo-printer{
        width:300px;
    }
    .col-lg-3{
        width:25%;
    }
    .col-lg-6{
        float: left;
        width: 50%;
    }
    .col-lg-12{
        width:100%
    }

    .row {
        margin-right: -15px;
        margin-left: -15px;
    }

    div {
        display: block;
    }

    table{
        width:100%;
        text-align:center;
    }
    .row-25{
        width:25%;
        text-align: center;
    }
    .row-33{
        width:33%;
        text-align: center;
    }
    .padding-10{
        padding:1%;
    }
    .clientes{
        background-color: #034aa2;
        color:white;
        font-size:20px;
    }
    .ventas{
        background-color: green;
        color:white;
        font-size:20px;
    }
    .mdp{
        background-color: darkgreen;
        color:white;
        font-size:20px;
    }

    .efectividad{
        background-color: darkgray;
        color:white;
        font-size:20px;
    }

    .globalClass_ET{
        display:none;
    }

    .footer {
      position: fixed;
      left: 0;
      bottom: 0;
      width: 100%;
      text-align: center;
    }

    .card-header{
        background-color: #2e3c54;
        color:white;
    }
    .brinco{
      page-break-after: always;
    }
    .text-lg-right{
        text-align: right;
    }

    .text-sm-center{
      font-size:9px;
    }
    @page{
      margin: 15px;
    }
	}

  .chips{
      border-radius: 5px;
      text-align: center;
      -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
      -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
      box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
  }
  .chips-block {
    width: 100%;
  }
  .chips-bloqueados {
    padding: 2px 5px 2px 5px;
    background: #E6A7A3;
    color: #fff;
  }
  .chips-libres {
    padding: 2px 5px 2px 5px;
    background: #A6BED7;
    color: #FFF;
  }
  .chips-reservas {
    padding: 2px 5px 2px 5px;
    background: #FFA500;
    color: #FFF;
  }
  .chips-contratos {
    padding: 2px 5px 2px 5px;
    background: RGB(116, 175, 76);
    color: #FFF
  }
  .chips-escrituraciones {
    padding: 2px 5px 2px 5px;
    background: #9BB6B5;
    color: #FFF
  }
  .chips-bajas{
    padding: 2px 5px 2px 5px;
    background: #aaa;
    color: #FFF
  }
</style>

<div class="modal fade" id="modalFilterReporteD1" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('Desarrollo'); ?>
          <div class="modal-header bg-blue-is">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <!-- <h4 class="modal-title" id="modalFilterReporteD1Label1" style="color:black">
                  <i class="fa fa-cogs"></i>
                  Parámetros de reporte
              </h4> -->
          </div>
          <div class="modal-body">
            <div class="row">
                <?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>

                <div class="col-sm-12 mt-2">
                  <label for="ClientePropiedades" id="ClientePropiedadesInteresLabel" class="fw-700">Propiedades de Interés*</label>
                  <select class="form-control chzn-select required" required="required" name="data[Desarrollo][desarrollo_id]" id="DesarrolloDesarrolloId">
                      <option value="0">Seleccionar un desarrollo o Cluster</option>
                      <optgroup label="DESARROLLOS">
                          <?php foreach ($desarrollos_list as $key_d => $d):?>
                          <option value="D<?= $key_d ?>" style="font-style: oblique"><?= $d?></option>
                          <?php endforeach; ?>
                      </optgroup>
                      <optgroup label="CLUSTER">
                          <?php foreach ($clusters as $key_c => $c):?>
                          <option value="C<?= $key_c ?>"><?= $c?></option>
                          <?php endforeach; ?>
                      </optgroup>
                  </select>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <!-- <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
              </button> -->
              <button type="button" class="btn btn-success float-xs-right" onclick='reporteDesarrollo()'>
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
			<div class="col-sm-12 col-lg-6">
				<h4 class="nav_top_align">
					Reporte por Desarrollo
				</h4>
			</div>
			<div class="col-sm-12 col-lg-6">
				<?= $this->Html->link('<i class="fa fa-cogs fa-2x"></i> Cambiar Rango de Fechas y Desarrollo', '#modalFilterReporteD1', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no float-xs-right','style'=>"color:white")) ?>
			</div>

		</div>
	</header>

	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row mt-3">
				<div class="col-sm-12">
					<div class="card">

						<div class="card-block" style="padding-top: 10px;">
							<!-- <a href="javascript:window.print()" class="btn btn-secondary-o float-right" style="margin-left:8px;">Enviar</a> -->
							<a href="javascript:window.print()" class="btn btn-secondary-o float-right" >Imprimir</a>
							<!-- Encabezado -->
							<div class="row">
								<div class="col-sm-12 col-lg-3 mt-1">
									<img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>"
										alt="Logo cuenta" class="img-fluid logo-printer">

								</div>
								<div class="col-sm-12 col-lg-6 mt-1">
									<h1 class="text-sm-center text-black">
										Reporte de Desarrollo: <span id="nombreDesarrollo"></span>
									</h1>

									<h1 class="text-sm-center text-black no-print">
										Reporte de Cluster:
									</h1>

									<p class="text-lg-center" style="font-size: 1rem;">
										<b style="font-size:14px">Periodo del: <span id="periodoReporte"> "Sin periodo" </span> </b>
									</p>
								</div>
								<div class="col-sm-12 col-lg-3 mt-1">
									<p class="text-lg-right">
										<?= $this->Html->image('no_photo',array('height'=>'150px', 'id' => 'logo_desarrollo_reporte_d1'))?>
									</p>
								</div>
							</div>

							<!-- Datos generales -->
							<div class="row mt-2">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header bg-blue-is">
											<i class="fa fa-building"></i> Datos Generales
										</div>
										<div class="card-block">
											<div class="row">
												<div class="col-sm-12 table-responsive">
													<table class="table table-sm" id="table-indicador-mensual">
															<tbody>
																<tr>
																	<td>
																		<b>Total desarrollo: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="totalDesarrollo">0 / $0</span>
																	</td>
																	<td style="padding-left: 5em;">
																		<b>Fecha de inicio de comercialización: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="fechaComercializacion">
																			Sin fecha
																		</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<b>Total Disponible: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="totalDisponible">0 / $0</span>
																	</td>
																	<td style="padding-left: 5em;">
																		<b>Fecha de inicio de obra: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="fechaInicioObra">
																			Sin fecha
																		</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<b>Total vendidas / contrato: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="totalSistema">0 / $0</span>
																	</td>
																	<td style="padding-left: 5em;">
																		<b>Fecha Estimada Fin de Obra: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="fechaEstimadaFinObra">
																			Sin fecha
																		</span>
																	</td>
																</tr>
																<tr>
																	<td>
																		<b>% de Ventas en Unidades: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="percentVentas">
																			0 %
																		</span>
																	</td>
																	<td style="padding-left: 5em;">
																		<b>Fecha Real Fin de Obra: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="fechaRealFinObra">
																			Sin fecha
																		</span>
																	</td>

																</tr>
																<tr>
																	<td>
																		<b>% de Construcción: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="percentConstruccion">
																			0 %
																		</span>
																	</td>

																	<td style="padding-left: 5em;">
																		<b>Fecha de inicio de Escrituración: </b>
																	</td>
																	<td class="text-sm-right">
																		<span id="fechaInicioEscrituracion">
																			Sin fecha
																		</span>
																	</td>
																</tr>
															</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!-- Estatus de las unidades del desarrollo - historico -->
							<div class="row mt-2">
								<div class="col-sm-12">
									<div class="card">
										<div class="card-header bg-blue-is">
											<i class="fa fa-building"></i> ESTATUS DE UNIDADES DEL DESARROLLO (HISTÓRICOS ACUMULADOS AL
											<?= date('d-m-Y') ?>)
										</div>
										<div class="card-block">

											<div class="row"
												style="background-color: #D1D1D1; margin: 5px; border-radius: 5px; text-transform: uppercase; font-weight: 600;">
												<div class="col-sm-6">
													Total de Unidades:
													<span id="totalUnidadesIndicador">U 0</span>
												</div>
												<div class="col-sm-6">
													Total en Cantidad:
													<span id="totalMontoIndicador"> $ 0 </span>
												</div>
											</div>

											<div class="row mt-1">
												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Baja
													</div>
													<div class="col-sm-12 number chips chips-bajas">
														<span id="unidadesBajaDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-bajas mt-1">
														<span id="unidadesBajaDesarrollo"> 0 $</span>
													</div>
												</div>

												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Bloqueados
													</div>
													<div class="col-sm-12 number chips chips-bloqueados">
														<span id="unidadesBloqeadasDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-bloqueados mt-1">
														<span id="montoBloqeadasDesarrollo"> 0 $</span>
													</div>
												</div>

												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Libres 
													</div>
													<div class="col-sm-12 number chips chips-libres">
														<span id="unidadesLibresDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-libres mt-1">
														<span id="montoLibresDesarrollo"> 0 $</span>
													</div>
												</div>

												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Reservados
													</div>
													<div class="col-sm-12 number chips chips-reservas">
														<span id="unidadesReservadosDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-reservas mt-1">
														<span id="montoReservadosDesarrollo"> 0 $</span>
													</div>
												</div>

												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Contrato
													</div>
													<div class="col-sm-12 number chips chips-contratos">
														<span id="unidadesContratoDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-contratos mt-1">
														<span id="montoContratoDesarrollo"> 0 $</span>
													</div>
												</div>

												<div class="col-sm-4 col-lg-2 text-center">
													<div class="col-sm-12">
														Escrituración
													</div>
													<div class="col-sm-12 number chips chips-escrituraciones">
														<span id="unidadesEscrituracionDesarrollo"> 0 U</span>
													</div>
													<div class="col-sm-12 number chips chips-escrituraciones mt-1">
														<span id="montoEscrituracionDesarrollo"> 0 $</span>
													</div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6  mt-1">
								<?= $this->element('Events/eventas_cards_by_ajax'); ?>
							</div>
							<!-- INDICADORES DE DESEMPEÑO HISTÓRICOS ACUMULADOS AL -->
							<div class="col-sm-6  mt-1">
								<?= $this->element('Events/eventas_cards_by__historico_ajax'); ?>
							</div>
						</div>
						<!-- ESTATUS GENERAL DE CLIENTES -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_estatus_by_ajax') ?>
							</div>
						</div>
						<!-- ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS  -->
						<div class="row">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_activos_atencion_by_ajax') ?>
							</div>
						</div>
						<!-- EMBUDO DE CLIENTES ACTIVOS AL (FECHA DEL ÚLTIMO DÍA DEL PERIODO SOLICITADO) -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_activos_etapa_by_ajax') ?>
							</div>
						</div>
						<!-- RAZONES DE INACTIVACIÓN TEMPORAL DE CLIENTES -->
						<div class="row">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_motivo_inactivo_temporal_by_ajax') ?>
							</div>
						</div>
						<!-- RAZONES DE INACTIVACIÓN DEFINITIVA DE CLIENTES -->
						<div class="row mt-1  salto">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_motivo_inactivo_definitivo_by_ajax') ?>
							</div>
						</div>
						<!-- ESTATUS DE APARTADOS ( TOTALES, VIGENTES, CANCELADOS ) VENTAS -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('OperacionesInmuebles/apartados_vigentes_cancelaciones_ventas_by_ajax') ?>
							</div>
						</div>
						<!-- RAZONES DE CANCELACIÓN DE LOS APARTADOS -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('OperacionesInmuebles/apartados_motivos_cancelacion_by_ajax') ?>
							</div>
						</div>
						<!-- LISTADO DE APARTADOS -->
						<div class="row">
							<div class="col-sm-12">
								<?= $this->Element('Ventas/apartados_by_ajax') ?>
							</div>
						</div>
						<!-- META VS VENTAS (EN UNIDADES) -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Desarrollos/desarrollo_ventas_metas_by_ajax') ?>
							</div>
						</div>
						<!-- META VS. VENTAS ($ MONTO EN MDP) -->
						<div class="row">
							<div class="col-sm-12">
								<?= $this->Element('Desarrollos/desarrollo_ventas_metas__dinero_by_ajax') ?>
							</div>
						</div>
						<!-- VENTAS EN UNIDADES Y MONTO EN MDP -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Desarrollos/desarrollo_ventas_acomuladas_by_ajax') ?>
							</div>
						</div>
						<!-- VENTAS POR ASESOR -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('Ventas/ventas_asesores_by_ajax') ?>
							</div>
						</div>
						<!-- LISTADO DE VENTAS -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Ventas/tabla_ventas_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES POR MEDIO DE PROMOCIÓN VS CITAS, VISITAS Y VENTAS -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_medio_ventas_visitas_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES POR MEDIO DE PROMOCIÓN, VENTAS E INVERSIÓN EN PUBLICIDAD -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Leads/leads_ventas_linea_contacto_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES POR MEDIO DE PROMOCIÓN, VISITAS E INVERSIÓN EN PUBLICIDAD -->
						<div class="row">
							<div class="col-sm-12">
								<?= $this->Element('Leads/leads_visitas_linea_contacto_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES POR MEDIOS DE PROMOCIÓN VS ESTATUS DE LOS CLIENTES -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Clientes/clientes_medio_inactivo_by_ajax') ?>
							</div>
						</div>
						<!--CLIENTES ACTIVOS POR MEDIO DE PROMOCIÓN VS INVERSIÓN EN PUBLICIDAD  -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('Leads/leads_activos_linea_contacto_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES INACTIVO TEMPORALES POR MEDIO DE PROMOCIÓN VS INVERSIÓN EN PUBLICIDAD -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Leads/leads_temporal_linea_contacto_by_ajax') ?>
							</div>
						</div>
						<!-- CLIENTES INACTIVOS DEFINITIVOS POR MEDIO DE PROMOCIÓN VS INVERSIÓN EN PUBLICIDAD -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('Leads/leads_definitivos_linea_contacto') ?>
							</div>
						</div>
						<!-- INVERSIÓN HISTÓRICA EN PUBLICIDAD  -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Publicidads/inversion_publucidad_by_ajax') ?>
							</div>
						</div>
						<!-- ANÁLISIS DE CITAS (VIGENTES, VENCIDAS, CANCELADAS Y CONCRETADAS) Y VISITAS POR PASE POR MEDIO DE PROMOCIÓN -->
						<div class="row ">
							<div class="col-sm-12">
								<?= $this->Element('Events/analisis_citas_visitas_cancelacion_by_ajax') ?>
							</div>
						</div>
						<!-- RAZONES DE CANCELACIÓN DE CITAS -->
						<div class="row mt-1 salto">
							<div class="col-sm-12">
								<?= $this->Element('Events/cancelaciones_citas_by_ajax') ?>
							</div>
						</div>

						<!-- listado de escruturacoin -->
						<div class="row RAZONES DE INACTIVACIÓN DEFINITIVA DE CLIENTES">
							<div class="col-sm-12">
								<?= $this->Element('Ventas/tabla_escrituracion_by_ajax') ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Footer -->
<div class="footer">
	<div class="">
		<div class="col-sm-12" style="background-color: #555555;">
			<p class="text-lg-center" style="color: white;">
				<br>
				POWERED BY
				<br>
				<img src="<?= Router::url('/img/logo_inmosystem.png',true) ?>"
					style="border: 0px; width: 80px; margin: 0px; height: 42px; width: auto;"><br>
				<span style="color:#FFFFFF"><small>Todos los derechos reservados <?= date('Y')?></small></span>
			</p>
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
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script>
  // Funciones JS

  $(document).ready(function () {
    $('#date_range').daterangepicker({
          orientation:"bottom",
          autoUpdateInput: false,
          locale: {
              cancelLabel: 'Limpiar',
              applyLabel: 'Aplicar'
          }
      });
      $('#date_range').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
          return false;
      });

      $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
          $(this).val('');
          return false;
      });

      $('[data-toggle="popover"]').popover();
  });
  
  function reporteDesarrollo(){ 
    get_desarrollo($("#DesarrolloDesarrolloId").val());
    let cuenta_id="<?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>";
    // ventas($("#DesarrolloDesarrolloId").val());
    //1.- Debemos separar el valor de $("#date_range").val() por fecha inicial, fecha final, cuenta_d, desarrollo_id, user_id
    cardsPeriodo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    cardHistorico( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaTemporalesLineaContacto( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );

    graficaClientesEstatus( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaActivosLineaContacto( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    
    graficaClientesActivos( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaClientesEtapa( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), null );
    graficaDefinitivosLineaContacto( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaMotivoInactivoDefinitivo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaMotivoInactivoTempo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaMotivoCancelacionCita( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0 );
    graficaVentasMetasDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaVentasMetasMontoDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaVentasAcomuladasDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaVentasAsesor( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaVentasLineaContacto( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaVisitasLineaContacto( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    //graficaVentasVisitasDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaInversionPublicidad( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    
    tablaVentasDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);

    tablaApartadosDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    graficaMotivoCancelacionApartados( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    gradicaApartados_ventas_cancelaciones( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    tablaMedioClientesVisitasVentas( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    
    tablaClientesInactivosMedio( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);
    
    tablanAlisisCitasVisitasCancelacion( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);

	tablaEscrituradasDesarrollo( $("#date_range").val(), cuenta_id, $("#DesarrolloDesarrolloId").val(), 0);


    window.setInterval(function(){
      $('#modalFilterReporteD1').modal('hide');
      $("#overlay").fadeOut();
    },7000);


  }

  // Metodo para mostrar la informacion del reporte.
  function get_desarrollo( desarrolloId ){
      // Ponemos el periodo de la fecha del reporte.
      $("#periodoReporte").html($("#date_range").val());

    let URL = '<?= Router::url(array("controller" => "desarrollos", "action" => "get_desarrollos_detalle")); ?>/'+desarrolloId.substring(1)+'';

    $.ajax({
    	type: "GET",
    	url: URL,
    	cache: false,
    	dataType: 'json',
    	success: function (response) {
    		var fotos = response.FotoDesarrollo;
    		var desarrollo = response.Desarrollo;
    		var inmuelesUnidadesMonto = response.estatus_monto_unidades;
        // console.log('caxa');
        // console.log(response);
        // console.log('caaaaca');
    		// Ponemos la informacion del desarrollo.
    		var image = fotos[0]['ruta'];
    		$("#logo_desarrollo_reporte_d1").attr('src', '<?= Router::url(' / ', true) ?>' + image);
    		$("#nombreDesarrollo").html(desarrollo['nombre']);

    		$("#fechaInicioObra").html(desarrollo['fecha_inicio_obra']);
    		$("#fechaEstimadaFinObra").html(desarrollo['fecha_fin_obra']);
    		$("#fechaRealFinObra").html(desarrollo['fecha_real_fin_obra']);
    		$("#fechaInicioEscrituracion").html(desarrollo['fecha_inicio_escrituracion']);
    		$("#fechaComercializacion").html(desarrollo['fecha_comercializacion']);
    		$("#percentConstruccion").html(desarrollo['porcentaje_construccion'] + ' % ');
    		// Datos general -> total desarrollo
    		$("#totalDesarrollo").html(
    			Number(inmuelesUnidadesMonto['bloqueada']['unidades']) +
    			Number(inmuelesUnidadesMonto['liberada']['unidades']) +
    			Number(inmuelesUnidadesMonto['reservada']['unidades']) +
    			Number(inmuelesUnidadesMonto['contrato']['unidades']) +
    			Number(inmuelesUnidadesMonto['escrituradas']['unidades']) +
    			Number(inmuelesUnidadesMonto['baja']['unidades']) +
    			' U / ' +

    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				(
						Number(inmuelesUnidadesMonto['bloqueada']['monto']) +
    					Number(inmuelesUnidadesMonto['liberada']['monto']) +
    					Number(inmuelesUnidadesMonto['reservada']['monto']) +
    					Number(inmuelesUnidadesMonto['contrato']['monto']) +
    					Number(inmuelesUnidadesMonto['escrituradas']['monto']) +
    					Number(inmuelesUnidadesMonto['baja']['monto'])
					).toFixed(2)
    			)

    		);

    		$("#totalUnidadesIndicador").html(
    			Number(inmuelesUnidadesMonto['bloqueada']['unidades']) +
    			Number(inmuelesUnidadesMonto['liberada']['unidades']) +
    			Number(inmuelesUnidadesMonto['reservada']['unidades']) +
    			Number(inmuelesUnidadesMonto['contrato']['unidades']) +
    			Number(inmuelesUnidadesMonto['escrituradas']['unidades']) +
    			Number(inmuelesUnidadesMonto['baja']['unidades']) +
    			' U / '
    		);

    		$("#totalMontoIndicador").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				(Number(inmuelesUnidadesMonto['bloqueada']['monto']) +
    					Number(inmuelesUnidadesMonto['liberada']['monto']) +
    					Number(inmuelesUnidadesMonto['reservada']['monto']) +
    					Number(inmuelesUnidadesMonto['contrato']['monto']) +
    					Number(inmuelesUnidadesMonto['escrituradas']['monto']) +
    					Number(inmuelesUnidadesMonto['baja']['monto'])).toFixed(2)
    			)
    		);
    		//
    		var ventasPorsentaje = 0;
    		var totalUnidades = 0;
    		var unidadesresto = 0;
    		total = (Number(inmuelesUnidadesMonto['bloqueada']['unidades']) +
    			Number(inmuelesUnidadesMonto['liberada']['unidades']) +
    			Number(inmuelesUnidadesMonto['reservada']['unidades']) +
    			Number(inmuelesUnidadesMonto['contrato']['unidades']) +
    			Number(inmuelesUnidadesMonto['escrituradas']['unidades']) +
    			Number(inmuelesUnidadesMonto['baja']['unidades'])
    		)
    		unidadesresto = (Number(inmuelesUnidadesMonto['operacion']['unidades']) );
    		ventasPorsentaje = (unidadesresto * 100) / (total);
    		ventasPorsentaje = ventasPorsentaje.toFixed(2);
    		$("#percentVentas").html(ventasPorsentaje + ' % ');
    		//
        var totalUnidades=(Number(inmuelesUnidadesMonto['bloqueada']['unidades']) +
          Number(inmuelesUnidadesMonto['liberada']['unidades']) +
          Number(inmuelesUnidadesMonto['reservada']['unidades']) +
          Number(inmuelesUnidadesMonto['contrato']['unidades']) +
          Number(inmuelesUnidadesMonto['escrituradas']['unidades']) +
          Number(inmuelesUnidadesMonto['baja']['unidades']) 
        );
        var ventaAdryo=Number(inmuelesUnidadesMonto['operacion']['unidades']);
          
        var disponible=totalUnidades-ventaAdryo;
        var montoTotal=(Number(inmuelesUnidadesMonto['bloqueada']['monto']) +
          Number(inmuelesUnidadesMonto['liberada']['monto']) +
          Number(inmuelesUnidadesMonto['reservada']['monto']) +
          Number(inmuelesUnidadesMonto['contrato']['monto']) +
          Number(inmuelesUnidadesMonto['escrituradas']['monto']) +
          Number(inmuelesUnidadesMonto['baja']['monto'])
        );
              
        var montoAdryo=	inmuelesUnidadesMonto['operacion']['monto'];
       
        var ventasAdryoMonto= Number(inmuelesUnidadesMonto['liberada']['monto']); //montoTotal-montoAdryo;
    		// Unidades y monto disponible
    		$("#totalDisponible").html(
    			Number(disponible) +
    			'U / ' +
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(ventasAdryoMonto).toFixed(2)
    			)
    		);
			//roberto
			$("#totalSistema").html(Number(inmuelesUnidadesMonto['operacion']['unidades']) + '  U/ ' +
    			new Intl.NumberFormat("es-MX", {
					style: "currency",
					currency: "MXN"
				}).format(
						Number(inmuelesUnidadesMonto['operacion']['monto']).toFixed(2)
				));
          


			//

    		$("#unidadesBloqeadasDesarrollo").html(Number(inmuelesUnidadesMonto['bloqueada']['unidades']) + ' U');
    		$("#montoBloqeadasDesarrollo").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(inmuelesUnidadesMonto['bloqueada']['monto']).toFixed(2)
    			)
    		);

    		$("#unidadesLibresDesarrollo").html(Number(inmuelesUnidadesMonto['liberada']['unidades']) + ' U');
    		$("#montoLibresDesarrollo").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(inmuelesUnidadesMonto['liberada']['monto']).toFixed(2)
    			)
    		);

    		$("#unidadesReservadosDesarrollo").html(Number(inmuelesUnidadesMonto['reservada']['unidades']) + ' U');
    		$("#montoReservadosDesarrollo").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(inmuelesUnidadesMonto['reservada']['monto']).toFixed(2)
    			)
    		);
        //aqui
    		$("#unidadesContratoDesarrollo").html(Number(inmuelesUnidadesMonto['operacion']['unidades']) + ' U');
    		$("#montoContratoDesarrollo").html(
            new Intl.NumberFormat("es-MX", {
              style: "currency",
              currency: "MXN"
            }).format(
              Number(inmuelesUnidadesMonto['operacion']['monto']).toFixed(2)
            )
          
          );

    		$("#unidadesEscrituracionDesarrollo").html(Number(inmuelesUnidadesMonto['escrituradas']['unidades']) + ' U');
    		$("#montoEscrituracionDesarrollo").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(inmuelesUnidadesMonto['escrituradas']['monto']).toFixed(2)
    			)
    		);

    		$("#unidadesBajaDesarrollo").html(Number(inmuelesUnidadesMonto['baja']['unidades']) + ' U');
    		$("#montoBajaDesarrollo").html(
    			new Intl.NumberFormat("es-MX", {
    				style: "currency",
    				currency: "MXN"
    			}).format(
    				Number(inmuelesUnidadesMonto['baja']['monto']).toFixed(2)
    			)
    		);

    	},
    	error: function (err) {
    		console.log(err.responseText);
    	}
    });
  }
 
</script>
