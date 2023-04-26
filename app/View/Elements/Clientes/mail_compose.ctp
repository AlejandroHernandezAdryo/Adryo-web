<?= $this->Html->css(
    array(
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/chosen/css/chosen',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        '/vendors/fileinput/css/fileinput.min',
        'pages/form_elements',
    ),
    array('inline'=>false)); 
?>

<style>
    #ClienteCc_tag, #ClienteBcc_tag{
        width: 100% !important;
    }

    .tagsinput{
        border-radius: 5px !important;
    }

    div.tagsinput span.tag{
        background    : #2e3c54;
        color         : #FFFFFF;
        border        : none !important;
        font-weight   : 400;
        padding-top   : 3px;
        padding-bottom: 3px;
        padding-left  : 10px;
        padding-right : 10px;
    }

    .input-group-addon{
        background-color: #FFFFFF;
    }

    .disabled{
        background-color: #E5E7E8;
    }

    #ClienteCc_tag,
    #ClienteBcc_tag{
        height : 20px;
        margin : 0px !important;
        padding: 0px !important;
    }

</style>

<!-- Modal para el envio de correos al cliente -->
<div class="modal fade" id="modal_mail_compose" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-envelope fa-lg"></i>
                    Enviar correo a cliente
                </h4>
            </div>
            <div class="modal-body">
                <?= $this->Form->create('Cliente',array('url'=>array('controller'=>'clientes','action'=>'send_correo'), 'type'=>'file', 'class'=>'form-horizontal'))?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <span class="input-group-addon disabled">Para:</span>
                                <?= $this->Form->input('para', array('class' => 'form-control', 'type' => 'email', 'value'=>$cliente['Cliente']['correo_electronico'], 'disabled', 'label' => false )) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 m-t-10">
                            <div class="input-group" id ="div-group-cc">
                                <span class="input-group-addon">Cc:</span>
                                <?= $this->Form->input('cc', array('class' => 'form-control tags', 'placeholder' => 'Cc', 'type' => 'text', 'label' => false, 'required' => false )) ?>
                            </div>
                        </div>
                        <div class="col-sm-12 m-t-10">

                            <div class="input-group" id ="div-group-cco">
                                <span class="input-group-addon">Cco:</span>
                                <?= $this->Form->input('bcc', array('class' => 'form-control tags', 'placeholder' => 'Cco', 'label' => false, 'type' => 'text', 'required' => false )) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">Asunto: * </span>
                        <?= $this->Form->input('asunto', array('class' => 'form-control', 'placeholder' => 'Asunto*', 'label' => false )) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon disabled ">De*</span>
                        <?= $this->Form->input('de', array('class' => 'form-control', 'placeholder' => 'De*', 'label' => false, 'value' => $this->Session->read('Auth.User.nombre_completo').' - '.$this->Session->read('Auth.User.correo_electronico'), 'disabled' )) ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <?= $this->Form->input('contenido', array('class'=>'form-control', 'div'=>'col-md-12 m-t-15', 'type'=>'textarea', 'label' => false ))?>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-sm-12">
                        <?= $this->Form->file('adjunto',array())?>
                    </div>
                </div>


            </div>
            
            <div class="modal-footer">
                <button type="submit" class="btn btn-success float-xs-right" id="add-new-event">
                    Enviar Correo
                </button>
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                    Cerrar
                </button>

            </div>
            <?= $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']))?>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<?= $this->Html->script([
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/chosen/js/chosen.jquery',
        '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/js/jquery.tagsinput',
        '/vendors/validval/js/jquery.validVal.min',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
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
    ], array('inline'=>false));
?>

<script>

    $(document).on("submit", "#ClienteSendCorreoForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "send_correo")); ?>',
            type: "POST",
            dataType: "json",
            data: new FormData(this),
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
                console.log( response.responseText );
            },
        });

    });

    $("#ClienteAdjunto").fileinput({
        theme: "fa",
        previewFileType: "image",
        browseClass: "btn btn-primary",
        browseLabel: "Foto del usuario",
        removeClass: "btn btn-danger",
        removeLabel: "Eliminar"
    });

    $('.tags').tagsInput({

        height             : '30px',
        width              : '100%',
        interactive        : true,
        defaultText        : 'ejemplo@dominio.com',
        removeWithBackspace: true,

    });

    // Validacion de correo para el campo de cc o cco.  
    $(document).on("keyup", "#ClienteCc_tag", function(){

        var texto = document.getElementById('ClienteCc_tag').value;
        var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

        if( texto != ''){

            if( !regex.test(texto) ){
                if( !document.body.contains(document.getElementById("errorClienteCc_tagsinput")) ) {
                    $( "#div-group-cc" ).before( $("<span id='errorClienteCc_tagsinput' class='label-danger'>Favor de escribir un correo valido.</span>"));
                }
    
            }else{
                if( document.body.contains(document.getElementById("errorClienteCc_tagsinput")) ) {
                    document.getElementById("errorClienteCc_tagsinput").remove();
                }
            }
            
        }else{
            if( document.body.contains(document.getElementById("errorClienteCc_tagsinput")) ) {
                document.getElementById("errorClienteCc_tagsinput").remove();
            }
        }
        

    });

    $(document).on("keyup", "#ClienteBcc_tag", function(){

        var texto = document.getElementById('ClienteBcc_tag').value;
        var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

        if( texto != ''){

            if( !regex.test(texto) ){
                if( !document.body.contains(document.getElementById("errorClienteCco_tagsinput")) ) {
                    $( "#div-group-cco" ).before( $("<span id='errorClienteCco_tagsinput' class='label-danger'>Favor de escribir un correo valido.</span>"));
                }

            }else{
                if( document.body.contains(document.getElementById("errorClienteCco_tagsinput")) ) {
                    document.getElementById("errorClienteCco_tagsinput").remove();
                }
            }
            
        }else{
            if( document.body.contains(document.getElementById("errorClienteCco_tagsinput")) ) {
                document.getElementById("errorClienteCc_tagsinput").remove();
            }
        }

    });


</script>