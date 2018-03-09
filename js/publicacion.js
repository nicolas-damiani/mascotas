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
        url: "nuevaPregunta.php",
        dataType: "json",
        type: "POST",
        data: "texto=" + textoPregunta + "&publicacion=" + idPublicacion,
        timeout: 2000,
        beforeSend: function () {
            //cargando();
        }
    }).done(function (data) {
        if (data == "ok") {
            location.reload();
        }
    })
}
