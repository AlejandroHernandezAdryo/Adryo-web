<?= $this->Html->css(
        array(
            '/vendors/sweetalert/css/sweetalert2.min.css',
            'pages/sweet_alert.css',
            
            // Radio, checkbox and switchs
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',

            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/vendors/wow/css/animate',
            'components',
            'custom',

            'pages/login1',
            )
        ,array('inline'=>false)
        );
 ?>

<body>
    <style>
        
        .flex-center{
            display: flex ;
            flex-direction: row ;
            flex-wrap: wrap ;
            justify-content: center ;
            align-items: center ;
            align-content: center ;
        }

        #div-row-login{

            height: 100vh;
            width : 100%;
        }

        #card-login{
            border-radius: 15px;
            opacity: .97;
        }
        #card-login:hover{
            box-shadow: none;
        }
        .custom-checkbox{
            color: #BBBBBB;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 2px;

        }

        #img-cuenta{
            width: 100px;
            height: auto;
        }

    </style>

    <div class="container">
        <div class="row flex-center" id="div-row-login">
            <div class="col-lg-4 col-sm-12">
                <div class="card" id ="card-login">
                    <?= $this->Form->create('User')?>
                        <div class="card-block">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="img-login-cuenta" class='flex-center'>
                                        <img id="img-cuenta" src='<?= Router::url('../img/favicon.png') ?>'>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <div class="input-group">
                                    <span class="input-group-addon input_email" style="background: transparent; border-right-style: none !important;">
                                        <i class="fa fa-envelope text-primary"></i>
                                    </span>
                                    <input id='input_correo_electronico' class="form-control" type="email" name="data[User][correo_electronico]" required="true" placeholder="Correo electrónico" value="<?php if(!empty($_COOKIE["name"])){echo htmlspecialchars($_COOKIE["name"]); }?>" style="border-left-style: none !important;">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <div class="input-group">
                                        
                                        <span class="input-group-addon addon_password"  style="background: transparent; border-right-style: none !important;"><i class="fa fa-lock text-primary"></i></span>
                                        <input id="input_password" class="form-control" type="password" name="data[User][password]" required="true" placeholder="Contraseña" value="<?php if(!empty($_COOKIE["pass"])){echo htmlspecialchars($_COOKIE["pass"]); }?>"  style="border-left-style: none !important; border-right-style: none !important;">
                                        <span class="input-group-addon addon_password"  style="background: transparent; border-left-style: none !important; cursor: pointer;" onclick="fun_pass()">
                                        <input type="checkbox" id="view_password" style="display: none;">

                                            <i class="fa fa-eye-slash fa-lg" id="show_pass"></i>
                                            <i class="fa fa-eye fa-lg text-primary" id="hidden_pass" style="display: none;"></i>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mt-2 text-sm-right">
                                    <label class="custom-control custom-checkbox">
                                        <?php
                                            if(!empty($_COOKIE["remm"])){ echo $this->Form->checkbox('recordar',array('div'=>false, 'label'=>false, 'checked'=> htmlspecialchars($_COOKIE["remm"]) )); }
                                            else { echo $this->Form->checkbox('recordar',array('label'=>false, 'checked'=> '' )); }
                                        ?>
                                        <a>Recordar contraseña</a>
                                    </label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <?php echo $this->Form->button('Acceder',array('type'=>'submit','class'=>'btn btn-primary btn-block btn-flat'))?>
                                </div>
                            </div>

                        </div>
                    <?= $this->form->end(); ?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Html->script(
        array(
            'components',

            // Radio, checkbox and switchs
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/switchery/js/switchery.min',
            'pages/radio_checkbox',

            'jquery.min',
            'tether.min',
        ),
        array('inline'=>true));
    ?>

    <script>
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

        $("#input_correo_electronico").on('keyup', function(){
            
            $.ajax({
                url     : '<?php echo Router::url(array("controller" => "cuentas", "action" => "find_login")); ?>',
                cache   : false,
                dataType: 'json',
                type    : "POST",
                data    : { email: $('#input_correo_electronico').val() },
                success: function ( response ) {

                    if( response.data.User['foto'] == 'user_no_photo.png'){
                        $("#img-cuenta").attr("src", "<?= Router::url('../img/favicon.png') ?>");
                    }else{
                        $("#img-cuenta").attr("src", "<?= Router::url('/', true) ?>" + response.data.User['foto']);
                    }

                },
            });
            
        });

    </script>

    </body>

</html>

