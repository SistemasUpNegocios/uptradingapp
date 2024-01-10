$(document).ready(function () {
    let acc = "";
    let estatus = "";
    let opc = "generados";
    let button = "generados-tab";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const tabsTickets = () => {
        $.ajax({
            type: "GET",
            url: "/admin/showTabsTickets",
            success: function (response) {
                $("#contenidoTicket").empty();
                $("#contenidoTicket").append(response);
                let count = $("#countInput").val();
                $("#countTickets").text(count);
                opcTab(opc, button);
            },
            error: function () {
                console.log("Error");
            },
        });
    };

    $(document).on("click", ".new", function (e) {
        $("#alertMessage").text("");
        acc = "new";
        $("#ticketForm")[0].reset();
        $("#ticketForm").attr("action", "/admin/addTicket");
        $("#idInput").val("");

        $("#fechaActualInput").val(moment().format("YYYY-MM-DD hh:mm"));

        $("#modalTitle").text("Abrir ticket");
        $("#btnSubmit").text("Abrir ticket");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();
        var id = $(this).data("id");
        var departamento = $(this).data("departamento");
        var asignado = $(this).data("asignado");
        var fechagenerado = $(this).data("fechagenerado");
        var fechalimite = $(this).data("fechalimite");
        var asunto = $(this).data("asunto");
        var descripcion = $(this).data("descripcion");

        asignado = asignado.split(",");
        let asignadoCount = asignado.length;
        let user_id = asignado[asignadoCount - 2];

        $("#idInput").val(id);

        $("#departamentoInput").val(departamento);
        $("#departamentoInput").prop("disabled", true);

        $("#fechaActualInput").val(fechagenerado);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", true);

        $("#asuntoInput").val(asunto);
        $("#asuntoInput").prop("readonly", true);

        let posicion = descripcion.indexOf("Contrato:");
        if (posicion !== -1) {
            let link = descripcion.slice(posicion + 6);
            let link_limpio = link.replace(/<\/?[^>]+(>|$)/g, "");
            $("#descripcionInput").val(descripcion.replace(link, link_limpio));
        } else {
            $("#descripcionInput").val(descripcion);
        }
        $("#descripcionInput").prop("readonly", true);

        $.ajax({
            type: "GET",
            url: "/admin/showUsuariosTickets",
            data: {
                privilegio: "edit_user",
                id: user_id,
            },
            success: function (user) {
                $("#asignadoAInput").prop("disabled", true);
                $("#asignadoAInput").empty();
                $("#asignadoAInput").append(`
                    <option value="" disabled>Selecciona...</option>
                `);

                $("#asignadoAInput").append(`
                    <option value="${user[0].id}" selected>${user[0].nombre} ${user[0].apellido_p}</option>
                `);

                $("#modalTitle").text("Ver ticket");
                $("#btnSubmit").hide();
                $("#btnCancel").text("Cancelar");
                $("#formModal").modal("show");
                $("#ticketForm").attr("action", "/admin/editTicket");
            },
        });
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        var departamento = $(this).data("departamento");
        var asignado = $(this).data("asignado");
        var fechagenerado = $(this).data("fechagenerado");
        var fechalimite = $(this).data("fechalimite");
        var asunto = $(this).data("asunto");
        var descripcion = $(this).data("descripcion");

        asignado = asignado.split(",");
        let asignadoCount = asignado.length;
        let user_id = asignado[asignadoCount - 2];

        $("#idInput").val(id);

        $("#departamentoInput").val(departamento);
        $("#departamentoInput").prop("disabled", false);

        $("#fechaActualInput").val(fechagenerado);

        $("#fechaLimiteInput").val(fechalimite);
        $("#fechaLimiteInput").prop("readonly", false);

        $("#asuntoInput").val(asunto);
        $("#asuntoInput").prop("readonly", false);

        let posicion = descripcion.indexOf("Contrato:");
        if (posicion !== -1) {
            let link = descripcion.slice(posicion + 6);
            let link_limpio = link.replace(/<\/?[^>]+(>|$)/g, "");
            $("#descripcionInput").val(descripcion.replace(link, link_limpio));
        } else {
            $("#descripcionInput").val(descripcion);
        }
        $("#descripcionInput").prop("readonly", false);

        $.ajax({
            type: "GET",
            url: "/admin/showUsuariosTickets",
            data: {
                privilegio: "edit_user",
                id: user_id,
            },
            success: function (user) {
                $("#asignadoAInput").empty();
                $("#asignadoAInput").append(`
                    <option value="" disabled>Selecciona...</option>
                `);

                $("#asignadoAInput").append(`
                    <option value="${user[0].id}" selected>${user[0].nombre} ${user[0].apellido_p}</option>
                `);

                $("#modalTitle").text("Editar ticket");
                $("#btnSubmit").show();
                $("#btnSubmit").text("Editar ticket");
                $("#btnCancel").text("Cancelar");
                $("#formModal").modal("show");
                $("#ticketForm").attr("action", "/admin/editTicket");
            },
        });
    });

    $(document).on("click", ".detalles", function (e) {
        e.preventDefault();
        $("#detallesModal").modal("show");

        var todo = $(this).data("todo");
        var asignado = $(this).data("asignado");
        var generado = $(this).data("generado");
        var fechagenerado = moment($(this).data("fechagenerado")).format(
            "DD/MM/YYYY hh:mm A"
        );
        var fechalimite = moment($(this).data("fechalimite")).format(
            "DD/MM/YYYY hh:mm A"
        );
        var departamento = $(this).data("departamento");
        var asunto = $(this).data("asunto");
        var descripcion = $(this).data("descripcion");
        var status = $(this).data("status");

        if (todo == true) {
            $("#asignado").text(asignado);
        }
        $("#generado").text(generado);
        $("#fecha_generado").text(fechagenerado);
        $("#fecha_limite").text(fechalimite);
        $("#departamento").text(departamento);
        $("#asunto").text(asunto);
        let posicion = descripcion.indexOf("Contrato:");
        if (posicion !== -1) {
            let link = descripcion.slice(posicion + 6);
            link = `<a href="${link}" target="_blank">${link}</a>`;
            $("#descripcion").html(descripcion.replace(link, ""));
        } else {
            $("#descripcion").text(descripcion);
        }
        $("#estatus").text(status);

        $("#historial").empty();
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "/admin/showAsignadosTickets",
            data: {
                id: id,
            },
            success: function (response) {
                response.nombre.map((nombre, i) => {
                    let fecha = moment(response.fecha[i]).format("LL hh:mm A");
                    if (i == 0) {
                        $("#historial").append(`
                            <div class="col-md-6 col-12 mb-2">
                                <b>Asignado a:</b> ${nombre}
                            </div>
                        `);
                    } else if (i + 1 == response.nombre.length) {
                        $("#historial").append(`
                            <div class="col-md-6 col-12 mb-2">
                                <b>Último traspaso a:</b> ${nombre}
                            </div>
                        `);
                    } else {
                        $("#historial").append(`
                            <div class="col-md-6 col-12 mb-2">
                                <b>Traspaso ${i} a:</b> ${nombre}
                            </div>
                        `);
                    }

                    $("#historial").append(`
                        <div class="col-md-6 col-12 mb-2">
                            <b>Fecha:</b> ${fecha}
                        </div>
                    `);
                });
            },
        });
    });

    $(document).on("click", ".status", function (e) {
        e.preventDefault();
        acc = "edit";
        $("#statusModal").modal("show");
        $("#ticketEstatusForm").attr("action", "/admin/editStatusTicket");

        var id = $(this).data("id");
        estatus = $(this).data("status");

        $("#idEstatusInput").val(id);
        $("#statusInput").val(estatus);
    });

    $(document).on("click", ".traspasar", function (e) {
        e.preventDefault();
        acc = "edit";
        $("#traspasarModal").modal("show");
        $("#traspasarForm").attr("action", "/admin/traspasarTicket");

        var id = $(this).data("id");

        $("#idTraspasarInput").val(id);
    });

    $("#departamentoInput").change(function () {
        var privilegio = $("#departamentoInput").val();

        $.ajax({
            type: "GET",
            url: "/admin/showUsuariosTickets",
            data: {
                privilegio: privilegio,
            },
            success: function (response) {
                $("#asignadoAInput").empty();
                $("#asignadoAInput").append(`
                    <option value="" disabled selected>Selecciona...</option>
                `);

                response.map(function (user) {
                    $("#asignadoAInput").append(`
                        <option value="${user.id}">${user.nombre} ${user.apellido_p}</option>
                    `);
                });
            },
        });
    });

    $("#departamentoTrasInput").change(function () {
        var privilegio = $("#departamentoTrasInput").val();

        $.ajax({
            type: "GET",
            url: "/admin/showUsuariosTickets",
            data: {
                privilegio: privilegio,
            },
            success: function (response) {
                $("#asignadoATrasInput").empty();
                $("#asignadoATrasInput").append(`
                    <option value="" disabled selected>Selecciona...</option>
                `);

                response.map(function (user) {
                    $("#asignadoATrasInput").append(`
                        <option value="${user.id}">${user.nombre} ${user.apellido_p}</option>
                    `);
                });
            },
        });
    });

    $("#ticketForm").on("submit", function (e) {
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
                $("#ticketForm")[0].reset();
                tabsTickets();
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Ticket abierto</h1>',
                        html: '<p style="font-family: Poppins">El ticket ha sido abierto correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Ticket actualizado</h1>',
                        html: '<p style="font-family: Poppins">El ticket ha sido actualizado correctamente</p>',
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

    $("#ticketEstatusForm").on("submit", function (e) {
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
                $("#statusModal").modal("hide");
                $("#ticketEstatusForm")[0].reset();
                tabsTickets();
            },
            error: function (jqXHR, exception) {
                var validacion = jqXHR.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertEstatusMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $("#traspasarForm").on("submit", function (e) {
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
                $("#traspasarModal").modal("hide");
                $("#traspasarForm")[0].reset();
                tabsTickets();
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Ticket traspasado</h1>',
                    html: '<p style="font-family: Poppins">El ticket fue traspasado con exito</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (jqXHR, exception) {
                var validacion = jqXHR.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertTrasMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $(document).on("click", ".archivar, .desarchivar", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        let archivado = $(this).data("archivado");

        $.ajax({
            type: "GET",
            url: "/admin/archivarTicket",
            data: {
                id,
                archivado,
            },
            success: function () {
                tabsTickets();
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: sans-serif; font-weight: 700;">Error al archivar</h1>',
                    html: '<p style="font-family: sans-serif">El ticket no se ha podido archivar, comunicate con sistemas</p>',
                    confirmButtonText:
                        '<a style="font-family: sans-serif">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
        });
    });

    $(document).on(
        "click",
        "#abiertos-tab, #proceso-tab, #cancelados-tab, #terminados-tab, #generados-tab, #archivados-tab, #todos-tab",
        function (e) {
            e.preventDefault();

            opc = $(this).data("opc");
            button = this.id;

            $("#tabTicketInput").val(opc);
        }
    );

    $(document).on("submit", "#busquedaTicketForm", function (e) {
        e.preventDefault();
        let url = $(this).attr("action");
        let busqueda = $("#busquedaTicketInput").val();

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                $("#contenidoTicket").empty();
                $("#contenidoTicket").append(res);
                let count = $("#countInput").val();
                $("#countTickets").text(count);
                opcTab(opc, button);
                $("#busquedaTicketInput").val(busqueda);
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

    $(document).on("click", "#resetButton", function (e) {
        tabsTickets();
    });

    const opcTab = (opc, button) => {
        $(`#${button}`).addClass("active");

        if (opc == "abiertos") {
            $("#abiertos-tab-pane").addClass("show active");
        } else if (opc == "proceso") {
            $("#proceso-tab-pane").addClass("show active");
        } else if (opc == "cancelados") {
            $("#cancelados-tab-pane").addClass("show active");
        } else if (opc == "atendidos") {
            $("#terminados-tab-pane").addClass("show active");
        } else if (opc == "generados") {
            $("#generados-tab-pane").addClass("show active");
        } else if (opc == "archivados") {
            $("#archivados-tab-pane").addClass("show active");
        } else if (opc == "todos") {
            $("#todos-tab-pane").addClass("show active");
        }
    };
});
