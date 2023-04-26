<?php
    // -----------------------------------------------------
    // Este modal es dinamico en la forma con la que trabaja
    // ya que varia segun la operacion que se elija, para el
    // inmueble.
    // -----------------------------------------------------
?>
<div class="modal fade" id="modal_operacion_inmueble" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">
                    <i class="fa fa-picture"></i>
                    <span id='title-operacion-inmueble'></span>
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Venta',array('url'=>array('action'=>'add','controller'=>'ventas')))?>
                <div class="row">
                    <div class="col-xl-4 text-xl-left">
                        <label for="lugar" class="form-control-label">Tipo de operación*</label>
                    </div>
                    
                    <?php echo $this->Form->input('operacion', array('label'=>false,'div' => 'col-md-8','class'=>'form-control'))?>

                </div>
                <div class="row">

                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Precio de cierre*</label>
                    </div>
                    
                    <?= $this->Form->input('precio_cerrado',array('class'=>'form-control','placeholder'=>'Precio Cierre','div'=>'col-md-8 m-t-15','label'=>false, 'required' => true))?>

                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left m-t-15">
                        <label for="estatus" class="form-control-label">Cambiar estado de propiedad*</label>
                    </div>
                    
                    <?= $this->Form->input('liberada', array('label'=>false,'div' => 'col-md-8 m-t-20','class'=>'form-control','empty'=>'Cambiar etapa de proceso', 'required' => true))?>

                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left mt-1">
                        <label for="lugar" class="form-control-label">Cliente*</label>
                    </div>
                    <?php echo $this->Form->input('cliente_id', array('label'=>false,'div' => 'col-md-8','class'=>'form-control chzn-select','type'=>'select', 'empty'=>'Seleccionar Cliente', 'required' => true))?>
                </div>
                <div class="row mt-1">
                    <div class="col-xl-4 text-xl-left">
                        <label for="lugar" class="form-control-label">Asesor que cierra la venta*</label>
                    </div>
                    <?php echo $this->Form->input('user_id', array('label'=>false,'div' => 'col-md-8','class'=>'form-control chzn-select','type'=>'select','empty'=>'Seleccionar Asesor', 'required' => true))?>
                </div>
                <div class="row">
                    <div class="col-xl-4 text-xl-left">
                        <label for="fecha_venta" class="form-control-label">Fecha de la venta*</label>
                    </div>
                    <?php echo $this->Form->input('fecha_venta', array('label'=>false,'div' => 'col-md-8','class'=>'form-control fecha_venta', 'placeholder'=>'dd-mm-yyyy', 'required' => true, 'autocomplete'=> 'off'))?>
                </div>
                <div class="row mt-1">
                    <?= $this->Form->input('retorno2', array('class'=>'form-control', 'div'=>'col-sm-12', 'type'=>'select', 'empty'=>'Seleccione una opción', 'options'=>array(1=>'Agregar factura inmediatamente', 2=>'Posponer la creación de la factura'), 'label'=>'Realización de factura'));?>
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="submit" class="btn btn-success float-xs-right" id="add-new-event">
                    Registrar Venta
                </button>

                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
                </button>
                

            </div>
            <?= $this->Form->hidden('retorno', array('value' => 1));?>
            <?= $this->Form->hidden('inmueble_id')?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<script>

    this.list_asesores();


    function agregar_operacion_propiedad( tipoOperacion, IDPropiedad ) {
        $('#VentaClienteId').empty().append('<option value="">Seleccione una opción</option>');

        const operacion = '';
        const precio    = '';

        // Paso 1 - Traer los datos de la propiedad.
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "inmuebles", "action" => "inmueble_operacion")); ?>',
            cache: false,
            data: { propiedad_id: IDPropiedad},
            dataType: 'json',
            success: function(response) {

                inmueble = response[0]['Inmueble'];
                clientes = response[0]['Lead'];

                $.each(clientes, function(key, value) {
                    
                    $('<option>').val(value['Cliente']['id']).text(value['Cliente']['nombre']).appendTo($("#VentaClienteId"));

                });
                
                $('.chzn-select').trigger('chosen:updated');


                switch( tipoOperacion ){
                    case 1:
                        $('#title-operacion-inmueble').html( 'Venta de la propiedad' );
                        this.operacion = 'Venta';
                        this.precio = inmueble['precio'];
                    break;
                    case 2:
                        $('#title-operacion-inmueble').html( 'Renta de la propiedad' );
                        this.operacion = 'Renta';
                        this.precio = inmueble['precio_2'];
                    break;
                    case 3:
                        $('#title-operacion-inmueble').html( 'Reserva / Apartado de la propiedad' );
                        this.operacion = 'Reserva / Apartado de la propiedad';
                        this.precio = inmueble['precio'];
                    break;
                }

                // Definicion de los campos para cada formulario.
                $("#VentaOperacion").val(this.operacion);
                $('#VentaOperacion').prop('disabled', true);
                $("#VentaPrecioCerrado").val(this.precio);

                
            },

            error: function ( response ) {
                console.log( response.responseText );
            }
        });

        $("#modal_operacion_inmueble").modal("show");
    }

    function list_asesores(){

        $('#VentaUserId').empty().append('<option value="">Seleccione una opción</option>');
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "users", "action" => "get_list_users")); ?>',
            cache: false,
            success: function ( response ) {
                $.each(response, function(key, value) {       
                    $('<option>').val(value).text(value).appendTo($("#VentaUserId"));
                });
                
                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

</script>