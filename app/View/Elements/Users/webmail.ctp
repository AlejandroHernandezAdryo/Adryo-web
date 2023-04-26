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
  ),
  array('inline'=>false))
?>

<div id="content" class="bg-container">
  <header class="head">
    <div class="main-bar row">
      <div class="col-lg-12">
        <h4 class="nav_top_align"><i class="fa fa-inbox"></i> Inbox</h4>
      </div>
    </div>
  </header>
  <div class="outer">
    <div class="inner bg-container">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-block m-t-20">
              <?php echo $this->Session->flash(); ?>
              <div class="row web-mail">
                <div class="col-lg-12">
                  <div class="card mail media_max_991">
                    <div class="card-block m-t-25 p-d-0">
                      <div class="tab-pane table-responsive reset padding-all fade active in" id="primary">
                        <table class="table">
                          <tbody>
                            <pre>
                            <!-- <?php

                              
                              print_r($mensajes);
                            ?> -->
                            </pre>
                            <?php foreach ($mensajes as $inbox): ?>
                              <tr class="mail-unread">
                                <td style="width: 50px;">
                                  <div class="checker m-l-20">
                                    <label class="custom-control custom-checkbox">
                                      <input name="checkbox" type="checkbox" class="custom-control-input ">
                                      <span class="custom-control-indicator"></span>
                                    </label>
                                  </div>
                                </td>
                                <td><i class="fa fa-star"></i></td>
                                <td>
                                  <a href="view_message/<?= $inbox['msgno'] ?>"><?= imap_utf8($inbox['from']) ?></a>
                                </td>
                                <td>
                                  <?php
                                    // Decodificar el texto
                                    $texto = $inbox['subject'];
                                    $elementos = imap_mime_header_decode($texto);
                                    for ($i=0; $i < count($elementos); $i++) {
                                      echo "<a href='view_message/".$inbox['msgno']."'>{$elementos[$i]->text}</a>";
                                    }
                                  ?>
                                </td>
                                <td style="width: 80px;">
                                  <a href="view_message/<?= $inbox['msgno'] ?>"><?= date('d-M', strtotime($inbox['date'])) ?></a>
                                </td>
                              </tr>
                            <?php endforeach ?>
                          </tbody>
                        </table>
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
    /*'pages/mail_box',*/
  ),
  array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
});
<?php 
    $this->Html->scriptEnd();
?>