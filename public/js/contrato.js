function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(".image-upload-wrapScanner1").hide();

            $(".file-upload-imageScanner1").attr("src", e.target.result);
            $(".file-upload-contentScanner1").show();

            $(".image-titleScanner1").html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload();
    }
}

function removeUpload() {
    $(".file-upload-inputScanner1").replaceWith(
        $(".file-upload-inputScanner1").clone()
    );
    $(".file-upload-contentScanner1").hide();
    $(".image-upload-wrapScanner1").show();
}

$(".image-upload-wrapScanner1").bind("dragover", function () {
    $(".image-upload-wrapScanner1").addClass("image-droppingScanner1");
});
$(".image-upload-wrapScanner1").bind("dragleave", function () {
    $(".image-upload-wrapScanner1").removeClass("image-droppingScanner1");
});

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(".image-upload-wrapScanner2").hide();

            $(".file-upload-imageScanner2").attr("src", e.target.result);
            $(".file-upload-contentScanner2").show();

            $(".image-titleScanner2").html(input.files[0].name);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        removeUpload2();
    }
}

function removeUpload2() {
    $(".file-upload-inputScanner2").replaceWith(
        $(".file-upload-inputScanner2").clone()
    );
    $(".file-upload-contentScanner2").hide();
    $(".image-upload-wrapScanner2").show();
}

$(".image-upload-wrapScanner2").bind("dragover", function () {
    $(".image-upload-wrapScanner2").addClass("image-droppingScanner2");
});
$(".image-upload-wrapScanner2").bind("dragleave", function () {
    $(".image-upload-wrapScanner2").removeClass("image-droppingScanner2");
});

$(document).ready(function () {
    const config = {
        search: true,
    };

    dselect(document.querySelector("#clienteIdInput"), config);
    dselect(document.querySelector("#psIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    $("#clienteIdInput")
        .next()
        .children()
        .next()
        .children()
        .children()
        .next()
        .addClass("d-none");

    $(".dropdown-menu .form-control").on("keyup", function () {
        let input = $(".dropdown-menu .form-control").val();

        if (input.length > 0) {
            $("#clienteIdInput")
                .next()
                .children()
                .next()
                .children()
                .children()
                .next()
                .removeClass("d-none");
        } else {
            $("#clienteIdInput")
                .next()
                .children()
                .next()
                .children()
                .children()
                .next()
                .addClass("d-none");
        }
    });

    let acc = "";
    let dataInversionUS = 0;
    let dataInversionMXN = 0;
    let dataFechaInicio = "";

    var table = $("#contrato").DataTable({
        ajax: "/admin/showContrato",
        columns: [
            { data: "contrato" },
            { data: "tipo" },
            { data: "status" },
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
            emptyTable: "No se ha registrado ning??n contrato",
            infoEmpty:
                "Mostrando contratos del 0 al 0 de un total de 0 contratos",
            infoFiltered: "(filtrado de un total de _MAX_ contratos)",
            search: "Buscar:",
            infoThousands: ",",
            loadingRecords: "Cargando...",
            paginate: {
                first: "Primero",
                last: "??ltimo",
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
                collection: "Colecci??n",
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
                add: "A??adir condici??n",
                button: {
                    0: "Constructor de b??squeda",
                    _: "Constructor de b??squeda (%d)",
                },
                clearAll: "Borrar todo",
                condition: "Condici??n",
                conditions: {
                    date: {
                        after: "Despues",
                        before: "Antes",
                        between: "Entre",
                        empty: "Vac??o",
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
                        notEmpty: "No vac??o",
                        not: "Diferente de",
                    },
                    string: {
                        contains: "Contiene",
                        empty: "Vac??o",
                        endsWith: "Termina en",
                        equals: "Igual a",
                        notEmpty: "No Vacio",
                        startsWith: "Empieza con",
                        not: "Diferente de",
                    },
                    array: {
                        not: "Diferente de",
                        equals: "Igual",
                        empty: "Vac??o",
                        contains: "Contiene",
                        notEmpty: "No Vac??o",
                        without: "Sin",
                    },
                },
                data: "Data",
                deleteTitle: "Eliminar regla de filtrado",
                leftTitle: "Criterios anulados",
                logicAnd: "Y",
                logicOr: "O",
                rightTitle: "Criterios de sangr??a",
                title: {
                    0: "Constructor de b??squeda",
                    _: "Constructor de b??squeda (%d)",
                },
                value: "Valor",
            },
            searchPanes: {
                clearMessage: "Borrar todo",
                collacontratoe: {
                    0: "Paneles de b??squeda",
                    _: "Paneles de b??squeda (%d)",
                },
                count: "{total}",
                countFiltered: "{shown} ({total})",
                emptyPanes: "Sin paneles de b??squeda",
                loadMessage: "Cargando paneles de b??squeda",
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
                        _: "??Est?? seguro que desea eliminar %d filas?",
                        1: "??Est?? seguro que desea eliminar 1 fila?",
                    },
                },
                error: {
                    system: 'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">M??s informaci??n&lt;\\/a&gt;).</a>',
                },
                multi: {
                    title: "M??ltiples Valores",
                    info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aqu??, de lo contrario conservar??n sus valores individuales.",
                    restore: "Deshacer Cambios",
                    noMulti:
                        "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
                },
            },
            info: "Mostrando de _START_ a _END_ de _TOTAL_ contratos",
        },
    });

    table.on("change", ".status", function () {
        var checked = $(this).is(":checked");

        if (checked) {
            $(this).val("Activado");
        } else {
            $(this).val("Pendiente de activaci??n");
        }

        let input = this;

        var id = $(this).data("id");
        var statusValor = $(this).val();
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
        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Editar estatus</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para editar el estatus</p>',
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
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.get(
                                "/admin/editStatus",
                                {
                                    id: id,
                                    status: statusValor,
                                },
                                function () {
                                    Toast.fire({
                                        icon: "success",
                                        title: "Estatus actualizado",
                                    });

                                    table.ajax.reload(function () {
                                        if (statusValor == "Activado") {
                                            $(this).prop("checked", true);
                                        } else {
                                            $(this).prop("checked", false);
                                        }
                                    });
                                }
                            );
                        } else {
                            estatusClaveIncorrecta(input);

                            Toast.fire({
                                icon: "error",
                                title: "Clave incorrecta",
                            });
                        }
                    },
                    error: function () {
                        estatusClaveIncorrecta(input);
                        Toast.fire({
                            icon: "error",
                            title: "Clave incorrecta",
                        });
                    },
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (!result.isConfirmed) {
                estatusClaveIncorrecta();
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El estatus no se ha actualizado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#contratoForm").on("submit", function (e) {
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
                $("#contratoForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato a??adido</h1>',
                        html: '<p style="font-family: Poppins">El contrato ha sido a??adido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato actualizado</h1>',
                        html: '<p style="font-family: Poppins">El contrato ha sido actualizado correctamente</p>',
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
                            <label for="telefonoBen1Input">Tel??fono del beneficiario</label>
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

    $("#scannerForm").on("submit", function (e) {
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
                $("#scannerModal").modal("hide");
                $("#scannerForm")[0].reset();
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Documento(s) a??adidos</h1>',
                    html: '<p style="font-family: Poppins">Los documento(s) han sido a??adido(s) correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#contratoForm")[0].reset();

        $("#tablaBody").empty();

        $("#alertMessage").text("");
        $("#contPagos").empty();
        $(".cont-tabla").empty();

        $("#clienteIdInput").next().children().first().empty();
        $("#clienteIdInput").next().children().first().text("Selecciona...");
        $("#clienteIdInput")
            .next()
            .children()
            .first()
            .attr("data-dselect-text", "");
        $("#clienteIdInput").next().children().first().attr("disabled", false);

        $("#psIdInput").next().children().first().empty();
        $("#psIdInput").next().children().first().text("Selecciona...");
        $("#psIdInput").next().children().first().attr("data-dselect-text", "");
        $("#psIdInput").next().children().first().attr("disabled", false);

        acc = "new";
        $("#contratoForm").attr("action", "/admin/addContrato");
        $("#idInput").val("");

        $("#operadorInput").prop("readonly", false);
        $("#operadorINEInput").prop("readonly", false);
        $("#lugarFirmaInput").prop("readonly", false);
        $("#fechaInicioInput").prop("readonly", false);
        $("#fechaRenInput").prop("readonly", false);
        $("#fechaPagInput").prop("readonly", false);
        $("#fechaLimiteInput").prop("readonly", false);
        $("#periodoInput").prop("disabled", false);
        $("#contratoInput").prop("readonly", false);
        $("#psIdInput").prop("disabled", false);
        $("#clienteIdInput").prop("disabled", false);
        $("#pendienteIdInput").prop("disabled", false);
        $("#tipoIdInput").prop("disabled", false);
        // $("#porcentajeInput").prop("readonly", false);
        $("#folioInput").prop("readonly", false);
        $("#modeloIdInput").prop("disabled", false);
        $("#inversionInput").prop("readonly", false);
        $("#inversionUsInput").prop("readonly", false);
        $("#tipoCambioInput").prop("readonly", false);
        $("#inversionLetInput").prop("readonly", false);
        $("#inversionLetUsInput").prop("readonly", false);
        $("#fechaReinInput").prop("readonly", false);
        $("#statusReinInput").prop("disabled", false);
        $("#memoReinInput").prop("readonly", false);
        $("#statusInput").prop("disabled", false);
        $("#beneficiariosInput").prop("disabled", false);
        $("#nombreBen1Input").prop("readonly", false);
        $("#porcentajeBen1Input").prop("readonly", false);
        $("#telefonoBen1Input").prop("readonly", false);
        $("#correoBen1Input").prop("readonly", false);
        $("#curpBen1Input").prop("readonly", false);
        $("#nombreBen2Input").prop("readonly", false);
        $("#porcentajeBen2Input").prop("readonly", false);
        $("#telefonoBen2Input").prop("readonly", false);
        $("#correoBen2Input").prop("readonly", false);
        $("#curpBen2Input").prop("readonly", false);
        $("#nombreBen3Input").prop("readonly", false);
        $("#porcentajeBen3Input").prop("readonly", false);
        $("#telefonoBen3Input").prop("readonly", false);
        $("#correoBen3Input").prop("readonly", false);
        $("#curpBen3Input").prop("readonly", false);
        $("#tipoPagoInput").prop("disabled", false);
        $("#comprobantePagoInput").prop("disabled", false);
        $("#efectivoInput").prop("disabled", false);
        $("#transferenciaSwissInput").prop("disabled", false);
        $("#transferenciaMXInput").prop("disabled", false);
        $("#ciBankInput").prop("disabled", false);
        $("#hsbcInput").prop("disabled", false);
        $("#renovacionInput").prop("disabled", false);
        $("#rendimientosInput").prop("disabled", false);
        $("#comisionesInput").prop("disabled", false);

        $("#montoEfectivoInput").prop("disabled", false);
        $("#montoTransSwissPOOLInput").prop("disabled", false);
        $("#montoTransMXPOOLInput").prop("disabled", false);
        $("#montoBankInput").prop("disabled", false);
        $("#montoHSBCInput").prop("disabled", false);
        $("#montoRenovacionInput").prop("disabled", false);
        $("#montoRendimientosInput").prop("disabled", false);
        $("#montoComisionesInput").prop("disabled", false);

        $("#comprobantePagoInput").removeClass("is-valid");
        $("#comprobantePagoInput").removeClass("is-invalid");

        $(".status_reintegro").hide();
        $(".memo_reintegro").hide();

        $("#modalTitle").text("A??adir contrato");
        $("#btnSubmit").text("A??adir contrato");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");

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
                    <label for="telefonoBen1Input">Tel??fono del beneficiario</label>
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

        $.ajax({
            url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
            jsonp: "callback",
            dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
            success: function (response) {
                //Handler de la respuesta
                var series = response.bmx.series;
                for (var i in series) {
                    var serie = series[i];

                    var precioDolar = serie.datos[0].dato;

                    $("#tipoCambioInput").val(precioDolar);
                }
            },
        });

        containerHide();
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
                                    <label for="telefonoBen${i}Input">Tel??fono del ${adjetivo} beneficiario</label>
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
                        $("#telefonoBen1Input").val("sin telefono de cont??cto");
                        $("#correoBen1Input").val("sin correo de cont??cto");
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
                        $("#telefonoBen2Input").val("sin telefono de cont??cto");
                        $("#correoBen2Input").val("sin correo de cont??cto");
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
                        $("#telefonoBen3Input").val("sin telefono de cont??cto");
                        $("#correoBen3Input").val("sin correo de cont??cto");
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
                            <label for="telefonoBen1Input">Tel??fono del beneficiario</label>
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
                                <th scope="col">Inter??s</th>
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
                                <th scope="col">Inter??s</th>
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

    $(document).on("click", ".scanner", function (e) {
        $("#scannerForm")[0].reset();

        acc = "scanner";
        e.preventDefault();

        $("#scannerForm").attr("action", "/admin/addScanner");

        var id = $(this).data("id");
        var contrato = $(this).data("contrato");

        $("#idInputScanner").val(id);
        $("#contratoInputScanner").val(contrato);

        $(".image-upload-wrapScanner1").show();
        $(".file-upload-imageScanner1").attr("src", "");
        $(".file-upload-contentScanner1").hide();

        $(".image-upload-wrapScanner2").show();
        $(".file-upload-imageScanner2").attr("src", "");
        $(".file-upload-contentScanner2").hide();

        $.get({
            url: "/admin/checkScanner",
            data: {
                id: id,
            },
            success: function (res) {
                if (res != "none") {
                    acc = "edit";
                    $("#scannerForm").attr("action", "/admin/editScanner");

                    if (res[0].img_anverso != null) {
                        $(".image-upload-wrapScanner1").hide();
                        $(".file-upload-imageScanner1").attr(
                            "src",
                            "/documentos/contrato_escaneado" +
                                "/" +
                                res[0].img_anverso
                        );
                        $(".file-upload-contentScanner1").show();
                    }

                    if (res[0].img_reverso != null) {
                        $(".image-upload-wrapScanner2").hide();
                        $(".file-upload-imageScanner2").attr(
                            "src",
                            "/documentos/contrato_escaneado" +
                                "/" +
                                res[0].img_reverso
                        );
                        $(".file-upload-contentScanner2").show();
                    }
                } else if (res == "none") {
                    $("#scannerForm").attr("action", "/admin/addScanner");
                    console.log(res);
                } else {
                    console.log(res);
                }
            },
            error: function (error) {
                console.log(error);
            },
        });

        $("#modalTitleScanner").text(`Contrato escaneado: ${contrato}`);
        $("#btnSubmitScanner").text("Guardar cambios");
        $("#scannerModal").modal("show");
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

        dataInversionUS = $(this).data("inversionus");
        dataInversionMXN = $(this).data("inversion");
        dataFechaInicio = $(this).data("fecha");

        $("#contratoForm").attr("action", "/admin/editContrato");

        $("#idInput").val(id);

        $("#operadorInput").val(operador);
        $("#operadorInput").prop("readonly", false);

        $("#operadorINEInput").val(operadorine);
        $("#operadorINEInput").prop("readonly", false);

        $("#lugarFirmaInput").val(lugarfirma);
        $("#lugarFirmaInput").prop("readonly", false);

        $("#fechaInicioInput").val(fechainicio);
        $("#fechaInicioInput").prop("readonly", false);

        $("#fechaRenInput").val(fecharen);
        $("#fechaRenInput").prop("readonly", false);

        $("#fechaPagInput").val(fechapag);
        $("#fechaPagInput").prop("readonly", false);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", false);

        $("#periodoInput").val(periodo);
        $("#periodoInput").prop("disabled", false);

        $("#contratoInput").val(contrato);
        $("#contratoInput").prop("readonly", false);

        $("#psIdInput").val(psid);
        $("#psIdInput").prop("disabled", false);

        $("#clienteIdInput").val(clienteid);
        // $("#clienteIdInput").prop("disabled", true);

        $("#pendienteIdInput").val(pendienteid);
        $("#pendienteIdInput").prop("disabled", false);

        $("#tipoIdInput").val(tipoid);
        $("#tipoIdInput").prop("disabled", false);

        porcentaje = porcentaje.toString().replace(",", ".");
        $("#porcentajeInput").val(porcentaje);
        // $("#porcentajeInput").prop("readonly", false);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", false);

        $("#modeloIdInput").val(modeloid);
        $("#modeloIdInput").prop("disabled", false);

        inversion = inversion.toString().replace(",", ".");
        $("#inversionInput").val(inversion);
        $("#inversionInput").prop("readonly", false);

        inversionus = inversionus.toString().replace(",", ".");
        $("#inversionUsInput").val(inversionus);
        $("#inversionUsInput").prop("readonly", false);

        tipocambio = tipocambio.toString().replace(",", ".");
        $("#tipoCambioInput").val(tipocambio);
        $("#tipoCambioInput").prop("readonly", false);

        $("#fechaReinInput").val(fecharein);
        $("#fechaReinInput").prop("readonly", false);

        $("#statusReinInput").val(statusrein);
        $("#statusReinInput").prop("disabled", false);

        $("#memoReinInput").val(memorein);
        $("#memoReinInput").prop("readonly", false);

        $("#inversionLetInput").val(inversionlet);
        $("#inversionLetInput").prop("readonly", false);

        $("#inversionLetUsInput").val(inversionletus);
        $("#inversionLetUsInput").prop("readonly", false);

        $("#statusInput").val(status);
        $("#statusInput").prop("disabled", false);

        $("#beneficiariosInput").prop("disabled", false);

        containerHide();

        $("#comprobantePagoInput").prop("disabled", false);
        comprobantePago(this);

        $("#efectivoInput").prop("disabled", false);
        $("#transferenciaSwissInput").prop("disabled", false);
        $("#transferenciaMXInput").prop("disabled", false);
        $("#ciBankInput").prop("disabled", false);
        $("#hsbcInput").prop("disabled", false);
        $("#renovacionInput").prop("disabled", false);
        $("#rendimientosInput").prop("disabled", false);
        $("#comisionesInput").prop("disabled", false);
        tipoPago(this);

        $("#montoEfectivoInput").prop("disabled", false);
        $("#montoTransSwissPOOLInput").prop("disabled", false);
        $("#montoTransMXPOOLInput").prop("disabled", false);
        $("#montoBankInput").prop("disabled", false);
        $("#montoHSBCInput").prop("disabled", false);
        $("#montoRenovacionInput").prop("disabled", false);
        $("#montoRendimientosInput").prop("disabled", false);
        $("#montoComisionesInput").prop("disabled", false);

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
                                    <label for="telefonoBen${i}Input">Tel??fono del ${adjetivo} beneficiario</label>
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

                        $(`#nombreBen${i}Input`).prop("readonly", false);
                        $(`#porcentajeBen${i}Input`).prop("readonly", false);
                        $(`#telefonoBen${i}Input`).prop("readonly", false);
                        $(`#correoBen${i}Input`).prop("readonly", false);
                        $(`#curpBen${i}Input`).prop("readonly", false);
                        $(`#curpBen${i}InputCheck`).prop("disabled", false);
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
                                <label for="telefonoBen1Input">Tel??fono del beneficiario</label>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-floating mb-3">                                
                                <input type="text" class="form-control"
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
                }
            },
        });

        $(".status_reintegro").show();
        $(".memo_reintegro").show();

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
                                <th scope="col">Inter??s</th>
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
                                <th scope="col">Inter??s</th>
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
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar contrato</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar el contrato</p>',
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
                    data: {
                        clave: clave,
                    },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteContrato",
                                {
                                    id: id,
                                },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Contrato eliminado</h1>',
                                        html: '<p style="font-family: Poppins">El contrato se ha eliminado correctamente</p>',
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
                    html: '<p style="font-family: Poppins">El contrato no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("click", ".print", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        window.location.href = "/admin/contrato/vercontrato?id=" + id;
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
                                    <th scope="col">Inter??s</th>
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
                                    <th scope="col">Inter??s</th>
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
                                            <th scope="col">Inter??s</th>
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
                                            <th scope="col">Inter??s</th>
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
                                            <th scope="col">Inter??s</th>
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
                                            <th scope="col">Inter??s</th>
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
                                <label for="telefonoBen${i}Input">Tel??fono del ${adjetivo} beneficiario</label>
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

        if (target.is("#comisionesInput")) {
            let comisionChecked = $("#comisionesInput").is(":checked");

            if (comisionChecked) {
                $("#montoComisionesCont").show();
            } else {
                $("#montoComisionesCont").hide();
            }
        }
    });

    //Evento change en el cambio de cliente para mostrar los pendientes que coincidan con el nombre del cliente
    $("#clienteIdInput").change(function () {
        var id = $("#clienteIdInput").val();
        $.ajax({
            type: "GET",
            url: "/admin/showListaPendientes",
            data: {
                id: id,
            },
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
                        data: {
                            id: psid,
                        },
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
            },
        });

        $.get({
            url: "/admin/showNumeroCliente",
            data: {
                id: id,
            },
            success: function (response) {
                $("#contratoInput").val(response);
            },
        });
    });

    function estatusClaveIncorrecta(input) {
        let estatus = $(input).data("status");
        if (estatus == "Activado") {
            $(input).prop("checked", true);
            $(input).val("Activado");
        } else {
            $(input).prop("checked", false);
            $(input).val("Pendiente de activaci??n");
        }
    }

    const comprobantePago = (thiss) => {
        var comprobantepago = $(thiss).data("comprobantepago");
        var contrato = $(thiss).data("contrato");

        if (comprobantepago.length > 0) {
            $("#comprobantePagoInput").addClass("is-valid");
            $("#comprobantePagoInput").removeClass("is-invalid");

            $("#comprobantePagoDesc").attr("download", `${contrato}.zip`);
            $("#comprobantePagoDesc").attr(
                "href",
                `../documentos/comprobantes_pagos/${contrato}/${contrato}.zip`
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
        montopago = montopago.split(",");

        let tipopago = $(thiss).data("tipopago");
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
