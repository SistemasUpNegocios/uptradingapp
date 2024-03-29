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
    let id;

    var table = $("#pagopsconvenio").DataTable({
        ajax: "/admin/showPSConvenio",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#contCalcular").hide();

    $("#pagoPSConvenioForm").on("submit", function (e) {
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
                $("#pagoPSConvenioForm")[0].reset();
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

        var convenio = $(this).data("convenio");
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
            $(".image-upload-wrap").show();
            $(".file-upload-image").attr("src", "");
            $(".file-upload-content").hide();
        } else {
            $("#fotoInput").removeAttr("required");
            $("#currentPictureInput").val(comprobante);
            $(".image-upload-wrap").hide();
            $(".file-upload-image").attr(
                "src",
                "/img/comprobantes/pagopsconvenio" + "/" + comprobante
            );
            $(".file-upload-content").show();
            $(".remove-image").hide();
        }

        $("#modalTitle").text(
            `Vista previa de pago a ${psnombre} del convenio con folio ${convenio} al mes ${serie}`
        );

        $("#formModal").modal("show");

        $("#convenioInput").val(convenio);
        $("#convenioInput").prop("readonly", true);

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

        $("#statusInputModal").val(status);
        $("#statusInputModal").prop("disabled", true);

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

        var convenio = $(this).data("convenio");
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

        $("#fotoInput").removeAttr("required");
        $("#contCalcular").hide();

        $(".file-upload").show();

        if (memo == "Comisión por rédito trimestral") {
            $("#contCalcular").show();
        } else {
            $("#contCalcular").hide();
        }

        $("#formModal").on("keyup", function (event) {
            var target = $(event.target);
            var montoactual = $("#montoActualInput").val();
            var porcentaje = $("#pTrimestralInput").val();
            var pago = 0;

            if (target.is("#montoActualInput")) {
                if ($("#pTrimestralInput").val()) {
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

                    pago = montoactual * porcentaje2;

                    $("#pagoInput").val(pago.toFixed(2));
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Ingresa el porcentaje trimestral</h1>',
                        html: '<p style="font-family: Poppins">Por favor, ingresa el porcentaje trimestral para calcular el pago</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            } else if (target.is("#pTrimestralInput")) {
                if ($("#montoActualInput").val()) {
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

                    pago = montoactual * porcentaje2;

                    $("#pagoInput").val(pago.toFixed(2));
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Ingresa el monto actual</h1>',
                        html: '<p style="font-family: Poppins">Por favor, ingresa el monto para calcular el pago</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            }
        });

        if (comprobante == "") {
            $(".image-upload-wrap").show();
            $(".file-upload-image").attr("src", "");
            $(".file-upload-content").hide();
        } else {
            // $('.file-upload').hide();
            $("#fotoInput").removeAttr("required");
            $("#currentPictureInput").val(comprobante);
            $(".image-upload-wrap").hide();
            $(".file-upload-image").attr(
                "src",
                "/img/comprobantes/pagopsconvenio" + "/" + comprobante
            );
            $(".file-upload-content").show();
            $(".remove-image").show();
        }

        $("#formModal").modal("show");
        $("#pagoPSConvenioForm").attr("action", "/admin/editPagosPSConvenio");

        $("#idInput").val(id);

        $("#convenioInput").val(convenio);
        $("#convenioInput").prop("readonly", true);

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

        $("#tipoPagoInput").val(tipo_pago);
        $("#tipoPagoInput").prop("disabled", false);

        $("#memoInput").val(memo);
        $("#memoInput").prop("readonly", true);

        $("#modalTitle").text(
            `Editar pago a ${psnombre} del convenio con folio ${convenio} al mes ${serie}`
        );

        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar pago PS");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", "#seePagosPS", function (e) {
        e.preventDefault();

        var convenioid = $(this).data("convenioid");
        var psnombre = $(this).data("psnombre");

        var tabla = $("#pagopsconvenio");

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
            url: "/admin/existPagosPSConvenio",
            data: {
                convenioid: convenioid,
            },
            success: function (data) {
                table.destroy();

                tabla.empty();

                tabla.append(`
                <thead>
                    <tr>
                        <th data-priority="0" scope="col">Mes</th>
                        <th data-priority="0" scope="col">Fecha límite de pago</th>
                        <th data-priority="0" scope="col">Motivo de pago</th>
                        <th data-priority="0" scope="col">Pago (USD)</th>
                        <th data-priority="0" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="pagoPSBody">
                </tbody>
                `);

                table = $("#pagopsconvenio").DataTable({
                    ajax: {
                        url: "/admin/showPagosPSConvenio",
                        data: {
                            convenioid: convenioid,
                        },
                    },

                    columns: [
                        {
                            data: "serie",
                        },
                        {
                            data: "fecha_limite",
                            render: function (data) {
                                return formatearFecha(data);
                            },
                        },
                        {
                            data: "memo",
                        },
                        {
                            data: "pago",
                            render: function (data) {
                                return formatearCantidad.format(data);
                            },
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
                    pageLength: 18,
                    language: {
                        processing: "Procesando...",
                        lengthMenu: "Mostrar _MENU_ pagos a PS",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "No se ha registrado ningún pago a PS",
                        infoEmpty:
                            "Mostrando pagos a PS del 0 al 0 de un total de 0 pagos a PS",
                        infoFiltered:
                            "(filtrado de un total de _MAX_ pagos a PS)",
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
                        info: "Mostrando de _START_ a _END_ de _TOTAL_ pagos a PS",
                    },
                });

                $("#btnVolver").css("display", "inline-block");

                $(document).on("click", "#btnVolver", function (e) {
                    $(".titlePage").text(`Clientes del PS ${psnombre}`);

                    $("#btnVolver").css("display", "none");
                    e.preventDefault();

                    table.destroy();

                    tabla.empty();

                    tabla.append(`
                        <thead>
                            <tr>
                                <th data-priority="0" scope="col"># convenio</th>
                                <th data-priority="0" scope="col">Cliente</th>
                                <th data-priority="0" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="amortizacionBody" style="vertical-align: middle;">
                        </tbody>
                    `);

                    table = $("#pagopsconvenio").DataTable({
                        ajax: {
                            url: "/admin/showContratosPSConvenio",
                            type: "GET",
                            data: {
                                psid: id,
                            },
                        },
                        columns: [
                            {
                                data: "convenio",
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
                            lengthMenu: "Mostrar _MENU_ convenios",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "No se ha registrado ningún convenio",
                            infoEmpty:
                                "Mostrando convenios del 0 al 0 de un total de 0 convenios",
                            infoFiltered:
                                "(filtrado de un total de _MAX_ convenios)",
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
                            info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
                        },
                    });
                });

                $.ajax({
                    type: "GET",
                    url: "/admin/showPagosPSConvenio",
                    data: {
                        convenioid: convenioid,
                    },
                    success: function (data) {
                        var convenio = data.data[0].convenio;
                        var cliente = data.data[0].clientenombre;
                        var ps = data.data[0].psnombre;

                        $(".titlePage").text(
                            `Pagos a ${ps} por el convenio ${convenio} del cliente ${cliente}`
                        );

                        $("#btnVolver").empty();
                        $("#btnVolver").append(
                            '<i class="bi-chevron-left me-1"></i>Volver a ver los convenios'
                        );
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

    $(document).on("click", "#seePagos", function (e) {
        e.preventDefault();

        table.destroy();

        var tabla = $("#pagopsconvenio");
        tabla.empty();
        tabla.append(
            `
                <thead>
                    <tr>
                        <th data-priority="0" scope="col"># convenio</th>
                        <th data-priority="0" scope="col">Cliente</th>
                        <th data-priority="0" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="amortizacionBody" style="vertical-align: middle;"></tbody>
            `
        );

        id = $(this).data("psid");
        let psnombre = $(this).data("psnombre");

        $(".titlePage").text(`Clientes del PS ${psnombre}`);

        table = $("#pagopsconvenio").DataTable({
            ajax: {
                url: "/admin/showContratosPSConvenio",
                type: "GET",
                data: {
                    psid: id,
                },
            },
            columns: [
                {
                    data: "convenio",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
            },
        });

        $("#btnVolver").css("display", "inline-block");
        $("#btnVolver").empty();
        $("#btnVolver").append(
            '<i class="bi-chevron-left me-1"></i>Ver todos los PS'
        );

        $(document).on("click", "#btnVolver", function (e) {
            $(".titlePage").text(`Gestión de pagos a PS de convenios MAM`);

            $("#btnVolver").css("display", "none");
            e.preventDefault();

            table.destroy();

            var tabla = $("#pagopsconvenio");
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

            table = $("#pagopsconvenio").DataTable({
                ajax: "/admin/showPSConvenio",
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
                    info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
                },
            });
        });
    });

    $(document).on("click", ".seeConvenio", function (e) {
        acc = "view";
        e.preventDefault();

        var folio = $(this).data("convenio");
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

        $("#modalTitle").text(`Vista previa del convenio de: ${nombrecliente}`);

        $("#convenioModal").modal("show");

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        $("#montoInput").val(monto);
        $("#montoInput").prop("readonly", true);

        $("#montoLetraInput").val(monto_letra);
        $("#montoLetraInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", true);

        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", true);

        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", true);

        $("#cTrimestralInput").val(ctrimestral);
        $("#cTrimestralInput").prop("readonly", true);

        $("#statusInputModal").val(status);
        $("#statusInputModal").prop("disabled", true);

        $("#numeroCuentaInput").val(numerocuenta);
        $("#numeroCuentaInput").prop("readonly", true);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", true);

        $("#modifySwitch").prop("disabled", true);

        $("#bancoIdInput").val(banco_id);
        $("#bancoIdInput").prop("disabled", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });
});

$(".table").addClass("compact nowrap w-100");
