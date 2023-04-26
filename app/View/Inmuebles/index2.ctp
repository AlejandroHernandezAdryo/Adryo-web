<?= $this->Html->css(
        array(
            'pages/general_components',
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            '/vendors/ionicons/css/ionicons.min',
            'pages/icons'
            ),
        array('inline'=>false)) ?>


<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Lista de propiedades
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                        <div class="card-header bg-white" style="background-color: #2e3c54; color:white">
                            <i class="fa fa-home"> </i> Propiedades cargadas
                        </div>
                        <div class="card-block">
                            <div class="m-t-35">
                                <table id="example" class="table display nowrap" >
                                    <thead>
                                    <tr>
                                        <th>Propiedades</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($inmuebles as $inmueble):?>           
                                            <tr>
                                                <td>
                                                 <div class="row">
                                                         <div class="col-lg-2"style="border-right: 1px solid black;">
                                                            <?php 
                                                                    if (isset($inmueble['FotoInmueble'][0]['ruta'])){
                                                                            echo $this->Html->link($this->Html->image($inmueble['FotoInmueble'][0]['ruta'],array('width'=>'100%','alt'=>$inmueble['FotoInmueble'][0]['descripcion'])),$inmueble['FotoInmueble'][0]['ruta'],array('class'=>'fancybox', 'rel'=>'group','escape'=>false,'target'=>'_blank'));
                                                                    }else{
                                                                            echo $this->Html->image('no_photo_inmuebles.png',array('width'=>'100%'));
                                                                    }
                                                                    ?>
                                                             
                                                         </div>
                                                         <div class="col-lg-9">
                                                                <div style="background-color: #2e3c54; color:white"><?php 
                                                                if ($inmueble['Inmueble']['premium']==1){
                                                                    echo $this->Html->link($inmueble['Inmueble']['titulo']."<i class='fa fa-certificate'></i>",array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                }else{
                                                                    echo $this->Html->link($inmueble['Inmueble']['titulo'],array('action'=>'view',$inmueble['Inmueble']['id']),array('escape'=>false,'style'=>'color:white'));
                                                                }
                                                                ?>
                                                                    <div style="float: right; color:white">
                                                                        <?php
                                                                            if ($inmueble['Inmueble']['liberada']!=0){
                                                                                echo $this->Html->link('<i class="fa fa-pencil"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],0),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BORRADOR','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-pencil"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],0), array('title'=>'Borrador','escape'=>false), __('Desea poner en borrador este inmueble?', $inmueble['Inmueble']['id']))." "; 
                                                                            }
                                                                            if ($inmueble['Inmueble']['liberada']!=1){
                                                                                echo $this->Html->link('<i class="fa fa-check"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],1),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'LIBRE','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-check"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],1), array('title'=>'Libre','escape'=>false), __('Desea liberar este inmueble?', $inmueble['Inmueble']['id']))." ";
                                                                            }
                                                                            if ($inmueble['Inmueble']['liberada']!=2){
                                                                                echo $this->Html->link('<i class="fa fa-calendar"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],2),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'RESERVADO','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-calendar"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],2), array('title'=>'Reservado','escape'=>false), __('Desea registrar reserva de este inmueble?', $inmueble['Inmueble']['id']))." ";
                                                                            }
                                                                            if ($inmueble['Inmueble']['liberada']!=3){
                                                                                echo $this->Html->link('<i class="fa fa-file"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],3),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'CONTRATO','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-file"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],3), array('title'=>'Contrato','escape'=>false), __('Desea registrar contrato de este inmueble?', $inmueble['Inmueble']['id']))." ";
                                                                            }
                                                                            if ($inmueble['Inmueble']['liberada']!=4){
                                                                                echo $this->Html->link('<i class="fa fa-certificate"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],4),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'ESCRITURACIÓN','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-certificate"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],4), array('title'=>'Escrituración','escape'=>false), __('Desea registrar escrituración de este inmueble?', $inmueble['Inmueble']['id']));
                                                                            }
                                                                            if ($inmueble['Inmueble']['liberada']!=5){
                                                                                echo $this->Html->link('<i class="fa fa-times"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],5),array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'BAJA','escape'=>false,'style'=>'color:white;margin-right:5px'));
                                                                                //echo $this->Form->postLink('<i class="fa fa-times"></i>', array('action' => 'status', $inmueble['Inmueble']['id'],5), array('title'=>'BAJA','escape'=>false), __('Desea dar de baja este inmueble?', $inmueble['Inmueble']['id']));
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                    <div class="col-lg-12">
                                                                        <div class="row">
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">REFERENCIA</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['referencia']?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">TERRENO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['terreno']?> m2
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">ESTADO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php
                                                                                switch ($inmueble['Inmueble']['liberada']){
                                                                                    case 0: //No liberada
                                                                                        echo "<div style='text-align: center; background-color: #fcee21'>NO LIBERADA</div>";
                                                                                        break;

                                                                                    case 1: // Libre
                                                                                        echo "<div style='text-align: center; background-color: #39b54a; color:white'>LIBRE</div>";
                                                                                        break;

                                                                                    case 2:
                                                                                        echo "<div style='text-align: center; background-color: #fbb03b; color:white'>RESERVA</div>";
                                                                                        break;

                                                                                    case 3:
                                                                                        echo "<div style='text-align: center; background-color: #29abe2'>CONTRATO</div>";
                                                                                        break;

                                                                                    case 4:
                                                                                        echo "<div style='text-align: center; background-color: #c1272d'>ESCRITURACION</div>";
                                                                                        break;
                                                                                    case 5:
                                                                                        echo "<div style='text-align: center; background-color: #c1272d; color:white'>BAJA</div>";
                                                                                        break;
                                                                                }

                                                                            ?>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-1" style="text-align:lef">
                                                                                <font color="##4FB7FE">PRECIO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo "$".number_format($inmueble['Inmueble']['precio'])?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">CONSTRUCCIÓN</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['construccion']?> m2
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">VENCIMIENTO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo date('d/M/Y',  strtotime($inmueble['Inmueble']['due_date']))?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-1" style="text-align:lef">
                                                                                <font color="##4FB7FE">PRECIO 2</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo "$".number_format($inmueble['Inmueble']['precio_2'])?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">HABITACIONES</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['recamaras']?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">CITA</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['cita']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-1" style="text-align:lef">
                                                                                <font color="##4FB7FE">OPERACIÓN</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php $inmueble['Inmueble']['venta_renta']?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">BAÑOS</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['banos']?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">EXCLUSIVA</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['exclusiva']?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-1" style="text-align:lef">
                                                                                <font color="##4FB7FE">FECHA INGRESO</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php $inmueble['Inmueble']['fecha']?>
                                                                            </div>
                                                                            <div class="col-lg-1" style="text-align:left">
                                                                                <font color="##4FB7FE">ESTACION.</font>
                                                                            </div>
                                                                            <div class="col-lg-2" style="text-align:left">
                                                                                <?php echo $inmueble['Inmueble']['estacionamiento_techado']+$inmueble['Inmueble']['estacionamiento_descubierto']?>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    
                                                                    
                                                                    
                                                                    </div>
                                                                    
                                                                                                                                        

                                                                    
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


<?php 
    echo $this->Html->script([
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        /*'/vendors/datatables/js/dataTables.colReorder.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/datatable',*/
        'pages/advanced_tables'
    ], array('inline'=>false));
?>

<script>
$(document).ready(function () {
    $('[data-toggle="popover"]').popover()
});
</script>