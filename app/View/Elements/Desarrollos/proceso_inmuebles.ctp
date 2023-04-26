<?= $this->Html->css(
    array(
 
        '/vendors/select2/css/select2.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/fileinput/css/fileinput.min',
        'pages/form_elements',

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
    .hide{
        display: none;
    }
    .show{
        display: block;
    }
    .label-danger{
        color: #EF6F6C !important;
        background-color: transparent !important;
    }
</style>

<!-- Modal apartado. -->
<div class="modal fade" id="modalProcesoInmuebles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-dialog-prospeccion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalProcesoInmueblesTitle"> </h4>
            </div>
            <?= $this->Form->create('ProcesoInmuebles', array('id' => 'addFormApartados')); ?>
                <div class="modal-body">
                    <div class="row">
                        
                    <div class="col-sm-12 col-lg-6">
                        <label for="nombrePropiedad">Referencia</label>
                        <p id="modalProcesoInmueblesNombrePropiedad"> </p>
                    </div>

                        <?= 
                            $this->Form->input('tipo_operacion',
                                array(
                                    'label'   => 'Tipo de operacion *',
                                    'div'     => 'col-sm-12 col-lg-6',
                                    'options' => array( 2 => 'Reserva / Apartado' ),
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                    </div>

                    <div class="row">

                        <?=
                            $this->Form->input('precio_unidad',
                                array(
                                    'label'   => 'Precio de la unidad',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('monto_reserva',
                                array(
                                    'label'    => 'Monto de la reserva / apartado *',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control',
                                    'required' => true
                                )
                            );
                        ?>
                        

                    </div>

                    <div class="row">
                        <?=
                            $this->Form->input('cliente_id',
                                array(
                                    'label'    => 'Cliente *',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control chzn-select',
                                    'required' => true,
                                    'empty' => 'Seleccione una opción'
                                )
                            );
                        ?>
                        
                        <?=
                            $this->Form->input('user_id',
                                array(
                                    'label'    => 'Asesor*',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control chzn-select',
                                    'required' => true,
                                    'empty' => 'Seleccione una opción',
                                )
                            );
                        ?>
                    </div>

                    <div class="row">

                        <?=
                            $this->Form->input('fecha_reserva',
                                array(
                                    'label'       => 'Fecha de reserva / apartado',
                                    'div'         => 'col-sm-12 col-lg-6 mt-1',
                                    'class'       => 'form-control fechaReserva',
                                    'required'    => true,
                                    'placeholder' => 'DD-MM-AAAA'
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('vigencia_reserva',
                                array(
                                    'label'       => 'Vigencia de reserva / apartado*',
                                    'div'         => 'col-sm-12 col-lg-6 mt-1',
                                    'class'       => 'form-control fechaReserva',
                                    'required'    => true,
                                    'placeholder' => 'DD-MM-AAAA'
                                )
                            );
                        ?>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1 mt-1">
                            <label for="archivos">Anexar comprobante de apartado (.jpg, .jepg o .pdf) </label>
                        </div>
                        <div class="col-sm-12 mt-1">
                            <?=
                                $this->Form->file('foto',array('accept'=>'image/*', 'id' => 'file_apartado'));
                            ?>
                        </div>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Registrar reserva/ apartado', array('class' => 'btn btn-success float-xs-right', 'id' => 'FormSubmitApartado', 'type' => 'submit')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('inmueble_id') ?>
        <?= $this->Form->end()?>
    </div>
</div>


<?php 
    echo $this->Html->script([
        'components',
        'custom',

        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',
        'form',

        '/vendors/chosen/js/chosen.jquery',

        // Radio and checkboxs
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',
        '/vendors/switchery/js/switchery.min',
        'pages/radio_checkbox',

    ], array('inline'=>false));
?>

<script>
    this.list_asesores();

    function showModalProcesoInmuebles( statusInmueble, inmuebleID ) {
        $("#ProcesoInmueblesInmuebleId").val(inmuebleID);
        // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja

        // Step 1 Consulta del inmueble.

        $.ajax({
            url     : '<?php echo Router::url(array("controller" => "inmuebles", "action" => "get_inmueble_detalle")); ?>/'+inmuebleID,
            cache   : false,
            dataType: 'json',
            success: function ( response ) {
                
                console.log( response );
                clientes = response['Lead'];

                $("#modalProcesoInmueblesNombrePropiedad").html( response['Inmueble']['referencia'] );

                if( response['Inmueble']['venta_renta'] == 'Venta' ){
                    $("#ProcesoInmueblesPrecioUnidad").val( response['Inmueble']['precio_r'] );
                }else{
                    $("#ProcesoInmueblesPrecioUnidad").val( response['Inmueble']['precio_2_r'] );
                }

                $.each(clientes, function(key, value) {
                    
                    $('<option>').val(value['Cliente']['id']).text(value['Cliente']['nombre']).appendTo($("#ProcesoInmueblesClienteId"));

                });


                
                $('.chzn-select').trigger('chosen:updated');

            },
        });

        // Step 2 Mostrar modal con la informacion que necesita el formulario.
        switch( statusInmueble ){
            case 2:
                $("#modalProcesoInmueblesTitle").html("Registrar reserva / Apartado de la propiedad");
                $("#modalProcesoInmuebles").modal("show");
                console.log(inmuebleID);
            break;
        }
    };

    function list_asesores(){

        $('#ProcesoInmueblesUserId').empty().append('<option value="">Seleccione una opción</option>');
        $.ajax({
            url: '<?php echo Router::url(array("controller" => "users", "action" => "get_list_users")); ?>',
            cache: false,
            success: function ( response ) {
                $.each(response, function(key, value) {       
                    $('<option>').val(key).text(value).appendTo($("#ProcesoInmueblesUserId"));
                });

                $("#ProcesoInmueblesUserId").val(<?= $this->Session->read('Auth.User.id') ?>);
                
                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

    // Agregar apartado del inmueble.
    $( "#addFormApartados" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
            url     : '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "add")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : $('#addFormApartados').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
                $("#FormSubmitApartado").prop('disabled', true);
            },
            success: function ( response ) {
                
                $("#overlay").fadeOut();
                location.reload();

            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
            }
        });

    });

    // Fecha del form de reserva
    $( document ).ready(function() {

        $(".hide_search").chosen({disable_search_threshold: 10});
        $(".chzn-select").chosen({allow_single_deselect: true});
        $(".chzn-select-deselect,#select2_sample").chosen();

        $("#file_apartado").fileinput({
            theme          : "fa",
            previewFileType: "image",
            browseClass    : "btn btn-primary",
            browseLabel    : "Foto del usuario",
            removeClass    : "btn btn-danger",
            removeLabel    : "Eliminar"
        });

        $('.fechaReserva').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation:"bottom"
        });

    });



</script>
