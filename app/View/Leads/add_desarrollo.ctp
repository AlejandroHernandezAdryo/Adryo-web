<?= $this->Html->css(
        array(
            // 'pages/general_components',
            '/vendors/select2/css/select2.min',
            '/vendors/datatables/css/scroller.bootstrap.min',
            '/vendors/datatables/css/dataTables.bootstrap.min',
            /*'pages/dataTables.bootstrap',
            'pages/tables',*/
            '/vendors/ionicons/css/ionicons.min',
            /*'pages/icons'*/
            ),
        array('inline'=>false)) ?>


<style>
    .filterDiv {
        display: none; /* Hidden by default */
    }
    
    /* The "show" class is added to the filtered elements */
    .show {
        display: block;
    }
</style>


<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Resultado de la búsqueda
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <?= $this->Form->create('Lead',array('url'=>array('action'=>'asignar')))?>
        <div class="inner bg-light lter bg-container">
            <div class="card">
                <div class="card-header bg-white" style="background-color: #2e3c54; color:white">
                    <i class="fa fa-home"> </i> Propiedades encontradas
                    <?php echo $this->Form->button('Asignar Propiedades',array('type'=>'submit','class'=>'btn btn-primary float-xs-right'))?>
                </div>
                <div class="card-block">
                    <div class="m-t-35">
                        <div class="row">
                            <?= $this->Form->input( 'searchProps',
                                array(
                                    'label'       => false,
                                    'div'         => 'col-sm-12 col-lg-4 m-5 float-xs-right',
                                    'class'       => 'form-control',
                                    'onkeyup'     => 'filterSelection();',
                                    'placeholder' => 'Búsqueda de propiedades'
                                )
                            ) ?>
                        </div>

                        <table id="example" class="table display nowrap" >
                            <thead>
                            <tr>
                                <th>Listado de unidades del desarrollo</th>
                            </tr>
                            </thead>
                            <tbody>

                                <?php $i=1;?>
                                <?php if (isset($propiedades)){?>
                                <?php foreach ($propiedades as $inmueble):?>
                                    <tr>

                                        <?php echo $this->Form->hidden('inmueble_id'.$i,array('value'=>$inmueble['Inmueble']['id']))?>
                                        <td class="filterDiv <?= strtolower($inmueble['Inmueble']['referencia']).' '.strtolower($status_inmueble[$inmueble['Inmueble']['liberada']])  ?>">
                                           <div class="col-lg-12 m-t-10" style="background-color: #2e3c54; color:white; padding: 5px;">
                                               <?php echo $this->Form->input('seleccionar'.$i,array('type'=>'checkbox','class'=>'checkbox','label'=>$inmueble['Inmueble']['referencia']))?>
                                           </div>

                                            <?php 
                                                $imagen = (isset($inmueble['FotoInmueble'][0]) ? $inmueble['FotoInmueble'][0]['ruta'] : "/img/no_photo_inmuebles.png");
                                            ?>
                                            <div class="col-lg-2 m-t-10" style="height:150px;background-image: url('<?= Router::url('/', true).$imagen?>'); background-position:center center; background-repeat:no-repeat; background-size:cover "></div>
                                                 <div class="col-lg-9 m-t-10">
                                                     <div class="col-lg-3" >
                                                         <b><?php echo $inmueble['TipoPropiedad']['tipo_propiedad']?></b><br>
                                                         <b><?php echo "$".number_format($inmueble['Inmueble']['precio'],2)?></b><br>
                                                         <b><?php echo $inmueble['Inmueble']['exclusiva']?></b><br>
                                                         <b><?php echo $inmueble['Inmueble']['venta_renta']?></b><br>
                                                         <b>Zona: <?= $inmueble['Inmueble']['colonia']?></b><br>

                                                     </div>
                                                     <div class="col-lg-4" style="text-align: right">
                                                        <div class="row">
                                                        <div class=" col-sm-6 col-md-3">
                                                        <?= $this->Html->image('m2.png',array('width'=>'40%'))?>
                                                        </div>
                                                        <div class=" col-sm-6 col-md-3">
                                                        
                                                            <p><?= intval($inmueble['Inmueble']['construccion'])+intval($inmueble['Inmueble']['construccion_no_habitable'])."m2"?></p>

                                                        </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="col-sm-6 col-md-3">
                                                            <?= $this->Html->image('autos.png',array('width'=>'40%'))?>
                                                        </div>
                                                        <div class="col-sm-6 col-md-3">
                                                            <?= $inmueble['Inmueble']['estacionamiento_techado']?>
                                                        </div>
                                                        </div>
                                                        <div class="row">
                                                        <div class="col-sm-6 col-md-3">
                                                        <?= $this->Html->image('banios.png',array('width'=>'40%'))?>
                                                        </div>
                                                        <div class="col-sm-6 col-md-3">
                                                            <?= $inmueble['Inmueble']['banos']?>
                                                        </div>
                                                            </div>
                                                        <div class="row">
                                                        <div class="col-sm-6 col-md-3">
                                                            <?= $this->Html->image('recamaras.png',array('width'=>'40%'))?>
                                                        </div>
                                                        <div class="col-sm-6 col-md-3">
                                                            <?= $inmueble['Inmueble']['recamaras']?>
                                                        </div>
                                                        </div>
                                                     </div>
                                                     <div class="col-lg-3" style="text-align: right">
                                                         <div class="row">
                                                         <?php
                                                            switch ($inmueble['Inmueble']['liberada']){
                                                                case 0: //No liberada
                                                                    echo "<div class='status' style='text-align: center; background-color: #fcee21'>NO LIBERADA</div>";
                                                                    break;

                                                                case 1: // Libre
                                                                    echo "<div class='status' style='text-align: center; background-color: #39b54a; color:white'>LIBRE</div>";
                                                                    break;

                                                                case 2:
                                                                    echo "<div class='status' style='text-align: center; background-color: #fbb03b; color:white'>RESERVA</div>";
                                                                    break;

                                                                case 3:
                                                                    echo "<div class='status' style='text-align: center; background-color: #29abe2'>CONTRATO</div>";
                                                                    break;

                                                                case 4:
                                                                    echo "<div  class='status' style='text-align: center; background-color: #c1272d; color:#FFF;'>ESCRITURACION</div>";
                                                                    break;
                                                                case 5:
                                                                    echo "<div class='status' style='text-align: center; background-color: #c1272d; color:white'>BAJA</div>";
                                                                    break;
                                                            }

                                                        ?><br>


                                                         </div>
                                                         </div>
                                                 </div>

                                        </td>
                                    </tr>
                                    <?php $i++;?>
                                    <?php 
                                        endforeach;
                                        }
                                    ?>
                                   

                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->hidden('cliente_id',array('value' => $cliente_id))?>
    <?= $this->Form->hidden('status',array('value' => "Abierto"))?>
    <?= $this->Form->hidden('contador',array('value' => $i))?>
    <?= $this->Form->end()?>
</div>


<?php 
    echo $this->Html->script(array(
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        'pages/advanced_tables'), 
        array('inline'=>false));
?>

<script>
    filterSelection("all")
    function filterSelection( ){
        var x, i;
        val = $("#LeadSearchProps").val();
        c = val.toLowerCase();
        console.log( c );
        
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