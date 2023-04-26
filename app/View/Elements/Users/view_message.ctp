<?= $this->Html->css(
  array(
    'pages/layouts',
    '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
    'pages/wizards',
    '/vendors/chosen/css/chosen',
    '/vendors/bootstrap-switch/css/bootstrap-switch.min',
    '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
    '/vendors/fileinput/css/fileinput.min',
    '/vendors/jquery-validation-engine/css/validationEngine.jquery',
    '/css/pages/form_validations',
    'pages/mail_box',

    '/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min',
    '/vendors/summernote/css/summernote',
    'custom',
  ),
  array('inline'=>false))
?>
<style>
  .no-print{display: none;}
</style>
<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-lg-12">
        <h4 class="nav_top_align"><i class="fa fa-inbox"></i> Bandeja de entrada</h4>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-container">
      <div class="row web-mail mail_compose">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-block m-t-20">

            <header style="border-bottom: 1px solid #000;">
              <p class="m-t-20" style=" font-size: 20px;">

                <?php
                  $texto = $inbox['header']['subject'];
                  $elementos = imap_mime_header_decode($texto);
                  for ($i=0; $i < count($elementos); $i++) {
                    $subjet = "{$elementos[$i]->text}";
                    echo $subjet;
                  }
                ?>
                
              </p>
              <p class="m-t-10">
                <span>De:
                  <?php
                    $elementos = imap_mime_header_decode($inbox['header']['fromAddress']);
                    for ($i=0; $i < count($elementos); $i++) {
                      $to = "{$elementos[$i]->text}";
                      echo $to;
                    }
                  ?>
                  <?php echo '< '.$inbox['header']['fromMail'].' >'; ?>
                </span>
                <span class="float-xs-right"><?= date('d-M-y H:m', strtotime($inbox['header']['date'])); ?></span>
              </p>
            </header>

              <div class="m-t-20 m-b-20">
                <?= $inbox['body']; ?>
              </div>
              <hr>
              <div class="m-t-30">
                <?= $this->Form->button('<i class="fa fa-reply"></i> Responder', array('class'=>'btn btn-primary', 'escape'=>false, 'id'=>'responder', 'type'=>'button')); ?>
                <?= $this->Form->button('<i class="fa fa-undo"></i> Reenviar', array('class'=>'btn btn-secundary', 'escape'=>false, 'id'=>'reenviar', 'type'=>'button')); ?>
              </div>

              <div class="m-t-10">
                <!-- Formulario para reenviar -->
                <div id="form-responder" style="display: none;">
                  <?= $this->Form->create('User', array('id'=>'responder', 'url'=>array('action'=>'enviar_email', 'controller'=>'users'))); ?>
                    <div class="form-group">
                        <?= $this->Form->input('para', array('type'=>'hidden', 'value'=>$inbox['header']['fromMail'])) ?>
                        <?= $this->Form->input('subject', array('type'=>'hidden', 'value'=>$subjet)) ?>
                        <?= $this->Form->input('message_id', array('type'=>'hidden', 'value'=>$id)) ?>
                        
                        <?php $message_structure =  $inbox["body"]; ?>

                        <div class="float-xs-right box-tools"></div>
                        <textarea class="textarea wysihtml5 form-control m-t-20" id="textarea_responder" name="data[User][mensaje]">
                          <?= $message_structure; ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                      <?= $this->Form->button('<i class="fa fa-send"></i> Enviar', array('class'=>'btn btn-primary', 'escape'=>false, 'type'=>'submit')); ?>
                      <?= $this->Form->button('<i class="fa fa-trash"></i> Cancelar', array('class'=>'btn btn-danger', 'type'=>'button', 'escape'=>false, 'id'=>'trash_responder')) ?>
                    </div>
                  <?= $this->Form->end(); ?>
                </div>
                <!-- Fin de formulario para reenviar -->


                <div id="form-reenviar" style="display: none;">
                  <?= $this->Form->create('User', array('id'=>'reenviar', 'url'=>array('action'=>'enviar_email', 'controller'=>'users'))); ?>
                    <div class="form-group">
                      <div class="col-sm-1">
                        <?= $this->Form->label('Para: '); ?>
                      </div>
                      <div class="col-sm-11">
                        <?= $this->Form->input('para', array('type'=>'text', 'label'=>false, 'class'=>'form-control m-b-20', 'id'=>'para_reenviar')) ?>
                        <?= $this->Form->input('subject', array('type'=>'hidden', 'value'=>$subjet)) ?>
                        <?= $this->Form->input('message_id', array('type'=>'hidden', 'value'=>$id)) ?>

                        
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="float-xs-right box-tools"></div>

                        <?php $messaje =  
                          '
                            <p>---------- Mensaje Reenviado ----------</p>
                            <p>De: '.$inbox["header"]["fromMail"].' </p>
                            <p>Fecha: '.date("d-m-y H:m", strtotime($inbox["header"]["date"])).' </p>
                            <p>Asunto: '.$subjet.'</p>
                            <br>
                            '.$message_structure.'
                          '
                        ?>
                        <textarea class="textarea wysihtml5 form-control m-t-20" id="textarea_renviar" name="data[User][mensaje]">
                          <?= $messaje; ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                      <?= $this->Form->button('<i class="fa fa-send"></i> Enviar', array('class'=>'btn btn-primary', 'escape'=>false, 'type'=>'submit')); ?>
                      <?= $this->Form->button('<i class="fa fa-trash"></i> Cancelar', array('class'=>'btn btn-danger', 'type'=>'button', 'escape'=>false, 'id'=>'trash_reenviar')) ?>
                    </div>
                  <?= $this->Form->end(); ?>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->Html->script(
  array(
    'pages/layouts',
    '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
    '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
    '/vendors/inputmask/js/inputmask',
    '/vendors/inputmask/js/jquery.inputmask',
    '/vendors/validval/js/jquery.validVal.min',
    '/vendors/chosen/js/chosen.jquery',
    '/vendors/bootstrap-switch/js/bootstrap-switch.min',
    'form',
    'pages/form_elements',
    '/vendors/tinymce/js/tinymce.min',
    '/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min',
    '/vendors/summernote/js/summernote.min',
    '/vendors/jquery.uniform/js/jquery.uniform',
    '/vendors/inputlimiter/js/jquery.inputlimiter',
    '/vendors/chosen/js/chosen.jquery',
    '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
    '/vendors/jquery-tagsinput/js/jquery.tagsinput',
    '/vendors/validval/js/jquery.validVal.min',
    '/vendors/moment/js/moment.min',
    '/vendors/daterangepicker/js/daterangepicker',
    '/vendors/datepicker/js/bootstrap-datepicker.min',
    '/vendors/datetimepicker/js/DateTimePicker.min',
    '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
    '/vendors/bootstrap-switch/js/bootstrap-switch.min',
    '/vendors/autosize/js/jquery.autosize.min',
    '/vendors/inputmask/js/inputmask',
    '/vendors/inputmask/js/jquery.inputmask',
    '/vendors/inputmask/js/inputmask.date.extensions',
    '/vendors/inputmask/js/inputmask.extensions',
    '/vendors/fileinput/js/fileinput.min',
    '/vendors/fileinput/js/theme',
    'form',
    'pages/mail_box',
  ),
  array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {

  $('#responder').click(function(){
    $("#form-responder").fadeIn();
    $("#form-reenviar").fadeOut(400);
    $('#textarea_responder').focus();
    $("#responder").addClass('disabled');
    $("#reenviar").removeClass('disabled');

  });

  $('#trash_responder').click(function(){
    $("#form-responder").fadeOut(400);
  });

  $('#reenviar').click(function(){
    $("#form-reenviar").fadeIn();
    $('#para_reenviar').focus();
    $("#form-responder").fadeOut(400);
    $("#reenviar").addClass('disabled');
    $("#responder").removeClass('disabled');

  });

  $('#trash_reenviar').click(function(){
    $("#form-reenviar").fadeOut(400);
  });
  

  /* Script for textarea wysihtml5*/
  $(".textarea").wysihtml5();
  $(".wysihtml5-toolbar li:nth-child(3) a,.wysihtml5-toolbar li:nth-child(4) a,.wysihtml5-toolbar li:nth-child(5) a,.wysihtml5-toolbar li:nth-child(6) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:first-child,.wysihtml5-toolbar .btn-group:eq(3) a:first-child").addClass("fa fa-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(2),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(2)").addClass("fa fa-th-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(3),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(3)").addClass("fa fa-align-left");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(4),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(4)").addClass("fa fa-align-right");
    $(".wysihtml5-toolbar li:nth-child(5) span").addClass("fa fa-share");
    $(".wysihtml5-toolbar li:nth-child(6) span").addClass("fa fa-picture-o");
    $("[data-wysihtml5-command='formatBlock'] span").css("position","relative").css("top","-5px").css("left","-5px");
    $(".note-toolbar button").removeClass('btn-default').addClass('btn-secondary');
    $(".wysihtml5-toolbar li:nth-child(2) a").removeClass('btn-default').addClass('btn-secondary');

});
<?php 
    $this->Html->scriptEnd();
?>