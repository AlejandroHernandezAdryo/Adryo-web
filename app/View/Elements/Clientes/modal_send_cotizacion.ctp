<?= $this->Html->css(
    array(
 
        '/vendors/select2/css/select2.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',

        // Chozen select
        '/vendors/chosen/css/chosen',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/fileinput/css/fileinput.min',

        // Radio and checkbox
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/switchery/css/switchery.min',
        '/vendors/radio_css/css/radiobox.min',
        '/vendors/checkbox_css/css/checkbox.min',
        'pages/radio_checkbox',
    ),
    array('inline'=>false))
?>

<div class="modal fade" id="modalSendCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" id="modal-send-cotizacion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id='modalSendCotizacionClose'>&times;</button>
                <h4 class="modal-title"> Envio de cotización por WhatsApp </h4>
            </div>

            <div class="modal-body">

                <div class="row" id='row_preview_send_cotizacion'>
                    <div class="col-sm-12">
                        Previsualización del mensaje:
                    </div>
                    <div class="col-sm-12 mt-1">
                        <p class="text-justify" id='p-mensaje-cotizacion'> </p>
                        <?= $this->Form->hidden('wa_mensaje_cotizacion') ?>
                        <?= $this->Form->hidden('modalSendCotizacionTelefono') ?>
                        <?= $this->Form->hidden('modalSendCotizacionClienteId') ?>
                        <?= $this->Form->hidden('modalSendCotizacionInmuebleReferencia') ?>
                        <?= $this->Form->hidden('modalSendCotizacionCotizacionId') ?>
                    </div>
                </div>

                <div class="row hidden" id ="input-error-modal-send-cotizacion">
                    <?= $this->Form->input('error_modal_send_cotizacion',
                        array(
                            'class' => 'form-control',
                            'label' => 'Motivo de error',
                            'div'   => 'col-sm-12',
                            'type'  => 'select',
                            'empty' => 'Seleccione una opción'
                        )
                    );
                    ?>
                    <div class="col-sm-12 mt-2">
                        <span class="btn btn-success btn-block" id = "btn-opccion-error-send-cotizacion"> Guardar observación</span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-1">
                        <span class="btn btn-success float-sm-right" id = "bnt-send-cotizacions"> Enviar Mensaje por Whastapp </span>
                    </div>
                </div>

                <div class="row hidden" id="btns-modal-send-cotizacion">
                    <div class="col-sm-12" id='col-btn-error-message'>
                        <span class="btn btn-danger btn-block" id = "btn-error-send-cotizacion"> Ocurrio algun error al enviar </span>
                    </div>
                    <div class="col-sm-12" id='col-btn-success-send-cotizacion'>
                        <span class="btn btn-success btn-block float-sm-right" id = "btn-success-send-cotizacion"> El mensaje se pudo enviar </span>
                    </div>
                </div>


            </div>

        </div>
    </div>
</div>

<script>
    
    function open_send_cotizacion( cliente, cliente_id, idCotizacion, nombreInmueble, telefono ){
        
        // $("#modalSendCotizacion").modal("show");
        $('#modalSendCotizacion').modal({backdrop: 'static', keyboard: false});

        var nombre_cliente   = cliente;
        var nombre_propiedad = nombreInmueble;
        var nombre_asesor    = '<?= $this->Session->read('Auth.User.nombre_completo') ?>';
        var url_cotizacion = '<?= Router::url('/cotizacions/cotizacion_view/', true); ?>'+idCotizacion+'';
        
        // Extraemos el mensaje de whastapp del cliente.
        $("#p-mensaje-cotizacion").html(`<?= $this->Session->read('Parametros.Paramconfig.wa_send_cotizacion') ?>`);
        $("#wa_mensaje_cotizacion").val(`<?= $this->Session->read('Parametros.Paramconfig.wa_send_cotizacion') ?>`);
        $("#modalSendCotizacionTelefono").val(telefono);
        $("#modalSendCotizacionClienteId").val(cliente_id);
        $("#modalSendCotizacionInmuebleReferencia").val(nombreInmueble);
        $("#modalSendCotizacionCotizacionId").val(idCotizacion);
        
    }

    $("#bnt-send-cotizacions").on('click', function (){
        $("#row_preview_send_cotizacion").addClass("hidden");
        $("#bnt-send-cotizacions").addClass("hidden");
        $("#btns-modal-send-cotizacion").removeClass("hidden");

        // Cambiamos las propiedades del modal para que se haga mas pequeño y se centre.
        $("#modal-send-cotizacion").addClass('modal-dialog-centered');
        $("#modal-send-cotizacion").addClass('modal-sm');

        // Presentamos los botones para guardar el seguimiento rápido.
        $("#btn-success-send-cotizacion").removeClass('float-sm-right');
        $("#btn-success-send-cotizacion").addClass('mt-1');
        // Evitar cierre de modal al mandar wa
        $("#modalSendCotizacionClose").addClass('hidden'); 

        // Abrimso en una página nueva wa
        window.open('https://wa.me/521'+$("#modalSendCotizacionTelefono").val()+'?text='+$("#wa_mensaje_cotizacion").val());
    });

    // Guardamos el seguimiento rápido en la desición que si se mando el wa
    $("#btn-success-send-cotizacion").on('click', function (){
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "add_whatsapp")); ?>',
            cache: false,
            type : "POST",
            data: { mensaje: `Se envió vía WhatsApp la cotización del departamento ${ $("#modalSendCotizacionInmuebleReferencia").val() } el día <?= date('d-m-Y H:m') ?>`, accion: 11, cliente_id: $("#modalSendCotizacionClienteId").val(), cotizacion_id: $("#modalSendCotizacionCotizacionId").val() },
            beforeSend: function () {
                $("#modalSendCotizacion").modal("hide");
            },
            success: function ( response ) {

                location.reload();

            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });
    });

    // Lista de opciones para el select de error de wa
    $("#btn-error-send-cotizacion").on('click', function (){
        $('#error_modal_send_cotizacion').empty().append('<option value="">Seleccione una opción</option>');

        $("#input-error-modal-send-cotizacion").removeClass('hidden');

        $("#btn-error-send-cotizacion").addClass('hidden');
        $("#btn-success-send-cotizacion").addClass('hidden');


        // Traer el listado de los errores.
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "diccionarios", "action" => "list_opciones")); ?>',
            cache: false,
            type : "POST",
            data: { subdirectorio: 'dic_wa_error_send_cotizacion' },
            beforeSend: function () {
            },
            success: function ( response ) {

                let diccionario = response;

                $.each(JSON.parse(diccionario), function(key, value) {
                    $('<option>').val('').text('select');
                    $('<option>').val(value).text(value).appendTo($("#error_modal_send_cotizacion"));
                });

            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });


    });

    $("#btn-opccion-error-send-cotizacion").on('click', function (){

        // Traer el listado de los errores.
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "error_send_whatsapp")); ?>',
            cache: false,
            type : "POST",
            data: { mensaje: `Ocurrió un problema al intentar envíar la cotización del inmueble ${ $("#modalSendCotizacionInmuebleReferencia").val() } vía WhatsApp al cliente, por motivo: ${ $("#error_modal_send_cotizacion").val() }`, accion: 11, cliente_id: $("#modalSendCotizacionClienteId").val() },
            beforeSend: function () {
                $("#modalSendCotizacion").modal("hide");
            },
            success: function ( response ) {

                location.reload();

            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });


    });

</script>