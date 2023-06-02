<?= $this->Html->css(
    array(
        '/vendors/select2/css/select2.min',
        '/vendors/datatables/css/scroller.bootstrap.min',
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        '/vendors/j_timepicker/css/jquery.timepicker',
        '/vendors/datetimepicker/css/DateTimePicker.min',
        '/vendors/clockpicker/css/jquery-clockpicker',
        'pages/colorpicker_hack',
        'custom'
        //'pages/form_elements'
    ),
    array('inline'=>false)),
    
    $bg_propiedades = array(
        0 => 'bg-bloqueado',
        1 => 'bg-libre',
        2 => 'bg-apartado',
        3 => 'bg-vendido',
        4 => 'bg-escriturado',
        5 => 'bg-baja',
    );
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
    <?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action' => 'registrar_llamada', $cliente['Cliente']['id']))); ?>
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
          <h4 class="modal-title">Proceso creado</h4>
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <label for="mensaje">Mensaje <small class="text-light">(Máximo 250 caracteres.)</small></label>
                    <?= $this->Form->textarea('mensaje', array('class'=>'form-control textarea', 'maxlength'=>250)); ?>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <?= $this->Html->link('Agregar tareas',array('controller'=>'desarrollos','action'=>'add_tarea',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary float-xs-right', 'style' => 'margin-left:8px;'))?>
            <button type="button" class="btn btn-primary-o float-xs-right" data-dismiss="modal">Salir</button>
            <!-- <button type="submit" class="btn btn-success">Registrar</button> -->
        </div>
        <?= $this->Form->end(); ?>
      </div>
    </div>
</div>
<!-- <div class="modal modal centered fade" id="myModal">
    <div class="card-block" style="background-color:green;">
        <span style="color:white;">
            Departamento A-05
        </span> 
        <div class="float-right pointer">
            <i class='fa fa-times' style="color:white;" data-dismiss="modal"></i>
        </div>
    </div>
     <div>
    <div class="col-sm-12">
        <div id="carouselExampleIndicators" class="carousel slide mt-1" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active text-center">
                    <div>
                        imagen 1
                    </div>
                    <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 150px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                <img src="https://www.google.com/imgres?imgurl=http%3A%2F%2Fwww.nasa.gov%2Fsites%2Fdefault%2Ffiles%2Fthumbnails%2Fimage%2Fweb_first_images_release_0.png&tbnid=XxvXRQC92RJQ8M&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygAegUIARCPAQ..i&imgrefurl=https%3A%2F%2Fwww.nasa.gov%2Fpress-release%2Fla-nasa-revela-las-primeras-im-genes-del-telescopio-webb-de-un-universo-nunca-antes&docid=RUrOsO8QXSU4zM&w=2048&h=1186&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygAegUIARCPAQ" class="d-block w-100" alt="..."> 
                </div>
                <div class="carousel-item text-center">
                    <div>
                        imagen 2
                    </div>
                    <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 150px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                     <img src="https://www.google.com/imgres?imgurl=https%3A%2F%2Fcdn.pixabay.com%2Fphoto%2F2015%2F04%2F23%2F22%2F00%2Ftree-736885_1280.jpg&tbnid=aVgXecnmQ_f1MM&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygDegUIARCVAQ..i&imgrefurl=https%3A%2F%2Fpixabay.com%2Fes%2Fimages%2Fsearch%2Fpaisaje%2F&docid=IQGKdq9vA1YGTM&w=1280&h=797&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygDegUIARCVAQ" class="d-block w-100" alt="..."> 
                </div>
                <div class="carousel-item text-center">
                    <div>
                        imagen 3
                    </div>
                    <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 150px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                     <img src="https://www.google.com/imgres?imgurl=https%3A%2F%2Fphantom-marca-mx.unidadeditorial.es%2F35e37481788873f19c37456f9bbae9b3%2Fresize%2F1320%2Ff%2Fjpg%2Fmx%2Fassets%2Fmultimedia%2Fimagenes%2F2023%2F04%2F03%2F16805545425507.jpg&tbnid=q52yeX_WHyh4GM&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygKegUIARCjAQ..i&imgrefurl=https%3A%2F%2Fwww.marca.com%2Fmx%2Ftecnologia%2F2023%2F04%2F03%2F642b3a8ee2704ed8078b45e2.html&docid=dONfUfA5ltVMXM&w=1320&h=880&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygKegUIARCjAQ" class="d-block w-100" alt="..."> 
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 8px 0;">
                <div style="width:49%;">
                    <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                    <span>
                        <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?> 
                    </span>
                </div>
                <br>
                <div style="width:49%;">
                    <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                    <span>
                        <?= $desarrollo['Desarrollo']['est_low']?>-<?= $desarrollo['Desarrollo']['est_top']?>
                    </span>
                </div>
                
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 8px 0;">
                <div style="width:49%;">
                    <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                    <span>
                        <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                    </span>
                </div>
                <br>
                <div style="width:49%;">
                    <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                    <span>
                        <?= $desarrollo['Desarrollo']['rec_low']?>-<?= $desarrollo['Desarrollo']['rec_top']?>
                    </span>
                </div>
            </div>
            <div class="" style="padding: 8px 0;">
                <div style="width:49%;">
                    <?= $this->Html->image('clientes_icons/toilet.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                    <span>
                        <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                    </span>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Precio de lista
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        $ 5,780,902.00
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Renta / Venta
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Venta
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Tipo de propiedad
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Departamento
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Estado
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Nuevo
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Comisión
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        4%
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Comparte
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Si / 1%
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Horario de atención
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        9:00 a 18:00 hrs
                    </small>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div class="text-sm-right">
                <small>
                    <a href="">
                        Ir a propiedad
                    </a>
                </small>
            </div>
        </div>
    </div>
     </div> 
     <div class="">
        <div class="modal-content">
            <div class="modal-header" style="background: #2e3c54;">
            <h4 class="modal-title col-sm-10" id="modal-seguimiento-titulo"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="seguimeinto-eliminar">
                </?= $this->Form->create('agendaEliminar', array('url'=>array('controller'=>'agendas', 'action' => 'delete', $cliente['Cliente']['id']))); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="mensaje">¿ Desea eliminar este comentario de seguimeinto ?</label>
                        </div>
                    </div>
                </div>
                 Modal footer 
                <div class="modal-footer">
                </?= $this->Form->hidden('id_seguimiento') ?>
                <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Eliminar</button>
                </div>
                </?= $this->Form->end(); ?>
            </div>
            <div id="seguimeinto-edicion">
                </?= $this->Form->create('agendaEdicion', array('url'=>array('controller'=>'agendas', 'action' => 'edit', $cliente['Cliente']['id']))); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="mensaje">Mensaje</label>
                            </?= $this->Form->textarea('mensaje', array('class'=>'form-control textarea', 'maxlength'=>250)); ?>
                        </div>
                    </div>
                </div>
                
                Modal footer 
                <div class="modal-footer">
                </?= $this->Form->hidden('id_seguimiento') ?>
                <button type="button" class="btn btn-danger float-xs-left" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar mensaje</button>
                </div>
                </?= $this->Form->end(); ?>
            </div>
        </div>
    </div> 
</div> -->

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Editar proceso 
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block">
                    <!-- Información superior -->
                    <div class="card-block" style="background-color:#f5f5f5 !important;border-radius:8px; padding:16px 0;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-12 col-lg-4 mt-2">
                                    <?= $this->Form->input('new_name_proceso', array(
                                        'class'       => 'form-control',
                                        'div'         => false,
                                        'placeholder' => 'Escribe un nombre para el proceso',
                                        'label'       => 'Nombre de proceso'
                                    )) ?>
                                </div> 
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('new_etapa_inicio', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Selecciona etapa',
                                        'label'       => 'Etapa <i class="fa fa-circle-info text-left" data-html="true" data-placement="top" title="Selecciona la etapa <br> Esta es la etapa en la que se iniciará el proceso." data-toggle="tooltip" style="color:#215D9C;margin-left:8px;"></i>',
                                        'options'     =>  array(
                                            '5' => 'Etapa 5',
                                            '6' => 'Etapa 6',
                                            '7' => 'Etapa 7',
                                        )
                                    )) ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-1">
                            <button class="btn btn-primary float-right">
                                Actualizar
                            </button>
                        </div>
                    </div>
                    <!-- <div class="mt-5 col-sm-12">
                        <table class="table table-striped" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Creador
                                    </th>
                                    <th>
                                        Etapa
                                    </th>
                                    <th >
                                        Estatus
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        </?= $this->Html->link('<i class="fa fa-add" style="color:#215D9C;margin-left:8px;"></i>', array(), array('escape' => false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?>
                                        </?= $this->Html->link('<i class="fa fa-eye" style="color:#215D9C;margin-left:8px;"></i>', array('controller'=>'desarrollos','action'=>'edit_tarea'), array('escape' => false))?>
                                        </?= $this->Html->link('<i class="fa fa-edit" style="color:#215D9C;margin-left:8px;"></i>', '',array('escape' => false, 'controller'=>'desarrollos','action'=>'edit_proceso',$desarrollo['Desarrollo']['id']))?>
                                        </?= $this->Html->link('<i class="fa fa-trash" style="color:#215D9C;margin-left:8px;"></i>', '',array('escape' => false, 'controller'=>'desarrollos','action'=>'edit_proceso',$desarrollo['Desarrollo']['id']))?>
                                        </?= $this->Html->link('Icono',array('controller'=>'desarrollos','action'=>'add_tarea',$desarrollo['Desarrollo']['id']))?>
                                    </td>
                                    <td>
                                        Nombre proceso
                                    </td>
                                    <td>
                                        Ana Luisa Medina del Toro
                                    </td>
                                    <td>
                                        5
                                    </td>
                                    <td>
                                        Activo
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <table class="table table-sm">
            <//?= $p = 1; ?> -->
        <!-- <//?= $p++; ?>
        <tbody>
            <tr>
                <td>Tipo de desarrollo</td>
                <td><?= $desarrollo['Desarrollo']['tipo_desarrollo']?></td>
            </tr>
            <tr>
                <td>Torres</td>
                <td><?= $desarrollo['Desarrollo']['torres']?></td>
            </tr>
            <tr>
                <td>Unidades totales</td>
                <td><?= $desarrollo['Desarrollo']['unidades_totales']?></td>
            </tr>
            <tr>
                <td>Entrega</td>
                <td><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata" ? $desarrollo['Desarrollo']['entrega'] : date('d - M - Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?></td>
            </tr>
            <tr>
                <td>Colonia</td>
                <td><?= $desarrollo['Desarrollo']['colonia']?></td>
            </tr>
        </tbody>
    </table> -->

<script>

    // $(document).ready(function () {
    //     let cuenta = '<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'); ?>';
    //     $.ajax({
    //         type: "POST",
    //         url: "<?= Router::url(array("controller" => "inmuebles", "action" => "inmueble_view_info")); ?>",
    //         data: {api_key: 'adryo', cuenta_id: cuenta},
    //         dataType: "Json",
    //         success: function (response) {
    //             // for each para info de desarrollo 
    //             $.each(response, function(index, value) {
    //                 $('#inventory-detail').append(
    //                     `<div class="card-header  </?= $bg_propiedades[$desarrollo['Desarrollo']['visible']] ?>">
    //                         <div class="row">
    //                             <div class="col-sm-12 col-lg-8">
    //                                 <p class="m-0">
    //                                     `+value['Desarrollo']['desarrollo']+`
    //                                     </?= $desarrollo['Desarrollo']['nombre'] ?>
    //                                 </p>
    //                             </div>
    //                             <div class="col-sm-12 col-lg-4 text-sm-right">
    //                                 <p class="m-0">
    //                                     <?php 
    //                                         switch ($desarrollo['Desarrollo']['visible']):
    //                                             case(0):
    //                                                 echo "Libre";
    //                                             break;
    //                                             case(1):
    //                                                 echo "En venta";
    //                                             break;
    //                                             case(2):
    //                                                 echo "No liberado";
    //                                             break;
    //                                         endswitch;
    //                                     ?>
    //                                 </p>
    //                             </div>
    //                         </div>
    //                     </div>
    //                     <div class="card-block">
    //                         <div class="row" >
    //                             <div class="col-sm-12 col-lg-2">
    //                                 <div class="pointer" style="background-image: url('</?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 220px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
    //                             </div>
    //                             <div class="col-sm-12 col-lg-2">
    //                                 <div>
    //                                     <b class="m-0">Tipo de desarrollo</b>
    //                                     <p class="m-0">`+value['Desarrollo']['tipo_desarrollo']+`</p>
    //                                 </div>
    //                                 <div>
    //                                     <b class="m-0">Torres</b>
    //                                     <p class="m-0">`+value['Desarrollo']['torres']+`</p>
    //                                 </div>
    //                                 <div>
    //                                     <b class="m-0">Unidades totales</b>
    //                                     <p class="m-0">`+value['Desarrollo']['unidades_totales']+`</p>
    //                                 </div>
    //                                 <div>
    //                                     <b class="m-0">Entrega</b>
    //                                     <p class="m-0"><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata" ? $desarrollo['Desarrollo']['entrega'] : date('d - M - Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?></p>
    //                                 </div>
    //                                 <div>
    //                                     <b class="m-0">Colonia</b>
    //                                     <p>`+value['Desarrollo']['colonia']+`</p>
    //                                 </div>
    //                             </div>
    //                             <div class="col-sm-12 col-lg-2">
    //                                 <div class="text-sm-center mt-1" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">
    //                                     <div style="width:49%;">
    //                                         <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                         <br>
    //                                         <span>
    //                                             `+value['Desarrollo']['m2']+`
    //                                         </span>
    //                                     </div>
    //                                     <br>
    //                                     <div style="width:49%;">
    //                                         <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                         <br>
    //                                         <span>
    //                                             `+value['Desarrollo']['rec']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-sm-center mt-1" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">
    //                                     <div style="width:49%;">
    //                                         <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                         <br>
    //                                         <span>
    //                                             `+value['Desarrollo']['banio']+`
    //                                         </span>
    //                                     </div>
    //                                     <br>
    //                                     <div style="width:49%;">
    //                                         <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                         <br>
    //                                         <span>
    //                                             `+value['Desarrollo']['est']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                             <div class="col-sm-12 col-lg-2">
    //                                 <div>
    //                                     <p class="m-0">
    //                                         Equipo
    //                                     </p>
    //                                     <p class="m-0"> <?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "No asignado" : $desarrollo['EquipoTrabajo']['nombre_grupo'])?> </p>
    //                                     <br>
    //                                     <p class="m-0">
    //                                         Privado 
    //                                     </p>
    //                                     <p class="m-0"> <?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?> </p>
    //                                 </div>
    //                             </div>
    //                             <div class="col-sm-12 col-lg-4">
    //                                 <div class="text-sm-right">
    //                                     <p style="font-size: 15px; font-weight: 700;margin:0;">
    //                                         Disponibilidad total
    //                                         <p style="font-size: 19px; font-weight: 400;" class="text-sm-right"> 
    //                                             `+value['contadores']['disponible_libres']+`
    //                                         </p>
    //                                     </p>
    //                                 </div>
    //                                 <div class="text-sm-right">
    //                                     Compartir
    //                                     <br>
    //                                     <span>
    //                                         <a href="https://www.facebook.com/share.php?u=<?=Router::url('', true)?>&title=Desarrollo" target="_blank" id="shareFbDesarrollo">
    //                                             <?= $this->Html->image('icons_desarrollo/fb-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                         </a>
    //                                     </span>
    //                                     <span>
    //                                         <?= $this->Html->image('icons_desarrollo/tw-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                     </span>
    //                                     <span>
    //                                         <?= $this->Html->image('icons_desarrollo/li-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
    //                                     </span>
    //                                 </div>
    //                                 <div class="mt-1 text-sm-right" style="position:sticky;right:16px;">
    //                                     <button class="btn btn-primary float-right ml-1">Vendido</button>
    //                                     <button class="btn btn-secondary-o float-right">Liberado</button>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                         <div class="row mt-1">
    //                             <div class="col-sm-12">
    //                                 <hr>
    //                             </div>
    //                         </div>
    //                         <div class="row">
    //                             <div class="col-sm-12" style="display:flex;justify-content:space-between;flex-wrap:wrap;">
    //                                 <div class="text-center mt-1 ">
    //                                     Total de unidades
    //                                     <div class="number chips bg-status-desarrollo-total">
    //                                         `+value['Desarrollo']['unidades_totales']+`
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Baja
    //                                     <div class="number chips bg-baja" style="padding: 2px 5px 2px 5px;">
    //                                         <span id="baja">
    //                                             `+value['contadores']['bloquedos']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Bloqueados
    //                                     <div class="number chips bg-bloqueado" style="padding: 2px 5px 2px 5px;">
    //                                         <span id="bloqueado"> 
    //                                             `+value['contadores']['bloquedos']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     En venta
    //                                     <div class="number chips bg-status-desarrollo-venta">
    //                                         <span id="libre">
    //                                             `+value['contadores']['libres']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Apartados
    //                                     <div class="number chips bg-status-desarrollo-bloqueado">
    //                                         <span id="no_liberado">
    //                                             `+value['contadores']['apartados']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Vendidos
    //                                     <div class="number chips bg-status-desarrollo-vendido">
    //                                         <span id="vendido"> 
    //                                             `+value['contadores']['ventas']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Escriturados
    //                                     <div class="number chips bg-escriturado" style="padding: 2px 5px 2px 5px;">
    //                                         <span id="escrituracion"> 
    //                                             `+value['contadores']['escriturados']+`
    //                                         </span>
    //                                     </div>
    //                                 </div>
    //                                 <div class="text-center mt-1">
    //                                     Venta
    //                                     <div style="vertical-align: top;">
    //                                         <b>
    //                                             `+value['contadores']['dinero']+`
    //                                             </?= (!isset($desarrollo['ObjetivoAplicable'][0]['monto'])?"No definido":"$".number_format($desarrollo['ObjetivoAplicable'][0]['monto'],0))?>
    //                                         </b>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                         <div class="row">
    //                             <div class="col-sm-12 mt-1">
    //                                 <div style="display:flex; gap:8px; align-items:center;width:100%;">
    //                                     <div class="level" id="level" style="background-color:purple;border-radius:100%;color:white;">
    //                                         <p style="width:20px;text-align:center;">
    //                                             `+value['inmueble']['nivel_propiedad']+`
    //                                         </p>
                                            
    //                                     </div>
    //                                     <div class="apt-tower">
    //                                         <div>
    //                                             <p class="m-0">
    //                                                 S-101
    //                                             </p>
    //                                         </div>
    //                                         <div>S-102</div>
    //                                         <div>S-103</div>
    //                                         <div>S-104</div>
    //                                         <div>S-105</div>
    //                                         <div>S-106</div>
    //                                         <div>S-107</div>
    //                                         <div>S-108</div>
    //                                         <div>S-109</div>
    //                                         <div>S-110</div>
    //                                         <div>S-111</div>
    //                                         <div>S-112</div>
    //                                         <div>S-113</div>
    //                                         <div>S-114</div>
    //                                         <div>S-115</div>
    //                                         <div>S-116</div>
    //                                         <div>S-117</div>
    //                                         <div>S-118</div>
    //                                     </div>
    //                                 </div>
    //                             </div>
    //                         </div>
    //                     </div>`
    //                 )
    //                 console.log(value['Desarrollo']);
    //             });
    //             // for each para info de desarrollo 
    //             $.each(response, function(index, value) {
    //                 $('#inventory-detail').append(
    //                     ``
    //                 )
    //                 console.log(value['Desarrollo']);
    //             });
    //         },
    //         error: function ( response ) {
    //             console.log(reponse);
    //         }
    //     });

    // });

</script>