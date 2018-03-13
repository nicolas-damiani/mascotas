$(document).ready(function () {
    $('#nuevaPregunta').on({
        'click': function () {
            $('#contenedorNuevaPregunta').css('display', 'block');
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
