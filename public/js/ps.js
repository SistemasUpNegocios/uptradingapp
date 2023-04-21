$(document).ready(function () {
    const config = {
        search: true,
    };
    dselect(document.querySelector("#oficinaIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    let acc = "";

    var table = $("#ps").DataTable({
        ajax: "/admin/showPs",
        columns: [
            { data: "codigoPS" },
            { data: "nombrePS" },
            { data: "oficina_ciudad" },
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
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#psForm").on("submit", function (e) {
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
                $("#psForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">PS añadido</h1>',
                        html: '<p style="font-family: Poppins">El PS ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">PS actualizado</h1>',
                        html: '<p style="font-family: Poppins">El PS ha sido actualizado correctamente</p>',
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
        $("#psForm")[0].reset();
        $("#alertMessage").text("");
        acc = "new";
        $("#psForm").attr("action", "/admin/addPs");
        $("#idInput").val("");

        $("#oficinaIdInput").next().children().first().empty();
        $("#oficinaIdInput").next().children().first().text("Selecciona...");
        $("#oficinaIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", "");
        $("#oficinaIdInput").next().children().first().attr("disabled", false);

        $("#codigoPsInput").prop("readonly", false);
        $("#nombreInput").prop("readonly", false);
        $("#apellidoPatInput").prop("readonly", false);
        $("#apellidoMatInput").prop("readonly", false);
        $("#fechaNacInput").prop("readonly", false);
        $("#nacionalidadInput").prop("readonly", false);
        $("#direccionInput").prop("readonly", false);
        $("#colFraccInput").prop("readonly", false);
        $("#cpInput").prop("readonly", false);
        $("#ciudadInput").prop("readonly", false);
        $("#estadoInput").prop("readonly", false);
        $("#celularInput").prop("readonly", false);
        $("#correopInput").prop("readonly", false);
        $("#correoiInput").prop("readonly", false);
        $("#ineInput").prop("readonly", false);
        $("#pasaporteInput").prop("readonly", false);
        $("#fechapasInput").prop("readonly", false);
        $("#oficinaIdInput").prop("disabled", false);
        $("#swiftInput").prop("readonly", false);
        $("#ibanInput").prop("readonly", false);

        $("#modalTitle").text("Añadir PS");
        $("#btnSubmit").text("Añadir PS");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");

        $.get({
            url: "/admin/showNumPS",
            success: function (response) {
                $("#codigoPsInput").val(response.numeroPS);
                $("#correoiInput").val(response.correoPS);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $(document).on("click", ".view", function (e) {
        $("#psForm")[0].reset();
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var codigops = $(this).data("codigops");
        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var fechanac = $(this).data("fechanac");
        var nacionalidad = $(this).data("nacionalidad");
        var direccion = $(this).data("direccion");
        var colonia = $(this).data("colonia");
        var cp = $(this).data("cp");
        var ciudad = $(this).data("ciudad");
        var estado = $(this).data("estado");
        var celular = $(this).data("celular");
        var correop = $(this).data("correop");
        var correoi = $(this).data("correoi");
        var ine = $(this).data("ine");
        var pasaporte = $(this).data("pasaporte");
        var vencimientopas = $(this).data("vencimientopas");
        var oficinaid = $(this).data("oficinaid");
        var swift = $(this).data("swift");
        var iban = $(this).data("iban");
        var oficina_ciudad = $(this).data("oficinaciudad");

        $("#oficinaIdInput").next().children().first().empty();
        $("#oficinaIdInput").next().children().first().text(oficina_ciudad);
        $("#oficinaIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", oficina_ciudad);
        $("#oficinaIdInput").next().children().first().attr("disabled", true);

        $("#modalTitle").text(
            `Vista previa de PS: ${nombre} ${apellidop} ${apellidom}`
        );

        $("#formModal").modal("show");

        $("#codigoPsInput").val(codigops);
        $("#codigoPsInput").prop("readonly", true);

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#apellidoPatInput").val(apellidop);
        $("#apellidoPatInput").prop("readonly", true);

        $("#apellidoMatInput").val(apellidom);
        $("#apellidoMatInput").prop("readonly", true);

        $("#fechaNacInput").val(fechanac);
        $("#fechaNacInput").prop("readonly", true);

        $("#nacionalidadInput").val(nacionalidad);
        $("#nacionalidadInput").prop("readonly", true);

        $("#direccionInput").val(direccion);
        $("#direccionInput").prop("readonly", true);

        $("#colFraccInput").val(colonia);
        $("#colFraccInput").prop("readonly", true);

        $("#cpInput").val(cp);
        $("#cpInput").prop("readonly", true);

        $("#ciudadInput").val(ciudad);
        $("#ciudadInput").prop("readonly", true);

        $("#estadoInput").val(estado);
        $("#estadoInput").prop("readonly", true);

        $("#celularInput").val(celular);
        $("#celularInput").prop("readonly", true);

        $("#correopInput").val(correop);
        $("#correopInput").prop("readonly", true);

        $("#correoiInput").val(correoi);
        $("#correoiInput").prop("readonly", true);

        $("#ineInput").val(ine);
        $("#ineInput").prop("readonly", true);

        $("#pasaporteInput").val(pasaporte);
        $("#pasaporteInput").prop("readonly", true);

        $("#fechapasInput").val(vencimientopas);
        $("#fechapasInput").prop("readonly", true);

        $("#oficinaIdInput").val(oficinaid);
        $("#oficinaIdInput").prop("disabled", true);

        $("#swiftInput").val(swift);
        $("#swiftInput").prop("readonly", true);

        $("#ibanInput").val(iban);
        $("#ibanInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#psForm")[0].reset();
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var codigops = $(this).data("codigops");
        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var fechanac = $(this).data("fechanac");
        var nacionalidad = $(this).data("nacionalidad");
        var direccion = $(this).data("direccion");
        var colonia = $(this).data("colonia");
        var cp = $(this).data("cp");
        var ciudad = $(this).data("ciudad");
        var estado = $(this).data("estado");
        var celular = $(this).data("celular");
        var correop = $(this).data("correop");
        var correoi = $(this).data("correoi");
        $("#correotInput").val(correoi.toLowerCase());
        var ine = $(this).data("ine");
        var pasaporte = $(this).data("pasaporte");
        var vencimientopas = $(this).data("vencimientopas");
        var oficinaid = $(this).data("oficinaid");
        var swift = $(this).data("swift");
        var iban = $(this).data("iban");
        var oficina_ciudad = $(this).data("oficinaciudad");

        $("#oficinaIdInput").next().children().first().empty();
        $("#oficinaIdInput").next().children().first().text(oficina_ciudad);
        $("#oficinaIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", oficina_ciudad);
        $("#oficinaIdInput").next().children().first().attr("disabled", false);

        $("#formModal").modal("show");
        $("#psForm").attr("action", "/admin/editPs");

        $("#idInput").val(id);

        $("#codigoPsInput").val(codigops);
        $("#codigoPsInput").prop("readonly", false);

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", false);

        $("#apellidoPatInput").val(apellidop);
        $("#apellidoPatInput").prop("readonly", false);

        $("#apellidoMatInput").val(apellidom);
        $("#apellidoMatInput").prop("readonly", false);

        $("#fechaNacInput").val(fechanac);
        $("#fechaNacInput").prop("readonly", false);

        $("#nacionalidadInput").val(nacionalidad);
        $("#nacionalidadInput").prop("readonly", false);

        $("#direccionInput").val(direccion);
        $("#direccionInput").prop("readonly", false);

        $("#colFraccInput").val(colonia);
        $("#colFraccInput").prop("readonly", false);

        $("#cpInput").val(cp);
        $("#cpInput").prop("readonly", false);

        $("#ciudadInput").val(ciudad);
        $("#ciudadInput").prop("readonly", false);

        $("#estadoInput").val(estado);
        $("#estadoInput").prop("readonly", false);

        $("#celularInput").val(celular);
        $("#celularInput").prop("readonly", false);

        $("#correopInput").val(correop);
        $("#correopInput").prop("readonly", false);

        $("#correoiInput").val(correoi);
        $("#correoiInput").prop("readonly", false);

        $("#ineInput").val(ine);
        $("#ineInput").prop("readonly", false);

        $("#pasaporteInput").val(pasaporte);
        $("#pasaporteInput").prop("readonly", false);

        $("#fechapasInput").val(vencimientopas);
        $("#fechapasInput").prop("readonly", false);

        $("#oficinaIdInput").val(oficinaid);
        $("#oficinaIdInput").prop("disabled", false);

        $("#swiftInput").val(swift);
        $("#swiftInput").prop("readonly", false);

        $("#ibanInput").val(iban);
        $("#ibanInput").prop("readonly", false);

        $("#modalTitle").text(`Editar PS: ${nombre} ${apellidop} ${apellidom}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar PS");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");
        var conf;

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar PS</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar este PS? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deletePs", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">PS eliminado</h1>',
                        html: '<p style="font-family: Poppins">El PS se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El PS no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $("#oficinaIdInput").change(function (e) {
        var idOficina = $("#oficinaIdInput").val();
        e.preventDefault();

        $.get({
            url: "/admin/showNumPSOficina",
            data: {
                id: idOficina,
            },
            success: function (response) {
                $("#codigoPsInput").val(response.numeroPS);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});

$(".table").addClass("compact nowrap w-100");
