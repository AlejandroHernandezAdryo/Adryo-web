    <div class="container">
        <div class="row flex-center" id="div-row-login">
            <div class="col-lg-4 col-sm-12">
                <div class="card" id ="card-login">
                    <?= $this->Form->create('Cuenta');?>
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
                                        <input name="data[Cuenta][correo_electronico]" id='correo_recpass' class="form-control" type="email" required="true" placeholder="Correo electrónico" value="<?php if(!empty($_COOKIE["name"])){echo htmlspecialchars($_COOKIE["name"]); }?>" style="border-left-style: none !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 mt-2">
                                    <?php echo $this->Form->button('Recuperar Contraseña',array('type'=>'submit','class'=>'btn btn-primary btn-block btn-flat'))?>
                                </div>
                            </div>

                        </div>
                    <?= $this->Form->end(); ?>
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

            $("#correo_recpass").on('keyup', function(){

                $.ajax({
                    url     : '<?php echo Router::url(array("controller" => "cuentas", "action" => "find_login")); ?>',
                    cache   : false,
                    dataType: 'json',
                    type    : "POST",
                    data    : { email: $('#correo_recpass').val() },
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