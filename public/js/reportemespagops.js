$(document).ready(function () {
    const config = {
        search: true,
    };
    dselect(document.querySelector("#mesInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    function onFrameLoad() {
        Swal.close();
    }

    $(document).on("click", "#btnGenerar", function (e) {
        if (!$("#mesInput").val()) {
            Swal.fire({
                icon: "warning",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">Mes no seleccionado</h1>',
                html: '<p style="font-family: Poppins">Por favor, selecciona un mes de la lista para generar el reporte</p>',
                confirmButtonText:
                    '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });
        } else {
            let fecha = $("#mesInput").val();
            Swal.fire({
                title: '<h2 style="font-family: Poppins;">Generando reporte, espera...</h2>',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            $("#contFrame").empty();
            $("#contFrame").append(`
            <iframe src="/admin/pdfReporteMesPagoPS?fecha=${fecha}" id="frameReporte" class="rounded" title="Reporte" style="width: 100%; height: 100%;">
            </iframe>
            `);

            $("#frameReporte").on("load", function () {
                onFrameLoad();
            });
        }
    });
});
