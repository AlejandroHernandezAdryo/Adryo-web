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

<style>
    .none{
        display:none !important;
    }
</style>

<div class="modal" id="modalShared">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light">
            <!-- Modal Header -->
            <div class="modal-header bg-blue-is">
                <h4 class="modal-title col-sm-10" id="modal-seguimiento-titulo">Compartir</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="social_media">
                    <div class="text-sm-center">
                        <a href="https://www.facebook.com/share.php?u=<?=Router::url('', true)?>&title=Ficha tecnica" target="_blank" id="refSharedFacebook">
                            <?= $this->Html->image('fb_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4', 'style' => 'width:40px;' )); ?>
                        </a>
                    </div>
                    <div class="text-sm-center">
                        <a href="https://twitter.com/intent/tweet?text=Les comparto este increíble desarrollo vía @adryo_ai <?=Router::url('', true)?>" target="_blank" id="refSharedTwitter">
                            <?= $this->Html->image('tw_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4', 'style' => 'width:40px;')); ?>
                        </a>
                    </div>
                    
                    <div class="text-sm-center">
                        <a target="_blank" id="refSharedWhatsApp" class="pointer">
                            <?= $this->Html->image('wa_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4', 'style' => 'width:40px;')); ?>
                        </a>
                    </div>
                    <div class="text-sm-center">
                        <a href="https://www.linkedin.com/shareArticle?url=<?=Router::url('', true)?>" target="_blank" id="refSharedLinkeding">
                            <?= $this->Html->image('in_r.svg', array('class' => 'img-social-share w-75 mt-4 mb-4', 'style' => 'width:40px;')); ?>
                        </a>
                    </div>
                    <div class="text-sm-center">
                        <a href="#" id="mailShare">
                            <?= $this->Html->image('mailblue.png', array('class' => 'img-social-share w-75 mt-4 mb-4', 'style' => 'width:40px;', 'onClick' => 'resend_email_desarrollo()')); ?>
                            
                            <?= $this->Form->hidden('desarrollo_id_modal_shared'); ?>
                            <?= $this->Form->hidden('cliente_id_modal_shared'); ?>
                            <?= $this->Form->hidden('asesor_id_modal_shared'); ?>
                            <?= $this->Form->hidden('send_iframe_telefono'); ?>
                            <?= $this->Form->hidden('mensaje'); ?>
                        </a>
                    </div>
                </div>

                <div class="row hidden" id ="error_message_send_row">
                    <?= $this->Form->input('error_message_send_iframe',
                        array(
                            'class'   => 'form-control',
                            'label'   => 'Motivo de error',
                            'div'     => 'col-sm-12',
                            'options' => array('Error en el teléfono', 'Se perdió la conexión', 'Número inválido'),
                            'empty'   => 'Seleccione una opción'
                        ));
                    ?>

                    <div class="col-sm-12 mt-2">
                        <span class="btn btn-success btn-block" id = "btn-opccion-error-send-iframe"> Guardar observación</span>
                    </div>
                </div>

                <div class="row hidden" id="btns-modal-send-iframe">
                    <div class="col-sm-12" id='col-btn-error-message'>
                        <button class="btn btn-danger btn-block" type="button"  onclick="errorWa()">Ocurrió algún error al enviar</button>
                    </div>
                    <div class="col-sm-12" id='col-btn-success-send-cotizacion'>
                        <span class="btn btn-success btn-block" id = "btn-success-send-iframe"> El mensaje se envío correctamente </span>
                    </div>
                </div>
            </div>
            <div class="row d-none" >
                <div class="col-sm-12">
                    <p id ="rowSuccessClipboard" class = "text-center hidden text-dark">Vínculo copiado al portapapeles</p>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <div class="input-group mb-1" style="width:88% !important;">
                    <input type             = "text"
                            class            = "form-control"
                            aria-label       = "Recipient's username"
                            aria-describedby = "button-copyshare"
                            id               = "btnCopyLinkShare"
                            readonly>
                    <button class   = "btn btn-secondary-o"
                            type    = "button"
                            onclick = "btnCopyClipboard()"
                            id      = "button-copyshare"
                            style="position:absolute;">
                                Copiar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function errorWa(){
        $('#error_message_send_row').removeClass('hidden');
        $('#btns-modal-send-iframe').addClass('hidden');
    }

    // Esta funcion copia el valor de un input y lo guarda en el portapapeles para solo pegar.
    function btnCopyClipboard() {
        var element = document.getElementById("rowSuccessClipboard");
        element.classList.remove("d-none");
        var copyText = document.getElementById("btnCopyLinkShare").value;
        navigator.clipboard.writeText(copyText).then(() => {
            console.log("SI entro");
            element.classList.remove("hidden");
            window.setInterval(function(){
                element.classList.add("hidden");
            },3000);
        });
    }

    // Esta funcion solo abre el modal de compartir el desarrollo con un URL dinamica
    // Valores que necesito
    // 1.- desarrollo_id.
    // 2.- asesor_id
    // 3.- cliente_id
    // 4.- URL que se comparte.
    // 5.- telefono
    // 6.- nombre_cliente
    var desarrollo_nombre    = 'prueba';
    var inmueble_nombre      = 'prueba';
    var tipo_propiedad_catch = 0;

    function modalShared( desarrollo_id, asesor_id, cliente_id, telefono_cliente, nombre_cliente, tipo_propiedad, nombre_asesor, correo, referencia){

        let URL                  = '';
        let cliente              = nombre_cliente;
            tipo_propiedad_catch = tipo_propiedad;
        let propiedad = referencia;
        
        if ( tipo_propiedad == 1 ) {
            desarrollo_nombre = referencia;
        }else{
            inmueble_nombre = referencia;
        }

        if ( correo != 'Sin correo'){
            event.preventDefault();
            $("#mailShare").removeClass("disabled-icon");
        } else {
            $("#mailShare").addClass("disabled-icon");
        }

        if( tipo_propiedad == 1 ){
            URL = "<?= Router::url(array('controller' => 'desarrollos', 'action' => 'detalle'), true) ?>/"+desarrollo_id+"/<?= $this->Session->read('CuentaUsuario.CuentasUser.user_id')?> ";
        }else{
            URL = "<?= Router::url(array('controller' => 'inmuebles', 'action' => 'detalle'), true) ?>/"+desarrollo_id+"/<?= $this->Session->read('CuentaUsuario.CuentasUser.user_id'); ?> ";
        }

        // Asignamos el valor del desarrollo_id al input que corresponde.
        $("#desarrollo_id_modal_shared").val(desarrollo_id);
        $("#cliente_id_modal_shared").val(cliente_id);
        $("#asesor_id_modal_shared").val(asesor_id);
        $("#send_iframe_telefono").val(telefono_cliente);
        $("#mensaje").val(`<?= $this->Session->read('Parametros.Paramconfig.message_default_whatsapp') ?>`)

        if(isNaN(telefono_cliente)) {
            $("#refSharedWhatsApp").addClass("disabled-icon");
        } 
        
        
        
        $("#btnCopyLinkShare").val(URL);
        $("#refSharedFacebook").attr('href', "https://www.facebook.com/share.php?u="+URL+"&title=Ficha tecnica" );
        $("#refSharedTwitter").attr('href', "https://twitter.com/intent/tweet?text=Les comparto este increíble desarrollo vía @adryo_ai "+URL);
        $("#refSharedLinkeding").attr('href', "https://www.linkedin.com/shareArticle?url="+URL);

        // Abrimos el modal de compartir
        $("#modalShared").modal('show');
        
    }

    function resend_email_desarrollo(){
        // resend_mail_desarrollo
        // desarrollo_id, cliente_id, user_id
        const desarrolloId = $("#desarrollo_id_modal_shared").val();
        const clienteId    = $("#cliente_id_modal_shared").val();
        const asesorId     = $("#asesor_id_modal_shared").val();

        $.ajax({
            type    : "POST",
            url     : '<?= Router::url(array("controller" => "leads", "action" => "resend_mail_desarrollo")); ?>',
            cache   : false,
            data    : { desarrollo_id: desarrolloId, cliente_id: clienteId, user_id: asesorId},
            dataType: 'json',
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                location.reload();
                $("#overlay").fadeOut();

            },
            error: function ( response ) {
                console.log( response.responseText );
            }
        });

    }


    $("#refSharedWhatsApp").on('click', function (){
        $("#btns-modal-send-iframe").removeClass("hidden");

        // Cambiamos las propiedades del modal para que se haga mas pequeño y se centre.
        // $("#social_media").addClass('modal-dialog-centered');
        // $("#social_media").addClass('modal-sm');//modalIframe

        $(".modal-footer").addClass("hidden");
        $(".social_media").addClass("hidden");

        // Presentamos los botones para guardar el seguimiento rápido.
        $("#btn-success-send-iframe").removeClass('float-sm-right');
        $("#btn-success-send-iframe").addClass('mt-1');


        // Evitar cierre de modal al mandar wa
        $("#modalShared").addClass('hidden'); 

        // Abrimso en una página nueva wa
        window.open('https://wa.me/521'+$("#send_iframe_telefono").val()+'?text='+$("#mensaje").val());
    });

    // Guardamos el seguimiento rápido en la desición que si se mando el wa
    $("#btn-success-send-iframe").on('click', function (){

        let tipo_propiedad       = tipo_propiedad_catch;
        let mensajePersonalizado = '';
        if (tipo_propiedad_catch == 1){
            mensajePersonalizado = `Se envió vía WhatsApp el desarrollo ` + desarrollo_nombre +   ` el dia <?= date('d-m-Y H:m') ?>`;
        }else{
            mensajePersonalizado = `Se envió vía WhatsApp la propiedad del departamento ` + inmueble_nombre +   `el dia <?= date('d-m-Y H:m') ?> `;
        }
        let cliente_id=<?=$cliente['Cliente']['id']  ?> ;
        // console.log(carlos_nosevise_siesta_bien_las_cosas_etm_emc);
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "add_whatsapp")); ?>',
            cache: false,
            type : "POST",
            data: { mensaje: mensajePersonalizado, accion: 11, cliente_id: cliente_id},
            beforeSend: function () {
                $("#modalShared").addClass("none");
                $(".modal-backdrop").addClass("none");
                location.reload();
            },
            success: function ( response ) {
                
                // console.log(response);
            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "add_send_iframe")); ?>',
            data: "data",
            dataType: 'json',
            success: function (response) {
                console.log(response);
            }
        });

        // console.log( mensajePersonalizado );
        });


    // Lista de opciones para el select de error de wa
    $("#btn-error-send-iframe").on('click', function (){

        console.log( "Estamos dando click el boton de enviar error. " );
        // $('#error_message_send_iframe').empty().append('<option value="">Seleccione una opción</option>');

        // $("#error_message_send_row").removeClass('hidden');

        // $("#btn-error-send-iframe").addClass('hidden');
        // $("#btn-success-send-iframe").addClass('hidden');


        // Traer el listado de los errores.
        // $.ajax({
        //     url: '<?php echo Router::url(array("controller" => "diccionarios", "action" => "list_opciones")); ?>',
        //     cache: false,
        //     type : "POST",
        //     data: { subdirectorio: 'dic_wa_error_send_cotizacion' },
        //     beforeSend: function () {
        //         $("#modalShared").addClass("none");
        //         $(".modal-backdrop").addClass("none");
        //         location.reload();
        //     },
        //     success: function ( response ) {

        //         let diccionario = response;

        //         $.each(JSON.parse(diccionario), function(key, value) {
        //             $('<option>').val('').text('select');
        //             $('<option>').val(value).text(value).appendTo($("#error_message_send_iframe"));
        //         });

        //     },
        //     error: function ( response ){
        //         console.log( response.responseText );
        //     }
        // });


    });

    $("#btn-opccion-error-send-iframe").on('click', function (){
        var error = null;
        if ($("#error_message_send_iframe").val() == 0) {
            error = 'Error en el teléfono'
        }else if ($("#error_message_send_iframe").val() == 1) {
            error = 'Se perdió la conexión'
        } else {
            error = 'Número inválido'
        }
        let cliente = "<?=$param_return?>";
        console.log(cliente);
        // Traer el listado de los errores.
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "error_send_whatsapp")); ?>',
            cache: false,
            type : "POST",
            data: { mensaje: `Ocurrió un problema al intentar envíar mensaje vía whatsApp al cliente, por motivo:` +error, accion: 11, cliente_id: cliente},
            beforeSend: function () {
                $("#modalIframe").modal("hide");
                $("#overlay").fadeIn();

            },
           
            success: function ( response ) {
                // console.log(response);
                location.reload();


            },
            error: function ( response ){
                console.log( response.responseText );
            }
        });


    });

</script>