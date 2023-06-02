<?= $this->Html->css(
    array(
        '/vendors/select2/css/select2.min',
        '/vendors/datatables/css/scroller.bootstrap.min',
        '/vendors/datatables/css/dataTables.bootstrap.min',
        'pages/dataTables.bootstrap',
        'pages/tables',
        '/vendors/datatables/css/colReorder.bootstrap.min',
        '/vendors/inputlimiter/css/jquery.inputlimiter',
        '/vendors/bootstrap-colorpicker/css/bootstrap-colorpicker.min',
        '/vendors/jquery-tagsinput/css/jquery.tagsinput',
        '/vendors/daterangepicker/css/daterangepicker',
        '/vendors/datepicker/css/bootstrap-datepicker.min',
        '/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min',
        '/vendors/bootstrap-switch/css/bootstrap-switch.min',
        '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
        '/vendors/j_timepicker/css/jquery.timepicker',
        '/vendors/datetimepicker/css/DateTimePicker.min',
        '/vendors/clockpicker/css/jquery-clockpicker',
        'pages/colorpicker_hack',
        'custom'
        //'pages/form_elements'
    ),
    array('inline'=>false));
    
   
?>
<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-lg-6 col-md-4 col-sm-4">
                <h4 class="nav_top_align">
                    Crear proceso 
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block">
                    <!-- Información superior -->
                    <div class="card-block" style="background-color:#f5f5f5 !important;border-radius:8px; padding:16px 0;">
                        <div class="row">
                        <?= $this->Form->create('Validations', array('type'=>'file'))?>
                            <div class="col-sm-12">
                                <div class="col-sm-12 col-lg-4 mt-2">
                                    <?= $this->Form->input('nombre', array(
                                        'class'       => 'form-control',
                                        'div'         => false,
                                        'placeholder' => 'Escribe un nombre para el proceso',
                                        'label'       => 'Nombre de proceso'
                                    )) ?>
                                </div> 
                                <div class="col-sm-12 col-lg-2 mt-2">
                                    <?= $this->Form->input('proceso', array(
                                        'class'       => 'form-control select',
                                        'div'         => false,
                                        'placeholder' => 'Selecciona etapa',
                                        'label'       => 'Etapa',
                                        'options'     =>  array(
                                            '5' => 'Etapa 5',
                                            '6' => 'Etapa 6',
                                            '7' => 'Etapa 7',
                                        )
                                    )) ?>
                                </div>
                            </div>
                        </div>
                        <?= $this->Form->hidden('cuenta_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id'))); ?>
                        <?= $this->Form->hidden('user_id', array('value'=>$this->Session->read('CuentaUsuario.CuentasUser.user_id'))); ?>
                        <div class="col-sm-12 mt-1">
                            <button type="submit" class="btn btn-primary float-right" style="margin-left:8px;">Aceptar</button>
                        </div>
                        <?= $this->Form->end(); ?>
                    </div>
                    
                    <div class="mt-5 col-sm-12">
                        <table class="table table-striped" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Creador
                                    </th>
                                    <th>
                                        Etapa
                                    </th>
                                    <th >
                                        Estatus
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                    <?= $this->Html->link('<i class="fa fa-edit" style="color:#215D9C;margin-left:8px;"></i>', '',array('escape' => false, 'controller'=>'desarrollos','action'=>'edit_proceso',$desarrollo['Desarrollo']['id']))?>
                                    </td>
                                    <td>
                                        Cristina Cruz Hernández
                                    </td>
                                    <td>
                                        Ana Luisa Medina del Toro
                                    </td>
                                    <td>
                                        5
                                    </td>
                                    <td>
                                        Activo
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

// ValidationsProcesoTablaForm
    $(document).on("submit", "#ValidationsProcesoTablaForm", function (event) {
        event.preventDefault();
        
        $.ajax({
            url        : '<?php echo Router::url(array("controller" => "Validations", "action" => "add")); ?>',
            type       : "POST",
            dataType   : "json",
            data       : new FormData(this),
            processData: false,
            contentType: false,
            // beforeSend: function () {
            //     $("#overlay").fadeIn();
            // },
            success: function (response) {
                // window.location.reload();
                console.log(response);
            },
            error: function ( response ) {

                document.getElementById("m_success").innerHTML = 'Ocurrio un problema al intentar guardar el apartado, favor de comunicarlo al administrador con el código ERC-001';
                location.reload();
            },
        });
    });

</script>