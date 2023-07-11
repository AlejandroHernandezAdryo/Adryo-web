<?php
    $interesados = count($desarrollo['Interesados']);
    $count = 0;
    $data_status_prop = array('bloqueados'=>0, 'libres'=>0, 'reserva'=>0, 'contrato'=>0, 'escrituracion'=>0, 'baja'=>0);
    $estados = array(
        0=>'No Liberada',
        1=>'En venta',
        2=>'Vendida'
    );
    echo $this->Html->css(
        array(

            // checkbox
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/switchery/css/switchery.min',
            '/vendors/radio_css/css/radiobox.min',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',

            // Slider images
            
            'pages/widgets',
            
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            'pages/new_dashboard',
            
            // Css Calendario
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',

            // Upload archiv
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',

            //Chosen
            '/vendors/chosen/css/chosen',
            'componentsadryo',
        ),
        array('inline'=>false)); 
?>
<style>
    .btn-group .btn-secondary{ margin: 5px; }
    .flex-center{display: flex ; flex-direction: row ; flex-wrap: wrap ; justify-content: center ; align-items: center ; align-content: center ;}
    .mt-5{margin-top: 5px !important;}
    .modal-dialog-centered{margin-top: 15%;}
    .hidden{display: none;}
    .padding10{
        padding: 10px;
    }
    .danger_bg_dark{
        background: #EA423E;
        color: white;
    }
    .bg-warning{
        background: #ff9933;
        color: white;
    }
    textarea{
        overflow:hidden;
        display:block;
    }
    li {
        list-style-type: circle;
    }
    .panel_datos{
        display: block;
        padding-top: 2px;
    }
    .text-black{
        color: #000 !important;
    }
    .text-center{
        text-align: center;
    }
    #img-principal{
        display: block;
        position: absolute;
        height: 31.5vh;
        width: auto;
    }
    .flex{
        display: flex ;
        flex-direction: column ;
        flex-wrap: wrap ;
        justify-content: center ;
        align-items: center ;
        align-content: space-between ;
    }
    .kv-fileinput-caption{
        height: 29px;
    }
    /* Clase para la tabla de inventario */
    table, tr, td, th {
        border: none !important;
    }
    table th, table td {
        border: none !important;
    }
    .sorting_asc:before, .sorting:before{
        top: 2px !important;
    }
    .sorting_asc:after, .sorting:after{
        top: 4px !important;
    }
    table thead{
        background-color: #E7E7E7;
    }
    .chips{
        border-radius: 5px;
        text-align: center; 
        -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
        -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
        box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
    }
    .disabled {
        background-color: transparent !important;
    }

</style>

<!--Modal Editar Publicidad--->
<div class="modal fade" id="edit_publicidad" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-line-chart"></i>
                    Editar Campaña
                </h4>
            </div>
            <?= $this->Form->create('Publicidad',array('url'=>array('action'=>'editPublicidad','controller'=>'publicidads')))?>
                <div class="modal-body">
                    <?= $this->Form->hidden('id',array('id'=>'id_publicidads'))?>
                    <div class="row form-group">
                        <?= $this->Form->input('dic_linea_contacto_id',
                            array(
                                'class'   => 'form-control chzn-select',
                                'label'   => 'Medio de promoción*',
                                'div'     => 'col-sm-12 col-lg-12',
                                'options' => $lineas_contactos,
                                'empty'   => 'Seleccione una opción',
                                'id'      =>'nombre_publicidads'
                            )); 
                        ?>
                    </div>
                    <div class="row form-group">
                        <?= $this->Form->input('fecha_inicio',
                            array(
                                  'class'        => 'form-control validity',
                                  'label'        => 'Fecha de inicio*',
                                  'div'          => 'col-sm-12 col-lg-6',
                                  'required'     => true,
                                  'autocomplete' => 'off',
                                  'type'         => 'text',
                                  'date-format'  => 'dd-mm-yyyy',
                                  'id'           =>'fecha_inicio_publicidads'
                            )); 
                        ?>
                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label">Inversión mensual*</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('inversion_prevista', array(
                                    'label'      => false, 
                                    'div'        => false, 
                                    'class'      => 'form-control',
                                    'id'         =>'inversion_prevista_publicidads',
                                    'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 
                                    'onkeyup'    => 'totInversion()',
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <?= $this->Form->input('meses',
                            array(
                                'class'    => 'form-control chzn-select',
                                'id'      =>'odjetivo_publicidads',
                                'label'    => 'Meses activos de la publicidad*',
                                'div'      => 'col-sm-12 col-lg-6',
                                'options'  => $inversion_meses,
                                'onchange' => 'totInversion()',
                                'empty'    => 'Seleccione una opción',
                            ));
                        ?>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label" id="LabelUserPassword">Total de inversión</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('tot_inversion', array(
                                    'label' => false, 
                                    'div' => false, 
                                    'class'=> 'form-control disabled', 
                                    'disabled' => true ,
                                    'id'      =>'inversion_real_publicidads'
                                    )); 
                                ?>
                            </div>
                        </div>
                    </div>      
                </div>
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn btn-success float-xs-right">
                        Guardar cambios
                    </button> -->
                    <button type="button" class="btn btn-success float-xs-right" onclick='editPublicidadGuardado()'>
                        Guardar cambios
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'])); ?>
        <?= $this->Form->end()?>
    </div>
</div>
<!-- Modales -->
<div class="modal fade" id="publicidad" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-line-chart"></i>
                    Registrar campaña
                </h4>
            </div>
            <?= $this->Form->create('Publicidad',array('url'=>array('action'=>'add_desarrollo','controller'=>'publicidads')))?>
                <div class="modal-body">
                    
                    <div class="row form-group">
                        <?= $this->Form->input('dic_linea_contacto_id',
                            array(
                                'class'   => 'form-control chzn-select',
                                'label'   => 'Medio de promoción*',
                                'div'     => 'col-sm-12 col-lg-12',
                                'options' => $lineas_contactos,
                                'empty'   => 'Seleccione una opción'
                            )
                        ); ?>


                    </div>

                    <div class="row form-group">
                        
                        <?= $this->Form->input('fecha_inicio',
                            array(
                                  'class'        => 'form-control fecha_campania',
                                  'label'        => 'Fecha de inicio*',
                                  'div'          => 'col-sm-12 col-lg-6',
                                  'required'     => true,
                                  'autocomplete' => false,
                                  'type'         => 'text'
                            )
                        ); ?>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label">Inversión mensual*</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('inversion_prevista', array('label' => false, 'div' => false, 'class'=> 'form-control','onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'onkeyup' => 'totInversion()',)) ?>
                            </div>
                        </div>

                        

                    </div>

                    <div class="row form-group">
                        <?= $this->Form->input('meses',
                            array(
                                'class'    => 'form-control chzn-select',
                                'label'    => 'Meses activos de la publicidad*',
                                'div'      => 'col-sm-12 col-lg-6',
                                'options'  => $inversion_meses,
                                'onchange' => 'totInversion()',
                                'empty'    => 'Seleccione una opción'
                            )
                        ); ?>

                        <div class="col-sm-12 col-lg-6">
                            <label class="form-control-label" id="LabelUserPassword">Total de inversión</label>
                            <div class="input-group">
                                <span class="input-group-addon"  style="background: transparent; border-right-style: none !important;">
                                    <i class="fa fa-dollar"></i>
                                </span>
                                <?= $this->Form->input('tot_inversion', array('label' => false, 'div' => false, 'class'=> 'form-control disabled', 'disabled' => true )) ?>
                            </div>
                        </div>
                    </div>
                            
                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right">
                        Registrar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'])); ?>
        <?= $this->Form->end()?>
    </div>
</div>
<!-- Modal agregar plan de pago al desarrollo -->
<div class="modal fade" id="add_plan" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-money"></i>
                    Registrar plan de pago
                </h4>
            </div>
            <?= $this->Form->create('PlanesDesarrollo',array('url'=>array('action'=>'add','controller'=>'planes_desarrollos')))?>
                <div class="modal-body">
                    
                    <div class="row form-group">
                        <?= $this->Form->input('alias',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Nombre de Plan de Pago*',
                                'div'     => 'col-sm-6 col-lg-6',
                            )
                        ); ?>
                    
                        <?= $this->Form->input('vigencia',
                            array(
                                'class'   => 'form-control fecha_vigencia_plan',
                                'label'   => 'Vigencia hasta',
                                'div'     => 'col-sm-6 col-lg-6',
                                'type'    =>'text'
                            )
                        ); ?>
                    </div>
                    
                    <!-- Descuentos en monto y porcentajes -->
                    <div class="row form-group">

                        <div class="col-sm-12 col-lg-12 pt-2">
                            <label> ¡ El descuento se restará del precio de lista de la unidad !  </label>
                            <label for="advertencia % y $" class="text-warning"> Los campos se pueden cambiar segun las necesidades del plan de pagos, en % o $ dando clic sobre los iconos de % y $</label>
                        </div>

                        <!-- Descuento -->
                        <div class="col-sm-12 col-lg-6">
                            <label for="descuento">
                                Descuento en <span onclick="cambioDescuento(1)" id="span_desc_p" class="text-primary pointer">(%)</span> o <span class="pointer" id="span_desc_q" onclick="cambioDescuento(2)">($)</span>
                            </label>
                            
                            <?= $this->Form->input('descuento',
                                array(
                                    'class'       => 'form-control',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '%'
                                )
                            ); ?>

                            <?= $this->Form->input('descuento_q',
                                array(
                                    'class'       => 'form-control hidden',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '$'
                                )
                            ); ?>
                        </div>
                        
                        <!-- Apartado -->
                        <div class="col-sm-12 col-lg-6">
                            <label for="apartado">
                                Apartado en <span onclick="cambioApartado(1)" id="span_apartado_p" class="text-primary pointer">(%)</span> o <span id = "span_apartado_q" class="pointer" onclick="cambioApartado(2)">($)</span>
                            </label>
                            <?= $this->Form->input('apartado',
                                array(
                                    'class'       => 'form-control',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '%'
                                )
                            ); ?>

                            <?= $this->Form->input('apartado_q',
                                array(
                                    'class'       => 'form-control hidden',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '$'
                                )
                            ); ?>
                        </div>

                    </div>

                    <!-- Sumatoria de los campos -->
                    <div class="row form-group">
                        <?= $this->Form->input('contrato',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Contrato / enganche (%)',
                                'div'     => 'col-sm-12 col-lg-3',
                                'type'    => 'text',
                                'onkeyup' => 'validaTotal()'
                            )
                        );?>

                        <?= $this->Form->input('financiamiento',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Financiamiento Aplazado / Diferido (%)',
                                'div'     => 'col-sm-12 col-lg-5',
                                'type'    => 'text',
                                'onkeyup' => 'validaTotal()'
                            )
                        );?>

                        <?= $this->Form->input('escrituracion',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Escrituración (%)',
                                'div'     => 'col-sm-12 col-lg-2',
                                'type'    =>'text',
                                'onkeyup' => 'validaTotal()'
                            )
                        );?>

                        <?= $this->Form->input('total',
                            array(
                                'class'    => 'form-control',
                                'label'    => 'Total (%)',
                                'div'      => 'col-sm-12 col-lg-2',
                                'type'     => 'text',
                                'disabled' => true
                            )
                        );?>

                    </div>

                    <div class="row form-group">
                        <?= $this->Form->input('observaciones_publicas',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Observaciones Públicas',
                                'div'     => 'col-sm-12',
                                'type'    =>'textarea',
                                'rows'=>"2"
                            )
                        );?>
                    </div>

                    <div class="row form-group">
                        <?= $this->Form->input('observaciones_internas',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Observaciones internas',
                                'div'     => 'col-sm-12',
                                'type'    =>'textarea',
                                'rows'=>"2"
                            )
                        );?>
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
            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'])); ?>
            <?= $this->Form->hidden('status', array('value'=>1)); ?>
        <?= $this->Form->end()?>
    </div>
</div>

<div class="modal fade" id="disabled_plan" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-sm moda-center">
        <div class="modal-content">

            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    Deshabilitar plan de pagos
                </h4>
            </div>

                <div class="modal-body">
                    <h1 class="text-black text-sm-center" id="labelDisabledPlan"> </h1>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-success float-xs-right" onclick="fDisabledPlan()">
                        Confirmar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
            <?= $this->Form->hidden('disabledPlanId'); ?>
            <?= $this->Form->hidden('disabledPlanStatus'); ?>
    </div>
</div>

<div class="modal fade" id="enable_plan" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-sm moda-center">
        <div class="modal-content">

            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    Habilitar plan de pagos
                </h4>
            </div>
                <?= $this->Form->create('EnablePlan') ?>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <p id="mensaje-enable-plan"></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <?= $this->Form->input('fecha_nueva',
                                array(
                                    'class' => 'form-control hidden vigencia_nueva',
                                    'div'   => 'col-sm-12',
                                    'label' => false,
                                )
                            );
                            ?>
                        </div>
                        
                    </div>
                
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success float-xs-right">
                            Confirmar
                        </button>
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                <?= $this->Form->end(); ?>
            </div>
            <?= $this->Form->hidden('enablePlanId'); ?>
            <?= $this->Form->hidden('enablePlanStatus'); ?>
    </div>
</div>
<!-- Modal editar plan de pago al desarrollo -->
<div class="modal fade" id="edit_plan" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-money"></i>
                    Edición de plan de pago
                </h4>
            </div>
            <?= $this->Form->create('PlanesDesarrolloEdit')?>
                <div class="modal-body">
                    
                    <div class="row form-group">
                        <?= $this->Form->input('alias',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Nombre de Plan de Pago*',
                                'div'     => 'col-sm-6 col-lg-6',
                            )
                        ); ?>
                    
                        <?= $this->Form->input('vigencia',
                            array(
                                'class'   => 'form-control fecha_vigencia_plan',
                                'label'   => 'Vigencia hasta',
                                'div'     => 'col-sm-6 col-lg-6',
                                'type'    =>'text'
                            )
                        ); ?>
                    </div>
                    
                    <!-- Descuentos en monto y porcentajes -->
                    <div class="row form-group">

                        <div class="col-sm-12 col-lg-12 pt-2">
                            <label> ¡ El descuento se restará del precio de lista de la unidad !  </label>
                            <label for="advertencia % y $" class="text-warning"> Los campos se pueden cambiar segun las necesidades del plan de pagos, en % o $ dando clic sobre los iconos de % y $</label>
                        </div>

                        <!-- Descuento -->
                        <div class="col-sm-12 col-lg-6">
                            <label for="descuento">
                                Descuento en
                                    <span onclick="cambioDescuento(1, 2)" id="span_desc_p_edit" class="text-primary pointer">(%)</span> o 
                                    <span class="pointer" id="span_desc_q_edit" onclick="cambioDescuento(2, 2)">($)</span>
                            </label>
                            
                            <?= $this->Form->input('descuento',
                                array(
                                    'class'       => 'form-control',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '%'
                                )
                            ); ?>

                            <?= $this->Form->input('descuento_q',
                                array(
                                    'class'       => 'form-control hidden',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '$'
                                )
                            ); ?>
                        </div>
                        
                        <!-- Apartado -->
                        <div class="col-sm-12 col-lg-6">
                            <label for="apartado">
                                Apartado en 
                                <span onclick="cambioApartado(1, 2)" id="span_apartado_p_edit" class="text-primary pointer">(%)</span> o 
                                <span id = "span_apartado_q_edit" class="pointer" onclick="cambioApartado(2, 2)">($)</span>
                            </label>
                            <?= $this->Form->input('apartado',
                                array(
                                    'class'       => 'form-control',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '%'
                                )
                            ); ?>

                            <?= $this->Form->input('apartado_q',
                                array(
                                    'class'       => 'form-control hidden',
                                    'label'       => false,
                                    'div'         => false,
                                    'type'        => 'text',
                                    'placeholder' => '$'
                                )
                            ); ?>
                        </div>

                    </div>

                    <!-- Sumatoria de los campos -->
                    <div class="row form-group">
                        <?= $this->Form->input('contrato',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Contrato / enganche (%)',
                                'div'     => 'col-sm-12 col-lg-3',
                                'type'    => 'text',
                                'onkeyup' => 'validaTotalEdit()'
                            )
                        );?>

                        <?= $this->Form->input('financiamiento',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Financiamiento Aplazado / Diferido (%)',
                                'div'     => 'col-sm-12 col-lg-5',
                                'type'    => 'text',
                                'onkeyup' => 'validaTotalEdit()'
                            )
                        );?>

                        <?= $this->Form->input('escrituracion',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Escrituración (%)',
                                'div'     => 'col-sm-12 col-lg-2',
                                'type'    =>'text',
                                'onkeyup' => 'validaTotalEdit()'
                            )
                        );?>

                        <?= $this->Form->input('total',
                            array(
                                'class'    => 'form-control',
                                'label'    => 'Total (%)',
                                'div'      => 'col-sm-12 col-lg-2',
                                'type'     => 'text',
                                'disabled' => true
                            )
                        );?>

                    </div>

                    <div class="row form-group">
                        <?= $this->Form->input('observaciones_publicas',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Observaciones Públicas',
                                'div'     => 'col-sm-12',
                                'type'    =>'textarea',
                                'rows'=>"2"
                            )
                        );?>
                    </div>

                    <div class="row form-group">
                        <?= $this->Form->input('observaciones_internas',
                            array(
                                'class'   => 'form-control',
                                'label'   => 'Observaciones internas',
                                'div'     => 'col-sm-12',
                                'type'    =>'textarea',
                                'rows'=>"2"
                            )
                        );?>
                    </div>

                </div>
            
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success float-xs-right" id="registrarEdit">
                        Registrar
                    </button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo['Desarrollo']['id'])); ?>
            <?= $this->Form->hidden('id'); ?>
        <?= $this->Form->end()?>
    </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title text-black">Galeria de Imagenes</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <?php foreach ($desarrollo['FotoDesarrollo'] as $pics): ?>
                <?php $count ++ ?>
                <div class="col-sm-12">
                    <?php echo $this->Html->image($pics['ruta'], array('class'=>'img-fluid', 'id'=>'galeria-'.$count, 'style'=>'display:none;')) ?>
                </div>
            <?php endforeach ?>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar &times;</button>
      </div>
    </div>
  </div>
</div>

<div id="archivos" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <?= $this->Form->create('Desarrollo',array('url'=>array('action'=>'send_attach')))?>
      <div class="modal-header">
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 class="modal-title text-black">Enviar archivos a cliente</h4>
      </div>
      <div class="modal-body">

        <div class="row">
            <div class="col-xl-3 text-xl-left m-t-15">
                    <label for="cliente" class="form-control-label">Cliente relacionado</label>
            </div>
            <?= $this->Form->input('cliente_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin cliente asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$clientes_list))?>
            <table class="table">
                        <thead>
                        <tr>
                            <th width="80%"><b>Documento</b></th>
                            <th width="20%"><b>Seleccionar</b></th>
                            
                        </tr>
                        </thead>
                        
                        <tbody>
                           <?php $i = 0 ?>
                           <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
                                <tr>
                                    <td><?= $documento['documento']?></td>
                                    <td>
                                        <?= $this->Form->input('seleccionar'.$i,array('type'=>'checkbox','label'=>false))?>
                                    </td>
                                    
                                </tr>
                             <?php $i++?>
                            <?php endforeach;?>
                        </tbody>
                    </table>
        </div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar &times;</button>
      </div>
    </div>
    <?= $this->Form->end(); ?>
  </div>
</div>

<div class="modal fade" id="fotos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Fotografías del Desarrollo
                </h4>
            </div>
            <div class="modal-body">
            <?php 
                foreach ($desarrollo['FotoDesarrollo'] as $imagen):
            ?>
            <div class="col-lg-6 m-t-20">
                <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/',true).$imagen['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$imagen['ruta']; ?>')">
                </div>
                <div class="col-xs-12">
                    <?= $imagen['descripcion']?>
                </div>
            </div>
            <?php 
                endforeach;
            ?>    
            </div>
            <div class="row modal-footer">
                
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="planos" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-picture"></i>
                    Planos comerciales del Desarrollo
                </h4>
            </div>
            <div class="modal-body">
            <?php 
                foreach ($desarrollo['Planos'] as $imagen):
            ?>
            <div class="col-lg-6 m-t-20">
                <div class="col-sm-12" style="height:200px;background-image: url('<?= Router::url('/', true).$imagen['ruta']; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?= Router::url('/',true).$imagen['ruta']; ?>')">
                </div>
                <div class="col-xs-12">
                    <?= $imagen['descripcion']?>
                </div>
            </div>
            <?php 
                endforeach;
            ?>    
            </div>
            <div class="row modal-footer">
                
            </div>
            
        </div>
    </div>
</div>
<!-- Modal add cta bancaria desarrollo -->
<div id="modalAddCtaBancaria" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <?= $this->Form->Create('CuentasBancariasDesarrollo'); ?>
                <div class="modal-header bg-blue-is">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel1">
                        <i class="fa fa-plus"></i>
                        Agregar cuenta bancaria
                    </h4>
                </div>
            
                <div class="modal-body">
                    
                    <div class="row">
                        <?= $this->Form->input('nombre_cuenta',
                            array(
                                'class' => 'form-control',
                                'label' => 'Nombre de la cuenta*',
                                'div'   => 'col-sm-12 col-lg-6 mt-1',
                                'required'
                            )
                        ); ?>

                        <?= $this->Form->input('tipo',
                            array(
                                'class' => 'form-control',
                                'label' => 'Tipo de cuenta*',
                                'div'   => 'col-sm-12 col-lg-6 mt-1',
                                'required'
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('banco',
                            array(
                                'class' => 'form-control',
                                'label' => 'Banco*',
                                'div'   => 'col-sm-12 col-lg-6 mt-1',
                                'required'
                            )
                        ); ?>

                        <?= $this->Form->input('numero_cuenta',
                            array(
                                'class' => 'form-control',
                                'label' => 'Numero de cuenta*',
                                'div'   => 'col-sm-12 col-lg-6 mt-1',
                                'required'
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('spei',
                            array(
                                'class' => 'form-control',
                                'label' => 'Cuenta Clabe*',
                                'div'   => 'col-sm-12 mt-1',
                                'required',
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('instrucciones',
                            array(
                                'class' => 'form-control',
                                'label' => 'Instrucciones*',
                                'div'   => 'col-sm-12 mt-1',
                                'type'  => 'textarea',
                                'required'
                            )
                        ); ?>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cerrar</button>

                    <?= $this->Form->button('Agregar cuenta', array(
                        'class'   => 'btn btn-success float-xs-right',
                        'type'    => 'submit'
                    )); ?>

                </div>
                <?= $this->Form->hidden('desarrollo_id'); ?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<!-- Modal delete cta bancaria desarrollos -->
<div id="modalDeleteCtaBancaria" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="text-center text-black">
                        ¿ Esta seguro que desea ELIMINAR la cuenta <span id = "nameCtaBancariaDelete" ></span> ?
                    </h3>
                </div>
            </div>
            <!-- Form delete cliente -->
            <?php
                echo $this->Form->create('CuentasBancariasDesarrolloDelete');
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
<!-- Modal edit cta bancaria -->
<div id="modalEditCtaBancaria" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <?= $this->Form->Create('CuentasBancariasDesarrolloEdit'); ?>
                <div class="modal-header bg-blue-is">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel1">
                        <i class="fa fa-edit"></i>
                        Edicion de cuenta bancaria
                    </h4>
                </div>
            
                <div class="modal-body">
                    
                    <div class="row">
                        <?= $this->Form->input('nombre_cuenta',
                            array(
                                'class'     => 'form-control',
                                'label'     => 'Nombre de la cuenta*',
                                'div'       => 'col-sm-12 col-lg-6 mt-1',
                                'maxlength' => 30,
                                'required'
                            )
                        ); ?>

                        <?= $this->Form->input('tipo',
                            array(
                                'class'     => 'form-control',
                                'label'     => 'Tipo de cuenta*',
                                'div'       => 'col-sm-12 col-lg-6 mt-1',
                                'maxlength' => 11,
                                'required'
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('banco',
                            array(
                                'class'     => 'form-control',
                                'label'     => 'Banco*',
                                'div'       => 'col-sm-12 col-lg-6 mt-1',
                                'maxlength' => 11,
                                'required'
                            )
                        ); ?>

                        <?= $this->Form->input('numero_cuenta',
                            array(
                                'class'     => 'form-control',
                                'label'     => 'Numero de cuenta*',
                                'div'       => 'col-sm-12 col-lg-6 mt-1',
                                'maxlength' => 18,
                                'required'
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('spei',
                            array(
                                'class'     => 'form-control',
                                'label'     => 'Numero de SPEI*',
                                'div'       => 'col-sm-12 mt-1',
                                'maxlength' => 45,
                                'required'
                            )
                        ); ?>
                    </div>

                    <div class="row">
                        <?= $this->Form->input('instrucciones',
                            array(
                                'class' => 'form-control',
                                'label' => 'Instrucciones*',
                                'div'   => 'col-sm-12 mt-1',
                                'type'  => 'textarea',
                                'required'
                            )
                        ); ?>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cerrar</button>

                    <?= $this->Form->button('Guardar cambios', array(
                        'class'   => 'btn btn-success float-xs-right',
                        'type'    => 'submit'
                    )); ?>

                </div>
                <?= $this->Form->hidden('id'); ?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<!-- Modal add propiedad extra de desarrollo -->
<div id="modalAddExtra" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->Create('ExtrasDesarrollo',array('url'=>array('action'=>'addExtra','controller'=>'desarrollos'))); ?>
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-plus"></i>
                    Agregar Extra para desarrollo
                </h4>
            </div>

            <div class="modal-body">

                <div class="row">
                    <?= $this->Form->input('nombre',
                        array(
                            'class' => 'form-control',
                            'label' => 'Nombre*',
                            'div'   => 'col-sm-12 col-lg-6 mt-1',
                            'required'
                        )
                    ); ?>

                    <?= $this->Form->input('precio_venta',
                        array(
                            'class' => 'form-control',
                            'label' => 'Precio de Venta*',
                            'div'   => 'col-sm-12 col-lg-3 mt-1',
                            'required',
                            'type'  => 'number',
                            'min'   => 0,
                        )
                    ); ?>

                    <?= $this->Form->input('status',
                        array(
                            'class' => 'form-control',
                            'label' => 'Estatus de Extra*',
                            'div'   => 'col-sm-12 col-lg-3 mt-1',
                            'required',
                            'type'  => 'select',
                            'options'=>$estados,
                                                    )
                    ); ?>
                </div>

                <div class="row">
                    <?= $this->Form->input('descripcion',
                        array(
                            'class' => 'form-control',
                            'label' => 'Descripción',
                            'div'   => 'col-sm-12 col-lg-12 mt-1',
                            'type'  => 'textarea'
                        )
                    ); ?>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cerrar</button>

                <?= $this->Form->button('Agregar Extra', array(
                    'class'   => 'btn btn-success float-xs-right',
                    'type'    => 'submit'
                )); ?>

            </div>
            <?= $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo['Desarrollo']['id'])); ?>
            <?= $this->Form->hidden('status',array('value'=>0)); ?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<!-- Modal add propiedad extra de desarrollo -->
<div id="modalEditExtra" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <?= $this->Form->Create('ExtrasDesarrollo',array('url'=>array('action'=>'addExtra','controller'=>'desarrollos'))); ?>
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel1">
                    <i class="fa fa-edit"></i>
                    Modificar Propiedad Extra
                </h4>
            </div>

            <div class="modal-body">

                <div class="row">
                    <?= $this->Form->input('nombre',
                        array(
                            'class' => 'form-control',
                            'label' => 'Nombre*',
                            'div'   => 'col-sm-12 col-lg-6 mt-1',
                            'required',
                            'id'    => 'nombre_extra_edit'
                        )
                    ); ?>

                    <?= $this->Form->input('precio_venta',
                        array(
                            'class' => 'form-control',
                            'label' => 'Precio de Venta*',
                            'div'   => 'col-sm-12 col-lg-3 mt-1',
                            'required',
                            'type'  => 'number',
                            'min'   => 0,
                            'id'    => 'precio_venta_extra_edit'
                        )
                    ); ?>

                    <?= $this->Form->input('status',
                        array(
                            'class' => 'form-control',
                            'label' => 'Estatus de Extra*',
                            'div'   => 'col-sm-12 col-lg-3 mt-1',
                            'required',
                            'type'  => 'select',
                            'options'=>$estados,
                            'id'    => 'estatus_extra_edit'
                        )
                    ); ?>
                </div>

                <div class="row">
                    <?= $this->Form->input('descripcion',
                        array(
                            'class' => 'form-control',
                            'label' => 'Descripción',
                            'div'   => 'col-sm-12 col-lg-12 mt-1',
                            'type'  => 'textarea',
                            'id'    => 'descripcion_extra_edit'
                        )
                    ); ?>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cerrar</button>

                <?= $this->Form->button('Modificar Extra', array(
                    'class'   => 'btn btn-success float-xs-right',
                    'type'    => 'submit'
                )); ?>

            </div>
            <?= $this->Form->hidden('id',array('id'=>'id_edit_extra')); ?>
            <?= $this->Form->hidden('desarrollo_id',array('value'=>$desarrollo['Desarrollo']['id'])); ?>
            <?= $this->Form->end(); ?>

        </div>
    </div>
</div>
<!-- Modal para las operaciones del inmueble -->
<?= $this->element('Desarrollos/operaciones_inmueble'); ?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-5 col-xs-12">
                <h4 class="nav_top_align">
                    <!-- <i class="fa fa-home" aria-hidden="true"></i> -->
                    Desarrollos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-container">
            <!-- Cabecera de datos del desarrollo -->
            <div class="card">
                <div class="card-header bg-blue-is">
                    <?php  echo $desarrollo['Desarrollo']['nombre']." / ".$desarrollo['Desarrollo']['referencia']?>
                        <div style="float:right">
                        <?php 
                            if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']) {
                                if ($this->Session->read('Permisos.Group.id')==1 ||($desarrollo['EquipoTrabajo']['administrador_id']=="" && $this->Session->read('Permisos.Group.id')==2) ||$desarrollo['EquipoTrabajo']['administrador_id']==$this->Session->read('Auth.User.id')){
                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit_generales',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR DESARROLLO','escape'=>false,'style'=>'color:white'));
                                }elseif( $this->Session->read('Permisos.Group.id') == 5 ){
                                    echo $this->Html->link('<i class="fa fa-edit fa-2x"></i>','#', array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR DESARROLLO','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));
                                }
                            } 
                            echo $this->Html->link('<i class="fa fa-home fa-2x"></i>',array('action'=>'detalle',$desarrollo['Desarrollo']['id'],$this->Session->read('Auth.User.id')),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'VER FICHA TÉCNICA PÚBLICA','escape'=>false,'style'=>'color:white'));
                            if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']) {
                                if ($this->Session->read('Permisos.Group.id')==1){
                                    echo $this->Html->link('<i class="fa fa-briefcase fa-2x"></i>',array('action'=>'asignar_corretaje',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'ASIGNAR A EMPRESA DE COMERCIALIZACIÓN','escape'=>false,'style'=>'color:white'));
                                    echo $this->Html->link('<i class="fa fa-external-link-square fa-2x"></i>',array('action'=>'cambiar_titular',$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'TRANSFERIR DESARROLLO A OTRA CUENTA','escape'=>false,'style'=>'color:white'));
                                }elseif( $this->Session->read('Permisos.Group.id') == 5 ){
                                    echo $this->Html->link('<i class="fa fa-briefcase fa-2x"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'ASIGNAR A EMPRESA DE COMERCIALIZACIÓN','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));
                                    echo $this->Html->link('<i class="fa fa-external-link-square fa-2x"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'TRANSFERIR DESARROLLO A OTRA CUENTA','escape'=>false,'style'=>'color: #bababa; cursor:not-allowed !important;'));
                                }
                            }
                        ?>
                        </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12 col-lg-9">
                            <div class="card" >
                                <div class="card-header bg-blue-is">
                                    <?php echo $desarrollo['Desarrollo']['calle'] . " " . $desarrollo['Desarrollo']['numero_ext'] . " " . $desarrollo['Desarrollo']['numero_int'] . " " . $desarrollo['Desarrollo']['colonia']?>
                                    <?php echo $desarrollo['Desarrollo']['ciudad'] . " " . $desarrollo['Desarrollo']['estado'] . " CP: " . $desarrollo['Desarrollo']['cp']?>
                                    
                                    <div style="float:right">
                                        <?php
                                          $shared_desarrollo = Router::url('/Desarrollos/detalle/'.$desarrollo['Desarrollo']['id'],true);
                                        ?>
                                        <?= $this->Html->link(
                                            '<i class="fa fa-facebook fa-lg"></i>',
                                            'http://www.facebook.com/sharer.php?u='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>

                                        <?= $this->Html->link(
                                            '<i class="fa fa-twitter fa-lg"></i>',
                                            'https://twitter.com/intent/tweet?text='." Les comparto este increíble desarrollo vía @adryo_ai ".$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                        

                                        <?= $this->Html->link(
                                            '<i class="fa fa-linkedin fa-lg"></i>',
                                            'https://www.linkedin.com/shareArticle?url='.$shared_desarrollo,
                                            array('escape'=>false, 'class'=>'rdsociales', 'target'=>'_blank')
                                        )?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Col logo desarrollo -->
                        <div class="col-sm-4 col-lg-3 flex-center">
                            <?php if (!empty($desarrollo['Desarrollo']['logotipo'])): ?>
                                <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('class'=>'img-fluid', 'style'=>'max-width: 70%;'))?>
                            <?php else: ?>
                                <div class="text-center text-danger">
                                    <h4 class="text-danger">
                                        ¡Falta Logotipo del desarrollo!
                                    </h4>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Direcciones -->

                    <div class="row" style="width:101%">
                        
                        <div class="col-lg-4 m-t-10">
                            <?php
                                $foto = ( isset($desarrollo['FotoDesarrollo'][0])?$desarrollo['FotoDesarrollo'][0]['ruta']:'/img/inmueble_no_photo.png') 
                            ?>

                            <div class="col-sm-12" style="height:35vh;background-image: url('<?php echo Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: zoom-in;" onclick="window.open('<?php echo Router::url('/',true).$foto ?>');">
                            </div>
                        </div>
                        <div class="col-lg-5 m-t-10">
                            <div class="row m-t-20">
                                <div class="col-lg-12" style="text-align:left;">
                                    <h3><font color="black"><b>Características Generales</b></font></h3>
                                </div>

                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <?= $this->Html->image('m2.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                    <?= $this->Html->image('recamaras.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['rec_low']?> - <?= $desarrollo['Desarrollo']['rec_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6"  style="text-align:center;">
                                    <?= $this->Html->image('banios.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['banio_low']?> - <?= $desarrollo['Desarrollo']['banio_top']?></p>
                                </div>
                                <div class="col-lg-3 col-xs-6" style="text-align:center;">
                                    <?= $this->Html->image('autos.png',array('width'=>'70%'))?>
                                    <p><?= $desarrollo['Desarrollo']['est_low']?> - <?= $desarrollo['Desarrollo']['est_top']?></p>
                                </div>                                
                            </div>
                            <div class="row m-t-30">
                                <div class="col-lg-12" style="text-align:left;">
                                    <h3><font color="black"><b>GALERÍA MULTIMEDIA</b></font></h3>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        GALERÍA
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#fotos" id="target-modal">
                                        <?php $foto = (sizeof($desarrollo['FotoDesarrollo'])>0?$desarrollo['FotoDesarrollo'][0]['ruta']:'/img/inmueble_no_photo.png')?>
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true).$foto; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; ">
                                        </div>
                                    </a>
                                    <div class="col-sm-12">
                                        <small><?= sizeof($desarrollo['FotoDesarrollo'])." Fotos"?></small>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        PLANOS
                                    </div>
                                    <a href="#" data-toggle="modal" data-target="#planos" id="target-modal">
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= (sizeof($desarrollo['Planos'])? Router::url('/',true).$desarrollo['Planos'][0]['ruta']:Router::url('/',true)."/img/no_photo_inmuebles.png"); ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" >
                                        </div>
                                    </a>
                                    <div class="col-sm-12">
                                        <small><?= sizeof($desarrollo['Planos'])." Planos"?></small>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                    <div class="col-sm-12">
                                        BROCHURE
                                    </div>
                                    <?php 
                                    $img_brochure="";
                                    if($desarrollo['Desarrollo']['brochure']!=""){
                                        $img_brochure='brochure.png';
                                    }else{
                                        $img_brochure='no_brochure.png';
                                    }
                                    ?>
                                    <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true); ?>/img/<?= $img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($desarrollo['Desarrollo']['brochure']==""?"#": Router::url($desarrollo['Desarrollo']['brochure'], true))?>')">
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <small><?= ($desarrollo['Desarrollo']['brochure']==""?"No":"1 Archivo")?></small>
                                    </div>
                                </div>
                                
                                <!-- Video de youtube -->
                                <?php if ($desarrollo['Desarrollo']['youtube'] != ''): ?>
                                    <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                        <div class="col-sm-12">
                                            YOUTUBE
                                        </div>
                                        <?php 
                                        $img_brochure="";
                                        if($desarrollo['Desarrollo']['youtube']!=""){
                                            $img_brochure='video.png';
                                        }else{
                                            $img_brochure='no_video.png';
                                        }
                                        ?>
                                        <div class="col-sm-12" style="height:60px;background-image: url('<?= Router::url('/',true); ?>/img/<?= $img_brochure; ?>'); background-position:center center; background-repeat:no-repeat; background-size:cover; cursor: pointer;" onclick="window.open('<?php echo ($desarrollo['Desarrollo']['youtube']==""?"#": $desarrollo['Desarrollo']['youtube'])?>')">
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <small><?= ($desarrollo['Desarrollo']['youtube']==""?"No":"1 Archivo")?></small>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($desarrollo['Desarrollo']['matterport'] != ''): ?>
                                    <div class="col-lg-3 col-xs-6 "style="text-align:center;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                MATTERPORT
                                            </div>

                                            <div class="col-sm-12">
                                                <?= $this->Html->link($this->Html->image('/img/matterport_logo.png', array('class'=>'img-fluid')), $desarrollo['Desarrollo']['matterport'], array('escape'=> false, 'target'=>'blank')) ?>
                                            </div>
                                            <div class="col-sm-12">
                                                <small><?= ($desarrollo['Desarrollo']['matterport']==""?"No":"1 Archivo")?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                        <div class="col-lg-3 m-t-10" style="text-align:left; background-color: #f5f5f5">
                            <div class="row m-t-10">
                                <table style="width:100%">
                                    <?php if (!empty($desarrollo['Comercializador'])){?>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comercializadora: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= $desarrollo['Comercializador']['nombre_comercial']?></b></td>
                                    </tr>
                                    <?php }?>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Equipo: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $this->Html->link($desarrollo['EquipoTrabajo']['nombre_grupo'],array('controller'=>'GruposUsuarios','action'=>'view',$desarrollo['EquipoTrabajo']['id'])))?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Privado: </td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?></b></tr>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Tipo de Desarrollo:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['tipo_desarrollo']=="&nbsp;"?"":$desarrollo['Desarrollo']['tipo_desarrollo'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Etapa:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['etapa_desarrollo']==""?"&nbsp;":$desarrollo['Desarrollo']['etapa_desarrollo'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Torres:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['torres']==""?"&nbsp;":$desarrollo['Desarrollo']['torres'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Unidades Totales:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['unidades_totales']==""?"&nbsp;":$desarrollo['Desarrollo']['unidades_totales'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Disponibilidad:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= sizeof($desarrollo['Disponibles'])?>/<?= sizeof($desarrollo['Propiedades'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Entrega:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata"?"Inmediata":date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Exclusividad:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?php 
                                        if ($desarrollo['Desarrollo']['exclusividad']=="No"){
                                          echo "No";  
                                        }else{
                                         echo date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_inicio_exclusiva']))." al ".date('d/M/Y', strtotime($desarrollo['Desarrollo']['fecha_exclusiva']));
                                        }
                                        ?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comisión:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['comision']==""?"No / 0%":$desarrollo['Desarrollo']['comision']."%")?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Comparte:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['compartir']==""?"No / 0 %":"Si / ".$desarrollo['Desarrollo']['porcentaje_compartir']."%")?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Departamento Muestra:</td>
                                        <td>
                                            <?php
                                                $boolean = array (1=>"Si",2=>'No');
                                                echo $boolean[$desarrollo['Desarrollo']['departamento_muestra']];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Horario Atención:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= ($desarrollo['Desarrollo']['horario_contacto']==""?"&nbsp;":$desarrollo['Desarrollo']['horario_contacto'])?></b></td>
                                    </tr>
                                    <tr>
                                        <td style="width:50%; vertical-align: top;">Objetivo de Ventas:</td>
                                        <td style="width:50%; vertical-align: top;"><b><?= (!isset($desarrollo['ObjetivoAplicable'][0]['monto'])?"SIN OBJETIVO DEFINIDO":"$".number_format($desarrollo['ObjetivoAplicable'][0]['monto'],0))?></b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- ./row imagenes y caracteristicas -->

                    <div class="row m-t-40">
                        <div class="col-sm-12">
                            <h3 class="text-black">Descripción del desarrollo</h3>
                            <hr>
                            <div class="col-sm-12">
                                <p>
                                    <?php echo $desarrollo['Desarrollo']['descripcion'];?> 
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- ./row Descripcion del Desarrollo -->


                    <div class="row m-t-40">
                        <div class="col-sm-12">
                            <h3 class="text-black">Entorno, Amenidades y Servicios</h3>
                            <hr>

                            <div class="col-sm-12">
                                <h4 class="text-black">- Lugares de interes</h4>
                                <?php echo ($desarrollo['Desarrollo']['cc_cercanos']            == 1 ? '<div class="col-lg-4">Centros comerciales cercanos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cerca_playa']            == 1 ? '<div class="col-lg-4">Cerca de la playa</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['escuelas']               == 1 ? '<div class="col-lg-4">Escuelas cercanas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['frente_parque']          == 1 ? '<div class="col-lg-4">Frente a parque</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['frente_playa']          == 1 ? '<div class="col-lg-4">Frente a playa</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['parque_cercano']         == 1 ? '<div class="col-lg-4">Parques cercanos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['plazas_comerciales']     == 1 ? '<div class="col-lg-4">Plazas comerciales</div>' : "") ?>
                            </div>

                            <div class="col-sm-12 m-t-20">
                                <h4 class="text-black">- Amenidades</h4>
                                <?php echo ($desarrollo['Desarrollo']['alberca_sin_techar']         == 1 ? '<div class="col-lg-4">Alberca descubierta</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['alberca_techada']            == 1 ? '<div class="col-lg-4">Alberca techada</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sala_cine']                  == 1 ? '<div class="col-lg-4">Área de cine</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['juegos_infantiles']          == 1 ? '<div class="col-lg-4">Área de juegos infantiles</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['fumadores']                  == 1 ? '<div class="col-lg-4">Área para fumadores</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['areas_verdes']               == 1 ? '<div class="col-lg-4">Áreas verdes</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['asador']                     == 1 ? '<div class="col-lg-4">Asador</div>' : "") ?>
                                
                                <?php echo ($desarrollo['Desarrollo']['biblioteca']                     == 1 ? '<div class="col-lg-4">Biblioteca</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cafeteria']                  == 1 ? '<div class="col-lg-4">Cafetería</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['camastros']                       == 1 ? '<div class="col-lg-4">Camastros</div>' : "") ?>
                                
                                <?php echo ($desarrollo['Desarrollo']['golf']                       == 1 ? '<div class="col-lg-4">Campo de golf</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['paddle_tennis']              == 1 ? '<div class="col-lg-4">Cancha de paddle</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['squash']                     == 1 ? '<div class="col-lg-4">Cancha de squash</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['tennis']                     == 1 ? '<div class="col-lg-4">Cancha de tennis</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cancha_petanca']             == 1 ? '<div class="col-lg-4">Cancha (petanca)</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['cancha_pickleball']          == 1 ? '<div class="col-lg-4">Cancha de pickleball</div>' : "") ?>
                                
                                <?php echo ($desarrollo['Desarrollo']['carril_nado']                == 1 ? '<div class="col-lg-4">Carril de nado</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['ciclopista']                 == 1 ? '<div class="col-lg-4">Ciclopista</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['conserje']                   == 1 ? '<div class="col-lg-4">Concierge</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['club_playa']                   == 1 ? '<div class="col-lg-4">Club de playa</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['fire_pit']                   == 1 ? '<div class="col-lg-4">Fire pit</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gimnasio']                   == 1 ? '<div class="col-lg-4">Gimnasio</div>' : "") ?>
                            
                                <?php echo ($desarrollo['Desarrollo']['helipuerto']                   == 1 ? '<div class="col-lg-4">Helipuerto</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['jacuzzi']                    == 1 ? '<div class="col-lg-4">Jacuzzi</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['living']                     == 1 ? '<div class="col-lg-4">Living</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['lobby']                      == 1 ? '<div class="col-lg-4">Lobby</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['ludoteca']                      == 1 ? '<div class="col-lg-4">Ludoteca</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['boliche']                    == 1 ? '<div class="col-lg-4">Mesa de boliche</div>' : "") ?>
                            
                                <?php echo ($desarrollo['Desarrollo']['pet_park']                    == 1 ? '<div class="col-lg-4">Pet park</div>' : "") ?>


                                <?php echo ($desarrollo['Desarrollo']['pista_jogging']              == 1 ? '<div class="col-lg-4">Pista de jogging</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['play_room']                  == 1 ? '<div class="col-lg-4">Play room / Cuarto de juegos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['restaurante']                == 1 ? '<div class="col-lg-4">Restaurante</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['roof_garden_compartido']     == 1 ? '<div class="col-lg-4">Roof garden</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['salon_juegos']               == 1 ? '<div class="col-lg-4">Salón de juegos</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['salon_usos_multiples']       == 1 ? '<div class="col-lg-4">Salón de usos múltiples</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sauna']                      == 1 ? '<div class="col-lg-4">Sauna</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['spa_vapor']                  == 1 ? '<div class="col-lg-4">Spa / Vapor</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['vista_panoramica']           == 1 ? '<div class="col-lg-4">Vista panorámica</div>' : "") ?>
                                
                                <?php echo ($desarrollo['Desarrollo']['meditation_room']           == 1 ? '<div class="col-lg-4">Yoga / Meditation room</div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['sky_garden']                 == 1 ? '<div class="col-lg-4">Sky garden</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['simulador_golf']             == 1 ? '<div class="col-lg-4">Simulador golf</div>' : "") ?>


                                <?php echo ($desarrollo['Desarrollo']['coworking']                  == 1 ? '<div class="col-lg-4">Coworking</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['pool_bar']                   == 1 ? '<div class="col-lg-4">Pool bar</div>' : "") ?>

                            </div>
                            <div class="col-sm-12 m-t-20">
                                <h4 class="text-black">- SERVICIOS</h4>
                                <?php echo ($desarrollo['Desarrollo']['acceso_discapacitados']      == 1 ? '<div class="col-lg-4">Acceso de discapacitados</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['internet']                   == 1 ? '<div class="col-lg-4">Acceso Internet / WiFi</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['tercera_edad']               == 1 ? '<div class="col-lg-4">Acceso para Tercera Edad</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['aire_acondicionado']         == 1 ? '<div class="col-lg-4">Aire Acondicionado</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['business_center']            == 1 ? '<div class="col-lg-4">Business Center</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['calefaccion']                == 1 ? '<div class="col-lg-4">Calefacción</div>' : "") ?>
                                
                                <?php echo ($desarrollo['Desarrollo']['cctv']                       == 1 ? '<div class="col-lg-4">CCTV</div>' : "") ?>
                                
                                <?php $certificaciones_led = array(1=>'Silver', 2=> 'Gold', 3=> 'Platinum'); ?>
                                <?php echo ($desarrollo['Desarrollo']['certificacion_led']                       == 1 ? '<div class="col-lg-4"> Certificación leed '.$certificaciones_led[$desarrollo['Desarrollo']['certificacion_led_opciones']].' </div>' : "") ?>

                                <?php echo ($desarrollo['Desarrollo']['cisterna']                   == 1 ? '<div class="col-lg-4">Cisterna: '.$desarrollo['Desarrollo']['m_cisterna'].'l.</div>' : "")?>
                                <?php echo ($desarrollo['Desarrollo']['conmutador']                 == 1 ? '<div class="col-lg-4">Conmutador</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['edificio_inteligente']       == 1 ? '<div class="col-lg-4">Edificio Inteligente</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['edificio_leed']              == 1 ? '<div class="col-lg-4">Edificio LEED</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['elevadores']                 == 1 ? '<div class="col-lg-4">Elevadores: '.$desarrollo['Desarrollo']['q_elevadores'].'</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas']    == 1 ? '<div class="col-lg-4">Estacionamiento de visitas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gas_lp']                     == 1 ? '<div class="col-lg-4">Gas LP</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['gas_natural']                == 1 ? '<div class="col-lg-4">Gas Natural</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['lavanderia']                 == 1 ? '<div class="col-lg-4">Lavanderia</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['mezzanine']                 == 1 ? '<div class="col-lg-4">Mezzanine</div>' : "") ?>


                                <?php echo ($desarrollo['Desarrollo']['locales_comerciales']        == 1 ? '<div class="col-lg-4">Locales Comerciales</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['mascotas']                   == 1 ? '<div class="col-lg-4">Permite Mascotas</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['planta_emergencia']          == 1 ? '<div class="col-lg-4">Planta de Emergencia</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['porton_electrico']           == 1 ? '<div class="col-lg-4">Portón Eléctrico</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios']   == 1 ? '<div class="col-lg-4">Sistema Contra Incendios</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['sistema_seguridad']          == 1 ? '<div class="col-lg-4">Sistema de Seguridad</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['valet_parking']              == 1 ? '<div class="col-lg-4">Valet Parking</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['vapor']                      == 1 ? '<div class="col-lg-4">Vapor</div>' : "") ?>
                                <?php echo ($desarrollo['Desarrollo']['seguridad']                  == 1 ? '<div class="col-lg-4">Vigilancia / Seguridad</div>' : "") ?>
                            </div>
                        </div>
                    </div>
                    <!-- ./row amenidades servicios -->
                </div>
            </div>
            
            <!-- Listado de inventario -->
            <div class="card m-t-10">
                <div class="card-header bg-blue-is">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            Inventario
                        </div>
                        <?php 
                            if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']):

                                if ($this->Session->read('Permisos.Group.de') == 1 || ($desarrollo['EquipoTrabajo']['administrador_id'] == "" && $this->Session->read('Permisos.Group.id') == 2 ) || $desarrollo['EquipoTrabajo']['administrador_id'] == $this->Session->read('Auth.User.id')): ?>

                                    <div class="col-sm-12 col-lg-6 text-lg-right">
                                        
                                        <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Crear Unidad',array('controller'=>'inmuebles','action'=>'add_unidades',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-success btn-sm'))?>
                                        
                                        <?= $this->Html->link('<i class="fa fa-edit fa-1x"></i>Modificación Masiva',array('controller'=>'inmuebles','action'=>'modificacion',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-success btn-sm'))?>

                                    </div>

                                <?php elseif( $this->Session->read('Permisos.Group.id') == 5): ?>
                                    <div class="col-sm-12 col-lg-6 text-lg-right">
                                        
                                        <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Crear Unidad', '#',array('escape'=>false,'class'=>'btn btn-sm disabled'))?>
                                        
                                        <?= $this->Html->link('<i class="fa fa-edit fa-1x"></i>Modificación Masiva','#',array('escape'=>false,'class'=>'btn disabled btn-sm'))?>

                                    </div>

                        <?php 
                                endif;
                            endif;
                        ?>
                    </div>
                </div>
                <div class="card-block cards_section_margin">
                    
                    <div class="row" style="background-color: #D1D1D1; margin: 5px; border-radius: 5px; text-transform: uppercase; font-weight: 600;">
                        <div class="col-sm-12 col-lg-6">
                            Total de unidades <?= count($desarrollo['Propiedades']) ?>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <span id="sum_propiedades_q"></span>
                        </div>
                    </div>


                    <div class="row mt-1">
                        <div class="col-sm-4 col-lg-2 text-center">
                            Baja
                            <div class="number chips bg-baja" style="padding: 2px 5px 2px 5px;">
                                <span id="baja"> <?= isset($contadores[5])? $contadores[5] : 0 ?>
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-2 text-center">
                            Bloqueados
                            <div class="number chips bg-bloqueado" style="padding: 2px 5px 2px 5px;">
                                <span id="bloqueado"> <?= isset($contadores[0])? $contadores[0] : 0 ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Libres / En venta
                            <div class="number chips bg-libre" style="padding: 2px 5px 2px 5px;">
                                <span id="libre"> <?= isset($contadores[1])? $contadores[1] : 0 ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Apartados/Reservados
                            <div class="number chips bg-apartado" style="padding: 2px 5px 2px 5px;">
                                <span id="reserva"> <?= isset($contadores[2])? $contadores[2] : 0 ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Vendidos / Contrato
                            <div class="number chips bg-vendido" style="padding: 2px 5px 2px 5px;">
                                <span id="contrato"> <?= isset($contadores[3])? $contadores[3] : 0 ?> 
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Escriturados
                            <div class="number chips bg-escriturado" style="padding: 2px 5px 2px 5px;">
                                <span id="escrituracion"> <?= isset($contadores[4])? $contadores[4] : 0 ?>
                                </span>
                            </div>
                        </div>
                    </div>


                    <?= $this->Form->create('Inmueble', array('url'=>array('controller'=>'Inmuebles', 'action'=>'update_inventario'))); ?>
                        <!-- Table -->
                        <div class="row mt-2">
                            
                            <div class="col-sm-12">
                                <div class="">

                                    <table class="table table-striped table-bordered table-hover table-sm" id="inventario">
                                        <thead>
                                            <tr>
                                                <th class="d-block">Id</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Referencia</th>
                                                <th class="text-center">Título</th>
                                                <th class="text-center">$</th>
                                                <th class="text-center"><?= $this->Html->image('m2.png',array('width'=>'20px'))?></th>
                                                <th class="text-center"><?= $this->Html->image('recamaras.png',array('width'=>'20px'))?></th>
                                                <th class="text-center"><?= $this->Html->image('banios.png',array('width'=>'20px'))?></th>
                                                <th class="text-center"><?= $this->Html->image('autos.png',array('width'=>'20px'))?></th>
                                                <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                    <!-- <th class="text-center"><?= "Cambiar Estado" ?></th> -->
                                                    <th class="text-center">
                                                        Liberar
                                                        <i class="fa fa-check" title="LIBERAR" data-placement="top" data-toggle="tooltip"></i>
                                                    </th>
                                                <?php endif ?>
                                                <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                    <th style="text-align:center">Eliminar <i class="fa fa-trash fa-lg" title="ELIMINAR" data-placement="top" data-toggle="tooltip"></i></th>
                                                    <!-- <th></th> -->
                                                <?php endif ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $i       = 0;
                                                $q_tot_r = 0;
                                                $q_tot_v = 0;
                                                foreach ($desarrollo['Propiedades'] as $tipo):
                                                $i++;
                                            ?>

                                                <?php if ($this->Session->read('Permisos.Group.id')!=3 || $this->Session->read('Permisos.Group.id')==3 && $tipo['liberada'] == 1): ?>
                                                    <tr>
                                                        <td class="d-block"><?= $tipo['id'] ?></td>
                                                        <!-- Estatus -->
                                                        <td>
                                                            <small>
                                                                <?php
                                                                    switch ($tipo['liberada']) {
                                                                    case 0: //Bloqueada
                                                                        echo "<span class='chip bg-bloqueado' style='text-align: center;'>Bloqueado</span>";
                                                                        $data_status_prop['bloqueados'] ++;
                                                                        break;

                                                                    case 1: // Libre
                                                                        echo "<span class='chip bg-libre' style='text-align: center;'>Libre / En venta</span>";
                                                                        $data_status_prop['libres'] ++;
                                                                        break;

                                                                    case 2: // Apartado
                                                                        echo "<span class='chip bg-apartado' style='text-align: center;'>Apartado / Reservado</span>";
                                                                        $data_status_prop['reserva'] ++;
                                                                        break;

                                                                    case 3: // Contrato
                                                                        echo "<span class='chip bg-vendido' style='text-align: center;'>Vendido / Contrato</span>";
                                                                        $data_status_prop['contrato'] ++;
                                                                        break;

                                                                    case 4: // Escrituracion
                                                                        echo "<span class='chip bg-escriturado' style='text-align: center;'>Escriturado</span>";
                                                                        $data_status_prop['escrituracion'] ++;
                                                                        break;
                                                                    case 5: // Baja
                                                                        echo "<span class='chip bg-baja' style='text-align: center;'>Baja</span>";
                                                                        $data_status_prop['baja'] ++;
                                                                        break;
                                                                    } 
                                                                ?>
                                                                
                                                            </small>
                                                        </td>

                                                        <td>
                                                            <span>
                                                                <?php
                                                                    if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                                                                        echo $tipo['referencia'];
                                                                    }else{
                                                                
                                                                        if ($tipo['liberada'] != 0 || $this->Session->read('Permisos.Group.dr') == 1) {
                                                                            echo $this->Html->link($tipo['referencia'], array('action' => 'view_tipo', 'controller' => 'inmuebles', $tipo['id'],$desarrollo['Desarrollo']['id']));
                                                                        } else {
                                                                            echo $tipo['referencia'];
                                                                        }
                                                                    }
                                                                ?>
                                                            </span>
                                                        </td>
                                                        <td data-search="<?= str_replace("-", "", $tipo['titulo']); ?> | <?= $tipo['titulo'] ?>" >
                                                            <span>
                                                                <?php
                                                                    if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==5){
                                                                        echo $tipo['titulo'];
                                                                    }else{
                                                                
                                                                        if ($tipo['liberada'] != 0 || $this->Session->read('Permisos.Group.dr') == 1) {
                                                                            echo $this->Html->link($tipo['titulo'], array('action' => 'view_tipo', 'controller' => 'inmuebles', $tipo['id'],$desarrollo['Desarrollo']['id']));
                                                                        } else {
                                                                            echo $tipo['titulo'];
                                                                        }
                                                                    }
                                                                ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span>
                                                            <?php
                                                                if ($tipo['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3){
                                                                    // echo "$" . number_format($tipo['precio'], 2);
                                                                    switch($tipo['venta_renta']) {
                                                                        case 'Venta / Renta':
                                                                            echo "V- $" . number_format($tipo['precio'], 2).'<br> R- '."$" . number_format($tipo['precio_2'], 2);
                                                                        break;
                                                                        case 'Venta':
                                                                            echo "V- $" . number_format($tipo['precio'], 2);
                                                                            $q_tot_v += $tipo['precio'];
                                                                        break;
                                                                        case 'Renta':
                                                                            echo 'R- '."$" . number_format($tipo['precio_2'], 2);
                                                                        break;
                                                                    }
                                                                }
                                                            ?>
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span>
                                                                <?php echo number_format($tipo['construccion'] + $tipo['construccion_no_habitable'], 2) ?> m2
                                                            </span>
                                                        </td>
                                                        <td class="text-center"><?php echo $tipo['recamaras'] ?></td>
                                                        <td class="text-center"><?php echo $tipo['banos'] ?> / <?php echo $tipo['medio_banos'] ?></td>
                                                        <td class="text-center"><?php echo $tipo['estacionamiento_techado'] + $tipo['estacionamiento_descubierto'] ?></td>
                                                        <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                            <!-- <td>
                                                                <?php if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['liberada'] != 4): ?>
                                                                    <?php

                                                                        // 0=> Bloqueada, 1=> Libre, 2=> Reservado, 3=> Contrato, 4=> Escrituracion, 5=> Baja
                                                                        switch( $tipo['liberada']  ) {
                                                                            case 1:
                                                                                echo "<i class='fa fa-calendar fa-lg pointer' onclick='showModalProcesoInmuebles(2, ".$tipo['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Apartados / Reservados' ></i>";
                                                                                
                                                                                echo $this->Html->link('<i class="fa fa-times fa-lg"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['id'], 5, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Baja','escape'=>false,'style'=>'margin-right:5px'));
                                                                            break;

                                                                            case 2:
                                                                                // Vende
                                                                                echo "<i class='fa fa fa-dollar fa-lg pointer' onclick='showModalProcesoInmuebles(3, ".$tipo['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Vendido / Contrato' ></i>";

                                                                            break;

                                                                            case 3:
                                                                                // Escrituracion
                                                                                echo "<i class='fa fa fa-key fa-lg pointer' onclick='showModalProcesoInmuebles(4, ".$tipo['id'].")' style = 'margin-right:5px' data-toggle ='tooltip' data-placement='top' title='Escriturado' ></i>";

                                                                            break;
                                                                        }
                                                                    
                                                                    ?>
                                                                <?php endif; ?>
                                                            </td> -->
                                                            <td>
                                                                <?php if ($this->Session->read('Permisos.Group.ilib') == 1): ?>
                                                                    <?php if ($tipo['liberada'] == 2 or $tipo['liberada'] == 5 or $tipo['liberada'] == 0): ?>
                                                                    <?php /* if ($tipo['liberada'] != 1 && $tipo['liberada'] != 3):*/ ?>
                                                                        <div class="checkbox" style="height: 10px;">
                                                                            <label style="height: 8px;">
                                                                            <input type="checkbox" style="height: 8px;" name="data[<?= $i ?>][liberar]">
                                                                            <span class="cr" style="height: 13px; width: 13px;"><i class="cr-icon fa fa-check"></i></span>
                                                                            </label>
                                                                        </div>
                                                                        <?= $this->Form->hidden('desarrollo_tipo', array('value'=>$tipo['id'], 'name'=>'data['.$i.'][inmueble_id]')) ?>
                                                                        <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo_id, 'name'=>'data[General][desarrollo_id]')) ?>

                                                                    <?php endif ?>
                                                                <?php endif ?>
                                                            </td>
                                                        <?php endif ?>
                                                        <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                                <td>
                                                                <?php if ($tipo['liberada'] == 0 || $tipo['liberada'] == 5): ?>
                                                                    <div class="checkbox" style="height: 10px;">
                                                                        <label style="height: 8px;">
                                                                        <input type="checkbox" style="height: 8px;" name="data[<?= $i ?>][borrar]">
                                                                        <span class="cr" style="height: 13px; width: 13px;"><i class="cr-icon fa fa-check"></i></span>
                                                                        </label>
                                                                    </div>
                                                                <?php endif ?>
                                                            </td>
                                                        <?php endif ?>
                                                    </tr>
                                                <?php endif ?>
                                                <?= $this->Form->hidden('desarrollo_tipo', array('value'=>$tipo['id'], 'name'=>'data['.$i.'][inmueble_id]')) ?>
                                                <?= $this->Form->hidden('desarrollo_id', array('value'=>$desarrollo_id, 'name'=>'data[General][desarrollo_id]')) ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                    if ($this->Session->read('Permisos.Group.de') == 1 || $this->Session->read('Permisos.Group.dd') == 1) {
                                        echo $this->Form->submit('Guardar cambios', array('class'=>'btn btn-success'));
                                    }
                                ?>
                            </div>
                        </div>

                    <?= $this->Form->end(); ?>
                </div>
            </div>

            <!-- Listado de inventario Extras -->
            <div class="card m-t-10">
                <div class="card-header"  >
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            Inventario de Extras
                        </div>
                        <?php
                        if ($this->Session->read('CuentaUsuario.CuentasUser.cuenta_id') == $desarrollo['Desarrollo']['cuenta_id']):

                            if ($this->Session->read('Permisos.Group.de') == 1 || ($desarrollo['EquipoTrabajo']['administrador_id'] == "" && $this->Session->read('Permisos.Group.id') == 2 ) || $desarrollo['EquipoTrabajo']['administrador_id'] == $this->Session->read('Auth.User.id')): ?>

                                <div class="col-sm-12 col-lg-6 text-lg-right">

                                    <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Agregar Extra','javascript:addExtra()',array('escape'=>false,'class'=>'btn btn-success btn-sm'))?>

                                </div>

                            <?php elseif( $this->Session->read('Permisos.Group.id') == 5): ?>
                                <div class="col-sm-12 col-lg-6 text-lg-right">

                                    <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Agregar Extra','javascript:addExtra()',array('escape'=>false,'class'=>'btn btn-success btn-sm'))?>

                                </div>

                            <?php
                            endif;
                        endif;
                        ?>
                    </div>
                </div>
                <div class="card-block cards_section_margin">

                    <div class="row mt-2">

                        <div class="col-sm-12">
                            <div class=" table-responsive">

                                <table class="table table-striped table-bordered table-hover table-sm" id="inventario_extras">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Precio de Venta</th>
                                            <th>Estatus</th>
                                            <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                <th>Editar</th>
                                            <?php endif ?>
                                            <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                <th>Eliminar</th>
                                            <?php endif ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php foreach ($desarrollo['Extras'] as $extra): ?>
                                        <tr>
                                            <td><?= $extra['nombre']?></td>
                                            <td><?= $extra['descripcion']?></td>
                                            <td style="text-align:center">$<?= number_format($extra['precio_venta'],2)?></td>
                                            <td style="text-align:center"><?= $estados[$extra['status']]?></td>
                                            <?php if ($this->Session->read('Permisos.Group.de')==1): ?>
                                                <td style="text-align:center"><?= $this->Html->link('<i class="fa fa-edit"></i>','javascript:editExtra('.$extra['id'].')',array('escape'=>false))?></td>
                                            <?php endif ?>
                                            <?php if ($this->Session->read('Permisos.Group.dd') == 1): ?>
                                                <td style="text-align:center"><?php echo $this->Form->postLink('<i class="fa fa-trash-o"></i>', array('controller'=>'desarrollos','action' => 'deleteExtra', $extra['id'],$desarrollo['Desarrollo']['id']), array('escape'=>false, 'confirm'=>'¿Deseas eliminar '.$extra['nombre'].' del desarrollo?')); ?></td>
                                            <?php endif ?>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        

            <!-- Tarjeta de eventos.  -->
            <?= $this->element('Events/eventos_cards'); ?>
    
            <!-- Graficas -->
            <?php if ( $this->Session->read('Permisos.Group.id') != 3 ): ?>
                <!-- rogue -->
                <!-- Grafica de META VS. VENTAS (ÚLTIMO AÑO) ok-->
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <?= $this->Element('Desarrollos/ventas_vs_metas_anio_by_ajax') ?>
                    </div>
                </div>

                <!-- META VS VENTAS (EN UNIDADES) ok-->
                <div class="row mt-1 salto">
                    <div class="col-sm-12">
                        <?= $this->Element('Desarrollos/desarrollo_ventas_metas_by_ajax') ?>
                    </div>
                </div>
                <!-- LEADS POR MEDIO DE PROMOCIÓN, VENTAS E INVERSIÓN EN PUBLICIDAD ok -->
                <div class="row mt-1 salto">
                    <div class="col-sm-12">
                        <?= $this->Element('Leads/leads_ventas_inversion_vistas_desarrollo_by_ajax') ?>
                    </div>
                </div>
                <!-- LEADS POR MEDIO DE PROMOCIÓN, VISITAS E INVERSIÓN EN PUBLICIDAD ok-->
                <div class="row mt-1 salto">
                    <div class="col-sm-12">
                        <?= $this->Element('Leads/leads_visitas_inversion_vistas_desarrollo_by_ajax') ?>
                    </div>
                </div>
                <!-- VENTAS POR ASESOR ok-->
                <div class="row ">
                    <div class="col-sm-12">
                        <?= $this->Element('Ventas/ventas_asesores_by_ajax') ?>
                    </div>
                </div>
                <!-- INVERSIÓN HISTÓRICA EN PUBLICIDAD  ok-->
                <div class="row mt-1 salto">
                    <div class="col-sm-12">
                        <?= $this->Element('Publicidads/inversion_publucidad_by_ajax') ?>
                    </div>
                </div>
                <!-- rogue -->
                
                <!-- Grafica de INVERSIÓN HISTÓRICA EN PUBLICIDAD -->
                

            <?php endif; ?>

            <!-- Ubicacion del desarrollo -->
            <div class="row">
                <div class="col-lg-12 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  >
                            Ubicación del desarrollo
                        </div>
                        <?php
                            list($latitud, $longitud) = explode(",", $desarrollo['Desarrollo']['google_maps']);
                        ?>
                        <div class="card-block twitter_section" style="overflow-y: scroll; height:350px !important">
                            <div id="map"></div>
                            <script>
                            function initMap() {
                                var uluru = {lat: <?= $latitud?>, lng: <?= $longitud?>};
                                var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 16,
                                center: uluru
                                });
                                var marker = new google.maps.Marker({
                                position: uluru,
                                map: map
                                });
                            }
                            </script>
                            <script async defer
                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbQezSnigCkcxQ1zaoucUWwsGGc3Ar4g0&callback=initMap">
                            </script>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de clientes. -->
            <div class="row" id="interesados">
                <div class="col-lg-12 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  >
                            Lista de Posibles clientes
                        </div>
                        <div class="card-block m-t-10" >
                            <div class="col-lg-12 mt-3">
                            <div class="pull-sm-right mt-3">
                                    <div class="tools pull-sm-right"></div>
                                </div>

                                <table class="table table-striped table-bordered table-hover" id="sample_1" class="m-t-35">
                                    <thead>
                                        <tr>
                                            <th>Etapa</th>
                                            <th>E.A</th>
                                            <th>Estatus</th>
                                            <th>Nombre</th>
                                            <th>Desarrollo/Inmueble</th>
                                            <th>Fecha de creación</th>
                                            <th>Asesor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($desarrollo['Interesados'] as $lead):?>
                                            <?php 
                                                if ($lead['user_id']==$this->Session->read('Auth.User.id') || $this->Session->read('Permisos.Group.call')==1){
                                                /*if ($lead['user_id'] != ''){*/
                                            ?>
                                                    <tr>
                                                        <?php 
                                                        switch($lead['etapa']){
                                                            case 1:
                                                            $c_etapa = 'estado1';
                                                            break;
                                                            case 2:
                                                            $c_etapa = 'estado2';
                                                            break;
                                                            case 3:
                                                            $c_etapa = 'estado3';
                                                            break;
                                                            case 4:
                                                            $c_etapa = 'estado4';
                                                            break;
                                                            case 5:
                                                            $c_etapa = 'estado5';
                                                            break;
                                                            case 6:
                                                            $c_etapa = 'estado6';
                                                            break;
                                                            case 7:
                                                            $c_etapa = 'estado7';
                                                            break;
                                                        }

                                                        if ($lead['last_edit'] <= $date_current.' 23:59:59' && $lead['last_edit'] >= $date_oportunos) {$at = 'OP'; $name_at = "Oportuno"; $class_at = "chip_bg_oportuno";}
                                                        elseif($lead['last_edit'] < $date_oportunos.' 23:59:59' && $lead['last_edit'] >= $date_tardios.' 00:00:00'){$at = 'TA'; $name_at = "Tardio"; $class_at = "chip_bg_tardio";}
                                                        elseif($lead['last_edit'] < $date_tardios.' 23:59:59' && $lead['last_edit'] >= $date_no_atendidos.' 00:00:00'){$at = 'NA'; $name_at = "No atendido"; $class_at = "chip_bg_no_antendido";}
                                                        elseif($lead['last_edit'] < $date_no_atendidos.' 23:59:59' && $lead['last_edit'] >= '0000-00-00 00:00:00'){$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                                                        else{$at = 'PR'; $name_at = "Por reasignar"; $class_at = "chip_bg_reasignar";}
                                                        ?>

                                                        <td><small class="chip <?= $c_etapa ?>"><?= $lead['etapa'] ?><small></td>
                                                        <td data-search="<?= $name_at; ?>"><small><span class="<?= $class_at ?>"><?= $at; ?></span></small></td>
                                                        <td><?= $lead['status'] ?></td>
                                                        <td>
                                                        <?= $this->Html->link(rtrim($lead['nombre']), array('controller' => 'clientes', 'action' => 'view', $lead['id'])) ?>
                                                        </td>
                                                        <td>
                                                        <?= empty($lead['Desarrollo']['nombre']) ? '' : rtrim($lead['Desarrollo']['nombre']) ?>
                                                        <?= empty($lead['Inmueble']['titulo']) ? '' : rtrim($lead['Inmueble']['titulo']) ?>
                                                        </td>
                                                        <td>
                                                        <?= date('Y-m-d', strtotime($lead['created'])) ?>
                                                        </td>
                                                        <td>
                                                        <?= $usuarios[$lead['user_id']] ?>
                                                        </td>
                                                    </tr>
                                            <?php 
                                                /*}*/
                                                    }
                                            
                                            ?>
                                        <?php endforeach;?>    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Tablas de finanzas -->
            <?php if ($this->Session->read('Permisos.Group.id') <= 2): ?>
        
                <!-- Tabla de facturas. -->
                <div class="row mt-2 finanzas">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        Listado de facturas
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm" id="dataTableFactura">
                                            <thead>
                                                <tr>
                                                    <th>Folio</th>
                                                    <th>Referencia</th>
                                                    <th>Fecha de emisión</th>
                                                    <th>Concepto</th>
                                                    <th>Subtotal</th>
                                                    <th>Iva</th>
                                                    <th>Total</th>
                                                    <th>Estado</th>
                                                    <th>Categoria</th>
                                                    <th>Pagar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($desarrollo['Facturas'] as $factura): ?>
                                                    <tr>
                                                        <td><?= $factura['folio'] ?></td>
                                                        <td><?= $factura['referencia'] ?></td>
                                                        <td><?= $factura['fecha_emision'] ?></td>
                                                        <td><?= $factura['concepto'] ?></td>
                                                        <td><?= '$'.number_format($factura['subtotal']) ?></td>
                                                        <td><?= '$'.number_format($factura['iva']) ?></td>
                                                        <td><?= '$'.number_format($factura['total']) ?></td>
                                                        <td><?= $estados_factura[$factura['estado']] ?></td>
                                                        <td><?= $categorias[$factura['categoria_id']] ?></td>
                                                        <td class="text-sm-center">
                                                            <?php if ($factura['estado'] == 0): ?>
                                                                <?= $this->Html->link('<i class="fa fa-dollar"></i>', array('controller'=>'aportacions', 'action'=>'pagos_factura', $factura['id']), array('escape'=>false)) ?>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  

                <!-- Listado de gastos en publicidad -->
                <div class="row mt-2 finanzas">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        Inversión en Publicidad
                                        <div style="float:right">
                                            <?php echo $this->Html->link('Registro de inversión','#',array('data-target'=>"#publicidad",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','class'=>'btn btn-success btn-sm','escape'=>false));?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm" id="dataTableInversion">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Medio</th>
                                                    <th>Monto Invertido</th>
                                                    <th>Editar</th>    
                                                    <th>Borrar</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($desarrollo['Publicidad'] as $publicidad): ?>
                                                    <tr>
                                                        <td><?= date("Y/m",strtotime($publicidad['fecha_inicio'])) ?></td>
                                                        <td><?= $lineas_contactos[$publicidad['dic_linea_contacto_id']] ?></td>
                                                        <td><?= "$".number_format($publicidad['inversion_prevista'],2) ?></td>
                                                        <?php if( $this->Session->read('Permisos.Group.id') == 1 ): ?>
                                                            <td>
                                                                <?= $this->Html->link('<i class="fa fa-edit"></i>',"javascript:editPublicidad(".$publicidad['id'].")", array('escape'=>false));?>
                                                            </td>
                                                            <td><?= $this->Form->postlink( '<i class="fa fa-trash"></i>', array('controller' => 'publicidads', 'action' => 'delete', $publicidad['id'], $desarrollo['Desarrollo']['id']), array( 'escape' => false) ); ?></td>
                                                        <?php endif;?>
                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Planes de pago -->
                <div class="row mt-2">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-12">
                                        Planes de Pago
                                        <?php if( $this->Session->read('Permisos.Group.id') < 3 ): ?>
                                            <div style="float:right">
                                                <?= $this->Html->link('Registro de Plan de Pago','#', array('escape'=>false, 'class'=>'btn btn-success btn-sm', 'data-toggle'=>'modal', 'data-target'=>'#add_plan'));?>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm" id="dataTableInversionP">
                                            <thead>
                                                <tr>
                                                    <th>Estatus</th>
                                                    <th>Alias</th>
                                                    <th>Vigencia</th>
                                                    <th>Descuento</th>
                                                    <th>Apartado</th>
                                                    <th>Plan de Pago</th>
                                                    <th>Observaciones Internas</th>
                                                    <th>Editar</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($desarrollo['PlanesPago'] as $plan): ?>
                                                    
                                                    <tr>
                                                        <td> <span class=" chips <?= $status_plan_pagos[$plan['status']]['color'] ?>"> <?= $status_plan_pagos[$plan['status']]['label']; ?> </span> </td>
                                                        <td><?= $plan['alias']; ?></td>
                                                        <td><?= date("d/m/Y",strtotime($plan['vigencia'])) ?></td>
                                                        <td> <?= ( ($plan['descuento'] > 0 ) ? $plan['descuento'].'%' : '$ '.number_format($plan['descuento_q']) )  ?>
                                                        </td>
                                                        <td> <?= ( ($plan['apartado'] > 0 ) ? $plan['apartado'].'%' : '$ '.number_format($plan['apartado_q']) ) ?> </td>
                                                        <td>
                                                            <?= "C:".$plan['contrato']."/"."F:".$plan['financiamiento']."/"."E:".$plan['escrituracion']."/" ?></td>
                                                        <td><?= $plan['observaciones_internas']?></td>
                                                        <?php if( $this->Session->read('Permisos.Group.id') == 1 ): ?>
                                                            <td><?= $this->Html->link('<i class="fa fa-edit"></i>','javascript:editPlan('.$plan['id'].')', array('escape'=>false));?></td>
                                                            <td>
                                                                <?php if( $plan['status'] == 1): ?>
                                                                        <?= $this->Html->link('<i class="fa fa-close"></i>','javascript:disabledPlan('.$plan['id'].', "'.$plan['alias'].'", 0)', array('escape'=>false));?>
                                                                    <?php else:?>
                                                                        <?= $this->Html->link('<i class="fa fa-check"></i>','javascript:enablePlan('.$plan['id'].', "'.$plan['alias'].'", "'.date("Y-m-d",strtotime($plan['vigencia'])).'" )', array('escape'=>false));?>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endif;?>

                                                    </tr>
                                                <?php endforeach ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de cuentas bancarias -->
                <div class="row">
                    <div class="col-sm-12 mt-1">
                        <div class="card">
                            <div class="card-header bg-blue-is">
                                <div class="row">
                                    <div class="col-sm-12 col-lg-6">
                                        Métodos de Pago
                                    </div>
                                    <div class="col-sm-12 col-lg-6 text-sm-right">
                                        <span class="pointer btn btn-sm btn-success" onclick="addCtasBancoDesarrollo(<?= $desarrollo['Desarrollo']['id'] ?>)"> Agregar cuenta</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                                <table class="table table-sm" id="metodoPagos"> </table>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <!-- Documentos anexos, proximos eventos y ultimas actividades -->
            <div class="row">
                <div class="col-lg-4 m-t-10">
                    <div class="card">
                        <div class="card-header bg-blue-is"  >
                            Documentos anexos.
                            <div style="float:right">
                                <?php echo $this->Html->link('<i class="fa fa-mail-forward fa-2x"></i>','#',array('data-target'=>"#archivos",'id'=>"target-modal",'data-toggle'=>'modal','data-placement'=>'top','title'=>'Reenviar Archivos','escape'=>false,'style'=>'color:white'));?>
                            </div>
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:330px !important">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th width="80%"><b>Documento</b></th>
                                    <th width="20%"><b>Descargar</b></th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
                                        <tr>
                                            <td><?= $documento['documento']?></td>
                                            <td><?= $this->Html->link(
                                                    '<i class="fa fa-download"></i>',
                                                    $documento['ruta'],
                                                    array('escape'=>false, 'target' => '_blank')
                                                )?>
                                            </td>
                                            
                                        </tr>
                                        
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 m-t-10">
                    <div class="card" >
                        <div class="card-header bg-blue-is"  >
                            Próximos Eventos (15 días)

                            <span class="float-xs-right">
                            <small style="text-transform: uppercase;">
                                <i class=" fa fa-home"></i> Cita
                                <i class=" fa fa-check-circle"></i> Visita
                            </small>
                        </span>
                        
                        </div>
                        <div class="card-block" style="overflow-y: scroll; height:330px !important">
                            <?= $this->element('Events/eventos_proximos'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 m-t-10">
                    <div class="card">
                        <div class="card-header bg-blue-is"  >
                            Últimas actividades
                        </div>
                        <div class="card-block twitter_section" style="overflow-y: scroll; height:330px !important">
                            <ul id="nt-example1">
                                <?php foreach ($desarrollo['Log'] as $log):?>
                                <li>
                                    <div class="row">
                                        <div class="col-xs-2 col-lg-3 col-xl-2">
                                            <?php
                                                $imagen = "";
                                                switch ($log['accion']){
                                                    case (1):
                                                        $imagen = "<i class='fa fa-plus fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (2) :
                                                        $imagen = "<i class='fa fa-pencil fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (3) :
                                                        $imagen = "<i class='fa fa-calendar fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (4) :
                                                        $imagen = "<i class='fa fa-phone fa-2x' style='color:green'></i>";
                                                        break;
                                                    case (5) :
                                                        $imagen = "<i class='fa fa-envelope fa-2x' style='color:green'></i>";
                                                        break;
                                                }
                                            ?>
                                            <?= $imagen;?>
                                        </div>
                                        <div class="col-xs-10 col-lg-9 col-xl-10">
                                            <span class="name"><?= $log['User']['nombre_completo'] ?></span> <span
                                                class="time"><?= $log['fecha']?></span>
                                            <br>
                                            <span class="msg"><?= $log['mensaje']?></span>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        </div>
    </div>

</div>


<?= $this->Html->script([

        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',

        // Datatables
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.colReorder.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/simple_datatables',

        // Files
        '/vendors/fileinput/js/fileinput.min',
        '/vendors/fileinput/js/theme',
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        
        '/vendors/chosen/js/chosen.jquery',
    ], array('inline'=>false));
?>

<script>
    'use strict';

    //rogue
    $(document).ready(function () {
        let desarrollo_id="<?= 'D'.$desarrollo_id?>";
        let dataRange =  "<?= date('d-m-Y', strtotime(  $fecha_primer_cleinte['Cliente']['created']  )) .' - '.date('d-m-Y') ?>";
        let cuenta_id= <?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')?>;
        let mescorriendo= "<?= date('01-m-Y').' - '.date('d-m-Y') ?>";
        let anio= "<?=  date("Y-m-d",strtotime("-1 year"))." - ".date('d-m-Y') ?>";
        // console.log(desarrollo_id);
        // console.log(dataRange);
        // console.log(cuenta_id);
        // console.log(mescorriendo);
        // console.log(anio);
        graficaVentasMetasAnioDesarrollo(cuenta_id, desarrollo_id, anio);
        // console.log(dataRange);
        graficaVentasMetasDesarrollo( dataRange, cuenta_id ,desarrollo_id, 0);
        graficaVentasLineaContactoViewDesarrollo( dataRange, cuenta_id ,desarrollo_id, 0);
        graficaVisitasLineaContactoVistaDesarrollo( dataRange, cuenta_id ,desarrollo_id, 0);
        graficaVentasAsesor( dataRange, cuenta_id ,desarrollo_id, 0);
        graficaInversionPublicidad( dataRange, cuenta_id ,desarrollo_id, 0);
        
        window.setInterval(function(){
            $('#myModal').modal('hide');
            $("#overlay").fadeOut();
        },2000);
    });
    // Agregar cta bancaria desarrollos.
    $( "#CuentasBancariasDesarrolloViewForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "CuentasBancariasDesarrollos", "action" => "add_cta_desarrollo")); ?>',
            cache: false,
            dataType: 'json',
            type: "POST",
            data : $('#CuentasBancariasDesarrolloViewForm').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                
                tableCtasBancarias.ajax.reload();
                $("#modalAddCtaBancaria").modal('hide');
                $("#overlay").fadeOut();

                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = response['mensaje'];

            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar guardar la cuenta bancaria <br> código de error: ESCB-001';
            }
        });

    });

    $( "#CuentasBancariasDesarrolloDeleteViewForm" ).submit(function( event ) {
        event.preventDefault();

        $.ajax({
            url: '<?php echo Router::url(array("controller" => "CuentasBancariasDesarrollos", "action" => "delete_cta_desarrollo")); ?>',
            cache: false,
            dataType: 'json',
            type: "POST",
            data : $('#CuentasBancariasDesarrolloDeleteViewForm').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {
                
                tableCtasBancarias.ajax.reload();
                $("#modalDeleteCtaBancaria").modal('hide');
                $("#overlay").fadeOut();

                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = response['mensaje'];

            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar guardar la cuenta bancaria <br> código de error: ESCB-001';
            }
        });

    });

    $("#CuentasBancariasDesarrolloEditViewForm").submit( function ( event ){
        event.preventDefault();

        $.ajax({
            url     : '<?php echo Router::url(array("controller" => "CuentasBancariasDesarrollos", "action" => "edit_cta_desarrollo")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : $('#CuentasBancariasDesarrolloEditViewForm').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {

                console.log( response );

                
                tableCtasBancarias.ajax.reload();
                $("#modalEditCtaBancaria").modal('hide');
                $("#overlay").fadeOut();

                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = response['mensaje'];

            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar guardar la cuenta bancaria <br> código de error: EECB-001';

            }
        });
    });

    // Abrir modal form de add cta bancaria desarrollos
    function addCtasBancoDesarrollo( desarrolloId ){
        $("#modalAddCtaBancaria").modal('show');
        $("#CuentasBancariasDesarrolloDesarrolloId").val( desarrolloId );
    }

    function editCtaBanco( ctaId ){
        $("#modalEditCtaBancaria").modal('show');

        $.ajax({
            url     : '<?php echo Router::url(array("controller" => "CuentasBancariasDesarrollos", "action" => "view_detalle")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : { cta_id: ctaId },
            success : function ( response ) {

                const cta = response['data']['CuentasBancariasDesarrollo'];
                
                // Seteo de variables en el form.
                $("#CuentasBancariasDesarrolloEditNombreCuenta").val( cta['nombre_cuenta'] );
                $("#CuentasBancariasDesarrolloEditTipo").val( cta['tipo'] );
                $("#CuentasBancariasDesarrolloEditBanco").val( cta['banco'] );
                $("#CuentasBancariasDesarrolloEditNumeroCuenta").val( cta['numero_cuenta'] );
                $("#CuentasBancariasDesarrolloEditSpei").val( cta['spei'] );
                $("#CuentasBancariasDesarrolloEditInstrucciones").val( cta['instrucciones'] );
                $("#CuentasBancariasDesarrolloEditId").val( cta['id'] );

            }
        });
        
    }

    function deleteCtaBanco( ctaId ){
        $("#modalDeleteCtaBancaria").modal('show');
        $("#CuentasBancariasDesarrolloDeleteId").val( ctaId );
    }

    // Abrir modal form de add extras desarrollos
    function addExtra(){
        $("#modalAddExtra").modal('show');
    }

    // Edición del plan para el desarrollo
    function editExtra(id){
        $("#modalEditExtra").modal('show');

        if (id) {
            var dataString = 'id_extra='+ id;
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "desarrollos", "action" => "getExtra")); ?>' ,
                data: dataString,
                cache: false,
                success: function(html) {
                    document.getElementById('nombre_extra_edit').value = html.ExtrasDesarrollo.nombre;
                    document.getElementById('precio_venta_extra_edit').value = html.ExtrasDesarrollo.precio_venta;
                    document.getElementById('descripcion_extra_edit').value = html.ExtrasDesarrollo.descripcion;
                    document.getElementById('estatus_extra_edit').value = html.ExtrasDesarrollo.status;
                    document.getElementById('id_edit_extra').value = html.ExtrasDesarrollo.id;
                }
            });
        }
    }

    
    // Contador para el inventario de unidades.
    document.getElementById("bloqueado").innerHTML     = <?= $data_status_prop['bloqueados'] ?>;
    document.getElementById("libre").innerHTML         = <?= $data_status_prop['libres'] ?>;
    document.getElementById("reserva").innerHTML       = <?= $data_status_prop['reserva'] ?>;
    document.getElementById("contrato").innerHTML      = <?= $data_status_prop['contrato'] ?>;
    document.getElementById("escrituracion").innerHTML = <?= $data_status_prop['escrituracion'] ?>;
    document.getElementById("baja").innerHTML          = <?= $data_status_prop['baja'] ?>;

    if( <?= $q_tot_r ?> > 0 ){
        document.getElementById("sum_propiedades_q").innerHTML = ' Venta: $ <?= number_format($tipo['precio']) ?> Renta: $ <?= number_format($q_tot_v) ?> (MDP)';
    }else {
        document.getElementById("sum_propiedades_q").innerHTML = ' Venta: $ <?= number_format($q_tot_v, 2) ?>';
    }

    $(document).ready(function() {

        // Duplicar el encabezado de la tabla para la busqueda por columna
        $('#metodoPagos thead tr').clone(true).appendTo( '#metodoPagos thead' );
        $('#metodoPagos thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

         // Tabla de metodos de pago del desarrollo
        var tableCtasBancarias = $('#metodoPagos').DataTable( {
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            ajax: "<?php echo Router::url(array("controller" => "CuentasBancariasDesarrollos", "action" => "list_ctas_desarrollo", $desarrollo['Desarrollo']['id'] )); ?>",
            columns: [

                { title: "Tipo" },
                { title: "Nombre Cta" },
                { title: "Banco" },
                { title: "No de Cta" },
                { title: "Cuenta Clabe" },
                { title: "Instrucciones" },

                <?php if( $this->Session->read('Permisos.Group.cbde') == 1 ): ?>
                    { title: "<i class='fa fa-edit'></i>" },
                <?php endif; ?>
                <?php if( $this->Session->read('Permisos.Group.cbdd') == 1 ): ?>
                    { title: "<i class='fa fa-trash'></i>" },
                <?php endif; ?>

            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });
        
        // Duplicar el encabezado de la tabla para la busqueda por columna
        $('#inventario thead tr').clone(true).appendTo( '#inventario thead' );
        $('#inventario thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table.column(i).search() !== this.value ) {
                    table
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );


        var table = $('#inventario').DataTable( {
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                { width: "20%", targets: 0 }
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

        // Duplicar el encabezado de la tabla Posibles Clientes para la busqueda por columna
        $('#sample_1 thead tr').clone(true).appendTo( '#sample_1 thead' );
        $('#sample_1 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( tables1.column(i).search() !== this.value ) {
                    tables1
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );

        var table1 = $('#sample_1').DataTable({
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

        // Duplicar el encabezado de la tabla Posibles Clientes para la busqueda por columna
        $('#sample_2 thead tr').clone(true).appendTo( '#sample_2 thead' );
        $('#sample_2 thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( tables2.column(i).search() !== this.value ) {
                    tables2
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });

        var tables2 = $('#sample_2').DataTable({
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

        // Duplicar el encabezado de la tabla Inversión para la busqueda por columna
        $('#dataTableInversion thead tr').clone(true).appendTo( '#dataTableInversion thead' );
        $('#dataTableInversion thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table2.column(i).search() !== this.value ) {
                    table2
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });

        var table2 = $('#dataTableInversion').DataTable({
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

        // Duplicar el encabezado de la tabla Inversión para la busqueda por columna
        $('#dataTableInversionP thead tr').clone(true).appendTo( '#dataTableInversionP thead' );
        $('#dataTableInversionP thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table2P.column(i).search() !== this.value ) {
                    table2P
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });

        var table2P = $('#dataTableInversionP').DataTable({
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });
        
        // Duplicar el encabezado de la tabla Facturas para la busqueda por columna
        $('#dataTableFactura thead tr').clone(true).appendTo( '#dataTableFactura thead' );
        $('#dataTableFactura thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table3.column(i).search() !== this.value ) {
                    table3
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });

        var table3 = $('#dataTableFactura').DataTable({
            dom: "B<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + "<'row'<'col-sm-12' <'table-responsive' tr>>>" + "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            orderCellsTop: true,
            autoWidth: true,
            columnDefs: [
                {targets: 0, width: '40px'},
            ],
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

        // Duplicar el encabezado de la tabla Inventarios Extras para la busqueda por columna
        $('#inventario_extras thead tr').clone(true).appendTo( '#inventario_extras thead' );
        $('#inventario_extras thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();
            $(this).html( '<input type="text" placeholder="'+title+'" class="form-control"  />');

            $( 'input', this ).on( 'keyup change', function () {
                if ( table4.column(i).search() !== this.value ) {
                    table4
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        });

        var table4 = $('#inventario_extras').DataTable({
            language: {
                sSearch: "Buscador",
                lengthMenu: '_MENU_ registros por página',
                info: 'Mostrando _TOTAL_ registro(s)',
                infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                emptyTable: "Sin información",
                paginate: {
                    previous: 'Anterior',
                    next: 'Siguiente'
                },
            },
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                    class : 'excel',
                    className: 'btn-secondary',
                    charset: 'utf-8',
                    bom: true
                },
                {
                    extend: 'print',
                    text: '<i class="fa  fa-print"></i> Imprimir',
                    className: 'btn-secondary',
                },
            ]
        });

    } );

    $('.fecha_vigencia_plan').datepicker({
        format        : 'dd-mm-yyyy',
        orientation   : "bottom",
        startDate     : '+0d',
        todayHighlight: true,
        autoclose     : true,
    });

    $('#EnablePlanFechaNueva').datepicker({
        format        : 'dd-mm-yyyy',
        orientation   : "bottom",
        startDate     : '+0d',
        todayHighlight: true,
        autoclose     : true,
    });

    $('.fecha_campania').datepicker({
        format        : 'dd-mm-yyyy',
        orientation   : "bottom",
        startDate: "<?= date('d-m-Y', strtotime("-1 year")); ?>", 
        todayHighlight: true,
        autoclose     : true,
    });
    
    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();

    // Calculo para el total de inversiones.
    function totInversion(){
        let total = 0;

        total = $("#PublicidadInversionPrevista").val() * $("#PublicidadMeses").val();
        $("#PublicidadTotInversion").val(new Intl.NumberFormat().format(total));
    }

    // Modal edit plan de pagos
    function disabledPlan( idPlan, aliasPlan, statusPlan) {
        $("#disabled_plan").modal('show');
        $("#disabledPlanId").val(idPlan);
        $("#disabledPlanStatus").val(statusPlan);

        if( statusPlan == 0 ){
            $("#labelDisabledPlan").html(" ¿ Desea deshabilitar el plan de pagos "+aliasPlan+" ? ");
        }else{
            $("#labelDisabledPlan").html(" ¿ Desea habilitar el plan de pagos "+aliasPlan+" ? ");
        }
    }

    // Submit form plan de pagos
    function fDisabledPlan (){
        
        $.ajax({
            url     : '<?= Router::url(array("controller" => "PlanesDesarrollos", "action" => "disable")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : { PlanesDesarrollo: { status: $("#disabledPlanStatus").val(), id: $("#disabledPlanId").val() } },
            success : function ( response ) {

                // console.log( response );
                $("#disabled_plan").modal('hide');
                location.reload();

            },
            error: function ( error ){
                console.log( error.responseText );
            }
        });

    };

    function enablePlan( idPlanPagos, aliasPlan, fechaPlan ){
        $("#enablePlanId").val(idPlanPagos);
        $("#enable_plan").modal('show');
        
        // Validacion de fecha actual vs fecha plan.
        var date1 = new Date(fechaPlan);
        var date2 = 
        ('<?= date('Y-m-d'); ?>');

        if( date1 < date2 ){
            $("#mensaje-enable-plan").html("Es necesario actualizar la fecha de vigencia, de lo contrario se hará de forma automática, agregando un año a la fecha actual.");
            // Mostramos el campo de la nueva vigencia.
            $("#EnablePlanFechaNueva").removeClass('hidden');
            $("#EnablePlanFechaNueva").prop('required',true);

        }else{
            $("#mensaje-enable-plan").html("Se cambiara el estatus del plan de pago " + '"'+ aliasPlan+ '"' );
            $("#EnablePlanFechaNueva").addClass('hidden');
            $("#EnablePlanFechaNueva").prop('required',false);
        }

    }

    // Modal para la edición del plan de pagos
    function editPlan(id){
        $("#edit_plan").modal('show');
        $("#PlanesDesarrolloEditId").val(id);

        if (id) {
            var dataString = 'plan_id='+ id;
            $.ajax({
                type: "POST",
                url: '<?php echo Router::url(array("controller" => "planes_desarrollos", "action" => "getPlan")); ?>' ,
                data: dataString,
                cache: false,
                success: function( response ) {
                    console.log( response );
                    let plan = response.PlanesDesarrollo;

                    // Pintamos el html.
                    $("#PlanesDesarrolloEditAlias").val( plan.alias );
                    $("#PlanesDesarrolloEditVigencia").val( plan.vigencia );

                    // Condicion de que campo mostrar
                    if( plan.descuento > 0 ){

                        $("#PlanesDesarrolloEditDescuento").removeClass('hidden');
                        $("#PlanesDesarrolloEditDescuentoQ").addClass('hidden');

                        $("#span_desc_p_edit").addClass('text-primary');
                        $("#span_desc_q_edit").removeClass('text-primary');

                    }else{
                        $("#PlanesDesarrolloEditDescuento").addClass('hidden');
                        $("#PlanesDesarrolloEditDescuentoQ").removeClass('hidden');

                        $("#span_desc_q_edit").addClass('text-primary');
                        $("#span_desc_p_edit").removeClass('text-primary');

                    }

                    if( plan.apartado > 0 ){

                        $("#PlanesDesarrolloEditApartado").removeClass('hidden');
                        $("#PlanesDesarrolloEditApartadoQ").addClass('hidden');

                        $("#span_apartado_p_edit").addClass('text-primary');
                        $("#span_apartado_q_edit").removeClass('text-primary');

                    }else{
                        $("#PlanesDesarrolloEditApartado").addClass('hidden');
                        $("#PlanesDesarrolloEditApartadoQ").removeClass('hidden');

                        $("#span_apartado_p_edit").removeClass('text-primary');
                        $("#span_apartado_q_edit").addClass('text-primary');

                    }



                    $("#PlanesDesarrolloEditDescuento").val( plan.descuento );
                    $("#PlanesDesarrolloEditDescuentoQ").val( plan.descuento_q );
                    
                    $("#PlanesDesarrolloEditApartado").val( plan.apartado );
                    $("#PlanesDesarrolloEditApartadoQ").val( plan.apartado_q );

                    $("#PlanesDesarrolloEditContrato").val( plan.contrato );
                    $("#PlanesDesarrolloEditFinanciamiento").val( plan.financiamiento );
                    $("#PlanesDesarrolloEditEscrituracion").val( plan.escrituracion );
                    
                    $("#PlanesDesarrolloEditTotal").val( Number(plan.contrato) + Number(plan.financiamiento) + Number(plan.escrituracion) );

                    $("#PlanesDesarrolloEditObservacionesPublicas").val( plan.observaciones_publicas );
                    $("#PlanesDesarrolloEditObservacionesInternas").val( plan.observaciones_internas );

                } 
            });
        }
    }

    $("#EnablePlanViewForm").submit( function ( event ){
        event.preventDefault();

        if( $("#EnablePlanFechaNueva").val() ){
            var dataSend = { vigencia: $("#EnablePlanFechaNueva").val(), id: $("#enablePlanId").val(), status: 1 };
        }else{
            var dataSend = { id: $("#enablePlanId").val(), status: 1 };
            // console.log("Entramos en solo status");
        }


        $.ajax({
            url     : '<?= Router::url(array("controller" => "PlanesDesarrollos", "action" => "edit")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : { PlanesDesarrolloEdit: dataSend },
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {

                $("#enable_plan").modal('hide');
                $("#overlay").fadeOut();
                location.reload();

            },
            error: function ( response ){
                
                console.log( response.responseText );

            }
        });
    });

    // Submit del formulario del plan de pagos.
    $("#PlanesDesarrolloEditViewForm").submit( function ( event ){
        event.preventDefault();

        $.ajax({
            url     : '<?= Router::url(array("controller" => "PlanesDesarrollos", "action" => "edit")); ?>',
            cache   : false,
            dataType: 'json',
            type    : "POST",
            data    : $('#PlanesDesarrolloEditViewForm').serialize(),
            beforeSend: function () {
                $("#overlay").fadeIn();
            },
            success: function ( response ) {

                $("#edit_plan").modal('hide');
                location.reload();

            },
            error: function ( response ){
                
                $("#overlay").fadeOut();
                console.log( response.responseText );
                $("#modal_success").modal('show');
                document.getElementById("m_success").innerHTML = 'Ocurrió un error al intentar guardar la cuenta bancaria <br> código de error: EECB-001';

            }
        });
    });

    // Validacion del plan del desarrollo
    function validaTotal(){
        // var apartado       = Number(document.getElementById('apartado').value);

        var contrato       = Number(document.getElementById('PlanesDesarrolloContrato').value);
        var financiamiento = Number(document.getElementById('PlanesDesarrolloFinanciamiento').value);
        var escrituracion  = Number(document.getElementById('PlanesDesarrolloEscrituracion').value);

        var total          = 0;

        if((contrato+financiamiento+escrituracion) == 100){
            document.getElementById('registrar').style.display="";
            $("#PlanesDesarrolloTotal").removeClass('form-control-danger');
        }else{
            document.getElementById('registrar').style.display="none";
            $("#PlanesDesarrolloTotal").addClass('form-control-danger');
        }
        total = (contrato+financiamiento+escrituracion);
        $("#PlanesDesarrolloTotal").val(total);
    }

    function validaTotalEdit(){
        // var apartado       = Number(document.getElementById('apartado').value);

        var contrato       = Number(document.getElementById('PlanesDesarrolloEditContrato').value);
        var financiamiento = Number(document.getElementById('PlanesDesarrolloEditFinanciamiento').value);
        var escrituracion  = Number(document.getElementById('PlanesDesarrolloEditEscrituracion').value);

        var total          = 0;

        if((contrato+financiamiento+escrituracion) == 100){
            document.getElementById('registrarEdit').style.display="";
            $("#PlanesDesarrolloEditTotal").removeClass('form-control-danger');
        }else{
            document.getElementById('registrarEdit').style.display="none";
            $("#PlanesDesarrolloEditTotal").addClass('form-control-danger');
        }
        total = (contrato+financiamiento+escrituracion);
        $("#PlanesDesarrolloEditTotal").val(total);
    }


    function cambioApartado( tipo ){
        if( tipo == 1 ){
            $("#PlanesDesarrolloApartado").removeClass('hidden');
            $("#PlanesDesarrolloApartadoQ").addClass('hidden');

            $("#span_apartado_p").addClass('text-primary');
            $("#span_apartado_q").removeClass('text-primary');

        }else{
            $("#PlanesDesarrolloApartado").addClass('hidden');
            $("#PlanesDesarrolloApartadoQ").removeClass('hidden');

            $("#span_apartado_p").removeClass('text-primary');
            $("#span_apartado_q").addClass('text-primary');
        }
    }

    function cambioDescuento( tipo ){
        if( tipo == 1 ){
            $("#PlanesDesarrolloDescuento").removeClass('hidden');
            $("#PlanesDesarrolloDescuentoQ").addClass('hidden');
            
            $("#span_desc_p").addClass('text-primary');
            $("#span_desc_q").removeClass('text-primary');

        }else{
            $("#PlanesDesarrolloDescuento").addClass('hidden');
            $("#PlanesDesarrolloDescuentoQ").removeClass('hidden');

            $("#span_desc_p").removeClass('text-primary');
            $("#span_desc_q").addClass('text-primary');

        }
    }

    /**
     * 
     * 
     * 10/05/2022 - AKA (rogueOne).
     * Esta funcion trae la informacion de la publicadad a modificar 
     * 
    */
    function editPublicidad(id){
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "publicidads", "action" => "getPublicidad")); ?>' ,
            data: { publicidad_id: id },
            cache: false,
            success: function(html) {
                document.getElementById('id_publicidads').value = html.Publicidad.id;
                document.getElementById('nombre_publicidads').value = html.Publicidad.dic_linea_contacto_id;
                document.getElementById('fecha_inicio_publicidads').value = html.Publicidad.fecha_inicio;
                document.getElementById('inversion_prevista_publicidads').value = html.Publicidad.inversion_prevista;
                document.getElementById('odjetivo_publicidads').value = html.Publicidad.meses;
                document.getElementById('inversion_real_publicidads').value = html.Publicidad.inversion_real;
                $('.chzn-select').trigger('chosen:updated');
            }, 
            error:function (html) {
                console.log(html.responseText);
            }
            
        });
        $("#edit_publicidad").modal('show');
    }
    /**
     * 
     */
    function editPublicidadGuardado(){
        let id        = document.getElementById('id_publicidads').value;
        let nombre    = document.getElementById('nombre_publicidads').value;
        let fecha     = document.getElementById('fecha_inicio_publicidads').value;
        let inversion = document.getElementById('inversion_prevista_publicidads').value ;
        let objetivo  = document.getElementById('odjetivo_publicidads').value;
        let real      = document.getElementById('inversion_real_publicidads').value;
        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "publicidads", "action" => "saveEditPublicidad")); ?>' ,
            data: { id:id, nombre:nombre , fecha:fecha, inversion:inversion, objetivo:objetivo, real:real},
            cache: false,
            success: function(response) {
                console.log( response );
            }, 
            error:function (html) {
                console.log(html.responseText);
            }
            
        });
    }


</script>