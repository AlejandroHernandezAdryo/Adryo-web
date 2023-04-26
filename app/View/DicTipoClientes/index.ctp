<?= $this->Html->css('/vendors/select2/css/select2.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/scroller.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('/vendors/datatables/css/dataTables.bootstrap.min',array('inline'=>false)) ?>
<?= $this->Html->css('pages/dataTables.bootstrap',array('inline'=>false)) ?>
<?= $this->Html->css('pages/tables',array('inline'=>false)) ?>

<div id="content" class="bg-container">
    <header class="head">
                <div class="main-bar row">
                    <div class="col-lg-6 col-md-4 col-sm-4">
                        <h4 class="nav_top_align">
                            <i class="fa fa-th"></i>
                            Diccionario de Tipo de clientes
                            
                        </h4>
                    </div>
                    
                </div>
            </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card">
                        <div class="card-header bg-white">
                            <i class="fa fa-plus"></i> Agregar Tipo de cliente
                        </div>
                        <div class="card-block">
                            <div class="card-block m-t-20">
                                            <?php echo $this->Form->create('DicTipoCliente')?>
                                            <div class="input-group">
                                            <input type="search" class="form-control" name="data[DicTipoCliente][tipo_cliente]" id="DicTipoClienteTipoCliente">
                                                    <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit">
                                                    <span class="glyphicon glyphicon-search" aria-hidden="true">
                                                </span> Agregar Tipo de cliente</button>
                                                </span>
                                                </div>
                                            
                                            <?php echo $this->Form->input('cuenta_id', array('type'=>'hidden','value'=>$this->Session->read('CuentaUsuario.CuentasUser.cuenta_id')))?>
                                            
                                        </div>
                                        
                        </div>
                    </div>
        </div>
        <div class="inner bg-light lter bg-container">
            <div class="card">
                        <div class="card-header bg-white">
                            <i class="fa fa-book"> </i> Tipo de clientes
                        </div>
                        <div class="card-block">
                            <div class="m-t-35">
                                <table id="example" class="table display nowrap" >
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Tipo de cliente</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($tipo_clientes as $tipo):?>

                                    <tr>
                                        <td><?= $tipo['DicTipoCliente']['id']?></td>
                                        <td><?= $tipo['DicTipoCliente']['tipo_cliente']?></td>
                                        
                                    </tr>
                                    <?php endforeach;?>
                                   </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
        </div>
    </div>

</div>


<?php 
    echo $this->Html->script([
        '/vendors/select2/js/select2',
        '/vendors/datatables/js/jquery.dataTables.min',
        '/vendors/datatables/js/dataTables.bootstrap.min',
        /*'/vendors/datatables/js/dataTables.colReorder.min',
        'pluginjs/dataTables.tableTools',
        '/vendors/datatables/js/dataTables.buttons.min',
        '/vendors/datatables/js/dataTables.responsive.min',
        '/vendors/datatables/js/dataTables.rowReorder.min',
        '/vendors/datatables/js/buttons.colVis.min',
        '/vendors/datatables/js/buttons.html5.min',
        '/vendors/datatables/js/buttons.bootstrap.min',
        '/vendors/datatables/js/buttons.print.min',
        '/vendors/datatables/js/dataTables.scroller.min',
        'pages/datatable',*/
        'pages/advanced_tables'
    ], array('inline'=>false));
?>
