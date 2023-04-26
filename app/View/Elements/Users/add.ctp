<?= $this->Html->css(
        array(
            '/vendors/chosen/css/chosen',
            'pages/form_elements',
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
        ),
        array('inline'=>false))
?>

<style>
    .file-caption {
        height: 29px !important;
    }
    .label-danger{
        color: #E74C3C !important;
    }
</style>

<div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-user"></i>
                    Registrar Usuario a Sistema
                </h4>
            </div>
            <?= $this->Form->create('User', array('type'=>'file','class'=>'form-horizontal login_validator','url'=>array('controller'=>'users','action'=>'add'), 'id' => 'UserAddForm'))?>
                <div class="modal-body">
                    <div class="row mt-1">
                        <?= $this->Form->input('nombre_completo',array('label'=> array('id' => 'LabelUserNombreCompleto', 'text' => 'Nombre Completo*'),'class'=>'form-control','div'=>'col-sm-12','required'=>true))?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('correo_electronico',array('label'=>array('text' => 'Correo Electrónico*', 'id' =>'LabelUserCorreoElectronico' ),'class'=>'form-control','div'=>'col-sm-12 col-lg-6','required'=>true, 'type' => 'email'))?>
                        
                        <div class="col-sm-12 col-lg-6">
                            <label for="password" class="form-control-label" id="LabelUserPassword">Password*</label>
                            <div class="input-group">
                                <input id="input_password" class="form-control" type="password" name="data[User][password]" required="true" autocomplete="off">
                                <span class="input-group-addon addon_password"  style="background: transparent; border-left-style: none !important; cursor: pointer;" onclick="fun_pass()">
                                    <i class="fa fa-eye-slash fa-lg" id="show_pass"></i>
                                    <i class="fa fa-eye fa-lg text-primary" id="hidden_pass" style="display: none;"></i>
                                </span>
                            </div>
                            <span id="addonLabelUserPassword"></span>
                        </div>
                        <input type="checkbox" id="view_password" style="display: none;">
                    </div>

                    <div class="row mt-1">
                        <?= $this->Form->input('telefono1',array('label'=>'Teléfono 1','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false,'type' => 'tel', 'onkeypress'=>"return validateNumberKey(event);", 'maxlength' => '10'))?>
                        <?= $this->Form->input('opcionador',array('type'=>'select','label'=>'Opcionador','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false,'options'=>array(0=>'No',1=>'Si')))?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('group_id',array('label'=>array('text' => 'Tipo usuario*', 'id' => 'LabelUserGroupId'),'required'=>true, 'class' => 'form-control', 'div' => 'col-sm-12 col-lg-6', 'empty' => 'Seleccione una opción', 'required' => true))?>

                        <?= $this->Form->input('puesto',array('label'=>'Puesto','class'=>'form-control required','div'=>'col-sm-12 col-lg-6','required'=>false))?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('unidad_venta',array('empty'=>'Seleccionar Unidad de medición','label'=>'Unidad de Ventas','type'=>'select','options'=>array(1=>'Monto'), 'class'=>'form-control', 'div'=>'col-sm-12 col-lg-6'))?>

                        <?= $this->Form->input('ventas_mensuales',array('label'=>'Objetivo de Ventas','class'=>'form-control required','div'=>'col-sm-12 col-lg-6'))?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('finanzas',array('label'=>'Acceso a módulo de finanzas','class'=>'form-control required','div'=>'col-sm-12','required'=>false,'options'=>array(0=>'No',1=>'Si'),'type'=>'select', 'required' => false))?>
                    </div>
                    <div class="row mt-1">
                        <?= $this->Form->input('desarrollos', array('id'=>'desarrollos','multiple'=>'multiple','div'=>'col-sm-12','label'=>array('text'=>'Seleccionar que desarrollos puede ver (Si deja vacío podrá ver todos)'),'class'=>'form-control chzn-select','options'=>$desarrollos)); ?>
                    </div>
        
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->file('foto_perfil',array('accept'=>'image/*'))?>
                        </div>
                    </div>
                            
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right">
                        Registrar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
            <?= $this->Form->hidden('status', array('value'=>1)); ?>
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

    $("#UserFotoPerfil").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-primary",
        browseLabel: "Foto del usuario",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"
    });


    function fun_pass(){
        password1 = document.getElementById("input_password");
        if (document.getElementById("view_password").checked == true){
            document.getElementById("hidden_pass").style.display = "none";
            document.getElementById("show_pass").style.display = "block";
            document.getElementById("view_password").checked = false;
            password1.type = "password";
        }else{
            document.getElementById("view_password").checked = true;
            document.getElementById("show_pass").style.display = "none";
            document.getElementById("hidden_pass").style.display = "block";
            password1.type = "text";
        }
    };


    $(document).on("submit", "#UserAddForm", function (event) {
        event.preventDefault();
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "users", "action" => "add")); ?>',
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
                $("#overlay").fadeOut(); //pantalla carga

                var n = 1;
                window.setInterval(function(){
                    n--;
                    if (n == 0) {
                        $("#overlay").fadeOut();
                        location.reload();
                    }
                },1000);

            },
            error: function ( response ) {
                console.log( response.responseText );
                // console.log("Oops! Something went wrong!");
            },
        });
    });

    function validate_users_add(){
        let flag = true;
        
        if( $("#UserNombreCompleto").val() == '' ){
            flag = false;
            $("#LabelUserNombreCompleto").addClass('label-danger');
            $("#UserNombreCompleto").focus();
        }else {
            $("#LabelUserNombreCompleto").removeClass('label-danger');
        }

        if (validateEmail($("#UserCorreoElectronico").val())) {
            $("#LabelUserCorreoElectronico").removeClass('label-danger');
        } else {
            $("#LabelUserCorreoElectronico").addClass('label-danger');
            $("#UserCorreoElectronico").focus();
            flag = false;
        }

        if ($("#input_password").val() == '') {
            $("#LabelUserPassword").addClass('label-danger');
            $("#input_password").focus();
            flag = false;
            
        } else {
            $("#LabelUserPassword").removeClass('label-danger');
        }

        if ($("#UserGroupId").val() == '') {
            $("#LabelUserGroupId").addClass('label-danger');
            $("#UserGroupId").focus();
            flag = false;
        } else {
            $("#LabelUserGroupId").removeClass('label-danger');
        }

        return flag;
    }

    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        return re.test(email);
    }

    function validateNumberKey(evt){
			
        // code is the decimal ASCII representation of the pressed key.
        var code = (evt.which) ? evt.which : evt.keyCode;
        
        if(code==8) { // backspace.
            return true;
        } else if(code>=48 && code<=57) { // is a number.
            return true;
        } else{ // other keys.
            return false;
        }
    }


</script>