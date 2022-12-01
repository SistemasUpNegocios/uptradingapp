$(document).ready(function () {
    let acc = "";

    var table = $("#cuentas").DataTable({
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
            lengthMenu: "Mostrar _MENU_ cuentas",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún cliente",
            infoEmpty: "Mostrando cliente del 0 al 0 de un total de 0 cuentas",
            infoFiltered: "(filtrado de un total de _MAX_ cuentas)",
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
                collaclientee: {
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ cuentas",
        },
        order: [[1, "desc"]],
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", ".new", function (e) {
        $("#cuentasForm")[0].reset();

        acc = "new";
        $("#cuentasForm").attr("action", "/admin/addCuenta");

        $("#nombreInput").prop("readonly", false);
        $("#apellidosInput").prop("readonly", false);
        $("#correoInput").prop("readonly", false);

        $("#modalTitle").text("Añadir cuenta");
        $("#btnSubmit").text("Añadir cuenta");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var nombre = $(this).data("nombre");
        var apellidos = $(this).data("apellidos");
        var correo = $(this).data("correo");
        correo = correo.split("@");

        $("#modalTitle").text(
            `Vista previa de la cuenta: ${correo[0]}@uptradingexperts.com`
        );

        $("#formModal").modal("show");

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#apellidosInput").val(apellidos);
        $("#apellidosInput").prop("readonly", true);

        $("#correoInput").val(correo[0]);
        $("#correoInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();

        var id = $(this).data("id");
        var nombre = $(this).data("nombre");
        var apellidos = $(this).data("apellidos");
        var correo = $(this).data("correo");
        correo = correo.split("@");

        $("#modalTitle").text(
            `Editar cuenta: ${correo[0]}@uptradingexperts.com`
        );

        $("#formModal").modal("show");

        $("#idInput").val(id);

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", false);

        $("#apellidosInput").val(apellidos);
        $("#apellidosInput").prop("readonly", false);

        $("#correoInput").val(correo[0]);
        $("#correoInput").prop("readonly", false);

        $("#formModal").modal("show");
        $("#cuentasForm").attr("action", "/admin/editCuenta");

        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar cuenta");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", "#generarEmails", function (e) {
        let correo = $("#ultimoCorreo").text();

        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Creando cuentas...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.post(
            "/admin/generarCuentas",
            { correo: correo },
            function (response) {
                Swal.close();

                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cuentas creadas</h1>',
                    html: `<p style="font-family: Poppins">Se ha creado desde la cuenta: <b>${correo}</b> hasta la <b>${response.ultimo_correo}</b></p>`,
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });

                cuentasPeticion(response.correos);
                $("#ultimoCorreo").text(response.ultimo_correo);
            }
        );
    });

    $("#cuentasForm").on("submit", function (e) {
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
            success: function (result) {
                $("#formModal").modal("hide");
                $("#cuentasForm")[0].reset();
                if (acc == "new") {
                    cuentasPeticion(result);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cuenta añadida</h1>',
                        html: `<p style="font-family: Poppins">La cuenta ha sido añadida correctamente</p>`,
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    console.log(result);
                    cuentasPeticion(result);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cuenta actualizada</h1>',
                        html: '<p style="font-family: Poppins">La cuenta ha sido actualizada correctamente</p>',
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

    const cuentasPeticion = (result) => {
        result.map(function (cuenta) {
            $("#cuentasBody").append(
                `
                <tr>
                  <td>${cuenta.name.fullName}</td>
                  <td>${cuenta.primaryEmail}</td>
                  <td class="text-center">
                    <a href="" data-nombre="${cuenta.name.givenName}" data-apellidos="${cuenta.name.familyName}" data-correo=" ${cuenta.primaryEmail}" type="button" title="Vista previa" class="btn btn-primary btn-sm btn-icon view"> <i class="bi bi-eye"></i></a>
                    <a href="" data-id="${cuenta.id}" data-nombre="${cuenta.name.givenName}" data-apellidos="${cuenta.name.familyName}" data-correo=" ${cuenta.primaryEmail}" type="button" title="Editar cliente" class="btn btn-success btn-sm btn-icon edit" id="edit"> <i class="bi bi-pencil"></i></a>
                  </td>
                </tr>
              `
            );
        });
    };
});
