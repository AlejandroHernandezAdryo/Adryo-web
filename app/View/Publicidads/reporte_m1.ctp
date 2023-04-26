<?php 
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

  .numbers_cards{
      font-size: 1.3rem;
      color: #525252;
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
  .indicadores{
    border: 1px solid rgba(0, 0, 0, 0.125); border-radius: 6px;
  }
    .colorH4{
      color:#525252;
      font-size:16px ;
      font-weight:bold ;
    }
	.text-icon{
		display: flex;
		justify-content: space-between;
	}
	.small_text{
		color: #525252;
		font-size: .8rem;
		font-weight:bold ;
	}

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

</style>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('Desarrollo'); ?>
          <div class="modal-header bg-blue-is">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1">
                  <!-- <i class="fa fa-cogs"></i>
                  Parámetros de reporte -->
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>
                <div class="col-sm-12 mt-1">
                  <label for="ClientePropiedades" id="ClientePropiedadesInteresLabel"  class="fw-700">Seleccionar desarrollo*</label>
                  <select class="form-control chzn-select required" multiple=true required="required" name="data[Desarrollo][desarrollos][]" id="DesarrolloDesarrollos">
                      <!-- <option>Seleccionar un desarrollo o Cluster</option> -->
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
                <div class="col-sm-12 mt-5">
                  <?= $this->Form->input('medios',array('type'=>'select','class'=>'form-control chzn-select','id'=>'medio_reporte','options'=>$list_medios,'multiple'=>true))?>
                    <button type="button" class="seleccionar_todos btn btn-secondary-o select" style="margin-top:100px">Seleccionar Todos los Medios</button>
                    <button type="button" class="limpiar_todos btn btn-secondary-o select" style="margin-top:100px" onclick='cleanInput()'>Limpiar Todos los Medios</button>
                </div>
            </div>
          </div>
          <div class="modal-footer mt-3">
              <button type="button" class="btn btn-secondary-o pull-left" data-dismiss="modal">
                    Cerrar
              </button>
              <button type="button" class="btn btn-success float-xs-right" onclick='reporteDesarrolloLeads()'>
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
					REPORTE DE INVERSIÓN EN PUBLICIDAD EN MEDIOS DE PROMOCIÓN
				</h4>
			</div>
			<div class="col-sm-12 col-lg-6">
				<?= $this->Html->link('<i class="fa fa-cogs fa-2x"></i> Cambiar Rango de Fechas y Desarrollo', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no float-xs-right','style'=>"color:white")) ?>
			</div>
		</div>
	</header>
	<div class="outer">
		<div class="inner bg-light lter bg-container">
			<div class="row mt-3">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-block" style="padding-top: 10px;">
							<a href="javascript:window.print()" class="btn btn-secondary-o float-right" >Imprimir</a>
							<!-- Encabezado -->
							<div class="row">
								<div class="col-sm-12 col-lg-3 mt-1">
									<img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>"
										alt="Logo cuenta" class="img-fluid logo-printer">
								</div>
								<div class="col-sm-12 col-lg-6 mt-1">
									<p>
										<h2 class="text-sm-center text-black">
											<?= $this->Session->read('CuentaUsuario.Cuenta.razon_social')?></h2>
									</p>
									<h1 class="text-sm-center text-black">
										Reporte de Desarrollo: <span id="nombreDesarrollo"></span>
									</h1>
									<p><b>Medios de Promoción Seleccionados:</b><span id="mediosSeleccionados"></p>
									<p class="text-lg-center" style="font-size: 1rem;">
										<b style="font-size:14px">Periodo del: <span id="periodoReporte"> "Sin periodo" </span> </b>
									</p>
								</div>
							</div>
							<!-- INDICADORES DE GESTIÓN DE PERIODO SELECCIONADO (DESARROLLOS Y MEDIOS SELECCIONADOS) -->
							<div class="row">
								<div class="col-sm-12">
									<?= $this->Element('Leads/indicadores_periodo_seleccionado_by_ajax') ?>
								</div>
							</div>
							<!-- LEADS E INVERSIÓN EN PUBLICIDAD POR DESARROLLO(S) SELECCIONADO(S)	-->
							<div class="row">
								<div class="col-sm-12">
									<?= $this->Element('Desarrollos/leads_desarrollos_by_ajax') ?>
								</div>
							</div>
              <!-- RESUMEN DE INVERSIÓN POR MEDIO DE PROMOCIÓN VS LEADS,CITAS,VISITAS Y VENTAS -->
							<div class="row mt-1 salto">
								<div class="col-sm-12">
									<?= $this->Element('Desarrollos/tabla_resumen_desarrollo_inversion_leads_costo_citas_visitas_visitas_by_ajax') ?>
								</div>
							</div>
							<!-- TOTAL DE LEADS VS VENTAS E INVERSIÓN POR MEDIO DE PROMOCIÓN  -->
							<div class="row">
								<div class="col-sm-12">
									<?= $this->Element('Leads/leads_ventas_ineversion_desarollos_by_ajax') ?>
								</div>
							</div>
							<!--TOTAL DE LEADS VS VENTAS Y VISITAS POR MEDIO DE PROMOCIÓN-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?= $this->Element('Leads/leads_ventas_visitas_desarrollos_by_ajax') ?>
								</div>
							</div>
              <!--CITAS VS VENTAS Y VISITAS POR MEDIO DE PROMOCIÓN-->
              <div class="row">
                <div class="col-sm-12">
                  <?= $this->Element('Leads/costo_leads_ventas_visitas_by_ajax') ?>
                </div>
              </div>
              <!--TOTAL INVERSIÓN EN PUBLICIDAD VS TOTAL DE LEADS POR DESARROLLO(S) SELECCIONADO(S)-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?= $this->Element('Leads/leads_costo_inversion_by_ajax') ?>
								</div>
							</div>
              <!--tabla activos temporales y definitivos	-->
							<div class="row">
								<div class="col-sm-12">
									<?= $this->Element('Clientes/tabla_inactivos_temporales_definitivos_by_ajax') ?>
								</div>
							</div>
              <!-- LEADS POR MEDIOS DE PROMOCIÓN VS Clientes Activos	-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?= $this->Element('Clientes/medios_leads_clientes_Activos_grafica_by_ajax') ?>
								</div>
							</div>
              <!-- LEADS POR MEDIOS DE PROMOCIÓN VS Clientes Temporales	-->
							<div class="row">
								<div class="col-sm-12">
									<?= $this->Element('Clientes/medios_leads_clientes_Temporales_grafica_by_ajax') ?>
								</div>
							</div>
              <!-- LEADS POR MEDIOS DE PROMOCIÓN VS INACTIVOS DEFINITIVOSs	-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?= $this->Element('Clientes/medios_clientes_inactivos_grafica_by_ajax') ?>
								</div>
							</div>
              <!-- ANALISIS DE CITAS, VISITAS Y CANCELACIONES POR MEDIO DE PROMOCIÓN -->
							<div class="row ">
								<div class="col-sm-12">
									<?= $this->Element('Events/medio_citas_citasECT_visita_by_ajax') ?>
								</div>
							</div>
              <!--TOTAL DE LEADS VS LEADS DUPLICADOS POR MEDIO DE PROMOCIÓN	-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?=$this->Element('Leads/leads_clientes_leadsduplicados_by_ajax') ?>
								</div>
							</div>
              <!--TABLA TOTAL DE clientes Y  LEADS DUPLICADOS POR MEDIO DE PROMOCIÓN	-->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?=$this->Element('Leads/tabla_clientes_leads_duplicados_by_ajax') ?>
								</div>
							</div>

              <!-- RAZONES DE CANCELACIÓN DE CITAS -->
							<div class="row mt-1 salto">
								<div class="col-sm-12 mt-1">
									<?=$this->Element('Events/razones_cancelaciones_citas_mk_by_ajax') ?>
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
//
  $(document).ready(function () {
    $('#date_range').daterangepicker({
      orientation:"bottom",
      autoUpdateInput: false,
      locale: {
        cancelLabel: 'Clear'
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
    $('.seleccionar_todos').each(function(index) {
      $(this).on('click', function() {
        $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
      });
    });
    $('[data-toggle="popover"]').popover();
  });

  // Actualizar el campo de los desarrollos para que se queden los que se seleccionaron.
  // DesarrolloDesarrollos

  <?php if( !empty( $desarrollos_seleccion )): ?>
    // $("#DesarrolloDesarrollos").val(<//?= json_encode ($desarrollos_seleccion) ?>);
    // $("#DesarrolloDesarrollos").trigger("chosen:updated");
  <?php endif; ?>
  function reporteDesarrolloLeads(){
    get_desarrollo($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    indicadoresPeriodoSeleccionado($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    // indicadoresHistoricoSeleccionado($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    tablaResumenDesarrollos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    tablaClientesActivosTemporalesDefinitivos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    graficaLeadsDuplicadosClientesPromocion($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    tablaClientesLeadsDuplicados($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    graficaLeadsPorDesarrollo($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    gradicaLeadsVentasInversionDesarrollos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    gradicaLeadsVentasVisitasDesarrollos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    gradicaLeadsCostoInversionDesarrollos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    gradicaCostoLeadsVisitasVentasDesarrollos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    
    medioCitasCitasETCVisitas($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>,0) ; 
    
    graficaMedioClienteInactivo($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    graficaMedioLeadsClientesTemporales($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    graficaMedioLeadsClientesActivos($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    
    graficaRazonesMotivoCancelacionCita($("#date_range").val(), $("#medio_reporte").val(), $('#DesarrolloDesarrollos').val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id')?>) ; 
    
    window.setInterval(function(){
      $('#myModal').modal('hide');
      $("#overlay").fadeOut();
    },7000);
    
  }
  function get_desarrollo(  rangoFechas, medioId,  desarrolloId, cuentaId  ){
      $("#periodoReporte").html($("#date_range").val());
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "leads", "action" => "get_detalles_inversion_leads_costos")); ?>',
      data: { rango_fechas: rangoFechas,  medio_id: medioId, desarrollo_id: desarrolloId, cuenta_id: cuentaId },
      cache: false,
      dataType: 'json',
      success: function ( response ) {
        document.getElementById("nombreDesarrollo").innerHTML =response[0].desarrollos;
        document.getElementById("mediosSeleccionados").innerHTML =response[0].medio;
      },
      error: function ( err ){
        console.log( err.responseText );
      }
    });
  } 

  function cleanInput(){
    $('#medio_reporte').val('').trigger('chosen:updated');
  }

</script>

