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
        'custom',
        'components_adryo'
        //'pages/form_elements'
    ),
    array('inline'=>false));
?>
<!-- Modal para la edicion y eliminar el seguimiento rapido. -->
<div class="fade side-bar" id="myModal">
    <div class="card-block" style="background-color:green;">
        <span style="color:white;">
            Validar "documento"
        </span> 
        <div class="float-right pointer">
            <i class='fa fa-times' style="color:white;" data-dismiss="modal"></i>
        </div>
    </div>
    <!-- <div> -->
    <div class="col-sm-12">
        <div class="mt-1">
            <h2 class="text-black">
                Nombre de documento
            </h2>
        </div>
        <div class="mt-1">
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Asesor
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Alejandro Hernández
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Fecha de inicio
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        03-05-2023
                    </small>
                </div>
            </div>
            <div class="" style="display:flex;justify-content:space-evenly;flex-wrap:wrap;padding: 2px 0;">
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Fecha de fin
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
                        Validado por
                    </small>
                </div>
                <br>
                <div style="width:49%;background-color:#CCDADA;padding:0 8px;">
                    <small>
                        Nuevo
                    </small>
                </div>
            </div>
        </div>
        <div class="mt-1">
            <div style="display:flex;flex-direction:column;">
                <label for="Observaciones">Observaciones</label>
                <textarea class="form-control" name="Observaciones" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="mt-1">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="btn btn-primay-o" for="customFile"></label>
            </div>
            <!-- <div class="file-drop-area" style="display:flex;flex-direction:column;">
                <span class="file-message text-center">Arrastra tus archivos aquí <br> o</span>
                <span class="choose-file-button btn btn-primary-o">Buscar archivos</span>
                <input class="file-input" type="file" multiple>
            </div> -->
        </div>
        <div class="mt-3" >
            <div>
                <div style="border-bottom:1px solid lightgray;display:flex;justify-content:space-between;">
                    <div style="width:10%">
                        <i class="fa fa-file"></i>
                    </div>
                    <div style="width:10%">
                        <i class="fa fa-trash"></i>
                    </div>
                    <div style="display:flex;gap:4px;">
                        <button class="btn btn-primary">
                            <small>
                                Validar
                            </small>
                        </button>
                        <button class="btn btn-danger">
                            <small>
                                Rechazar
                            </small>
                        </button>
                    </div>
                </div>
                <!-- <?= $this->Html->link('Conoce el proceso de Adryo',array('controller'=>'desarrollos','action'=>'inicio_proceso',$desarrollo['Desarrollo']['id']))?>
                <?= $this->Html->link('Crear Proceso',array('controller'=>'desarrollos','action'=>'proceso_tabla',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary'))?> -->
                <!-- <a href="">Conoce el proceso de <b>Adryo</b></a>
                <button class="btn btn-primary">Crear Proceso</button> -->
            </div>
        </div>
    </div>
    <!-- </div> -->
    <!-- <div class="">
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
    </div> -->
</div>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Proceso cliente
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block" style="height:80vh;">
                    <!-- Información superior -->
                    <div class="row mt-1" >
                        <div class="col-sm-12 col-lg-6">
                            <div>
                                <p style="background-color: #FBD89B;margin-bottom:0;padding:0 4px;">
                                    <b>Yoselin Medina</b>
                                </p>
                                <div style="display:flex;">
                                    <div style="width:50%;padding:0 4px;">
                                        Proceso
                                    </div>
                                    <div style="width:50%;padding:0 4px;">
                                        Validación B
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div style="width:50%;background-color:#E6ECEC;padding:0 4px;">
                                        Creado
                                    </div>
                                    <div style="width:50%;background-color:#E6ECEC;padding:0 4px;">
                                        Ian Sánchez Pérez
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div style="width:50%;padding:0 4px;">
                                        Fecha de creación
                                    </div>
                                    <div style="width:50%;padding:0 4px;">
                                        03-05-2023
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div style="width:50%;background-color:#E6ECEC;padding:0 4px;">
                                        Fecha de finalización
                                    </div>
                                    <div style="width:50%;background-color:#E6ECEC;padding:0 4px;">
                                        
                                    </div>
                                </div>
                                <div style="display:flex;">
                                    <div style="width:50%;padding:0 4px;">
                                        Etapa
                                    </div>
                                    <div style="width:50%;padding:0 4px;">
                                        5. Perfilado
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 text-sm-center">
                            Grafica
                        </div>
                    </div>
                    
                    <!-- </div> -->
                    <div class="mt-3" >
                        <div>
                            <div style="border-bottom:1px solid lightgray;display:flex;justify-content:space-between;padding: 0 16px;">
                                <div style="width:10%">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div style="width:40%">
                                    <?= $this->Html->link('Validar comprobante de pago','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status', 'data-toggle'=>'modal', 'data-target'=>'#myModal'))?>
                                </div>
                                <!-- <div style="width:10%">
                                    24 hrs.
                                </div> -->
                                <div style="width:10%">
                                    Gerente
                                </div>
                                <div style="width:10%">
                                    1
                                    <span>
                                        <i class="fa fa-file-o" style="margin-left:8px;"></i>
                                    </span>
                                </div>
                            </div>
                            <!-- <?= $this->Html->link('Conoce el proceso de Adryo',array('controller'=>'desarrollos','action'=>'inicio_proceso',$desarrollo['Desarrollo']['id']))?>
                            <?= $this->Html->link('Crear Proceso',array('controller'=>'desarrollos','action'=>'proceso_tabla',$desarrollo['Desarrollo']['id']), array('class' => 'btn btn-primary'))?> -->
                            <!-- <a href="">Conoce el proceso de <b>Adryo</b></a>
                            <button class="btn btn-primary">Crear Proceso</button> -->
                        </div>
                    </div>
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

$(document).on('change', '.file-input', function() {
        

        var filesCount = $(this)[0].files.length;
        
        var textbox = $(this).prev();
      
        if (filesCount === 1) {
          var fileName = $(this).val().split('\\').pop();
          textbox.text(fileName);
        } else {
          textbox.text(filesCount + ' files selected');
        }
      });

    $('.file-upload').file_upload();

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