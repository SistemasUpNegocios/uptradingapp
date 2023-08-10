function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(".image-upload-wrapScanner1").hide();

            $(".file-upload-imageScanner1").attr("src", e.target.result);
            $(".file-upload-contentScanner1").show();

            $(".image-titleScanner1").html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $(".file-upload-inputScanner1").replaceWith(
        $(".file-upload-inputScanner1").clone()
    );
    $(".file-upload-contentScanner1").hide();
    $(".image-upload-wrapScanner1").show();
}

$(".image-upload-wrapScanner1").bind("dragover", function () {
    $(".image-upload-wrapScanner1").addClass("image-droppingScanner1");
});
$(".image-upload-wrapScanner1").bind("dragleave", function () {
    $(".image-upload-wrapScanner1").removeClass("image-droppingScanner1");
});

$(document).ready(function () {
    let acc = "";
    let casilla = false;

    $(".contEuro").hide();
    $(".contFranco").hide();

    var table = $("#contrato").DataTable({
        ajax: "/admin/showContrato",
        columns: [
            { data: "contrato" },
            { data: "tipo" },
            { data: "status" },
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
        aaSorting: [],
    });

    $("#contenedor_filtros").hide();
    $(document).on("click", "#filtros", function (e) {
        e.preventDefault();
        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#todos", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando todos los contratos");

        table = $("#contrato").DataTable({
            ajax: "/admin/showContrato",
            columns: [
                { data: "contrato" },
                { data: "tipo" },
                { data: "status" },
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

        estilos(
            "btn-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#contratosMensuales", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando contratos mensuales");

        table = $("#contrato").DataTable({
            ajax: "/admin/showContratoMensuales",
            columns: [
                { data: "contrato" },
                { data: "tipo" },
                { data: "status" },
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
                lengthMenu: "Mostrar _MENU_ contratos mensuales",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No se ha registrado ningún contrato mensual",
                infoEmpty:
                    "Mostrando contratos del 0 al 0 de un total de 0 contratos mensuales",
                infoFiltered:
                    "(filtrado de un total de _MAX_ contratos mensuales)",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos mensuales",
            },
        });

        estilos(
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#contratosCompuestos", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando contratos compuestos");

        table = $("#contrato").DataTable({
            ajax: "/admin/showContratoCompuestos",
            columns: [
                { data: "contrato" },
                { data: "tipo" },
                { data: "status" },
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
                lengthMenu: "Mostrar _MENU_ contratos compuestos",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No se ha registrado ningún contrato compuestos",
                infoEmpty:
                    "Mostrando contratos del 0 al 0 de un total de 0 contratos compuestos",
                infoFiltered:
                    "(filtrado de un total de _MAX_ contratos compuestos)",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos compuestos",
            },
        });

        estilos(
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#contratosActivados", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando contratos activados");

        table = $("#contrato").DataTable({
            ajax: "/admin/showContratoActivados",
            columns: [
                { data: "contrato" },
                { data: "tipo" },
                { data: "status" },
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
                lengthMenu: "Mostrar _MENU_ contratos activados",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No se ha registrado ningún contrato activado",
                infoEmpty:
                    "Mostrando contratos del 0 al 0 de un total de 0 contratos activados",
                infoFiltered:
                    "(filtrado de un total de _MAX_ contratos activados)",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos activados",
            },
        });

        estilos(
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#contratosPendientes", function () {
        table.destroy();

        $("#titulo_filtro").text(
            "Mostrando contratos en pendientes de activación"
        );

        table = $("#contrato").DataTable({
            ajax: "/admin/showContratoPendientes",
            columns: [
                { data: "contrato" },
                { data: "tipo" },
                { data: "status" },
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
                lengthMenu: "Mostrar _MENU_ contratos pendientes de activación",
                zeroRecords: "No se encontraron resultados",
                emptyTable:
                    "No se ha registrado ningún contrato pendiente de activación",
                infoEmpty:
                    "Mostrando contratos del 0 al 0 de un total de 0 contratos pendientes de activación",
                infoFiltered:
                    "(filtrado de un total de _MAX_ contratos pendientes de activación)",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos pendientes de activación",
            },
        });

        estilos(
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-outline-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    const config = {
        search: true,
    };

    dselect(document.querySelector("#clienteIdInput"), config);
    dselect(document.querySelector("#psIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    $("#clienteIdInput")
        .next()
        .children()
        .next()
        .children()
        .children()
        .next()
        .addClass("d-none");

    $(".dropdown-menu .form-control").on("keyup", function () {
        let input = $(".dropdown-menu .form-control").val();

        if (input.length > 0) {
            $("#clienteIdInput")
                .next()
                .children()
                .next()
                .children()
                .children()
                .next()
                .removeClass("d-none");
        } else {
            $("#clienteIdInput")
                .next()
                .children()
                .next()
                .children()
                .children()
                .next()
                .addClass("d-none");
        }
    });

    let dataInversionUS = 0;
    let dataInversionMXN = 0;
    let dataInversionEUR = 0;
    let dataInversionCHF = 0;
    let dataFechaInicio = "";

    table.on("change", ".status", function () {
        var checked = $(this).is(":checked");

        if (checked) {
            $(this).val("Activado");
        } else {
            $(this).val("Pendiente de activación");
        }

        let input = this;

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
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar estatus</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el estatus</p>',
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
                    data: {
                        clave: clave,
                        id: id,
                        status: statusValor,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.get(
                                "/admin/editStatus",
                                {
                                    id: id,
                                    status: statusValor,
                                },
                                function () {
                                    Toast.fire({
                                        icon: "success",
                                        title: "Estatus actualizado",
                                    });

                                    table.ajax.reload(function () {
                                        if (statusValor == "Activado") {
                                            $(this).prop("checked", true);
                                        } else {
                                            $(this).prop("checked", false);
                                        }
                                    });
                                }
                            );
                        } else {
                            estatusClaveIncorrecta(input);

                            Toast.fire({
                                icon: "error",
                                title: "Clave incorrecta",
                            });
                        }
                    },
                    error: function () {
                        estatusClaveIncorrecta(input);
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
                estatusClaveIncorrecta();
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El estatus no se ha actualizado</p>',
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

    $("#contratoForm").on("submit", function (e) {
        e.preventDefault();
        var url = $(this).attr("action");
        $("#alertMessage").text("");
        $("option:selected", "#statusInput").prop("disabled", false);

        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Se está generando el contrato, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                Swal.close();

                let rendimiento = $("#porcentajeRendimientoInput").val();
                let contrato_numero = $("#contratoInput").val();
                let estatus = $("#statusInput").val();
                if (estatus == "Activado") {
                    $("option:selected", "#statusInput").prop("disabled", true);
                }

                $("#formModal").modal("hide");
                $("#contratoForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    if (casilla && rendimiento > 0) {
                        let mensaje = `Se ha generado un nuevo contrato, por favor actívalo.\nEn este mismo contrato se pide cambiar el porcentaje del rendimiento al ${rendimiento}%.\nNúmero de contrato: ${contrato_numero}`;
                        $.get({
                            url: "/admin/enviarTelegram",
                            data: {
                                mensaje: mensaje,
                            },
                            success: function (response) {
                                $("#contratoInput").val(response);
                            },
                        });
                    } else {
                        let mensaje = `Se ha generado un nuevo contrato, por favor actívalo.\nNúmero de contrato: ${contrato_numero}`;
                        $.get({
                            url: "/admin/enviarTelegram",
                            data: {
                                mensaje: mensaje,
                            },
                            success: function (response) {
                                $("#contratoInput").val(response);
                            },
                        });
                    }

                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato añadido</h1>',
                        html: '<p style="font-family: Poppins">El contrato ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato actualizado</h1>',
                        html: '<p style="font-family: Poppins">El contrato ha sido actualizado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }

                $("#contBeneficiarios").empty();
                $("#contBeneficiarios").append(`
                    <div class="col-12">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Ingresa al beneficiario en caso de fallecimiento del cliente:
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control"
                                placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input"
                                name="nombre-ben1" minlength="3" maxlength="255">
                            <label for="nombreBen1Input">Nombre del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input type="number" step="any" class="form-control"
                                placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                                name="porcentaje-ben1" value="0">
                            <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input type="number" class="form-control"
                                placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                                name="telefono-ben1" minlength="3" maxlength="100">
                            <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">                                
                            <input style="text-transform: lowercase;" type="email" class="form-control"
                                placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                                name="correo-ben1" minlength="3" maxlength="100">
                            <label for="correoBen1Input">Correo del beneficiario</label>
                        </div>
                    </div>                    
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control"
                                placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                                name="curp-ben1" minlength="3" maxlength="100">
                            <label for="curpBen1Input">CURP del beneficiario</label>
                        </div>
                    </div>
                `);
                casilla = false;
            },
            error: function (err, exception) {
                Swal.close();

                var validacion = err.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $("#scannerForm").on("submit", function (e) {
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
            success: function () {
                $("#scannerModal").modal("hide");
                $("#scannerForm")[0].reset();
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Escaner subido</h1>',
                    html: '<p style="font-family: Poppins">El escaner ha sido subido correctamente</p>',
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

    $(document).on("click", ".new", function (e) {
        $("#contratoForm")[0].reset();

        $("#tablaBody").empty();

        $("#alertMessage").text("");
        $("#contPagos").empty();
        $(".cont-tabla").empty();

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
        $("#contratoForm").attr("action", "/admin/addContrato");
        $("#idInput").val("");

        $("#operadorInput").prop("readonly", false);
        $("#operadorINEInput").prop("readonly", false);
        $("#lugarFirmaInput").prop("readonly", false);
        $("#fechaInicioInput").prop("readonly", false);
        $("#fechaRenInput").prop("readonly", false);
        $("#fechaPagInput").prop("readonly", false);
        $("#fechaLimiteInput").prop("readonly", false);
        $("#periodoInput").prop("disabled", false);
        $("#contratoInput").prop("readonly", false);
        $("#psIdInput").prop("disabled", false);
        $("#clienteIdInput").prop("disabled", false);
        $("#tipoIdInput").prop("disabled", false);
        $("#folioInput").prop("readonly", false);
        $("#modeloIdInput").prop("disabled", false);
        $("#inversionInput").prop("readonly", false);
        $("#inversionUsInput").prop("readonly", false);
        $("#tipoCambioInput").prop("readonly", false);
        $("#inversionLetInput").prop("readonly", false);
        $("#inversionLetUsInput").prop("readonly", false);
        $("#tipoCambioInputEUR").prop("readonly", false);
        $("#tipoCambioInputCHF").prop("readonly", false);
        $("#inversionInputEUR").prop("readonly", false);
        $("#inversionInputCHF").prop("readonly", false);
        $("#inversionLetInputEUR").prop("readonly", false);
        $("#inversionLetInputCHF").prop("readonly", false);
        $("#fechaReinInput").prop("readonly", false);
        $("#statusReinInput").prop("disabled", false);
        $("#memoReinInput").prop("readonly", false);
        $("#statusInput").prop("disabled", false);
        $("#beneficiariosInput").prop("disabled", false);
        $("#nombreBen1Input").prop("readonly", false);
        $("#porcentajeBen1Input").prop("readonly", false);
        $("#telefonoBen1Input").prop("readonly", false);
        $("#correoBen1Input").prop("readonly", false);
        $("#curpBen1Input").prop("readonly", false);
        $("#nombreBen2Input").prop("readonly", false);
        $("#porcentajeBen2Input").prop("readonly", false);
        $("#telefonoBen2Input").prop("readonly", false);
        $("#correoBen2Input").prop("readonly", false);
        $("#curpBen2Input").prop("readonly", false);
        $("#nombreBen3Input").prop("readonly", false);
        $("#porcentajeBen3Input").prop("readonly", false);
        $("#telefonoBen3Input").prop("readonly", false);
        $("#correoBen3Input").prop("readonly", false);
        $("#curpBen3Input").prop("readonly", false);
        $("#tipoPagoInput").prop("disabled", false);
        $("#comprobantePagoInput").prop("disabled", false);
        $("#efectivoInput").prop("disabled", false);
        $("#transferenciaSwissInput").prop("disabled", false);
        $("#transferenciaMXInput").prop("disabled", false);
        $("#ciBankInput").prop("disabled", false);
        $("#wiseInput").prop("disabled", false);
        $("#hsbcInput").prop("disabled", false);
        $("#renovacionInput").prop("disabled", false);
        $("#rendimientosInput").prop("disabled", false);
        $("#comisionesInput").prop("disabled", false);
        $("#bitsoInput").prop("disabled", false);

        $("#montoEfectivoInput").prop("disabled", false);
        $("#montoTransSwissPOOLInput").prop("disabled", false);
        $("#montoTransMXPOOLInput").prop("disabled", false);
        $("#montoBankInput").prop("disabled", false);
        $("#montoWiseInput").prop("disabled", false);
        $("#montoHSBCInput").prop("disabled", false);
        $("#montoRenovacionInput").prop("disabled", false);
        $("#montoRendimientosInput").prop("disabled", false);
        $("#montoComisionesInput").prop("disabled", false);
        $("#montoBitsoInput").prop("disabled", false);

        $("#referenciaTransSwissPOOLInput").prop("disabled", false);
        $("#referenciaTransMXPOOLInput").prop("disabled", false);
        $("#referenciaWiseInput").prop("disabled", false);
        $("#referenciaHSBCInput").prop("disabled", false);

        $("#cambiarPorcentajeInput").prop("disabled", false);

        $("#comprobantePagoInput").removeClass("is-valid");
        $("#comprobantePagoInput").removeClass("is-invalid");

        $(".status_reintegro").hide();
        $(".memo_reintegro").hide();

        $("#monedaDolaresInput").prop("disabled", false);
        $("#monedaEurosInput").prop("disabled", false);
        $("#monedaFrancosInput").prop("disabled", false);

        $("#modalTitle").text("Añadir contrato");
        $("#btnSubmit").text("Añadir contrato");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");

        $("#contBeneficiarios").empty();
        $("#contBeneficiarios").append(`
            <div class="col-12">
                <div class="alert alert-primary d-flex align-items-center" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                        <use xlink:href="#info-fill" />
                    </svg>
                    <div>
                        Ingresa al beneficiario en caso de fallecimiento del cliente:
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control"
                        placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input"
                        name="nombre-ben1" minlength="3" maxlength="255">
                    <label for="nombreBen1Input">Nombre del beneficiario</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-2">
                    <input type="number" step="any" class="form-control"
                        placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                        name="porcentaje-ben1" value="0">
                    <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-2">
                    <input type="number" class="form-control"
                        placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                        name="telefono-ben1" minlength="3" maxlength="100">
                    <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">                                
                    <input style="text-transform: lowercase;" type="email" class="form-control"
                        placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                        name="correo-ben1" minlength="3" maxlength="100">
                    <label for="correoBen1Input">Correo del beneficiario</label>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control"
                        placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                        name="curp-ben1" minlength="3" maxlength="100">
                    <label for="curpBen1Input">CURP del beneficiario</label>
                </div>
            </div>
        `);

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

        $.ajax({
            url: "https://api.currencyapi.com/v3/latest?apikey=cur_live_5M1goOJMnU9vgGYLZIGNkbHFI2fvMUGTR063XuVO&currencies=MXN&base_currency=CHF",
            success: function (response) {
                //FRANCO SUIZO
                let franco = response.data.MXN.value;
                $("#tipoCambioInputCHF").val(franco.toFixed(2));
            },
        });

        $.ajax({
            url: "https://api.currencyapi.com/v3/latest?apikey=cur_live_5M1goOJMnU9vgGYLZIGNkbHFI2fvMUGTR063XuVO&currencies=MXN&base_currency=EUR",
            success: function (response) {
                //EURO
                let euro = response.data.MXN.value;
                $("#tipoCambioInputEUR").val(euro.toFixed(2));
            },
        });

        $.ajax({
            type: "GET",
            url: "/admin/getFolio",
            success: function (data) {
                $("#folioInput").val(data);
            },
            error: function (data) {
                console.log(data);
            },
        });

        containerHide();
    });

    $(document).on("click", ".view", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var id = $(this).data("id");
        var nombrecliente = $(this).data("nombrecliente");
        var operador = $(this).data("operador");
        var operadorine = $(this).data("operadorine");
        var lugarfirma = $(this).data("lugarfirma");
        var fechainicio = $(this).data("fecha");
        var fecharen = $(this).data("fecharen");
        var fechapag = $(this).data("fechapag");
        var fechalimite = $(this).data("fechalimite");
        var periodo = $(this).data("periodo");
        var contrato = $(this).data("contrato");
        var psid = $(this).data("psid");
        var psnombre = $(this).data("psnombre");
        var clienteid = $(this).data("clienteid");
        var tipoid = $(this).data("tipoid");
        var porcentaje = $(this).data("porcentaje");
        var folio = $(this).data("folio");
        var modeloid = $(this).data("modeloid");
        var inversion = $(this).data("inversion");
        var inversionus = $(this).data("inversionus");
        var tipocambio = $(this).data("tipocambio");
        var inversionlet = $(this).data("inversionlet");
        var tipocambio_eur = $(this).data("tipocambioeur");
        var tipocambio_chf = $(this).data("tipocambiochf");
        var inversion_eur = $(this).data("inversioneur");
        var inversion_chf = $(this).data("inversionchf");
        var inversionlet_eur = $(this).data("inversionleteur");
        var inversionlet_chf = $(this).data("inversionletchf");
        var inversionletus = $(this).data("inversionletus");
        var fecharein = $(this).data("fecharein");
        var statusrein = $(this).data("statusrein");
        var memorein = $(this).data("memorein");
        var status = $(this).data("status");
        var moneda = $(this).data("moneda");

        $("#modalTitle").text(`Vista previa del contrato de: ${nombrecliente}`);

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

        $("#formModal").modal("show");

        $("#operadorInput").val(operador);
        $("#operadorInput").prop("readonly", true);

        $("#operadorINEInput").val(operadorine);
        $("#operadorINEInput").prop("readonly", true);

        $("#lugarFirmaInput").val(lugarfirma);
        $("#lugarFirmaInput").prop("readonly", true);

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

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        // $("#porcentajeInput").prop("readonly", true);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", true);

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

        $("#tipoCambioInputEUR").val(tipocambio_eur);
        $("#tipoCambioInputEUR").prop("readonly", true);

        $("#tipoCambioInputCHF").val(tipocambio_chf);
        $("#tipoCambioInputCHF").prop("readonly", true);

        inversion_eur = inversion_eur.toString().replace(",", ".");
        $("#inversionInputEUR").val(inversion_eur);
        $("#inversionInputEUR").prop("readonly", true);

        inversion_chf = inversion_chf.toString().replace(",", ".");
        $("#inversionInputCHF").val(inversion_chf);
        $("#inversionInputCHF").prop("readonly", true);

        $("#inversionLetInputEUR").val(inversionlet_eur);
        $("#inversionLetInputEUR").prop("readonly", true);

        $("#inversionLetInputCHF").val(inversionlet_chf);
        $("#inversionLetInputCHF").prop("readonly", true);

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", true);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", true);

        $("#cambiarPorcentajeInput").prop("disabled", true);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#monedaDolaresInput").prop("disabled", true);
        $("#monedaDolaresInput").prop("checked", false);

        $("#monedaEurosInput").prop("disabled", true);
        $("#monedaEurosInput").prop("checked", false);

        $("#monedaFrancosInput").prop("disabled", true);
        $("#monedaFrancosInput").prop("checked", false);

        if (moneda == "dolares") {
            $("#monedaDolaresInput").prop("checked", true);

            $(".contEuro").hide();
            $(".contFranco").hide();

            $(".contDolar").show();
        } else if (moneda == "euros") {
            $("#monedaEurosInput").prop("checked", true);

            $(".contDolar").hide();
            $(".contFranco").hide();

            $(".contEuro").show();
        } else if (moneda == "francos") {
            $("#monedaFrancosInput").prop("checked", true);

            $(".contDolar").hide();
            $(".contEuro").hide();

            $(".contFranco").show();
        }

        $("#beneficiariosInput").prop("disabled", true);

        containerHide();

        $("#comprobantePagoInput").prop("disabled", true);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", true);
        $("#transferenciaSwissInput").prop("disabled", true);
        $("#transferenciaMXInput").prop("disabled", true);
        $("#ciBankInput").prop("disabled", true);
        $("#wiseInput").prop("disabled", true);
        $("#hsbcInput").prop("disabled", true);
        $("#renovacionInput").prop("disabled", true);
        $("#rendimientosInput").prop("disabled", true);
        $("#comisionesInput").prop("disabled", true);
        $("#bitsoInput").prop("disabled", true);
        tipoPago(this);

        $("#montoEfectivoInput").prop("disabled", true);
        $("#montoTransSwissPOOLInput").prop("disabled", true);
        $("#montoTransMXPOOLInput").prop("disabled", true);
        $("#montoBankInput").prop("disabled", true);
        $("#montoWiseInput").prop("disabled", true);
        $("#montoHSBCInput").prop("disabled", true);
        $("#montoRenovacionInput").prop("disabled", true);
        $("#montoRendimientosInput").prop("disabled", true);
        $("#montoComisionesInput").prop("disabled", true);
        $("#montoBitsoInput").prop("disabled", true);

        $("#referenciaTransSwissPOOLInput").prop("disabled", true);
        $("#referenciaTransMXPOOLInput").prop("disabled", true);
        $("#referenciaWiseInput").prop("disabled", true);
        $("#referenciaHSBCInput").prop("disabled", true);

        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiarios",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $("#beneficiariosInput").val(response.countBeneficiarios);
                if (response.countBeneficiarios > 0) {
                    $("#contBeneficiarios").empty();
                    for (var i = 1; i <= response.countBeneficiarios; i++) {
                        var adjetivo = "";
                        if (i == 1) {
                            adjetivo = "primer";
                        } else if (i == 2) {
                            adjetivo = "segundo";
                        } else if (i == 3) {
                            adjetivo = "tercer";
                        } else if (i == 4) {
                            adjetivo = "cuarto";
                        }
                        $("#contBeneficiarios").append(`             
                            <div class="col-12">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                        <use xlink:href="#info-fill" />
                                    </svg>
                                    <div>
                                        Ingresa al ${adjetivo} beneficiario en caso de fallecimiento del cliente:
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa el nombre del ${adjetivo} beneficiario" id="nombreBen${i}Input"
                                        name="nombre-ben${i}" minlength="3" maxlength="255">
                                    <label for="nombreBen${i}Input">Nombre del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" step="any" class="form-control"
                                        placeholder="Ingresa el porcentaje del ${adjetivo} beneficiario" id="porcentajeBen${i}Input"
                                        name="porcentaje-ben${i}" value="0">
                                    <label for="porcentajeBen${i}Input">Porcentaje del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control"
                                        placeholder="Ingresa el telefono del ${adjetivo} beneficiario" id="telefonoBen${i}Input"
                                        name="telefono-ben${i}" minlength="3" maxlength="100">
                                    <label for="telefonoBen${i}Input">Teléfono del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">                                
                                    <input style="text-transform: lowercase;" type="email" class="form-control"
                                        placeholder="Ingresa el correo del ${adjetivo} beneficiario" id="correoBen${i}Input"
                                        name="correo-ben${i}" minlength="3" maxlength="100">
                                    <label for="correoBen${i}Input">Correo del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa la curp del ${adjetivo} beneficiario" id="curpBen${i}Input"
                                        name="curp-ben${i}" minlength="3" maxlength="100">
                                    <label for="curpBen${i}Input">CURP del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                        `);

                        $(`#nombreBen${i}Input`).prop("readonly", true);
                        $(`#porcentajeBen${i}Input`).prop("readonly", true);
                        $(`#telefonoBen${i}Input`).prop("readonly", true);
                        $(`#correoBen${i}Input`).prop("readonly", true);
                        $(`#curpBen${i}Input`).prop("readonly", true);
                        $(`#curpBen${i}InputCheck`).prop("disabled", true);
                    }

                    if (response.beneficiarios[0]) {
                        var nombreben1 = response.beneficiarios[0].nombre;
                        var porcentajeben1 =
                            response.beneficiarios[0].porcentaje;
                        var telefonoben1 = response.beneficiarios[0].telefono;
                        var correoben1 =
                            response.beneficiarios[0].correo_electronico;
                        var curpben1 = response.beneficiarios[0].curp;

                        $("#nombreBen1Input").val(nombreben1);
                        $("#porcentajeBen1Input").val(porcentajeben1);
                        $("#telefonoBen1Input").val(telefonoben1);
                        $("#correoBen1Input").val(correoben1);
                        $("#curpBen1Input").val(curpben1);
                    } else {
                        $("#nombreBen1Input").val("sin beneficiario");
                        $("#porcentajeBen1Input").val(0);
                        $("#telefonoBen1Input").val("sin telefono de contácto");
                        $("#correoBen1Input").val("sin correo de contácto");
                        $("#curpBen1Input").val("sin curp");
                    }

                    if (response.beneficiarios[1]) {
                        var nombreben2 = response.beneficiarios[1].nombre;
                        var porcentajeben2 =
                            response.beneficiarios[1].porcentaje;
                        var telefonoben2 = response.beneficiarios[1].telefono;
                        var correoben2 =
                            response.beneficiarios[1].correo_electronico;
                        var curpben2 = response.beneficiarios[1].curp;

                        $("#nombreBen2Input").val(nombreben2);
                        $("#porcentajeBen2Input").val(porcentajeben2);
                        $("#telefonoBen2Input").val(telefonoben2);
                        $("#correoBen2Input").val(correoben2);
                        $("#curpBen2Input").val(curpben2);
                    } else {
                        $("#nombreBen2Input").val("sin beneficiario");
                        $("#porcentajeBen2Input").val(0);
                        $("#telefonoBen2Input").val("sin telefono de contácto");
                        $("#correoBen2Input").val("sin correo de contácto");
                        $("#curpBen2Input").val("sin curp");
                    }

                    if (response.beneficiarios[2]) {
                        var nombreben3 = response.beneficiarios[2].nombre;
                        var porcentajeben3 =
                            response.beneficiarios[2].porcentaje;
                        var telefonoben3 = response.beneficiarios[2].telefono;
                        var correoben3 =
                            response.beneficiarios[2].correo_electronico;
                        var curpben3 = response.beneficiarios[2].curp;

                        $("#nombreBen3Input").val(nombreben3);
                        $("#porcentajeBen3Input").val(porcentajeben3);
                        $("#telefonoBen3Input").val(telefonoben3);
                        $("#correoBen3Input").val(correoben3);
                        $("#curpBen3Input").val(curpben3);
                    } else {
                        $("#nombreBen3Input").val("sin beneficiario");
                        $("#porcentajeBen3Input").val(0);
                        $("#telefonoBen3Input").val("sin telefono de contácto");
                        $("#correoBen3Input").val("sin correo de contácto");
                        $("#curpBen3Input").val("sin curp");
                    }

                    if (response.beneficiarios[3]) {
                        var nombreben4 = response.beneficiarios[3].nombre;
                        var porcentajeben4 =
                            response.beneficiarios[3].porcentaje;
                        var telefonoben4 = response.beneficiarios[3].telefono;
                        var correoben4 =
                            response.beneficiarios[3].correo_electronico;
                        var curpben4 = response.beneficiarios[3].curp;

                        $("#nombreBen4Input").val(nombreben4);
                        $("#porcentajeBen4Input").val(porcentajeben4);
                        $("#telefonoBen4Input").val(telefonoben4);
                        $("#correoBen4Input").val(correoben4);
                        $("#curpBen4Input").val(curpben4);
                    } else {
                        $("#nombreBen4Input").val("sin beneficiario");
                        $("#porcentajeBen4Input").val(0);
                        $("#telefonoBen4Input").val("sin telefono de contácto");
                        $("#correoBen4Input").val("sin correo de contácto");
                        $("#curpBen4Input").val("sin curp");
                    }
                } else {
                    $("#beneficiariosInput").val(1);
                    $("#contBeneficiarios").empty();
                    $("#contBeneficiarios").append(`
                    <div class="col-12">
                        <div class="alert alert-primary d-flex align-items-center" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                <use xlink:href="#info-fill" />
                            </svg>
                            <div>
                                Ingresa al beneficiario en caso de fallecimiento del cliente:
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input readonly type="text" class="form-control"
                                placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input"
                                name="nombre-ben1" minlength="3" maxlength="255">
                            <label for="nombreBen1Input">Nombre del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input readonly type="number" step="any" class="form-control"
                                placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                                name="porcentaje-ben1" value="0">
                            <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input readonly type="number" class="form-control"
                                placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                                name="telefono-ben1" minlength="3" maxlength="100">
                            <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">                                
                            <input readonly type="text" class="form-control"
                                placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                                name="correo-ben1" minlength="3" maxlength="100">
                            <label for="correoBen1Input">Correo del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input readonly type="text" class="form-control"
                                placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                                name="curp-ben1" minlength="3" maxlength="100">
                            <label for="curpBen1Input">CURP del beneficiario</label>
                        </div>
                    </div>
                `);
                }
            },
        });

        $(".status_reintegro").show();
        $(".memo_reintegro").show();

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();

        $("#contPagos").empty();
        $(".cont-tabla").empty();

        var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
            "data-tipo"
        );

        let monedaDolaresChecked = $("#monedaDolaresInput").is(":checked");
        let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
        let monedaFrancosChecked = $("#monedaFrancosInput").is(":checked");
        let capital_nombre = "";

        if (monedaDolaresChecked) {
            var inversionUSD = $("#inversionUsInput").val();
            capital_nombre = "Capital (USD)";
        } else if (monedaEurosChecked) {
            var inversionUSD = $("#inversionInputEUR").val();
            capital_nombre = "Capital (EUR)";
        } else if (monedaFrancosChecked) {
            var inversionUSD = $("#inversionInputCHF").val();
            capital_nombre = "Capital (CHF)";
        }

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">${capital_nombre}</th>
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
                                <th scope="col">${capital_nombre}</th>
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

        inversionUSD = parseFloat(inversionUSD);
        // var inversionInicialUSD = parseFloat(inversionUSD);

        var porcentaje = $("#porcentajeInput").val();
        porcentaje = parseFloat(porcentaje);

        var fecha = $("#fechaInicioInput").val();

        var porcentaje = $("#porcentajeInput").val();
        var usd = parseFloat($("#tipoCambioInput").val());

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
            var pagoPS = cmensual2 * inversionUSD;

            $("#contPagos").append(
                `
                <input type="hidden" name="serie-reintegro${
                    i + 1
                }" id="serieReintegro${i + 1}Input" value="${i + 1}">
                <input type="hidden" name="fecha-reintegro${
                    i + 1
                }" id="fechaReintegro${i + 1}Input" value="${fechaInput}">
                <input type="hidden" name="monto-reintegro${
                    i + 1
                }" id="montoReintegro${i + 1}Input" value="${monto.toFixed(2)}">
                <input type="hidden" name="redito-reintegro${
                    i + 1
                }" id="reditoReintegro${i + 1}Input" value="${redito.toFixed(
                    2
                )}">
                <input type="hidden" name="montoredito-reintegro${
                    i + 1
                }" id="montoReditoReintegro${
                    i + 1
                }Input" value="${monto_redito.toFixed(2)}">

                <input type="hidden" name="monto-pagops${
                    i + 1
                }" id="montoPagoPs${i + 1}Input" value="${pagoPS.toFixed(2)}">
                `
            );

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

    $(document).on("click", ".scanner", function (e) {
        $("#scannerForm")[0].reset();

        acc = "scanner";
        e.preventDefault();

        $("#scannerForm").attr("action", "/admin/addScanner");

        var id = $(this).data("id");
        var contrato = $(this).data("contrato");

        $("#idInputScanner").val(id);
        $("#contratoInputScanner").val(contrato);

        $(".image-upload-wrapScanner1").show();
        $(".file-upload-imageScanner1").attr("src", "");
        $(".file-upload-contentScanner1").hide();

        $.get({
            url: "/admin/checkScanner",
            data: {
                id: id,
            },
            success: function (res) {
                if (res != "none") {
                    acc = "edit";
                    $("#scannerForm").attr("action", "/admin/editScanner");

                    if (res[0].img != null) {
                        $(".image-upload-wrapScanner1").hide();
                        $(".file-upload-imageScanner1").attr(
                            "src",
                            "/documentos/contrato_escaneado" + "/" + res[0].img
                        );
                        $(".file-upload-contentScanner1").show();
                    }
                } else if (res == "none") {
                    $("#scannerForm").attr("action", "/admin/addScanner");
                    console.log(res);
                } else {
                    console.log(res);
                }
            },
            error: function (error) {
                console.log(error);
            },
        });

        $("#modalTitleScanner").text(`Contrato escaneado: ${contrato}`);
        $("#btnSubmitScanner").text("Guardar cambios");
        $("#scannerModal").modal("show");
    });

    $(document).on("click", ".edit", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();

        var id = $(this).data("id");

        var nombrecliente = $(this).data("nombrecliente");
        var operador = $(this).data("operador");
        var operadorine = $(this).data("operadorine");
        var lugarfirma = $(this).data("lugarfirma");
        var fechainicio = $(this).data("fecha");
        var fecharen = $(this).data("fecharen");
        var fechapag = $(this).data("fechapag");
        var fechalimite = $(this).data("fechalimite");
        var periodo = $(this).data("periodo");
        var contrato = $(this).data("contrato");
        var psid = $(this).data("psid");
        var psnombre = $(this).data("psnombre");
        var clienteid = $(this).data("clienteid");
        var tipoid = $(this).data("tipoid");
        var porcentaje = $(this).data("porcentaje");
        var folio = $(this).data("folio");
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
        var moneda = $(this).data("moneda");
        var tipocambio_eur = $(this).data("tipocambioeur");
        var tipocambio_chf = $(this).data("tipocambiochf");
        var inversion_eur = $(this).data("inversioneur");
        var inversion_chf = $(this).data("inversionchf");
        var inversionlet_eur = $(this).data("inversionleteur");
        var inversionlet_chf = $(this).data("inversionletchf");

        dataInversionUS = $(this).data("inversionus");
        dataInversionMXN = $(this).data("inversion");
        dataInversionEUR = $(this).data("inversioneur");
        dataInversionCHF = $(this).data("inversionchf");
        dataFechaInicio = $(this).data("fecha");

        $("#contratoForm").attr("action", "/admin/editContrato");

        $("#idInput").val(id);

        $("#operadorInput").val(operador);
        $("#operadorInput").prop("readonly", false);

        $("#operadorINEInput").val(operadorine);
        $("#operadorINEInput").prop("readonly", false);

        $("#lugarFirmaInput").val(lugarfirma);
        $("#lugarFirmaInput").prop("readonly", false);

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", false);

        $("#fechaRenInput").val(fecharen);
        $("#fechaRenInput").prop("readonly", false);

        $("#fechaPagInput").val(fechapag);
        $("#fechaPagInput").prop("readonly", false);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", false);

        $("#periodoInput").val(periodo);
        $("#periodoInput").prop("disabled", false);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", false);

        $("#clienteIdInput").val(clienteid);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", false);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", false);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", false);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", false);

        inversion = inversion.toString().replace(",", ".");
        $("#inversionInput").val(inversion);
        $("#inversionInput").prop("readonly", false);

        inversionus = inversionus.toString().replace(",", ".");
        $("#inversionUsInput").val(inversionus);
        $("#inversionUsInput").prop("readonly", false);

        tipocambio = tipocambio.toString().replace(",", ".");
        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", false);

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", false);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", false);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", false);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", false);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", false);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#tipoCambioInputEUR").val(tipocambio_eur);
        $("#tipoCambioInputEUR").prop("readonly", false);

        $("#tipoCambioInputCHF").val(tipocambio_chf);
        $("#tipoCambioInputCHF").prop("readonly", false);

        inversion_eur = inversion_eur.toString().replace(",", ".");
        $("#inversionInputEUR").val(inversion_eur);
        $("#inversionInputEUR").prop("readonly", false);

        inversion_chf = inversion_chf.toString().replace(",", ".");
        $("#inversionInputCHF").val(inversion_chf);
        $("#inversionInputCHF").prop("readonly", false);

        $("#inversionLetInputEUR").val(inversionlet_eur);
        $("#inversionLetInputEUR").prop("readonly", false);

        $("#inversionLetInputCHF").val(inversionlet_chf);
        $("#inversionLetInputCHF").prop("readonly", false);

        $("#monedaDolaresInput").prop("disabled", false);
        $("#monedaDolaresInput").prop("checked", false);

        $("#monedaEurosInput").prop("disabled", false);
        $("#monedaEurosInput").prop("checked", false);

        $("#monedaFrancosInput").prop("disabled", false);
        $("#monedaFrancosInput").prop("checked", false);

        if (moneda == "dolares") {
            $("#monedaDolaresInput").prop("checked", true);
            $("#inversionInputEUR").val(inversionus);
            $("#inversionInputCHF").val(inversionus);

            $(".contEuro").hide();
            $(".contFranco").hide();
            $(".contDolar").show();
        } else if (moneda == "euros") {
            $("#monedaEurosInput").prop("checked", true);
            $("#inversionUsInput").val(inversion_eur);
            $("#inversionInputCHF").val(inversion_eur);

            $(".contDolar").hide();
            $(".contFranco").hide();
            $(".contEuro").show();
        } else if (moneda == "francos") {
            $("#monedaFrancosInput").prop("checked", true);
            $("#inversionUsInput").val(inversion_chf);
            $("#inversionInputEUR").val(inversion_chf);

            $(".contDolar").hide();
            $(".contEuro").hide();
            $(".contFranco").show();
        }

        $("#beneficiariosInput").prop("disabled", false);

        containerHide();

        $("#comprobantePagoInput").prop("disabled", false);
        $("#comprobantePagoInput").prop("required", false);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", false);
        $("#transferenciaSwissInput").prop("disabled", false);
        $("#transferenciaMXInput").prop("disabled", false);
        $("#ciBankInput").prop("disabled", false);
        $("#wiseInput").prop("disabled", false);
        $("#hsbcInput").prop("disabled", false);
        $("#renovacionInput").prop("disabled", false);
        $("#rendimientosInput").prop("disabled", false);
        $("#comisionesInput").prop("disabled", false);
        $("#bitsoInput").prop("disabled", false);
        tipoPago(this);

        $("#montoEfectivoInput").prop("disabled", false);
        $("#montoTransSwissPOOLInput").prop("disabled", false);
        $("#montoTransMXPOOLInput").prop("disabled", false);
        $("#montoBankInput").prop("disabled", false);
        $("#montoWiseInput").prop("disabled", false);
        $("#montoHSBCInput").prop("disabled", false);
        $("#montoRenovacionInput").prop("disabled", false);
        $("#montoRendimientosInput").prop("disabled", false);
        $("#montoComisionesInput").prop("disabled", false);
        $("#montoBitsoInput").prop("disabled", false);

        $("#referenciaTransSwissPOOLInput").prop("disabled", false);
        $("#referenciaTransMXPOOLInput").prop("disabled", false);
        $("#referenciaWiseInput").prop("disabled", false);
        $("#referenciaHSBCInput").prop("disabled", false);

        $("#cambiarPorcentajeInput").prop("disabled", false);

        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiarios",
            data: {
                id: id,
            },
            dataType: "json",
            success: function (response) {
                $("#beneficiariosInput").val(response.countBeneficiarios);
                if (response.countBeneficiarios > 0) {
                    $("#contBeneficiarios").empty();
                    for (var i = 1; i <= response.countBeneficiarios; i++) {
                        var adjetivo = "";
                        if (i == 1) {
                            adjetivo = "primer";
                        } else if (i == 2) {
                            adjetivo = "segundo";
                        } else if (i == 3) {
                            adjetivo = "tercer";
                        } else if (i == 4) {
                            adjetivo = "cuarto";
                        }
                        $("#contBeneficiarios").append(`             
                            <div class="col-12">
                                <div class="alert alert-primary d-flex align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                        aria-label="Info:">
                                        <use xlink:href="#info-fill" />
                                    </svg>
                                    <div>
                                        Ingresa al ${adjetivo} beneficiario en caso de fallecimiento del cliente:
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa el nombre del ${adjetivo} beneficiario" id="nombreBen${i}Input"
                                        name="nombre-ben${i}" minlength="3" maxlength="255">
                                    <label for="nombreBen${i}Input">Nombre del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" step="any" class="form-control"
                                        placeholder="Ingresa el porcentaje del ${adjetivo} beneficiario" id="porcentajeBen${i}Input"
                                        name="porcentaje-ben${i}" value="0">
                                    <label for="porcentajeBen${i}Input">Porcentaje del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control"
                                        placeholder="Ingresa el telefono del ${adjetivo} beneficiario" id="telefonoBen${i}Input"
                                        name="telefono-ben${i}" minlength="3" maxlength="100">
                                    <label for="telefonoBen${i}Input">Teléfono del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" class="form-control"
                                        placeholder="Ingresa el correo del ${adjetivo} beneficiario" id="correoBen${i}Input"
                                        name="correo-ben${i}" minlength="3" maxlength="100">
                                    <label for="correoBen${i}Input">Correo del ${adjetivo} beneficiario</label>
                                </div>
                            </div>                            
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa la curp del ${adjetivo} beneficiario" id="curpBen${i}Input"
                                        name="curp-ben${i}" minlength="3" maxlength="100">
                                    <label for="curpBen${i}Input">CURP del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                        `);

                        $(`#nombreBen${i}Input`).prop("readonly", false);
                        $(`#porcentajeBen${i}Input`).prop("readonly", false);
                        $(`#telefonoBen${i}Input`).prop("readonly", false);
                        $(`#correoBen${i}Input`).prop("readonly", false);
                        $(`#curpBen${i}Input`).prop("readonly", false);
                        $(`#curpBen${i}InputCheck`).prop("disabled", false);
                    }
                    if (response.beneficiarios[0]) {
                        var nombreben1 = response.beneficiarios[0].nombre;
                        var porcentajeben1 =
                            response.beneficiarios[0].porcentaje;
                        var telefonoben1 = response.beneficiarios[0].telefono;
                        var correoben1 =
                            response.beneficiarios[0].correo_electronico;
                        var curpben1 = response.beneficiarios[0].curp;

                        $("#nombreBen1Input").val(nombreben1);
                        $("#porcentajeBen1Input").val(porcentajeben1);
                        $("#telefonoBen1Input").val(telefonoben1);
                        $("#correoBen1Input").val(correoben1);
                        $("#curpBen1Input").val(curpben1);
                    } else {
                        $("#nombreBen1Input").val("");
                        $("#porcentajeBen1Input").val(0);
                        $("#telefonoBen1Input").val("");
                        $("#correoBen1Input").val("");
                        $("#curpBen1Input").val("");
                    }

                    if (response.beneficiarios[1]) {
                        var nombreben2 = response.beneficiarios[1].nombre;
                        var porcentajeben2 =
                            response.beneficiarios[1].porcentaje;
                        var telefonoben2 = response.beneficiarios[1].telefono;
                        var correoben2 =
                            response.beneficiarios[1].correo_electronico;
                        var curpben2 = response.beneficiarios[1].curp;

                        $("#nombreBen2Input").val(nombreben2);
                        $("#porcentajeBen2Input").val(porcentajeben2);
                        $("#telefonoBen2Input").val(telefonoben2);
                        $("#correoBen2Input").val(correoben2);
                        $("#curpBen2Input").val(curpben2);
                    } else {
                        $("#nombreBen2Input").val("");
                        $("#porcentajeBen2Input").val(0);
                        $("#telefonoBen2Input").val("");
                        $("#correoBen2Input").val("");
                        $("#curpBen2Input").val("");
                    }

                    if (response.beneficiarios[2]) {
                        var nombreben3 = response.beneficiarios[2].nombre;
                        var porcentajeben3 =
                            response.beneficiarios[2].porcentaje;
                        var telefonoben3 = response.beneficiarios[2].telefono;
                        var correoben3 =
                            response.beneficiarios[2].correo_electronico;
                        var curpben3 = response.beneficiarios[2].curp;

                        $("#nombreBen3Input").val(nombreben3);
                        $("#porcentajeBen3Input").val(porcentajeben3);
                        $("#telefonoBen3Input").val(telefonoben3);
                        $("#correoBen3Input").val(correoben3);
                        $("#curpBen3Input").val(curpben3);
                    } else {
                        $("#nombreBen3Input").val("");
                        $("#porcentajeBen3Input").val(0);
                        $("#telefonoBen3Input").val("");
                        $("#correoBen3Input").val("");
                        $("#curpBen3Input").val("");
                    }

                    if (response.beneficiarios[3]) {
                        var nombreben4 = response.beneficiarios[3].nombre;
                        var porcentajeben4 =
                            response.beneficiarios[3].porcentaje;
                        var telefonoben4 = response.beneficiarios[3].telefono;
                        var correoben4 =
                            response.beneficiarios[3].correo_electronico;
                        var curpben4 = response.beneficiarios[3].curp;

                        $("#nombreBen4Input").val(nombreben4);
                        $("#porcentajeBen4Input").val(porcentajeben4);
                        $("#telefonoBen4Input").val(telefonoben4);
                        $("#correoBen4Input").val(correoben4);
                        $("#curpBen4Input").val(curpben4);
                    } else {
                        $("#nombreBen4Input").val("");
                        $("#porcentajeBen4Input").val(0);
                        $("#telefonoBen4Input").val("");
                        $("#correoBen4Input").val("");
                        $("#curpBen4Input").val("");
                    }
                } else {
                    $("#beneficiariosInput").val(1);
                    $("#contBeneficiarios").empty();
                    $("#contBeneficiarios").append(`
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Ingresa al beneficiario en caso de fallecimiento del cliente:
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control"
                                    placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input"
                                    name="nombre-ben1" minlength="3" maxlength="255">
                                <label for="nombreBen1Input">Nombre del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                                    name="porcentaje-ben1" value="0">
                                <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control"
                                    placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                                    name="telefono-ben1" minlength="3" maxlength="100">
                                <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">                                
                                <input type="text" class="form-control"
                                    placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                                    name="correo-ben1" minlength="3" maxlength="100">
                                <label for="correoBen1Input">Correo del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                    placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                                    name="curp-ben1" minlength="3" maxlength="100">
                                <label for="curpBen1Input">CURP del beneficiario</label>
                            </div>
                        </div>
                `);
                }
            },
        });

        $(".status_reintegro").show();
        $(".memo_reintegro").show();

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

        $("#modalTitle").text(`Editar contrato de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar contrato");
        $("#btnCancel").text("Cancelar");

        $("#contPagos").empty();
        $(".cont-tabla").empty();

        var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
            "data-tipo"
        );

        let monedaDolaresChecked = $("#monedaDolaresInput").is(":checked");
        let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
        let monedaFrancosChecked = $("#monedaFrancosInput").is(":checked");
        let capital_nombre = "";

        if (monedaDolaresChecked) {
            var inversionUSD = $("#inversionUsInput").val();
            capital_nombre = "Capital (USD)";
        } else if (monedaEurosChecked) {
            var inversionUSD = $("#inversionInputEUR").val();
            capital_nombre = "Capital (EUR)";
        } else if (monedaFrancosChecked) {
            var inversionUSD = $("#inversionInputCHF").val();
            capital_nombre = "Capital (CHF)";
        }

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">${capital_nombre}</th>
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
                                <th scope="col">${capital_nombre}</th>
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

        inversionUSD = parseFloat(inversionUSD);
        // var inversionInicialUSD = parseFloat(inversionUSD);

        var porcentaje = $("#porcentajeInput").val();
        porcentaje = parseFloat(porcentaje);

        var fecha = $("#fechaInicioInput").val();

        var porcentaje = $("#porcentajeInput").val();
        var usd = parseFloat($("#tipoCambioInput").val());

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
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar el contrato</p>',
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
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteContrato",
                                {
                                    id: id,
                                },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato eliminado</h1>',
                                        html: '<p style="font-family: Poppins">El contrato se ha eliminado correctamente</p>',
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
                                html: '<p style="font-family: Poppins">El contrato no se ha eliminado porque la clave es incorrecta</p>',
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
                            html: '<p style="font-family: Poppins">El contrato no se ha eliminado porque la clave no es correcta</p>',
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
                    html: '<p style="font-family: Poppins">El contrato no se ha eliminado</p>',
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

        window.location.href = "/admin/contrato/vercontrato?id=" + id;
    });

    var meses = $("#periodoInput").val();
    $("#formModal").on("keyup change", function (event) {
        $("#periodoInput").val(meses);
        $("#tablaBody").empty();

        var target = $(event.target);

        if (target.is("#tipoIdInput")) {
            var select = $("#tipoIdInput");

            var capertura = $("option:selected", select).attr("data-capertura");
            var cmensual = $("option:selected", select).attr("data-cmensual");
            var rendimiento = $("option:selected", select).attr(
                "data-rendimiento"
            );

            $("#porcentajeInput").val(rendimiento);
        }

        if (target.is("#inversionInput")) {
            if ($("#tipoCambioInput").val()) {
                var peso = $("#inversionInput").val();

                var dolar_peso = $("#tipoCambioInput").val();
                var dolares = peso / dolar_peso;
                $("#inversionUsInput").val(dolares.toFixed(2));

                var euro_peso = $("#tipoCambioInputEUR").val();
                let euros = peso / euro_peso;
                $("#inversionInputEUR").val(euros.toFixed(2));

                var franco_peso = $("#tipoCambioInputCHF").val();
                let francos = peso / franco_peso;
                $("#inversionInputCHF").val(francos.toFixed(2));
            }
            //Condicional para refrendo
            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionMXN != $("#inversionInput").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionUsInput").val())
            );
            $("#inversionLetInputEUR").val(
                numeroALetrasEUR($("#inversionInputEUR").val())
            );
            $("#inversionLetInputCHF").val(
                numeroALetrasCHF($("#inversionInputCHF").val())
            );
        } else if (target.is("#inversionUsInput")) {
            if ($("#tipoCambioInput").val()) {
                var dolar = $("#inversionUsInput").val();

                var dolar_peso = $("#tipoCambioInput").val();
                var pesos = dolar * dolar_peso;
                $("#inversionInput").val(pesos.toFixed(2));

                $("#inversionInputEUR").val(dolar);
                $("#inversionInputCHF").val(dolar);
            }

            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionUS != $("#inversionUsInput").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionUsInput").val())
            );
            $("#inversionLetInputEUR").val(
                numeroALetrasEUR($("#inversionUsInput").val())
            );
            $("#inversionLetInputCHF").val(
                numeroALetrasCHF($("#inversionUsInput").val())
            );
        } else if (target.is("#inversionInputEUR")) {
            if ($("#tipoCambioInputEUR").val()) {
                var euro = $("#inversionInputEUR").val();

                var euro_peso = $("#tipoCambioInputEUR").val();
                let euros = euro * euro_peso;
                $("#inversionInput").val(euros.toFixed(2));

                $("#inversionUsInput").val(euro);
                $("#inversionInputCHF").val(euro);
            }

            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionEUR != $("#inversionInputEUR").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionInputEUR").val())
            );
            $("#inversionLetInputEUR").val(
                numeroALetrasEUR($("#inversionInputEUR").val())
            );
            $("#inversionLetInputCHF").val(
                numeroALetrasCHF($("#inversionInputEUR").val())
            );
        } else if (target.is("#inversionInputCHF")) {
            if ($("#tipoCambioInputCHF").val()) {
                var franco = $("#inversionInputCHF").val();

                var franco_peso = $("#tipoCambioInputCHF").val();
                let francos = franco * franco_peso;
                $("#inversionInput").val(francos.toFixed(2));

                $("#inversionUsInput").val(franco);
                $("#inversionInputEUR").val(franco);
            }

            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionCHF != $("#inversionInputCHF").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionInputCHF").val())
            );
            $("#inversionLetInputEUR").val(
                numeroALetrasEUR($("#inversionInputCHF").val())
            );
            $("#inversionLetInputCHF").val(
                numeroALetrasCHF($("#inversionInputCHF").val())
            );
        }

        if ($("#fechaInicioInput").val()) {
            var fechaInicio = $("#fechaInicioInput").val();
            fechaInicio = new Date(fechaInicio);
            fechaInicio = fechaInicio.addDays(1);

            var fechaReintegro = new Date(
                fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
            );

            var fechaPago = fechaReintegro.outDays(1);
            fechaPago = formatDate(new Date(fechaPago));
            fechaPago = fechaPago.split("/").reverse().join("-");
            $("#fechaPagInput").val(fechaPago);

            var fechaLimite = fechaReintegro.addDays(14);
            fechaLimite = formatDate(new Date(fechaLimite));
            fechaLimite = fechaLimite.split("/").reverse().join("-");
            $("#fechaLimiteInput").val(fechaLimite);

            var fechaRenovacion = fechaReintegro;
            fechaRenovacion = formatDate(new Date(fechaRenovacion));
            fechaRenovacion = fechaRenovacion.split("/").reverse().join("-");
            $("#fechaRenInput").val(fechaRenovacion);

            fechaReintegro = formatDate(new Date(fechaReintegro));
            fechaReintegro = fechaReintegro.split("/").reverse().join("-");
            $("#fechaReinInput").val(fechaReintegro);
        }

        if (
            $("#inversionInput").val() &&
            $("#inversionUsInput").val() &&
            $("#tipoCambioInput").val() &&
            $("#fechaInicioInput").val() &&
            $("#fechaRenInput").val() &&
            $("#fechaPagInput").val() &&
            $("#fechaLimiteInput").val() &&
            $("#tipoIdInput").val() &&
            $("#porcentajeInput").val()
        ) {
            $("#contPagos").empty();
            $(".cont-tabla").empty();

            var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                "data-tipo"
            );

            let monedaDolaresChecked = $("#monedaDolaresInput").is(":checked");
            let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
            let monedaFrancosChecked = $("#monedaFrancosInput").is(":checked");
            let capital_nombre = "";

            if (monedaDolaresChecked) {
                var inversionUSD = $("#inversionUsInput").val();
                capital_nombre = "Capital (USD)";
            } else if (monedaEurosChecked) {
                var inversionUSD = $("#inversionInputEUR").val();
                capital_nombre = "Capital (EUR)";
            } else if (monedaFrancosChecked) {
                var inversionUSD = $("#inversionInputCHF").val();
                capital_nombre = "Capital (CHF)";
            }

            if (tipo_contrato == "Rendimiento compuesto") {
                $(".cont-tabla").append(`
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Serie</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">${capital_nombre}</th>
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
                                    <th scope="col">${capital_nombre}</th>
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

            inversionUSD = parseFloat(inversionUSD);

            var porcentaje = $("#porcentajeInput").val();
            porcentaje = parseFloat(porcentaje);

            var fecha = $("#fechaInicioInput").val();
            var fechaFeb = $("#fechaInicioInput").val();
            fechaFeb = fechaFeb.split("-");

            var porcentaje = $("#porcentajeInput").val();

            var cmensual2 = `0.0${cmensual}`;
            cmensual2 = parseFloat(cmensual2);

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
                var pagoPS = cmensual2 * inversionUSD;

                $("#contPagos").append(
                    `
                    <input type="hidden" name="serie-reintegro${
                        i + 1
                    }" id="serieReintegro${i + 1}Input" value="${i + 1}">
                    <input type="hidden" name="fecha-reintegro${
                        i + 1
                    }" id="fechaReintegro${i + 1}Input" value="${fechaInput}">
                    <input type="hidden" name="monto-reintegro${
                        i + 1
                    }" id="montoReintegro${i + 1}Input" value="${monto.toFixed(
                        2
                    )}">
                    <input type="hidden" name="redito-reintegro${
                        i + 1
                    }" id="reditoReintegro${
                        i + 1
                    }Input" value="${redito.toFixed(2)}">
                    <input type="hidden" name="montoredito-reintegro${
                        i + 1
                    }" id="montoReditoReintegro${
                        i + 1
                    }Input" value="${monto_redito.toFixed(2)}">

                    <input type="hidden" name="monto-pagops${
                        i + 1
                    }" id="montoPagoPs${i + 1}Input" value="${pagoPS.toFixed(
                        2
                    )}">
                    `
                );

                if (tipo_contrato == "Rendimiento compuesto") {
                    // rendimiento = inversionUSD * porcentaje2 + rendimiento;

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
        }

        //condicional de refrendo con nuevas fechas
        if (target.is("#statusInput") && event.type == "change") {
            if ($("#statusInput").val() == "Refrendado") {
                $.ajax({
                    type: "GET",
                    url: "/admin/getFolio",
                    success: function (data) {
                        $("#folioInput").val(data);
                    },
                    error: function (data) {
                        console.log(data);
                    },
                });

                if (acc == "new") {
                    dataInversionMXN = $("#inversionInput").val();
                    dataInversionMXN = parseFloat(dataInversionMXN);

                    dataInversionUS = $("#inversionUsInput").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataInversionEUR = $("#inversionInputEUR").val();
                    dataInversionEUR = parseFloat(dataInversionEUR);

                    dataInversionCHF = $("#inversionInputCHF").val();
                    dataInversionCHF = parseFloat(dataInversionCHF);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contMemoCan").addClass("d-none");

                $("#contPagos").empty();
                $(".cont-tabla").empty();

                var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                    "data-tipo"
                );

                let monedaDolaresChecked = $("#monedaDolaresInput").is(
                    ":checked"
                );
                let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
                let monedaFrancosChecked = $("#monedaFrancosInput").is(
                    ":checked"
                );
                let capital_nombre = "";

                if (monedaDolaresChecked) {
                    var inversionUSD = $("#inversionUsInput").val();
                    capital_nombre = "Capital (USD)";
                } else if (monedaEurosChecked) {
                    var inversionUSD = $("#inversionInputEUR").val();
                    capital_nombre = "Capital (EUR)";
                } else if (monedaFrancosChecked) {
                    var inversionUSD = $("#inversionInputCHF").val();
                    capital_nombre = "Capital (CHF)";
                }

                if (tipo_contrato == "Rendimiento compuesto") {
                    $(".cont-tabla").append(
                        `
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serie</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">${capital_nombre}</th>
                                            <th scope="col">Interés</th>
                                            <th scope="col">Rendimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaBody">                        
                                    </tbody>
                                </table>
                            </div>
                        `
                    );
                } else if (tipo_contrato == "Rendimiento mensual") {
                    $(".cont-tabla").append(
                        `
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serie</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">${capital_nombre}</th>
                                            <th scope="col">Interés</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaBody">                        
                                    </tbody>
                                </table>
                            </div>
                        `
                    );
                }

                var cmensual = $("option:selected", "#tipoIdInput").attr(
                    "data-cmensual"
                );

                cmensual = parseFloat(cmensual);
                var cmensual2 = `0.0${cmensual}`;
                cmensual2 = parseFloat(cmensual2);

                var inversionMXN = $("#inversionInput").val();
                inversionMXN = parseFloat(inversionMXN);

                inversionUSD = parseFloat(inversionUSD);
                // var inversionInicialUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput").val();
                porcentaje = parseFloat(porcentaje);

                $("#fechaInicioInput").val($("#fechaRenInput").val());

                var fecha = $("#fechaRenInput").val();

                var fechaInicio = $("#fechaRenInput").val();
                fechaInicio = new Date(fechaInicio);
                fechaInicio = fechaInicio.addDays(1);

                var fechaReintegro = new Date(
                    fechaInicio.setMonth(
                        fechaInicio.getMonth() + parseInt(meses)
                    )
                );

                var fechaPago = fechaReintegro.outDays(1);
                fechaPago = formatDate(new Date(fechaPago));
                fechaPago = fechaPago.split("/").reverse().join("-");
                $("#fechaPagInput").val(fechaPago);

                var fechaLimite = fechaReintegro.addDays(14);
                fechaLimite = formatDate(new Date(fechaLimite));
                fechaLimite = fechaLimite.split("/").reverse().join("-");
                $("#fechaLimiteInput").val(fechaLimite);

                var fechaRenovacion = fechaReintegro;
                fechaRenovacion = formatDate(new Date(fechaRenovacion));
                fechaRenovacion = fechaRenovacion
                    .split("/")
                    .reverse()
                    .join("-");
                $("#fechaRenInput").val(fechaRenovacion);

                fechaReintegro = formatDate(new Date(fechaReintegro));
                fechaReintegro = fechaReintegro.split("/").reverse().join("-");
                $("#fechaReinInput").val(fechaReintegro);

                var formatterUSD = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                });

                var formatterMXN = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN",
                });

                if (tipo_contrato == "Rendimiento compuesto") {
                    for (var i = 0; i < meses; i++) {
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;

                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                    }
                }

                $("#inversionUsInput").val(inversionUSD.toFixed(2));
                $("#inversionInput").val(inversionMXN.toFixed(2));

                $("#inversionLetInput").val(
                    numeroALetrasMXN($("#inversionInput").val())
                );
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD($("#inversionUsInput").val())
                );
                $("#inversionLetInputEUR").val(
                    numeroALetrasEUR($("#inversionUsInput").val())
                );
                $("#inversionLetInputCHF").val(
                    numeroALetrasCHF($("#inversionUsInput").val())
                );

                // var rendimiento = 0;
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
                    var pagoPS = cmensual2 * inversionUSD;

                    $("#contPagos").append(
                        `
                        <input type="hidden" name="serie-reintegro${
                            i + 1
                        }" id="serieReintegro${i + 1}Input" value="${i + 1}">
                        <input type="hidden" name="fecha-reintegro${
                            i + 1
                        }" id="fechaReintegro${
                            i + 1
                        }Input" value="${fechaInput}">
                        <input type="hidden" name="monto-reintegro${
                            i + 1
                        }" id="montoReintegro${
                            i + 1
                        }Input" value="${monto.toFixed(2)}">
                        <input type="hidden" name="redito-reintegro${
                            i + 1
                        }" id="reditoReintegro${
                            i + 1
                        }Input" value="${redito.toFixed(2)}">
                        <input type="hidden" name="montoredito-reintegro${
                            i + 1
                        }" id="montoReditoReintegro${
                            i + 1
                        }Input" value="${monto_redito.toFixed(2)}">

            <input type="hidden" name="monto-pagops${i + 1}" id="montoPagoPs${
                            i + 1
                        }Input" value="${pagoPS.toFixed(2)}">
            `
                    );

                    if (tipo_contrato == "Rendimiento compuesto") {
                        $("#tablaBody").append(
                            ` 
                                <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${fecha}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD * porcentaje2
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD +
                                            inversionUSD * porcentaje2
                                    )}</td>
                                </tr>
                            `
                        );
                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;
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
            } else if ($("#statusInput").val() == "Activado") {
                if (acc == "new") {
                    dataInversionMXN = $("#inversionInput").val();
                    dataInversionMXN = parseFloat(dataInversionMXN);

                    dataInversionUS = $("#inversionUsInput").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataInversionEUR = $("#inversionInputEUR").val();
                    dataInversionEUR = parseFloat(dataInversionEUR);

                    dataInversionCHF = $("#inversionInputCHF").val();
                    dataInversionCHF = parseFloat(dataInversionCHF);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contMemoCan").addClass("d-none");
                $("#contPagos").empty();
                $(".cont-tabla").empty();

                var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                    "data-tipo"
                );

                let monedaDolaresChecked = $("#monedaDolaresInput").is(
                    ":checked"
                );
                let monedaEurosChecked = $("#monedaEurosInput").is(":checked");
                let monedaFrancosChecked = $("#monedaFrancosInput").is(
                    ":checked"
                );
                let capital_nombre = "";

                var inversionUSD = 0;
                if (monedaDolaresChecked) {
                    inversionUSD = dataInversionUS;
                    capital_nombre = "Capital (USD)";
                } else if (monedaEurosChecked) {
                    inversionUSD = dataInversionEUR;
                    capital_nombre = "Capital (EUR)";
                } else if (monedaFrancosChecked) {
                    inversionUSD = dataInversionCHF;
                    capital_nombre = "Capital (CHF)";
                }

                if (tipo_contrato == "Rendimiento compuesto") {
                    $(".cont-tabla").append(
                        `
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serie</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">${capital_nombre}</th>
                                            <th scope="col">Interés</th>
                                            <th scope="col">Rendimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaBody">                        
                                    </tbody>
                                </table>
                            </div>
                        `
                    );
                } else if (tipo_contrato == "Rendimiento mensual") {
                    $(".cont-tabla").append(
                        `
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Serie</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">${capital_nombre}</th>
                                            <th scope="col">Interés</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaBody">                        
                                    </tbody>
                                </table>
                            </div>
                        `
                    );
                }

                var cmensual = $("option:selected", "#tipoIdInput").attr(
                    "data-cmensual"
                );

                cmensual = parseFloat(cmensual);
                var cmensual2 = `0.0${cmensual}`;
                cmensual2 = parseFloat(cmensual2);

                var inversionMXN = dataInversionMXN;
                inversionMXN = parseFloat(inversionMXN);

                inversionUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput").val();
                porcentaje = parseFloat(porcentaje);

                dataFechaInicio = dataFechaInicio
                    .split("/")
                    .reverse()
                    .join("-");

                $("#fechaInicioInput").val(dataFechaInicio);

                var fecha = $("#fechaInicioInput").val();

                var fechaInicio = $("#fechaInicioInput").val();
                fechaInicio = new Date(fechaInicio);
                fechaInicio = fechaInicio.addDays(1);

                var fechaReintegro = new Date(
                    fechaInicio.setMonth(
                        fechaInicio.getMonth() + parseInt(meses)
                    )
                );

                var fechaPago = fechaReintegro.outDays(1);
                fechaPago = formatDate(new Date(fechaPago));
                fechaPago = fechaPago.split("/").reverse().join("-");
                $("#fechaPagInput").val(fechaPago);

                var fechaLimite = fechaReintegro.addDays(14);
                fechaLimite = formatDate(new Date(fechaLimite));
                fechaLimite = fechaLimite.split("/").reverse().join("-");
                $("#fechaLimiteInput").val(fechaLimite);

                var fechaRenovacion = fechaReintegro;
                fechaRenovacion = formatDate(new Date(fechaRenovacion));
                fechaRenovacion = fechaRenovacion
                    .split("/")
                    .reverse()
                    .join("-");
                $("#fechaRenInput").val(fechaRenovacion);

                fechaReintegro = formatDate(new Date(fechaReintegro));
                fechaReintegro = fechaReintegro.split("/").reverse().join("-");
                $("#fechaReinInput").val(fechaReintegro);

                var formatterUSD = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                });

                var formatterMXN = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN",
                });

                $("#inversionUsInput").val(inversionUSD.toFixed(2));
                $("#inversionInput").val(inversionMXN.toFixed(2));

                $("#inversionLetInput").val(
                    numeroALetrasMXN($("#inversionInput").val())
                );
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD($("#inversionUsInput").val())
                );
                $("#inversionLetInputEUR").val(
                    numeroALetrasEUR($("#inversionUsInput").val())
                );
                $("#inversionLetInputCHF").val(
                    numeroALetrasCHF($("#inversionUsInput").val())
                );

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
                    var pagoPS = cmensual2 * inversionUSD;

                    $("#contPagos").append(
                        `
                        <input type="hidden" name="serie-reintegro${
                            i + 1
                        }" id="serieReintegro${i + 1}Input" value="${i + 1}">
                        <input type="hidden" name="fecha-reintegro${
                            i + 1
                        }" id="fechaReintegro${
                            i + 1
                        }Input" value="${fechaInput}">
                        <input type="hidden" name="monto-reintegro${
                            i + 1
                        }" id="montoReintegro${
                            i + 1
                        }Input" value="${monto.toFixed(2)}">
                        <input type="hidden" name="redito-reintegro${
                            i + 1
                        }" id="reditoReintegro${
                            i + 1
                        }Input" value="${redito.toFixed(2)}">
                        <input type="hidden" name="montoredito-reintegro${
                            i + 1
                        }" id="montoReditoReintegro${
                            i + 1
                        }Input" value="${monto_redito.toFixed(2)}">

            <input type="hidden" name="monto-pagops${i + 1}" id="montoPagoPs${
                            i + 1
                        }Input" value="${pagoPS.toFixed(2)}">
            `
                    );

                    if (tipo_contrato == "Rendimiento compuesto") {
                        $("#tablaBody").append(
                            ` 
                                <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${fecha}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD * porcentaje2
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD +
                                            inversionUSD * porcentaje2
                                    )}</td>
                                </tr>
                            `
                        );
                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;
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
            } else if ($("#statusInput").val() == "Cancelado") {
                $("#contMemoCan").removeClass("d-none");
            } else {
                $("#contMemoCan").addClass("d-none");
            }
        }

        //APARTADO DE BENEFICIARIOS
        if (target.is("#beneficiariosInput")) {
            $("#contBeneficiarios").empty();

            var beneficiarios = $("#beneficiariosInput").val();

            if (beneficiarios != "") {
                for (var i = 1; i <= beneficiarios; i++) {
                    var adjetivo = "";
                    if (i == 1) {
                        adjetivo = "primer";
                    } else if (i == 2) {
                        adjetivo = "segundo";
                    } else if (i == 3) {
                        adjetivo = "tercer";
                    } else if (i == 4) {
                        adjetivo = "cuarto";
                    }
                    $("#contBeneficiarios").append(`             
                        <div class="col-12">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                    aria-label="Info:">
                                    <use xlink:href="#info-fill" />
                                </svg>
                                <div>
                                    Ingresa al ${adjetivo} beneficiario en caso de fallecimiento del cliente:
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control"
                                    placeholder="Ingresa el nombre del ${adjetivo} beneficiario" id="nombreBen${i}Input"
                                    name="nombre-ben${i}" minlength="3" maxlength="255">
                                <label for="nombreBen${i}Input">Nombre del ${adjetivo} beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa el porcentaje del ${adjetivo} beneficiario" id="porcentajeBen${i}Input"
                                    name="porcentaje-ben${i}" value="0">
                                <label for="porcentajeBen${i}Input">Porcentaje del ${adjetivo} beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control"
                                    placeholder="Ingresa el telefono del ${adjetivo} beneficiario" id="telefonoBen${i}Input"
                                    name="telefono-ben${i}" minlength="3" maxlength="100">
                                <label for="telefonoBen${i}Input">Teléfono del ${adjetivo} beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input style="text-transform: lowercase;" type="email" class="form-control"
                                    placeholder="Ingresa el correo del ${adjetivo} beneficiario" id="correoBen${i}Input"
                                    name="correo-ben${i}" minlength="3" maxlength="100">
                                <label for="correoBen${i}Input">Correo del ${adjetivo} beneficiario</label>
                            </div>
                        </div>                        
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                    placeholder="Ingresa la curp del ${adjetivo} beneficiario" id="curpBen${i}Input"
                                    name="curp-ben${i}" minlength="3" maxlength="100">
                                <label for="curpBen${i}Input">CURP del ${adjetivo} beneficiario</label>
                            </div>
                        </div>
                    `);
                }

                if (beneficiarios == 1) {
                    $("#nombreBen1Input").keyup(function () {
                        $("#porcentajeBen1Input").val(100);
                    });
                }

                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen1Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );

                    if (porcentajeben1 > 100 || porcentajeben1 < 0) {
                        let nuevo_porcentaje = 100 / beneficiarios;
                        $("#porcentajeBen1Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen2Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen3Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen4Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                    } else {
                        if (beneficiarios == 2) {
                            var porcentajeRestante = 100 - porcentajeben1;
                            $("#porcentajeBen2Input").val(porcentajeRestante);
                        } else if (beneficiarios == 3) {
                            var porcentajeRestante = (100 - porcentajeben1) / 2;
                            $("#porcentajeBen2Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                            $("#porcentajeBen3Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                        } else if (beneficiarios == 4) {
                            var porcentajeRestante = (100 - porcentajeben1) / 3;
                            $("#porcentajeBen2Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                            $("#porcentajeBen3Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                            $("#porcentajeBen4Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                        }
                    }
                });
                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen2Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );
                    var porcentajeben2 = parseInt(
                        $("#porcentajeBen2Input").val()
                    );
                    if (porcentajeben2 > 100 || porcentajeben2 < 0) {
                        let nuevo_porcentaje = 100 / beneficiarios;
                        $("#porcentajeBen1Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen2Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen3Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen4Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                    } else {
                        if (beneficiarios == 2) {
                            var porcentajeRestante = 100 - porcentajeben2;
                            $("#porcentajeBen1Input").val(
                                porcentajeRestante.toFixed(2)
                            );
                        } else if (beneficiarios == 3) {
                            var porcentajeRestante =
                                100 - (porcentajeben1 + porcentajeben2);
                            var sumaPorcentajes =
                                porcentajeben1 + porcentajeben2;
                            if (sumaPorcentajes > 100) {
                                var porcentajeRestante =
                                    (100 - porcentajeben1) / 2;
                                $("#porcentajeBen2Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            } else {
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            }
                        } else if (beneficiarios == 4) {
                            var porcentajeRestante =
                                100 - (porcentajeben1 + porcentajeben2);
                            var sumaPorcentajes =
                                porcentajeben1 + porcentajeben2;
                            if (sumaPorcentajes > 100) {
                                var porcentajeRestante =
                                    (100 - porcentajeben1) / 3;
                                $("#porcentajeBen2Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen4Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            } else {
                                porcentajeRestante = porcentajeRestante / 2;
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen4Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            }
                        }
                    }
                });
                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen3Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );
                    var porcentajeben2 = parseInt(
                        $("#porcentajeBen2Input").val()
                    );
                    var porcentajeben3 = parseInt(
                        $("#porcentajeBen3Input").val()
                    );

                    if (porcentajeben3 > 100 || porcentajeben3 < 0) {
                        let nuevo_porcentaje = 100 / beneficiarios;
                        $("#porcentajeBen1Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen2Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen3Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen4Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                    } else {
                        if (beneficiarios == 4) {
                            // var sumaPorcentajes =
                            //     porcentajeben1 +
                            //     porcentajeben2 +
                            //     porcentajeben3;

                            // if (sumaPorcentajes > 100.0) {
                            //     var porcentajeRestante =
                            //         100 -
                            //         (porcentajeben1 +
                            //             porcentajeben2 +
                            //             porcentajeben3);
                            //     $("#porcentajeBen4Input").val(
                            //         porcentajeRestante
                            //     );
                            // } else {
                            //     var porcentajeRestante =
                            //         (100 - porcentajeben3) / 3;
                            //     $("#porcentajeBen1Input").val(
                            //         porcentajeRestante
                            //     );
                            //     $("#porcentajeBen2Input").val(
                            //         porcentajeRestante
                            //     );
                            //     $("#porcentajeBen4Input").val(
                            //         porcentajeRestante
                            //     );
                            // }
                            var porcentajeRestante =
                                100 -
                                (porcentajeben1 +
                                    porcentajeben2 +
                                    porcentajeben3);
                            var sumaPorcentajes =
                                porcentajeben1 +
                                porcentajeben2 +
                                porcentajeben3;
                            if (sumaPorcentajes > 100) {
                                var porcentajeRestante =
                                    (100 - porcentajeben1) / 3;
                                $("#porcentajeBen2Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                                $("#porcentajeBen4Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            } else {
                                $("#porcentajeBen4Input").val(
                                    porcentajeRestante.toFixed(2)
                                );
                            }
                        } else {
                            var sumaPorcentajes =
                                porcentajeben1 +
                                porcentajeben2 +
                                porcentajeben3;

                            if (sumaPorcentajes > 100.0) {
                                var porcentajeRestante =
                                    100 - (porcentajeben1 + porcentajeben2);
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante
                                );
                            } else {
                                var porcentajeRestante =
                                    (100 - porcentajeben3) / 2;
                                $("#porcentajeBen1Input").val(
                                    porcentajeRestante
                                );
                                $("#porcentajeBen2Input").val(
                                    porcentajeRestante
                                );
                            }
                        }
                    }
                });
                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen4Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );
                    var porcentajeben2 = parseInt(
                        $("#porcentajeBen2Input").val()
                    );
                    var porcentajeben3 = parseInt(
                        $("#porcentajeBen3Input").val()
                    );
                    var porcentajeben4 = parseInt(
                        $("#porcentajeBen4Input").val()
                    );

                    if (porcentajeben4 > 100 || porcentajeben4 < 0) {
                        let nuevo_porcentaje = 100 / beneficiarios;
                        $("#porcentajeBen1Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen2Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen3Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                        $("#porcentajeBen4Input").val(
                            nuevo_porcentaje.toFixed(2)
                        );
                    } else {
                        var sumaPorcentajes =
                            porcentajeben1 +
                            porcentajeben2 +
                            porcentajeben3 +
                            porcentajeben4;

                        if (sumaPorcentajes > 100.0) {
                            var porcentajeRestante =
                                100 -
                                (porcentajeben1 +
                                    porcentajeben2 +
                                    porcentajeben3);
                            $("#porcentajeBen4Input").val(porcentajeRestante);
                        } else {
                            var porcentajeRestante = (100 - porcentajeben4) / 3;
                            $("#porcentajeBen1Input").val(porcentajeRestante);
                            $("#porcentajeBen2Input").val(porcentajeRestante);
                            $("#porcentajeBen3Input").val(porcentajeRestante);
                        }
                    }
                });
            }
        }
        var beneficiarios = $("#beneficiariosInput").val();
        if (beneficiarios == 1) {
            let nombreBeneficiario = $("#nombreBen1Input").val();
            if (
                target.is("#nombreBen1Input") ||
                nombreBeneficiario.length > 0
            ) {
                $("#porcentajeBen1Input").val(100);
            }
        }

        //APARTADO SOBRE EL MONTO DE LA(S) TRANSFERENCIA(S)
        if (target.is("#efectivoInput")) {
            let efectivoChecked = $("#efectivoInput").is(":checked");

            if (efectivoChecked) {
                $("#montoEfectivoCont").show();
                $("#montoEfectivoInput").prop("required", true);
            } else {
                $("#montoEfectivoCont").hide();
                $("#montoEfectivoInput").prop("required", false);
            }
        }
        if (target.is("#transferenciaSwissInput")) {
            let transferenciaSwissChecked = $("#transferenciaSwissInput").is(
                ":checked"
            );

            if (transferenciaSwissChecked) {
                $("#montoTransSwissPOOLCont").show();
                $("#montoTransSwissPOOLInput").prop("required", true);
                $("#referenciaTransSwissPOOLCont").show();
                $("#referenciaTransSwissPOOLInput").prop("required", true);
            } else {
                $("#montoTransSwissPOOLCont").hide();
                $("#montoTransSwissPOOLInput").prop("required", false);
                $("#referenciaTransSwissPOOLCont").hide();
                $("#referenciaTransSwissPOOLInput").prop("required", false);
            }
        }
        if (target.is("#transferenciaMXInput")) {
            let transferenciaMXChecked = $("#transferenciaMXInput").is(
                ":checked"
            );

            if (transferenciaMXChecked) {
                $("#montoTransMXPOOLCont").show();
                $("#montoTransMXPOOLInput").prop("required", true);
                $("#referenciaTransMXPOOLCont").show();
                $("#referenciaTransMXPOOLInput").prop("required", true);
            } else {
                $("#montoTransMXPOOLCont").hide();
                $("#montoTransMXPOOLInput").prop("required", false);
                $("#referenciaTransMXPOOLCont").hide();
                $("#referenciaTransMXPOOLInput").prop("required", false);
            }
        }
        if (target.is("#ciBankInput")) {
            let ciBankChecked = $("#ciBankInput").is(":checked");

            if (ciBankChecked) {
                $("#montoBankCont").show();
                $("#montoBankInput").prop("required", true);
            } else {
                $("#montoBankCont").hide();
                $("#montoBankInput").prop("required", false);
            }
        }
        if (target.is("#wiseInput")) {
            let wiseChecked = $("#wiseInput").is(":checked");

            if (wiseChecked) {
                $("#montoWiseCont").show();
                $("#montoWiseInput").prop("required", true);
                $("#referenciaWiseCont").show();
                $("#referenciaWiseInput").prop("required", true);
            } else {
                $("#montoWiseCont").hide();
                $("#montoWiseInput").prop("required", false);
                $("#referenciaWiseCont").hide();
                $("#referenciaWiseInput").prop("required", false);
            }
        }
        if (target.is("#hsbcInput")) {
            let hsbcChecked = $("#hsbcInput").is(":checked");

            if (hsbcChecked) {
                $("#montoHSBCCont").show();
                $("#montoHSBCInput").prop("required", true);
                $("#referenciaHSBCCont").show();
                $("#referenciaHSBCInput").prop("required", true);
            } else {
                $("#montoHSBCCont").hide();
                $("#montoHSBCInput").prop("required", false);
                $("#referenciaHSBCCont").hide();
                $("#referenciaHSBCInput").prop("required", false);
            }
        }
        if (target.is("#renovacionInput")) {
            let renovacionChecked = $("#renovacionInput").is(":checked");

            if (renovacionChecked) {
                $("#montoRenovacionCont").show();
                $("#montoRenovacionInput").prop("required", true);
            } else {
                $("#montoRenovacionCont").hide();
                $("#montoRenovacionInput").prop("required", false);
            }
        }
        if (target.is("#rendimientosInput")) {
            let rendimientoChecked = $("#rendimientosInput").is(":checked");

            if (rendimientoChecked) {
                $("#montoRendimientosCont").show();
                $("#montoRendimientosInput").prop("required", true);
            } else {
                $("#montoRendimientosCont").hide();
                $("#montoRendimientosInput").prop("required", false);
            }
        }
        if (target.is("#comisionesInput")) {
            let comisionChecked = $("#comisionesInput").is(":checked");

            if (comisionChecked) {
                $("#montoComisionesCont").show();
                $("#montoComisionesInput").prop("required", true);
            } else {
                $("#montoComisionesCont").hide();
                $("#montoComisionesInput").prop("required", false);
            }
        }
        if (target.is("#bitsoInput")) {
            let bitsoChecked = $("#bitsoInput").is(":checked");

            if (bitsoChecked) {
                $("#montoBitsoCont").show();
                $("#montoBitsoInput").prop("required", true);
            } else {
                $("#montoBitsoCont").hide();
                $("#montoBitsoInput").prop("required", false);
            }
        }

        //APARTADO PARA CAMBIAR EL PORCENTAJE DE RENDIMIENTOS
        if (target.is("#cambiarPorcentajeInput")) {
            casilla = $("#cambiarPorcentajeInput").prop("checked");
            if (casilla) {
                $("#porcentajeRendimientoCont").show();
            } else {
                $("#porcentajeRendimientoCont").hide();
                $("#porcentajeRendimientoInput").val(0);
            }
        }

        //APARTADO DEL TIPO DE MONEDA
        if (target.is("#monedaDolaresInput")) {
            $(".contEuro").hide();
            $(".contFranco").hide();

            $(".contDolar").show();
            var dolar = parseFloat($("#inversionUsInput").val());

            var dolar_peso = $("#tipoCambioInput").val();
            var pesos = dolar * dolar_peso;
            $("#inversionInput").val(pesos.toFixed(2));

            if ($("#inversionUsInput").val() > 0) {
                $("#inversionLetInput").val(numeroALetrasMXN(pesos.toFixed(2)));
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD(dolar.toFixed(2))
                );
                $("#inversionLetInputEUR").val(
                    numeroALetrasEUR(dolar.toFixed(2))
                );
                $("#inversionLetInputCHF").val(
                    numeroALetrasCHF(dolar.toFixed(2))
                );
            }
        }
        if (target.is("#monedaEurosInput")) {
            $(".contDolar").hide();
            $(".contFranco").hide();

            $(".contEuro").show();
            var euro = parseFloat($("#inversionInputEUR").val());

            var euro_peso = $("#tipoCambioInputEUR").val();
            let pesos = euro * euro_peso;
            $("#inversionInput").val(pesos.toFixed(2));

            if ($("#inversionInputEUR").val() > 0) {
                $("#inversionLetInput").val(numeroALetrasMXN(pesos.toFixed(2)));
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD(euro.toFixed(2))
                );
                $("#inversionLetInputEUR").val(
                    numeroALetrasEUR(euro.toFixed(2))
                );
                $("#inversionLetInputCHF").val(
                    numeroALetrasCHF(euro.toFixed(2))
                );
            }
        }
        if (target.is("#monedaFrancosInput")) {
            $(".contDolar").hide();
            $(".contEuro").hide();

            $(".contFranco").show();
            var franco = parseFloat($("#inversionInputCHF").val());

            var franco_peso = $("#tipoCambioInputCHF").val();
            let pesos = franco * franco_peso;
            $("#inversionInput").val(pesos.toFixed(2));

            if ($("#inversionInputCHF").val() > 0) {
                $("#inversionLetInput").val(numeroALetrasMXN(pesos.toFixed(2)));
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD(franco.toFixed(2))
                );
                $("#inversionLetInputEUR").val(
                    numeroALetrasEUR(franco.toFixed(2))
                );
                $("#inversionLetInputCHF").val(
                    numeroALetrasCHF(franco.toFixed(2))
                );
            }
        }
    });

    $("#clienteIdInput").change(function () {
        var id = $("#clienteIdInput").val();
        $.get({
            url: "/admin/showNumeroCliente",
            data: {
                id: id,
            },
            success: function (response) {
                $("#contratoInput").val(response);
            },
        });
    });

    function estatusClaveIncorrecta(input) {
        let estatus = $(input).data("status");
        if (estatus == "Activado") {
            $(input).prop("checked", true);
            $(input).val("Activado");
        } else {
            $(input).prop("checked", false);
            $(input).val("Pendiente de activación");
        }
    }

    const comprobantePago = (thiss) => {
        var comprobantepago = $(thiss).data("comprobantepago");
        var documento = comprobantepago.split(",");
        var contrato = $(thiss).data("contrato");

        if (comprobantepago.length > 0) {
            $("#comprobantePagoInput").addClass("is-valid");
            $("#comprobantePagoInput").removeClass("is-invalid");

            $("#comprobantePagoDesc").attr("download", `${contrato}.zip`);
            $("#comprobantePagoDesc").attr(
                "href",
                `../documentos/comprobantes_pagos/contratos/${contrato}/${contrato}.zip`
            );
            $("#comprobantePagoView").attr(
                "href",
                `../documentos/comprobantes_pagos/contratos/${contrato}/${documento[0]}`
            );

            $("#comprobantePagoDesc").removeClass("d-none");
            $("#comprobantePagoView").removeClass("d-none");
        } else {
            $("#comprobantePagoInput").addClass("is-invalid");
            $("#comprobantePagoInput").removeClass("is-valid");

            $("#comprobantePagoDesc").addClass("d-none");
            $("#comprobantePagoView").addClass("d-none");
        }
    };

    const tipoPago = (thiss) => {
        let checkbox = [
            "#efectivoInput",
            "#transferenciaSwissInput",
            "#transferenciaMXInput",
            "#ciBankInput",
            "#wiseInput",
            "#hsbcInput",
            "#renovacionInput",
            "#rendimientosInput",
            "#comisionesInput",
            "#bitsoInput",
        ];

        let inputs = [
            "#montoEfectivoInput",
            "#montoTransSwissPOOLInput",
            "#montoTransMXPOOLInput",
            "#montoBankInput",
            "#montoWiseInput",
            "#montoHSBCInput",
            "#montoRenovacionInput",
            "#montoRendimientosInput",
            "#montoComisionesInput",
            "#montoBitsoInput",
        ];

        let conts = [
            "#montoEfectivoCont",
            "#montoTransSwissPOOLCont",
            "#montoTransMXPOOLCont",
            "#montoBankCont",
            "#montoWiseCont",
            "#montoHSBCCont",
            "#montoRenovacionCont",
            "#montoRendimientosCont",
            "#montoComisionesCont",
            "#montoBitsoCont",
        ];

        let contsRef = [
            "#referenciaEfectivoCont",
            "#referenciaTransSwissPOOLCont",
            "#referenciaTransMXPOOLCont",
            "#referenciaBankCont",
            "#referenciaWiseCont",
            "#referenciaHSBCCont",
            "#referenciaRenovacionCont",
            "#referenciaRendimientosCont",
            "#referenciaComisionesCont",
            "#referenciaBitsoCont",
        ];

        let montopago = $(thiss).data("montopago");
        let tipopago = $(thiss).data("tipopago");
        let referencia = $(thiss).data("referencia");

        if (typeof montopago !== "undefined") {
            montopago = montopago.split(",");
            tipopago = tipopago.split(",");
            referencia = referencia.split(",");

            tipopago.map((tipo, j) => {
                checkbox.map((input, i) => {
                    if (tipo == $(input).val()) {
                        $(input).prop("checked", true);
                        let checked = $(input).is(":checked");
                        if (checked) {
                            $(conts[i]).show();
                            $(inputs[i]).val(montopago[j]);

                            referencia.map((ref, j) => {
                                if (
                                    contsRef[j] ==
                                        "#referenciaTransSwissPOOLCont" &&
                                    tipo == "transferencia_swiss_pool"
                                ) {
                                    $("#referenciaTransSwissPOOLCont").show();
                                    $("#referenciaTransSwissPOOLInput").val(
                                        ref
                                    );
                                } else if (
                                    contsRef[j] ==
                                        "#referenciaTransMXPOOLCont" &&
                                    tipo == "transferencia_mx_pool"
                                ) {
                                    $("#referenciaTransMXPOOLCont").show();
                                    $("#referenciaTransMXPOOLInput").val(ref);
                                } else if (
                                    contsRef[j] == "#referenciaHSBCCont" &&
                                    tipo == "Santander"
                                ) {
                                    $("#referenciaHSBCCont").show();
                                    $("#referenciaHSBCInput").val(ref);
                                } else if (
                                    contsRef[j] == "#referenciaWiseCont" &&
                                    tipo == "wise"
                                ) {
                                    $("#referenciaWiseCont").show();
                                    $("#referenciaWiseInput").val(ref);
                                }
                            });
                        }
                    }
                });
            });
        }
    };

    const containerHide = () => {
        $("#montoEfectivoCont").hide();
        $("#montoTransSwissPOOLCont").hide();
        $("#montoTransMXPOOLCont").hide();
        $("#montoBankCont").hide();
        $("#montoWiseCont").hide();
        $("#montoHSBCCont").hide();
        $("#montoRenovacionCont").hide();
        $("#montoRendimientosCont").hide();
        $("#montoComisionesCont").hide();
        $("#montoBitsoCont").hide();
        $("#porcentajeRendimientoCont").hide();

        $("#referenciaTransSwissPOOLCont").hide();
        $("#referenciaTransMXPOOLCont").hide();
        $("#referenciaHSBCCont").hide();
        $("#referenciaWiseCont").hide();
        //rendimientos no sale
        $("#montoEfectivoInput").prop("required", false);
        $("#montoTransSwissPOOLInput").prop("required", false);
        $("#montoTransMXPOOLInput").prop("required", false);
        $("#montoBankInput").prop("required", false);
        $("#montoWiseInput").prop("required", false);
        $("#montoHSBCInput").prop("required", false);
        $("#montoRenovacionInput").prop("required", false);
        $("#montoRendimientosInput").prop("required", false);
        $("#montoComisionesInput").prop("required", false);
        $("#montoBitsoInput").prop("required", false);

        $("#referenciaTransSwissPOOLInput").prop("required", false);
        $("#referenciaTransMXPOOLInput").prop("required", false);
        $("#referenciaHSBCInput").prop("required", false);
        $("#referenciaWiseInput").prop("required", false);
    };

    const estilos = (
        todos_add,
        contmen_add,
        contcomp_add,
        contact_add,
        contpend_add,
        todos_rem,
        contmen_rem,
        contcomp_rem,
        contact_rem,
        contpend_rem
    ) => {
        $("#todos").addClass(todos_add);
        $("#contratosMensuales").addClass(contmen_add);
        $("#contratosCompuestos").addClass(contcomp_add);
        $("#contratosActivados").addClass(contact_add);
        $("#contratosPendientes").addClass(contpend_add);

        $("#todos").removeClass(todos_rem);
        $("#contratosMensuales").removeClass(contmen_rem);
        $("#contratosCompuestos").removeClass(contcomp_rem);
        $("#contratosActivados").removeClass(contact_rem);
        $("#contratosPendientes").removeClass(contpend_rem);
    };
});

$(".table").addClass("compact nowrap w-100");
