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
        ajax: "/admin/showIncrementoConvenio",
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

    $("#contenedor_filtros").hide();
    $(document).on("click", "#filtros", function (e) {
        e.preventDefault();
        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#todos", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando todos los convenios");

        table = $("#convenio").DataTable({
            ajax: "/admin/showIncrementoConvenio",
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

    $(document).on("click", "#conveniosActivados", function () {
        table.destroy();

        $("#titulo_filtro").text("Mostrando convenios activados");

        table = $("#convenio").DataTable({
            ajax: "/admin/showIncrementoConvenioActivados",
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

        estilos(
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-outline-primary",
            "btn-primary"
        );

        $("#contenedor_filtros").toggle();
    });

    $(document).on("click", "#conveniosPendientes", function () {
        table.destroy();

        $("#titulo_filtro").text(
            "Mostrando convenios en pendientes de activación"
        );

        table = $("#convenio").DataTable({
            ajax: "/admin/showIncrementoConvenioPendientes",
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

        estilos(
            "btn-outline-primary",
            "btn-outline-primary",
            "btn-primary",
            "btn-primary",
            "btn-primary",
            "btn-outline-primary"
        );

        $("#contenedor_filtros").toggle();
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
                    url: "/admin/validateClaveIncrementoConvenio",
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.get(
                                "/admin/editStatusIncrementoConvenio",
                                {
                                    id: id,
                                    status: statusValor,
                                },
                                function () {
                                    Toast.fire({
                                        icon: "success",
                                        title: "Estatus actualizado",
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
                let folio = $("#folioInput").val();
                let estatus = $("#statusInput").val();
                if (estatus == "Activado") {
                    $("option:selected", "#statusInput").prop("disabled", true);
                }

                $("#formModal").modal("hide");
                $("#convenioForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    // let mensaje = `Se ha generado un nuevo convenio, por favor actívalo.\nFolio de convenio: ${folio}`;
                    // $.get({
                    //     url: "/admin/enviarTelegramConvenio",
                    //     data: {
                    //         mensaje: mensaje,
                    //     },
                    //     success: function (response) {
                    //         $("#folioInput").val(response);
                    //     },
                    // });

                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Incremento de convenio añadido</h1>',
                        html: '<p style="font-family: Poppins">El incremento de convenio ha sido añadido correctamente</p>',
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
        var today = new Date().toISOString().split("T")[0];
        $("#fechaInicioInput").val(today);

        $("#convenioForm").attr("action", "/admin/addIncrementoConvenio");
        $("#idInput").val("");

        $("#gerenteInput").prop("disabled", false);
        $("#representanteInput").prop("disabled", false);
        $("#modifySwitch").prop("disabled", false);

        $("#clienteIdInput").prop("disabled", false);
        $("#convenioIdInput").prop("disabled", false);
        $("#psIdInput").prop("disabled", false);
        $("#fechaInicioInput").prop("disabled", false);
        $("#montoIncrementoInput").prop("readonly", false);
        $("#montoLetraIncrementoInput").prop("readonly", false);
        $("#statusInput").prop("disabled", false);

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
        var convenio_id = $(this).data("convenio_id");
        var fecha_inicio = $(this).data("fecha_inicio");
        var nombrecliente = $(this).data("nombrecliente");
        var monto = $(this).data("monto");
        var monto_letra = $(this).data("monto_letra");
        var fecha_inicio = $(this).data("fecha_inicio");
        var status = $(this).data("status");
        var cliente_id = $(this).data("cliente_id");
        var ps_id = $(this).data("ps_id");
        var psnombre = $(this).data("psnombre");
        var firma = $(this).data("firma");

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

        if (firma == "MARIA EUGENIA RINCON ACEVAL") {
            $("#gerenteInput").prop("checked", true);
            $("#representanteInput").prop("checked", false);
        } else {
            $("#representanteInput").prop("checked", true);
            $("#gerenteInput").prop("checked", false);
        }
        $("#gerenteInput").prop("disabled", true);
        $("#representanteInput").prop("disabled", true);

        monto = monto.toString().replace(",", ".");
        $("#montoIncrementoInput").val(monto);
        $("#montoIncrementoInput").prop("readonly", true);

        $("#montoLetraIncrementoInput").val(monto_letra);
        $("#montoLetraIncrementoInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", true);

        $.get({
            type: "GET",
            url: "/admin/getConvenioUsuario",
            data: {
                id: cliente_id,
            },
            success: function (res) {
                convenios = [];
                convenios = res;
                $("#convenioIdInput").empty();
                $("#convenioIdInput").append(
                    $("<option>", {
                        value: "",
                        text: "Seleciona...",
                    })
                );
                $.each(convenios, function (key, item) {
                    $("#convenioIdInput").append(
                        $("<option>", {
                            value: item.id,
                            text: item.folio,
                        })
                    );
                });

                $("#convenioIdInput").val(convenio_id);
                $("#convenioIdInput").prop("disabled", true);
            },
            error: function (res) {
                console.log(res);
            },
        });

        $.get({
            type: "GET",
            url: "/admin/getFolioIncrementoConvenio",
            data: {
                id: cliente_id,
                id_convenio: convenio_id,
                opc: 3,
            },
            success: function (res) {
                $("#fechaInicioConvenioInput").val(res.convenio.fecha_inicio);
                $("#montoInput").val(res.convenio.monto);
                $("#montoLetraInput").val(res.convenio.monto_letra);
            },
            error: function (res) {
                console.log(res);
            },
        });

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
        var status = $(this).data("status");
        var ps_id = $(this).data("ps_id");
        var cliente_id = $(this).data("cliente_id");
        var convenio_id = $(this).data("convenio_id");
        var psnombre = $(this).data("psnombre");
        var firma = $(this).data("firma");

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

        $("#convenioForm").attr("action", "/admin/editIncrementoConvenio");

        $("#idInput").val(id);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        if (firma == "MARIA EUGENIA RINCON ACEVAL") {
            $("#gerenteInput").prop("checked", true);
            $("#representanteInput").prop("checked", false);
        } else {
            $("#representanteInput").prop("checked", true);
            $("#gerenteInput").prop("checked", false);
        }
        $("#gerenteInput").prop("disabled", false);
        $("#representanteInput").prop("disabled", false);

        monto = monto.toString().replace(",", ".");
        $("#montoIncrementoInput").val(monto);
        $("#montoIncrementoInput").prop("readonly", false);

        $("#montoLetraIncrementoInput").val(monto_letra);
        $("#montoLetraIncrementoInput").prop("readonly", false);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", false);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", false);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", false);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", false);

        $.get({
            type: "GET",
            url: "/admin/getConvenioUsuario",
            data: {
                id: cliente_id,
            },
            success: function (res) {
                convenios = [];
                convenios = res;
                $("#convenioIdInput").empty();
                $("#convenioIdInput").append(
                    $("<option>", {
                        value: "",
                        text: "Seleciona...",
                    })
                );
                $.each(convenios, function (key, item) {
                    $("#convenioIdInput").append(
                        $("<option>", {
                            value: item.id,
                            text: item.folio,
                        })
                    );
                });

                $("#convenioIdInput").val(convenio_id);
                $("#convenioIdInput").prop("disabled", false);
            },
            error: function (res) {
                console.log(res);
            },
        });

        $.get({
            type: "GET",
            url: "/admin/getFolioIncrementoConvenio",
            data: {
                id: cliente_id,
                id_convenio: convenio_id,
                opc: 3,
            },
            success: function (res) {
                $("#fechaInicioConvenioInput").val(res.convenio.fecha_inicio);
                $("#montoInput").val(res.convenio.monto);
                $("#montoLetraInput").val(res.convenio.monto_letra);
            },
            error: function (res) {
                console.log(res);
            },
        });

        $("#modifySwitch").prop("disabled", false);

        $("#modalTitle").text(`Editar convenio de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar convenio");
        $("#btnCancel").text("Cancelar");

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
                    url: "/admin/validateClaveIncrementoConvenio",
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
                    url: "/admin/validateClaveIncrementoConvenio",
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteIncrementoConvenio",
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

    var convenios = [];

    $("#montoIncrementoInput").on("keyup", function (event) {
        $("#montoLetraIncrementoInput").val(
            numeroALetrasUSD($("#montoIncrementoInput").val())
        );
    });

    $("#clienteIdInput").change(function () {
        var cliente_id = $("#clienteIdInput").val();
        $.get({
            type: "GET",
            url: "/admin/getFolioIncrementoConvenio",
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
        $.get({
            type: "GET",
            url: "/admin/getConvenioUsuario",
            data: {
                id: cliente_id,
            },
            success: function (res) {
                convenios = [];
                convenios = res;
                $("#convenioIdInput").empty();
                $("#convenioIdInput").append(
                    $("<option>", {
                        value: "",
                        text: "Seleciona...",
                    })
                );
                $.each(convenios, function (key, item) {
                    $("#convenioIdInput").append(
                        $("<option>", {
                            value: item.id,
                            text: item.folio,
                        })
                    );
                });
            },
            error: function (res) {
                console.log(res);
            },
        });
    });

    $("#convenioIdInput").change(function () {
        var cliente_id = $("#clienteIdInput").val();
        var convenio_id = $("#convenioIdInput").val();

        $.get({
            type: "GET",
            url: "/admin/getFolioIncrementoConvenio",
            data: {
                id: cliente_id,
                id_convenio: convenio_id,
                opc: 3,
            },
            success: function (res) {
                var current_num = res.folio;
                current_num = current_num.split("-");

                let new_conv = parseInt(current_num[3]) + 1;
                new_conv = new_conv.toString().padStart(2, 0);

                let new_num = parseInt(current_num[4]) + 1;
                new_num = new_num.toString().padStart(2, 0);
                new_num = `${current_num[0]}-${current_num[1]}-${current_num[2]}-${new_conv}-${new_num}`;
                $("#folioInput").val(new_num);

                $("#fechaInicioConvenioInput").val(res.convenio.fecha_inicio);
                $("#montoInput").val(res.convenio.monto);
                $("#montoLetraInput").val(res.convenio.monto_letra);
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
            url: "/admin/getFolioIncrementoConvenio",
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

    const estilos = (
        todos_add,
        convact_add,
        convpend_add,
        todos_rem,
        convact_rem,
        convpend_rem
    ) => {
        $("#todos").addClass(todos_add);
        $("#conveniosActivados").addClass(convact_add);
        $("#conveniosPendientes").addClass(convpend_add);

        $("#todos").removeClass(todos_rem);
        $("#conveniosActivados").removeClass(convact_rem);
        $("#conveniosPendientes").removeClass(convpend_rem);
    };
});

$(".table").addClass("compact nowrap w-100");
