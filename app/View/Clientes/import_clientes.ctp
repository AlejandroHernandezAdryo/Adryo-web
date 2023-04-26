<?= $this->Html->css(
        array(

            'pages/layouts',
            
            '/vendors/chosen/css/chosen',
            '/vendors/fileinput/css/fileinput.min',
            
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Agregar Cliente </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner">
            <div class="card">
                <div class="card-block">
                    <?= $this->Form->create('Clientes', array('type' => 'file')) ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <?= $this->Form->label('Archivo') ?>
                                <?= $this->Form->file('xml', array( 'class' => 'form-control' )) ?>
                            </div>
                        </div>

                        <div class="row">
                            <?= $this->Form->submit('Subir archivo', array('class' => 'btn btn-success btn-block', 'div' => 'col-sm-12 mt-1')) ?>
                        </div>
                    <?= $this->Form->end() ?>
                    <pre>
                        <?php
                            print_r( $this->request->data );
                            echo "<br>";
                            print_r( $data );
                        ?>
                    </pre>
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
    ),
    array('inline'=>false))
?>