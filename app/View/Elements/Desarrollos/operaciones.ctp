<?php
    $status_venta = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Reserva / apartado',
        3 => 'Enganche',
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
    $status_proceso = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Proceso de apartado',
        3 => 'Proceso de contrato',
        4 => 'Escriturado',
        5 => 'Baja',
    );
    $status_fecha = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Vigencia',
        3 => 'Fecha de escrituracion',
        4 => 'Fecha de escrituracion real',
        5 => 'Baja',
    );
    $status_fecha_oparacion = array(
        0 => 'Bloqueada',
        1 => 'Libre / En venta',
        2 => 'Fecha',
        3 => 'Fecha de venta',
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

<!-- Modal delete -->
<div class="modal fade" id="modalCancelacionOperacion">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <?= $this->Form->create('OperacionCancelar'); ?>
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black" id="titleModalCancelacionOperacion"> </h3>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <p id="text_warning_cancelacion">
                        
                    </p>
                </div>
            </div>

            <div class="row">
                <?= $this->Form->hidden('tipo_operacion', array(
                    'class' => 'form-control',
                    'div' => 'col-sm-12'
                )) ?>
                <?= $this->Form->hidden('inmueble_id', array(
                    'class' => 'form-control',
                    'div' => 'col-sm-12'
                )) ?>
                <?= $this->Form->hidden('cliente_id', array(
                    'class' => 'form-control',
                    'div' => 'col-sm-12'
                )) ?>
                <?= $this->Form->hidden('opciones_cancelacion', array(
                    'class' => 'form-control',
                    'div' => 'col-sm-12'
                )) ?>
            </div>

            <div class="modal-footer">
              <div class="row">
                <div class="col-sm-12 btn-group float-right">
                    <button type="button" class="btn btn-secondary-o" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success">Aceptar</button>
                </div>
              </div>
            </div>

            <?= $this->Form->hidden('id') ?>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>


<!-- Seccion de las operaciones -->
<div class="card">

    <div class="card-header bg-blue-is">
        Operaciones de propiedades
    </div>

    <div class="card-block">
        <div class="row">
            <?php $operacion_inmueble_id = 0; ?>
            <?php if( !empty($operaciones)): ?>
                <?php foreach($operaciones as $operacion ): ?>
                    
                    
                    <div class="col-sm-12">
                        <div class="card card-o" style="border-radius:9px;margin-top: 8px;">
                            <div class="col-sm-12 headerOps">
                                <h4 style="color:black; padding:4px 8px;">
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
                                </h4>
                                <!-- <span class="float-right">
                                    <i class="fa fa-chevron-down" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"></i>
                                </span> -->
                            </div>
                            <div class="col-lg-12 col-sm-12 mt-2">
                                <div class="col-lg-5 col-sm-12">
                                    <div class="<?= $bg_propiedades[$operacion['tipo_operacion']] ?>" style="border-radius:0 !important;padding:2px 4px;">
                                        <p class="m-0">
                                            <b>
                                                <?= $status_proceso[$operacion['tipo_operacion']]?>
                                            </b>
                                        </p>
                                    </div>
                                    <div style="display:flex;background-color:#E6ECEC;padding:2px 4px;">
                                        <div style="width:50%;">
                                            <p class="m-0">
                                                Creado
                                            </p>
                                        </div>
                                        <div style="width:50%;">
                                            <p class="m-0">
                                                <?= $this->Html->link($cliente['User']['nombre_completo'], array('controller' => 'users', 'action' => 'view', $cliente['User']['id'] ), array('escape' => false))?>
                                            </p>
                                        </div>
                                    </div>
                                    <div style="display:flex;padding:2px 4px;">
                                        <div style="width:50%;">
                                            <p class="m-0">
                                                Fecha de creación
                                            </p>
                                        </div>
                                        <div style="width:50%;">
                                            <p class="m-0">
                                                03-05-2023
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <?= $this->Html->link('Ver proceso',array('controller'=>'desarrollos','action'=>'inicio_proceso',$desarrollo['Desarrollo']['id']),array('style' => 'color:#258F8D;float:right;'))?>
                                    </div>
                                </div>
                            </div>
                            <!-- Imagen
                            <div class="card-block mt-3">
                                <div class="col">
                                    <div class="mt-1">
                                        <div class="col-lg-5 col-sm-12 border-300 text-sm-center" style="border-radius:8px;">
                                        <?= $this->Html->image($operacion['Inmueble']['FotoInmueble']['0']['ruta'], array('class' => 'img-fluid', 'style' => 'height:330px;'))?>
                                        Boton de edicion, oh eliminacion.
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
                                        <div class="col-lg-7 col-sm-12">
                                            <div>
                                                <div style="display:flex;justify-content:space-between;border-top:0.5px solid #c1c1c1;padding:2px 0;">
                                                        <div>Id operación:</div> 
                                                        <div><?= $operacion['id'] ?></div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;border-top:0.5px solid #c1c1c1;padding:2px 0;">
                                                        <div>Precio de venta:</div> 
                                                        <div><?= '$ '.number_format($operacion['precio_unidad'], 2) ?></div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div>Precio de Lista:</div>
                                                    <div><?= '$ '.number_format($operacion['Inmueble']['precio'], 2) ?></div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div><?php echo $status_venta[$operacion['tipo_operacion']];?>: </div>
                                                    <div><?= '$ '.number_format($operacion['precio_cierre'], 2) ?></div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div><?php echo $status_fecha_oparacion[$operacion['tipo_operacion']];?>:</div>
                                                    <div><?= date("d-m-Y", strtotime( $operacion['fecha'])) ?></div>
                                                </div>
                                                <?php if( $operacion['tipo_operacion'] == 3 ): ?>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div>Financiamiento: </div>
                                                    <div>
                                                        <?php if( $operacion['Cotizacion']['financiamiento'] > 100 ): ?>
                                                            $ <?= number_format($operacion['Cotizacion']['financiamiento'], 2) ?>
                                                        <?php else: ?>
                                                            $ <?= number_format(($operacion['Cotizacion']['precio_final']*($operacion['Cotizacion']['financiamiento']/100)), 2) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div>Monto mensual: </div>
                                                    <div>
                                                        <?php if( $operacion['Cotizacion']['financiamiento'] > 100 ): ?>
                                                            $ <?= (empty($operacion['Cotizacion']['financiamiento']) ? 0 : number_format($operacion['Cotizacion']['financiamiento'] / $operacion['Cotizacion']['meses'], 2)) ?>
                                                        <?php else: ?>
                                                                $ <?= (empty($operacion['Cotizacion']['financiamiento']) ? 0 : number_format(($operacion['Cotizacion']['precio_final']*($operacion['Cotizacion']['financiamiento']/100)) / $operacion['Cotizacion']['meses'], 2)) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div style="display:flex;justify-content:space-between;border-bottom:0.5px solid #c1c1c1;padding:2px 0;">
                                                    <div>Meses de plazo:  </div>
                                                    <div>
                                                        <?= ( empty($operacion['Cotizacion']['meses']) ? 0 : $operacion['Cotizacion']['meses'] ) ?>
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
                                                <div class="btn btn-secondary-o col-sm-12 col-lg-5 mt-1" style="border-bottom:0.5px solid #c1c1c1;padding:6px 15px;">
                                                    <div class="float-left">Ver documentos</div>
                                                    <i class="fa fa-file-text float-right" ></i>
                                                    <div>
                                                        <?php foreach( $operacion['Documentos'] as $documento ): ?>
                                                            <?= ucfirst(str_replace("_", " ", $documento['tipo_documento'] )) ?>
                                                            <a href="<?= router::url($documento['ruta']) ?>" class="float-right" target="_blank"> <span class ="fa fa-eye">  </span> </a>
                                                            <br>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="btn btn-danger col-sm-12 col-lg-5 mt-1 float-right" style="padding:6px 15px; display:flex;justify-content:space-between;">
                                                    <div class=">
                                                        <?=$operacion['cliente_id']?>,
                                                            <?=$operacion['inmueble_id'] ?>,
                                                            '<?=$status_venta[$operacion['tipo_operacion']]?>',
                                                            <?=$operacion['tipo_operacion']?>,
                                                            <?=$operacion['id']?>
                                                        );">
                                                        Cancelar <?php echo $status_venta[$operacion['tipo_operacion']]; ?>
                                                    </div>
                                                    <i class="fa fa-trash"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
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
        $("#text_warning_cancelacion").html(' Deseas cancelar la operación ' + operacion_tipo_operacion + '  ' );

        // $("#OperacionCancelarId").val(id);
        // $("#OperacionCancelarTipoOperacion").val(tipo_operacion);
        // $("#OperacionCancelarInmuebleId").val(operacion_inmueble_id);
        // $("#OperacionCancelarClienteId").val(operacion_cliente_id);
        // $('#OperacionCancelarOpcionesCancelacion').empty().append('<option value="">Seleccione una opción</option>');
        //console.log( operacion_cliente_id, operacion_inmueble_id, operacion_tipo_operacion, tipo_operacion);
        
        // $.ajax({
        //     type    : "GET",
        //     url     : "<?php echo Router::url(array("controller" => "users", "action" => "get_dic_cancelacion")); ?>",
        //     dataType: "json",
        //     cache   : false,
        //     success : function (response) {
        //         var opcionesApartado      = [];
        //         var opcionesVenta         = [];
        //         var opcionesEscrituracion = [];
                
        //         opcionesApartado      = response.apartado;
        //         opcionesVenta         = response.venta;
        //         opcionesEscrituracion = response.escritura;

        //         switch ( tipo_operacion ) {
        //             case 2:
        //                 $.each(opcionesApartado, function(key, value) {
        //                     $('<option>').val('').text('select');
        //                     $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
        //                 });
        //                 break;
        //             case 3:
        //                 $.each(opcionesVenta, function(key, value) {
        //                     $('<option>').val('').text('select');
        //                     $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
        //                 });
        //                 break;
        //             case 4:
        //                 $.each(opcionesEscrituracion, function(key, value) {
        //                     $('<option>').val('').text('select');
        //                     $('<option>').val(key).text(value).appendTo($("#OperacionCancelarOpcionesCancelacion"));
        //                 });
        //                 break;
        //             default:
        //                 //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
        //                 break;
        //         }

        //     }
        // });

        
    }
    


</script>


