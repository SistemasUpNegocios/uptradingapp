function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(".image-upload-wrap").hide();

            $(".file-upload-image").attr("src", e.target.result);
            $(".file-upload-content").show();

            $(".image-title").html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $(".file-upload-input").replaceWith($(".file-upload-input").clone());
    $(".file-upload-content").hide();
    $(".image-upload-wrap").show();
}
$(".image-upload-wrap").bind("dragover", function () {
    $(".image-upload-wrap").addClass("image-dropping");
});
$(".image-upload-wrap").bind("dragleave", function () {
    $(".image-upload-wrap").removeClass("image-dropping");
});

$(document).ready(function () {
    let acc = "";

    var table = $("#pagops").DataTable({
        ajax: "/admin/showPS",
        columns: [
            {
                data: "codigoPs",
            },
            {
                data: "psnombre",
            },
            {
                data: "enlace",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#pagoPSForm").on("submit", function (e) {
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
                $("#pagoPSForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Pago a PS actualizado</h1>',
                        html: '<p style="font-family: Poppins">El pago a PS ha sido actualizado correctamente</p>',
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

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var contrato = $(this).data("contrato");
        var serie = $(this).data("serie");
        var fecha_pago = $(this).data("fecha_pago");
        var fecha_limite = $(this).data("fecha_limite");
        var fecha_pagado = $(this).data("fecha_pagado");
        var pago = $(this).data("pago");
        var status = $(this).data("status");
        var tipo_pago = $(this).data("tipo_pago");
        var memo = $(this).data("memo");
        var psnombre = $(this).data("psnombre");
        var comprobante = $(this).data("comprobante");

        $("#contCalcular").hide();

        if (comprobante == "") {
            $(".file-upload").hide();
        } else {
            $(".file-upload").show();
            $("#fotoInput").removeAttr("required");
            $("#currentPictureInput").val(comprobante);
            $(".image-upload-wrap").hide();
            $(".file-upload-image").attr(
                "src",
                "/img/comprobantes/pagops/" + comprobante
            );
            $(".file-upload-content").show();
            $(".image-title-wrap").hide();
        }

        $("#modalTitle").text(
            `Vista previa de pago a ${psnombre} del contrato ${contrato} al mes ${serie}`
        );

        $("#formModal").modal("show");

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", true);

        $("#serieInput").val(serie);
        $("#serieInput").prop("readonly", true);

        $("#fechaPagoInput").val(fecha_pago);
        $("#fechaPagoInput").prop("readonly", true);

        $("#fechaLimiteInput").val(fecha_limite);
        $("#fechaLimiteInput").prop("readonly", true);

        $("#fechaPagadoInput").val(fecha_pagado);
        $("#fechaPagadoInput").prop("readonly", true);

        $("#pagoInput").val(pago);
        $("#pagoInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#tipoPagoInput").val(tipo_pago);
        $("#tipoPagoInput").prop("disabled", true);

        $("#memoInput").val(memo);
        $("#memoInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var contrato = $(this).data("contrato");
        var serie = $(this).data("serie");
        var fecha_pago = $(this).data("fecha_pago");
        var fecha_limite = $(this).data("fecha_limite");
        var fecha_pagado = $(this).data("fecha_pagado");
        var pago = $(this).data("pago");
        var status = $(this).data("status");
        var tipo_pago = $(this).data("tipo_pago");
        var memo = $(this).data("memo");
        var psnombre = $(this).data("psnombre");
        var comprobante = $(this).data("comprobante");

        if (comprobante == "") {
            $(".file-upload").show();
            $(".image-upload-wrap").show();
            $(".file-upload-image").attr("src", "");
            $(".file-upload-content").hide();
        } else {
            $("#fotoInput").removeAttr("required");
            $("#currentPictureInput").val(comprobante);
            $(".image-upload-wrap").hide();
            $(".file-upload-image").attr(
                "src",
                "/img/comprobantes/pagops/" + comprobante
            );
            $(".file-upload-content").show();
            $(".image-title-wrap").show();
        }

        $("#formModal").modal("show");
        $("#pagoPSForm").attr("action", "/admin/editPagosPS");

        $("#idInput").val(id);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", true);

        $("#serieInput").val(serie);
        $("#serieInput").prop("readonly", true);

        $("#fechaPagoInput").val(fecha_pago);
        $("#fechaPagoInput").prop("readonly", true);

        $("#fechaLimiteInput").val(fecha_limite);
        $("#fechaLimiteInput").prop("readonly", true);

        $("#fechaPagadoInput").val(fecha_pagado);
        $("#fechaPagadoInput").prop("readonly", false);

        $("#pagoInput").val(pago);
        $("#pagoInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#memoInput").val(memo);
        $("#memoInput").prop("readonly", true);

        $("#tipoPagoInput").val(tipo_pago);
        $("#tipoPagoInput").prop("disabled", false);

        $("#modalTitle").text(`Editar pago PS: ${contrato}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar pago PS");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", "#seeContrato", function (e) {
        acc = "view";
        e.preventDefault();

        var nombrecliente = $(this).data("nombrecliente");
        var operador = $(this).data("operador");
        var lugarfirma = $(this).data("lugarfirma");
        var fechainicio = $(this).data("fecha");
        var fecharen = $(this).data("fecharen");
        var fechapag = $(this).data("fechapag");
        var periodo = $(this).data("periodo");
        var contrato = $(this).data("contrato");
        var psid = $(this).data("psid");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var clienteid = $(this).data("clienteid");
        var tipoid = $(this).data("tipoid");
        var porcentaje = $(this).data("porcentaje");
        var modeloid = $(this).data("modeloid");
        var inversion = $(this).data("inversion");
        var inversionus = $(this).data("inversionus");
        var tipocambio = $(this).data("tipocambio");
        var inversionlet = $(this).data("inversionlet");
        var inversionletus = $(this).data("inversionletus");
        var fecharein = $(this).data("fecharein");
        var statusrein = $(this).data("statusrein");
        var memorein = $(this).data("memorein");
        var status = $(this).data("status");

        $("#modalTitle").text(`Vista previa del contrato de: ${nombrecliente}`);

        $("#contratoModal").modal("show");

        $("#operadorInput").val(operador);
        $("#operadorInput").prop("readonly", true);

        $("#lugarFirmaInput").val(lugarfirma);
        $("#lugarFirmaInput").prop("readonly", true);

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaRenInput").val(fecharen);
        $("#fechaRenInput").prop("readonly", true);

        $("#fechaPagInput").val(fechapag);
        $("#fechaPagInput").prop("readonly", true);

        $("#periodoInput").val(periodo);
        $("#periodoInput").prop("disabled", true);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", true);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", true);

        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", true);

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        $("#porcentajeInput").val(porcentaje);
        $("#porcentajeInput").prop("readonly", true);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", true);

        $("#inversionInput").val(inversion);
        $("#inversionInput").prop("readonly", true);

        $("#inversionUsInput").val(inversionus);
        $("#inversionUsInput").prop("readonly", true);

        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", true);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", true);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", true);

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", true);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", true);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", true);

        $("#statusContratoInput").val(status);
        $("#statusContratoInput").prop("disabled", true);

        $(".status_reintegro").show();
        $(".memo_reintegro").show();

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", "#seePagos", function (e) {
        e.preventDefault();

        table.destroy();

        var tabla = $("#pagops");
        tabla.empty();
        tabla.append(
            `
                <thead>
                    <tr>
                        <th data-priority="0" scope="col"># contrato</th>
                        <th data-priority="0" scope="col">Cliente</th>
                        <th data-priority="0" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="amortizacionBody" style="vertical-align: middle;"></tbody>
            `
        );

        let id = $(this).data("psid");
        let psnombre = $(this).data("psnombre");

        $(".titlePage").text(`Clientes del PS ${psnombre}`);

        table = $("#pagops").DataTable({
            ajax: {
                url: "/admin/showContratosPS",
                type: "GET",
                data: {
                    psid: id,
                },
            },
            columns: [
                {
                    data: "contrato",
                },
                {
                    data: "cliente_nombre",
                },
                {
                    data: "buttons",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
            },
        });

        $("#btnVolver").css("display", "inline-block");
        $("#btnVolver").empty();
        $("#btnVolver").append(
            '<i class="bi-chevron-left me-1"></i>Ver todos los PS'
        );

        $(document).on("click", "#btnVolver", function (e) {
            $(".titlePage").text(`Gestión de pagos a PS`);

            $("#btnVolver").css("display", "none");
            e.preventDefault();

            table.destroy();

            var tabla = $("#pagops");
            tabla.empty();
            tabla.append(
                `
                    <thead>
                        <tr>
                        <th data-priority="0" scope="col">Código PS</th>
                            <th data-priority="0" scope="col">Nombre completo</th>
                            <th data-priority="0" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="amortizacionBody" style="vertical-align: middle;"></tbody>
                `
            );

            table = $("#pagops").DataTable({
                ajax: "/admin/showPS",
                columns: [
                    {
                        data: "codigoPs",
                    },
                    {
                        data: "psnombre",
                    },
                    {
                        data: "enlace",
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
                    info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
                },
            });
        });
    });

    $(document).on("click", "#seePagosPS", function (e) {
        e.preventDefault();

        var contratoid = $(this).data("contratoid");
        var psnombre = $(this).data("psnombre");
        var psid = $(this).data("psid");

        var tabla = $("#pagops");

        var formatearCantidad = new Intl.NumberFormat("es-US", {
            style: "currency",
            currency: "USD",
            minimumFractionDigits: 2,
        });

        const formatearFecha = (fecha) => {
            return fecha.split(" ")[0].split("-").reverse().join("/");
        };

        $.ajax({
            type: "POST",
            url: "/admin/existPagosPS",
            data: {
                contratoid: contratoid,
            },
            success: function (data) {
                table.destroy();

                tabla.empty();

                tabla.append(`
                <thead>
                    <tr>
                        <th data-priority="0" scope="col">Mes</th>
                        <th data-priority="0" scope="col">Fecha de pago</th>
                        <th data-priority="0" scope="col">Pago (USD)</th>
                        <th data-priority="0" scope="col">Status del pago</th>
                        <th data-priority="0" scope="col">Tipo de pago</th>
                        <th data-priority="0" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="pagoPSBody">
                </tbody>
                `);

                table = $("#pagops").DataTable({
                    ajax: {
                        url: "/admin/showPagosPS",
                        data: {
                            contratoid: contratoid,
                        },
                    },

                    columns: [
                        {
                            data: "serie",
                        },
                        {
                            data: "fecha_pago",
                            render: function (data) {
                                return formatearFecha(data);
                            },
                        },
                        {
                            data: "pago",
                            render: function (data) {
                                return formatearCantidad.format(data);
                            },
                        },
                        {
                            data: "status",
                        },
                        {
                            data: "tipo_pago",
                        },
                        {
                            data: "acciones",
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
                    lengthMenu: [
                        [3, 6, 12, 18, 24, -1],
                        [3, 6, 12, 18, 24, "Todo"],
                    ],
                    pageLength: 12,
                    language: {
                        processing: "Procesando...",
                        lengthMenu: "Mostrar _MENU_ amortizaciones",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "No se ha registrado ninguna amortizacion",
                        infoEmpty:
                            "Mostrando amortizaciones del 0 al 0 de un total de 0 amortizaciones",
                        infoFiltered:
                            "(filtrado de un total de _MAX_ amortizaciones)",
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
                        info: "Mostrando de _START_ a _END_ de _TOTAL_ amortizaciones",
                    },
                });

                $("#btnVolver").css("display", "inline-block");
                $("#btnVolver").empty();
                $("#btnVolver").append(
                    '<i class="bi-chevron-left me-1"></i>Volver a ver los contratos'
                );

                $(document).on("click", "#btnVolver", function (e) {
                    $(".titlePage").text(`Clientes del PS ${psnombre}`);

                    $("#btnVolver").css("display", "none");
                    e.preventDefault();

                    table.destroy();

                    tabla.empty();

                    tabla.append(`
                    <thead>
                        <tr>
                            <th data-priority="0" scope="col"># contrato</th>
                            <th data-priority="0" scope="col">clientes</th>
                            <th data-priority="0" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="amortizacionBody" style="vertical-align: middle;">
                    </tbody>
                    `);

                    table = $("#pagops").DataTable({
                        ajax: {
                            url: "/admin/showContratosPS",
                            type: "GET",
                            data: {
                                psid: psid,
                            },
                        },
                        columns: [
                            {
                                data: "contrato",
                            },
                            {
                                data: "cliente_nombre",
                            },
                            {
                                data: "buttons",
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
                            lengthMenu: "Mostrar _MENU_ contratos",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "No se ha registrado ningún contrato",
                            infoEmpty:
                                "Mostrando contratos del 0 al 0 de un total de 0 contratos",
                            infoFiltered:
                                "(filtrado de un total de _MAX_ contratos)",
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
                                fillHorizontal:
                                    "Rellenar celdas horizontalmente",
                                fillVertical:
                                    "Rellenar celdas verticalmentemente",
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
                            info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
                        },
                    });

                    $("#btnVolver").css("display", "inline-block");
                    $("#btnVolver").empty();
                    $("#btnVolver").append(
                        '<i class="bi-chevron-left me-1"></i>Ver todos los PS'
                    );

                    $(".titlePage").text(`Clientes del PS ${psnombre}`);

                    $(document).on("click", "#btnVolver", function (e) {
                        $(".titlePage").text(`Gestión de pagos a PS`);
                        $("#btnVolver").css("display", "none");

                        e.preventDefault();

                        table.destroy();

                        var tabla = $("#pagops");
                        tabla.empty();
                        tabla.append(
                            `
                                <thead>
                                    <tr>
                                        <th data-priority="0" scope="col">Código PS</th>
                                        <th data-priority="0" scope="col">Nombre completo</th>
                                        <th data-priority="0" scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="amortizacionBody" style="vertical-align: middle;"></tbody>
                            `
                        );

                        table = $("#pagops").DataTable({
                            ajax: "/admin/showPS",
                            columns: [
                                {
                                    data: "codigoPs",
                                },
                                {
                                    data: "psnombre",
                                },
                                {
                                    data: "enlace",
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
                                lengthMenu: "Mostrar _MENU_ contratos",
                                zeroRecords: "No se encontraron resultados",
                                emptyTable:
                                    "No se ha registrado ningún contrato",
                                infoEmpty:
                                    "Mostrando contratos del 0 al 0 de un total de 0 contratos",
                                infoFiltered:
                                    "(filtrado de un total de _MAX_ contratos)",
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
                                    fillHorizontal:
                                        "Rellenar celdas horizontalmente",
                                    fillVertical:
                                        "Rellenar celdas verticalmentemente",
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
                                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
                            },
                        });
                    });
                });

                $.ajax({
                    type: "GET",
                    url: "/admin/showPagosPS",
                    data: {
                        contratoid: contratoid,
                    },
                    success: function (data) {
                        var contrato = data.data[0].contrato;

                        $(".titlePage").text(`Contrato ${contrato}`);
                    },
                    error: function () {
                        console.log("Error");
                    },
                });
            },
            error: function () {
                console.log("Error");
            },
        });
    });
});

$(".table").addClass("compact nowrap w-100");
