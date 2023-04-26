<?= $this->Html->css(
        array(
            'pages/new_dashboard',

            '/vendors/imagehover/css/imagehover.min',
            'pages/gallery',
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fullcalendar/css/fullcalendar.min',
            'pages/timeline2',
            'pages/calendar_custom',
            'pages/profile',
            'pages/gallery',
            
            '/vendors/c3/css/c3.min',
            '/vendors/toastr/css/toastr.min',
            '/vendors/switchery/css/switchery.min',
            'pages/new_dashboard',
            
            '/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min',

            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements'
        ),
        array('inline'=>false)); 
?>
<?php 
    $temperaturas_arreglo = array(1=>'Frio',2=>'Tibio',3=>'Caliente');
    $colores_temperaturas = array(1 => '#4fb7fe',2 => '#ffcb5e', 3=>'#ff5042');
?>



<!-- Modal para edicion de evento -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2" style="color:black">
                    <i class="fa fa-plus"></i>
                    EDITAR EVENTO
                </h4>
            </div>
            <?= $this->Form->create('Event',array('url'=>array('action'=>'add','controller'=>'events')))?>
            <div class="modal-body">
                <div class="input-group">
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="nombre_evento" class="form-control-label">Editar Evento*</label>
                    </div>
                    <?= $this->Form->input('id',array('type'=>'hidden','id'=>'id_edit'))?>
                    <?= $this->Form->input('nombre_evento',array('id'=>'nombre_evento_edit','class'=>'form-control','placeholder'=>'Nuevo Evento','div'=>'col-md-9 m-t-15','label'=>false,))?>
                    <div class="col-xl-3 text-xl-left m-t-15",>
                        <label for="lugar" class="form-control-label">Lugar</label>
                    </div>
                    <?= $this->Form->input('direccion',array('id'=>'direccion_edit','class'=>'form-control','placeholder'=>'Lugar','div'=>'col-md-6 m-t-15','label'=>false,))?>

                    <?php 
                        $colores = array(4=>'Llamada',3=>'Mail',5=>'Visita');
                    ?>
                    
                    <?= $this->Form->input('color',array('id'=>'color_edit','empty'=>'Tipo de evento','class'=>'form-control','type'=>'select','options'=>$colores,'div'=>'col-md-3 m-t-15','label'=>false,))?>

                    <div class="input-group">
                    <div class="col-lg-3 text-xl-left m-t-15">
                        <label for="Del" class="form-control-label">Del</label>
                    </div>
                    <?php
                        $hours=array();
                        for($i=0;$i<24;$i++){
                          $hours[$i]=  str_pad($i,2,'0',STR_PAD_LEFT);
                        }

                        $ms=array();
                        for($i=0;$i<60;$i++){
                          $ms[$i]=str_pad($i,2,'0',STR_PAD_LEFT);
                        }
                    ?>

                    <?= $this->Form->input('fi',array('id'=>'fi_edit','class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
                    <?= $this->Form->input('hi',array('id'=>'hi_edit','class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','empty'=>'HH','options'=>$hours))?>

                    <div class="col-lg-1 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">:</label>
                    </div>
                    <?= $this->Form->input('mi',array('id'=>'mi_edit','class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'empty'=>'MM','type'=>'select','options'=>$ms))?>
                    </div>
                    <div class="input-group">
                    <div class="col-lg-3 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">Al</label>
                    </div>
                    <?= $this->Form->input('ff',array('id'=>'ff_edit','class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
                    <?= $this->Form->input('hf',array('id'=>'hf_edit','class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'empty'=>'HH','type'=>'select','options'=>$hours))?>

                    <div class="col-lg-1 text-xl-left m-t-15">
                        <label for="lugar" class="form-control-label">:</label>
                    </div>
                    <?= $this->Form->input('mf',array('id'=>'mf_edit','class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'empty'=>'MM','type'=>'select','options'=>$ms))?>
                    </div>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="recordatorio" class="form-control-label">Recordatorio 1</label>
                    </div>
                    <?php $recordatorios = array(1=>'A la hora',2=>'15 minutos antes',3=>'30 minutos antes',4=>'1 hora antes',5=>'2 horas antes',6=>'6 horas antes',7=>'12 horas antes',8=>'1 día antes',9=>'2 días antes')?>
                    <?= $this->Form->input('recordatorio_1',array('onchange'=>'javascript:validar2()','type'=>'select','class'=>'form-control','empty'=>'Sin recordatorio','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$recordatorios))?>
                    <script>
                        function validar2(){
                            if (document.getElementById('EventRecordatorio1').value!=""){
                                document.getElementById('recordatorio2').style.display="";
                            }else{
                                document.getElementById('recordatorio2').style.display="none";
                            }
                        }
                    </script>
                    <div id="recordatorio2" style="display:none">
                        <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="recordatorio" class="form-control-label">Recordatorio 2</label>
                        </div>
                        <?= $this->Form->input('recordatorio_2',array('type'=>'select','class'=>'form-control','empty'=>'Sin recordatorio','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$recordatorios))?>
                    </div>
                    <div class="col-xl-3 text-xl-left m-t-15">
                        <label for="cliente" class="form-control-label">Cliente relacionado</label>
                    </div>
                    <?= $this->Form->input('cliente_id',array('id'=>'cliente_id_edit','type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin cliente asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$list_clientes))?>

                        
                    

                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="desarrollo" class="form-control-label">Desarrollo</label>
                        </div>
                    <?= $this->Form->input('desarrollo_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin desarrollo asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$desarrollos))?>
                    <div class="col-xl-3 text-xl-left m-t-15">
                            <label for="Inmueble" class="form-control-label">Propiedad</label>
                        </div>
                    <?= $this->Form->input('inmueble_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin inmueble asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$propiedades))?>
                    <!-- /btn-group -->
                </div>
                <!-- /input-group -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger float-xs-right" data-dismiss="modal">
                    Cerrar
                    <i class="fa fa-times"></i>
                </button>
                <button type="submit" class="btn btn-success pull-left" id="add-new-event" data-dismiss="modal" onclick="javascript:this.form.submit()">
                    <i class="fa fa-pencil"></i>
                    EDITAR EVENTO
                </button>
            </div>
            <?= $this->Form->end()?>
        </div>
    </div>
</div>

<!-- Fin de modal Edicion evento -->
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            MI AGENDA
                        </h4>
                        <?php echo $this->Session->flash(); ?>
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="col-lg-6 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Mis siguientes eventos
                        </div>
                        <div class="card-block padding-body view_user_cal">
                            <div class="list-group" style="overflow-y: scroll; height:200px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat; font-size: 1.2em;">
                                
                                <!-- id,nombre, direccion, fecha_inicio, hora_inicio, minuto_inicio, fecha_fin, hora_fin, minuto_fin, cliente, inmueble, desarrollo,color -->
                                <?php foreach ($eventos as $proximo):?>
                                    <?php
                                        if (!isset($proximo['Event']['inmueble_id'])) {
                                            $inmueble_id = 0;
                                          }else{
                                            $inmueble_id = $proximo['Event']['inmueble_id'];
                                          }

                                          if (!isset($proximo['Event']['desarrollo_id'])) {
                                            $desarrollo_id = 0;
                                          }else{
                                            $desarrollo_id = $proximo['Event']['desarrollo_id'];
                                          }
                                    ?>
                                    
                                    <div class="tag tag-pill tag-primary float-xs-right">
                                        <a  href="#" data-toggle="modal" data-target="#myModal2" id="target-modal" onclick="editEvent(
                                            <?= $proximo['Event']['id'].
                                                ",'".$proximo['Event']['nombre_evento']."'".
                                                ",'".$proximo['Event']['direccion']."'".
                                                ",'".date('d-m-Y',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                                ",'".date('H',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                                ",'".date('i',  strtotime($proximo['Event']['fecha_inicio']))."'".
                                                ",'".date('d-m-Y', strtotime($proximo['Event']['fecha_fin']))."'".
                                                ",'".date('H', strtotime($proximo['Event']['fecha_fin']))."'".
                                                ",'".date('i',  strtotime($proximo['Event']['fecha_fin']))."'".
                                                ",".$proximo['Event']['cliente_id'].
                                                ",".$inmueble_id.
                                                ",".$desarrollo_id.
                                                ",".$proximo['Event']['color']

                                            ?>
                                        )" title ="Editar evento" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                                    </div>
                                    
                                    
                                    <div class="tag tag-pill tag-danger float-xs-right"><?= $this->Html->link('<i class="fa fa-close"></i>',array('controller'=>'events','action'=>'cerrar',$proximo['Event']['id'],3),array('escape'=>false, 'title'=>'Da clic si el evento se ha cancelado', 'data-toggle'=>'tooltip'))?></div>

                                    <div class="tag tag-pill tag-success float-xs-right"><?= $this->Html->link('<i class="fa fa-check"></i>',array('controller'=>'events','action'=>'cerrar',$proximo['Event']['id'],2),array('escape'=>false, 'title'=>'Da clic si el evento se ha registrado con exito', 'data-toggle'=>'tooltip'))?></div>

                                    <div class="tag tag-pill tag-primary float-xs-right"><?= date('d/M/Y \a \l\a\s H:i',  strtotime($proximo['Event']['fecha_inicio']))?></div>
                                    
                                    <?= $proximo['Event']['nombre_evento']?><br>
                                
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 m-t-10">
                    <div class="card">
                        <?= $this->Form->create('User',array('url'=>array('controller'=>'Users','action'=>'notas')));?>  
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Mis Notas
                            <div style="float:right">
                                <?= $this->Form->submit('Guardar Notas')?>
                            </div>
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="content">
                                        
                                        <div class="notes" contenteditable="false" style="overflow-y: scroll; height:200px !important">
                                            <div>
                                                <?= $this->Form->input('texto',array('id'=>'tinymce_full','value'=>$this->Session->read('CuentaUsuario.CuentasUser.notas'),'label'=>false,'type'=>'textarea','style'=>'background-color: transparent; border: 0;width:100%'))?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->end()?>
                    </div>
                </div>
<!--                <div class="col-lg-6 m-t-10">
                    <div class="card">
                        <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                            Tareas
                        </div>
                        <div class="card-block cards_section_margin">
                            <div class="row">
                                <div class="col-lg-12">
                                            <div class="row">
                                                <div class="todo_section">
                                                    <form class="list_of_items">
                                                        <div class="todolist_list showactions">
                                                            <div class="col-xs-9 nopad custom_textbox1">
                                                                <div class="todo_primarybadge"></div>
                                                                <div class="todoitemcheck checkbox-custom">
                                                                    <input type="checkbox" class="striked large"/>
                                                                </div>
                                                                <div class="todotext todoitem todo_width">Realizar las llamadas</div>
                                                            </div>
                                                            <div class="col-xs-3  showbtns todoitembtns">
                                                                <a href="#" class="todoedit">
                                                                    <span class="fa fa-pencil"></span>
                                                                </a>
                                                                <span class='dividor'>|</span>
                                                                <a href="#" class="tododelete redcolor">
                                                                    <span class="fa fa-trash"></span>
                                                                </a>
                                                            </div>
                                                            <span class="seperator"></span>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form id="main_input_box" class="form-inline">
                                                    <div class="input-group todo">
                                                            <span class="input-group-btn">
                                                            <a class="btn btn-primary" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-contentwrapper=".mycontent" id="btn_color" data-badge="todo_mintbadge">Color&nbsp;&nbsp; <i
                                                                    class="fa fa-caret-right"> </i></a>
                                                            </span>
                                                        <input id="custom_textbox" name="Item" type="text" required
                                                               placeholder="Escribir nota"
                                                               class="input-md form-control" size="75"/>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="mycontent">
                                                <div class="border_color bg-danger border_danger"
                                                     data-color="btn-danger" data-badge="bg-danger"></div>
                                                <div class="border_color bg-primary border_primary"
                                                     data-color="btn-primary" data-badge="bg-primary"></div>
                                                <div class="border_color bg-info border_info" data-color="btn-info"
                                                     data-badge="bg-info"></div>
                                                <div class="border_color bg-mint border_mint" data-color="btn-mint"
                                                     data-badge="bg-mint"></div>
                                            </div>
                                        </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
    
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            CLIENTES
                        </h4>
<!--                        <pre><?= var_dump($temperaturas)?></pre>-->
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-4 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    CLIENTES ACTIVOS
                                </div>
                                <a href="../clientes/index/1">
                                    <div class="card-block cards_section_margin">
                                        <div class="row" style=" margin-top: -10%">
                                            <div class="col-lg-12">
                                                <div class="bg-success top_cards">
                                                    <div class="row icon_margin_left">
                                                        <div class="col-lg-2 icon_padd_left">
                                                            <div class="float-xs-left">
                                                                <span class="fa-stack fa-sm">
                                                                    <i class="fa fa-circle fa-stack-2x"></i>
                                                                    <i class="fa fa-check fa-stack-1x fa-inverse text-success visit_icon"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-9 icon_padd_right">
                                                            <div class="float-xs-right cards_content">
                                                                <span class="number_val" id="visitors_count"><?= $clientes?></span>
                                                                <br/>
                                                                <span class="card_description">Activos</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                      
                                            </div>
                                        </div>
                                    </div>
                                </a>
                        </div>
                    </div>
                        <div class="col-lg-4 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                   CLIENTES RETRASADOS
                                </div>
                                <a href="../clientes/index/2">
                                    <div class="card-block cards_section_margin">
                                        <div class="row" style=" margin-top: -10%">
                                            <div class="col-lg-12">
                                                <div class="bg-warning top_cards">
                                                     <div class="row icon_margin_left">
                                                         <div class="col-lg-5 icon_padd_left">
                                                             <div class="float-xs-left">
                                                                 <span class="fa-stack fa-sm">
                                                                     <i class="fa fa-circle fa-stack-2x"></i>
                                                                     <i class="fa fa-clock-o fa-stack-1x fa-inverse text-info visit_icon"></i>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                         <div class="col-lg-7 icon_padd_right">
                                                             <div class="float-xs-right cards_content">
                                                                <span class="number_val" id="visitors_count"><?= $atrasados?></span>
                                                                <br/>
                                                                <span class="card_description">Atrasados</span>
                                                            </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                        </div>
                    </div>
                    <div class="col-lg-4 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    CLIENTES SIN SEGUIMIENTO
                                </div>
                                <a href="../clientes/index/3">
                                    <div class="card-block cards_section_margin">
                                        <div class="row" style=" margin-top: -10%">
                                            <div class="col-lg-12">
                                                <div class="bg-error top_cards">
                                                     <div class="row icon_margin_left">
                                                         <div class="col-lg-5 icon_padd_left">
                                                             <div class="float-xs-left">
                                                                 <span class="fa-stack fa-sm">
                                                                     <i class="fa fa-circle fa-stack-2x"></i>
                                                                     <i class="fa fa-warning fa-stack-1x fa-inverse text-warning revenue_icon"></i>
                                                                 </span>
                                                             </div>
                                                         </div>
                                                         <div class="float-xs-right cards_content">
                                                                <span class="number_val" id="visitors_count"><?= $no_atendidos?></span>
                                                                <br/>
                                                                <span class="card_description">No Atendidos</span>
                                                         </div>
                                                     </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Temperaturas de clientes
                                </div>
                                <div class="card-block" >
                                    <div class="card-block" >
                                        <div id="donut" class="donut"></div>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                        <div class="col-lg-6 m-t-10" >
                            <div class="card" style="height:403px">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Clientes por contactar 
                                </div>
                                <div class="card-block" >
                                    <div class="card-block twitter_section" style="overflow-y: scroll; height:200px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                                    <?php $tipo_contacto = array(1=>'') ?>   
                                    <ul id="nt-example1">
                                        <?php foreach($clientes_contactar as $cliente):?>
                                        <li>
                                            <div class="row">
                                                <div class="col-xs-2 col-lg-3 col-xl-2">
                                                    <i class="fa fa-phone fa-4x"></i>
                                                </div>
                                                <div class="col-xs-10 col-lg-9 col-xl-10">
                                                    <span class="name"><?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?></span> <span
                                                        class="time"><?= $cliente['Event']['fecha_inicio']?></span>
                                                    <br>
                                                    <span class="msg"><?= $cliente['Event']['nombre_evento']?></span>
                                                </div>
                                            </div>
                                            <hr>
                                        </li>
                                        <?php endforeach;?>
                                    </ul>
                                </div>
                                </div>
                                
                        </div>
                    </div>

        </div>
    </div>       
            
</div>
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            INMUEBLES
                        </h4>
<!--                        <pre><?= var_dump($temperaturas)?></pre>-->
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                         <div class="col-lg-12 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    BITÁCORA DE CAMBIOS
                                </div>
                                <div class="card-block" >
                                    <div class="card-header">
                                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                            <li class="nav-item">
                                                <a class="nav-link active" href="#tab1" data-toggle="tab">Precios</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#tab2" data-toggle="tab">Estados</a>
                                            </li>
                                         </ul>
                                    </div>
                                    <div class="card-block">
                                        
                                        <div class="tab-content text-justify">
                                            <div class="tab-pane active" id="tab1">
                                                <div class="list-group m-t-35">
                                                    <ul class="list-group lists_margin_bottom">
                                                        <li class="list-group-item">
                                                            <div class="form-group">
                                                            <div class="row">
                                                            <div class="col-xs-2">
                                                                Imagen
                                                            </div>
                                                            <div class="col-xs-3">
                                                                 Propiedad
                                                            </div>
                                                            <div class="col-xs-3">
                                                                Precio Anterior
                                                            </div>
                                                            <div class="col-xs-3">
                                                                Precio Nuevo
                                                            </div>
                                                            <div class="col-xs-1">
                                                                Variación
                                                            </div>
                                                            </div>
                                                            </div>
                                                            </li>
                                                            <?php foreach ($precios_inmuebles as $precio):?>
                                                            
                                                                <?php if (isset($precio['Precio'][1]['precio'])){?>
                                                                <li class="list-group-item">
                                                                    <div class="form-group">
                                                                        <div class="row">
                                                                            <div class="col-xs-2">
                                                                                <?= $this->Html->image($precio['FotoInmueble'][0]['ruta'],array('style'=>'max-height: 50px;'))?>
                                                                            </div>
                                                                            <div class="col-xs-3">
                                                                                 <?= $this->Html->link($precio['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$precio['Inmueble']['id']))?>
                                                                            </div>
                                                                            <?php $last_price = sizeof($precio['Precio'])-2?>
                                                                            <?php $final_price = sizeof($precio['Precio'])-1?>
                                                                            <div class="col-xs-3">
                                                                                <font style="color: red; text-decoration: line-through"><b>$<?= number_format($precio['Precio'][$last_price]['precio'],2)?></b></font>
                                                                            </div>
                                                                            <div class="col-xs-3">
                                                                                <b>$<?= number_format($precio['Precio'][$final_price]['precio'],2)?></b>&nbsp;
                                                                            </div>
                                                                            <div class="col-xs-1">
                                                                               
                                                                                <?php if ($precio['Precio'][$final_price]['precio']<$precio['Precio'][$last_price]['precio']){?>
                                                                                <i class="fa fa-arrow-circle-o-down fa-2x"></i>
                                                                                <?php }else{?>
                                                                                <i class="fa fa-arrow-circle-o-up fa-2x"></i>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php }?>
                                                            <?php endforeach;?>
                                                 </ul>
                                                </div>
                                                            
                                                        </div>
                                                        <div class="tab-pane" id="tab2">
                                                            <div class="list-group m-t-35">
                                        <ul class="list-group lists_margin_bottom">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    Imagen
                                                </div>
                                                <div class="col-xs-3">
                                                     Propiedad
                                                </div>
                                                <div class="col-xs-3">
                                                    Cambio
                                                </div>
                                                <div class="col-xs-3">
                                                    Fecha
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                
                                                <?php foreach ($cambios_inmuebles as $cambio):?>
                                                <li class="list-group-item">
                                                    <div class="form-group">
                                                    <div class="row">
                                                    <div class="col-xs-3">
                                                        <?= $this->Html->image($cambio['Inmueble']['FotoInmueble'][0]['ruta'],array('style'=>'max-height: 50px;'))?>
                                                    </div>
                                                    <div class="col-xs-3">
                                                          <?= $this->Html->link($cambio['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$cambio['Inmueble']['id']))?>
                                                    </div>
                                                    <div class="col-xs-3">
                                                          <?= $cambio['LogInmueble']['mensaje']?>
                                                    </div>
                                                    <div class="col-xs-3">
                                                        <?= date('d-m-y', strtotime($cambio['LogInmueble']['fecha']))?>
                                                    </div>
                                                    </div>
                                                    </div>
                                                </li>
                                                <?php endforeach;?>
                                            
                                     </ul>
                                    </div>
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    NUEVAS PROPIEDADES
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;" >
                                   <?php foreach ($nuevas as $nueva):?>
                                    <a href="../inmuebles/view/<?= $nueva['Inmueble']['id']?>">
                                    <div class="col-lg-4 gallery-border" style="padding: 5px">
                                        <figure class="imghvr-push-down">
                                            <?= $this->Html->image($nueva['FotoInmueble'][0]['ruta'],array('width'=>'100%','style'=>'height:100px'))?>
                                            <figcaption>
                                                <h5><?= $nueva['Inmueble']['titulo']?></h5>
                                                <p><b>Operación:</b><?= $nueva['Inmueble']['venta_renta']?></p>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    </a>
                                    <?php endforeach; ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    PROPIEDADES POR VENCER
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;" >
                                   <?php foreach ($due as $vence):?>
                                    <a href="../inmuebles/view/<?= $vence['Inmueble']['id']?>">
                                    <div class="col-lg-4 gallery-border" style="padding: 5px">
                                        <figure class="imghvr-push-down">
                                            <?= $this->Html->image($vence['FotoInmueble'][0]['ruta'],array('width'=>'100%','style'=>'height:100px'))?>
                                            <figcaption>
                                                <h5><?= $vence['Inmueble']['titulo']?></h5>
                                                <p><b>Vence:</b><?= date('d/m/y',strtotime($vence['Inmueble']['due_date']))?></p>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    PROPIEDADES DESTACADAS
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                                   <?php foreach ($destacadas as $destacada):?>
                                    <a href="../inmuebles/view/<?= $destacada['Inmueble']['id']?>">
                                    <div class="col-lg-4 gallery-border" style="padding: 5px">
                                        <figure class="imghvr-push-down">
                                            <?= $this->Html->image($destacada['FotoInmueble'][0]['ruta'],array('width'=>'100%','style'=>'height:100px'))?>
                                            <figcaption>
                                                <h5><?= $destacada['Inmueble']['titulo']?></h5>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    PROPIEDADES DADAS BAJA
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                                   <?php foreach ($bajas as $baja):?>
                                    <a href="../inmuebles/view/<?= $baja['Inmueble']['id']?>">
                                    <div class="col-lg-4 gallery-border" style="padding: 5px">
                                        <figure class="imghvr-push-down">
                                            <?php 
                                                if (isset($baja['FotoInmueble'][0]['ruta'])){
                                                   echo $this->Html->image($baja['FotoInmueble'][0]['ruta'],array('width'=>'100%','style'=>'height:100px'));
                                                }else{
                                                   echo $this->Html->image('inmueble_no_photo.png',array('width'=>'100%','style'=>'height:100px'));
                                                }
                                                
                                            ?>
                                            <figcaption>
                                                <h5><?= $baja['Inmueble']['titulo']?></h5>
                                            </figcaption>
                                        </figure>
                                    </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                       
                        
                        

        </div>
    </div>       
            
            </div>
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-building" aria-hidden="true"></i>
                            DESARROLLOS
                        </h4>
<!--                        <pre><?= var_dump($temperaturas)?></pre>-->
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    NUEVOS DESARROLLOS
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;">
                                   <?php foreach ($nuevos_desarrollos as $nuevo):?>
                                    <a href="../desarrollos/view/<?= $nuevo['Desarrollo']['id']?>">
                                        <div class="col-lg-4 gallery-border" style="padding: 5px">
                                            <figure class="imghvr-push-down">
                                                <?= $this->Html->image($nuevo['FotoDesarrollo'][0]['ruta'],array('style'=>'width:100%; height:100px'))?>
                                                <figcaption>
                                                    <h5><?= $nuevo['Desarrollo']['nombre']?></h5>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    DESARROLLOS DESTACADOS
                                </div>
                                <div class="card-block" style="overflow-y: scroll; height:400px !important; background-image: url('../img/fondo_trans.jpg'); background-size: auto 100%; background-position: center; background-repeat:no-repeat;" >
                                   <?php foreach ($desarrollos_destacados as $destacado):?>
                                    <a href="../desarrollos/view/<?= $destacado['Desarrollo']['id']?>">
                                        <div class="col-lg-4 gallery-border" style="padding: 5px">
                                            <figure class="imghvr-push-down">
                                                <?= $this->Html->image($destacado['FotoDesarrollo'][0]['ruta'],array('style'=>'width:100%; height:100px'))?>
                                                <figcaption>
                                                    <h5><?= $destacado['Desarrollo']['nombre']?></h5>
                                                </figcaption>
                                            </figure>
                                        </div>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        
                        

        </div>
    </div>       
            
</div>
</div>
<?php 
    echo $this->Html->script([
        
        
        
        '/vendors/flotchart/js/jquery.flot',
        '/vendors/flotchart/js/jquery.flot.resize',
        '/vendors/flotchart/js/jquery.flot.stack',
        '/vendors/flotchart/js/jquery.flot.time',
        '/vendors/flotspline/js/jquery.flot.spline.min',
        '/vendors/flotchart/js/jquery.flot.categories',
        '/vendors/flotchart/js/jquery.flot.pie',
        '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        
        '/vendors/holderjs/js/holder',
        
        '/vendors/slimscroll/js/jquery.slimscroll.min',
        '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
        '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
        '/vendors/moment/js/moment.min',
        '/vendors/fullcalendar/js/fullcalendar.min',
        'pluginjs/calendarcustom',
        'pages/mini_calendar',
        '/vendors/daterangepicker/js/daterangepicker',
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        
        '/vendors/raphael/js/raphael-min',
        '/vendors/d3/js/d3.min',
        '/vendors/c3/js/c3.min',
        '/vendors/toastr/js/toastr.min',
        '/vendors/switchery/js/switchery.min',
        '/vendors/jquery_newsTicker/js/newsTicker',
        '/vendors/countUp.js/js/countUp.min',
        
        '/vendors/tinymce/js/tinymce.min',

        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/chosen/js/chosen.jquery',
        '/vendors/jasny-bootstrap/js/inputmask',
        
        
        //'pages/new_dashboard'
               
    ], array('inline'=>false));
?>
<?php

$this->Html->scriptStart(array('inline' => false));

?>
'use strict';

function editEvent(id,nombre, direccion, fecha_inicio, hora_inicio, minuto_inicio, fecha_fin, hora_fin, minuto_fin, cliente, inmueble, desarrollo,color) {
    document.getElementById('id_edit').value = id;
    document.getElementById('nombre_evento_edit').value = nombre;
    document.getElementById('direccion_edit').value = direccion;
    document.getElementById('fi_edit').value =  fecha_inicio;
    if (hora_inicio === "00") hora_inicio = "0";
    document.getElementById('hi_edit').value =  hora_inicio;
    if (minuto_inicio === "00") minuto_inicio = "0";
    document.getElementById('mi_edit').value =  minuto_inicio;
    document.getElementById('ff_edit').value =  fecha_fin;
    if (hora_fin === "00") hora_fin = "0";
    document.getElementById('hf_edit').value =  hora_fin;
    if (minuto_fin === "00") minuto_fin = "0";
    document.getElementById('mf_edit').value =  minuto_fin;
    document.getElementById('cliente_id_edit').value = cliente;
    $('#EventInmuebleId').val(inmueble);
    $('#EventDesarrolloId').val(desarrollo); 
    $('#color_edit').val(color);
    /* Actualizar evento chosen en el input (Asignar valor con anterioridad) */
    $('.chzn-select').trigger('chosen:updated');

}

$(document).ready(function () {
$('[data-toggle="tooltip"]').tooltip(); 


$(".chzn-select").chosen({allow_single_deselect: true});

$('.fecha').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true,
    orientation:"bottom"
});


tinymce.init({
        selector: "#tinymce_full",
        toolbar: false,
        menubar: false,
        statusbar:false,
        body_class: 'transparent'
        
        
        
    });

//donut

    
    var datax = [
    <?php foreach($temperaturas as $temperatura):?>
        {
            label:"<?= $temperatura[0]['COUNT(temperatura)']." ".$temperaturas_arreglo[$temperatura['clientes']['temperatura']]?>",
            data: <?= $temperatura[0]['COUNT(temperatura)']?>,
            color:'<?= $colores_temperaturas[$temperatura['clientes']['temperatura']]?>'
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
            show: true
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s"
        }

    });
    
    //Calendar
    
    
});



<?php $this->Html->scriptEnd();

?>
