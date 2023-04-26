<!doctype html>
<html class="no-js" lang="es-MX">
<head>
   <meta charset="UTF-8">
    <title>ADRYO</title>
    <!--IE Compatibility modes-->
    <?php
        echo $this->Html->meta ( 'favicon.ico', '/img/favicon.png', array (
            'type' => 'icon' 
        ) );
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--global styles-->
    <?php $this->Html->css(array('components','custom', 'pages/general_components')); ?>
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
       .no-print{display: none !important;}
       /*.finanzas{display: none !important;}*/

       .disable-custom {
           background-color: #bababa;
           color: #FFF !important;
       }
    </style>
    
    <?php
        echo $scripts_for_layout;
        echo $this->Js->writeBuffer(array('cache' => TRUE));
    ?>
    <script src="//code.jivosite.com/widget.js" data-jv-id="K3D8wzy6xr" async></script>
</head>
<style>
.modal-dialog-centered{margin-top: 15% !important;}
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


body{font-size: 1.07rem !important;}
.card-block{ padding-top: 1rem;}
.bg-emails{ background-color: #F0D38A;}
.bg-citas{ background-color: #AEE9EA;}
.bg-visitas{ background-color: #7CC3C4;}
.bg-llamadas{ background-color: #7AABF9;}
.bg-opciones{ background-color: #D6C0F8}
.text-black{color: #525252;}

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
<body class="fixedNav_position">
    <div class="bg-dark" id="wrap">
        <div id="top" class="fixed">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="https://adryo.com.mx" target="_blank">
                    <?= $this->Html->image('logo_inmosystem.png',array('class'=>'admin_img','alt'=>'Logo Adryo', 'style'=>'max-height: 46px !important;'))?>
                </a>
                <div class="menu">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
                </div>
                <div class="topnav dropdown-menu-right float-xs-right" style="margin-top: 14px;">
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
        
        <!-- <div id="left" class="fixed"> -->
        <div id="left" class="fixed">
            <!-- <div class="menu_scroll left_scrolled"> -->
            <div class="menu_scroll menu_scroll left_scrolled jspScrollable">
                <div style="text-align: center;padding-top: 5%;padding-bottom: 5%;">

                <?php 
                        if ($this->Session->read('CuentaUsuario.Cuenta.logo')==""|| $this->Session->read('CuentaUsuario.Cuenta.logo')=="/img/"){
                            echo $this->Html->image('logo_inmosystem.png',array('class'=>'admin_img'));
                        }else{
                            if (empty($this->Session->read('Desarrollador'))) {
                                echo $this->Html->image($this->Session->read('CuentaUsuario.Cuenta.logo'),array('class'=>'admin_img','style'=>'max-height:150px;max-width: 100%;padding-left: 5%;padding-right: 5%;padding-top: 5%;'));
                            }else{
                                if (!empty($this->Session->read('Desarrollador.Desarrollo.logotipo'))) {
                                    echo $this->Html->image($this->Session->read('Desarrollador.Desarrollo.logotipo'),array('class'=>'admin_img','alt'=>'Logo Inmosystem', 'style'=>'max-height:150px;max-width: 100%;padding-left: 5%;padding-right: 5%;padding-top: 5%;'));
                                }else{
                                    echo $this->Html->image($this->Session->read('CuentaUsuario.Cuenta.logo'),array('class'=>'admin_img','style'=>'max-height:150px;max-width: 100%;padding-left: 5%;padding-right: 5%;padding-top: 5%;'));
                                }
                            }
                        }
                        ?>
                </div>
                <ul id="menu" style="font-size: 1.03rem !important;">
                    <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                        
                        <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide"> Tablero</span>','#',array('escape'=>false, 'class'=>'disable-custom'))?></li>
                        
                        <li class="treeview">
                            <a href="#" class="disable-custom"><i class="fa fa-bar-chart-o"></i><span>Reportes avanzados</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li>
                                    <?= $this->Html->link('<span>Reporte de clientes</span>', '#', array('escape'=>false, 'class'=>'disable-custom'))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte por Asesor</span>', '#', array('escape'=>false, 'class'=>'disable-custom'))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte por Desarrollo</span>', '#', array('escape'=>false, 'class'=>'disable-custom'))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte de Medios de Promoción</span>', '#', array('escape'=>false, 'class'=>'disable-custom'))?>
                                    <?php $this->Html->link('<span>Reporte de Medios de Promoción</span>', '#', array('escape'=>false, 'class'=>'disable-custom'))?>
                                </li>

                            </ul>
                        </li>
                    
                    <?php else: ?>
                    
                        <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide"> Tablero</span>',array('controller'=>'users','action'=>'dashboard'),array('escape'=>false))?></li>
                        
                        <li class="treeview">
                            <a href="#"><i class="fa fa-bar-chart-o"></i><span>Reportes avanzados</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li>
                                    <?= $this->Html->link('<span>Reporte de clientes</span>', array('controller'=>'clientes', 'action'=>'reporte_c1'), array('escape'=>false))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte por Asesor</span>', array('controller'=>'users', 'action'=>'reporte_a1'), array('escape'=>false))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte por Desarrollo</span>', array('controller'=>'desarrollos', 'action'=>'reporte_d1'), array('escape'=>false))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<span>Reporte de Medios de Promoción</span>', '#', array('escape'=>false))?>
                                    <?php $this->Html->link('<span>Reporte de Medios de Promoción</span>', array('controller'=>'users', 'action'=>'reporte_m1'), array('escape'=>false))?>
                                </li>

                            </ul>
                        </li>

                    <?php endif; ?>



                    <li>
                        <?= $this->Html->link('<i class="fa fa-calendar"></i><span class="link-title menu_hide">Calendario</span>', array('controller'=>'users','action'=>'calendar'), array('escape'=>false))?>
                    </li>



                    <li class="treeview">
                        <a href="#">
                         <?php //if ($this->Session->read('Permisos.group_id')!=3){?>
                            <i class="fa fa-user"></i>
                            <span class="link-title menu_hide">Clientes</span>
                            <?php if (empty($this->Session->read('Desarrollador'))): /* Condicion para los desarrolladores */?>
                                <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide"><?= $this->Session->read('clundef')?></span>
                            <?php endif ?>
                         <?php 
                            //}else{
                         ?>
<!--                            <i class="fa fa-user"></i><span>Clientes</span>-->
                         <?php //}?>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          
                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-user-plus"></i><span class="link-title"> Agregar Cliente</span>','#',array('escape'=>false, 'class'=>'disable-custom'))?></li>

                        <?php else: ?>

                            <?php if ($this->Session->read('Permisos.Group.cc') == 1){?>
                            
                                
                                <li><?php echo $this->Html->link('<i class="fa fa-user-plus"></i><span class="link-title"> Agregar Cliente</span>',array('controller'=>'clientes','action'=>'add'),array('escape'=>false))?></li>
                                
                            <?php } ?>

                        <?php endif; ?>


                          <li><?= $this->Html->link('<i class="fa fa-filter"></i><span class="link-title"> Embudo de Ventas </span>',array('controller'=>'clientes','action'=>'pipeline'),array('escape'=>false))?></li>
                          <?php if ($this->Session->read('Permisos.Group.call')==1 || $this->Session->read('Permisos.Group.cown')){?>
                                <li><?php echo $this->Html->link('<i class="fa fa-list"></i><span class="link-title"> Listar Clientes </span>',array('controller'=>'clientes','action'=>'index'),array('escape'=>false))?></li>
                          <?php } ?>
                        <?php if ($this->Session->read('Permisos.Group.id')!=3){?>
                            <?php if (empty($this->Session->read('Desarrollador'))): /* Condicion para los desarrolladores */?>
                                <li><?php echo $this->Html->link('<i class="fa fa-home"></i><span class="link-title"> Clientes sin Asignar</span>',array('controller'=>'clientes','action'=>'sinasignar'),array('escape'=>false))?></li>
                            <?php endif ?>
                          <?php } ?>
                        </ul>
                      </li>
                      
                        <?php if ( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            <li class="treeview">
                                
                                <a href="#" class="disable-custom">
                                    <i class="fa fa-home"></i><span class="link-title menu_hide">Propiedades</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                
                                <ul class="treeview-menu">
                                    
                                    <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Subir propiedad</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?></li>
                                    
                                    <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listar propiedades','#',array('escape'=>false, 'class' => 'disable-custom'))?></li>

                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-home"></i><span class="link-title menu_hide">Propiedades</span>
                                  <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                  <?php if ($this->Session->read('Permisos.Group.ic')==1){?>
                                  <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Subir propiedad</span>',array('controller'=>'inmuebles','action'=>'add'),array('escape'=>false))?></li>
                                  <?php }?>
                                  <?php if ($this->Session->read('Permisos.Group.ir')==1){?>
                                <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listar propiedades',array('controller'=>'inmuebles','action'=>'index'),array('escape'=>false))?></li>
                                  <?php } ?>
                                </ul>
                            </li>
                        <?php endif; ?>



                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-building"></i><span class="link-title menu_hide">Desarrollos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>

                      <ul class="treeview-menu">
                            
                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Subir desarrollo</span>','#',array('escape'=>false, 'class'=>'disable-custom'))?></li>
                        
                        <?php elseif( $this->Session->read('Permisos.Group.dc') == 1): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Subir desarrollo</span>',array('controller'=>'desarrollos','action'=>'add'),array('escape'=>false))?></li>

                        <?php endif; ?>

                        <?php if ( $this->Session->read('Permisos.Group.dr') == 1 ): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listar Desarrollos',array('controller'=>'desarrollos','action'=>'index'),array('escape'=>false))?></li>

                        <?php endif; ?>

                      </ul>

                    </li>


                    <?php if ($this->Session->read('Permisos.Group.id')!=3){?>
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-users"></i><span class="link-title menu_hide"> Asesores</span>',array('controller'=>'users','action'=>'asesores'),array('escape'=>false))?>
                        </li>
                    <?php }?>
                    <?php if ($this->Session->read('Permisos.Group.id')!=3){?>
                        <?php if (empty($this->Session->read('Desarrollador'))): ?>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-spinner"></i><span class="link-title menu_hide"> Equipos de Trabajo</span>',array('controller'=>'gruposUsuarios','action'=>'index'),array('escape'=>false))?>
                            </li>
                        <?php endif ?>
                    <?php }?>
                    <?php if ($this->Session->read('CuentaUsuario.CuentasUser.finanzas')==1){?>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-bank"></i><span>Finanzas</span><span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide"><?= $this->Session->read('facturas_por_autorizar')?></span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-bank"></i> Cuentas bancarias',array('controller'=>'bancos','action'=>'index'),array('escape'=>false))?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-user"></i> Clientes Externos', array('controller'=>'clientes_externos','action'=>'index'),array('escape'=>false)) ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-users"></i> Proveedores',array('controller'=>'proveedors','action'=>'index'),array('escape'=>false))?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-money"></i>Ingresos', array('controller'=>'aportacions', 'action'=>'index'),array('escape'=>false)) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-money"></i>Ingresos a 30 Días', array('controller'=>'aportacions', 'action'=>'index',1),array('escape'=>false)) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-bars"></i>Gastos', array('controller'=>'facturas', 'action'=>'index'),array('escape'=>false)) ?>
                            </li>
                            <li>
                                <?= $this->Html->link('<i class="fa fa-check"></i>Mis Autorizaciones <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide">'.$this->Session->read('facturas_por_autorizar').'</span>', array('controller'=>'facturas', 'action'=>'por_autorizar'),array('escape'=>false)) ?>
                            </li> 
                        </ul>
                    </li>
                    <?php }?>
                    <?php if ($this->Session->read('Permisos.Group.vv') == 1): ?>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-dollar"></i><span>Ventas</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                              <li><?php echo $this->Html->link('<i class="fa fa-list-alt"></i> Lista de ventas',array('controller'=>'ventas','action'=>'sale_list'),array('escape'=>false))?></li>
                            </ul>
                        </li>
                    <?php endif ?>
                        <!-- <li><?php echo $this->Html->link('<i class="fa fa-envelope"></i><span class="link-title menu_hide"> webmail</span>',array('controller'=>'users','action'=>'inbox'),array('escape'=>false))?></li> -->
                    
<!--                    <li class="treeview">
                        <a href="#">
                         <i class="fa fa-briefcase"></i><span>Proveedores</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <?php //if ($this->Session->read('Permisos.Group.cc')==1){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Nuevo Proveedor </span>',array('controller'=>'proveedors','action'=>'add'),array('escape'=>false))?></li>
                          <?php //} ?>
                          <?php //if ($this->Session->read('Permisos.Group.call')==1 || $this->Session->read('Permisos.Group.cown')){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-bars"></i> Listar Proveedores',array('controller'=>'proveedors','action'=>'index'),array('escape'=>false))?></li>
                          <?php //} ?>

                        </ul>
                      </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-money"></i><span>Finanzas</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#">
                             <i class="fa fa-angle-double-right"></i><span>Gastos</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Nuevo gasto</span>',array('controller'=>'facturas','action'=>'seleccionar_proyecto'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> Listar Gastos</span>',array('controller'=>'facturas','action'=>'index'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span> Listar Gastos Pendientes</span>',array('controller'=>'facturas','action'=>'programa'),array('escape'=>false))?>  </li>
                            </ul>
                          </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-angle-double-left"></i><span>Ingresos</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Nuevo ingreso</span>',array('controller'=>'aportacions','action'=>'add'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> Listar Ingresos</span>',array('controller'=>'aportacions','action'=>'index'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span> Listar Ingresos Pendientes</span>',array('controller'=>'aportacions','action'=>'programa'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          <li><?php echo $this->Html->link('<i class="fa fa-clock-o"></i> Nueva Programación',array('controller'=>'aportacions','action'=>'program'),array('escape'=>false))?></li>
                        </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-building"></i><span>Contratos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php if ($this->Session->read('Permisos.Group.dc')==1){?>
                        <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Crear Contrato</span>',array('controller'=>'contratos','action'=>'add'),array('escape'=>false))?></li>
                        <?php } ?>
                        <?php if ($this->Session->read('Permisos.Group.dr')==1){?>
                      <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listar Contratos',array('controller'=>'contratos','action'=>'index'),array('escape'=>false))?></li>
                        <?php } ?>
                      </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-bank"></i><span>Bancos</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                          <li><?php echo $this->Html->link('<i class="fa fa-refresh"></i> Transferencias Bancarias',array('controller'=>'transaccions','action'=>'transferencia'),array('escape'=>false))?></li>
                          <li><?php echo $this->Html->link('<i class="fa fa-bars"></i> Listar Transacciones',array('controller'=>'transaccions','action'=>'index'),array('escape'=>false))?></li>
                          <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listado de cuentas',array('controller'=>'cuentas','action'=>'index'),array('escape'=>false))?></li>
                        </ul>
                    </li>-->
                    
                    <?php if ($this->Session->read('CuentaUsuario.CuentasUser.group_id')==1){?>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i><span class="link-title menu_hide">Configuración</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li><?php echo $this->Html->link('<i class="fa fa-building"></i><span> General</span>',array('controller'=>'cuentas','action'=>'view'),array('escape'=>false))?></li>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-dashboard"></i><span> Objetivos de Venta</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-home"></i><span>Por Corretaje</span>',array('controller'=>'cuentas','action'=>'kpi_corretaje'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-user"></i><span>Por Usuarios</span>',array('controller'=>'cuentas','action'=>'kpi_usuarios'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-building"></i><span> Por Desarrollos</span>',array('controller'=>'cuentas','action'=>'kpi_desarrollos'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                            <li><?php echo $this->Html->link('<i class="fa fa-check"></i><span> Autorización Facturas</span>',array('controller'=>'facturas','action'=>'config_autorizacion'),array('escape'=>false))?></li>
                            <li>
                            <?php echo $this->Html->link('<i class="fa fa-book"></i><span> Diccionarios</span>',array('controller'=>'users','action'=>'diccionarios_config'),array('escape'=>false))?>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-user"></i><span> Usuarios</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Crear Usuario</span>',array('controller'=>'users','action'=>'add'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> LIstar Usuarios</span>',array('controller'=>'users','action'=>'index'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                            <!-- <li><?php echo $this->Html->link('<i class="fa fa-lock"></i><span> Permisos</span>',array('controller'=>'groups','action'=>'permisos'),array('escape'=>false))?></li> -->
                            <!--
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-files-o"></i><span>Catálogos</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-bank"></i><span> Cuentas Bancarias</span>',array('controller'=>'bancos','action'=>'index'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> Categorias de Clientes</span>',array('controller'=>'categorias','action'=>'clientes'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> Categorias de Proveedores</span>',array('controller'=>'categorias','action'=>'proveedores'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-file"></i><span>Contratos</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Plantillas de Contratos</span>',array('controller'=>'contratos','action'=>'plantillas'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-qrcode"></i><span>Facturas</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span> Categorias de Facturas</span>',array('controller'=>'categorias','action'=>'facturas'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-sort-amount-asc"></i><span> Reglas de seguimiento</span>',array('controller'=>'facturas','action'=>'seguimiento'),array('escape'=>false))?></li>
                            </ul>
                          </li>-->
                          <!-- <li class="treeview">
                            <a href="#">
                             <i class="fa fa-sliders"></i><span> Parámetros</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">                                
                                <li><?php echo $this->Html->link('<i class="fa fa-tasks"></i><span> Parametrización</span>',array('controller'=>'users','action'=>'parametrizacion'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-envelope-o"></i><span> Configuración de mail</span>',array('controller'=>'users','action'=>'parametros_mail_config'),array('escape'=>false))?></li>
                            </ul>
                          </li> -->
                          <!-- <li class="treeview">
                            <a href="#">
                             <i class="fa fa-tint"></i><span> Diseño</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">                                
                                <li><?php echo $this->Html->link('<i class="fa fa-globe"></i><span>Ver mi sitio Web</span>',array('controller'=>'cuentas','action'=>'home',$this->Session->read('CuentaUsuario.Cuenta.sufix_website')),array('escape'=>false,'target'=>'_blank'))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-file-text-o"></i><span> Brochure Impreso</span>',array('controller'=>'users','action'=>'parametros_mail_config'),array('escape'=>false))?></li>
                            </ul>
                          </li> -->
                        </ul>
                    </li>
                    <?php }?>
                </ul>
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

<?php //echo $this->element('sql_dump');?>