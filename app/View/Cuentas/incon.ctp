<div class=" bd-stretchtobottom-2 bd-stretch-to-bottom" data-control-selector=".bd-content-12"><div class=" bd-content-12 ">
    
    <div class=" bd-htmlcontent-13 bd-margins" 
 data-page-id="page.18">
    <section class=" bd-section-27 bd-page-width bd-tagstyles " id="section4" data-section-title="Two Columns with Image Right">
    <div class="bd-container-inner bd-margins clearfix">
        <div class=" bd-layoutcontainer-39 bd-page-width  bd-columns bd-no-margins">
    <div class="bd-container-inner">
        <div class="container-fluid">
            <div class="row 
 bd-row-flex 
 bd-row-align-middle">
                <?php echo $this->Session->flash(); ?>
                <div class=" bd-columnwrapper-153 
 col-md-6
 col-sm-12">
    <div class="bd-layoutcolumn-153 bd-column" ><div class="bd-vertical-align-wrapper"><h1 class=" bd-textblock-202 bd-content-element">
    ¡Gracias por haber asistido a la INCON 2019!
</h1>
	
		<div class=" bd-spacer-47 clearfix"></div>
	
		<p class=" bd-textblock-201 bd-content-element">
    Por tiempo limitado, Adryo te regala.
                <h2>¡PRUEBA GRATIS POR 2 MESES!</h2>
                </p>por haber asistido al Workshop <b>"El uso de herramientas inteligentes para la venta; ADRYO A.I. La nueva Plataforma Integral Inmobiliaria"</b>
<p class=" bd-textblock-201 bd-content-element">
    Registra tus datos y recibe en tu correo tu clave de acceso para el sistema Adryo A.I, con una cuenta de Desarrollador PRO durante 2 meses gratis.
</p>
<p class=" bd-textblock-201 bd-content-element">
    Contarás con soporte Premium durante tu etapa de prueba para que nuestros especialistas te ayuden en todo momento.
</p>
<p class=" bd-textblock-201 bd-content-element">
    Si quieres probar nuestro ambiente DEMO, da click <a href="https://demo.adryo.com.mx">aquí</a> y conoce todo lo que Adryo puede hacer por ti en un ambiente seguro y libre de errores.
</p>
	
		<div class=" bd-spacer-46 clearfix"></div></div></div>
</div>
	
		<div class=" bd-columnwrapper-152 
 col-md-6
 col-sm-12">
                    <style>
                        .margin-forma{
                            margin-bottom: 20px;
                        }
                        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
                            color: red;
                            opacity: 1; /* Firefox */
                        }

                        :-ms-input-placeholder { /* Internet Explorer 10-11 */
                            color: red;
                        }

                        ::-ms-input-placeholder { /* Microsoft Edge */
                            color: red;
                        }
                        .success{
                            background-color: #036903;
                            color: white;
                            padding: 5%;
                            width: 100%;
                            text-align: center;
                            font-size: 1.2em;
                        }
                    </style>
    <div class="bd-layoutcolumn-152 bd-column" ><div class="bd-vertical-align-wrapper">
            <h2 style="font-size: 1em">Favor de llenar los siguientes datos para obtener tu prueba por 2 meses.</h2>
            <?= $this->Form->create('Cuenta',array('url'=>array('controller'=>'cuentas','action'=>'add'))) ?>
            <?php echo $this->Form->input('nombre_contacto', array('required'=>'required','label'=>false,'div' => 'col-md-12 margin-forma', 'placeholder'=>'Nombre Contacto','class'=>'form-control required','type'=>'text'))?>
            <?php echo $this->Form->input('nombre_comercial', array('required'=>'required','label'=>false,'div' => 'col-md-12 margin-forma', 'placeholder'=>'Nombre Empresa','class'=>'form-control required','type'=>'text'))?>
            <?php echo $this->Form->input('correo_contacto', array('required'=>'required','label'=>false,'div' => 'col-md-12 margin-forma','placeholder'=>'Email','class'=>'form-control required','type'=>'email'))?>
            <?php echo $this->Form->input('telefono_1', array('required'=>'required','label'=>false,'div' => 'col-md-12 margin-forma','placeholder'=>'Teléfono','class'=>'form-control required','type'=>'text'))?>
            <?php echo $this->Form->hidden('return',array('value'=>1))?>
            
            <?= $this->Form->end('Solicitar Prueba',array('style'=>'bd-linkbutton-20 bd-no-margins  bd-button-25 bd-icon bd-icon-55 bd-own-margins bd-content-element'))?>
</div>
            </div>
        </div>
    </div>
</div>
    </div>
</section>
	
</div>
</div></div>
