<?php
    $status_venta = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'reserva/apartado',
        3 => 'la firma del contrato/enganche',
        4 => 'escritura',
        5 => 'Baja',
    );
    $status_propiedades = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Apartado / Reservado',
        3 => 'Vendido / Contrato',
        4 => 'Escriturado',
        5 => 'Baja',
      );
    $status_fecha = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Vigencia de la reserva / apartado',
        3 => 'Fecha registrada para escrituracion',
        4 => 'Fecha de escrituracion real',
        5 => 'Baja',
    );
    $status_fecha_oparacion = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Fecha de la operación',
        3 => 'Fecha venta / contrato',
        4 => 'Fecha de escrituracion',
        5 => 'Baja',
    );
    
    $bg_propiedades = array(
        0 => 'bg-bloqueado',
        1 => 'bg-libre',
        2 => 'bg-apartado',
        3 => 'bg-vendido',
        4 => 'bg-escriturado',
        5 => 'bg-baja',
    );
?>

<div class="card">

    <div class="card-header bg-blue-is">
        Operaciones de propiedades
    </div>
    <div class="card-block">
        <div class="row">
            <?php $operacion_inmueble_id = 0; ?>
            <?php if( !empty($operaciones)): ?>
                <?php foreach($operaciones as $operacion ): ?>
                    <div class="col-sm-12 col-lg-12">
                        <div class="card card-o" style="border-radius:9px;margin-top: 8px;">
                            <div class="col-sm-12 <?= $bg_propiedades[$operacion['tipo_operacion']] ?> chip" style="border-radius: 8px 8px 0 0 !important;display:flex;justify-content: space-evenly;">
                                <?= $status_propiedades[$operacion['tipo_operacion']] ?>
                                <?= $this->Html->link($operacion['Inmueble']['referencia'], array('controller' => 'inmuebles', 'action' => 'view_tipo', $operacion['inmueble_id'], 'style' => 'padding-left:8px;')) ?>
                                <?php if( $this->Session->read('Permisos.Group.eoi') ): ?>
                                    <span class="float-sm-right pointer icon-group" onclick="editModalProcesoInmueble( <?= $operacion['tipo_operacion'] ?> )">
                                        <i class="fa fa-edit"> </i>
                                    </span>
                                <?php endif; ?>

                                <?php if( $this->Session->read('Permisos.Group.doi') ): ?>
                                    <span class="float-sm-right pointer icon-group" onclick="deleteModalProcesoInmueble( <?= $operacion['id'] ?>, <?= $operacion['cliente_id'] ?>, '<?= $operacion['Inmueble']['referencia'] ?>', <?= $operacion['Inmueble']['id'] ?>, <?= $operacion['tipo_operacion'] ?> )">
                                        <i class="fa fa-trash"> </i>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <!-- Imagen -->
                            <div class="card-block mt-3">
                                <div class="col-lg-4 col-sm-12 border-300" style="border-radius:8px;">
                                    <?= $this->Html->image($operacion['Inmueble']['FotoInmueble']['0']['ruta'], array('class' => 'img-fluid'))?>
                                    <?= $this->Html->link($operacion['Inmueble']['referencia'], array('controller' => 'inmuebles', 'action' => 'view_tipo', $operacion['inmueble_id'])) ?>
                                            <!-- Boton de edicion, oh eliminacion. -->
                                            <?php if( $this->Session->read('Permisos.Group.eoi') ): ?>
                                                <span class="float-sm-right pointer icon-group" onclick="editModalProcesoInmueble( <?= $operacion['tipo_operacion'] ?> )">
                                                    <i class="fa fa-edit"> </i>
                                                </span>
                                            <?php endif; ?>
        
                                            <?php if( $this->Session->read('Permisos.Group.doi') ): ?>
                                                <span class="float-sm-right pointer icon-group" onclick="deleteModalProcesoInmueble( <?= $operacion['id'] ?>, <?= $operacion['cliente_id'] ?>, '<?= $operacion['Inmueble']['referencia'] ?>', <?= $operacion['Inmueble']['id'] ?>, <?= $operacion['tipo_operacion'] ?> )">
                                                    <i class="fa fa-trash"> </i>
                                                </span>
                                            <?php endif; ?>
                                </div>
                                <div class="col-lg-8 col-sm-12">
                                    <div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;border-top:0.5px solid #c1c1c1;padding:2px 0;">
                                                <div>Precio de venta:</div> 
                                                <div><?= '$ '.number_format($operacion['precio_unidad'], 2) ?></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Precio de Lista:</div>
                                            <div><?= '$ '.number_format($operacion['Inmueble']['precio'], 2) ?></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Pago de <?php echo $status_venta[$operacion['tipo_operacion']];?>: </div>
                                            <div><?= '$ '.number_format($operacion['precio_cierre'], 2) ?></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div><?php echo $status_fecha_oparacion[$operacion['tipo_operacion']];?>:</div>
                                            <div><?= date("d-m-Y", strtotime( $operacion['fecha'])) ?></div>
                                        </div>
                                        <?php if( $operacion['tipo_operacion'] == 3 ): ?>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Financiamiento aplazados /diferido a "<?= ( empty($operacion['Cotizacion']['meses']) ? 0 : $operacion['Cotizacion']['meses'] ) ?>" meses: </div>
                                            <div>
                                                <?php if( $operacion['Cotizacion']['financiamiento'] > 100 ): ?>
                                                    $ <?= number_format($operacion['Cotizacion']['financiamiento'], 2) ?>
                                                <?php else: ?>
                                                    $ <?= number_format(($operacion['Cotizacion']['precio_final']*($operacion['Cotizacion']['financiamiento']/100)), 2) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Monto del aplazado ( mensual): </div>
                                            <div>
                                                <?php if( $operacion['Cotizacion']['financiamiento'] > 100 ): ?>
                                                    $ <?= (empty($operacion['Cotizacion']['financiamiento']) ? 0 : number_format($operacion['Cotizacion']['financiamiento'] / $operacion['Cotizacion']['meses'], 2)) ?>
                                                <?php else: ?>
                                                        $ <?= (empty($operacion['Cotizacion']['financiamiento']) ? 0 : number_format(($operacion['Cotizacion']['precio_final']*($operacion['Cotizacion']['financiamiento']/100)) / $operacion['Cotizacion']['meses'], 2)) ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div><?php echo $status_fecha[$operacion['tipo_operacion']];?>:</div>
                                            <div><?= date("d-m-Y", strtotime( $operacion['vigencia_operacion'])) ?></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Asesor:</div>
                                            <div><?php echo $operacion['User']['nombre_completo']; ?></div>
                                        </div>
                                        <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                            <div>Cliente:</div>
                                            <div><?php echo $operacion['Cliente']['nombre'];?></div>
                                        </div>
                                        <div style="border-bottom:0.5px solid #c1c1c1;padding:2px 0;"">
                                            <div>Documentos:</div>
                                            <div>
                                                <?php foreach( $operacion['Documentos'] as $documento ): ?>
                                                    <?= ucfirst(str_replace("_", " ", $documento['tipo_documento'] )) ?>
                                                    <a href="<?= router::url($documento['ruta']) ?>" class="float-right" target="_blank"> <span class ="fa fa-eye">  </span> </a>
                                                    <br>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div style="margin-top: 16px;">
                                            <button type="button" class="btn btn-success" style="float:right;" onclick="cancelacion(
                                                                                                                <?=$operacion['cliente_id']?>,
                                                                                                                <?=$operacion['inmueble_id'] ?>,
                                                                                                                '<?=$status_venta[$operacion['tipo_operacion']]?>',
                                                                                                                <?=$operacion['tipo_operacion']?>,
                                                                                                                <?=$operacion['id']?>
                                                                                                            );">
                                                cancelar <?php echo $status_venta[$operacion['tipo_operacion']]; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <?php $operacion_inmueble_id = $operacion['inmueble_id']; ?>

                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-sm-12">
                    <h3 class="text-sm-center text-black">
                        Aun no hay operaciones relacionadas a una propiedad.
                    </h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    'use strict';
    /**
     * 
     * 
     * 10/05/2022 - AKA (rogueOne).
     * 
     * 
    */
    
    function cancelacion( operacion_cliente_id, operacion_inmueble_id, operacion_tipo_operacion, tipo_operacion,id ){
        $("#modalCancelacionOperacion").modal('show');
        $("#titleModalCancelacionOperacion").html('Cancelacion de '+operacion_tipo_operacion);
        $("#OperacionCancelarId").val(id);
        $("#OperacionCancelarTipoOperacion").val(tipo_operacion);
        $("#OperacionCancelarInmuebleId").val(operacion_inmueble_id);
        $("#OperacionCancelarClienteId").val(operacion_cliente_id);
        $('#OperacionCancelarOpcionesCancelacion').empty().append('<option value="">Seleccione una opción</option>');
        //console.log( operacion_cliente_id, operacion_inmueble_id, operacion_tipo_operacion, tipo_operacion);
        $.ajax({
            type    : "GET",
            url     : "<?php echo Router::url(array("controller" => "users", "action" => "get_dic_cancelacion")); ?>",
            dataType: "json",
            cache   : false,
            success : function (response) {
                var opcionesApartado      = [];
                var opcionesVenta         = [];
                var opcionesEscrituracion = [];
                
                opcionesApartado      = response.apartado;
                opcionesVenta         = response.venta;
                opcionesEscrituracion = response.escritura;

                switch ( tipo_operacion ) {
                    case 2:
                        $.each(opcionesApartado, function(key, value) {
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
                        });
                        break;
                    case 3:
                        $.each(opcionesVenta, function(key, value) {
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
                        });
                        break;
                    case 4:
                        $.each(opcionesEscrituracion, function(key, value) {
                            $('<option>').val('').text('select');
                            $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
                        });
                        break;
                    default:
                        //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                        break;
                }

            }
        });

        
    }
    


</script>


