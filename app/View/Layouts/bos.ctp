<!doctype html>
<html class="no-js" lang="es-MX">

<head>
    
    
    <meta charset="UTF-8">
    <title>CRM Inmobiliario</title>
    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="img/logo1.ico"/>
    <!--global styles-->
    <?php echo $this->Html->css(array('components','custom')); ?>
    <!-- end of global styles-->
    <?php echo $this->fetch('css') ?>
    <?php echo $this->Html->css('skins/red_black_skin',array('id'=>'skin_change')); ?>


</head>

<body class="fixedNav_position">
    <div class="bg-dark" id="wrap">
        <div id="top" class="fixed">
        <!-- .navbar -->
        <nav class="navbar navbar-static-top" style="background-color: #2e3c54">
            <div class="container-fluid">
                <a class="navbar-brand text-xs-center" href="index.html">
                    <?php echo $this->Html->image('logo.png',array('width'=>'200px','class'=>'admin_img'))?>
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
                    <div class="btn-group">
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
                    </div>
                    <div class="btn-group">
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
                    </div>
                    <div class="btn-group">
                        <div class="notifications request_section no-bg">
                            <a class="btn btn-default btn-sm messages" id="request_btn"> <i
                                    class="fa fa-sliders" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                    <div class="btn-group">
                        <div class="user-settings no-bg">
                            <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                                <img src="img/admin.jpg" class="admin_img2 img-thumbnail rounded-circle avatar-img"
                                     alt="avatar"> <strong>Micheal</strong>
                                <span class="fa fa-sort-down white_bg"></span>
                            </button>
                            <div class="dropdown-menu admire_admin">
                                <a class="dropdown-item title" href="#">
                                    Admire Admin</a>
                                <a class="dropdown-item" href="edit_user.html"><i class="fa fa-cogs"></i>
                                    Account Settings</a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa fa-user"></i>
                                    User Status
                                </a>
                                <a class="dropdown-item" href="mail_inbox.html"><i class="fa fa-envelope"></i>
                                    Inbox</a>

                                <a class="dropdown-item" href="lockscreen.html"><i class="fa fa-lock"></i>
                                    Lock Screen</a>
                                <a class="dropdown-item" href="login2.html"><i class="fa fa-sign-out"></i>
                                    Log Out</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="top_search_box float-xs-right hidden-sm-down">
                    <form class="header_input_search float-xs-right">
                        <input type="text" placeholder="Search" name="search">
                        <button type="submit">
                            <span class="font-icon-search"></span>
                        </button>
                        <div class="overlay"></div>
                    </form>
                </div>
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
                <ul id="menu">
                    <li>Menu Principal</li>
                    <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide">Tablero</span>',array('controller'=>'users','action'=>'dashboard'),array('escape'=>false))?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-dashboard"></i><span class="link-title menu_hide">Tablero Agente</span>',array('controller'=>'users','action'=>'dashboard_agente'),array('escape'=>false))?></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span>Ver calendario</span>',array('controller'=>'users','action'=>'calendar'),array('escape'=>false))?></li>
                    <li class="treeview">
                        <a href="#">
                         <?php if ($this->Session->read('Auth.User.group_id')!=3){?>
                            <i class="fa fa-user"></i>
                            <span class="link-title menu_hide">Clientes</span>
                            <span class="tag tag-pill tag-primary float-xs-right calendar_tag menu_hide"><?= $this->Session->read('clundef')?></span>
                         <?php 
                            }else{
                         ?>
                            <i class="fa fa-user"></i><span>Clientes</span>
                         <?php }?>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <?php if ($this->Session->read('Auth.User.Group.cc')==1){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-user-plus"></i><span class="link-title">Agregar Cliente</span>',array('controller'=>'clientes','action'=>'add'),array('escape'=>false))?></li>
                          <?php } ?>
                          <?php if ($this->Session->read('Auth.User.Group.call')==1 || $this->Session->read('Auth.User.Group.cown')){?>
                        <li><?php echo $this->Html->link('<i class="fa fa-list"></i><span class="link-title">Listar Clientes </span>',array('controller'=>'clientes','action'=>'index'),array('escape'=>false))?></li>
                          <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.id')!=3){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-home"></i><span class="link-title">Sin Asignar Corretaje</span>',array('controller'=>'clientes','action'=>'sinasignar',1),array('escape'=>false))?></li>
                          <li><?php echo $this->Html->link('<i class="fa fa-building"></i><span class="link-title">Sin Asignar Desarrollos</span>',array('controller'=>'clientes','action'=>'sinasignar',2),array('escape'=>false))?></li>

                          <?php } ?>
                        </ul>
                      </li>
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-home"></i><span>Propiedades</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php if ($this->Session->read('Auth.User.Group.ic')==1){?>
                        <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Propiedad</span>',array('controller'=>'inmuebles','action'=>'add'),array('escape'=>false))?></li>
                        <?php }?>
                        <?php if ($this->Session->read('Auth.User.Group.ir')==1){?>
                      <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Propiedades',array('controller'=>'inmuebles','action'=>'index'),array('escape'=>false))?></li>
                        <?php } ?>
                      </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-building"></i><span>Desarrollos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php if ($this->Session->read('Auth.User.Group.dc')==1){?>
                        <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Desarrollo</span>',array('controller'=>'desarrollos','action'=>'add'),array('escape'=>false))?></li>
                        <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.dr')==1){?>
                      <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Desarrollos',array('controller'=>'desarrollos','action'=>'index'),array('escape'=>false))?></li>
                        <?php } ?>
                      </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                         <i class="fa fa-briefcase"></i><span>Proveedores</span>
                          <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <?php //if ($this->Session->read('Auth.User.Group.cc')==1){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Nuevo Proveedor </span>',array('controller'=>'proveedors','action'=>'add'),array('escape'=>false))?></li>
                          <?php //} ?>
                          <?php //if ($this->Session->read('Auth.User.Group.call')==1 || $this->Session->read('Auth.User.Group.cown')){?>
                          <li><?php echo $this->Html->link('<i class="fa fa-bars"></i>Listar Proveedores',array('controller'=>'proveedors','action'=>'index'),array('escape'=>false))?></li>
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
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Nuevo gasto</span>',array('controller'=>'facturas','action'=>'seleccionar_proyecto'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Listar Gastos</span>',array('controller'=>'facturas','action'=>'index'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span>Listar Gastos Pendientes</span>',array('controller'=>'facturas','action'=>'programa'),array('escape'=>false))?>  </li>
                            </ul>
                          </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-angle-double-left"></i><span>Ingresos</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Nuevo ingreso</span>',array('controller'=>'aportacions','action'=>'add'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Listar Ingresos</span>',array('controller'=>'aportacions','action'=>'index'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-calendar"></i><span>Listar Ingresos Pendientes</span>',array('controller'=>'aportacions','action'=>'programa'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          <li><?php echo $this->Html->link('<i class="fa fa-clock-o"></i>Nueva Programación',array('controller'=>'aportacions','action'=>'program'),array('escape'=>false))?></li>
                        </ul>
                    </li>
                    <li class="treeview">
                      <a href="#">
                       <i class="fa fa-building"></i><span>Contratos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul class="treeview-menu">
                        <?php if ($this->Session->read('Auth.User.Group.dc')==1){?>
                        <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Contrato</span>',array('controller'=>'contratos','action'=>'add'),array('escape'=>false))?></li>
                        <?php } ?>
                        <?php if ($this->Session->read('Auth.User.Group.dr')==1){?>
                      <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listar Contratos',array('controller'=>'contratos','action'=>'index'),array('escape'=>false))?></li>
                        <?php } ?>
                      </ul>
                    </li>
                    <li class="treeview">
                        <a href="#"><i class="fa fa-bank"></i><span>Bancos</span><i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                          <li><?php echo $this->Html->link('<i class="fa fa-refresh"></i>Transferencias Bancarias',array('controller'=>'transaccions','action'=>'transferencia'),array('escape'=>false))?></li>
                          <li><?php echo $this->Html->link('<i class="fa fa-bars"></i>Listar Transacciones',array('controller'=>'transaccions','action'=>'index'),array('escape'=>false))?></li>
                          <li><?php echo $this->Html->link('<i class="fa fa-list"></i>Listado de cuentas',array('controller'=>'cuentas','action'=>'index'),array('escape'=>false))?></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i><span>Configuración</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-book"></i><span>Diccionarios</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Tipos de Cliente</span>',array('controller'=>'dic_tipo_clientes','action'=>'index'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Etapas de Cliente</span>',array('controller'=>'dic_etapas','action'=>'index'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Linea de contacto</span>',array('controller'=>'dic_linea_contactos','action'=>'index'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-user"></i><span>Usuarios</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Usuario</span>',array('controller'=>'users','action'=>'add'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>LIstar Usuarios</span>',array('controller'=>'users','action'=>'index'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-users"></i><span>Grupos Usuarios</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Crear Grupo</span>',array('controller'=>'groups','action'=>'add'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Listar Grupos</span>',array('controller'=>'groups','action'=>'index'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                 <i class="fa fa-files-o"></i><span>Catálogos</span>
                                 <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">
                                    <li><?php echo $this->Html->link('<i class="fa fa-bank"></i><span>Cuentas Bancarias</span>',array('controller'=>'bancos','action'=>'index'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Categorias de Clientes</span>',array('controller'=>'categorias','action'=>'clientes'),array('escape'=>false))?></li>
                                    <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Categorias de Proveedores</span>',array('controller'=>'categorias','action'=>'proveedores'),array('escape'=>false))?></li>
                                </ul>
                            </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-file"></i><span>Contratos</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-plus"></i><span>Plantillas de Contratos</span>',array('controller'=>'contratos','action'=>'plantillas'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-qrcode"></i><span>Facturas</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-bars"></i><span>Categorias de Facturas</span>',array('controller'=>'categorias','action'=>'facturas'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-sort-amount-asc"></i><span>Reglas de seguimiento</span>',array('controller'=>'facturas','action'=>'seguimiento'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          <li class="treeview">
                            <a href="#">
                             <i class="fa fa-sliders"></i><span>Parámetros</span>
                             <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><?php echo $this->Html->link('<i class="fa fa-tasks"></i><span>Valores de Seguimiento</span>',array('controller'=>'categorias','action'=>'facturas'),array('escape'=>false))?></li>
                                <li><?php echo $this->Html->link('<i class="fa fa-envelope-o"></i><span>Envío de mail</span>',array('controller'=>'facturas','action'=>'seguimiento'),array('escape'=>false))?></li>
                            </ul>
                          </li>
                          
                        </ul>
                    </li>
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
<?= $this->Html->script('pages/index')?>
</body>
</html>
