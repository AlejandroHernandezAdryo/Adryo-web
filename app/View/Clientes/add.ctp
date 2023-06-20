<?= $this->Html->css(
        array(

            'pages/layouts',
            
            '/vendors/chosen/css/chosen',
            '/vendors/fileinput/css/fileinput.min',
            '/vendors/datepicker/css/bootstrap-datepicker3',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            
        ),
        array('inline'=>false))
?>

<style>
    .modal-dialog-centered{margin-top: 15%;}
    .fw-700{
        font-weight: 700;
    }
    .label-error{
        color: #E74C3C;
    }
    .flex-center{
        display: flex ;
        flex-direction: row ;
        flex-wrap: wrap ;
        justify-content: center ;
        align-items: center ;
        align-content: center ;
    }
    .chosen-results, .chosen-single{
        text-transform: uppercase;
    }
    .label-danger {color: #EF6F6C;}

    #info-cliente{
        display: none;
    }
    .inner {
        min-height: 93vh;
    }

</style>

<div id="content" class="bg-container">
    <header class="head">
    </header>
    <div class="outer">
        <div class="inner">
            <div class="row">
                <div class="col-sm-12 col-lg-8 offset-lg-2">
                    <div class="card">
                            <div class="card-header bg-blue-is">
                                <i class="fa fa-user-plus"></i> Agregar cliente
                            </div>
                        <div class="card-block">
                            <div class="row" id="info-cliente">
                                <div class="col-sm-12">
                                    <p class="label-danger"> <i class="fa fa-exclamation-triangle"></i> El cliente ya existe en la base de datos con la siguiente información: </p>
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Nombre Cliente:</td>
                                                <td id="info-nombre-cliente"></td>
                                            </tr>
                                            <tr>
                                                <td>Asesor:</td>
                                                <td id="info-nombre-asesor"></td>
                                            </tr>
                                            <tr>
                                                <td>Desarrollo/Propiedad:</td>
                                                <td id="info-prop-interes"></td>
                                            </tr>
                                            <tr>
                                                <td>Forma de contacto:</td>
                                                <td id="info-dic-linea-contacto-id"></td>
                                            </tr>
                                            <tr>
                                                <td>Estatus:</td>
                                                <td id="info-status-clietne"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="div">
                                    <div class="col-sm-12">
                                        <hr style ="border-top: 10px solid #2e3c54; display: block; width: 100%; border-radius: 5px">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <p class="label-danger"> <i class="fa fa-exclamation-triangle"></i> Información de registro del cliente duplicado: </p>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <?= $this->Form->create('Cliente',array('class'=>'form-horizontal login_validator', 'id'=>'form_add_cliente')); ?>
                                        
                                        <div class="row" id="row1">
                                            <?= $this->Form->input('nombre_fake',
                                                array(
                                                    'class'      => 'form-control',
                                                    'div'        => 'col-sm-12 col-lg-4 form-group',
                                                    'label'      => 'Nombre',
                                                    'onkeypress' => "return checkNatural(event)"
                                                )
                                            )?>
                                            <?= $this->Form->input('correo_electronico_fake',
                                                array(
                                                    'label'   => array('text' => 'Correo electrónico', 'id' => 'LabelClienteCorreoElectronico'),
                                                    'div'     => 'col-sm-12 col-lg-4 form-group',
                                                    'class'   => 'form-control',
                                                    'onkeyup' => 'validarEmail(this)',
                                                    'type'    => 'email',
                                                )
                                            ) ?>

                                            <?= $this->Form->input('telefono1_fake',
                                                array(
                                                    'label'      => 'Teléfono',
                                                    'div'        => 'col-sm-12 col-lg-4 form-group',
                                                    'class'      => 'form-control',
                                                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57',
                                                    'maxlength' => 10
                                                )
                                            ) ?>
                                        </div>

                                        <div class="row mt-1">
                                            <div class="col-sm-12 col-md-6">
                                                <label for="ClientePropiedades" id="ClientePropiedadesInteresLabel" class="fw-700">Desarrollo/Propiedad*</label>
                                                <select class="form-control chzn-select required" required="required" name="data[Cliente][PropiedadesFake]" id="ClientePropiedadesFake">
                                                    <option value="0">Seleccionar una opción</option>
                                                    <optgroup label="DESARROLLOS">
                                                        <?php foreach ($list_desarrollos as $desarrollo):?>
                                                        <option value="D<?= $desarrollo['Desarrollo']['id'] ?>" style="font-style: oblique"><?= $desarrollo['Desarrollo']['nombre']?></option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                    <optgroup label="PROPIEDADES">
                                                        <?php foreach ($list_inmuebles as $inmueble):?>
                                                        <option value="P<?= $inmueble['Inmueble']['id'] ?>"><?= $inmueble['Inmueble']['titulo']?></option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            
                                            <?= $this->Form->input('dic_linea_contacto_id_fake',
                                                array(
                                                    'label'   => array('text'=>'Forma de contacto*', 'id'=>'ClienteDicLineaContactoIdLabel', 'class'=>'fw-700'),
                                                    'div'     => 'col-sm-12 col-md-6',
                                                    'class'   => 'form-control chzn-select',
                                                    'type'    => 'select',
                                                    'empty'   => 'Seleccionar la forma de contacto' ,
                                                    'options' => $list_linea_contactos,
                                                    'style'   => 'text-transform: uppercase;',
                                                    'required'
                                                )
                                            )?>
                                        </div>

                                        <div class="row mt-1">
                                            
                                            <?php 
                                                if ( $this->Session->read('Permisos.Group.id') != 3 ){
                                                    echo $this->Form->input('user_id_fake',
                                                        array(
                                                            'label'=>array('text' => 'Agente Comercial*', 'class' => 'fw-700', 'id' => 'ClienteUserIdLabel'),
                                                            'div' => 'col-sm-12 col-md-6',
                                                            'class'=>'form-control chzn-select',
                                                            'empty'=>'SIN AGENTE ASIGNADO',
                                                            'required' => true,
                                                            'options' => $list_users
                                                        )
                                                    );
                                                }else{
                                                    echo $this->Form->hidden('user_id_fake',array('value'=>$this->Session->read('Auth.User.id')));
                                                }
                                            ?>

                                            <?= $this->Form->input('dic_tipo_cliente_id_fake',
                                                array(
                                                    'label'    => array('text'=>'Tipo de cliente*', 'id'=>'ClienteDicTipoClienteIdLabel', 'class'=>'fw-700'),
                                                    'div'      => 'col-sm-12 col-md-6',
                                                    'class'    => 'form-control chzn-select',
                                                    'type'     => 'select',
                                                    'empty'    => 'Seleccionar el tipo de cliente',
                                                    'options'  => $list_tipos_cliente,
                                                    'style'    => 'text-transform: uppercase;',
                                                    'required' => true
                                                )
                                            )?>
                                        
                                        </div>
                                        
                                        <!-- Fecha de creacion -->
                                        <?php if( $this->Session->read('Auth.User.id') == 146 OR $this->Session->read('Auth.User.id') == 82 OR $this->Session->read('Auth.User.id') == 625 OR $this->Session->read('Auth.User.id') == 598 OR $this->Session->read('Auth.User.id') == 385 OR $this->Session->read('Auth.User.id') == 683 ): ?>
                                            <div class="row">
                                                <?= $this->Form->input('created',
                                                    array(
                                                        'label'    => array('text'=>'Fecha de creación*', 'id'=>'ClienteCreatedLabel', 'class'=>'fw-700'),
                                                        'div'      => 'col-sm-12 col-md-6',
                                                        'class'    => 'form-control date_created',
                                                        'required' => true,
                                                        'type' => 'text'
                                                    )
                                                )?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="row mt-1">
                                            <div class="col-sm-12">
                                                <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success btn-block', 'id' => 'ClienteBntValidate', 'onclick' => "validate_user();", 'type' => 'button')); ?>
                                                <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success btn-block', 'id' => 'ClienteBntSubmit', 'type' => 'button', 'style' => 'display: none;', 'onclick' => "submitForm();")); ?>
                                            </div>
                                        </div>

                                    <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                    <?= $this->Form->hidden('user_id_hidden'); ?>
                                    <?= $this->Form->hidden('status'); ?>
                                    <?= $this->Form->hidden('id'); ?>

                                    <!-- Inputs original -->
                                    <?= $this->Form->hidden('nombre') ?>
                                    <?= $this->Form->hidden('correo_electronico') ?>
                                    <?= $this->Form->hidden('telefono1') ?>
                                    <?= $this->Form->hidden('dic_linea_contacto_id') ?>
                                    <?= $this->Form->hidden('user_id') ?>
                                    <?= $this->Form->hidden('dic_tipo_cliente_id') ?>
                                    <?= $this->Form->hidden('Propiedades') ?>
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
        'components',
        'custom',
        '/vendors/chosen/js/chosen.jquery',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
    ),
    array('inline'=>false))
?>
<script>

$('.date_created').datepicker({
    format        : 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose     : true,
    orientation   : "bottom"
});

function validarEmail(elemento){

    var texto = document.getElementById('ClienteCorreoElectronicoFake').value;
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if( texto != '' ){
        if (!regex.test(texto)) {
            $("#LabelClienteCorreoElectronico").addClass('label-danger');
            if( !document.body.contains(document.getElementById("errorCorreoElectronico")) ) {
                $( "#ClienteCorreoElectronicoFake" ).after( $("<span id='errorCorreoElectronico' class='label-danger'>Correo electrónico inválido</span>"));
            }
        } else {
            $("#LabelClienteCorreoElectronico").removeClass('label-danger');
            if( document.body.contains(document.getElementById("errorCorreoElectronico")) ) {
                document.getElementById("errorCorreoElectronico").remove();
            }
            return true;
        }
        document.getElementById("LabelClienteCorreoElectronico").innerHTML        = 'Correo electrónico*';
        $("#ClienteCorreoElectronicoFake").prop('required', true);
        $("#LabelClienteCorreoElectronico").addClass("fw-700");
    }else {
        $("#LabelClienteCorreoElectronico").removeClass('label-danger');
        document.getElementById("LabelClienteCorreoElectronico").innerHTML        = 'Correo electrónico';
        $("#ClienteCorreoElectronicoFake").prop('required', false);

        if( document.body.contains(document.getElementById("errorCorreoElectronico")) ) {
            document.getElementById("errorCorreoElectronico").remove();
        }
        return false;
    }

}

function validateForm(){
    let flag = true;

    // Validacion de correo y telefono, uno de los debe estar lleno.
    if( $("#ClienteCorreoElectronicoFake").val() == '' && $("#ClienteTelefono1Fake").val() == '' ){
        if( !document.body.contains(document.getElementById("errorClienteCorreoTelefono")) ) {
            $( "#row1" ).after( $("<span id='errorClienteCorreoTelefono' class='label-danger'>Es necesario agregar correo y/o teléfono</span>"));
        }
        flag = false;
    }else{
        if( document.body.contains(document.getElementById("errorClienteCorreoTelefono")) ) {
            document.getElementById("errorClienteCorreoTelefono").remove();
        }
    }

    if( $('#ClientePropiedadesFake').val() == 0 ){
        $('#ClientePropiedadesInteresLabel').addClass('label-danger');
        if( !document.body.contains(document.getElementById("errorClientePropiedades")) ) {
            $( "#ClientePropiedades_chosen" ).after( $("<span id='errorClientePropiedades' class='label-danger'>Es necesesario seleccionar una opción.</span>"));
            flag = false;
        }
    }else {
        $('#ClientePropiedadesInteresLabel').removeClass('label-danger');
        if( document.body.contains(document.getElementById("errorClientePropiedades")) ) {
            document.getElementById("errorClientePropiedades").remove();
        }
    }


    if( $('#ClienteDicLineaContactoIdFake').val() == 0 ){
        $('#ClienteDicLineaContactoIdLabel').addClass('label-danger');
        if( !document.body.contains(document.getElementById("errorClienteDicLineaContactoId")) ) {
            $( "#ClienteDicLineaContactoId_chosen" ).after( $("<span id='errorClienteDicLineaContactoId' class='label-danger'>Es necesesario seleccionar una opción.</span>"));
            flag = false;
        }
    }else {
        $('#ClienteDicLineaContactoIdLabel').removeClass('label-danger');
        if( document.body.contains(document.getElementById("errorClienteDicLineaContactoId")) ) {
            document.getElementById("errorClienteDicLineaContactoId").remove();
        }
    }

    if( $('#ClienteUserIdFake').val() == 0 ){
        $('#ClienteUserIdLabel').addClass('label-danger');
        if( !document.body.contains(document.getElementById("errorClienteUserId")) ) {
            $( "#ClienteUserId_chosen" ).after( $("<span id='errorClienteUserId' class='label-danger'>Es necesesario seleccionar una opción.</span>"));
            flag = false;
        }
    }else {
        $('#ClienteUserIdLabelFake').removeClass('label-danger');
        if( document.body.contains(document.getElementById("errorClienteUserId")) ) {
            document.getElementById("errorClienteUserId").remove();
        }
    }

    if( $('#ClienteDicTipoClienteIdFake').val() == 0 ){
        $('#ClienteDicTipoClienteIdLabel').addClass('label-danger');
        if( !document.body.contains(document.getElementById("errorClienteDicTipoClienteId")) ) {
            $( "#ClienteDicTipoClienteId_chosen" ).after( $("<span id='errorClienteDicTipoClienteId' class='label-danger'>Es necesesario seleccionar una opción.</span>"));
            flag = false;
        }
    }else {
        $('#ClienteDicTipoClienteIdLabel').removeClass('label-danger');
        if( document.body.contains(document.getElementById("errorClienteDicTipoClienteId")) ) {
            document.getElementById("errorClienteDicTipoClienteId").remove();
        }
    }

    return flag;

}

function validate_user(){
    
    let flag = this.validateForm();

    if( flag == true ){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "validate_user")); ?>',
            cache: false,
            data: { email_search: $('#ClienteCorreoElectronicoFake').val(), telefono_search: $('#ClienteTelefono1Fake').val(), cuenta_id: $('#ClienteCuentaId').val()},
            dataType: 'json',
            success: function(response) {
                let propInteres = '';

                if( response.flag == true ){

                    if( response[0].Desarrollo.nombre != null ){
                        propInteres = response[0].Desarrollo.nombre;
                    }else {
                        propInteres = response[0].Inmueble.titulo;
                    }
                    
                    document.getElementById("info-nombre-cliente").innerHTML        = response[0].Cliente.nombre;
                    document.getElementById("info-nombre-asesor").innerHTML         = response[0].User.nombre_completo;
                    document.getElementById("info-prop-interes").innerHTML          = propInteres;
                    document.getElementById("info-dic-linea-contacto-id").innerHTML = response[0].DicLineaContacto.linea_contacto;
                    
                    // Información de origen del cliente.
                    $('#ClienteNombre').val(response[0].Cliente.nombre);
                    $('#ClienteTelefono1').val(response[0].Cliente.telefono1);
                    $('#ClienteCorreoElectronico').val(response[0].Cliente.correo_electronico);
                    $('#ClienteId').val(response[0].Cliente.id);
                    $('#ClienteStatus').val(response[0].Cliente.status);

                    $('#ClienteNombreFake').val(response[0].Cliente.nombre);
                    $('#ClienteTelefono1Fake').val(response[0].Cliente.telefono1);
                    $('#ClienteCorreoElectronicoFake').val(response[0].Cliente.correo_electronico);
                    $('#ClienteIdFake').val(response[0].Cliente.id);
                    $('#ClienteStatusFake').val(response[0].Cliente.status);

                    // Asignacion de propieades Fake a propiedades.
                    $('#ClientePropiedades').val( $('#ClientePropiedadesFake').val());
                    $('#ClienteDicLineaContactoId').val( $('#ClienteDicLineaContactoIdFake').val());
                    $('#ClienteDicTipoClienteId').val( $('#ClienteDicTipoClienteIdFake').val());

                    if( response[0].Cliente.status == 'Activo' || response[0].Cliente.status == 'Inactivo temporal' ){
                        
                        // Si el cliente esta activo se actualiza el id del cliente, 
                        $('#ClienteUserIdFake').val(response[0].Cliente.user_id);
                        $('#ClienteUserId').val(response[0].Cliente.user_id);
                        $('.chzn-select').trigger('chosen:updated');
                        document.getElementById("info-status-clietne").innerHTML        = response[0].Cliente.status;
                    }

                    // Si el cliente esta inactivo se guarda el asesor que tiene para la reasignación.
                    if(response[0].Cliente.status == 'Inactivo'){
                        $('#ClienteUserIdHidden').val(response[0].Cliente.status);
                        document.getElementById("info-status-clietne").innerHTML        = response[0].Cliente.status + ' definitivo';
                    }

                    $("#info-cliente").slideDown(250);

                    $('#ClienteNombreFake').attr("disabled", true);
                    $('#ClienteTelefono1Fake').attr("disabled", true);
                    $('#ClienteCorreoElectronicoFake').attr("disabled", true);
                    
                    $("#ClienteDicTipoClienteIdFake").attr("disabled", true);
                    $("#ClienteDicLineaContactoIdFake").attr("disabled", true);
                    $("#ClientePropiedadesFake").attr("disabled", true);
                    $("#ClienteUserIdFake").attr("disabled", true);
                    
                    $('.chzn-select').trigger('chosen:updated');

                    document.getElementById("ClienteBntValidate").style.display = "none";
                    document.getElementById("ClienteBntSubmit").style.display = "block";
                    
                }else{
                    $("#overlay").fadeIn();
                    
                    $('#ClienteNombre').val($('#ClienteNombreFake').val());
                    $('#ClienteCorreoElectronico').val($('#ClienteCorreoElectronicoFake').val());
                    $('#ClienteTelefono1').val($('#ClienteTelefono1Fake').val());

                    $('#ClienteDicLineaContactoId').val( $('#ClienteDicLineaContactoIdFake').val());
                    $('#ClienteDicTipoClienteId').val( $('#ClienteDicTipoClienteIdFake').val());
                    $('#ClientePropiedades').val( $('#ClientePropiedadesFake').val());
                    $('#ClienteUserId').val( $('#ClienteUserIdFake').val());

                    $('#ClienteBntSubmit').attr("disabled", true);
                    $('#ClienteBntSubmit').addClass('disabled');;
                    $('#form_add_cliente').submit();
                }

            },
            error: function ( response ) {
                console.log( response );
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar validar cliente en base de datos <br>Código: EVU-001';
            }
        });
    }
}

function submitForm(){

    $("#overlay").fadeIn();

    $('#ClienteNombre').val($('#ClienteNombreFake').val());
    $('#ClienteCorreoElectronico').val($('#ClienteCorreoElectronicoFake').val());
    $('#ClienteTelefono1').val($('#ClienteTelefono1Fake').val());
    $('#ClientePropiedades').val( $('#ClientePropiedadesFake').val());

    $('#ClienteDicLineaContactoId').val( $('#ClienteDicLineaContactoIdFake').val());
    $('#ClienteDicTipoClienteId').val( $('#ClienteDicTipoClienteIdFake').val());
    $('#ClienteUserId').val( $('#ClienteUserIdFake').val());

    $('#ClienteBntSubmit').attr("disabled", true);
    $('#ClienteBntSubmit').addClass('disabled');;
    $('#form_add_cliente').submit();

}

function checkNatural(e) {
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla == 8) {
        return true;
    }

    // Patron de entrada, en este caso solo acepta numeros y letras
    patron = /^[A-Za-zÁÉÍÓÚáéíóúñÑ ]+$/g;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}

$(".hide_search").chosen({disable_search_threshold: 10});
$(".chzn-select").chosen({allow_single_deselect: true});
$(".chzn-select-deselect,#select2_sample").chosen();

</script>