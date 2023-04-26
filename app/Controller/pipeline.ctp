<?= $this->Html->css(
    array(
        
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        '/vendors/j_timepicker/css/jquery.timepicker',
        '/vendors/datetimepicker/css/DateTimePicker.min',
        '/vendors/fileinput/css/fileinput.min',
        'pages/layouts',
        '/vendors/fullcalendar/css/fullcalendar.min',
        'pages/calendar_custom',
        'pages/colorpicker_hack',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        
        // Select chozen
        '/vendors/chosen/css/chosen',
        'pages/form_elements',
        'pages/wizards',
        'components',
        'pages/new_dashboard',
    ),
    array('inline'=>false))
?>

<style>
    .pipeline{
        width:200%;
        overflow:scroll;
    }
    .column-pipeline{
        width: 13%;
        float: left;
        margin-right: 1%;
        height: 80vh;
        overflow-y:scroll;
    }

    .contain-column-pipeline{
        height: 80vh;
        padding: 0px .3em;
        margin-top: 15%;
    }

    .fila-cliente {
        border: 1px solid silver;
        padding: 0.3em;
        margin-bottom: .5em;
        background-color: #f2f4f4;
    }

    .titulo {
        position: absolute;
        width: 24%;
        background-color: white;
        text-align: center;
        padding: .5em;
        border-radius: 5px;
    }

    .estado1{
        background-color: #ceeefd;
    }

    .estado2{
        background-color: #6bc7f2;
    }

    .estado3{
        background-color: #f4e6c5;
    }

    .estado4{
        background-color: #f0ce7e;
    }

    .estado5{
        background-color: #f08551;
    }

    .estado6{
        background-color: #ee5003;
    }

    .estado7{
        background-color: #3ed21f;
    }

    

</style>

<div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <?= $this->Form->create('Cliente', array('url'=>array('action'=>'cambiarEstadoPipeline', 'controller'=>'clientes'))) ?>
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <h2>Cambiar Cliente al siguiente estado</h2>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
            </div> <!-- Modal Header -->
            <div class="modal-body">
                <?php
                    $estados = array(
                        1=>'Interés Preliminar',
                        2=>'Comunicación Abierta',
                        3=>'Precalificación',
                        4=>'Cita / Visita',
                        5=>'Consideración',
                        6=>'Validación de Recursos',
                        7=>'Cierre' 
                    );
                ?>
                <?php echo $this->Form->hidden('id');?>
                <div class="row">
                    <div class="col-md-12">
                        Nombre de cliente <span id="nombre_Cliente"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        Etapa Actual: <br> <span id="etapa_original_Cliente"></span>    
                    </div>
                    <div class="col-md-2">
                        <i class="fa fa-arrow-right"></i>
                    </div>
                    <div class="col-md-5">
                        Etapa Nuevo: <br> <span id="etapa_nueva_Cliente"></span>    
                    </div>
                    <?php echo $this->Form->input('comentarios', array('label'=>'Comentarios','div' => 'col-md-12 m-t-20','class'=>'form-control', 'maxlength'=>'150'))?>
                    <?php echo $this->Form->hidden('nuevo_status');?>
                    <?php echo $this->Form->hidden('cliente_id');?>
                </div>
                
            </div> <!-- Fin del bloque de mostrara los datos del evento -->
            <div class="modal-footer mt-3">
                <?= $this->Form->submit('Cambiar de Etapa', array('class'=>'btn btn-success float-xs-right')); ?>
                <?= $this->Form->button('Cancelar', array('class'=>'btn btn-danger pull-left', 'data-dismiss' => 'modal')); ?>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>


<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-filter"></i> Embudo de Ventas</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="row">
            <div class="card mt-1" style="overflow-y:scroll">
                <div class="card-block pipeline">
                    <div class="column-pipeline">
                        <div class="titulo estado1">
                            <h2 style="color:black">1. Interés Preliminar (<?= sizeof($clientes_e1)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e1 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",1,2)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado2">
                            <h2 style="color:black">2. Comunicación Abierta (<?= sizeof($clientes_e2)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e2 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",2,3)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado3">
                            <h2 style="color:black">3. Precalificación (<?= sizeof($clientes_e3)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e3 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",3,4)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado4">
                            <h2 style="color:black">4. Cita / Visita (<?= sizeof($clientes_e4)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e4 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",4,5)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado5">
                            <h2 style="color:black">5. Consideración (<?= sizeof($clientes_e5)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e5 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",5,6)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado6">
                            <h2 style="color:black">6. Validación de Recursos (<?= sizeof($clientes_e6)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e6 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        <div style="float:right">
                                            <?= $this->Html->link('<i class="fa fa-arrow-right"></i>','javascript:adelantarCliente('.$cliente['Cliente']['id'].',"'.$cliente['Cliente']['nombre'].'",6,7)',array('escape'=>false))?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                    <div class="column-pipeline">
                        <div class="titulo estado7">
                            <h2 style="color:black">7. Cierre (<?= sizeof($clientes_e7)?>)</h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php foreach($clientes_e7 as $cliente):?>
                                <div class="fila-cliente">
                                    <h3 style="color:black">
                                        <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                        <div style="float:right">
                                            <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                        </div>    
                                    </h3>
                                    <?= $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre']?>
                                    <div>
                                        <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var estados = []; 
    estados[1]='Ingresado en la base de datos';
    estados[2]='Comunicación Abierta';
    estados[3]='Precalificación';
    estados[4]='Cita / Visita';
    estados[5]='Consideración';
    estados[6]='Financiamiento';
    estados[7]='Contrato / Escrituración';
    
    function adelantarCliente(id_cliente,nombre_cliente,original,nuevo){
        $('#cambiarEstado').modal('show');
        document.getElementById('nombre_Cliente').textContent = nombre_cliente;
        document.getElementById('etapa_original_Cliente').textContent = estados[original];
        document.getElementById('etapa_nueva_Cliente').textContent = estados[nuevo];
        document.getElementById('ClienteId').value = id_cliente;
        document.getElementById('ClienteNuevoStatus').value = nuevo;
        
        
    }
</script>

<?= $this->Html->script(
        array(
            'components',
            'custom',

            '/vendors/moment/js/moment.min',
            '/vendors/fullcalendar/js/fullcalendar.min',
            'pluginjs/calendarcustom',

            '/vendors/jquery.uniform/js/jquery.uniform',
            '/vendors/inputlimiter/js/jquery.inputlimiter',
            '/vendors/chosen/js/chosen.jquery',
            '/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min',
            '/vendors/jquery-tagsinput/js/jquery.tagsinput',
            '/vendors/validval/js/jquery.validVal.min',
            '/vendors/inputmask/js/jquery.inputmask.bundle',
            '/vendors/daterangepicker/js/daterangepicker',
            '/vendors/datepicker/js/bootstrap-datepicker.min',
            '/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min',
            '/vendors/bootstrap-switch/js/bootstrap-switch.min',
            '/vendors/autosize/js/jquery.autosize.min',
            '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',

            'form',
            // Calendario
            '/vendors/jasny-bootstrap/js/inputmask',
            '/vendors/datetimepicker/js/DateTimePicker.min',
            '/vendors/j_timepicker/js/jquery.timepicker.min',
            '/vendors/clockpicker/js/jquery-clockpicker.min',
            'pages/form_elements',
        ),
        array('inline'=>true))
?>


