<?php

require_once("_class/class.dashboard.php");
$Dashboard = new Dashboard();

$cotizaciones = $Dashboard->get_cotizaciones();
$negocios = $Dashboard->get_negocios();
$usuarios = $Dashboard->get_usuarios();

?>

  <style>
    #chart2,
    .card-content div {
      height: 60vh !important;
      width: 70vw !important;
    }
    
    .mn-inner {
      padding: 0px 0px 0px !important;
      padding-left: 245px !important;
      min-height: calc(100% - 181px);
    }
    /*
.orders {
padding-left: 25px;
position: relative;
}
*/
    
    .usuarios {
      background-color: #2c3e50;
      height: 15px !important;
      width: 15px !important;
      position: absolute;
      left: 0;
    }
    
    .negocios {
      background-color: #2980b9;
      height: 15px !important;
      width: 15px !important;
      position: absolute;
      left: 0;
    }
    
    .cotizaciones {
      background-color: #c0392b;
      height: 15px !important;
      width: 15px !important;
      position: absolute;
      left: 0;
    }
    
    .label {
      padding-left: 25px;
      position: relative;
    }
  </style>

  <div class="row">
    <div class="col s12">
      <!--<div class="page-title">Dashboard</div>-->
      <div class="label margint-10"><span class="usuarios"></span>Usuarios</div>
      <div class="label"><span class="negocios"></span>Negocios</div>
      <div class="label"><span class="cotizaciones"></span>Cotizaciones</div>
    </div>

    <div class="col s12 grafica">
      <div class="card">
        <div class="card-content">
          <span class="card-title">Estadísticas por mes</span>
          <div>
            <canvas id="chart2" width="400" height="270"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>


  <script>
    $(document).ready(function(e) {

      var usuarios = <?php echo json_encode($usuarios); ?>;
      var negocios = <?php echo json_encode($negocios); ?>;
      var cotizaciones = <?php echo json_encode($cotizaciones); ?>;
      var usuarios_mes = new Array(12);
      var negocios_mes = new Array(12);
      var cotizaciones_mes = new Array(12);

      var meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

      // Crea los arreglos y les cada elemento lo iguala a 0
      usuarios_mes = meses.map(function(mes) {
        return 0;
      });
      negocios_mes = meses.map(function(mes) {
        return 0;
      });
      cotizaciones_mes = meses.map(function(mes) {
        return 0;
      });

      usuarios.forEach(function(element) {
        // Compara si el arreglo en la posicion del mes existe sino lo iguala a 1 para que si se vuelve
        // a encontrar el mismo mes ahora lo sume
        usuarios_mes[element.mes - 1] ? usuarios_mes[element.mes - 1] += 1 : usuarios_mes[element.mes - 1] = 1;
      });

      negocios.forEach(function(element) {
        negocios_mes[element.mes - 1] ? negocios_mes[element.mes - 1] += 1 : negocios_mes[element.mes - 1] = 1;
      });

      cotizaciones.forEach(function(element) {
        cotizaciones_mes[element.mes - 1] ? cotizaciones_mes[element.mes - 1] += 1 : cotizaciones_mes[element.mes - 1] = 1;
      });

      // Gráfica

      var ctx2 = document.getElementById("chart2").getContext("2d");
      var data2 = {
        labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        datasets: [{
          label: "Uno",
          fillColor: "#2c3e50",
          highlightFill: "#2c3e50",
          highlightStroke: "#2c3e50",
          data: usuarios_mes
        }, {
          label: "Dos",
          fillColor: "#2980b9",
          highlightFill: "#2980b9",
          highlightStroke: "#2980b9",
          data: negocios_mes
        }, {
          label: "Tres",
          fillColor: "#c0392b",
          highlightFill: "#c0392b",
          highlightStroke: "#c0392b",
          data: cotizaciones_mes
        }]
      };

      var chart2 = new Chart(ctx2).Bar(data2, {
        scaleBeginAtZero: true,
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: false,
        barShowStroke: true,
        barStrokeWidth: 2,
        barDatasetSpacing: 1,
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        responsive: true,
        scaleOverride: true,
        scaleSteps: 6,
        scaleStepWidth: 15,
        scaleStartValue: 0,
        barValueSpacing: 20,
        tooltipCornerRadius: 2
      });

      var resizeChart;

      $(window).resize(function(e) {
        clearTimeout(resizeChart);
        resizeChart = setTimeout(function() {}, 300);
      });
    })
  </script>