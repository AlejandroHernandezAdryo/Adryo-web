<div class="modal fade" id="newCottizacion" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <?= $this->Form->create('Cotizacion',array('url'=>array('action'=>'add','controller'=>'cotizacions')))?>
            <div class="modal-content">
                <div class="modal-header bg-blue-is">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel1">
                        <i class="fa fa-money"></i>
                        Crear Cotización
                    </h4>
                </div>
                
                <div class="modal-body" style="overflow-y: scroll;">

                    <div class="row">
                        
                        <!-- Propiedad, Precio de lista, % de descuento, $ de descuento -->
                        <div class="col-sm-12 col-lg-6">
                            <div class="row">
                                <div class="col-sm-12 col-lg-4">
                                    PROPIEDAD:
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <span id="propiedad_label"></span>
                                    <?= $this->Form->hidden('propiedad_label') ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-lg-4">
                                    <label>Plan de Pago </label>
                                </div>
                                <div class="col-sm-12 col-lg-8">
                                    <?= $this->Form->input('plan_pago',
                                        array(
                                            'class'   => 'form-control',
                                            'label'   => false,
                                            'div'     => false,
                                            'type'    => 'select',
                                            'empty'   => 'Cotización manual',
                                            'onchange'=>'javascript:getPlan()'
                                        )
                                    ); ?>
                                </div>
                            </div>

                            <div class="row" id="inputDescuentoPorcentaje">
                                <?= $this->Form->hidden('descuento_hiden', array('id' => 'descuento')) ?>
                                <div class="col-sm-12 col-lg-4">
                                    <label for="descuento" id="label-descuento">DESCUENTO</label>
                                </div>

                                <div class="col-sm-12 col-lg-4">
                                    <div class="input-group">

                                        <?= $this->Form->input('descuento',
                                            array(
                                                'class' => 'form-control',
                                                'label' => false,
                                                'div'   => false,
                                                // 'style'        => 'border-right-style: none !important;',
                                                'id'           => 'descuento_fake',
                                                // 'oninput'      => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",
                                                'autocomplete' => 'off',
                                                'type'         => 'text',
                                                'onchange'     => 'javascript:recalcular()'
                                            )
                                        ); ?>
                                    </div>
                                </div>

                                <div class="col-sm-12 col-lg-4">
                                    <?= $this->Form->input('tipo_descuento',array('onchange'=>'javascript:setTipoDescuento()','type'=>'select','options'=>array(1=>'Monto Fijo',2=>'Porcentaje'),'label'=>false, 'class' => 'form-control', 'value' => '2' ))?>
                                </div>
                                
                            </div>

                            <div class="row hidden" id="inputDescuentoMonto">
                                <div class="col-sm-12 col-lg-4">
                                <label for="descuento" id="label-descuento-q"> $ DESCUENTO</label>
                                </div>

                                <div class="col-sm-12 col-lg-8">
                                    <div class="input-group">

                                        <?= $this->Form->input('descuento_q',
                                            array(
                                                'class'        => 'form-control',
                                                'label'        => false,
                                                'div'          => false,
                                                'style'        => 'border-right-style: none !important;',
                                                'oninput'      => "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');",
                                                'autocomplete' => 'off',
                                                'type'         => 'text'
                                            )
                                        ); ?>
                                        <span class="input-group-addon"  style=" background: transparent; border-left-style: none !important; cursor: pointer;" onclick="cambio_input()">
                                            <input type="checkbox" id="view_password" style="display: none;">
                                            <i class="fa fa fa-usd"></i>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        
                        <!-- Precio con descuento, Adicionales Extras, Precio de Venta -->
                        <div class="col-sm-12 col-lg-6">

                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Precio de lista:
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <span id="precio_venta"></span>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Precio c/descuento:
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <!-- roberto  -->
                                    <span id="precio_descuento_venta"> $0.00</span>
                                    <?= $this->Form->hidden('precio_con_descuento') ?>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Adicionales / Extras:
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <span id="precio_extras">$0.00</span>
                                    <?= $this->Form->hidden('precio_extras') ?>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-lg-8">
                                    Precio de Venta:
                                </div>
                                <div class="col-sm-12 col-lg-4">
                                    <span id="precio_final_venta_label">$0.00</span>
                                    <?= $this->Form->hidden('precio_de_venta') ?>
                                </div>
                            </div>

                        </div>
                        
                    </div>

                    <!-- Tabla de extras de cotización. -->
                    <div class="row">
                        <div class="col-sm-12 mt-3">
                            <h3 class="text-sm-center text-black">
                                <b>AGREGAR EXTRAS A LA COTIZACIÓN</b>
                            </h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-1">
                            <table class="table table-sm" id ="test">
                                <thead>
                                    <tr>
                                        <th>Adicional</th>
                                        <th>Precio de Venta</th>
                                        <th>Agregar de Cotización</th>
                                        <th>Eliminar de Cotización</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php for( $i = 0; $i < 10; $i++ ): ?>
                                        <tr id="row<?= $i?>" <?= (($i != 0) ? 'style="display: none;"' : '' ) ?>>
                                            <td>
                                                <?= $this->Form->input('extra'.$i,array('id'=>'extra_id'.$i,'empty'=>'Sin Adicional','label'=>false,'type'=>'select','onchange'=>'getExtra('.$i.')', 'class' => 'form-control' ))?>
                                            </td>
                                            <td>
                                                <?= $this->Form->input('precio_cotizado'.$i,array('label'=>false,'type'=>'text','onchange'=>'javascript:validaTotal()', 'class' => 'form-control'))?>
                                            </td>
                                            <td style="text-align:center">
                                                    <?= $this->Html->link("<i class='fa fa-plus'></i>","javascript:addRow(".$i.")",array('escape'=>false))?>
                                            </td>
                                            <td style="text-align:center">
                                                <?php if( $i != 0 ): ?>
                                                    <?= $this->Html->link("<i class='fa fa-times'></i>","javascript:deleteRow(".$i.")",array('escape'=>false))?>
                                                <?php endif; ?>
                                            </td>
                                            <?= $this->Form->hidden('active_row'.$i,array('id'=>'row_active'.$i,'value'=>0)) ?>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 mt-2">
                            <h3 class="text-sm-center text-black">
                                <b>Plan de pagos</b>
                            </h3>
                        </div>
                    </div>

                    <!-- Input's Plan de pagos y vigencia -->
                    <div class="row form-group">

                        <?= $this->Form->input('fecha_escrituracion',
                            array(
                                'class'    => 'form-control',
                                'div'      => 'col-sm-12 col-lg-6',
                                'label'    => 'Fecha Est. de entrega / escrituración:',
                                'disabled' => true
                            )
                        );?>

                        <div class="col-sm-12 col-lg-6">
                            <label for="vigencia_plan_pagos">
                                Vigencia de la cotización en días <span class="pointer anchor" onclick="datePlusCotizacion(5)">(5)</span> <span class="pointer anchor" onclick="datePlusCotizacion(10)">(10)</span> <span class="pointer anchor" onclick="datePlusCotizacion(15)">(15)</span> <span class="pointer anchor" onclick="datePlusCotizacion(0)">(manual)</span>
                            </label>
                            <?= $this->Form->input('vigencia',
                                array(
                                    'class'        => 'form-control',
                                    'label'        => false,
                                    'div'          => false,
                                    'type'         => 'text',
                                    'autocomplete' => 'off',
                                    'required'     => true,

                                )
                            ); ?>
                        </div>

                    </div>
                    
                    <!-- Porcentajes -->
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 offset-lg-3 text-sm-center">
                            <label for="">!El valor de los campos debe sumar el 100% ¡</label>
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <div class="row">
                                <?= $this->Form->input('apartado', array(
                                        'label' => 'Apartado / reserva (%)',
                                        'div'   => 'col-sm-12',
                                        'class' => 'form-control',
                                        'type'         => 'number',
                                        'max'=>'100',
                                        'autocomplete' => 'off',
                                        'onchange'=>"javascript:()"
                                    )
                                ); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-9 bg-blue-is">
                            <div class="row">
                                <?= $this->Form->input('contrato', array(
                                        'label' => 'Contrato (%)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionContrato','CotizacionContratoadoQ')",
                                        'type' => 'text'
                                    )
                                ); ?>

                                <?= $this->Form->input('financiamiento', array(
                                        'label' => 'Financiamiento (%)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionFinanciamiento','CotizacionFinanciamientoQ')",
                                        'type' => 'text'
                                    )
                                ); ?>

                                <?= $this->Form->input('escrituracion', array(
                                        'label' => 'Escrituración (%)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionEscrituracion','CotizacionEscrituracionQ')",
                                        'type' => 'text'
                                    )
                                ); ?>

                                <?= $this->Form->input('total', array(
                                        'label' => 'Total (%)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'readonly'=>'readonly'
                                    )
                                ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Montos -->
                    <div class="row mt-2">
                        <div class="col-sm-12 col-lg-9 offset-lg-3 text-sm-center">
                            <label for="">!El valor de los campos debe dar el total del <b>Precio de venta</b> ¡</label>
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <div class="row">
                                <?= $this->Form->input('apartado_q', array(
                                        'label' => 'Apartado / reserva ($)',
                                        'div'   => 'col-sm-12',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionApartadoQ','CotizacionApartado')"
                                    )
                                ); ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-9 bg-blue-is">
                            <div class="row">
                                <?= $this->Form->input('contratoado_q', array(
                                        'label' => 'Contrato ($)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionContratoadoQ','CotizacionContrato')"
                                    )
                                ); ?>

                                <?= $this->Form->input('financiamiento_q', array(
                                        'label' => 'Financiamiento ($)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionFinanciamientoQ','CotizacionFinanciamiento')"
                                    )
                                ); ?>

                                <?= $this->Form->input('escrituracion_q', array(
                                        'label' => 'Escrituración ($)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'onchange'=>"javascript:bloquearComplemento('CotizacionEscrituracionQ','CotizacionEscrituracion')"
                                    )
                                ); ?>

                                <?= $this->Form->input('total_q', array(
                                        'label' => 'Total ($)',
                                        'div'   => 'col-sm-12 col-lg-3',
                                        'class' => 'form-control',
                                        'readonly'=>true
                                    )
                                ); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha para calcular las mensualidades. -->
                    <div class="row">
                        <div class="col-sm-12 col-lg-6 mt-2">
                            <label for=""> <h3 class="text-black">Meses de aplazado del financiamiento / diferido</h3> </label>
                        </div>
                        <?= $this->Form->input('meses_diferido',
                            array(
                                'div'      => 'col-sm-12 col-lg-2 mt-2',
                                'label'    => false,
                                'class'    => 'form-control',
                                'readonly' => false,
                                'type'     => 'select',
                                'onchange' => 'CambioMeses()',
                            )
                        );?>
                        <div class="col-sm-12 col-lg-2 mt-2">
                            <label> <h3 class="text-black">Total mensual</h3> </label>
                        </div>
                        <?= $this->Form->input('monto_diferido_mensual_fake',
                            array(
                                'div'      => 'col-sm-12 col-lg-2 mt-2',
                                'label'    => false,
                                'class'    => 'form-control',
                                'readonly' => true
                            )
                        );?>
                        <?= $this->Form->hidden('monto_diferido_mensual') ?>
                    </div>


                    <!-- Observaciones -->
                    <div class="row form-group">
                        <?= $this->Form->input('observaciones',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Observaciones Públicas',
                                'div'     => 'col-sm-12 col-lg-12',
                                'type'    => 'text',
                            )
                        ); ?>
                        
                        <?= $this->Form->input('observaciones_internas',
                            array(
                                'class'    => 'form-control',
                                'label'    => 'Observaciones Internas',
                                'div'      => 'col-sm-12 col-lg-12',
                                'type'     => 'textarea',
                                'disabled' => true,
                                'rows'     => 2
                            )
                        ); ?>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right" id="registrar">
                        Registrar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        <?= $this->Form->hidden('precio_lista')?>
        <?= $this->Form->hidden('cliente_id')?>
        <?= $this->Form->hidden('inmueble_id')?>
        <?= $this->Form->hidden('contrato_p')?>
        <?= $this->Form->hidden('financiamiento_p')?>
        <?= $this->Form->hidden('escrituracion_p')?>
        <?= $this->Form->end()?>
    </div>
</div>
<script src="http://momentjs.com/downloads/moment.min.js"></script>
<script>

    /**
     * Esta funcion hace el calculo de los meses seleccionados / el monto de financiamiento.
     * AKA Korner 30-Mar-2023
    */
    function CambioMeses(){
        var totalMensual = Number($("#CotizacionFinanciamientoQ").val()) / Number($("#CotizacionMesesDiferido").val());
        $("#CotizacionMontoDiferidoMensualFake").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( totalMensual ) );
        $("#CotizacionMontoDiferidoMensual").val( totalMensual );

    }

    $('#CotizacionVigencia').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });

    // Funcion para abril modal
    function addCotizacion(inmueble_id,referencia, precio, clienteId){
        // Limpiar todos los campos select antes de cargar el modal
        $('#CotizacionPlanPago').empty().append('<option selected="selected" value="">Cotización Manual</option>');
        $('.chzn-select').trigger('chosen:updated');

        cleanInputs();

        $("#newCottizacion").modal("show");
        $("#CotizacionInmuebleId").val( inmueble_id );

        // 1.- Se agrega la referencia en el span de propiedad_label
        $("#propiedad_label").html( referencia );
        $("#CotizacionPropiedadLabel").val( referencia );

        // 2.- Precio original de venta de la propiedad
        $("#precio_venta").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( precio ) );
        $("#CotizacionPrecioLista").val( precio ); // Input precio de venta.


        // 3.- Se buscan los planes para las opciones de seleccion de planes.
        planesOptions(inmueble_id);

        // Mostrar la fecha de escrituracion.
        $.ajax({
            type: "GET",
            url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "get_inmueble_desarrollo_detalle")); ?>/'+inmueble_id,
            cache: false,
            dataType: 'Json',
            success: function( response ) {
                
                $("#CotizacionFechaEscrituracion").val( response.fecha_format );
                var fecha1 = moment(response.fecha);
                var fecha2 = moment(response.fecha_current);
                var resta = fecha1.diff(fecha2, 'month');
                var menosuno = (resta );

                if( resta > 0 ){
                    for (var i = resta; i > 0; i--) {
                        $('<option>').val('').text('select');
                        $('<option>').val(i).text(i).appendTo($("#CotizacionMesesDiferido"));
                    }

                }else{
                    $('<option>').val('').text('select');
                    $('<option>').val(1).text(1).appendTo($("#CotizacionMesesDiferido"));
                }

                

            }
        });

        $("#CotizacionClienteId").val( clienteId ); // Input precio de venta.

    }

    // Funciones para la tabla de extras
    function addRow(row){
        document.getElementById('row'+(row+1)).style.display='';
        document.getElementById('row_active'+(row+1)).value=1;
        $('row_active'+(row+1)).addClass('form-control');
        $('row'+(row+1)).addClass('form-control');
        validaTotal();
    }

    function deleteRow(row){
        document.getElementById('row'+(row)).style.display='none';
        document.getElementById('row_active'+(row)).value=0;
        
        var extras = sumarExtras();
        document.getElementById('precio_extras').innerHTML = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(extras);

        validaTotal();
    }

    function getExtra(row){
        var extra_id = document.getElementById('extra_id'+row).value;
        if (extra_id){
            var dataString = 'id_extra='+ extra_id;
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "getExtra")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    document.getElementById('CotizacionPrecioCotizado'+row).value=html.ExtrasDesarrollo.precio_venta;
                    var extras = sumarExtras();
                    document.getElementById('precio_extras').innerHTML = new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(extras);
                    
                    // precio_extras
                    if(document.getElementById('CotizacionPlanPago').value==""){
                        recalcular();
                    }else{
                        validaTotal();
                    }

                }
            });
        }
    }

    function sumarExtras(){
        var extras = 0;
        document.getElementById('precio_extras').innerHTML = "";
        document.getElementById('CotizacionPrecioExtras').value = 0;

        for(i=0; i<10 ; i++){
            if(document.getElementById('row_active'+i).value == 1 && document.getElementById('extra_id'+i).value!=""){
                extras += Number(document.getElementById('CotizacionPrecioCotizado'+i).value);
            }
        }
        
        document.getElementById('CotizacionPrecioExtras').value = extras;
        return extras;
    }

    // Metodos para agregar dias en el calendario.
    function datePlusCotizacion( days ){

        if( days == 0 ){
            document.getElementById("CotizacionVigencia").focus();
        }

        var tmpDate  = new Date();
        var new_date = addDaysToDate(tmpDate, days);
        var mes      = Number(new Date(new_date).getMonth());

        mes             = Number(new Date(new_date).getMonth());
        document.getElementById('CotizacionVigencia').value = new Date(new_date).getDate() + "-" + (mes+1) + '-' + new Date(new_date).getFullYear();
        //roberto
        $("#registrar").prop('disabled', false);
    }

    function addDaysToDate(date, days){
        var resultado = new Date(date);
        resultado.setDate(resultado.getDate() + days);
        return resultado;
    }

    // Metodo para llenar el selec de las opciones de planes de pago.
    function planesOptions( inmuebleId ){
        if (inmuebleId){
            $.ajax({
                url     : '<?php echo Router::url(array("controller" => "planes_desarrollos", "action" => "getPlanes")); ?>',
                type    : "POST",
                data    : { 'inmueble_id': inmuebleId },
                cache   : false,
                dataType: 'json',
                success : function(response) {

                    //Rellenar planes de pago
                    $.each(response.planes, function(key, value) {
                        $('<option>').val('').text('select');
                        $('<option>').val(key).text(value).appendTo($("#CotizacionPlanPago"));
                    });
                    
                    //Rellenar extras
                    for (var i = 0; i < 10; i++) {
                        $.each(response.extras, function (key, value) {
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#extra_id"+i));
                        });
                    }

                    // Se agrega una nueva fila en la tabla de extras
                    document.getElementById('row0').style.display = '';
                    document.getElementById('row_active0').value  = 1;

                }
            });
        }
    }

    // Llenado de los campos con las variables del plan de pago.
    // Condicionado, que si el valor seleccionado es manual;
    // Debe deshabilittar los campos.
    function getPlan(){
        var plan_id                 = document.getElementById('CotizacionPlanPago').value;

        if ( plan_id ){
            $.ajax({
                type   : "POST",
                url    : '<?php echo Router::url(array("controller" => "planes_desarrollos", "action" => "getPlan")); ?>',
                data   : { 'plan_id': plan_id },
                cache  : false,
                success: function( response ) {

                    var plan = response['PlanesDesarrollo'];
                    
                    // Vamos llenando los datos
                    $("#CotizacionApartado").val( plan.apartado );
                    $("#CotizacionApartadoQ").val( plan.apartado_q );
                    $("#CotizacionContrato").val( plan.contrato );
                    //roberto
                    $("#descuento").val( plan.descuento );
                    $("#descuento_fake").val( plan.descuento );

                    $("#CotizacionDescuentoQ").val( plan.descuento_q );
                    $("#CotizacionEscrituracion").val( plan.escrituracion );
                    $("#CotizacionFinanciamiento").val( plan.financiamiento );
                    $("#CotizacionObservacionesInternas").val( plan.observaciones_internas );
                    $("#CotizacionObservaciones").val( plan.observaciones_publicas );

                    // Bloquear los campos si se selecciona un plan de pagos
                    document.getElementById('CotizacionTipoDescuento').setAttribute("disabled", "disabled");
                    
                    $('#descuento').attr('readonly', true);
                    $('#descuento_fake').attr('readonly', true);
                    $('#CotizacionDescuentoQ').attr('readonly', true);
                    $('#CotizacionApartado').attr('readonly', true);
                    $('#CotizacionApartadoQ').attr('readonly', true);
                    $('#CotizacionContrato').attr('readonly', true);
                    $('#CotizacionFinanciamiento').attr('readonly', true);
                    $('#CotizacionEscrituracion').attr('readonly', true);
                    $('#CotizacionObservaciones').attr('readonly', true);
                    $('#CotizacionObservacionesInternas').attr('readonly', true);
                    $('#CotizacionTotal').attr('readonly', true);
                    $('#CotizacionContratoadoQ').attr('readonly', true);
                    $('#CotizacionFinanciamientoQ').attr('readonly', true);
                    $('#CotizacionEscrituracionQ').attr('readonly', true);
                    $('#CotizacionTotalQ').attr('readonly', true);

                    $("#inputDescuentoPorcentaje").removeClass('hidden');
                    $("#inputDescuentoMonto").removeClass('hidden');

                    validacionAutomatica();

                }
            });
        }else{
            
            $("#descuento").val(0);
            $("#descuento_fake").val(0);
            $("#CotizacionDescuentoQ").val(0);
            $("#CotizacionApartado").val(0);
            $("#CotizacionApartadoQ").val(0);
            $("#CotizacionContrato").val(0);
            $("#CotizacionFinanciamiento").val(0);
            $("#CotizacionEscrituracion").val(0);
            $("#CotizacionTotal").val(0);
            $("#CotizacionContratoadoQ").val(0);
            $("#CotizacionFinanciamientoQ").val(0);
            $("#CotizacionEscrituracionQ").val(0);
            $("#CotizacionTotalQ").val(0);
            $("#CotizacionMontoDiferidoMensualFake").val(0);
            $("#CotizacionMontoDiferidoMensual").val(0);
            

            $("#CotizacionObservaciones").val('');
            $("#CotizacionObservacionesInternas").val('');
            
            $('#descuento').attr('readonly', false);
            $('#descuento_fake').attr('readonly', false);
            $('#CotizacionDescuentoQ').attr('readonly', false);
            $('#CotizacionApartado').attr('readonly', false);
            $('#CotizacionApartadoQ').attr('readonly', false);
            $('#CotizacionContrato').attr('readonly', false);
            $('#CotizacionFinanciamiento').attr('readonly', false);
            $('#CotizacionEscrituracion').attr('readonly', false);
            $('#CotizacionObservaciones').attr('readonly', false);
            $('#CotizacionObservacionesInternas').attr('readonly', false);
            $('#CotizacionTotal').attr('readonly', false);
            $('#CotizacionContratoadoQ').attr('readonly', false);
            $('#CotizacionFinanciamientoQ').attr('readonly', false);
            $('#CotizacionEscrituracionQ').attr('readonly', false);
            $('#CotizacionTotalQ').attr('readonly', false);

            document.getElementById('CotizacionTipoDescuento').removeAttribute("disabled");

            $("#CotizacionContratoadoQ").removeClass('disabled');
            $("#CotizacionFinanciamientoQ").removeClass('disabled');
            $("#CotizacionEscrituracionQ").removeClass('disabled');
            $("#CotizacionTotalQ").removeClass('disabled');

            $("#inputDescuentoMonto").addClass('hidden');
            
        }
    }

    // Calculo de los campos de forma automatica si se selecciona un plan de pagos.
    function validacionAutomatica(){
        // Proceso completo de calculos
            // 1.- Calculamos el precio con descuento.
            //     1.1.- Validamos que tipo de descuento es, en porcentaje o monto.
            //     1.2.- Calcularemos el monto del descuento.
            // 2.- Traer los valores para hacer los calculos.
            // 3.- Sumar los costos de los extras al monto total de la venta.
            // 4.- Sumar descuento + extras.
            // 5.- Sumar el % de los campos de contrato, financiamiento, escrituracion.
            // 6.- Calculamos el monto y el total de contrato, financiamiento, escriturracion y total
            // 7.- Calcular el monto y las mensualidades

        
        // Inicializacion de las variables.
            var precioDeLista      = $("#CotizacionPrecioLista").val();
            var precioConDescuento = 0;
            var totalExtras        = 0;
            var precioDeVenta      = 0;

            var contrato       = 0;
            var financiamiento = 0;
            var escrituracion  = 0;
            var totalPorcent   = 0;

            var contratoQ       = 0;
            var financiamientoQ = 0;
            var escrituracionQ  = 0;
            var totalQ   = 0;

        // Condicion de Descuento en monto o en porcentaje.

            if( $("#descuento").val() ){
                // Calculamos el monto del descuento.
                precioDescuento = Number( precioDeLista * Number($("#descuento").val() / 100));
                $("#CotizacionDescuentoQ").val( precioDescuento.toFixed(1) );

                
            }else{
                // descuentoQ*100/percioLista
                var descuentoFake = 0;
                precioDescuento = Number( Number($("#CotizacionDescuentoQ").val() * 100 / precioDeLista ));
                descuentoFake = precioDescuento.toFixed(1);

                $("#descuento").val( precioDescuento );
                $("#descuento_fake").val( descuentoFake );


            }

        // Llenamos el campo de precio con descuento.
            precioConDescuento = Number( precioDeLista ) - Number($("#CotizacionDescuentoQ").val());
            $("#precio_descuento_venta").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( precioConDescuento ) );
            $("#CotizacionPrecioConDescuento").val( precioConDescuento );

        // step 3
            totalExtras = Number(getTotalExtras());

        // Step 4
            precioDeVenta = precioConDescuento + totalExtras;
            $("#precio_final_venta_label").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( precioDeVenta ) );
            $("#CotizacionPrecioDeVenta").val( precioDeVenta );

        // Step 5
            contrato       = Number($("#CotizacionContrato").val());
            financiamiento = Number($("#CotizacionFinanciamiento").val());
            escrituracion  = Number($("#CotizacionEscrituracion").val());

            totalPorcent = contrato + financiamiento + escrituracion;
            $("#CotizacionTotal").val(  totalPorcent );
        // Step 6

            var contratoQ       = Number(precioDeVenta * Number(contrato / 100));
            var financiamientoQ = Number(precioDeVenta * Number(financiamiento / 100));
            var escrituracionQ  = Number(precioDeVenta * Number(escrituracion / 100));

            var contratoQFixed = contratoQ.toFixed(1);
            var financiamientoQFixed = financiamientoQ.toFixed(1);
            var escrituracionQFixed = escrituracionQ.toFixed(1);

            $("#CotizacionContratoadoQ").val( contratoQFixed );
            $("#CotizacionFinanciamientoQ").val( financiamientoQFixed );

            $("#CotizacionContratoP").val( contratoQ );
            $("#CotizacionFinanciamientoP").val( financiamientoQ );
            $("#CotizacionEscrituracionQ").val( escrituracionQ );
            
            var totalQ          = (contratoQ + financiamientoQ + escrituracionQ);
            $("#CotizacionTotalQ").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( totalQ )  );

        // Step 7
            var totalMensual = financiamientoQ / Number($("#CotizacionMesesDiferido").val());
            $("#CotizacionMontoDiferidoMensualFake").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( totalMensual ) );
            $("#CotizacionMontoDiferidoMensual").val( totalMensual );

        // Step 8
            var apartadoQ = 0;
            var apartado  = 0;
            
            if( $('#CotizacionApartado').val() > 0 ){
                apartadoQ       = Number(precioDeVenta * Number($('#CotizacionApartado').val() / 100));
                $("#CotizacionApartadoQ").val( apartadoQ.toFixed(1) );
            }else{
                apartado       = Number( Number($('#CotizacionApartadoQ').val()) * 100 / precioDeLista );
                apartado = apartado.toFixed(1);
                $("#CotizacionApartado").val( apartado );
            }
        // Fin de los pasos
    
    }

    // Calculos de los campos de forrma manual, en caso de que se seleccione cottizacion manual.
    // Cambio de input para el descuento.
    function cambioDescuento( campo ){
        
        
        if( campo == 1){
            // Escogemos descuento en %
            $("#CotizacionDescuentoQ").addClass('disabled');
            $("#descuento").removeClass('disabled');

            $("#label-descuento-q").removeClass('text-primary');
            $("#label-descuento").addClass('text-primary');

            document.getElementById("descuento").focus();


        }else{
            // Escogemos descuento en $
            $("#CotizacionDescuentoQ").removeClass('disabled');
            $("#descuento").addClass('disabled');
            
            $("#label-descuento-q").addClass('text-primary');
            $("#label-descuento").removeClass('text-primary');
            
            document.getElementById("CotizacionDescuentoQ").focus();


        }

    }

    function validaTotal(){
        if(document.getElementById('CotizacionPlanPago').value !=""){
            validacionAutomatica();
            getTotalExtras();
        }else{
            recalcular();
        }
    }

    function setTipoDescuento(){
        if (document.getElementById('CotizacionTipoDescuento').value == 1){ //Tipo de descuento Monto Fijo
            document.getElementById('descuento_fake').setAttribute('max',document.getElementById('CotizacionPrecioLista').value);
        }else{ //Tipo de descuento
            document.getElementById('descuento_fake').setAttribute('max',100);
        }
        recalcular();
    }

    function recalcular(){
        var precioConDescuento = 0;

        if (document.getElementById('CotizacionTipoDescuento').value == 1) { //Tipo de descuento Monto Fijo
            precioConDescuento = document.getElementById('CotizacionPrecioLista').value - document.getElementById('descuento_fake').value;
        }else{
            precioConDescuento = document.getElementById('CotizacionPrecioLista').value * (1-(document.getElementById('descuento_fake').value/100));
        }

        $("#precio_descuento_venta").html(new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN"
        }).format(precioConDescuento));
        $("#CotizacionPrecioConDescuento").val(precioConDescuento);

        totalExtras = Number(getTotalExtras());
        // Step 4
        precioDeVenta = precioConDescuento + totalExtras;

        $("#precio_final_venta_label").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( precioDeVenta ) );
        $("#CotizacionPrecioDeVenta").val( precioDeVenta );
    }

    function getTotalExtras(){
        var total = 0;
        for(i=0; i<10 ;i++){
            if(document.getElementById('row_active'+i).value ==1){
                total = total + Number(document.getElementById('CotizacionPrecioCotizado'+i).value);
            }
        }
        document.getElementById('CotizacionPrecioExtras').value = total;
        $("#precio_extras").html( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format( total ) );
        return total;
    }

    function bloquearComplemento(input1, input2){

        calcularMontosManual(input1,input2);

        if (document.getElementById(input1).value==""){
            document.getElementById(input2).removeAttribute('readonly');
        }else{
            document.getElementById(input2).setAttribute('readonly','readonly');
        }


        // Calculo del 100% de los campos
        var contrato        = 0;
        var financiamiento  = 0;
        var escrituracion   = 0;
        var totalPorcentaje = 0;
        var totalQ          = 0;

        
        
        contrato        = Number($("#CotizacionContrato").val());
        financiamiento  = Number($("#CotizacionFinanciamiento").val());
        escrituracion   = Number($("#CotizacionEscrituracion").val());
        totalPorcentaje = contrato + financiamiento + escrituracion;

        if (totalPorcentaje == 99.9 || totalPorcentaje == 99.99) {
            $("#CotizacionTotal").val( 100 );
        }else{

            $("#CotizacionTotal").val( totalPorcentaje );
        }
        // $("#CotizacionTotal").val( totalPorcentaje );

        // Calculo del total mensual
        var calTotalMensual = Number($("#CotizacionFinanciamientoQ").val()) / Number( $("#CotizacionMesesDiferido").val() );
        $("#CotizacionMontoDiferidoMensualFake").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(calTotalMensual) );
        $("#CotizacionMontoDiferidoMensual").val(calTotalMensual);

        // Calcular total del monto
        var totalQ = Number($("#CotizacionContratoadoQ").val()) + Number($("#CotizacionFinanciamientoQ").val()) + Number($("#CotizacionEscrituracionQ").val());
        $("#CotizacionTotalQ").val( new Intl.NumberFormat("es-MX", {style: "currency", currency: "MXN"}).format(totalQ) );


        $('#CotizacionTotal').attr('readonly', true);
        $('#CotizacionTotalQ').attr('readonly', true);

        // Bloquear el boton de enviar si no es el 100% o el monto total del precio de venta.

        if( totalPorcentaje != 100  ){
            $("#registrar").prop('disabled', true);
        }else{
            $("#registrar").prop('disabled', false);
        }
        

    }

    function calcularMontosManual(input1,input2){
        
        if (document.getElementById(input1).value == 0){
            
            document.getElementById(input2).value = 0;

        }else if(document.getElementById(input1).value <= 100){ //El valor está en porcentaje
            var calculo1 = (Number(document.getElementById(input1).value)/100) * Number(document.getElementById('CotizacionPrecioDeVenta').value);
            document.getElementById(input2).value = calculo1.toFixed(1);

        }else{ //El valor está en monto
            var calculo2 = ((Number(document.getElementById(input1).value)/ Number(document.getElementById('CotizacionPrecioDeVenta').value))*100);
            document.getElementById(input2).value= calculo2.toFixed(1);
            
            // hacer case en caso de que el calculo sea de contrato, financiamiento o escrituracion, en este caso manda el monto sin hacer fixed de los montos.
            switch ( input1 ){
                case 'CotizacionContratoadoQ':
                    document.getElementById('CotizacionContratoP').value= calculo2;
                    break;
                case 'CotizacionFinanciamientoQ':
                    document.getElementById('CotizacionFinanciamientoP').value= calculo2;
                    break;
                case 'CotizacionEscrituracionQ':
                    document.getElementById('CotizacionEscrituracionP').value= calculo2;
                    break;
            }
        }
        


    }

    // Mostrar la pantalla de carga al guardar una cotizacio.
    $(document).on("submit", "#CotizacionAddForm", function (event) {
        event.preventDefault();
        $.ajax({
            url        : '<?php echo Router::url(array('action'=>'add','controller'=>'cotizacions')); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#newCottizacion").modal('hide');
                $("#overlay").fadeIn();
            },
            success: function (response) {
                location.reload();
            },
            error: function ( response ) {
                console.log( response.responseText );
            },
        });
    });

    function cleanInputs(){

        $("#descuento").val(0);
        $("#descuento_fake").val(0);
        $("#CotizacionDescuentoQ").val(0);
        $("#CotizacionApartado").val(0);
        $("#CotizacionApartadoQ").val(0);
        $("#CotizacionContrato").val(0);
        $("#CotizacionFinanciamiento").val(0);
        $("#CotizacionEscrituracion").val(0);
        $("#CotizacionTotal").val(0);
        $("#CotizacionContratoadoQ").val(0);
        $("#CotizacionFinanciamientoQ").val(0);
        $("#CotizacionEscrituracionQ").val(0);
        $("#CotizacionTotalQ").val(0);
        $("#CotizacionMontoDiferidoMensualFake").val(0);
        $("#CotizacionMontoDiferidoMensual").val(0);


        $("#CotizacionObservaciones").val('');
        $("#CotizacionObservacionesInternas").val('');

        $('#descuento').attr('readonly', false);
        $('#descuento_fake').attr('readonly', false);
        $('#CotizacionDescuentoQ').attr('readonly', false);
        $('#CotizacionApartado').attr('readonly', false);
        $('#CotizacionApartadoQ').attr('readonly', false);
        $('#CotizacionContrato').attr('readonly', false);
        $('#CotizacionFinanciamiento').attr('readonly', false);
        $('#CotizacionEscrituracion').attr('readonly', false);
        $('#CotizacionObservaciones').attr('readonly', false);
        $('#CotizacionObservacionesInternas').attr('readonly', false);
        $('#CotizacionTotal').attr('readonly', false);
        $('#CotizacionContratoadoQ').attr('readonly', false);
        $('#CotizacionFinanciamientoQ').attr('readonly', false);
        $('#CotizacionEscrituracionQ').attr('readonly', false);
        $('#CotizacionTotalQ').attr('readonly', false);

        document.getElementById('CotizacionTipoDescuento').removeAttribute("disabled");

        $("#CotizacionContratoadoQ").removeClass('disabled');
        $("#CotizacionFinanciamientoQ").removeClass('disabled');
        $("#CotizacionEscrituracionQ").removeClass('disabled');
        $("#CotizacionTotalQ").removeClass('disabled');

        $("#inputDescuentoMonto").addClass('hidden');

        $("#CotizacionPrecioLista").val(0);
        $("#CotizacionPrecioConDescuento").val(0);
        $("#CotizacionPrecioDeVenta").val(0);
        $("#precio_descuento_venta").html('$0.00');
        $("#precio_final_venta_label").html('$0.00');
        $("#registrar").prop('disabled', true);


        // Fecha aka RrogueOne 23/ene/2023
        $("#CotizacionVigencia").val(0);
        

        $('.chzn-select').trigger('chosen:updated');


    }


</script>