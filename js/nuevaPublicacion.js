$(document).ready(function () {
    $('#selectEspecie').on('change', function () {
        cargarRazasSelector(this.value);
    })

    $("form").submit(function (e) {
        var barrioId = $('#selectBarrio').val();
        var especieId = $('#selectEspecie').val();
        var razaId = $('#selectRaza').val();
        var tipo = $('#selectTipo').val();
        var titulo = $('#titulo').val();
        var descripcion = $('#descripcion').val();
        var imageFiles = document.getElementById("imagenes"),
        filesLength = imageFiles.files.length;

        if (barrioId == null || especieId == null || razaId == null || titulo == "" || descripcion == "") {
            e.preventDefault();
            alert("debe completar todos los datos.");
        }
        if (filesLength==0){
            e.preventDefault();
            alert("Debe de seleccionar por lo menos una imagen");
        }
    });
});


function initMap() {
    var uluru = {lat: -34.5, lng: -56};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru
    });
    var marker = new google.maps.Marker({
        position: uluru,
        map: map,
        draggable: true
    });
    marker.addListener('drag', handleEvent);
    marker.addListener('dragend', handleEvent);
}


function handleEvent(event) {
    document.getElementById('lat').value = event.latLng.lat();
    document.getElementById('lng').value = event.latLng.lng();
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