Edit prospeccion chido
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

<div class="modal fade" id="modalProspeccion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" id="modal-dialog-prospeccion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modalProspeccionTitle">
                    
                </h4>
            </div>
            <?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action' => 'editProspeccion'))); ?>
                <div class="modal-body">

                    <div id="etapaCliente">

                        <div class="row">
                            <div class="col-sm-12 text-sm-center text-warning">
                                <label> <i class="fa fa-warning"></i> Cambio de etapa.</label>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-5">
                                Etapa Actual: <strong> <span id='clienteEtapaactual'></span> </strong>    
                            </div>
                            <div class="col-md-2">
                                <div class="radio_basic_swithes_padbott">
                                    <span class="radio_switchery_padding"> <i class="fa fa-arrow-left"></i> No </span>
                                        <?= $this->Form->input('cambio_etapa', array('type' => 'checkbox', 'class' => 'js-switch sm_toggle', 'label' => false, 'div' => false)) ?>
                                    <span class="radio_switchery_padding">Si <i class="fa fa-arrow-right"></i> </span>
                                </div>
                            </div>
                            <div class="col-md-5 text-lg-center">
                                Etapa Nuevo: <strong> <span id='clienteEtapaSiguiente'> </span> </strong>
                            </div>
                            <?= $this->Form->input('comentarios', array('label'=>array('text' => 'Comentarios*', 'id' => 'labelClienteComententario'),'div' => 'col-md-12','class'=>'form-control', 'maxlength'=>'150'))?>
                        </div>
                    </div>

                    <div id="prospeccion" class="hide">
                        <div class="row">
                            <?= $this->Form->input('operacion_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Tipo de operación',
                                    'options'  => $opciones_venta,
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>

                            <?= $this->Form->input('tipo_propiedad_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Tipo de propiedad',
                                    'options'  => $propiedades_text,
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>

                            <div class="col-sm-12 col-lg-4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $this->Form->label('presupuesto', 'Presupuesto (MDP)') ?>
                                    </div>
                                    <?= $this->Form->input('precio_min_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6 mt-1',
                                            'label'       => false,
                                            'placeholder' => 'Desde',
                                            'step'        => 0.1,
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                    <?= $this->Form->input('precio_max_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6 mt-1',
                                            'label'       => false,
                                            'placeholder' => 'Hasta',
                                            'step'        => 0.1,
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?= $this->Form->input('forma_pago_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Forma de pago',
                                    'options'  => $opciones_formas_pago,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>

                            <?= $this->Form->input('hab_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Recámaras',
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>

                            <div class="col-sm-12 col-lg-4">
                                <div class="row">
                                    <div class="col-sm-12 mt-1">
                                        <?= $this->Form->label('metrajes', 'Metraje deseado') ?>
                                    </div>
                                    <?= $this->Form->input('metros_min_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Minimo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                    <?= $this->Form->input('metros_max_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Maximo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?= $this->Form->input('banios_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Baños',
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>

                            <?= $this->Form->input('estacionamientos_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-4 mt-1',
                                    'label'    => 'Estacionamientos',
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción'
                                )
                            ); ?>

                        </div>

                        <div class="row">
                            <?= $this->Form->input('amenidades_prospeccion_arreglo',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 mt-1',
                                    'label'    => 'Amenidades (Maximo 5 amenidades)',
                                    'options'  => $opciones_amenidades,
                                    'multiple' => 'multiple',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>
                        </div>

                        <div class="row mt-2">
                            <?= $this->Form->input('estado_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => 'Estado',
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'search_alcaldia()'
                                )
                            ); ?>

                            <?= $this->Form->input('ciudad_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => 'Alcaldía / Municipio',
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'search_colonia()',
                                )
                            ); ?>

                            <?= $this->Form->input('colonia_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => 'Colonia',
                                    'onchange' => 'edit_prospeccion(1)',
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>

                            <?= $this->Form->input('zona_prospeccion',
                                array(
                                    'class' => 'form-control',
                                    'div'   => 'col-sm-12 col-lg-3 mt-1',
                                    'label' => 'Zona',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>


                        </div>
                    </div>
                    
                            
                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success float-xs-right', 'id' => 'ClienteBntValidate', 'onclick' => 'submit_form();', 'type' => 'button')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('id'); ?>
            <?= $this->Form->hidden('edit_prospeccion', array('value' => 0)); ?>
            <?= $this->Form->hidden('etapa');?>
        <?= $this->Form->end()?>
    </div>
</div>

<?php 
    echo $this->Html->script([
        'components',
        'custom',
        
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
const switchCambioEtapa = $('#ClienteCambioEtapa');
const etapas =  {
    '1': 'Interés Preliminar',
    '2': 'Comunicación Abierta',
    '3': 'Precalificación',
    '4': 'Visita',
    '5': 'Análisis de Opciones',
    '6': 'Validación de Recursos',
    '7': 'Cierre'
};

// Traer informacion del cliente
function changeSwitchery(element, checked) {
  if ( ( element.is(':checked') && checked == false ) || ( !element.is(':checked') && checked == true ) ) {
    element.parent().find('.switchery').trigger('click');
  }
}

function data_client( cliente_id, cambioEtapa ){

    if( cambioEtapa ){
        changeSwitchery(switchCambioEtapa, true);
        $("#ClienteComentarios").fadeIn();
    }else{
        changeSwitchery(switchCambioEtapa, false);
        $("#ClienteComentarios").fadeOut();
    }

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "data_prospection_client")); ?>',
        cache: false,
        dataType: 'json',
        data: { 'Cliente' : {'cliente_id': cliente_id} },
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        
        success: function ( response ) {

            Cliente = response.data.Cliente;

            // Validación si tiene amenidades, si no, entra en en bucle.
            if( Cliente.amenidades_prospeccion ){
            
                let arrayAmenidades = Cliente.amenidades_prospeccion.split(',');
                const arrayAmenidadesPush = [];
                
                for (var i=0; i < arrayAmenidades.length; i++) {
                    arrayAmenidadesPush.push(arrayAmenidades[i]);
                }

                $("#ClienteAmenidadesProspeccionArreglo").val(arrayAmenidadesPush);
                $("#ClienteAmenidadesProspeccionArreglo").trigger("chosen:updated");

            }

            $('#ClienteId').val(Cliente.id);
            $('#ClienteOperacionProspeccion').val(Cliente.operacion_prospeccion);
            $('#ClienteTipoPropiedadProspeccion').val(Cliente.tipo_propiedad_prospeccion);
            $('#ClientePrecioMinProspeccion').val(Cliente.precio_min_prospeccion);
            $('#ClientePrecioMaxProspeccion').val(Cliente.precio_max_prospeccion);
            $('#ClienteFormaPagoProspeccion').val(Cliente.forma_pago_prospeccion);
            $('#ClienteHabProspeccion').val(Cliente.hab_prospeccion);
            $('#ClienteMetrosMinProspeccion').val(Cliente.metros_min_prospeccion);
            $('#ClienteMetrosMaxProspeccion').val(Cliente.metros_max_prospeccion);
            $('#ClienteBaniosProspeccion').val(Cliente.banios_prospeccion);
            $('#ClienteEstacionamientosProspeccion').val(Cliente.estacionamientos_prospeccion);
            $('#ClienteEstadoProspeccion').val(Cliente.estado_prospeccion);
            $('#ClienteCiudadProspeccion').val(Cliente.ciudad_prospeccion);
            $('#ClienteColoniaProspeccion').val(Cliente.colonia_prospeccion);
            $('#ClienteZonaProspeccion').val(Cliente.zona_prospeccion);

            // Validacion si hay datos en ciudad y colonia, hacer la busqueda para que aparezcan las opciones.
            if( Cliente.estado_prospeccion != '' ){
                search_alcaldia(Cliente.ciudad_prospeccion, Cliente.colonia_prospeccion);
            }


            $('.chzn-select').trigger('chosen:updated');
            
            // Revisar que el estatus del clietne sea el correcto para ingresar la prospección.
            if( Cliente.etapa >= 2 ){
                // 1.- mostrar los campos para prospeccion.
                $('#prospeccion').addClass('show');
                $('#prospeccion').removeClass('hide');

                // 2.- Cambiar el titulo del modal.
                $('#modalProspeccionTitle').html('<i class="fa fa-user-plus"></i> INFORMACIÓN ESPECÍFICA DEL CLIENTE');

                // 3.- Agregarla clase para el modal grande.
                $('#modal-dialog-prospeccion').addClass('modal-lg');
            }else{
                // 1.- Cambiar el titulo del modal.
                $('#modalProspeccionTitle').html('<i class="fa fa-arrow-right"></i> Cambiar cliente a la siguiente etapa');
            }

            
            // Hacer validacion de que si esta en etapa 7, ya no haga el cambio.
            if( Cliente.etapa < 7 ){
                // Asignar la nueva etapa al campo
                let etapaSiguiente = parseInt(Cliente.etapa) + parseInt(1);
                $("#clienteEtapaactual").html( etapas[Cliente.etapa] );
                
                $("#clienteEtapaSiguiente").html( etapas[etapaSiguiente] );
                $("#ClienteEtapa").val(etapaSiguiente);

            }else{
                $('#etapaCliente').addClass('hide');
                $("#ClienteEtapa").val(Cliente.etapa);
            }

            var n = 1;
            window.setInterval(function(){
                n--;
                if (n == 0) {
                    $("#overlay").fadeOut();
                }
            },1000);

        },

        error: function ( response ){
            
            $("#overlay").fadeOut();
            console.log( response.responseText );
        }

        
    });
    
}

function edit_prospeccion( value ){
    console.log('Entra en la edición de edit forma');
    $('#ClienteEditProspeccion').val(1);
}

function validateForm() {
    flag = true;

    // Validación para la etapa, si es etapa, 7 o menor a 2, no tomar en cuenta el comentario.
    // if( $('#ClienteEtapa').val() != 7 ||  $('#ClienteEtapa').val() <= 2 ){
        
    //     if( $("#ClienteComentarios").val() != "" ){
    //         flag = true;
    //     }else{
    //         flag = false;
    //         if( !document.body.contains(document.getElementById("errorClienteComentario")) ) {
    //             $( "#ClienteComentarios" ).after( $("<span id='errorClienteComentario' class='label-danger'>Es necesario agregar un comentario, gracias</span>"));
    //         }
    //         $("#labelClienteComententario").addClass('label-danger');
    //     }

    // }


    return flag;
}

function submit_form(){
    
    if( this.validateForm() == true ){
        // Mandar ajax

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "clientes", "action" => "editProspeccion")); ?>',
            cache: false,
            data : $('#ClienteEditProspeccionForm').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                
                var n = 2;
                window.setInterval(function(){
                    n--;
                    if (n == 0) {
                        $("#overlay").fadeOut();
                        location.reload();
                    }
                },1000);
                
            },
            error: function ( response ) {
                $("#overlay").fadeOut();
                $("#modal_success").modal('show');
                $("#modalProspeccion").modal('hide');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar guardar la información del cliente <br> código de error: ECP-001';
                console.log( response.responseText );
            }
        });


    }
}

// Estados con json
$.ajax({
    url: '<?php echo Router::url(array("controller" => "cps", "action" => "estados_json")); ?>',
    cache: false,
    success: function ( response ) {
        
        $.each(response, function(key, value) {              
            $('<option>').val(value).text(value).appendTo($("#ClienteEstadoProspeccion"));
        });
        $('.chzn-select').trigger('chosen:updated');
        
    }
});

// Traer las alcaldias.
function search_alcaldia( value, colonia ){
    $('#ClienteCiudadProspeccion').empty().append('<option value="">Seleccione una opción</option>');
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "cps", "action" => "alcaldias_json")); ?>',
        cache: false,
        data: { estado: $('#ClienteEstadoProspeccion').val() },
        success: function ( response ) {
            $.each(response, function(key, value) {       
                $('<option>').val(value).text(value).appendTo($("#ClienteCiudadProspeccion"));
            });
            
            if ( value ){
                $('#ClienteCiudadProspeccion').val(value);

                if( colonia ){ search_colonia(colonia); }
                else { search_colonia(); }
            }

            $('.chzn-select').trigger('chosen:updated');
        }
    });
    

    $('.chzn-select').trigger('chosen:updated');
}

function search_colonia( value ){
    $('#ClienteColoniaProspeccion').empty().append('<option value="">Seleccione una opción</option>');
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "cps", "action" => "colonias_json")); ?>',
        cache: false,
        data: { municipio: $('#ClienteCiudadProspeccion').val() },
        success: function ( response ) {
            $.each(response, function(key, value) {       
                $('<option>').val(value).text(value).appendTo($("#ClienteColoniaProspeccion"));
            });

            if ( value ){
                $('#ClienteColoniaProspeccion').val(value);
            }

            $('.chzn-select').trigger('chosen:updated');        
        }
    });

    

    $('.chzn-select').trigger('chosen:updated');
}

$( document ).ready(function() {

    $("#ClienteAmenidadesProspeccionArreglo").chosen({
        max_selected_options: 5,
        placeholder_text_multiple: 'Selecciona hasta 5 opciones.',
    });

    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

});

</script>