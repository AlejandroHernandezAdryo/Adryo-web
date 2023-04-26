<?= $this->Html->css(
    array(

        '/vendors/swiper/css/swiper.min',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,200,1,200',
        'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200',
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
        'components_adryo'
    ),
    array('inline'=>false))
?>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-10">
                <h4 class="nav_top_align" style="font-size: 16px; margin-top:6px;"> Embudo de Ventas </h4>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-success float-xs-right" onclick='busquedaInfoAll()'>Filtrar embudo</button>
                <!-- <//?= $this->Form->submit('Filtrar Embudo', array('class'=>'btn btn-success float-xs-right <i class="fa fa-question"></i>')); ?> -->
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="row">
            <!-- Inputs de busqueda -->
            <div class="col-lg-12 bg-white pt-1">
                <div class="col-sm-12 col-lg-3 mb-1">
                    <div class="input-group">
                        <?= $this->Form->input('nombre_cliente',array('class'=>'form-control','placeholder'=>'Nombre de Cliente','label'=>false )); ?>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-3 mb-1">
                    <?= $this->Form->input('asesor_id',
                        array(
                            'type'        => 'select',
                            'options'     => $users,
                            'empty'       => 'Todos los usuarios',
                            'class'       => 'form-control chzn-select',
                            'placeholder' => 'Teléfono',
                            'label'       => false,
                            'value'       => ( ($this->Session->read('Permisos.Group.call') != 1 ) ? $this->Session->read('Auth.User.id') : '' ),
                            'disabled'    => ( ($this->Session->read('Permisos.Group.call') != 1 ) ? 'true' : 'false' )
                        )
                    ); ?>
                </div>
                <div class="col-sm-12 col-lg-3 mb-1">
                    <?= $this->Form->input('desarrollo_id',array('type'=>'select','options'=>$desarrollos,'empty'=>'Todos los desarrollos','class'=>'form-control chzn-select','placeholder'=>'Teléfono','label'=>false,)); ?>
                </div>
                <div class="col-sm-12 col-lg-3 mb-1">
                    <div class="input-group">
                        <?= $this->Form->input('rango_fechas', array('class'=>'form-control', 'placeholder'=>'Rango de fechas', 'div'=>'col-sm-12', 'id'=>'date_range', 'label'=>false, 'required'=>true, 'autocomplete'=>'off')); ?>
                    </div>
                </div>
            </div>
            <!-- Botones de etapas-->
            <div class="col-sm-12 bg-white">
                <div class="advice" style="padding-left:8px;"><p>* Da click en el apartado que deseas ver. <b>Recuerda que la información mostrada se despliega de Izquierda a Derecha</b></p></div>
                <div class="mb-4 row p-1" style="display:flex; flex-wrap:wrap;">
                    <p id="botonEtapas">
                        <div class="col filterButton">
                            <input type="checkbox" id="check_etapa_1" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" id="button_1" onclick='busquedaInfo(1,"primerEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_2" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2" id="button_2" onclick='busquedaInfo(2,"segundaEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_3" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3" id="button_3" onclick='busquedaInfo(3,"terceraEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_4" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample4" role="button" aria-expanded="false" aria-controls="multiCollapseExample4" id="button_4" onclick='busquedaInfo(4,"cuartaEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_5" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample5" role="button" aria-expanded="false" aria-controls="multiCollapseExample5" id="button_5" onclick='busquedaInfo(5,"quintaEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_6" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample6" role="button" aria-expanded="false" aria-controls="multiCollapseExample6" id="button_6" onclick='busquedaInfo(6,"sextaEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col">
                            <input type="checkbox" id="check_etapa_7" class="invisible" >
                            <a class="btn btn-primary btn-act mb-2" data-toggle="collapse" href="#multiCollapseExample7" role="button" aria-expanded="false" aria-controls="multiCollapseExample7" id="button_7" onclick='busquedaInfo(7,"septimaEtapaData")'>
                                
                            </a>
                        </div>
                        <div class="col invisible">
                            <input type="checkbox" id="check_etapa_8" class="invisible">
                            <button class="btn btn-primary  mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample8" aria-expanded="false" id="button_8" aria-controls="multiCollapseExample8" style="width:130px;">
                            </button>
                        </div>
                    </p>
                </div>
            </div>
            <!-- Columnas -->
            <div class="row">
                <div class="col-sm-12 bg-white" style="padding-left:40px;display:flex;overflow:scroll;">
                    <div style="width: fit-content; height: 80vh;display:flex;column-gap: 10px;">
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample1">
                            <div class="card card-o">
                                <div class="card-header position-relative mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center bg-light">
                                                <h2 style="color:black;margin:6px 0; display: inline-block;" id="titlePrimerEtapa"></h2> <h2 style="display: inline-block; color: black;" id="primerEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_1" value="oportuno" onclick = 'filterSelection();'>
                                                    <span class=""></span>
                                                    <label class="form-check-label text-black"  for="oportuno_filter_1"><small>Oportuno ( <span id="oportuno_label_1"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click checkmark-ta" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_1" value="tardio">
                                                    <label class="form-check-label text-black"  for="tardio_filter_1"><small>Tardío ( <span id="tardio_label_1"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click checkmark-na" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_1" value="no atendido">
                                                    <label class="form-check-label text-black"  for="noatendido_filter_1"><small>No atendido ( <span id="noatendido_label_1"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click checkmark-pr" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_1" value="por reasignar">
                                                    <label class="form-check-label text-black"  for="reasignar_filter_1"><small>Por reasignar ( <span id="reasignar_label_1"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="primerEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample2">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                            <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleSegundaEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="segundaEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_2" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_2"><small>Oportuno ( <span id="oportuno_label_2"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_2" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_2"><small>Tardío ( <span id="tardio_label_2"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_2" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_2"><small>No atendido ( <span id="noatendido_label_2"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_2" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_2"><small>Por reasignar ( <span id="reasignar_label_2"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="segundaEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample3">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                            <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleTercerEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="terceraEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_3" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_3"><small>Oportuno ( <span id="oportuno_label_3"></span> ) </small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_3" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_3"><small>Tardío ( <span id="tardio_label_3"></span> ) </small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_3" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_3"><small>No atendido ( <span id="noatendido_label_3"></span> ) </small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_3" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_3"><small>Por reasignar ( <span id="reasignar_label_3"></span> ) </small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="terceraEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample4">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                            <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleCuartaEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="cuartaEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_4" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_4"><small>Oportuno ( <span id="oportuno_label_4"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_4" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_4"><small>Tardío ( <span id="tardio_label_4"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_4" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_4"><small>No atendido ( <span id="noatendido_label_4"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_4" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_4"><small>Por reasignar ( <span id="reasignar_label_4"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="cuartaEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample5">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                                <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleQuintaEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="quintaEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_5" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_5"><small>Oportuno ( <span id="oportuno_label_5"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_5" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_5"><small>Tardío ( <span id="tardio_label_5"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_5" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_5"><small>No atendido ( <span id="noatendido_label_5"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_5" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_5"><small>Por reasignar ( <span id="reasignar_label_5"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="quintaEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample6">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                                <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleSextaEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="sextaEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_6" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_6"><small>Oportuno ( <span id="oportuno_label_6"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_6" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_6"><small>Tardío ( <span id="tardio_label_6"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_6" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_6"><small>No atendido ( <span id="noatendido_label_6"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked style="color" class="form-check-input click" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_6" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_6"><small>Por reasignar ( <span id="reasignar_label_6"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="sextaEtapaData"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column-pipe collapse multi-collapse" style="width: 440px;" id="multiCollapseExample7">
                            <div class="card card-o">
                                <div class="card-header position-relative bg-light mb-1 pb-1">
                                    <div class="row mb-1">
                                        <div class="col-sm-12">
                                            <div id="simple-list-example" class="d-flex flex-column gap-2 simple-list-example-scrollspy text-center">
                                                <h2 style="color:black;margin:6px 0; display: inline-block;" id="titleSeptimaEtapa"> </h2> <h2 style="display: inline-block; color: black;" id="septimaEtapaDataContador"></h2>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked class="form-check-input click check-oportuno" type="checkbox" style="border-radius: 100%;" name="" id="oportuno_filter_7" value="oportuno">
                                                    <label class="form-check-label text-black" for="oportuno_filter_7"><small>Oportuno ( <span id="oportuno_label_7"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked class="form-check-input click check-tardio" type="checkbox" style="border-radius: 100%;" name="" id="tardio_filter_7" value="tardio">
                                                    <label class="form-check-label text-black" for="tardio_filter_7"><small>Tardío ( <span id="tardio_label_7"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="radio" style="display: flex;justify-content: space-evenly;">
                                                <div class="form-check form-check-inline check-atendido" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked class="form-check-input click check-noaten" type="checkbox" style="border-radius: 100%;" name="" id="noatendido_filter_7" value="no atendido">
                                                    <label class="form-check-label text-black" for="noatendido_filter_7"><small>No atendido ( <span id="noatendido_label_7"></span> )</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="position: relative;display: inline-flex;padding-left: 1.0rem;margin-bottom: 0;cursor: pointer;align-items: center;">
                                                    <input checked class="form-check-input click check-reasignar" type="checkbox" style="border-radius: 100%;" name="" id="reasignar_filter_7" value="por reasignar">
                                                    <label class="form-check-label text-black" for="reasignar_filter_7"><small>Por reasignar ( <span id="reasignar_label_7"></span> )</small></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: scroll; height: 60vh;">
                                        <div id="septimaEtapaData"></div>
                                    </div>
                                </div>
                            </div>
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
            'components_adryo'

        ),
        array('inline'=>false))
?>

<script>
    'use strict';
    // Chozen select
    $(".hide_search").chosen({disable_search_threshold: 10});
    $(".chzn-select").chosen({allow_single_deselect: true});
    $(".chzn-select-deselect,#select2_sample").chosen();



    $( "#button_1").click(function() {
        if (document.getElementById("check_etapa_1").checked == true){
            document.getElementById("check_etapa_1").checked = false;
            $("#button_1").removeClass("btn-e1");
        } else {
            document.getElementById("check_etapa_1").checked = true;
            $("#button_1").addClass("btn-e1");
        }
    });
    $( "#button_2").click(function() {
        if (document.getElementById("check_etapa_2").checked == true){
            document.getElementById("check_etapa_2").checked = false;
            $("#button_2").removeClass("btn-e2");
        } else {
            document.getElementById("check_etapa_2").checked = true;
            $("#button_2").addClass("btn-e2");
        }
    });
    $( "#button_3").click(function() {
        if (document.getElementById("check_etapa_3").checked == true){
            document.getElementById("check_etapa_3").checked = false;
            $("#button_3").removeClass("btn-e3");
        } else {
            document.getElementById("check_etapa_3").checked = true;
            $("#button_3").addClass("btn-e3");
        }
    });
    $( "#button_4").click(function() {
        if (document.getElementById("check_etapa_4").checked == true){
            document.getElementById("check_etapa_4").checked = false;
            $("#button_4").removeClass("btn-e4");
        } else {
            document.getElementById("check_etapa_4").checked = true;
            $("#button_4").addClass("btn-e4");
        }
    });
    $( "#button_5").click(function() {
        if (document.getElementById("check_etapa_5").checked == true){
            document.getElementById("check_etapa_5").checked = false;
            $("#button_5").removeClass("btn-e5");
        } else {
            document.getElementById("check_etapa_5").checked = true;
            $("#button_5").addClass("btn-e5");
        }
    });
    $( "#button_6").click(function() {
        if (document.getElementById("check_etapa_6").checked == true){
            document.getElementById("check_etapa_6").checked = false;
            $("#button_6").removeClass("btn-e6");
        } else {
            document.getElementById("check_etapa_6").checked = true;
            $("#button_6").addClass("btn-e6");
        }
    });
    $( "#button_7").click(function() {
        if (document.getElementById("check_etapa_7").checked == true){
            document.getElementById("check_etapa_7").checked = false;
            $("#button_7").removeClass("btn-e7");
        } else {
            document.getElementById("check_etapa_7").checked = true;
            $("#button_7").addClass("btn-e7");
        }
    });

    function busquedaInfo(etapa_id, id_row){
        let dataSend = { 
            cuenta_id: "<?= $this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'); ?>", 
            etapa: etapa_id, 
            nombre: $('#nombre_cliente').val(), 
            user_id: $('#asesor_id').val(), 
            desarrollo_id: $('#desarrollo_id').val(),
            rango_fechas: $('#date_range').val()
        };
        $("#"+id_row).empty();

        $.ajax({
            type: "POST",
            url: '<?php echo Router::url(array("controller" => "LogClientesEtapas", "action" => "get_list_etapa")); ?>',
            data: dataSend,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                // $("#overlay").fadeIn();
            },
            success: function ( response ) {

                console.log( response );

                $("#oportuno_label_"+etapa_id).html(response['oportunos']);
                $("#tardio_label_"+etapa_id).html(response['tardios']);
                $("#noatendido_label_"+etapa_id).html(response['no_atendidos']);
                $("#reasignar_label_"+etapa_id).html(response['por_reasignar']);


                $("#"+id_row+"Contador").html( "("+response['clientes'].length+")" );
                $("#"+id_row+"Contador").html( "("+response['clientes'].length+")" );
                $("#"+id_row+"Contador").html( "("+response['clientes'].length+")" );
                $("#"+id_row+"Contador").html( "("+response['clientes'].length+")" );

                // $("#noatendido_label_1").html('1');

                $("#"+id_row+"Contador").html( "("+response['clientes'].length+")" );
                
                for (let i in response['clientes'] ){
                    
                    let cliente    = response['clientes'][i].Cliente;
                    let desarrollo = response['clientes'][i].Desarrollo;
                    let inmueble   = response['clientes'][i].Inmueble;
                    let log        = response['clientes'][i].LogClientesEtapa;
                    let user       = response['clientes'][i].User;
                    
                    // Ejemplo de como se debe pintar el html dentro de un div, el div padre es primerEtapaData
                    $("#"+id_row).append(`
                    <div class="col-sm-12 p-1 filterDiv `+cliente.class_filter+`">
                        <div class="card" style="display:flex; border-radius:8px;">
                            <div class="`+cliente.class_pleca+` pleca rounded-start"></div>
                            <div class="card-block border-1 rounded-4 p-2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span style="display: inline-block;">
                                            <h5 class="text-black" style="font-size:1.25rem;">
                                                <a class="underline" href="<?= Router::url(array('action' => 'view', 'controller' => 'clientes')); ?>/`+cliente.id+`">
                                                    `+cliente.nombre+`
                                                </a>
                                            </h5> 
                                        </span>
                                        <span style="float: right;color:black;display:flex;flex-direction:column;">
                                            <small style="text-transform: lowercase;"> Cambio de etapa</small>
                                            <small> `+log.fecha+` </small> 
                                        </span>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-12">
                                        <p style="font-size: 1rem; margin-bottom:0;color:black;">
                                            `+log.propieades_show+`
                                            <span style="float: right;">
                                                <small class="badge rounded-pill `+cliente.class+` " style="padding: 2px 4px;border-radius: 25px;">
                                                    `+cliente.estatus_atencion+`
                                                </small>
                                            </span>
                                        </p>
                                        <p class="asesor" style="font-size: 1rem;color:black;">
                                            `+user.nombre_completo+`
                                        </p>
                                    </div>
                                </div> 
                                <div class="row hidden" id="data-seg-1">
                                    <div class="col-sm-12 col-lg-7 align-middle" style="display:flex;align-content: center;flex-direction: column;justify-content: flex-start;color:black;">
                                        <span class="material-symbols-rounded icon-x1">
                                            call 
                                        </span>
                                        <small>
                                            `+cliente.telefono1+`
                                        </small>
                                    </div>
                                    <div class="col-sm-12 col-lg-5 align-middle" style="display:flex;align-content: center;flex-direction: column;justify-content: flex-start;color:black;">
                                        <span class="material-symbols-rounded icon-x1">
                                            add_circle
                                        </span>
                                        <small>
                                            Creado: `+cliente.created+`
                                        </small>
                                    </div>
                                    <div class="col-sm-12 col-lg-7 align-middle" style="display:flex;align-content: center;flex-direction: column;justify-content: flex-start;color:black;">
                                        <span class="material-symbols-rounded icon-x1">
                                            mail
                                        </span>
                                        <small>
                                            `+cliente.correo_electronico+`
                                        </small>
                                    </div>
                                    <div class="col-sm-12 col-lg-5 align-middle" style="display:flex;align-content: center;flex-direction: column;justify-content: flex-start;color:black;">
                                        <span class="material-symbols-rounded icon-x1">
                                            calendar_month
                                        </span>
                                        <small>
                                            Ult Seg: `+cliente.last_edit+`
                                        </small>
                                    </div>
                                </div>
                                <!-- Notas -->
                                <div class="row hidden" id="data-notas">
                                    <div class="col-sm-12 mt-2">
                                        <input type="text" class="form-control form-control-sm" placeholder="Notas">
                                    </div>
                                </div>
                                <!-- Botones de accion -->
                                <!-- <div class="row pr-2">
                                    <div class="col mt-1 float-right" style="display:flex;flex-direction:row;">
                                        <span>
                                            Siguiente etapa
                                        </span>
                                        <span class="material-symbols-outlined float-end cursor-pointer">
                                            arrow_forward
                                        </span>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div> `
                    );
                }

            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });

    }

    function busquedaInfoAll(){
        
        $("#primerEtapaData").empty();
        $("#segundaEtapaData").empty();
        $("#terceraEtapaData").empty();
        $("#cuartaEtapaData").empty();
        $("#quintaEtapaData").empty();
        $("#sextaEtapaData").empty();
        $("#septimaEtapaData").empty();

        busquedaInfo(1,"primerEtapaData");
        busquedaInfo(2,"segundaEtapaData");
        busquedaInfo(3,"terceraEtapaData");
        busquedaInfo(4,"cuartaEtapaData");
        busquedaInfo(5,"quintaEtapaData");
        busquedaInfo(6,"sextaEtapaData");
        busquedaInfo(7,"septimaEtapaData");
        
    }

    filterSelection("all")

    function filterSelection( ){

        let x, i;
        let valor = $("#op_e1").val();
        // c = valor.toLowerCase();
        let c = valor;
        
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

    function titleRow(){
        $.ajax({
            type: "GET",
            url: '<?php echo Router::url(array("controller" => "DicEmbudoVentas", "action" => "view_etapas")); ?>/'+<?= $this->Session->read('CuentaUsuario.Cuenta.id');?>,
            cache: false,
            dataType: 'json',
            beforeSend: function () {
                // $("#overlay").fadeIn();
            },
            success: function ( response ) {
                console.log( response );

                $("#button_1").html( '1.- '+response[1] );
                $("#button_2").html( '2.- '+response[2] );
                $("#button_3").html( '3.- '+response[3] );
                $("#button_4").html( '4.- '+response[4] );
                $("#button_5").html( '5.- '+response[5] );
                $("#button_6").html( '6.- '+response[6] );
                $("#button_7").html( '7.- '+response[7] );


                $("#titlePrimerEtapa").html(    '1.- '+response[1] );
                $("#titleSegundaEtapa").html(   '2.- '+response[2] );
                $("#titleTercerEtapa").html(    '3.- '+response[3] );
                $("#titleCuartaEtapa").html(    '4.- '+response[4] );
                $("#titleQuintaEtapa").html(    '5.- '+response[5] );
                $("#titleSextaEtapa").html(     '6.- '+response[6] );
                $("#titleSeptimaEtapa").html(   '7.- '+response[7] );
            },
            error: function ( err ){
                console.log( err.responseText );
            }
        });
    }
    titleRow();

    $(document).ready(function () {
        document.querySelectorAll(".click").forEach(el => {
            el.addEventListener("click", e => {
                const id = e.target.getAttribute("id");
                console.log("Se ha clickeado el id "+id);
                
                if( $('#'+id).prop('checked') ) {
                    $('.'+id).show();
                } else {
                    $('.'+id).hide();
                }
                
            });
        });

        $('#date_range').daterangepicker({
            orientation:"bottom",
            autoUpdateInput: false,
            locale: {
            cancelLabel: 'Limpiar'
            }
        });
        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            return false;
        });
        $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            return false;
        });
        $('[data-toggle="popover"]').popover();
    });

</script>

<!-- <div class="row filterDiv `+cliente.class_filter+` "> -->



