
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

<?= $this->element('Events/eventos_abc'); ?>



<div class="modal fade" id="searchEvent" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <?= $this->Form->create('Event', array('url'=>array('action'=>'calendar', 'controller'=>'users'))) ?>

        <div class="modal-content">
        <div class="modal-header bg-blue-is">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
            <h4 class="modal-title" id="searchEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Filtro de eventos</h4>
        </div> <!-- Modal Header -->
            <div class="modal-body">
                
                <div class="row mt-1">
                    <?= $this->Form->input('asesor_id', array(
                        'type'    => 'select',
                        'options' => $asesores,
                        'class'   => 'form-control chzn-select',
                        'div'     => array('class' => 'col-sm-12 col-lg-6'),
                        'label'   => 'Asesor',
                        'empty'   => array(0=>'Todos los asesores')
                    )); ?>
                    <?= $this->Form->input('cliente_id', array(
                        'type'    => 'select',
                        'options' => $clientes,
                        'class'   => 'form-control chzn-select',
                        'div'     => array('class' => 'col-sm-12 col-lg-6'),
                        'label'   => 'Cliente',
                        'empty'   => array(0=>'Todos los clientes')
                    )); ?>
                </div> <!-- Fin del bloque de mostrara los datos del evento -->


                <div class="row mt-1">
                    <?= $this->Form->input('desarrollo_id', array(
                        'type'    => 'select',
                        'options' => $opt_desarrollos,
                        'class'   => 'form-control chzn-select',
                        'div'     => array('class' => 'col-sm-12 col-lg-6'),
                        'label'   => 'Desarrollo',
                        'empty'   => array(0=>'Todos los desarrollos')
                    )); ?>



                    <?php 
                        if( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 5 ) {
                            echo $this->Form->input('inmueble_id', array(
                                'type'    => 'select',
                                    'class'   => 'form-control disabled',
                                    'div'     => array('class' => 'col-sm-12 col-lg-6'),
                                    'label'   => 'Inmueble',
                                    'empty'   => array(0=>'Todos los inmuebles')
                                ));
                        }else {
                            
                            echo $this->Form->input('inmueble_id', array(
                            'type'    => 'select',
                                'options' => $opt_inmuebles,
                                'class'   => 'form-control chzn-select',
                                'div'     => array('class' => 'col-sm-12 col-lg-6'),
                                'label'   => 'Inmueble',
                                'empty'   => array(0=>'Todos los inmuebles')
                            ));

                        }

                    ?>

                </div> <!-- Fin del bloque de mostrara los datos del evento -->

                <div class="row mt-1">
                    <?= $this->Form->input('tipo_tarea', array(
                        'type'    => 'select',
                        'options' => $tipo_tarea,
                        'class'   => 'form-control chzn-select',
                        'div'     => array('class' => 'col-sm-12 col-lg-6'),
                        'label'   => 'Tipo de evento',
                        'empty'   => array(''=>'Todos los eventos')
                    )); ?>

                    <?= $this->Form->input('status', array(
                        'type'    => 'select',
                        'options' => $status,
                        'class'   => 'form-control chzn-select',
                        'div'     => array('class' => 'col-sm-12 col-lg-6'),
                        'label'   => 'Estatus de evento',
                        'empty'   => array(''=>'Todos los estatus')
                    )); ?>
                </div> <!-- Fin del bloque de mostrara los datos del evento -->

                <div class="row mt-1">
                <!-- <?= 
                    $this->Form->input('rango_fechas', array(
                        'class'        => 'form-control',
                        'placeholder'  => 'dd/mm/yyyy - dd/mm/yyyy',
                        'div'          => 'col-sm-12',
                        'label'        => 'Rango de fechas',
                        'id'           => 'date_range',
                        'required'     => true,
                        'autocomplete' => 'off'
                    )); 
                ?> -->
                </div> <!-- Fin del bloque de mostrara los datos del evento -->

                <div class="modal-footer mt-3">
                    <?= $this->Form->submit('Filtrar', array('class'=>'btn btn-success float-xs-right')); ?>
                    <?= $this->Form->button('Cancelar', array('class'=>'btn btn-danger pull-left', 'data-dismiss' => 'modal')); ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>



<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-12">
                <h4 class="nav_top_align"><i class="fa fa-calendar"></i> Calendario</h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner lter bg-container">
            <div class="card mt-1">
                <div class="card-header bg-blue-is">
                    <a href="#" data-toggle="modal" data-target="#searchEvent" class="text-white btn btn-sm btn-primary">
                        <i class="fa fa-filter"></i>
                        Filtros
                    </a>
                    
                    <span class="float-right">
                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            <a  href="#" class="btn btn-sm disabled" >
                                <i class="fa fa-plus"></i> Agregar Evento
                            </a>
                        <?php else: ?>
                            <a  href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addEvento">
                                <i class="fa fa-plus"></i> Agregar Evento
                            </a>
                        <?php endif; ?>

                    </span>
                </div>

                <div class="card-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="calendar" class="mt-2"></div>
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
        ),
        array('inline'=>false))
?>

<script>

"use strict";
$(document).ready(function() {
    
$('#date_range').daterangepicker({
    orientation:"bottom",
    autoUpdateInput: false,
    locale: {
        cancelLabel: 'Clear'
    }
});
    
 /* initialize the external events
  -----------------------------------------------------------------*/
 function ini_events(ele) {
     ele.each(function() {

         var eventObject = {
             title: $.trim($(this).text())
         };

         $(this).data('eventObject', eventObject);

         // make the event draggable using jQuery UI
         $(this).draggable({
             zIndex: 1070,
             revert: true,
             revertDuration: 0
         });
     });
 }
 ini_events($('#external-events div.external-event'));
 var evt_obj;

 /* initialize the calendar */
 //Date for the calendar events (dummy data)
 var date = new Date();
 var d = date.getDate(),
     m = date.getMonth(),
     y = date.getFullYear();
 $('#calendar').fullCalendar({
     displayEventTime: false,
     header: {
         left: 'prev,next today',
         center: 'title',
         right: 'month,agendaWeek,agendaDay'
     },
     buttonText: {
         prev: "",
         next: "",
         today: 'Hoy',
         month: 'M',
         week: 'S',
         day: 'D'
     },
     
     events:[
        <?php foreach($data_eventos as $evento): ?>
            {
                title          : '<?= $evento['titulo'] ?>',
                start          : new Date('<?= $evento['fecha_inicio'] ?>'),
                backgroundColor: "<?= $evento['color'] ?>",
                textColor      : "<?= $evento['textColor'] ?>",
                icon           : "<?= $evento['icon'] ?>",
                url            : "<?= $evento['url'] ?>"
            },
        <?php endforeach; ?>
     ],
     editable: true,
     droppable: false,
     eventLimit: true,
     eventLimitText: " por ver",
     drop: function(date, allDay) {

         // retrieve the dropped element's stored Event Object
         var originalEventObject = $(this).data('eventObject');

         // we need to copy it, so that multiple events don't have a reference to the same object
         var copiedEventObject = $.extend({}, originalEventObject);
         var $calendar_tag= $(".calendar_tag");
         // assign it the date that was reported
         copiedEventObject.start = date;
         copiedEventObject.allDay = allDay;
         copiedEventObject.backgroundColor = $(this).css("background-color");
         copiedEventObject.borderColor = $(this).css("border-color");

         $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
         $calendar_tag.text(parseInt($calendar_tag.text()) + 1);
         // is the "remove after drop" checkbox checked?
         if ($('#drop-remove').is(':checked')) {
             $(this).remove();
         }
         setpopover();
     },
     eventDrop: function() {
         setTimeout(setpopover,100);
     },
     eventResize:function() {
         setTimeout(setpopover,100);
     },
     eventRender: function(event, element) {
        if(event.icon){          
            element.find(".fc-title").prepend("<i class='fa fa-"+event.icon+"'></i> ");
        }
    }
     
 });

 /* ADDING EVENTS */
 var currColor = "#737373"; //default
 //Color chooser button
 var colorChooser = $(".color-chooser-btn");
 $(".color-chooser > li").on('click',function(e) {
     e.preventDefault();
     //Save color
     currColor = $(this).css("background-color");
     //Add color effect to button
     colorChooser
         .css({
             "background-color": currColor,
             "border-color": currColor
         })
         .html($(this).text() + ' <span class="caret"></span>');
 });
 $("#add-new-event").on('click',function(e) {
     e.preventDefault();
     //Get value and make sure it is not null
     var $newevent = $("#new-event");
     var val       = $newevent.val();
     if (val.length == 0) {
         return;
     }

     //Create event
     var event = $("<div />");
     event.css({
         "background-color": currColor,
         "border-color": currColor,
         "color": "#fff"
     }).addClass("external-event");
     event.html(val).append(' <i class="fa fa-times event-clear" aria-hidden="true"></i>');
     $('#external-events').prepend(event);

     //Add draggable funtionality
     ini_events(event);

     //Remove event from text input
     $newevent.val("");
 });
 $("body").on("click", "#external-events .event-clear", function() {
     $(this).closest(".external-event").remove();
     return false;
 });
 $(".modal-dialog [data-dismiss='modal']").on('click', function() {
     $("#new-event").replaceWith('<input type="text" id="new-event" class="form-control" placeholder="Event">');
 });

 function setpopover() {
     $(".fc-month-view").find(".fc-event-container a").each(function() {
         $(this).popover({
             placement: 'top',
             html: true,
             content: $(this).text(),
             trigger: 'hover'
         });
     });
     $(".fc-month-button").on('click',function () {
         $(".fc-event-container a").each(function() {
             $(this).popover({
                 placement: 'top',
                 html: true,
                 content: $(this).text(),
                 trigger: 'hover'
             });
         });
         return false;
     })
 }
 $(".fc-center").find('h2').css('font-size', '18px');
 setpopover();
 
 $(".chzn-select").chosen({allow_single_deselect: true});
});
</script>