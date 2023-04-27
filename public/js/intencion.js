$(document).ready(function () {
    let formatearFecha = (fecha) => {
        return fecha.split(" ")[0].split("-").reverse().join("/");
    };

    let formatearCantidad = new Intl.NumberFormat("es-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
    });

    var table = $("#intencion").DataTable({
        ajax: "/admin/showIntencion",
        columns: [
            { data: "nombre" },
            { data: "telefono" },
            { data: "email" },
            {
                data: "inversion_usd",
                render: function (data) {
                    return formatearCantidad.format(data);
                },
            },
            {
                data: "fecha_inicio",
                render: function (data) {
                    return formatearFecha(data);
                },
            },
            { data: "btn" },
        ],
        responsive: {
            breakpoints: [
                {
                    name: "desktop",
                    width: Infinity,
                },
                {
                    name: "tablet",
                    width: 1024,
                },
                {
                    name: "fablet",
                    width: 768,
                },
                {
                    name: "phone",
                    width: 480,
                },
            ],
        },
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ intenciones",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ninguna intención de inversión",
            infoEmpty:
                "Mostrando intenciones del 0 al 0 de un total de 0 intenciones",
            infoFiltered: "(filtrado de un total de _MAX_ intenciones)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ intenciones",
        },
        aaSorting: [],
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var nombre = $(this).data("nombre");
        var telefono = $(this).data("telefono");
        var email = $(this).data("email");
        var tipocambio = $(this).data("tipocambio");
        var inversionmxn = $(this).data("inversionmxn");
        var inversionusd = $(this).data("inversionusd");
        var fechainicio = $(this).data("fechainicio");
        var fechapago = $(this).data("fechapago");
        var fecharenovacion = $(this).data("fecharenovacion");
        var tipo1 = $(this).data("tipo1");
        var porcentajetipo1 = $(this).data("porcentajetipo1");
        var porcentajeinversion1 = $(this).data("porcentajeinversion1");
        var tipo2 = $(this).data("tipo2");
        var porcentajetipo2 = $(this).data("porcentajetipo2");
        var porcentajeinversion2 = $(this).data("porcentajeinversion2");

        $("#modalTitle").text(
            `Vista previa de la intención de inversión de: ${nombre}`
        );

        $("#formModal").modal("show");

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#telefonoInput").val(telefono);
        $("#telefonoInput").prop("readonly", true);

        $("#emailInput").val(email);
        $("#emailInput").prop("readonly", true);

        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", true);

        $("#inversionInput").val(inversionmxn);
        $("#inversionInput").prop("readonly", true);

        $("#inversionUsInput").val(inversionusd);
        $("#inversionUsInput").prop("readonly", true);

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaPagoInput").val(fechapago);
        $("#fechaPagoInput").prop("readonly", true);

        $("#fechaRenovacionInput").val(fecharenovacion);
        $("#fechaRenovacionInput").prop("readonly", true);

        $("#tipo1Input").val(tipo1);
        $("#tipo1Input").prop("readonly", true);

        $("#porcentajeTipo1Input").val(porcentajetipo1);
        $("#porcentajeTipo1Input").prop("readonly", true);

        $("#porcentajeInversion1Input").val(porcentajeinversion1);
        $("#porcentajeInversion1Input").prop("readonly", true);

        $("#tipo2Input").val(tipo2);
        $("#tipo2Input").prop("readonly", true);

        $("#porcentajeTipo2Input").val(porcentajetipo2);
        $("#porcentajeTipo2Input").prop("readonly", true);

        $("#porcentajeInversion2Input").val(porcentajeinversion2);
        $("#porcentajeInversion2Input").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar intención de inversión</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar esta intención de inversión? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteIntencion", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Intención de inversión eliminada</h1>',
                        html: '<p style="font-family: Poppins">La intención de inversión se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La intención de inversión no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    //Fecha inicial
    let fechaInicial = formatDate(new Date());
    fechaInicial = fechaInicial.split("/").reverse().join("-");
    $("#fechaInicioInput").val(fechaInicial);

    fechaInicial = new Date();
    let fechaInicialReintegro = new Date(
        fechaInicial.setMonth(fechaInicial.getMonth() + parseInt(12))
    );

    //Fecha inicial de reintegro
    let fechaInicialRenovacion = fechaInicialReintegro.outDays(15);
    fechaInicialRenovacion = formatDate(new Date(fechaInicialRenovacion));
    fechaInicialRenovacion = fechaInicialRenovacion
        .split("/")
        .reverse()
        .join("-");
    $("#fechaRenInput").val(fechaInicialRenovacion);

    //Fecha inicial de pago
    let fechaInicialPago = fechaInicialReintegro.addDays(15);
    fechaInicialPago = formatDate(new Date(fechaInicialPago));
    fechaInicialPago = fechaInicialPago.split("/").reverse().join("-");
    $("#fechaPagInput").val(fechaInicialPago);

    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
        success: function (response) {
            //Handler de la respuesta
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioDolar = serie.datos[0].dato;

                $("#tipoCambioInput").val(precioDolar);
            }
        },
    });

    if ($("#dividirSwitch").prop("checked") == false) {
        $.ajax({
            type: "POST",
            url: "/admin/getOpc",
            success: function (response) {
                $("#contOpciones").html(response);
            },
        });
    } else {
        $.ajax({
            type: "POST",
            url: "/admin/getOpcDividir",
            success: function (response) {
                $("#contOpciones").empty();
                $("#contOpciones").html(response);
            },
        });
    }

    $("#dividirSwitch").change(function () {
        if ($("#dividirSwitch").prop("checked") == true) {
            $.ajax({
                type: "POST",
                url: "/admin/getOpcDividir",
                success: function (response) {
                    $("#contOpciones").empty();
                    $("#contOpciones").html(response);
                },
            });
        } else {
            $.ajax({
                type: "POST",
                url: "/admin/getOpc",
                success: function (response) {
                    $("#contOpciones").empty();
                    $("#contOpciones").html(response);
                },
            });
        }
    });

    $("#clienteSwitch").change(function () {
        if ($("#clienteSwitch").prop("checked") == false) {
            $("#contCliente").empty();

            $("#contCliente").append(`
            <div class="col-md-6 col-12">
            <div class="form-floating mb-3">
                <input type="text" class="form-control"
                    placeholder="Ingresa el nombre completo" id="nombreInput"
                    name="nombre" required style="text-transform: none;">
                <label for="nombreInput">Nombre completo del inversor</label>
            </div>
        </div>
        <div class="col-md-3 col-12">
        <div class="form-floating mb-3">
            <input type="email" class="form-control"
                placeholder="Ingresa el correo electrónico" id="emailInput"
                name="email" required style="text-transform: none;">
            <label for="emailInput">Correo electrónico</label>
        </div>
    </div>
    <div class="col-md-3 col-12">
        <div class="form-floating mb-3">
            <input type="number" step="any" class="form-control"
                placeholder="Ingresa la cantidad de inversión" id="telefonoInput"
                name="telefono" required>
            <label for="telefonoInput">Número de teléfono</label>
        </div>
    </div>
        `);
        } else {
            $.ajax({
                type: "POST",
                url: "/admin/getClientes",
                success: function (response) {
                    $("#contCliente").empty();
                    $("#contCliente").append(response);
                },
            });
        }
    });
});

function getPorcentaje() {
    var select = $("#tipoIdInput");
    var rendimiento = $("option:selected", select).attr("data-rendimiento");
    // rendimiento = rendimiento.slice(3);
    $("#porcentajeInput").val(rendimiento);
}

function getPorcentaje2() {
    var select = $("#tipoIdInput2");
    var rendimiento = $("option:selected", select).attr("data-rendimiento");
    // rendimiento = rendimiento.slice(3);
    $("#porcentajeInput2").val(rendimiento);
}

function setPorcentaje() {
    var porcentaje = $("#porcentajeInversionInput").val();

    var restante = 100 - porcentaje;

    if (porcentaje >= 100) {
        $("#porcentajeInversionInput").val(100);
        $("#porcentajeInversionInput2").val(0);
    } else {
        $("#porcentajeInversionInput2").val(restante);
    }
}

function setPorcentaje2() {
    var porcentaje = $("#porcentajeInversionInput2").val();

    var restante = 100 - porcentaje;

    if (porcentaje >= 100) {
        $("#porcentajeInversionInput2").val(100);
        $("#porcentajeInversionInput").val(0);
    } else {
        $("#porcentajeInversionInput").val(restante);
    }
}

$("#contForm").on("keyup change", function (event) {
    $("#tablaBody").empty();
    var meses = 12;

    var target = $(event.target);
    if (target.is("#inversionInput")) {
        if ($("#tipoCambioInput").val()) {
            var peso = $("#inversionInput").val();

            var dolar_peso = $("#tipoCambioInput").val();

            var dolares = peso / dolar_peso;

            $("#inversionUsInput").val(dolares.toFixed(2));
        }
    } else if (target.is("#inversionUsInput")) {
        if ($("#tipoCambioInput").val()) {
            var dolar = $("#inversionUsInput").val();

            var dolar_peso = $("#tipoCambioInput").val();

            var peso = 1 / dolar_peso;

            var pesos = dolar / peso;

            $("#inversionInput").val(pesos.toFixed(2));
        }
    }
    if (target.is($("#nombreInput"))) {
        if (target.is("select")) {
            var id = $("option:selected", this).data("id");

            $.post({
                data: {
                    id: id,
                },
                url: "/admin/getDatosCliente",
                success: function (response) {
                    $("#telefonoInput").val(response[0].celular);
                    $("#emailInput").val(response[0].correo_personal);
                },
            });
        }
    }
    if ($("#fechaInicioInput").val()) {
        var fechaInicio = $("#fechaInicioInput").val();
        fechaInicio = new Date(fechaInicio);
        fechaInicio = fechaInicio.addDays(1);

        var fechaReintegro = new Date(
            fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
        );

        var fechaRenovacion = fechaReintegro.outDays(15);

        var fechaPago = fechaReintegro.addDays(15);
        fechaPago = formatDate(new Date(fechaPago));
        fechaPago = fechaPago.split("/").reverse().join("-");

        $("#fechaPagInput").val(fechaPago);

        fechaRenovacion = formatDate(new Date(fechaRenovacion));
        fechaRenovacion = fechaRenovacion.split("/").reverse().join("-");

        $("#fechaRenInput").val(fechaRenovacion);
    }
    if ($("#tipoIdInput").val()) {
        getPorcentaje();
    }
    if ($("#tipoIdInput2").val()) {
        getPorcentaje2();
    }
    if (target.is("#porcentajeInversionInput")) {
        setPorcentaje();
    } else if (target.is("#porcentajeInversionInput2")) {
        setPorcentaje2();
    }
    if (
        $("#inversionInput").val() &&
        $("#inversionUsInput").val() &&
        $("#tipoCambioInput").val() &&
        $("#fechaInicioInput").val() &&
        $("#fechaRenInput").val() &&
        $("#fechaPagInput").val() &&
        $("#tipoIdInput").val() &&
        $("#porcentajeInput").val()
    ) {
        if ($("#dividirSwitch").prop("checked") == false) {
            $("#contTabla").empty();

            var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                "data-tipo"
            );

            if (tipo_contrato == "Rendimiento compuesto") {
                $("#contTabla").append(`
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Capital (MXN)</th>
                                    <th scope="col">Capital (USD)</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBody">                        
                            </tbody>
                        </table>
                    </div>
                `);
            } else if (tipo_contrato == "Rendimiento mensual") {
                $("#contTabla").append(`
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Capital (MXN)</th>
                                    <th scope="col">Capital (USD)</th>
                                    <th scope="col">Interés</th>
                                    <th scope="col">Fecha</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBody">                        
                            </tbody>
                        </table>
                    </div>
                `);
            }

            var inversionMXN = $("#inversionInput").val();
            inversionMXN = parseFloat(inversionMXN);

            var inversionUSD = $("#inversionUsInput").val();
            inversionUSD = parseFloat(inversionUSD);

            var porcentaje = $("#porcentajeInput").val();
            porcentaje = parseFloat(porcentaje);

            var fecha = $("#fechaInicioInput").val();
            var porcentaje = $("#porcentajeInput").val();
            var usd = parseFloat($("#tipoCambioInput").val());

            for (var i = 0; i < meses; i++) {
                fecha = new Date(fecha);
                fecha = fecha.setMonth(fecha.getMonth() + 1);
                fecha = new Date(fecha);
                fecha = fecha.addDays(1);
                fecha = formatDate(fecha);

                var fechaInput = fecha.split("/").reverse().join("-");

                var formatterUSD = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                });

                var formatterMXN = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN",
                });

                if (tipo_contrato == "Rendimiento compuesto") {
                    var porcentaje2 = `0.0${porcentaje}`;
                    porcentaje2 = parseFloat(porcentaje2);

                    inversionMXN = inversionMXN + inversionMXN * porcentaje2;
                    inversionUSD = inversionMXN / usd;
                    $("#tablaBody").append(` 
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${formatterMXN.format(inversionMXN)}</td>
                        <td>${formatterUSD.format(inversionUSD)}</td>
                        <td>${fecha}</td>
                    </tr>
                    `);
                } else if (tipo_contrato == "Rendimiento mensual") {
                    var porcentaje2 = `0.0${porcentaje}`;
                    porcentaje2 = parseFloat(porcentaje2);
                    $("#tablaBody").append(` 
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${formatterMXN.format(inversionMXN)}</td>
                        <td>${formatterUSD.format(inversionUSD)}</td>
                        <td>${formatterUSD.format(
                            inversionUSD * porcentaje2
                        )}</td>
                        <td>${fecha}</td>
                    </tr>
                    `);
                }

                fecha = fecha.split("/").reverse().join("-");
            }
        } else {
            $("#contTabla").empty();
            if (
                $("#inversionInput").val() &&
                $("#inversionUsInput").val() &&
                $("#tipoCambioInput").val() &&
                $("#fechaInicioInput").val() &&
                $("#fechaRenInput").val() &&
                $("#fechaPagInput").val() &&
                $("#tipoIdInput").val() &&
                $("#porcentajeInput").val() &&
                $("#tipoIdInput2").val() &&
                $("#porcentajeInput2").val() &&
                $("#porcentajeInversionInput").val() &&
                $("#porcentajeInversionInput2").val()
            ) {
                var porcentaje1 = $("#porcentajeInversionInput").val();
                var porcentaje2 = $("#porcentajeInversionInput2").val();
                var dolar_peso = $("#tipoCambioInput").val();
                var inversionMXN1;
                var inversionUSD1;
                var inversionMXN2;
                var inversionUSD2;

                if (porcentaje1.toString().length == 1) {
                    porcentaje1 = `0.0${porcentaje1}`;
                    porcentaje1 = parseFloat(porcentaje1);

                    inversionMXN1 = $("#inversionInput").val() * porcentaje1;
                } else {
                    porcentaje1 = `0.${porcentaje1}`;
                    porcentaje1 = parseFloat(porcentaje1);
                    inversionMXN1 = $("#inversionInput").val() * porcentaje1;
                }

                if (porcentaje2.toString().length == 1) {
                    porcentaje2 = `0.0${porcentaje2}`;
                    porcentaje2 = parseFloat(porcentaje2);

                    inversionMXN2 = $("#inversionInput").val() * porcentaje2;
                } else {
                    porcentaje2 = `0.${porcentaje2}`;
                    porcentaje2 = parseFloat(porcentaje2);
                    inversionMXN2 = $("#inversionInput").val() * porcentaje2;
                }

                inversionMXN1 = inversionMXN1.toFixed(2);
                inversionUSD1 = (inversionMXN1 / dolar_peso).toFixed(2);

                $("#inversionMXN1").val(inversionMXN1);
                $("#inversionUSD1").val(inversionUSD1);

                inversionMXN2 = inversionMXN2.toFixed(2);
                inversionUSD2 = (inversionMXN2 / dolar_peso).toFixed(2);

                $("#inversionMXN2").val(inversionMXN2);
                $("#inversionUSD2").val(inversionUSD2);

                $("#contTabla").empty();

                var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                    "data-tipo"
                );

                if (tipo_contrato == "Rendimiento compuesto") {
                    $("#contTabla").append(`
                    <div class="col-12">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#info-fill" />
                        </svg>
                        <div>
                            Inversión del primer contrato de tipo ${tipo_contrato} al ${$(
                        "#porcentajeInversionInput"
                    ).val()}% de la inversión inicial:
                        </div>
                    </div>
                </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Capital (MXN)</th>
                                        <th scope="col">Capital (USD)</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaBody">                        
                                </tbody>
                            </table>
                        </div>
                    `);
                } else if (tipo_contrato == "Rendimiento mensual") {
                    $("#contTabla").append(`
                    <div class="col-12">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#info-fill" />
                        </svg>
                        <div>
                            Inversión del primer contrato de tipo ${tipo_contrato} al ${$(
                        "#porcentajeInversionInput"
                    ).val()}% de la inversión inicial:
                        </div>
                    </div>
                </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Capital (MXN)</th>
                                        <th scope="col">Capital (USD)</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaBody">                        
                                </tbody>
                            </table>
                        </div>
                    `);
                }

                var inversionMXN = $("#inversionMXN1").val();
                inversionMXN = parseFloat(inversionMXN);

                var inversionUSD = $("#inversionUSD1").val();
                inversionUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput").val();
                porcentaje = parseFloat(porcentaje);

                var fecha = $("#fechaInicioInput").val();
                var porcentaje = $("#porcentajeInput").val();
                var usd = parseFloat($("#tipoCambioInput").val());

                for (var i = 0; i < meses; i++) {
                    fecha = new Date(fecha);
                    fecha = fecha.setMonth(fecha.getMonth() + 1);
                    fecha = new Date(fecha);
                    fecha = fecha.addDays(1);
                    fecha = formatDate(fecha);

                    var fechaInput = fecha.split("/").reverse().join("-");

                    var formatterUSD = new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "USD",
                    });

                    var formatterMXN = new Intl.NumberFormat("es-MX", {
                        style: "currency",
                        currency: "MXN",
                    });

                    if (tipo_contrato == "Rendimiento compuesto") {
                        $("#tablaBody").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${formatterMXN.format(inversionMXN)}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${fecha}</td>
                        </tr>
                        `);
                        var porcentaje2 = `0.0${porcentaje}`;
                        porcentaje2 = parseFloat(porcentaje2);

                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD = inversionMXN / usd;
                    } else if (tipo_contrato == "Rendimiento mensual") {
                        var porcentaje2 = `0.0${porcentaje}`;
                        porcentaje2 = parseFloat(porcentaje2);
                        $("#tablaBody").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${formatterMXN.format(inversionMXN)}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${formatterUSD.format(
                                inversionUSD * porcentaje2
                            )}</td>
                            <td>${fecha}</td>
                        </tr>
                        `);
                    }

                    fecha = fecha.split("/").reverse().join("-");
                }

                $("#contTabla2").empty();

                var tipo_contrato2 = $("option:selected", "#tipoIdInput2").attr(
                    "data-tipo"
                );

                if (tipo_contrato2 == "Rendimiento compuesto") {
                    $("#contTabla2").append(`
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Inversión del segundo contrato de tipo ${tipo_contrato2} al ${$(
                        "#porcentajeInversionInput2"
                    ).val()}% de la inversión inicial:
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Capital (MXN)</th>
                                        <th scope="col">Capital (USD)</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaBody2">                        
                                </tbody>
                            </table>
                        </div>
                    `);
                } else if (tipo_contrato2 == "Rendimiento mensual") {
                    $("#contTabla2").append(`
                    <div class="col-12">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                            <use xlink:href="#info-fill" />
                        </svg>
                        <div>
                            Inversión del segundo contrato de tipo ${tipo_contrato2} al ${$(
                        "#porcentajeInversionInput2"
                    ).val()}% de la inversión inicial:
                        </div>
                    </div>
                </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Serie</th>
                                        <th scope="col">Capital (MXN)</th>
                                        <th scope="col">Capital (USD)</th>
                                        <th scope="col">Interés</th>
                                        <th scope="col">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaBody2">                        
                                </tbody>
                            </table>
                        </div>
                    `);
                }

                var inversionMXN = $("#inversionMXN2").val();
                inversionMXN = parseFloat(inversionMXN);

                var inversionUSD = $("#inversionUSD2").val();
                inversionUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput2").val();
                porcentaje = parseFloat(porcentaje);

                var fecha = $("#fechaInicioInput").val();
                var porcentaje = $("#porcentajeInput2").val();
                var usd = parseFloat($("#tipoCambioInput").val());

                for (var i = 0; i < meses; i++) {
                    fecha = new Date(fecha);
                    fecha = fecha.setMonth(fecha.getMonth() + 1);
                    fecha = new Date(fecha);
                    fecha = fecha.addDays(1);
                    fecha = formatDate(fecha);

                    var fechaInput = fecha.split("/").reverse().join("-");

                    var formatterUSD = new Intl.NumberFormat("en-US", {
                        style: "currency",
                        currency: "USD",
                    });

                    var formatterMXN = new Intl.NumberFormat("es-MX", {
                        style: "currency",
                        currency: "MXN",
                    });

                    if (tipo_contrato2 == "Rendimiento compuesto") {
                        $("#tablaBody2").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${formatterMXN.format(inversionMXN)}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${fecha}</td>
                        </tr>
                        `);
                        var porcentaje2 = `0.0${porcentaje}`;
                        porcentaje2 = parseFloat(porcentaje2);

                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD = inversionMXN / usd;
                    } else if (tipo_contrato2 == "Rendimiento mensual") {
                        var porcentaje2 = `0.0${porcentaje}`;
                        porcentaje2 = parseFloat(porcentaje2);
                        $("#tablaBody2").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${formatterMXN.format(inversionMXN)}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${formatterUSD.format(
                                inversionUSD * porcentaje2
                            )}</td>
                            <td>${fecha}</td>
                        </tr>
                        `);
                    }

                    fecha = fecha.split("/").reverse().join("-");
                }
            }
        }
    }
});
