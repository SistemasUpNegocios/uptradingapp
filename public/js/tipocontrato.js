$(document).ready(function () {
    let acc = "";

    var tipoid = "";

    var table = $("#tipoContrato").DataTable({
        ajax: "/admin/showTipoContratos",
        columns: [{ data: "tipo" }, { data: "nombremodelo" }, { data: "btn" }],
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
            lengthMenu: "Mostrar _MENU_ Tipos de contrato",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún tipo de contrato",
            infoEmpty:
                "Mostrando tipos de contrato del 0 al 0 de un total de 0 tipos de contrato",
            infoFiltered: "(filtrado de un total de _MAX_ tipos de contrato)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ tipos de contrato",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#tipoContratoForm").on("submit", function (e) {
        e.preventDefault();
        var checkbox = $("#tablaInput").is(":checked");

        if (checkbox) {
            $("#tablaInput").val("true");
        } else {
            $("#tablaInput").val("false");
        }
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
                $("#tipoContratoForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Tipo de contrato añadido</h1>',
                        html: '<p style="font-family: Poppins">El tipo de contrato ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Tipo de contrato actualizado</h1>',
                        html: '<p style="font-family: Poppins">El tipo de contrato ha sido actualizado correctamente</p>',
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
        $("#alertMessage").text("");
        acc = "new";
        $("#tipoContratoForm").attr("action", "/admin/addTipoContrato");
        $("#idInput").val("");

        $("#tipoInput").prop("readonly", false);

        $("#redaccionInput").prop("readonly", false);
        $("#cAperturaInput").prop("readonly", false);
        $("#cMensualInput").prop("readonly", false);
        $("#rendimientoInput").prop("readonly", false);
        $("#modeloIdInput").prop("disabled", false);
        $("#tablaInput").prop("disabled", false);

        $("#modalTitle").text("Añadir tipo de contrato");
        $("#btnSubmit").text("Añadir tipo de contrato");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var tipo = $(this).data("tipo");
        var redaccion = $(this).data("redaccion");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var rendimiento = $(this).data("rendimiento");
        var modeloid = $(this).data("modeloid");
        var tabla = $(this).data("tabla");

        $("#modalTitle").text(`Vista previa del tipo de contrato: ${tipo}`);

        $("#formModal").modal("show");

        $("#tipoInput").val(tipo);
        $("#tipoInput").prop("readonly", true);

        $("#redaccionInput").val(redaccion);
        $("#redaccionInput").prop("readonly", true);

        $("#cAperturaInput").prop("readonly", true);
        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);

        $("#cMensualInput").prop("readonly", true);
        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);

        $("#rendimientoInput").prop("readonly", true);
        rendimiento = rendimiento.toString().replace(",", ".");
        $("#rendimientoInput").val(rendimiento);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", true);

        $("#tablaInput").prop("disabled", true);

        if (tabla) {
            $("#tablaInput").prop("checked", true);
        } else {
            $("#tablaInput").prop("checked", false);
        }

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var tipo = $(this).data("tipo");
        var redaccion = $(this).data("redaccion");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var rendimiento = $(this).data("rendimiento");
        var modeloid = $(this).data("modeloid");
        var tabla = $(this).data("tabla");

        $("#tipoContratoForm").attr("action", "/admin/editTipoContrato");

        $("#idInput").val(id);

        $("#tipoInput").val(tipo);
        $("#tipoInput").prop("readonly", false);

        $("#redaccionInput").val(redaccion);
        $("#redaccionInput").prop("readonly", false);

        $("#cAperturaInput").prop("readonly", false);
        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);

        $("#cMensualInput").prop("readonly", false);
        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);

        $("#rendimientoInput").prop("readonly", false);
        rendimiento = rendimiento.toString().replace(",", ".");
        $("#rendimientoInput").val(rendimiento);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", false);

        $("#tablaInput").prop("disabled", false);

        if (tabla) {
            $("#tablaInput").prop("checked", true);
        } else {
            $("#tablaInput").prop("checked", false);
        }

        $("#modalTitle").text(`Editar tipo de contrato: ${tipo}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar tipo de contrato");
        $("#btnCancel").text("Cancelar");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar tipo de contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el tipo de contrato</p>',
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

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar tipo de contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar el tipo de contrato</p>',
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
                    url: "/admin/showClave",
                    data: { clave: clave },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteTipoContrato",
                                { id: id },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Tipo de contrato eliminado</h1>',
                                        html: '<p style="font-family: Poppins">El tipo de contrato se ha eliminado correctamente</p>',
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

    $(document).on("click", "#seeClausulas", function (e) {
        e.preventDefault();

        tipoid = $(this).data("tipoid");

        $("#TipoIdInput").val(tipoid);

        var tabla = $("#tipoContrato");

        $.ajax({
            type: "POST",
            url: "/admin/existClausulas",
            data: { tipoid: tipoid },
            success: function (data) {
                table.destroy();

                tabla.empty();

                tabla.append(`
                    <thead>
                        <tr>
                            <th data-priority="0" scope="col">Redacción</th>
                            <th data-priority="0" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle">
                    </tbody>
                `);

                table = $("#tipoContrato").DataTable({
                    ajax: {
                        url: "/admin/showClausulas",
                        data: { tipoid: tipoid },
                    },
                    columns: [{ data: "redaccion" }, { data: "btn" }],
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
                        lengthMenu: "Mostrar _MENU_ cláusulas",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "No se ha registrado ninguna cláusula",
                        infoEmpty:
                            "Mostrando cláusulas del 0 al 0 de un total de 0 cláusulas",
                        infoFiltered:
                            "(filtrado de un total de _MAX_ cláusulas)",
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
                        info: "Mostrando de _START_ a _END_ de _TOTAL_ cláusulas",
                    },
                    aaSorting: [],
                });

                $("#btnVolver").css("display", "inline-block");
                $("#newClausula").css("display", "inline-block");

                $("#newTipo").css("display", "none");

                $(document).on("click", "#btnVolver", function (e) {
                    $(".titlePage").text(`Gestión de tipos de contrato`);

                    $("#btnVolver").css("display", "none");
                    e.preventDefault();

                    table.destroy();

                    tabla.empty();

                    tabla.append(`
                    <thead>
                        <tr>
                            <th data-priority="0" scope="col">Tipo</th>
                            <th data-priority="0" scope="col">Modelo</th>
                            <th data-priority="0" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle;">
                    </tbody>
                    `);

                    table = $("#tipoContrato").DataTable({
                        ajax: "/admin/showTipoContratos",
                        columns: [
                            { data: "tipo" },
                            { data: "nombremodelo" },
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
                            lengthMenu: "Mostrar _MENU_ Tipos de contrato",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable:
                                "No se ha registrado ningún tipo de contrato",
                            infoEmpty:
                                "Mostrando tipos de contrato del 0 al 0 de un total de 0 tipos de contrato",
                            infoFiltered:
                                "(filtrado de un total de _MAX_ tipos de contrato)",
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
                            info: "Mostrando de _START_ a _END_ de _TOTAL_ tipos de contrato",
                        },
                    });

                    $("#newTipo").css("display", "inline-block");
                    $("#newClausula").css("display", "none");
                });

                $.ajax({
                    type: "GET",
                    url: "/admin/showTipoContrato",
                    data: { tipoid: tipoid },
                    success: function (data) {
                        var tipo = data[0].tipo;

                        $(".titlePage").text(
                            `Cláusulas del tipo de contrato ${tipo}`
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

    $(document).on("click", ".viewClausula", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        var redaccion = $(this).data("redaccion");

        $("#formModalClausula").modal("show");

        $("#clausulaForm #idInput").val(id);

        $("#clausulaForm #tipoIdInput").val(tipoid);
        $("#clausulaForm #tipoIdInput").prop("readonly", true);

        $("#clausulaForm #redaccionInput").val(redaccion);
        $("#clausulaForm #redaccionInput").prop("readonly", true);

        $("#formModalClausula #modalTitle").text(`Vista previa de la clausula`);
        $("#clausulaForm #btnSubmit").hide();
        $("#clausulaForm #btnCancel").text("Cerrar vista previa");
    });

    $(document).on("click", "#newClausula", function (e) {
        $("#alertMessage").text("");
        acc = "new";
        $("#clausulaForm").attr("action", "/admin/addClausula");
        $("#idInput").val("");

        $("#clausulaForm #tipoIdInput").prop("readonly", false);
        $("#clausulaForm #redaccionInput").prop("readonly", false);

        $("#modalTitle").text("Añadir cláusula");
        $("#btnSubmit").text("Añadir cláusula");

        $("#formModalClausula #modalTitle").text(`Añadir cláusula`);
        $("#clausulaForm #btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".editClausula", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        var redaccion = $(this).data("redaccion");

        // console.log(id);
        // console.log(redaccion);

        $("#formModalClausula").modal("show");
        $("#clausulaForm").attr("action", "/admin/editClausula");

        $("#clausulaForm #idInput").val(id);

        $("#clausulaForm #tipoIdInput").val(tipoid);
        $("#clausulaForm #tipoIdInput").prop("readonly", false);

        $("#clausulaForm #redaccionInput").val(redaccion);
        $("#clausulaForm #redaccionInput").prop("readonly", false);

        $("#formModalClausula #modalTitle").text(`Editar cláusula`);
        $("#clausulaForm #btnSubmit").show();
        $("#clausulaForm #btnSubmit").text("Editar cláusula");
        $("#clausulaForm #btnCancel").text("Cancelar");
    });

    $("#clausulaForm").on("submit", function (e) {
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
                $("#formModalClausula").modal("hide");
                $("#clausulaForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cláusula añadida</h1>',
                        html: '<p style="font-family: Poppins">La cláusula ha sido añadida correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cláusula actualizada</h1>',
                        html: '<p style="font-family: Poppins">La cláusula ha sido actualizada correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
        });
    });

    $(document).on("click", ".deleteClausula", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar cláusula</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar esta cláusula? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteClausula", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cláusula eliminada</h1>',
                        html: '<p style="font-family: Poppins">La cláusula se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La cláusula no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });
});

$(".table").addClass("compact nowrap w-100");
