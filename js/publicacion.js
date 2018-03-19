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

    $('#pdf').on({
        'click': function () {
            var doc = new jsPDF();

            doc.text(10, 10, "Titulo: " + $('#tituloPublicacion').html());
            doc.text(10, 20, "Estado: " + $('#estadoPublicacion').html());
            doc.text(10, 30, "Especie: " + $('#especiePublicacion').html());
            doc.text(10, 40, 'Descripcion' + $('#descripcionPublicacion').html());

            var position = 50;
            $('.imagenPublicacion').each(function (index) {
                doc.addImage(this, 'png', 10, position);
                position += 60;
            });
            doc.save('Test.pdf');
        }
    });

    $('#exportar').on({
        'click': function () {
            exportarPublicacion();
        }
    });


    $('#imagenesPublicacion').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2600,
        dots: true,
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

function exportarPublicacion() {
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
        } else {
            alert("error cerrando publicacion");
        }
    })
}

function cerrarPublicacion() {
    var exitoso = $('#selectExito').val();
    var idPublicacion = $('#idPublicacion').html();
    $.ajax({
        url: "publicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=cerrarPublicacion&exitosa=" + exitoso + "&idPublicacion=" + idPublicacion,
        timeout: 2000,
        beforeSend: function () {
            //cargando();
        }
    }).done(function (data) {
        if (data.status == "ok") {
            alert('publicacion cerrada');
        } else {
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
