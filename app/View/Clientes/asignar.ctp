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
            'pages/new_dashboard'
            
            
        ),
        array('inline'=>false)); 
?>
<?php
    $estados = array(
        1=>'Interés Preliminar',
        2=>'Comunicación Abierta',
        3=>'Precalificación',
        4=>'Visita',
        5=>'Análisis de Opciones',
        6=>'Validación de Recursos',
        7=>'Cierre' 
    );
    $style="";
?>
<?php

switch ($cliente['Cliente']['etapa']) {
    case 1:
        $style = "width:50% !important;background-color: #ceeefd;;  width:100%; border-radius:5px; text-align:center;";
        break;

    case 2:
        $style = "width:50% !important;background-color:#6bc7f2;  width:100%; border-radius:5px; text-align:center;";
        break;

    case 3:
        $style = "width:50% !important;background-color: #f4e6c5;  width:100%; border-radius:5px; text-align:center;";
        break;
    case 4:
        $style = "width:50% !important;background-color: #f0ce7e;  width:100%; border-radius:5px; text-align:center;";
        break;
    case 5:
        $style = "width:50% !important;background-color: #f08551;  width:100%; border-radius:5px; text-align:center;";
        break;
    case 6:
        $style = "width:50% !important;background-color: #ee5003;  width:100%; border-radius:5px; text-align:center;";
        break;
    case 7:
        $style = "width:50% !important;background-color: #3ed21f;  width:100%; border-radius:5px; text-align:center;";
        break;
}
?>
<style>
    .chip{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; font-size: 1.1em; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
</style>
<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-sm-5 col-xs-12">
                        <h4 class="nav_top_align">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            Asignar Cliente a Asesor
                        </h4>
                        
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-12">
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    <b><?php echo $cliente['Cliente']['nombre']?></b>
                                    <div style="float:right">
                                                            <?= $this->Html->link('<i class="fa fa-edit"></i>',array('action'=>'edit',$cliente['Cliente']['id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'EDITAR CLIENTE','style'=>'color:white','escape'=>false))?>
                                                        </div>
                                </div>
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo substr($cliente['Cliente']['telefono1'], -10) ?><br>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['telefono2']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['telefono3']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-envelope"></i></font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['correo_electronico']?><br>   
                                        </div>
                                        <div class="col-lg-4">
                                            <font color="#4fb7fe">Tipo de cliente:</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['DicTipoCliente']['tipo_cliente']?><br>
                                            <font color="#4fb7fe">Etapa:</font>&nbsp;&nbsp;&nbsp;&nbsp;<span style="<?= $style?>"><?php echo $estados[$cliente['Cliente']['etapa']]?></span><br>
                                            <font color="#4fb7fe">Línea de contacto:</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo  $cliente['DicLineaContacto']['linea_contacto']?><br>
                                        </div>
                                        <div class="col-lg-4">
                                            <font color="#4fb7fe"><i class="fa fa-user"></i> Agente</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['User']['nombre_completo']?><br>
                                            <font color="#4fb7fe"><i class="fa fa-phone"></i> Comentarios</font>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $cliente['Cliente']['comentarios']?><br>
                                            <?php 
                                                $activo = "background-color:#1ec61e; color:white; width:100%";
                                                $inactivo = "background-color:red; color:white";
                                                $neutral = "background-color:orange; color:white";
                                                $style = ($cliente['Cliente']['status']=='Activo' ? $activo : ($cliente['Cliente']['status']=='Inactivo' ? $inactivo : $neutral));
                                            ?>
                                            <div style="<?= $style?>" class="chip"><?php echo $cliente['Cliente']['status']?></div><br>
                                        </div>
                                </div>
                                    <div class="row m-t-10">
                                        <div class="col-sm-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row m-t-10">
                                        <?php echo $this->Form->create('Cliente')?>
                            <?php echo $this->Form->input('id')?>
                            <?php 
                                //if ($this->Session->read('Auth.User.Group.id')!=3){
                                    echo $this->Form->input('user_id', array('options'=>$users,'label'=>'Agente Comercial','div' => 'col-md-12','class'=>'form-control','empty'=>'SIN AGENTE ASIGNADO'));
                                    echo $this->Form->input('cliente_id', array('type'=>'hidden','value'=>$cliente['Cliente']['id']));
                                //}else{
                                    //echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.id')));
                                //}
                            ?>
                                    </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $this->Form->button('Asignar Cliente',array('type'=>'submit','class'=>'btn btn-responsive layout_btn_prevent btn-primary mt-1'))?>
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
                        
                    <div class="col-lg-6 m-t-10">
                        <div class="card">
                                <?php echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar')))?>
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Inmuebles Seleccionados
                                </div>
                                
                                    
                                <p class="card-text"> 
                                   <div class="row">
                                    <div class="col-md-12">
                                        <table id="propiedades" class="table display nowrap" style="width:94% !important">
                                            <thead>
                                                <tr>
                                                    <th>Propiedades</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($leads as $inmueble):?>           
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php 
                                                                  $claseB= ($inmueble['Lead']['status']=="Abierto" ? "hsl(39, 100%, 50%)" : ($inmueble['Lead']['status']=="Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                                ?>
                                                                <div style="background-color: <?= $claseB?>; color:white">
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
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                            <?php 
                                                                if (isset($inmueble['Inmueble']['FotoInmueble'][0]['ruta'])){
                                                                    echo $this->Html->link($this->Html->image($inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('width'=>'100%','alt'=>$inmueble['Inmueble']['FotoInmueble'][0]['descripcion'])),$inmueble['Inmueble']['FotoInmueble'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                }else{
                                                                    echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                }
                                                            ?>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <font color="#4FB7FE">OPERACIÓN</font>
                                                                    <?php echo $inmueble['Inmueble']['venta_renta']?><br>
                                                                <font color="#4FB7FE">PRECIO</font>
                                                                    <?php echo "$".number_format($inmueble['Inmueble']['precio'])?><br>
                                                                    <?php if ($inmueble['Inmueble']['precio_2']>0){?>
                                                                <font color="#4FB7FE">PRECIO 2</font>
                                                                    <?php echo "$".number_format($inmueble['Inmueble']['precio_2'])?>
                                                                    <?php }?>
                                                                
                                                            </div>
                                                            <div class="col-md-3">
                                                                <font color="##4FB7FE">HABITACIONES</font>
                                                               
                                                                    <?php echo $inmueble['Inmueble']['recamaras']?><br>
                                                               
                                                                <font color="##4FB7FE">BAÑOS</font>
                                                               
                                                                    <?php echo $inmueble['Inmueble']['banos']?><br>
                                                               
                                                                <font color="##4FB7FE">ESTACIONAMIENTO</font>
                                                               
                                                                    <?php echo $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?><br>
                                                                
                                                            </div>
                                                        </div>
                                                </td>
                                            </tr>
                                            
                                            <?php endforeach;?>    
                                        </tbody>
                                </table>
                                    
                                   </div>  
                                
                    </div>
                                
                </div>
 
            </div>
                    <div class="col-lg-6 m-t-10">
                        <div class="card">
                                <?php echo $this->Form->create('Lead',array('url'=>array('action'=>'enviar_desarrollos')))?>
                                <div class="card-header bg-white"  style="background-color: #2e3c54; color:white">
                                    Desarrollos Seleccionados
                                    
                                </div>
                                
                                    
                                <p class="card-text"> 
                                   <div class="row">
                                    <div class="col-md-12">
                                        <table id="desarrollos" class="table display nowrap" style="width:94% !important">
                                            <thead>
                                                <tr>
                                                    <th>Desarrollos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($desarrollos as $desarrollo):?>           
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <?php 
                                                                   $claseB= ($desarrollo['Lead']['status']=="Abierto" ? "hsl(39, 100%, 50%)" : ($desarrollo['Lead']['status']=="Cerrado" ? "hsl(19, 100%, 50%)" : "rgba(126, 204, 0, 0.79)"));
                                                                ?>
                                                                <div style="background-color: <?= $claseB?>; color:white">
                                                                    <?php 
                                                                        echo $this->Html->link($desarrollo['Desarrollo']['nombre'],array('action'=>'view','controller'=>'desarrollos',$desarrollo['Desarrollo']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                    ?>
                                                                    <div style="float: right; color:white">
                                                                        <?php
                                                                            switch ($desarrollo['Lead']['status']):
                                                                                case("Abierto"):
                                                                                    echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                    echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                    //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case("Cerrado"):
                                                                                    echo $this->Html->link('<i class="fa fa-thumbs-up"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                    echo $this->Html->link('<i class="fa fa-tag"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Abierto",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'REABRIR INTERÉS','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                                case("Aprobado"):
                                                                                    echo $this->Html->link('<i class="fa fa-thumbs-down"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Cerrado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'NO LE INTERESA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                    //echo $this->Html->link('<i class="fa fa-calendar"></i>', array('controller'=>'leads','action' => 'status', $desarrollo['Lead']['id'],"Aprobado",$desarrollo['Lead']['cliente_id']),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'AGENDAR CITA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                break;
                                                                            endswitch;
                                                                        ?>
                                                                    </div>
                                                                </div>   
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                
                                                            <?php 
                                                                if (isset($desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'])){
                                                                    echo $this->Html->link($this->Html->image($desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'],array('width'=>'100%','alt'=>$desarrollo['Desarrollo']['FotoDesarrollo'][0]['descripcion'])),$desarrollo['Desarrollo']['FotoDesarrollo'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                }else{
                                                                    echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                }
                                                            ?>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <font color="#4FB7FE">DISPONIBILIDAD</font>
                                                                    <?php echo $desarrollo['Desarrollo']['disponibilidad']?><br>
                                                                <font color="#4FB7FE">TIPO DE DESARROLLO</font>
                                                                    <?php echo $desarrollo['Desarrollo']['tipo_desarrollo']?><br>
                                                                <font color="#4FB7FE">FECHA DE ENTREGA</font>
                                                                    <?php echo $desarrollo['Desarrollo']['fecha_entrega']?>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                </td>
                                            </tr>
                                            <?php endforeach;?>    
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
        '/vendors/fullcalendar/js/fullcalendar.min'
        
        
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
        "scrollY": 100,
        "scrollX": true
    });
    
    //End of Scroll - horizontal and Vertical Scroll Table

    // advanced Table

    var table = $('#example_demo').DataTable({
        "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-responsive't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
    });
    var $example_demo= $('#example_demo tbody');
    $example_demo.on( 'mouseenter', 'td', function () {
        var colIdx = table.cell(this).index().column;
        $( table.cells().nodes() ).removeClass( 'highlight' );
        $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        return false;
    } );
    $example_demo.on( 'mouseleave','td', function () {
        $( table.cells().nodes() ).removeClass( 'highlight' );
        return false;
    } );

    $example_demo.on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        $('#del_button').on('click', function () {
            table.row('#example_demo tbody .selected').remove().draw( false );
            return false;
        } );
        return false;
    } );
    // End of advanced Table
    
    
       
    var flot2 = function() {
        // We use an inline data source in the example, usually data would
        // be fetched from a server
        
            

        
        
        function getData(){
        var res = [];
            <?php
                $i=1;
                $min = 0;
                $max = 0;
                foreach ($inmueble['Precio'] as $precio):
                    if ($min == 0 || $min > $precio['precio']){ 
                        $min = $precio['precio'];
                    }
                    if ($max == 0 || $max < $precio['precio']){ 
                        $max = $precio['precio'];
                    }
                    
                ?>
                    res.push([<?php echo $i?>, <?= $precio['precio']?>]);
                
            <?php 
                $i++; 
                endforeach;
            ?>
            return res;
        }
        var data = [{
            label: "Precio",
            data: getData(),
            color: "#0fb0c0"
        }
        ];
        var plot2 = $.plot("#flotchart2", [getData()], {
            
            series: {
                shadowSize: 0, // Drawing is faster without shadows
                lines:{
                    show:true
                },
                points: {
                    show: true,
                    radius: 4.5,
                    fill: true,
                    fillColor: "#ffffff",
                    lineWidth: 2
                }
            },
            grid: {
                hoverable: true,
                clickable: false,
                borderWidth: 0
            },
            legend: {
                container: '#basicFlotLegend',
                show: true
            },
            tooltip: true,
            tooltipOpts: {
                content: '%s: %y'
            },
            yaxis: {
                
            },
            xaxis: {
                
            },
            colors: ["#22BAA0"],
            
            
        });

        
    };
    flot2();
    
    var datax = [{
        label: "Inmuebles 24",
        data: 150,
        color: '#4fb7fe'
    }, {
        label: "M3 ",
        data: 130,
        color: '#00cc99'
    }, {
        label: "Contacto Directo ",
        data: 190,
        color: '#0fb0c0'
    }, {
        label: "Anuncio",
        data: 180,
        color: '#EF6F6C'
    }, 
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



