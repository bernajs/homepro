// $(document).ready(function() {
//     var ctx2 = document.getElementById("chart2").getContext("2d");
//     var data2 = {
//         labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
//         datasets: [
//             {
//                 label: "Uno",
//                 fillColor: "#9575CD",
//                 highlightFill: "#9575CD",
//                 highlightStroke: "#B3B3B3",
//                 data: [65, 59, 80, 81, 56, 55, 40]
//             },
//             {
//                 label: "Dos",
//                 fillColor: "#33AC71",
//                 highlightFill: "#33AC71",
//                 highlightStroke: "#B3B3B3",
//                 data: [28, 48, 40, 19, 86, 27, 90]
//             },
//             {
//                 label: "Tres",
//                 fillColor: "red",
//                 highlightFill: "red",
//                 highlightStroke: "orange",
//                 data: [75, 45, 24, 54, 62, 48, 73]
//             }
//         ]
//     };

//     var chart2 = new Chart(ctx2).Bar(data2, {
//         scaleBeginAtZero: true,
//         scaleShowGridLines: true,
//         scaleGridLineColor: "rgba(0,0,0,.05)",
//         scaleGridLineWidth: 1,
//         scaleShowHorizontalLines: true,
//         scaleShowVerticalLines: false,
//         barShowStroke: true,
//         barStrokeWidth: 2,
//         barDatasetSpacing: 1,
//         legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
//         responsive: true,
//         scaleOverride: true,
//         scaleSteps: 6,
//         scaleStepWidth: 15,
//         scaleStartValue: 0,
//         barValueSpacing: 20,
//         tooltipCornerRadius: 2
//     });

//     var resizeChart;

//     $(window).resize(function(e) {
//         clearTimeout(resizeChart);
//         resizeChart = setTimeout(function() {
//         }, 300);
//     });
// });
