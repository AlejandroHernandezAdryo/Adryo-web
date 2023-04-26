<?= $this->Html->css(
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

<script>
    function showPuntos(){
        if (document.getElementById('ParamconfigTemperatura').value==2){
            document.getElementById('puntos').style.display="none";
        }else{
            document.getElementById('puntos').style.display="";
        }
    }
    
</script>

<div id="content" class="bg-container">
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
                        <div class="card-header bg-blue-is" style="color:white">
                            Editar información
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $this->Form->create('Cuenta', array('type'=>'file'))?>
                                    <div class="col-sm-12 mb-2">
                                        <?= $this->Html->image($cuenta['Cuenta']['logo'], array('class'=>'img-fluid mx-auto d-block','style'=> 'width:20%;')); ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <?= $this->Form->create('Paramconfig',array('url'=>array('controller'=>'Paramconfigs','action'=>'parametros'),'class'=>'form-horizontal login_validator'))?>
                                        <div id="rootwizard_no_val">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <!-- <a class="nav-link active" href="#info_emp" data-toggle="tab" onclick="link_dinamico(1)">Información de la empresa</a> -->
                                                    <?= $this->HTML->link('Información de la empresa',array('action'=>'edit','controller'=>'cuentas'),array('class'=>'nav-link')) ?>
                                                </li>
                                                <li class="nav-item">
                                                    <!-- <a class="nav-link" href="#param_general" data-toggle="tab" onclick="link_dinamico(2)">Parámetro de seguimiento</a> -->
                                                    <?= $this->HTML->link('Parámetro de seguimiento',array('action'=>'parametrizacion','controller'=>'users'),array('class'=>'nav-link active')) ?>
                                                </li>
                                                <li class="nav-item">
                                                    <!-- <a class="nav-link" href="#config_av" data-toggle="tab" onclick="link_dinamico(3)">Configuración de correo</a> -->
                                                    <?= $this->HTML->link('Configuración de correo',array('action'=>'parametros_mail_config','controller'=>'users'),array('class'=>'nav-link')) ?>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#conexion" data-toggle="tab" onclick="link_dinamico(4)">Conexiones externas</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content m-t-20">
                                                <div class="tab-pane active" id="param_generales">
        
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- End seccion configuración de temperatura de clientes -->

                                                    <!-- Edición de parámetros de seguimiento **Korner 24-04-2023** -->
                                                    <div class="row">
                                                        <!-- Estatus de seguimiento **Korner 24-04-2023** -->
                                                        <div class="col-sm-12 col-lg-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    Estatus de seguimiento
                                                                    <br>
                                                                    <small>Esta información se verá reflejada en el listado de clientes en la columna E.A.</small>
                                                                </div>
                                                                <div class="card-block" style="padding-bottom: 4px;">
                                                                    <div class="row" style="border-bottom:1px solid #82A3A3;">
                                                                        <div class="col-sm-12 col-lg-10">
                                                                            <?= $this->Form->label('DiasOportunos','Días límite para considerar seguimiento oportuno', array('style'=>'margin-left: 0;')); ?>
                                                                        </div>
                                                                        <?= $this->Form->input('sla_oportuna',
                                                                            array(
                                                                                'label'    => False,
                                                                                'div'      => 'col-sm-12 col-lg-2',
                                                                                'class'    => 'form-control',
                                                                                'value'    => $param['Paramconfig']['sla_oportuna'],
                                                                                'required' => True,
                                                                                'style'    => 'height:24px!important;'
                                                                            )
                                                                        ) ?>
                                                                    </div>
                                                                    <div class="row" style="border-bottom:1px solid #82A3A3;">
                                                                        <div class="col-sm-12 col-lg-10">
                                                                            <?= $this->Form->label('DiasOportunosTardia','Días límite para considerar seguimiento tardío', array('style'=>'margin:8px 0;')); ?>
                                                                        </div>
                                                                        <?= $this->Form->input('sla_atrasados',
                                                                            array(
                                                                                'label'    => False,
                                                                                'div'      => 'col-sm-12 col-lg-2',
                                                                                'class'    => 'form-control',
                                                                                'value'    => $param['Paramconfig']['sla_atrasados'],
                                                                                'required' => True,
                                                                                'style'    => 'height:24px!important;margin:8px 0'
                                                                            )
                                                                        ) ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-12 col-lg-10">
                                                                            <?= $this->Form->label('DiasOportunosNoOportunos','Días límite para considerar seguimiento no atendido', array('style'=>'margin:8px 0;')); ?>
                                                                        </div>
                                                                        <?= $this->Form->input('sla_no_atendidos',
                                                                            array(
                                                                                'label'    => False,
                                                                                'div'      => 'col-sm-12 col-lg-2',
                                                                                'class'    => 'form-control',
                                                                                'value'    => $param['Paramconfig']['sla_no_atendidos'],
                                                                                'required' => True,
                                                                                'style'    => 'height:24px!important;margin:8px 0'
                                                                            )
                                                                        ) ?>
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
                                                                <div class="card-block">
                                                                    <?= $this->Form->input('message_default_whatsapp',
                                                                        array(
                                                                            'label'    => False,
                                                                            'div'      => 'col-sm-12',
                                                                            'class'    => 'form-control',
                                                                            'value'    => $param['Paramconfig']['message_default_whatsapp'],
                                                                            'required' => True,
                                                                            'style'    => 'height: 56px !important; overflow-y:scroll;'
                                                                        )
                                                                    ) ?>
                                                                    <div class="col-sm-12">
                                                                        <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-asesor' type='button'>
                                                                            Asesor
                                                                        </button>
                                                                        <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-propiedad' type='button'>
                                                                            Tipo de propiedad
                                                                        </button>
                                                                        <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-cliente' type='button'>
                                                                            Cliente
                                                                        </button>
                                                                        <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-prop' type='button'>
                                                                            Propiedad/Desarrollo
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                                                                <?= $this->Form->input('smessage_new_client',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control float-right',
                                                                                        'value'    => $param['Paramconfig']['smessage_new_client'],
                                                                                        'required' => True
                                                                                    )
                                                                                ) ?>
                                                                                <!-- <small><//?= (!empty($cuenta['Parametros']['smessage_new_client']) ? $cuenta['Parametros']['smessage_new_client'] : '') ?></small> -->
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= $this->Form->input('bmessage_new_client',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control',
                                                                                        'value'    => $param['Paramconfig']['bmessage_new_client'],
                                                                                        'required' => True,
                                                                                        'style'    => 'height:56px !important;'
                                                                                    )
                                                                                ) ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Correo de reenvío / otro desarrollo **Korner 24-04-2023** -->
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            Correo de reenvío / otro desarrollo
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div>
                                                                                <span>Asunto:</span>
                                                                                <?= $this->Form->input('smessage_new_desarrollo',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control float-right',
                                                                                        'value'    => $param['Paramconfig']['smessage_new_desarrollo'],
                                                                                        'required' => True
                                                                                    )
                                                                                ) ?>
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= $this->Form->input('bmessage_seg_cliente_desarrollo',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control',
                                                                                        'value'    => $param['Paramconfig']['bmessage_seg_cliente_desarrollo'],
                                                                                        'required' => True,
                                                                                        'style'    => 'height:56px !important;'
                                                                                    )
                                                                                ) ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Correo de unidades **Korner 24-04-2023** -->
                                                                <div class="col-sm-12 col-lg-4">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            Correo de unidades
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div>
                                                                                <span>Asunto:</span>
                                                                                <?= $this->Form->input('smessage_new_propiedad',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control float-right',
                                                                                        'value'    => $param['Paramconfig']['smessage_new_propiedad'],
                                                                                        'required' => True
                                                                                    )
                                                                                ) ?>
                                                                                <!-- <small><//?= (!empty($cuenta['Parametros']['smessage_new_desarrollo']) ? $cuenta['Parametros']['smessage_new_desarrollo'] : '') ?></small> -->
                                                                            </div>
                                                                            <div>
                                                                                <span>Mensaje:</span>
                                                                                <br>
                                                                                <?= $this->Form->input('bmessage_seg_cliente_inmuebles',
                                                                                    array(
                                                                                        'label'    => False,
                                                                                        'div'      => False,
                                                                                        'class'    => 'form-control',
                                                                                        'value'    => $param['Paramconfig']['bmessage_seg_cliente_inmuebles'],
                                                                                        'required' => True,
                                                                                        'style'    => 'height:56px !important;'
                                                                                    )
                                                                                ) ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                    <!-- Boton de guardar -->
                                                    <div class="row mt-1">
                                                        <div class="col-sm-2 float-right">
                                                            <?= $this->Form->submit('Guardar', array('class'=>'btn btn-success btn-block')); ?>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
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

<script>

    function insertAtCursor(myField, myValue) {
        //IE support
        if (document.selection) {
            myField.focus();
            sel = document.selection.createRange();
            sel.text = myValue;
        }
        // Microsoft Edge
        else if(window.navigator.userAgent.indexOf("Edge") > -1) {
          var startPos = myField.selectionStart; 
          var endPos = myField.selectionEnd; 
              
          myField.value = myField.value.substring(0, startPos)+ myValue 
                 + myField.value.substring(endPos, myField.value.length); 
          
          var pos = startPos + myValue.length;
          myField.focus();
          myField.setSelectionRange(pos, pos);
        }
        //MOZILLA and others
        else if (myField.selectionStart || myField.selectionStart == '0') {
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
            myField.value = myField.value.substring(0, startPos)
                + myValue
                + myField.value.substring(endPos, myField.value.length);
        } else {
            myField.value += myValue;
        }
    }
    
    document.getElementById('btn-add-parametrizacion-asesor').onclick = function() {
        insertAtCursor(document.getElementById('ParamconfigMessageDefaultWhatsapp'), '${ nombre_asesor }');
    };

    document.getElementById('btn-add-parametrizacion-propiedad').onclick = function() {
        insertAtCursor(document.getElementById('ParamconfigMessageDefaultWhatsapp'), '${ propiedad }');
    };
    
    document.getElementById('btn-add-parametrizacion-cliente').onclick = function() {
        insertAtCursor(document.getElementById('ParamconfigMessageDefaultWhatsapp'), '${ cliente }');
    };
    
    document.getElementById('btn-add-parametrizacion-prop').onclick = function() {
        insertAtCursor(document.getElementById('ParamconfigMessageDefaultWhatsapp'), '${ URL }');
    };
    

</script>