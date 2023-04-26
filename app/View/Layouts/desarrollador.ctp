<!doctype html>
<html class="no-js" lang="es-MX">
<head>
   <meta charset="UTF-8">
    <title>INMO SYSTEM</title>
    <!--IE Compatibility modes-->
    <?php
        echo $this->Html->meta ( 'favicon.ico', '/img/favicon.png', array (
            'type' => 'icon' 
        ) );
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/logo1.ico"/>
    <!--global styles-->
    <?php echo $this->Html->css(array('components','custom')); ?>
    <!-- end of global styles-->
    <?php echo $this->fetch('css') ?>
    <?php echo $this->fetch('meta'); ?>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <?php // echo $this->Html->css('skins/inmosystem',array('id'=>'skin_change')); ?>
    <style>
       #map {
        height: 300px;
        width: 100%;
       }
       .no-print{display: none;}
    </style>
    
    <?php
        echo $scripts_for_layout;
        echo $this->Js->writeBuffer(array('cache' => TRUE));
    ?>
</head>
<style>
.modal-dialog-centered{margin-top: 15%;}
.flex-center{
    display: flex ;
    flex-direction: row ;
    flex-wrap: wrap ;
    justify-content: center ;
    align-items: center ;
    align-content: center ;
}
.chip{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; font-size: 1.1em; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
    .flex-center{display: flex ; flex-direction: row ; flex-wrap: wrap ; justify-content: center ; align-items: center ; align-content: center ;}
.bg_frio{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50); background: #5B9BD5;}
.bg_tibio{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);  background: #FFC000; }
.bg_caliente{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50); background: #C00000;}
.bg_venta{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50); background: #70AD47;}
.bg_renta{padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50); background: #86AF6B;}
/* bg color btn atencion-clientes */
.chip_bg_oportuno{background: #1F4E79; padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
.chip_bg_tardio{ background: #7030A0;  padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
.chip_bg_no_antendido{background: #DA19CA; padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}
.chip_bg_reasignar{background: #7F7F7F; padding-left: 5px ; padding-right:  5px; font-weight: 500; display:inline-block; border-radius: 5px; color: white; text-align: center; -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50); box-shadow: 3px 1px 16px rgba(184,184,184,0.50);}

.bg_oportuno{background: #1F4E79;}
.bg_tardio{ background: #7030A0; }
.bg_no_antendido{background: #DA19CA;}
.bg_reasignar{background: #7F7F7F;}
.bg_inactivo_temp{background: #B58800;}

.text_hidden{display: none;}
.fa_fa_edit{display: inline-block; font: normal normal normal 14px/1 FontAwesome; font-size: inherit; text-rendering: auto; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-size: 1.2rem;}
.fa_fa_edit:before, .fa-pencil-square-o:before {content: "\f044";}

.fa_fa_trash{display: inline-block; font: normal normal normal 14px/1 FontAwesome; font-size: inherit; text-rendering: auto; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; font-size: 1.2rem;}
.fa_fa_trash:before, .fa-pencil-square-o:before {content: "\f1f8";}
.bg-blue-is{background-color: #2e3c54; color:white;}
.float-right{float: right;}
.text-float-right{text-align: right;}
.text-center{text-align: center;}
.text-grey-black{color: #4F4D4D;}
</style>
<div class="modal fade" id="modal_error">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <div class="swal2-icon swal2-error animate-error-icon" style="display: block;"><span class="x-mark animate-x-mark"><span class="line left"></span><span class="line right"></span></span></div>
                </div>
            </div>
            <h3 style="color: black;"><?= $this->Session->flash('m_error'); ?></h3>
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="modal_success">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="swal2-icon swal2-success animate" style="display: block;"><span class="line tip animate-success-tip"></span> <span class="line long animate-success-long"></span><div class="placeholder"></div> <div class="fix"></div></div>
                </div>
            </div>
            <h3 style="color: black;"><?= $this->Session->flash('m_success'); ?></h3>
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
<body class="boxed fixedNav_position">
    <div class="bg-dark" id="wrap">
        <div id="top" class="fixed">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="https://inmosystem.com.mx" target="_blank">
                    <?= $this->Html->image('logo_inmosystem.png',array('class'=>'admin_img','alt'=>'Logo Inmosystem'))?>
                </a>
                <div class="menu">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
                <div class="topnav dropdown-menu-right float-xs-right">
                    <div class="btn-group hidden-md-up small_device_search" data-toggle="modal"
                         data-target="#search_modal">
                        <i class="fa fa-search text-primary"></i>
                    </div>
<!--                    <div class="btn-group">
                        <div class="notifications no-bg">
                            <a class="btn btn-default btn-sm messages" data-toggle="dropdown" id="messages_section"> <i
                                    class="fa fa-envelope-o fa-1x"></i>
                                <span class="tag tag-pill tag-warning notifications_tag_top">8</span>
                            </a>
                            <div class="dropdown-menu drop_box_align" role="menu" id="messages_dropdown">
                                <div class="popover-title">You have 8 Messages</div>
                                <div id="messages">
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/5.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data"><strong>hally</strong>
                                            sent you an image.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/8.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data"><strong>Meri</strong>
                                            invitation for party.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/7.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <strong>Remo</strong>
                                            meeting details .
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/6.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <strong>David</strong>
                                            upcoming events list.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/5.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data"><strong>hally</strong>
                                            sent you an image.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/8.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data"><strong>Meri</strong>
                                            invitation for party.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/7.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <strong>Remo</strong>
                                            meeting details .
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/6.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <strong>David</strong>
                                            upcoming events list.
                                            <br>
                                            <small>add to timeline</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="popover-footer">
                                    <a href="mail_inbox.html" class="text-white">Inbox</a>
                                </div>
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="btn-group">
                        <div class="notifications messages no-bg">
                            <a class="btn btn-default btn-sm" data-toggle="dropdown" id="notifications_section"> <i
                                    class="fa fa-bell-o"></i>
                                <span class="tag tag-pill tag-danger notifications_tag_top">9</span>
                            </a>
                            <div class="dropdown-menu drop_box_align" role="menu" id="notifications_dropdown">
                                <div class="popover-title">You have 9 Notifications</div>
                                <div id="notifications">
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/1.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Remo</strong>
                                            sent you an image
                                            <br>
                                            <small class="primary_txt">just now.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/2.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>clay</strong>
                                            business propasals
                                            <br>
                                            <small class="primary_txt">20min Back.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/3.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>John</strong>
                                            meeting at Ritz
                                            <br>
                                            <small class="primary_txt">2hrs Back.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/6.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Luicy</strong>
                                            Request Invitation
                                            <br>
                                            <small class="primary_txt">Yesterday.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/1.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Remo</strong>
                                            sent you an image
                                            <br>
                                            <small class="primary_txt">just now.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/2.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>clay</strong>
                                            business propasals
                                            <br>
                                            <small class="primary_txt">20min Back.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/3.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>John</strong>
                                            meeting at Ritz
                                            <br>
                                            <small class="primary_txt">2hrs Back.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/6.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Luicy</strong>
                                            Request Invitation
                                            <br>
                                            <small class="primary_txt">Yesterday.</small>
                                            <br></div>
                                    </div>
                                    <div class="data">
                                        <div class="col-xs-2">
                                            <img src="img/mailbox_imgs/1.jpg" class="message-img avatar rounded-circle"
                                                 alt="avatar1"></div>
                                        <div class="col-xs-10 message-data">
                                            <i class="fa fa-clock-o"></i>
                                            <strong>Remo</strong>
                                            sent you an image
                                            <br>
                                            <small class="primary_txt">just now.</small>
                                            <br></div>
                                    </div>
                                </div>

                                <div class="popover-footer">
                                    <a href="#" class="text-white">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="btn-group">
                        <div class="notifications request_section no-bg">
                            <a class="btn btn-default btn-sm messages" id="request_btn"> <i
                                    class="fa fa-sliders" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>-->
                    <div class="btn-group">
                        <div class="user-settings no-bg">
                            <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown" style="color: #FFF !important;">
                                <?php
                                    if ($this->Session->read('CuentaUsuario.User.foto')=="" || $this->Session->read('CuentaUsuario.User.foto')=="/img/"){
                                       echo $this->Html->image('usuarios/no_photo.png',array('class'=>'admin_img2 img-thumbnail rounded-circle avatar-img')); 
                                    }else{
                                       echo $this->Html->image($this->Session->read('CuentaUsuario.User.foto'),array('class'=>'admin_img2 img-thumbnail rounded-circle avatar-img'));
                                    }
                                    ?>
                                <?= $this->Session->read('CuentaUsuario.User.nombre_completo')?>
                                <span class="fa fa-sort-down white_bg"></span>
                            </button>
                            <div class="dropdown-menu admire_admin">
                                <?php //echo $this->Html->link('<i class="fa fa-cogs"></i> Mi cuenta',array('controller'=>'users','action'=>'view'),array('class'=>'dropdown-item','escape'=>false))?>
                                <?php $this->Html->link('<i class="fa fa-building"></i> Cambiar de Empresa',array('controller'=>'users','action'=>'cambiar_empresa'),array('class'=>'dropdown-item','escape'=>false))?>
                                <?= $this->Html->link('<i class="fa fa-lock"></i> Cambiar Password',array('controller'=>'users','action'=>'change_password'),array('class'=>'dropdown-item','escape'=>false))?>
                                <?= $this->Html->link('<i class="fa fa-sign-out"></i> Salir',array('controller'=>'users','action'=>'logout'),array('class'=>'dropdown-item','escape'=>false))?>
                            </div>
                        </div>
                    </div>

                </div>
<!--                <div class="top_search_box float-xs-right hidden-sm-down">
                    <form class="header_input_search float-xs-right">
                        <input type="text" placeholder="Search" name="search">
                        <button type="submit">
                            <span class="font-icon-search"></span>
                        </button>
                        <div class="overlay"></div>
                    </form>
                </div>-->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!-- /.navbar -->
        <!-- /.head -->
    </div>
    <!-- /#top -->
    <div class="wrapper fixedNav_top">
        
        <div id="left">
            <div class="menu_scroll">
                <div style="text-align: center;padding-top: 5%;padding-bottom: 5%;">
                <?php 
                        if ($this->Session->read('CuentaUsuario.Cuenta.logo')==""|| $this->Session->read('CuentaUsuario.Cuenta.logo')=="/img/"){
                            echo $this->Html->image('logo_inmosystem.png',array('class'=>'admin_img'));
                        }else{
                            echo $this->Html->image($this->Session->read('CuentaUsuario.Cuenta.logo'),array('class'=>'admin_img','style'=>'max-height:150px;max-width: 100%;padding-left: 5%;padding-right: 5%;padding-top: 5%;'));
                        }
                        ?>
                </div>
                
                <!-- /#menu -->
            </div>
        </div>
        <!-- /#left -->
       <?= $this->fetch('content')?> 
    </div>
</div>
   


<!-- global scripts-->
<?= $this->Html->script('components')?>
<?= $this->Html->script('custom')?>
<!--end of global scripts-->
<!--  plugin scripts -->
<?= $this->fetch('script')?>
<!--end of plugin scripts-->

</body>

</html>
<script>
    $(document).ready(function() {
    <?php if($this->Session->flash('error')){ ?>
        $("#modal_error").modal('show')
    <?php } ?>

    <?php if($this->Session->flash('success')){ ?>
      $("#modal_success").modal('show')
    <?php } ?>
    });
</script>
