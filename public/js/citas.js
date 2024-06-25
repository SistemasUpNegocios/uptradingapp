$(document).ready(function () {
    let opc = "pendiente";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const countCitas = () => {
        $.ajax({
            type: "GET",
            url: "/admin/showCountCitas",
            success: function (data) {
                $("#countCitas").text(
                    `Hola, tienes ${data} cita(s) pendiente(s).`
                );
            },
            error: function () {
                console.log("Error");
            },
        });
    };

    countCitas();

    $(document).on(
        "click",
        "#abiertos-tab, #proceso-tab, #cancelados-tab, #terminados-tab",
        function () {
            opc = $(this).data("opc");
        }
    );

    $(document).on("keyup", "#busquedaCitaInput", function (e) {
        e.preventDefault();
        $("#resetButton").removeClass("d-none");
    });

    $(document).on("click", "#resetButton", function (e) {
        $.ajax({
            type: "GET",
            url: "/admin/showAllCitas",
            data: { opc },
            success: function (data) {
                $("#contenidoCitas").html(data);
            },
            error: function () {
                console.log("Error");
            },
        });

        $("#resetButton").addClass("d-none");
    });

    $(document).on("change", "#diaInput", function () {
        let dia = moment($(this).val()).format("dddd");
        if (dia == "sábado" || dia == "domingo") {
            Swal.fire({
                icon: "warning",
                title: "Lo sentimos, solo trabajamos de lunes a viernes.",
                showConfirmButton: true,
            });
            $(this).val("");
        }
    });

    $(document).on("change", "#horaInput", function () {
        let hora = $(this).val();
        if (hora < "09:00" || hora > "17:30") {
            Swal.fire({
                icon: "warning",
                title: "Lo sentimos, solo trabajamos de 09:00am a 05:30pm",
                showConfirmButton: true,
            });
            $(this).val("");
        }
    });

    $(document).on("click", ".horario", function (e) {
        e.preventDefault();
        $("#formModal").modal("show");
        $(".campos-horario").show();
        $(".campos-generales").hide();
        $(".campos-bitacora").hide();
        $("#citaForm").attr("action", "/admin/editHorarioCita");

        let id = $(this).data("id");
        $("#idInput").val(id);

        $("#activeInput").val(opc);

        let dia = $(this).data("dia");
        $("#diaInput").val(dia);
        $("#diaInput").prop("readonly", false);
        $("#diaInput").prop("required", true);

        let hora = $(this).data("hora");
        hora = hora.substring(0, 5);
        $("#horaInput").val(hora);
        $("#horaInput").prop("readonly", false);
        $("#horaInput").prop("required", true);

        $("#modalTitle").text(`Cambiar horario de la cita`);
        $("#btnSubmit").text("Cambiar horario");
        $("#btnSubmit").show();
    });

    $(document).on("click", ".detalles", function (e) {
        e.preventDefault();
        $("#formModal").modal("show");
        $(".campos-generales").show();
        $(".campos-horario").show();
        $(".campos-bitacora").show();

        let codigo_cliente = $(this).data("codigo_cliente");
        $("#codigoClienteInput").val(codigo_cliente);
        $("#codigoClienteInput").prop("readonly", true);

        let nombre = $(this).data("nombre");
        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        let apellido_p = $(this).data("apellido_p");
        $("#apellidopInput").val(apellido_p);
        $("#apellidopInput").prop("readonly", true);

        let apellido_m = $(this).data("apellido_m");
        $("#apellidomInput").val(apellido_m);
        $("#apellidomInput").prop("readonly", true);

        let telefono_alterno = $(this).data("telefono_alterno");
        $("#telefonoAlternoInput").val(telefono_alterno);
        $("#telefonoAlternoInput").prop("readonly", true);

        let correo_alterno = $(this).data("correo_alterno");
        $("#correoAlternoInput").val(correo_alterno);
        $("#correoAlternoInput").prop("readonly", true);

        let dia = $(this).data("dia");
        $("#diaInput").val(dia);
        $("#diaInput").prop("readonly", true);

        let hora = $(this).data("hora");
        hora = hora.substring(0, 5);
        $("#horaInput").val(hora);
        $("#horaInput").prop("readonly", true);

        let contenido_llamada = $(this).data("contenido_llamada");
        $("#contenidoLlamadaInput").val(contenido_llamada);
        $("#contenidoLlamadaInput").prop("readonly", true);

        let fecha_contenido = $(this).data("fecha_contenido_llamada");
        if (!fecha_contenido) fecha_contenido = "Sin actualización aun.";
        else
            fecha_contenido = `Fecha de última actualización: <b>${moment(
                fecha_contenido
            ).format("lll")} hrs.</b>`;
        $("#actualizacionContenido").html(fecha_contenido);

        let acuerdo = $(this).data("acuerdo");
        $("#acuerdoInput").val(acuerdo);
        $("#acuerdoInput").prop("readonly", true);

        let fecha_acuerdo = $(this).data("fecha_acuerdo");
        if (!fecha_acuerdo) fecha_acuerdo = "Sin actualización aun.";
        else
            fecha_acuerdo = `Fecha de última actualización: <b>${moment(
                fecha_acuerdo
            ).format("lll")} hrs.</b>`;
        $("#actualizacionAcuerdo").html(fecha_acuerdo);

        let firma_documento = $(this).data("firma_documento");
        $("#firmaDocumentoInput").val(firma_documento);
        $("#firmaDocumentoInput").prop("readonly", true);

        let fecha_firma = $(this).data("fecha_firma_documento");
        if (!fecha_firma) fecha_firma = "Sin actualización aun.";
        else
            fecha_firma = `Fecha de última actualización: <b>${moment(
                fecha_firma
            ).format("lll")} hrs.</b>`;
        $("#actualizacionFirma").html(fecha_firma);

        let otros_comentarios = $(this).data("otros_comentarios");
        $("#otrosComentariosInput").val(otros_comentarios);
        $("#otrosComentariosInput").prop("readonly", true);

        let fecha_otros = $(this).data("fecha_otros_comentarios");
        if (!fecha_otros) fecha_otros = "Sin actualización aun.";
        else
            fecha_otros = `Fecha de última actualización: <b>${moment(
                fecha_otros
            ).format("lll")} hrs.</b>`;
        $("#actualizacionComentarios").html(fecha_otros);

        $("#modalTitle").text(`Detalles de la cita de ${nombre}`);
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit-cita", function (e) {
        e.preventDefault();
        $("#formModal").modal("show");
        $(".campos-bitacora").show();
        $(".campos-generales").hide();
        $(".campos-horario").hide();
        $("#citaForm").attr("action", "/admin/editBitacoraCita");

        $("#diaInput").prop("required", false);
        $("#horaInput").prop("required", false);

        let id = $(this).data("id");
        $("#idInput").val(id);

        $("#activeInput").val(opc);

        let contenido_llamada = $(this).data("contenido_llamada");
        $("#contenidoLlamadaInput").val(contenido_llamada);
        $("#contenidoLlamadaInput").prop("readonly", false);

        let fecha_contenido = $(this).data("fecha_contenido_llamada");
        if (!fecha_contenido) fecha_contenido = "Sin actualización aun.";
        else
            fecha_contenido = `Fecha de última actualización: <b>${moment(
                fecha_contenido
            ).format("lll")} hrs.</b>`;
        $("#actualizacionContenido").html(fecha_contenido);

        let acuerdo = $(this).data("acuerdo");
        $("#acuerdoInput").val(acuerdo);
        $("#acuerdoInput").prop("readonly", false);

        let fecha_acuerdo = $(this).data("fecha_acuerdo");
        if (!fecha_acuerdo) fecha_acuerdo = "Sin actualización aun.";
        else
            fecha_acuerdo = `Fecha de última actualización: <b>${moment(
                fecha_acuerdo
            ).format("lll")} hrs.</b>`;
        $("#actualizacionAcuerdo").html(fecha_acuerdo);

        let firma_documento = $(this).data("firma_documento");
        $("#firmaDocumentoInput").val(firma_documento);
        $("#firmaDocumentoInput").prop("readonly", false);

        let fecha_firma = $(this).data("fecha_firma_documento");
        if (!fecha_firma) fecha_firma = "Sin actualización aun.";
        else
            fecha_firma = `Fecha de última actualización: <b>${moment(
                fecha_firma
            ).format("lll")} hrs.</b>`;
        $("#actualizacionFirma").html(fecha_firma);

        let otros_comentarios = $(this).data("otros_comentarios");
        $("#otrosComentariosInput").val(otros_comentarios);
        $("#otrosComentariosInput").prop("readonly", false);

        let fecha_otros = $(this).data("fecha_otros_comentarios");
        if (!fecha_otros) fecha_otros = "Sin actualización aun.";
        else
            fecha_otros = `Fecha de última actualización: <b>${moment(
                fecha_otros
            ).format("lll")} hrs.</b>`;
        $("#actualizacionComentarios").html(fecha_otros);

        $("#modalTitle").text(`Bitacora del cliente`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Actualizar bitacora");
    });

    $(document).on("click", ".estatus", function (e) {
        e.preventDefault();
        $("#estatusModal").modal("show");

        let id = $(this).data("id");
        $("#idEstatusInput").val(id);

        $("#activeEstatusInput").val(opc);

        let estatus = $(this).data("estatus");
        $("#estatusInput").val(estatus);
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        let id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar cita</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar esta cita? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteCita", { id: id }, function () {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cita eliminada</h1>',
                        html: '<p style="font-family: Poppins">La cita se ha eliminada correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La cita no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $("#citaForm").on("submit", function (e) {
        e.preventDefault();
        let url = $(this).attr("action");

        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Se está haciendo el cambio, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                Swal.close();
                countCitas();
                $("#formModal").modal("hide");
                $("#contenidoCitas").html(data);

                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Registro actualizado</h1>',
                    html: '<p style="font-family: Poppins">La cita ha sido actualizada correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (err) {
                console.error(err);
            },
        });
    });

    $("#citaEstatusForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/admin/editStatusCita",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                countCitas();
                $("#estatusModal").modal("hide");
                $("#contenidoCitas").html(data);
            },
            error: function (err) {
                console.error(err);
            },
        });
    });

    $(document).on("submit", "#busquedaCitaForm", function (e) {
        e.preventDefault();
        let url = $(this).attr("action");
        $("#opcInput").val(opc);
        $("#resetButton").removeClass("d-none");

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                $("#contenidoCitas").html(res);
            },
            error: function (res) {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Sin resultados</h1>',
                    html:
                        '<p style="font-family: Poppins">No hay coincidencias para tu búsqueda: <span class="fw-bolder">' +
                        res.responseText +
                        "</span>. Por favor, intenta de nuevo</p>",
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
        });
    });
});

$(".table").addClass("compact nowrap w-100");
