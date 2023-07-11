<!doctype html>
<html class="no-js" lang="es-MX">
<head>
   <meta charset="UTF-8">
    <title>ADRYO</title>
    <!--IE Compatibility modes-->
    <?php
        echo $this->Html->meta ('favicon.ico', '/img/favicon.png', array (
            'type' => 'icon' 
        ) );
    ?>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--global styles-->
    <?php echo $this->Html->css(array(
        'components',
        'componentsadryo',
        'custom',

        'pages/layouts',

    )); ?>
    <?php echo $this->fetch('css') ?>
    <!-- 'pages/general_components' -->
    
    <!-- end of global styles-->
    <?php echo $this->fetch('meta'); ?>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <?php // echo $this->Html->css('skins/inmosystem',array('id'=>'skin_change')); ?>
    <style>

        .bgClienteA {
            background-color: #BF9000;
        }
        .bgClienteID {
            background-color: #000000;
        }
        .bgClienteIT {
            background-color: #7F6000;
        }
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

       .cursor-disable, .disabled {
            cursor:not-allowed;
       }
    </style>

    <!-- <script src="//code.jivosite.com/widget.js" data-jv-id="K3D8wzy6xr" async></script> -->

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

    .btn-group .btn-secondary{ margin: 5px; }

    .content-list{
        width: 100%;
        height: 100vh;
    }

    .content-list{
        width: 100%;
        height: 100vh;
    }
    #overlay {
        display: none;
        width: 100%;
        height: 100vh;
        position: fixed;
        z-index: 1993;
        background: #393939;
        opacity: 0.94;
    }

    #overlay img {
        position: absolute;
        display: inline-block;
        top: 35%;
        left: 45%;
        z-index: 1994;
        width: auto;
        height: 100px;
    }

    #overlay div li {
        float: left;
        list-style: none;
        margin: 2px;
    }
    #overlay div li:nth-child(1) {
        background: #FFF;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
        -webkit-animation-delay: 0.10s;
        animation-delay: 0.10s;
    }

    #overlay div li:nth-child(2) {
        background: #FFF;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
        -webkit-animation-delay: 0.20s;
        animation-delay: 0.20s;
    }

    #overlay div li:nth-child(3) {
        background: #FFF;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 5em;
        -webkit-animation-delay: 0.30s;
        animation-delay: 0.30s;
    }

    .cargando {
        display: block;
        color: #fff;
        width: 100%;
    }

    @keyframes blockRevealAnimation {
        0% {
            left: -100%;
        }
        40% {
            left: 0%;
        }
        60% {
            left: 0%;
        }
        100% {
            left: 100%;
        }
    }

    @keyframes revealTextAnimation {
        0% {
            color: transparent;
        }
        40% {
            color: transparent;
        }
        60% {
            color: #fff;
        }
    }

    @keyframes revealImgAnimation {
        0% {
            opacity: 0;
        }
        60% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @-webkit-keyframes load1 {
        0%,
        80%,
        100% {
        box-shadow: 0 0 #FFF;
        height: 4em;
        }
        40% {
        box-shadow: 0 -2em #ffffff;
        height: 5em;
        }
    }
    @keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0 #FFF;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em #ffffff;
            height: 5em;
        }
    }

    @media (max-width: 375px) {
        #overlay img {
            left: 30%;
        }
    }

    @media (max-width: 414px) {
        #overlay img {
            left: 32%;
        }
    }
    @media print
	{
        .globalClass_5c43{
            display: none;
        }
    }

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
            <h3 style="color: black;" id="m_success"></h3>
            <div class="row">
                <div class="col-sm-12 flex-center">
                    <button type="button" class="btn btn-primary btn-lg" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
      </div>
    </div>
</div>

<div id="overlay">
    <?= $this->Html->image('logo_inmosystem.png',array('class'=>'admin_img','alt'=>'Logo Adryo'))?>
    <br>
    <div class="content-list flex-center">
        <li></li>
        <li></li>
        <li></li>
    </div>
</div>

<body class="body fixedNav_position fixedMenu_left">
<!-- Pantalla de carga -->
<!-- <div class="pantalla-carga"></div> -->

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
                                       echo $this->Html->image('no_photo.png',array('class'=>'admin_img2 img-thumbnail rounded-circle avatar-img')); 
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
                                
                                <?php
                                    // $this->Html->link('<i class="fa fa-lock"></i> Cambiar Password',array('controller'=>'users','action'=>'change_password'),array('class'=>'dropdown-item','escape'=>false))
                                ?>
                                
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
                            <a href="#" class="disable-custom">
                                <i class="fa fa-bar-chart-o"></i>
                                <span class="link-title menu_hide">Reportes</span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>

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
                                </li>

                            </ul>
                        </li>
                    <?php elseif ($this->Session->read('Permisos.Group.id') <= 2): ?>
                        
                            <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide"> Tablero</span>',array('controller'=>'users','action'=>'dashboard'),array('escape'=>false))?>
                            </li>
                            
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-bar-chart-o"></i>
                                    <span class="link-title menu_hide">Reportes</span>
                                    <i class="fa fa-angle-left pull-right menu_hide"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <!-- se elimina el reporte por cliente -->
                                    <li>
                                        <?= $this->Html->link('<span>Reporte por Asesor</span>', array('controller'=>'users', 'action'=>'reporte_a1'), array('escape'=>false))?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('<span>Reporte por Grupo de Asesores</span>', array('action'=>'reporte_a2','controller'=>'users'), array('escape'=>false))?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('<span>Reporte por Desarrollo</span>', array('controller'=>'desarrollos', 'action'=>'reporte_d1'), array('escape'=>false))?>
                                    </li>
                                    <li>
                                        <?= $this->Html->link('<span>Reporte de Medios de Promoción</span>', array('controller'=>'publicidads', 'action'=>'reporte_m1'), array('escape'=>false))?>
                                    </li>

                                </ul>
                            </li>

                    <?php endif; ?>

                    <li>
                        <?= $this->Html->link('<i class="fa fa-calendar"></i><span class="link-title menu_hide"> Calendario</span>', array('controller'=>'users','action'=>'calendar'), array('escape'=>false))?>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user"></i>
                            <span class="link-title menu_hide">Clientes</span>
                            <?php if (empty($this->Session->read('Desarrollador'))): /* Condicion para los desarrolladores */?>
                                <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide"><?= $this->Session->read('clundef')?></span>
                            <?php endif; ?>
                            <i class="fa fa-angle-left pull-right menu_hide"></i>
                        </a>

                        <ul class="treeview-menu">
                          
                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-user-plus"></i> Agregar Cliente','#',array('escape'=>false, 'class'=>'disable-custom'))?></li>

                        <?php elseif ($this->Session->read('Permisos.Group.cc') == 1):?>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-user-plus"></i> Agregar Cliente', array('action' => 'add', 'controller' => 'clientes'), array('escape' => false)) ?>
                                </li>
                        <?php endif; ?>

                          <li><?= $this->Html->link('<i class="fa fa-filter"></i> Embudo de Ventas',array('controller'=>'clientes','action'=>'pipeline'),array('escape'=>false))?></li>

                          <?php if ($this->Session->read('Permisos.Group.call')==1 || $this->Session->read('Permisos.Group.cown')):?>
                                <li><?php echo $this->Html->link('<i class="fa fa-list"></i><span class="link-title"> Listar Clientes</span>',array('controller'=>'clientes','action'=>'index'),array('escape'=>false))?></li>
                          <?php endif; ?>

                        <?php if ($this->Session->read('Permisos.Group.cown') == 0):?>
                            <?php if (empty($this->Session->read('Desarrollador'))): /* Condicion para los desarrolladores */?>
                                <li><?php echo $this->Html->link('<i class="fa fa-home"></i><span class="link-title"> Clientes sin Asignar</span>',array('controller'=>'clientes','action'=>'sinasignar'),array('escape'=>false))?></li>
                            <?php endif; ?>
                        <?php endif; ?>
                        </ul>
                    </li>
                      


                        <?php if ($this->Session->read('Permisos.Group.id') == 5): ?>
                            <li class="treeview">
                                
                                <a href="#" class="disable-custom">
                                    <i class="fa fa-home"></i>
                                    <span class="link-title menu_hide">Propiedades</span>
                                    <i class="fa fa-angle-left pull-right menu_hide"></i>
                                </a>
                                
                                <ul class="treeview-menu">
                                    
                                    <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span> Subir propiedad</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?></li>
                                    
                                    <li><?php echo $this->Html->link('<i class="fa fa-list"></i> Listar propiedades','#',array('escape'=>false, 'class' => 'disable-custom'))?></li>

                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-home"></i>
                                 <span class="link-title menu_hide">Propiedades</span>
                                  <i class="fa fa-angle-left pull-right menu_hide"></i>
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


                    <!-- Desarrollos **Korner 25-05-2023** -->
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-building"></i>
                       <span class="link-title menu_hide">Desarrollos</span>
                        <i class="fa fa-angle-left pull-right menu_hide"></i>
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
                    <!-- Mesa de control **Korner 25-05-2023** -->
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-tasks"></i>
                       <span class="link-title menu_hide">Mesa de control</span>
                        <i class="fa fa-angle-left pull-right menu_hide"></i>
                      </a>

                      <ul class="treeview-menu">
                            
                        <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>
                            <li><?php echo $this->Html->link('<i class="fa fa-file-archive-o"></i><span> Procesos</span>','#',array('escape'=>false, 'class'=>'disable-custom'))?></li>
                        
                        <?php elseif( $this->Session->read('Permisos.Group.dc') == 1): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-file-archive-o"></i><span> Procesos</span>',array('controller'=>'desarrollos','action'=>'control_table'),array('escape'=>false))?></li>

                        <?php endif; ?>

                        <?php if ( $this->Session->read('Permisos.Group.dr') == 1 ): ?>
                            
                            <li><?php echo $this->Html->link('<i class="fa fa-folder-open"></i> Validación',array('controller'=>'desarrollos','action'=>'validation'),array('escape'=>false))?></li>

                        <?php endif; ?>

                      </ul>

                    </li>


                    <?php if ($this->Session->read('Permisos.Group.id')!=3):?>
                        <li>
                            <?php echo $this->Html->link('<i class="fa fa-users"></i><span class="link-title menu_hide"> Asesores</span>',array('controller'=>'users','action'=>'asesores'),array('escape'=>false))?>
                        </li>
                    <?php endif; ?>

                    <?php if ($this->Session->read('Permisos.Group.id')!=3):?>
                        <?php if (empty($this->Session->read('Desarrollador'))): ?>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-spinner"></i><span class="link-title menu_hide"> Equipos de Trabajo</span>',array('controller'=>'gruposUsuarios','action'=>'index'),array('escape'=>false))?>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if( $this->Session->read('Permisos.Group.id') == 5 ): ?>

                        <li class="treeview">
                            
                            <a href="#" class="disable-custom">
                                <i class="fa fa-bank"></i>
                                <span class="link-title menu_hide">Finanzas</span>
                                <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide">
                                    0
                                </span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>

                            <ul class="treeview-menu">
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-bank"></i> Cuentas bancarias','#',array('escape'=>false, 'class' => 'disable-custom'))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-user"></i> Clientes Externos', '#',array('escape'=>false, 'class' => 'disable-custom')) ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-users"></i> Proveedores','#', array('escape'=>false, 'class' => 'disable-custom'))?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-money"></i>Ingresos', '#', array('escape'=>false, 'class' => 'disable-custom')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-money"></i>Ingresos a 30 Días', '#', array('escape'=>false, 'class' => 'disable-custom')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-bars"></i>Gastos', '#', array('escape'=>false, 'class' => 'disable-custom')) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-check"></i>Mis Autorizaciones <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide">0</span>', '#',array('escape'=>false, 'class' => 'disable-custom')) ?>
                                </li>
                            </ul>
                        </li>

                    <?php elseif ($this->Session->read('CuentaUsuario.CuentasUser.finanzas')==1): ?>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-bank"></i>
                                <span class="link-title menu_hide">Finanzas</span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>
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
                                    <?= $this->Html->link('<i class="fa fa-money"></i> Ingresos', array('controller'=>'aportacions', 'action'=>'index'),array('escape'=>false)) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-money"></i> Ingresos a 30 Días', array('controller'=>'aportacions', 'action'=>'index',1),array('escape'=>false)) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-bars"></i> Gastos', array('controller'=>'facturas', 'action'=>'index'),array('escape'=>false)) ?>
                                </li>
                                <li>
                                    <?= $this->Html->link('<i class="fa fa-check"></i> Mis Autorizaciones', array('controller'=>'facturas', 'action'=>'por_autorizar'),array('escape'=>false)) ?>
                                </li> 
                            </ul>
                        </li>
                    <?php endif;?>

                    <?php if ($this->Session->read('Permisos.Group.vv') == 1): ?>
                        
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-dollar"></i>
                                <span class="link-title menu_hide">Ventas</span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><?php echo $this->Html->link('<i class="fa fa-list-alt"></i> Lista de ventas',array('controller'=>'ventas','action'=>'sale_list'),array('escape'=>false))?></li>
                            </ul>
                            <ul class="treeview-menu">
                              <li><?php echo $this->Html->link('<i class="fa fa-list-alt"></i> Lista de apartados',array('controller'=>'ventas','action'=>'listado_apartados'),array('escape'=>false))?></li>
                            </ul>
                        </li>
                        
                    <?php endif; ?>
                    
                    <?php if( $this->Session->read('Permisos.Group.id') == 5): ?>

                        <li class="dropdown_menu">
                            <a href="#" class="disable-custom">
                                <i class="fa fa-cogs"></i>
                                <span class="link-title menu_hide">Configuración</span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>

                            <ul class="sub-menu">
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-cogs"></i><span> General</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-dashboard"></i><span> Objetivos de Venta</span>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="sub-menu sub-submenu">

                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-home"></i><span>Por Corretaje</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?>
                                        </li>

                                       <li>
                                            <?php echo $this->Html->link('<i class="fa fa-user"></i><span>Por Usuarios</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?>
                                        </li>
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-building"></i><span> Por Desarrollos</span>','#',array('escape'=>false, 'class' => 'disable-custom'))?>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-check"></i><span> Autorización Facturas</span>','#', array('escape'=>false, 'class' => 'disable-custom'))?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-book"></i><span> Diccionarios</span>','#', array('escape'=>false, 'class' => 'disable-custom'))?>
                                </li>

                                <li>
                                    <a href="#">
                                    <i class="fa fa-user"></i>
                                    <span> Usuarios</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="sub-menu sub-submenu">
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-bars"></i><span> LIstar Usuarios</span>', '#', array('escape'=>false, 'class' => 'disable-custom'))?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </li>

                    <?php elseif ( $this->Session->read('CuentaUsuario.CuentasUser.group_id') == 1 ): ?>

                        <li class="dropdown_menu">

                            <a href="#">
                                <i class="fa fa-cogs"></i>
                                <span class="link-title menu_hide">Configuración</span>
                                <i class="fa fa-angle-left pull-right menu_hide"></i>
                            </a>

                            <ul class="sub-menu">
                                
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-cogs"></i><span> General</span>',array('controller'=>'cuentas','action'=>'view'),array('escape'=>false))?>
                                </li>

                                <!-- <li><?php //echo $this->Html->link('<i class="fa fa-building"></i><span> Clusters de Desarrollos</span>',array('controller'=>'desarrollos','action'=>'clusters'),array('escape'=>false, 'class' => 'disable-custom'))?></li> -->

                                <li>
                                    <a href="#">
                                    <i class="fa fa-dashboard"></i><span> Objetivos de Venta</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="sub-menu sub-submenu">
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-home"></i><span>Por Corretaje</span>',array('controller'=>'cuentas','action'=>'kpi_corretaje'),array('escape'=>false))?>
                                        </li>
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-user"></i><span>Por Usuarios</span>',array('controller'=>'cuentas','action'=>'kpi_usuarios'),array('escape'=>false))?>
                                        </li>
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-building"></i><span> Por Desarrollos</span>',array('controller'=>'cuentas','action'=>'kpi_desarrollos'),array('escape'=>false))?>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <?php echo $this->Html->link('<i class="fa fa-check"></i><span> Autorización Facturas</span>',array('controller'=>'facturas','action'=>'config_autorizacion'),array('escape'=>false))?>
                                </li>
                                <li>
                                <?php echo $this->Html->link('<i class="fa fa-book"></i><span> Diccionarios</span>',array('controller'=>'users','action'=>'diccionarios_config'),array('escape'=>false))?>
                                </li>
                                <li>
                                    <a href="#">
                                    <i class="fa fa-user"></i>
                                    <span> Usuarios</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                    </a>
                                    <ul class="sub-menu sub-submenu">
                                        <li>
                                            <?php echo $this->Html->link('<i class="fa fa-bars"></i><span> LIstar Usuarios</span>',array('controller'=>'users','action'=>'index'),array('escape'=>false))?>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                        </li>
                    <?php endif; ?>
                    
                    <?php if( $this->Session->read('Permisos.Group.vpc') == 1 ): ?>
                        <li>
                            <?= $this->Html->link('<i class="fa fa-sliders"></i><span class="link-title menu_hide">Panel de control</span>', array('controller'=>'cuentas','action'=>'control_panel'), array('escape'=>false))?>
                        </li>
                    <?php endif; ?>

                </ul>
                <!-- /#menu -->
            </div>
        </div>
        <!-- global scripts-->
        <?php
            echo $this->Html->script(array(
                'components',
                'custom',

                // Chosen select
                // 'pages/layouts',

                'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
            ));
            // everything else from the view, echoed after
            echo $this->fetch('script');
        ?>
        <!-- /#left -->
       <?= $this->fetch('content')?> 
    </div>
</div>

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
<script src="https://kit.fontawesome.com/b0d8aefb17.js" crossorigin="anonymous"></script>
<?= $this->Html->script('/js/blocksend')?>
<?php //echo $this->element('sql_dump');?>