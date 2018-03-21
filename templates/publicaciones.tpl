{* Smarty *}
<!DOCTYPE html>

<html>
    <head>
        <title>Publicaciones</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/estilos.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="js/publicaciones.js"></script>
        <link href="css/publicaciones.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>


        {include file="encabezado.tpl"}


        <h1>PUBLICACIONES</h1>
        <div class="contenido">
            <div id="p" style="display: none">{$p}</div>
            <div class="columnaFiltro">
                <div class="filtrosTitulo">Filtros</div>
                <div class="filtrosContainer">
                    <div class="filtro">
                        <div class="filtroTitulo">Tipo</div>
                        <select id="filtroTipo" class="filtroSelect">
                            <option value="0">No especifica</option>
                            <option value="P">Perdido</option>
                            <option value="E">Encontrado</option>
                        </select>
                    </div>
                    <div class="filtro">
                        <div class="filtroTitulo">Especie</div>
                        <select id="filtroEspecie" class="filtroSelect">
                            <option value="0">No especifica</option>
                            {foreach from=$especies item=valor key=clave}
                                <option value="{$valor.id}">{$valor.nombre}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="filtro">
                        <div class="filtroTitulo">Raza</div>
                        <select id="filtroRaza" class="filtroSelect">
                            <option value="0">No especifica</option>
                        </select>
                    </div>
                    <div class="filtro">
                        <div class="filtroTitulo">Barrio</div>
                        <select id="filtroBarrio" class="filtroSelect">
                            <option value="0">No especifica</option>
                            {foreach from=$barrios item=valor key=clave}
                                <option value="{$valor.id}">{$valor.nombre}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="filtro">
                        <input id="filtroPalabras" placeholder="Palabras Claves"type="text" name="fname">
                    </div>    

                    <div id="filtrarBtn">
                        Filtrar
                    </div>

                </div>
            </div>

            <div class="columnaPublicaciones">
                <div class="cuerpo">
                    <table class="tablaPublicaciones" width="80%" cellpadding="0" cellspacing="0">
                        {foreach from=$publicaciones item=valor key=clave}

                            <tr class="filaMiniatura">

                                {if ($valor.foto!="")}
                                    <td width="150px"><a target="_blank" href="publicacion.php?publicacion={$valor.id}"><img class="imagenPublicacion" src="imgs/{$valor.id}/{$valor.foto}" /></a></td>
                                        {/if}
                                <td > <div class="tituloMiniatura"><a target="_blank" href="publicacion.php?publicacion={$valor.id}">{$valor.titulo}</a></div>
                                    <div class="descripcionMiniatura"> {$valor.descripcion} </div></td>
                                <td width="150px">{$valor.tipo}</td>

                            </tr>

                        {/foreach}
                    </table>
                </div>
                {include file="paginacion.tpl"}
            </div>
        </div>



        <div style="display: none">
            <div id="dialog-cargando" title="">
                <p><img  src="imgs/loading-icon.gif" alt="cargando..." /></p>
            </div>
        </div>



    </body>
</html>
