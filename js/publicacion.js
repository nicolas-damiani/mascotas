$(document).ready(function () {
    $('#nuevaPregunta').on({
        'click': function () {
            $('#contenedorNuevaPregunta').css('display', 'block');
        }
    });

    $('#imagenesPublicacion').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2600,
                dots: true,
             //   appendDots: $('#circle')
          //      prevArrow: '<img class="slick-prev" src="/files/layouts/leftArrowColor.png" style="display: block;height: 38px;position: absolute;top: 41%;margin-bottom: 0px;margin-left: 18px;z-index: 2;" />',
           //     nextArrow: '<img class="slick-next" src="/files/layouts/rightArrowColor.png" style="display: block;height: 38px;position: absolute;float: right;margin-right: 21px;z-index: 2;right: 0;top: 41%;"/>'
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
