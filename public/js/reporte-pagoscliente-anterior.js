$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let url_filtro = "/admin/getResumenPagoClienteDiaMensualAnterior";
    let filtro = "mensual";
    let dolar = 0;
    let table = "";
    let pesos = 0;
    let pesos_divididos = 0;
    let dolares_divididos = 0;
    let dolares = 0;

    $(".contEuro").hide();
    $(".contFranco").hide();

    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp",
        success: function (response) {
            let series = response.bmx.series;
            for (let i in series) {
                let serie = series[i];

                dolar = parseFloat(serie.datos[0].dato);
                $("#dolarInput").val(dolar.toFixed(2));
                datos();
            }
        },
    });

    //EURO
    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF46410/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
        success: function (response) {
            //Handler de la respuesta
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioEuro = parseFloat(serie.datos[0].dato);
                $("#euroInput").val(precioEuro.toFixed(2));
                datos();
            }
        },
    });

    //FRANCO SUIZO
    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF57905/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
        success: function (response) {
            //Handler de la respuesta
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioFranco = parseFloat(serie.datos[0].dato);
                $("#francoInput").val(precioFranco.toFixed(2));
            }
        },
    });

    const datos = () => {
        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");
        $("#botonActualizar").removeClass("d-none");
        dolar = $("#dolarInput").val();
        euro = $("#euroInput").val();
        franco = $("#francoInput").val();

        $.ajax({
            type: "GET",
            data: { fecha: fecha, dolar: dolar, euro: euro, franco: franco },
            url: url_filtro,
            success: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(response);
                tablaResumen();

                $(".contEuro").hide();
                $(".contFranco").hide();

                let vacio = $("#vacioInput").val();
                if (vacio == "vacio") {
                    $("#contImprimirResum").addClass("d-none");
                } else {
                    $("#contImprimirResum").removeClass("d-none");
                }
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
        $("#fechaInicioInput").val(fecha);
        $("#fechaFinInput").val(fecha);
    };

    let date = formatDate(new Date());
    date = date.split("/").reverse().join("-");
    $("#dateInput").val(date);

    const tablaResumen = () => {
        table = $(".resumenPagoClienteMonedas").DataTable({
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
                [50, 100, 150, -1],
                [50, 100, 150, "Todo"],
            ],
            pageLength: 50,
            order: [[1, "asc"]],
        });
    };

    $(document).on("change", ".status", function () {
        let checked = $(this).is(":checked");

        if (checked) {
            $(this).val("Pagado");
        } else {
            $(this).val("Pendiente");
        }

        let id = $(this).data("id");
        let contratoid = $(this).data("contratoid");
        let pago = $(this).data("pago");
        let statusValor = $(this).val();
        let moneda = $(this).data("moneda");
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();

        if (moneda == "euros") {
            dolar = euro;
        } else if (moneda == "francos") {
            dolar = franco;
        }

        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/editStatusPagoClienteAnterior",
            data: {
                id: id,
                status: statusValor,
                pago: pago,
                contratoid: contratoid,
                dolar: dolar,
            },
            success: function () {
                Toast.fire({
                    icon: "success",
                    title: "Estatus actualizado",
                });
            },
            error: function () {
                Toast.fire({
                    icon: "error",
                    title: "Clave incorrecta",
                });
            },
        });
    });

    $(document).on("change", "#fechaInicioInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        dolar = $("#dolarInput").val();
        euros = $("#euroInput").val();
        francos = $("#francoInput").val();

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteCompuestoAnterior";
        }

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
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                        </div>
                    `
                );

                $("#generarResumenClientes").prop("disabled", false);
                $("#botonActualizar").removeClass("d-none");

                $.ajax({
                    type: "GET",
                    data: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        dolar: dolar,
                        euro: euros,
                        franco: francos,
                    },
                    url: url_filtro,
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

                        let monedaDolaresChecked = $("#monedaDolaresInput").is(
                            ":checked"
                        );
                        let monedaEurosChecked =
                            $("#monedaEurosInput").is(":checked");
                        let monedaFrancosChecked = $("#monedaFrancosInput").is(
                            ":checked"
                        );

                        if (monedaDolaresChecked) {
                            $(".contEuro").hide();
                            $(".contFranco").hide();
                            $(".contDolar").show();
                        } else if (monedaEurosChecked) {
                            $(".contDolar").hide();
                            $(".contFranco").hide();
                            $(".contEuro").show();
                        } else if (monedaFrancosChecked) {
                            $(".contDolar").hide();
                            $(".contEuro").hide();
                            $(".contFranco").show();
                        }
                    },
                    error: function (response) {
                        $("#tablaResumen").empty();
                        $("#tablaResumen").html(
                            `
                                <div class="text-center mt-4">
                                    <div class="spinner-border text-danger" role="status"></div>
                                    <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                                </div>
                            `
                        );
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
        dolar = $("#dolarInput").val();
        euros = $("#euroInput").val();
        francos = $("#francoInput").val();

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteCompuestoAnterior";
        }

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

                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                        </div>
                    `
                );

                $.ajax({
                    type: "GET",
                    data: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        dolar: dolar,
                        euro: euros,
                        franco: francos,
                    },
                    url: url_filtro,
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

                        let monedaDolaresChecked = $("#monedaDolaresInput").is(
                            ":checked"
                        );
                        let monedaEurosChecked =
                            $("#monedaEurosInput").is(":checked");
                        let monedaFrancosChecked = $("#monedaFrancosInput").is(
                            ":checked"
                        );

                        if (monedaDolaresChecked) {
                            $(".contEuro").hide();
                            $(".contFranco").hide();
                            $(".contDolar").show();
                        } else if (monedaEurosChecked) {
                            $(".contDolar").hide();
                            $(".contFranco").hide();
                            $(".contEuro").show();
                        } else if (monedaFrancosChecked) {
                            $(".contDolar").hide();
                            $(".contEuro").hide();
                            $(".contFranco").show();
                        }
                    },
                    error: function (response) {
                        $("#tablaResumen").empty();
                        $("#tablaResumen").html(
                            `
                                <div class="text-center mt-4">
                                    <div class="spinner-border text-danger" role="status"></div>
                                    <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                                </div>
                            `
                        );
                    },
                });
            }
        } else {
            $("#generarResumenClientes").prop("disabled", true);
            $("#contImprimirResum").addClass("d-none");
            $("#contVacio").empty();
        }
    });

    $("#reporteDia").on("click", function () {
        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");
        $("#botonActualizar").removeClass("d-none");

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteDiaMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteDiaCompuestoAnterior";
        }

        dolar = $("#dolarInput").val();
        euros = $("#euroInput").val();
        francos = $("#francoInput").val();

        $.ajax({
            type: "GET",
            data: { fecha: fecha, dolar: dolar, euro: euros, franco: francos },
            url: url_filtro,
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

                let monedaDolaresChecked = $("#monedaDolaresInput").is(
                    ":checked"
                );
                let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
                let monedaFrancosChecked = $("#monedaFrancosInput").is(
                    ":checked"
                );

                if (monedaDolaresChecked) {
                    $(".contEuro").hide();
                    $(".contFranco").hide();
                    $(".contDolar").show();
                } else if (monedaEurosChecked) {
                    $(".contDolar").hide();
                    $(".contFranco").hide();
                    $(".contEuro").show();
                } else if (monedaFrancosChecked) {
                    $(".contDolar").hide();
                    $(".contEuro").hide();
                    $(".contFranco").show();
                }
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });

        $("#fechaInicioInput").val(fecha);
        $("#fechaFinInput").val(fecha);
    });

    $("#imprimirResumenClientes").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();

        window.open(
            `/admin/imprimirResumenClienteAnterior?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&dolar=${dolar}&euro=${euro}&franco=${franco}`,
            "_blank"
        );
    });

    $("#exportarResumenClientes").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();

        window.open(
            `/admin/exportarResumenClienteAnterior?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&dolar=${dolar}&euro=${euro}&franco=${franco}`
        );
    });

    $("#tiposPagos").on("click", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        window.open(
            `/admin/tiposPagosClientesAnterior?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}`,
            "_blank"
        );
    });

    $(document).on("click", "#imprimirReporte", function () {
        let date_valor = $("#dateInput").val();
        if (date_valor.length > 0) {
            let pago = $(this).data("pago");
            let cliente = $(this).data("cliente");
            let rendimiento = $(this).data("rendimiento");
            let rendimiento_dolar = $(this).data("rendimientoini");
            let fecha = $(this).data("fecha");
            let contrato = $(this).data("contrato");
            let contratoid = $(this).data("contratoid");
            let tipo = $(this).data("tipo");
            let reporte = $(this).data("reporte");
            let moneda = $(this).data("moneda");
            let dolar = $("#dolarInput").val();
            let euro = $("#euroInput").val();
            let franco = $("#francoInput").val();
            let inversionus = $(this).data("inversionus");
            let inversioneuros = $(this).data("inversioneuros");
            let inversionfrancos = $(this).data("inversionfrancos");
            let letra = "";
            let letra_dolares = numeroALetrasUSD(rendimiento_dolar);

            if (reporte == "liquidacion") {
                if (moneda == "dolares") {
                    rendimiento = parseFloat(inversionus) * parseFloat(dolar);
                } else if (moneda == "euros") {
                    rendimiento = parseFloat(inversioneuros) * parseFloat(euro);
                } else if (moneda == "francos") {
                    rendimiento =
                        parseFloat(inversionfrancos) * parseFloat(franco);
                }
                letra = numeroALetrasMXN(rendimiento);
            } else {
                rendimiento = rendimiento
                    .replaceAll("$", "")
                    .replaceAll(",", "");
                letra = numeroALetrasMXN(rendimiento);
            }

            if (moneda == "dolares") {
                letra_dolares = numeroALetrasUSD(rendimiento_dolar);
            } else if (moneda == "euros") {
                letra_dolares = numeroALetrasEUR(rendimiento_dolar);
                dolar = euro;
            } else if (moneda == "francos") {
                letra_dolares = numeroALetrasCHF(rendimiento_dolar);
                dolar = franco;
            }

            window.open(
                `/admin/imprimirReporteClienteAnterior?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}&rendimiento_dolar=${rendimiento_dolar}&letra_dolares=${letra_dolares}&dolar=${dolar}&contratoid=${contratoid}&fecha_imprimir=${date_valor}&tipo=${tipo}&reporte=${reporte}&moneda=${moneda}`,
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
        let formatearCantidad = new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2,
        });

        let id = $(this).data("contratoid");
        let pago = $(this).data("pago");
        let fecha = $(this).data("fecha");
        let cliente = $(this).data("cliente");
        let contrato = $(this).data("contrato");
        let moneda = $(this).data("moneda");
        let tipo = $(this).data("tipo");
        let rendimiento = String($(this).data("rendimiento"))
            .replaceAll("$", "")
            .replaceAll(",", "");
        let rendimiento_dolar = String($(this).data("rendimientoini"))
            .replaceAll("$", "")
            .replaceAll(",", "");
        let reporte = $(this).data("reporte");
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();
        let inversioneuros = $(this).data("inversioneuros");
        let inversionfrancos = $(this).data("inversionfrancos");
        let inversionus = $(this).data("inversionus");
        let letra = "";

        if (reporte == "liquidacion") {
            if (moneda == "dolares") {
                rendimiento = parseFloat(inversionus) * parseFloat(dolar);
            } else if (moneda == "euros") {
                rendimiento = parseFloat(inversioneuros) * parseFloat(euro);
            } else if (moneda == "francos") {
                rendimiento = parseFloat(inversionfrancos) * parseFloat(franco);
            }

            letra = numeroALetrasMXN(rendimiento);
        } else {
            letra = numeroALetrasMXN(rendimiento);
        }

        if (moneda == "euros") {
            dolar = euro;
        } else if (moneda == "francos") {
            rendimiento = parseFloat(inversionfrancos) * parseFloat(franco);
            dolar = franco;
        }

        $("#pagoInput").val(pago);
        $("#fechaInput").val(fecha);
        $("#clienteInput").val(cliente);
        $("#rendimientoInput").val(formatearCantidad.format(rendimiento));
        $("#rendimientoIniInput").val(
            formatearCantidad.format(rendimiento_dolar)
        );
        $("#contratoInput").val(contrato);
        $("#letraInput").val(letra);
        $("#contratoIdInput").val(id);
        $("#tipoInput").val(tipo);
        $("#reporteInput").val(reporte);
        $("#monedaInput").val(moneda);
    });

    $(document).on("click", "#imprimirReporteModal", function () {
        let date_valor = $("#dateInput").val();
        let pago = $("#pagoInput").val();
        let cliente = $("#clienteInput").val();
        let rendimiento = $("#rendimientoInput")
            .val()
            .replaceAll("$", "")
            .replaceAll(",", "");
        let rendimiento_dolar = $("#rendimientoIniInput")
            .val()
            .replaceAll("$", "")
            .replaceAll(",", "");
        let fecha = $("#fechaInput").val();
        let contrato = $("#contratoInput").val();
        let letra = numeroALetrasMXN(rendimiento);
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();
        let moneda = $("#monedaInput").val();
        let contratoid = $("#contratoIdInput").val();
        let tipo = $("#tipoInput").val();
        let reporte = $("#reporteInput").val();

        let letra_dolares = numeroALetrasUSD(rendimiento_dolar);

        if (moneda == "euros") {
            letra_dolares = numeroALetrasEUR(rendimiento_dolar);
            dolar = euro;
        } else if (moneda == "francos") {
            letra_dolares = numeroALetrasCHF(rendimiento_dolar);
            dolar = franco;
        }

        window.open(
            `/admin/imprimirReporteClienteAnterior?pago=${pago}&cliente=${cliente}&rendimiento=${rendimiento}&fecha=${fecha}&contrato=${contrato}&letra=${letra}&rendimiento_dolar=${rendimiento_dolar}&letra_dolares=${letra_dolares}&reporte=${reporte}&dolar=${dolar}&contratoid=${contratoid}&fecha_imprimir=${date_valor}&tipo=${tipo}&moneda=${moneda}`,
            "_blank"
        );
    });

    $(document).on("keyup", "#dolarInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let dolar_nuevo = $("#dolarInput").val();
        if (dolar_nuevo == 0 || dolar_nuevo == "") {
            $("#dolarInput").val(dolar);
            dolar_nuevo = $("#dolarInput").val();
        }

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteCompuestoAnterior";
        }

        $.ajax({
            type: "GET",
            data: {
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                dolar: dolar_nuevo,
                euro: $("#euroInput").val(),
                franco: $("#francoInput").val(),
            },
            url: url_filtro,
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

                $(".contEuro").hide();
                $(".contFranco").hide();
                $(".contDolar").show();
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
    });

    $(document).on("keyup", "#euroInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let euro_nuevo = $("#euroInput").val();
        if (euro_nuevo == 0 || euro_nuevo == "") {
            $("#euroInput").val(euro);
            euro_nuevo = $("#dolarInput").val();
        }

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteCompuestoAnterior";
        }

        $.ajax({
            type: "GET",
            data: {
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                euro: euro_nuevo,
                franco: $("#francoInput").val(),
                dolar: $("#dolarInput").val(),
            },
            url: url_filtro,
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

                $(".contDolar").hide();
                $(".contFranco").hide();
                $(".contEuro").show();
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
    });

    $(document).on("keyup", "#francoInput", function () {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let franco_nuevo = $("#francoInput").val();
        if (franco_nuevo == 0 || franco_nuevo == "") {
            $("#francoInput").val(franco);
            franco_nuevo = $("#francoInput").val();
        }

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            ("/admin/getResumenPagoClienteCompuestoAnterior");
        }

        $.ajax({
            type: "GET",
            data: {
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                franco: franco_nuevo,
                euro: $("#euroInput").val(),
                dolar: $("#dolarInput").val(),
            },
            url: url_filtro,
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

                $(".contDolar").hide();
                $(".contEuro").hide();
                $(".contFranco").show();
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
    });

    $(document).on("click", ".abrirWhats", function () {
        let formatearCantidad = new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2,
        });

        let mensaje = "";
        let cliente = $(this).data("cliente");
        let contrato = $(this).data("contrato");
        let pago = $(this).data("pago");
        let rendimiento = $(this).data("rendimiento");
        let inversionus = $(this).data("inversionus");
        let clientenumero = $(this).data("clientenumero");
        let reporte = $(this).data("reporte");
        let fecha = $(this).data("fecha");
        let tipo = $(this).data("tipo");
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();
        let moneda = $(this).data("moneda");
        let moneda_tipo = "dólares";
        let pos = rendimiento.toString().indexOf(",");
        let rendimiento_remp = "";
        if (pos != -1) {
            rendimiento_remp = rendimiento.replaceAll(",", "");
        } else {
            rendimiento_remp = rendimiento;
        }

        let dolares = 0;
        if (moneda == "dolares") {
            dolares = parseFloat(rendimiento_remp) / parseFloat(dolar);
        } else if (moneda == "euros") {
            dolares = parseFloat(rendimiento_remp) / parseFloat(euro);
            dolar = euro;
            moneda_tipo = "euros";
        } else if (moneda == "francos") {
            dolares = parseFloat(rendimiento_remp) / parseFloat(franco);
            dolar = franco;
            moneda_tipo = "francos suizos";
        }

        dolares = dolares.toFixed(2);

        if (tipo == 1) {
            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta por la cantidad de $${rendimiento} pesos, por concepto de pago del rendimiento mensual del día ${fecha} con relación al contrato ${contrato} (pago ${pago}), correspondiente a $${dolares} ${moneda_tipo} al tipo de cambio $${dolar}, sin que al momento exista algún adeudo.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        } else if (tipo == 2) {
            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta por la cantidad de $${rendimiento} pesos, por concepto de pago de rendimiento y liquidación del contrato compuesto ${contrato} con fecha de inicio ${fecha}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        }

        if (reporte == "liquidacion") {
            rendimiento = parseFloat(inversionus) * parseFloat(dolar);
            rendimiento = formatearCantidad.format(rendimiento);

            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta por la cantidad de ${rendimiento} pesos, por concepto de pago de liquidación del contrato mensual ${contrato} de fecha ${fecha}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        }

        $("#nombreClienteInput").val(cliente);
        $("#numeroClienteInput").val(clientenumero);
        $("#mensajeInput").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", ".abrirTrans", function () {
        let formatearCantidad = new Intl.NumberFormat("en-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
        });

        let mensaje = "";
        let cliente = $(this).data("cliente");
        let reporte = $(this).data("reporte");
        let contrato = $(this).data("contrato");
        let pago = $(this).data("pago");
        let rendimiento = $(this).data("rendimiento");
        let clientenumero = $(this).data("clientenumero");
        let inversionus = $(this).data("inversionus");
        let fecha = $(this).data("fecha");
        let tipo = $(this).data("tipo");
        let moneda = $(this).data("moneda");
        let moneda_tipo = "dólares";

        if (moneda == "euros") {
            moneda_tipo = "euros";
        } else if (moneda == "francos") {
            moneda_tipo = "francos suizos";
        }

        if (tipo == 1) {
            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta Swissquote por la cantidad de $${rendimiento} ${moneda_tipo}, por el rendimiento del día ${fecha} con relación al contrato ${contrato} (pago ${pago}).\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        } else if (tipo == 2) {
            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta Swissquote por la cantidad de $${rendimiento} ${moneda_tipo}, por concepto de pago de rendimiento y liquidación del contrato compuesto ${contrato} con fecha de inicio ${fecha}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        }

        if (reporte == "liquidacion") {
            rendimiento = formatearCantidad.format(inversionus);

            mensaje = `Buen día ${cliente}, se ha realizado una transferencia a su cuenta Swissquote por la cantidad de ${rendimiento} ${moneda_tipo}, por concepto de pago de liquidación del contrato mensual ${contrato} de fecha ${fecha}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;
        }

        $("#nombreClienteInput").val(cliente);
        $("#numeroClienteInput").val(clientenumero);
        $("#mensajeInput").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", "#enviarWhats", function () {
        let cliente = $("#nombreClienteInput").val();
        let numero = $("#numeroClienteInput").val();
        let mensaje = $("#mensajeInput").val();

        window.open(
            `https://web.whatsapp.com/send?phone=${numero}&text=${mensaje}`,
            "_blank"
        );
        Swal.fire({
            icon: "success",
            title: '<h1 style="font-family: Poppins; font-weight: 700;">WhatsApp envíado</h1>',
            html: `<p style="font-family: Poppins">Se ha enviado un mensaje a <b>${cliente}</b>, con número de teléfono <b>${numero}</b>.</p>`,
            confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
            confirmButtonColor: "#01bbcc",
        });
        $("#formModalWhats").modal("hide");
    });

    const filtros = () => {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        dolar = $("#dolarInput").val();
        euros = $("#euroInput").val();
        francos = $("#francoInput").val();

        if (filtro == "mensual") {
            url_filtro = "/admin/getResumenPagoClienteMensualAnterior";
        } else if (filtro == "compuesto") {
            url_filtro = "/admin/getResumenPagoClienteCompuestoAnterior";
        } else if (filtro == "liquidacion") {
            url_filtro = "/admin/getResumenPagoClienteLiquidacionAnterior";
        }

        $.ajax({
            type: "GET",
            data: {
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
                dolar: dolar,
                euro: euros,
                franco: francos,
            },
            url: url_filtro,
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

                let monedaDolaresChecked = $("#monedaDolaresInput").is(
                    ":checked"
                );
                let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
                let monedaFrancosChecked = $("#monedaFrancosInput").is(
                    ":checked"
                );

                if (monedaDolaresChecked) {
                    $(".contEuro").hide();
                    $(".contFranco").hide();
                    $(".contDolar").show();
                } else if (monedaEurosChecked) {
                    $(".contDolar").hide();
                    $(".contFranco").hide();
                    $(".contEuro").show();
                } else if (monedaFrancosChecked) {
                    $(".contDolar").hide();
                    $(".contEuro").hide();
                    $(".contFranco").show();
                }
            },
            error: function (response) {
                $("#tablaResumen").empty();
                $("#tablaResumen").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
    };

    $(document).on("click", "#filtroMensual", function () {
        filtro = "mensual";
        $("#filtroCompuesto").removeClass("btn-primary");
        $("#filtroCompuesto").addClass("btn-outline-primary");

        $("#filtroLiquidacion").removeClass("btn-primary");
        $("#filtroLiquidacion").addClass("btn-outline-primary");

        $("#filtroMensual").addClass("btn-primary");
        $("#filtroMensual").removeClass("btn-outline-primary");

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        filtros();
    });
    $(document).on("click", "#filtroCompuesto", function () {
        filtro = "compuesto";

        $("#filtroMensual").removeClass("btn-primary");
        $("#filtroMensual").addClass("btn-outline-primary");

        $("#filtroLiquidacion").removeClass("btn-primary");
        $("#filtroLiquidacion").addClass("btn-outline-primary");

        $("#filtroCompuesto").addClass("btn-primary");
        $("#filtroCompuesto").removeClass("btn-outline-primary");

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        filtros();
    });
    $(document).on("click", "#filtroLiquidacion", function () {
        filtro = "liquidacion";

        $("#filtroMensual").removeClass("btn-primary");
        $("#filtroMensual").addClass("btn-outline-primary");

        $("#filtroCompuesto").removeClass("btn-primary");
        $("#filtroCompuesto").addClass("btn-outline-primary");

        $("#filtroLiquidacion").addClass("btn-primary");
        $("#filtroLiquidacion").removeClass("btn-outline-primary");

        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-primary">Cargando rendimientos<span class="dotting"> </span></p>
                </div>
            `
        );

        filtros();
    });

    $(document).on("click", ".nota", function (e) {
        $("#notaForm")[0].reset();
        $("#formModalNota").modal("show");
        $("#alertaNota").empty();

        $("#montoEfectivoCont").hide();
        $("#montoInversionesCont").hide();
        $("#montoTransferenciaCont").hide();
        $("#montoTransSwissCont").hide();

        let pagoid = $(this).data("pagoid");
        let contratoid = $(this).data("contratoid");
        let reporte = $(this).data("reporte");
        let pago = $(this).data("pago");
        let moneda = $(this).data("moneda");
        let dolar = $("#dolarInput").val();
        let euro = $("#euroInput").val();
        let franco = $("#francoInput").val();

        if (moneda == "euros") {
            dolar = euro;
        } else if (moneda == "francos") {
            dolar = franco;
        }

        let monto = $(this).data("monto");
        pesos = $(this).data("pesos").toString().replaceAll(",", "");
        let dolar_liq = $(this).data("pesos").toString().replaceAll(",", "");
        dolares = $(this).data("dolares").toString().replaceAll(",", ".");
        dolares = parseFloat(dolares);
        let tipopago = $(this).data("tipopago");
        let tipopagocliente = $(this).data("tipopagocliente");

        if (reporte == "liquidacion") {
            pesos = parseFloat(pesos) * parseFloat(dolar);
            dolares = parseFloat(dolar_liq);
        }

        let checkbox = [
            "#efectivoInput",
            "#inversionesInput",
            "#transferenciaInput",
            "#transferenciaSwissInput",
        ];

        let inputs = [
            "#montoEfectivoInput",
            "#montoInversionesInput",
            "#montoTransferenciaInput",
            "#montoTransferenciaSwissInput",
        ];

        let conts = [
            "#montoEfectivoCont",
            "#montoInversionesCont",
            "#montoTransferenciaCont",
            "#montoTransSwissCont",
        ];

        if (typeof tipopagocliente !== "undefined") {
            tipopagocliente = tipopagocliente.split(",");
            tipopagocliente.map((tipo) => {
                checkbox.map((input, i) => {
                    if (tipo == $(input).val()) {
                        $(input).prop("checked", true);
                        let checked = $(input).is(":checked");
                        if (checked) {
                            $(conts[i]).show();
                        }
                    }
                });

                var efectivoCont =
                    $("#montoEfectivoCont").css("display") == "none"
                        ? true
                        : false;

                var transferenciaCont =
                    $("#montoTransferenciaCont").css("display") == "none"
                        ? true
                        : false;

                if (tipo == "efectivo" || tipo == "transferencia") {
                    if (!efectivoCont && !transferenciaCont) {
                        pesos_divididos = pesos / 2;
                        $("#montoEfectivoInput").val(
                            pesos_divididos.toFixed(2)
                        );
                        $("#montoTransferenciaInput").val(
                            pesos_divididos.toFixed(2)
                        );
                    } else if (efectivoCont) {
                        $("#montoTransferenciaInput").val(pesos);
                    } else if (transferenciaCont) {
                        $("#montoEfectivoInput").val(pesos);
                    }
                }

                if (tipo == "transferenciaSwiss") {
                    $("#montoTransferenciaSwissInput").val(dolares.toFixed(2));
                }
            });
        } else {
            if (typeof monto !== "undefined") {
                monto = monto.split(",");
                tipopago = tipopago.split(",");

                tipopago.map((tipo, j) => {
                    checkbox.map((input, i) => {
                        if (tipo == $(input).val()) {
                            $(input).prop("checked", true);
                            let checked = $(input).is(":checked");
                            if (checked) {
                                $(conts[i]).show();
                                $(inputs[i]).val(monto[j]);
                            }
                        }
                    });
                });
            } else {
                checkbox.map((input, i) => {
                    $(input).prop("checked", false);
                    $(conts[i]).hide();
                    $(inputs[i]).val(pesos);
                });
            }
        }

        $("#idInputNota").val(pagoid);
        $("#contratoIdInputNota").val(contratoid);
        $("#memoInputNota").val(`Pago a cliente (${pago})`);
        $("#pagoInputNota").val(pago);
        $("#dolarInputNota").val(dolar);

        $("#notaForm").attr("action", "/admin/guardarPagoAnterior");
    });

    $(document).on("change", "#efectivoInput", () => {
        $("#alertaNota").empty();
        $("#montoEfectivoCont").toggle();

        if (
            !$("#montoEfectivoCont").is(":hidden") &&
            !$("#montoTransferenciaCont").is(":hidden")
        ) {
            pesos_divididos = pesos / 2;
            $("#montoEfectivoInput").val(pesos_divididos.toFixed(2));
            $("#montoTransferenciaInput").val(pesos_divididos.toFixed(2));
        } else if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(pesos);
        } else if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoEfectivoInput").val(pesos);
        }
    });

    $(document).on("change", "#inversionesInput", () => {
        $("#alertaNota").empty();
        $("#montoInversionesCont").toggle();

        if (
            !$("#montoEfectivoCont").is(":hidden") &&
            !$("#montoTransferenciaCont").is(":hidden")
        ) {
            pesos_divididos = pesos / 2;
            $("#montoEfectivoInput").val(pesos_divididos.toFixed(2));
            $("#montoTransferenciaInput").val(pesos_divididos.toFixed(2));
        } else if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(pesos);
        } else if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoEfectivoInput").val(pesos);
        }

        if (
            !$("#montoInversionesCont").is(":hidden") &&
            !$("#montoTransSwissCont").is(":hidden")
        ) {
            dolares_divididos = dolares / 2;
            $("#montoInversionesInput").val(dolares_divididos.toFixed(2));
            $("#montoTransferenciaSwissInput").val(
                dolares_divididos.toFixed(2)
            );
        } else if ($("#montoInversionesCont").is(":hidden")) {
            $("#montoTransferenciaSwissInput").val(dolares.toFixed(2));
        } else if ($("#montoTransSwissCont").is(":hidden")) {
            $("#montoInversionesInput").val(dolares.toFixed(2));
        }
    });

    $(document).on("change", "#transferenciaInput", () => {
        $("#alertaNota").empty();
        $("#montoTransferenciaCont").toggle();

        if (
            !$("#montoEfectivoCont").is(":hidden") &&
            !$("#montoTransferenciaCont").is(":hidden")
        ) {
            pesos_divididos = pesos / 2;
            $("#montoEfectivoInput").val(pesos_divididos.toFixed(2));
            $("#montoTransferenciaInput").val(pesos_divididos.toFixed(2));
        } else if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(pesos);
        } else if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoEfectivoInput").val(pesos);
        }
    });

    $(document).on("change", "#transferenciaSwissInput", () => {
        $("#alertaNota").empty();
        $("#montoTransSwissCont").toggle();

        if (
            !$("#montoEfectivoCont").is(":hidden") &&
            !$("#montoTransferenciaCont").is(":hidden")
        ) {
            pesos_divididos = pesos / 2;
            $("#montoEfectivoInput").val(pesos_divididos.toFixed(2));
            $("#montoTransferenciaInput").val(pesos_divididos.toFixed(2));
        } else if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(pesos);
        } else if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoEfectivoInput").val(pesos);
        }

        if (
            !$("#montoInversionesCont").is(":hidden") &&
            !$("#montoTransSwissCont").is(":hidden")
        ) {
            dolares_divididos = dolares / 2;
            $("#montoInversionesInput").val(dolares_divididos.toFixed(2));
            $("#montoTransferenciaSwissInput").val(
                dolares_divididos.toFixed(2)
            );
        } else if ($("#montoInversionesCont").is(":hidden")) {
            $("#montoTransferenciaSwissInput").val(dolares.toFixed(2));
        } else if ($("#montoTransSwissCont").is(":hidden")) {
            $("#montoInversionesInput").val(dolares.toFixed(2));
        }
    });

    $(document).on("submit", "#notaForm", function (e) {
        e.preventDefault();
        let url = $(this).attr("action");
        $("#alertMessage").text("");

        if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoEfectivoInput").val(0);
        }

        if ($("#montoInversionesCont").is(":hidden")) {
            $("#montoInversionesInput").val(0);
        }

        if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(0);
        }

        if ($("#montoTransSwissCont").is(":hidden")) {
            $("#montoTransferenciaSwissInput").val(0);
        }

        let efectivo = $("#montoEfectivoInput").val();
        let inversiones = $("#montoInversionesInput").val();
        let transferencia = $("#montoTransferenciaInput").val();
        let transferenciaSwiss = $("#montoTransferenciaSwissInput").val();

        if (
            efectivo > 0 ||
            transferencia > 0 ||
            transferenciaSwiss > 0 ||
            inversiones > 0
        ) {
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function () {
                    $("#formModalNota").modal("hide");
                    $("#notaForm")[0].reset();
                    filtros();
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Pago guardado</h1>',
                        html: '<p style="font-family: Poppins">El pago ha sido guardado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                },
                error: function (err) {
                    console.log(err);
                },
            });
        } else {
            $("#alertaNota").html(`
                <div class="alert alert-danger" role="alert">
                    Debe de ingresar un monto
                </div>
            `);
        }
    });

    $(document).on("click", "#monedaDolaresInput", function () {
        $(".contEuro").hide();
        $(".contFranco").hide();

        $(".contDolar").show();
    });

    $(document).on("click", "#monedaEurosInput", function () {
        $(".contDolar").hide();
        $(".contFranco").hide();

        $(".contEuro").show();
    });

    $(document).on("click", "#monedaFrancosInput", function () {
        $(".contDolar").hide();
        $(".contEuro").hide();

        $(".contFranco").show();
    });
});
