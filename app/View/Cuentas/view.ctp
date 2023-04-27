
<?php 
    $condiciones = array('1'=>'Si', '2'=>'No');
    $condiciones_temp = array('1'=>'Automatico', '2'=>'Manual');

    echo $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            ),
        array('inline'=>false))
        
?>
<style>
    .text-align-right{
        text-align: right;
    }
</style>

<div id="content" class="bg-container">

    <?= $this->Element('Cuentas/add_data_mappen') ?>

    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align">Configuración</h4> 
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card m-t-15">
                        <div class="card-header bg-blue-is rounded-top" >
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">Información de la cuenta</div>
                                <div class="col-sm-12 col-lg-6 text-align-right" >
                                    <span>Editar</span>
                                    <?= $this->Html->link('<i class="fa fa-edit fa-lg"></i>', array('controller'=>'cuentas', 'action'=>'edit'), array('escape'=>false, 'class'=>'color:#1E5B5A;', 'id' => 'edit_info_cuenta')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $this->Form->create('Cuenta', array('type'=>'file'))?>
                                    <div class="col-sm-12 mb-2">
                                        <?= $this->Html->image($cuenta['Cuenta']['logo'], array('class'=>'img-fluid mx-auto d-block','style'=> 'width:20%;')); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div id="rootwizard_no_val">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#info_emp" data-toggle="tab" onclick="link_dinamico(1)">Información de la empresa</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#param_general" data-toggle="tab" onclick="link_dinamico(2)">Parámetro de seguimiento</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#config_av" data-toggle="tab" onclick="link_dinamico(3)">Configuración de correo</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#conexion" data-toggle="tab" onclick="link_dinamico(4)">Conexiones externas</a>
                                            </li>
                                        </ul>
                                        <!-- <ul class="nav nav-pills">
                                            <li class="nav-item user1 m-t-15">
                                                <a class="nav-link active" href="#info_emp" data-toggle="tab" onclick="link_dinamico(1)">
                                                    <span class="userprofile_tab">
                                                        1
                                                    </span>
                                                    Información de la Empresa
                                                </a>
                                            </li>
                                            <li class="nav-item user2 m-t-15">
                                                <a class="nav-link" href="#param_general" data-toggle="tab" onclick="link_dinamico(2)">
                                                    <span class="profile_tab">
                                                        2
                                                    </span>
                                                    Párametros de seguimiento
                                                </a>
                                            </li>
                                            <li class="nav-item finish_tab m-t-15">
                                                <a class="nav-link " href="#config_av" data-toggle="tab" onclick="link_dinamico(3)"><span>3</span>Configuración de correos</a>
                                            </li>
                                        </ul> -->
                                        <div class="tab-content m-t-20">
                                            <!-- tab información de la empresa -->
                                            <div class="tab-pane active" id="info_emp">
                                                <div class="row m-t-20">
                                                    <div class="col-sm-12">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Razón social</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-right:8px;"><?= $cuenta['Cuenta']['razon_social'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Nombre comercial</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['nombre_comercial'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>RFC</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['rfc'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Dirección fiscal</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['direccion'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Teléfono 1</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['telefono_1'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Teléfono 2</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['telefono_2'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                        <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Página web</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['pagina_web'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Correo de contacto</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['correo_contacto'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>ID de Seguridad de Cuenta</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-right:8px;"><?= $cuenta['Cuenta']['unique_id'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Url de Facebook</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['url_facebook'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Url de Twitter</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['url_twitter'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span style="padding-left:8px;"><b>Url de Instagram</b></span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-6">
                                                                    <span class="float-lg-right pl-sm-2" style="padding-left:8px;"><?= $cuenta['Cuenta']['url_instagram'] ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="margin-top:4px;">
                                                        <!-- <table class="table responsive-table">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Razón social</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['razon_social'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="min-width: 150px;">Nombre comercial</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['nombre_comercial'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['rfc'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="min-width: 150px;">Dirección fiscal</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['direccion'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Teléfono 1</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['telefono_1'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Teléfono 2</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['telefono_2'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Página web</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['pagina_web'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="min-width: 150px;">Correo de contacto</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['correo_contacto'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>ID de Seguridad de Cuenta</td>
                                                                    <td class="text-align-right" style="text-transform:uppercase"><?= $cuenta['Cuenta']['unique_id'] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Url de Facebook</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['url_facebook'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Url de Twitter</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['url_twitter'] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Url de Instagram</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['url_instagram'] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>Url de Youtube</td>
                                                                    <td class="text-align-right"><?= $cuenta['Cuenta']['url_youtube'] ?></td>
                                                                </tr>

                                                            </tbody>
                                                        </table> -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tab 2 Parametros Generales. -->
                                            <div class="tab-pane" id="param_general">
                                                <div class="row">
                                                    <!-- Estatus de seguimiento **Korner 24-04-2023** -->
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Estatus de seguimiento
                                                                <br>
                                                                <small>Esta información se verá reflejada en el listado de clientes en la columna E.A.</small>
                                                            </div>
                                                            <div class="card-block" style="height:138px;">
                                                                <div class="row" style="border-bottom:1px solid #82A3A3;">
                                                                    <div class="col-sm-12 col-lg-10">
                                                                        <p>Días límite para considerar seguimiento oportuno</p>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-2">
                                                                        <p>
                                                                            <?= $cuenta['Parametros']['sla_oportuna'] ?>
                                                                            <span><?= (($cuenta['Parametros']['sla_oportuna']  > 1  ) ? 'dias' : 'día') ?></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="border-bottom:1px solid #82A3A3;padding-top:8px;">
                                                                    <div class="col-sm-12 col-lg-10">
                                                                        <p>Días límite para considerar seguimiento tardío</p>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-2">
                                                                        <p>
                                                                            <?= $cuenta['Parametros']['sla_atrasados'] ?>
                                                                            <span><?= (($cuenta['Parametros']['sla_atrasados']  > 1  ) ? 'dias' : 'día') ?></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="padding-top:8px;">
                                                                    <div class="col-sm-12 col-lg-10">
                                                                        <p style="margin-bottom:0;">Días límite para considerar seguimiento no atendido</p>
                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-2">
                                                                        <p style="margin-bottom:0;">
                                                                            <?= $cuenta['Parametros']['sla_no_atendidos'] ?>
                                                                            <span><?= (($cuenta['Parametros']['sla_no_atendidos']  > 1  ) ? 'dias' : 'día') ?></span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Mensaje de WA al cliente **Korner 24-04-2023** -->
                                                    <div class="col-sm-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Mensaje de WhatsApp al cliente
                                                                <br>
                                                                <small>Edita el texto usando las variables para personalizar tu mensaje</small>
                                                            </div>
                                                            <div class="card-block" style="height: 145px;">
                                                                <p>
                                                                    <?= (!empty($cuenta['Parametros']['message_default_whatsapp']) ? $cuenta['Parametros']['message_default_whatsapp'] : '') ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Mensajes de correo al cliente **Korner 24-04-2023** -->
                                                <div class="row mt-2">
                                                    <div class="col-sm-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                Mensajes de correo al cliente
                                                                <br>
                                                                <small>Edita el cuerpo del correo y el asunto para generar tus correo predeterminados</small>
                                                            </div>
                                                            <div class="card-block" style="padding: 16px 2px;">
                                                                <!-- Correo de bienvenida **Korner 24-04-2023** -->
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            Correo de bienvenida
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div>
                                                                                <span>Asunto:</span>
                                                                                <p><?= (!empty($cuenta['Parametros']['smessage_new_client']) ? $cuenta['Parametros']['smessage_new_client'] : '') ?></p>
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= (!empty($cuenta['Parametros']['bmessage_new_client']) ? $cuenta['Parametros']['bmessage_new_client'] : '') ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Correo de unidades **Korner 24-04-2023** -->
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                        Correo de reenvío / otro desarrollo
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div>
                                                                                <span>Asunto:</span>
                                                                                <p><?= (!empty($cuenta['Parametros']['smessage_new_desarrollo']) ? $cuenta['Parametros']['smessage_new_desarrollo'] : '') ?></p>
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= (!empty($cuenta['Parametros']['bmessage_seg_cliente_desarrollo']) ? $cuenta['Parametros']['bmessage_seg_cliente_desarrollo'] : '') ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Correo de reenvío / otro desarrollo **Korner 24-04-2023** -->
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            Correo de unidades
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div>
                                                                                <span>Asunto:</span>
                                                                                <p><?= (!empty($cuenta['Parametros']['smessage_new_propiedad']) ? $cuenta['Parametros']['smessage_new_propiedad'] : '') ?></p>
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= (!empty($cuenta['Parametros']['bmessage_seg_cliente_inmuebles']) ? $cuenta['Parametros']['bmessage_seg_cliente_inmuebles'] : '') ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- tab 3 Configuración avanzada -->
                                            <div class="tab-pane " id="config_av">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <table class="table responsive-table table-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2" style="background: #258F8D; font-weight: 500; color: #fff;padding-left:8px;border-radius:8px 8px 0 0;">
                                                                        Configuración de correo electrónico de notificaciones
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 8px;">Correo Electrónico</td>
                                                                    <td class="text-align-right" style="padding-right:8px;"><?= $cuenta['MailConfig']['usuario'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 8px;">Password</td>
                                                                    <td class="text-align-right" style="padding-right:8px;">
                                                                        <?php
                                                                            $contador      = strlen($cuenta['MailConfig']['password']);
                                                                            $finPassword   = substr($cuenta['MailConfig']['password'], -3);
                                                                            $contadorNuevo = $contador - 3;

                                                                            for ($i=0; $i < $contadorNuevo ; $i++) { 
                                                                                echo "*";
                                                                            }
                                                                            echo $finPassword;

                                                                        ?>
                                                                        <!-- <i class="fa fa-eye pointer" data-toggle = "tooltip" data-placement = "top" title = "Mostrar contraseña" onclick="showPassword()"></i> -->
                                                                    </td>
                                                                </tr>
                                                                <script>
                                                                    function showPassword(){
                                                                        alert('Alerta de click');
                                                                    }
                                                                </script>
                                                                <tr>
                                                                    <td style="padding-left: 8px;">Puerto SMTP</td>
                                                                    <td class="text-align-right" style="padding-right:8px;"><?= $cuenta['MailConfig']['puerto'] ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 8px;">Servidor de salida</td>
                                                                    <td class="text-align-right" style="padding-right:8px;"><?= $cuenta['MailConfig']['smtp'] ?></td>
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="2" style="background: #258F8D; font-weight: 500; color: #fff;padding-left:8px;border-radius:8px 8px 0 0;">
                                                                        Notificaciones de correo electrónicos (clientes)
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="padding-left: 8px;">
                                                                        Correos para notificar un registro de nuevo cliente en la base de datos.
                                                                    </td>
                                                                    <td class="text-align-right" style="padding-right:8px;">
                                                                        <?php
                                                                            $emails_c_a = explode( ",", $parametros['Paramconfig']['nuevo_cliente'] );
                                                                            foreach($emails_c_a as $email_c_a):
                                                                                echo $email_c_a.'<br>';
                                                                            endforeach;
                                                                        ?>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td style="padding-left: 8px;">
                                                                        Correos para recibir copia del aviso al asesor de una nueva asignación de cliente.
                                                                    </td>
                                                                    <td class="text-align-right" style="padding-right:8px;">
                                                                        <?php
                                                                            $asignacions_c_a = explode( ",", $parametros['Paramconfig']['asignacion_c_a'] );
                                                                            foreach($asignacions_c_a as $asignacion_c_a):
                                                                                echo $asignacion_c_a.'<br>';
                                                                            endforeach;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 8px;">
                                                                    Correos para recibir copia de los emails enviados por el cliente de forma automática <br> o en envío de nuevas propiedades.
                                                                    </td>
                                                                    <td class="text-align-right" style="padding-right:8px;">
                                                                        <?php
                                                                            $cc_a_cs = explode( ",", $parametros['Paramconfig']['cc_a_c'] );
                                                                            foreach($cc_a_cs as $cc_a_c):
                                                                                echo $cc_a_c.'<br>';
                                                                            endforeach;
                                                                        ?>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- End table. parameter of configurations emails -->
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- tab 4 Conexiones externas -->
                                            <div class="tab-pane " id="conexion">
                                                <div class="row">

                                                    <div class="col col-lg-4 col-md-6 col-sm-12 mb-2">
                                                        <div class="card border-dark rounded">
                                                            <div class="card-block p-1">
                                                                <div class="col-sm-3">
                                                                <?= $this->Html->image('mappen.png', array('class'=>'img-fluid mx-auto d-block','style'=> 'width:120%;')); ?>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <div><h4 style="color:#000;">Adryo - <?= (!empty($mappen['ConexionesExtern']['nombre_externo']) ? $mappen['ConexionesExtern']['nombre_externo'] : '' ) ?></h4></div>
                                                                    <div><p class = "uppercase">Identificador: <?= (!empty($mappen['ConexionesExtern']['id_externo']) ? $mappen['ConexionesExtern']['id_externo'] : '' ) ?> </p></div>
                                                                </div>
                                                            </div>
                                                            <div class="card-block p-1">
                                                                <div class="col-sm-12 col-lg-8">
                                                                    <span>
                                                                        <b>
                                                                            Estatus:
                                                                            <?= (!empty($mappen['ConexionesExtern']['status']) ? 'Vinculado <span class="vinculado"></span>' : 'Desvinculado <span class="desvinculado"></span>' ) ?>
                                                                        </b>
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <?php if( empty($mappen['ConexionesExtern']['status'] )): ?>
                                                                        <button type="button" class="btn btn-success-o float-right" onclick="openModalMappen()">
                                                                            Vincular
                                                                        </button>
                                                                    <?php else: ?>
                                                                        <button type="button" class="btn btn-success float-right" onclick="openModalMappenDisabled()">
                                                                            Desvincular
                                                                        </button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col col-lg-4 col-md-6 col-sm-12 mb-2">
                                                        <div class="card border-dark rounded">
                                                            <div class="card-block p-1">
                                                                <div class="col-sm-3">
                                                                <?= $this->Html->image('fb_r.svg', array('class'=>'img-fluid mx-auto d-block','style'=> 'width:120%;')); ?>
                                                                </div>
                                                                <div class="col-sm-9">
                                                                    <div><h4 style="color:#000;">Adryo - </h4></div>
                                                                    <div><p class = "uppercase">Identificador: </p></div>
                                                                </div>
                                                            </div>
                                                            <div class="card-block p-1">
                                                                <div class="col-sm-12 col-lg-8">
                                                                    <span>
                                                                        <b>
                                                                            Estatus:
                                                                        </b>
                                                                    </span>
                                                                </div>
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                                                                    </fb:login-button>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(
        array(
            '/vendors/jquery-validation-engine/js/jquery.validationEngine',
            '/vendors/jquery-validation-engine/js/jquery.validationEngine-en',
            '/vendors/jquery-validation/js/jquery.validate',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/moment/js/moment.min',
            'js/form',
            
            '/vendors/sweetalert/js/sweetalert2.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            
            
        ),
        array('inline'=>false))
?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
    var accessToken0=[];
    var accessToken=[];
    function statusChangeCallback(response) {
        if (response.status === 'connected') {
            testAPI();  
        } else {
        document.getElementById('status').innerHTML = 'Please log ' + 'into this webpage.';
        }
    }

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
        statusChangeCallback(response);

        });
    }


    window.fbAsyncInit = function() {
        FB.init({
            appId      : '457352695300401',
            cookie     : true,
            xfbml      : true,
            version    : 'v12.0',
            app_secret : 'e858663a7608ee3601d56ab22f7f2933',
        });

        FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
        });
    };

  
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/es_LA/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    
    function testAPI() {
        // console.log('Bienvenido a facebook');
        FB.api(
        '/me/accounts',
        'GET',
        {"fields":"access_token,id,name"},
        function(response) {
            
            accessToken = response ;
            resp = accessToken.data;
            
            for (let i in resp){

                accessToken0[i]=resp[i].access_token
                accessToken[i]=resp[i].name

                // $.ajax({
                //     type: "POST",
                //     url:'<?php //echo Router::url(array("controller" => "ConexionesExterns", "action" => "facebook_tokens")); ?>',
                //     data: {'token' : accessToken0[i], 'cuenta_id':<?= $this->Session->read('CuentaUsuario.Cuenta.id') ?>, 'desarrollo_name' : accessToken[i], },                
                //     dataType: "Json",
                //     success: function (response) {
                //     console.log(response);
                //     }
                // });

                consulta(accessToken[i],accessToken0[i]);
                // console.log(accessToken[i] + ': ' + accessToken0[i]);
            
            }        
        }
        );
    }
    function consulta(accessToken0, accessToken){
        FB.api(
        '/me',
        'GET',
        {
            access_token: accessToken,
            "fields":"leadgen_forms{leads_count,leads}"
            // "fields":"leadgen_forms{id,name,leads_count,leads,questions}"
        },
        function(response) {
            let j=0,au=0,a=0;

            let leadsData = new Array();
            //console.log(response);

            let leadgen_forms=response.leadgen_forms;
            //console.log(leadgen_forms);

            let data=leadgen_forms.data;
            //console.log(data);

            for (let i in data){

            if (data[i].leads_count>0) {

                leadsData[j]=data[i].leads;

                j++;
            
            }
            
            }
            //console.log(leadsData);
            let arraydata  = new Array();

            for (let i in leadsData){
            arraydata[au]=leadsData[i].data;
            au++;
            }
            //console.log(arraydata);

            let arrayfiel  = new Array();
            
            for (let i in arraydata){

            for (let e in arraydata[i]){
                
                arrayfiel[a]=arraydata[i][e].field_data; 

                a++;
            
            }
            
            }
            var arreglo =  new Array();
            arreglo = {
        
            'clientes': arrayfiel
            }
            console.log(arreglo);
                $.ajax({
                    type: "POST",
                    url:'<?php echo Router::url(array("controller" => "ConexionesExterns", "action" => "limpiesa")); ?>',
                    data: {'clientes' : arreglo, 'cuenta_id':<?= $this->Session->read('CuentaUsuario.Cuenta.id') ?> },                
                    dataType: "Json",
                    success: function (response) {
                        // location.reload();
                        console.log(response);
                    },
                    error: function ( err ){
                        console.log( err.responseText );
                    }
                });
            
            // console.log(arreglo);
        }
        );
    }
</script>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
    'use strict';
            
        function link_dinamico( id ){

            switch( id ){
                case 1:
                    $('#edit_info_cuenta').attr('href', "<?= Router::url(array("controller" => "cuentas", "action" => "edit")); ?>");
                break;
                case 2:
                    $('#edit_info_cuenta').attr('href', "<?= Router::url(array("controller" => "users", "action" => "parametrizacion")); ?>");
                break;
                case 3:
                    $('#edit_info_cuenta').attr('href', "<?= Router::url(array("controller" => "users", "action" => "parametros_mail_config")); ?>");
                break;
            }
        }

    $(document).ready(function() {
        
        
        $('#CuentaInformacionEmpresaForm').bootstrapValidator({
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
        
        $("#CuentaLogo").fileinput({
            theme: "fa",
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: "Escoger Foto",
            removeClass: "btn btn-danger",
            removeLabel: "Eliminar"


        });
        
        
        
        
    });


<?php 
    $this->Html->scriptEnd();
?>