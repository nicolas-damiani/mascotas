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
        <script type="text/javascript" src="js/publicacion.js"></script>
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
        <h1>{$publicacion.titulo}</h1>

        <div class="fila">
            <div class="col1">
                <div class="label">Estado:</div>
                <h2>{$publicacion.tipo}</h2>
            </div>
            <div class="col2">
                <div class="label">Especie:</div>
                <h2>{$especie.nombre}</h2>
            </div>
        </div>
        <p>{$publicacion.descripcion}</p>

        <div id="imagenesPublicacion">
            {foreach from=$fotos item=valor}
                <div>
                    <img class="imagenPublicacion" src="imgs/{$publicacion.id}/{$valor}" />
                </div>
            {/foreach}
        </div>

        <ul>{foreach from=$preguntas item=pregunta}
            <div class="pregunta">Pregunta: {$pregunta.texto} <br></div>
            <div class="respuesta">Respuesta: {$pregunta.respuesta} <br><br><br></div>
                {/foreach}
            </ul>

            {if !$usuario}
                <a href="login.php">Inicia sesión para realizar una pregunta</a>
            {elseif (($usuario eq true) and ($cerrada eq false))}
                <div id="nuevaPregunta">Nueva pregunta</div>
            {else}
                <div>La publicación ya fue cerrada, no se pueden realizar preguntas nuevas</div>
            {/if}

            <div id="contenedorNuevaPregunta" style="display: none;">
                <input type="text" id="textoPregunta">
                <input type="button" id="realizarPregunta" value="PREGUNTAR">
            </div>

            <div>Creador: {$creador}</div>

            <div id="exportar">
                EXPORTAR
            </div>

            {*            {if ($creador and !$cerrada)}*}
            <div>Indique si la mascota fue encontrada o no</div>
            <select id="selectExito">
                <option value="1">Encontrada</option>
                <option value="0">No encontrada</option>
            </select>
            <div id="cerrarPublicacion">CERRAR</div>
            {*            {else}*}
            {*    {if $exitosa} 
            <div>La mascota fue encontrada por su dueño! Muchas gracias!</div>
            {else}
            <div>Lamentablemente la mascota no fue encontrada por su dueño.</div>
            {/if}
            {/if}*}
            <p>
                <a href="noticias.php">Volver a las noticias</a>
            </p>
        </body>
    </html>