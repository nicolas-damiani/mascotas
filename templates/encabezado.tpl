<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/encabezado.css">
    </head>
    <body>
        <div class="contenidoEncabezado">
            <div id="contenedorLogoHeader">
                <img id="logoHeader" src='/Obligatorio/imgs/logo.png'> 
            </div>
            <div id="divEncabezado"> 


                <div class="opcionEncabezado"><a href="publicaciones.php">Publicaciones</a></div>


                {if $usuario}
                    <div class="opcionEncabezado">
                        <a href="nuevaPublicacion.php">Nueva Publicacion</a>
                    </div>
                {/if}

                {if $usuario}
                    <div class="opcionEncabezado"><a href="estadisticas.php">Estadisticas</a></div>
                {/if}

                {if !$usuario}
                    <div class="opcionEncabezado"><a href="registro.php">Registrarme</a></div>
                    <div class="opcionEncabezado"><a href="login.php">Iniciar Sesion</a></div>
                {else}
                    <div class="opcionEncabezado"><a href="login.php?accion=logout">Cerrar Sesion</a></div>
                {/if}
            </div>
        </div>
    </body>
