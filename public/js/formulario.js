$(document).ready(function () {
    const config = {
        search: true,
    };

    dselect(document.querySelector("#psInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    let acc = "";

    var table = $("#formulario").DataTable({
        ajax: "/admin/showFormulario",
        columns: [
            {
                data: "codigoCliente",
            },
            {
                data: "nombre",
            },
            {
                data: "apellido_p",
            },
            {
                data: "apellido_m",
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
            lengthMenu: "Mostrar _MENU_ cuentas",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningúna cuenta",
            infoEmpty: "Mostrando cuentas del 0 al 0 de un total de 0 cuentas",
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
                collage: {
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
        order: [[0, "desc"]],
    });

    var formatearCantidad = new Intl.NumberFormat("es-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#formularioForm").on("submit", function (e) {
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
                $("#formModal").modal("hide");
                $("#formularioForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cuenta añadida</h1>',
                        html: `<p style="font-family: Poppins">La cuenta ha sido añadida correctamente</p>`,
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
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
            error: function (error, exception) {
                console.log(error);
                var validacion = error.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#formularioForm")[0].reset();

        $("#alertMessage").text("");
        acc = "new";
        $("#formularioForm").attr("action", "/admin/addFormulario");
        $("#idInput").val("");

        $("#psInput").next().children().first().empty();
        $("#psInput").next().children().first().text("Selecciona");
        $("#psInput").next().children().first().attr("data-dselect-text", "");
        $("#psInput").next().children().first().attr("disabled", false);

        $.get({
            url: "/admin/showNumeroClienteForm", // Pass your tenant
            success: function (response) {
                $("#codigoClienteInput").val(response.numeroCliente);
                $("#correoiInput").val(response.correoCliente);
            },
            error: function (error) {
                console.log(error);
            },
        });

        $("#codigoClienteInput").prop("readonly", false);
        $("#nombreInput").prop("readonly", false);
        $("#apellidoPatInput").prop("readonly", false);
        $("#apellidoMatInput").prop("readonly", false);
        $("#fechaNacInput").prop("readonly", false);
        $("#nacionalidadInput").prop("readonly", false);
        $("#solteroInput").prop("disabled", false);
        $("#casadoInput").prop("disabled", false);
        $("#concubinatoInput").prop("disabled", false);
        $("#direccionInput").prop("readonly", false);
        $("#colFraccInput").prop("readonly", false);
        $("#cpInput").prop("readonly", false);
        $("#ciudadInput").prop("readonly", false);
        $("#estadoInput").prop("readonly", false);
        $("#paisInput").prop("readonly", false);
        $("#celularInput").prop("readonly", false);
        $("#correopInput").prop("readonly", false);
        $("#correoiInput").prop("readonly", false);
        $("#trabajoFueraSiInput").prop("disabled", false);
        $("#trabajoFueraNoInput").prop("disabled", false);
        $("#situacionLaboralInput").prop("disabled", false);
        $("#empresaAjenaInput").prop("readonly", false);
        $("#puestoTrabajoAjenaInput").prop("readonly", false);
        $("#serviciosAjenaInput").prop("disabled", false);
        $("#comercialAjenaInput").prop("disabled", false);
        $("#industrialAjenaInput").prop("disabled", false);
        $("#publicoAjenaInput").prop("disabled", false);
        $("#privadoAjenaInput").prop("disabled", false);
        $("#empresaPropiaInput").prop("readonly", false);
        $("#puestoTrabajoPropiaInput").prop("readonly", false);
        $("#porcentajeAccionesInput").prop("readonly", false);
        $("#montoFacturadoInput").prop("readonly", false);
        $("#paginaWebInput").prop("readonly", false);
        $("#serviciosPropiaInput").prop("disabled", false);
        $("#comercialPropiaInput").prop("disabled", false);
        $("#industrialPropiaInput").prop("disabled", false);
        $("#personasCargo0Input").prop("disabled", false);
        $("#personasCargo1Input").prop("disabled", false);
        $("#personasCargo2Input").prop("disabled", false);
        $("#personasCargo3Input").prop("disabled", false);
        $("#personasCargo4Input").prop("disabled", false);
        $("#personasCargo5Input").prop("disabled", false);
        $("#personasCargo6Input").prop("disabled", false);
        $("#personasCargo7Input").prop("disabled", false);
        $("#personasCargo8Input").prop("disabled", false);
        $("#personasCargo9Input").prop("disabled", false);
        $("#personasCargo10Input").prop("disabled", false);
        $("#ultimoEmpleoInput").prop("readonly", false);
        $("#ultimoEmpleadorInput").prop("readonly", false);
        $("#empleoInput").prop("readonly", false);
        $("#montoMensualInput").prop("readonly", false);
        $("#ajenaInput").prop("readonly", false);
        $("#propiaInput").prop("readonly", false);
        $("#escuelaInput").prop("readonly", false);
        $("#facultadInput").prop("readonly", false);
        $("#especifiqueInput").prop("readonly", false);
        $("#funcionPublicaInput").prop("readonly", false);
        $("#funcionPublicaSiInput").prop("disabled", false);
        $("#funcionPublicaNoInput").prop("disabled", false);
        $("#residenciaInput").prop("disabled", false);
        $("#rfcInput").prop("readonly", false);
        $("#depositoInput").prop("readonly", false);
        $("#origenDinero").prop("disabled", false);
        $("#psInput").prop("disabled", false);

        $("#modalTitle").text("Formulario de cuenta Forex");
        $("#btnSubmit").text("Agregar cuenta Forex");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#formularioForm")[0].reset();
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();
        var id = $(this).data("id");

        var codigocliente = $(this).data("codigocliente");
        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var fechanac = $(this).data("fechanac");
        var nacionalidad = $(this).data("nacionalidad");
        var estadocivil = $(this).data("estadocivil");
        var direccion = $(this).data("direccion");
        var colonia = $(this).data("colonia");
        var cp = $(this).data("cp");
        var ciudad = $(this).data("ciudad");
        var estado = $(this).data("estado");
        var pais = $(this).data("pais");
        var celular = $(this).data("celular");
        var correop = $(this).data("correop");
        var correoi = $(this).data("correoi");
        var fueramexico = $(this).data("fueramexico");
        var situacionlaboral = $(this).data("situacionlaboral");
        var nombredireccion = $(this).data("nombredireccion");
        var giroempresa = $(this).data("giroempresa");
        var puesto = $(this).data("puesto");
        var sectorempresa = $(this).data("sectorempresa");
        var personascargo = $(this).data("personascargo");
        var porcentajeacciones = $(this).data("porcentajeacciones");
        var montoanio = $(this).data("montoanio");
        montoanio = formatearCantidad.format(montoanio);
        var paginaweb = $(this).data("paginaweb");
        var ultimoempleo = $(this).data("ultimoempleo");
        var ultimoempleador = $(this).data("ultimoempleador");
        var statusanterior = $(this).data("statusanterior");
        var montomensualjubilacion = $(this).data("montomensualjubilacion");
        montomensualjubilacion = formatearCantidad.format(
            montomensualjubilacion
        );
        var esculauniversidad = $(this).data("esculauniversidad");
        var campofacultad = $(this).data("campofacultad");
        var especificaciontrabajo = $(this).data("especificaciontrabajo");
        var funcionpublica = $(this).data("funcionpublica");
        var descripcionfuncionpublica = $(this).data(
            "descripcionfuncionpublica"
        );
        var residencia = $(this).data("residencia");
        var rfc = $(this).data("rfc");
        var depositoinicial = $(this).data("depositoinicial");
        depositoinicial = formatearCantidad.format(depositoinicial);
        var origendinero = $(this).data("origendinero");
        var psnombre = $(this).data("psnombre");

        $("#psInput").next().children().first().empty();
        $("#psInput").next().children().first().text(psnombre);
        $("#psInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", psnombre);
        $("#psInput").next().children().first().attr("disabled", true);

        $("#formModal").modal("show");

        $("#idInput").val(id);

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

        $("#solteroInput").prop("disabled", true);
        $("#casadoInput").prop("disabled", true);
        $("#concubinatoInput").prop("disabled", true);

        if (estadocivil == "SOLTERO") {
            $("#solteroInput").val(estadocivil);
            $("#solteroInput").prop("checked", true);
        } else if (estadocivil == "CASADO") {
            $("#casadoInput").val(estadocivil);
            $("#casadoInput").prop("checked", true);
        } else if (estadocivil == "CONCUBINATO") {
            $("#concubinatoInput").val(estadocivil);
            $("#concubinatoInput").prop("checked", true);
        }

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

        $("#paisInput").val(pais);
        $("#paisInput").prop("readonly", true);

        $("#celularInput").val(celular);
        $("#celularInput").prop("readonly", true);

        $("#correopInput").val(correop);
        $("#correopInput").prop("readonly", true);

        $("#correoiInput").val(correoi);
        $("#correoiInput").prop("readonly", true);

        $("#trabajoFueraSiInput").prop("disabled", true);
        $("#trabajoFueraNoInput").prop("disabled", true);

        if (fueramexico == "SI") {
            $("#trabajoFueraSiInput").val(fueramexico);
            $("#trabajoFueraSiInput").prop("checked", true);
        } else if (fueramexico == "NO") {
            $("#trabajoFueraNoInput").val(fueramexico);
            $("#trabajoFueraNoInput").prop("checked", true);
        }

        $("#situacionLaboralInput").val(situacionlaboral);
        $("#situacionLaboralInput").prop("disabled", true);

        situacionLaboralView(situacionlaboral);

        if (situacionlaboral == "AJENA") {
            $("#puestoTrabajoAjenaInput").val(puesto);
            $("#empresaAjenaInput").val(nombredireccion);

            if (giroempresa == "SERVICIOS") {
                $("#serviciosAjenaInput").val(giroempresa);
                $("#serviciosAjenaInput").prop("checked", true);
            } else if (giroempresa == "COMERCIAL") {
                $("#comercialAjenaInput").val(giroempresa);
                $("#comercialAjenaInput").prop("checked", true);
            } else if (giroempresa == "INDUSTRIAL") {
                $("#industrialAjenaInput").val(giroempresa);
                $("#industrialAjenaInput").prop("checked", true);
            }

            if (sectorempresa == "PUBLICO") {
                $("#publicoAjenaInput").val(sectorempresa);
                $("#publicoAjenaInput").prop("checked", true);
            } else if (sectorempresa == "PRIVADO") {
                $("#privadoAjenaInput").val(sectorempresa);
                $("#privadoAjenaInput").prop("checked", true);
            }
        } else if (situacionlaboral == "PROPIA") {
            $("#empresaPropiaInput").val(nombredireccion);
            $("#puestoTrabajoPropiaInput").val(puesto);
            $("#porcentajeAccionesInput").val(porcentajeacciones);
            $("#montoFacturadoInput").val(montoanio);
            $("#paginaWebInput").val(paginaweb);

            if (giroempresa == "SERVICIOS") {
                $("#serviciosPropiaInput").val(giroempresa);
                $("#serviciosPropiaInput").prop("checked", true);
            } else if (giroempresa == "COMERCIAL") {
                $("#comercialPropiaInput").val(giroempresa);
                $("#comercialPropiaInput").prop("checked", true);
            } else if (giroempresa == "INDUSTRIAL") {
                $("#industrialPropiaInput").val(giroempresa);
                $("#industrialPropiaInput").prop("checked", true);
            }

            if (personascargo == 0) {
                $("#personasCargo0Input").val(personascargo);
                $("#personasCargo0Input").prop("checked", true);
            } else if (personascargo == 1) {
                $("#personasCargo1Input").val(personascargo);
                $("#personasCargo1Input").prop("checked", true);
            } else if (personascargo == 2) {
                $("#personasCargo2Input").val(personascargo);
                $("#personasCargo2Input").prop("checked", true);
            } else if (personascargo == 3) {
                $("#personasCargo3Input").val(personascargo);
                $("#personasCargo3Input").prop("checked", true);
            } else if (personascargo == 4) {
                $("#personasCargo4Input").val(personascargo);
                $("#personasCargo4Input").prop("checked", true);
            } else if (personascargo == 5) {
                $("#personasCargo5Input").val(personascargo);
                $("#personasCargo5Input").prop("checked", true);
            } else if (personascargo == 6) {
                $("#personasCargo6Input").val(personascargo);
                $("#personasCargo6Input").prop("checked", true);
            } else if (personascargo == 7) {
                $("#personasCargo7Input").val(personascargo);
                $("#personasCargo7Input").prop("checked", true);
            } else if (personascargo == 8) {
                $("#personasCargo8Input").val(personascargo);
                $("#personasCargo8Input").prop("checked", true);
            } else if (personascargo == 9) {
                $("#personasCargo9Input").val(personascargo);
                $("#personasCargo9Input").prop("checked", true);
            } else if (personascargo == 10) {
                $("#personasCargo10Input").val(personascargo);
                $("#personasCargo10Input").prop("checked", true);
            }
        } else if (situacionlaboral == "DESEMPLEADO") {
            $("#ultimoEmpleoInput").val(ultimoempleo);
            $("#ultimoEmpleadorInput").val(ultimoempleador);
        } else if (situacionlaboral == "JUBILADO") {
            $("#empleoInput").val(ultimoempleo);
            $("#montoMensualInput").val(montomensualjubilacion);

            if (statusanterior == "AJENA") {
                $("#ajenaInput").val(statusanterior);
                $("#ajenaInput").prop("checked", true);
            } else if (statusanterior == "PROPIA") {
                $("#propiaInput").val(statusanterior);
                $("#propiaInput").prop("checked", true);
            }
        } else if (situacionlaboral == "ESTUDIANTE") {
            $("#escuelaInput").val(esculauniversidad);
            $("#facultadInput").val(campofacultad);
        } else if (situacionlaboral == "OTROS") {
            $("#especifiqueInput").val(especificaciontrabajo);
        }

        $("#funcionPublicaInput").val(descripcionfuncionpublica);
        $("#funcionPublicaInput").prop("readonly", true);

        $("#funcionPublicaSiInput").prop("disabled", true);
        $("#funcionPublicaNoInput").prop("disabled", true);

        if (funcionpublica == "SI") {
            $("#funcionPublicaSiInput").val(funcionpublica);
            $("#funcionPublicaSiInput").prop("checked", true);
        } else if (funcionpublica == "NO") {
            $("#funcionPublicaNoInput").val(funcionpublica);
            $("#funcionPublicaNoInput").prop("checked", true);
        }

        $("#depositoInput").val(depositoinicial);
        $("#depositoInput").prop("readonly", true);

        $("#residenciaInput").val(residencia);
        $("#residenciaInput").prop("disabled", true);

        $("#rfcInput").val(rfc);
        $("#rfcInput").prop("readonly", true);

        $("#origenDinero").val(origendinero);
        $("#origenDinero").prop("disabled", true);

        $("#psInput").val(psnombre);
        $("#psInput").prop("disabled", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        e.preventDefault();
        $("#formularioForm")[0].reset();
        $("#alertMessage").text("");
        acc = "edit";
        var id = $(this).data("id");

        var codigocliente = $(this).data("codigocliente");
        var nombre = $(this).data("nombre");
        var apellidop = $(this).data("apellidop");
        var apellidom = $(this).data("apellidom");
        var fechanac = $(this).data("fechanac");
        var nacionalidad = $(this).data("nacionalidad");
        var estadocivil = $(this).data("estadocivil");
        var direccion = $(this).data("direccion");
        var colonia = $(this).data("colonia");
        var cp = $(this).data("cp");
        var ciudad = $(this).data("ciudad");
        var estado = $(this).data("estado");
        var pais = $(this).data("pais");
        var celular = $(this).data("celular");
        var correop = $(this).data("correop");
        var correoi = $(this).data("correoi");
        var fueramexico = $(this).data("fueramexico");
        var situacionlaboral = $(this).data("situacionlaboral");
        var nombredireccion = $(this).data("nombredireccion");
        var giroempresa = $(this).data("giroempresa");
        var puesto = $(this).data("puesto");
        var sectorempresa = $(this).data("sectorempresa");
        var personascargo = $(this).data("personascargo");
        var porcentajeacciones = $(this).data("porcentajeacciones");
        var montoanio = $(this).data("montoanio");
        montoanio = formatearCantidad.format(montoanio);
        var paginaweb = $(this).data("paginaweb");
        var ultimoempleo = $(this).data("ultimoempleo");
        var ultimoempleador = $(this).data("ultimoempleador");
        var statusanterior = $(this).data("statusanterior");
        var montomensualjubilacion = $(this).data("montomensualjubilacion");
        montomensualjubilacion = formatearCantidad.format(
            montomensualjubilacion
        );
        var esculauniversidad = $(this).data("esculauniversidad");
        var campofacultad = $(this).data("campofacultad");
        var especificaciontrabajo = $(this).data("especificaciontrabajo");
        var funcionpublica = $(this).data("funcionpublica");
        var descripcionfuncionpublica = $(this).data(
            "descripcionfuncionpublica"
        );
        var residencia = $(this).data("residencia");
        var rfc = $(this).data("rfc");
        var depositoinicial = $(this).data("depositoinicial");
        depositoinicial = formatearCantidad.format(depositoinicial);
        var origendinero = $(this).data("origendinero");
        var psnombre = $(this).data("psnombre");

        $("#psInput").next().children().first().empty();
        $("#psInput").next().children().first().text(psnombre);
        $("#psInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", psnombre);
        $("#psInput").next().children().first().attr("disabled", false);

        $("#idInput").val(id);

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

        $("#solteroInput").prop("disabled", false);
        $("#casadoInput").prop("disabled", false);
        $("#concubinatoInput").prop("disabled", false);

        if (estadocivil == "SOLTERO") {
            $("#solteroInput").val(estadocivil);
            $("#solteroInput").prop("checked", true);
        } else if (estadocivil == "CASADO") {
            $("#casadoInput").val(estadocivil);
            $("#casadoInput").prop("checked", true);
        } else if (estadocivil == "CONCUBINATO") {
            $("#concubinatoInput").val(estadocivil);
            $("#concubinatoInput").prop("checked", true);
        }

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

        $("#paisInput").val(pais);
        $("#paisInput").prop("readonly", false);

        $("#celularInput").val(celular);
        $("#celularInput").prop("readonly", false);

        $("#correopInput").val(correop);
        $("#correopInput").prop("readonly", false);

        $("#correoiInput").val(correoi);
        $("#correoiInput").prop("readonly", false);

        $("#trabajoFueraSiInput").prop("disabled", false);
        $("#trabajoFueraNoInput").prop("disabled", false);

        if (fueramexico == "SI") {
            $("#trabajoFueraSiInput").val(fueramexico);
            $("#trabajoFueraSiInput").prop("checked", true);
        } else if (fueramexico == "NO") {
            $("#trabajoFueraNoInput").val(fueramexico);
            $("#trabajoFueraNoInput").prop("checked", true);
        }

        $("#situacionLaboralInput").val(situacionlaboral);
        $("#situacionLaboralInput").prop("disabled", false);

        situacionLaboralEdit(situacionlaboral);

        if (situacionlaboral == "AJENA") {
            $("#puestoTrabajoAjenaInput").val(puesto);
            $("#empresaAjenaInput").val(nombredireccion);

            if (giroempresa == "SERVICIOS") {
                $("#serviciosAjenaInput").val(giroempresa);
                $("#serviciosAjenaInput").prop("checked", true);
            } else if (giroempresa == "COMERCIAL") {
                $("#comercialAjenaInput").val(giroempresa);
                $("#comercialAjenaInput").prop("checked", true);
            } else if (giroempresa == "INDUSTRIAL") {
                $("#industrialAjenaInput").val(giroempresa);
                $("#industrialAjenaInput").prop("checked", true);
            }

            if (sectorempresa == "PUBLICO") {
                $("#publicoAjenaInput").val(sectorempresa);
                $("#publicoAjenaInput").prop("checked", true);
            } else if (sectorempresa == "PRIVADO") {
                $("#privadoAjenaInput").val(sectorempresa);
                $("#privadoAjenaInput").prop("checked", true);
            }
        } else if (situacionlaboral == "PROPIA") {
            $("#empresaPropiaInput").val(nombredireccion);
            $("#puestoTrabajoPropiaInput").val(puesto);
            $("#porcentajeAccionesInput").val(porcentajeacciones);
            $("#montoFacturadoInput").val(montoanio);
            $("#paginaWebInput").val(paginaweb);

            if (giroempresa == "SERVICIOS") {
                $("#serviciosPropiaInput").val(giroempresa);
                $("#serviciosPropiaInput").prop("checked", true);
            } else if (giroempresa == "COMERCIAL") {
                $("#comercialPropiaInput").val(giroempresa);
                $("#comercialPropiaInput").prop("checked", true);
            } else if (giroempresa == "INDUSTRIAL") {
                $("#industrialPropiaInput").val(giroempresa);
                $("#industrialPropiaInput").prop("checked", true);
            }

            if (personascargo == 0) {
                $("#personasCargo0Input").val(personascargo);
                $("#personasCargo0Input").prop("checked", true);
            } else if (personascargo == 1) {
                $("#personasCargo1Input").val(personascargo);
                $("#personasCargo1Input").prop("checked", true);
            } else if (personascargo == 2) {
                $("#personasCargo2Input").val(personascargo);
                $("#personasCargo2Input").prop("checked", true);
            } else if (personascargo == 3) {
                $("#personasCargo3Input").val(personascargo);
                $("#personasCargo3Input").prop("checked", true);
            } else if (personascargo == 4) {
                $("#personasCargo4Input").val(personascargo);
                $("#personasCargo4Input").prop("checked", true);
            } else if (personascargo == 5) {
                $("#personasCargo5Input").val(personascargo);
                $("#personasCargo5Input").prop("checked", true);
            } else if (personascargo == 6) {
                $("#personasCargo6Input").val(personascargo);
                $("#personasCargo6Input").prop("checked", true);
            } else if (personascargo == 7) {
                $("#personasCargo7Input").val(personascargo);
                $("#personasCargo7Input").prop("checked", true);
            } else if (personascargo == 8) {
                $("#personasCargo8Input").val(personascargo);
                $("#personasCargo8Input").prop("checked", true);
            } else if (personascargo == 9) {
                $("#personasCargo9Input").val(personascargo);
                $("#personasCargo9Input").prop("checked", true);
            } else if (personascargo == 10) {
                $("#personasCargo10Input").val(personascargo);
                $("#personasCargo10Input").prop("checked", true);
            }
        } else if (situacionlaboral == "DESEMPLEADO") {
            $("#ultimoEmpleoInput").val(ultimoempleo);
            $("#ultimoEmpleadorInput").val(ultimoempleador);
        } else if (situacionlaboral == "JUBILADO") {
            $("#empleoInput").val(ultimoempleo);
            $("#montoMensualInput").val(montomensualjubilacion);

            if (statusanterior == "AJENA") {
                $("#ajenaInput").val(statusanterior);
                $("#ajenaInput").prop("checked", true);
            } else if (statusanterior == "PROPIA") {
                $("#propiaInput").val(statusanterior);
                $("#propiaInput").prop("checked", true);
            }
        } else if (situacionlaboral == "ESTUDIANTE") {
            $("#escuelaInput").val(esculauniversidad);
            $("#facultadInput").val(campofacultad);
        } else if (situacionlaboral == "OTROS") {
            $("#especifiqueInput").val(especificaciontrabajo);
        }

        $("#funcionPublicaInput").val(descripcionfuncionpublica);
        $("#funcionPublicaInput").prop("readonly", false);

        $("#funcionPublicaSiInput").prop("disabled", false);
        $("#funcionPublicaNoInput").prop("disabled", false);

        if (funcionpublica == "SI") {
            $("#funcionPublicaSiInput").val(funcionpublica);
            $("#funcionPublicaSiInput").prop("checked", true);
        } else if (funcionpublica == "NO") {
            $("#funcionPublicaNoInput").val(funcionpublica);
            $("#funcionPublicaNoInput").prop("checked", true);
        }

        $("#depositoInput").val(depositoinicial);
        $("#depositoInput").prop("readonly", false);

        $("#residenciaInput").val(residencia);
        $("#residenciaInput").prop("disabled", false);

        $("#rfcInput").val(rfc);
        $("#rfcInput").prop("readonly", false);

        $("#origenDinero").val(origendinero);
        $("#origenDinero").prop("disabled", false);

        $("#psInput").val(psnombre);
        $("#psInput").prop("disabled", false);

        $("#modalTitle").text("Cuenta forex");
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar cuenta");
        $("#btnCancel").text("Cancelar");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar cuenta forex</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar la cuenta</p>',
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
                            $("#formularioForm").attr(
                                "action",
                                "/admin/editFormulario"
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

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar cuenta</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar la cuenta</p>',
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
                                "/admin/deleteFormulario",
                                { id: id },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cuenta eliminada</h1>',
                                        html: '<p style="font-family: Poppins">La cuenta se ha eliminada correctamente</p>',
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
                    html: '<p style="font-family: Poppins">La cuenta no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("change", "#situacionLaboralInput", function (e) {
        let situacion_laboral = $("#situacionLaboralInput").val();

        situacionLaboralEdit(situacion_laboral);
    });

    $(document).on("change", "#montoFacturadoInput", function (e) {
        let montoFacturado = $("#montoFacturadoInput").val();
        montoFacturado = montoFacturado.replace("$", "");
        montoFacturado = montoFacturado.replace(",", "");
        $("#montoFacturadoInput").val(formatearCantidad.format(montoFacturado));
    });

    $(document).on("change", "#montoMensualInput", function (e) {
        let montoMensual = $("#montoMensualInput").val();
        montoMensual = montoMensual.replace("$", "");
        montoMensual = montoMensual.replace(",", "");
        $("#montoMensualInput").val(formatearCantidad.format(montoMensual));
    });

    $(document).on("change", "#depositoInput", function (e) {
        let depositoInput = $("#depositoInput").val();
        depositoInput = depositoInput.replace("$", "");
        depositoInput = depositoInput.replace(",", "");
        $("#depositoInput").val(formatearCantidad.format(depositoInput));
    });

    $("#funcionPublicaInput").hide();

    $(document).on("change", "#funcionPublicaSiInput", function (e) {
        if ($("#funcionPublicaSiInput").is(":checked")) {
            $("#funcionPublicaInput").show();
        } else {
            $("#funcionPublicaInput").hide();
        }
    });

    $(document).on("change", "#funcionPublicaNoInput", function (e) {
        if ($("#funcionPublicaNoInput").is(":checked")) {
            $("#funcionPublicaInput").hide();
        } else {
            $("#funcionPublicaInput").show();
        }
    });

    const situacionLaboralView = (situacion_laboral) => {
        if (situacion_laboral == "AJENA") {
            $("#ajenaContainer").removeClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#puestoTrabajoAjenaInput").prop("readonly", true);
            $("#empresaAjenaInput").prop("readonly", true);
            $("#serviciosAjenaInput").prop("disabled", true);
            $("#comercialAjenaInput").prop("disabled", true);
            $("#industrialAjenaInput").prop("disabled", true);
            $("#publicoAjenaInput").prop("disabled", true);
            $("#privadoAjenaInput").prop("disabled", true);
            $("#ajenaInput").prop("readonly", true);
        } else if (situacion_laboral == "PROPIA") {
            $("#propiaContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#empresaPropiaInput").prop("readonly", true);
            $("#puestoTrabajoPropiaInput").prop("readonly", true);
            $("#porcentajeAccionesInput").prop("readonly", true);
            $("#montoFacturadoInput").prop("readonly", true);
            $("#paginaWebInput").prop("readonly", true);
            $("#serviciosPropiaInput").prop("disabled", true);
            $("#comercialPropiaInput").prop("disabled", true);
            $("#industrialPropiaInput").prop("disabled", true);
            $("#propiaInput").prop("readonly", true);
        } else if (situacion_laboral == "DESEMPLEADO") {
            $("#desempleadoContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#ultimoEmpleoInput").prop("readonly", true);
            $("#ultimoEmpleadorInput").prop("readonly", true);
        } else if (situacion_laboral == "JUBILADO") {
            $("#jubiladoContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#empleoInput").prop("readonly", true);
            $("#montoMensualInput").prop("readonly", true);
        } else if (situacion_laboral == "ESTUDIANTE") {
            $("#estudianteContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#escuelaInput").prop("readonly", true);
            $("#facultadInput").prop("readonly", true);
        } else if (situacion_laboral == "OTROS") {
            $("#otroContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");

            $("#especifiqueInput").prop("readonly", true);
        }
    };

    const situacionLaboralEdit = (situacion_laboral) => {
        if (situacion_laboral == "AJENA") {
            $("#ajenaContainer").removeClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#puestoTrabajoAjenaInput").prop("readonly", false);
            $("#empresaAjenaInput").prop("readonly", false);
            $("#serviciosAjenaInput").prop("disabled", false);
            $("#comercialAjenaInput").prop("disabled", false);
            $("#industrialAjenaInput").prop("disabled", false);
            $("#publicoAjenaInput").prop("disabled", false);
            $("#privadoAjenaInput").prop("disabled", false);
            $("#ajenaInput").prop("readonly", false);
        } else if (situacion_laboral == "PROPIA") {
            $("#propiaContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#empresaPropiaInput").prop("readonly", false);
            $("#puestoTrabajoPropiaInput").prop("readonly", false);
            $("#porcentajeAccionesInput").prop("readonly", false);
            $("#montoFacturadoInput").prop("readonly", false);
            $("#paginaWebInput").prop("readonly", false);
            $("#serviciosPropiaInput").prop("disabled", false);
            $("#comercialPropiaInput").prop("disabled", false);
            $("#industrialPropiaInput").prop("disabled", false);
            $("#propiaInput").prop("readonly", false);
        } else if (situacion_laboral == "DESEMPLEADO") {
            $("#desempleadoContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#ultimoEmpleoInput").prop("readonly", false);
            $("#ultimoEmpleadorInput").prop("readonly", false);
        } else if (situacion_laboral == "JUBILADO") {
            $("#jubiladoContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#empleoInput").prop("readonly", false);
            $("#montoMensualInput").prop("readonly", false);
        } else if (situacion_laboral == "ESTUDIANTE") {
            $("#estudianteContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#otroContainer").addClass("d-none");

            $("#escuelaInput").prop("readonly", false);
            $("#facultadInput").prop("readonly", false);
        } else if (situacion_laboral == "OTROS") {
            $("#otroContainer").removeClass("d-none");
            $("#ajenaContainer").addClass("d-none");
            $("#propiaContainer").addClass("d-none");
            $("#desempleadoContainer").addClass("d-none");
            $("#jubiladoContainer").addClass("d-none");
            $("#estudianteContainer").addClass("d-none");

            $("#especifiqueInput").prop("readonly", false);
        }
    };
});

$(".table").addClass("compact nowrap w-100");
