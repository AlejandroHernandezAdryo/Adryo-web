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

        // Radio and checkbox
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/switchery/css/switchery.min',
        '/vendors/radio_css/css/radiobox.min',
        '/vendors/checkbox_css/css/checkbox.min',
        'pages/radio_checkbox',

        '/vendors/swiper/css/swiper.min',
        'pages/widgets',
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
<div class="modal fade" id="modalApartado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-dialog-prospeccion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Registrar reserva / Apartado de la propiedad</h4>
            </div>
            <?= $this->Form->create('ProcesoInmuebles', array('type'=>'file','class'=>'form-horizontal login_validator', 'id' => 'addFormApartados'))?>
                <div class="modal-body">
                    <div class="row">
                        
                    <div class="col-sm-12 col-lg-6">
                        <label for="nombrePropiedad">Referencia</label>
                        <p id="modalApartadoNombrePropiedad"> </p>
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
                            $this->Form->input('cliente_id',
                                array(
                                    'label'    => 'Cliente *',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control chzn-select',
                                    'required' => true,
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'carga_monto();'
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
                            $this->Form->input('precio_lista_2',
                                array(
                                    'label'   => 'Precio de lista',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control',
                                    'disabled' => true
                                )
                            );
                        ?>

                        <?=
                            // $this->Form->input('monto_cotizacion',
                            $this->Form->input('precio_unidad_hiden',
                                array(
                                    'label'    => 'Precio de venta*',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control',
                                    'required' => true
                                )
                            );
                        ?>

                        <?= $this->Form->hidden('precio_unidad'); ?>

                    </div>

                    <!-- Rellenar con el monto de la cotización -->
                    <div class="row">
                        <?=
                            $this->Form->input('monto_reserva_hiden',
                                array(
                                    'label'    => 'Pago de reserva / apartado *',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control',
                                    'required' => true
                                )
                            );
                        ?>

                        <?= $this->Form->hidden('monto_reserva'); ?>


                    </div>

                    <div class="row">

                        <?=
                            $this->Form->input('fecha_reserva',
                                array(
                                    'label'        => 'Fecha de reserva / apartado',
                                    'div'          => 'col-sm-12 col-lg-6 mt-1',
                                    'class'        => 'form-control fechaReserva',
                                    'required'     => true,
                                    'placeholder'  => 'DD-MM-AAAA',
                                    'autocomplete' => 'off'
                                )
                            );
                        ?>

                        <div class="col-sm-12 col-lg-6 mt-1">
                            <label for="vigencia_plan_pagos">
                                Vigencia de reserva / apartado en días* <span class="pointer anchor" onclick="datePlus(5,2)">(5)</span> <span class="pointer anchor" onclick="datePlus(10,2)">(10)</span> <span class="pointer anchor" onclick="datePlus(15,2)">(15)</span> <span class="pointer anchor" onclick="datePlus(0,2)">(manual)</span>
                            </label>
                            <?= $this->Form->input('vigencia_reserva',
                                array(
                                    'class'        => 'form-control fechaReserva',
                                    'label'        => false,
                                    'div'          => false,
                                    'type'         => 'text',
                                    'autocomplete' => 'off',
                                    'required'     => true,
                                    'placeholder'  => 'DD-MM-AAAA'
                                )
                            ); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1">
                            <label for="Documentacion">Documentos para apoyo de reserva / apartado</label>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <select id="ProcesoInmueblesApartadoTipoDocumento" class="form-control chzn-select" onchange="validacionDocumentoApartado();"></select>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <button type="button" id="add_documento" class="btn btn-success float-sm-right">
                                agregar documento
                            </button>
                        </div>
                    </div>
                    <div class="row mb-1" id="add_documento_apartado"> </div>

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
            <?= $this->Form->hidden('precio_lista'); ?>
            <?= $this->Form->hidden('cotizacion_id') ?>
        <?= $this->Form->end()?>
    </div>
</div>

<!-- Modal de Venta -->
<div class="modal fade" id="modalVenta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-dialog-prospeccion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Registrar Venta / Contrato </h4>
            </div>
            <?= $this->Form->create('ProcesoInmueblesVenta', array('type'=>'file','class'=>'form-horizontal login_validator', 'id' => 'addFormVenta'))?>
                <div class="modal-body">
                    <div class="row">
                        
                    <div class="col-sm-12 col-lg-6">
                        <label for="nombrePropiedad">Referencia</label>
                        <p id="modalVentaNombrePropiedad"> </p>
                    </div>

                        <?= 
                            $this->Form->input('tipo_operacion',
                                array(
                                    'label'   => 'Tipo de operacion *',
                                    'div'     => 'col-sm-12 col-lg-6',
                                    'options' => array( 3 => 'Venta / Contrato' ),
                                    'class'   => 'form-control'
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
                                    'empty'    => 'Seleccione una opción',
                                    'onchange' => 'carga_monto_venta();'
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
                            $this->Form->input('precio_lista_2',
                                array(
                                    'label'   => 'Precio de lista',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control',
                                    'disabled' => true
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('precio_unidad_2',
                                array(
                                    'label'   => 'Precio de venta',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                        <?=
                            $this->Form->hidden('precio_unidad',
                                array(
                                    'label'   => 'Precio de venta',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                    </div>


                    <div class="row">
                        <?=
                            $this->Form->input('monto_venta_2',
                                array(
                                    'label'    => 'Pago a la firma de contrato / enganche*',
                                    'div'      => 'col-sm-12 col-lg-6 mt-1',
                                    'class'    => 'form-control',
                                    'required' => true
                                )
                            );
                        ?>
                        <?= $this->Form->hidden('monto_venta'); ?>
                    </div>

                    <div class="row">
                        <?=
                            $this->Form->input('monto_financiamiento',
                                array(
                                    'label'       => 'Financiamiento apalazado / diferido',
                                    'div'         => 'col-sm-12 col-lg-6 mt-1',
                                    'class'       => 'form-control',
                                    'required'    => true,
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('plazos_financimiento',
                                array(
                                    'label'       => 'Plazo (meses)',
                                    'div'         => 'col-sm-12 col-lg-3 mt-1',
                                    'class'       => 'form-control',
                                    'required'    => true,
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('monto_plazos',
                                array(
                                    'label'       => 'Monto de los aplazados',
                                    'div'         => 'col-sm-12 col-lg-3 mt-1',
                                    'class'       => 'form-control',
                                    'required'    => true,
                                )
                            );
                        ?>

                    </div>

                    <div class="row">
                        <?=
                            $this->Form->input('fecha_venta',
                                array(
                                    'label'       => 'Fecha de venta / contrato',
                                    'div'         => 'col-sm-12 col-lg-6 mt-1',
                                    'class'       => 'form-control fechaVenta',
                                    'required'    => true,
                                    'placeholder' => 'DD-MM-AAAA'
                                )
                            );
                        ?>

                        <div class="col-sm-12 col-lg-6 mt-1">
                            <label for="vigencia_plan_pagos">
                                Fecha registrada para escrituración*
                                <!-- Fecha registrada para escrituración* <span class="pointer anchor" onclick="datePlus(5, 3)">(5)</span> <span class="pointer anchor" onclick="datePlus(10, 3)">(10)</span> <span class="pointer anchor" onclick="datePlus(15, 3)">(15)</span> <span class="pointer anchor" onclick="datePlus(0, 3)">(manual)</span> -->
                            </label>
                            <?= $this->Form->input('vigencia_venta',
                                array(
                                    'class'        => 'form-control fechaReserva',
                                    'label'        => false,
                                    'div'          => false,
                                    'type'         => 'text',
                                    'autocomplete' => 'off',
                                    'required'     => true,
                                    'placeholder'  => 'DD-MM-AAAA'
                                )
                            ); ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1">
                            <label for="Documentacion">Documentos para apoyo de venta / contrato</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <select id="ProcesoInmueblesVentaTipoDocumento" class="form-control chzn-select" onchange="validacionDocumentoVenta();"></select>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <button type="button" id="add_documento_venta" class="btn btn-success float-sm-right">
                                agregar documento
                            </button>
                        </div>
                    </div>
                    <div class="row mb-1" id="row_add_documento_venta"> </div>

                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Registrar venta / contrato', array('class' => 'btn btn-success float-xs-right', 'id' => 'FormSubmitApartado', 'type' => 'submit')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('inmueble_id') ?>
            <?= $this->Form->hidden('cotizacion_id') ?>
            <?= $this->Form->hidden('precio_lista'); ?>
        <?= $this->Form->end()?>
    </div>
</div>

<!-- Modal de Escrituracion -->
<div class="modal fade" id="modalEscrituracion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="modal-dialog-prospeccion">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Registrar escrituración de la propiedad.</h4>
            </div>
            <?= $this->Form->create('ProcesoInmueblesEscrituracion', array('type'=>'file','class'=>'form-horizontal login_validator', 'id' => 'addFormEscrituracion'))?>
                <div class="modal-body">
                    <div class="row">
                        
                    <div class="col-sm-12 col-lg-6">
                        <label for="nombrePropiedad">Referencia</label>
                        <p id="modalEscrituracionNombrePropiedad"> </p>
                    </div>

                        <?= 
                            $this->Form->input('tipo_operacion',
                                array(
                                    'label'   => 'Tipo de operacion *',
                                    'div'     => 'col-sm-12 col-lg-6',
                                    'options' => array( 4 => 'Escrituración' ),
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                    </div>

                    <div class="row">

                        <?=
                            $this->Form->input('precio_unidad',
                                array(
                                    'label'   => 'Precio de venta',
                                    'div'     => 'col-sm-12 col-lg-6 mt-1',
                                    'class'   => 'form-control'
                                )
                            );
                        ?>

                        <?=
                            $this->Form->input('monto_escrituracion',
                                array(
                                    'label'    => 'Monto de la escrituración *',
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
                            $this->Form->input('fecha_escrituracion',
                                array(
                                    'label'       => 'Fecha de escrituración',
                                    'div'         => 'col-sm-12 col-lg-6 mt-1',
                                    'class'       => 'form-control fechaReserva',
                                    'required'    => true,
                                    'placeholder' => 'DD-MM-AAAA'
                                )
                            );
                        ?>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mt-2">
                            <select id="ProcesoInmueblesEscrituracionTipoDocumento" class="form-control chzn-select"></select>
                        </div>
                        <div class="col-sm-12 col-lg-6 mt-2">
                            <button type="button" id="add_documento_escrituracion" class="btn btn-success float-sm-right">
                                agregar documento
                            </button>
                        </div>
                    </div>
                    <div class="row mb-1" id="row_add_documento_escrituracion"> </div>

                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Registrar escrituración', array('class' => 'btn btn-success float-xs-right', 'type' => 'submit')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('inmueble_id') ?>
        <?= $this->Form->end()?>
    </div>
</div>

<!-- Modales para eliminar el apartado -->
<div class="modal fade" id="modalDeleteApartado" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Borrado de operación </h4>
            </div>
            <?= $this->Form->create('DeleteOperacionesInmueble', array('id' => 'deleteFormApartados'))?>
                <div class="modal-body">
                    Esta seguro que desea eliminar el proceso de <span id="processDeleteName"></span>
                </div>
            
                <div class="modal-footer">
                    <div class="row mt-1">
                        <div class="col-sm-12">
                            <?= $this->Form->button('Eliminar', array('class' => 'btn btn-danger float-xs-right', 'id' => 'FormSubmitDeleteOperacion', 'type' => 'submit')); ?>
                        </div>
                    </div>
                </div>

            </div>
            <?= $this->Form->hidden('inmueble_id') ?>
            <?= $this->Form->hidden('operacionId') ?>
            <?= $this->Form->hidden('clienteId') ?>

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
    this.list_documentos_reserva();

    // Funcion para abrir el modal para las operaciones
    function showModalProcesoInmuebles( statusInmueble, inmuebleID, clienteID = null ) {
        // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja

        // Step 1.- Limpieza de los campos de opciones para la seleccion del proceso
        $('#ProcesoInmueblesClienteId').empty().append('<option value="">Seleccione una opción</option>');
        $('#ProcesoInmueblesVentaClienteId').empty().append('<option value="">Seleccione una opción</option>');
        $('#ProcesoInmueblesEscrituracionClienteId').empty().append('<option value="">Seleccione una opción</option>');
        
        // Step 2.- Agregar valor al campo de inmueble ID
        $("#ProcesoInmueblesInmuebleId").val(inmuebleID);
        $("#ProcesoInmueblesVentaInmuebleId").val(inmuebleID);
        $("#ProcesoInmueblesEscrituracionInmuebleId").val(inmuebleID);

        // Step 3.- Consulta del inmueble.
        $.ajax({
            url     : '<?php echo Router::url(array("controller" => "inmuebles", "action" => "get_inmueble_detalle")); ?>/'+inmuebleID,
            cache   : false,
            dataType: 'json',
            success: function ( response ) {
                // console.log( response );
                clientes = response['Lead'];

                // 4.- itulos para el label del nombre de la propiedad
                $("#modalApartadoNombrePropiedad").html( response['Inmueble']['referencia'] );
                $("#modalVentaNombrePropiedad").html( response['Inmueble']['referencia'] );
                $("#modalEscrituracionNombrePropiedad").html( response['Inmueble']['referencia'] );

                // 5.- Llenado del campo de precio
                if( response['Inmueble']['venta_renta'] == 'Venta' ){
                    $("#ProcesoInmueblesPrecioLista").val( response['Inmueble']['precio_r'] );
                    document.getElementById('ProcesoInmueblesPrecioLista2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['Inmueble']['precio_r']);
                    
                    $("#ProcesoInmueblesVentaPrecioUnidad").val( response['Inmueble']['precio_r'] );
                    document.getElementById('ProcesoInmueblesVentaPrecioLista2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['Inmueble']['precio_r']);
                    
                    $("#ProcesoInmueblesEscrituracionPrecioUnidad").val( response['Inmueble']['precio_r'] );

                    
                }else{
                    $("#ProcesoInmueblesPrecioLista").val( response['Inmueble']['precio_2_r'] );
                    document.getElementById('ProcesoInmueblesPrecioLista2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['Inmueble']['precio_2_r']);

                    $("#ProcesoInmueblesVentaPrecioUnidad").val( response['Inmueble']['precio_2_r'] );
                    document.getElementById('ProcesoInmueblesVentaPrecioLista2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['Inmueble']['precio_2_r']);
                    
                    $("#ProcesoInmueblesEscrituracionPrecioUnidad").val( response['Inmueble']['precio_2_r'] );
                }

                // 6.- Opciones para los clientes relacionados con la propiedad.
                $.each(clientes, function(key, value) {
                    
                    $('<option>').val(value['Cliente']['id']).text(value['Cliente']['nombre']).appendTo($("#ProcesoInmueblesClienteId"));
                    $('<option>').val(value['Cliente']['id']).text(value['Cliente']['nombre']).appendTo($("#ProcesoInmueblesVentaClienteId"));
                    $('<option>').val(value['Cliente']['id']).text(value['Cliente']['nombre']).appendTo($("#ProcesoInmueblesEscrituracionClienteId"));

                });

                // Actualizaremos el id del cliente si se obtiene desde la vista del cliente.
                if( clienteID ){
                    $("#ProcesoInmueblesClienteId").val( clienteID );
                    $('#ProcesoInmueblesClienteId_chosen').attr('readonly', true);
                    // $('#ProcesoInmueblesClienteId').prop('disabled', true).trigger("liszt:updated");


                    $("#ProcesoInmueblesVentaClienteId").val( clienteID );
                    $('#ProcesoInmueblesVentaClienteId_chosen').attr('readonly', true);


                    carga_monto();
                    carga_monto_venta();
                }

                $('.chzn-select').trigger('chosen:updated');


            },
        });

        // Step 7.- Mostrar modal con la informacion que necesita el formulario.
        switch( statusInmueble ){

            case 2: // Apartado
                $("#modalApartado").modal("show");
            break;

            case 3: // Venta
                $("#modalVenta").modal("show");
                this.list_documentos_venta();
            break;

            case 4: // Escrituracion
                $("#modalEscrituracion").modal("show");
                this.list_documentos_escrituracion()
            break;
        }



    };

    // Funcion para edicion del apartado de venta.
    function editModalProcesoInmueble( operacionId ){
        alert( operacionId );
    }

    // Eliminar la operacion de la propiedad.
    function deleteModalProcesoInmueble( operacionId, clienteId, nombrePropiedad, inmuebleId, statusInmueble ){

        $("#modalDeleteApartado").modal('show');
        
        // Rellenar la info del formulario.
        switch( statusInmueble ){
            case 2: // Apartado
                proceso = 'apartado';
            break;

            case 3: // Venta
                proceso = 'venta';
            break;

            case 4: // Escrituracion
                proceso = 'escrituración';
            break;
        }

        document.getElementById("processDeleteName").innerHTML = proceso + ' de la propiedad ' + nombrePropiedad;
        $("#DeleteOperacionesInmuebleInmuebleId").val(inmuebleId);
        $("#DeleteOperacionesInmuebleOperacionId").val(operacionId);
        $("#DeleteOperacionesInmuebleClienteId").val(clienteId);

    }

    // Formulario de apartado
    $(document).on("submit", "#addFormApartados", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "add_reserva")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                window.location.reload();
            },
            error: function ( response ) {

                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
        });
    });

    // Formulario de venta / contrato.
    $(document).on("submit", "#addFormVenta", function (event) {
        event.preventDefault();
        
        // var FormData =new FormData(this);
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "add_venta")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                window.location.reload(true);
            },
            error: function ( response ) {
                
                window.location.reload(true);
                console.log( response );
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                console.log("Hay un error aqui en el modal de la venta");
            },
        });
    });
    function reload(){
        location.reload();
    }
    // Formulario de escrituración.
    $(document).on("submit", "#addFormEscrituracion", function (event) {
        event.preventDefault();

        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "add_escrituracion")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function (response) {
                console.log("Hola estamos mandando el formulario de la escrituración.");
                $("#overlay").fadeIn();
                location.reload();
            },
            error: function ( response ) {
                $("#overlay").fadeOut();
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
            },
        });
    });

    // Formulario para eliminar las operaciones.
    $(document).on("submit", "#deleteFormApartados", function (event) {
        event.preventDefault();

        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "OperacionesInmuebles", "action" => "delete")); ?>',
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
                // location.reload();
                console.log("Termino de cancelar");
                console.log( response );
            },
            error: function ( response ) {
                $("#overlay").fadeOut();
                console.log("Termino de mandar error en la cancelación.");
                console.log( response );
                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar eliminar el apartado, favor de comunicarlo al administrador con el código ERD-001';
            },
        });
    });

    // Listado de los asesores
    function list_asesores(){

        $('#ProcesoInmueblesUserId').empty().append('<option value="">Seleccione una opción</option>');
        $('#ProcesoInmueblesVentaUserId').empty().append('<option value="">Seleccione una opción</option>');
        $('#ProcesoInmueblesEscrituracionUserId').empty().append('<option value="">Seleccione una opción</option>');

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "users", "action" => "get_list_users")); ?>',
            cache: false,
            success: function ( response ) {
                
                $.each(response, function(key, value) {       
                    $('<option>').val(key).text(value).appendTo($("#ProcesoInmueblesUserId"));
                    $('<option>').val(key).text(value).appendTo($("#ProcesoInmueblesVentaUserId"));
                    $('<option>').val(key).text(value).appendTo($("#ProcesoInmueblesEscrituracionUserId"));
                });

                // Esta variable de cambiar de forma interactiva desde que se abre el modal de apartado, venta y escrituración AKA SaaK 30/Mar/23
                $("#ProcesoInmueblesUserId").val(<?= $cliente['Cliente']['user_id'] ?>);
                $("#ProcesoInmueblesVentaUserId").val(<?= $cliente['Cliente']['user_id'] ?>); 
                $("#ProcesoInmueblesEscrituracionUserId").val(<?= $cliente['Cliente']['user_id'] ?>);
                
                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

    function list_documentos_reserva(){

        $('#ProcesoInmueblesApartadoTipoDocumento').empty().append('<option value="">Seleccione una opción</option>');

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "diccionarios", "action" => "docs_inmuebles_apartado")); ?>',
            cache: false,
            success: function ( response ) {
                
                $.each(response, function(key, value) {       
                    $('<option>').val(value.replace(/ /g, "_")).text(value).appendTo($("#ProcesoInmueblesApartadoTipoDocumento"));
                });

                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

    function list_documentos_venta(){

        $('#ProcesoInmueblesVentaTipoDocumento').empty().append('<option value="">Seleccione una opción</option>');

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "diccionarios", "action" => "docs_inmuebles_venta")); ?>',
            cache: false,
            success: function ( response ) {
                
                $.each(response, function(key, value) {       
                    $('<option>').val(value.replace(/ /g, "_")).text(value).appendTo($("#ProcesoInmueblesVentaTipoDocumento"));
                });

                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

    function list_documentos_escrituracion(){

        $('#ProcesoInmueblesEscrituracionTipoDocumento').empty().append('<option value="">Seleccione una opción</option>');

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "diccionarios", "action" => "docs_inmuebles_escrituracion")); ?>',
            cache: false,
            success: function ( response ) {
                
                $.each(response, function(key, value) {       
                    $('<option>').val(value.replace(/ /g, "_")).text(value).appendTo($("#ProcesoInmueblesEscrituracionTipoDocumento"));
                });

                $('.chzn-select').trigger('chosen:updated');
            }
        });

    }

    var nextinput = 0;
    $("#add_documento").on('click', function(){

        valorCampo = $("#ProcesoInmueblesApartadoTipoDocumento").val();
        remplazar = valorCampo.replace(/_/g, " ");

        campo = '<div class="col-sm-12 mt-1"> <label for="label-documento-1">'+remplazar+'</label> </div> <div class="col-sm-12"> <input type="file" name="data[ProcesoInmuebles][archivos_reserva]['+nextinput+']['+valorCampo.toLowerCase()+']" accept="image/*, .pdf" required="required"> </div>';
        $("#add_documento_apartado").append(campo);
        nextinput++;

        // Validacion de campo lleno al agregar un documento.
        $("#ProcesoInmueblesApartadoTipoDocumento").val('');
        $('.chzn-select').trigger('chosen:updated');
        validacionDocumentoApartado();
        
    });

    var nextinput2 = 0;
    $("#add_documento_venta").on('click', function(){

        valorCampo = $("#ProcesoInmueblesVentaTipoDocumento").val();
        remplazar = valorCampo.replace(/_/g, " ");

        campo = '<div class="col-sm-12 mt-1"> <label for="label-documento-1">'+remplazar+'</label> </div> <div class="col-sm-12"> <input type="file" name="data[ProcesoInmueblesVenta][archivos_venta]['+nextinput2+']['+valorCampo.toLowerCase()+']" accept="image/*, .pdf" required="required"> </div>';
        $("#row_add_documento_venta").append(campo);
        nextinput2++;

        // Validacion de campo lleno al agregar un documento.
        $("#ProcesoInmueblesVentaTipoDocumento").val('');
        $('.chzn-select').trigger('chosen:updated');
        validacionDocumentoVenta();

    });

    var nextinput3 = 0;
    $("#add_documento_escrituracion").on('click', function(){

        valorCampo = $("#ProcesoInmueblesEscrituracionTipoDocumento").val();
        remplazar = valorCampo.replace(/_/g, " ");

        campo = '<div class="col-sm-12 mt-1"> <label for="label-documento-1">'+remplazar+'</label> </div> <div class="col-sm-12"> <input type="file" name="data[ProcesoInmueblesEscrituracion][archivos_escrituracion]['+nextinput3+']['+valorCampo.toLowerCase()+']" accept="image/*, .pdf"> </div>';
        $("#row_add_documento_escrituracion").append(campo);
        nextinput3++;
    });

    // Dias para la cotizacion 5, 10, 15
    function datePlus( days, campo ){

        switch( campo ){

            case 2: // Apartado
                if( days == 0 ){
                    document.getElementById("ProcesoInmueblesVigenciaReserva").focus();
                }

                var date = $("#ProcesoInmueblesFechaReserva").val();
                var newdate = date.split("-").reverse().join("-");


                    days     = days + 1;
                var tmpDate  = new Date( newdate );
                var new_date = addDaysToDate(tmpDate, days);
                var mes      = Number(new Date(new_date).getMonth());
                    mes      = Number(new Date(new_date).getMonth());
                document.getElementById('ProcesoInmueblesVigenciaReserva').value = new Date(new_date).getDate() + "-" + (mes+1) + '-' + new Date(new_date).getFullYear();




            break;

            case 3: // Venta

                if( days == 0 ){
                    document.getElementById("ProcesoInmueblesVentaVigenciaVenta").focus();
                }

                var date = $("#ProcesoInmueblesVentaFechaVenta").val();
                var newdate = date.split("-").reverse().join("-");


                    days     = days + 1;
                var tmpDate  = new Date( newdate );
                var new_date = addDaysToDate(tmpDate, days);
                var mes      = Number(new Date(new_date).getMonth());
                    mes      = Number(new Date(new_date).getMonth());
                document.getElementById('ProcesoInmueblesVentaVigenciaVenta').value = new Date(new_date).getDate() + "-" + (mes+1) + '-' + new Date(new_date).getFullYear();

            break;

            case 4: // Escrituracion
                $("#modalEscrituracion").modal("show");
                this.list_documentos_escrituracion()
            break;

        }

    }

    function addDaysToDate(date, days){
        var resultado = new Date(date);
        resultado.setDate(resultado.getDate() + days);
        return resultado;
    }

    // Carga el monto del precio de venta y el apartado
    function carga_monto(){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "cotizacions", "action" => "data_operacions")); ?>',
            cache: false,
            data: { cliente_id: $("#ProcesoInmueblesClienteId").val() },
            dataType: 'json',
            success: function ( response ) {
                // console.log( response );
                
                // Agregamos el precio para los campos de apartado
                // Se ponen los campos bloqueados para el usuario en caso de que se cargue de forma auttomatica.
                
                $("#ProcesoInmueblesPrecioUnidad").val( response['cotizacion']['Cotizacion']['precio_final'] );
                $("#ProcesoInmueblesPrecioUnidadHiden").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( response['cotizacion']['Cotizacion']['precio_final'] ) );
                $('#ProcesoInmueblesPrecioUnidadHiden').attr('readonly', true);
                
                


                $("#ProcesoInmueblesMontoReserva").val( response['cotizacion']['Cotizacion']['monto_apartado'] );
                $("#ProcesoInmueblesMontoReservaHiden").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( response['cotizacion']['Cotizacion']['monto_apartado'] ) );
                $('#ProcesoInmueblesMontoReservaHiden').attr('readonly', true);

                // Agregar el id de la cotizacion.
                $("#ProcesoInmueblesCotizacionId").val( response['cotizacion']['Cotizacion']['id'] );
                

            },
            error: function ( response ) {
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Error';
                console.log( response.responseText );
            }
        });
        
    }

    function carga_monto_venta(){

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "cotizacions", "action" => "data_operacions")); ?>',
            cache: false,
            data: { cliente_id: $("#ProcesoInmueblesVentaClienteId").val() },
            dataType: 'json',
            success: function ( response ) {
                // console.log( response );
                
                // Agregamos el precio para los campos de venta.
                $("#ProcesoInmueblesVentaPrecioLista").val( response['cotizacion']['Cotizacion']['precio_final'] );

                // El campo de monto de la venta se deshabilita y se pone con signo de precios.
                $("#ProcesoInmueblesVentaMontoVenta").val( response['cotizacion']['Cotizacion']['monto_contrato'] );
                document.getElementById('ProcesoInmueblesVentaMontoVenta2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['cotizacion']['Cotizacion']['monto_contrato']);
                $('#ProcesoInmueblesVentaMontoVenta2').attr('readonly', true);


                $("#ProcesoInmueblesVentaPrecioUnidad").val( response['cotizacion']['Cotizacion']['precio_final'] );

                document.getElementById('ProcesoInmueblesVentaPrecioUnidad2').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['cotizacion']['Cotizacion']['precio_final']);
                $('#ProcesoInmueblesVentaPrecioUnidad2').attr('readonly', true);


                // Meses de aplazado
                document.getElementById('ProcesoInmueblesVentaMontoFinanciamiento').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['cotizacion']['Cotizacion']['monto_financiamiento']);
                $('#ProcesoInmueblesVentaMontoFinanciamiento').attr('readonly', true);

                $("#ProcesoInmueblesVentaPlazosFinancimiento").val( response['cotizacion']['Cotizacion']['meses'] );
                $('#ProcesoInmueblesVentaPlazosFinancimiento').attr('readonly', true);

                document.getElementById('ProcesoInmueblesVentaMontoPlazos').value = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(response['cotizacion']['Cotizacion']['monto_mensual']);
                $('#ProcesoInmueblesVentaMontoPlazos').attr('readonly', true);


                // Agregar el id de la cotizacion.
                $("#ProcesoInmueblesVentaCotizacionId").val( response['cotizacion']['Cotizacion']['id'] );
                
                // Traer la fecha de escrituracion del desarrollo.
                $("#ProcesoInmueblesVentaVigenciaVenta").val( response['desarrollo']['Desarrollos']['fecha_inicio_escrituracion'] );
                $('#ProcesoInmueblesVentaVigenciaVenta').attr('readonly', true);
                

            },
            error: function ( response ) {
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Error';
            }
        });

    }

    function validacionDocumentoApartado(){
        if( $("#ProcesoInmueblesApartadoTipoDocumento").val()  == '' ){
            document.getElementById("add_documento").disabled = true;
        }else{
            document.getElementById("add_documento").disabled = false;
        }
    }

    function validacionDocumentoVenta(){
        if( $("#ProcesoInmueblesVentaTipoDocumento").val()  == null || $("#ProcesoInmueblesVentaTipoDocumento").val()  == '' ){
            document.getElementById("add_documento_venta").disabled = true;
        }else{
            document.getElementById("add_documento_venta").disabled = false;
        }

        // console.log( $("#ProcesoInmueblesVentaTipoDocumento").val() );
    }

    // Document Ready
    $( document ).ready(function() {

        $(".hide_search").chosen({disable_search_threshold: 10});
        $(".chzn-select").chosen({allow_single_deselect: true});
        $(".chzn-select-deselect,#select2_sample").chosen();

        $('.fechaReserva').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation:"bottom"
        });

        $('.fechaVenta').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation:"bottom"
        });

        validacionDocumentoApartado();
        validacionDocumentoVenta();

    });



</script>
