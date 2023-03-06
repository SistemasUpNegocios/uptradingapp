$(document).ready(function () {
    const startOfMonth = moment().startOf("year").format("YYYY-MM-DD");
    const endOfMonth = moment().endOf("month").format("YYYY-MM-DD");
    $("#fechaInicioInput").val(startOfMonth);
    $("#fechaFinInput").val(endOfMonth);

    const tablaResumen = () => {
        table = $("#conteo").DataTable({
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ PS",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "No se ha registrado ningún PS",
                infoEmpty: "Mostrando PS del 0 al 0 de un total de 0 PS",
                infoFiltered: "(filtrado de un total de _MAX_ PS)",
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
                info: "Mostrando de _START_ a _END_ de _TOTAL_ PS",
            },
            lengthMenu: [
                [50, 100, 150, -1],
                [50, 100, 150, "Todo"],
            ],
            pageLength: 50,
            aaSorting: [],
        });
    };

    $.ajax({
        type: "GET",
        data: { fecha_inicio: startOfMonth, fecha_fin: endOfMonth },
        url: "showConteoPs",
        success: function (response) {
            $("#contTabla").empty();
            $("#contTabla").html(response);
            tablaResumen();
        },
        error: function (response) {
            $("#contTabla").empty();
            $("#contTabla").html(
                `
                    <div class="text-center mt-4">
                        <div class="spinner-border text-danger" role="status"></div>
                        <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                    </div>
                `
            );
        },
    });

    $(document).on("change", "#fechaInicioInput, #fechaFinInput", function (e) {
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();

        $("#contTabla").empty();
        $("#contTabla").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border" style="color: #01bbcc" role="status"></div>
                    <p style="color: #01bbcc">Cargando número de contratos de PS<span class="dotting"> </span></p>
                </div>
            `
        );

        if (fecha_inicio.length > 0 && fecha_fin.length > 0) {
            if (fecha_inicio > fecha_fin) {
                $("#fechaInicioInput").val(startOfMonth);
                $("#fechaFinInput").val(endOfMonth);
                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Error en fechas</h1>',
                    html: '<p style="font-family: Poppins">La fecha de inicio debe de ser menor a la fecha de fin.</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            } else {
                $.ajax({
                    type: "GET",
                    data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                    url: "showConteoPs",
                    success: function (response) {
                        $("#contTabla").empty();
                        $("#contTabla").html(response);
                        tablaResumen();
                    },
                    error: function (response) {
                        $("#contTabla").empty();
                        $("#contTabla").html(
                            `
                                <div class="text-center mt-4">
                                    <div class="spinner-border text-danger" role="status"></div>
                                    <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                                </div>
                            `
                        );
                    },
                });
            }
        } else {
            $.ajax({
                type: "GET",
                data: { fecha_inicio: "2020-02-28", fecha_fin: endOfMonth },
                url: "showConteoPs",
                success: function (response) {
                    $("#contTabla").empty();
                    $("#contTabla").html(response);
                    tablaResumen();
                },
                error: function (response) {
                    $("#contTabla").empty();
                    $("#contTabla").html(
                        `
                                <div class="text-center mt-4">
                                    <div class="spinner-border text-danger" role="status"></div>
                                    <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                                </div>
                            `
                    );
                },
            });
        }
    });
});

$(".table").addClass("compact nowrap w-100");
