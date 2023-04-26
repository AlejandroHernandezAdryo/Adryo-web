<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/css/pages/form_validations',
            
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i>Nueva Cuenta</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="card">
                <div class="card-block">
                    <?php echo $this->Form->create('Cuenta',array('class'=>'form-horizontal login_validator'));?>
                        <div class="row">

                            <?php echo $this->Form->input('nombre_contacto', array('required'=>false,'div' => 'mt-1 col-md-12','class'=>'form-control','type'=>'text','placeholder'=>'Nombre Contacto*'))?>
                            <?php echo $this->Form->input('nombre_comercial', array('required'=>false,'div' => 'mt-1 col-md-12','class'=>'form-control','type'=>'text', 'placeholder'=>'Nombre Empresa*' ))?>
                            <?php echo $this->Form->input('correo_contacto', array('required'=>false,'div' => 'mt-1 col-md-12','class'=>'form-control','type'=>'text','placeholder'=>'Email*'))?>
                            <?php echo $this->Form->input('telefono_1', array('required'=>false,'div' => 'mt-1 col-md-12','class'=>'form-control','type'=>'text','placeholder'=>'Teléfono*' ))?>
                            <?php echo $this->Form->input('meses_gratis', array('empty'=>'Sin Meses Gratis','required'=>false,'div' => 'mt-1 col-md-12','class'=>'form-control','type'=>'select','options'=>array(1=>'1 Mes',2=>'2 Meses',3=>'3 Meses')))?>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mt-1">
                                <?= $this->Form->submit('Registrar Cuenta', array('class' => 'btn btn-success btn-block')); ?>
                            </div>
                        </div>
                    <?= $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(
        array(
            
            //'/vendors/chosen/js/chosen.jquery',
            
            'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            
            '/vendors/validval/js/jquery.validVal.min',
            
            
            '/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min',
            
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/jquery.uniform/js/jquery.uniform',
            '/vendors/inputlimiter/js/jquery.inputlimiter',
            '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/js/jquery.tagsinput',
            '/vendors/validval/js/jquery.validVal.min',
            '/vendors/moment/js/moment.min',
            '/vendors/daterangepicker/js/daterangepicker',
            '/vendors/datepicker/js/bootstrap-datepicker.min',
            '/vendors/datetimepicker/js/DateTimePicker.min',
            '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/autosize/js/jquery.autosize.min',
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/inputmask/js/inputmask.date.extensions',
            '/vendors/inputmask/js/inputmask.extensions',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            'form',
            'pages/form_elements',
            
            
            
        ),
        array('inline'=>false))
?>