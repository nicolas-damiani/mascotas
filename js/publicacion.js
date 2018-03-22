$(document).ready(function () {
    $('#nuevaPregunta').on({
        'click': function () {
            $('#contenedorNuevaPregunta').css('display', 'flex');
        }
    });

    $('#cerrarPublicacion').on({
        'click': function () {
            cerrarPublicacion();
        }
    });

    $('.responder').on({
        'click': function () {
            var idPregunta = this.id;
            var respuesta = $(this).siblings('.inputRespuesta').val();
            if (respuesta != "" && respuesta != " ") {
                responderPregunta(idPregunta, respuesta);
            } else {
                alert("La respuesta no puede ser vacia");
            }
        }
    });

    $('#pdf').on({
        'click': function () {
            var doc = new jsPDF(),
                    margins = {
                        top: 40,
                        bottom: 60,
                        left: 40,
                        width: 522
                    };

            var pageHeight = doc.internal.pageSize.height;
            
            doc.setFontType("bold");
            doc.text(10, 10, "Titulo: ");
            doc.setFontType("normal");
            doc.text(50, 10, $('#tituloPublicacion').html());
            doc.setFontType("bold");
            doc.text(10, 20, "Estado: ");
            doc.setFontType("normal");
            doc.text(50, 20, $('#estadoPublicacion').html());
            doc.setFontType("bold");
            doc.text(10, 30, "Especie: ");
            doc.setFontType("normal");
            doc.text(50, 30, $('#especiePublicacion').html());
            doc.setFontType("bold");
            doc.text(10, 40, "Descripción:");
            doc.setFontType("normal");
            var descripcion = doc.splitTextToSize($('#descripcionPublicacion').html(), 140);

            var position = 40;
            descripcion.forEach(function (item, index) {
                if (position >= (pageHeight-20))
                {
                    doc.addPage();
                    position = 10;
                }
                doc.text(50, position, item);
                position += 10;
            });

            $('.imagenPublicacionHidden').each(function (index) {
                if (position >= (pageHeight-20))
                {
                    doc.addPage();
                    position = 10;
                }
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

function initMap() {
    if ($('#latitud').val() != "" && $('#longitud').val() != "") {

        var lat = parseInt($('#latitud').val());
        var long = parseInt($('#longitud').val());


        var uluru = {lat: lat, lng: long};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    } else {
        $('#map').css('display', 'none');
    }
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

function responderPregunta(idPregunta, respuesta) {

    $.ajax({
        url: "publicacion.php",
        dataType: "json",
        type: "POST",
        data: "accion=responderPregunta&idPregunta=" + idPregunta + "&respuesta=" + respuesta,
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
