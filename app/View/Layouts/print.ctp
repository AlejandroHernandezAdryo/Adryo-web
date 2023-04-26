
    <?php echo $this->Html->css(array('components','custom','pages/widgets','pages/layouts')); ?>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Sen&display=swap');
        body {
            background: white;
            font-family: 'Sen', sans-serif;
            font-size: 10px;
        }
        table{
            font-family: 'Sen', sans-serif;
            font-size: 10px;
            width:100%
        }
        .titulo_bloque{
            background-color: #2e3c54; 
            color:white;
            width:100%;
            font-size: 12px;
            text-transform: uppercase;
            padding: 0.75rem 0.75rem;
            margin-bottom: 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        } 
        .header{
            width:100%;
            text-align: left;
            position: fixed;
            top:0;
            -webkit-print-color-adjust: exact;
        }
        .footer{
            width:100%;
            background-color: white;
            color:white;
            text-align: center;
            position: fixed;
            bottom:0;
            font-size: 8px;
            -webkit-print-color-adjust: exact;
        }
        .h1{
            font-size:14px;
            color:black
        }
        .m-t-60{
            margin-top:60px;
        }
        .m-t-25{
            margin-top:25px;
        }
        .salto{
            page-break-before: always;  
        }
        .titulo{
            font-weight: bold;
            text-transform: uppercase;
            font-size:16px;
            color:black;
        }
        .spacer{
        width:100%;
        height:20px;
        }
        .firmas{
        padding: 5px 10% 5px 10%;
        }
        @media print {
        body, page {
            margin: 0;
            box-shadow: 0;
            -webkit-print-color-adjust: exact;
        }
        .header{}
        .footer{}
        .m-t-60{}
        .m-t-25{}
        .spacer{}
        .salto{}
        }

        .chips{
        border-radius: 5px;
        text-align: center; 
        -moz-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
        -webkit-box-shadow: 3px 1px 16px rgba(184,184,184,0.50);
        box-shadow: 3px 1px 16px rgba(184,184,184,0.50)º;
    }
    .chips-block {
    width: 100%;
    }
    .chips-bloqueados {
    padding: 2px 5px 2px 5px;
    background: #FFFF00;
    color: #3D3D3D;
    }
    .chips-libres {
    padding: 2px 5px 2px 5px;
    background: rgb(0, 64 , 128);
    color: #FFF;
    }
    .chips-reservas {
    padding: 2px 5px 2px 5px;
    background: #FFA500;
    color: #FFF;
    }
    .chips-contratos {
    padding: 2px 5px 2px 5px;
    background: RGB(116, 175, 76);
    color: #FFF
    }
    .chips-escrituraciones {
    padding: 2px 5px 2px 5px;
    background: #8B4513;
    color: #FFF
    }
    .chips-bajas{
    padding: 2px 5px 2px 5px;
    background: #000000;
    color: #FFF
    }

        .text-black{
            color: black;
        }
        .card:hover{
            box-shadow: none;
        }

        footer{
            padding-top: 20px;
            padding-bottom: 0px;
            margin-bottom: 0px;
        }
    #DesarrolloId_chosen{
        width: 100% !important;
    }
        .tr-secondary-im, #fa-icon-minus-im{
            display: none;
        }
        .tr-secondary-im td{
            padding-left: 7.2%;
        }


        /* Media para no imprimir */
        @media print
        {    
                    .col-xs, .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12, .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-xl, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12 {
                        position: relative;
                        min-height: 1px;
                        padding-right: 15px;
                        padding-left: 15px;
                    }
                    .text-lg-center{
                        text-align:center;
                    }
            body {
            background-image: none;
                    font-size: 11px;
                    -webkit-print-color-adjust: exact;
            /*background-repeat: no-repeat;
            background-size: cover !important;*/
            }
            .bg-container {
                background-color: rgb(255, 255, 255);
            }
            .bg-inner {
                background-color: rgb(255, 255, 255);
            }
                    .no-imprimir, .no-imprimir *
                    {
                        display: none !important;
                    }
                    .logo-printer{
                        width:300px;
                    }
                    .col-lg-3{
                        width:25%;
                    }
                    .col-lg-6{
                        float: left;
                        width: 50%;
                    }
                    .col-lg-12{
                        width:100%
                    }
                    
                    .row {
                        margin-right: -15px;
                        margin-left: -15px;
                    }
                    
                    div {
                        display: block;
                    }
                    
                    table{
                        width:100%;
                        text-align:center;
                    }
                    .row-25{
                        width:25%;
                        text-align: center;
                    }
                    .row-33{
                        width:33%;
                        text-align: center;
                    }
                    .padding-10{
                        padding:1%;
                    } 
                    .clientes{
                        background-color: #034aa2;
                        color:white;
                        font-size:20px;
                    }
                    .ventas{
                        background-color: green;
                        color:white;
                        font-size:20px;
                    }
                    .mdp{
                        background-color: darkgreen;
                        color:white;
                        font-size:20px;
                    }
                    
                    .efectividad{
                        background-color: darkgray;
                        color:white;
                        font-size:20px;
                    }
                    
                    .globalClass_ET{
                        display:none;
                    }
                    
                    .footer {
                        position: fixed;
                        left: 0;
                        bottom: 0;
                        width: 100%;
                        text-align: center;
                    }
                    
                    .card-header{
                        background-color: #2e3c54; 
                        color:white;
                    }
                    .brinco{
                        page-break-after: always;
                    }
                    .text-lg-right{
                        text-align: right;
                    }
                    

                    @page{
            margin: 15px;
            }
        }

    </style>

    <?php echo $this->fetch('content'); ?>

    <div class="m-t-25">
        <div class="row mt-3">
        <div class="col-sm-12" style="background-color: #555555;">
            <p class="text-lg-center" style="color: white;">
            POWERED BY <br>
            <img src="<?= Router::url('/img/logo_inmosystem.png',true) ?>" style="border: 0px; width: 80px; margin: 0px; height: 42px; width: auto;"><br>
                <span style="color:#FFFFFF"><small>Todos los derechos reservados <?= date('Y')?></small></span>
            </p>
        </div>
        </div>
</div>
