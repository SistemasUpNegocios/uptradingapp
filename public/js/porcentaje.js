$(document).ready(function () {
    let acc = "";
    let dataInversionUS = 0;
    let dataInversionMXN = 0;
    let dataFechaInicio = "";

    var table = $("#porcentaje").DataTable({
        ajax: "/admin/getContratosPorcentaje",
        columns: [
            {
                data: function (data) {
                    return data.contrato;
                },
            },
            {
                data: function (data) {
                    return `${data.capertura}%`;
                },
            },
            {
                data: function (data) {
                    return `${data.cmensual}%`;
                },
            },
            {
                data: function (data) {
                    return `${data.porcentaje}%`;
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
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#contratoForm").on("submit", function (e) {
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
            success: function (data) {
                $("#formModal").modal("hide");
                $("#contratoForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Porcentajes actualizados</h1>',
                        html: '<p style="font-family: Poppins">El contrato ha sido actualizado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".view", function (e) {
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "view";
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
        var clienteid = $(this).data("clienteid");
        var pendienteid = $(this).data("pendienteid");
        var tipoid = $(this).data("tipoid");
        var cmensual = $(this).data("cmensual");
        var capertura = $(this).data("capertura");
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

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#pendienteIdInput").val(pendienteid);
        $("#pendienteIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        $("#porcentajeInput").prop("disabled", true);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("disabled", true);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("disabled", true);

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

        $("#comprobantePagoInput").prop("disabled", true);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", true);
        $("#transferenciaSwissInput").prop("disabled", true);
        $("#transferenciaMXInput").prop("disabled", true);
        $("#ciBankInput").prop("disabled", true);
        $("#hsbcInput").prop("disabled", true);
        $("#renovacionInput").prop("disabled", true);
        $("#rendimientosInput").prop("disabled", true);
        tipoPago(this);

        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiarios",
            data: { id: id },
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
                                        Beneficiario(s) del contrato en caso de fallecimiento del cliente:
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

                        $(`#nombreBen${i}Input`).prop("disabled", true);
                        $(`#porcentajeBen${i}Input`).prop("disabled", true);
                        $(`#telefonoBen${i}Input`).prop("disabled", true);
                        $(`#correoBen${i}Input`).prop("disabled", true);
                        $(`#curpBen${i}Input`).prop("disabled", true);
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
                                name="nombre-ben1" minlength="3" maxlength="255" disabled>
                            <label for="nombreBen1Input">Nombre del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input readonly type="number" step="any" class="form-control"
                                placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                                name="porcentaje-ben1" value="0" disabled>
                            <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-2">
                            <input readonly type="number" class="form-control"
                                placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                                name="telefono-ben1" minlength="3" maxlength="100" disabled>
                            <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">                                
                            <input readonly type="text" class="form-control"
                                placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                                name="correo-ben1" minlength="3" maxlength="100" disabled>
                            <label for="correoBen1Input">Correo del beneficiario</label>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-floating mb-3">
                            <input readonly type="text" class="form-control"
                                placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                                name="curp-ben1" minlength="3" maxlength="100" disabled>
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
        $("#contratoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "edit";
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
        var clienteid = $(this).data("clienteid");
        var pendienteid = $(this).data("pendienteid");
        var tipoid = $(this).data("tipoid");
        var cmensual = $(this).data("cmensual");
        var capertura = $(this).data("capertura");
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

        dataInversionUS = $(this).data("inversionus");
        dataInversionMXN = $(this).data("inversion");
        dataFechaInicio = $(this).data("fecha");

        $("#contratoForm").attr("action", "/admin/editPorcentajes");

        $("#idInput").val(id);

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

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", true);

        $("#clienteIdInput").val(clienteid);
        $("#clienteIdInput").prop("disabled", true);

        $("#pendienteIdInput").val(pendienteid);
        $("#pendienteIdInput").prop("disabled", true);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", true);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        // $("#porcentajeInput").prop("readonly", false);

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

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        $("#porcentajeInput").prop("disabled", false);

        capertura = capertura.toString().replace(",", ".");
        $("#cAperturaInput").val(capertura);
        $("#cAperturaInput").prop("disabled", false);

        cmensual = cmensual.toString().replace(",", ".");
        $("#cMensualInput").val(cmensual);
        $("#cMensualInput").prop("disabled", false);

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", true);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", true);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", true);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", true);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", true);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", true);

        $("#beneficiariosInput").prop("disabled", true);

        $("#comprobantePagoInput").prop("disabled", true);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", true);
        $("#transferenciaSwissInput").prop("disabled", true);
        $("#transferenciaMXInput").prop("disabled", true);
        $("#ciBankInput").prop("disabled", true);
        $("#hsbcInput").prop("disabled", true);
        $("#renovacionInput").prop("disabled", true);
        $("#rendimientosInput").prop("disabled", true);

        tipoPago(this);

        $.ajax({
            type: "GET",
            url: "/admin/getBeneficiarios",
            data: { id: id },
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
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa el nombre del ${adjetivo} beneficiario" id="nombreBen${i}Input"
                                        name="nombre-ben${i}" minlength="3" maxlength="255" readonly>
                                    <label for="nombreBen${i}Input">Nombre del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" step="any" class="form-control"
                                        placeholder="Ingresa el porcentaje del ${adjetivo} beneficiario" id="porcentajeBen${i}Input"
                                        name="porcentaje-ben${i}" value="0" readonly>
                                    <label for="porcentajeBen${i}Input">Porcentaje del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control"
                                        placeholder="Ingresa el telefono del ${adjetivo} beneficiario" id="telefonoBen${i}Input"
                                        name="telefono-ben${i}" minlength="3" maxlength="100" readonly>
                                    <label for="telefonoBen${i}Input">Teléfono del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input style="text-transform: lowercase;" type="email" class="form-control"
                                        placeholder="Ingresa el correo del ${adjetivo} beneficiario" id="correoBen${i}Input"
                                        name="correo-ben${i}" minlength="3" maxlength="100" readonly>
                                    <label for="correoBen${i}Input">Correo del ${adjetivo} beneficiario</label>
                                </div>
                            </div>                            
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control"
                                        placeholder="Ingresa la curp del ${adjetivo} beneficiario" id="curpBen${i}Input"
                                        name="curp-ben${i}" minlength="3" maxlength="100" readonly>
                                    <label for="curpBen${i}Input">CURP del ${adjetivo} beneficiario</label>
                                </div>
                            </div>
                        `);

                        $(`#nombreBen${i}Input`).prop("disabled", true);
                        $(`#porcentajeBen${i}Input`).prop("disabled", true);
                        $(`#telefonoBen${i}Input`).prop("disabled", true);
                        $(`#correoBen${i}Input`).prop("disabled", true);
                        $(`#curpBen${i}Input`).prop("disabled", true);
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
                                <input type="text" class="form-control"
                                    placeholder="Ingresa el nombre del beneficiario" id="nombreBen1Input"
                                    name="nombre-ben1" minlength="3" maxlength="255" disabled>
                                <label for="nombreBen1Input">Nombre del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" step="any" class="form-control"
                                    placeholder="Ingresa el porcentaje del beneficiario" id="porcentajeBen1Input"
                                    name="porcentaje-ben1" value="0" disabled>
                                <label for="porcentajeBen1Input">Porcentaje del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control"
                                    placeholder="Ingresa el telefono del beneficiario" id="telefonoBen1Input"
                                    name="telefono-ben1" minlength="3" maxlength="100" disabled>
                                <label for="telefonoBen1Input">Teléfono del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">                                
                                <input type="text" class="form-control"
                                    placeholder="Ingresa el correo del beneficiario" id="correoBen1Input"
                                    name="correo-ben1" minlength="3" maxlength="100" disabled>
                                <label for="correoBen1Input">Correo del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                    placeholder="Ingresa la curp del beneficiario" id="curpBen1Input"
                                    name="curp-ben1" minlength="3" maxlength="100" disabled>
                                <label for="curpBen1Input">CURP del beneficiario</label>
                            </div>
                        </div>
                `);
                }
            },
        });

        $(".status_reintegro").show();
        $(".memo_reintegro").show();

        $("#modalTitle").text(`Editar contrato de: ${nombrecliente}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar contrato");
        $("#btnCancel").text("Cancelar");

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

            if (tipo_contrato == "Rendimiento compuesto") {
                // rendimiento = inversionUSD * porcentaje2 + rendimiento;

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

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el contrato</p>',
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

    var meses = $("#periodoInput").val();
    $("#formModal").on("keyup change", function (event) {
        $("#periodoInput").val(meses);
        $("#tablaBody").empty();

        var target = $(event.target);

        if (target.is("#tipoIdInput")) {
            var select = $("#tipoIdInput");

            var capertura = $("option:selected", select).attr("data-capertura");
            var cmensual = $("option:selected", select).attr("data-cmensual");
            var rendimiento = $("option:selected", select).attr(
                "data-rendimiento"
            );

            $("#porcentajeInput").val(rendimiento);
        }

        if (target.is("#inversionInput")) {
            if ($("#tipoCambioInput").val()) {
                var peso = $("#inversionInput").val();
                var dolar_peso = $("#tipoCambioInput").val();
                var dolares = peso / dolar_peso;
                $("#inversionUsInput").val(dolares.toFixed(2));
            }
            //Condicional para refrendo
            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionMXN != $("#inversionInput").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionUsInput").val())
            );
        } else if (target.is("#inversionUsInput")) {
            if ($("#tipoCambioInput").val()) {
                var dolar = $("#inversionUsInput").val();
                var dolar_peso = $("#tipoCambioInput").val();
                var peso = 1 / dolar_peso;
                var pesos = dolar / peso;
                $("#inversionInput").val(pesos.toFixed(2));
            }

            if (acc == "edit") {
                if (
                    $("#statusInput").val() == "Refrendado" &&
                    dataInversionUS != $("#inversionUsInput").val()
                ) {
                    $("#contratoForm").attr("action", "/admin/addContrato");
                }
            }

            $("#inversionLetInput").val(
                numeroALetrasMXN($("#inversionInput").val())
            );
            $("#inversionLetUsInput").val(
                numeroALetrasUSD($("#inversionUsInput").val())
            );
        }

        if ($("#fechaInicioInput").val()) {
            var fechaInicio = $("#fechaInicioInput").val();
            fechaInicio = new Date(fechaInicio);
            fechaInicio = fechaInicio.addDays(1);

            var fechaReintegro = new Date(
                fechaInicio.setMonth(fechaInicio.getMonth() + parseInt(meses))
            );

            var fechaPago = fechaReintegro.outDays(1);
            fechaPago = formatDate(new Date(fechaPago));
            fechaPago = fechaPago.split("/").reverse().join("-");
            $("#fechaPagInput").val(fechaPago);

            var fechaLimite = fechaReintegro.addDays(14);
            fechaLimite = formatDate(new Date(fechaLimite));
            fechaLimite = fechaLimite.split("/").reverse().join("-");
            $("#fechaLimiteInput").val(fechaLimite);

            var fechaRenovacion = fechaReintegro;
            fechaRenovacion = formatDate(new Date(fechaRenovacion));
            fechaRenovacion = fechaRenovacion.split("/").reverse().join("-");
            $("#fechaRenInput").val(fechaRenovacion);

            fechaReintegro = formatDate(new Date(fechaReintegro));
            fechaReintegro = fechaReintegro.split("/").reverse().join("-");
            $("#fechaReinInput").val(fechaReintegro);
        }

        if (
            $("#inversionInput").val() &&
            $("#inversionUsInput").val() &&
            $("#tipoCambioInput").val() &&
            $("#fechaInicioInput").val() &&
            $("#fechaRenInput").val() &&
            $("#fechaPagInput").val() &&
            $("#fechaLimiteInput").val() &&
            $("#tipoIdInput").val() &&
            $("#porcentajeInput").val()
        ) {
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
            var fechaFeb = $("#fechaInicioInput").val();
            fechaFeb = fechaFeb.split("-");

            var porcentaje = $("#porcentajeInput").val();
            // var usd = parseFloat($("#tipoCambioInput").val());

            var cmensual2 = `0.0${cmensual}`;
            cmensual2 = parseFloat(cmensual2);

            var fechaFeb = $("#fechaInicioInput").val();
            fechaFeb = fechaFeb.split("-");
            // var rendimiento = 0;
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
                    }" id="montoReintegro${i + 1}Input" value="${monto.toFixed(
                        2
                    )}">
                    <input type="hidden" name="redito-reintegro${
                        i + 1
                    }" id="reditoReintegro${
                        i + 1
                    }Input" value="${redito.toFixed(2)}">
                    <input type="hidden" name="montoredito-reintegro${
                        i + 1
                    }" id="montoReditoReintegro${
                        i + 1
                    }Input" value="${monto_redito.toFixed(2)}">

                    <input type="hidden" name="monto-pagops${
                        i + 1
                    }" id="montoPagoPs${i + 1}Input" value="${pagoPS.toFixed(
                        2
                    )}">
                    `
                );

                if (tipo_contrato == "Rendimiento compuesto") {
                    // rendimiento = inversionUSD * porcentaje2 + rendimiento;

                    $("#tablaBody").append(` 
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${fecha}</td>
                        <td>${formatterUSD.format(inversionUSD)}</td>
                        <td>${formatterUSD.format(
                            inversionUSD * porcentaje2
                        )}</td>
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
                        <td>${formatterUSD.format(
                            inversionUSD * porcentaje2
                        )}</td>
                    </tr>
                    `);
                }

                fecha = fecha.split("/").reverse().join("-");
            }
        }

        //condicional de refrendo con nuevas fechas
        if (target.is("#statusInput") && event.type == "change") {
            if ($("#statusInput").val() == "Refrendado") {
                if (acc == "new") {
                    dataInversionMXN = $("#inversionInput").val();
                    dataInversionMXN = parseFloat(dataInversionMXN);

                    dataInversionUS = $("#inversionUsInput").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contMemoCan").addClass("d-none");

                $("#contPagos").empty();
                $(".cont-tabla").empty();

                var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                    "data-tipo"
                );

                if (tipo_contrato == "Rendimiento compuesto") {
                    $(".cont-tabla").append(
                        `
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
                        `
                    );
                } else if (tipo_contrato == "Rendimiento mensual") {
                    $(".cont-tabla").append(
                        `
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
                        `
                    );
                }

                var cmensual = $("option:selected", "#tipoIdInput").attr(
                    "data-cmensual"
                );

                cmensual = parseFloat(cmensual);
                var cmensual2 = `0.0${cmensual}`;
                cmensual2 = parseFloat(cmensual2);

                var inversionMXN = $("#inversionInput").val();
                inversionMXN = parseFloat(inversionMXN);

                var inversionUSD = $("#inversionUsInput").val();
                inversionUSD = parseFloat(inversionUSD);
                // var inversionInicialUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput").val();
                porcentaje = parseFloat(porcentaje);

                $("#fechaInicioInput").val($("#fechaRenInput").val());

                var fecha = $("#fechaRenInput").val();

                var fechaInicio = $("#fechaRenInput").val();
                fechaInicio = new Date(fechaInicio);
                fechaInicio = fechaInicio.addDays(1);

                var fechaReintegro = new Date(
                    fechaInicio.setMonth(
                        fechaInicio.getMonth() + parseInt(meses)
                    )
                );

                var fechaPago = fechaReintegro.outDays(1);
                fechaPago = formatDate(new Date(fechaPago));
                fechaPago = fechaPago.split("/").reverse().join("-");
                $("#fechaPagInput").val(fechaPago);

                var fechaLimite = fechaReintegro.addDays(14);
                fechaLimite = formatDate(new Date(fechaLimite));
                fechaLimite = fechaLimite.split("/").reverse().join("-");
                $("#fechaLimiteInput").val(fechaLimite);

                var fechaRenovacion = fechaReintegro;
                fechaRenovacion = formatDate(new Date(fechaRenovacion));
                fechaRenovacion = fechaRenovacion
                    .split("/")
                    .reverse()
                    .join("-");
                $("#fechaRenInput").val(fechaRenovacion);

                fechaReintegro = formatDate(new Date(fechaReintegro));
                fechaReintegro = fechaReintegro.split("/").reverse().join("-");
                $("#fechaReinInput").val(fechaReintegro);

                var formatterUSD = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                });

                var formatterMXN = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN",
                });

                if (tipo_contrato == "Rendimiento compuesto") {
                    for (var i = 0; i < meses; i++) {
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;

                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                    }
                }

                $("#inversionUsInput").val(inversionUSD.toFixed(2));
                $("#inversionInput").val(inversionMXN.toFixed(2));

                $("#inversionLetInput").val(
                    numeroALetrasMXN($("#inversionInput").val())
                );
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD($("#inversionUsInput").val())
                );

                // var rendimiento = 0;
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
                        }" id="fechaReintegro${
                            i + 1
                        }Input" value="${fechaInput}">
                        <input type="hidden" name="monto-reintegro${
                            i + 1
                        }" id="montoReintegro${
                            i + 1
                        }Input" value="${monto.toFixed(2)}">
                        <input type="hidden" name="redito-reintegro${
                            i + 1
                        }" id="reditoReintegro${
                            i + 1
                        }Input" value="${redito.toFixed(2)}">
                        <input type="hidden" name="montoredito-reintegro${
                            i + 1
                        }" id="montoReditoReintegro${
                            i + 1
                        }Input" value="${monto_redito.toFixed(2)}">

            <input type="hidden" name="monto-pagops${i + 1}" id="montoPagoPs${
                            i + 1
                        }Input" value="${pagoPS.toFixed(2)}">
            `
                    );

                    if (tipo_contrato == "Rendimiento compuesto") {
                        $("#tablaBody").append(
                            ` 
                                <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${fecha}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD * porcentaje2
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD +
                                            inversionUSD * porcentaje2
                                    )}</td>
                                </tr>
                            `
                        );
                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;
                    } else if (tipo_contrato == "Rendimiento mensual") {
                        $("#tablaBody").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${fecha}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${formatterUSD.format(
                                inversionUSD * porcentaje2
                            )}</td>
                        </tr>
                        `);
                    }

                    fecha = fecha.split("/").reverse().join("-");
                }
            } else if ($("#statusInput").val() == "Activado") {
                if (acc == "new") {
                    dataInversionMXN = $("#inversionInput").val();
                    dataInversionMXN = parseFloat(dataInversionMXN);

                    dataInversionUS = $("#inversionUsInput").val();
                    dataInversionUS = parseFloat(dataInversionUS);

                    dataFechaInicio = $("#fechaInicioInput").val();
                }

                $("#contMemoCan").addClass("d-none");
                $("#contPagos").empty();
                $(".cont-tabla").empty();

                var tipo_contrato = $("option:selected", "#tipoIdInput").attr(
                    "data-tipo"
                );

                if (tipo_contrato == "Rendimiento compuesto") {
                    $(".cont-tabla").append(
                        `
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
                        `
                    );
                } else if (tipo_contrato == "Rendimiento mensual") {
                    $(".cont-tabla").append(
                        `
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
                        `
                    );
                }

                var cmensual = $("option:selected", "#tipoIdInput").attr(
                    "data-cmensual"
                );

                cmensual = parseFloat(cmensual);
                var cmensual2 = `0.0${cmensual}`;
                cmensual2 = parseFloat(cmensual2);

                var inversionMXN = dataInversionMXN;
                inversionMXN = parseFloat(inversionMXN);

                var inversionUSD = dataInversionUS;
                inversionUSD = parseFloat(inversionUSD);

                var porcentaje = $("#porcentajeInput").val();
                porcentaje = parseFloat(porcentaje);

                dataFechaInicio = dataFechaInicio
                    .split("/")
                    .reverse()
                    .join("-");

                $("#fechaInicioInput").val(dataFechaInicio);

                var fecha = $("#fechaInicioInput").val();

                var fechaInicio = $("#fechaInicioInput").val();
                fechaInicio = new Date(fechaInicio);
                fechaInicio = fechaInicio.addDays(1);

                var fechaReintegro = new Date(
                    fechaInicio.setMonth(
                        fechaInicio.getMonth() + parseInt(meses)
                    )
                );

                var fechaPago = fechaReintegro.outDays(1);
                fechaPago = formatDate(new Date(fechaPago));
                fechaPago = fechaPago.split("/").reverse().join("-");
                $("#fechaPagInput").val(fechaPago);

                var fechaLimite = fechaReintegro.addDays(14);
                fechaLimite = formatDate(new Date(fechaLimite));
                fechaLimite = fechaLimite.split("/").reverse().join("-");
                $("#fechaLimiteInput").val(fechaLimite);

                var fechaRenovacion = fechaReintegro;
                fechaRenovacion = formatDate(new Date(fechaRenovacion));
                fechaRenovacion = fechaRenovacion
                    .split("/")
                    .reverse()
                    .join("-");
                $("#fechaRenInput").val(fechaRenovacion);

                fechaReintegro = formatDate(new Date(fechaReintegro));
                fechaReintegro = fechaReintegro.split("/").reverse().join("-");
                $("#fechaReinInput").val(fechaReintegro);

                var formatterUSD = new Intl.NumberFormat("en-US", {
                    style: "currency",
                    currency: "USD",
                });

                var formatterMXN = new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN",
                });

                $("#inversionUsInput").val(inversionUSD.toFixed(2));
                $("#inversionInput").val(inversionMXN.toFixed(2));

                $("#inversionLetInput").val(
                    numeroALetrasMXN($("#inversionInput").val())
                );
                $("#inversionLetUsInput").val(
                    numeroALetrasUSD($("#inversionUsInput").val())
                );

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
                        }" id="fechaReintegro${
                            i + 1
                        }Input" value="${fechaInput}">
                        <input type="hidden" name="monto-reintegro${
                            i + 1
                        }" id="montoReintegro${
                            i + 1
                        }Input" value="${monto.toFixed(2)}">
                        <input type="hidden" name="redito-reintegro${
                            i + 1
                        }" id="reditoReintegro${
                            i + 1
                        }Input" value="${redito.toFixed(2)}">
                        <input type="hidden" name="montoredito-reintegro${
                            i + 1
                        }" id="montoReditoReintegro${
                            i + 1
                        }Input" value="${monto_redito.toFixed(2)}">

            <input type="hidden" name="monto-pagops${i + 1}" id="montoPagoPs${
                            i + 1
                        }Input" value="${pagoPS.toFixed(2)}">
            `
                    );

                    if (tipo_contrato == "Rendimiento compuesto") {
                        $("#tablaBody").append(
                            ` 
                                <tr>
                                    <th scope="row">${i + 1}</th>
                                    <td>${fecha}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD * porcentaje2
                                    )}</td>
                                    <td>${formatterUSD.format(
                                        inversionUSD +
                                            inversionUSD * porcentaje2
                                    )}</td>
                                </tr>
                            `
                        );
                        inversionMXN =
                            inversionMXN + inversionMXN * porcentaje2;
                        inversionUSD =
                            inversionUSD + inversionUSD * porcentaje2;
                    } else if (tipo_contrato == "Rendimiento mensual") {
                        $("#tablaBody").append(` 
                        <tr>
                            <th scope="row">${i + 1}</th>
                            <td>${fecha}</td>
                            <td>${formatterUSD.format(inversionUSD)}</td>
                            <td>${formatterUSD.format(
                                inversionUSD * porcentaje2
                            )}</td>
                        </tr>
                        `);
                    }

                    fecha = fecha.split("/").reverse().join("-");
                }
            } else if ($("#statusInput").val() == "Cancelado") {
                $("#contMemoCan").removeClass("d-none");
            } else {
                $("#contMemoCan").addClass("d-none");
            }
        }

        //APARTADO DE BENEFICIARIOS
        if (target.is("#beneficiariosInput")) {
            $("#contBeneficiarios").empty();

            var beneficiarios = $("#beneficiariosInput").val();

            if (beneficiarios != "") {
                for (var i = 1; i <= beneficiarios; i++) {
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
                }

                if (beneficiarios == 1) {
                    $("#nombreBen1Input").keyup(function () {
                        $("#porcentajeBen1Input").val(100);
                    });
                }

                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen1Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );

                    if (porcentajeben1 > 100 || porcentajeben1 < 0) {
                        $("#porcentajeBen1Input").val(50);
                        $("#porcentajeBen2Input").val(50);
                        $("#porcentajeBen3Input").val(0);
                    } else {
                        if (beneficiarios == 2) {
                            var porcentajeRestante = 100 - porcentajeben1;
                            $("#porcentajeBen2Input").val(porcentajeRestante);
                        } else if (beneficiarios == 3) {
                            var porcentajeRestante = (100 - porcentajeben1) / 2;
                            $("#porcentajeBen2Input").val(porcentajeRestante);
                            $("#porcentajeBen3Input").val(porcentajeRestante);
                        }
                    }
                });
                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen2Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );
                    var porcentajeben2 = parseInt(
                        $("#porcentajeBen2Input").val()
                    );

                    if (porcentajeben2 > 100 || porcentajeben2 < 0) {
                        $("#porcentajeBen1Input").val(50);
                        $("#porcentajeBen2Input").val(50);
                        $("#porcentajeBen3Input").val(0);
                    } else {
                        if (beneficiarios == 2) {
                            var porcentajeRestante = 100 - porcentajeben2;
                            $("#porcentajeBen1Input").val(porcentajeRestante);
                        } else if (beneficiarios == 3) {
                            var porcentajeRestante =
                                100 - (porcentajeben1 + porcentajeben2);
                            var sumaPorcentajes =
                                porcentajeben1 + porcentajeben2;
                            if (sumaPorcentajes > 100) {
                                var porcentajeRestante =
                                    (100 - porcentajeben1) / 2;
                                $("#porcentajeBen2Input").val(
                                    porcentajeRestante
                                );
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante
                                );
                            } else {
                                $("#porcentajeBen3Input").val(
                                    porcentajeRestante
                                );
                            }
                        }
                    }
                });
                // Evento on change del porcentaje para ajustar automaticamente el porcentaje del beneficiario
                $("#porcentajeBen3Input").change(function () {
                    var porcentajeben1 = parseInt(
                        $("#porcentajeBen1Input").val()
                    );
                    var porcentajeben2 = parseInt(
                        $("#porcentajeBen2Input").val()
                    );
                    var porcentajeben3 = parseInt(
                        $("#porcentajeBen3Input").val()
                    );

                    if (porcentajeben3 > 100 || porcentajeben3 < 0) {
                        $("#porcentajeBen1Input").val(33);
                        $("#porcentajeBen2Input").val(33);
                        $("#porcentajeBen3Input").val(33);
                    } else {
                        var sumaPorcentajes =
                            porcentajeben1 + porcentajeben2 + porcentajeben3;

                        if (sumaPorcentajes > 100.0) {
                            var porcentajeRestante =
                                100 - (porcentajeben1 + porcentajeben2);
                            $("#porcentajeBen3Input").val(porcentajeRestante);
                        } else {
                            var porcentajeRestante = (100 - porcentajeben3) / 2;
                            $("#porcentajeBen1Input").val(porcentajeRestante);
                            $("#porcentajeBen2Input").val(porcentajeRestante);
                        }
                    }
                });
            }
        }

        var beneficiarios = $("#beneficiariosInput").val();
        if (beneficiarios == 1) {
            let nombreBeneficiario = $("#nombreBen1Input").val();
            if (
                target.is("#nombreBen1Input") ||
                nombreBeneficiario.length > 0
            ) {
                $("#porcentajeBen1Input").val(100);
            }
        }

        //Evento change en el cambio de cliente para mostrar los pendientes que coincidan con el nombre del cliente
        if (target.is("#clienteIdInput")) {
            var id = $("option:selected", "#clienteIdInput").val();
            $.ajax({
                type: "GET",
                url: "/admin/showListaPendientes",
                data: { id: id },
                success: function (response) {
                    $("#pendienteIdInput").empty();
                    $("#pendienteIdInput").append(`
                        <option value="" disabled selected>Selecciona...</option>
                    `);

                    response.map(function (pendiente) {
                        $("#pendienteIdInput").append(`
                            <option value="${pendiente.id}">${pendiente.nombre}</option>
                        `);
                    });

                    $("#pendienteIdInput").change(function () {
                        var psid = $("#pendienteIdInput").val();
                        $.ajax({
                            type: "GET",
                            url: "/admin/showPendiente",
                            data: { id: psid },
                            success: function (response) {
                                $("#psIdInput").empty();
                                $("#psIdInput").append(`
                                    <option value="" disabled>Selecciona...</option>
                                `);

                                response.map(function (ps) {
                                    $("#psIdInput").append(`
                                        <option value="${ps.psid}" selected>${ps.psnombre}</option>
                                    `);
                                });
                            },
                        });
                    });

                    // $("#psIdInput").append(`
                    //         <option value="${pendiente.psid}" selected>${pendiente.psnombre}</option>
                    //     `);
                },
            });

            $.get({
                url: "/admin/showNumeroCliente",
                data: { id: id },
                success: function (response) {
                    $("#contratoInput").val(response);
                },
            });
        }

        $("#comprobantePagoInput").change(function () {
            let datatarget = $(`.${acc}`).data("comprobantepago");

            if ($("#comprobantePagoInput")[0].files[0]?.name) {
                $("#comprobantePagoInput").removeClass("is-invalid");
                $("#comprobantePagoInput").addClass("is-valid");
            } else {
                if (datatarget < 1) {
                    $("#comprobantePagoInput").removeClass("is-valid");
                    $("#comprobantePagoInput").addClass("is-invalid");
                }
            }
        });

        if (target.is("#efectivoInput")) {
            let efectivoChecked = $("#efectivoInput").is(":checked");

            if (efectivoChecked) {
                $("#montoEfectivoCont").show();
            } else {
                $("#montoEfectivoCont").hide();
            }
        }

        if (target.is("#transferenciaSwissInput")) {
            let transferenciaSwissChecked = $("#transferenciaSwissInput").is(
                ":checked"
            );

            if (transferenciaSwissChecked) {
                $("#montoTransSwissPOOLCont").show();
            } else {
                $("#montoTransSwissPOOLCont").hide();
            }
        }

        if (target.is("#transferenciaMXInput")) {
            let transferenciaMXChecked = $("#transferenciaMXInput").is(
                ":checked"
            );

            if (transferenciaMXChecked) {
                $("#montoTransMXPOOLCont").show();
            } else {
                $("#montoTransMXPOOLCont").hide();
            }
        }

        if (target.is("#ciBankInput")) {
            let ciBankChecked = $("#ciBankInput").is(":checked");

            if (ciBankChecked) {
                $("#montoBankCont").show();
            } else {
                $("#montoBankCont").hide();
            }
        }

        if (target.is("#hsbcInput")) {
            let hsbcChecked = $("#hsbcInput").is(":checked");

            if (hsbcChecked) {
                $("#montoHSBCCont").show();
            } else {
                $("#montoHSBCCont").hide();
            }
        }

        if (target.is("#renovacionInput")) {
            let renovacionChecked = $("#renovacionInput").is(":checked");

            if (renovacionChecked) {
                $("#montoRenovacionCont").show();
            } else {
                $("#montoRenovacionCont").hide();
            }
        }

        if (target.is("#rendimientosInput")) {
            let rendimientoChecked = $("#rendimientosInput").is(":checked");

            if (rendimientoChecked) {
                $("#montoRendimientosCont").show();
            } else {
                $("#montoRendimientosCont").hide();
            }
        }
    });

    function estatusClaveIncorrecta(input) {
        let estatus = $(input).data("status");
        if (estatus == "Activado") {
            $(input).prop("checked", true);
            $(input).val("Activado");
        } else {
            $(input).prop("checked", false);
            $(input).val("Pendiente de activación");
        }
    }

    const comprobantePago = (thiss) => {
        var comprobantepago = $(thiss).data("comprobantepago");
        if (comprobantepago.length > 0) {
            $("#comprobantePagoInput").addClass("is-valid");
            $("#comprobantePagoInput").removeClass("is-invalid");

            $("#comprobantePagoDesc").attr("download", `${comprobantepago}`);
            $("#comprobantePagoDesc").attr(
                "href",
                `../documentos/contratos/${comprobantepago}`
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
        ];
        let tipopago = $(thiss).data("tipopago");

        tipopago = tipopago.split(", ");
        tipopago.map((tipo) => {
            checkbox.map((input) => {
                if (tipo == $(input).val()) {
                    $(input).prop("checked", true);
                }
            });
        });
    };
});

$(".table").addClass("compact nowrap w-100");
