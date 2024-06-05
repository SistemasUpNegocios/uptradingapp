$(document).ready(function () {
    var table = $("#numeros").DataTable({
        ajax: "/admin/showNumeros",
        columns: [
            { data: "cliente" },
            { data: "telefono" },
            { data: "ps" },
            { data: "color" },
            { data: "modelo" },
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
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún registro",
            infoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
        },
        aaSorting: [],
    });

    $(document).on("click", ".modelo", function (e) {
        $("#modeloForm")[0].reset();
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        $("#idInputModelo").val(id);

        $("#formModalModelo").modal("show");

        var modelo = $(this).data("modelo");
        $("#modeloInput").val(modelo);
    });

    $("#modeloForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/admin/editModeloNumeros",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                $("#formModalModelo").modal("hide");
                $("#modeloForm")[0].reset();
                table.ajax.reload(null, false);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".color", function (e) {
        $("#colorForm")[0].reset();
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        $("#idInputColor").val(id);

        $("#formModalColor").modal("show");

        var color = $(this).data("color");
        $("#colorInput").val(color);
    });

    $("#colorForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/admin/editColor",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                $("#formModalColor").modal("hide");
                $("#colorForm")[0].reset();
                table.ajax.reload(null, false);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".view", function (e) {
        $("#bitacoraForm")[0].reset();
        e.preventDefault();

        var bitacora = $(this).data("bitacora");
        $("#bitacoraInput").val(bitacora);
        $("#bitacoraInput").prop("disabled", true);

        $("#formModalBitacora").modal("show");
    });

    $(document).on("click", ".edit", function (e) {
        $("#bitacoraForm")[0].reset();
        e.preventDefault();
        var id = $(this).data("id");
        $("#idInputBitacora").val(id);

        var bitacora = $(this).data("bitacora");
        $("#bitacoraInput").val(bitacora);
        $("#bitacoraInput").prop("disabled", false);

        $("#formModalBitacora").modal("show");
    });

    $("#bitacoraForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/admin/editBitacora",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (result) {
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cliente actualizado</h1>',
                    html: '<p style="font-family: Poppins">El cliente ha sido actualizado correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });

                $("#formModalBitacora").modal("hide");
                $("#bitacoraForm")[0].reset();
                table.ajax.reload(null, false);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(".table").addClass("compact nowrap w-100");
