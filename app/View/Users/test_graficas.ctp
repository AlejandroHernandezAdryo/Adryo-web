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

  #UserUserId_chosen{
    width: 100% !important;
  }
 
  .periodo_tiempo {
      bottom: 0;
      position: absolute;
  }


	/* Media para no imprimir */
	@media print
	{    
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
		  /*background-repeat: no-repeat;
		  background-size: cover !important;*/
		}
		.bg-container {
		    background-color: rgb(255, 255, 255);
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
        text-align:center;
    }
    .row-25{
        width:25%;
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
      

    @page{
		   margin: 15px;
		}
	}

</style>

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
            
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-success float-xs-right ">
                    Buscar
              </button>
              <button type="button" class="btn btn-danger pull-left " data-dismiss="modal">
                    Cerrar
              </button>
          </div>
          <?= $this->Form->end(); ?>
      </div>
  </div>
</div>


<div id="content" class="bg-container">
<div class="outer">
    <div class="inner bg-light lter bg-container">
        <div class="row mt-3">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-header no-imprimir" style="background-color: #2e3c54; color:white;">
                <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <h3 class="text-white">Reporte por Asesor</h3>
                </div>
                <div class="col-sm-12 col-lg-6 text-lg-right">
                    <?= $this->Html->link('<i class="fa fa-cogs fa-2x"></i> Cambiar Rango de Fechas y Asesor', '#myModal', array('data-toggle'=>'modal', 'escape'=>false,'class'=>'no-imprimir','style'=>"color:white")) ?>	
                </div>
                </div>
            </div>
            <div class="card-block" style="padding-top: 10px;">
                <div class="row">
                <div class="col-sm-12 col-lg-12 mt-1">
                    <?= $this->Element('Clientes/clientes_linea_contacto_visitas_v2') ?>
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