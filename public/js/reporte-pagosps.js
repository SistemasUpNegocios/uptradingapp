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
                dolar = parseFloat(dolar);
                dolar = dolar.toFixed(2);
                $("#dolarInput").val(dolar);
                datos();
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
            },
            url: "/admin/getResumenPagoPs",
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
    };

    let date = formatDate(new Date());
    date = date.split("/").reverse().join("-");
    $("#dateInput").val(date);

    const tablaResumen = () => {
        var table = $("#resumenPagoPs").DataTable({
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
        var dolar = $("#dolarInput").val();

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
            url: "/admin/editStatusPagoPs",
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
                    dolar: dolar,
                },
                url: "/admin/getResumenPagoPs",
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

        window.open(`/admin/exportarResumenPs?fecha=${fecha}&dolar=${dolar}`);
    });

    $(document).on("click", "#imprimirReporte", function () {
        let date_valor = $("#dateInput").val();
        if (date_valor.length > 0) {
            let ps = $(this).data("ps");
            let comision = String($(this).data("comision"))
                .replaceAll("$", "")
                .replaceAll(",", "");
            let comision_dolares = String($(this).data("comisiondolares"))
                .replaceAll("$", "")
                .replaceAll(",", "");

            let letra = numeroALetrasMXN(comision);
            let letra_dolares = numeroALetrasUSD(comision_dolares);

            let fecha_mes = $(this).data("fecha");

            window.open(
                `/admin/imprimirReportePs?ps=${ps}&comision=${comision}&comision_dolares=${comision_dolares}&letra=${letra}&letra_dolares=${letra_dolares}&dolar=${dolar}&fecha_imprimir=${date_valor}&fecha_mes=${fecha_mes}`,
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

        let ps = $(this).data("ps");
        let comision = String($(this).data("comision"))
            .replaceAll("$", "")
            .replaceAll(",", "");
        let comision_dolares = String($(this).data("comisiondolares"))
            .replaceAll("$", "")
            .replaceAll(",", "");

        let letra = numeroALetrasMXN(comision);
        let letra_dolares = numeroALetrasUSD(comision_dolares);

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
        let letra = numeroALetrasMXN(comision);
        let letra_dolares = numeroALetrasUSD(comision_dolares);
        let dolar = $("#dolarInput").val();
        let date_valor = $("#dateInput").val();
        let fecha_mes = $("#fechaMesInput").val();

        window.open(
            `/admin/imprimirReportePs?ps=${ps}&comision=${comision}&comision_dolares=${comision_dolares}&letra=${letra}&letra_dolares=${letra_dolares}&dolar=${dolar}&fecha_imprimir=${date_valor}&fecha_mes=${fecha_mes}`,
            "_blank"
        );
    });

    $(document).on("change", "#dolarInput", function () {
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
            },
            url: "/admin/getResumenPagoPs",
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
        let comision_dolares = $(this).data("comisiondolares");
        let fecha_mes = $(this).data("fecha");

        let mensaje = `Buen día ${ps}, se ha realizado una transferencia a su cuenta Swissquote por la cantidad de $${comision_dolares} dólares, por su comisión de PS por el mes de ${fecha_mes}.\n%0AAtte: Departamento de pagos - Up Trading Experts.`;

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
});
