
<div class="card">
    <div class="card-header bg-blue-is">
        CONTACTOS POR MEDIO DE PROMOCIÓN VS VISITAS V2        
    </div>

    <div class="card-block">
        <div class="row">
            
          <div class="col-sm-12">
            <?= $this->Form->create('GraficaClientesLineaContacto'); ?>
              <div class="row">
                <div class="col-sm-12 col-lg-3 offset-lg-9">
                  <?= $this->Form->input('select_fecha', array('class' => 'form-control form-control-sm', 'label' => false)) ?>
                </div>
              </div>
            <?= $this->Form->end(); ?>
          </div>

          <div class="col-sm-12">
              
              <div id="grafica_visitas_lineas_contacto"></div>

          </div>

          <div class="col-sm-12">
              <small id="fecha_periodo"> </small>
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

    // Calendario
    '/vendors/datepicker/js/bootstrap-datepicker.min',    
    '/vendors/jquery.uniform/js/jquery.uniform',
    '/vendors/inputlimiter/js/jquery.inputlimiter',
    '/vendors/moment/js/moment.min',
    '/vendors/daterangepicker/js/daterangepicker',
    '/vendors/bootstrap-switch/js/bootstrap-switch.min',


  ], array('inline'=>false));
?>

<script>
  
  $('##GraficaClientesLineaContactoSelectFecha').daterangepicker({
    orientation    : 'auto top',
    autoUpdateInput: false,
    locale         : {
      cancelLabel: 'Limpiar',
      applyLabel : 'Aplicar'
    }

  });

  let  dataGrafica = [];
  $.ajax({
      url: '<?= Router::url(array("controller" => "users", "action" => "response_graficas")); ?>',
      cache: false,
      dataType: 'json',
      success: function ( response ) {
          
          update( response );

      }
  });

  function update( responseData ){
    
    $("#fecha_periodo").html(responseData['fecha_grafica']);

  }
  


</script>