<!DOCTYPE html>
<html>
<head>
    
    
    <meta charset="UTF-8">
    <title>Iniciar Sesión | Adryo</title>
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/logo1.ico"/>

    <?= $this->Html->css(
        array(
            'components',
            'custom',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/vendors/wow/css/animate',
            '/vendors/sweetalert/css/sweetalert2.min.css',
            'pages/sweet_alert.css',
            
            // Radio, checkbox and switchs
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            'pages/login1',
            )
        ,array('inline'=>false)
        );
 ?>
    <!-- end of global styles-->
    <?php echo $this->fetch('css') ?>
    <?php echo $this->Html->css('skins/red_black_skin',array('id'=>'skin_change')); ?>


</head>

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

    <?php echo $this->fetch('content'); ?>

    <div class="modal fade" id="modal_success" role="dialog" aria-labelledby="modalLabeldanger">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <strong> <?= $this->Session->flash('m_success');?> </strong>
                </div>
                <div class="modal-footer">
                    <button class="btn  btn-success" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


        <?= $this->Html->script(
            array(
                'jquery.min',
                'bootstrap.min.js',
                'components',

                // Radio, checkbox and switchs
                '/vendors/bootstrap-switch/js/bootstrap-switch.min',
                '/vendors/switchery/js/switchery.min',
                'pages/radio_checkbox',

                
                'tether.min',
            ),
            array('inline'=>true));
        ?>

    <script>
        $(document).ready(function() {
            <?php if($this->Session->flash('error')){ ?>
                $("#modal_error").modal('show');
            <?php } ?>

            <?php if($this->Session->flash('success')){ ?>
            $("#modal_success").modal('show');
            <?php } ?>
        });
    </script>

</body>


</html>
