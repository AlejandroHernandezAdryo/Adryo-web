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
                    Inventario
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1">
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
                    <!-- Información superior -->
                    <div class="row">
                        <div class="col-sm-12 col-lg-2">
                            <div class="pointer" style="background-image: url('<?= Router::url('/',true).$desarrollo['FotoDesarrollo'][0]['ruta']; ?>'); border-radius: 8px; height: 220px; background-repeat: no-repeat; background-size: cover; background-position: top center;" onclick="location.href='<?php echo Router::url('/',true)."Desarrollos/view/".$desarrollo['Desarrollo']['id'] ?>';"></div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <div>
                                <b class="m-0">Tipo de desarrollo</b>
                                <p><?= $desarrollo['Desarrollo']['tipo_desarrollo']?></p>
                            </div>
                            <div>
                                <b class="m-0">Torres</b>
                                <p><?= $desarrollo['Desarrollo']['torres']?></p>
                            </div>
                            <div>
                                <b class="m-0">Unidades totales</b>
                                <p><?= $desarrollo['Desarrollo']['unidades_totales']?></p>
                            </div>
                            <div>
                                <b class="m-0">Entrega</b>
                                <p><?= ($desarrollo['Desarrollo']['entrega']=="Inmediata" ? $desarrollo['Desarrollo']['entrega'] : date('d - M - Y',  strtotime($desarrollo['Desarrollo']['fecha_entrega'])))?></p>
                            </div>
                            <div>
                                <b class="m-0">Colonia</b>
                                <p><?= $desarrollo['Desarrollo']['colonia']?></p>
                            </div>
                            <!-- <table class="table table-sm">
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
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <div style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">
                                <div>
                                    <?= $this->Html->image('adryo_iconos/icons-profile/aspect_ratio.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                    <br>
                                    <span>
                                        <?= $desarrollo['Desarrollo']['m2_low']?> - <?= $desarrollo['Desarrollo']['m2_top']?> 
                                        <!-- m<sup>2</sup> -->
                                    </span>
                                </div>
                                <br>
                                <div>
                                    <?= $this->Html->image('adryo_iconos/icons-profile/king_bed.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                    <br>
                                    <span>
                                        <?= $desarrollo['Desarrollo']['rec_low']?>-<?= $desarrollo['Desarrollo']['rec_top']?>
                                    </span>
                                </div>
                            </div>
                            <div style="display:flex;justify-content:space-evenly;flex-wrap:wrap;">
                                <div>
                                    <?= $this->Html->image('adryo_iconos/icons-profile/bathtub.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                    <br>
                                    <span>
                                        <?= $desarrollo['Desarrollo']['banio_low']?>-<?= $desarrollo['Desarrollo']['banio_top']?>
                                    </span>
                                </div>
                                <br>
                                <div>
                                    <?= $this->Html->image('adryo_iconos/icons-profile/car-sport.png', array('class' => 'img-icon', 'style' => 'width:27px;')); ?>
                                    <br>
                                    <span>
                                        <?= $desarrollo['Desarrollo']['est_low']?>-<?= $desarrollo['Desarrollo']['est_top']?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4">
                            <div>
                                <p class="m-0">
                                    Equipo
                                </p>
                                <p class="m-0"> <?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $desarrollo['EquipoTrabajo']['nombre_grupo'])?> </p>
                                <br>
                                <p class="m-0">
                                    Privado 
                                </p>
                                <p class="m-0"> <?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?> </p>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-2">
                            <div class="text-sm-right">
                                <p style="font-size: 15px; font-weight: 700;">
                                    Disponibilidad total
                                    <p style="font-size: 19px; font-weight: 400;" class="text-sm-center"> <?= sizeof($desarrollo['Disponibles'])?> / <?= sizeof($desarrollo['Propiedades'])?></p>
                                </p>
                            </div>
                            <!-- <div>
                                Equipo <span class="text-sm-right"> <?= ($desarrollo['EquipoTrabajo']['nombre_grupo']==null ? "Sin equipo asignado" : $desarrollo['EquipoTrabajo']['nombre_grupo'])?> </span>
                                <br>
                                Privado <span class="text-sm-right"> <?= ($desarrollo['Desarrollo']['is_private']==1 ? "Si" : "No")?> </span>
                            </div> -->
                            <div class="text-sm-right">
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
                            <div class="mt-1 text-sm-right" style="position:absolute;right:16px;">
                                <button class="btn btn-primary float-right ml-1">Vendido</button>
                                <button class="btn btn-secondary-o float-right">Liberado</button>
                            </div>
                        </div>
                    </div>
                    <!-- separador -->
                    <div>
                        <hr>
                    </div>
                    <!-- Inventario -->
                    <div class="row mt-3">
                        <div class="col-sm-12" style="display:flex;justify-content:space-between;">
                            <div class="text-center ">
                                Total de desarrollos 
                                <div class="number chips bg-status-desarrollo-total">
                                    <?= count($desarrollos); ?>
                                </div>
                            </div>
                            <div class="text-center">
                                Baja
                                <div class="number chips bg-baja" style="padding: 2px 5px 2px 5px;">
                                    <span id="baja"> <?= isset($contadores[5])? $contadores[5] : 0 ?>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center">
                                Bloqueados
                                <div class="number chips bg-bloqueado" style="padding: 2px 5px 2px 5px;">
                                    <span id="bloqueado"> <?= isset($contadores[0])? $contadores[0] : 0 ?>
                                    </span>
                                </div>
                            </div>
                            <div class="text-center">
                                En venta
                                <div class="number chips bg-status-desarrollo-venta">
                                    <span id="libre"> 0 </span>
                                </div>
                            </div>
                            <div class="text-center">
                                Apartados
                                <div class="number chips bg-status-desarrollo-bloqueado">
                                    <span id="no_liberado"> 0 </span>
                                </div>
                            </div>
                            <div class="text-center">
                                Vendidos
                                <div class="number chips bg-status-desarrollo-vendido">
                                    <span id="vendido"> 0 </span>
                                </div>
                            </div>
                            <div class="text-center">
                                Escriturados
                                <div class="number chips bg-escriturado" style="padding: 2px 5px 2px 5px;">
                                    <span id="escrituracion"> <?= isset($contadores[4])? $contadores[4] : 0 ?>
                                    </span>
                                </div>
                            </div>
                            <div>
                                Venta
                                <div style="vertical-align: top;"><b><?= (!isset($desarrollo['ObjetivoAplicable'][0]['monto'])?"No definido":"$".number_format($desarrollo['ObjetivoAplicable'][0]['monto'],0))?></b></div>
                            </div>
                        </div>
                    </div>
                    <!-- Cuadricula de pisos -->
                    <!-- <//?= $p = 1; ?> -->
                    <div class="row">
                        <div class="col-sm-12 mt-1">
                            <div style="display:flex; gap:8px; align-items:center;">
                                <div class="level" style="background-color:purple; border-radius:100%;color:white;width:20px;height:20px;">
                                    <p class="text-sm-center">
                                        1
                                    </p>
                                    <!-- <//?= $p++; ?> -->
                                </div>
                                <div style="display:flex; gap:8px;">
                                    <div>S-101</div>
                                    <div>S-102</div>
                                    <div>S-103</div>
                                    <div>S-104</div>
                                    <div>S-105</div>
                                    <div>S-106</div>
                                    <div>S-107</div>
                                    <div>S-108</div>
                                    <div>S-109</div>
                                    <div>S-110</div>
                                    <div>S-111</div>
                                    <div>S-112</div>
                                </div>
                            </div>
                            <div class="col-sm-1">
                            </div>
                            <div class="col-sm-11">
                                <div>
                                    <div>S-101</div>
                                    <div>S-102</div>
                                    <div>S-103</div>
                                    <div>S-104</div>
                                    <div>S-105</div>
                                    <div>S-106</div>
                                    <div>S-107</div>
                                    <div>S-108</div>
                                    <div>S-109</div>
                                    <div>S-110</div>
                                    <div>S-111</div>
                                    <div>S-112</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>