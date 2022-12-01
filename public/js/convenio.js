$(document).ready(function () {
    const config = {
        search: true,
    };

    dselect(document.querySelector("#clienteIdInput"), config);
    dselect(document.querySelector("#psIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    let acc = "";
    let dataInversionUS = 0;
    let dataFechaInicio = "";
    let dataFechaFin = "";

    var table = $("#convenio").DataTable({
        ajax: "/admin/showConvenio",
        columns: [
            {
                data: "folio",
            },
            {
                data: "status",
            },
            {
                data: "btn",
            },
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
            lengthMenu: "Mostrar _MENU_ convenios",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún convenio",
            infoEmpty:
                "Mostrando convenios del 0 al 0 de un total de 0 convenios",
            infoFiltered: "(filtrado de un total de _MAX_ convenios)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
        },
    });

    table.on("change", ".status", function () {
        var checked = $(this).is(":checked");

        if (checked) {
            $(this).val("Activado");
        } else {
            $(this).val("Pendiente de activación");
        }

        var id = $(this).data("id");
        var statusValor = $(this).val();
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
        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar status</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el status</p>',
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
                    url: "/admin/validateClaveConvenio",
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.get(
                                "/admin/editStatusConvenio",
                                {
                                    id: id,
                                    status: statusValor,
                                },
                                function () {
                                    Toast.fire({
                                        icon: "success",
                                        title: "Status actualizado",
                                    });

                                    table.ajax.reload(null, false);
                                }
                            );
                        } else {
                            statusClaveIncorrecta();

                            Toast.fire({
                                icon: "error",
                                title: "Clave incorrecta",
                            });
                        }
                    },
                    error: function () {
                        statusClaveIncorrecta();
                        Toast.fire({
                            icon: "error",
                            title: "Clave incorrecta",
                        });
                    },
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (!result.isConfirmed) {
                statusClaveIncorrecta();
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El status del convenio no se ha actualizado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#convenioForm").on("submit", function (e) {
        e.preventDefault();
        var form = $(this).serialize();
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
            success: function () {
                $("#formModal").modal("hide");
                $("#convenioForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Convenio añadido</h1>',
                        html: '<p style="font-family: Poppins">El convenio ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Convenio actualizado</h1>',
                        html: '<p style="font-family: Poppins">El convenio ha sido actualizado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (jqXHR, exception) {
                var validacion = jqXHR.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#convenioForm")[0].reset();

        $("#alertMessage").text("");
        $("#contPagos").empty();

        $("#clienteIdInput").next().children().first().empty();
        $("#clienteIdInput").next().children().first().text("Selecciona...");
        $("#clienteIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", "");
        $("#clienteIdInput").next().children().first().attr("disabled", false);

        $("#psIdInput").next().children().first().empty();
        $("#psIdInput").next().children().first().text("Selecciona...");
        $("#psIdInput").next().children().first().attr("data-dselect-text", "");
        $("#psIdInput").next().children().first().attr("disabled", false);

        acc = "new";
        $("#convenioForm").attr("action", "/admin/addConvenio");
        $("#idInput").val("");

        $("#clienteIdInput").prop("disabled", false);
        $("#psIdInput").prop("disabled", false);
        $("#bancoIdInput").prop("disabled", false);
        $("#fechaInicioInput").prop("readonly", false);
        $("#fechaFinInput").prop("readonly", false);
        $("#cAperturaInput").prop("readonly", false);
        $("#cMensualInput").prop("readonly", false);
        $("#montoInput").prop("readonly", false);
        $("#montoLetraInput").prop("readonly", false);
        $("#statusInput").prop("disabled", false);
        $("#numeroCuentaInput").prop("readonly", false);
        $("#modifySwitch").prop("disabled", false);

        $("#modalTitle").text("Añadir convenio");
        $("#btnSubmit").text("Añadir convenio");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#convenioForm")[0].reset();

        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var folio = $(this).data("folio");
        var nombrecliente = $(this).data("nombrecliente");
        var monto = $(this).data("monto");
        var monto_letra = $(this).data("monto_letra");
        var fecha_inicio = $(this).data("fecha_inicio");
        var fecha_fin = $(this).data("fecha_fin");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var ctrimestral = $(this).data("ctrimestral");
        var status = $(this).data("status");
        var numerocuenta = $(this).data("numerocuenta");
        var ps_id = $(this).data("ps_id");
        var cliente_id = $(this).data("cliente_id");
        var banco_id = $(this).data("banco_id");
        var psnombre = $(this).data("psnombre");

        $("#clienteIdInput").next().children().first().empty();
        $("#clienteIdInput").next().children().first().text(nombrecliente);
        $("#clienteIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", nombrecliente);
        $("#clienteIdInput").next().children().first().attr("disabled", true);

        $("#psIdInput").next().children().first().empty();
        $("#psIdInput").next().children().first().text(psnombre);
        $("#psIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", psnombre);
        $("#psIdInput").next().children().first().attr("disabled", true);

        $("#modalTitle").text(`Vista previa del convenio de: ${nombrecliente}`);

        $("#formModal").modal("show");

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        monto = monto.toString().replace(",", ".");
        $("#montoInput").val(monto);
        $("#montoInput").prop("readonly", true);

        $("#montoLetraInput").val(monto_letra);
        $("#montoLetraInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", true);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", true);

        ctrimestral = ctrimestral.toString().replace(",", ".");
        $("#cTrimestralInput").val(ctrimestral);
        $("#cTrimestralInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#numeroCuentaInput").val(numerocuenta);
        $("#numeroCuentaInput").prop("readonly", true);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", true);

        $("#bancoIdInput").val(banco_id);
        $("#bancoIdInput").prop("disabled", true);

        $("#modifySwitch").prop("disabled", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();

        $("#contPagos").empty();
    });

    $(document).on("click", ".edit", function (e) {
        $("#convenioForm")[0].reset();

        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();

        var id = $(this).data("id");

        var folio = $(this).data("folio");
        var nombrecliente = $(this).data("nombrecliente");
        var monto = $(this).data("monto");
        var monto_letra = $(this).data("monto_letra");
        var fecha_inicio = $(this).data("fecha_inicio");
        var fecha_fin = $(this).data("fecha_fin");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var ctrimestral = $(this).data("ctrimestral");
        var status = $(this).data("status");
        var numerocuenta = $(this).data("numerocuenta");
        var ps_id = $(this).data("ps_id");
        var cliente_id = $(this).data("cliente_id");
        var psnombre = $(this).data("psnombre");
        var banco_id = $(this).data("banco_id");

        if (cmensual.toString().charAt(1) == ",") {
            cmensual = cmensual.replace(",", ".");
        }

        dataInversionUS = $(this).data("monto");
        dataFechaInicio = $(this).data("fecha_inicio");
        dataFechaFin = $(this).data("fecha_fin");

        $("#clienteIdInput").next().children().first().empty();
        $("#clienteIdInput").next().children().first().text(nombrecliente);
        $("#clienteIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", nombrecliente);
        $("#clienteIdInput").next().children().first().attr("disabled", false);

        $("#psIdInput").next().children().first().empty();
        $("#psIdInput").next().children().first().text(psnombre);
        $("#psIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", psnombre);
        $("#psIdInput").next().children().first().attr("disabled", false);

        $("#convenioForm").attr("action", "/admin/editConvenio");

        $("#idInput").val(id);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        monto = monto.toString().replace(",", ".");
        $("#montoInput").val(monto);
        $("#montoInput").prop("readonly", false);

        $("#montoLetraInput").val(monto_letra);
        $("#montoLetraInput").prop("readonly", false);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", false);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", false);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", false);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", false);

        ctrimestral = ctrimestral.toString().replace(",", ".");
        $("#cTrimestralInput").val(ctrimestral);
        $("#cTrimestralInput").prop("readonly", false);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#numeroCuentaInput").val(numerocuenta);
        $("#numeroCuentaInput").prop("readonly", false);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", false);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", false);

        $("#bancoIdInput").val(banco_id);
        $("#bancoIdInput").prop("disabled", false);

        $("#modifySwitch").prop("disabled", false);

        $("#modalTitle").text(`Editar convenio de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar convenio");
        $("#btnCancel").text("Cancelar");

        $("#contPagos").empty();
        var meses = 12;

        if ($("#fechaInicioInput").val()) {
            var fechaInicio = $("#fechaInicioInput").val();
            fechaInicio = new Date(fechaInicio);
            fechaInicio = fechaInicio.addDays(1);

            var fechaFin = new Date(
                fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
            );

            fechaFin = formatDate(fechaFin).split("/").reverse().join("-");

            $("#fechaFinInput").val(fechaFin);
        }
        if (
            $("#montoInput").val() &&
            $("#fechaInicioInput").val() &&
            $("#fechaFinInput").val()
        ) {
            $("#contPagos").empty();

            var capertura = $("#cAperturaInput").val();
            if (capertura.length < 3 && capertura.length > 0) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `0.0${capertura}`;
                }
            } else if (capertura.length == 3) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `${capertura}`;
                }
            }
            capertura = parseFloat(capertura);

            var cmensual = $("#cMensualInput").val();
            if (cmensual.length < 3 && cmensual.length > 0) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `0.0${cmensual}`;
                }
            } else if (cmensual.length == 3) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `${cmensual}`;
                }
            }
            cmensual = parseFloat(cmensual);

            var ctrimestral = $("#cTrimestralInput").val();
            if (ctrimestral.length < 3 && ctrimestral.length > 0) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `0.0${ctrimestral}`;
                }
            } else if (ctrimestral.length == 3) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `${ctrimestral}`;
                }
            }
            ctrimestral = parseFloat(ctrimestral);

            var monto = $("#montoInput").val();
            monto = parseFloat(monto);

            var fecha = $("#fechaInicioInput").val();
            fecha = new Date(fecha);
            fecha = fecha.addDays(1);

            for (var i = 1; i < 13; i++) {
                monto = $("#montoInput").val();
                var monto2 = monto;

                var fechaPago = fecha;
                fechaPago.setMonth(fechaPago.getMonth() + 1);
                var añoPago = fechaPago.getFullYear();
                var mesPago = fechaPago.getMonth();

                fechaPago = lastDay(añoPago, mesPago);
                fechaPago = formatDate(fechaPago);
                fechaPago = fechaPago.split("/").reverse().join("-");

                var fechaLimite = fecha;
                fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                fechaLimite.setDate(10);
                fechaLimite = formatDate(fechaLimite);
                fechaLimite = fechaLimite.split("/").reverse().join("-");

                if (i == 1) {
                    monto = monto * capertura;
                    monto2 = monto2 * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops0" id="seriePagoPS0Input" value="0">
                            <input type="hidden" name="fecha-pagops0" id="fechaPago0Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops0" id="fechaLimite0Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops0" id="montoReintegro0Input" value="${monto.toFixed(
                                2
                            )}">
                            `
                    );
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                } else if (i == 3 || i == 6 || i == 9 || i == 12) {
                    monto2 = monto * ctrimestral;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}trimestral" id="seriePagoPS${i}TrimestralInput" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}trimestral" id="fechaPago${i}TrimestralInput" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}trimestral" id="fechaLimite${i}TrimestralInput" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}trimestral" id="montoReintegro${i}TrimestralInput" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                } else {
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                }

                fecha = new Date(fechaPago);
            }
        }

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar convenio</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el convenio</p>',
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
                    url: "/admin/validateClaveConvenio",
                    data: {
                        clave: clave,
                    },
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
                            html: '<p style="font-family: Poppins">Se ha cancelado la operación</p>',
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
                    html: '<p style="font-family: Poppins">El convenio no se ha editado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar convenio</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar el convenio</p>',
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#01bbcc",
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#dc3545",
            input: "password",
            showLoaderOnConfirm: true,
            preConfirm: (clave) => {
                $.ajax({
                    type: "GET",
                    url: "/admin/validateClaveConvenio",
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteConvenio",
                                {
                                    id: id,
                                },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Convenio eliminado</h1>',
                                        html: '<p style="font-family: Poppins">El convenio se ha eliminado correctamente</p>',
                                        confirmButtonText:
                                            '<a style="font-family: Poppins">Aceptar</a>',
                                        confirmButtonColor: "#01bbcc",
                                    });
                                }
                            );
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: '<h1 style="font-family: Poppins; font-weight: 700;">Clave incorrecta</h1>',
                                html: '<p style="font-family: Poppins">El convenio no se ha eliminado porque la clave es incorrecta</p>',
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
                            html: '<p style="font-family: Poppins">El convenio no se ha eliminado porque la clave no es correcta</p>',
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
                    html: '<p style="font-family: Poppins">El convenio no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("click", ".print", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        window.location.href = "/admin/convenio/verConvenio?id=" + id;
    });

    $("#formModal").on("keyup change", function (event) {
        var meses = 12;

        var target = $(event.target);

        if (target.is("#montoInput")) {
            $("#montoLetraInput").val(numeroALetrasUSD($("#montoInput").val()));

            if (!$("#fechaInicioInput").val()) {
                Swal.fire({
                    icon: "info",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Ingresa la fecha de inicio</h1>',
                    html: '<p style="font-family: Poppins">Por favor, ingresa la fecha de inicio antes de ingresar el monto</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
                $("#montoInput").val("");
            } else {
                //Condicional para refrendo
                if (acc == "edit") {
                    if (
                        $("#statusInput").val() == "Refrendado" &&
                        dataInversionUS != $("#montoInput").val()
                    ) {
                        $("#convenioForm").attr("action", "/admin/addConvenio");
                    }
                }
            }
        }

        if ($("#fechaInicioInput").val()) {
            var fechaInicio = $("#fechaInicioInput").val();
            fechaInicio = new Date(fechaInicio);
            fechaInicio = fechaInicio.addDays(1);

            var fechaFin = new Date(
                fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
            );

            fechaFin = formatDate(fechaFin).split("/").reverse().join("-");

            $("#fechaFinInput").val(fechaFin);
        }

        if (acc == "edit") {
            console.log(dataInversionUS);
            console.log($("#montoInput").val());
            if (
                $("#statusInput").val() == "Refrendado" &&
                dataInversionUS != $("#montoInput").val()
            ) {
                $("#convenioForm").attr("action", "/admin/addConvenio");
            } else {
                $("#convenioForm").attr("action", "/admin/editConvenio");
            }
        }

        if (
            $("#montoInput").val() &&
            $("#fechaInicioInput").val() &&
            $("#fechaFinInput").val()
        ) {
            $("#contPagos").empty();

            var capertura = $("#cAperturaInput").val();
            if (capertura.length < 3 && capertura.length > 0) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `0.0${capertura}`;
                }
            } else if (capertura.length == 3) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `${capertura}`;
                }
            }
            capertura = parseFloat(capertura);

            var cmensual = $("#cMensualInput").val();
            if (cmensual.length < 3 && cmensual.length > 0) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `0.0${cmensual}`;
                }
            } else if (cmensual.length == 3) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `${cmensual}`;
                }
            }
            cmensual = parseFloat(cmensual);

            var ctrimestral = $("#cTrimestralInput").val();
            if (ctrimestral.length < 3 && ctrimestral.length > 0) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `0.0${ctrimestral}`;
                }
            } else if (ctrimestral.length == 3) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `${ctrimestral}`;
                }
            }
            ctrimestral = parseFloat(ctrimestral);

            var monto = $("#montoInput").val();
            monto = parseFloat(monto);

            var fecha = $("#fechaInicioInput").val();
            fecha = new Date(fecha);
            fecha = fecha.addDays(1);

            for (var i = 1; i < 13; i++) {
                monto = $("#montoInput").val();
                var monto2 = monto;

                var fechaPago = fecha;
                fechaPago.setMonth(fechaPago.getMonth() + 1);
                var añoPago = fechaPago.getFullYear();
                var mesPago = fechaPago.getMonth();

                fechaPago = lastDay(añoPago, mesPago);
                fechaPago = formatDate(fechaPago);
                fechaPago = fechaPago.split("/").reverse().join("-");

                var fechaLimite = fecha;
                fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                fechaLimite.setDate(10);
                fechaLimite = formatDate(fechaLimite);
                fechaLimite = fechaLimite.split("/").reverse().join("-");

                if (i == 1) {
                    monto = monto * capertura;
                    monto2 = monto2 * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops0" id="seriePagoPS0Input" value="0">
                            <input type="hidden" name="fecha-pagops0" id="fechaPago0Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops0" id="fechaLimite0Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops0" id="montoReintegro0Input" value="${monto.toFixed(
                                2
                            )}">
                            `
                    );
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                } else if (i == 3 || i == 6 || i == 9 || i == 12) {
                    monto2 = monto * ctrimestral;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}trimestral" id="seriePagoPS${i}TrimestralInput" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}trimestral" id="fechaPago${i}TrimestralInput" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}trimestral" id="fechaLimite${i}TrimestralInput" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}trimestral" id="montoReintegro${i}TrimestralInput" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                } else {
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                }

                fecha = new Date(fechaPago);
            }
        }

        //condicional de refrendo con nuevas fechas
        if (target.is("#statusInput") && event.type == "change") {
            if ($("#statusInput").val() == "Refrendado") {
                if (acc == "new") {
                    dataInversionUS = $("#monto").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contPagos").empty();
                $("#contMemoCan").addClass("d-none");

                var capertura = $("#cAperturaInput").val();
                if (capertura.length < 3 && capertura.length > 0) {
                    var posicion = capertura.indexOf(".");
                    if (posicion > 0) {
                        capertura = capertura.replace(".", "");
                        capertura = `0.0${capertura}`;
                    } else {
                        var capertura = `0.0${capertura}`;
                    }
                } else if (capertura.length == 3) {
                    var posicion = capertura.indexOf(".");
                    if (posicion > 0) {
                        capertura = capertura.replace(".", "");
                        capertura = `0.0${capertura}`;
                    } else {
                        var capertura = `${capertura}`;
                    }
                }
                capertura = parseFloat(capertura);

                var cmensual = $("#cMensualInput").val();
                if (cmensual.length < 3 && cmensual.length > 0) {
                    var posicion = cmensual.indexOf(".");
                    if (posicion > 0) {
                        cmensual = cmensual.replace(".", "");
                        cmensual = `0.0${cmensual}`;
                    } else {
                        var cmensual = `0.0${cmensual}`;
                    }
                } else if (cmensual.length == 3) {
                    var posicion = cmensual.indexOf(".");
                    if (posicion > 0) {
                        cmensual = cmensual.replace(".", "");
                        cmensual = `0.0${cmensual}`;
                    } else {
                        var cmensual = `${cmensual}`;
                    }
                }
                cmensual = parseFloat(cmensual);

                var ctrimestral = $("#cTrimestralInput").val();
                if (ctrimestral.length < 3 && ctrimestral.length > 0) {
                    var posicion = ctrimestral.indexOf(".");
                    if (posicion > 0) {
                        ctrimestral = ctrimestral.replace(".", "");
                        ctrimestral = `0.0${ctrimestral}`;
                    } else {
                        var ctrimestral = `0.0${ctrimestral}`;
                    }
                } else if (ctrimestral.length == 3) {
                    var posicion = ctrimestral.indexOf(".");
                    if (posicion > 0) {
                        ctrimestral = ctrimestral.replace(".", "");
                        ctrimestral = `0.0${ctrimestral}`;
                    } else {
                        var ctrimestral = `${ctrimestral}`;
                    }
                }
                ctrimestral = parseFloat(ctrimestral);

                var monto = $("#montoInput").val();
                monto = parseFloat(monto);

                $("#fechaInicioInput").val(dataFechaFin);
                var fecha = dataFechaFin;
                fecha = new Date(fecha);
                fecha = fecha.addDays(1);

                var fechaInicio = $("#fechaInicioInput").val();
                fechaInicio = new Date(fechaInicio);
                fechaInicio = fechaInicio.addDays(1);

                var fechaInicioRef = $("#fechaInicioInput").val();
                fechaInicioRef = new Date(fechaInicioRef);
                fechaInicioRef = fechaInicioRef.addDays(1);

                var fechaFinRef = new Date(
                    fechaInicioRef.setMonth(
                        fechaInicioRef.getMonth() + parseInt(meses)
                    )
                );

                fechaFinRef = formatDate(fechaFinRef)
                    .split("/")
                    .reverse()
                    .join("-");

                $("#fechaFinInput").val(fechaFinRef);

                for (var i = 1; i < 13; i++) {
                    monto = $("#montoInput").val();
                    var monto2 = monto;

                    var fechaPago = fecha;
                    fechaPago.setMonth(fechaPago.getMonth() + 1);
                    var añoPago = fechaPago.getFullYear();
                    var mesPago = fechaPago.getMonth();

                    fechaPago = lastDay(añoPago, mesPago);
                    fechaPago = formatDate(fechaPago);
                    fechaPago = fechaPago.split("/").reverse().join("-");

                    var fechaLimite = fecha;
                    fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                    fechaLimite.setDate(10);
                    fechaLimite = formatDate(fechaLimite);
                    fechaLimite = fechaLimite.split("/").reverse().join("-");

                    if (i == 1) {
                        monto = monto * capertura;
                        monto2 = monto2 * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops0" id="seriePagoPS0Input" value="0">
                                <input type="hidden" name="fecha-pagops0" id="fechaPago0Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops0" id="fechaLimite0Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops0" id="montoReintegro0Input" value="${monto.toFixed(
                                    2
                                )}">
                                `
                        );
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto2.toFixed(
                                2
                            )}">
                                `
                        );
                    } else if (i == 3 || i == 6 || i == 9 || i == 12) {
                        monto2 = monto * ctrimestral;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}trimestral" id="seriePagoPS${i}TrimestralInput" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}trimestral" id="fechaPago${i}TrimestralInput" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}trimestral" id="fechaLimite${i}TrimestralInput" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}trimestral" id="montoReintegro${i}TrimestralInput" value="${monto2.toFixed(
                                2
                            )}">
                                `
                        );
                        monto = monto * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                                2
                            )}">
                                `
                        );
                    } else {
                        monto = monto * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                                2
                            )}">
                                `
                        );
                    }

                    fecha = new Date(fechaPago);
                }
            } else if ($("#statusInput").val() == "Activado") {
                if (acc == "new") {
                    dataInversionMXN = $("#inversionInput").val();
                    dataInversionMXN = parseFloat(dataInversionMXN);

                    dataInversionUS = $("#montoInput").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contPagos").empty();
                $("#contMemoCan").addClass("d-none");

                var capertura = $("#cAperturaInput").val();
                if (capertura.length < 3 && capertura.length > 0) {
                    var posicion = capertura.indexOf(".");
                    if (posicion > 0) {
                        capertura = capertura.replace(".", "");
                        capertura = `0.0${capertura}`;
                    } else {
                        var capertura = `0.0${capertura}`;
                    }
                } else if (capertura.length == 3) {
                    var posicion = capertura.indexOf(".");
                    if (posicion > 0) {
                        capertura = capertura.replace(".", "");
                        capertura = `0.0${capertura}`;
                    } else {
                        var capertura = `${capertura}`;
                    }
                }
                capertura = parseFloat(capertura);

                var cmensual = $("#cMensualInput").val();
                if (cmensual.length < 3 && cmensual.length > 0) {
                    var posicion = cmensual.indexOf(".");
                    if (posicion > 0) {
                        cmensual = cmensual.replace(".", "");
                        cmensual = `0.0${cmensual}`;
                    } else {
                        var cmensual = `0.0${cmensual}`;
                    }
                } else if (cmensual.length == 3) {
                    var posicion = cmensual.indexOf(".");
                    if (posicion > 0) {
                        cmensual = cmensual.replace(".", "");
                        cmensual = `0.0${cmensual}`;
                    } else {
                        var cmensual = `${cmensual}`;
                    }
                }
                cmensual = parseFloat(cmensual);

                var ctrimestral = $("#cTrimestralInput").val();
                if (ctrimestral.length < 3 && ctrimestral.length > 0) {
                    var posicion = ctrimestral.indexOf(".");
                    if (posicion > 0) {
                        ctrimestral = ctrimestral.replace(".", "");
                        ctrimestral = `0.0${ctrimestral}`;
                    } else {
                        var ctrimestral = `0.0${ctrimestral}`;
                    }
                } else if (ctrimestral.length == 3) {
                    var posicion = ctrimestral.indexOf(".");
                    if (posicion > 0) {
                        ctrimestral = ctrimestral.replace(".", "");
                        ctrimestral = `0.0${ctrimestral}`;
                    } else {
                        var ctrimestral = `${ctrimestral}`;
                    }
                }
                ctrimestral = parseFloat(ctrimestral);

                var monto = $("#montoInput").val();
                monto = parseFloat(monto);

                $("#fechaInicioInput").val(dataFechaInicio);
                var fecha = $("#fechaInicioInput").val();
                fecha = new Date(fecha);
                fecha = fecha.addDays(1);

                var fechaInicioRef = $("#fechaInicioInput").val();
                fechaInicioRef = new Date(fechaInicioRef);
                fechaInicioRef = fechaInicioRef.addDays(1);

                var fechaFinRef = new Date(
                    fechaInicioRef.setMonth(
                        fechaInicioRef.getMonth() + parseInt(meses)
                    )
                );

                fechaFinRef = formatDate(fechaFinRef)
                    .split("/")
                    .reverse()
                    .join("-");

                $("#fechaFinInput").val(fechaFinRef);

                for (var i = 1; i < 13; i++) {
                    monto = $("#montoInput").val();
                    var monto2 = monto;

                    var fechaPago = fecha;
                    fechaPago.setMonth(fechaPago.getMonth() + 1);
                    var añoPago = fechaPago.getFullYear();
                    var mesPago = fechaPago.getMonth();

                    fechaPago = lastDay(añoPago, mesPago);
                    fechaPago = formatDate(fechaPago);
                    fechaPago = fechaPago.split("/").reverse().join("-");

                    var fechaLimite = fecha;
                    fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                    fechaLimite.setDate(10);
                    fechaLimite = formatDate(fechaLimite);
                    fechaLimite = fechaLimite.split("/").reverse().join("-");

                    if (i == 1) {
                        monto = monto * capertura;
                        monto2 = monto2 * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops0" id="seriePagoPS0Input" value="0">
                                <input type="hidden" name="fecha-pagops0" id="fechaPago0Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops0" id="fechaLimite0Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops0" id="montoReintegro0Input" value="${monto.toFixed(
                                    2
                                )}">
                                `
                        );
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto2.toFixed(
                                2
                            )}">
                                `
                        );
                    } else if (i == 3 || i == 6 || i == 9 || i == 12) {
                        monto2 = monto * ctrimestral;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}trimestral" id="seriePagoPS${i}TrimestralInput" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}trimestral" id="fechaPago${i}TrimestralInput" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}trimestral" id="fechaLimite${i}TrimestralInput" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}trimestral" id="montoReintegro${i}TrimestralInput" value="${monto2.toFixed(
                                2
                            )}">
                                `
                        );
                        monto = monto * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                                2
                            )}">
                                `
                        );
                    } else {
                        monto = monto * cmensual;
                        $("#contPagos").append(
                            `
                                <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                                <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                                <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                                <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                                2
                            )}">
                                `
                        );
                    }

                    fecha = new Date(fechaPago);
                }
            } else if ($("#statusInput").val() == "Cancelado") {
                $("#contMemoCan").removeClass("d-none");
            } else {
                $("#contMemoCan").addClass("d-none");
            }
        }
    });

    $("#clienteIdInput").change(function () {
        var cliente_id = $("#clienteIdInput").val();
        $.get({
            type: "GET",
            url: "/admin/getFolioConvenio",
            data: {
                id: cliente_id,
                opc: 1,
            },
            success: function (res) {
                var cliente_num = res;
                var new_num = "";

                var current_num = $("#folioInput").val();
                var current_num = current_num.split("-");

                current_num.forEach(function (element, index) {
                    if (index == 0) {
                        new_num = element + "-" + new_num;
                    }
                    if (index == 1) {
                        new_num = new_num + cliente_num;
                    }
                });

                $("#folioInput").val(new_num);
            },
            error: function (res) {
                console.log(res);
            },
        });
    });

    $("#psIdInput").change(function () {
        var ps_id = $("#psIdInput").val();
        $.get({
            type: "GET",
            url: "/admin/getFolioConvenio",
            data: {
                id: ps_id,
                opc: 2,
            },
            success: function (res) {
                var oficina_num = res;
                var new_num = "";

                var current_num = $("#folioInput").val();
                var current_num = current_num.split("-");

                current_num.forEach(function (element, index, array) {
                    if (index == 0) {
                        new_num = oficina_num + "-";
                    } else {
                        if (index === array.length - 1) {
                            new_num = new_num + element;
                        } else {
                            new_num = new_num + element + "-";
                        }
                    }
                });

                $("#folioInput").val(new_num);
            },
            error: function (res) {
                console.log(res);
            },
        });
    });

    function statusClaveIncorrecta() {
        var estatus = $("#convenioStatusInput").data("status");

        if (estatus == "Activado") {
            $("#convenioStatusInput").prop("checked", true);
            $("#convenioStatusInput").val("Activado");
        } else {
            $("#convenioStatusInput").prop("checked", false);
            $("#convenioStatusInput").val("Pendiente de activación");
        }
    }

    $("#folioInput").prop("readonly", true);

    $("#modifySwitch").change(function () {
        if ($("#modifySwitch").prop("checked") == true) {
            $("#folioInput").prop("readonly", false);
        } else {
            $("#folioInput").prop("readonly", true);
        }
    });
});

$(".table").addClass("compact nowrap w-100");
