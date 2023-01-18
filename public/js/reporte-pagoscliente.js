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

    let date = formatDate(new Date());
    date = date.split("/").reverse().join("-");

    $("#dateInput").val(date);

    const tablaResumen = () => {
        var table = $("#resumenPagoCliente").DataTable({
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ pagos",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No se ha registrado ningún pago",
                infoEmpty: "Mostrando pagos del 0 al 0 de un total de 0 pagos",
                infoFiltered: "(filtrado de un total de _MAX_ pagos)",
                search: "Buscar:",
                infoThousands: ",",
                loadingRecords: "Cargando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: ">",
                    previous: "<",
                },
                aria: {
                    sortAscending:
                        ": Activar para ordenar la columna de manera ascendente",
                    sortDescending:
                        ": Activar para ordenar la columna de manera descendente",
                },
                buttons: {
                    copy: "Copiar",
                    colvis: "Visibilidad",
                    collection: "Colección",
                    colvisRestore: "Restaurar visibilidad",
                    copyKeys:
                        "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
                    copySuccess: {
                        1: "Copiada 1 fila al portapapeles",
                        _: "Copiadas %d fila al portapapeles",
                    },
                    copyTitle: "Copiar al portapapeles",
                    csv: "CSV",
                    excel: "Excel",
                    pageLength: {
                        "-1": "Mostrar todas las filas",
                        1: "Mostrar 1 fila",
                        _: "Mostrar %d filas",
                    },
                    pdf: "PDF",
                    print: "Imprimir",
                },
                autoFill: {
                    cancel: "Cancelar",
                    fill: "Rellene todas las celdas con <i>%d</i>",
                    fillHorizontal: "Rellenar celdas horizontalmente",
                    fillVertical: "Rellenar celdas verticalmentemente",
                },
                decimal: ",",
                searchBuilder: {
                    add: "Añadir condición",
                    button: {
                        0: "Constructor de búsqueda",
                        _: "Constructor de búsqueda (%d)",
                    },
                    clearAll: "Borrar todo",
                    condition: "Condición",
                    conditions: {
                        date: {
                            after: "Despues",
                            before: "Antes",
                            between: "Entre",
                            empty: "Vacío",
                            equals: "Igual a",
                            notBetween: "No entre",
                            notEmpty: "No Vacio",
                            not: "Diferente de",
                        },
                        number: {
                            between: "Entre",
                            empty: "Vacio",
                            equals: "Igual a",
                            gt: "Mayor a",
                            gte: "Mayor o igual a",
                            lt: "Menor que",
                            lte: "Menor o igual que",
                            notBetween: "No entre",
                            notEmpty: "No vacío",
                            not: "Diferente de",
                        },
                        string: {
                            contains: "Contiene",
                            empty: "Vacío",
                            endsWith: "Termina en",
                            equals: "Igual a",
                            notEmpty: "No Vacio",
                            startsWith: "Empieza con",
                            not: "Diferente de",
                        },
                        array: {
                            not: "Diferente de",
                            equals: "Igual",
                            empty: "Vacío",
                            contains: "Contiene",
                            notEmpty: "No Vacío",
                            without: "Sin",
                        },
                    },
                    data: "Data",
                    deleteTitle: "Eliminar regla de filtrado",
                    leftTitle: "Criterios anulados",
                    logicAnd: "Y",
                    logicOr: "O",
                    rightTitle: "Criterios de sangría",
                    title: {
                        0: "Constructor de búsqueda",
                        _: "Constructor de búsqueda (%d)",
                    },
                    value: "Valor",
                },
                searchPanes: {
                    clearMessage: "Borrar todo",
                    collapse: {
                        0: "Paneles de búsqueda",
                        _: "Paneles de búsqueda (%d)",
                    },
                    count: "{total}",
                    countFiltered: "{shown} ({total})",
                    emptyPanes: "Sin paneles de búsqueda",
                    loadMessage: "Cargando paneles de búsqueda",
                    title: "Filtros Activos - %d",
                },
                select: {
                    1: "%d fila seleccionada",
                    _: "%d filas seleccionadas",
                    cells: {
                        1: "1 celda seleccionada",
                        _: "$d celdas seleccionadas",
                    },
                    columns: {
                        1: "1 columna seleccionada",
                        _: "%d columnas seleccionadas",
                    },
                },
                thousands: ".",
                datetime: {
                    previous: "Anterior",
                    next: "Proximo",
                    hours: "Horas",
                    minutes: "Minutos",
                    seconds: "Segundos",
                    unknown: "-",
                    amPm: ["am", "pm"],
                },
                editor: {
                    close: "Cerrar",
                    create: {
                        button: "Nuevo",
                        title: "Crear Nuevo Registro",
                        submit: "Crear",
                    },
                    edit: {
                        button: "Editar",
                        title: "Editar Registro",
                        submit: "Actualizar",
                    },
                    remove: {
                        button: "Eliminar",
                        title: "Eliminar Registro",
                        submit: "Eliminar",
                        confirm: {
                            _: "¿Está seguro que desea eliminar %d filas?",
                            1: "¿Está seguro que desea eliminar 1 fila?",
                        },
                    },
                    error: {
                        system: 'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">Más información&lt;\\/a&gt;).</a>',
                    },
                    multi: {
                        title: "Múltiples Valores",
                        info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                        restore: "Deshacer Cambios",
                        noMulti:
                            "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
                    },
                },
                info: "Mostrando de _START_ a _END_ de _TOTAL_ pagos",
            },
            lengthMenu: [
                [5, 10, 15, 20, 25, 30, -1],
                [5, 10, 15, 20, 25, 30, "Todo"],
            ],
            pageLength: 5,
            order: [[1, "asc"]],
        });
    };

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
                        tablaResumen();

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
                        tablaResumen();

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
                tablaResumen();

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
        let date_valor = $("#dateInput").val();
        if (date_valor.length > 0) {
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
                .replaceAll("$", "")
                .replaceAll(",", "");

            let letra = numeroALetrasMXN(rendimiento);

            window.open(
                `/admin/imprimirReporteCliente?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}&dolar=${dolar}&contratoid=${contratoid}&fecha_imprimir=${date_valor}`,
                "_blank"
            );
        } else {
            Swal.fire({
                icon: "warning",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">Error en fecha</h1>',
                html: '<p style="font-family: Poppins">La fecha a imprimir no puede estar vacía.</p>',
                confirmButtonText:
                    '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });
        }
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
            .replaceAll("$", "")
            .replaceAll(",", "");

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
        let rendimiento = $("#rendimientoInput")
            .val()
            .replaceAll("$", "")
            .replaceAll(",", "");
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
                tablaResumen();
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

    $(document).on("click", ".abrirWhats", function () {
        let cliente = $(this).data("cliente");
        let contrato = $(this).data("contrato");
        let pago = $(this).data("pago");
        let rendimiento = $(this).data("rendimiento");
        let clientenumero = $(this).data("clientenumero");
        let fecha = $(this).data("fecha");

        let mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta por la cantidad de $${rendimiento} pesos, por el rendimiento del día ${fecha} con relación al contrato ${contrato} (pago ${pago}).\nAtte: Ma. Elena.\nDepartamento de pagos.`;

        $("#nombreClienteInput").val(cliente);
        $("#numeroClienteInput").val(clientenumero);
        $("#mensajeInput").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", "#enviarWhats", function () {
        let cliente = $("#nombreClienteInput").val();
        let numero = $("#numeroClienteInput").val();
        let mensaje = $("#mensajeInput").val();

        $.ajax({
            type: "GET",
            data: { cliente: cliente, numero: numero, mensaje: mensaje },
            url: "/admin/enviarWhatsPagoCliente",
            success: function (response) {
                if (response == "hecho") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">WhatsApp envíado</h1>',
                        html: `<p style="font-family: Poppins">Se ha enviado un mensaje a <b>${cliente}</b>, con número de telefono <b>${numero}</b>.</p>`,
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                    $("#formModalWhats").modal("hide");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Error</h1>',
                        html: `<p style="font-family: Poppins">El WhatsApp no se pudo envíar, comuniquese con sistemas.</p>`,
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (response) {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Error</h1>',
                    html: `<p style="font-family: Poppins">El WhatsApp no se pudo envíar, comuniquese con sistemas.</p>`,
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
        });
    });
});
