<?php
  $this->assign('title', 'Dashboard | KMD');
  echo $this->Html->css(
    array(
      // Chozen find in select
      '/vendors/chosen/css/chosen',

      '/vendors/fullcalendar/css/fullcalendar.min',
      'pages/calendar_custom',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      'pages/colorpicker_hack',
      
      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/fileinput/css/fileinput.min',
      'pages/form_elements',

      '/vendors/inputlimiter/css/jquery.inputlimiter',
      '/vendors/chosen/css/chosen',
      '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
      '/vendors/jquery-tagsinput/css/jquery.tagsinput',
      '/vendors/daterangepicker/css/daterangepicker',
      '/vendors/datepicker/css/bootstrap-datepicker.min',
      '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
      '/vendors/bootstrap-switch/css/bootstrap-switch.min',
      '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
      '/vendors/fileinput/css/fileinput.min',
      '/vendors/select2/css/select2.min',
      'pages/form_elements',
    ),
    array('inline'=>false)
  );
?>
<header class="head">
  <div class="main-bar">
    <div class="row m-t-10">
      <div class="col-sm-12 col-lg-6">
        <h5 class="text-white">
          Empresas
        </h5>
      </div>
      <div class="col-sm-12 col-lg-6">
        <?php echo $this->Html->link('<i class="fa fa-arrow-left fs-20"></i> Regresar', array('action' => 'view', $empresa['Empresa']['id']),array('escape' => false, 'class'=>'float-right text-white')); ?>
      </div>
    </div>
  </div>
</header>
<div class="outer">
  <div class="inner bg-light lter bg-container">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header bg-white m-b-40">
            <h4>Editar Cliente</h4>
          </div>
          <div class="card-block card_block_top_align ">
            <div class="m-t-40">
              <?= $this->Form->create('Empresa'); ?>
                <?php
                  echo $this->Form->input('id');
                  echo $this->Form->input('direccion_id', array('type'=>'hidden'));
                ?>
                
                <div class="row">
                  <div class="col-sm-12">
                    <h6>Fecha de creación</h6>
                    <h6><?php echo date('d-M-Y', strtotime($empresa['Empresa']['date_create'])); ?></h6>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('razon_social', array('label'=>array('for'=>'razon_social', 'text'=>'Razon social*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required')) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('rfc', array('label'=>array('text'=>'RFC*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required')) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('nombre_comercial', array('label'=>array('text'=>'Nombre comercial*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required')) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('calle', array('label'=>array('text'=>'Calle*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required','value'=>$empresa['Direccion']['calle'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('numero_exterior', array('label'=>array('text'=>'Numero exterior*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required', 'value'=>$empresa['Direccion']['exterior'])) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('numero_interior', array('label'=>array('for'=>'numero_interior', 'text'=>'Numero interior'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control','value'=>$empresa['Direccion']['interior'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('colonia', array('label'=>array('text'=>'Colonia', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required', 'value'=>$empresa['Direccion']['colonia'])) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('cp', array('label'=>array('text'=>'Código postal'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'value'=>$empresa['Direccion']['cp'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('municipio', array('label'=>array('text'=>'Delegación o municipio*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required','value'=>$empresa['Direccion']['municipio'])) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('ciudad', array('label'=>array('for'=>'ciudad', 'text'=>'Ciudad'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control','value'=>$empresa['Direccion']['ciudad'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('estado', array('label'=>array('text'=>'Estado*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required','value'=>$empresa['Direccion']['estado'])) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('pais', array('label'=>array('text'=>'Pais*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required','value'=>$empresa['Direccion']['pais'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('lat', array('label'=>array('text'=>'Latitud*'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control','value'=>$empresa['Direccion']['lat'])) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('lng', array('label'=>array('for'=>'lng', 'text'=>'Longitud*'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control','value'=>$empresa['Direccion']['lng'])) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('telefono', array('label'=>array('for'=>'telefono', 'text'=>'Telefono*', 'class'=>'required'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required')) ?>
                  </div>
                  <div class="form-group">
                    <?= $this->Form->input('fax', array('label'=>array('for'=>'fax', 'text'=>'Fax'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control')) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('pagina_Web', array('label'=>array('for'=>'pagina_Web', 'text'=>'Pagina Web'), 'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control')) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('giro', array('div'=>array('class'=>'col-sm-12'), 'class'=>'form-control', 'rows'=>'1')) ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?php
                      $opciones_categoria = array(
                        'Supervisión Anual' => 'Supervisión Anual',
                        'Partida especial' => 'Partida especial',
                        'Maquilas' => 'Maquilas',
                        'Supervisión Externa OU' => 'Supervisión Externa OU',
                        'Supervisión Externa star-k' => 'Supervisión Externa star-k',
                        'Supervisión Otra' => 'Supervisión Otra',
                        'Otra' => 'Otra');
                      echo $this->Form->input(
                        'objetivo',
                          array(
                            'label' =>array('text'=>'Categoria'),
                            'div'=>array('class'=>'col-sm-12'),
                            'class'=>'form-control required chzn-select',
                            'type'=>'select',
                            'options'=>$opciones_categoria
                          )
                        )
                    ?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('horario_trabajo', array('label' => array('text'=>'Horario de Trabajo*', 'class'=>'required'),'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required')) ?>

                    <?= $this->Form->input('fecha_vencimiento',
                      array(
                        'label'=>'Fecha Vigencia',
                        'div'=>array('class'=>'col-sm-12 col-lg-6'),
                        'id'=>'dp1',
                        'type'=>'text',
                        'class'=>'form-control',
                        'value' => date('d-m-Y', strtotime($empresa['Empresa']['fecha_vencimiento'])),
                        'placeholder'=>'dd/mm/yyyy',
                        'required'=>True
                      )
                    )?>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?php if (isset($id_padre)): ?>
                      <?= $this->Form->input('empresa_padre', array('div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control chzn-select', 'type'=>'select', 'options'=>$empresas,'value'=>$id_padre)) ?>
                    <?php else: ?>
                      <?= $this->Form->input('empresa_padre', array('div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control chzn-select', 'type'=>'select', 'options'=>$empresas,'empty'=>'Ninguna')) ?>
                      
                    <?php endif ?>

                    <?= $this->Form->input('status', array('div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control', 'required', 'type'=>'select', 'options'=>array('Activo'=>'Activo','Inactivo'=>'Inactivo'))) ?>
                  </div>
                </div>
                <div class="row m-t-40">
                  <hr>
                </div>
                <div class="row">
                  <div class="form-group">
                    <?= $this->Form->input('rabino_responsable', array('label'=>array('text'=>'Rabino responsable*', 'class'=>'required'),'div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control chzn-select required', 'required', 'type'=>'select', 'options'=>$responsables)) ?>

                    <?= $this->Form->input('promotor_id', array('div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control required chzn-select', 'required', 'type'=>'select', 'options'=>$promotores)) ?>

                    <?= $this->Form->input('renovacion_id', array('div'=>array('class'=>'col-sm-12 col-md-6'), 'class'=>'form-control required chzn-select', 'required', 'type'=>'select', 'options'=>$renovaciones)) ?>
                    
                  </div>
                </div>
                <div class="row">
                  <div class="form-group">
                    
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-12 m-t-20">
                    <?= $this->Form->button('Guardar', array('class'=>'btn btn-success', 'type'=>'submit')); ?>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?=
$this->Html->script(
  array(
    '/vendors/jquery.uniform/js/jquery.uniform',
    '/vendors/inputlimiter/js/jquery.inputlimiter',
    '/vendors/chosen/js/chosen.jquery',
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

    '/vendors/select2/js/select2',
    'form',
    'pages/form_elements',
    '/vendors/inputmask/js/inputmask',
    '/vendors/inputmask/js/jquery.inputmask',
    '/vendors/inputmask/js/inputmask.date.extensions',
    '/vendors/inputmask/js/inputmask.extensions',
    '/vendors/fileinput/js/fileinput.min',
    '/vendors/fileinput/js/theme',
    'pages/form_elements',
    'form',

    // Calendario
  ),
  array('inline'=>false)
);
?>
<?php
  $aniomas = date('Y') + 2;
  $aniomenos = date('Y') - 2;
?>
<?php
    $this->Html->scriptStart(array('inline' => false));
?>
"use strict";
$(document).ready(function() {
  /* Calendarios */
  $('#dp1').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"auto",
    startDate: "<?= '01-01-'.$aniomenos; ?>",
    endDate: "<?= '31-12-'.$aniomas; ?>"
  });
});
<?php
    $this->Html->scriptEnd();
?>
