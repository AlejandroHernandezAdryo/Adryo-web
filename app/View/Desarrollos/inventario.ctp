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
        
        $bg_propiedades = array(
            0 => 'bg-libre',
            1 => 'bg-libre',
            2 => 'bg-apartado',
            3 => 'bg-vendido',
            4 => 'bg-escriturado',
            5 => 'bg-baja',
        );
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="fade side-bar" id="myModal">
</div>
    <!-- <div class="card-block" style="background-color:green;">
        <span style="color:white;">
            Departamento A-05
        </span> 
        <div class="float-right pointer">
            <i class='fa fa-times' style="color:white;" data-dismiss="modal"></i>
        </div>
    </div>
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
    </div> -->

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Inventario
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <img src="app/webroot/img/adryo_iconos/icons-profile/aspect_ratio.png" alt="">
            </div>
        </div>
    </div>
</div>
<!-- Contador de baja -->
<!-- <div>
    <b>Baja</b>
    <div class="text-center bg-status-desarrollo-baja">
        `+response[0].Contadores['unidades_totales']+`
    </div>
</div> -->

<script>

    let urlapi = `https://adryo.com.mx/inmuebles/inmueble_view_info`;


    $(document).ready(function () {
        let cuenta = '<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'); ?>';
        let desarrollo = '<?= $id ?>';
        $.ajax({
            type: "POST",
            url: urlapi,
            data: {api_key: 'adryo', cuenta_id: cuenta, desarrollo_id: desarrollo},
            dataType: "Json",
            success: function (response) {
                // console.log(response);

                $('#inventory-detail').append(`
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-12 col-lg-8">
                                <p class="m-0">
                                    `+response[0].Desarrollo['desarrollo']+`
                                </p>
                            </div>
                            <div class="col-sm-12 col-lg-4 text-sm-right">
                                <p class="m-0">
                                `+response[0].Inmuebles['liberada']+`
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-sm-12 col-lg-2">
                            
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div>
                                    <b class="m-0">Tipo de desarrollo</b>
                                    <p class="m-0">`+response[0].Desarrollo['tipo_desarrollo']+`</p>
                                </div>
                                <div>
                                    <b class="m-0">Torres</b>
                                    <p class="m-0">`+response[0].Desarrollo['torres']+`</p>
                                </div>
                                <div>
                                    <b class="m-0">Unidades totales</b>
                                    <p class="m-0">`+response[0].Desarrollo['unidades_totales']+`</p>
                                </div>
                                <div>
                                    <b class="m-0">Entrega</b>
                                    <p class="m-0">`+response[0].Desarrollo['fecha_entrega']+`</p>
                                </div>
                                <div>
                                    <b class="m-0">Colonia</b>
                                    <p class="m-0">`+response[0].Desarrollo['colonia']+`</p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div style="display: flex;flex-direction: column;justify-content: space-evenly;gap: 16px;">
                                    <div style="display: flex;align-items: center;">
                                        <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                        <span style="margin-left: 16px;">
                                            `+response[0].Desarrollo['m2']+` m <sup>2</sup>
                                        </span>
                                    </div>
                                    <div style="display: flex;align-items: center;">
                                        <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                        <span style="margin-left: 16px;">
                                            `+response[0].Desarrollo['est']+`
                                        </span>
                                    </div>
                                    <div style="display: flex;align-items: center;">
                                        <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                        <span style="margin-left: 16px;">
                                            `+response[0].Desarrollo['rec']+`
                                        </span>
                                    </div>
                                    <div style="display: flex;align-items: center;">
                                        <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                        <span style="margin-left: 16px;">
                                            `+response[0].Desarrollo['banio']+`
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div>
                                    <b class="m-0">Equipo</b>
                                    <p class="m-0">`+response[0].Desarrollo['equipo']+`</p>
                                </div>
                                <div>
                                    <b class="m-0">Privado</b>
                                    <p class="m-0"><?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?></p>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4" style="display: flex;flex-direction: column;align-items: flex-end;">
                                <div class="float-right">
                                    <b class="m-0">Disponibilidad total</b>
                                    <p class="m-0" style="text-align:center;">`+response[0].Contadores['disponible_libres']+`</p>
                                </div>
                                <div class="float-right mt-1">
                                    <a>
                                        <span><i class="fa fa-share-alt"></i>  Compartir</span>
                                    </a>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-primary-o">Liberado</button>
                                    <button class="btn btn-primary">Vendido</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <hr>
                        </div>
                        <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:16px;">
                            <div>
                                <b>Total Unidades</b>
                                <div class="text-center bg-status-desarrollo-total">
                                    `+response[0].Desarrollo['unidades_totales']+`
                                </div>
                            </div>
                            <div>
                                <b>Bloqueados</b>
                                <div class="text-center bg-status-desarrollo-bloqueado">
                                    `+response[0].Contadores['bloquedos']+`
                                </div>
                            </div>
                            <div>
                                <b>En venta</b>
                                <div class="text-center bg-status-desarrollo-venta">
                                    `+response[0].Contadores['libres']+`
                                </div>
                            </div>
                            <div>
                                <b>Apartados</b>
                                <div class="text-center bg-status-desarrollo-reservado">
                                    `+response[0].Contadores['apartados']+`
                                </div>
                            </div>
                            <div>
                                <b>Vendidos</b>
                                <div class="text-center bg-status-desarrollo-vendido">
                                    `+response[0].Contadores['ventas']+`
                                </div>
                            </div>
                            <div>
                                <b>Escriturados</b>
                                <div class="text-center bg-status-desarrollo-escriturado">
                                    `+response[0].Contadores['escriturados']+`
                                </div>
                            </div>
                            <div>
                                <b>Venta</b>
                                <div class="text-center">
                                    `+response[0].Contadores['dinero']+`
                                </div>
                            </div>
                        </div>
                        <div class="mt-1" style="display:flex;gap:16px;">
                            <div id="niveles">
                                
                            </div>
                        </div>
                    </div>
                    `);
                        for (let i = 0; i < response[0].Pisos.length; i++){
                            let piso = response[0].Pisos[i].piso;
                            $("#niveles").append(`
                                <div style="display:flex;align-items:baseline;gap:16px;" id="nivel_`+piso+`">
                                    <div class="level text-center mt-1" id="pisos_`+piso+`">
                                        `+piso+`
                                    </div>
                                    <div class="apt-tower" id="deptos_`+piso+`"></div>
                                </div>
                            `
                            );
                        }
                        for (let i = 0; i < response[0].Inmuebles.length; i++){
                            let arr = [
                                {
                                    estatus : 'liberada',
                                    clase   : 'bg-libre'},
                                {
                                    estatus : 'en_venta',
                                    clase   : 'bg-status-desarrollo-venta'},
                                {
                                    estatus : 'bloqueada',
                                    clase   : 'bg-status-desarrollo-bloqueado'},
                                {
                                    estatus : 'reservada',
                                    clase   : 'bg-status-desarrollo-reservado'},
                                {
                                    estatus : 'contrato',
                                    clase   : 'bg-status-desarrollo-vendido'},
                                {
                                    estatus : 'escrituradas',
                                    clase   : 'bg-status-desarrollo-escriturado'},
                            ];
                            
                            let piso = response[0].Inmuebles[i].nivel_propiedad;
                            let estatus = response[0].Inmuebles[i].liberada;
                            jQuery.each( arr, function( index, value ) {
                                if (value.estatus == estatus) {
                                    $('.bg_'+estatus).addClass(value.clase);
                                }
                            });
                            $("#deptos_"+piso).append(`
                                <div onclick="view_detail(`+response[0].Inmuebles[i].id+`)" class="pointer bg_`+estatus+` " data-toggle="modal" data-target="#myModal" >
                                    `+response[0].Inmuebles[i].id+`
                                </div>
                                `
                            );
                        }
                    },
                    error: function ( response ) {
                        console.log(reponse);
                    }
                });
            });

    function view_detail(id = null){
        $('#myModal').html('');
        // alert(id);
        // let cuenta = '<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'); ?>';
        $.ajax({
            type: "POST",
            url: "<?= Router::url(array("controller" => "Inmuebles", "action" => "view_info_inmueble_inventario")); ?>",
            // url: "http://localhost/Adryo-web/Inmuebles/view_info_inmueble_inventario",
            data: {api_key: 'adryo', inmueble_id: id},
            dataType: "Json",
            success: function (response) {
                console.log(response);
                $('#myModal').append(`
                    <div class="card-block" style="background-color:#376D6C;">
                        <span style="color:white;">
                            `+response[0].inmueble.titulo+`
                        </span> 
                        <div class="float-right pointer">
                            <i class='fa fa-times' style="color:white;" data-dismiss="modal"></i>
                        </div>
                    </div>
                    <div class="" style="background-color:gray;width:40%;padding: 0 12px;">
                        <p style="color:white;margin:0;">
                            `+response[0].inmueble.liberada+`
                        </p>
                    </div>
                    <div class="card-block">
                        <div>
                            `+response[0].inmueble.plano+`
                        </div>
                        <div class="mt-1" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 8px 0;">
                            <div style="width:49%;">
                                <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:24px;')); ?>
                                <span>
                                    - `+response[0].inmueble.terrano+` m<sup>2</sup> 
                                </span>
                            </div>
                            <br>
                            <div style="width:49%;">
                                <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:24px;')); ?>
                                <span>
                                    - `+response[0].inmueble.estacionamiento_techado+`
                                </span>
                            </div>
                        </div>
                        <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 8px 0;">
                            <div style="width:49%;">
                                <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png',array('class' => 'img-icon', 'style' => 'width:24px;')); ?>
                                <span>
                                    - `+response[0].inmueble.recamaras+` 
                                </span>
                            </div>
                            <br>
                            <div style="width:49%;">
                                <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:24px;')); ?>
                                <span>
                                    - `+response[0].inmueble.banos+`
                                </span>
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
                                        $ `+response[0].inmueble.precio+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Piso
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.nivel_propiedad+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        M2 habitables
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.avitable+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        M2 no habitables
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.noavitable+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        M2 totales
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.terrano+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Entrega
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.entrega+`
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-1" id="forward">
                        </div>
                        <div class="mt-1">
                            <div class="text-sm-right">
                                <small>
                                    <?= $this->Html->image('Ir a propiedad', array('class' => 'img-icon', 'style' => 'width:24px;')); ?>
                                    <a href="">
                                        Ir a propiedad
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                    `
                );
                if(response[0].inmueble.liberada > 1){
                    $('#forward').append(`
                        <div class="mt-1">
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        ID operación
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        $ `+response[0].inmueble.user+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Cliente
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.nivel_propiedad+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Asesor
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.avitable+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Fecha apartado
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.noavitable+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Vigencia apartado
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.terrano+`
                                    </small>
                                </div>
                            </div>
                            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        Monto apartado
                                    </small>
                                </div>
                                <br>
                                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                                    <small>
                                        `+response[0].inmueble.entrega+`
                                    </small>
                                </div>
                            </div>
                        </div>
                    `)
                }
            },
            error: function ( response ) {
                // console.log(reponse);
            }
        });
        
        // console.log(id);
    }


</script>