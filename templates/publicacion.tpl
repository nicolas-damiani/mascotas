{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Publicación</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>

        <link rel="stylesheet" type="text/css" href="css/publicacion.css"/>
        <script type="text/javascript" src="slick/slick.js"></script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACChU-DFItFOx-BfhQdvtpOGZDJsG88d4&callback=initMap">
        </script>
        <script type="text/javascript" src="js/publicacion.js"></script>
        <script type="text/javascript" src="js/jspdf.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#nuevaPregunta').on({
                    'click': function () {
                        $('#contenedorNuevaPregunta').style('display', 'block');
                    }
                });
            });
        </script>
    </head>
    <body>
        <div id="idPublicacion" style="display: none">{$publicacion.id}</div>
        {include file="encabezado.tpl"}
        <div id="tituloPublicacion">{$publicacion.titulo}</div>


        <div class="filaPublicacion rows">
            <div class="columna1">
                <div id="imagenesPublicacion">
                    {foreach from=$fotos item=valor}
                        <div>
                            <img class="imagenPublicacion" src="imgs/{$publicacion.id}/{$valor}" />
                        </div>
                    {/foreach}
                </div>
                
                    {foreach from=$fotos item=valor}
                            <img  class="imagenPublicacionHidden" src="imgs/{$publicacion.id}/{$valor}" />
                    {/foreach}
            </div>

            <div class="columna2">
                <div class="infoPublicacion first">
                    <div class="labelInfoPublicacion">Estado:</div>
                    <div id="estadoPublicacion" class="dataInfoPublicacion">{$publicacion.tipo}</div>
                </div>

                <div class="infoPublicacion">
                    <div class="labelInfoPublicacion">Especie:</div>
                    <div id="especiePublicacion" class="dataInfoPublicacion">{$especie.nombre}</div>
                </div>

                <div class="infoPublicacion">
                    <div id="descripcionPublicacion">{$publicacion.descripcion}</div>
                </div>
                <div class="infoPublicacion">
                    <div class="labelInfoPublicacion">Ubicación:</div>
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <input id="latitud" value="{$publicacion.latitud}" type="hidden" />
        <input id="longitud" value="{$publicacion.longitud}" type="hidden" />


        <div class='filaPublicacion'>
            <div class='labelInfoPublicacion'>Preguntas:</div>
            <div class='separadorPreguntas'></div>
            {foreach from=$preguntas item=pregunta}
                <div class='contenedorPregunta'>
                    <div class="pregunta">• {$pregunta.texto}</div>
                    {if $creador && ($pregunta.respuesta eq "No hay respuesta aun.")}
                        <div class="contenedorResponder">
                            <input class="inputRespuesta" placeholder="Responder...">
                            <div class="responder" id="{$pregunta.id}">RESPONDER</div>
                        </div>
                    {else}
                        <div class="respuesta">• {$pregunta.respuesta}</div>
                    {/if}
                </div>
                <div class='separadorPreguntas'></div>
            {/foreach}


            {if !$usuario}
                <a href="index.php"><div id="iniciarSesion">Inicia sesión para realizar una pregunta</div></a>
            {elseif (($usuario eq true))}
                <div id="nuevaPregunta" class="boton">Nueva pregunta</div>
            {/if}

            <div id="contenedorNuevaPregunta" style="display: none;">
                <input type="text" id="textoPregunta">
                <input type="button" id="realizarPregunta" value="PREGUNTAR">
            </div>
        </div>

        <div class="filaPublicacion">
            <div id="pdf" class="boton">EXPORTAR PUBLICACIÓN A PDF</div>
        </div>

        {if $creador}
            <div class="filaPublicacion">
                <div class="labelInfoPublicacion" style="width:  22%;">Cerrar Publicación:</div>
                <div id="labelCerrarPublicacion">Indique si la mascota fue encontrada o no</div>
                <select id="selectExito">
                    <option value="1">Encontrada</option>
                    <option value="0">No encontrada</option>
                </select>
                <div id="cerrarPublicacion" class="boton" style="margin-left: 20px;">CERRAR</div>
            </div>
        {/if}
    </body>
</html>