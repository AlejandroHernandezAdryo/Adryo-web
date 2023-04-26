
<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            '/vendors/swiper/css/swiper.min',
            'css/pages/general_components'
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-th"></i>Bienvenido a Inmosystem</h4> 
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                            
                            <div class="col-xl-12">
                                <div class="card m-t-35">
                                    <div class="card-header bg-white">
                                        <i class="fa fa-users"></i>
                                        Seguimiento de clientes
                                        
                                    </div>
                                    <div id="rootwizard">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">1</span>Información de Super Usuario',
                                                    array(
                                                        'controller'=>'users','action'=>'informacion_personal'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">2</span>Información de Empresa',
                                                    array(
                                                        'controller'=>'users','action'=>'informacion_empresa'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                            
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <?= $this->Html->link(
                                                    '<span class="userprofile_tab1 tab_clr">3</span>Reglas de envío de correos',
                                                    array(
                                                        'controller'=>'users','action'=>'parametros_mail'
                                                        ),
                                                    array('escape'=>false,'class'=>'nav-link','data-toogle'=>'tab')
                                                    )
                                            ?>
                                            
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link active" href="#tab4"
                                               data-toggle="tab"><span class="userprofile_tab4 tab_clr">4</span>Diccionarios</a>
                                        </li>
                                        <li class="nav-item m-t-15">
                                            <a class="nav-link" href="#"
                                               data-toggle="tab" style="pointer-events: none"><span>5</span>Parmámetros Generales</a>
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-lg-12 m-t-35">
                                            <div class="card">
                                                <div class="card-header bg-white">
                                                    DIccionarios del sistema
                                                    <?= $this->Html->link('Continuar al siguiente paso',array('controller'=>'users','action'=>'calificacion_clientes'),array('style'=>'color:red; float:right'))?>                                                    
                                                </div>
                                                <div class="card-block">
                                                    <div class="col-md-12 m-t-10 accordian_alignment">
                                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-header" role="tab" id="title-one" style="background-color: #06256e;color: white;">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-one" aria-expanded="false">
                                                                        Tipos de clientes
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($tipo_clientes)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="card-data-one" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-one" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar Tipo de cliente
                                                                                
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicTipoCliente',array('url'=>array('action'=>'add_config','controller'=>'DicTipoClientes')))?>
                                                                                    <div class="input-group">
                                                                                    <input type="search" class="form-control" name="data[DicTipoCliente][tipo_cliente]" id="DicTipoClienteTipoCliente">
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Tipo de cliente</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table>
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Tipo de cliente</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_clientes as $tipo):?>

                                                                                <tr>
                                                                                    <td><?= $tipo['DicTipoCliente']['tipo_cliente']?></td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoClientes','action' => 'delete_config', $tipo['DicTipoCliente']['id']), array('escape'=>false), __('Desea eliminar este tipo de cliente?', $tipo['DicTipoCliente']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                               </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card m-t-20">
                                                                <div class="card-header" role="tab" id="title-two" style="background-color: #06256e;color: white;">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-two" aria-expanded="false">
                                                                        Etapa de cliente
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($etapas)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 2){?>
                                                                    <div id="card-data-two" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-two" class="card-collapse collapse">
                                                                <?php } ?>
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar Etapa del cliente
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicEtapa',array('url'=>array('action'=>'add_config','controller'=>'DicEtapas')))?>
                                                                                    <div class="input-group">
                                                                                    <input type="search" class="form-control" name="data[DicEtapa][etapa]" id="DicTipoClienteTipoCliente">
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Etapa del cliente</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table>
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Etapa de cliente</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($etapas as $etapa):?>
                                                                                <tr>
                                                                                    <td><?= $etapa['DicEtapa']['etapa']?></td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicEtapas','action' => 'delete_config', $etapa['DicEtapa']['id']), array('escape'=>false), __('Desea eliminar esta etapa de cliente?', $etapa['DicEtapa']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="card m-t-20">
                                                                <div class="card-header" role="tab" id="title-three" style="background-color: #06256e;color: white;">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-three" aria-expanded="false">
                                                                        Lineas de contacto
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($linea_contactos)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 3){?>
                                                                    <div id="card-data-three" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-three" class="card-collapse collapse">
                                                                <?php } ?>
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar Línea de contacto
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicLineaContacto',array('url'=>array('action'=>'add_config','controller'=>'DicLineaContactos')))?>
                                                                                    <div class="input-group">
                                                                                    <input type="search" class="form-control" name="data[DicLineaContacto][linea_contacto]" id="DicTipoClienteTipoCliente">
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Línea de contacto</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table>
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Línea de contacto</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($linea_contactos as $linea):?>
                                                                                <tr>

                                                                                    <td><?= $linea['DicLineaContacto']['linea_contacto']?></td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicLineaContactos','action' => 'delete_config', $linea['DicLineaContacto']['id']), array('escape'=>false), __('Desea eliminar esta línea de contacto?', $linea['DicLineaContacto']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="card m-t-20">
                                                                <div class="card-header" role="tab" id="title-four" style="background-color: #06256e;color: white;">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-four" aria-expanded="false">
                                                                        Tipo de anuncio
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($tipo_anuncios)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 4){?>
                                                                    <div id="card-data-four" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-four" class="card-collapse collapse">
                                                                <?php } ?>
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar Tipo de Anuncios
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicTipoAnuncio',array('url'=>array('action'=>'add_config','controller'=>'DicTipoAnuncios')))?>
                                                                                    <div class="input-group">
                                                                                    <input type="search" class="form-control" name="data[DicTipoAnuncio][tipo_anuncio]" id="DicTipoAnuncioTipoAnuncio">
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Tipo de anuncios</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table>
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Tipo de anuncio</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_anuncios as $tipo):?>
                                                                                <tr>

                                                                                    <td><?= $tipo['DicTipoAnuncio']['tipo_anuncio']?></td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoAnuncios','action' => 'delete_config', $tipo['DicTipoAnuncio']['id']), array('escape'=>false), __('Desea eliminar esta línea de contacto?', $tipo['DicTipoAnuncio']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="card m-t-20">
                                                                <div class="card-header" role="tab" id="title-six" style="background-color: #06256e;color: white;">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-six" aria-expanded="false">
                                                                        Tipos de propiedades
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($tipo_propiedads)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 6){?>
                                                                    <div id="card-data-six" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-six" class="card-collapse collapse">
                                                                <?php } ?>
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar Tipo de propiedad
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicTipoPropiedad',array('url'=>array('action'=>'add_config','controller'=>'DicTipoPropiedads')))?>
                                                                                    <div class="input-group">
                                                                                    <input type="search" class="form-control" name="data[DicTipoPropiedad][tipo_propiedad]" id="DicTipoPropiedadTipoPropiedad">
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Tipo de propiedad</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table>
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Tipo de propiedad</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_propiedads as $tipo):?>
                                                                                <tr>
                                                                                    <td><?= $tipo['DicTipoPropiedad']['tipo_propiedad']?></td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoPropiedads','action' => 'delete_config', $tipo['DicTipoPropiedad']['id']), array('escape'=>false), __('Desea eliminar esta tipo de propiedad?', $tipo['DicTipoPropiedad']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                        
                                                                </div>
                                                                        
                                                            </div>
                                                        </div>
                                                                <div class="form-actions form-group row">
                                                <div class="col-xl-12">
                                                    
                                                    <a href="/bos2/users/calificacion_clientes"><input type="button" value="Guardar Información de configuración de mails e ir al siguiente paso" class="btn btn-success" style="width:100%"></a>
                                                </div>
                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        
                        
                    </div>
                    
                </div>
            </div>
        </div>

 
<?= $this->Html->script(
        array(
            '/vendors/jquery-validation-engine/js/jquery.validationEngine',
            '/vendors/jquery-validation-engine/js/jquery.validationEngine-en',
            '/vendors/jquery-validation/js/jquery.validate',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/moment/js/moment.min',
            'js/form',
            
            '/vendors/sweetalert/js/sweetalert2.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            
            '/vendors/swiper/js/swiper.min'
            
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function() {
    
    
    $(".card-collapse").on('show.bs.collapse', function () {
        $(this).prev("div").find("i").removeClass("fa-plus").addClass("fa-minus");
    });
    $(".card-collapse").on('hide.bs.collapse', function () {
        $(this).prev("div").find("i").removeClass("fa-minus").addClass("fa-plus");
    });

//        swiper
    var swiper = new Swiper('.widget_swiper', {
        centeredSlides: true,
        autoplay: 2000,
        loop: true,
        autoplayDisableOnInteraction: false
    });
    $(".wrapper").on("resize", function() {
        setTimeout(function() {
            swiper.update();
        }, 400);
    });
    
    
    
});


<?php 
    $this->Html->scriptEnd();
?>