<?php 
    $users_tot_act = 0;
    $users_tot_des = 0;
?>
<?= $this->Html->css(
        array(
            '/vendors/chosen/css/chosen',
            'pages/form_elements',
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
        ),
        array('inline'=>false))
?>

<style>
    .widget_section {
        /*height: 371px;*/
    }
    .user-name{
        min-height: 150px;
    }
    .user-body{
        min-height: 75px;
    }

    .filterDiv {
        display: none; /* Hidden by default */
    }
    
    /* The "show" class is added to the filtered elements */
    .show {
        display: block;
    }

</style>

<?= $this->Element('Users/add') ?>


<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-th"></i>
                    Lista de Asesores
                </h4>
            </div>
            
        </div>
    </header>

    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            Total asesores activos: <span id="users_tot_act"></span>
                            <br>
                            Total asesores inactivos: <span id="users_tot_des"></span>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div style="float:right">
                            <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>
                                <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#modal_add_user"><i class="fa fa-user"></i> Agregar usuario
                                </a>
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div>
                                <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>

                                    <?= $this->Form->input('search_input',
                                        array(
                                            'class'       => 'form-control',
                                            'div'         => 'col-sm-12',
                                            'label'       => false,
                                            'onkeyup'     => 'filterSelection();',
                                            'placeholder' => 'Búsqueda de usuario'
                                        )
                                    ); ?>                                    

                                <?php else: ?>
                                    <select disabled>
                                        <option value="0">Búsqueda de usuarios</option>
                                    </select>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
                    
                <div class="card-block">
                    <?php foreach ($users_custom as $user):?>
                    <div class="col-xs-12 col-lg-4 m-t-35 filterDiv <?= strtolower($user['nombre_completo']) ?>">
                        <div class="widget_section section_border">
                            <?php
                                if ($user['status'] == 1) {
                                    $bg_color = "#2e3c54";
                                    $users_tot_act++;
                                }else{
                                    $bg_color = "#FF4C26";
                                    $users_tot_des++;
                                }
                            ?>
                            <div class="user-name bg-primary" style="background-color: <?= $bg_color; ?> !important; border-radius: 5px;">
                                <h4 class="text-center text-white p-t-25"><?= $user['nombre_completo']?></h4>
                                <?= $user['correo_electronico']?>
                                
                            </div>
                            <div class="text-xs-center user-body">
                                <?php
                                    $foto = '';
                                    $extencion = substr($user['foto'], -3);
                                    switch ($extencion) {
                                        case 'jpg':
                                        case 'JPG':
                                        case 'png':
                                        case 'PNG':
                                        case 'peg':
                                        case 'PEG':
                                            $foto = $user['foto'];
                                            break;
                                        default:
                                            $foto = 'no_photo.png';
                                            break;
                                    }
                                ?>
                                <?php echo $this->Html->image($foto ,array('class'=>'img-fluid avatar_wid','alt'=>'Fotografía Asesor')); ?>
                            </div>
                            <?php
                                if( $this->Session->read('Permisos.Group.id') != 5 ){

                                    echo $this->Html->link('<button class="btn btn-blue-ao m-t-15">Ver Detalle</button>',array('controller'=>'users','action'=>'view',$user['id']),array('escape'=>false));

                                }
                            ?>
                            
                            <div style="padding-top: 15px;" class="mt-1">
                            
                                <div class="row" style="padding: 5px;">
                                    <div class="col-xs-3">
                                        <h4 style ="display: block !important; padding: 3px;" class="text-white chip_bg_oportuno"><?= $user['oportunos']?></h4>
                                        <small style ="display:block; padding: 3px; height: 42px;" class="text-white chip_bg_oportuno">Oportuno </small>
                                    </div>
                                    <div class="col-xs-3">
                                        <h4 style ="display: block !important; padding: 3px;" class="text-white chip_bg_tardio"><?= $user['tardios']?></h4>
                                        <small style ="display:block; padding: 3px; height: 42px;" class="text-white chip_bg_tardio">Tardio</small>
                                    </div>
                                    <div class="col-xs-3 ">
                                        <h4 style ="display: block !important; padding: 3px;" class="text-white chip_bg_no_antendido"><?= $user['no_atendidos']?></h4>
                                        <small style ="display:block; padding: 3px; height: 42px;" class="text-white chip_bg_no_antendido">No atendido</small>
                                    </div>
                                    <div class="col-xs-3 ">
                                        <h4 style ="display: block !important; padding: 3px;" class="text-white chip_bg_reasignar"><?= $user['por_reasignar']?></h4>
                                        <small style ="display:block; padding: 3px; height: 42px;" class="text-white chip_bg_reasignar">Por reasignar</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        Total de clientes
                                        <span><?= $user['oportunos'] + $user['tardios'] + $user['no_atendidos'] + $user['por_reasignar'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
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
        '/vendors/datatables/js/dataTables.bootstrap.min',
        'pages/advanced_tables',

    ], array('inline'=>false));
?>
<script>
    // Chosen
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();
    // End of chosen
    document.getElementById("users_tot_act").innerHTML = '<?= number_format($users_tot_act); ?>';
    document.getElementById("users_tot_des").innerHTML = '<?= number_format($users_tot_des); ?>';

    filterSelection("all")
    function filterSelection( ){
        var x, i;
        val = $("#search_input").val();
        c = val.toLowerCase();
        
        x = document.getElementsByClassName("filterDiv");
        if (c == "all") c = "";
        
        for (i = 0; i < x.length; i++) {
        removeClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) addClass(x[i], "show");
        }
    }

    function addClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
            if (arr1.indexOf(arr2[i]) == -1) {
            element.className += " " + arr2[i];
            }
        }
    }
    
    function removeClass(element, name) {
        var i, arr1, arr2;
        arr1 = element.className.split(" ");
        arr2 = name.split(" ");
        for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
            arr1.splice(arr1.indexOf(arr2[i]), 1); 
        }
        }
        element.className = arr1.join(" ");
    }

</script>