$(document).ready(function () {
    $(document).on("change", "#fechaInicioInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        if (fecha_inicio.length > 0 && fecha_fin.length > 0) {
            if (fecha_inicio > fecha_fin) {
                $("#fechaInicioInput").val(0);
                $("#fechaFinInput").val(0);
                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Error en fechas</h1>',
                    html: '<p style="font-family: Poppins">La fecha de inicio debe de ser menor a la fecha de fin.</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            } else {
                $("#generarResumenClientes").prop("disabled", false);

                $.ajax({
                    type: "GET",
                    data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                    url: "/admin/getResumenPagoCliente",
                    success: function (response) {
                        $("#tablaResumen").empty();
                        $("#tablaResumen").html(response);
                        let vacio = $("#vacioInput").val();
                        if (vacio == "vacio") {
                            $("#contImprimirResum").addClass("d-none");
                        } else {
                            $("#contImprimirResum").removeClass("d-none");
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    },
                });
            }
        } else {
            $("#generarResumenClientes").prop("disabled", true);
            $("#contImprimirResum").addClass("d-none");
            $("#contVacio").empty();
        }
    });

    $(document).on("change", "#fechaFinInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        if (fecha_inicio.length > 0 && fecha_fin.length > 0) {
            if (fecha_inicio > fecha_fin) {
                $("#fechaInicioInput").val(0);
                $("#fechaFinInput").val(0);
                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Error en fechas</h1>',
                    html: '<p style="font-family: Poppins">La fecha de inicio debe de ser menor a la fecha de fin.</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            } else {
                $("#generarResumenClientes").prop("disabled", false);

                $.ajax({
                    type: "GET",
                    data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                    url: "/admin/getResumenPagoCliente",
                    success: function (response) {
                        $("#tablaResumen").empty();
                        $("#tablaResumen").html(response);
                        let vacio = $("#vacioInput").val();
                        if (vacio == "vacio") {
                            $("#contImprimirResum").addClass("d-none");
                        } else {
                            $("#contImprimirResum").removeClass("d-none");
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    },
                });
            }
        } else {
            $("#generarResumenClientes").prop("disabled", true);
            $("#contImprimirResum").addClass("d-none");
            $("#contVacio").empty();
        }
    });

    $("#imprimirResumenClientes").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        window.open(
            `/admin/imprimirResumenCliente?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}`,
            "_blank"
        );
    });

    $("#exportarResumenClientes").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        window.open(
            `/admin/exportarResumenCliente?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}`
        );
    });

    $("#reporteDia").on("click", function () {
        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");

        $.ajax({
            type: "GET",
            data: { fecha: fecha },
            url: "/admin/getResumenPagoClienteDia",
            success: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(response);
                let vacio = $("#vacioInput").val();
                if (vacio == "vacio") {
                    $("#contImprimirResum").addClass("d-none");
                } else {
                    $("#contImprimirResum").removeClass("d-none");
                }
            },
            error: function (response) {
                console.log(response);
            },
        });

        $("#fechaInicioInput").val(fecha);
        $("#fechaFinInput").val(fecha);
    });

    $(document).on("click", "#imprimirReporte", function () {
        var formatearCantidad = new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2,
        });

        let pago = $(this).data("pago");
        let cliente = $(this).data("cliente");
        let rendimiento = $(this).data("rendimiento").replace(",", "");
        let fecha = $(this).data("fecha");
        let contrato = $(this).data("contrato");
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

                rendimiento = parseFloat(dolar) * parseFloat(rendimiento);
                rendimiento = formatearCantidad
                    .format(rendimiento)
                    .replace("$", "")
                    .replace(",", "");

                let letra = numeroALetrasMXN(rendimiento);

                window.open(
                    `/admin/imprimirReporteCliente?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}`,
                    "_blank"
                );
            },
        });
    });
});
