$(document).ready(function () {
    let dolar = 0;
    let pesos = 0;
    let pesos_divididos = 0;
    let dolares = 0;
    var table = "";

    $(".contEuro").hide();
    $(".contFranco").hide();

    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp",
        success: function (response) {
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                dolar = parseFloat(serie.datos[0].dato);
                $("#dolarInput").val(dolar.toFixed(2));

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

                                        var precioFranco = parseFloat(
                                            serie.datos[0].dato
                                        );
                                        $("#francoInput").val(
                                            precioFranco.toFixed(2)
                                        );
                                        datos();
                                    }
                                },
                            });
                        }
                    },
                });
            }
        },
    });

    const datos = () => {
        let mes = formatDate(new Date());
        mes = mes.split("/").reverse().join("-");
        mes = mes.split("-");
        $("#fechaInput").val(`${mes[0]}-${mes[1]}`);
        $.ajax({
            type: "GET",
            data: {
                fecha: `${mes[0]}-${mes[1]}`,
                dolar: dolar,
                euro: $("#euroInput").val(),
                franco: $("#francoInput").val(),
            },
            url: "/admin/getResumenPagoPsAnterior",
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
                console.log(response);
            },
        });
    };

    let date = formatDate(new Date());
    date = date.split("/").reverse().join("-");
    $("#dateInput").val(date);

    const tablaResumen = () => {
        table = $(".resumenPagoPs").DataTable({
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
            order: [[0, "asc"]],
        });
    };

    $(document).on("change", ".status", function () {
        var checked = $(this).is(":checked");

        if (checked) {
            $(this).val("Pagado");
        } else {
            $(this).val("Pendiente");
        }

        var id = $(this).data("id");
        var statusValor = $(this).val();
        let moneda = $(this).data("moneda");
        let dolar = $("#dolarInput").val();

        if (moneda == "euros") {
            dolar = $("#euroInput").val();
        } else if (moneda == "francos") {
            dolar = $("#francoInput").val();
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
            url: "/admin/editStatusPagoPsAnterior",
            data: {
                id: id,
                status: statusValor,
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

    $(document).on("change", "#fechaInput", function () {
        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-success">Cargando comisiones<span class="dotting"> </span></p>
                </div>
            `
        );

        let fecha = $("#fechaInput").val();

        if (fecha.length > 0) {
            $("#generarResumenPs").prop("disabled", false);
            $.ajax({
                type: "GET",
                data: {
                    fecha: fecha,
                    dolar: $("#dolarInput").val(),
                    euro: $("#euroInput").val(),
                    franco: $("#francoInput").val(),
                },
                url: "/admin/getResumenPagoPsAnterior",
                success: function (response) {
                    $("#tablaResumen").empty();
                    $("#tablaResumen").html(response);
                    tablaResumen();

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
        } else {
            $("#generarResumenPs").prop("disabled", true);
            $("#contImprimirResum").addClass("d-none");
            $("#contVacio").empty();
        }
    });

    $("#exportarResumenPs").on("click", function () {
        let fecha = $("#fechaInput").val();
        let dolar = $("#dolarInput").val();

        window.open(
            `/admin/exportarResumenPsAnterior?fecha=${fecha}&dolar=${dolar}`
        );
    });

    $(document).on("click", "#imprimirReporte", function () {
        let dolar_reporte = $("#dolarInput").val();
        let date_valor = $("#dateInput").val();
        if (date_valor.length > 0) {
            let moneda = $(this).data("moneda");
            let ps = $(this).data("ps");
            let comision = String($(this).data("comision"))
                .replaceAll("$", "")
                .replaceAll(",", "");
            let comision_dolares = String($(this).data("comisiondolares"))
                .replaceAll("$", "")
                .replaceAll(",", "");

            let letra_dolares = numeroALetrasUSD(comision_dolares);

            if (moneda == "euros") {
                comision_dolares = String($(this).data("comisioneuros"))
                    .replaceAll("$", "")
                    .replaceAll(",", "");
                letra_dolares = numeroALetrasEUR(comision_dolares);
            } else if (moneda == "francos") {
                comision_dolares = String($(this).data("comisionfrancos"))
                    .replaceAll("$", "")
                    .replaceAll(",", "");
                letra_dolares = numeroALetrasCHF(comision_dolares);
            }

            let letra = numeroALetrasMXN(comision);

            let fecha_mes = $(this).data("fecha");

            window.open(
                `/admin/imprimirReportePsAnterior?ps=${ps}&comision=${comision}&comision_dolares=${comision_dolares}&letra=${letra}&letra_dolares=${letra_dolares}&dolar=${dolar_reporte}&fecha_imprimir=${date_valor}&fecha_mes=${fecha_mes}&moneda=${moneda}`,
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

        let moneda = $(this).data("moneda");
        let ps = $(this).data("ps");
        let comision = String($(this).data("comision"))
            .replaceAll("$", "")
            .replaceAll(",", "");
        let comision_dolares = String($(this).data("comisiondolares"))
            .replaceAll("$", "")
            .replaceAll(",", "");

        let letra_dolares = numeroALetrasUSD(comision_dolares);

        if (moneda == "euros") {
            comision_dolares = String($(this).data("comisioneuros"))
                .replaceAll("$", "")
                .replaceAll(",", "");
            letra_dolares = numeroALetrasEUR(comision_dolares);
        } else if (moneda == "francos") {
            comision_dolares = String($(this).data("comisionfrancos"))
                .replaceAll("$", "")
                .replaceAll(",", "");
            letra_dolares = numeroALetrasCHF(comision_dolares);
        }

        let letra = numeroALetrasMXN(comision);

        let fecha_mes = $(this).data("fecha");

        $("#psInput").val(ps);
        $("#comisionInput").val(formatearCantidad.format(comision));
        $("#comisionDolaresInput").val(
            formatearCantidad.format(comision_dolares)
        );
        $("#letraInput").val(letra);
        $("#letraDolaresInput").val(letra_dolares);
        $("#fechaMesInput").val(fecha_mes);
    });

    $(document).on("click", "#imprimirReporteModal", function () {
        let ps = $("#psInput").val();
        let comision = $("#comisionInput")
            .val()
            .replaceAll("$", "")
            .replaceAll(",", "");
        let comision_dolares = $("#comisionDolaresInput")
            .val()
            .replaceAll("$", "")
            .replaceAll(",", "");
        let letra = $("#letraInput").val();
        let letra_dolares = $("#letraDolaresInput").val();
        let moneda = $("#monedaInput").val();
        let dolar = $("#dolarInput").val();
        let date_valor = $("#dateInput").val();
        let fecha_mes = $("#fechaMesInput").val();

        if (moneda == "euros") {
            dolar = $("#euroInput").val();
        } else if (moneda == "francos") {
            dolar = $("#francoInput").val();
        }

        window.open(
            `/admin/imprimirReportePsAnterior?ps=${ps}&comision=${comision}&comision_dolares=${comision_dolares}&letra=${letra}&letra_dolares=${letra_dolares}&dolar=${dolar}&fecha_imprimir=${date_valor}&fecha_mes=${fecha_mes}&moneda=${moneda}`,
            "_blank"
        );
    });

    $(document).on("keyup", "#dolarInput", function () {
        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-success">Cargando comisiones<span class="dotting"> </span></p>
                </div>
            `
        );

        let dolar_nuevo = $("#dolarInput").val();
        let fecha = $("#fechaInput").val();

        if (dolar_nuevo == 0 || dolar_nuevo == "") {
            $("#dolarInput").val(dolar);
            dolar_nuevo = $("#dolarInput").val();
        }

        $.ajax({
            type: "GET",
            data: {
                fecha: fecha,
                dolar: dolar_nuevo,
                euro: $("#euroInput").val(),
                franco: $("#francoInput").val(),
            },
            url: "/admin/getResumenPagoPsAnterior",
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
        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-success">Cargando comisiones<span class="dotting"> </span></p>
                </div>
            `
        );

        let euro_nuevo = $("#euroInput").val();
        let fecha = $("#fechaInput").val();

        if (euro_nuevo == 0 || euro_nuevo == "") {
            $("#euroInput").val(euro);
            euro_nuevo = $("#euroInput").val();
        }

        $.ajax({
            type: "GET",
            data: {
                fecha: fecha,
                euro: euro_nuevo,
                dolar: $("#dolarInput").val(),
                franco: $("#francoInput").val(),
            },
            url: "/admin/getResumenPagoPsAnterior",
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
        $("#tablaResumen").empty();
        $("#tablaResumen").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-success" role="status"></div>
                    <p class="text-success">Cargando comisiones<span class="dotting"> </span></p>
                </div>
            `
        );

        let franco_nuevo = $("#francoInput").val();
        let fecha = $("#fechaInput").val();

        if (franco_nuevo == 0 || franco_nuevo == "") {
            $("#francoInput").val(franco);
            franco_nuevo = $("#francoInput").val();
        }

        $.ajax({
            type: "GET",
            data: {
                fecha: fecha,
                franco: franco_nuevo,
                euro: $("#euroInput").val(),
                dolar: $("#dolarInput").val(),
            },
            url: "/admin/getResumenPagoPsAnterior",
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
        $("#modalTitleWhats").text("Mandar WhatsApp para pago en pesos");
        let ps = $(this).data("ps");
        let psnumero = $(this).data("psnumero");
        let comision = $(this).data("comision");
        let fecha_mes = $(this).data("fecha");

        let mensaje = `Buen día ${ps}, se ha realizado una transferencia a su cuenta por la cantidad de $${comision} pesos, por su comisión de PS por el mes de ${fecha_mes}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;

        $("#nombrePsInput").val(ps);
        $("#numeroPsInput").val(psnumero);
        $("#mensajeInput").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", ".abrirTrans", function () {
        $("#modalTitleWhats").text("Mandar WhatsApp para transferencia");
        let ps = $(this).data("ps");
        let psnumero = $(this).data("psnumero");
        let moneda = $(this).data("moneda");
        let comision_dolares = $(this).data("comisiondolares");
        let fecha_mes = $(this).data("fecha");
        let tipo_moneda = "dólares";

        if (moneda == "euros") {
            comision_dolares = $(this).data("comisioneuros");
            tipo_moneda = "euros";
        } else if (moneda == "francos") {
            comision_dolares = $(this).data("comisionfrancos");
            tipo_moneda = "francos suizos";
        }

        let mensaje = `Buen día ${ps}, se ha realizado una transferencia a su cuenta Swissquote por la cantidad de $${comision_dolares} ${tipo_moneda}, por su comisión de PS por el mes de ${fecha_mes}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;

        $("#nombrePsInput").val(ps);
        $("#numeroPsInput").val(psnumero);
        $("#mensajeInput").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", "#enviarWhats", function () {
        let ps = $("#nombrePsInput").val();
        let numero = $("#numeroPsInput").val();
        let mensaje = $("#mensajeInput").val();

        window.open(
            `https://web.whatsapp.com/send?phone=${numero}&text=${mensaje}`,
            "_blank"
        );

        Swal.fire({
            icon: "success",
            title: '<h1 style="font-family: Poppins; font-weight: 700;">WhatsApp envíado</h1>',
            html: `<p style="font-family: Poppins">Se ha enviado un mensaje a <b>${ps}</b>, con número de teléfono <b>${numero}</b>.</p>`,
            confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
            confirmButtonColor: "#01bbcc",
        });
        $("#formModalWhats").modal("hide");
    });

    $(document).on("click", ".nota", function (e) {
        $("#notaForm")[0].reset();
        $("#formModalNota").modal("show");
        $("#alertaNota").empty();

        $("#montoEfectivoCont").hide();
        $("#montoTransferenciaCont").hide();
        $("#montoTransSwissCont").hide();

        let pagoid = $(this).data("pagoid");
        let pagoidconvenio = $(this).data("pagoidconvenio");
        let contratoid = $(this).data("contratoid");
        let numero_pago = $(this).data("numeropago");
        let numero_pago_convenio = $(this).data("numeropagoconvenio");
        let moneda = $(this).data("moneda");
        let dolar = $("#dolarInput").val();

        if (moneda == "euros") {
            dolar = $("#euroInput").val();
        } else if (moneda == "francos") {
            dolar = $("#francoInput").val();
        }

        let monto = $(this).data("monto");
        pesos = $(this).data("pesos").toString().replaceAll(",", "");
        dolares = $(this).data("dolares").toString().replaceAll(",", "");
        dolares = parseFloat(dolares);
        let tipopago = $(this).data("tipopago");

        let checkbox = [
            "#efectivoInput",
            "#transferenciaInput",
            "#transferenciaSwissInput",
        ];

        let inputs = [
            "#montoEfectivoInput",
            "#montoTransferenciaInput",
            "#montoTransferenciaSwissInput",
        ];

        let conts = [
            "#montoEfectivoCont",
            "#montoTransferenciaCont",
            "#montoTransSwissCont",
        ];

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

        $("#idInputNota").val(pagoid);
        $("#idConvenioInputNota").val(pagoidconvenio);
        $("#contratoIdInputNota").val(contratoid);
        $("#numeroPagoInputNota").val(numero_pago);
        $("#numeroPagoConvenioInputNota").val(numero_pago_convenio);
        $("#memoInputNota").val("Pago de comisión");
        $("#dolarInputNota").val(dolar);

        $("#notaForm").attr("action", "/admin/guardarPagoPsAnterior");
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

        $("#montoTransferenciaSwissInput").val(dolares.toFixed(2));
    });

    $(document).on("submit", "#notaForm", function (e) {
        e.preventDefault();
        let url = $(this).attr("action");
        $("#alertMessage").text("");

        if ($("#montoEfectivoCont").is(":hidden")) {
            $("#montoEfectivoInput").val(0);
        }

        if ($("#montoTransferenciaCont").is(":hidden")) {
            $("#montoTransferenciaInput").val(0);
        }

        if ($("#montoTransSwissCont").is(":hidden")) {
            $("#montoTransferenciaSwissInput").val(0);
        }

        let efectivo = $("#montoEfectivoInput").val();
        let transferencia = $("#montoTransferenciaInput").val();
        let transferenciaSwiss = $("#montoTransferenciaSwissInput").val();

        if (efectivo > 0 || transferencia > 0 || transferenciaSwiss > 0) {
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData(this),
                // dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function () {
                    $("#formModalNota").modal("hide");
                    $("#notaForm")[0].reset();
                    let fecha = $("#fechaInput").val();
                    $.ajax({
                        type: "GET",
                        data: {
                            fecha: fecha,
                            dolar: dolar,
                            euro: $("#euroInput").val(),
                            franco: $("#francoInput").val(),
                        },
                        url: "/admin/getResumenPagoPsAnterior",
                        success: function (response) {
                            table.destroy();
                            $("#tablaResumen").empty();
                            $("#tablaResumen").html(response);
                            tablaResumen();

                            let monedaDolaresChecked = $(
                                "#monedaDolaresInput"
                            ).is(":checked");
                            let monedaEurosChecked =
                                $("#monedaEurosInput").is(":checked");
                            let monedaFrancosChecked = $(
                                "#monedaFrancosInput"
                            ).is(":checked");

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
