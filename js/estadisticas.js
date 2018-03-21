

var google;

$(document).ready(function () {
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(cargarDatos);
    //  cargarDatos();
    // drawChart();

});

$(window).load(function () {

    /* google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(googleChartReady);
     function googleChartReady() {
     cargarDatos();
     };*/
});




function cargarDatos() {
    $.ajax({
        url: "estadisticas.php",
        dataType: "json",
        type: "POST",
        data: "accion=cargarDatos",
        timeout: 2000,
        beforeSend: function () {
            //  cargando();
        }
    }).done(function (data) {
        var publicacionesPorEspecie = data.publicacionesPorEspecie;
        dibujarGraficaEspecie('graficoEspecie', publicacionesPorEspecie, 'Especies');
        var publicacionesAbierto = data.publicacionesPorAbierto;
        dibujarGraficaTipo('graficoEstado', publicacionesAbierto, 'Tipo');
        var publicacionesExitosas = data.publicacionesExitosas;
        dibujarGraficaExitosas('graficoExitosas', publicacionesExitosas, 'Estado');

    });
}

function dibujarGraficaEspecie(id, datos, titulo) {

    var chartData = new google.visualization.DataTable();
    chartData.addColumn('string', titulo);
    chartData.addColumn('number', 'Cantidad');

    for (var i = 0; i < datos.length; i++) {
        var aux = [datos[i].nombre, parseInt(datos[i].cantidad)];

        chartData.addRow(aux);
    }


    var chart = new google.visualization.PieChart(document.getElementById(id));
    chart.draw(chartData);

}


function dibujarGraficaTipo(id, datos, titulo) {

    var chartData = new google.visualization.DataTable();
    chartData.addColumn('string', titulo);
    chartData.addColumn('number', 'Cantidad');

    chartData.addRow(['Abierto', parseInt(datos.abierto)]);
    chartData.addRow(['Cerrado', parseInt(datos.cerrado)]);




    var chart = new google.visualization.PieChart(document.getElementById(id));
    chart.draw(chartData);

}

function dibujarGraficaExitosas(id, datos, titulo) {

    var chartData = new google.visualization.DataTable();
    chartData.addColumn('string', titulo);
    chartData.addColumn('number', 'Cantidad');

    chartData.addRow(['Exitosa', parseInt(datos.exitosas)]);
    chartData.addRow(['No Exitosa', parseInt(datos.noExitosas)]);

    var options = {
        fill: 'transparent',
        hAxis: {
            textStyle: {color: '#AACCFF'}
        }
    };




    var chart = new google.visualization.PieChart(document.getElementById(id));
    chart.draw(chartData, options);

}