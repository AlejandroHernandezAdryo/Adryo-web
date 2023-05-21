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

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    <i class="fa fa-building"></i>
                    Desarrollos
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-block">

                    <!-- Contadores -->
                    <div class="row mt-1">
                        <div class="col-sm-4 col-lg-2 text-center offset-lg-2">
                            Total de desarrollos 
                            <div class="number chips bg-status-desarrollo-total">
                                <?= count($desarrollos); ?>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            No liberado
                            <div class="number chips bg-status-desarrollo-bloqueado">
                                <span id="no_liberado"> 0 </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            En venta
                            <div class="number chips bg-status-desarrollo-venta">
                                <span id="libre"> 0 </span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-2 text-center">
                            Vendido
                            <div class="number chips bg-status-desarrollo-vendido">
                                <span id="vendido"> 0 </span>
                            </div>
                        </div>
                    </div>

                    <!-- Inputs -->
                    <div class="row">
                        <!-- <div class="col-sm-12 col-lg-1 mt-2">
                            <?= $this->Form->input('contador', array(
                                'class'       => 'form-control text-sm-center',
                                'div'         => false,
                                'placeholder' => 0,
                                'label'       => false
                            )) ?>
                        </div> -->
                        <div class="col-sm-12 col-lg-3 mt-2 offset-lg-9">
                            <?= $this->Form->input('contador', array(
                                'class'       => 'form-control',
                                'div'         => false,
                                'placeholder' => 'Buscador',
                                'label'       => false
                            )) ?>
                        </div>
                    </div>

                    <div class="contenedor-desarrollos mt-2" style="height: 68vh; width: 100%; overflow-y: scroll; overflow-x: none;">
                        
                        <?php foreach ($desarrollos as $desarrollo): ?> 
                            <div class="col-sm-12 col-lg-4 mt-1">
                                <div class="card">
                                    <div class="card-header <?= $bg_propiedades[$desarrollo['Desarrollo']['visible']] ?>">
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-8">
                                                <p class="m-0">
                                                    <?= $desarrollo['Desarrollo']['nombre'] ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 col-lg-4 text-sm-right">
                                                <p class="m-0">
                                                    <?php 
                                                        switch ($desarrollo['Desarrollo']['visible']):
                                                            case(0):
                                                                echo "Libre";
                                                            break;
                                                            case(1):
                                                                echo "En venta";
                                                            break;
                                                            case(2):
                                                                echo "No liberado";
                                                            break;
                                                        endswitch;
                                                    ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <!-- Img -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 220px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                                            </div>
                                        </div>
                                        <!-- Disponibilidad e inventario -->
                                        <div class="row mt-1">
                                            <div class="col-sm-12 col-lg-6">
                                                <p style="font-size: 15px; font-weight: 700;">
                                                    Disponibilidad total
                                                    <p style="font-size: 19px; font-weight: 400;" class="text-sm-center"> <?= sizeof($desarrollo['Disponibles'])?> / <?= sizeof($desarrollo['Propiedades'])?></p>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                                <div class="text-sm-right">
                                                    <small>
                                                        <?= $this->Html->link('Ver inventario',array('controller'=>'desarrollos','action'=>'inventario',$desarrollo['Desarrollo']['id']))?>
                                                        <!-- <a href="#">Ver inventario</a> -->
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Iconos y asignacion de equipos -->
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                Equipo <span class="text-sm-right"> <?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $desarrollo['EquipoTrabajo']['nombre_grupo'])?> </span>
                                                <br>
                                                Privado <span class="text-sm-right"> <?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?> </span>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 text-sm-right">
                                                Compartir
                                                <br>
                                                <span>
                                                    <a href="https://www.facebook.com/share.php?u=<?=Router::url('', true)?>&title=Desarrollo" target="_blank" id="shareFbDesarrollo">
                                                        <?= $this->Html->image('icons_desarrollo/fb-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                    </a>
                                                </span>
                                                <span>
                                                    <?= $this->Html->image('icons_desarrollo/tw-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                </span>
                                                <span>
                                                    <?= $this->Html->image('icons_desarrollo/li-rounded.svg', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Separador -->
                                        <div class="row mt-2">
                                            <div class="col-sm-12">
                                                <hr>
                                            </div>
                                        </div>
                                        <!-- Metrajes -->
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6">
                                                <div>
                                                    <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                    <span>
                                                        <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?> 
                                                        <!-- m<sup>2</sup> -->
                                                    </span>
                                                </div>
                                                <br>
                                                <div>
                                                    <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                    <span>
                                                        <?= $desarrollo['Desarrollo']['rec_low']?>-<?= $desarrollo['Desarrollo']['rec_top']?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-6">
                                                <div>
                                                    <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                    <span>
                                                        <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                                                    </span>
                                                </div>
                                                <br>
                                                <div>
                                                    <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                                    <span>
                                                        <?= $desarrollo['Desarrollo']['est_low']?>-<?= $desarrollo['Desarrollo']['est_top']?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Descripciones -->
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-sm">
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
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button class="btn btn-primary float-right ml-1">Vendido</button>
                                                <button class="btn btn-secondary-o float-right">Liberado</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    echo $this->Html->script([

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
        '/vendors/bootstrap-switch/js/bootstrap-switch.min'
    ], array('inline'=>false));
?>
<script>

$("#shareFbDesarrollo").attr('href', "https://www.facebook.com/share.php?u="+URL+"&title=Desarrollo" );

    'use strict';
    $(document).ready(function) () {

    }();

</script>