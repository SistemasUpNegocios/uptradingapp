$(document).ready(function () {
    let acc = "";

    var table = $("#usuario").DataTable({
        ajax: "/admin/showUsuario",
        columns: [
            { data: "nombre" },
            {
                data: (data) => {
                    return data.apellido_p + " " + data.apellido_m;
                },
            },
            { data: "correo" },
            {
                data: "privilegio",
                render: function (privilegio) {
                    if (privilegio == "root") {
                        return "SUPERUSUARIO";
                    } else if (privilegio == "admin") {
                        return "ADMINISTRADOR";
                    } else if (privilegio == "procesos") {
                        return "PROCESOS";
                    } else if (privilegio == "egresos") {
                        return "EGRESOS";
                    } else if (privilegio == "contabilidad") {
                        return "CONTABILIDAD";
                    } else if (privilegio == "ps_diamond") {
                        return "PS DIAMOND";
                    } else if (privilegio == "ps_gold") {
                        return "PS GOLD";
                    } else if (privilegio == "ps_silver") {
                        return "PS SILVER";
                    } else if (privilegio == "ps_bronze") {
                        return "PS BRONZE";
                    } else if (privilegio == "cliente") {
                        return "CLIENTE";
                    }
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
            lengthMenu: "Mostrar _MENU_ usuarios",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún usuario",
            infoEmpty:
                "Mostrando usuarios del 0 al 0 de un total de 0 usuarios",
            infoFiltered: "(filtrado de un total de _MAX_ usuarios)",
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
            info: "Mostrando del _START_ al _END_ de _TOTAL_ usuarios",
        },
        aaSorting: [],
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#usuarioForm").on("submit", function (e) {
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
                $("#usuarioForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Usuario añadido</h1>',
                        html: '<p style="font-family: Poppins">El usuario ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Usuario actualizado</h1>',
                        html: '<p style="font-family: Poppins">El usuario ha sido actualizado correctamente</p>',
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
        $("#usuarioForm").attr("action", "/admin/addUsuario");
        $("#idInput").val("");

        $("#nombreInput").prop("readonly", false);
        $("#apellidoPatInput").prop("readonly", false);
        $("#apellidoMatInput").prop("readonly", false);
        $("#correoInput").prop("readonly", false);
        $("#passwordInput").prop("readonly", false);
        $("#privilegioInput").prop("disabled", false);
        $("#oficinaInput").prop("disabled", false);

        $("#containerPassword").show();
        $("#containerPrivilegio").addClass("col-md-6 col-12");
        $("#containerPrivilegio").removeClass("col-12");

        $("#checkCont").hide();
        $("#passInputCheck").prop("checked", false);

        $("#modalTitle").text("Añadir usuario");
        $("#btnSubmit").text("Añadir usuario");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var correo = $(this).data("correo");
        var privilegio = $(this).data("privilegio");
        var oficina = $(this).data("oficina");

        $("#modalTitle").text(
            `Vista previal de usuario: ${nombre} ${apellidop} ${apellidom}`
        );

        $("#formModal").modal("show");

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#apellidoPatInput").val(apellidop);
        $("#apellidoPatInput").prop("readonly", true);

        $("#apellidoMatInput").val(apellidom);
        $("#apellidoMatInput").prop("readonly", true);

        $("#correoInput").val(correo);
        $("#correoInput").prop("readonly", true);

        $("#containerPassword").hide();
        $("#containerPrivilegio").removeClass("col-md-6 col-12");
        $("#containerPrivilegio").addClass("col-12");

        $("#checkCont").hide();
        $("#passInputCheck").prop("checked", false);

        $("#privilegioInput").val(privilegio);
        $("#privilegioInput").prop("disabled", true);

        $("#oficinaInput").val(oficina);
        $("#oficinaInput").prop("disabled", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var correo = $(this).data("correo");
        var privilegio = $(this).data("privilegio");
        var oficina = $(this).data("oficina");

        $("#formModal").modal("show");
        $("#usuarioForm").attr("action", "/admin/editUsuario");

        $("#idInput").val(id);

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#apellidoPatInput").val(apellidop);
        $("#apellidoPatInput").prop("readonly", true);

        $("#apellidoMatInput").val(apellidom);
        $("#apellidoMatInput").prop("readonly", true);

        $("#correoInput").val(correo);
        $("#correoInput").prop("readonly", true);

        $("#containerPassword").hide();
        $("#containerPrivilegio").removeClass("col-md-6 col-12");
        $("#containerPrivilegio").addClass("col-12");

        $("#passInputCheck").prop("checked", false);
        $("#checkCont").show();

        $("#privilegioInput").val(privilegio);
        $("#privilegioInput").prop("disabled", false);

        $("#oficinaInput").val(oficina);
        $("#oficinaInput").prop("disabled", false);

        $("#modalTitle").text(
            `Editar usuario: ${nombre} ${apellidop} ${apellidom}`
        );
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar usuario");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");
        var conf;

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar usuario</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar este usuario? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteUsuario", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Usuario eliminado</h1>',
                        html: '<p style="font-family: Poppins">El usuario se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El usuario no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("change", "#passInputCheck", function (e) {
        if ($("#passInputCheck").prop("checked") == true) {
            $("#containerPassword").show();
            $("#containerPrivilegio").addClass("col-md-6 col-12");
            $("#containerPrivilegio").removeClass("col-12");
        } else {
            $("#containerPassword").hide();
            $("#containerPrivilegio").removeClass("col-md-6 col-12");
            $("#containerPrivilegio").addClass("col-12");
        }
    });
});

$(".table").addClass("compact nowrap w-100");
