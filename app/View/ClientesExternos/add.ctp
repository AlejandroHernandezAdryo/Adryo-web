<?= $this->Html->css(
        array(
           '/vendors/datatables/css/dataTables.bootstrap.min',
            'pages/dataTables.bootstrap',
            'pages/tables',
            
            '/vendors/datatables/css/colReorder.bootstrap.min',
                      
        ),
        array('inline'=>false))
?>

<div id="content" class="bg-container">
    <header class="head">
        <div class="main-bar row">
            <div class="col-sm-12 col-md-4 col-lg-6">
                <h4 class="nav_top_align">
                    <i class="fa fa-users"></i>
                    Alta de Proveedores
                </h4>
            </div>
            
        </div>
    </header>
    <div class="outer">
        <div class="inner bg-light lter bg-container">
            <div class="card ">
            </div>
        </div>
    </div>
</div>


<?php 
    echo $this->Html->script([
        'custom',
        'components',
    ], array('inline'=>false));
?>

<script>
'use strict';
$(document).ready(function () {

});
</script>