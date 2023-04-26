<?= $this->Html->css(
        array(
            'pages/layouts',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            
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
            
            '/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min',
            '/vendors/summernote/css/summernote',
            'custom',
            
            'pages/form_elements',
            
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/css/pages/form_validations',
            
            '/vendors/datepicker/css/bootstrap-datepicker3',

            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            
            ),
        array('inline'=>false))
        
?>

<!-- Modal delete -->
<div class="modal fade" id="modalDocumentoUserDelete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Esta seguro de eliminar este documento ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('DocumentosUser', array('url'=>array('controller'=>'Inmuebles', 'action'=>'eliminar_documento', $this->request->data['Inmueble']['id']
            )));
                echo $this->Form->hidden('id');
            ?>

            <div class="modal-footer">
              <div class="row">
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <button type="submit" class="btn btn-success float-right">Aceptar</button>
                  </div>
              </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="modalBrochureDelete">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Desea eliminar el brochure ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?= $this->Form->create('DeleteBrochure', array('url'=>array('controller'=>'inmuebles', 'action'=>'borrar_brochure', $this->request->data['Inmueble']['id']
            )));
            ?>

            <div class="modal-footer">
              <div class="row">
                  <div class="col-sm-12 col-lg-6">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                  </div>
                  <div class="col-sm-12 col-lg-6">
                      <button type="submit" class="btn btn-success float-right">Aceptar</button>
                  </div>
              </div>
            </div>
            <?= $this->Form->end(); ?>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="infoPane" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">
                <b>Documentos para apoyar tu venta se entienden como:</b>
                <ul>
                    <li>Acta constitutiva.</li>
                    <li>Contrato de compra venta de terreno.</li>
                    <li>Permisos.</li>
                    <li>Contratos.</li>
                    <li>Poderes.</li>
                </ul>
                <i>Sólo se permiten archivos PDF, Word y Excel</i>
                <br>
                <hr>
                <b>Brochure Personalizado:</b>
                <p>
                    Si se sube un archivo, este será anexado en los correos electrónicos que se envíen al cliente.
                </p>
                <i>Sólo se permiten archivos PDF</i>
            </div>
            <div class="modal-footer">
                <button class="btn  btn-danger" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>

<style>
    
    .card, .card-header {
        border-radius: 5px !important;
    }

    .card:hover {
        box-shadow: none !important;
    }

    .file-caption {
        height: 29px !important;
    }
    .fa-minus::before{
        content: 'minimizar' !important;
        text-transform: none !important;
    }
    .fa-maximus::before{
        content: 'expandir' !important;
        text-transform: none !important;
    }

</style>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-th"></i> Cargar Propiedad </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <div class="card">
                <div class="card-block">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        <?= $this->Form->create('Inmueble', array('type'=>'file'));?>

                            <!-- Datos generales -->
                            <div class="card mt-2">
                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                    <a class="collapsed accordion-section-title text-white" data-toggle="collapse" data-parent="#accordion" href="#card-data-one" aria-expanded="false">
                                        Datos generales
                                         <i class="fa fa-maximus float-xs-right m-t-5"></i>
                                        <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"></span>
                                    </a>
                                </div>

                                <?php if (isset($tab) && $tab == 1){?>
                                <div id="card-data-one" class="card-collapse">
                                <?php }else{?>
                                <div id="card-data-one" class="card-collapse collapse">
                                <?php } ?>

                                    <div class="card-block">

                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Datos del propietario
                                            </div>

                                            <div class="card-block">
                                                <div class="row">
                                                    
                                                    <?= $this->Form->input('nombre_cliente', array('div' => 'col-sm-12 col-lg-6','class'=>'form-control','label'=>array('text' => 'Nombre Completo*', 'class' => 'required'), 'required' => true, 'type' => 'text'))?>
                                                            
                                                    <?= $this->Form->input('telefono1', array('div' => 'col-sm-12 col-lg-3','class'=>'form-control','label'=>'Teléfono', 'type' => 'tel', 'maxlength' => 10, 'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57'))?>
                                                    
                                                    <?= $this->Form->input('correo_electronico', array('div' => 'col-lg-3 col-sm-12','class'=>'form-control','label'=>'Correo electrónico', 'type' => 'email'))?>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Información General
                                            </div>

                                            <div class="card-block">

                                                <div class="row">
                                                
                                                    <?php
                                                        
                                                        echo $this->Form->input('referencia', array('label'=>array('text'=>'Referencia*','style'=>'font-weight:bold'),'class'=>'form-control required','div' => 'form-group col-xl-6','required'=>true));
                                                        
                                                        echo $this->Form->input('titulo', array('label'=>array('text'=>'Nombre de la Propiedad*','style'=>'font-weight:bold'),'class'=>'form-control','div' => 'form-group col-xl-6', 'required' => true));
                                                        
                                                        echo $this->Form->input('dic_tipo_propiedad_id', array('label'=>array('text'=>'Tipo de Inmueble*','style'=>'font-weight:bold'),'div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad', 'required' => true));
                                                        
                                                        echo $this->Form->input('premium', array('class'=>'form-control','div' => 'form-group col-xl-6','type'=>'select','options'=>array('No','Si')));
                                                        
                                                    ?>

                                                </div>


                                                <div class="row">
                                                    <?=
                                                        $this->Form->input('exclusiva', array('label'=>array('text'=>'Exclusiva*','style'=>'font-weight:bold'),'id'=>'exclusiva','onchange'=>'javascript:showExclusiva()','div' => 'form-group col-md-6','class'=>'form-control','type'=>'select','options'=>$exclusiva,'empty'=>'Selecciona exclusiva', 'required' => true));
                                                    ?>
                                                    
                                                    <div class="col-xs-3" id="fecha_exclusiva" style="display:none">
                                                        <label for="DesarrolloFechaExclusividad">Fecha Inicio Exclusiva</label>
                                                        <?php echo $this->Form->input('fecha_inicio_exclusiva', array('type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%', 'autocomplete'=>'off'))?>
                                                    </div>
                                                    
                                                    <div class="col-xs-3" id="fecha_exclusiva2" style="display:none">
                                                        <label for="DesarrolloFechaExclusividad">Fecha Vencimiento Exclusiva</label>
                                                        <?php echo $this->Form->input('due_date', array('type'=>'text','label'=>false,'class'=>'form-control fecha','style'=>'width:100%', 'autocomplete'=>'off'))?>
                                                    </div>

                                                </div>


                                                <div class="row">
                                                    
                                                    <?php echo $this->Form->input('venta_renta', array('label'=>array('text'=>'Tipo de Operación*','style'=>'font-weight:bold'),'onchange'=>'showPrecio()','id'=>'rv','div' => 'form-group col-xl-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta', 'required' => true));?>
                                                    
                                                    <div class="form-group col-md-3" id="precio1">
                                                        <label for="InmueblePrecio">Precio Venta</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            
                                                            <?= $this->Form->input('precio', array(
                                                                'class' => 'form-control',
                                                                'min'   => 0,
                                                                'label' => false,
                                                                'div'   => false
                                                            ))?>
            
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-md-3" style="display:none" id="precio2">
                                                        <label for="InmueblePrecio2">Precio Renta</label>
                                                        
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            <?= $this->Form->input('precio_2', array(
                                                                'class' => 'form-control',
                                                                'min'   => 0,
                                                                'label' => false,
                                                                'div'   => false
                                                            ))?>
                                                        </div>
            
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    
                                                    <div class="form-group col-md-3">
                                                        <label for="InmuebleComision">Comisión</label>
                                                        <div class="input-group">
                                                            <input class="form-control percent" name="data[Inmueble][comision]" type="number" id="comision" min="0" step=".01">
                                                            
                                                        </div>
                                                    </div>

                                                    <?= $this->Form->input('compartir', array('onchange'=>'javascript:showPorcentaje()','div' => 'form-group col-md-3','class'=>'form-control','type'=>'select','options'=>array(0=>'No',1=>'Si'),'label'=>'¿Se puede compartir inmueble?')); ?>
            
                                                    <div class="form-group col-md-3" id="porcentaje" style="display:none">
                                                        <label for="InmueblePorcentajeCompartir">Porcentaje a Compartir</label>
                                                        <div class="input-group">
                                                            <input class="form-control" type="number"  id="percent"   name="data[Inmueble][porcentaje_compartir]" min="0" step=".01">
                                                            
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                
                                                    <?php    
                                                        echo $this->Form->input('cita', array('div' => 'form-group col-md-6','class'=>'form-control','label'=>'Horario de Contacto', 'type' => 'text'));

                                                        echo $this->Form->input('opcionador_id', array('empty'=>'Seleccionar Opcionador','div' => 'form-group col-md-6','class'=>'form-control','options'=>$opcionadors));

                                                    ?>

                                                </div>
                                                
                                                <div class="row">
                                                    
                                                    <div class="col-xs-12">
                                                        <div class='summer_note_display summer_note_btn'>
                                                            Descripción de la propiedad*
                                                            <small>Datos generales</small>
                                                            <textarea name="data[Inmueble][comentarios]" id="InmuebleComentarios" class="summernote_editor" placeholder="Escribir descripción" required = 'required'><?= empty($this->request->data['Inmueble']['comentarios']) ? '' : $this->request->data['Inmueble']['comentarios'] ?></textarea>
                                                        </div>
                                                    </div>

                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- Fin de información general -->

                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Ubicación de la propiedad
                                            </div>

                                            <!-- <div class="card-block"> -->

                                                <div class="row col-sm-12">
                                                    <?php echo $this->Form->input('cp', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Código Postal*', 'required' => true, 'type' => 'text', 'maxlength' => '5' ,'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'onkeyup'=>'find_cp()'))?>
                                                    

                                                    <?php echo $this->Form->input('estado_ubicacion', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control chzn-select','label'=>'Estado', 'type'=>'select'))?>

                                                </div>

                                                <div class="row col-sm-12">
                                                    <?php echo $this->Form->input('delegacion', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control chzn-select','label'=>'Alcaldía / Municipio*', 'type' => 'text', 'required' => true, 'type' => 'select'))?>

                                                    
                                                    <?php echo $this->Form->input('colonia', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control chzn-select','label'=>'Colonia*', 'type' => 'text', 'required' => true, 'type' => 'select'))?>
                                                    
                                                </div>

                                                <div class="row col-sm-12">

                                                    <?php echo $this->Form->input('calle', array('div' => 'col-sm-12 col-lg-4','class'=>'form-control','label'=>'Calle*', 'type' => 'text', 'required' => true))?>

                                                    <?php echo $this->Form->input('numero_exterior', array('div' => 'form-group col-sm-12 col-lg-4','class'=>'form-control','label'=>'Número Exterior*', 'type' => 'text', 'required' => true))?>

                                                    <?php echo $this->Form->input('numero_interior', array('div' => 'form-group col-sm-12 col-lg-4','class'=>'form-control','label'=>'Número Interior', 'type' => 'text'))?>

                                                    <?php echo $this->Form->hidden('ciudad')?>

                                                </div>

                                                <div class="row col-sm-12">
                                                    
                                                    <?php echo $this->Form->input('entre_calles', array('div' => 'form-group col-sm-12 col-lg-6','class'=>'form-control','label'=>'Entre calles', 'type' => 'text'))?>
                                                    
                                                    <?php echo $this->Form->input('google_maps', array('div' => 'form-group col-lg-6 col-sm-12','class'=>'form-control','label'=>'Coordenadas Google Maps', 'type' => 'text'))?>
                                                    
                                                </div>

                                                
                                            <!-- </div> -->
                                        </div>
                                        <!-- Ubicación del desarrollo -->
                                        
                                    </div>
                                
                                </div>
                            </div>

                            <!-- Caracteristicas -->
                            <div class="card mt-2">
                                <div class="card-header bg-blue-is" role="tab" id="title-two">
                                    <a class="collapsed accordion-section-title text-white" data-toggle="collapse" data-parent="#accordion" href="#card-caracteristicas" aria-expanded="false">
                                        caracteristícas
                                         <i class="fa fa-maximus float-xs-right m-t-5"></i>
                                        <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"></span>
                                    </a>
                                </div>

                                <?php if (isset($tab) && $tab == 1){?>
                                <div id="card-caracteristicas" class="card-collapse">
                                <?php }else{?>
                                <div id="card-caracteristicas" class="card-collapse collapse">
                                <?php } ?>

                                    <div class="card-block">

                                        <!-- Metrajes -->
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Metrajes
                                            </div>

                                            <div class="card-block">

                                                <div class="row mt-1">
                                                    <?php echo $this->Form->input('construccion', array('div' => 'col-md-4','class'=>'form-control','label'=>'Superficie Habitable (m2)', 'type' => 'number', 'min' => 0, 'step'=>'any' ))?>

                                                    <?php echo $this->Form->input('construccion_no_habitable', array('div' => 'col-md-4','class'=>'form-control','label'=>'Superficie No Habitable (m2)', 'type' => 'number', 'min' => 0, 'step'=>'any'))?>

                                                    <?php echo $this->Form->input('terreno', array('div' => 'col-md-4','class'=>'form-control','label'=>'Superficie de Terreno (m2)', 'type' => 'number', 'min' => 0, 'step'=>'any'))?>
                                                </div>
                                                <div class="row mt-1">

                                                    <?php echo $this->Form->input('frente_fondo', array('div' => 'col-md-4','class'=>'form-control','label'=>'Frente (m2) x Fondo (m2)', 'maxlenght' => 8, 'step'=>'any'))?>

                                                    <?php echo $this->Form->input('niveles_totales', array('div' => 'col-md-4','class'=>'form-control','label'=>'Si es depto en qué nivel se encuentra', 'type' => 'number', 'min' => 0))?>

                                                    <?php echo $this->Form->input('nivel_propiedad', array('div' => 'col-md-4','class'=>'form-control','label'=>'Niveles de la Propiedad', 'type' => 'number', 'min' => 0))?>
                                                </div>

                                                <div class="row mt-1">

                                                    <?php echo $this->Form->input('unidades_totales', array('div' => 'col-md-4','class'=>'form-control','label'=>'Unidades Totales (Depto / Condominio)', 'type' => 'number', 'min' => 0))?>

                                                    <?php echo $this->Form->input('recamaras', array('div' => 'col-md-4','class'=>'form-control','label'=>'Recámaras (Cantidad)', 'type' => 'number', 'min' => 0))?>

                                                    <?php echo $this->Form->input('banos', array('div' => 'col-md-4','class'=>'form-control','label'=>'Baños (Cantidad)', 'type' => 'number', 'min' => 0))?>
                                                    
                                                </div>
                                                <div class="row mt-1">

                                                    <?php echo $this->Form->input('medio_banos', array('div' => 'col-md-4','class'=>'form-control','label'=>'Medios Baños', 'type' => 'number', 'min' => 0))?>

                                                    <?php echo $this->Form->input('estacionamiento_techado', array('div' => 'col-md-4','class'=>'form-control','label'=>'Estacionamientos Techados (Cantidad)', 'type' => 'number', 'min' => 0))?>

                                                    <?php echo $this->Form->input('estacionamiento_descubierto', array('div' => 'col-md-4','class'=>'form-control','label'=>'Estacionamientos Descubiertos (Cantidad)', 'type' => 'number', 'min' => 0))?>
                                                </div>

                                                <div class="row mt-1">
                                                    <?php
                    
                                                        echo $this->Form->input('disposicion',array('options'=>$disposicion,'class'=>'form-control','div' => 'col-md-4','label'=>'Disposición'));
                                                        echo $this->Form->input('orientacion',array('options'=>$orientacion,'class'=>'form-control','div' => 'col-md-4','label'=>'Orientación'));
                                                        echo $this->Form->input('estado',array('options'=>$estado,'class'=>'form-control','div' => 'col-md-4'));
                                                        
                                                    ?>

                                                </div>

                                                <div class="row mt-1">
                                                    <?php echo $this->Form->input('edad', array('div' => 'col-md-4','class'=>'form-control','label'=>'Edad en años', 'type' => 'text'))?>
                                                    
                                                    
                                                    <div class="col-md-4">
                                                        <label for="InmuebleMantenimiento">Mantenimiento</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">$</span>
                                                            
                                                            <?= $this->Form->input('mantenimiento', array('div'=>False, 'label'=>False, 'class'=>'form-control', 'arial-label'=>'Amount (rounded to the nearest dollar)', 'min' => 0)); ?>

                                                            <span class="input-group-addon">.00</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Lugares de interes -->
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                LUGARES DE INTERÉS
                                            </div>
                                            <div class="card-block">

                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cc_cercanos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Centros Comerciales Cercanos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('escuelas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Escuelas
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('frente_parque', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Frente a Parque
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('parque_cercano', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Parques Cercanos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('plazas_comerciales', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Plazas Comerciales
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Areas y amenidades -->
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                ÁREAS Y AMENIDADES
                                            </div>
                                            <div class="card-block">
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('alberca_sin_techar', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Alberca descubierta
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('golf', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Campo de Golf
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('gimnasio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gimnasio
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('roof_garden_compartido', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Roof Garden
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('alberca_techada', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Alberca Techada
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('paddle_tennis', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de Paddle
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('jacuzzi', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Jacuzzi
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sala_tv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sala de TV
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sala_cine', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área de Cine
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('squash', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de Squash
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('living', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Living
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('salon_juegos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Salón de Juegos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('area_juegos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área de Juegos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cancha_tenis', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cancha de Tenis
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('lobby', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Lobby
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('salon_multiple', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Salón de usos múltiples
                                                    </label>
                                                </div><div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('juegos_infantiles', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área de Juegos Infantiles
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cantina_cava', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cantina / Cava
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('boliche', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Mesa de Boliche
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sauna', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sauna
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('fumadores', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Área para fumadores
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('carril_nado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Carril de Nado
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('patio_servicio', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Patio de Servicio
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('pet_park', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Pet Park
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('spa', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Spa
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('areas_verdes', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Áreas Verdes
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cocina_integral', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cocina Integral
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('coworking', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Coworking
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('pista_jogging', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Pista de Jogging
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sky_garden', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sky Garden
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('asador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Asador
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('closet_blancos', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Closet de Blancos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('play_room', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Play Room / Cuarto de Juegos
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('tina_hidromasaje', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Tina de Hidromasaje
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('business_center', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Business Center
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('desayunador_antecomedor', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Desayunador / Antecomedor
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('restaurante', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Restaurante
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('vapor', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Vapor
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cafeteria', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cafetería
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('fire_pit', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Fire Pit
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('meditation_room', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Yoga / meditation room
                                                    </label>
                                                </div>

                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('Simulador de golf', array('label'=>false,'div'=>false,'default'=>'unchecked', 'type' => 'checkbox'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Simulador golf
                                                    </label>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Servicios -->
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                Servicios
                                            </div>
                                            <div class="card-block">
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('acceso_discapacitados', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso de discapacitados
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('calefaccion', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Calefacción
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('interfon', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Interfón
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('planta_emergencia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Planta de Emergencia
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('agua_corriente', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Agua Corriente
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cctv', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        CCTV
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('gas_lp', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gas LP
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('porton_electrico', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Portón Eléctrico
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('amueblado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Amueblado
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('cisterna', array('onchange'=>'showLitros()','type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Cisterna
                                                        <?php
                                                            $show = "";
                                                            if (empty($inmueble['Inmueble']['cisterna']) OR $inmueble['Inmueble']['cisterna'] == 0 ){
                                                                $show = 'display:none';
                                                            }
                                                            echo $this->Form->input('m_cisterna', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Cantidad en Litros', 'class'=>'form-control', 'div'=>false,)) ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('gas_natural', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Gas Natural
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('refrigerador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Refrigerador
                                                    </label>
                                                </div><br><br><br><br><br><br>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('internet', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso Internet / WiFi
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('conmutador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Conmutador
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('lavavajillas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Lavavajillas
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sistema_incendios', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sistema Contra Incendios
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('tercera_edad', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Acceso para Tercera Edad
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('edificio_inteligente', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Edificio Inteligente
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('lavanderia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Lavanderia
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('sistema_seguridad', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Sistema de Seguridad
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('aire_acondicionado', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Aire Acondicionado
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('edificio_leed', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Edificio LEED
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('linea_telefonica', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Línea Telefónica
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('valet_parking', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Valet Parking
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('bodega', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Bodega
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('elevador', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Elevadores
                                                        <?php
                                                        $show = "";
                                                            if (empty($inmueble['Inmueble']['elevador']) OR $inmueble['Inmueble']['elevador'] == 0 ){
                                                                $show = 'display:none';
                                                            }
                                                        echo $this->Form->input('q_elevadores', array('label'=>false,'style'=>"<?= $show?>",'placeholder'=>'Número Elevadores', 'class'=>'form-control', 'div'=>false,)) ?>
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('locales_comerciales', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Locales Comerciales
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('vigilancia', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Vigilancia / Seguridad
                                                    </label>
                                                </div><br><br><br><br><br><br><br>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('boiler', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Boiler / Calentador de Agua
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('estacionamiento_visitas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Estacionamiento de visitas
                                                    </label>
                                                </div>
                                                <div class="checkbox radio_Checkbox_size4 col-lg-3">
                                                    <label>
                                                        <?= $this->Form->input('mascotas', array('type'=>'checkbox','label'=>false,'div'=>false,'default'=>'unchecked'));?>
                                                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                        Permite Mascotas
                                                    </label>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                
                                </div>
                            </div>

                            <!-- Archivos multimedia -->
                            <div class="card mt-2">
                                <div class="card-header bg-blue-is" role="tab" id="title-two">
                                    <a class="collapsed accordion-section-title text-white" data-toggle="collapse" data-parent="#accordion" href="#card-multimedia" aria-expanded="false">
                                        archivos multimedia
                                         <i class="fa fa-maximus float-xs-right m-t-5"></i>
                                        <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"></span>
                                    </a>
                                </div>

                                <?php if (isset($tab) && $tab == 1){?>
                                <div id="card-multimedia" class="card-collapse">
                                <?php }else{?>
                                <div id="card-multimedia" class="card-collapse collapse">
                                <?php } ?>

                                    <div class="card-block">
                                        <div class="sub-card mt-3">
                                            <div class="card-header bg-blue-is">
                                                ARCHIVOS E IMÁGENES CARGADOS PARA EL INMUEBLE
                                            </div>
                                            <div class="card-block">

                                                <div class="row">
                                                    <div class="col-lg-8" style="height: 400px; overflow-y: scroll; padding: 20px; border: 1px solid silver">
                                                        <?php if( !empty($this->request->data['FotoInmueble']) ): ?>
                                                    
                                                            <?php  $i =0; foreach ($this->request->data['FotoInmueble'] as $imagen): ?>
                                                                <div class="col-lg-6 m-t-20">
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Html->image($imagen['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['descripcion'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[fotografias]['.$i.'][descripcion]', 'class'=>'form-control'))?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['orden'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[fotografias]['.$i.'][orden]', 'class'=>'form-control'))?>
                                                                        <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['id'], 'name'=>'data[fotografias]['.$i.'][id]'));?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <div class="checkbox" style="margin-top: 2px;">
                                                                            <label>
                                                                                <input type="checkbox" name="data[fotografias][<?= $i ?>][eliminar]">
                                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                                                Eliminar
                                                                            </label>
                                                                        </div>
                                                                    </div>

                                                                    <style> 
                                                                        .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                                    </style>
                                                                    <div class="col-xs-12">
                                                                        <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                                    </div>
                                                                </div>
                                                            <?php  $i++; endforeach; ?>
                                                        <?php endif; ?>

                                                        <?php $s = 0; if( !empty($this->request->data['PlanoInmueble']) ): ?>
                                                            <?php foreach ($this->request->data['PlanoInmueble'] as $imagen): ?>
                                                                <div class="col-lg-6 m-t-20">
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Html->image($imagen['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['descripcion'],'label'=>false,'style'=>'width:100%; margin-top:5px;','name'=>'data[planos_cargados]['.$s.'][descripcion]', 'class'=>'form-control'))?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['orden'],'label'=>false,'style'=>'width:100%; margin-top:5px;', 'name'=>'data[planos_cargados]['.$s.'][orden]', 'class'=>'form-control'))?>
                                                                        <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['id'],'name'=>'data[planos_cargados]['.$s.'][id]'));?>
                                                                    </div>
                                                                    <div class="col-xs-12">
                                                                        <div class="checkbox" style="margin-top: 2px;">
                                                                            <label>
                                                                                <input type="checkbox" name="data[planos_cargados][<?= $s ?>][eliminar]">
                                                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                                                Eliminar
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <style> .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                                    </style>
                                                                    <div class="col-xs-12">
                                                                        <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                                    </div>
                                                                </div>
                                                            <?php  $s++; endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="col-lg-4" style="height: 400px; overflow-y: scroll; padding: 20px; border-right: 1px solid silver;border-top: 1px solid silver; border-bottom: 1px solid silver">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th width="80%"><b>Documento</b></th>
                                                                    <th width="10%"><b><i class="fa fa-download"></i></b></th>
                                                                    <th width="10%"><b><i class="fa fa-trash fa-lg"></i></b></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php if( !empty($this->request->data['Inmueble']['brochure'])):?>
                                                                    <tr>
                                                                        <td>Brochure Comercial</td>
                                                                        <td>
                                                                            <?= $this->Html->link('<i class="fa fa-download"></i>',$this->request->data['Inmueble']['brochure'],array('escape'=>false, 'target' => '_BLank'))?>
                                                                        </td>
                                                                        <td>
                                                                            <?=
                                                                                $this->Html->link(
                                                                                    '<i class="fa fa-trash fa-lg"></i>','#', array(
                                                                                        'escape'      => false,
                                                                                        'data-toggle' => 'modal',
                                                                                        'data-target' => '#modalBrochureDelete'
                                                                                    )
                                                                                );
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                                <?php if( !empty($this->request->data['DocumentosUser'])): ?>
                                                                    <?php foreach ($this->request->data['DocumentosUser'] as $documento):?>
                                                                        <tr>
                                                                            <td><?= $documento['documento']?></td>
                                                                            <td><?= $this->Html->link(
                                                                                    '<i class="fa fa-download"></i>',
                                                                                    $documento['ruta'],
                                                                                    array('escape'=>false,
                                                                                    'target'      => '_blank')
                                                                                )?>
                                                                            </td>
                                                                            <td>

                                                                                <?=
                                                                                    $this->Html->link(
                                                                                        '<i class="fa fa-trash fa-lg"></i>','#', array(
                                                                                            'escape'      => false,
                                                                                            'data-toggle' => 'modal',
                                                                                            'data-target' => '#modalDocumentoUserDelete',
                                                                                            'onclick'     => "inputValDocumentoUser('".$documento['id']."')"
                                                                                        )
                                                                                    );
                                                                                ?>

                                                                            </td>
                                                                        </tr>
                                                                    <?php endforeach;?>
                                                                <?php endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="row m-t-10">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <?php 
                                                                echo $this->Form->input('youtube', array('label'=>'Video de Youtube','div' => 'col-lg-6','class'=>'form-control'));

                                                                echo $this->Form->input('matterport', array('label'=>'Tour Virtual Matterport','div' => 'col-lg-6','class'=>'form-control'));
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6" onmousedown="return false">
                                                        <label>Subir Imágenes de Inmueble</label>
                                                        <input id="input-fa-inmueble" name="data[fotos][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6" onmousedown="return false">
                                                        <label>Subir Planos Comerciales</label>
                                                        <input id="input-fa-planos" name="data[planos][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <label>Documentos Necesarios para apoyar tu venta</label>
                                                        <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#infoPane" type="button" style="border: none !important;">
                                                                <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                            </button>
                                                        <input id="input-fa-multimedia" name="data[documentos][]" type="file" multiple class="file-loading">
                                                    </div>
                                                    <div class="col-sm-12 col-lg-6">
                                                        <label>Brochure Personalizado</label>
                                                        <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#infoPane" type="button" style="border: none !important;">
                                                                <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                            </button>
                                                        <input id="input-fa-brochure" name="data[brochure][]" type="file" class="file-loading">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de formulario -->
                            <div class="form-actions form-group row m-t-20">
                                <div class="col-xl-6">
                                    <input type="submit" value="Guardar Información y salir" class="btn btn-warning btn-block">
                                </div>
                                <div class="col-xl-6">
                                    <input type="submit" value="Guardar Información y Continuar Editando" class="btn btn-success btn-block" onclick="javascript:document.getElementById('InmuebleReturn').value=1">
                                </div>
                            </div>

                            <?= $this->Form->hidden('cuenta_id', array('value' => $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))) ?>
                            <?= $this->Form->hidden('id') ?>
                            <?= $this->Form->hidden('return') ?>

                        <?= $this->Form->end()?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
<?= $this->Html->script(
    array(
        'components',
        'custom',

        'pages/layouts',
        '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
        '/vendors/twitter-bootstrap-wizard/js/jquery.bootstrap.wizard.min',
        
        '/vendors/tinymce/js/tinymce.min',
        '/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min',
        '/vendors/summernote/js/summernote.min',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/chosen/js/chosen.jquery',
        '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/js/jquery.tagsinput',
        '/vendors/validval/js/jquery.validVal.min',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/datetimepicker/js/DateTimePicker.min',
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
        
    ),
    array('inline'=>true))
?>

<script>

this.default_input_select('<?= empty($this->request->data['Inmueble']['estado_ubicacion']) ? '' : $this->request->data['Inmueble']['estado_ubicacion'] ?>', $("#InmuebleEstadoUbicacion"));
this.default_input_select('<?= empty($this->request->data['Inmueble']['colonia']) ? '' : $this->request->data['Inmueble']['colonia'] ?>', $("#InmuebleColonia"));
this.default_input_select('<?= empty($this->request->data['Inmueble']['ciudad']) ? '' : $this->request->data['Inmueble']['ciudad'] ?>', $("#InmuebleCiudad"));
this.default_input_select('<?= empty($this->request->data['Inmueble']['delegacion']) ? '' : $this->request->data['Inmueble']['delegacion'] ?>', $("#InmuebleDelegacion"));

function default_input_select( value, idInput ){
    $('<option>').val('').text('select');
    $('<option>').val(value).text(value).appendTo(idInput);
    $('.chzn-select').trigger('chosen:updated');
}

function find_cp() {

    if( $("#InmuebleCp").val().length >= 5 ){

        this.clear_select(document.getElementById("InmuebleColonia"));
        this.clear_select(document.getElementById("InmuebleDelegacion"));
        this.clear_select(document.getElementById("InmuebleEstadoUbicacion"));

        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_estados")); ?>', $("#InmuebleEstadoUbicacion"), 'ECC-C-001');
        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_colonias")); ?>', $("#InmuebleColonia"), 'CC-C-002');
        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_ciudad")); ?>', $("#InmuebleCiudad"), 'ECC-C-003');
        this.send_ajax( '<?php echo Router::url(array("controller" => "cps", "action" => "get_delegacion")); ?>', $("#InmuebleDelegacion"), 'ECC-C-004');

        $("#InmuebleCalle").focus();
    }
}

function send_ajax( url, idInput, codigoError){
    
    $.ajax({
        type: "POST",
        url,
        cache: false,
        data: { cp: $('#InmuebleCp').val() },
        dataType: 'json',
        success: function ( response ) {
            $.each(response, function(key, value) {              
                $('<option>').val('').text('select');
                $('<option>').val(key).text(value).appendTo(idInput);
                $('.chzn-select').trigger('chosen:updated');
            });
        },
        error: function ( response ) {
            $("#modal_success").modal('show');
            document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar buscar el CP <br>Código: '+codigoError;
        }
    });

};

function clear_select( id ){
    let length = id.options.length;
    for (i = length-1; i >= 0; i--) {
        id.options[i] = null;
    }
    $('.chzn-select').trigger('chosen:updated');
}

function showLitros(){
    if (document.getElementById('InmuebleCisterna').checked){
        document.getElementById('InmuebleMCisterna').style.display='';
    }else{
    document.getElementById('InmuebleMCisterna').style.display='none';
    }

}

function showElevadores(){
    if (document.getElementById('InmuebleElevadores').checked){
        document.getElementById('InmuebleQElevadores').style.display='';
    }else{
    document.getElementById('InmuebleQElevadores').style.display='none';
    }

}

function showExclusiva(){
    if(document.getElementById('exclusiva').value=="Exclusiva"){
        document.getElementById('fecha_exclusiva').style.display="";
        document.getElementById('fecha_exclusiva2').style.display="";
    }else{
        document.getElementById('fecha_exclusiva').style.display="none";
        document.getElementById('fecha_exclusiva2').style.display="none";
    }
}

function showPrecio(){
    if(document.getElementById('rv').value == "Venta"){
        document.getElementById('precio2').style.display = "none";
        document.getElementById('precio1').style.display = "";
    }else if(document.getElementById('rv').value == "Renta"){
        document.getElementById('precio1').style.display = "none";
        document.getElementById('precio2').style.display = "";
    }else {
        document.getElementById('precio1').style.display="block";
        document.getElementById('precio2').style.display="block";
    }
}

function showPorcentaje(){
    if (document.getElementById('InmuebleCompartir').value === "1"){
        document.getElementById('porcentaje').style.display="";
    }else{
        document.getElementById('porcentaje').style.display="none";
    } 
}

$(".card-collapse").on('show.bs.collapse', function () {
    $(this).prev("div").find("i").removeClass("fa-maximus").addClass("fa-minus");
});

$(".card-collapse").on('hide.bs.collapse', function () {
    $(this).prev("div").find("i").removeClass("fa-minus").addClass("fa-maximus");
});

if(document.getElementById('rv').value == "Venta"){
    document.getElementById('precio2').style.display = "none";
    document.getElementById('precio1').style.display = "";
}else if(document.getElementById('rv').value == "Renta"){
    document.getElementById('precio1').style.display = "none";
    document.getElementById('precio2').style.display = "";
}else {
    document.getElementById('precio1').style.display="block";
    document.getElementById('precio2').style.display="block";
}


$('.fecha').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"bottom"
});

$(".hide_search").chosen({disable_search_threshold: 10});
$(".chzn-select").chosen({allow_single_deselect: true});
$(".chzn-select-deselect,#select2_sample").chosen();
// End of chosen

$("#input-fa").fileinput({
    theme: "fa",
    allowedFileExtensions: ["jpg", "png", "bmp", "tiff", "jpeg"],
});

$("#input-fa-2").fileinput({
    theme: "fa",
});

Admire.formGeneral() ;

$(".textarea").wysihtml5();

$('.airmode').summernote({
    height: 300,
    airMode: true
});

// TinyMCE Full
tinymce.init({
    selector: "#tinymce_full",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    image_advtab: true,
    templates: [{
        title: 'Test template 1',
        content: 'Test 1'
    }, {
        title: 'Test template 2',
        content: 'Test 2'
    }]
});
// Bootstrap
$('#bootstrap-editor').wysihtml5({
    stylesheets: [
        'assets/lib/bootstrap-wysihtml5/stylesheets/bootstrap-wysihtml5wysiwyg-color.css'
    ]
});

$('.summernote_editor').summernote({
    height:200,
    toolbar:[
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['fontsize', ['fontsize']],
        ['para', ['ul', 'ol', 'paragraph']],
    ]
});

$(".wysihtml5-toolbar li:nth-child(3) a,.wysihtml5-toolbar li:nth-child(4) a,.wysihtml5-toolbar li:nth-child(5) a,.wysihtml5-toolbar li:nth-child(6) a").addClass("btn-outline-primary");
$(".wysihtml5-toolbar .btn-group:eq(1) a:first-child,.wysihtml5-toolbar .btn-group:eq(3) a:first-child").addClass("fa fa-list");
$(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(2),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(2)").addClass("fa fa-th-list");
$(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(3),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(3)").addClass("fa fa-align-left");
$(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(4),.wysihtml5-toolbar .btn-group:eq(3) a:nth-child(4)").addClass("fa fa-align-right");
$(".wysihtml5-toolbar li:nth-child(5) span").addClass("fa fa-share");
$(".wysihtml5-toolbar li:nth-child(6) span").addClass("fa fa-picture-o");
$("[data-wysihtml5-command='formatBlock'] span").css("position","relative").css("top","-5px").css("left","-5px");
$(".note-toolbar button").removeClass('btn-default').addClass('btn-secondary');
$(".wysihtml5-toolbar li:nth-child(2) a").removeClass('btn-default').addClass('btn-secondary');


$("#input-fa-inmueble").fileinput({
    theme: "fa",
    allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
    showRemove : false,
    showUpload : false,
    resizeImage: true,
    maxImageWidth: 800,
    maxImageHeight: 800,
    browseLabel: "Escoger Imagen",
});

$("#input-fa-multimedia").fileinput({
    theme: "fa",
    allowedFileExtensions: ["pdf","docx","xlsx","doc","xls"],
    showRemove : false,
    showUpload : false,
    resizeImage: true,
    maxImageWidth: 800,
    maxImageHeight: 800,
    browseLabel: "Escoger Documento",
});

$("#input-fa-planos").fileinput({
    theme: "fa",
    allowedFileExtensions: ["jpg", "png","jpeg","pdf"],
    showRemove : false,
    showUpload : false,
    resizeImage: true,
    maxImageWidth: 800,
    maxImageHeight: 800,
    showBrowse: true,
    uploadAsync: false,
    browseLabel: "Escoger Plano",
});

$("#input-fa-brochure").fileinput({
    theme: "fa",
    allowedFileExtensions: ["pdf"],
    showRemove : false,
    showUpload : false,
    resizeImage: true,
    maxImageWidth: 800,
    maxImageHeight: 800,
    showBrowse: true,
    uploadAsync: false,
    browseLabel: "Escoger Brochure",
});

Admire.formGeneral();

function inputValDocumentoUser(idDocumento){
    console.log(idDocumento);
    $("#DocumentosUserId").val(idDocumento);
}

</script>