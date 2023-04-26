<?= $this->Html->css(
        array(
            '/vendors/swiper/css/swiper.min',
//            'pages/general_components',
            
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
            
            '/vendors/checkbox_css/css/checkbox.min',
            'pages/radio_checkbox',
            
            '/vendors/datepicker/css/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
            'pages/colorpicker_hack',


            '/vendors/inputlimiter/css/jquery.inputlimiter',
            '/vendors/chosen/css/chosen',
            '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements'
            
           
            
            
        ),
        array('inline'=>false)); 
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Clientes
                        </h4>
                        
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel1" style="color:black">
                                        <i class="fa fa-phone-square"></i>
                                        Registrar Llamada
                                    </h4>
                                </div>
                                <?= $this->Form->create('Event',array('url'=>array('action'=>'add_llamada','controller'=>'events')))?>
                                <div class="modal-body">
                                    
                                    <div class="input-group">
                                        <?= $this->Form->input('nombre_evento',array('type'=>'hidden','value'=>'Llamada a Cliente:'.$cliente['Cliente']['nombre']))?>
                                        <?= $this->Form->input('color',array('type'=>'hidden','value'=>4))?>
                                        <div class="checkbox radio_Checkbox_size2">
                                            <label>
                                                <input type="checkbox" id="campo_fecha" onchange="javascript:showFecha()">
                                                <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                                Programar llamada en otra fecha
                                            </label>
                                        </div>
                                        <script>
                                            function showFecha(){
                                                if (document.getElementById('campo_fecha').checked){
                                                    document.getElementById('fecha').style.display = '';
                                                }else{
                                                    document.getElementById('fecha').style.display = 'none';
                                                }
                                            }
                                        </script>
                                        <div id="fecha" style="display:none">
                                        <div class="input-group">
                                        <div class="col-lg-3 text-xl-left m-t-15">
                                            <label for="Del" class="form-control-label">Fecha de Llamada</label>
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
                                        <?= $this->Form->input('fi',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('hi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$hours))?>
                                        <div class="col-lg-1 text-xl-left m-t-15">
                                            <label for="lugar" class="form-control-label">:</label>
                                        </div>
                                        <?= $this->Form->input('mi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$ms))?>
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
                                        </div>
                                        <?= $this->Form->input('cliente_id',array('type'=>'hidden','value'=>$cliente['Cliente']['id']))?>
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                                <label for="desarrollo" class="form-control-label">Desarrollo</label>
                                            </div>
                                        <?= $this->Form->input('desarrollo_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin desarrollo asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$desarrollos))?>
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                                <label for="Inmueble" class="form-control-label">Propiedad</label>
                                            </div>
                                        <?= $this->Form->input('inmueble_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin inmueble asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$inmuebles))?>
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
                                        <i class="fa fa-plus"></i>
                                        Registrar Llamada
                                    </button>
                                </div>
                                <?= $this->Form->end()?>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-hidden="true" >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel2" style="color:black">
                                        <i class="fa fa-plus"></i>
                                        Agregar nuevo evento
                                    </h4>
                                </div>
                                <?= $this->Form->create('Event',array('url'=>array('action'=>'add','controller'=>'events')))?>
                                <div class="modal-body">
                                    <div class="input-group">
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                            <label for="nombre_evento" class="form-control-label">Nuevo Evento*</label>
                                        </div>
                                        <?= $this->Form->input('nombre_evento',array('class'=>'form-control','placeholder'=>'Nuevo Evento','div'=>'col-md-9 m-t-15','label'=>false,))?>
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                            <label for="lugar" class="form-control-label">Lugar</label>
                                        </div>
                                        <?= $this->Form->input('direccion',array('class'=>'form-control','placeholder'=>'Lugar','div'=>'col-md-6 m-t-15','label'=>false,))?>
                                        <?php 
                                            $colores = array(4=>'Llamada',3=>'Mail',5=>'Visita');
                                        ?>
                                        <?= $this->Form->input('color',array('empty'=>'Tipo de evento','class'=>'form-control','type'=>'select','options'=>$colores,'div'=>'col-md-3 m-t-15','label'=>false,))?>
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
                                        <?= $this->Form->input('fi',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('hi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$hours))?>
                                        <div class="col-lg-1 text-xl-left m-t-15">
                                            <label for="lugar" class="form-control-label">:</label>
                                        </div>
                                        <?= $this->Form->input('mi',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$ms))?>
                                        </div>
                                        <div class="input-group">
                                        <div class="col-lg-3 text-xl-left m-t-15">
                                            <label for="lugar" class="form-control-label">Al</label>
                                        </div>
                                        <?= $this->Form->input('ff',array('class'=>'form-control fecha','placeholder'=>'dd-mm-yyyy','div'=>'col-md-4 m-t-15','label'=>false,))?>
                                        <?= $this->Form->input('hf',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$hours))?>
                                        <div class="col-lg-1 text-xl-left m-t-15">
                                            <label for="lugar" class="form-control-label">:</label>
                                        </div>
                                        <?= $this->Form->input('mf',array('class'=>'form-control','div'=>'col-md-2 m-t-15','label'=>false,'type'=>'select','options'=>$ms))?>
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

                                        <?= $this->Form->input('nombre_cliente',array('class'=>'form-control','div'=>'col-md-9 m-t-15','label'=>false, 'value'=>$cliente['Cliente']['nombre'], 'disabled'))?>
                                        
                                        <?= $this->Form->input('cliente_id',array('value'=>$cliente['Cliente']['id'], 'type'=>'hidden'))?>


                                        <div class="col-xl-3 text-xl-left m-t-15">
                                                <label for="desarrollo" class="form-control-label">Desarrollo</label>
                                            </div>
                                        <?= $this->Form->input('desarrollo_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin desarrollo asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$desarrollosA))?>
                                        
                                        <div class="col-xl-3 text-xl-left m-t-15">
                                            <label for="Inmueble" class="form-control-label">Propiedad</label>
                                        </div>
                                        <?= $this->Form->input('inmueble_id',array('type'=>'select','class'=>'form-control chzn-select','empty'=>'Sin inmueble asignado','div'=>'col-md-9 m-t-15','label'=>false,'options'=>$inmueblesA))?>
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
                                        <i class="fa fa-plus"></i>
                                        Crear Evento
                                    </button>
                                </div>
                                <?= $this->Form->end()?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo $this->Session->flash(); ?>
                            <?php 
                                                $activo = "width:50% !important;background-color:#1ec61e; color:white; width:100%";
                                                $inactivo = "width:50% !important;background-color:red; color:white";
                                                $neutral = "width:50% !important;background-color:orange; color:white";
                                                $style = ($cliente['Cliente']['status']=='Activo' ? $activo : ($cliente['Cliente']['status']=='Inactivo' ? $inactivo : $neutral));
                                            ?>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    <b><?php echo $cliente['Cliente']['nombre']?></b>
                                    <div style="float:right">
                                        <?= $this->Html->link('<i class="fa fa-edit fa-lg"></i>',array('action'=>'edit',$cliente['Cliente']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR CLIENTE','style'=>'color:white','escape'=>false))?>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            
                                            <h2 style="color:#4fb7fe">Información General</h2>
                                            <div style="<?= $style?>"><?php echo $cliente['Cliente']['status']?></div>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['telefono1']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['telefono2']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['telefono3']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-envelope"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['correo_electronico']?><br>   
                                            <font color="#4fb7fe">Tipo de cliente:</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['DicTipoCliente']['tipo_cliente']?><br>
                                            <font color="#4fb7fe">Etapa:</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['DicEtapa']['etapa']?><br>
                                            <font color="#4fb7fe">Línea de contacto:</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $cliente['DicLineaContacto']['linea_contacto']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-user"></i> Agente</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['User']['nombre_completo']?><br>

                                            <!-- Temperatura del cliente -->
                                            <?php $temp = array(1=>'Frio',2=>'Tibio',3=>'Caliente') ?>
                                            <font color="#4fb7fe";>Temperatura del cliente:</font>&nbsp; <?= $this->Html->link('<i class="fa fa-edit"></i>','javascript:showEdit()',array('escape'=>false))?> 
                                            &nbsp;&nbsp;
                                            <style>.chip{ padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block;}</style>
                                            <?php 
                                                switch ($cliente['Cliente']['temperatura']){
                                                    case 1:
                                                        echo "<div style='background-color: #00c0ef;' class='chip'>Frio</div>";
                                                        break;
                                                    case 2:
                                                        echo "<div style='background-color: yellow;' class='chip'>Tibio</div>";
                                                        break;
                                                    case 3:
                                                        echo "<div style='background-color: red;' class='chip'>Caliente</div>";
                                                        break;
                                                    default:
                                                        echo "<td>&nbsp;</td>";
                                                        break;
                                                }
                                            ?>
                                            <br>
                                            <div style="display: none;" id="form_temp" class="col-sm-12 col-lg-4">
                                                <?php 
                                                    echo $this->Form->create('Cliente',array('url'=>array('action'=>'cambio_temp','controller'=>'clientes')));
                                                    echo $this->Form->input('temperatura',  array('label'=>false,'type'=>'select','options'=>$temp,'default'=>$cliente['Cliente']['temperatura'], 'class'=>'form-control'));
                                                    echo $this->Form->hidden('id',array('label'=>false,'value'=>$cliente['Cliente']['id']));
                                                    echo $this->Form->input('Guardar',array('label'=>false,'type'=>'submit', 'class'=>'btn btn-primary m-t-5'));
                                                    echo $this->Form->end();
                                                ?>
                                            </div>
                                            <script>
                                                function showEdit(){
                                                    $("#form_temp").fadeIn();
                                                }
                                            </script>
                                        </div>
                                        <div class="col-lg-6">
                                            <h2 style="color:#4fb7fe">Seguimiento Rápido</h2>
                                            <div class="feed"style="overflow-y: scroll; height:200px !important">
                                                <ul>                                                            
                                                    <?php foreach ($agendas as $agenda):?>
                                                    <li>
                                                        <span>
                                                            <?php echo $this->Html->image($agenda['User']['foto'], array('class'=>'img-circle img-bordered-sm'))?>
                                                        </span>
                                                        <h5><font color="black"><?php echo $this->Html->link($agenda['User']['nombre_completo'],array('action'=>'view','controller'=>'users',$agenda['User']['id']))?></font></h5>
                                                        <p>
                                                            <?php echo $agenda['Agenda']['mensaje']?>
                                                        </p>
                                                        <i><?php echo $agenda['Agenda']['fecha']?></i>
                                                    </li>
                                                    <?php endforeach;?>
                                                </ul>
                                            </div>      
                                        </div>
                                        <div class="col-lg-12 m-t-15">
                                            <font color="#4fb7fe"><i class="fa fa-pencil"></i> Comentarios</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['comentarios']?><br>
                                        </div>
                                </div>
                                
                            </div>
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
                                    Indicadores de desempeño
                                </div>
                                <div class="row" style="padding:1%">
                                    <div class="col-lg-6">
                                        <div class="bg-success top_cards">
                                                <div class="row icon_margin_left">
                                                    <div class="col-lg-2 icon_padd_left">
                                                        <div class="float-xs-left">
                                                            <span class="fa-stack fa-sm">
                                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                                <i class="fa fa-envelope fa-stack-1x fa-inverse text-success visit_icon"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-9 icon_padd_right">
                                                        <div class="float-xs-right cards_content">
                                                            <span class="number_val" id="visitors_count"><?= $mails?></span>
                                                            <br/>
                                                            <span class="card_description">Emails
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-lg-6" >
                                        <div class="bg-info top_cards">
                                                 <div class="row icon_margin_left">
                                                     <div class="col-lg-5 icon_padd_left">
                                                         <div class="float-xs-left">
                                                             <a href="tel:<?= $cliente['Cliente']['telefono1']?>" style="color:white">
                                                             <span class="fa-stack fa-sm">
                                                                 <i class="fa fa-circle fa-stack-2x"></i>
                                                                 <i class="fa fa-phone fa-stack-1x fa-inverse text-info visit_icon"></i>
                                                             </span>
                                                             </a>
                                                         </div>
                                                     </div>
                                                     <div class="col-lg-7 icon_padd_right">
                                                         <div class="float-xs-right cards_content">
                                                             <span class="number_val" id="visitors_count"><?= $llamadas?></span>
                                                             <br/>
                                                             <span class="card_description">Llamadas</span>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                    </div>
                                </div>
                                <div class="row" style="padding:1%">
                                    <div class="col-lg-6">
                                        <div class="bg-warning top_cards">
                                                 <div class="row icon_margin_left">
                                                     <div class="col-lg-5 icon_padd_left">
                                                         <div class="float-xs-left">
                                                             <span class="fa-stack fa-sm">
                                                                 <a href="#" data-toggle="modal" data-target="#myModal2" style="color:white">
                                                                 <i class="fa fa-circle fa-stack-2x"></i>
                                                                 <i class="fa fa-location-arrow fa-stack-1x fa-inverse text-warning revenue_icon"></i>
                                                                 </a>
                                                             </span>
                                                         </div>
                                                     </div>
                                                     <div class="col-lg-7 icon_padd_right">
                                                         <div class="float-xs-right cards_content">
                                                             <span class="number_val" id="revenue_count"><?= $visitas?></span>
                                                             <br/>
                                                             <span class="card_description">Visitas</span>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="bg-mint top_cards">
                                                <div class="row icon_margin_left">
                                                    <div class="col-lg-5 icon_padd_left">
                                                        <div class="float-xs-left">
                                                            <a href="#leads" style="color:white">
                                                            <span class="fa-stack fa-sm">
                                                                <i class="fa fa-circle fa-stack-2x"></i>
                                                                <i class="fa fa-home  fa-stack-1x fa-inverse text-mint sub"></i>
                                                            </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7 icon_padd_right">
                                                        <div class="float-xs-right cards_content">
                                                            <span class="number_val" id="subscribers_count"><?= sizeof($cliente['Lead'])?></span>
                                                            <br/>
                                                            <span class="card_description">Posibles</span>
                                                        </div>
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
                                    Seguimiento Rápido
                                </div>
                                <div class="row" style="padding:1%">
                                    <div class="col-lg-12">
                                        <div class="user-block">
                                            <?php echo $this->Form->create('Agenda',array('url'=>array('controller'=>'Agendas','action'=>'add')))?>
                                            <?php 
                                                if ($this->Session->read('Permisos.Group.id')==3){
                                                    echo $this->Form->checkbox('asesoria')." Solicitar apoyo del gerente.";
                                                }else{
                                                    echo $this->Form->checkbox('asesoria')." Notificar por mail a asesor.";
                                                }

                                            ?>
                                            <?php echo $this->Form->input('mensaje',array('class'=>'form-control input-sm','placeholder'=>'Escribe un mensaje','label'=>false))?>

                                            <?php echo $this->Form->input('user_id',array('value'=>$this->Session->read('Auth.User.id'),'type'=>'hidden'))?>
                                            <?php echo $this->Form->input('lead_id',array('value'=>0,'type'=>'hidden'))?>
                                            <?php echo $this->Form->input('fecha',array('value'=>date("Y-m-d H:i:s"),'type'=>'hidden'))?>
                                            <?php echo $this->Form->input('cliente_id',array('value'=>$cliente['Cliente']['id'],'type'=>'hidden'))?>
                                            <?php echo $this->Form->button('Guardar mensaje',array('type'=>'submit','class'=>'btn btn-primary m-t-5'))?>
                                            <?php echo $this->Form->end()?> 
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="card m-t-20">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Agregar Evento
                                </div>
                                <div class="row" style="padding:1%">
                                    <div class="col-lg-12">
                                        <div class="user-block">
                                             <a  href="#" class="btn btn-primary m-t-5" data-toggle="modal" data-target="#myModal2"><i class="fa fa-plus"></i> Agregar Evento
                                             </a>
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
                    <div class="row" id="leads">
                        <div class="col-lg-12 m-t-10">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Oportunidades de Venta
                                </div>
                            <div class="card m-t-35">
                                <div class="card-header bg-white">
                                    <ul class="nav nav-tabs card-header-tabs float-left">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#tab1" data-toggle="tab">Inmuebles Interesados</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab2" data-toggle="tab">Desarrollos Interesados</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab3" data-toggle="tab">Buscar Propiedad para cliente</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#tab4" data-toggle="tab">Recomendaciones Inmosystem</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content text-justify">
                                        <div class="tab-pane active" id="tab1">
                                            <?php 
                                                echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar')));
                                                $i = 1;
                                                echo $this->Form->button('Reenviar Propiedades',array('type'=>'submit','class'=>'btn btn-primary'));
                                             ?>
                                            <div class="row m-t-30">
                                                <?php foreach ($leads as $inmueble):?>
                                                     <div class="col-md-3">
                                                         <?php 
                                                             $claseB= ($inmueble['Lead']['status']=="Abierto" ? "hsl(39, 100%, 50%)" : ($inmueble['Lead']['status']=="Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                         ?>
                                                         <div style="background-color: <?= $claseB?>; color:white">
                                                             <?php echo $this->Form->checkbox('seleccionar'.$i)?>
                                                             <?php echo $this->Form->hidden('inmueble_id'.$i,array('value'=>$inmueble['Inmueble']['id']))?>
                                                             <?php 
                                                                 if ($inmueble['Inmueble']['premium']==1){
                                                                     echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                 }else{
                                                                     echo $this->Html->link($inmueble['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                 }
                                                             ?>
                                                             <div style="float: right; color:white">
                                                                 <?php
                                                                     switch ($inmueble['Lead']['status']):
                                                                         case("Abierto"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Cerrado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                         break;
                                                                         case("Cerrado"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             echo $this->Html->link('<i class="fa fa-tag"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Abierto",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'REABRIR INTERÉS','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                             break;
                                                                         case("Aprobado"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Cerrado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                         break;
                                                                     endswitch;
                                                                 ?>
                                                             </div>
                                                         </div> 
                                                         <?php 
                                                             if (isset($inmueble['Inmueble']['FotoInmueble'][0]['ruta'])){
                                                                 echo $this->Html->link($this->Html->image($inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('width'=>'100%','height:170px','alt'=>$inmueble['Inmueble']['FotoInmueble'][0]['descripcion'])),$inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                             }else{
                                                                 echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%','height'=>'170px'));
                                                             }
                                                         ?>
                                                         <div class="col-md-12" style="background-color:rgb(29, 131, 143); color:white;">
                                                                 <b><?= $tipo_propiedad[$inmueble['Inmueble']['dic_tipo_propiedad_id']] ?></b>
                                                                 <div style="float:right">
                                                                     <b><?= "$".  number_format($inmueble['Inmueble']['precio'],2)?></b>
                                                                 </div>
                                                         </div>
                                                         <div class="col-md-12" style="background-color:rgb(29, 131, 143); color:white;">

                                                                 <b><?= $inmueble['Inmueble']['venta_renta'] ?></b>

                                                         </div>
                                                         <div class="col-md-12">
                                                             <div class="row ">
                                                                 <div class=" col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('m2.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class=" col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['construccion']."m2"?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('autos.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['estacionamiento_techado']?>
                                                                 </div>
                                                             </div>
                                                             <div class="row ">
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('banios.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['banos']?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('recamaras.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['recamaras']?>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                     </div>
                                                 <?php $i++;?>
                                                 <?php endforeach;?>
                                                 <?php 
                                                    echo $this->Form->hidden('contador',array('value'=>$i));
                                                    echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                                                    echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                                                  ?>
                                                  <?= $this->Form->end()?> 
                                            </div>
                                        </div>
                                        <div class="tab-pane active" id="tab2">
                                            <?php 
                                                echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar_desarrollos')));
                                                $j = 1;
                                                echo $this->Form->button('Reenviar Desarrollos',array('type'=>'submit','class'=>'btn btn-primary'));
                                             ?>
                                            <div class="row m-t-30">
                                                <?php foreach ($desarrollos as $desarrollo):?>
                                                     <div class="col-md-3">
                                                         <?php 
                                                             $claseB= ($desarrollo['Lead']['status']=="Abierto" ? "hsl(39, 100%, 50%)" : ($desarrollo['Lead']['status']=="Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                         ?>
                                                         <div style="background-color: <?= $claseB?>; color:white">
                                                             <?php echo $this->Form->checkbox('seleccionar'.$j)?>
                                                             <?php echo $this->Form->hidden('desarrollo_id'.$j,array('value'=>$desarrollo['Desarrollo']['id']))?>
                                                             <?php 
                                                                        echo $this->Html->link($desarrollo['Desarrollo']['nombre'],array('action'=>'view','controller'=>'desarrollos',$desarrollo['Desarrollo']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                    ?>
                                                             <div style="float: right; color:white">
                                                                 <?php
                                                                     switch ($desarrollo['Lead']['status']):
                                                                         case("Abierto"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                         break;
                                                                         case("Cerrado"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             echo $this->Html->link('<i class="fa fa-tag"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Abierto",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'REABRIR INTERÉS','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                             break;
                                                                         case("Aprobado"):
                                                                             echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                             //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $inmueble['Lead']['id'],"Aprobado",$inmueble['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                         break;
                                                                     endswitch;
                                                                 ?>
                                                             </div>
                                                         </div> 
                                                         <?php 
                                                                if (isset($desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'])){
                                                                    echo $this->Html->link($this->Html->image($desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'],array('width'=>'100%','alt'=>$desarrollo['Desarrollo']['FotoDesarrollo'][0]['descripcion'])),$desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                }else{
                                                                    echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                }
                                                            ?>
                                                         <div class="col-md-12" style="background-color:rgb(29, 131, 143); color:white;">
                                                                <font color="#4FB7FE">DISPONIBILIDAD</font>
                                                                    <?php echo $desarrollo['Desarrollo']['disponibilidad']?><br>
                                                                <font color="#4FB7FE">TIPO DE DESARROLLO</font>
                                                                    <?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?><br>
                                                                <font color="#4FB7FE">FECHA DE ENTREGA</font>
                                                                    <?php echo $desarrollo['Desarrollo']['fecha_entrega']?>
                                                         </div>

                                                     </div>
                                                 <?php $j++;?>
                                                <?php endforeach;?>    
                                                 <?php 
                                                    echo $this->Form->hidden('contador',array('value'=>$i));
                                                    echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                                                    echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                                                  ?>
                                                  <?= $this->Form->end()?> 
                                            </div>
                                        </div>
                            
                                        
                                        <div class="tab-pane" id="tab3">
                                            <h4 class="card-title">Tab 3</h4>
                                            <p class="card-text">
                                                
                                            <div class="card-block" >
                                            <div class="row">       
                                            <?php echo $this->Form->create('Lead',array('url'=>array('controller'=>'leads','action'=>'add'),'class'=>'form-horizontal'))?>
                                            <?php 

                                                      $venta = array('Venta'=>'Venta','Renta'=>'Renta','Venta / Renta' =>'Venta / Renta');
                                             ?>
                                             <?php echo $this->Form->input('tipo_propiedad', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>  $tipo_propiedad,'empty'=>'Selecciona un tipo de propiedad'))?>
                                             <?php echo $this->Form->input('desarrollo_id', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>  $all_desarrollos,'empty'=>'Seleccionar un desarrollo'))?>
                                             <?php echo $this->Form->input('venta_renta', array('div' => 'col-xs-6','class'=>'form-control','type'=>'select','options'=>$venta,'empty'=>'Selecciona si es renta o venta','label'=>'Renta/Venta'))?>
                                             <?php echo $this->Form->input('colonia', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Colonia'))?>
                                             <?php echo $this->Form->input('delegacion', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Delegación o Municipio'))?>
                                             <?php echo $this->Form->input('ciudad', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Ciudad'))?>
                                             <?php echo $this->Form->input('estado_ubicacion', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Estado'))?>
                                             <?php echo $this->Form->input('precio_min', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Precio Min','type'=>'text'))?>
                                             <?php echo $this->Form->input('precio_max', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Precio Max','type'=>'text'))?>
                                             <?php echo $this->Form->input('edad_min', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Edad Min'))?>
                                             <?php echo $this->Form->input('edad_max', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Edad Max'))?>
                                             <?php echo $this->Form->input('construccion_min', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Construcción min'))?>
                                             <?php echo $this->Form->input('construccion_max', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Construcción max'))?>
                                             <?php echo $this->Form->input('terreno', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Superficie de Terreno mínima'))?>
                                             <?php echo $this->Form->input('recamaras', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Recamaras (cuantas)'))?>
                                             <?php echo $this->Form->input('banos', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Baños (cuantos)'))?>
                                             <?php echo $this->Form->input('estacionamiento_descubierto', array('div' => 'col-xs-3','class'=>'form-control','label'=>'Estacionamientos'))?>

                                            </div>
                                                <div class="row m-t-10">
                                                    <div class="col-lg-12">
                                                     <?php echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']))?>
                                                    <?php echo $this->Form->submit('Buscar Propiedades',array('type'=>'submit','class'=>'btn btn-action layout_btn_prevent btn-primary', 'style'=>'width:100%'))?>  
                                                    <?php echo $this->Form->end();?>   
                                                    </div>
                                                </div>
                                            </div>
                                            </p>
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <p class="card-text">
                                                <div class="tab-pane active" id="tab1">
                                            <?php 
                                                echo $this->Form->create('Lead',array('url'=>array('action'=>'asignar')));
                                                $i = 1;
                                                echo $this->Form->button('Asignar Propiedades',array('type'=>'submit','class'=>'btn btn-primary'));
                                             ?>
                                            <div class="row m-t-30">
                                                <?php if (isset($sugeridas)){?>
                                                    <?php foreach ($sugeridas as $inmueble):?>   
                                                     <div class="col-md-3">
                                                         <div style="background-color: <?= $claseB?>; color:white">
                                                             <?php echo $this->Form->checkbox('seleccionar'.$i)?>
                                                             <?php echo $this->Form->hidden('inmueble_id'.$i,array('value'=>$inmueble['Inmueble']['id']))?>
                                                             <?php 
                                                                 if ($inmueble['Inmueble']['premium']==1){
                                                                     echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                 }else{
                                                                     echo $this->Html->link($inmueble['Inmueble']['titulo'],array('controller'=>'inmuebles','action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                 }
                                                             ?>
                                                            
                                                         </div> 
                                                         <?php 
                                                             if (isset($inmueble['Inmueble']['FotoInmueble'][0]['ruta'])){
                                                                 echo $this->Html->link($this->Html->image($inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('width'=>'100%','height:170px','alt'=>$inmueble['Inmueble']['FotoInmueble'][0]['descripcion'])),$inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                             }else{
                                                                 echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%','height'=>'170px'));
                                                             }
                                                         ?>
                                                         <div class="col-md-12" style="background-color:rgb(29, 131, 143); color:white;">
                                                                 <b><?= $tipo_propiedad[$inmueble['Inmueble']['dic_tipo_propiedad_id']] ?></b>
                                                                 <div style="float:right">
                                                                     <b><?= "$".  number_format($inmueble['Inmueble']['precio'],2)?></b>
                                                                 </div>
                                                         </div>
                                                         <div class="col-md-12" style="background-color:rgb(29, 131, 143); color:white;">

                                                                 <b><?= $inmueble['Inmueble']['venta_renta'] ?></b>

                                                         </div>
                                                         <div class="col-md-12">
                                                             <div class="row ">
                                                                 <div class=" col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('m2.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class=" col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['construccion']."m2"?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('autos.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['estacionamiento_techado']?>
                                                                 </div>
                                                             </div>
                                                             <div class="row ">
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('banios.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['banos']?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $this->Html->image('recamaras.png',array('width'=>'50%'))?>
                                                                 </div>
                                                                 <div class="col-sm-6 col-md-3">
                                                                     <?= $inmueble['Inmueble']['recamaras']?>
                                                                 </div>
                                                             </div>
                                                         </div>

                                                     </div>
                                                 <?php $i++;?>
                                                 <?php endforeach;?>
                                                 <?php 
                                                    echo $this->Form->hidden('contador',array('value'=>$i));
                                                    echo $this->Form->hidden('cliente_id',array('value'=>$cliente['Cliente']['id']));
                                                    echo $this->Form->hidden('user_id',array('value'=>$this->Session->read('Auth.User.id')));
                                                  ?>
                                                  <?= $this->Form->end()?> 
                                                </div>
                                             <?php }?>
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

<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover()
});
</script>
<?php 
    echo $this->Html->script([
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
            
        '/vendors/slimscroll/js/jquery.slimscroll.min',
        '/vendors/raphael/js/raphael-min',
        '/vendors/d3/js/d3.min',
        '/vendors/c3/js/c3.min',
        '/vendors/toastr/js/toastr.min',
        '/vendors/bootstrap-switch/js/bootstrap-switch.min',
        '/vendors/switchery/js/switchery.min',
        '/vendors/flotchart/js/jquery.flot',
        '/vendors/flotchart/js/jquery.flot.resize',
        '/vendors/flotchart/js/jquery.flot.stack',
        '/vendors/flotchart/js/jquery.flot.time',
        '/vendors/flotspline/js/jquery.flot.spline.min',
        '/vendors/flotchart/js/jquery.flot.categories',
        '/vendors/flotchart/js/jquery.flot.pie',
        '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
        '/vendors/jquery_newsTicker/js/newsTicker',
        '/vendors/countUp.js/js/countUp.min',
        '/vendors/sweetalert/js/sweetalert2.min',
        
        '/vendors/datepicker/js/bootstrap-datepicker.min',
        '/vendors/chosen/js/chosen.jquery',
        '/vendors/jasny-bootstrap/js/inputmask',
        
        
        
        
        //'pages/advanced_tables',
        
        //'pages/sweet_alerts',
        //'pages/new_dashboard',
        
        
       
    ], array('inline'=>false));
?>
<?php

$this->Html->scriptStart(array('inline' => false));

?>

'use strict';
$(document).ready(function () {

$(".chzn-select").chosen({allow_single_deselect: true});

    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom"
    });
    
    
    $('#propiedades').DataTable( {
        "scrollY": 400,
        "scrollX": true
    });
    
    $('#desarrollos').DataTable( {
        "scrollY": 400,
        "scrollX": true
    });
    
    //End of Scroll - horizontal and Vertical Scroll Table

    // advanced Table

    
    // End of advanced Table
    
    
});

<?php $this->Html->scriptEnd();

?>