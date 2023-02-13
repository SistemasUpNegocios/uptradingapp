$(document).ready(function () {
    const config = {
        search: true,
    };

    dselect(document.querySelector("#clienteIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let dolar = 0;
    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp",
        success: function (response) {
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                dolar = serie.datos[0].dato;
            }
        },
    });

    $("#clienteIdInput").change(function () {
        var id = $("#clienteIdInput").val();

        $.ajax({
            type: "GET",
            data: {
                id: id,
                dolar: dolar,
            },
            url: "/admin/showConcentrado",
            success: function (response) {
                $("#contDatos").empty();
                $("#contDatos").html(response);
            },
            error: function (response) {
                console.log(response);
            },
        });
    });
});
