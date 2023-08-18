let acc = "";
document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("agenda");

    let calendar = "";

    $(document).change("#verCitasInput", function () {
        let ver_citas = $("#verCitasInput").val();

        mostrarCalendario(`/admin/showAgenda?citas=${ver_citas}`);
    });

    $(document).on("click", "#btnGuardar", function (e) {
        acc = "new";
        $("#agendaForm").attr("action", "/admin/addAgenda");
    });

    $(document).on("click", "#btnModificar", function (e) {
        actualizarCita();
    });

    $(document).on("click", "#btnCerrar", function (e) {
        $("#formModal").modal("hide");
    });

    $(document).on("click", "#btnEliminar", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        let id = $("#idInput").val();

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
                $.post("/admin/deleteAgenda", { id: id }, function () {
                    $("#agendaForm")[0].reset();
                    $("#formModal").modal("hide");
                    calendar.refetchEvents();
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cita eliminada</h1>',
                        html: '<p style="font-family: Poppins">La cita se ha eliminado correctamente</p>',
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

    $(document).on("change", "#asignadoAInput", function () {
        if ($(this).val() == "1" || $(this).val() == "4") {
            $("#colorInput").val("#D71313");
        } else if ($(this).val() == "2" || $(this).val() == "246") {
            $("#colorInput").val("#01BBCC");
        } else if ($(this).val() == "3") {
            $("#colorInput").val("#557A46");
        } else if ($(this).val() == "234" || $(this).val() == "235") {
            $("#colorInput").val("#CB01A6");
        }
    });

    $("#agendaForm").on("submit", function (e) {
        e.preventDefault();
        $("#alertMessage").text("");
        enviarDatos(this);
        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Enviando correo, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    });

    const actualizarCita = () => {
        acc = "edit";
        $("#agendaForm").attr("action", "/admin/editAgenda");
    };

    const enviarDatos = (thiss) => {
        let url = $(thiss).attr("action");
        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(thiss),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                $("#formModal").modal("hide");
                $("#agendaForm")[0].reset();
                calendar.refetchEvents();
                Swal.close();
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cita añadida</h1>',
                        html: '<p style="font-family: Poppins">La cita ha sido añadida correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Cita actualizada</h1>',
                        html: '<p style="font-family: Poppins">La cita ha sido actualizada correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (err, exception) {
                let validacion = err.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    };

    const mostrarCalendario = (url) => {
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: "dayGridMonth",
            locale: "es",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth, timeGridWeek, listWeek",
            },
            slotLabelFormat: {
                hour: "2-digit",
                minute: "2-digit",
            },
            eventTimeFormat: {
                hour: "2-digit",
                minute: "2-digit",
            },
            editable: true,
            eventDrop: function (info) {
                $.get({
                    url: "/admin/showCita",
                    data: {
                        id: info.event.id,
                    },
                    success: function (data) {
                        let fecha = formatDate(info.event.start);
                        fecha = fecha.split("/").reverse().join("-");
                        $("#idInput").val(data.id);
                        $("#tituloInput").val(data.title);
                        $("#descripcionInput").val(data.description);
                        $("#horaInput").val(data.hour);
                        $("#colorInput").val(data.color);
                        $("#asignadoAInput").val(data.asignado_a);
                        $("#asignadoA2Input").val(data.asignado_a2);
                        $("#fechaInput").val(fecha);

                        let form = document.getElementById("agendaForm");
                        actualizarCita();
                        enviarDatos(form);
                    },
                    error: function (error) {
                        console.log(error.response.data);
                    },
                });
            },
            eventSources: {
                url: url,
                metohd: "GET",
                extraParams: {
                    _token: $("#agendaForm")._token,
                },
            },

            dateClick: function (info) {
                $("#idInput").prop("disabled", false);
                $("#tituloInput").prop("disabled", false);
                $("#descripcionInput").prop("disabled", false);
                $("#horaInput").prop("disabled", false);
                $("#colorInput").prop("disabled", false);
                $("#asignadoAInput").prop("disabled", false);
                $("#asignadoA2Input").prop("disabled", false);
                $("#fechaInput").prop("disabled", false);

                $("#agendaForm")[0].reset();
                $("#fechaInput").val(info.dateStr);
                $("#btnModificar").hide();
                $("#btnEliminar").hide();
                $("#btnGuardar").show();
                $("#formModal").modal("show");
                $("#modalTitle").text("Añadir cita");
            },

            eventClick: function (info) {
                $("#formModal").modal("show");
                $("#btnGuardar").hide();
                let id_generado = info.event.extendedProps.generado_por;
                let id_user = $("#id_user").val();
                if (id_user == id_generado) {
                    $("#idInput").prop("disabled", false);
                    $("#tituloInput").prop("disabled", false);
                    $("#descripcionInput").prop("disabled", false);
                    $("#horaInput").prop("disabled", false);
                    $("#colorInput").prop("disabled", false);
                    $("#asignadoAInput").prop("disabled", false);
                    $("#asignadoA2Input").prop("disabled", false);
                    $("#fechaInput").prop("disabled", false);

                    $("#btnModificar").show();
                    $("#btnEliminar").show();
                    $("#modalTitle").text("Editar cita");
                } else {
                    $("#idInput").prop("disabled", true);
                    $("#tituloInput").prop("disabled", true);
                    $("#descripcionInput").prop("disabled", true);
                    $("#horaInput").prop("disabled", true);
                    $("#colorInput").prop("disabled", true);
                    $("#asignadoAInput").prop("disabled", true);
                    $("#asignadoA2Input").prop("disabled", true);
                    $("#fechaInput").prop("disabled", true);

                    $("#btnModificar").hide();
                    $("#btnEliminar").hide();
                    $("#modalTitle").text("Cita asignada a ti");
                }

                $.get({
                    url: "/admin/showCita",
                    data: {
                        id: info.event.id,
                    },
                    success: function (data) {
                        $("#idInput").val(data.id);
                        $("#tituloInput").val(data.title);
                        $("#descripcionInput").val(data.description);
                        $("#fechaInput").val(data.date);
                        $("#horaInput").val(data.hour);
                        $("#colorInput").val(data.color);
                        $("#asignadoAInput").val(data.asignado_a);
                        $("#asignadoA2Input").val(data.asignado_a2);
                    },
                    error: function (error) {
                        console.log(error.response.data);
                    },
                });
            },
        });

        calendar.render();
    };

    let ver_citas = $("#verCitasInput").val();
    mostrarCalendario(`/admin/showAgenda?citas=${ver_citas}`);
});
