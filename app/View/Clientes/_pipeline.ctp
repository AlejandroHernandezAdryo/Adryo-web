<?= $this->Html->css(
    array(

        '/vendors/swiper/css/swiper.min',
        
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
    #status_cliente{
        display: none;
    }

    

</style>

<div class="modal fade" id="buscar" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <?= $this->Form->create('Cliente') ?>
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <h2>Filtrar Embudo de ventas</h2>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
            </div> <!-- Modal Header -->
            <div class="modal-body">
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
                ?>
                <div class="row mt-1">
                    <div class="col-xl-3">
                        <?= $this->Form->label('nombre','Nombre Cliente', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('nombre_cliente',array('class'=>'form-control','placeholder'=>'Nombre de Cliente','div'=>'col-xl-9','label'=>false,)); ?>
                </div>
                <div class="row mt-1">
                    <div class="col-xl-3">
                        <?= $this->Form->label('asesor_id','Asesor', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('asesor_id',array('type'=>'select','options'=>$users,'empty'=>'Todos los usuarios','class'=>'form-control chzn-select','placeholder'=>'Teléfono','div'=>'col-xl-9','label'=>false,)); ?>
                </div>
                <div class="row mt-1">
                    <div class="col-xl-3">
                        <?= $this->Form->label('desarrollo_id','Desarrollo', array('class' => 'form-control-label')); ?>
                    </div>
                    <?= $this->Form->input('desarrollo_id',array('type'=>'select','options'=>$desarrollos,'empty'=>'Todos los desarrollos','class'=>'form-control chzn-select','placeholder'=>'Teléfono','div'=>'col-xl-9','label'=>false,)); ?>
                </div>
                </div> <!-- Fin del bloque de mostrara los datos del evento -->
                <div class="modal-footer mt-3">
                    <?= $this->Form->submit('Filtrar Embudo', array('class'=>'btn btn-success float-xs-right')); ?>
                    <?= $this->Form->button('Cancelar', array('class'=>'btn btn-danger pull-left', 'data-dismiss' => 'modal')); ?>
                </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?= $this->element('Clientes/edit_prospeccion'); ?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-10">
                <h4 class="nav_top_align"><i class="fa fa-filter"></i> Embudo de Ventas </h4>
            </div>
            <div class="col-lg-2">
                <a  href="#" class="btn btn-success" data-toggle="modal" data-target="#buscar">
                    <span class="btn-label btn-label-tr"><i class="fa fa-filter fa-1x"></i></span> Filtrar Embudo
                </a>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="row">
            <div class="card mt-1" style="overflow-y:scroll">
                <div class="card-block pipeline">
                    <div class="column-pipeline">
                        <div class="titulo estado1">
                            <h2 style="color:black"><?= $etapas[1] ?> ( <span id="contador_e1"></span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Registro en sistema / primer contacto ','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e1 = 0; ?>
                            <?php foreach($clientes_e1 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e1 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">
                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status','data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));

                                                    }else {
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'style'=>'color: #bababa; cursor:not-allowed !important;'));
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado2">
                            <h2 style="color:black"><?= $etapas[2] ?> ( <span id="contador_e2"></span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Ha habido una respuesta del cliente. Ya existe un intercambio continuo de información','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e2 = 0; ?>
                            <?php foreach($clientes_e2 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e2 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">

                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status','data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));

                                                    }else {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#',array('escape'=>false, 'class' => 'disabled'));
                                                    }
                                                ?>
                                            
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado3">
                            <h2 style="color:black"><?= $etapas[3] ?> ( <span id="contador_e3"></span> ) <?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Las condiciones del cliente empatan con el portafolio de propiedades disponibles. (Zona, presupuesto, habitaciones, tiempos de entrega, etc.)','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e3 = 0; ?>
                            <?php foreach($clientes_e3 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e3 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">

                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false, 'style'=>'margin-left: 5px;', 'id'=>'btn_show_status','data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));

                                                    }else {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#',array('escape'=>false, 'class' => 'disabled'));

                                                    }
                                                ?>
                                            
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado4">
                            <h2 style="color:black"><?= $etapas[4] ?> ( <span id="contador_e4"> </span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'El cliente ya visitó la propiedad','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>

                        <div class="contain-column-pipeline">
                        <?php $contador_e4 = 0; ?>
                            <?php foreach($clientes_e4 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e4 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">

                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false,'data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));


                                                    }else {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#',array('escape'=>false, 'class' => 'disabled'));

                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado5">
                            <h2 style="color:black"><?= $etapas[5] ?> ( <span id="contador_e5"></span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Evaluación de inmuebles que cumplen el requerimiento del cliente. Se evalua el presupuesto real del cliente, y formas de pago.','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e5 = 0; ?>
                            <?php foreach($clientes_e5 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e5 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">

                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false,'data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));

                                                    }else {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#',array('escape'=>false, 'class' => 'disabled'));

                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado6">
                            <h2 style="color:black"><?= $etapas[6] ?> ( <span id="contador_e6"></span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Clientes que ya iniciaron proceso de apartado, enganche, carta oferta con su borker correspondiente.','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e6 = 0; ?>
                            <?php foreach($clientes_e6 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                
                                    <?php $contador_e6 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                            <div style="float:right">
                                                
                                                <?php 
                                                    if( $this->Session->read('Permisos.Group.id') != 5 ) {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#', array('escape'=>false,'data-toggle'=>'modal', 'data-target'=>'#modalProspeccion', 'onclick' => 'data_client('.$cliente['Cliente']['id'].', 1)'));

                                                    }else {
                                                        
                                                        echo $this->Html->link('<i class="fa fa-arrow-right"></i>','#',array('escape'=>false, 'class' => 'disabled'));

                                                    }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>

                    <div class="column-pipeline">
                        <div class="titulo estado7">
                            <h2 style="color:black"><?= $etapas[7] ?> ( <span id="contador_e7"></span> )<?= $this->Html->link('<i class="fa fa-question"></i>','#',array('data-toggle'=>'tooltip','data-placement'=>'top','title'=>'Firma de contrato / Escrituración.','escape'=>false,'style'=>'background-color: #12bb7c;color: white;padding: 2px;border-radius: 100px; float:right')) ?></h2>
                        </div>
                        <div class="contain-column-pipeline">
                            <?php $contador_e7 = 0; ?>
                            <?php foreach($clientes_e7 as $cliente):?>
                                <?php
                                $presentar = true;
                                if (isset($desarrollo_id)){
                                    if (isset($cliente['Lead'][0])){
                                        $presentar = false;
                                        foreach($cliente['Lead'] as $lead):
                                            if ($lead['desarrollo_id']==$desarrollo_id){
                                                $presentar = true;
                                            }        
                                        endforeach;
                                    }
                                }
                                ?>
                                <?php if ($presentar): ?>
                                    <?php $contador_e7 ++; ?>
                                    <div class="fila-cliente">
                                        <h3 style="color:black">
                                            <?= $this->Html->link($cliente['Cliente']['nombre'],array('controller'=>'clientes','action'=>'view',$cliente['Cliente']['id']))?>
                                            <div style="float:right">
                                                <small><?= date("d/M/Y H:i:s",strtotime($cliente['Cliente']['last_edit']))?></small>
                                            </div>    
                                        </h3>
                                        <?php
                                            if (isset($cliente['Lead'][0])){
                                                foreach($cliente['Lead'] as $lead):
                                                    echo $lead['Inmueble']['titulo'].$lead['Desarrollo']['nombre'].",";    
                                                endforeach;
                                            }else{

                                                echo $cliente['Inmueble']['titulo']." ".$cliente['Desarrollo']['nombre'];
                                            }
                                        
                                        ?>
                                        <div>
                                            <i class="fa fa-user"></i> <?= $cliente['User']['nombre_completo']?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach;?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

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

            '/vendors/chosen/js/chosen.jquery',
            'form',
        ),
        array('inline'=>false))
?>

<script>
'use strict';
// Chozen select
$(".hide_search").chosen({disable_search_threshold: 10});
$(".chzn-select").chosen({allow_single_deselect: true});
$(".chzn-select-deselect,#select2_sample").chosen();

// Contadores para secciones.
$("#contador_e1").html(<?= $contador_e1 ?>);
$("#contador_e2").html(<?= $contador_e2 ?>);
$("#contador_e3").html(<?= $contador_e3 ?>);
$("#contador_e4").html(<?= $contador_e4 ?>);
$("#contador_e5").html(<?= $contador_e5 ?>);
$("#contador_e6").html(<?= $contador_e6 ?>);
$("#contador_e7").html(<?= $contador_e7 ?>);

    
</script>


