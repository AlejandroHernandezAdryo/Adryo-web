<?= $this->Html->css(
        array(
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            'pages/wizards',
            '/vendors/jquery-validation-engine/css/validationEngine.jquery',
            '/vendors/bootstrapvalidator/css/bootstrapValidator.min',
            '/css/pages/form_validations',
            '/vendors/fileinput/css/fileinput.min',
            'pages/form_elements',
            
            ),
        array('inline'=>false))
        
?>

<div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-12">
                        <h4 class="nav_top_align"><i class="fa fa-lock"></i>Editar Permisos de Grupo</h4> 
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container ">
                    <div class="row">
                            
                            <div class="col-xl-12">
                                <div class="card m-t-35">
                                    <div class="card-header bg-white">
                                        <i class="fa fa-file-building"></i>
                                        Editar Permisos de grupo
                                        
                                    </div>
                                    <div id="rootwizard">
                                    <div class="card-block m-t-35">
                                            <?= $this->Form->create('Group')?>
                                            <?php 
                                                echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')));
                                            ?>
                                            <div class="form-group row">
                                                <div class="col-xl-2">
                                                    <label for="nombre" class="form-control-label">Nombre Grupo</label>
                                                </div>
                                                <?= $this->Form->input('nombre',array('label'=>false,'class'=>'form-control required','div'=>'col-md-10','required'=>false))?>
                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-xl-2">
                                                    <label for="descripcion" class="form-control-label">Descripción</label>
                                                </div>
                                                <?= $this->Form->input('descripcion',array('label'=>false,'class'=>'form-control required','div'=>'col-md-10','required'=>false))?>
                                                
                                            </div>
                                        <table style="width: 100%">
                                            <tr>
                                                <th >Módulo</th>
                                                <th style="text-align:center">Consultar</th>
                                                <th style="text-align:center">Crear</th>
                                                <th style="text-align:center">Editar</th>
                                                <th style="text-align:center">Eliminar</th>
                                            </tr>
                                            <tr>
                                                <td>Usuarios</td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ur') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('uc') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ue') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ud') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Grupos de Usuario</td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('gr') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('gc') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ge') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('gd') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Clientes</td>
                                                <td style="text-align:center"><?php echo $this->Form->input('call',array('label'=>false,'type'=>'select','empty'=>'Seleccionar que clientes puede ver el grupo','options'=>array(1=>'Todos',2=>'Propios'))) ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('cc') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ce') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('cd') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Inmuebles</td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ir') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ic') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ie') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('idel') ?></td>
                                            </tr>
                                            <tr>
                                                <td>Desarrollos</td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('dr') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('dc') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('dr') ?></td>
                                                <td style="text-align:center"><?php echo $this->Form->checkbox('ddel') ?></td>
                                            </tr>
                                            
                                        </table>
                                            <div class="form-actions form-group row m-t-35">
                                                <div class="col-xl-12">
                                                    
                                                    <input type="submit" value="Actualizar Información" class="btn btn-success" style="width:100%">
                                                </div>
                                            </div>
                                            <?= $this->Form->end()?>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.row -->
                        
                        
                    </div>
                    
                </div>
            </div>
        </div>

 
<?= $this->Html->script(
        array(
            '/vendors/jquery-validation-engine/js/jquery.validationEngine',
            '/vendors/jquery-validation-engine/js/jquery.validationEngine-en',
            '/vendors/jquery-validation/js/jquery.validate',
            '/vendors/bootstrapvalidator/js/bootstrapValidator.min',
            '/vendors/moment/js/moment.min',
            'js/form',
            
            '/vendors/sweetalert/js/sweetalert2.min',
            
            
            '/vendors/inputmask/js/inputmask',
            '/vendors/inputmask/js/jquery.inputmask',
            '/vendors/fileinput/js/fileinput.min',
            '/vendors/fileinput/js/theme',
            
            
        ),
        array('inline'=>false))
?>

<?php
    $this->Html->scriptStart(array('inline' => false));
?>

<?php 
    $this->Html->scriptEnd();
?>



