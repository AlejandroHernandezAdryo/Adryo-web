<?=
    $this->Html->css(
            array(
                '/vendors/chartist/css/chartist.min',
                '/vendors/circliful/css/jquery.circliful',
                'pages/index',
                
                '/vendors/jasny-bootstrap/css/jasny-bootstrap.min',
                '/vendors/fullcalendar/css/fullcalendar.min',
                'pages/calendar_custom',
                'pages/profile',
                'pages/gallery',
               // '/vendors/c3/css/c3.min',
                //'/vendors/toastr/css/toastr.min',
                //'/vendors/switchery/css/switchery.min',
                 //'pages/new_dashboard',
                
                ),array('inline'=>false))
 ?>
 
       <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar row">
                    <div class="col-xs-6">
                        <h4 class="m-t-5">
                            <i class="fa fa-home"></i>
                            Tablero de control
                        </h4>
                    </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #2e3c54; color:white">Clientes</div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-4 m-t-35">
                                            <div class="card">
                                                <div id="top_widget2">
                                                        <div class="front">
                                                            <div class="bg-success p-d-15 b_r_5">
                                                                <div class="float-xs-right m-t-5">
                                                                    <i class="fa fa-star-o"></i>
                                                                </div>
                                                                <div class="user_font">Clientes Activos</div>
                                                                <div id="widget_countup4">15</div>
                                                                <div class="tag-white">
                                                                    <span id="percent_count4">80</span>%
                                                                </div>
                                                                <div class="previous_font">Del total de tus clientes</div>
                                                            </div>
                                                        </div>

                                                        <div class="back">
                                                            <div class="bg-white section_border b_r_5">
                                                                <div class="p-t-l-r-15">
                                                                    <div class="float-xs-right m-t-5 text-success">
                                                                        <i class="fa fa-star-o"></i>
                                                                    </div>

                                                                    <div id="widget_countup42">15</div>
                                                                    <div>Rating</div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <span id="rating"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                        </div>
                                        <div class="col-lg-4 m-t-35">
                                            <div class="card">
                                                <div id ="top_widget3">
                                                    <div class="front">
                                                        <div class="bg-warning p-d-15 b_r_5">
                                                            <div class="float-xs-right m-t-5">
                                                                <i class="fa fa-comments-o"></i>
                                                            </div>
                                                            <div class="user_font">Clientes Retrasados</div>
                                                            <div id="widget_countup3">5</div>
                                                            <div class="tag-white ">
                                                                <span id="percent_count3">20</span>%
                                                            </div>
                                                            <div class="previous_font">De tus clientes</div>
                                                        </div>
                                                    </div>

                                                    <div class="back">
                                                        <div class="bg-white b_r_5 section_border">
                                                            <div class="p-t-l-r-15">
                                                                <div class="float-xs-right m-t-5 text-warning">
                                                                    <i class="fa fa-comments-o"></i>
                                                                </div>
                                                                <div id="widget_countup32">5</div>
                                                                <div>Comments</div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <span id="mousespeed"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 m-t-35">
                                            <div class="card">
                                                <div id="top_widget2">
                                                        <div class="front">
                                                            <div class="bg-danger p-d-15 b_r_5">
                                                                <div class="float-xs-right m-t-5">
                                                                    <i class="fa fa-shopping-cart"></i>
                                                                </div>
                                                                <div class="user_font">Clientes Sin seguimiento</div>
                                                                <div id="widget_countup2">5</div>
                                                                <div class="tag-white">
                                                                    <span id="percent_count2">20</span>%
                                                                </div>
                                                                <div class="previous_font">Del total de tus clientes</div>
                                                            </div>
                                                        </div>

                                                        <div class="back">
                                                            <div class="bg-white b_r_5 section_border">
                                                                <div class="p-t-l-r-15">
                                                                    <div class="float-xs-right m-t-5 text-success">
                                                                        <i class="fa fa-shopping-cart"></i>
                                                                    </div>
                                                                    <div id="widget_countup22">20</div>
                                                                    <div>Inactivos</div>

                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <span id="salesspark-chart"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                        <div class="col-lg-4 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                   Temperaturas de clientes
                                </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/1.png',array('width'=>'100%'))?>
                                </div>
                            </div>

                        </div>
                            
                        <div class="col-lg-4 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Medios de contacto de clientes
                                </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/2.png',array('width'=>'100%'))?>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Clientes por contactar hoy
                                </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/clientes.png',array('width'=>'100%'))?>
                                     <?= $this->Html->image('charts/clientes.png',array('width'=>'100%'))?>
                                </div>
                            
                        </div>
                                        
                                        
                                        
                                    </div>
                        
                    </div>
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    top section widgets
                    

                    
                   
               
                </div>
                    </div>
            <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #2e3c54; color:white">Corretaje</div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Propiedades destacadas
                                                </div>
                                                <div class="card-block p-t-0">
                                                    <div class="card-columns">
                                                         Card 1 
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Fuego 345</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa1.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$5,500,000 </p><p>CDMX</p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Radiatas 23</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa2.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$15,500,000 </p><p>CDMX</p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Sánchez Azcona</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa3.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$2,500,000 </p><p>CDMX</p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Jardines P. 12</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa4.jpeg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$12,500,000 </p><p> CDMX</p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Tamarindos</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa5.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$2,000,000 </p><p>CDMX</p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Juriquilla</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa6.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                                <p>$500,000 USD </p><p>Qto.</p>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Propiedades nuevas
                                                </div>
                                                <div class="card-block p-t-0">
                                                    <div class="card-columns">
                                                         Card 1 
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Fuego 345</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa1.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Radiatas 23</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa2.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Tamarindos</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa5.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Juriquilla</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa6.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                       </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Exclusivas por vencer próximos 7 días
                                                </div>
                                                <div class="card-block p-t-0">
                                                    <div class="card-columns">
                                                         Card 1 
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Fuego 345</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa1.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Sánchez Azcona</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa3.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Tamarindos</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa5.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Casa Juriquilla</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('muestras/casa6.jpg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Bitácoras de Cambios
                                                </div>
                                                <div class="card-header">
                                                    <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#tab1" data-toggle="tab">Precios</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#tab2" data-toggle="tab">Estados</a>
                                                        </li>
                                                     </ul>
                                                </div>
                                                <div class="card-block">
                                                    <div class="tab-content text-justify">
                                                        <div class="tab-pane active" id="tab1">
                                                            <div class="list-group m-t-35">
                                        <ul class="list-group lists_margin_bottom">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    Imagen
                                                </div>
                                                <div class="col-xs-3">
                                                     Propiedad
                                                </div>
                                                <div class="col-xs-3">
                                                    Precio Anterior
                                                </div>
                                                 <div class="col-xs-3">
                                                    Precio Nuevo
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('muestras/casa6.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                     Casa Juriquilla
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$2,550,000</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$2,350,000</b>&nbsp;<i class="fa fa-arrow-circle-o-down fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('muestras/casa2.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                     Radiatas 23
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$12,000,000</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$12,350,000</b>&nbsp;<i class="fa fa-arrow-circle-o-up fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('muestras/casa6.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                    Casa Juriquilla
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$3,000,000</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$3,350,000</b>&nbsp;<i class="fa fa-arrow-circle-o-up fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                     </ul>
                                    </div>
                                                            
                                                        </div>
                                                        <div class="tab-pane" id="tab2">
                                                            <div class="list-group m-t-35">
                                        <ul class="list-group lists_margin_bottom">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    Imagen
                                                </div>
                                                <div class="col-xs-3">
                                                     Propiedad
                                                </div>
                                                <div class="col-xs-3">
                                                    Estado Anterior
                                                </div>
                                                 <div class="col-xs-3">
                                                    Estado Actualizado
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('muestras/casa6.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                     Casa Juriquilla
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Contrato</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Escriturada</b>&nbsp;<i class="fa fa-arrow-circle-o-down fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('muestras/casa2.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                     Radiatas 23
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Libre</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Apartado</b>&nbsp;<i class="fa fa-arrow-circle-o-up fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            
                                     </ul>
                                    </div>
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                        
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header" style="background-color: #2e3c54; color:white">Desarrollos</div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Desarrollos destacados
                                                </div>
                                                <div class="card-block p-t-0">
                                                    <div class="card-columns">
                                                         Card 1 
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Nova Habita Obrera</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('desarrollos/32/1.-FACHADA EDIFICIO.jpeg',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Rebsamen</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('desarrollos/34/1.-FACHADA REBSAMEN.png',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Valle 3520</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('desarrollos/35/1.-RENDER FACHADA.png',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Desarrollos nuevos
                                                </div>
                                                <div class="card-block p-t-0">
                                                    <div class="card-columns">
                                                         Card 1 
                                                        <div class="card card-outline-primary m-t-25">
                                                            <div class="card-header">Rebsamen</div>
                                                            <div class="card-block">
                                                                <p class="card-text"><?= $this->Html->image('desarrollos/34/1.-FACHADA REBSAMEN.png',array('width'=>'100%','style'=>'max-height: 83px;'))?></p>
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        
                                                       </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    <div class="row">
                                        
                                        <div class="col-lg-12">
                                            <div class="card m-t-35">
                                                <div class="card-header">
                                                   Bitácoras de Cambios
                                                </div>
                                                <div class="card-header">
                                                    <ul class="nav nav-tabs card-header-tabs float-xs-left">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" href="#tab1A" data-toggle="tab">Precios</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" href="#tab2A" data-toggle="tab">Estados</a>
                                                        </li>
                                                     </ul>
                                                </div>
                                                <div class="card-block">
                                                    <div class="tab-content text-justify">
                                                        <div class="tab-pane active" id="tab1A">
                                                            <div class="list-group m-t-35">
                                        <ul class="list-group lists_margin_bottom">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    Imagen
                                                </div>
                                                <div class="col-xs-3">
                                                     Propiedad
                                                </div>
                                                <div class="col-xs-3">
                                                    Precio Anterior
                                                </div>
                                                 <div class="col-xs-3">
                                                    Precio Nuevo
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                     <?= $this->Html->image('desarrollos/28/13.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                    Depto. 201
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$2,550,000</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>$2,350,000</b>&nbsp;<i class="fa fa-arrow-circle-o-down fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            
                                     </ul>
                                    </div>
                                                            
                                                        </div>
                                                        <div class="tab-pane" id="tab2A">
                                                            <div class="list-group m-t-35">
                                        <ul class="list-group lists_margin_bottom">
                                            <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    Imagen
                                                </div>
                                                <div class="col-xs-3">
                                                     Propiedad
                                                </div>
                                                <div class="col-xs-3">
                                                    Estado Anterior
                                                </div>
                                                 <div class="col-xs-3">
                                                    Estado Actualizado
                                                </div>
                                                </div>
                                                </div>
                                                </li>
                                                <li class="list-group-item">
                                                <div class="form-group">
                                                <div class="row">
                                                <div class="col-xs-3">
                                                    <?= $this->Html->image('desarrollos/28/13.jpg',array('style'=>'max-height: 50px;'))?>
                                                </div>
                                                <div class="col-xs-3">
                                                     Depto. 201
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Contrato</b>
                                                </div>
                                                <div class="col-xs-3">
                                                    <b>Escriturada</b>&nbsp;<i class="fa fa-arrow-circle-o-down fa-lg"></i>
                                                </div>
                                                </div>
                                                </div>
                                            </li>
                                            
                                            
                                     </ul>
                                    </div>
                                                            
                                                        </div>
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    top section widgets
                    

                    
                   
               
                </div>
                    </div>
                </div>
                <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #2e3c54; color:white">Finanzas</div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-6  m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    <span class="card-title">Flujo de efectivo Mensual</span>
                                    <div class="dropdown chart_drop float-xs-right">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                        <i class="fa fa-arrows-alt"></i>
                                    </div>
                                    </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/flujo.png',array('width'=>'100%'))?>
                                </div>
                            </div>
                                        
                                        
                                        
                                    </div>
                                        <div class="col-lg-6  m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    <span class="card-title">Saldos Mensuales</span>
                                    <div class="dropdown chart_drop float-xs-right">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Action</a></li>
                                            <li><a href="#">Another action</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a></li>
                                        </ul>
                                        <i class="fa fa-arrows-alt"></i>
                                    </div>
                                    </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/bancos.png',array('width'=>'100%'))?>
                                </div>
                            </div>
                                        
                                        
                                        
                                    </div>
                                    </div>
                                    <div class="row">
                        <div class="col-lg-6 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Facturas pendientes de cobro
                                </div>
                                <div class="card-block">
                                    <table class="table table-responsive m-t-35" style="width: 100%">
                                            <thead class="thead-inverse">
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Fecha de pago</th>
                                                <th>Monto por cobrar</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i=0;$i<rand(1, 7);$i++){?>
                                            <tr>
                                                <td>Aigel SA de CV</td>
                                                <td>28-feb-2017</td>
                                                <td><?= "$".number_format(rand(150, 999999),2) ?></td>
                                                <td>No Pagada</td>
                                                
                                            </tr>
                                                <?php }?>
                                            
                                            </tbody>
                                        </table> 
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Facturas pendientes de Pago
                                </div>
                                <div class="card-block">
                                    <table class="table table-responsive m-t-35" style="width: 100%">
                                            <thead class="thead-inverse">
                                            <tr>
                                                <th>Proveedor</th>
                                                <th>Fecha de pago</th>
                                                <th>Monto por pagar</th>
                                                <th>Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($i=0;$i<rand(1, 7);$i++){?>
                                            <tr>
                                                <td>Aigel SA de CV</td>
                                                <td>28-feb-2017</td>
                                                <td><?= "$".number_format(rand(150, 999999),2) ?></td>
                                                <td>No Pagada</td>
                                                
                                            </tr>
                                                <?php }?>
                                            
                                            </tbody>
                                        </table> 
                                </div>
                            </div>
                        </div>
                        
                                    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    top section widgets
                    

                    
                   
               
                </div>
                    </div>
                </div>
                <div class="outer">
                <div class="inner bg-container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #2e3c54; color:white">Organización</div>
                                <div class="card-block cards_section_margin">
                                    <div class="row">
                                        <div class="col-lg-8">
                            <div class="card m-t-35">
                                <div class="card-header">
                                    <div>
                                        <i class="fa fa-calendar"></i>
                                        Póximos eventos
                                    </div>
                                </div>
                                <div class="card-block m-t-35 padding-body view_user_cal">
                                    <div id="calendar_mini" class="bg-primary"></div>
                                    <div class="list-group">
                                        <a href="#" class="list-group-item calendar-list">
                                            <div class="tag tag-pill tag-primary float-xs-right">11:30</div>
                                            Muestra de casa Pedregal
                                        </a>
                                        <a href="#" class="list-group-item calendar-list">
                                            <div class="tag tag-pill tag-primary float-xs-right">12:30</div>
                                           Llamar a Juan Pablo Segura
                                        </a>
                                        <a href="#" class="list-group-item calendar-list">
                                            <div class="tag tag-pill tag-primary float-xs-right">13:30</div>
                                            Correo electrónico a Patricia Suárez
                                        </a>
                                        <a href="#" class="list-group-item calendar-list">
                                            <div class="tag tag-pill tag-primary float-xs-right">17:30</div>
                                            Envíar más casas a Sr. Portillo
                                        </a>
                                        <a href="#" class="list-group-item calendar-list">
                                            <div class="tag tag-pill tag-primary float-xs-right">19:30</div>
                                            Junta de avances con gerencia
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Recordatorios
                                </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/todo.png',array('width'=>'100%'))?>
                                </div>
                            </div>

                        </div>
                                        <div class="col-lg-4 col-xs-12 m-t-35">
                            <div class="card">
                                <div class="card-header">
                                    Notas
                                </div>
                                <div class="card-block">
                                    <?= $this->Html->image('charts/lista.png',array('width'=>'100%'))?>
                                </div>
                            </div>

                        </div>
                                        <div class="col-lg-4 col-xs-12 m-t-35">
                                            <?= $this->Html->image('hora.png',array('width'=>'100%'))?>
                                    </div>
                                        <div class="col-lg-4 col-xs-12 m-t-35">
                                            <div class="card">
                                <div class="card-header">
                                    Mensajes Internos
                                <div class="card-block">
                                    <div class="row p-d-20">
                                    <div class="col-lg-3 col-md-4 col-xs-4">
                                        <?php echo $this->Html->image($this->Session->read('Auth.User.foto'),array('class'=>'img-fluid rounded-circle','width'=>'100'))?>
                                        
                                    </div>
                                    <div class="col-lg-9 col-md-8 col-xs-8">
                                        <h5>César Pineda García</h5>
                                        <p>¿Me puedes apoyar con la información de la casa de Pedregal en Venta por favor?</p>
                                        <div class="clearfix hidden-xs-down hidden-sm-down hidden-lg-down hidden-xl-down">
                                            Necesito enviar la ficha técnica a un cliente que le puede interesar. Gracias
                                        </div>
                                        
                                    </div>
                                    <form id="main_input_box" class="form-inline">
                                                    <div class="input-group todo">
                                                            <span class="input-group-btn">
                                                            <a class="btn btn-primary" tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-contentwrapper=".mycontent" id="btn_color" data-badge="todo_mintbadge" data-original-title="" title="">Responder&nbsp;&nbsp; <i class="fa fa-caret-right"> </i></a>
                                                            </span>
                                                        <input id="custom_textbox" name="Item" required="" placeholder="Responder" class="input-md form-control" size="75" type="text">
                                                    </div>
                                                </form>
                                </div>
                                </div>
                            </div>
                        </div>
                            
                        </div>
                                    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                    

                    
                   
               
                </div>
                    </div>
                </div>
                 
            </div>
              
        </div>
         
        

<!--wrapper-->
    
    <!-- /#content -->
   
<!-- # right side -->
<!-- /#wrap -->

<?php 
        echo $this->Html->script(
                array(
                    
                    '/vendors/countUp.js/js/countUp.min.js',
                    '/vendors/flip/js/jquery.flip.min',
                    'pluginjs/jquery.sparkline',
                    '/vendors/chartist/js/chartist.min',
                    'pluginjs/chartist-tooltip',
                    '/vendors/swiper/js/swiper.min',
                    '/vendors/circliful/js/jquery.circliful.min',
                    '/vendors/countUp.js/js/countUp.min',
                    '/vendors/flotchart/js/jquery.flot',
                    '/vendors/flotchart/js/jquery.flot.resize',
            
                    '/vendors/slimscroll/js/jquery.slimscroll.min',
                    '/vendors/jasny-bootstrap/js/jasny-bootstrap.min',
                    '/vendors/bootstrap_calendar/js/bootstrap_calendar.min',
                    '/vendors/moment/js/moment.min',
                    '/vendors/fullcalendar/js/fullcalendar.min',
                    /* '/vendors/slimscroll/js/jquery.slimscroll.min',
                    '/vendors/raphael/js/raphael-min',
                    '/vendors/d3/js/d3.min',
                    '/vendors/c3/js/c3.min',
                    '/vendors/toastr/js/toastr.min',
                    '/vendors/switchery/js/switchery.min',
                    '/vendors/flotchart/js/jquery.flot',
                    '/vendors/flotchart/js/jquery.flot.resize',
                    '/vendors/flotchart/js/jquery.flot.stack',
                    '/vendors/flotchart/js/jquery.flot.time',
                    '/vendors/flotspline/js/jquery.flot.spline.min',
                    '/vendors/flotchart/js/jquery.flot.categories',
                    '/vendors/flotchart/js/jquery.flot.pie',
                    '/vendors/flot.tooltip/js/jquery.flot.tooltip.min',
                     '/vendors/jquery_newsTicker/js/newsTicker',
                     '/vendors/countUp.js/js/countUp.min',*/
                     'pages/mini_calendar',
                    ),
                array('inline'=>false))?>
