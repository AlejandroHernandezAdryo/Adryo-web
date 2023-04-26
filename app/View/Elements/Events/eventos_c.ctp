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
.float-left {float: left;}
</style>


<!-- Modal para agregar evento desde cualquier pagina en donde se mande a llamar. -->
<div class="modal fade" id="editEvento" tabindex="-1" role="dialog" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-blue-is">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-toggle ="tooltip" title="CERRAR">&times;</button>
                <h4 class="modal-title" id="addEvento-header"><i class="fa fa-calendar"></i>&nbsp;&nbsp; Agregar evento</h4>
            </div> <!-- Modal Header -->

            <div class="modal-body">
            
                <div class="form-add-event">

                    <?= $this->Form->create('FormEditEvent', array('id'=>'FormEditEvent', 'url' => array('action' => 'add', 'controller'=> 'events' ) )); ?>

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

                        
                        <div class="modal-footer mt-2">
                            <div class="row mt-2">
                                
                                <div class="col-sm-12">
                                    
                                    <button type="button" class="btn btn-danger float-left" data-dismiss="modal">
                                        Cancelar
                                    </button>

                                    <button class="btn btn-success float-right" type="submit">
                                        Guardar evento
                                    </button>

                                </div>
                            </div>
                        </div>

                    <?= $this->Form->end();  ?>

                </div>
            
            </div>

        </div>
    </div>
</div>





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

    "use strict";
    $(document).ready(function() {

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