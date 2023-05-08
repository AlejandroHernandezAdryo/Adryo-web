<?= $this->Html->css(
    array(
        '/vendors/chosen/css/chosen',
        'pages/form_elements',
        '/vendors/swiper/css/swiper.min',
        'pages/widgets',
        '/vendors/fileinput/css/fileinput.min',
    ),
    array('inline'=>false))
?>

<style>
    div .label-danger{
        color: #E74C3C !important;
        background: none !important;
    }
    #showInputPassword{
        display: none;
        transition-duration: 4s;
        transition-delay: 2s;
    }
</style>

<div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-user"></i>
                    Edición de Usuario
                </h4>
            </div>
            
            <?= $this->Form->create('UserEdit',array('type'=>'file','class'=>'form-horizontal login_validator','url'=>array('controller'=>'users','action'=>'edit'), 'id' => 'UserEditForm'))?>
                <div class="modal-body">

                    <div class="row">
                        <?= $this->Form->input('nombre_completo',
                            array(
                                'class' => 'form-control',
                                'div'   => 'col-sm-12',
                                'label' => 'Nombre completo*'
                            )
                        ); ?>
                    </div>

                    <div class="row mt-2">
                        	
                        <?= $this->Form->input('correo_electronico',
                            array(
                                'class'    => 'form-control',
                                'div'      => 'col-sm-12 col-lg-6',
                                'label'    => 'Correo Electrónico*',
                                'disabled' => ( ($this->Session->read('Permisos.Group.ur') == true ) ? 'false' : 'true' )
                            )
                        ); ?>
                        
                        <?php if( $this->Session->read('Permisos.Group.ur') ): ?>
                            <div class="col-sm-12 col-lg-6 mt-3">

                                <div class="radio_basic_swithes_padbott" onclick="viewPassword();">
                                    <input type="checkbox" class="js-switch sm_toggle" id="checkboxChangePassword" />
                                    <span class="radio_switchery_padding">¿Deseas cambiar la contraseña?</span>
                                    <br />
                                </div>

                            </div>
                        <?php endif; ?>

                    </div>
                    
                    <?php if( $this->Session->read('Permisos.Group.ur') ): ?>
                        <div class="row mt-1" id="showInputPassword">
                            
                            <div class="col-sm-12 col-lg-6">
                                <label for="password" class="form-control-label" id="LabelUserPassword">Password*</label>
                                <div class="input-group">
                                    <input id="input_password_1" class="form-control" type="password" name="data[UserEdit][password]" onkeyup="validatePassword();" autocomplete="off">
                                    <span class="input-group-addon addon_password"  style="background: transparent; border-left-style: none !important; cursor: pointer;" onclick="fun_pass_1()">
                                        <i class="fa fa-eye-slash fa-lg" id="show_pass_1"></i>
                                        <i class="fa fa-eye fa-lg text-primary" id="hidden_pass_1" style="display: none;"></i>
                                    </span>
                                </div>
                                <span id="addonLabelUserPassword"></span>
                            </div>
                            <input type="checkbox" id="view_password_1" style="display: none;">
    
                            <div class="col-sm-12 col-lg-6">
                                <label for="password" class="form-control-label" id="LabelUserPassword">Confirmar Password*</label>
                                <div class="input-group">
                                    <input id="input_password_2" class="form-control" type="password" name="data[UserEdit][password_2]" onkeyup="validatePassword();" autocomplete="off">
                                    <span class="input-group-addon addon_password"  style="background: transparent; border-left-style: none !important; cursor: pointer;" onclick="fun_pass_2()">
                                        <i class="fa fa-eye-slash fa-lg" id="show_pass_2"></i>
                                        <i class="fa fa-eye fa-lg text-primary" id="hidden_pass_2" style="display: none;"></i>
                                    </span>
                                </div>
                                <span id="addonLabelUserPassword"></span>
                            </div>
                            <input type="checkbox" id="view_password_2" style="display: none;">
    
                            <div class="col-sm-12" id="infoPassword"></div>
                        </div>
                    <?php endif; ?>



                    <div class="row mt-1">
                        <?= $this->Form->input('telefono1',array('label'=>'Teléfono 1','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false,'type' => 'tel', 'onkeypress'=>"return validateNumberKey(event);", 'maxlength' => '10'))?>
                        <?= $this->Form->input('opcionador',array('type'=>'select','label'=>'Opcionador','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false,'options'=>array(0=>'No',1=>'Si')))?>
                    </div>

                    <div class="row mt-1">

                        <?php
                            if ($this->Session->read('Permisos.Group.ur') == 1){
                            echo $this->Form->input('group_id',array('label'=>array('text' => 'Tipo usuario*', 'id' => 'LabelUserGroupId'),'required'=>true, 'class' => 'form-control', 'div' => 'col-sm-12 col-lg-6', 'empty' => 'Seleccione una opción', 'required' => true, 'value' => empty($user['Grupo']['id']) ? '' :  $user['Grupo']['id']));
                            }else{
                            echo $this->Form->hidden('group_id',array('value' => empty($user['Grupo']['id']) ? '' :  $user['Grupo']['id']));
                            }
                        ?>
                        
                        <?php if( $this->Session->read('Permisos.Group.ur') ): ?>
                            <?= $this->Form->input('puesto',array('label'=>'Puesto','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false,'value' => empty($user['CuentasUser']['puesto']) ? '' :  $user['CuentasUser']['puesto']))?>
                        <?php endif; ?>
                    </div>

                    <!-- Objetivos de ventas mensuales en monto y unidad -->
                    <?php if( $this->Session->read('Permisos.Group.ur') ): ?>
                        <div class="row mt-1">
                            <?= $this->Form->hidden('unidad_venta',array('value'=>1))?>
                            <?= $this->Form->input('ventas_mensuales_q',array('label'=>'Objetivo de Ventas (Unidades)','class'=>'form-control required','div'=>'col-sm-12 col-lg-6', 'value' => empty($user['CuentasUser']['ventas_mensuales_q']) ? '' :  $user['CuentasUser']['ventas_mensuales_q']))?>
                            <?= $this->Form->input('ventas_mensuales',array('label'=>'Objetivo de Ventas (Monto)','class'=>'form-control required','div'=>'col-sm-12 col-lg-6', 'value' => empty($user['CuentasUser']['ventas_mensuales']) ? '' :  $user['CuentasUser']['ventas_mensuales']))?>
                        </div>
                        
                        <!-- Acceso al modulo de finanzas -->
                        <div class="row mt-1">
                            <?= $this->Form->input('finanzas',array('label'=>'Acceso a módulo de finanzas','class'=>'form-control required','div'=>'col-sm-12','required'=>false,'options'=>array(0=>'No',1=>'Si'),'type'=>'select', 'required' => false,  'value' => empty($user['CuentasUser']['finanzas']) ? '' :  $user['CuentasUser']['finanzas']))?>
                        </div>
                        
                        <!-- Seleccionador de desarrollos que puede comercializar -->
                        <div class="row mt-1">
                            <?= $this->Form->input('desarrollos', array('id'=>'desarrollos','multiple'=>'multiple','div'=>'col-sm-12','label'=>array('text'=>'Seleccionar que desarrollos puede ver (Si deja vacío podrá ver todos)'),'class'=>'form-control chzn-select','options'=>$desarrollos)); ?>
                        </div>
                    <?php endif; ?>

                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->file('foto',array('accept'=>'image/*'))?>
                        </div>
                    </div>
                            
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right">
                        Actualizar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
            <?= $this->Form->hidden('id'); ?>
            <?= $this->Form->hidden('cuenta_user_id'); ?>
            <?= $this->Form->hidden('status'); ?>
        <?= $this->Form->end()?>
    </div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',

        '/vendors/chosen/js/chosen.jquery',
        'form',

        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        'pages/advanced_tables',

        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',

    ], array('inline'=>false));
?>

<script>

// Chosen
$(".hide_search").chosen({disable_search_threshold: 10});
$(".chzn-select").chosen({allow_single_deselect: true});
$(".chzn-select-deselect,#select2_sample").chosen();
// End of chosen

$("#UserEditFoto").fileinput({
    theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-primary",
        browseLabel: "Foto del usuario",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"
});

function fun_pass_1(){
    password1 = document.getElementById("input_password_1");
    if (document.getElementById("view_password_1").checked == true){
        document.getElementById("hidden_pass_1").style.display = "none";
        document.getElementById("show_pass_1").style.display = "block";
        document.getElementById("view_password_1").checked = false;
        password1.type = "password";
    }else{
        document.getElementById("view_password_1").checked = true;
        document.getElementById("show_pass_1").style.display = "none";
        document.getElementById("hidden_pass_1").style.display = "block";
        password1.type = "text";
    }
};

function fun_pass_2(){
    password1 = document.getElementById("input_password_2");
    if (document.getElementById("view_password_2").checked == true){
        document.getElementById("hidden_pass_2").style.display = "none";
        document.getElementById("show_pass_2").style.display = "block";
        document.getElementById("view_password_2").checked = false;
        password1.type = "password";
    }else{
        document.getElementById("view_password_2").checked = true;
        document.getElementById("show_pass_2").style.display = "none";
        document.getElementById("hidden_pass_2").style.display = "block";
        password1.type = "text";
    }
};

function viewPassword() {
    if (document.getElementById("checkboxChangePassword").checked == true){
        document.getElementById("showInputPassword").style.display = "block";
    }else{
        document.getElementById("showInputPassword").style.display = "none";
    }
}

function validatePassword(){
    if( $("#input_password_1").val() == $("#input_password_2").val() ){
        document.getElementById("infoPassword").innerHTML = '';
        $("#infoPassword").removeClass('label-danger');
    }else{
        document.getElementById("infoPassword").innerHTML = 'Las contraseñas no coinciden.';
        $("#infoPassword").addClass('label-danger');
    }
}


$(document).on("submit", "#UserEditForm", function (event) {
    event.preventDefault();
    // let form = new FormData(this);
    $.ajax({
        url        : '<?php echo Router::url(array("controller" => "users", "action" => "edit")); ?>',
        type       : "POST",
        dataType   : "json",
        data       : new FormData(this),
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function (response) {
            console.log( response );

            var n = 1;
            window.setInterval(function(){
                n--;
                if (n == 0) {
                    $("#overlay").fadeOut();
                    location.reload();
                }
            },1000);

        },
        // error: function ( response ) {
        //     console.log( response.responseText );
        //     // console.log("Oops! Something went wrong!");
        // },
    });
});
 

// Modal edit function.
function edit_user_modal( id ){
    
    $.ajax({
        url: '<?php echo Router::url(array("controller" => "users", "action" => "user_view")); ?>/' + id ,
        cache: false,
        success: function ( response ) {
            
            $("#modal_edit_user").modal('show');
            $('#UserEditNombreCompleto').val( response.User['nombre_completo'] );
            $('#UserEditCorreoElectronico').val( response.User['correo_electronico'] );
            $('#UserEditTelefono1').val( response.User['telefono1'] );
            $('#UserEditGroupId').val( response.Grupo['id'] ); 
            $('#UserEditUnidadVenta').val( response.CuentasUser['unidad_venta'] ); 
            $('#UserEditFinanzas').val( response.CuentasUser['finanzas'] ); 
            $('#UserEditVentasMensuales').val( response.CuentasUser['ventas_mensuales'] ); 
            $('#UserEditPuesto').val( response.CuentasUser['puesto'] );
            $("#photo-profile").attr("src", "<?= Router::url('/', true) ?>" + response.User['foto']);
            $("#UserEditId").val(response.User['id']);
            $("#UserEditCuentaUserId").val(response.CuentasUser['id']);
            if( response.CuentasUser['opcionador'] == true ){
                $("#UserEditOpcionador").val(1);
            }else{
                $("#UserEditOpcionador").val(0);
            }
            
            
            // console.log( response );
        },
        error: function ( response ){
            // console.log( response.responseText );
        }
    });
}

</script>