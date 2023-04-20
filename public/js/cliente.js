const { PDFDocument, StandardFonts, rgb } = PDFLib;
var fontkit = window.fontkit;

$(document).ready(function () {
    const config = {
        search: true,
    };
    dselect(document.querySelector("#formIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    let acc = "";

    var table = $("#cliente").DataTable({
        ajax: "/admin/showCliente",
        columns: [
            { data: "codigoCliente" },
            { data: "nombre" },
            { data: "apellido_p" },
            { data: "apellido_m" },
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
            lengthMenu: "Mostrar _MENU_ clientes",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún cliente",
            infoEmpty: "Mostrando cliente del 0 al 0 de un total de 0 clientes",
            infoFiltered: "(filtrado de un total de _MAX_ clientes)",
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ clientes",
        },
        order: [[0, "desc"]],
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#lpoaSwitch").change(function () {
        let LPOAChecked = $("#lpoaSwitch").is(":checked");
        if (LPOAChecked) {
            $(".imprimirLPOAButton").removeClass("d-none");
            $(".nota").removeClass("d-none");
            $("#alertaNota").removeClass("d-none");
        } else {
            $(".imprimirLPOAButton").addClass("d-none");
            $(".nota").addClass("d-none");
            $("#alertaNota").addClass("d-none");
        }
    });

    $("#clienteForm").on("submit", function (e) {
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
                $("#clienteForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cliente añadido</h1>',
                        html: `<p style="font-family: Poppins">El cliente ha sido añadido correctamente</p>`,
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cliente actualizado</h1>',
                        html: '<p style="font-family: Poppins">El cliente ha sido actualizado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (err, exception) {
                console.log(err);
                var validacion = err.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#clienteForm")[0].reset();

        $("#alertMessage").text("");
        acc = "new";
        $("#clienteForm").attr("action", "/admin/addCliente");
        $("#idInput").val("");

        $.get({
            url: "/admin/showNumCliente",
            success: function (response) {
                $("#codigoClienteInput").val(response.numeroCliente);
                $("#correoiInput").val(response.correoCliente);
            },
            error: function (error) {
                console.log(error);
            },
        });

        $("#formIdInput").next().children().first().empty();
        $("#formIdInput").next().children().first().text("Selecciona...");
        $("#formIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", "");
        $("#formIdInput").next().children().first().attr("disabled", false);

        $("#formIdInput").prop("disabled", false);
        $("#codigoClienteInput").prop("readonly", false);
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
        $("#swiftInput").prop("readonly", false);
        $("#ibanInput").prop("readonly", false);
        $("#tarjetaInput").prop("disabled", false);
        $("#identificadorInput").prop("readonly", false);

        $("#ineDocumentoInput").prop("disabled", false);
        $("#pasaporteDocumentoInput").prop("disabled", false);
        $("#comprobanteDomicilioInput").prop("disabled", false);
        $("#LPOADocumentoInput").prop("disabled", false);
        $("#formAperturaInput").prop("disabled", false);
        $("#formRiesgosInput").prop("disabled", false);

        $("#ineDocumentoDesc").prop("disabled", false);
        $("#pasaporteDocumentoDesc").prop("disabled", false);
        $("#comprobanteDomicilioDesc").prop("disabled", false);
        $("#LPOADocumentoDesc").prop("disabled", false);
        $("#formAperturaDesc").prop("disabled", false);
        $("#formRiesgosDesc").prop("disabled", false);

        $("#modalTitle").text("Añadir cliente");
        $("#btnSubmit").text("Añadir cliente");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");

        $("#tipoClienteSwitch").prop("checked", false);
        switchCliente();
    });

    $(document).on("click", ".view", function (e) {
        $("#clienteForm")[0].reset();
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var codigocliente = $(this).data("codigocliente");
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
        var swift = $(this).data("swift");
        var iban = $(this).data("iban");
        var tarjeta = $(this).data("tarjeta");
        var identificador = $(this).data("identificador");

        if (
            String(identificador).length > 0 ||
            (String(fechanac).length == 0 &&
                String(nacionalidad).length == 0 &&
                String(direccion).length == 0 &&
                String(colonia).length == 0 &&
                String(cp).length == 0 &&
                String(ciudad).length == 0 &&
                String(estado).length == 0 &&
                String(celular).length == 0 &&
                String(correop).length == 0 &&
                String(ine).length == 0 &&
                String(pasaporte).length == 0 &&
                String(vencimientopas).length == 0)
        ) {
            $("#tipoClienteSwitch").prop("checked", true);
            switchCliente();
        } else {
            $("#tipoClienteSwitch").prop("checked", false);
            switchCliente();
        }

        let nombrecompleto = `${nombre} ${apellidop} ${apellidom}`;

        $("#formIdInput").next().children().first().empty();
        $("#formIdInput").next().children().first().text(nombrecompleto);
        $("#formIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", nombrecompleto);
        $("#formIdInput").next().children().first().attr("disabled", true);

        $("#modalTitle").text(
            `Vista previa del cliente: ${nombre} ${apellidop} ${apellidom}`
        );

        $("#formModal").modal("show");

        $("#formIdInput").prop("disabled", true);

        $("#codigoClienteInput").val(codigocliente);
        $("#codigoClienteInput").prop("readonly", true);

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

        $("#swiftInput").val(swift);
        $("#swiftInput").prop("readonly", true);

        $("#ibanInput").val(iban);
        $("#ibanInput").prop("readonly", true);

        $("#tarjetaInput").prop("disabled", true);

        $("#identificadorInput").val(identificador);
        $("#identificadorInput").prop("readonly", true);

        if (tarjeta == "SI") {
            $("#tarjetaInput").prop("checked", true);
        } else if (tarjeta == "NO") {
            $("#tarjetaInput").prop("checked", false);
        } else {
            $("#tarjetaInput").prop("checked", false);
        }

        $("#ineDocumentoInput").prop("disabled", true);
        $("#pasaporteDocumentoInput").prop("disabled", true);
        $("#comprobanteDomicilioInput").prop("disabled", true);
        $("#LPOADocumentoInput").prop("disabled", true);
        $("#formAperturaInput").prop("disabled", true);
        $("#formRiesgosInput").prop("disabled", true);

        $("#ineDocumentoDesc").prop("disabled", true);
        $("#pasaporteDocumentoDesc").prop("disabled", true);
        $("#comprobanteDomicilioDesc").prop("disabled", true);
        $("#LPOADocumentoDesc").prop("disabled", true);
        $("#formAperturaDesc").prop("disabled", true);
        $("#formRiesgosDesc").prop("disabled", true);

        documentosClientes(this);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#clienteForm")[0].reset();
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var codigocliente = $(this).data("codigocliente");
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
        $("#correotInput").val(correoi.toUpperCase());
        var ine = $(this).data("ine");
        var pasaporte = $(this).data("pasaporte");
        var vencimientopas = $(this).data("vencimientopas");
        var swift = $(this).data("swift");
        var iban = $(this).data("iban");
        var tarjeta = $(this).data("tarjeta");
        var identificador = $(this).data("identificador");

        if (
            String(identificador).length > 0 ||
            (String(fechanac).length == 0 &&
                String(nacionalidad).length == 0 &&
                String(direccion).length == 0 &&
                String(colonia).length == 0 &&
                String(cp).length == 0 &&
                String(ciudad).length == 0 &&
                String(estado).length == 0 &&
                String(celular).length == 0 &&
                String(correop).length == 0 &&
                String(ine).length == 0 &&
                String(pasaporte).length == 0 &&
                String(vencimientopas).length == 0)
        ) {
            $("#tipoClienteSwitch").prop("checked", true);
            switchCliente();
        } else {
            $("#tipoClienteSwitch").prop("checked", false);
            switchCliente();
        }

        let nombrecompleto = `${nombre} ${apellidop} ${apellidom}`;

        $("#formIdInput").next().children().first().empty();
        $("#formIdInput").next().children().first().text(nombrecompleto);
        $("#formIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", nombrecompleto);
        $("#formIdInput").next().children().first().attr("disabled", false);

        $("#formModal").modal("show");
        $("#clienteForm").attr("action", "/admin/editCliente");

        $("#idInput").val(id);

        $("#formIdInput").prop("disabled", false);

        $("#codigoClienteInput").val(codigocliente);
        $("#codigoClienteInput").prop("readonly", false);

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

        $("#swiftInput").val(swift);
        $("#swiftInput").prop("readonly", false);

        $("#ibanInput").val(iban);
        $("#ibanInput").prop("readonly", false);

        $("#tarjetaInput").prop("disabled", false);

        $("#identificadorInput").val(identificador);
        $("#identificadorInput").prop("readonly", false);

        if (tarjeta == "SI") {
            $("#tarjetaInput").prop("checked", true);
        } else if (tarjeta == "NO") {
            $("#tarjetaInput").prop("checked", false);
        } else {
            $("#tarjetaInput").prop("checked", false);
        }

        $("#contForm").hide();
        $("#formIdInput").prop("required", false);

        $("#ineDocumentoInput").prop("disabled", false);
        $("#pasaporteDocumentoInput").prop("disabled", false);
        $("#comprobanteDomicilioInput").prop("disabled", false);
        $("#LPOADocumentoInput").prop("disabled", false);
        $("#formAperturaInput").prop("disabled", false);
        $("#formRiesgosInput").prop("disabled", false);

        $("#ineDocumentoDesc").prop("disabled", false);
        $("#pasaporteDocumentoDesc").prop("disabled", false);
        $("#comprobanteDomicilioDesc").prop("disabled", false);
        $("#LPOADocumentoDesc").prop("disabled", false);
        $("#formAperturaDesc").prop("disabled", false);
        $("#formRiesgosDesc").prop("disabled", false);

        documentosClientes(this);

        $("#modalTitle").text(
            `Editar cliente: ${nombre} ${apellidop} ${apellidom}`
        );
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar cliente");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        var id = $(this).data("id");
        var conf;

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar cliente</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar este cliente? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteCliente", { id: id }, function () {
                    table.ajax.reload(null, false);
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cliente eliminado</h1>',
                        html: '<p style="font-family: Poppins">El cliente se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El cliente no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("click", ".whats", function (e) {
        e.preventDefault();

        let nombre = $(this).data("nombre");
        let apellidop = $(this).data("apellidop");
        let apellidom = $(this).data("apellidom");
        let numero = $(this).data("numero");
        let mensaje = `Buen día ${nombre} ${apellidop} ${apellidom}, .\n%0AAtte: Up Trading Experts.`;

        $("#nombreInputWhats").val(`${nombre} ${apellidop} ${apellidom}`);
        $("#numeroInputWhats").val(numero);
        $("#mensajeInputWhats").val(mensaje);

        $("#formModalWhats").modal("show");
    });

    $(document).on("click", "#enviarWhats", function () {
        let cliente = $("#nombreInputWhats").val();
        let numero = $("#numeroInputWhats").val();
        let mensaje = $("#mensajeInputWhats").val();

        window.open(
            `https://web.whatsapp.com/send?phone=${numero}&text=${mensaje}`,
            "_blank"
        );
        Swal.fire({
            icon: "success",
            title: '<h1 style="font-family: Poppins; font-weight: 700;">WhatsApp envíado</h1>',
            html: `<p style="font-family: Poppins">Se ha enviado un mensaje a <b>${cliente}</b>, con número de teléfono <b>${numero}</b>.</p>`,
            confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
            confirmButtonColor: "#01bbcc",
        });
        $("#formModalWhats").modal("hide");
    });

    $(document).on("click", ".print", async function (e) {
        e.preventDefault();

        const url = "../documentos/swissquote/LPOA.pdf";
        const existingPdfBytes = await fetch(url).then((res) =>
            res.arrayBuffer()
        );

        const urlFont = "../fonts/Calibri Regular.ttf";
        const fontBytes = await fetch(urlFont).then((res) => res.arrayBuffer());

        const pdfDoc = await PDFDocument.load(existingPdfBytes);

        const pages = pdfDoc.getPages();
        const firstPage = pages[0];
        const secondPage = pages[1];

        let nombre = $(this).data("nombre");
        let apellidop = $(this).data("apellidop");
        let apellidom = $(this).data("apellidom");
        let nombrecompleto = `${nombre} ${apellidop} ${apellidom}`;

        let fecha = $(this).data("fechanac");
        fecha = fecha.split("-").reverse().join("/");

        let hoy = new Date();
        hoy = formatDate(hoy);

        pdfDoc.registerFontkit(fontkit);
        const customFont = await pdfDoc.embedFont(fontBytes);

        firstPage.drawText(nombrecompleto, {
            x: 235,
            y: 691,
            size: 9,
            color: rgb(0.12, 0.12, 0.12),
            font: customFont,
        });

        firstPage.drawText(fecha, {
            x: 235,
            y: 680,
            size: 8.5,
            color: rgb(0.12, 0.12, 0.12),
            font: customFont,
        });

        secondPage.drawText(hoy, {
            x: 134,
            y: 80,
            size: 8.5,
            color: rgb(0.12, 0.12, 0.12),
            font: customFont,
        });

        const pdfBytes = await pdfDoc.save();

        // download(pdfBytes, "example.pdf", "application/pdf");
        const bytes = new Uint8Array(pdfBytes);
        const blob = new Blob([bytes], { type: "application/pdf" });
        const docUrl = URL.createObjectURL(blob);

        window.open(docUrl, "_blank");
    });

    $(document).on("click", ".nota", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let codigo = $(this).data("codigo");
        let nota = $(this).data("comprobantenota");
        let img = $(this).data("comprobanteimg");
        if (img.length > 0) {
            $("#comprobanteInput").addClass("is-valid");
            $("#comprobanteInput").removeClass("is-invalid");

            $("#comprobanteDesc").attr("download", `${img}`);
            $("#comprobanteDesc").attr(
                "href",
                `../documentos/comprobantes_pagos/convenios/${codigo}/${img}`
            );

            $("#comprobanteDesc").removeClass("d-none");
        } else {
            $("#comprobanteInput").addClass("is-invalid");
            $("#comprobanteInput").removeClass("is-valid");

            $("#comprobanteDesc").addClass("d-none");
        }

        $("#idInputNota").val(id);
        $("#notaInput").val(nota);
        $("#formModalNota").modal("show");
    });

    $(document).on("change", "#comprobanteInput", function () {
        if ($("#comprobanteInput")[0].files[0]?.name) {
            $("#comprobanteInput").removeClass("is-invalid");
            $("#comprobanteInput").addClass("is-valid");
        } else {
            $("#comprobanteInput").removeClass("is-valid");
            $("#comprobanteInput").addClass("is-invalid");
        }
    });

    $("#formNota").on("submit", function (e) {
        e.preventDefault();
        $("#alertMessage").text("");
        $.ajax({
            type: "POST",
            url: "/admin/cliente/notaMam",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                $("#formModalNota").modal("hide");
                $("#formNota")[0].reset();
                $("#lpoaSwitch").prop("checked", false);
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Nota agregada</h1>',
                    html: '<p style="font-family: Poppins">La nota ha sido agregada correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (err, exception) {
                var validacion = err.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    const switchCliente = () => {
        if ($("#tipoClienteSwitch").prop("checked") == true) {
            $("#codigoClienteCont").hide();
            $("#fechaNacCont").hide();
            $("#dirColCont").hide();
            $("#codCiudCont").hide();
            $("#estCelCont").hide();
            $("#corrCont").hide();
            $("#inPasCont").hide();
            $("#venCuentCont").hide();
            $("#ibanCont").hide();
            $("#inePasCont").hide();
            $("#comprobanteLPOACont").hide();
            $("#formAPRICont").hide();
            $("#cargarCliente").hide();
            $("#formCont").hide();
            $("#identificadorCont").show();

            $("#codigoClienteInput").prop("required", false);
            $("#fechaNacInput").prop("required", false);
            $("#nacionalidadInput").prop("required", false);
            $("#direccionInput").prop("required", false);
            $("#colFraccInput").prop("required", false);
            $("#cpInput").prop("required", false);
            $("#ciudadInput").prop("required", false);
            $("#estadoInput").prop("required", false);
            $("#celularInput").prop("required", false);
            $("#correopInput").prop("required", false);
            $("#correoiInput").prop("required", false);
            $("#ineInput").prop("required", false);
            $("#pasaporteInput").prop("required", false);
            $("#fechapasInput").prop("required", false);
            $("#swiftInput").prop("required", false);
            $("#ibanInput").prop("required", false);
        } else {
            $("#codigoClienteCont").show();
            $("#fechaNacCont").show();
            $("#dirColCont").show();
            $("#codCiudCont").show();
            $("#estCelCont").show();
            $("#corrCont").show();
            $("#inPasCont").show();
            $("#venCuentCont").show();
            $("#ibanCont").show();
            $("#inePasCont").show();
            $("#comprobanteLPOACont").show();
            $("#formAPRICont").show();
            $("#cargarCliente").show();
            $("#formCont").show();
            $("#identificadorCont").hide();

            $("#codigoClienteInput").prop("required", true);
            $("#fechaNacInput").prop("required", true);
            $("#nacionalidadInput").prop("required", true);
            $("#direccionInput").prop("required", true);
            $("#colFraccInput").prop("required", true);
            $("#cpInput").prop("required", true);
            $("#ciudadInput").prop("required", true);
            $("#estadoInput").prop("required", true);
            $("#celularInput").prop("required", true);
            $("#correopInput").prop("required", true);
            $("#correoiInput").prop("required", true);
        }
    };

    switchCliente();

    $("#formIdInput").change(function () {
        var idForm = $("#formIdInput").val();
        $.ajax({
            type: "GET",
            url: "/admin/showFormCliente",
            data: { id: idForm },
            success: function (response) {
                response.map(function (form) {
                    $("#codigoClienteInput").val(form.codigoCliente);
                    $("#nombreInput").val(form.nombre);
                    $("#apellidoPatInput").val(form.apellido_p);
                    $("#apellidoMatInput").val(form.apellido_m);
                    $("#fechaNacInput").val(form.fecha_nacimiento);
                    $("#nacionalidadInput").val(form.nacionalidad);
                    $("#direccionInput").val(form.direccion);
                    $("#colFraccInput").val(form.colonia);
                    $("#cpInput").val(form.cp);
                    $("#ciudadInput").val(form.ciudad);
                    $("#estadoInput").val(form.estado);
                    $("#celularInput").val(form.celular);
                    $("#correopInput").val(form.correo_personal);
                    $("#correoiInput").val(form.correo_institucional);
                    $("#ineInput").val(form.ine);
                    $("#pasaporteInput").val(form.pasaporte);
                });
            },
        });
    });

    $("#tipoClienteSwitch").change(function () {
        if ($("#tipoClienteSwitch").prop("checked") == true) {
            $("#codigoClienteCont").hide();
            $("#fechaNacCont").hide();
            $("#dirColCont").hide();
            $("#codCiudCont").hide();
            $("#estCelCont").hide();
            $("#corrCont").hide();
            $("#inPasCont").hide();
            $("#venCuentCont").hide();
            $("#ibanCont").hide();
            $("#inePasCont").hide();
            $("#comprobanteLPOACont").hide();
            $("#formAPRICont").hide();
            $("#cargarCliente").hide();
            $("#formCont").hide();
            $("#identificadorCont").show();

            $("#codigoClienteInput").prop("required", false);
            $("#fechaNacInput").prop("required", false);
            $("#nacionalidadInput").prop("required", false);
            $("#direccionInput").prop("required", false);
            $("#colFraccInput").prop("required", false);
            $("#cpInput").prop("required", false);
            $("#ciudadInput").prop("required", false);
            $("#estadoInput").prop("required", false);
            $("#celularInput").prop("required", false);
            $("#correopInput").prop("required", false);
            $("#correoiInput").prop("required", false);
            $("#ineInput").prop("required", false);
            $("#pasaporteInput").prop("required", false);
            $("#fechapasInput").prop("required", false);
            $("#swiftInput").prop("required", false);
            $("#ibanInput").prop("required", false);
        } else {
            $("#codigoClienteCont").show();
            $("#fechaNacCont").show();
            $("#dirColCont").show();
            $("#codCiudCont").show();
            $("#estCelCont").show();
            $("#corrCont").show();
            $("#inPasCont").show();
            $("#venCuentCont").show();
            $("#ibanCont").show();
            $("#inePasCont").show();
            $("#comprobanteLPOACont").show();
            $("#formAPRICont").show();
            $("#cargarCliente").show();
            $("#formCont").show();
            $("#identificadorCont").hide();

            $("#codigoClienteInput").prop("required", true);
            $("#fechaNacInput").prop("required", true);
            $("#nacionalidadInput").prop("required", true);
            $("#direccionInput").prop("required", true);
            $("#colFraccInput").prop("required", true);
            $("#cpInput").prop("required", true);
            $("#ciudadInput").prop("required", true);
            $("#estadoInput").prop("required", true);
            $("#celularInput").prop("required", true);
            $("#correopInput").prop("required", true);
            $("#correoiInput").prop("required", true);
        }
    });

    const documentosClientes = (thiss) => {
        var codigocliente = $(thiss).data("codigocliente");
        codigocliente = codigocliente.split("-");
        codigocliente = `${codigocliente[1]}-${codigocliente[2]}`;
        var inedocumento = $(thiss).data("inedocumento");
        var pasaportedocumento = $(thiss).data("pasaportedocumento");
        var comprobantedomicilio = $(thiss).data("comprobantedomicilio");
        var lpoadocumento = $(thiss).data("lpoadocumento");
        var formapertura = $(thiss).data("formapertura");
        var formriesgos = $(thiss).data("formriesgos");

        if (inedocumento.length > 0) {
            $("#ineDocumentoInput").addClass("is-valid");
            $("#ineDocumentoInput").removeClass("is-invalid");

            $("#ineDocumentoDesc").attr("download", `${inedocumento}`);
            $("#ineDocumentoDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${inedocumento}`
            );
            $("#ineDocumentoDesc").removeClass("d-none");
        } else {
            $("#ineDocumentoInput").addClass("is-invalid");
            $("#ineDocumentoInput").removeClass("is-valid");

            $("#ineDocumentoDesc").addClass("d-none");
        }

        if (pasaportedocumento.length > 0) {
            $("#pasaporteDocumentoInput").addClass("is-valid");
            $("#pasaporteDocumentoInput").removeClass("is-invalid");

            $("#pasaporteDocumentoDesc").attr(
                "download",
                `${pasaportedocumento}`
            );
            $("#pasaporteDocumentoDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${pasaportedocumento}`
            );
            $("#pasaporteDocumentoDesc").removeClass("d-none");
        } else {
            $("#pasaporteDocumentoInput").addClass("is-invalid");
            $("#pasaporteDocumentoInput").removeClass("is-valid");

            $("#pasaporteDocumentoDesc").addClass("d-none");
        }

        if (comprobantedomicilio.length > 0) {
            $("#comprobanteDomicilioInput").addClass("is-valid");
            $("#comprobanteDomicilioInput").removeClass("is-invalid");

            $("#comprobanteDomicilioDesc").attr(
                "download",
                `${comprobantedomicilio}`
            );
            $("#comprobanteDomicilioDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${comprobantedomicilio}`
            );
            $("#comprobanteDomicilioDesc").removeClass("d-none");
        } else {
            $("#comprobanteDomicilioInput").addClass("is-invalid");
            $("#comprobanteDomicilioInput").removeClass("is-valid");

            $("#comprobanteDomicilioDesc").addClass("d-none");
        }

        if (lpoadocumento.length > 0) {
            $("#LPOADocumentoInput").addClass("is-valid");
            $("#LPOADocumentoInput").removeClass("is-invalid");

            $("#LPOADocumentoDesc").attr("download", `${lpoadocumento}`);
            $("#LPOADocumentoDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${lpoadocumento}`
            );
            $("#LPOADocumentoDesc").removeClass("d-none");
        } else {
            $("#LPOADocumentoInput").addClass("is-invalid");
            $("#LPOADocumentoInput").removeClass("is-valid");

            $("#LPOADocumentoDesc").addClass("d-none");
        }

        if (formapertura.length > 0) {
            $("#formAperturaInput").addClass("is-valid");
            $("#formAperturaInput").removeClass("is-invalid");

            $("#formAperturaDesc").attr("download", `${formapertura}`);
            $("#formAperturaDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${formapertura}`
            );
            $("#formAperturaDesc").removeClass("d-none");
        } else {
            $("#formAperturaInput").addClass("is-invalid");
            $("#formAperturaInput").removeClass("is-valid");

            $("#formAperturaDesc").addClass("d-none");
        }

        if (formriesgos.length > 0) {
            $("#formRiesgosInput").addClass("is-valid");
            $("#formRiesgosInput").removeClass("is-invalid");

            $("#formRiesgosDesc").attr("download", `${formriesgos}`);
            $("#formRiesgosDesc").attr(
                "href",
                `../documentos/clientes/${codigocliente}/${formriesgos}`
            );
            $("#formRiesgosDesc").removeClass("d-none");
        } else {
            $("#formRiesgosInput").addClass("is-invalid");
            $("#formRiesgosInput").removeClass("is-valid");

            $("#formRiesgosDesc").addClass("d-none");
        }
    };

    $("#ineDocumentoInput").change(function (event) {
        let datatarget = $(`.${acc}`).data("inedocumento");
        if ($("#ineDocumentoInput")[0].files[0]?.name) {
            $("#ineDocumentoInput").removeClass("is-invalid");
            $("#ineDocumentoInput").addClass("is-valid");
            validarExtension(
                $("#ineDocumentoInput").val(),
                "#ineDocumentoInput"
            );
        } else {
            if (datatarget < 1) {
                $("#ineDocumentoInput").removeClass("is-valid");
                $("#ineDocumentoInput").addClass("is-invalid");
            }
        }
    });

    $("#pasaporteDocumentoInput").change(function (event) {
        let datatarget = $(`.${acc}`).data("pasaportedocumento");

        if ($("#pasaporteDocumentoInput")[0].files[0]?.name) {
            $("#pasaporteDocumentoInput").removeClass("is-invalid");
            $("#pasaporteDocumentoInput").addClass("is-valid");
            validarExtension(
                $("#pasaporteDocumentoInput").val(),
                "#pasaporteDocumentoInput"
            );
        } else {
            if (datatarget < 1) {
                $("#pasaporteDocumentoInput").removeClass("is-valid");
                $("#pasaporteDocumentoInput").addClass("is-invalid");
            }
        }
    });

    $("#comprobanteDomicilioInput").change(function () {
        let datatarget = $(`.${acc}`).data("comprobantedomicilio");

        if ($("#comprobanteDomicilioInput")[0].files[0]?.name) {
            $("#comprobanteDomicilioInput").removeClass("is-invalid");
            $("#comprobanteDomicilioInput").addClass("is-valid");
            validarExtension(
                $("#comprobanteDomicilioInput").val(),
                "#comprobanteDomicilioInput"
            );
        } else {
            if (datatarget < 1) {
                $("#comprobanteDomicilioInput").removeClass("is-valid");
                $("#comprobanteDomicilioInput").addClass("is-invalid");
            }
        }
    });

    $("#LPOADocumentoInput").change(function (event) {
        let datatarget = $(`.${acc}`).data("lpoadocumento");
        let ext = "";

        if ($("#LPOADocumentoInput")[0].files[0]?.name) {
            $("#LPOADocumentoInput").removeClass("is-invalid");
            $("#LPOADocumentoInput").addClass("is-valid");
            ext = validarExtension(
                $("#LPOADocumentoInput").val(),
                "#LPOADocumentoInput"
            );
        } else {
            if (datatarget < 1) {
                $("#LPOADocumentoInput").removeClass("is-valid");
                $("#LPOADocumentoInput").addClass("is-invalid");
            }
        }

        let srcPath = event.target.files[0];
        let objectURL = URL.createObjectURL(srcPath);
        console.log(ext);
        if (ext == "pdf" || ext == "PDF") {
            validarDocumento(
                objectURL,
                "Poder limitado de representación",
                "#LPOADocumentoInput"
            );
        } else {
            validarImagen(
                objectURL,
                "Poder limitado de representación",
                "#LPOADocumentoInput"
            );
        }
    });

    $("#formAperturaInput").change(function (event) {
        let datatarget = $(`.${acc}`).data("formapertura");
        let ext = "";

        if ($("#formAperturaInput")[0].files[0]?.name) {
            $("#formAperturaInput").removeClass("is-invalid");
            $("#formAperturaInput").addClass("is-valid");
            ext = validarExtension(
                $("#formAperturaInput").val(),
                "#formAperturaInput"
            );
        } else {
            if (datatarget < 1) {
                $("#formAperturaInput").removeClass("is-valid");
                $("#formAperturaInput").addClass("is-invalid");
            }
        }

        let srcPath = event.target.files[0];
        let objectURL = URL.createObjectURL(srcPath);
        console.log(ext);
        if (ext == "pdf" || ext == "PDF") {
            validarDocumento(
                objectURL,
                "FORMULARIO DE APERTURA DE CUENTA",
                "#formAperturaInput"
            );
        } else {
            validarImagen(
                objectURL,
                "FORMULARIO DE APERTURA DE CUENTA",
                "#formAperturaInput"
            );
        }
    });

    $("#formRiesgosInput").change(function (event) {
        let datatarget = $(`.${acc}`).data("formriesgos");
        let ext = "";

        if ($("#formRiesgosInput")[0].files[0]?.name) {
            $("#formRiesgosInput").removeClass("is-invalid");
            $("#formRiesgosInput").addClass("is-valid");
            ext = validarExtension(
                $("#formRiesgosInput").val(),
                "#formRiesgosInput"
            );
        } else {
            if (datatarget < 1) {
                $("#formRiesgosInput").removeClass("is-valid");
                $("#formRiesgosInput").addClass("is-invalid");
            }
        }

        let srcPath = event.target.files[0];
        let objectURL = URL.createObjectURL(srcPath);
        console.log(ext);
        if (ext == "pdf" || ext == "PDF") {
            validarDocumento(
                objectURL,
                "Documento de Información sobre los Riesgos Relacionados con Forex y CFD",
                "#formRiesgosInput"
            );
        } else {
            validarImagen(
                objectURL,
                "Documento de Información sobre los Riesgos Relacionados con Forex y CFD",
                "#formRiesgosInput"
            );
        }
    });

    const validarExtension = (file, input) => {
        var extensiones =
            /(.png|.jpg|.jpeg|.pdf|.jfif|.PNG|.JPG|.JPEG|.PDF|.JFIF)$/i;
        if (!extensiones.exec(file)) {
            Swal.fire({
                icon: "error",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">Extensión invalida</h1>',
                html: `<p style="font-family: Poppins">Las extensiones permitidas son: <b>png, jpg, jpeg, pdf y jfif</b></p>`,
                confirmButtonText:
                    '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });

            $(input).val("");
            $(input).removeClass("is-valid");

            return false;
        } else {
            let ext = file.split(".");
            return ext[ext.length - 1];
        }
    };

    const validarImagen = async (srcImagen, validacion, input) => {
        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Validando imagen, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        Tesseract.recognize(srcImagen, "spa").then(({ data: { text } }) => {
            let pos = text.indexOf(validacion);
            Swal.close();

            if (pos == -1) {
                Swal.fire({
                    icon: "warning",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">El archivo subido no es lo que se pide</h1>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });

                $(input).val("");
                $(input).removeClass("is-valid");
            }
        });
    };

    const getContent = async (src) => {
        const doc = await pdfjsLib.getDocument(src).promise;
        const page = await doc.getPage(1);
        return await page.getTextContent();
    };

    const validarDocumento = async (src, validacion, input) => {
        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Validando documento, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        const content = await getContent(src);
        const texto = [];
        content.items.map((item) => {
            texto.push(item.str);
        });
        let pos = texto.indexOf(validacion);

        Swal.close();
        if (pos == -1) {
            Swal.fire({
                icon: "warning",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">El archivo subido no es lo que se pide</h1>',
                confirmButtonText:
                    '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });

            $(input).val("");
            $(input).removeClass("is-valid");
        }
    };
});

$(".table").addClass("compact nowrap w-100");
