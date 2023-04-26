<!DOCTYPE html>
<html>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway&display=swap');
        body{
            font-size: 9px;
            font-family: 'Raleway', sans-serif;
            font-weight: 500;
        }
        footer {position: fixed; bottom: -20px; left: 0px; right: 0px; background-color: #555555; height: 55px; }
        .img-fluid{
            width: 150px;
            height: auto;
            position: absolute;
            top: 10.5px;
        }
        .text-center{
            text-align: center;
        }
        h1{
            font-size: 1.3rem;
        }
        h3{
            font-size: 1.1rem;
        }
        h1, h3{
            margin-bottom: 0.5rem;
            font-family: "Syncopate", sans-serif;
            font-weight: 500;
            line-height: 1.1;
            text-transform: uppercase;
        }
        a{
            color: black;
            text-decoration: none;
        }
        small{font-size: .8rem; color: #d2d2d2;}
    </style>
    <head>
        <title>Reporte de estatus de mis clientes | Adryo</title>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
    <body>
        <section>
            <table style="width: 100%;">
                <tr>
                    <td colspan="3" style="width:100%; text-align:left; color: #FFF; background-color: #2e3c54; padding: 7px;">ESTATUS GENERAL DE CLIENTES</td>
                </tr>
                <tr style="top: 30px;">
                    <td style="width: 33.3%;">
                        <img src="<?= Router::url($this->Session->read('CuentaUsuario.Cuenta.logo'),true) ?>" alt="Logo cuenta" class="img-fluid">
                    </td>
                    <td style="width: 33.3%;">
                        <h1 class="text-center">Reporte de Desempeño</h1>
                        <p class="text-center" style="font-size: .9rem;">
                            <?= $this->Session->read('CuentaUsuario.Cuenta.razon_social') ?>
                            <br>
                            <?= $this->Session->read('CuentaUsuario.Cuenta.direccion') ?>
                            <br>
                            <?= $this->Session->read('CuentaUsuario.Cuenta.telefono_1') ?>
                            <br>
                            <?= $this->Html->link($this->Session->read('CuentaUsuario.Cuenta.pagina_web'), 'http://'.$this->Session->read('CuentaUsuario.Cuenta.pagina_web'), array('target'=>'_Blanck')) ?>
                        </p>
                    </td>
                    <td style="width: 33.3%;">
                        <p style="text-align: right; display: block; margin-top: -42px;">
                            Fecha
                            <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?>
                        </p>
                    </td>
                </tr>
                <tr style="width: 100%;">
                    <hr style="margin-top: .2rem; border-bottom: 1px rgba(0, 0, 0, 0.1);">
                    <h3>
                        Graficas de usuarios
                    </h3>
                </tr>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="width:100%; text-align:left; color: #FFF; background-color: #2e3c54; padding: 7px;">ESTATUS GENERAL DE MIS CLIENTES</td>
                </tr>
                <tr style="margin-top: 0px; padding-top: 0px;">
                    <td  style="border: 1px solid #d1d1d1; padding: 7px;">
                        <div id="grafica_estatus_general_clientes" style="width: 500px; height: 300px;"></div>
                        <div style="width: 100%;">
                          <i>
                            <small>INFORMACIÓN DE <?= date('d-m-Y', strtotime($fecha_ini)).' al '.date('d-m-Y', strtotime($fecha_fin)) ?></small>
                          </i>
                        </div>
                    </td>
                </tr>
            </table>
        </section>
        <footer>
            <table style="width:100%">
                <tr>
                    <td style="width:100%; text-align:center; color: #FFF;">POWER BY</td>
                </tr>
                <tr>
                    <td style="width: 100%;">
                        <img src="<?= Router::url('/img/logo_inmosystem.png',true) ?>" style="border: 0px; margin: 0px; height: 20px; width: auto; margin-left: 43%;">
                    </td>
                </tr>
                <tr>
                    <td style="width:100%; text-align:center; color: #FFF; font-size: .8rem;">Todos los derechos reservados <?= date('Y') ?></td>
                </tr>
            </table>
        </footer>
        <table style="width: 100%">
        </table>
    </body>
</html>
<script type="text/javascript">
$(document).ready(function () {
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(ClienteStatusGeneral);                  // Grafica de status de clientes

    function ClienteStatusGeneral(){
      var data = google.visualization.arrayToDataTable([
          ["Estado", "Cantidad", { role: "style" } ],
          ["ACTIVO", 6, "#BF9000"],
          ["INACTIVO TEMPORAL", 10, "#7F6000"],
          ["INACTIVO DEFINITIVO", 15, "#000000"],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                         2]);

        var options = {
          height: 300,
          titleTextStyle:{
          color:'#616161',
          fontSize: 14,
          textAlign: 'center',
          },
          backgroundColor:'transparent',
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
          hAxis: {
              textStyle:{color: '#616161'}
          },
          vAxis: {
              textStyle:{color: '#616161'}
          }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("grafica_estatus_general_clientes"));

        google.visualization.events.addListener(chart, 'ready', function () {
        grafica_estatus_general_clientes.innerHTML = '<img src="' + chart.getImageURI() + '" style="width: 500px; height300px;">';
        /*console.log(grafica_estatus_general_clientes.innerHTML);*/
        });
        chart.draw(view, options);
    }
});
</script>