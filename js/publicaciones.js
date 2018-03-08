$(document).ready(function () {
    comportamientoInicial();
});

function comportamientoInicial() {
    $("#paginacion a").click(function (e) {
        e.preventDefault();

        cargarPagina($(this).attr("alt"));
    });
}

var pagina = $('p').text();

function cargarPagina(p) {
    pagina = p;
    $.ajax({
        url: "publicaciones.php",
        dataType: "json",
        type: "POST",
        data: "accion=ajax&p=" + p,
        timeout: 2000,
        beforeSend: function () {
            cargando();
        }
    }).done(function (data) {
        var tabla = $(".cuerpo table").empty();

        var tr = $("<tr />");
        tr.append($("<th />").html("Título"));
        tr.append($("<th />").html("Descripción"));
        tr.append($("<th />").html("Tipo"));
        tabla.append(tr);

        for (var i = 0; i < data.length; i++) {
            tr = $("<tr />");
            tr.append($("<td />").html(data[i].titulo));
            tr.append($("<td />").html(data[i].descripcion));
            tr.append($("<td />").html(data[i].tipo));
            tabla.append(tr);
        }

        $(cargandoDialog).dialog("close");
        // cambiar la pagina seleccionada
        $("#paginacion a.sel").removeClass("sel");
        $("#paginacion a").eq(parseInt(pagina) - 1).addClass("sel");
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