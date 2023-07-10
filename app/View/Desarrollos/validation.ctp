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
                    Validaciones
                </h4>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card mt-1" id="inventory-detail">
                <div class="card-block">
                    <!-- Información superior -->
                    <div class="row" >
                    <div class="col-sm-12">
                        <button class="btn btn-secondary-o ml-4"><i class="fa fa-file-excel"></i> Descargar</button>
                        <button class="btn btn-secondary-o"><i class="fa fa-print"></i> Imprimir</button>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 col-lg-1 mt-2">
                                <?= $this->Form->input('contador', array(
                                    'class'       => 'form-control text-sm-center',
                                    'div'         => false,
                                    'placeholder' => 0,
                                    'label'       => false
                                )) ?>
                            </div> 
                            <div class="col-sm-12 col-lg-3 mt-2 offset-lg-8">
                                <?= $this->Form->input('contador', array(
                                    'class'       => 'form-control tools',
                                    'div'         => false,
                                    'placeholder' => 'Buscador',
                                    'label'       => false
                                )) ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-1 col-sm-12">
                        <table class="table table-striped" style="overflow:scroll;">
                            <thead>
                                <tr>
                                    <th>
                                        Acciones
                                    </th>
                                    <th>
                                        Cliente
                                    </th>
                                    <th>
                                        Propiedad
                                    </th>
                                    <th>
                                        Asesor
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
                                        <?= $this->Html->link('<i class="fa fa-eye" style="color:#215D9C;margin-left:8px;"></i>', array( 'controller'=>'desarrollos','action'=>'inicio_proceso'),array('escape' => false))?>
                                        <!-- </?= $this->Html->link('Icono',array('controller'=>'desarrollos','action'=>'inicio_proceso',$desarrollo['Desarrollo']['id']))?> -->
                                    </td>
                                    <td>
                                        Cristina Cruz Hernández
                                    </td>
                                    <td>
                                        Cumbres Herradura Tipo A depto 4
                                    </td>
                                    <td>
                                        Ana Luisa Medina del Toro
                                    </td>
                                    <td>
                                        5
                                    </td>
                                    <td style="text-align:right;">
                                        Rechazado
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="side-bar" onclick="mod()">
    </div>
</div>

<script>
    

</script>