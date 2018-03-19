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
        </script>
    </head>
    <body>
        <div id="idPublicacion" style="display: none">{$publicacion.id}</div>
        <h1>Realizar Publicacion</h1>


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
            </div
            <br>
            <br>

            <div class="infoNuevaPublicacion">
                <div class="infoTitulo">Seleccionar Especie:</div>
                <select name="especie" id="selectEspecie">
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
                <select name="raza" id="selectRaza">
                    <option disabled selected>Seleccione una Especie para ver Razas</option>
                </select>
            </div>
            <br>
            <br>

            <div class="infoNuevaPublicacion">
                <div class="infoTitulo">Titulo de la publicacion:</div>
                <input name="titulo" type="text" id="titulo">
            </div>
            <br>
            <br>

            <div class="infoNuevaPublicacion">
                <div class="infoTitulo">Descripcion de la publicacion:</div>
                <input name="descripcion" type="text" id="descripcion">
            </div>
            <br>
            <br>

            <div class="infoNuevaPublicacion">
                <div class="infoTitulo">Tipo de publicacion:</div>
                <select name="tipo" id="selectTipo">
                    <option value="E">Encontrada</option>
                    <option value="P">Perdida</option>
                </select>
            </div>
            <br>
            <br>
            <div class="infoNuevaPublicacion">
                <div class="infoTitulo">Seleccione una o multiples imagenes:</div>
                <input type="file" name="archivos[]" multiple/>
            </div>
            
             <input type="hidden" name="accion" value="nuevaPublicacion" />
             
             <div id="map"></div>
             
             <input id="lat" type="hidden" name="latitud" />
             <input id="lng" type="hidden" name="longitud" />
             
            
            

            <input type="submit" value="Crear">

            <!--       <div id="botonNuevaPublicacion">
                       CREAR
                   </div>
            -->
        </form>
    </body>
</html>