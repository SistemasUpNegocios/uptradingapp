$(document).ready(function () {
    const formatearFecha = (fecha) => {
        return fecha.split(" ")[0].split("-").reverse().join("/");
    };

    Swal.fire({
        icon: "warning",
        title: '<h1 style="font-family: Poppins; font-weight: 700;">¡ADVERTENCIA!</h1>',
        html: '<p style="font-family: Poppins">SI EL CONTRATO SE VA A <b>RENOVAR</b>, NO AÑADAS UNA NOTA. EL SISTEMA LO RENOVARÁ AUTOMÁTICAMENTE.</p>',
        confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
        confirmButtonColor: "#01bbcc",
    });

    var table = $("#contratoVencer").DataTable({
        ajax: "/admin/showContratoVencer",
        columns: [
            { data: "contrato" },
            { data: "clientenombre" },
            {
                data: "fecha_renovacion",
                render: function (data) {
                    return formatearFecha(data);
                },
            },
            {
                data: "fecha_limite",
                render: function (data) {
                    return formatearFecha(data);
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

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).on("click", ".view", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
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
        var pendienteid = $(this).data("pendienteid");
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

        $("#pendienteIdInput").val(pendienteid);
        $("#pendienteIdInput").prop("disabled", true);

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

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", true);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", true);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#beneficiariosInput").prop("disabled", true);

        containerHide();

        $("#comprobantePagoInput").prop("disabled", true);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", true);
        $("#transferenciaSwissInput").prop("disabled", true);
        $("#transferenciaMXInput").prop("disabled", true);
        $("#ciBankInput").prop("disabled", true);
        $("#hsbcInput").prop("disabled", true);
        $("#renovacionInput").prop("disabled", true);
        $("#rendimientosInput").prop("disabled", true);
        $("#comisionesInput").prop("disabled", true);
        tipoPago(this);

        $("#montoEfectivoInput").prop("disabled", true);
        $("#montoTransSwissPOOLInput").prop("disabled", true);
        $("#montoTransMXPOOLInput").prop("disabled", true);
        $("#montoBankInput").prop("disabled", true);
        $("#montoHSBCInput").prop("disabled", true);
        $("#montoRenovacionInput").prop("disabled", true);
        $("#montoRendimientosInput").prop("disabled", true);
        $("#montoComisionesInput").prop("disabled", true);

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

        if (tipo_contrato == "Rendimiento compuesto") {
            $(".cont-tabla").append(`
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Serie</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Capital (USD)</th>
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
                                <th scope="col">Capital (USD)</th>
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

        var inversionUSD = $("#inversionUsInput").val();
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

    $(document).on("click", ".edit", function (e) {
        $("#contratoFormNota")[0].reset();
        $("#alertMessage").text("");
        e.preventDefault();

        var id = $(this).data("id");
        var contrato = $(this).data("contrato");
        var nota = $(this).data("notacontrato");
        var cliente = $(this).data("cliente");

        $("#idInputNota").val(id);
        $("#notaInput").val(nota);

        $("#modalTitleNota").text(
            `Agregar nota para el contrato: ${contrato} de ${cliente}`
        );
        $("#formModalNota").modal("show");

        $("#btnCancelNota").text("Cerrar vista previa");
        $("#btnSubmitNota").text("Agregar nota");
    });

    $(document).on("change", ".autorizado", function () {
        var checked = $(this).is(":checked");
        var thiss = $(this);

        if (checked) {
            $(this).val("SI");
        } else {
            $(this).val("NO");
        }

        var id = $(this).data("id");
        var autorizacion = $(this).val();

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

        $.ajax({
            type: "GET",
            url: "/admin/contrato/autorizarnota",
            data: {
                id: id,
                autorizacion: autorizacion,
            },
            success: function () {
                if (autorizacion == "SI") {
                    Toast.fire({
                        icon: "success",
                        title: "Autorización emitida",
                    });
                    $(thiss).prop("checked", true);
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "Autorización revocada",
                    });
                    $(thiss).prop("checked", false);
                }
            },
            error: function () {
                Toast.fire({
                    icon: "error",
                    title: "Error al emitir autorización",
                });
                $(thiss).prop("checked", false);
            },
        });
    });

    $("#contratoFormNota").on("submit", function (e) {
        e.preventDefault();
        $("#alertMessage").text("");
        $.ajax({
            type: "POST",
            url: "/admin/contrato/editnota",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                $("#formModalNota").modal("hide");
                $("#contratoFormNota")[0].reset();
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

    const comprobantePago = (thiss) => {
        var comprobantepago = $(thiss).data("comprobantepago");
        var contrato = $(thiss).data("contrato");

        if (comprobantepago.length > 0) {
            $("#comprobantePagoInput").addClass("is-valid");
            $("#comprobantePagoInput").removeClass("is-invalid");

            $("#comprobantePagoDesc").attr("download", `${contrato}.zip`);
            $("#comprobantePagoDesc").attr(
                "href",
                `../documentos/comprobantes_pagos/contratos/${contrato}/${contrato}.zip`
            );

            $("#comprobantePagoDesc").removeClass("d-none");
        } else {
            $("#comprobantePagoInput").addClass("is-invalid");
            $("#comprobantePagoInput").removeClass("is-valid");

            $("#comprobantePagoDesc").addClass("d-none");
        }
    };

    const tipoPago = (thiss) => {
        let checkbox = [
            "#efectivoInput",
            "#transferenciaSwissInput",
            "#transferenciaMXInput",
            "#ciBankInput",
            "#hsbcInput",
            "#renovacionInput",
            "#rendimientosInput",
            "#comisionesInput",
        ];

        let inputs = [
            "#montoEfectivoInput",
            "#montoTransSwissPOOLInput",
            "#montoTransMXPOOLInput",
            "#montoBankInput",
            "#montoHSBCInput",
            "#montoRenovacionInput",
            "#montoRendimientosInput",
            "#montoComisionesInput",
        ];

        let conts = [
            "#montoEfectivoCont",
            "#montoTransSwissPOOLCont",
            "#montoTransMXPOOLCont",
            "#montoBankCont",
            "#montoHSBCCont",
            "#montoRenovacionCont",
            "#montoComisionesCont",
        ];

        let montopago = $(thiss).data("montopago");
        let tipopago = $(thiss).data("tipopago");

        if (typeof montopago !== "undefined") {
            montopago = montopago.split(",");

            tipopago = tipopago.split(",");
            let j = 0;
            tipopago.map((tipo) => {
                let i = 0;
                checkbox.map((input) => {
                    if (tipo == $(input).val()) {
                        $(input).prop("checked", true);
                        let checked = $(input).is(":checked");
                        if (checked) {
                            $(conts[i]).show();
                            $(inputs[i]).val(montopago[j]);
                        }
                        j++;
                    }
                    i++;
                });
            });
        }
    };

    const containerHide = () => {
        $("#montoEfectivoCont").hide();
        $("#montoTransSwissPOOLCont").hide();
        $("#montoTransMXPOOLCont").hide();
        $("#montoBankCont").hide();
        $("#montoHSBCCont").hide();
        $("#montoRenovacionCont").hide();
        $("#montoRendimientosCont").hide();
        $("#montoComisionesCont").hide();
    };
});

$(".table").addClass("compact nowrap w-100");
