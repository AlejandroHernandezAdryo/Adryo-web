<?= $this->Html->css(
        array(
            'pages/wizards',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox'
            ),
        array('inline'=>false))
?>
<style>
    .text-black{color: black;}
    .file-caption{
        height: 29px !important;
    }
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



<!-- Modales  -->
<div class="modal fade" id="small" tabindex="-1" role="dialog" aria-labelledby="modalLabelSmall" aria-hidden="true">
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
                <button class="btn  btn-primary" data-dismiss="modal">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="brochure_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabelBrochureModal" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body">
                kasdkasd
            </div>
            <div class="modal-footer">
                <button class="btn  btn-primary" data-dismiss="alerta">Cerrar ventana</button>
            </div>
        </div>
    </div>
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-building"></i> Subir Imágenes y Documentos del Desarrollo</h4>
            </div>
            
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-container ">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block m-t-20">
                            <div id="rootwizard">
                                <ul class="nav nav-pills">
                                    <li class="nav-item m-t-15">
                                        <?= $this->Html->link(
                                                '<span class="userprofile_tab1 tab_clr">1</span>Datos Generales',
                                                array(
                                                    'controller'=>'desarrollos',
                                                    'action'=>'edit_generales',
                                                    $desarrollo['Desarrollo']['id']
                                                ),
                                                array('class'=>'nav-link','escape'=>false)
                                            )
                                        ?>
                                    
                                    </li>
                                    <li class="nav-item m-t-15">
                                        <?= $this->Html->link(
                                                '<span class="userprofile_tab1 tab_clr">2</span>Entorno, Amenidades y Servicios',
                                                array(
                                                    'controller'=>'desarrollos',
                                                    'action'=>'amenidades',
                                                    $desarrollo['Desarrollo']['id']
                                                ),
                                                array('class'=>'nav-link','escape'=>false)
                                            )
                                        ?>
                                    </li>
                                    <li class="nav-item m-t-15">
                                        <?= $this->Html->link(
                                                '<span class="userprofile_tab1 tab_clr">3</span> Multimedia y Documentos',
                                                array(
                                                    'controller'=>'desarrollos',
                                                    'action'=>'anexos',
                                                    $desarrollo['Desarrollo']['id']
                                                ),
                                                array('class'=>'nav-link','escape'=>false)
                                            )
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-block m-t-35">
                            <?php echo $this->Form->create('Desarrollo', array('type'=>'file','url'=>array('controller'=>'Desarrollos', 'action'=>'anexos', $desarrollo['Desarrollo']['id']))); ?>

                            <div class="sub-card mt-3">
                                <div class="card-header bg-blue-is">
                                    Archivos e Imágenes cargados para el desarrollo
                                </div>

                                <div class="card-block">

                                    <div class="row">

                                        <div class="col-lg-8" style="height: 400px; overflow-y: scroll; padding: 20px; border: 1px solid silver">
                                        <?php if (!empty($desarrollo['Desarrollo']['logotipo'])): ?>
                                            <div class="col-sm-12">
                                                <h4 class="text-black">Logotipo del desarrollo</h4>
                                            </div>
                                            <div class="col-sm-12 col-lg-2">
                                                    <?= $this->Html->image($desarrollo['Desarrollo']['logotipo'],array('class'=>'img-fluid'))?>
                                            </div>
                                        <?php endif ?>
                                            <h4 class="col-sm-12 mt-2"><font color="black">Imágenes del Desarrollo</h4>
                                            <?php 
                                                $i =1;
                                                $count = 0;
                                                foreach ($imagenes as $imagen):
                                                $count ++;
                                            ?>
                                            <div class="col-lg-6 m-t-20">
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input('foto_id',array('type'=>'hidden','value'=>$imagen['FotoDesarrollo']['id'], 'name'=>'data[fotos]['.$count.'][id]'));?>

                                                    <?php echo $this->Html->image($imagen['FotoDesarrollo']['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                </div>
                                                
                                                <div class="col-xs-12" style="margin-top: 3px;">
                                                    <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['FotoDesarrollo']['descripcion'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos]['.$count.'][descripcion]','type'=>'text'))?>
                                                </div>
                                                <div class="col-xs-12" style="margin-top: 3px;">
                                                    <?php echo $this->Form->input ('orden', array('placeholder'=>'Orden','value'=>$imagen['FotoDesarrollo']['orden'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos]['.$count.'][orden]'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="checkbox" style="margin-top: 2px;">
                                                        <label>
                                                            <input type="checkbox" name="data[fotos][<?= $count ?>][eliminar]">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>

                                                <style> 
                                                    .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                </style>
                                                <div class="col-xs-12">
                                                    <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['FotoDesarrollo']['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                </div>
                                            </div>
                                            <?php 
                                                $i++;
                                                endforeach;
                                            ?>
                                            <h4 class="col-sm-12 m-t-35"><font color="black">Planos Comerciales</h4>
                                            <hr>
                                            <?php 
                                                $count2 = 0;
                                                foreach ($planos as $imagen):
                                                $count2 ++;

                                            ?>
                                            <div class="col-lg-6 m-t-20">
                                                <div class="col-xs-12">
                                                    <?php echo $this->Html->image($imagen['FotoDesarrollo']['ruta'],array('width'=>'100%','height'=>'150px'))?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <?php echo $this->Form->input ('descripcion', array('placeholder'=>'Descripción','value'=>$imagen['FotoDesarrollo']['descripcion'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos2]['.$count2.'][descripcion]', 'type'=>'text'))?>
                                                </div>
                                                <div class="col-xs-12" style="margin-top: 3px;">
                                                    <?php echo $this->Form->input ('orden'.$i, array('placeholder'=>'Orden','value'=>$imagen['FotoDesarrollo']['orden'],'label'=>false,'style'=>'width:100%', 'name'=>'data[fotos2]['.$count2.'][orden]'))?>
                                                    <?php echo $this->Form->input('foto_id'.$i,array('type'=>'hidden','value'=>$imagen['FotoDesarrollo']['id'], 'name'=>'data[fotos2]['.$count2.'][id]'));?>
                                                </div>
                                                <style> .btn-danger{background-color: #cb2027 !important; }  .btn-danger:hover{background-color: #a81a20 !important ; }
                                                </style>
                                                <div class="col-xs-12">

                                                    <?= $this->Html->link('<i class="fa fa-search fa-lg"></i> Zoom', Router::url($imagen['FotoDesarrollo']['ruta'],true), array('class'=>'btn btn-primary m-t-5', 'escape'=>false, 'target'=>'blanck')) ?>
                                                </div>
                                                <div class="col-xs-12">
                                                    <div class="checkbox" style="margin-top: 2px;">
                                                        <label>
                                                            <input type="checkbox" name="data[fotos2][<?= $count2 ?>][eliminar]">
                                                            <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                                $i++;
                                                endforeach;
                                                echo $this->Form->input('i',array('type'=>'hidden','value'=>$i));
                                            ?>
                                        </div>

                                        <div class="row col-lg-4" style="height: 400px; overflow-y: scroll; padding: 20px; border-right: 1px solid silver;border-top: 1px solid silver; border-bottom: 1px solid silver">
                                            
                                            <h5 class="col-sm-12"><font color="black">Archivos Auxiliares Comerciales</h5>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th width="80%"><b>Documento</b></th>
                                                    <th width="10%"><b><i class="fa fa-download"></i></b></th>
                                                    <th width="10%"><b><i class="fa fa-trash fa-lg"></i></b></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                   <?php if($desarrollo['Desarrollo']['brochure']!=""){?>
                                                    <tr>
                                                        <td>Brochure Comercial</td>
                                                        <td>
                                                            <?= $this->Html->link('<i class="fa fa-download"></i>',$desarrollo['Desarrollo']['brochure'],array('escape'=>false))?>
                                                        </td>
                                                        <td>
                                                            <?= $this->Form->postLink(
                                                           '<i class="fa fa-trash fa-lg"></i>', 
                                                           array(
                                                               'controller'=>'Desarrollos','action'=>'borrar_brochure',
                                                               $desarrollo['Desarrollo']['id']
                                                            ), 
                                                           array(
                                                               'inline'=>false,
                                                               'escape' => false, 'confirm'=> __('Desea eliminar este documento?')
                                                               )
                                                           ); ?>
                                                        </td>
                                                    </tr>
                                                   <?php }?>
                                                   <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
                                                        <tr>
                                                            <td><?= $documento['documento']?></td>
                                                            <td><?= $this->Html->link(
                                                                    '<i class="fa fa-download"></i>',
                                                                    $documento['ruta'],
                                                                    array('escape'=>false)
                                                                )?>
                                                            </td>
                                                            <td>
                                                                <?= $this->Form->postLink(
                                                           '<i class="fa fa-trash fa-lg"></i>', 
                                                           array(
                                                               'controller'=>'Desarrollos','action'=>'eliminar_documento',
                                                               $documento['id'],$desarrollo['Desarrollo']['id']
                                                            ), 
                                                           array(
                                                               'inline'=>false,
                                                               'escape' => false, 'confirm'=> __('Desea eliminar este documento?')
                                                               )
                                                           ); ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach;?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row m-t-10">
                                    <?php 
                                        echo $this->Form->hidden('id', array('value'=>$desarrollo['Desarrollo']['id']));
                                    ?>
                                        <div class="col-sm-12" onmousedown="return false">
                                            <label>Subir Logotipo de Desarrollo</label>
                                            <input id="input-logo" name="data[Desarrollo][logo]" type="file" class="file-loading">
                                        </div>

                                        <div class="col-sm-12">
                                            <div class="row">
                                                <?php 
                                                    echo $this->Form->input('youtube', array('label'=>'URL de video ( Youtube, Vimeo, etc...)','div' => 'col-lg-6','class'=>'form-control'));

                                                    echo $this->Form->input('matterport', array('label'=>'Tour Virtual Matterport','div' => 'col-lg-6','class'=>'form-control'));
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" onmousedown="return false">
                                            <label>Subir Imágenes de Desarrollo</label>
                                            <input id="input-fa" name="data[Desarrollo][fotos][]" type="file" multiple class="file-loading">
                                        </div>

                                        <div class="col-sm-12" onmousedown="return false">
                                            <label>Subir Planos Comerciales</label>
                                            <input id="input-fa-multimedia" name="data[Desarrollo][planos_comerciales][]" type="file" multiple class="file-loading">
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Documentos Necesarios para apoyar tu venta</label>
                                            <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#small" type="button" style="border: none !important;">
                                                    <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                </button>
                                            <input id="input-fa-planos" name="data[Desarrollo][planos][]" type="file" multiple class="file-loading">
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Brochure Personalizado</label>
                                            <button class="btn btn-raised btn-secondary adv_cust_mod_btn" data-toggle="modal" data-target="#small" type="button" style="border: none !important;">
                                                    <i style="cursor: pointer;" class="fa fa-question-circle-o fa-lg"></i>
                                                </button>
                                            <input id="input-fa-brochure" name="data[Desarrollo][brochure]" type="file" class="file-loading">
                                        </div>

                                        <?=
                                            $this->Form->input('url_facebook',
                                                array(
                                                    'class' => 'form-control',
                                                    'div'   =>  'col-sm-12',
                                                    'label' => 'Url Facebook'
                                                )
                                            );
                                        ?>

                                        <?=
                                            $this->Form->input('url_twitter',
                                                array(
                                                    'class' => 'form-control',
                                                    'div'   =>  'col-sm-12',
                                                    'label' => 'Url Twitter'
                                                )
                                            );
                                        ?>

                                        <?=
                                            $this->Form->input('url_instagram',
                                                array(
                                                    'class' => 'form-control',
                                                    'div'   =>  'col-sm-12',
                                                    'label' => 'Url Instagram'
                                                )
                                            );
                                        ?>

                                        <?=
                                            $this->Form->input('url_youtube',
                                                array(
                                                    'class' => 'form-control',
                                                    'div'   =>  'col-sm-12',
                                                    'label' => 'Url Youtube'
                                                )
                                            );
                                        ?>
                                    </div>

                                    <?php echo $this->Form->hidden('return'); ?>
                                    <div class="form-actions form-group row m-t-20">
                                        <div class="col-xl-6">
                                            <input type="submit" value="Guardar Información y Regresar al Desarrollo" class="btn btn-warning" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=1">
                                        </div>
                                        <div class="col-xl-6">
                                            <input type="submit" value="Guardar Información y continuar Editando" class="btn btn-success" style="width:100%" onclick="javascript:document.getElementById('DesarrolloReturn').value=2">
                                        </div>
                                    </div>
                                    <?= $this->Form->end()?>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(
        array(
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            'form',
            
            
        ),
        array('inline'=>false))
?>
<?= $this->fetch('postLink'); ?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>
'use strict';
$(document).ready(function () {
    
    $("#input-logo").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        browseLabel: "Escoger Logotipo"
    });

    $("#input-fa").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        browseLabel: "Escoger Imagen"
    });

    $("#input-fa-planos").fileinput({
        theme: "fa",
        allowedFileExtensions: ["pdf","docx","xlsx","doc","xls"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        showBrowse: true,
        uploadAsync: false,
        browseLabel: "Escoger Documento"
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
        browseLabel: "Escoger Brochure"
    });

      $("#input-fa-multimedia").fileinput({
        theme: "fa",
        allowedFileExtensions: ["jpg", "png","jpeg"],
        showRemove : false,
        showUpload : false,
        resizeImage: true,
        maxImageWidth: 800,
        maxImageHeight: 800,
        browseLabel: "Escoger Plano"
    });
    
    Admire.formGeneral() ;
});
<?php 
    $this->Html->scriptEnd();
?>