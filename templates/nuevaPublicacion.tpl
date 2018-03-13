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
                {foreach from=$barrios item=valor key=clave}
                    <option value="{$valor.id}">{$valor.nombre}</option>
                {/foreach}
            </select>
        </div>
            
        <div class="infoNuevaPublicacion">
            <div class="infoTitulo">Seleccionar Especie:</div>
            <select id="selectEspecie">
                {foreach from=$especies item=valor key=clave}
                    <option value="{$valor.id}">{$valor.nombre}</option>
                {/foreach}
            </select>
        </div>

    </body>
</html>