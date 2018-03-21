<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/encabezado.css">
    </head>
    <body>
        <div id="divEncabezado"> 

            <div id="contenedorLogoHeader">
                <img id="logoHeader" src='/Obligatorio/imgs/logo.png'> 
            </div>
            
            <div class="opcionEncabezado">Publicaciones</div>


            {if $usuario}
                <div class="opcionEncabezado">Nueva Publicacion</div>
            {/if}

            {if $usuario}
                <div class="opcionEncabezado">Estadisticas</div>
            {/if}
            
            {if !$usuario}
                <div class="opcionEncabezado">Iniciar Sesion</div>
            {else}
                <div class="opcionEncabezado">Cerrar Sesion</div>
            {/if}
        </div>
    </body>
