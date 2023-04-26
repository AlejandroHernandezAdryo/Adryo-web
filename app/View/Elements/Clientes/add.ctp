<?= $this->Html->css(
    array(
        'pages/layouts',
        '/vendors/chosen/css/chosen',
        '/vendors/fileinput/css/fileinput.min',
    ),
    array('inline'=>false))
?>

<style>
    .fw-700{
        font-weight: 700;
    }
    .chosen-results, .chosen-single{
        text-transform: uppercase;
    }
    .label-danger {color: #EF6F6C;}

    #info-cliente{
        display: none;
    }
</style>

<div class="modal fade" id="modal_add_client" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-user-plus"></i>
                    Agregar cliente
                </h4>
            </div>
            <?= $this->Form->create('ClienteAdd',array('class'=>'form-horizontal login_validator', 'id'=>'form_add_cliente')); ?>
                <div class="modal-body">
                    
                    <div class="row" id="info-cliente">
                        <div class="col-sm-12">
                            <p class="label-danger" style="background-color: transparent !important;"> <i class="fa fa-exclamation-triangle"></i> El cliente ya existe en la base de datos. </p>
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
                        <hr style ="border-top: 2.5px solid #2e3c54; display: block; width: 100%; border-radius: 5px">
                    </div>

                    <div class="row" id="form-cliente">

                        <div class="col-sm-12">
                            
                            <div class="row">
                                <?=
                                    $this->Form->input('nombre',
                                    array(
                                        'class' => 'form-control',
                                        'div' => 'col-sm-12 col-lg-4 form-group',
                                        'label' => 'Nombre'
                                    )
                                    );
                                ?>
                                <?= $this->Form->input('correo_electronico',
                                    array(
                                        'label'  => 'Correo eléctronico',
                                        'div'    => 'col-sm-12 col-lg-4 form-group',
                                        'class'  => 'form-control',
                                    )
                                ) ?>

                                <?= $this->Form->input('telefono1',
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
                                    <select class="form-control chzn-select required" required="required" name="data[Cliente][Propiedades]" id="ClientePropiedades">
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
                                
                                <?= $this->Form->input(
                                    'dic_linea_contacto_id',
                                        array(
                                            'label'   => array('text'=>'Forma de contacto*', 'id'=>'ClienteDicLineaContactoIdLabel', 'class'=>'fw-700'),
                                            'div'     => 'col-sm-12 col-md-6',
                                            'class'   => 'form-control chzn-select',
                                            'type'    => 'select',
                                            'empty'   => 'Seleccionar la forma de contacto' ,
                                            'options' => $list_linea_contactos,
                                            'style'   => 'text-transform: uppercase;'
                                        )
                                    )
                                ?>
                            </div>

                            <div class="row mt-1">
                                
                                <?php 
                                    if ( $this->Session->read('Permisos.Group.id') != 3 ){
                                        echo $this->Form->input('user_id', array('label'=>array('text' => 'Agente Comercial*', 'class' => 'fw-700'),'div' => 'col-sm-12 col-md-6','class'=>'form-control chzn-select','empty'=>'SIN AGENTE ASIGNADO', 'required' => true, 'options' => $list_users));
                                    }else{
                                        echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                                    }
                                ?>

                                <?= $this->Form->input(
                                    'dic_tipo_cliente_id',
                                        array(
                                            'label'    => array('text'=>'Tipo de cliente*', 'id'=>'ClienteDicLineaTipoClienteIdLabel', 'class'=>'fw-700'),
                                            'div'      => 'col-sm-12 col-md-6',
                                            'class'    => 'form-control chzn-select',
                                            'type'     => 'select',
                                            'empty'    => 'Seleccionar el tipo de cliente',
                                            'options'  => $tipos_cliente,
                                            'style'    => 'text-transform: uppercase;',
                                            'required' => true
                                        )
                                    )
                                ?>
                            
                            </div>

                        </div>

                    </div>
                            
                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12 col-lg-6">
                            <?= $this->Form->button('Limpiar campos', array('class' => 'btn btn-link float-xs-left', 'onclick' => 'clear_input();', 'type' => 'button')) ?>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success float-xs-right', 'id' => 'ClienteBntValidate', 'onclick' => "validate_user();", 'type' => 'button')); ?>
                            <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success float-xs-right', 'id' => 'ClienteBntSubmit', 'type' => 'submit', 'style' => 'display: none;')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
            <?= $this->Form->hidden('dic_linea_contacto_id_hidden'); ?>
            <?= $this->Form->hidden('nombre_hidden'); ?>
            <?= $this->Form->hidden('user_id_hidden'); ?>
            <?= $this->Form->hidden('id'); ?>
        <?= $this->Form->end()?>
    </div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
        '/vendors/chosen/js/chosen.jquery',

    ], array('inline'=>false));
?>

<script>
        
function validar_email( email ) {
    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}



function validate_user(){
    // console.log( $('#ClienteAddCorreoElectronico').val() + ' '+ $('#ClienteAddTelefono1').val() + ' ' +  $('#ClienteAddCuentaId').val());
    // alert("Validar user");
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "validate_user")); ?>',
        cache: false,
        data: { email_search: $('#ClienteAddCorreoElectronico').val(), telefono_search: $('#ClienteAddTelefono1').val(), cuenta_id: $('#ClienteAddCuentaId').val()},
        dataType: 'json',
        success: function(response) {

            console.log( response );

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
                document.getElementById("info-status-clietne").innerHTML        = response[0].Cliente.status;
                $("#info-cliente").slideDown(250);

                if( response[0].Cliente.status != 'Inactivo') {
                    $('#ClienteAddUserId').prop('disabled', true);    
                }

                $('#ClienteAddNombre').val(response[0].Cliente.nombre);
                $('#ClienteAddNombreHidden').val(response[0].Cliente.nombre);
                $('#ClienteAddTelefono1').val(response[0].Cliente.telefono1);
                $('#ClienteAddCorreoElectronico').val(response[0].Cliente.correo_electronico);
                $('#ClienteAddId').val(response[0].Cliente.id);
                $('#ClienteAddUserId').val(response[0].Cliente.user_id);
                $('#ClienteAddUserIdHidden').val(response[0].Cliente.user_id);
                $('#ClienteAddDicLineaContactoIdHidden').val(response[0].Cliente.dic_linea_contacto_id);

                $('#ClienteAddNombre').prop('disabled', true);
                $('#ClienteAddTelefono1').prop('disabled', true);
                $('#ClienteAddCorreoElectronico').prop('disabled', true);
                $("#ClienteAddDicTipoClienteId").prop('disabled', true);
                
                $('.chzn-select').trigger('chosen:updated');

                document.getElementById("ClienteBntValidate").style.display = "none";
                document.getElementById("ClienteBntSubmit").style.display = "block";
                
            }else{
                $('#form_add_cliente').submit();
            }

        },

        error: function ( response ) {
            console.log( response.responseText );
            $("#modal_success").modal('show');
            document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar validar cliente en base de datos <br>Código: ';
        }
    });
}

function clear_input(){
    $('#ClienteAddNombre').val('');
    $('#ClienteAddNombreHidden').val('');
    $('#ClienteAddTelefono1').val('');
    $('#ClienteAddCorreoElectronico').val('');
    $('#ClienteAddId').val('');
    $('#ClienteAddUserId').val('');
    $('#ClienteAddUserIdHidden').val('');
    $('#ClienteAddDicLineaContactoIdHidden').val('');
    $('#ClienteAddDicLineaContactoId').val('');
    $('#ClienteAddDicTipoClienteId').val('');
    

    $('#ClienteAddNombre').prop('disabled', false);
    $('#ClienteAddTelefono1').prop('disabled', false);
    $('#ClienteAddCorreoElectronico').prop('disabled', false);
    $("#ClienteAddDicTipoClienteId").prop('disabled', false);

    document.getElementById("info-nombre-cliente").innerHTML        = '';
    document.getElementById("info-nombre-asesor").innerHTML         = '';
    document.getElementById("info-prop-interes").innerHTML          = '';
    document.getElementById("info-dic-linea-contacto-id").innerHTML = '';
    document.getElementById("info-status-clietne").innerHTML        = '';
    $("#info-cliente").slideUp(250);

    $('.chzn-select').trigger('chosen:updated');
}

$(".hide_search").chosen({disable_search_threshold: 10});
$(".chzn-select").chosen({allow_single_deselect: true});
$(".chzn-select-deselect,#select2_sample").chosen();
</script>