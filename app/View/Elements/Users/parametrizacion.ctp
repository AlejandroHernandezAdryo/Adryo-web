<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            'pages/general_components',
            
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
                                    <?= $this->Form->create('Paramconfig',array('url'=>array('controller'=>'Paramconfigs','action'=>'parametros'),'class'=>'form-horizontal login_validator'))?>
                                        <div id="rootwizard_no_val">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item user1 m-t-15">
                                                    <?= $this->Html->link('<span class="userprofile_tab">1</span>Información de la Empresa', array('action'=>'edit', 'controller'=>'cuentas'),array('escape'=>False, 'class'=>'nav-link')) ?>
                                                </li>
                                                <li class="nav-item user2 m-t-15">
                                                    <a class="nav-link active" href="#param_generales" data-toggle="tab"><span class="profile_tab">2</span>Párametros de seguimiento</a>
                                                </li>
                                                <li class="nav-item finish_tab m-t-15">
                                                    <a class="nav-link"><span>3</span>Configuración de correos</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content m-t-20">
                                                <div class="tab-pane active" id="param_generales">
        
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            
                                                        </div>
                                                    </div>
                                                    <!-- End seccion configuración de temperatura de clientes -->

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <table class="table table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="background: #646464; font-weight: 500; color: #fff; text-transform: uppercase;">CONFIGURACIÓN DE SEGUIMIENTO DE CLIENTES</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12 col-lg-6">
                                                            <?= $this->Form->label('DiasOportunos','Días límite para considerar a un cliente como Atención Oportuna*', array('style'=>'margin-left: 2%;')); ?>
                                                        </div>
                                                        <?= $this->Form->input('sla_oportuna',
                                                            array(
                                                                'label'    => False,
                                                                'div'      => 'col-sm-12 col-lg-6',
                                                                'class'    => 'form-control',
                                                                'value'    => $param['Paramconfig']['sla_oportuna'],
                                                                'required' => True
                                                            )
                                                        ) ?>
                                                    </div>
                                                    <div class="row mt-1">
                                                        <div class="col-sm-12 col-lg-6">
                                                            <?= $this->Form->label('DiasOportunosTardia','Días límite para considerar a un cliente como Atención Tardía*', array('style'=>'margin-left: 2%;')); ?>
                                                        </div>
                                                        <?= $this->Form->input('sla_atrasados',
                                                            array(
                                                                'label'    => False,
                                                                'div'      => 'col-sm-12 col-lg-6',
                                                                'class'    => 'form-control',
                                                                'value'    => $param['Paramconfig']['sla_atrasados'],
                                                                'required' => True
                                                            )
                                                        ) ?>
                                                    </div>

                                                    <div class="row mt-1">
                                                        <div class="col-sm-12 col-lg-6">
                                                            <?= $this->Form->label('DiasOportunosNoOportunos','Días límite para considerar a un cliente como No Atenido*', array('style'=>'margin-left: 2%;')); ?>
                                                        </div>
                                                        <?= $this->Form->input('sla_no_atendidos',
                                                            array(
                                                                'label'    => False,
                                                                'div'      => 'col-sm-12 col-lg-6',
                                                                'class'    => 'form-control',
                                                                'value'    => $param['Paramconfig']['sla_no_atendidos'],
                                                                'required' => True
                                                            )
                                                        ) ?>
                                                    </div>
                                                    
                                                    <!-- Encabezado de whatsapp -->
                                                    <div class="row">
                                                        <div class="col-sm-12 mt-1">
                                                            <table class="table table-sm">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="background: #646464; font-weight: 500; color: #fff; text-transform: uppercase;">CONFIGURACIÓN DE MENSAJE DE WHATSAPP AL CLIENTE</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-1">
                                                        <div class="col-sm-12 col-lg-6">
                                                            <?= $this->Form->label('DiasOportunosNoOportunos','Mensaje predeterminado para el envio de propiedades al cliente vía WhatsApp*', array('style'=>'margin-left: 2%;')); ?>
                                                        </div>
                                                        <?= $this->Form->input('message_default_whatsapp',
                                                            array(
                                                                'label'    => False,
                                                                'div'      => 'col-sm-12 col-lg-6',
                                                                'class'    => 'form-control',
                                                                'value'    => $param['Paramconfig']['message_default_whatsapp'],
                                                                'required' => True
                                                            )
                                                        ) ?>

                                                        <div class="col-sm-12 col-lg-6 offset-lg-6">
                                                            
                                                            <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-asesor' type='button'>
                                                                Agregar nombre del asesor
                                                            </button>
                                                            <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-propiedad' type='button'>
                                                                Agregar Tipo de propiedad
                                                            </button>
                                                            <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-cliente' type='button'>
                                                                Agregar nombre del cliente
                                                            </button>
                                                            <button class='btn btn-primary mt-1 btn-sm' id='btn-add-parametrizacion-prop' type='button'>
                                                                Agregar nombre de la Propiedad/Desarrollo
                                                            </button>
                                                        </div>

                                                    </div>


                                                    <!-- Boton de guardar -->
                                                    <div class="row mt-1">
                                                        <div class="col-sm-12">
                                                            <?= $this->Form->submit('Guardar los cambios e ir al siguiente paso', array('class'=>'btn btn-success btn-block')); ?>
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