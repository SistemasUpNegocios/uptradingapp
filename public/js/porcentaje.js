$(document).ready(function () {
    let acc = "";
    let dataInversionUS = 0;
    let dataInversionMXN = 0;
    let dataFechaInicio = "";

    var table = $("#porcentaje").DataTable({
        ajax: "/admin/getContratosPorcentaje",
        columns: [
            {
                data: function (data) {
                    return data.contrato;
                },
            },
            {
                data: function (data) {
                    return `${data.capertura}%`;
                },
            },
            {
                data: function (data) {
                    return `${data.cmensual}%`;
                },
            },
            {
                data: function (data) {
                    return `${data.porcentaje}%`;
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
            lengthMenu: "Mostrar _MENU_ contratos",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún contrato",
            infoEmpty:
                "Mostrando contratos del 0 al 0 de un total de 0 contratos",
            infoFiltered: "(filtrado de un total de _MAX_ contratos)",
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
                collacontratoe: {
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#contratoForm").on("submit", function (e) {
        e.preventDefault();
        var url = $(this).attr("action");
        $("#alertMessage").text("");

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $("#formModal").modal("hide");
                $("#contratoForm")[0].reset();
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Porcentajes actualizados</h1>',
                    html: '<p style="font-family: Poppins">El contrato ha sido actualizado correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".view", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var nombrecliente = $(this).data("nombrecliente");
        var fechainicio = $(this).data("fecha");
        var fecharen = $(this).data("fecharen");
        var fechapag = $(this).data("fechapag");
        var fechalimite = $(this).data("fechalimite");
        var periodo = $(this).data("periodo");
        var contrato = $(this).data("contrato");
        var psid = $(this).data("psid");
        var clienteid = $(this).data("clienteid");
        var tipoid = $(this).data("tipoid");
        var cmensual = $(this).data("cmensual");
        var capertura = $(this).data("capertura");
        var porcentaje = $(this).data("porcentaje");
        var folio = $(this).data("folio");
        var inversion = $(this).data("inversion");
        var inversionus = $(this).data("inversionus");
        var tipocambio = $(this).data("tipocambio");
        var inversionlet = $(this).data("inversionlet");
        var inversionletus = $(this).data("inversionletus");

        $("#modalTitle").text(`Vista previa del contrato de: ${nombrecliente}`);

        $("#formModal").modal("show");

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaRenInput").val(fecharen);
        $("#fechaRenInput").prop("readonly", true);

        $("#fechaPagInput").val(fechapag);
        $("#fechaPagInput").prop("readonly", true);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", true);

        $("#periodoInput").val(periodo);
        $("#periodoInput").prop("disabled", true);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", true);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        $("#porcentajeInput").prop("disabled", true);

        $("#porcentajeRenInput").val(porcentaje);
        $("#porcentajeRenInput").prop("disabled", true);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("disabled", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("disabled", true);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        inversion = inversion.toString().replace(",", ".");
        $("#inversionInput").val(inversion);
        $("#inversionInput").prop("readonly", true);

        inversionus = inversionus.toString().replace(",", ".");
        $("#inversionUsInput").val(inversionus);
        $("#inversionUsInput").prop("readonly", true);

        tipocambio = tipocambio.toString().replace(",", ".");
        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", true);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", true);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();

        $(".cont-tabla").empty();

        var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
            "data-tipo"
        );

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Capital (USD)</th>
                                <th scope="col">Interés</th>
                                <th scope="col">Rendimiento</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">                        
                        </tbody>
                    </table>
                </div>
            `);
        } else if (tipo_contrato == "Rendimiento mensual") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Capital (USD)</th>
                                <th scope="col">Interés</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">                        
                        </tbody>
                    </table>
                </div>
            `);
        }

        var cmensual = $("option:selected", "#tipoIdInput").attr(
            "data-cmensual"
        );

        cmensual = parseFloat(cmensual);

        var inversionMXN = $("#inversionInput").val();
        inversionMXN = parseFloat(inversionMXN);

        var inversionUSD = $("#inversionUsInput").val();
        inversionUSD = parseFloat(inversionUSD);

        var fecha = $("#fechaInicioInput").val();

        var porcentaje = $("#porcentajeInput").val();

        var cmensual2 = `0.0${cmensual}`;
        cmensual2 = parseFloat(cmensual2);

        var meses = $("#periodoInput").val();

        var fechaFeb = $("#fechaInicioInput").val();
        fechaFeb = fechaFeb.split("-");
        for (var i = 0; i < meses; i++) {
            fecha = fecha.split("-");
            if (parseInt(fecha[1]) + 1 == 2) {
                if (
                    fechaFeb[2] == 29 ||
                    fechaFeb[2] == 30 ||
                    fechaFeb[2] == 31
                ) {
                    fecha = `28/02/${fecha[0]}`;
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else if (fechaFeb[2] == 31) {
                if (
                    fecha[1] == 3 ||
                    fecha[1] == 5 ||
                    fecha[1] == 8 ||
                    fecha[1] == 10
                ) {
                    fecha = new Date(fecha[0], fecha[1], 30);
                    fecha = formatDate(fecha);
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else {
                fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                fecha = formatDate(fecha);
            }

            var formatterUSD = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            });

            if (porcentaje.length < 3 && porcentaje.length > 0) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `0.0${porcentaje}`;
                }
            } else if (porcentaje.length == 3) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `${porcentaje}`;
                }
            }
            porcentaje2 = parseFloat(porcentaje2);

            if (tipo_contrato == "Rendimiento compuesto") {
                $("#tablaBody").append(` 
                <tr>
                    <th scope="row">${i + 1}</th>
                    <td>${fecha}</td>
                    <td>${formatterUSD.format(inversionUSD)}</td>
                    <td>${formatterUSD.format(inversionUSD * porcentaje2)}</td>
                    <td>${formatterUSD.format(
                        inversionUSD + inversionUSD * porcentaje2
                    )}</td>
                </tr>
                `);
                inversionMXN = inversionMXN + inversionMXN * porcentaje2;
                inversionUSD = inversionUSD + inversionUSD * porcentaje2;
            } else if (tipo_contrato == "Rendimiento mensual") {
                $("#tablaBody").append(` 
                <tr>
                    <th scope="row">${i + 1}</th>
                    <td>${fecha}</td>
                    <td>${formatterUSD.format(inversionUSD)}</td>
                    <td>${formatterUSD.format(inversionUSD * porcentaje2)}</td>
                </tr>
                `);
            }

            fecha = fecha.split("/").reverse().join("-");
        }
    });

    $(document).on("click", ".edit", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();

        var id = $(this).data("id");

        var nombrecliente = $(this).data("nombrecliente");
        var fechainicio = $(this).data("fecha");
        var fecharen = $(this).data("fecharen");
        var fechapag = $(this).data("fechapag");
        var fechalimite = $(this).data("fechalimite");
        var periodo = $(this).data("periodo");
        var contrato = $(this).data("contrato");
        var psid = $(this).data("psid");
        var clienteid = $(this).data("clienteid");
        var tipoid = $(this).data("tipoid");
        var cmensual = $(this).data("cmensual");
        var capertura = $(this).data("capertura");
        var porcentaje = $(this).data("porcentaje");
        var folio = $(this).data("folio");
        var inversion = $(this).data("inversion");
        var inversionus = $(this).data("inversionus");
        var tipocambio = $(this).data("tipocambio");
        var inversionlet = $(this).data("inversionlet");
        var inversionletus = $(this).data("inversionletus");

        dataInversionUS = $(this).data("inversionus");
        dataInversionMXN = $(this).data("inversion");
        dataFechaInicio = $(this).data("fecha");

        $("#contratoForm").attr("action", "/admin/editPorcentajes");

        $("#idInput").val(id);

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaRenInput").val(fecharen);
        $("#fechaRenInput").prop("readonly", true);

        $("#fechaPagInput").val(fechapag);
        $("#fechaPagInput").prop("readonly", true);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", true);

        $("#periodoInput").val(periodo);
        $("#periodoInput").prop("disabled", true);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", true);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);

        $("#porcentajeRenInput").val(porcentaje);
        $("#porcentajeRenInput").prop("readonly", true);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        inversion = inversion.toString().replace(",", ".");
        $("#inversionInput").val(inversion);
        $("#inversionInput").prop("readonly", true);

        inversionus = inversionus.toString().replace(",", ".");
        $("#inversionUsInput").val(inversionus);
        $("#inversionUsInput").prop("readonly", true);

        tipocambio = tipocambio.toString().replace(",", ".");
        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        $("#porcentajeInput").prop("disabled", false);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("disabled", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("disabled", true);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", true);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", true);

        $("#modalTitle").text(`Editar contrato de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar contrato");
        $("#btnCancel").text("Cancelar");

        $(".cont-tabla").empty();

        var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
            "data-tipo"
        );

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Capital (USD)</th>
                                <th scope="col">Interés</th>
                                <th scope="col">Rendimiento</th>
                            </tr>
                        </thead>
                        <tbody id="tablaBody">                        
                        </tbody>
                    </table>
                </div>
            `);
        } else if (tipo_contrato == "Rendimiento mensual") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Capital (USD)</th>
                                <th scope="col">Interés</th>
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

        var fecha = $("#fechaInicioInput").val();

        var porcentaje = $("#porcentajeInput").val();

        var meses = $("#periodoInput").val();

        var fechaFeb = $("#fechaInicioInput").val();
        fechaFeb = fechaFeb.split("-");
        for (var i = 0; i < meses; i++) {
            fecha = fecha.split("-");
            if (parseInt(fecha[1]) + 1 == 2) {
                if (
                    fechaFeb[2] == 29 ||
                    fechaFeb[2] == 30 ||
                    fechaFeb[2] == 31
                ) {
                    fecha = `28/02/${fecha[0]}`;
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else if (fechaFeb[2] == 31) {
                if (
                    fecha[1] == 3 ||
                    fecha[1] == 5 ||
                    fecha[1] == 8 ||
                    fecha[1] == 10
                ) {
                    fecha = new Date(fecha[0], fecha[1], 30);
                    fecha = formatDate(fecha);
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else {
                fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                fecha = formatDate(fecha);
            }

            var formatterUSD = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            });

            var formatterMXN = new Intl.NumberFormat("es-MX", {
                style: "currency",
                currency: "MXN",
            });

            var fechaInput = fecha.split("/").reverse().join("-");

            if (porcentaje.length < 3 && porcentaje.length > 0) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `0.0${porcentaje}`;
                }
            } else if (porcentaje.length == 3) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `${porcentaje}`;
                }
            }
            porcentaje2 = parseFloat(porcentaje2);

            var monto = inversionUSD;
            var redito = inversionUSD * porcentaje2;
            var monto_redito = monto + redito;

            if (tipo_contrato == "Rendimiento compuesto") {
                // rendimiento = inversionUSD * porcentaje2 + rendimiento;

                $("#tablaBody").append(` 
                <tr>
                    <th scope="row">${i + 1}</th>
                    <td>${fecha}</td>
                    <td>${formatterUSD.format(inversionUSD)}</td>
                    <td>${formatterUSD.format(inversionUSD * porcentaje2)}</td>
                    <td>${formatterUSD.format(
                        inversionUSD + inversionUSD * porcentaje2
                    )}</td>
                </tr>
                `);
                inversionMXN = inversionMXN + inversionMXN * porcentaje2;
                inversionUSD = inversionUSD + inversionUSD * porcentaje2;
            } else if (tipo_contrato == "Rendimiento mensual") {
                $("#tablaBody").append(` 
                <tr>
                    <th scope="row">${i + 1}</th>
                    <td>${fecha}</td>
                    <td>${formatterUSD.format(inversionUSD)}</td>
                    <td>${formatterUSD.format(inversionUSD * porcentaje2)}</td>
                </tr>
                `);
            }

            fecha = fecha.split("/").reverse().join("-");
        }

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el contrato</p>',
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#01bbcc",
            confirmButtonText: '<a style="font-family: Poppins">Editar</a>',
            confirmButtonColor: "#198754",
            input: "password",
            showLoaderOnConfirm: true,
            preConfirm: (clave) => {
                $.ajax({
                    type: "GET",
                    url: "/admin/showClave",
                    data: { clave: clave },
                    success: function (result) {
                        if (result == "success") {
                            $("#formModal").modal("show");
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: '<h1 style="font-family: Poppins; font-weight: 700;">Clave incorrecta</h1>',
                                html: '<p style="font-family: Poppins">La clave introducida es incorrecta</p>',
                                confirmButtonText:
                                    '<a style="font-family: Poppins">Aceptar</a>',
                                confirmButtonColor: "#01bbcc",
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                            html: '<p style="font-family: Poppins">Clave es correcta</p>',
                            confirmButtonText:
                                '<a style="font-family: Poppins">Aceptar</a>',
                            confirmButtonColor: "#01bbcc",
                        });
                    },
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (!result.isConfirmed) {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El contrato no se ha editado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    var meses = $("#periodoInput").val();
    $(document).on("keyup", "#porcentajeInput", function (event) {
        $("#periodoInput").val(meses);
        $("#tablaBody").empty();

        $(".cont-tabla").empty();

        var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
            "data-tipo"
        );

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Capital (USD)</th>
                                    <th scope="col">Interés</th>
                                    <th scope="col">Rendimiento</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBody">                        
                            </tbody>
                        </table>
                    </div>
                `);
        } else if (tipo_contrato == "Rendimiento mensual") {
            $(".cont-tabla").append(`
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Capital (USD)</th>
                                    <th scope="col">Interés</th>
                                </tr>
                            </thead>
                            <tbody id="tablaBody">                        
                            </tbody>
                        </table>
                    </div>
                `);
        }

        var cmensual = $("option:selected", "#tipoIdInput").attr(
            "data-cmensual"
        );

        cmensual = parseFloat(cmensual);

        var inversionMXN = $("#inversionInput").val();
        inversionMXN = parseFloat(inversionMXN);

        var inversionUSD = $("#inversionUsInput").val();
        inversionUSD = parseFloat(inversionUSD);

        var fecha = $("#fechaInicioInput").val();
        var fechaFeb = $("#fechaInicioInput").val();
        fechaFeb = fechaFeb.split("-");

        var porcentaje = $("#porcentajeInput").val();

        var cmensual2 = `0.0${cmensual}`;
        cmensual2 = parseFloat(cmensual2);

        var fechaFeb = $("#fechaInicioInput").val();
        fechaFeb = fechaFeb.split("-");
        for (var i = 0; i < meses; i++) {
            fecha = fecha.split("-");

            if (parseInt(fecha[1]) + 1 == 2) {
                if (
                    fechaFeb[2] == 29 ||
                    fechaFeb[2] == 30 ||
                    fechaFeb[2] == 31
                ) {
                    fecha = `28/02/${fecha[0]}`;
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else if (fechaFeb[2] == 31) {
                if (
                    fecha[1] == 3 ||
                    fecha[1] == 5 ||
                    fecha[1] == 8 ||
                    fecha[1] == 10
                ) {
                    fecha = new Date(fecha[0], fecha[1], 30);
                    fecha = formatDate(fecha);
                } else {
                    fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                    fecha = formatDate(fecha);
                }
            } else {
                fecha = new Date(fecha[0], fecha[1], fechaFeb[2]);
                fecha = formatDate(fecha);
            }

            var formatterUSD = new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "USD",
            });

            if (porcentaje.length < 3 && porcentaje.length > 0) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `0.0${porcentaje}`;
                }
            } else if (porcentaje.length == 3) {
                var posicion = porcentaje.indexOf(".");
                if (posicion > 0) {
                    var porcentaje2 = porcentaje.replace(".", "");
                    porcentaje2 = `0.0${porcentaje2}`;
                } else {
                    var porcentaje2 = `${porcentaje}`;
                }
            }
            porcentaje2 = parseFloat(porcentaje2);

            if (tipo_contrato == "Rendimiento compuesto") {
                $("#tablaBody").append(` 
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${fecha}</td>
                        <td>${formatterUSD.format(inversionUSD)}</td>
                        <td>${formatterUSD.format(
                            inversionUSD * porcentaje2
                        )}</td>
                        <td>${formatterUSD.format(
                            inversionUSD + inversionUSD * porcentaje2
                        )}</td>
                    </tr>
                    `);
                inversionMXN = inversionMXN + inversionMXN * porcentaje2;
                inversionUSD = inversionUSD + inversionUSD * porcentaje2;
            } else if (tipo_contrato == "Rendimiento mensual") {
                $("#tablaBody").append(` 
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${fecha}</td>
                        <td>${formatterUSD.format(inversionUSD)}</td>
                        <td>${formatterUSD.format(
                            inversionUSD * porcentaje2
                        )}</td>
                    </tr>
                    `);
            }

            fecha = fecha.split("/").reverse().join("-");
        }
    });
});

$(".table").addClass("compact nowrap w-100");
