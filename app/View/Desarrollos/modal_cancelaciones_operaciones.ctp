<!--modal-->
<div class="modal fade" id="modalCancelacionOperacion">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('OperacionCancelar'); ?>
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
          <h4 class="modal-title col-sm-10" id='titleModalCancelacionOperacion' ></h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <?= $this->Form->input('opciones_cancelacion',
              array(
                'div'   => 'col-sm-12',
                'class' => 'form-control',
                'label' => 'Cancelar movimiento',
                'type'  => 'select',
                'empty' => 'Seleccione una opción'
              )
            );?>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button onclick="cancelacion_save($('#OperacionCancelarInmuebleId').val(),$('#OperacionCancelarTipoOperacion').val(),$('#OperacionCancelarClienteId').val())" class="btn btn-success float-xs-right">Guardar</button>
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        </div>
        <?= $this->Form->hidden('tipo_operacion'); ?>
        <?= $this->Form->hidden('inmueble_id'); ?>
        <?= $this->Form->hidden('cliente_id'); ?>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>
<script>
  function cancelacion_save(tipo_operacion,inmueble_id,cliente_id) {
    console.log($('#OperacionCancelarInmuebleId').val(),$('#OperacionCancelarTipoOperacion').val(),$('#OperacionCancelarClienteId').val());
    console.log(tipo_operacion,inmueble_id,cliente_id);
    $.ajax({
      type    : "POST",
      url     : "<?php echo Router::url(array("controller" => "operacionesinmuebles", "action" => "cancelacion_save")); ?>",
      data    : {status:'#OperacionCancelarTipoOperacion',inmueble_id:'#OperacionCancelarInmuebleId',clinete_id:'#OperacionCancelarClienteId'},
      dataType: "json",
      cache   : false,
      beforeSend: function () {
        alert();
      },
      success : function (response) {
        console.log(response);
        console.log('hola');

      },
    });
  }
</script>