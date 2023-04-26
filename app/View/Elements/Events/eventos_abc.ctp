<style>
    .notice {display: none;}
    .form-control-danger {border: 1px solid #EF6F6C;}
    .label-danger-ao {color: #EF6F6C;}
    #addEvento-camposCitaVisita, #divRecordatorio2, #editEvento-header, #form-editEvent, #addEvento-warningCitaVisita, #recordatorio {display: none;}
    .chosen-results, .chosen-single {text-transform: uppercase;}
    h2 {color: #434343 !important;}
    #infoEvento-titulo {font-size: 16px; margin-bottom: -3px;}
    .fc-today > span {font-size: 14px; background-color: #2e3c54 !important; padding: 1px !important; border-radius: 50px; color: #FFF; height: 24px !important; width: 24px !important; margin-left: 42%; margin-top: 1px;}
    .fc-today {background-color: #F0F0F0 !important;}
    .fc-ltr .fc-basic-view .fc-day-top .fc-day-number  {float: none !important; text-align: center; display: inline-block; margin-top: 6px !important;}
    .fc-day-number  {display: block !important;}
    #labelStatusUpdate{font-size: 1.2rem;}
    .float-left {float: left;}
    #editEventTitulo {
        text-transform: uppercase;
        font-size: 16px;
        text-align: center;
        letter-spacing: 1.2px
    }

    #addeventatc1{
        visibility : visible;
        font-size  : 12px;
        font-weight: 600;
        padding    : 10px;
        padding-left: 50px;
    }
    .copyx{ display: none !important; }
    .hide{
        display: none;
    }
    .show{
        display: block;
    }
</style>

<?= $this->Html->css(
    array(
        '/vendors/inputlimiter/css/jquery.inputlimiter',
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

        // Chosen
        '/vendors/chosen/css/chosen',
        'pages/form_elements',
        'pages/wizards',
        'components',
        'pages/new_dashboard',

        // Switch
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
		'/vendors/switchery/css/switchery.min',
		'/vendors/radio_css/css/radiobox.min',
		'/vendors/checkbox_css/css/checkbox.min',
        'pages/radio_checkbox.css',
    ),
    array('inline'=>false))
?>

<!-- Modal para agregar evento desde cualquier pagina en donde se mande a llamar. -->
<div class="modal fade" id="addEvento" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title" id="addEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Agregar evento</h4>
            </div>

            <div class="modal-body">

            	<div id="notice"></div>

                <div class="form-add-event">

                    <?= $this->Form->create('FormCreateEvent', array('id'=>'FormCreateEvent', 'url' => array('action' => 'add', 'controller'=> 'events' ) )); ?>
                        
                        <div class="row">
                            <?= $this->Form->input('tipo_tarea', array(
                                'type'     => 'select',
                                'options'  => $tipo_tarea_opciones,
                                'onchange' => 'showInputsProps();',
                                'class'    => 'form-control',
                                'div'      => array('class'=> 'col-sm-12 mt-2'),
                                'label'    => array('text' => 'Tipo de evento*', 'id' => 'lEventTipoTarea'),
                                'required' => true,
                                'empty'    => array( 24041993 => 'Seleccione una opción')
                            )); ?>
                        </div>

                        <div class="row mt-1">
                            <?= $this->Form->input('fechaInicial', array(
                                    'class'        => 'form-control fecha',
                                    'div'          => array('class'=> 'col-sm-12 col-lg-6'),
                                    'label'        => array('text' => 'Fecha*', 'id' => 'lEventFecha'),
                                    'placeholder'  => 'dd-mm-YYYY',
                                    'required'     => true,
                                    'autocomplete' => 'off',
                            )); ?>
            
                            <?= $this->Form->input('horaInicial', array(
                                'type'         => 'select',
                                'options'      => $hours,
                                'class'        => 'form-control',
                                'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                                'label'        => 'Hora',
                                'placeholder'  => 'H',
                                'required'     => true,
                                'autocomplete' => 'off',
                            )); ?>
        
                            <?= $this->Form->input('minutoInicial', array(
                                'type'         => 'select',
                                'options'      => $minutos,
                                'class'        => 'form-control',
                                'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                                'label'        => 'Minutos',
                                'placeholder'  => 'm',
                                'required'     => true,
                                'autocomplete' => 'off',
                            )); ?>
                        </div>

                        <div class="row mt-1" id="addEvento-warningCitaVisita">
                            <div class="col-sm-12">
                                <label style="color: #f89815; ">* Es necesario llenar los campos en el siguiente orden, "cliente", "asesor", "inmueble o desarrollo".</label>
                            </div>
                        </div>

                        <div class="row mt-1">
                            <?= $this->Form->input('cliente_id', array(
                                'type'     => 'select',
                                'options'  => $clientes,
                                'class'    => 'form-control chzn-select',
                                'div'      => array('class' => 'col-sm-12 col-lg-6'),
                                'label'    => array('text' => 'Cliente*', 'id' => 'lEventCliente'),
                                'empty'    => array(0=>'Seleccione una opción'),
                                'onchange' => 'searchLeadsDesarrolloInmueble();'
                            )); ?>
        
                            <?= $this->Form->input('user_id', array(
                                'type'         => 'select',
                                'options'      => $asesores,
                                'class'        => 'form-control chzn-select',
                                'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                'label'    => array('text' => 'Asesor*', 'id' => 'lEventAsesor'),
                                'empty'    => array(0=>'Seleccione una opción')
                            )); ?>
                        </div>

                        <div id="addEvento-camposCitaVisita">
                            <div class="row mt-1">
                                
                                <?= $this->Form->input('inmueble_id', array(
                                    'type'         => 'select',
                                    'class'        => 'form-control chzn-select',
                                    'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'    => array('id' => 'lEventInmueble'),
                                    'empty'    => array(0=>'Seleccione una opción'),
                                    'onchange' => 'disableInputProps();'
                                )); ?>

                                <?= $this->Form->input('desarrollo_id', array(
                                    'type'         => 'select',
                                    'class'        => 'form-control chzn-select',
                                    'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'    => array('id' => 'lEventDesarrollo'),
                                    'empty'    => array(0=>'Seleccione una opción'),
                                    'onchange' => 'disableInputProps();'
                                )); ?>
                            </div>
                        </div>

                        <div id="recordatorio">
                            <div class="row mt-1">
                                <?= $this->Form->input('recordatorio_1', array(
                                    'type'     => 'select',
                                    'options'  => $recordatorios,
                                    'class'    => 'form-control chzn-select',
                                    'div'      => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'    => 'Recordatorio',
                                    'onchange' => 'showRecordatorio2();',
                                    'empty'    => array(0=>'Seleccione una opción')
                                )); ?>
            
                                <?= $this->Form->input('recordatorio_2', array(
                                    'type'    => 'select',
                                    'options' => $recordatorios,
                                    'class'   => 'form-control chzn-select',
                                    'div'     => array('class' => 'col-sm-12 col-lg-6', 'id' => 'divRecordatorio2'),
                                    'label'   => 'Recordatorio 2',
                                )); ?>
                            </div>
                        </div>


                        <div class="row mt-2">
                        	
                        	<div class="col-sm-12">

                        		<div class="radio_basic_swithes_padbott" onclick="viewRemider();">
                                    <input type="checkbox" class="js-switch sm_toggle" id="checkboxRemider" />
                                    <span class="radio_switchery_padding">Deseas agregar un recordatorio</span>
                                    <br />
                                </div>

                        	</div>
                        </div>


                        
                        <div class="modal-footer">
                            <div class="row mt-2">
                                
                                <div class="col-sm-12">
                                    
                                    <button type="button" class="btn btn-danger float-left" data-dismiss="modal">
                                        Cancelar
                                    </button>

                                    <button class="btn btn-success float-right" type="button" onclick="submitAddEvent();">
                                        Guardar evento
                                    </button>

                                </div>
                            </div>
                        </div>
                    <?= $this->Form->hidden('return', array('value' => $return) ) ?>
                    <?= $this->Form->end();  ?>

                </div>
            
            </div>

        </div>
    </div>
</div>

<!-- Modal para ver el evento -->
<div class="modal fade" id="eventInfo" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title text-white" id="infoEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Información del evento</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 text-float-right" id="botones-accion"></div>
                </div>
                <div class="row" id="block-view-info">
                    <div class="col-sm-12">
                        <table class="table-sm">
                            <tbody>
                                <tr>
                                    <td> <label id="infoEvento-titulo"></label> </td>
                                </tr>
                                
                                <tr style="margin-top: -5px;">
                                    <td>
                                        <label id="infoEvent-master"></label>
                                    </td>
                                </tr>

                                <tr style="margin-top: -5px;">
                                    <td>
                                        <label id="infoEvent-recordatorio"></label>
                                    </td>
                                </tr>

                                <tr>
                                    <td> <label id="infoEvento-asesor"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12">
                        <div title="Add to Calendar" class="addeventatc">
                            Exportar a calendarios.
                            <span class="start"></span>
                            <span class="title"></span>
                            <span class="description"></span>
                            <span class="location"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-3">
                    <?= $this->Form->button('Cerrar', array('type'=>'button','class'=>'btn btn-danger float-left', 'data-dismiss' => 'modal')); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cancelar evento -->

<div class="modal fade" id="eventStatusUpdate" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog modal-md modal-dialog-centered">
        <?= $this->Form->create('formUpdateEvent', array('url'=>array('action'=>'status', 'controller'=>'events'), 'id' => 'FormStatusUpdate')) ?>
        <div class="modal-content">
            <div class="modal-body">
                <div class="row" id="block-view-info">
                    <div class="col-sm-12 text-center">
                        <span id="labelStatusUpdate"></span>
                    </div>
                    
                    <div id="campos-cancelacion-eventos" class="hide">
                        <div class="col-sm-12 text-center">
                            <label>Motivo de Cancelación</label>
                        </div>
                        <?= $this->Form->input('motivo_cancelacion',array('label'=>false,'class'=>'form-control','div'=>'col-sm-12 text-center mb-2','type'=>'select','options'=>$motivos_citas_canceladas,'empty'=>'Selecciona un Motivo de Cancelación','required'))?>
                    </div>

                </div>
                <div class="modal-footer">
                    <?= $this->Form->hidden('status') ?>
                    <?= $this->Form->hidden('return', array('value' => $return)) ?>
                    <?= $this->Form->hidden('param_return', array('value' => $param_return)) ?>
                    <?= $this->Form->hidden('evento_id') ?>
                    <?= $this->Form->button('Si', array('class'=>'btn btn-success btn-sm float-xs-right', 'onclick' => 'buttonEventStatusUpdate()', 'type' => 'button')); ?>
                    <?= $this->Form->button('No', array('class'=>'btn btn-danger btn-sm pull-left', 'data-dismiss' => 'modal', 'type' => 'button')); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>



<!-- Modal para la edicion de evento -->
<div class="modal fade" id="editEvent" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <?= $this->Form->create('FormEditEvent', array('url'=>array('action'=>'edit', 'controller'=>'events'), 'id' => 'formEditEvent')) ?>
        
        <div class="modal-content">
        
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title" id="addEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Edición de evento</h4>
            </div> <!-- Modal Header -->

            <div class="modal-body">
                
                <div class="row">
                    
                    <div class="col-sm-12">
                        
                        <p id="editEventTitulo"></p>
                        <p id="editEventUbicacion"> </p>
                        <p id="editEventRecordatorio"> </p>
                        <p id="editEventAsesor"> </p>
                        
                    </div>

                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        
                        <p style="font-size: 14px; font-weight: 600;">
                            Fecha del evento: <span id="edtiEventFechaInicial"></span>
                        </p>
                        
                    </div>
                </div>

                <div class="row">
                    <?= $this->Form->input('fechaInicial', array(
                            'class'       => 'form-control fecha',
                            'div'         => array('class'=> 'col-sm-12 col-lg-6'),
                            'label'    => array('text' => 'Fecha*', 'id' => 'formEditEventLabelFI'),
                            'placeholder' => 'dd-mm-YYYY',
                            'required'    => true,
                            'autocomplete' => 'off',
                    )); ?>
    
                    <?= $this->Form->input('horaInicial', array(
                        'type'         => 'select',
                        'options'      => $hours,
                        'class'        => 'form-control',
                        'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                        'label'        => 'Hora',
                        'placeholder'  => 'H',
                        'required'     => true,
                        'autocomplete' => 'off',
                    )); ?>

                    <?= $this->Form->input('minutoInicial', array(
                        'type'         => 'select',
                        'options'      => $minutos,
                        'class'        => 'form-control',
                        'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                        'label'        => 'Minutos',
                        'placeholder'  => 'm',
                        'required'     => true,
                        'autocomplete' => 'off',
                    )); ?>
                </div>

                <div class="row">
                    
                    <?= $this->Form->input('user_id', array(
                        'type'         => 'select',
                        'options'      => $asesores,
                        'class'        => 'form-control chzn-select',
                        'div'          => array('class' => 'col-sm-12 mt-1'),
                        'label'        => array('text' => 'Asesor*', 'id' => 'editEventlAsesor'),
                        'empty'        => array(0=>'Seleccione una opción')
                    )); ?>

                </div>

                <div id="editRecordatorio">
                    <div class="row mt-1">
                        <?= $this->Form->input('recordatorio_1', array(
                            'type'     => 'select',
                            'options'  => $recordatorios,
                            'class'    => 'form-control chzn-select',
                            'div'      => array('class' => 'col-sm-12 col-lg-6'),
                            'label'    => 'Recordatorio',
                            'empty'    => array(0=>'Seleccione una opción')
                        )); ?>
    
                        <?= $this->Form->input('recordatorio_2', array(
                            'type'    => 'select',
                            'options' => $recordatorios,
                            'class'   => 'form-control chzn-select',
                            'div'     => array('class' => 'col-sm-12 col-lg-6'),
                            'label'   => 'Recordatorio 2',
                        )); ?>
                    </div>
                </div>

                <div class="modal-footer mt-2">
                    <?= $this->Form->hidden('evento_id') ?>
                    <?= $this->Form->hidden('fecha_origen') ?>
                    <?= $this->Form->hidden('cliente_id') ?>
                    <?= $this->Form->hidden('return', array('value' => $return) ) ?>
                    <?= $this->Form->button('Guardar', array('class'=>'btn btn-success float-xs-right', 'type' => 'submit')); ?>
                    <?= $this->Form->button('Cancelar', array('class'=>'btn btn-danger pull-left', 'data-dismiss' => 'modal', 'type' => 'button', 'onclick' => 'returnViewInfo();')); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
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
            // 'pages/form_elements',

            // Add events and calendar.
            'https://addevent.com/libs/atc/1.6.1/atc.min.js'
        ),
        array('inline'=>false))
?>


<script>

    "use strict";

    // Date picker
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom",
        startDate: "<?= ( $this->Session->read('CuentaUsuario.Cuenta.id') == 170 ? date('d-m-Y', strtotime("-1 month")) :  date('d-m-Y') ); ?>", 
    });

    // Script para compartir eventos a calendarios.
    window.addeventasync = function(){
        addeventatc.settings({
            appleical  : {show:true, text:"Calendario Apple"},
            google     : {show:true, text:"Google <em>(online)</em>"},
            office365  : {show:true, text:"Office 365 <em>(online)</em>"},
            outlook    : {show:true, text:"Outlook"},
            outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
        });
    };

    //  Validación de formulario para alta de evento.
    function submitAddEvent() {
	    var flag = true;
	    

	    if($('#FormCreateEventFechaInicial').val() == ''){
	        flag = false;
	        $('#lEventFecha').addClass('label-danger-ao');
	        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
	    }else{
	        $('#lEventFecha').removeClass('label-danger-ao');
	    }


	    if($('#FormCreateEventClienteId').val() == 0){
	        flag = false;
	        $('#lEventCliente').addClass('label-danger-ao');
	        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
	    }else{
	        $('#lEventCliente').removeClass('label-danger-ao');
	    }

	    if($('#FormCreateEventUserId').val() == 0){
	        flag = false;
	        $('#lEventAsesor').addClass('label-danger-ao');
	        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
	    }else{
	        $('#lEventAsesor').removeClass('label-danger-ao');
	    }

	    if($('#FormCreateEventTipoTarea').val() == 24041993){
	        flag = false;
	        
	        $('#lEventTipoTarea').addClass('label-danger-ao');
	        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
	        
	        if ( $('#FormCreateEventTipoTarea').val() == 0 || $('#FormCreateEventTipoTarea').val() == 1 ) {
	            
	            if ($('#FormCreateEventDesarrolloId').val() == 0 && $('#FormCreateEventInmuebleId').val() == 0) {
	                flag = false;
	                $('#lEventDesarrollo').addClass('label-danger-ao');
	                $('#lEventInmueble').addClass('label-danger-ao');
	                document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Debes seleccionar por lo menos un inmueble o un desarrollo *';
	            }else{
	                $('#lEventDesarrollo').removeClass('label-danger-ao');
	                $('#lEventInmueble').removeClass('label-danger-ao');
	            }
	        }

	    }else{
	        
	        $('#lEventTipoTarea').removeClass('label-danger-ao');
	        if ($('#FormCreateEventTipoTarea').val() == 0 || $('#FormCreateEventTipoTarea').val() == 1) {
	            if ($('#FormCreateEventDesarrolloId').val() == 0 && $('#FormCreateEventInmuebleId').val() == 0) {
	                flag = false;
	                $('#lEventDesarrollo').addClass('label-danger-ao');
	                $('#lEventInmueble').addClass('label-danger-ao');
	                document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Debes seleccionar por lo menos un inmueble o un desarrollo *';
	            }else{
	                $('#lEventDesarrollo').removeClass('label-danger-ao');
	                $('#lEventInmueble').removeClass('label-danger-ao');
	            }
	        }

	    }

	    if( flag === true ){
	        // alert('Todos los campos estan llenos');
	        document.getElementById("notice").innerHTML = '';
	        $('#notice').removeClass('label-danger-ao');
	        $("#notice").css("display", "none");
	        $("#FormCreateEvent").submit();

	        $("#btnSubmitAddEvent").addClass("disabled");
	        $("#btnSubmitAddEvent").css("display", "none");
	        $("#addEvento").modal("hide");

	        console.log( "Mandamos el formulario" );

	    }else{
	        $("#notice").css("display", "block");
	        $('#notice').addClass('label-danger-ao');
	        $('#notice').addClass('text-center');
	        console.log( "Aun faltan campos" );
	    }

	}

    function viewRemider() {
    	if ( $('#checkboxRemider').prop('checked') == true ) {
    		
    		$("#recordatorio").css("display", "block");
    	}else {
    		$("#recordatorio").css("display", "none");
    	}
    }

    function showRecordatorio() {
	    $("#evento").css("display", "none");
	    $("#recordatorio").css("display", "block");
	}

	function showRecordatorio2() {
	    // EventRecordatorio2
	    if( $("#EventRecordatorio1").val() == 0 ) {
	        $("#divRecordatorio2").css("display", "none");
	    }else {
	        $("#divRecordatorio2").css("display", "block");
	    }
	}

    function returnViewInfo() {
        $("#eventInfo").modal('show');
    }
    
    function searchLeadsDesarrolloInmueble(){

        var selectDesarrollo = document.getElementById("FormCreateEventDesarrolloId");
        var lengthDesarrollo = selectDesarrollo.options.length;
        var i = 0;
        for (i = lengthDesarrollo-1; i >= 0; i--) {
        selectDesarrollo.options[i] = null;
        }

        var select = document.getElementById("FormCreateEventInmuebleId");
        var length = select.options.length;
        for (i = length-1; i >= 0; i--) {
        select.options[i] = null;
        }

        $('<option>').val(0).text('Seleccione una opción').appendTo($("#FormCreateEventDesarrolloId"));
        $('<option>').val(0).text('Seleccione una opción').appendTo($("#FormCreateEventInmuebleId"));
        $('.chzn-select').trigger('chosen:updated');

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "leads", "action" => "get_options_desarrollos")); ?>/' + $('#FormCreateEventClienteId').val() ,
            cache: false,
            success: function ( response ) {
                            
                $.each(JSON.parse(response), function(key, value) {              
                    $('<option>').val('').text('select');
                    $('<option>').val(key).text(value).appendTo($("#FormCreateEventDesarrolloId"));
                });

                $('.chzn-select').trigger('chosen:updated');

            }
        });

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "leads", "action" => "get_options_inmuebles")); ?>/' + $('#FormCreateEventClienteId').val() ,
            cache: false,
            success: function ( response ) {
                            
                $.each(JSON.parse(response), function(key, value) {              
                    $('<option>').val('').text('select');
                    $('<option>').val(key).text(value).appendTo($("#FormCreateEventInmuebleId"));
                });

                $('.chzn-select').trigger('chosen:updated');

            }
        });

    }

    // Fucion para mostrar los campos de desarrollo e inmubeles.
    function showInputsProps() {

        if( $("#FormCreateEventTipoTarea").val() == 0 || $("#FormCreateEventTipoTarea").val() == 1 ) {
            
            $("#addEvento-camposCitaVisita").css("display", "block");
        }else {
            
            $("#addEvento-camposCitaVisita").css("display", "none");
        }

    }

    function disableInputProps() {

        if( $("#FormCreateEventDesarrolloId").val() != 0 ) {
            
            $('#FormCreateEventInmuebleId').prop('disabled', true).trigger("chosen:updated");
        }else {
            $('#FormCreateEventInmuebleId').prop('disabled', false).trigger("chosen:updated");
        }

        if( $("#FormCreateEventInmuebleId").val() != 0 ) {
            
            $('#FormCreateEventDesarrolloId').prop('disabled', true).trigger("chosen:updated");
        }else {
            $('#FormCreateEventDesarrolloId').prop('disabled', false).trigger("chosen:updated");
        }

    }

    // Funcion de detalle
    function viewEvent(titulo, fechaInicial, ubicacion, asesor, tipoTarea, status, asesorId, clienteId, urlUbicacion, eventId, fechaIniF, horaIniF, minutoIniF, desarrolloId, inmuebleId, recordatorio1, recordatorio2, optRecordatorio1, optRecordatorio2) {

        var base_url = window.location;
        $("#eventInfo").modal('show');
        var recordatorioSec = '';

        if( recordatorio2 != undefined ) {
        	recordatorioSec = ' <i class="fa fa-bell-o fa-lg"></i> ' + recordatorio2;
        }

        // Definimos los valores que se mostraran

        document.getElementById("infoEvento-titulo").innerHTML = '<a href=" <?= Router::url(array("controller" => "clientes", "action" => "view")); ?>/'+clienteId+'"> '+titulo+' </a>';
        document.getElementById("botones-accion").innerHTML = '';

        if( tipoTarea == 0 ){

            <?php if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5 ): ?>
                document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span><label> &nbsp;&nbsp;</label><span><span class="disabled"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </span></span>';
                document.getElementById("infoEvent-recordatorio").innerHTML = ' <i class="fa fa-bell-o fa-lg"></i> <span>' + recordatorio1 + '' + recordatorioSec + '</span>';
            <?php else: ?>
                document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span><label> &nbsp;&nbsp;</label><span><a href="'+urlUbicacion+'"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </a></span>';
                document.getElementById("infoEvent-recordatorio").innerHTML = ' <i class="fa fa-bell-o fa-lg"></i> <span>' + recordatorio1 + '' + recordatorioSec + '</span>';
            <?php endif; ?>


            if( status == 0 ) {
                <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>

                    $("#botones-accion").html("<a class='pointer' rel='noreferrer' onclick='editEvent();' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR'> <i class='fa fa-pencil fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='cancelarEvent('+eventId+');'style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='confirmarEvent('+eventId+');' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check fa-lg'></i></a>");

                <?php else: ?>
                
                    $("#botones-accion").html("<a class='pointer' rel='noreferrer' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR' class='disabled'> <i class='fa fa-pencil fa-lg'></i></a> <a class='pointer' rel='noreferrer' style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR' class='disabled'><i class='fa fa-close fa-lg'></i></a> <a class='pointer' rel='noreferrer' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR' class='disabled'> <i class='fa fa-check fa-lg'></i></a>");

                <?php endif; ?>
            }else if( status == 1 ) {


                <?php if( $this->Session->read('Permisos.Group.id') != 5 ): ?>

                    $("#botones-accion").html("<a class='pointer' rel='noreferrer' onclick='editEvent();' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR'> <i class='fa fa-pencil fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='cancelarEvent("+eventId+");' style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='confirmarEvent("+eventId+");' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check fa-lg'></i></a>");

                <?php else: ?>

                    $("#botones-accion").html("<a class='disabled' rel='noreferrer' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR'> <i class='fa fa-pencil fa-lg'></i></a> <a class='disabled' rel='noreferrer' style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close fa-lg'></i></a> <a class='disabled' rel='noreferrer' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check fa-lg'></i></a>");

                <?php endif; ?>

            }else {

                document.getElementById("botones-accion").innerHTML = '';
            }

        }else if( tipoTarea == 1 ){

            <?php if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5 ): ?>
                document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span></label> &nbsp;&nbsp;<label><span><span class="disabled"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </span></span>';
                document.getElementById("botones-accion").innerHTML = '';
            <?php else: ?>
                document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span></label> &nbsp;&nbsp;<label><span><a href="'+urlUbicacion+'"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </a></span>';
                document.getElementById("botones-accion").innerHTML = '';
            <?php endif; ?>


            

        }else{
            document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span></label>';
        }

        <?php if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5 ): ?>
            document.getElementById("infoEvento-asesor").innerHTML = '<span class="disabled">'+asesor+'</span>';
        <?php else: ?>
            document.getElementById("infoEvento-asesor").innerHTML = '<a href=" <?= Router::url(array("controller" => "users", "action" => "view")); ?>/'+asesorId+'"> '+asesor+' </a>';
        <?php endif; ?>


        // Iniciallizamos los campos de edicion tambien.
        document.getElementById("editEventTitulo").innerHTML        = titulo;
        document.getElementById("editEventUbicacion").innerHTML     = '<i class="fa fa-map-marker fa-lg"></i> &nbsp;&nbsp;' + ubicacion;
        document.getElementById("editEventRecordatorio").innerHTML  = '<i class="fa fa-bell-o fa-lg"></i> &nbsp;&nbsp;' + recordatorio1 + '' + recordatorioSec;
        document.getElementById("editEventAsesor").innerHTML        = '<i class="fa fa-user fa-lg"></i> &nbsp;&nbsp;' + asesor;
        document.getElementById("edtiEventFechaInicial").innerHTML  = '<i class="fa fa-clock-o fa-lg"></i> &nbsp;&nbsp;' + fechaInicial;

        // Inicializar los campos para eportar el eventos a otros calendarios.
        // <span class="start">09/21/2021 08:00 AM</span>
        // <span class="end">09/21/2021 10:00 AM</span>
        // <span class="timezone">America/Los_Angeles</span>
        // <span class="title"></span>
        // <span class="description"></span>
        // <span class="location"></span>

        $(".title").html(titulo);
        $(".description").html(titulo+' en '+ubicacion+' a las '+horaIniF+':'+minutoIniF+' por el agente inmobiliario '+asesor);
        $(".location").html(ubicacion);
        $(".start").html(fechaInicial);

        $("#FormEditEventFechaInicial").val(fechaIniF);
        $("#FormEditEventHoraInicial").val(horaIniF);
        $("#FormEditEventMinutoInicial").val(minutoIniF);
        $("#FormEditEventEventoId").val(eventId);
        $("#FormEditEventUserId").val(asesorId);
        $("#FormEditEventFechaOrigen").val(fechaInicial);
        $("#FormEditEventClienteId").val(clienteId);
        $("#FormEditEventRecordatorio1").val(optRecordatorio1);
        $("#FormEditEventRecordatorio2").val(optRecordatorio2);

        console.log( optRecordatorio1 + ' y ' + optRecordatorio2 );
        $('.chzn-select').trigger('chosen:updated');
        

    }


    // Cancelar evento
    function cancelarEvent(eventId) {
    
        $("#eventInfo").modal('hide');
        $("#eventStatusUpdate").modal('show');
        document.getElementById("labelStatusUpdate").innerHTML = '¿Desea cancelar el evento?';
        $("#formUpdateEventEventoId").val(eventId);
        $("#formUpdateEventStatus").val(2);

        // Mostrar div para cancelacion
        $("#campos-cancelacion-eventos").removeClass('hide');

    }

    // Confirmar evento
    function confirmarEvent(eventId) {
        
        $("#eventInfo").modal('hide');
        $("#eventStatusUpdate").modal('show');
        document.getElementById("labelStatusUpdate").innerHTML = '¿Desea confirmar el evento?';
        $("#formUpdateEventEventoId").val(eventId);
        $("#formUpdateEventStatus").val(1);
        
        // Mostrar div para cancelacion
        $("#campos-cancelacion-eventos").addClass('hide');
    }

    // Agregar funcion de actualizacion de estatus
    function buttonEventStatusUpdate() {
        $("#eventStatusUpdate").modal('hide');
        $("#FormStatusUpdate").submit();
    }

    function editEvent() {
        $("#eventInfo").modal('hide');
        $("#editEvent").modal('show');
    }

</script>

<?= $this->Html->script(
        array(
        	'/vendors/bootstrap-switch/js/bootstrap-switch.min',
			'/vendors/switchery/js/switchery.min',
        	'pages/radio_checkbox'
        ),
        array('inline'=>false))
?>