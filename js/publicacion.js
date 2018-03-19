$(document).ready(function () {
    $('#nuevaPregunta').on({
        'click': function () {
            $('#contenedorNuevaPregunta').css('display', 'block');
        }
    });
    
    $('#cerrarPublicacion').on({
        'click': function () {
            cerrarPublicacion();
        }
    });
    
    $('#exportar').on({
        'click': function () {
            exportarPublicacion();
        }
    });
    
    $('#realizarPregunta').on({
        'click': function () {
            var textoPregunta = $('#textoPregunta').val();
            var idPublicacion = $('#idPublicacion').html();
            if (textoPregunta != "") {
                nuevaPregunta(textoPregunta, idPublicacion);
            } else {
                alert("No puede estar vacia");
            }
        }
    });
});

function exportarPublicacion(){
    $.ajax({
        url: "publicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=exportarPublicacion",
        timeout: 2000,
        beforeSend: function () {
            //cargando();
        }
    }).done(function (data) {
        if (data.status == "ok") {
            alert('publicacion cerrada');
        }else{
            alert("error cerrando publicacion");
        }
    })
}

function cerrarPublicacion(){
    var exitoso = $('#selectExito').val();
    var idPublicacion = $('#idPublicacion').html();
    $.ajax({
        url: "publicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=cerrarPublicacion&exitosa=" + exitoso+"&idPublicacion="+idPublicacion,
        timeout: 2000,
        beforeSend: function () {
            //cargando();
        }
    }).done(function (data) {
        if (data.status == "ok") {
            alert('publicacion cerrada');
        }else{
            alert("error cerrando publicacion");
        }
    })
}

function nuevaPregunta(textoPregunta, idPublicacion) {

    $.ajax({
        url: "publicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=nuevaPregunta&texto=" + textoPregunta + "&idPublicacion=" + idPublicacion,
        timeout: 2000,
        beforeSend: function () {
            //cargando();
        }
    }).done(function (data) {
        if (data.status == "ok") {
            location.reload();
        }
    })
}
