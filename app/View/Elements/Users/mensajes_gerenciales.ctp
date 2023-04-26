<?= $this->Html->css(
    array(
        'pages/layouts',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        'custom',
        'pages/form_elements',
        '/vendors/datepicker/css/bootstrap-datepicker3',
    ),
array('inline'=>false))
        
?>

<div class="modal fade" id="modal_add_message">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">
                Agregar mensaje gerencial
            </h4>
        </div>

        <div class="modal-body">
            <?= $this->Form->create('Mensaje', array('url'=>array('controller'=>'mensajes', 'action'=>'add'))); ?>
                <div class="row">
                    <?= $this->Form->input('mensaje', array(
                        'class' => 'form-control',
                        'div'   => 'col-sm-12'
                    )); ?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('ff', array(
                        'class'       => 'form-control fecha',
                        'div'         => 'col-sm-12',
                        'label'       => 'Fecha de expiración',
                        'placeholder' => 'dd-mm-yyyy'
                    )); ?>
                </div>

                <div class="modal-footer mt-3">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mt-1">
                            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"> Cancelar</button>
                        </div>
                        <div class="col-sm-12 col-lg-6 mt-1">
                            <button type="button" class="btn btn-success float-right btn-block" onclick="submit_modal_close()"> Guardar</button>
                        </div>
                    </div>
                </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>


<div class="card">
    <div class="card-header bg-blue-is">
        Mensajes de gerencia <span class="float-right"><i class="fa fa-plus" data-toggle="modal" data-target="#modal_add_message"></i></span>
    </div>

    <div class="card-block" style="overflow-y: scroll; height:300px !important; background-image: url('../img/fondo_trans.png'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
        <?php foreach ($mensajes_gerenciales as $mensaje):?>
            <li style="list-style: none;">
                <div class="row mt-1">
                <div class="col-xs-3 col-lg-2">
                    <?php echo $this->Html->image($mensaje['Created']['foto'], array('class'=>'img-circle img-bordered-sm img-fluid'))?>
                </div>
                <div class="col-sm-12 col-lg-10">
                    <div class="row">
                    <div class="col-sm-12">
                        <ins>
                        <?php echo $this->Html->link($mensaje['Created']['nombre_completo'],array('action'=>'view','controller'=>'users',$mensaje['Created']['id']))?>
                        </ins>
                    </div>
                    <div class="col-sm-12">
                        <?php echo $mensaje['Mensaje']['mensaje']?>
                    </div>
                    <div class="col-sm-12">
                        <small>
                            <i>Creado el <?= date("d-M-Y", strtotime($mensaje['Mensaje']['creation_date']))?> vigente al <?= date("d-M-Y", strtotime($mensaje['Mensaje']['expiration_date']))?></i>
                        </small>
                    </div>
                    </div>
                </div>
                </div>
            </li>
            <hr class="mt-1">
        <?php endforeach;?>
    </div>
</div>

<?= $this->Html->script(
    array(
        'components',
        'custom',
        'pages/layouts',
        '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/datetimepicker/js/DateTimePicker.min',
        '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
        'form',
    ),
    array('inline'=>false))
?>


<script>
    function submit_modal_close() {
        $('#modal_add_message').modal('hide');
        $('#MensajeAddForm').submit();
    }

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom",
        startDate: "<?= date('d-m-Y'); ?>",
    });

</script>