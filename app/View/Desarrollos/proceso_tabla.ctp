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
    array('inline'=>false));
    
   
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-dialog-centered modal-sm">
    <?= $this->Form->create('Cliente', array('url'=>array('controller'=>'clientes', 'action' => 'registrar_llamada', $cliente['Cliente']['id']))); ?>
      <div class="modal-content">
        <div class="modal-header bg-blue-is">
          <h4 class="modal-title">Proceso creado</h4>
          <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <p>
                        Para que tu proceso pueda ser implementado es necesario que cuente con tareas.
                        <br>
                        <br>
                        Puedes agregar las tareas ahora o más tarde desde el listado de procesos en el ícono   <i class="fa fa-add" style="color:#215D9C;"></i>
                    </p>
                </div>
            </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
            <?= $this->Html->link('Agregar tareas',array('controller'=>'desarrollos','action'=>'add_tarea',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary float-xs-right', 'style' => 'margin-left:8px;'))?>
            <?= $this->Html->link('Regresar',array('controller'=>'desarrollos','action'=>'control_table',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary float-xs-right', 'style' => 'margin-left:8px;'))?>
            <!-- <button type="button" class="btn btn-primary-o float-xs-right" data-dismiss="modal">Salir</button> -->
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
                    Crear proceso 
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
                        <?= $this->Form->create('Validations', array('type'=>'file'))?>
                            <div class="col-sm-12">
                                <div class="col-sm-12 col-lg-4 mt-2">
                                    <?= $this->Form->input('name_proceso', array(
                                        'class'       => 'form-control',
                                        'div'         => false,
                                        'placeholder' => 'Escribe un nombre para el proceso',
                                        'label'       => 'Nombre de proceso'
                                    )) ?>
                                </div> 
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('etapa_inicio', array(
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
                            <?= $this->Html->link('Guardar', array(), array('escape' => false, 'class' => 'btn btn-primary', 'style'=>'margin-left: 5px;float:right;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?>
                            <!-- <button class="btn btn-primary float-right">
                                Guardar
                            </button> -->
                        </div>
                        <?= $this->Form->end(); ?>
                    </div>
                    <div class="mt-5 col-sm-12">
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
                                        <?= $this->Html->link('<i class="fa fa-add" style="color:#215D9C;margin-left:8px;"></i>',array('controller'=>'desarrollos','action'=>'add_tarea'), array('escape' => false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Agregar tareas'))?>
                                        <!-- <?= $this->Html->link('<i class="fa fa-add" style="color:#215D9C;margin-left:8px;"></i>', array('controller'=>'desarrollos','action'=>'add_tarea'), array('escape' => false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?> -->
                                        <?= $this->Html->link('<i class="fa fa-edit" style="color:#215D9C;margin-left:8px;"></i>', array('controller'=>'desarrollos','action'=>'edit_proceso'), array('escape' => false, 'id'=>'btn_show_status', 'data-toggle'=>'tooltip', 'title' => 'Editar proceso', 'data-placement' =>'top', 'data-target'=>'#myModal'))?>
                                    </td>
                                    <td>
                                        Nombre proceso
                                        <!-- </?= $this->Html->link('Nombre proceso', array(), array('escape' => false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?> -->
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

// ValidationsProcesoTablaForm
    $(document).on("submit", "#ValidationsProcesoTablaForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "Validations", "action" => "add")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            // beforeSend: function () {
            //     $("#overlay").fadeIn();
            // },
            success: function (response) {
                // window.location.reload();
                console.log(response);
            },
            error: function ( response ) {

                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
        });
    });

</script>