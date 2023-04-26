<style>
.notice {display: none;}
.form-control-danger {border: 1px solid #EF6F6C;}
.label-danger-ao {color: #EF6F6C;}
#addEvento-camposCitaVisita, #divRecordatorio2, #editEvento-header, #form-editEvent, #addEvento-warningCitaVisita {display: none;}
.chosen-results, .chosen-single {text-transform: uppercase;}
h2 {color: #434343 !important;}
#infoEvento-titulo {font-size: 16px; margin-bottom: -3px;}
.fc-today > span {font-size: 14px; background-color: #2e3c54 !important; padding: 1px !important; border-radius: 50px; color: #FFF; height: 24px !important; width: 24px !important; margin-left: 42%; margin-top: 1px;}
.fc-today {background-color: #F0F0F0 !important;}
.fc-ltr .fc-basic-view .fc-day-top .fc-day-number  {float: none !important; text-align: center; display: inline-block; margin-top: 6px !important;}
.fc-day-number  {display: block !important;}
#labelStatusUpdate{font-size: 1.2rem;}

</style>



<div class="modal fade" id="eventInfo" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title" id="infoEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Información del evento</h4>
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
                </div>
                <div class="modal-footer">
                    <?= $this->Form->button('Cerrar', array('type'=>'button','class'=>'btn btn-error float-xs-right', 'data-dismiss' => 'modal')); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de visualizacion de evento -->


<div class="modal fade" id="addEvento" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title" id="addEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Agregar evento</h4>
                <h4 class="modal-title" id="editEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Editar evento</h4>
            </div> <!-- Modal Header -->

            <div id="form-addEvent">
                <?= $this->Form->create('Event',array('id' => 'FormEventAdd','url'=>array('action'=>'add','controller'=>'events')))?>
                <div class="modal-body">

                    <div id="notice"></div>

                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#evento" data-toggle="tab" onclick="showEvento()">Evento</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#recordatorio" data-toggle="tab"  onclick="showRecordatorio()">Recordatorio</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="evento">
                            <div class="row">
                                <?= $this->Form->input('tipo_tarea', array(
                                    'type'     => 'select',
                                    'options'  => $tipo_tarea_opciones,
                                    'onchange' => 'despliegeCampos();',
                                    'class'    => 'form-control',
                                    'div'      => array('class'=> 'col-sm-12 mt-2'),
                                    'label'    => array('text' => 'Tipo de evento*', 'id' => 'lEventTipoTarea'),
                                    'required' => true,
                                    'empty'    => array(999=>'Seleccione una opción'),
                                )); ?>
                            </div>
                            
                            <div class="row mt-1">
                                <?= $this->Form->input('fechaInicial', array(
                                    'class'       => 'form-control fecha',
                                    'div'         => array('class'=> 'col-sm-12 col-lg-6'),
                                    'label'    => array('text' => 'Fecha*', 'id' => 'lEventFecha'),
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

                            <div class="row mt-1" id="addEvento-warningCitaVisita">
                                <div class="col-sm-12">
                                    <label style="color: #f89815; ">* Es necesario llenar los campos en el siguiente orden, "cliente", "asesor", "inmueble o desarrollo".</label>
                                </div>
                            </div>
            
                            <div class="row">
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
                                        'options'      => $inmuebles_opciones,
                                        'class'        => 'form-control chzn-select',
                                        'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                        'label'    => array('id' => 'lEventInmueble'),
                                        'empty'    => array(0=>'Seleccione una opción')
                                    )); ?>

                                    <?= $this->Form->input('desarrollo_id', array(
                                        'type'         => 'select',
                                        'options'      => $desarrollos_opciones,
                                        'class'        => 'form-control chzn-select',
                                        'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                        'label'    => array('id' => 'lEventDesarrollo'),
                                        'empty'    => array(0=>'Seleccione una opción')
                                    )); ?>
                                </div>
                            </div>
                            
                        </div>
        
                        <div class="tab-pane" id="recordatorio">
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
                    </div> <!-- End tab-content -->

                </div>
                <div class="modal-footer">
                    <?= $this->Form->hidden('tipo_evento', array('value'=>'1')) ?>
                    <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))) ?>
                    <?= $this->Form->hidden('status', array('value'=>'0')) ?>
                    <?= $this->Form->hidden('return', array('value'=> $return)) ?>
                    <?= $this->Form->button('Guardar evento', array('class'=>'btn btn-success', 'type'=>'button', 'onclick' => 'submitAddEvent()', 'id' => 'btnSubmitAddEvent')); ?>
                </div>
                <?= $this->Form->end() ?>
            </div>

            <div id="form-editEvent">
                <?= $this->Form->create('EventEdit',array('url'=>array('action'=>'edit','controller'=>'events')))?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#evento" data-toggle="tab" onclick="showEvento()">Evento</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#recordatorio" data-toggle="tab"  onclick="showRecordatorio()">Recordatorio</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="tab-content">

                        <div class="tab-pane active" id="evento">
                            <div class="row">
                                <?= $this->Form->input('edit_tipo_tarea', array(
                                    'type'     => 'select',
                                    'options'  => $tipo_tarea_opciones,
                                    'onchange' => 'despliegeCampos();',
                                    'class'    => 'form-control',
                                    'div'      => array('class'=> 'col-sm-12 mt-2'),
                                    'label'    => 'Tipo de evento',
                                    'required' => true,
                                    'empty'    => array(999=>'Seleccione una opción')
                                )); ?>
                            </div>
                            
                            <div class="row mt-1">
                                <?= $this->Form->input('edit_fechaInicial', array(
                                    'class'       => 'form-control fecha',
                                    'div'         => array('class'=> 'col-sm-12 col-lg-6'),
                                    'label'       => 'Fecha*',
                                    'placeholder' => 'dd-mm-YYYY',
                                    'required'    => true,
                                    'autocomplete' => 'off',
                                )); ?>
            
                                <?= $this->Form->input('edit_horaInicial', array(
                                    'type'         => 'select',
                                    'options'      => $hours,
                                    'class'        => 'form-control',
                                    'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                                    'label'        => 'Hora*',
                                    'placeholder'  => 'H',
                                    'required'     => true,
                                    'autocomplete' => 'off',
                                )); ?>
            
                                <?= $this->Form->input('edit_minutoInicial', array(
                                    'type'         => 'select',
                                    'options'      => $minutos,
                                    'class'        => 'form-control',
                                    'div'          => array('class' => 'clockpicker2 col-sm-12 col-lg-3'),
                                    'label'        => 'Minutos*',
                                    'placeholder'  => 'm',
                                    'required'     => true,
                                    'autocomplete' => 'off',
                                )); ?>
                            </div>
                            
                            <div class="row mt-1">
                                <?= $this->Form->input('edit_cliente_id', array(
                                    'type'         => 'select',
                                    'options'      => $clientes,
                                    'class'        => 'form-control chzn-select',
                                    'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'        => 'Cliente*',
                                    'empty'    => array(0=>'Seleccione una opción')
                                )); ?>
            
                                <?= $this->Form->input('edit_user_id', array(
                                    'type'         => 'select',
                                    'options'      => $asesores,
                                    'class'        => 'form-control chzn-select',
                                    'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'        => 'Asesor*',
                                    'empty'    => array(0=>'Seleccione una opción')
                                )); ?>
                            </div>

                            <div id="editEvento-camposCitaVisita">
                                <div class="row mt-1">
                                    <?= $this->Form->input('edit_desarrollo_id', array(
                                        'type'         => 'select',
                                        'options'      => $desarrollos,
                                        'class'        => 'form-control chzn-select',
                                        'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                        'label'        => 'Desarrollo',
                                        'empty'    => array(0=>'Seleccione una opción')
                                    )); ?>
                                    <?= $this->Form->input('edit_inmueble_id', array(
                                        'type'         => 'select',
                                        'options'      => $inmuebles,
                                        'class'        => 'form-control chzn-select',
                                        'div'          => array('class' => 'col-sm-12 col-lg-6'),
                                        'label'        => 'Inmueble',
                                        'empty'    => array(0=>'Seleccione una opción')
                                    )); ?>
                                </div>
                            </div>
                            
                        </div>
        
                        <div class="tab-pane" id="recordatorio">
                            <div class="row mt-1">
                                <?= $this->Form->input('edit_recordatorio_1', array(
                                    'type'     => 'select',
                                    'options'  => $recordatorios,
                                    'class'    => 'form-control chzn-select',
                                    'div'      => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'    => 'Recordatorio',
                                    'onchange' => 'showRecordatorio2();',
                                    'empty'    => array(0=>'Seleccione una opción')
                                )); ?>
            
                                <?= $this->Form->input('edit_recordatorio_2', array(
                                    'type'    => 'select',
                                    'options' => $recordatorios,
                                    'class'   => 'form-control chzn-select',
                                    'div'     => array('class' => 'col-sm-12 col-lg-6', 'id' => 'divRecordatorio2'),
                                    'label'   => 'Recordatorio 2',
                                )); ?>
                            </div>
                        </div>
                    </div> <!-- End tab-content -->

                </div>
                <div class="modal-footer">
                    <?= $this->Form->hidden('tipo_evento', array('value'=>'1')) ?>
                    <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))) ?>
                    <?= $this->Form->hidden('status', array('value'=>'0')) ?>
                    <?= $this->Form->hidden('return', array('value'=> $return)) ?>
                    <?= $this->Form->button('Cancelar', array('type'=>'button','class'=>'btn btn-error float-xs-right', 'onclick'=>'cancelarEdicion()')); ?>
                    <?= $this->Form->submit('Guardar evento', array('class'=>'btn btn-success pull-left')); ?>

                </div>
                <?= $this->Form->end() ?>
            </div> <!-- Fin form edit event -->
            
        </div>
    </div>
</div>
<!-- Modal para agregar evento y editarlo -->



<?= $this->Html->script(
        array(
            'components',
            'custom',
            'form',

            // Calendario
            '/vendors/jasny-bootstrap/js/inputmask',
            '/vendors/datetimepicker/js/DateTimePicker.min',
            '/vendors/j_timepicker/js/jquery.timepicker.min',
            '/vendors/clockpicker/js/jquery-clockpicker.min',
            // 'pages/form_elements',
        ),
        array('inline'=>false))
?>


<script>
function submitAddEvent() {
    flag = true;
    

    if($('#EventFechaInicial').val() == ''){
        flag = false;
        $('#lEventFecha').addClass('label-danger-ao');
        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
    }else{
        $('#lEventFecha').removeClass('label-danger-ao');
    }


    if($('#EventClienteId').val() == 0){
        flag = false;
        $('#lEventCliente').addClass('label-danger-ao');
        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
    }else{
        $('#lEventCliente').removeClass('label-danger-ao');
    }

    if($('#EventUserId').val() == 0){
        flag = false;
        $('#lEventAsesor').addClass('label-danger-ao');
        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
    }else{
        $('#lEventAsesor').removeClass('label-danger-ao');
    }

    if($('#EventTipoTarea').val() == 999){
        flag = false;
        $('#lEventTipoTarea').addClass('label-danger-ao');
        document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
        if ($('#EventTipoTarea').val() == 0 || $('#EventTipoTarea').val() == 1) {
            if ($('#EventDesarrolloId').val() == 0 && $('#EventInmuebleId').val() == 0) {
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
        if ($('#EventTipoTarea').val() == 0 || $('#EventTipoTarea').val() == 1) {
            if ($('#EventDesarrolloId').val() == 0 && $('#EventInmuebleId').val() == 0) {
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
        $("#FormEventAdd").submit();

        $("#btnSubmitAddEvent").addClass("disabled");
        $("#btnSubmitAddEvent").css("display", "none");

        $("#addEvento").modal("hide");
    }else{
        $("#notice").css("display", "block");
        // document.getElementById("notice").innerHTML = ' <i class="fa fa-warning fa-lg"></i> Es necesario completar los campos marcados con rojo y *';
        $('#notice').addClass('label-danger-ao');
        $('#notice').addClass('text-center');
    }

}

// Funcion para despligue de campos en formulario
function despliegeCampos() {
    if( $("#EventTipoTarea").val() <= 1 ) {
        $("#addEvento-camposCitaVisita").css("display", "block");
        $("#addEvento-warningCitaVisita").css("display", "block");
    }else if ($("#EventTipoTarea").val() == 999) {
        $("#addEvento-camposCitaVisita").css("display", "none");
        $("#addEvento-warningCitaVisita").css("display", "none");
    }else {
        $("#addEvento-camposCitaVisita").css("display", "none");
        $("#addEvento-warningCitaVisita").css("display", "none");
    }
}


// Funcion de detalle
function viewEvent(titulo, fechaInicial, ubicacion, asesor, tipoTarea, status, asesorId, clienteId, urlUbicacion, eventId, fechaIniF, horaIniF, minutoIniF, desarrolloId, inmuebleId, recordatorio1) {
    $("#eventInfo").modal('show');

    // Definimos los valores que se mostraran

    document.getElementById("infoEvento-titulo").innerHTML = '<a href="../clientes/view/'+clienteId+'"> '+titulo+' </a>';
    document.getElementById("botones-accion").innerHTML = '';

    if( tipoTarea == 0 ){
        document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span><label> &nbsp;&nbsp;</label><span><a href="'+urlUbicacion+'"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </a></span>';

        document.getElementById("infoEvent-recordatorio").innerHTML = ' <i class="fa fa-bell-o fa-lg"></i> <span>'+recordatorio1+'</span>';

        if( status == 0 ) {
            $("#botones-accion").html("<a class='pointer' rel='noreferrer' onclick='editEvent();' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR'> <i class='fa fa-pencil fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='cancelarEvent('+eventId+');'style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='confirmarEvent('+eventId+');' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check fa-lg'></i></a>");
        }else if( status == 1 ) {
            $("#botones-accion").html("<a class='pointer' rel='noreferrer' onclick='editEvent();' style='padding: 10px;' data-toggle ='tooltip' title='EDITAR'> <i class='fa fa-pencil fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='cancelarEvent("+eventId+");' style='padding: 10px;' data-toggle ='tooltip' title='CANCELAR'> <i class='fa fa-close fa-lg'></i></a> <a class='pointer' rel='noreferrer' onclick='confirmarEvent("+eventId+");' style='padding: 10px;' data-toggle  ='tooltip' title='CONFIRMAR'> <i class='fa fa-check fa-lg'></i></a>");
        }else {
            document.getElementById("botones-accion").innerHTML = '';
        }

    }else if( tipoTarea == 1 ){
        document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span></label> &nbsp;&nbsp;<label><span><a href="'+urlUbicacion+'"> <i class="fa fa-map-marker fa-lg"></i> '+ubicacion+' </a></span>';

        document.getElementById("botones-accion").innerHTML = '';

    }else{
        document.getElementById("infoEvent-master").innerHTML = ' <i class="fa fa-clock-o fa-lg"></i> <span>'+fechaInicial+'</span></label>';
    }

    document.getElementById("infoEvento-asesor").innerHTML = '<a href="../users/view/'+asesorId+'"> <i class="fa fa-user fa-lg"></i> '+asesor+' </a>';


    // Iniciallizamos los campos de edicion tambien.
    $("#EventEditTipoTarea").val(tipoTarea);
    $("#EventEditFechaInicial").val(fechaIniF);
    $("#EventEditHoraInicial").val(horaIniF)
    $("#EventEditMinutoInicial").val(minutoIniF)
    $("#EventEditDesarrolloId").val(desarrolloId)
    $("#EventEditInmuebleId").val(inmuebleId)
    $("#EventEditClienteId").val(clienteId)
    $("#EventEditUserId").val(asesorId)
    // $("#EventEditRecordatorio1").val()
    // $("#EventEditRecordatorio2").val()
    $('.chzn-select').trigger('chosen:updated');
}


function showEvento() {
    $("#evento").css("display", "block");
    $("#recordatorio").css("display", "none");
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

// function editEvent(tipoTarea, fechaIniF) {
function editEvent() {
    $("#addEvento-header").css("display", "none");
    $("#editEvento-header").css("display", "block");
    $("#form-editEvent").css("display", "block");
    $("#form-addEvent").css("display", "none");
    $("#eventInfo").modal('hide');
    $("#addEvento").modal('show');
}


function searchLeadsDesarrolloInmueble(){

    var selectDesarrollo = document.getElementById("EventDesarrolloId");
    var lengthDesarrollo = selectDesarrollo.options.length;
    for (i = lengthDesarrollo-1; i >= 0; i--) {
      selectDesarrollo.options[i] = null;
    }

    var select = document.getElementById("EventInmuebleId");
    var length = select.options.length;
    for (i = length-1; i >= 0; i--) {
      select.options[i] = null;
    }

    $('<option>').val(0).text('Seleccione una opción').appendTo($("#EventDesarrolloId"));
    $('<option>').val(0).text('Seleccione una opción').appendTo($("#EventInmuebleId"));



    $('.chzn-select').trigger('chosen:updated');

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "leads", "action" => "get_options_desarrollos")); ?>/' + $('#EventClienteId').val() ,
        cache: false,
        success: function ( response ) {
                        
            $.each(JSON.parse(response), function(key, value) {              
                $('<option>').val('').text('select');
                $('<option>').val(key).text(value).appendTo($("#EventDesarrolloId"));
            });

            $('.chzn-select').trigger('chosen:updated');

        }
    });

    $.ajax({
        type: "POST",
        url: '<?php echo Router::url(array("controller" => "leads", "action" => "get_options_inmuebles")); ?>/' + $('#EventClienteId').val() ,
        cache: false,
        success: function ( response ) {
                        
            $.each(JSON.parse(response), function(key, value) {              
                $('<option>').val('').text('select');
                $('<option>').val(key).text(value).appendTo($("#EventInmuebleId"));
            });

            $('.chzn-select').trigger('chosen:updated');

        }
    });

}


"use strict";
$(document).ready(function() {

    // $('#date_range').daterangepicker({
    //     orientation:"bottom",
    //     autoUpdateInput: false,
    //     locale: {
    //         cancelLabel: 'Clear'
    //     }
    // });

    // Date picker
    $('.fecha').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
        orientation:"bottom",
        startDate: "<?= date('d-m-Y'); ?>",
    });

});

</script>