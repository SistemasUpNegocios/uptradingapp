$(document).ready(function () {
    var table = $("#cambios").DataTable({
        ajax: "/admin/showCambios",
        columns: [
            { data: "tipos" },
            { data: "tabla" },
            { data: "user_correo" },
            {
                data: function (data) {
                    var fecha_hora = new Date(data.hora_fecha);
                    var opciones = {
                        year: "numeric",
                        month: "2-digit",
                        day: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                        hour12: true,
                    };
                    let date = fecha_hora.toLocaleString("es-MX", opciones);

                    return date;
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
            lengthMenu: "Mostrar _MENU_ cambios",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún cambio",
            infoEmpty: "Mostrando cambios del 0 al 0 de un total de 0 cambios",
            infoFiltered: "(filtrado de un total de _MAX_ cambios)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ cambios",
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

        $("#detallesModal").modal("show");

        var direccionip = $(this).data("direccionip");
        var fechaentrada = $(this).data("fechaentrada");
        var fechasalida = $(this).data("fechasalida");
        var tipodispositivo = $(this).data("tipodispositivo");
        var so = $(this).data("so");
        var navegador = $(this).data("navegador");
        var tipoaccion = $(this).data("tipoaccion");
        var tabla = $(this).data("tabla");

        $("#ip").text(direccionip);
        $("#fe").text(fechaentrada);

        var fecha_actual = new Date();
        var fecha_salida = new Date(fechasalida);
        if (fecha_actual >= fecha_salida) {
            $("#fs").text(fechasalida);
        } else {
            $("#fs").html(
                `<span class="badge bg-info">Sesión aún activa</span>`
            );
        }

        $("#td").text(tipodispositivo);
        $("#so").text(so);
        $("#br").text(navegador);
        $("#tab").text(tabla);

        if (tipoaccion == "Inserción") {
            $("#acc").html(
                `<span class="badge bg-primary"><i class="bi-plus-lg"></i> ${tipoaccion}</span>`
            );
        } else if (tipoaccion == "Actualización") {
            $("#acc").html(
                `<span class="badge bg-success"><i class="bi bi-pencil"></i> ${tipoaccion}</span>`
            );
        } else if (tipoaccion == "Eliminación") {
            $("#acc").html(
                `<span class="badge bg-danger"><i class="bi bi-trash"></i> ${tipoaccion}</span>`
            );
        }

        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var correo = $(this).data("correo");
        var privilegio = $(this).data("privilegio");
        var foto = $(this).data("foto");

        $("#collapseBtn").html(
            `Desplegar información del usuario &nbsp;<b>${nombre} ${apellidop} ${apellidom}</b>`
        );
        $("#no").text(nombre);
        $("#ap").text(apellidop);
        $("#am").text(apellidom);
        $("#ce").text(correo);
        $("#pr").text(privilegio);
        $("#imgPerfil").attr("src", `../img/usuarios/${foto}`);
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        console.log(id);

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar cambio</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar este cambio? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteCambio", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cambio eliminado</h1>',
                        html: '<p style="font-family: Poppins">El cambio se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El cambio no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });
});

$(".table").addClass("compact nowrap w-100");
