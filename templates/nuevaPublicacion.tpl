{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Publicación</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/nuevaPublicacion.js"></script>

        <link rel="stylesheet" type="text/css" href="css/nuevaPublicacion.css"/>


        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACChU-DFItFOx-BfhQdvtpOGZDJsG88d4&callback=initMap">
                    $(document).ready(function () {
                        
                    });
        </script>
    </head>
    <body>
        <div id="idPublicacion" style="display: none">{$publicacion.id}</div>
        {include file="encabezado.tpl"}
        <div id="contenedorPublicacion">
            <div id="tituloNuevaPublicacion">Realizar Publicacion</div>


            <form method="POST" action="nuevaPublicacion.php"
                  enctype="multipart/form-data">

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Seleccionar Barrio:</div>
                    <select name="barrio" id="selectBarrio">
                        <option disabled selected>Seleccione un Barrio</option>
                        {foreach from=$barrios item=valor key=clave}
                            <option value="{$valor.id}">{$valor.nombre}</option>
                        {/foreach}
                    </select>
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Seleccionar Especie:</div>
                    <select name="especie" id="selectEspecie">
                        <option disabled selected>Seleccione una Especie</option>
                        {foreach from=$especies item=valor key=clave}
                            <option value="{$valor.id}">{$valor.nombre}</option>
                        {/foreach}
                    </select>
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Seleccionar Raza:</div>
                    <select name="raza" id="selectRaza">
                        <option disabled selected>Seleccione una Especie para ver Razas</option>
                    </select>
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Titulo de la publicacion:</div>
                    <input name="titulo" type="text" id="titulo">
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Descripcion de la publicacion:</div>
                    <input name="descripcion" type="text" id="descripcion">
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Tipo de publicacion:</div>
                    <select name="tipo" id="selectTipo">
                        <option value="E">Encontrada</option>
                        <option value="P">Perdida</option>
                    </select>
                </div>

                <div class="infoNuevaPublicacion">
                    <div class="infoTitulo">Seleccione una o multiples imagenes:</div>
                    <input id="imagenes" type="file" name="archivos[]" multiple/>
                </div>

                <input type="hidden" name="accion" value="nuevaPublicacion" />

                <div id="labelMapa">Marque la ubicacion en el mapa:</div>
                <div id="map"></div>

                <input id="lat" type="hidden" name="latitud" value="-34.5"/>
                <input id="lng" type="hidden" name="longitud" value="-56"/>




                <button id="botonNuevaPublicacion" type="submit">Crear</button>

            </form>
        </div>

        <!--       <div id="botonNuevaPublicacion">
                   CREAR
               </div>
        -->
    </body>
</html>