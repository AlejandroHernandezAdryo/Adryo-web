<?= $this->Html->css(
        array(
            '/vendors/swiper/css/swiper.min',
            'pages/general_components',
            
            'jquery.fancybox',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fullcalendar/css/fullcalendar.min',
            'pages/timeline2',
            'pages/calendar_custom',
            'pages/profile',
            'pages/gallery',
            '/vendors/swiper/css/swiper.min',
            'pages/widgets',
            'pages/flot_charts',
            
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/c3/css/c3.min',
            '/vendors/toastr/css/toastr.min',
            '/vendors/switchery/css/switchery.min',
            'pages/new_dashboard',
            
            'pages/layouts',
                        
            '/vendors/chosen/css/chosen',
            '/vendors/bootstrap-switch/css/bootstrap-switch.min',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            
            '/vendors/fancybox/css/jquery.fancybox',
            '/vendors/fancybox/css/jquery.fancybox-buttons',
            '/vendors/fancybox/css/jquery.fancybox-thumbs',
            '/vendors/imagehover/css/imagehover.min',
            'pages/gallery'
            
            
            
        ),
        array('inline'=>false)); 
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Desarrollos
                        </h4>
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white"><?php 
                                    
                                        echo $desarrollo['Desarrollo']['nombre'];
                                    
                                    ?>
                                    <?php if ($this->Session->read('Permisos.Group.de')==1){?>
                                                        <div style="float:right">
                                                            <?= $this->Html->link('<i class="fa fa-edit fa-2x"></i>',array('action'=>'edit_generales',$desarrollo['Desarrollo']['id']),array('style'=>'color:white','escape'=>false))?>
                                                        </div>
                                                        <?php }?>
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header">
                                                        <?php echo $desarrollo['Desarrollo']['calle'] . " " . $desarrollo['Desarrollo']['numero_ext'] . " " . $desarrollo['Desarrollo']['numero_int'] . " " . $desarrollo['Desarrollo']['colonia']?>
                                                        <small><?php echo $desarrollo['Desarrollo']['ciudad'] . " " . $desarrollo['Desarrollo']['estado'] . " CP: " . $desarrollo['Desarrollo']['cp']?></small>
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-2" style="text-align: center">
                                            <?php 
                                                if (isset($desarrollo['FotoDesarrollo'][0]['ruta'])){
                                                ?>
                                                <?php 
                                                        echo $this->Html->link(
                                                            $this->Html->image($desarrollo['FotoDesarrollo'][0]['ruta'],array('class'=>'img-fluid gallery-style')),
                                                            $desarrollo['FotoDesarrollo'][0]['ruta'],
                                                            array(
                                                                'class'=>'fancybox zoom thumb_zoom',
                                                                'data-fancybox-group'=>'gallery',
                                                                'title'=>$desarrollo['FotoDesarrollo'][0]['descripcion'],
                                                                'escape'=>false
                                                            )
                                                                );
                                                    ?>
                                                <?php
                                                    foreach ($desarrollo['FotoDesarrollo'] as $imagen):
                                                ?>
                                                
                                            <div class="col-md-3 col-6 gallery-border" style="display: none">
                                                    <?php 
                                                        echo $this->Html->link(
                                                            $this->Html->image($imagen['ruta'],array('class'=>'img-fluid gallery-style','style'=>'width:100%;height:20px;')),
                                                            $imagen['ruta'],
                                                            array(
                                                                'class'=>'fancybox zoom thumb_zoom',
                                                                'data-fancybox-group'=>'gallery',
                                                                'title'=>$imagen['descripcion'],
                                                                'escape'=>false
                                                            )
                                                                );
                                                    ?>
                                                </div>
                                                <?php        
                                                    endforeach;
                                                ?>
                                                <?php
                                                }else{
                                                    echo $this->Html->image('no_photo_inmuebles.png',array('style'=>'max-width:100%; max-height:200px',));
                                                }
                                                
                                            ?>
                                            <div style="margin-top:10px">
                                                <?= sizeof($desarrollo['FotoDesarrollo'])?> Imágenes<br>

                                                
                                            </div>

                                            
                                            
                                        </div>
                                        
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col-lg-3" style="text-align:left">
                                                    <font color="##4FB7FE">DISPONIBILIDAD</font>
                                                </div>
                                                <div class="col-lg-3" style="text-align:left">
                                                    <?php echo $desarrollo['Desarrollo']['disponibilidad']?>
                                                </div>
                                                <div class="col-lg-3" style="text-align:left">
                                                    <font color="##4FB7FE">TIPO DE DESARROLLO</font>
                                                </div>
                                                <div class="col-lg-3" style="text-align:left">
                                                    <?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?>
                                                </div>
                                                
                                            </div>
                                        <div class="row">
                                            <div class="col-lg-3" style="text-align:left">
                                                <font color="##4FB7FE">FECHA DE ENTREGA</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php echo $desarrollo['Desarrollo']['fecha_entrega']?>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <font color="##4FB7FE">UNIDADES TOTALES</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php echo $desarrollo['Desarrollo']['unidades_totales']?>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3" style="text-align:lef">
                                                <font color="##4FB7FE">INICIO DE PREVENTA</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php echo $desarrollo['Desarrollo']['inicio_preventa']?>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <font color="##4FB7FE">TORRES</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php echo $desarrollo['Desarrollo']['torres']?>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3" style="text-align:lef">
                                                <font color="##4FB7FE">UNIDADES TOTALES</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php $desarrollo['Desarrollo']['unidades_totales']?>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <font color="##4FB7FE">DEPARTAMENTOS MUESTRA</font>
                                            </div>
                                            <div class="col-lg-3" style="text-align:left">
                                                <?php echo $desarrollo['Desarrollo']['torres']?>
                                            </div>
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="card m-t-10">
                                        <div class="card-header bg-white">
                                            <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#tab1" data-toggle="tab" aria-expanded="true">Descripción General</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#tab2" data-toggle="tab" aria-expanded="false">Amenidades</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-block">
                                            <div class="tab-content text-justify">
                                                <div class="tab-pane active" id="tab1" aria-expanded="true">
                                                    <p class="card-text"> 
                                                        <?php echo $desarrollo['Desarrollo']['descripcion'];?>    
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="tab2" aria-expanded="false">
                                                    <p class="card-text">
                                                                <?php echo ($desarrollo['Desarrollo']['alberca_sin_techar'] == 1 ? '<div class="col-xs-3">Alberca descubierta</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['alberca_techada'] == 1 ? '<div class="col-xs-3">Alberca Techada</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['areas_verdes'] == 1 ? '<div class="col-xs-3">Áreas Verdes</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['asador'] == 1 ? '<div class="col-xs-3">Asador</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['business_center'] == 1 ? '<div class="col-xs-3">Business Center</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['cafeteria'] == 1 ? '<div class="col-xs-3">Cafetería</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['carril_nado'] == 1 ? '<div class="col-xs-3">Carril de Nado</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['cctv'] == 1 ? '<div class="col-xs-3">CCTV</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['elevadores'] == 1 ? '<div class="col-xs-3">Elevadores</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['estacionamiento_visitas'] == 1 ? '<div class="col-xs-3">Estacionamiento de visitas</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['fire_pit'] == 1 ? '<div class="col-xs-3">Gimnasio</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['gimnasio'] == 1 ? '<div class="col-xs-3">Gimnasio</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['interfon'] == 1 ? '<div class="col-xs-3">Interfón</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['internet'] == 1 ? '<div class="col-xs-3">Internet</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['jacuzzi'] == 1 ? '<div class="col-xs-3">Jacuzzi</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['juegos_infantiles'] == 1 ? '<div class="col-xs-3">Juegos Infantiles</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['lobby'] == 1 ? '<div class="col-xs-3">Lobby</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['paddle_tennis'] == 1 ? '<div class="col-xs-3">Cancha de Paddle Tennis</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['pista_jogging'] == 1 ? '<div class="col-xs-3">Pista de Jogging</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['planta_emergencia'] == 1 ? '<div class="col-xs-3">Planta de emergencia</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['porton_electrico'] == 1 ? '<div class="col-xs-3">Porton Eléctrico</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['roof_garden_compartido'] == 1 ? '<div class="col-xs-3">Roof Garden Compartido</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['sala_cine'] == 1 ? '<div class="col-xs-3">Sala de Cine</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['salon_juegos'] == 1 ? '<div class="col-xs-3">Salón de Juegos</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['salon_usos_multiples'] == 1 ? '<div class="col-xs-3">Salón de usos múltiples</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['sistema_contra_incendios'] == 1 ? '<div class="col-xs-3">Sistema contra incendios</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['seguridad'] == 1 ? '<div class="col-xs-3">Seguridad</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['sky_garden'] == 1 ? '<div class="col-xs-3">Sky Garden</div>' : "") ?>
                                                                <?php echo ($desarrollo['Desarrollo']['spa_vapor'] == 1 ? '<div class="col-xs-3">Spa / Vapor</div>' : "") ?>
                                                            </p>
                                                </div>
                                                <div class="tab-pane" id="tab3" aria-expanded="false">
                                                    
                                                    <p class="card-text"> 
                                                                
                                                        
                                                        <div class="row">
                                                                <table id="example2" class="table table-bordered table-striped" role="grid" aria-describedby="example2_info">
                                                                                <thead>
                                                                                    <tr role="row">
                                                                                        
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    
                                                                            </table>
                                                        </div>
                                                    
                                                                            
                                       
                                                                 
                                                            </p>
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
            <div class="outer" style="margin-top:0px !important">
                <div class="inner bg-container">
                    <div class="row ">
                        <?php  echo $this->Form->create('Lead', array('url' => array('action' => 'enviar_departamentos'))) ?>
                        <div class="col-lg-12">
                            <div class="card m-t-10">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Inventario
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                                    Lista de inventario
                                                    <div class="float-xs-right">
                                                        <?= $this->Html->link('<i class="fa fa-home fa-1x"></i>Crear Unidad',array('controller'=>'inmuebles','action'=>'add_unidades',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-xs','style'=>'background-color:green; color:white'))?>
                                                        <?= $this->Html->link('<i class="fa fa-edit fa-1x"></i>Modificación Masiva',array('controller'=>'inmuebles','action'=>'modificacion',$desarrollo['Desarrollo']['id']),array('escape'=>false,'class'=>'btn btn-link btn-xs','style'=>'background-color:green; color:white'))?>
                                                    </div>
                                                </div>
                                                <div class="card-block m-t-35" >
                                                        <div class="col-lg-12">
                                                            <table id="inventario" class="table display nowrap" >
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th >Referencia</th>
                                                                        <th >Título</th>
                                                                        <th >Tipo</th>
                                                                        <th >Operación</th>
                                                                        <th >Precio</th>
                                                                        <th >Const.</th>
                                                                        <th >Hab.</th>
                                                                        <th >Baños</th>
                                                                        <th >Estaci.</th>
                                                                        <th><?php echo "Status" ?></th>
                                                                        <?php if ($this->Session->read('Permisos.Group.ilib') == 1) { ?>
                                                                            <th><?= "Cambiar Estado" ?></th>
                                                                        <?php } ?>
                                                                        <?php if ($this->Session->read('Permisos.Group.idel') == 1) { ?>
                                                                            <th><?php echo "Eliminar" ?></th>
                                                                    <?php } ?>
                                                                    </tr>
                                                                </thead>
                                                            <tbody>
                                                                <?php //$i = 1 ?>
                                                                <?php foreach ($tipos as $tipo): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php // echo $this->Form->hidden('inmueble_id' . $i, array('value' => $tipo['Inmueble']['id'])) ?>
                                                                        <?php //echo $this->Form->input('seleccionar' . $i, array('type' => 'checkbox', 'label' => false)) ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php
                                                                            if ($tipo['Inmueble']['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3) {
                                                                                echo $this->Html->link($tipo['Inmueble']['referencia'], array('action' => 'view', 'controller' => 'inmuebles', $tipo['Inmueble']['id']));
                                                                            } else {
                                                                                echo $tipo['Inmueble']['referencia'];
                                                                            }
                                                                            ?>
                                                                    </td>
                                                                    <td><?php echo $tipo['Inmueble']['titulo'] ?></td>
                                                                    <td><?php echo $tipo['TipoPropiedad']['tipo_propiedad'] ?></td>
                                                                    <td><?php echo $tipo['Inmueble']['venta_renta'] ?></td>
                                                                    <td><?php
                                                                        if ($tipo['Inmueble']['liberada'] != 0 || $this->Session->read('Auth.User.group_id') != 3)
                                                                            echo "$" . number_format($tipo['Inmueble']['precio'], 2);
                                                                        ?>
                                                                    </td>
                                                                    <td><?php echo $tipo['Inmueble']['construccion'] ?>m2</td>
                                                                    <td><?php echo $tipo['Inmueble']['recamaras'] ?></td>
                                                                    <td><?php echo $tipo['Inmueble']['banos'] ?></td>
                                                                    <td><?php echo $tipo['Inmueble']['estacionamiento_techado'] + $tipo['Inmueble']['estacionamiento_descubierto'] ?></td>
                                                                    <?php
                                                                        switch ($tipo['Inmueble']['liberada']) {
                                                                        case 0: //No liberada
                                                                            echo "<td style='text-align: center; background-color: #fcee21'>BLOQUEAD0</td>";
                                                                            break;

                                                                        case 1: // Libre
                                                                            echo "<td style='text-align: center; background-color: #39b54a'>LIBRE</td>";
                                                                            break;

                                                                        case 2:
                                                                            echo "<td style='text-align: center; background-color: #fbb03b'>RESERVA</td>";
                                                                            break;

                                                                        case 3:
                                                                            echo "<td style='text-align: center; background-color: #29abe2'>CONTRATO</td>";
                                                                            break;

                                                                        case 4:
                                                                            echo "<td style='text-align: center; background-color: #c1272d'>ESCRITURACION</td>";
                                                                            break;
                                                                        case 5:
                                                                            echo "<td style='text-align: center; background-color: red'>BAJA</td>";
                                                                            break;
                                                                    }
                                                                    ?>
                                                                    <?php if ($this->Session->read('Permisos.Group.ilib') == 1 && $tipo['Inmueble']['liberada'] != 4) { ?>    
                                                                        <td>
                                                                            <?php
                                                                            if ($tipo['Inmueble']['liberada'] != 0) {
                                                                                echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'inmuebles','action' => 'status', $tipo['Inmueble']['id'],0,$desarrollo['Desarrollo']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BORRADOR','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Html->link('<i class="fa fa-pencil"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 0), array('escape' => false));
                                                                                //echo $this->Form->postLink('<i class="fa fa-pencil"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],0), array('title'=>'Borrador','escape'=>false), __('Desea poner en borrador este inmueble?', $desarrollo['Desarrollo']['id']))." "; 
                                                                            }
                                                                            if ($tipo['Inmueble']['liberada'] != 1) {
                                                                                echo $this->Html->link('<i class="fa fa-check"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 1, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBRE','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-check"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],1), array('title'=>'Libre','escape'=>false), __('Desea liberar este inmueble?', $desarrollo['Desarrollo']['id']))." ";
                                                                            }
                                                                            if ($tipo['Inmueble']['liberada'] != 2) {
                                                                                echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 2, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'RESERVADO','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-calendar"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],2), array('title'=>'Reservado','escape'=>false), __('Desea registrar reserva de este inmueble?', $desarrollo['Desarrollo']['id']))." ";
                                                                            }
                                                                            if ($tipo['Inmueble']['liberada'] != 3) {
                                                                                echo $this->Html->link('<i class="fa fa-file"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 3, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'CONTRATO','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-file"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],3), array('title'=>'Contrato','escape'=>false), __('Desea registrar contrato de este inmueble?', $desarrollo['Desarrollo']['id']))." ";
                                                                            }
                                                                            if ($tipo['Inmueble']['liberada'] != 4) {
                                                                                echo $this->Html->link('<i class="fa fa-certificate"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 4, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'ESCRITURACIÓN','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-certificate"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],4), array('title'=>'Escrituración','escape'=>false), __('Desea registrar escrituración de este inmueble?', $desarrollo['Desarrollo']['id']));
                                                                            }
                                                                            if ($tipo['Inmueble']['liberada'] != 5) {
                                                                                echo $this->Html->link('<i class="fa fa-times"></i>', array('controller' => 'inmuebles', 'action' => 'status', $tipo['Inmueble']['id'], 5, $desarrollo['Desarrollo']['id']), array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BAJA','escape'=>false,'style'=>'margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-times"></i>', array('action' => 'status', $desarrollo['Desarrollo']['id'],5), array('title'=>'BAJA','escape'=>false), __('Desea dar de baja este inmueble?', $desarrollo['Desarrollo']['id']));
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    <?php
                                                                    } if ($tipo['Inmueble']['liberada'] == 4 && $this->Session->read('Permisos.Group.id') == 1) {
                                                                        echo "<td>" . $this->Form->postLink('<i class="fa fa-check"></i>', array('action' => 'status', $tipo['Inmueble']['id'], 1, $desarrollo['Desarrollo']['id']), array('title' => 'Libre', 'escape' => false), __('Desea liberar este inmueble?', $tipo['Inmueble']['id'])) . "<td>";
                                                                    } else {
                                                                        echo "<td></td>";
                                                                    }
                                                                    ?>
                                                                    <?php if ($this->Session->read('Permisos.Group.idel') == 1) { ?>
                                                                        <td style="text-align: center;"><?php echo $this->Form->postLink('<i class="fa fa-trash"></i>', array('controller' => 'inmuebles', 'action' => 'delete_depto', $tipo['Inmueble']['id'],$desarrollo['Desarrollo']['id']), array('escape' => false), __('Desea eliminar este inmueble?', $tipo['Inmueble']['id'],$desarrollo['Desarrollo']['id'])); ?></td>
                                                                    <?php } ?>

                                                                </tr>
                                                                <?php // $i++ ?>
                                                            <?php endforeach; ?> 
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
                    
            <div class="outer" style="margin-top:0px !important">
                <div class="inner bg-container">
                    
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card m-t-10">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Lead de ventas
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="widget_icon_bgclr icon_align bg-white section_border">
                                                <div class="bg_icon bg_icon_info float-xs-left">
                                                    <i class="fa fa-heart-o text-info" aria-hidden="true"></i>
                                                </div>
                                                <div class="text-xs-right">
                                                    <h3 class="kpi"><?= $interesados?></h3>
                                                    <p>Personas interesadas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                        <div class="col-lg-3">
                            <div class="card m-t-10">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Visitas
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="widget_icon_bgclr icon_align bg-white section_border">
                                                <div class="bg_icon bg_icon_info float-xs-left">
                                                    <i class="fa fa-eye text-info" aria-hidden="true"></i>
                                                </div>
                                                <div class="text-xs-right">
                                                    <h3 class="kpi"><?= $visitas?></h3>
                                                    <p>Visitas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="card m-t-10">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Llamadas
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="widget_icon_bgclr icon_align bg-white section_border">
                                                <div class="bg_icon bg_icon_info float-xs-left">
                                                    <i class="fa fa-phone text-info" aria-hidden="true"></i>
                                                </div>
                                                <div class="text-xs-right">
                                                    <h3 class="kpi"><?= $llamadas?></h3>
                                                    <p>Llamadas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                        <div class="col-lg-3">
                            <div class="card m-t-10">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    E-mails
                                </div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="widget_icon_bgclr icon_align bg-white section_border">
                                                <div class="bg_icon bg_icon_info float-xs-left">
                                                    <i class="fa fa-envelope text-info" aria-hidden="true"></i>
                                                </div>
                                                <div class="text-xs-right">
                                                    <h3 class="kpi"><?= $emails?></h3>
                                                    <p>E-mails Enviados</p>
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
            <div class="outer" style="margin-top:0px !important">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-4 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Formas de contacto: Total: <?= sizeof($contactos) ?> contactos
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:330px !important">
                                        <div class="col-lg-12">
                                            <div class="demo-container">
                                                <div id="donut" class="flotChart2"></div>
                                                
                                            </div>
                                        </div>
                                </div>
                                
                        </div>
                    </div>
                    
                    
                        <div class="col-lg-4 m-t-10">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                Últimas 5 actividades
                            </div>
                            <div class="card-block twitter_section" style="overflow-y: scroll; height:330px !important">
                                    <ul id="nt-example1">
                                       
                                       <?php foreach ($desarrollo['Log'] as $log):?>
                                        
                                        <li>
                                            <div class="row">
                                                <div class="col-xs-2 col-lg-3 col-xl-2">
                                                    <?php
                                                        $imagen = "";
                                                        switch ($log['accion']){
                                                            case (1):
                                                                $imagen = "<i class='fa fa-plus fa-2x' style='color:green'></i>";
                                                                break;
                                                            case (2) :
                                                                $imagen = "<i class='fa fa-pencil fa-2x' style='color:green'></i>";
                                                                break;
                                                            case (3) :
                                                                $imagen = "<i class='fa fa-calendar fa-2x' style='color:green'></i>";
                                                                break;
                                                            case (4) :
                                                                $imagen = "<i class='fa fa-phone fa-2x' style='color:green'></i>";
                                                                break;
                                                            case (5) :
                                                                $imagen = "<i class='fa fa-envelope fa-2x' style='color:green'></i>";
                                                                break;
                                                        }
                                                    ?>
                                                    <?= $imagen;?>
                                                    
                                                </div>
                                                <div class="col-xs-10 col-lg-9 col-xl-10">
                                                    <span class="name"><?= $usuarios[$log['usuario_id']]?></span> <span
                                                        class="time"><?= $log['fecha']?></span>
                                                    <br>
                                                    <span class="msg"><?= $log['mensaje']?></span>
                                                </div>
                                            </div>
                                            <hr>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>

                    </div>
                </div>
                     <div class="col-lg-4 m-t-10">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                Ubicación del desarrollo
                                
                            </div>
                            <?php
                                list($latitud, $longitud) = explode(",", $desarrollo['Desarrollo']['google_maps']);
                            ?>
                            <div class="card-block twitter_section" style="overflow-y: scroll; height:330px !important">
                                <div id="map"></div>
                                    <script>
                                      function initMap() {
                                        var uluru = {lat: <?= $latitud?>, lng: <?= $longitud?>};
                                        var map = new google.maps.Map(document.getElementById('map'), {
                                          zoom: 16,
                                          center: uluru
                                        });
                                        var marker = new google.maps.Marker({
                                          position: uluru,
                                          map: map
                                        });
                                      }
                                    </script>
                                    <script async defer
                                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOf3eYcnrP8hgEx5_914fUwMR1NCyQPfw&callback=initMap">
                                    </script>    
                                </div>

                    </div>
                </div>
                        <div class="col-lg-12 m-t-10">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                Lista de Posibles clientes
                            </div>
                            <div class="card-block m-t-10" >
                                    <div class="col-lg-12">
                                        <table id="example" class="table display nowrap" >
                                        <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Estatus de Lead</th>
                                            <th>Temperatura del cliente</th>
                                        </tr>
                                        </thead>
                                <tbody>
                                    <?php foreach ($leads as $lead):?>           
                                        <tr>
                                            <td><?= $this->Html->link($lead['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$lead['Cliente']['id']))?></td>
                                            <td><?= $lead['Lead']['status']?></td>
                                            <?php 
                                                switch ($lead['Cliente']['temperatura']){
                                                    case 1:
                                                        echo "<td style='background-color: #00c0ef'>&nbsp;</td>";
                                                        break;
                                                    case 2:
                                                        echo "<td style='background-color: yellow'>&nbsp;</td>";
                                                        break;
                                                    case 3:
                                                        echo "<td style='background-color: red'>&nbsp;</td>";
                                                        break;
                                                    default:
                                                        echo "<td>&nbsp;</td>";
                                                        break;
                                                }
                                            ?>
                                        </tr>
                                        <?php endforeach;?>    
                                    </tbody>
                            </table>
                                    </div>
                            </div>

                    </div>
                </div>
                        
                    
                    <div class="col-lg-4 m-t-10">
                        <div class="card">
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                Archivos Anexos
                            </div>
                            <div class="card-block" style="overflow-y: scroll; height:330px !important">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="80%"><b>Archivo</b></th>
                                        <th width="20%"><b>Descargar</b></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                       <?php foreach ($desarrollo['DocumentosUser'] as $documento):?>
                                            <tr>
                                                <td><?= $documento['documento']?></td>
                                                <td><?= $this->Html->link(
                                                        '<i class="fa fa-download"></i>',
                                                        $documento['ruta'],
                                                        array('escape'=>false)
                                                        )?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                            
                                    </tbody>
                                </table>
                                </div>
                         

                    </div>
                </div>
                    <div class="col-lg-4 m-t-10">
                        <div class="card" >
                            <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                Eventos de Hoy
                            </div>
                            <div class="card-block" style="overflow-y: scroll; height:330px !important">
                                <?php foreach ($desarrollo['Evento'] as $evento):?>
                                <a href="#" class="list-group-item calendar-list">
                                    <div class="tag tag-pill tag-primary float-xs-right"><?= date('H:i',  strtotime($evento['fecha_inicio']))?></div>
                                    <?= $evento['nombre_evento']?>
                                    <small><?= $usuarios[$evento['user_id']]?></small>
                                </a>
                                <?php endforeach;?>
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>       
            
</div>
                                          
                                    
                                    
                                    
                                    
                                    
                                    
                                

<?php 
    echo $this->Html->script([
        'vendors/swiper/js/swiper.min',
        
        '/vendors/slimscroll/js/jquery.slimscroll.min',
        '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        '/vendors/countUp.js/js/countUp.min',
        '/vendors/swiper/js/swiper.min',
        '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        
        '/vendors/flotchart/js/jquery.flot',
        '/vendors/flotchart/js/jquery.flot.resize',
        '/vendors/flotchart/js/jquery.flot.stack',
        '/vendors/flotchart/js/jquery.flot.time',
        '/vendors/flotspline/js/jquery.flot.spline.min',
        '/vendors/flotchart/js/jquery.flot.categories',
        '/vendors/flotchart/js/jquery.flot.pie',
        '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        
        '/vendors/raphael/js/raphael-min',
        '/vendors/d3/js/d3.min',
        '/vendors/c3/js/c3.min',
        '/vendors/toastr/js/toastr.min',
        '/vendors/switchery/js/switchery.min',
        '/vendors/jquery_newsTicker/js/newsTicker',
        '/vendors/countUp.js/js/countUp.min',
        
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        
        '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            'form',
        'pages/layouts',
        
        '/vendors/holderjs/js/holder',
        '/vendors/fancybox/js/jquery.fancybox.pack',
        '/vendors/fancybox/js/jquery.fancybox-buttons',
        '/vendors/fancybox/js/jquery.fancybox-thumbs',
        '/vendors/fancybox/js/jquery.fancybox-media',
        'pages/gallery'
        
        
        //'pages/tabla_leads',
        //'pages/flot_charts',
       
        
        
        
//      'pages/cards',
//      'pages/widget2',
//      'pages/mini_calendar',
        
    ], array('inline'=>false));
?>
<?php

$this->Html->scriptStart(array('inline' => false));

?>

'use strict';
$(document).ready(function () {

    
    $('#example').DataTable( {
        "scrollY": 300,
        "scrollX": true
    });

    $(".chzn-select").chosen({allow_single_deselect: true});
    
    
    //End of Scroll - horizontal and Vertical Scroll Table

    
    var datax = [
        <?php foreach ($contactos as $contacto):?>
    {
        label: "<?= $contacto['dic_linea_contactos']['linea_contacto']?>",
        data: <?= $contacto[0]['total']?>,
        color: '#4fb7fe'
    },
    <?php endforeach;?>
    ];

    $.plot($("#donut"), datax, {
        series: {
            pie: {
                innerRadius: 0.5,
                show: true
            }
        },
        legend: {
            show: false
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s"
        }

    });


    var data = [],
        series = Math.floor(Math.random() * 6) + 3;

    for (var i = 0; i < series; i++) {
        data[i] = {
            label: "Series" + (i + 1),
            data: Math.floor(Math.random() * 100) + 1
        }
    }
    $.plot("#placeholdertranslabel", data, {
        series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 1,
                    formatter:labelFormatter,
                    background: {
                        opacity: 0.8
                    }
                }
            }
        },
        legend: {
            show: false
        },
        colors: [ '#00cc99', '#4fb7fe', '#347dff', '#ff9933', '#0fb0c0']
    });

    $("#footer").prepend("Flot " + $.plot.version + " &ndash; ");
    function labelFormatter(label, series) {
        return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
    }
    
    
 

    
    

});

<?php $this->Html->scriptEnd();

?>

<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover()
});
</script>