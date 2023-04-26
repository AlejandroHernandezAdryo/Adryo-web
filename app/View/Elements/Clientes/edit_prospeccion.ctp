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

                    <div id="mensajes">
                        <div class="row">
                            <div class="col-sm-12">
                                <p id="mensajeText"></p>
                            </div>
                        </div>
                    </div>

                    <div id="etapaCliente">
                        <div class="row">
                            <div class="col-md-5">
                                Etapa Actual: <strong> <span id='clienteEtapaactual'></span> </strong>    
                            </div>
                            <div class="col-md-2 text-sm-center">
                                <i class="fa fa-arrows-h" style="font-size: 3rem;"></i>
                            </div>
                            <div class="col-md-5 text-lg-center">
                                Etapa Nuevo: <strong> <span id='clienteEtapaSiguiente'> </span> </strong>
                            </div>
                            
                        </div>
                    </div>
                    <!-- selects -->
                    <div id="prospeccion" class="hide">
                        <!-- primer row de selects -->
                        <div class="row">
                            <!-- tipo de operación -->
                            <?= $this->Form->input('operacion_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array( 'id' => 'ClienteOperacionProspeccionLabel', 'text' => 'Tipo de operación' ),
                                    'options'  => $opciones_venta,
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>
                            <!-- tipo de propiedad -->
                            <?= $this->Form->input('tipo_propiedad_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('id' => 'ClienteTipoPropiedadProspeccionLabel', 'text'=>'Tipo de propiedad'),
                                    'options'  => $propiedades_text,
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>
                            <!-- presupuesto -->
                            <div class="col-sm-12 col-lg-3 mt-1">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= $this->Form->label('presupuesto', 'Presupuesto (MDP)', array('id' => 'ClientePresupuestoProspeccionLabel')) ?>
                                    </div>
                                    <?= $this->Form->input('precio_min_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'type'        => 'text',
                                            'placeholder' => 'Desde 0.1',
                                            'maxlength'   => '5',
                                            'pattern'     => '[0-9]{1,3}[,\.]{1}[0-9]{1,3}',
                                            //'required'    => true,
                                            'onkeypress'  => 'return valideKey(event)',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                    <?= $this->Form->input('precio_max_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'type'        => 'text',
                                            'placeholder' => 'Hasta 999.9',
                                            'maxlength'   => '5',
                                            'pattern'     => '[0-9]{1,3}[,\.]{1}[0-9]{1,3}',
                                            //'required'    => true,
                                            'onkeypress'  => 'return valideKey(event)',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>    
                                </div>
                            </div>
                            <!-- metraje deseado -->
                            <div class="col-sm-12 col-lg-3">
                                <div class="row">
                                    <div class="col-sm-12 mt-1">
                                        <?= $this->Form->label('metrajes', 'Metraje deseado') ?>
                                    </div>
                                    <?= $this->Form->input('metros_min_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Mínimo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                    <?= $this->Form->input('metros_max_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Máximo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                            )
                                        ); 
                                    ?>   
                                </div>
                            </div>
                        </div>
                        <!-- segundo row de selects -->
                        <div class="row">
                            <!-- forma de pago -->
                            <?= $this->Form->input('forma_pago_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Forma de pago', 'id' => 'ClienteFormaPagoProspeccionLabel'),
                                    'options'  => $opciones_formas_pago,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>
                            <!-- Recámaras -->
                            <?= $this->Form->input('hab_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => 'Recámaras',
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>
                            <!-- metraje deseado (BORRAR) -->
                            <!-- <div class="col-sm-12 col-lg-4">
                                <div class="row">
                                    <div class="col-sm-12 mt-1">
                                        <?= $this->Form->label('metrajes', 'Metraje deseado') ?>
                                    </div>
                                    <?= $this->Form->input('metros_min_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Mínimo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                        )
                                    ); ?>   
                                    <?= $this->Form->input('metros_max_prospeccion',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12 col-lg-6',
                                            'label'       => false,
                                            'placeholder' => 'Máximo',
                                            'step'        => '00.1',
                                            'onchange' => 'edit_prospeccion(1)'
                                            )
                                        ); 
                                    ?>   
                                </div>
                            </div> -->
                            <?= $this->Form->input('banios_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Baños', 'id' => 'ClienteBaniosProspeccionLabel'),
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>
                            <!-- estacionamientos meter en segundo row -->
                            <?= $this->Form->input('estacionamientos_prospeccion',
                                array(
                                    'class'    => 'form-control',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Estacionamientos', 'id' => 'ClienteEstacionamientosProspeccionLabel'),
                                    'options'  => $opciones_minimos,
                                    'onchange' => 'edit_prospeccion(1)',
                                    'empty'    => 'Seleccione una opción'
                                )
                            ); ?>
                        </div>
                        <!-- tercer row -->
                        <div class="row mb-1">
                            <!-- amenidades -->
                            <?= $this->Form->input('amenidades_prospeccion_arreglo',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 mt-1',
                                    'label'    => 'Amenidades (Máximo 5 amenidades)',
                                    'options'  => $opciones_amenidades,
                                    'multiple' => 'multiple',
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>
                        </div>
                        <!-- cuarto row -->
                        <div class="row mb-2">
                            <!-- Estado -->
                            <?= $this->Form->input('estado_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Estado', 'id' => 'ClienteEstadoProspeccionLabel'),
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'search_alcaldia()'
                                )
                            ); ?>
                            <!-- alcaldia municipio -->
                            <?= $this->Form->input('ciudad_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Alcaldía / Municipio', 'id' => 'ClienteCiudadProspeccionLabel'),
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'search_colonia()',
                                )
                            ); ?>
                            <!-- colonia -->
                            <?= $this->Form->input('colonia_prospeccion',
                                array(
                                    'class'    => 'form-control chzn-select',
                                    'div'      => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Colonia', 'id' => 'ClienteColoniaProspeccionLabel'),
                                    'onchange' => 'edit_prospeccion(1)',
                                    'type'     => 'select',
                                    'empty'    => 'Seleccione una opción',
                                )
                            ); ?>
                            <!-- zona de prospeccion -->
                            <?= $this->Form->input('zona_prospeccion',
                                array(
                                    'class' => 'form-control',
                                    'div'   => 'col-sm-12 col-lg-3 mt-1',
                                    'label'    => array('text' => 'Zona', 'id' => 'ClienteZonaProspeccionLabel'),
                                    'onchange' => 'edit_prospeccion(1)'
                                )
                            ); ?>


                        </div>
                    </div>
                    <!-- comentarios -->
                    <?= $this->Form->input('comentarios', array('label'=>array('text' => 'Comentarios* <small class="text-light">(Máximo 250 caracteres.)</small>', 'id' => 'ClienteComentariosLabel'),'div' => 'col-lg-12','class'=>'form-control', 'style' => 'height:48px;', 'maxlength'=>'250'))?>
                    
                            
                </div>
            
                <div class="modal-footer" style="border-top: none !important;">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Guardar cliente', array('class' => 'btn btn-success float-xs-right mt-2', 'id' => 'ClienteBntValidate', 'onclick' => 'btnSubmitForm();', 'type' => 'button')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('id'); ?>
            <?= $this->Form->hidden('edit_prospeccion', array('value' => 0)); ?>
            <?= $this->Form->hidden('cambio_etapa', array('value' => 0)); ?>
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
    '1': '',
    '2': '',
    '3': '',
    '4': '',
    '5': '',
    '6': '',
    '7': ''
};

$.ajax({
    url: '<?php echo Router::url(array("controller" => "DicEmbudoVentas", "action" => "view_etapas", $this->Session->read('CuentaUsuario.Cuenta.id') )); ?>',
    cache: false,
    dataType: 'json',
    success: function ( response ) {

        etapas[1] = response[1];
        etapas[2] = response[2];
        etapas[3] = response[3];
        etapas[4] = response[4];
        etapas[5] = response[5];
        etapas[6] = response[6];
        etapas[7] = response[7];
        
    }
});

// Función para los datos del cliente.
function data_client( cliente_id, cambiarEtapa ){
    $("#modalProspeccion").modal("show");

    cambioEtapa2 = cambiarEtapa;

    if( cambiarEtapa == 0  ){
        $("#etapaCliente").fadeOut("fast");
    }else{
        $("#etapaCliente").fadeIn("fast");
    }

    $("#ClienteCambioEtapa").val(cambiarEtapa);

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

            if( Cliente.hab_prospeccion == 5 ){
                $('#ClienteHabProspeccion').val('+5');
            }else{
                $('#ClienteHabProspeccion').val(Cliente.hab_prospeccion);
            } 

            $('#ClienteMetrosMinProspeccion').val(Cliente.metros_min_prospeccion);
            $('#ClienteMetrosMaxProspeccion').val(Cliente.metros_max_prospeccion);
            
            if( Cliente.banios_prospeccion == 5 ){
                $('#ClienteBaniosProspeccion').val('+5');
            }else{
                $('#ClienteBaniosProspeccion').val(Cliente.banios_prospeccion);
            } 

            if( Cliente.estacionamientos_prospeccion == 5 ){
                $('#ClienteEstacionamientosProspeccion').val('+5');
            }else{
                $('#ClienteEstacionamientosProspeccion').val(Cliente.estacionamientos_prospeccion);
            } 
            

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
                $('#modalProspeccionTitle').html('<i class="fa fa-user-plus"></i> INFORMACIÓN PARA PERFILAMIENTO DEL CLIENTE');

                // 3.- Agregarla clase para el modal grande.
                $('#modal-dialog-prospeccion').addClass('modal-lg');

            }else{
                // 1.- Cambiar el titulo del modal.
                $('#modalProspeccionTitle').html('<i class="fa fa-arrow-right"></i> ACTUALIZAR ETAPA DEL CLIENTE');
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
            
            // validateForm( Cliente.etapa );

        },

        error: function ( response ){
            
            $("#overlay").fadeOut();
            console.log( response.responseText );
        }

        
    });
    
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
        },
        error: function( jqXHR, status, error ) {
            console.log( 'En alcaldia '+error );
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
        dataType: 'json',
        data: { municipio: $('#ClienteCiudadProspeccion').val() },
        success: function ( response ) {
            $.each(response, function(key, value) {       
                $('<option>').val(value).text(value).appendTo($("#ClienteColoniaProspeccion"));
            });

            if ( value ){
                $('#ClienteColoniaProspeccion').val(value);
            }

            $('.chzn-select').trigger('chosen:updated');        
        },
        error: function( jqXHR, status, error ) {
            console.log( error );
        }
    });

    

    $('.chzn-select').trigger('chosen:updated');
}

// Se manda a llamar cada que se detecta un cambio en los campos de prospeccioón.
function edit_prospeccion( value ){
    $('#ClienteEditProspeccion').val(1);
}

// Campos obligatorios para la etapa 1
function camposEtapa1(){
    flag = true;

    // Tipo de operación
    $("#ClienteComentarios").prop('required',true);
    $('#ClienteComentariosLabel').html('Comentarios* <small class="text-light">(Máximo 250 caracteres.)</small>');

    if( $("#ClienteComentarios").val() == '' ){
        $('#ClienteComentariosLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteComentariosLabel').removeClass('label-danger');
    }
    return flag;
}

// Campos obligatorios para la etapa 2
function camposEtapa2(){
    flag = true;

    if( this.camposEtapa1() == false ){
        flag = false
    }

    // Tipo de operación
    $("#ClienteOperacionProspeccion").prop('required',true);
    $('#ClienteOperacionProspeccionLabel').html('Tipo de operación*');

    if( $("#ClienteOperacionProspeccion").val() == '' ){
        $('#ClienteOperacionProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteOperacionProspeccionLabel').removeClass('label-danger');
    }

    // Tipo de propiedad
    $("#ClienteTipoPropiedadProspeccion").prop('required',true);
    $('#ClienteTipoPropiedadProspeccionLabel').html('Tipo de propiedad*');
    if( $("#ClienteTipoPropiedadProspeccion").val() == '' ){
        $('#ClienteTipoPropiedadProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteTipoPropiedadProspeccionLabel').removeClass('label-danger');
    }

    // Presupuesto
    $('#ClientePresupuestoProspeccionLabel').html('Presupuesto (MDP)*');
    $("#ClientePrecioMinProspeccion").prop('required',true);

    if( $("#ClientePrecioMinProspeccion").val() == '' || $("#ClientePrecioMaxProspeccion").val() == ''  ){
        $('#ClientePresupuestoProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClientePresupuestoProspeccionLabel').removeClass('label-danger');
    }

    // Recámaras (Agregar No Aplica)
    // Ubicación (Todas)
    $("#ClienteEstadoProspeccion").prop('required',true);
    $("#ClienteCiudadProspeccion").prop('required',true);
    $("#ClienteColoniaProspeccion").prop('required',true);
    $("#ClienteZonaProspeccion").prop('required',true);
    $('#ClienteEstadoProspeccionLabel').html('Estado*');
    $('#ClienteCiudadProspeccionLabel').html('Alcaldía / Municipio*');
    $('#ClienteColoniaProspeccionLabel').html('Colonia*');
    $('#ClienteZonaProspeccionLabel').html('Zona*');

    if( $("#ClienteEstadoProspeccion").val() == '' ){
        $('#ClienteEstadoProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteEstadoProspeccionLabel').removeClass('label-danger');
    }

    if( $("#ClienteCiudadProspeccion").val() == '' ){
        $('#ClienteCiudadProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteCiudadProspeccionLabel').removeClass('label-danger');
    }

    if( $("#ClienteColoniaProspeccion").val() == '' ){
        $('#ClienteColoniaProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteColoniaProspeccionLabel').removeClass('label-danger');
    }

    if( $("#ClienteZonaProspeccion").val() == '' ){
        $('#ClienteZonaProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteZonaProspeccionLabel').removeClass('label-danger');
    }

    return flag;
}

// Campos obligatorios para la etapa 3
function camposEtapa3(){
    flag = true;

    if( this.camposEtapa1() == false ){
        flag = false
    }

    if( this.camposEtapa2() == false ){
        flag = false
    }

    // Baños.
    $("#ClienteBaniosProspeccion").prop('required',true);
    $('#ClienteBaniosProspeccionLabel').html('Baños*');

    if( $("#ClienteBaniosProspeccion").val() == '' ){
        $('#ClienteBaniosProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteBaniosProspeccionLabel').removeClass('label-danger');
    }

    // Estacionamientos.
    $("#ClienteEstacionamientosProspeccion").prop('required',true);
    $('#ClienteEstacionamientosProspeccionLabel').html('Estacionamientos*');

    if( $("#ClienteEstacionamientosProspeccion").val() == '' ){
        $('#ClienteEstacionamientosProspeccionLabel').addClass('label-danger');
        flag = false;
    }else{
        $('#ClienteEstacionamientosProspeccionLabel').removeClass('label-danger');
    }
    
    return flag;
}

// Función para la validación del formulario.
function validateForm( e ) {
    flag = true;

    switch( e ){

        // Agregar el nivel de interés en la forma de brinco de etapa
        case '1':
            if( this.camposEtapa1() == false ){
                flag = false
            }
        break;
        case '2':

            if( this.camposEtapa2() == false ){
                flag = false
            }

        break;
        case '3':

            if( this.camposEtapa3() == false ){
                flag = false
            }
            
        break;
        case '4': case '5': case '6': case '7':

            if( this.camposEtapa3() == false ){
                flag = false
            }

            // Campos de etapa 4
            $("#ClienteFormaPagoProspeccion").prop('required',true);
            $('#ClienteFormaPagoProspeccionLabel').html('Forma de pago*');

            if( $("#ClienteFormaPagoProspeccion").val() == '' ){
                $('#ClienteFormaPagoProspeccionLabel').addClass('label-danger');
                flag = false;
            }else{
                $('#ClienteFormaPagoProspeccionLabel').removeClass('label-danger');
            }
        break;
        
    }

    return flag;

}

// Función para el envío del formulario con ajax,
function send_ajax_edit_prospeccion(){
    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "clientes", "action" => "editProspeccion")); ?>',
        cache: false,
        data : $('#ClienteEditProspeccionForm').serialize(),
        beforeSend: function () {
            $("#overlay").fadeIn();
        },
        success: function ( response ) {
            
            location.reload();
            
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

function cleanAllInput(){
    // Tipo de operación
    $('#ClienteComentariosLabel').removeClass('label-danger');

    // Baños
    $('#ClienteBaniosProspeccionLabel').removeClass('label-danger');

    // Operacion
    $('#ClienteTipoPropiedadProspeccionLabel').removeClass('label-danger');

    // Operacion
    $('#ClienteOperacionProspeccionLabel').removeClass('label-danger');

    // Presupuesto
    $('#ClientePresupuestoProspeccionLabel').removeClass('label-danger');

    // Estacionamientos
    $('#ClienteEstacionamientosProspeccionLabel').removeClass('label-danger');

    // Estado
    $('#ClienteEstadoProspeccionLabel').removeClass('label-danger');

    // Ciudad
    $('#ClienteCiudadProspeccionLabel').removeClass('label-danger');

    // Colonia
    $('#ClienteColoniaProspeccionLabel').removeClass('label-danger');

    // Zona
    $('#ClienteZonaProspeccionLabel').removeClass('label-danger');

}

// Función para cuando se hace click en el boton de guardar del popUp.
function btnSubmitForm(){

    if( cambioEtapa2 == 1 ){
        $("#mensajeText").fadeOut("fast");

        this.send_ajax_edit_prospeccion();
        
    }else{
        this.cleanAllInput();
        if( $('#ClienteEditProspeccion').val() == 1 ){
            $("#mensajeText").fadeOut("fast");
            this.send_ajax_edit_prospeccion();
        }else{
            $("#mensajeText").fadeIn("fast");
            $("#mensajeText").addClass("label-danger");
            $("#mensajeText").html("No se han detectado cambios en el formulario.");
        }
    }
    
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
