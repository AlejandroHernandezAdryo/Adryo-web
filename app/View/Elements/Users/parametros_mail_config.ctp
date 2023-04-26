
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',

            '/vendors/jquery-tagsinput/css/jquery.tagsinput',
            ),
        array('inline'=>false))
        
?>
<style>
    .tag{
        background: #2e3c54eb !important;
        border: none !important;
        color: #FFF !important;
        font-weight: 500 !important;
    }
    
    div.tagsinput span.tag a {
        color: #FFF !important;
    }
    .tagsinput{
        width: 100% !important;
        height: auto !important;
        min-height: 30px !important;
    }

    #ParametrosNClientes_tag, #ParametrosCcAsignacion_tag, #ParametrosCcAsesorAClientes_tag {
        width: auto !important;
    }
</style>
<script>
    function displayClientes(){
        if (document.getElementById('UserMep').value==0){
            document.getElementById('mails_clientes').style.display="none";
        }else{
            document.getElementById('mails_clientes').style.display="";
        }
    }
    
    function displayRegistro(){
        if (document.getElementById('UserMr').value==0){
            document.getElementById('registro_clientes').style.display="none";
        }else{
            document.getElementById('registro_clientes').style.display="";
        }
    }
    
    function showDetalle(){
        if (String(document.getElementById('UserCuentaCorreo').value).includes("gmail.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("hotmail.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("yahoo.com") ||
            String(document.getElementById('UserCuentaCorreo').value).includes("outlook.com")
            )
        {
            document.getElementById('detalle').style.display="none";
        }else{
            document.getElementById('detalle').style.display="";
        }
    }

</script>
<div id="content" class="bg-container">
  <header class="head">
      <div class="main-bar row">
          <div class="col-lg-12">
              <h4 class="nav_top_align"><i class="fa fa-th"></i> Bienvenido a Adryo</h4> 
          </div>
      </div>
  </header>
  <div class="outer">
      <div class="inner bg-container ">
          <div class="row">
              <div class="col-xl-12">
                  <div class="card m-t-35">
                      <div class="card-header" style="background-color: #2e3c54; color:white">
                          INFORMACIÓN DE LA CUENTA
                      </div>
                      <div class="card-block">
                          <div class="row">
                              <div class="col-sm-12">
                                  <div id="rootwizard_no_val">
                                      <ul class="nav nav-pills">
                                          <li class="nav-item user1 m-t-15">
                                              <?= $this->Html->link('<span class="userprofile_tab">1</span>Información de la Empresa', array('action'=>'edit', 'controller'=>'cuentas'),array('escape'=>False, 'class'=>'nav-link')) ?>
                                          </li>
                                          <li class="nav-item user2 m-t-15">
                                              <?= $this->Html->link('<span class="userprofile_tab">2</span>Párametros de seguimiento', array('action'=>'parametrizacion', 'controller'=>'users'),array('escape'=>False, 'class'=>'nav-link')) ?>
                                          </li>
                                          <li class="nav-item finish_tab m-t-15">
                                              <a class="nav-link active"><span>3</span>Configuración de correos</a>
                                          </li>
                                      </ul>
                                      <div class="tab-content m-t-20">
                                          <div class="tab-pane active" id="info_emp">
                                              <?php
                                                echo $this->Form->create('Parametros');
                                                echo $this->Form->hidden('mail_config_id', array('value'=>$parametros_mail['Mailconfig']['id']));
                                              ?>
                                              <div class="row mt-2">
            <div class="col-sm-12">
            <!-- <pre> 
              <?php
                print_r($parametros_generales);
              ?>
            </pre> -->
              <div class="table-responsive">
                <table class="table table-sm" style="border: none;">
                  <tbody>
                    <tr>
                      <td style="background: #646464;
                                font-weight: 500;
                                color: #fff;
                                text-transform: uppercase;"
                          colspan="2">
                          CONFIGURACIÓN DE CORREO ELECTRÓNICO DE NOTIFICACIONES
                      </td>
                    </tr>
                    <tr>
                      <td class="col-sm-12 col-lg-6">
                        <?= $this->Form->label('LabelCorreoContacto',
                            'Correo Electrónico',
                            array(
                                'div' => 'col-sm-12',
                            )
                        ); ?>
                      </td>
                      <td class="col-sm-12 col-lg-6">
                          <?= $this->Form->input('correo_contacto',
                              array(
                                  'class'       => 'form-control',
                                  'label'       => false,
                                  'div'         => 'col-sm-12',
                                  'placeholder' => 'sistemabos@dominio.com',
                                  'value'       => $parametros_mail['Mailconfig']['usuario']
                              )
                          ); ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-sm-12 col-lg-6">
                        <?= $this->Form->label('LabelPassword',
                            'Password',
                            array(
                                'div' => 'col-sm-12',
                            )
                        ); ?>
                      </td>
                      <td class="col-sm-12 col-lg-6">
                          <?= $this->Form->input('password',
                              array(
                                  'class'       => 'form-control',
                                  'label'       => false,
                                  'div'         => 'col-sm-12',
                                  'placeholder' => '',
                                  'value'       => $parametros_mail['Mailconfig']['password'],
                                  'type'        => 'text'
                              )
                          ); ?>
                      </td>
                    </tr>
                    <tr>
                      <td class="col-sm-12 col-lg-6">
                        <?= $this->Form->label('LabelPuerto',
                            'Puerto SMTP',
                            array(
                                'div' => 'col-sm-12',
                            )
                        ); ?>
                      </td>
                      <td class="col-sm-12 col-lg-6">
                          <?= $this->Form->input('puerto',
                              array(
                                  'class'       => 'form-control',
                                  'label'       => false,
                                  'div'         => 'col-sm-12',
                                  'placeholder' => '587',
                                  'value'       => $parametros_mail['Mailconfig']['puerto']
                              )
                          ); ?>
                      </td>
                      <tr>
                      <td class="col-sm-12 col-lg-6">
                        <?= $this->Form->label('LabelServidorSalida',
                            'Servidor de Salida',
                            array(
                                'div' => 'col-sm-12',
                            )
                        ); ?>
                      </td>
                      <td class="col-sm-12 col-lg-6">
                          <?= $this->Form->input('smtp',
                              array(
                                  'class'       => 'form-control',
                                  'label'       => false,
                                  'div'         => 'col-sm-12',
                                  'placeholder' => 'mail.dominio.com',
                                  'value'       => $parametros_mail['Mailconfig']['smtp']
                              )
                          ); ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="row mt-2">
              <div class="col-sm-12">
                  <div class="table-responsive">
                      <table class="table table-sm" style="border: none;">
                          <tbody>
                              <tr>
                                  <td style="background: #646464; font-weight: 500; color: #fff; text-transform: uppercase;" colspan="2">Notificaciones de correos electronicos (para clientes)</td>
                              </tr>
                              <tr>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->label('nRegistro',
                                          'Correos para notificar un registro de nuevo cliente en la base de datos.',
                                          array(
                                              'div' => 'col-sm-12',
                                          )
                                      ); ?>
                                  </td>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->input('nClientes',
                                          array(
                                              'class' => 'form-control tags',
                                              'label' => false,
                                              'div'   => 'col-sm-12',
                                              'placeholder' => 'Agregar correo',
                                              'value' => $parametros_generales['Paramconfig']['nuevo_cliente']
                                          )
                                      ); ?>
                                  </td>
                              </tr>
                              
                              <!-- Con Copia para asignación de clientes. -->
                              <tr>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->label('ccAsignacion',
                                          'Correos para recibir copia del aviso al asesor de una nueva asignación de cliente.',
                                          array(
                                              'div' => 'col-sm-12',
                                          )
                                      ); ?>
                                  </td>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->input('ccAsignacion',
                                          array(
                                              'class' => 'form-control tags',
                                              'label' => false,
                                              'div'   => 'col-sm-12',
                                              'placeholder' => 'Agregar correo',
                                              'value' => $parametros_generales['Paramconfig']['asignacion_c_a']
                                          )
                                      ); ?>
                                  </td>
                              </tr>

                              <!-- Con Copia de asesores para clientes. -->
                              <tr>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->label('ccAsesorAClientes',
                                          'Correos para recibir copia de los emails enviados por el cliente de forma automática o en envío de nuevas propiedades.',
                                          array(
                                              'div' => 'col-sm-12',
                                          )
                                      ); ?>
                                  </td>
                                  <td class="col-sm-12 col-lg-6">
                                      <?= $this->Form->input('ccAsesorAClientes',
                                          array(
                                              'class' => 'form-control tags',
                                              'label' => false,
                                              'div'   => 'col-sm-12',
                                              'placeholder' => 'Agregar correo',
                                              'value' => $parametros_generales['Paramconfig']['cc_a_c']
                                          )
                                      ); ?>
                                  </td>
                              </tr>


                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
          <!-- End of table notifications emial-->


                                                  <div class="row">
                                                      <div class="col-sm-12">
                                                        <?= $this->Form->submit('Terminar configuración', array('class'=>'btn btn-success btn-block')); ?>
                                                      </div>
                                                  </div>
                                              <?= $this->Form->end(); ?>
                                          </div>
                                      </div>
                                      <!-- End div tab content -->
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
            'components',
            'custom',

            '/vendors/jquery-validation-engine/js/jquery.validationEngine',
            '/vendors/jquery-validation-engine/js/jquery.validationEngine-en',
            '/vendors/jquery-validation/js/jquery.validate',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/moment/js/moment.min',
            'form',
            '/vendors/sweetalert/js/sweetalert2.min',
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            
            // Input tags
            '/vendors/jquery-tagsinput/js/jquery.tagsinput',
            // 'form',
            // 'pages/form_elements',
        ),
        array('inline'=>false))
?>

<script>
    
'use strict';
$(document).ready(function() {

    $('.tags').tagsInput({
        defaultText:'Agregar correo',
        /*width:'600px',
        height:'100px',*/
    });

    $('#UserInformacionEmpresaForm').bootstrapValidator({
        framework: 'bootstrap',
        fields: {
            razon_social: {
                validators: {
                    notEmpty: {
                        message: 'Es necesaria la razón social'
                    }
                }
            },
            nombre_comercial: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su nombre comercial'
                    }
                }
            },
            rfc: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su RFC'
                    },
                }
            },
            direccion_fiscal: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su dirección fiscal'
                    }
                }
            },
            telefono_empresa_1: {
                validators: {
                    notEmpty: {
                        message: 'Es necesario su número telefónico'
                    }
                }
            },
        }
    });

    
    $(".phone").inputmask();
    $("#UserProfilePicture").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Escoger Foto",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"


    });
    $("#UserLogo").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-success",
        browseLabel: "Escoger Foto",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"


    });
});
</script>