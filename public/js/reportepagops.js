$(document).ready(function () {

    function onFrameLoad() {
        Swal.close();
    }

    $(document).on("click", "#btnGenerar", function (e) {
        if (!$("#fechaDesdeInput").val() || !$("#fechaHastaInput").val()) {
            Swal.fire({
                icon: "warning",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">Fechas no seleccionadas</h1>',
                html: '<p style="font-family: Poppins">Por favor, indica las dos fechas para generar el reporte</p>',
                confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });
        } else {
            let fechadesde = $("#fechaDesdeInput").val();
            let fechahasta = $("#fechaHastaInput").val();
            Swal.fire({
                title: '<h2 style="font-family: Poppins;">Generando reporte, espera...</h2>',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
            $("#contFrame").empty();
            $("#contFrame").append(`
            <iframe src="/admin/pdfReporteFiltroPagoPS?fechadesde=${fechadesde}&fechahasta=${fechahasta}" id="frameReporte" class="rounded" title="Reporte" style="width: 100%; height: 100%;">
            </iframe>
            `);

            $("#frameReporte").on("load", function () {
                onFrameLoad();
            })
        }
    });

    $(document).on("click", "#btnHoy", function (e) {
        e.preventDefault();
        var date = new Date();

        date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
            '-' + date.getDate().toString().padStart(2, 0);

        $("#fechaDesdeInput").val(date);
        $("#fechaHastaInput").val(date);
    });

    $(document).on("click", "#btnSiete", function (e) {
        e.preventDefault();
        var date = new Date();

        date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
            '-' + date.getDate().toString().padStart(2, 0);

        var dateFrom = new Date();
        dateFrom.setDate(dateFrom.getDate() - 7);

        dateFrom = dateFrom.getFullYear().toString() + '-' + (dateFrom.getMonth() + 1).toString().padStart(2, 0) +
            '-' + dateFrom.getDate().toString().padStart(2, 0);

        $("#fechaDesdeInput").val(dateFrom);
        $("#fechaHastaInput").val(date);
    });

    $(document).on("click", "#btnQuince", function (e) {
        e.preventDefault();
        var date = new Date();

        date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
            '-' + date.getDate().toString().padStart(2, 0);

        var dateFrom = new Date();
        dateFrom.setDate(dateFrom.getDate() - 15);

        dateFrom = dateFrom.getFullYear().toString() + '-' + (dateFrom.getMonth() + 1).toString().padStart(2, 0) +
            '-' + dateFrom.getDate().toString().padStart(2, 0);

        $("#fechaDesdeInput").val(dateFrom);
        $("#fechaHastaInput").val(date);
    });

    $(document).on("click", "#btnMes", function (e) {
        e.preventDefault();
        var date = new Date();

        date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
            '-' + date.getDate().toString().padStart(2, 0);

        var dateFrom = new Date();
        dateFrom.setMonth(dateFrom.getMonth() - 1);

        dateFrom = dateFrom.getFullYear().toString() + '-' + (dateFrom.getMonth() + 1).toString().padStart(2, 0) +
            '-' + dateFrom.getDate().toString().padStart(2, 0);

        $("#fechaDesdeInput").val(dateFrom);
        $("#fechaHastaInput").val(date);
    });

    
    function checkFrom() {
        if ($("#fechaHastaInput").val()) {
            var desde = $("#fechaDesdeInput").val();
            var hasta = $("#fechaHastaInput").val();

            if (desde > hasta) {
                $("#fechaDesdeInput").val(hasta);

                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Fecha inválida</h1>',
                    html: '<p style="font-family: Poppins">Lo sentimos, la fecha inicial no puede ser mayor a la fecha final</p>',
                    confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        }
    }

    function checkTo() {
        if ($("#fechaHastaInput").val()) {
            var desde = $("#fechaDesdeInput").val();
            var hasta = $("#fechaHastaInput").val();

            if (hasta < desde) {
                $("#fechaHastaInput").val(desde);

                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Fecha inválida</h1>',
                    html: '<p style="font-family: Poppins">Lo sentimos, la fecha final no puede ser menor a la fecha inicial</p>',
                    confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        }    
    }

    $(document).on("click", "#btnMenosDesde", function (e) {
        e.preventDefault();
        var date = new Date($("#fechaDesdeInput").val());

        if ($("#fechaDesdeInput").val()) {
            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaDesdeInput").val(date);
        } else {
            var date = new Date();
            date.setDate(date.getDate() - 1);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaDesdeInput").val(date);
        }

        checkFrom();
    });

    $(document).on("click", "#btnMenosHasta", function (e) {
        e.preventDefault();
        var date = new Date($("#fechaHastaInput").val());

        if ($("#fechaHastaInput").val()) {
            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaHastaInput").val(date);
        } else {
            var date = new Date();
            date.setDate(date.getDate() - 1);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaHastaInput").val(date);
        }

        checkFrom();
    });

    $(document).on("click", "#btnMasDesde", function (e) {
        e.preventDefault();
        var date = new Date($("#fechaDesdeInput").val());

        if ($("#fechaDesdeInput").val()) {
            date.setDate(date.getDate() + 2);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaDesdeInput").val(date);
        } else {
            var date = new Date();
            date.setDate(date.getDate() + 1);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaDesdeInput").val(date);
        }

        checkTo();
    });

    $(document).on("click", "#btnMasHasta", function (e) {
        e.preventDefault();
        var date = new Date($("#fechaHastaInput").val());

        if ($("#fechaHastaInput").val()) {
            date.setDate(date.getDate() + 2);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaHastaInput").val(date);
        } else {
            var date = new Date();
            date.setDate(date.getDate() + 1);

            date = date.getFullYear().toString() + '-' + (date.getMonth() + 1).toString().padStart(2, 0) +
                '-' + date.getDate().toString().padStart(2, 0);

            $("#fechaHastaInput").val(date);
        }

        checkTo();
    });

    $(document).on("change", "#fechaDesdeInput", function (e) {
        if ($("#fechaHastaInput").val()) {
            var desde = $("#fechaDesdeInput").val();
            var hasta = $("#fechaHastaInput").val();

            if (desde > hasta) {
                $("#fechaDesdeInput").val(hasta);

                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Fecha inválida</h1>',
                    html: '<p style="font-family: Poppins">Lo sentimos, la fecha inicial no puede ser mayor a la fecha final</p>',
                    confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        }
    });

    $(document).on("change", "#fechaHastaInput", function (e) {
        if ($("#fechaHastaInput").val()) {
            var desde = $("#fechaDesdeInput").val();
            var hasta = $("#fechaHastaInput").val();

            if (hasta < desde) {
                $("#fechaHastaInput").val(desde);

                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Fecha inválida</h1>',
                    html: '<p style="font-family: Poppins">Lo sentimos, la fecha final no puede ser menor a la fecha inicial</p>',
                    confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        }
    });
});
