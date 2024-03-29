$(document).ready(function () {
    let acc = "";

    var table = $("#convenioTerminado").DataTable({
        ajax: "/admin/showConvenioTerminado",
        columns: [{ data: "folio" }, { data: "status" }, { data: "btn" }],
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
                collaconvenioe: {
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
        aaSorting: [],
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#convenioForm").on("submit", function (e) {
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
                $("#convenioForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Convenio añadido</h1>',
                        html: '<p style="font-family: Poppins">El convenio ha sido añadido correctamente</p>',
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

    $(document).on("click", ".view", function (e) {
        $("#convenioForm")[0].reset();

        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var id = $(this).data("id");
        var folio = $(this).data("folio");
        var nombrecliente = $(this).data("nombrecliente");
        var monto = $(this).data("monto");
        var monto_letra = $(this).data("monto_letra");
        var fecha_inicio = $(this).data("fecha_inicio");
        var fecha_fin = $(this).data("fecha_fin");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var ctrimestral = $(this).data("ctrimestral");
        var status = $(this).data("status");
        var numerocuenta = $(this).data("numerocuenta");
        var loggin = $(this).data("loggin");
        var ps_id = $(this).data("ps_id");
        var cliente_id = $(this).data("cliente_id");
        var banco_id = $(this).data("banco_id");
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
        $("#montoInput").val(monto);
        $("#montoInput").prop("readonly", true);

        $("#montoLetraInput").val(monto_letra);
        $("#montoLetraInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", true);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", true);

        ctrimestral = ctrimestral.toString().replace(",", ".");
        $("#cTrimestralInput").val(ctrimestral);
        $("#cTrimestralInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#numeroCuentaInput").val(numerocuenta);
        $("#numeroCuentaInput").prop("readonly", true);

        $("#logginInput").val(loggin);
        $("#logginInput").prop("readonly", true);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", true);

        $("#bancoIdInput").val(banco_id);
        $("#bancoIdInput").prop("disabled", true);

        $("#modifySwitch").prop("disabled", true);

        $("#beneficiariosInput").prop("disabled", true);
        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiariosConvenioTerminido",
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
        var fecha_fin = $(this).data("fecha_fin");
        var capertura = $(this).data("capertura");
        var cmensual = $(this).data("cmensual");
        var ctrimestral = $(this).data("ctrimestral");
        var status = $(this).data("status");
        var numerocuenta = $(this).data("numerocuenta");
        var loggin = $(this).data("loggin");
        var ps_id = $(this).data("ps_id");
        var cliente_id = $(this).data("cliente_id");
        var psnombre = $(this).data("psnombre");
        var banco_id = $(this).data("banco_id");
        var firma = $(this).data("firma");

        if (cmensual.toString().charAt(1) == ",") {
            cmensual = cmensual.replace(",", ".");
        }

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

        $("#convenioForm").attr("action", "/admin/editConvenioTerminado");

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
        $("#montoInput").val(monto);
        $("#montoInput").prop("readonly", true);

        $("#montoLetraInput").val(monto_letra);
        $("#montoLetraInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", true);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("readonly", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("readonly", true);

        ctrimestral = ctrimestral.toString().replace(",", ".");
        $("#cTrimestralInput").val(ctrimestral);
        $("#cTrimestralInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#numeroCuentaInput").val(numerocuenta);
        $("#numeroCuentaInput").prop("readonly", true);

        $("#logginInput").val(loggin);
        $("#logginInput").prop("readonly", true);

        $("#psIdInput").val(ps_id);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(cliente_id);
        $("#clienteIdInput").prop("disabled", true);

        $("#bancoIdInput").val(banco_id);
        $("#bancoIdInput").prop("disabled", true);

        $("#modifySwitch").prop("disabled", true);

        $("#beneficiariosInput").prop("disabled", true);
        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiariosConvenioTerminido",
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
                                    <input type="text" class="form-control" placeholder="Ingresa el nombre del ${adjetivo} beneficiario" id="nombreBen${i}Input" name="nombre-ben${i}" minlength="3" maxlength="255" readonly>
                                    <label for="nombreBen${i}Input">Nombre del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje del ${adjetivo} beneficiario" id="porcentajeBen${i}Input" name="porcentaje-ben${i}" value="0" readonly>
                                    <label for="porcentajeBen${i}Input">Porcentaje del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" placeholder="Ingresa el telefono del ${adjetivo} beneficiario" id="telefonoBen${i}Input" name="telefono-ben${i}" minlength="3" maxlength="100" readonly>
                                    <label for="telefonoBen${i}Input">Teléfono del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" class="form-control" placeholder="Ingresa el correo del ${adjetivo} beneficiario" id="correoBen${i}Input" name="correo-ben${i}" minlength="3" maxlength="100" readonly>
                                    <label for="correoBen${i}Input">Correo del ${adjetivo} beneficiario</label>
                                </div>
                            </div>                            
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" placeholder="Ingresa la curp del ${adjetivo} beneficiario" id="curpBen${i}Input" name="curp-ben${i}" minlength="3" maxlength="100" readonly>
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
                                <input type="text" class="form-control" placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input" name="nombre-ben1" minlength="3" maxlength="255" readonly>
                                <label for="nombreBen1Input">Nombre del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" step="any" class="form-control" placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input" name="porcentaje-ben1" value="0" readonly>
                                <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control" placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input" name="telefono-ben1" minlength="3" maxlength="100" readonly>
                                <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">                                
                                <input type="text" class="form-control" placeholder="Ingresa el correo del beneficiario" id="correoBen1Input" name="correo-ben1" minlength="3" maxlength="100" readonly>
                                <label for="correoBen1Input">Correo del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="Ingresa la curp del beneficiario" id="curpBen1Input" name="curp-ben1" minlength="3" maxlength="100" readonly>
                                <label for="curpBen1Input">CURP del beneficiario</label>
                            </div>
                        </div>
                `);
                }
            },
        });

        $("#modalTitle").text(`Editar convenio de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar convenio");
        $("#btnCancel").text("Cancelar");

        $("#contPagos").empty();
        var meses = 12;

        if ($("#fechaInicioInput").val()) {
            var fechaInicio = $("#fechaInicioInput").val();
            fechaInicio = new Date(fechaInicio);
            fechaInicio = fechaInicio.addDays(1);

            var fechaFin = new Date(
                fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
            );

            fechaFin = formatDate(fechaFin).split("/").reverse().join("-");

            $("#fechaFinInput").val(fechaFin);
        }
        if (
            $("#montoInput").val() &&
            $("#fechaInicioInput").val() &&
            $("#fechaFinInput").val()
        ) {
            $("#contPagos").empty();

            var capertura = $("#cAperturaInput").val();
            if (capertura.length < 3 && capertura.length > 0) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `0.0${capertura}`;
                }
            } else if (capertura.length == 3) {
                var posicion = capertura.indexOf(".");
                if (posicion > 0) {
                    capertura = capertura.replace(".", "");
                    capertura = `0.0${capertura}`;
                } else {
                    var capertura = `${capertura}`;
                }
            }
            capertura = parseFloat(capertura);

            var cmensual = $("#cMensualInput").val();
            if (cmensual.length < 3 && cmensual.length > 0) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `0.0${cmensual}`;
                }
            } else if (cmensual.length == 3) {
                var posicion = cmensual.indexOf(".");
                if (posicion > 0) {
                    cmensual = cmensual.replace(".", "");
                    cmensual = `0.0${cmensual}`;
                } else {
                    var cmensual = `${cmensual}`;
                }
            }
            cmensual = parseFloat(cmensual);

            var ctrimestral = $("#cTrimestralInput").val();
            if (ctrimestral.length < 3 && ctrimestral.length > 0) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `0.0${ctrimestral}`;
                }
            } else if (ctrimestral.length == 3) {
                var posicion = ctrimestral.indexOf(".");
                if (posicion > 0) {
                    ctrimestral = ctrimestral.replace(".", "");
                    ctrimestral = `0.0${ctrimestral}`;
                } else {
                    var ctrimestral = `${ctrimestral}`;
                }
            }
            ctrimestral = parseFloat(ctrimestral);

            var monto = $("#montoInput").val();
            monto = parseFloat(monto);

            var fecha = $("#fechaInicioInput").val();
            fecha = new Date(fecha);
            fecha = fecha.addDays(1);

            for (var i = 1; i < 13; i++) {
                monto = $("#montoInput").val();
                var monto2 = monto;

                var fechaPago = fecha;
                fechaPago.setMonth(fechaPago.getMonth() + 1);
                var añoPago = fechaPago.getFullYear();
                var mesPago = fechaPago.getMonth();

                fechaPago = lastDay(añoPago, mesPago);
                fechaPago = formatDate(fechaPago);
                fechaPago = fechaPago.split("/").reverse().join("-");

                var fechaLimite = fecha;
                fechaLimite.setMonth(fechaLimite.getMonth() + 1);
                fechaLimite.setDate(10);
                fechaLimite = formatDate(fechaLimite);
                fechaLimite = fechaLimite.split("/").reverse().join("-");

                if (i == 1) {
                    monto = monto * capertura;
                    monto2 = monto2 * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops0" id="seriePagoPS0Input" value="0">
                            <input type="hidden" name="fecha-pagops0" id="fechaPago0Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops0" id="fechaLimite0Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops0" id="montoReintegro0Input" value="${monto.toFixed(
                                2
                            )}">
                            `
                    );
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                } else if (i == 3 || i == 6 || i == 9 || i == 12) {
                    monto2 = monto * ctrimestral;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}trimestral" id="seriePagoPS${i}TrimestralInput" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}trimestral" id="fechaPago${i}TrimestralInput" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}trimestral" id="fechaLimite${i}TrimestralInput" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}trimestral" id="montoReintegro${i}TrimestralInput" value="${monto2.toFixed(
                            2
                        )}">
                            `
                    );
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                } else {
                    monto = monto * cmensual;
                    $("#contPagos").append(
                        `
                            <input type="hidden" name="serie-pagops${i}" id="seriePagoPS${i}Input" value="${i}">
                            <input type="hidden" name="fecha-pagops${i}" id="fechaPago${i}Input" value="${fechaPago}">
                            <input type="hidden" name="fecha-limitepagops${i}" id="fechaLimite${i}Input" value="${fechaLimite}">
                            <input type="hidden" name="pago-pagops${i}" id="montoReintegro${i}Input" value="${monto.toFixed(
                            2
                        )}">
                            `
                    );
                }

                fecha = new Date(fechaPago);
            }
        }

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
                    url: "/admin/validateClaveConvenioTerminado",
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
                    url: "/admin/validateClaveConvenioTerminado",
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteConvenioTerminado",
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
});

$(".table").addClass("compact nowrap w-100");
