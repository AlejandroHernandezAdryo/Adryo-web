<div class="modal fade" id="modalNewConfigMappen">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <?= $this->Form->create('AddConexionesExtern', array('actions' => 'add', 'controller' => 'ConexionesExterns' ), array('class' => 'form')); ?>
                <div class="modal-header bg-blue-is">
                    <h4 class="modal-title col-sm-10">Vinculación con su cuenta de Mappen </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                    <div class="row">
                        <?= $this->Form->input('end_point', array(
                            'class' => 'form-control',
                            'div'   => 'col-sm-12',
                            'label' => 'End point (URL de conexión)',
                            'value' => (!empty($mappen['ConexionesExtern']['end_point']) ? $mappen['ConexionesExtern']['end_point'] : '' ),
                            'required',
                        )); ?>
                    </div>
                    
                    <div class="row">
                        <?= $this->Form->input('key_exterior', array(
                            'class' => 'form-control',
                            'div'   => 'col-sm-12',
                            'label' => 'Id Corporativo',
                            'value' => (!empty($mappen['ConexionesExtern']['key_exterior']) ? $mappen['ConexionesExtern']['key_exterior'] : '' ),
                            'required'
                        )); ?>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Vincular</button>
                </div>
                <?= $this->Form->hidden('id', array( 'value' => (!empty($mappen['ConexionesExtern']['id']) ? $mappen['ConexionesExtern']['id'] : null ))); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDisabledConfigMappen">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <?= $this->Form->create('DisabledConexionesExtern', array('actions' => 'disabled', 'controller' => 'ConexionesExterns' ), array('class' => 'form')); ?>
                <div class="modal-body">
                    <p class="text-sm-center">
                        ¿ DESEAS DESVINCULAR MAPPEN ?
                    </p>
                    <p>
                        Esto podría <b>afectar</b> los desarrollos que se tienen vinculados con Mappen.
                    </p>
                    <?= $this->Form->hidden('id', array(
                        'value' => (!empty($mappen['ConexionesExtern']['id']) ? $mappen['ConexionesExtern']['id'] : null ),
                    )); ?>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Desvincular</button>
                    <button type="button" class="btn btn-success-o float-sm-left" data-dismiss="modal">Cancelar</button>
                </div>
            <?= $this->Form->end(); ?>
        </div>
    </div>
</div>

<script>
    function openModalMappen(){
        $("#modalNewConfigMappen").modal("show");
    }

    function openModalMappenDisabled(){
        $("#modalDisabledConfigMappen").modal("show");
    }

    $(document).on("submit", "#AddConexionesExternViewForm", function (event) {
        event.preventDefault();

        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "ConexionesExterns", "action" => "addMappen")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                $("#overlay").fadeOut();
                location.reload();
            },
            error: function ( response ) {
                // $("#overlay").fadeOut();
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
            },
        });


    });

    $(document).on("submit", "#DisabledConexionesExternViewForm", function (event) {
        event.preventDefault();

        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "ConexionesExterns", "action" => "disabled")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                $("#overlay").fadeOut();
                location.reload();
            },
            error: function ( response ) {
                // $("#overlay").fadeOut();
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
            },
        });


    });

</script>