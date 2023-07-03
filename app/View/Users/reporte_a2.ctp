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

      '/vendors/chosen/css/chosen',
      '/vendors/fileinput/css/fileinput.min',
      'pages/layouts',

      'pages/widgets',
    ),
    array('inline'=>false)); 
?>
<style>
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
        .no-imprimir, .no-imprimir *
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
            font-size: .8em;
        }

        .nombre{
            text-align: left;
        }

        .titulo{
            font-size:.8em;
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
        background: #FFFF00;
        color: #3D3D3D;
    }
    .chips-libres {
        padding: 2px 5px 2px 5px;
        background: rgb(0, 64 , 128);
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
        background: #8B4513;
        color: #FFF
    }
    .chips-bajas{
        padding: 2px 5px 2px 5px;
        background: #000000;
        color: #FFF
    }
</style>
<!-- model -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog">
      <div class="modal-content">
      	<?= $this->Form->create('User'); ?>
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title" id="myModalLabel1" style="color:black">
                  <i class="fa fa-cogs"></i>
                  Parámetros de reporte
              </h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'dd/mm/yyyy - dd/mm/yyyy', 'div'=>'col-sm-12', 'label'=>'Rango de fechas', 'id'=>'date_range', 'required'=>true, 'autocomplete'=>'off')); ?>
                 <?= $this->Form->input('user_id', array('type'=>'select','multiple'=>true,'options'=>$users,'class'=>'form-control chzn-select', 'div'=>'col-sm-12', 'label'=>'Seleccionar Asesor','id'=>'users', 'required'=>true)); ?>
                <button type="button" class="seleccionar_todos btn btn-primary select" style="margin-top:100px">Seleccionar Todos los Asesores</button>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success float-xs-right" onclick='reporteGrupoAsesor()'>
                      Buscar
            </button>
              <!-- <button type="submit" class="btn btn-success float-xs-right ">
                    Buscar
              </button> -->
              <button type="button" class="btn btn-danger pull-left " data-dismiss="modal">
                    Cerrar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>
<!-- model -->
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-sm-12 col-lg-6">
        <h4 class="nav_top_align">
          REPORTE POR GRUPO DE ASESORES
        </h4>
      </div>
      <div class="col-sm-12 col-lg-6">
        <?= $this->Html->link('<i class="fa fa-cogs fa-2x"></i> Cambiar Rango de Fechas y Asesor', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no-imprimir float-xs-right','style'=>"color:white")) ?>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-light lter bg-container">
      <div class="row mt-3">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-block" style="padding-top: 10px;">
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
                    Reporte Grupo de Asesores: <span id="grupoAsesoresReporte"></span>
                  </h1>
                  <p class="text-lg-center" style="font-size: 1rem;">
                    <b style="font-size:14px">Periodo del: <span id="periodoReporte"> "Sin periodo" </span> </b>
                  </p>
                  
                </div>
              </div>
              <!-- ESTATUS GENERAL DE CLIENTES POR ASESOR -->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Clientes/clientes_status_user_by_ajax') ?>
                </div>
              </div>

              <!-- ESTATUS DE ATENCIÓN A CLIENTES ACTIVOS -->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Clientes/clientes_atencion_grupo_by_ajax') ?>
                </div>
              </div>

              <!-- RAZONES DE CITAS CANCELADAS DEL PERIODO -->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Events/razon_citas_canceladas_grupo_by_ajax') ?>
                </div>
              </div>

               <!-- ETAPAS DE CLIENTES ACTIVOS A LA FECHA -->
               <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Clientes/clientes_etapa_grupo_by_ajax') ?>
                </div>
              </div>
              <!-- TOTAL DE CLIENTES VS VISITAS Y VENTAS -->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Clientes/clientes_ventas_visitas_grupo_by_ajax') ?>
                </div>
              </div>

              <!-- TOTAL DE CLIENTES VS CITAS Y VENTAS-->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('Clientes/clientes_ventas_citas_grupo_by_ajax') ?>
                </div>
              </div>

              <!-- META VS. VENTAS (UNIDADES)-->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('OperacionesInmuebles/ventas_metas_grupo_asesores_by_ajax') ?>
                </div>
              </div>
              <!--  META VS. VENTAS (MONTO)-->
              <div class="row mt-1 salto">
                <div class="col-sm-12">
                  <?= $this->Element('OperacionesInmuebles/ventas_metas_monto_grupo_asesores_by_ajax') ?>
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

    '/vendors/chosen/js/chosen.jquery',

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
    'pages/form_elements',

  ], array('inline'=>false));
?>
<script>
  function reporteGrupoAsesor(){
    
    clientesStatusClientes( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    clientesAtencionClientes( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    graficaMotivoCancelacionCitaGrupo( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    tablaEtapaGrupoAsesor( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    ClienteVentasVisitasGrupoAsesor( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    ClienteVentasCitasGrupoAsesor( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    graficaVentasMetasGrupoAsesoresUnidades( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    graficaVentasMetasMontoGrupoAsesores( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    getGrupoAsesores( $("#date_range").val(), <?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 0, $("#users").val()  );
    window.setInterval(function(){
      $('#myModal').modal('hide');
      $("#overlay").fadeOut();
    },9000);
    
  }

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

    TableAdvanced.init();
    $(".dataTables_scrollHeadInner .table").addClass("table-responsive");
    $(".dataTables_wrapper .dt-buttons .btn").addClass('btn-secondary').removeClass('btn-default');

  });
  function getGrupoAsesores ( rangoFechas, cuentaId, desarrolloId, asesorId ) {
    $.ajax({
      type: "POST",
      url: '<?php echo Router::url(array("controller" => "users", "action" => "reporte_grupo_asesores_info")); ?>',
      data: {
				rango_fechas: rangoFechas,
				cuenta_id: cuentaId,
				desarrollo_id: desarrolloId,
				user_id: asesorId
			},
      cache: false,
      dataType: 'json',
      beforeSend: function () {
        $("#overlay").fadeIn();
      },
      success: function ( response ) {
        document.getElementById("periodoReporte").innerHTML =response[0].periodo;
        document.getElementById("grupoAsesoresReporte").innerHTML =response[0].asesores;
      },
      error: function ( err ){
        console.log( err.responseText );
      }
    });
  }
  var TableAdvanced = function() {
      // ===============table 1====================
      var initTable1 = function() {
          var table = $('#table_v_general');
          /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
          /* Set tabletools buttons and button container */
          table.DataTable({
              lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
              order: [[3, "Desc"]],
              dom: 'Bflr<"table-responsive"t>ip',
              buttons: [
                {
                  extend: 'csv',
                  text: '<i class="fa  fa-file-excel-o"></i> Exportar a Excel',
                  filename: 'ClientList',
                  class : 'excel',
                  charset: 'utf-8',
                  bom: true
                },
                {
                  extend: 'print',
                  text: '<i class="fa  fa-print"></i> Imprimir',
                  filename: 'ClientList',
                },
              ]
          });
          var tableWrapper = $('#sample_1_wrapper'); // datatable creates the table wrapper by adding with id {your_table_id}_wrapper
          tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
      }
      // ===============table 1===============

      return {
          //main function to initiate the module
          init: function() {
              if (!jQuery().dataTable) {
                  return;
              }
              initTable1();
          }
      };
  }();

</script>