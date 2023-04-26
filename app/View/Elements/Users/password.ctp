<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min'
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Cambiar Password</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <?php echo $this->Form->create('User');?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block m-t-20">
                            <div class="row">
                                <p class="col-sm-12" style="font-size: 1.2rem;">Usuario: <?= $nombre ?></p>
                                <?php
                                    echo $this->Form->input('id');
                                    echo $this->Form->input('password', array('div' => 'col-sm-12 col-lg-4','class'=>'form-control','type'=>'password','value'=>''));
                                    echo $this->Form->input('password2', array('div' => 'col-sm-12 col-lg-4','class'=>'form-control','type'=>'password','label'=>'Confirmar Contraseña'));
                                ?>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <?php echo $this->Form->button('Cambiar contraseña',array('type'=>'submit','class'=>'btn btn-primary'))?>
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
            'pages/layouts',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
            'pages/wizard',
            
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            'form',
            'pages/form_elements'
        ),
        array('inline'=>false))
?>