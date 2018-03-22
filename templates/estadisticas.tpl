<html>
    <head>
        <title>Publicaciones</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
         <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript" src="js/estadisticas.js"></script>
        <link href="css/estadisticas.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        {include file="encabezado.tpl"}
        <div id="tituloPpalEstadisticas">ESTADISTICAS</div>
        <div class="cuadroEstadisticas">
            <div id="publicacionesPorEspecie"style="display: none"> </div>
            <div class="tituloEstadisticas">Publicaciones por Especies:</div>
            <div id="graficoEspecie" class="graficoEstadisticas"> </div>
        </div>
        <div class="cuadroEstadisticas">
            <div class="tituloEstadisticas">Publicaciones por Estado:</div>
            <div id="graficoEstado" class="graficoEstadisticas"></div>
        </div>
        <div class="cuadroEstadisticas">
            <div class="tituloEstadisticas">Publicaciones Cerradas:</div>
            <div id="graficoExitosas" class="graficoEstadisticas"></div>
        </div>

    </body>
</html>