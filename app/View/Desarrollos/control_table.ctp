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
    array('inline'=>false))
    
    ;
    
    
    
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="fade side-bar" id="myModal">
    <div class="card-block" style="background-color:green;">
        <span style="color:white;">
            Departamento A-05
        </span> 
        <div class="float-right pointer">
            <i class='fa fa-times' style="color:white;" data-dismiss="modal"></i>
        </div>
    </div>
    <!-- <div> -->
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
                    <!-- <img src="https://www.google.com/imgres?imgurl=http%3A%2F%2Fwww.nasa.gov%2Fsites%2Fdefault%2Ffiles%2Fthumbnails%2Fimage%2Fweb_first_images_release_0.png&tbnid=XxvXRQC92RJQ8M&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygAegUIARCPAQ..i&imgrefurl=https%3A%2F%2Fwww.nasa.gov%2Fpress-release%2Fla-nasa-revela-las-primeras-im-genes-del-telescopio-webb-de-un-universo-nunca-antes&docid=RUrOsO8QXSU4zM&w=2048&h=1186&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygAegUIARCPAQ" class="d-block w-100" alt="..."> -->
                </div>
                <div class="carousel-item text-center">
                    <div>
                        imagen 2
                    </div>
                    <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 150px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                    <!-- <img src="https://www.google.com/imgres?imgurl=https%3A%2F%2Fcdn.pixabay.com%2Fphoto%2F2015%2F04%2F23%2F22%2F00%2Ftree-736885_1280.jpg&tbnid=aVgXecnmQ_f1MM&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygDegUIARCVAQ..i&imgrefurl=https%3A%2F%2Fpixabay.com%2Fes%2Fimages%2Fsearch%2Fpaisaje%2F&docid=IQGKdq9vA1YGTM&w=1280&h=797&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygDegUIARCVAQ" class="d-block w-100" alt="..."> -->
                </div>
                <div class="carousel-item text-center">
                    <div>
                        imagen 3
                    </div>
                    <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 150px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                    <!-- <img src="https://www.google.com/imgres?imgurl=https%3A%2F%2Fphantom-marca-mx.unidadeditorial.es%2F35e37481788873f19c37456f9bbae9b3%2Fresize%2F1320%2Ff%2Fjpg%2Fmx%2Fassets%2Fmultimedia%2Fimagenes%2F2023%2F04%2F03%2F16805545425507.jpg&tbnid=q52yeX_WHyh4GM&vet=12ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygKegUIARCjAQ..i&imgrefurl=https%3A%2F%2Fwww.marca.com%2Fmx%2Ftecnologia%2F2023%2F04%2F03%2F642b3a8ee2704ed8078b45e2.html&docid=dONfUfA5ltVMXM&w=1320&h=880&q=imagenes&ved=2ahUKEwjNg-mJyYz_AhVANd4AHRjEALQQMygKegUIARCjAQ" class="d-block w-100" alt="..."> -->
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
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Procesos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block">
                    <!-- Información superior -->
                    <div class="row mt-3" >
                        <div class="col-sm-12 text-sm-center">
                            <h2 class="text-black" style="text-transform:none !important;font-style: normal;font-weight: 700;font-size: 30px;line-height: 36px;"><b>No tienes procesos creados</b></h2>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-sm-12 text-sm-center">
                            <?= $this->Html->image('img/flujo-de-trabajo-1.png', array('class' => 'img-fluid')); ?>
                        </div>
                    </div>
                    <!-- <div class="row mt-1" > -->
                        <div class="mt-1">
                            <h2 class="text-black text-center" style="text-transform:none !important;font-style: normal;font-weight: 500;font-size: 26px;line-height: 31px;">
                                Crea un nuevo proceso
                                <br>
                                    o
                                <br>
                                continua con el flujo normal de
                                <b>
                                    Adryo
                                </b>
                            </h2>
                        </div>
                    <!-- </div> -->
                    <div class="mt-1" style="width: 315px;margin:0 auto;">
                        <div class="text-sm-center" style="display: flex;align-items: center;justify-content: space-between;">
                            <?= $this->Html->link('Conoce el proceso de Adryo',array('controller'=>'desarrollos','action'=>'inicio_proceso',$desarrollo['Desarrollo']['id']))?>
                            <?= $this->Html->link('Crear Proceso',array('controller'=>'desarrollos','action'=>'proceso_tabla',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary'))?>
                            <!-- <a href="">Conoce el proceso de <b>Adryo</b></a>
                            <button class="btn btn-primary">Crear Proceso</button> -->
                        </div>
                    </div>
                    <div class="mt-5 col-sm-12">
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
                                            'label'       => 'Nombre de proceso',
                                            'required'     => true,
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
                                    <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                                    <?= $this->Form->hidden('user_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.user_id'))); ?>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-1">
                                <!-- <?= $this->Html->link('Guardar', array(), array('escape' => false, 'class' => 'btn btn-primary', 'style'=>'margin-left: 5px;float:right;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?> -->
                                <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Aceptar</button>
                            </div>
                            <?= $this->Form->end(); ?>
                        </div>
                    <div class="mt-5 col-sm-12">
                        <table class="table table-striped" id="sample_1">
                        
                        </table>
                    </div>
                
            </div>
        </div>
    </div>
</div>
<?php 
    echo $this->Html->script([
        'components',
        'custom',
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
        
        
        '/vendors/jquery.uniform/js/jquery.uniform',
        '/vendors/inputlimiter/js/jquery.inputlimiter',
        '/vendors/moment/js/moment.min',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>

<script>


    $(document).ready(function () {
        let cuenta_id=<?=$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id');?>;
        console.log(cuenta_id);
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "Validations", "action" => "view")); ?>",
            data: {cuenta_id: cuenta_id },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                $('#sample_1').dataTable( {
                    destroy: true,
                    data : response,
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    dom: 'Bflr<"table-responsive"t>ip',
                    columnDefs: [
                        {
                            targets: [ 5 ],
                            visible: true,
                            searchable: false
                        },
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
                    buttons: [
                        {
                            extend: 'excel',
                            text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                            filename: 'ClientList',
                            class : 'excel',
                            charset: 'utf-8',
                            bom: true,
                            // enabled: false,
        
                        },
                        {
                            extend: 'print',
                            text: '<i class="fa  fa-print"></i> Imprimir',
                            filename: 'ClientList',
                        },
                    ]
                });
            }
        });
    });
    var TableAdvanced = function() {
         // ===============table 1====================
        var initTable1 = function() {
            var table = $('#sample_1');
            table.DataTable({
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                columnDefs: [
                    {
                        targets: [ 3 ],
                        visible: false,
                        searchable: false
                    },
                ],
                language: {
                    sSearch: "Buscador",
                    lengthMenu: '_MENU_ registros por página',
                    info: 'Mostrando _TOTAL_ registro(s)',
                    infoFiltered: " filtrado(s) de un total de _MAX_ en _PAGES_ páginas",
                    emptyTable: "Sin información.",
                    paginate: {
                        previous: 'Anterior',
                        next: 'Siguiente'
                    },
                },
                columns: [

                    { title: "ver" },
                    { title: "Comprobante" },
                    { title: "Referencia" },
                    { title: "programada de Pago" },
                    { title: "nose" },
                    { title: "estatus" },
    
                    
                ],
                dom: 'Bflr<"table-responsive"t>ip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa  fa-file-excel-o"></i> Exportar',
                        filename: 'ClientList',
                        class : 'excel',
                        charset: 'utf-8',
                        bom: true,
                        enabled: false,

                    },
                    {
                        extend: 'print',
                        text: '<i class="fa  fa-print"></i> Imprimir',
                        filename: 'ClientList',
                        enabled: false,
                    },
                ]
            });
            var tableWrapper = $('#sample_1_wrapper');
            tableWrapper.find('.dataTables_length select').select2();
        }
        
        return {
            //main function to initiate the module
            init: function() {
                if (!jQuery().dataTable) {
                    return;
                }
                initTable1();
                
            }
        };
    }();


</script>