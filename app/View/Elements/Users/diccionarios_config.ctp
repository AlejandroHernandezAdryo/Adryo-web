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


<div class="modal fade" id="diccionarioEdit" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip">&times;</button>
                <h4 class="modal'title" id="header-formulario"></h4>
            </div>
            
            <div class="modal-body" id="form-edit">
            </div>

        </div>
    </div>
</div>





<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-cogs"></i>CONFIGURACIÓN</h4> 
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                            
                            <div class="col-xl-12">
                                    <div class="row">
                                        <div class="col-lg-12 m-t-35">
                                            <div class="card">
                                                <div class="card-header bg-white">
                                                    Diccionarios del sistema
                                                </div>
                                                <div class="card-block">
                                                    <div class="col-md-12 m-t-10 accordian_alignment">
                                                        <div id="accordion" role="tablist" aria-multiselectable="true">
                                                            <div class="card">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
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
                                                                                    <?php echo $this->Form->create('DicTipoCliente',array('url'=>array('action'=>'add_config_c','controller'=>'DicTipoClientes')))?>
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
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Tipo de cliente</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                    <th style="width:20%">Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_clientes as $tipo):?>

                                                                                <tr>
                                                                                    <td><?= $tipo['DicTipoCliente']['tipo_cliente'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(1, <?= $tipo['DicTipoCliente']['id'] ?>, '<?= $tipo['DicTipoCliente']['tipo_cliente'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoClientes','action' => 'delete_config', $tipo['DicTipoCliente']['id']), array('escape'=>false), __('Desea eliminar este tipo de cliente?', $tipo['DicTipoCliente']['id'])); ?>
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                               </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            

                                                            <!-- Linea de contacto -->
                                                            <div class="card m-t-20">
                                                                <?php
                                                                    // Cambiamos el array de los estados por el que tenemos en el diccionario
                                                                    $estados = array(
                                                                        1 => 'Interés Preliminar',
                                                                        2 => 'Comunicación Abierta',
                                                                        3 => 'Precalificación',
                                                                        4 => 'Visita',
                                                                        5 => 'Análisis de Opciones',
                                                                        6 => 'Validación de Recursos',
                                                                        7 => 'Cierre'
                                                                    );
                                                                ?>
                                                                <div class="card-header bg-blue-is"  bg-blue-isrole="tab" id="title-three">
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
                                                                                    <?php echo $this->Form->create('DicLineaContacto',array('url'=>array('action'=>'add_config_c','controller'=>'DicLineaContactos')))?>
                                                                                    <div class="input-group">
                                                                                        <?= $this->Form->input('linea_contacto',array('type'=>'text','class'=>'form-control','div'=>'col-sm-6','label'=>'Nombre de linea'))?>
                                                                                        <?= $this->Form->input('etapa_embudo',array('type'=>'select','options'=>$estados, 'class'=>'form-control','div'=>'col-sm-6','label'=>'Etapa en la que comienza esta línea de contacto'))?>
                                                                                            <span class="input-group-btn">
                                                                                        <button class="btn btn-primary" type="submit">
                                                                                            <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                        </span> Agregar Línea de contacto</button>
                                                                                        </span>
                                                                                        </div>

                                                                                    <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Línea de contacto</th>
                                                                                    <th>Etapa del Embudo de Ventas</th>
                                                                                    <th>Editar</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($linea_contactos as $linea):?>
                                                                                <tr>

                                                                                    <td><?= $linea['DicLineaContacto']['linea_contacto']?></td>
                                                                                    <td><?= $estados[$linea['DicLineaContacto']['etapa_embudo']]?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(3, <?= $linea['DicLineaContacto']['id'] ?>, '<?= $linea['DicLineaContacto']['linea_contacto'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicLineaContactos','action' => 'delete_config', $linea['DicLineaContacto']['id']), array('escape'=>false), __('Desea eliminar esta línea de contacto?', $linea['DicLineaContacto']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Tipos de propiedades. -->
                                                            <div class="card m-t-20">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-six">
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
                                                                                    <?php echo $this->Form->create('DicTipoPropiedad',array('url'=>array('action'=>'add_config_c','controller'=>'DicTipoPropiedads')))?>
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
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Tipo de propiedad</th>
                                                                                    <th>Editar</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_propiedads as $tipo):?>
                                                                                <tr>
                                                                                    <td><?= $tipo['DicTipoPropiedad']['tipo_propiedad']?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(4, <?= $tipo['DicTipoPropiedad']['id'] ?>, '<?= $tipo['DicTipoPropiedad']['tipo_propiedad'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoPropiedads','action' => 'delete_config', $tipo['DicTipoPropiedad']['id']), array('escape'=>false), __('Desea eliminar esta tipo de propiedad?', $tipo['DicTipoPropiedad']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tipo de anuncio -->
                                                            <div class="card m-t-20">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-four">
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
                                                                            <table class="table table-sm">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Tipo de anuncio</th>
                                                                                    <th>Editar</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_anuncios as $tipo):?>
                                                                                <tr>

                                                                                    <td><?= $tipo['DicTipoAnuncio']['tipo_anuncio']?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(5, <?= $tipo['DicTipoAnuncio']['id'] ?>, '<?= $tipo['DicTipoAnuncio']['tipo_anuncio'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicTipoAnuncios','action' => 'delete_config', $tipo['DicTipoAnuncio']['id']), array('escape'=>false), __('Desea eliminar esta línea de contacto?', $tipo['DicTipoAnuncio']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Dicconario de tipo de proveedores -->
                                                            <div class="card m-t-20">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-six">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-factura" aria-expanded="false">
                                                                        Categorias de facturas
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($tipo_facturas)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 6){?>
                                                                    <div id="card-data-factura" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-factura" class="card-collapse collapse">
                                                                <?php } ?>
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar categoria de factura
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php
                                                                                        echo $this->Form->create('DicFactura',array('url'=>array('action'=>'add','controller'=>'DicFacturas')));
                                                                                        echo $this->Form->hidden('redirectTo', array('value'=>2));
                                                                                    ?>
                                                                                    <div class="input-group">
                                                                                        <?= $this->Form->input('nombre', array('type'=>'search', 'class'=>'form-control', 'div'=>false,'label'=>false)); ?>
                                                                                        <span class="input-group-btn">
                                                                                            <button class="btn btn-primary" type="submit">
                                                                                                <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                                </span> Agregar categoria de factura
                                                                                            </button>
                                                                                        </span>
                                                                                    </div>

                                                                                    <?php
                                                                                        echo $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')));
                                                                                        echo $this->Form->hidden( 'status', array( 'value' =>1 ) );
                                                                                    ?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Categoria de factura</th>
                                                                                    <th>Editar</th>
                                                                                    <th>Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($tipo_facturas as $tipo):?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <?= $tipo['DicFactura']['nombre']?>
                                                                                        
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(6, <?= $tipo['DicFactura']['id'] ?>, '<?= $tipo['DicFactura']['nombre'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td><?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicFacturas','action' => 'delete', $tipo['DicFactura']['id']), array('escape'=>false), __('Desea eliminar esta categoria de factura?', $tipo['DicFactura']['id'])); ?></td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                                </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Diccionario inactivación de clientes -->
                                                            <div class="card mt-2">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-ridc" aria-expanded="false">
                                                                        Razones de inactivación definitiva de clientes
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($razon_inactivacion_def_clientes)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="card-data-ridc" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-ridc" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar razón de inactivación de cliente
                                                                                
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicRazonInactivacion',array('url'=>array('action'=>'add_dic_config','controller'=>'DicRazonInactivacions')))?>
                                                                                        
                                                                                        <div class="input-group">
                                                                                            
                                                                                            <!-- <input type="text" class="form-control"> -->

                                                                                            <?= $this->Form->input('razon', array('class' => 'form-control', 'label' => false)); ?>
                                                                                            <span class="input-group-btn">
                                                                                                <button class="btn btn-primary" type="submit">
                                                                                                <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                                </span> Agregar razón de inactivación de cliente</button>
                                                                                            </span>
                                                                                        </div>

                                                                                        <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                        <?= $this->Form->hidden('status', array('value'=>'1'))?>
                                                                                        <?= $this->Form->hidden('tabla', array('value'=>'clientes'))?>
                                                                                        <?= $this->Form->hidden('tipo_razon', array('value'=>'1'))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Razón de inactivación definitiva</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                    <th style="width:20%">Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($razon_inactivacion_def_clientes as $razon_def_clientes):?>

                                                                                <tr>
                                                                                    <td><?= $razon_def_clientes['DicRazonInactivacion']['razon'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(7, <?= $razon_def_clientes['DicRazonInactivacion']['id'] ?>, '<?= $razon_def_clientes['DicRazonInactivacion']['razon'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicRazonInactivacions','action' => 'delete', $razon_def_clientes['DicRazonInactivacion']['id']), array('escape'=>false), __('Desea eliminar esta razón de inactivación definitiva de clienes?', $razon_def_clientes['DicRazonInactivacion']['id'])); ?>
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                               </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Razones temporales de inactivacion de clientes. -->
                                                            <div class="card mt-2">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#card-data-ritc" aria-expanded="false">
                                                                        Razones de inactivación temporal de clientes
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($razon_inactivacion_temp_clientes)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="card-data-ritc" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="card-data-ritc" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                            <div class="card-header">
                                                                                <i class="fa fa-plus"></i> Agregar razón de inactivación temporal de cliente
                                                                                
                                                                            </div>
                                                                            <div class="card-block">
                                                                                <div class="card-block m-t-20">
                                                                                    <?php echo $this->Form->create('DicRazonInactivacion',array('url'=>array('action'=>'add_dic_config','controller'=>'DicRazonInactivacions')))?>
                                                                                        
                                                                                        <div class="input-group">
                                                                                            
                                                                                            <!-- <input type="text" class="form-control"> -->

                                                                                            <?= $this->Form->input('razon', array('class' => 'form-control', 'label' => false)); ?>
                                                                                            <span class="input-group-btn">
                                                                                                <button class="btn btn-primary" type="submit">
                                                                                                <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                                                                </span> Agregar razón de inactivación temporal de cliente</button>
                                                                                            </span>
                                                                                        </div>

                                                                                        <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                                                                        <?= $this->Form->hidden('status', array('value'=>'1'))?>
                                                                                        <?= $this->Form->hidden('tabla', array('value'=>'clientes'))?>
                                                                                        <?= $this->Form->hidden('tipo_razon', array('value'=>'2'))?>
                                                                                    <?= $this->Form->end()?>
                                                                                </div>
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Razón de inactivación temporal</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                    <th style="width:20%">Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($razon_inactivacion_temp_clientes as $razon_temp_clientes):?>

                                                                                <tr>
                                                                                    <td><?= $razon_temp_clientes['DicRazonInactivacion']['razon'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(8, <?= $razon_temp_clientes['DicRazonInactivacion']['id'] ?>, '<?= $razon_temp_clientes['DicRazonInactivacion']['razon'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'DicRazonInactivacions','action' => 'delete', $razon_temp_clientes['DicRazonInactivacion']['id']), array('escape'=>false), __('Desea eliminar esta razón de inactivación definitiva de clienes?', $razon_temp_clientes['DicRazonInactivacion']['id'])); ?>
                                                                                        
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                               </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Diccionario de embudo de ventas. -->
                                                            <div class="card mt-2">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#dic_embudo_ventas" aria-expanded="false">
                                                                        Diccionario de embudo de ventas
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($embudo_ventas)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="dic_embudo_ventas" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="dic_embudo_ventas" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                        <?php if( sizeof($embudo_ventas) < 7 ): ?>
                                                                            <?php echo $this->Form->create('DicEmbudoVenta',array('url'=>array('action'=>'add_diccionario','controller'=>'DicEmbudoVentas')))?>
                                                                                
                                                                                <div class="row">
                                                                                    <?=
                                                                                        $this->Form->input('nombre',
                                                                                            array(
                                                                                                'class'       => 'form-control',
                                                                                                'div'         => 'col-sm-12 col-lg-6',
                                                                                                'label'       => false,
                                                                                                'required'    => true,
                                                                                                'placeholder' => 'Nombre de etapa'
                                                                                            )
                                                                                        );
                                                                                    ?>
                                                                                    <?=
                                                                                        $this->Form->input('orden',
                                                                                            array(
                                                                                                'class'       => 'form-control',
                                                                                                'div'         => 'col-sm-12 col-lg-6',
                                                                                                'label'       => false,
                                                                                                'required'    => true,
                                                                                                'placeholder' => 'Orden de la etapa'
                                                                                            )
                                                                                        );
                                                                                    ?>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-sm-12 col-lg-6 mt-2">
                                                                                        <?=
                                                                                            $this->Form->submit('Agregar etapa',
                                                                                                array(
                                                                                                    'class' => 'btn btn-primary'
                                                                                                )
                                                                                            );
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            <?= $this->Form->end() ?>
                                                                        <?php endif; ?>
                                                                    
                                                                            <div class="card-block">
                                                                                <p class='text-danger'>
                                                                                    <i class='fa fa-exclamation-circle'></i>
                                                                                    Es forzoso tener 7 etapas.
                                                                                </p>
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Nombre de etapa</th>
                                                                                    <th style="width:20%">Orden</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($embudo_ventas as $embudo):?>

                                                                                <tr>
                                                                                    <td><?= $embudo['DicEmbudoVenta']['nombre'] ?></td>
                                                                                    <td><?= $embudo['DicEmbudoVenta']['orden'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(9, <?= $embudo['DicEmbudoVenta']['id'] ?>, '<?= $embudo['DicEmbudoVenta']['nombre'] ?>', '<?= $embudo['DicEmbudoVenta']['orden'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                               </tbody>
                                                                            </table>
                                                                            </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Diccionario de razones de citas canceladas. -->
                                                            <div class="card mt-2">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#dic_citas_canceladas" aria-expanded="false">
                                                                        Diccionario de razones de citas canceladas
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($citas_canceladas)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="dic_citas_canceladas" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="dic_citas_canceladas" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                        <?php echo $this->Form->create('Diccionario',array('url'=>array('action'=>'add_diccionario','controller'=>'Diccionarios')))?>
                                                                            
                                                                            <div class="row">
                                                                                <?=
                                                                                    $this->Form->input('descripcion',
                                                                                        array(
                                                                                            'class'       => 'form-control',
                                                                                            'div'         => 'col-sm-12 col-lg-6',
                                                                                            'label'       => false,
                                                                                            'required'    => true,
                                                                                            'placeholder' => 'Opción para cancelar cita',
                                                                                            'type'        => 'text'
                                                                                        )
                                                                                    );
                                                                                ?>
                                                                                <?= $this->Form->hidden('sub_directorio', array('value' => 'dic_citas_canceladas'));?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-lg-6 mt-2">
                                                                                    <?=
                                                                                        $this->Form->submit('Agregar opción de citas canceladas',
                                                                                            array(
                                                                                                'class' => 'btn btn-primary'
                                                                                            )
                                                                                        );
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        <?= $this->Form->end() ?>
                                                                    
                                                                        <div class="card-block">
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Opcion</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                    <th style="width:20%">Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($citas_canceladas as $cancelacion_citas):?>

                                                                                <tr>
                                                                                    <td><?= $cancelacion_citas['Diccionario']['descripcion'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(10, <?= $cancelacion_citas['Diccionario']['id'] ?>, '<?= $cancelacion_citas['Diccionario']['descripcion'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'Diccionarios','action' => 'delete', $cancelacion_citas['Diccionario']['id']), array('escape'=>false), __('Desea eliminar esta opción ?', $cancelacion_citas['Diccionario']['id'])); ?>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                            </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Diccionario de razones de citas canceladas. -->
                                                            <div class="card mt-2">
                                                                <div class="card-header bg-blue-is" role="tab" id="title-one">
                                                                    <a class="collapsed accordion-section-title" style="color: white;" data-toggle="collapse" data-parent="#accordion" href="#dic_error_send_cotizacion_wa" aria-expanded="false">
                                                                        Diccionario de error para envio de cotización vía whatsApp
                                                                         <i class="fa fa-plus float-xs-right m-t-5"></i>
                                                                         <span class="tag tag-pill tag-warning float-xs-right calendar_tag menu_hide"><?= sizeof($error_send_cotizaciones)?></span>
                                                                    </a>
                                                                </div>
                                                                <?php if (isset($tab) && $tab == 1){?>
                                                                    <div id="dic_error_send_cotizacion_wa" class="card-collapse">
                                                                <?php }else{?>
                                                                    <div id="dic_error_send_cotizacion_wa" class="card-collapse collapse">
                                                                <?php } ?>
                                                                
                                                                    <div class="card-block m-t-20">
                                                                        <?php echo $this->Form->create('Diccionario',array('url'=>array('action'=>'add_diccionario','controller'=>'Diccionarios')))?>
                                                                            
                                                                            <div class="row">
                                                                                <?=
                                                                                    $this->Form->input('descripcion',
                                                                                        array(
                                                                                            'class'       => 'form-control',
                                                                                            'div'         => 'col-sm-12 col-lg-6',
                                                                                            'label'       => false,
                                                                                            'required'    => true,
                                                                                            'placeholder' => 'Opción para cancelar cita',
                                                                                            'type'        => 'text'
                                                                                        )
                                                                                    );
                                                                                ?>
                                                                                <?= $this->Form->hidden('sub_directorio', array('value' => 'dic_wa_error_send_cotizacion'));?>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-sm-12 col-lg-6 mt-2">
                                                                                    <?=
                                                                                        $this->Form->submit('Agregar opción de error de envío de cotización vía whatsApp',
                                                                                            array(
                                                                                                'class' => 'btn btn-primary'
                                                                                            )
                                                                                        );
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        <?= $this->Form->end() ?>
                                                                    
                                                                        <div class="card-block">
                                                                            <table class="table table-sm ">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:80%">Opcion</th>
                                                                                    <th style="width:20%">Editar</th>
                                                                                    <th style="width:20%">Eliminar</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php foreach ($error_send_cotizaciones as $error_send_cotizacion):?>

                                                                                <tr>
                                                                                    <td><?= $error_send_cotizacion['Diccionario']['descripcion'] ?></td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <i class="fa fa-pencil pointer" onclick="editDiccionario(11, <?= $error_send_cotizacion['Diccionario']['id'] ?>, '<?= $error_send_cotizacion['Diccionario']['descripcion'] ?>' )">
                                                                                            </i>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <?= $this->Form->postLink('<i class="fa fa-trash-o fa-lg"></i>', array('controller'=>'Diccionarios','action' => 'delete', $error_send_cotizacion['Diccionario']['id']), array('escape'=>false), __('Desea eliminar esta opción ?', $error_send_cotizacion['Diccionario']['id'])); ?>
                                                                                        </span>
                                                                                    </td>
                                                                                </tr>
                                                                                <?php endforeach;?>
                                                                            </tbody>
                                                                            </table>
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
                                </div>
                            </div>
                            <!-- /.row -->
                        
                        
                    </div>
                    
                </div>
            </div>
        </div>

 
<?= $this->Html->script(
        array(
            'components',
            'custom',

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


<script>


    function editDiccionario( idFormulario, idDiccionario, valorActual, paramAdd1 ) {
        $("#diccionarioEdit").modal('show');

        // Id formularios 1=> Tipos de cliente, 2=> Etapa de cliente, 3=> Lineas de contacto, 4=> Tipos de propiedades, 5=> Tipo de anuncio, 6=> Categoria de factura, 7=> Razón de inactivación definitiva de clientes, 8 => Razon de inactivacion temporal de clietnes, 9 => Diccionario del embudo de ventas, 10 => Cancelacion de citas, 11 => Opciones de error de envio cotización por whatsapp.

        switch( idFormulario ){
            case 1:
                document.getElementById("header-formulario").innerHTML = 'Edición de tipo de cliente';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicTipoClientes", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicTipoCliente][tipo_cliente]' value='"+valorActual+"'> <input type='hidden' name='data[DicTipoCliente][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 2:
                document.getElementById("header-formulario").innerHTML = 'Edición de etapa de cliente';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicEtapas", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicEtapa][etapa]' value='"+valorActual+"'> <input type='hidden' name='data[DicEtapa][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 3:
                document.getElementById("header-formulario").innerHTML = 'Edición de linea de contacto';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicLineaContactos", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicLineaContacto][linea_contacto]' value='"+valorActual+"'> <input type='hidden' name='data[DicLineaContacto][id]' value='"+idDiccionario+"'> </div><div class='col-sm-12'><label for='DicLineaContactoEtapaEmbudo'>Etapa en la que comienza esta línea de contacto</label><select name='data[DicLineaContacto][etapa_embudo]' class='form-control' id='DicLineaContactoEtapaEmbudo'><option value='1'>Interés Preliminar</option><option value='2'>Comunicación Abierta</option><option value='3'>Precalificación</option><option value='4'>Visita</option><option value='5'>Análisis de Opciones</option><option value='6'>Validación de Recursos</option><option value='7'>Cierre</option></select></div></div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 4:
                document.getElementById("header-formulario").innerHTML = 'Edición de linea de contacto';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicTipoPropiedads", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicTipoPropiedad][tipo_propiedad]' value='"+valorActual+"'> <input type='hidden' name='data[DicTipoPropiedad][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;
            
            case 5:
                document.getElementById("header-formulario").innerHTML = 'Edición de linea de contacto';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicTipoAnuncios", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicTipoAnuncio][tipo_anuncio]' value='"+valorActual+"'> <input type='hidden' name='data[DicTipoAnuncio][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 6:
                document.getElementById("header-formulario").innerHTML = 'Edición de linea de contacto';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicFacturas", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicFactura][nombre]' value='"+valorActual+"'> <input type='hidden' name='data[DicFactura][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer' style='margin-top: 15px;'> <button class='btn btn-success btn-sm pull-left' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 7:
                document.getElementById("header-formulario").innerHTML = 'Edición de RAZONES DE INACTIVACIÓN DEFINITIVA DE CLIENTES  ';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicRazonInactivacions", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicRazonInactivacion][razon]' value='"+valorActual+"'> <input type='hidden' name='data[DicRazonInactivacion][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer'> <button class='btn btn-success btn-sm pull-left mt-1' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right mt-1' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 8:
                document.getElementById("header-formulario").innerHTML = 'Edición de RAZONES DE INACTIVACIÓN temporal DE CLIENTES  ';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicRazonInactivacions", "action" => "edit")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicRazonInactivacion][razon]' value='"+valorActual+"'> <input type='hidden' name='data[DicRazonInactivacion][id]' value='"+idDiccionario+"'> </div> <div class='modal-footer'> <button class='btn btn-success btn-sm pull-left mt-1' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right mt-1' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 9:
                document.getElementById("header-formulario").innerHTML = 'Edición de DICCIONARIO DE EMBUDO DE VENTAS ';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "DicEmbudoVentas", "action" => "edit_diccionario")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[DicEmbudoVenta][nombre]' value='"+valorActual+"'> <input type='hidden' name='data[DicEmbudoVenta][id]' value='"+idDiccionario+"'> </div> <div class='col-sm-12 mt-1'> </div> <div class='modal-footer'> <button class='btn btn-success btn-sm pull-left mt-1' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right mt-1' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;
            
            case 10:
                document.getElementById("header-formulario").innerHTML = 'Edición de DICCIONARIO DE RAZONES DE CITAS CANCELADAS ';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "Diccionarios", "action" => "edit_diccionario")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[Diccionario][descripcion]' value='"+valorActual+"'> <input type='hidden' name='data[Diccionario][id]' value='"+idDiccionario+"'> </div> <div class='col-sm-12 mt-1'> </div> <div class='modal-footer'> <button class='btn btn-success btn-sm pull-left mt-1' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right mt-1' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

            case 11:
                document.getElementById("header-formulario").innerHTML = 'Edición de DICCIONARIO de error de envío de cotizacion vía whatsApp ';
                document.getElementById("form-edit").innerHTML = "<form id='formEditDiccionarios' method='post' action='<?php echo Router::url(array("controller" => "Diccionarios", "action" => "edit_diccionario")); ?>'> <div class='row'> <div class='col-sm-12'> <input class='form-control' name='data[Diccionario][descripcion]' value='"+valorActual+"'> <input type='hidden' name='data[Diccionario][id]' value='"+idDiccionario+"'> </div> <div class='col-sm-12 mt-1'> </div> <div class='modal-footer'> <button class='btn btn-success btn-sm pull-left mt-1' type='button' onclick='formSubmit()'>Guardar cambios</button> <button class='btn btn-error btn-sm float-xs-right mt-1' data-dismiss='modal'>Cancelar</button> </div> </div> </form>";
            break;

        }
    }


    function formSubmit(){
        $("#formEditDiccionarios").submit();
        $("#diccionarioEdit").modal('hide');        
    }

'use strict';
$(document).ready(function() {
    
    
    $(".card-collapse").on('show.bs.collapse', function () {
        $(this).prev("div").find("i").removeClass("fa-plus").addClass("fa-minus");
    });
    $(".card-collapse").on('hide.bs.collapse', function () {
        $(this).prev("div").find("i").removeClass("fa-minus").addClass("fa-plus");
    });

    
});

    
</script>