$(document).ready(function () {
    $('#selectEspecie').on('change', function () {
        cargarRazasSelector(this.value);
    })

    $('#botonNuevaPublicacion').on('click', function () {
        crearPublicacion();
    })
});

function crearPublicacion() {
    var barrioId = $('#selectBarrio').val();
    var especieId = $('#selectEspecie').val();
    var razaId = $('#selectRaza').val();
    var tipo = $('#selectTipo').val();
    var titulo = $('#titulo').val();
    var descripcion = $('#descripcion').val();
    if (barrioId != null && especieId != null && razaId != null && titulo != "" && descripcion != "") {
        $.ajax({
            url: "nuevaPublicacion.php",
            dataType: "json",
            type: "POST",
            data: "accion=nuevaPublicacion&tipo=" + tipo + "&especie=" + especieId + "&raza=" + razaId + "&titulo=" + titulo + "&descripcion=" + descripcion + "&barrio=" + barrioId,
            timeout: 2000,
            beforeSend: function () {
                //      cargando();
            }
        }).done(function (data) {
            if (data.status == "ok") {
                alert("Publicacion agregada correctamente");
            } else {
                alert("No se pudo agregar la publicacion");
            }

        });
    } else {
        alert("Debe llenar todos los datos");
    }
}

function enviarImagenes() {
    var data = new FormData($('input[name^="media"]'));
    jQuery.each($('input[name^="media"]')[0].files, function (i, file) {
        data.append(i, file);
    });

    $.ajax({
        type: ppiFormMethod,
        data: data,
        url: ppiFormActionURL,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            alert(data);
        }
    });
}

function cargarRazasSelector(id) {

    $.ajax({
        url: "nuevaPublicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=cargarRazas&especie=" + id,
        timeout: 2000,
        beforeSend: function () {
            //      cargando();
        }
    }).done(function (data) {
        var selector = $("#selectRaza").empty();
        var option = $('<option value="0" disabled selected>').html("Seleccione una Raza</option>");
        selector.append(option);
        for (var i = 0; i < data.length; i++) {
            option = $('<option value="' + data[i].id + '"/>').html(data[i].nombre + "</option>");
            selector.append(option);
        }

    });

}