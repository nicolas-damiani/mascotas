{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Publicación</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/nuevaPublicacion.js"></script>
        <script>
            $(document).ready(function () {

            });
        </script>
    </head>
    <body>
        <div id="idPublicacion" style="display: none">{$publicacion.id}</div>
        <h1>Realizar Publicacion</h1>


        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Seleccionar Barrio:</div>
            <select id="selectBarrio">
                <option disabled selected>Seleccione un Barrio</option>
                {foreach from=$barrios item=valor key=clave}
                    <option value="{$valor.id}">{$valor.nombre}</option>
                {/foreach}
            </select>
        </div
            <br>
            <br>

        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Seleccionar Especie:</div>
            <select id="selectEspecie">
                <option disabled selected>Seleccione una Especie</option>
                {foreach from=$especies item=valor key=clave}
                    <option value="{$valor.id}">{$valor.nombre}</option>
                {/foreach}
            </select>
        </div>
            <br>
            <br>
            
        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Seleccionar Raza:</div>
            <select id="selectRaza">
                <option disabled selected>Seleccione una Especie para ver Razas</option>
            </select>
        </div>
            <br>
            <br>

        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Titulo de la publicacion:</div>
            <input type="text" id="titulo">
        </div>
            <br>
            <br>

        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Descripcion de la publicacion:</div>
            <input type="text" id="descripcion">
        </div>
            <br>
            <br>

        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Tipo de publicacion:</div>
            <select id="selectTipo">
                <option value="E">Encontrada</option>
                <option value="P">Perdida</option>
            </select>
        </div>
            <br>
            <br>

            
            <div id="botonNuevaPublicacion">
                CREAR
            </div>
    </body>
</html>