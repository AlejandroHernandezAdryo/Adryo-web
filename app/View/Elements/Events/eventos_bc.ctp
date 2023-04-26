<div class="modal fade" id="eventStatusUpdate" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <?= $this->Form->create('Event', array('url'=>array('action'=>'status', 'controller'=>'events'), 'id' => 'FormStatusUpdate')) ?>
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" id="block-view-info">
                    <div class="col-sm-12 text-center">
                        <span id="labelStatusUpdate"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <?= $this->Form->hidden('status') ?>
                    <?= $this->Form->hidden('return', array('value' => $return)) ?>
                    <?= $this->Form->hidden('param_return', array('value' => $param_return)) ?>
                    <?= $this->Form->hidden('evento_id') ?>
                    <?= $this->Form->button('Cancelar', array('class'=>'btn btn-error btn-sm float-xs-right', 'data-dismiss' => 'modal', 'type' => 'button')); ?>
                    <?= $this->Form->button('Confirmar', array('class'=>'btn btn-success btn-sm pull-left', 'onclick' => 'buttonEventStatusUpdate()', 'type' => 'button')); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
<!-- Modal de cambio de estatus del evento -->


<script>

function cancelarEvent(eventId) {
    
    $("#eventInfo").modal('hide');
    $("#eventStatusUpdate").modal('show');
    document.getElementById("labelStatusUpdate").innerHTML = '¿Dese cancelar el evento?';
    $("#EventEventoId").val(eventId);
    $("#EventStatus").val(2);

}

function confirmarEvent(eventId) {
    
    $("#eventInfo").modal('hide');
    $("#eventStatusUpdate").modal('show');
    document.getElementById("labelStatusUpdate").innerHTML = '¿Dese confirmar el evento?';
    $("#EventEventoId").val(eventId);
    $("#EventStatus").val(1);
    
}

// Agregar funcion de actualizacion de estatus
function buttonEventStatusUpdate() {
    $("#eventStatusUpdate").modal('hide');
    $("#FormStatusUpdate").submit();
}




</script>