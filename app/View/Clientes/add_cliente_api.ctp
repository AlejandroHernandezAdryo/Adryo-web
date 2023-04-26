<?= $this->Html->css(
        array(

            'pages/layouts',
            
            '/vendors/chosen/css/chosen',
            '/vendors/fileinput/css/fileinput.min',
            
        ),
        array('inline'=>false))
?>

<style>
    .modal-dialog-centered{margin-top: 15%;}
    .fw-700{
        font-weight: 700;
    }
    .label-error{
        color: #E74C3C;
    }
    .flex-center{
        display: flex ;
        flex-direction: row ;
        flex-wrap: wrap ;
        justify-content: center ;
        align-items: center ;
        align-content: center ;
    }
    .chosen-results, .chosen-single{
        text-transform: uppercase;
    }
    .label-danger {color: #EF6F6C;}

    #info-cliente{
        display: none;
    }
    .inner {
        min-height: 93vh;
    }

</style>

<div id="content" class="bg-container">
    <header class="head">
    </header>
    <div class="outer">
        <div class="inner">
            <div class="row">
                <div class="col-sm-12 col-lg-8 offset-lg-2">
                    <div class="card">
                            <div class="card-header bg-blue-is">
                                <i class="fa fa-user-plus"></i> ------
                            </div>
                        <div class="card-block">
                            <div class="row">
                                <div class="col-sm-12">
                                    NOTHING TO SEE HERE
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
        '/vendors/chosen/js/chosen.jquery',
    ),
    array('inline'=>false))
?>
