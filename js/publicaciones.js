var razas = [];
var pagina = "";
var filtros = {tipo: 0, especie: 0, raza: 0, barrio: 0, palabras: ""};
var isFiltered = false;


$(document).ready(function () {
    comportamientoInicial();

    $('#filtroEspecie').on('change', function () {
        cargarRazasSelector(this.value);
    })
    $('#filtrarBtn').on('click', function () {
        filtros.tipo = $("#filtroTipo").val();
        filtros.especie = $("#filtroEspecie").val();
        filtros.raza = $("#filtroRaza").val();
        filtros.barrio = $("#filtroBarrio").val();
        filtros.palabras = $("#filtroPalabras").val();
        filtrarPublicaciones(1);
        isFiltered = true;
    })

});

function comportamientoInicial() {
    $("#paginacion a").click(function (e) {
        e.preventDefault();
        if (!isFiltered) {
            cargarPagina($(this).attr("alt"));
        } else {
            filtrarPublicaciones($(this).attr("alt"));
        }
    });
}



function cargarPagina(p) {
    pagina = p;
    $.ajax({
        url: "publicaciones.php",
        dataType: "json",
        type: "POST",
        data: "accion=ajax&p=" + p,
        timeout: 2000,
        beforeSend: function () {
            //  cargando();
        }
    }).done(function (data) {
        var tabla = $(".cuerpo table").empty();

        var tr = $("<tr />");
        tr.append($("<th />").html("Título"));
        tr.append($("<th />").html("Descripción"));
        tr.append($("<th />").html("Tipo"));
    tr.append($("<th />").html("Imagen"));
        tabla.append(tr);

        for (var i = 0; i < data.length; i++) {
            tr = $("<tr />");
            tr.append($("<td />").html(data[i].titulo));
            tr.append($("<td />").html(data[i].descripcion));
            tr.append($("<td />").html(data[i].tipo));

            if (data[i].foto != "")
                tr.append($("<td />").html("<img class='imagenPublicacion' src='imgs/" + data[i].id + "/"+data[i].foto + "' />"));
            tabla.append(tr);
        }

        //     $(cargandoDialog).dialog("close");
        // cambiar la pagina seleccionada
    });

}


function cargarRazasSelector(id) {

    $.ajax({
        url: "publicaciones.php",
        dataType: "json",
        type: "POST",
        data: "accion=razas&especie=" + id,
        timeout: 2000,
        beforeSend: function () {
            //      cargando();
        }
    }).done(function (data) {
        var selector = $("#filtroRaza").empty();
        var option = $('<option value="0"/>').html("No especifica</option>");
        selector.append(option);
        for (var i = 0; i < data.length; i++) {
            option = $('<option value="' + data[i].id + '"/>').html(data[i].nombre + "</option>");
            selector.append(option);
        }

    });

}

var cargandoDialog = null;
function cargando() {
    cargandoDialog = $("#dialog-cargando").dialog({
        resizable: false,
        height: "auto",
        width: "auto",
        modal: true,
        buttons: {},
        open: function (event, ui) {
            $("#dialog-cargando").parent().find(".ui-dialog-titlebar").hide();
        }
    });

}


function filtrarPublicaciones(p) {
    pagina = p;
    $.ajax({
        url: "publicaciones.php",
        dataType: "json",
        type: "POST",
        data: "accion=filtro&p=" + pagina + "&tipo=" + filtros.tipo + "&especie=" + filtros.especie + "&raza=" + filtros.raza + "&barrio=" + filtros.barrio + "&palabras=" + filtros.palabras,
        timeout: 2000,
        beforeSend: function () {
            //      cargando();
        }
    }).done(function (data) {

        var publicaciones = data.publicaciones;

        cargarTablaPublicaciones(publicaciones);
        var paginacion = data.paginacion;

        cargarPaginacion(paginacion);

    });

}

function cargarTablaPublicaciones(publicaciones) {
    var tabla = $(".cuerpo table").empty();

    var tr = $("<tr />");
    tr.append($("<th />").html("Título"));
    tr.append($("<th />").html("Descripción"));
    tr.append($("<th />").html("Tipo"));
    tr.append($("<th />").html("Imagen"));
    tabla.append(tr);

    for (var i = 0; i < publicaciones.length; i++) {
        tr = $("<tr />");
        tr.append($("<td />").html("<a target='_blank' href='publicacion.php?publicacion=" + publicaciones[i].id + "'>" + publicaciones[i].titulo + "</a>"));
        tr.append($("<td />").html(publicaciones[i].descripcion));
        tr.append($("<td />").html(publicaciones[i].tipo));
        if (publicaciones[i].foto != "")
            tr.append($("<td />").html("<img class='imagenPublicacion' src='imgs/" + publicaciones[i].id +"/" +publicaciones[i].foto + "' />"));
        tabla.append(tr);
    }
}

function cargarPaginacion(paginacion) {
    var tabla = $("#paginacion").empty();
    var paginacionInterna;

    for (var i = 0; i < paginacion.length; i++) {
        //   paginacionInterna = "<li><a href='?p=" + paginacion[i].p + "' alt='" + paginacion[i].p + "'>" + paginacion[i].texto + "</a></li>"
        paginacionInterna = "<li><a href='?p=" + paginacion[i].p + "' alt='" + paginacion[i].p + "'>" + paginacion[i].texto + "</a></li>"


        tabla.append(paginacionInterna);
    }

    $("#paginacion a").click(function (e) {
        e.preventDefault();
        if (!isFiltered) {
            cargarPagina($(this).attr("alt"));
        } else {
            filtrarPublicaciones($(this).attr("alt"));
        }
    });
    ///   $("#paginacion a.sel").removeClass("sel");
    //   $("#paginacion a").eq(parseInt(pagina) - 1).addClass("sel");
}