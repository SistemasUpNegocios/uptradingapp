$(document).ready(function () {
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
                $("#dolarInput").val(dolar);
            }
        },
    });

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
                $("#botonActualizar").removeClass("d-none");

                $.ajax({
                    type: "GET",
                    data: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        dolar: dolar,
                    },
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
                $("#botonActualizar").removeClass("d-none");

                $.ajax({
                    type: "GET",
                    data: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        dolar: dolar,
                    },
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
        let dolar = $("#dolarInput").val();

        window.open(
            `/admin/imprimirResumenCliente?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&dolar=${dolar}`,
            "_blank"
        );
    });

    $("#exportarResumenClientes").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let dolar = $("#dolarInput").val();

        window.open(
            `/admin/exportarResumenCliente?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&dolar=${dolar}`
        );
    });

    $("#reporteDia").on("click", function () {
        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");
        $("#botonActualizar").removeClass("d-none");

        $.ajax({
            type: "GET",
            data: { fecha: fecha, dolar: dolar },
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
        let fecha = $(this).data("fecha");
        let contrato = $(this).data("contrato");
        let contratoid = $(this).data("contratoid");
        let dolar = $("#dolarInput").val();
        let rendimiento = $(this).data("rendimientoini");

        rendimiento = formatearCantidad
            .format(parseFloat(rendimiento) * parseFloat(dolar))
            .replace("$", "")
            .replace(",", "");

        rendimiento = rendimiento.replace(",", "");

        let letra = numeroALetrasMXN(rendimiento);

        window.open(
            `/admin/imprimirReporteCliente?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}&dolar=${dolar}&contratoid=${contratoid}`,
            "_blank"
        );
    });

    $(document).on("click", "#editarInput", function () {
        var formatearCantidad = new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2,
        });

        let id = $(this).data("contratoid");
        let pago = $(this).data("pago");
        let fecha = $(this).data("fecha");
        let cliente = $(this).data("cliente");
        let contrato = $(this).data("contrato");
        let rendimiento = String($(this).data("rendimiento"))
            .replace("$", "")
            .replace(",", "");

        let letra = numeroALetrasMXN(rendimiento);
        $("#pagoInput").val(pago);
        $("#fechaInput").val(fecha);
        $("#clienteInput").val(cliente);
        $("#rendimientoInput").val(formatearCantidad.format(rendimiento));
        $("#contratoInput").val(contrato);
        $("#letraInput").val(letra);
        $("#contratoIdInput").val(id);
    });

    $(document).on("click", "#imprimirReporteModal", function () {
        let pago = $("#pagoInput").val();
        let cliente = $("#clienteInput").val();
        let rendimiento = $("#rendimientoInput").val();
        rendimiento = rendimiento.replace("$", "").replace(",", "");
        let fecha = $("#fechaInput").val();
        let contrato = $("#contratoInput").val();
        let letra = numeroALetrasMXN(rendimiento);
        let dolar = $("#dolarInput").val();
        let contratoid = $("#contratoIdInput").val();

        window.open(
            `/admin/imprimirReporteCliente?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}&dolar=${dolar}&contratoid=${contratoid}`,
            "_blank"
        );
    });

    $(document).on("change", "#dolarInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let dolar = $("#dolarInput").val();

        $.ajax({
            type: "GET",
            data: {
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                dolar: dolar,
            },
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
    });
});
