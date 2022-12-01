$(document).ready(function () {
    let acc = "";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#ticketForm").on("submit", function (e) {
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
                $("#ticketForm")[0].reset();
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

    $(document).on("click", ".new", function (e) {
        $("#alertMessage").text("");
        acc = "new";
        $("#ticketForm")[0].reset();
        $("#ticketForm").attr("action", "/admin/addTicket");
        $("#idInput").val("");

        $("#nombreInput").prop("readonly", false);

        $("#modalTitle").text("Abrir ticket");
        $("#btnSubmit").text("Abrir ticket");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var nombre = $(this).data("nombre");

        $("#modalTitle").text(`Vista previa del banco: ${nombre}`);

        $("#formModal").modal("show");

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var nombre = $(this).data("nombre");

        $("#formModal").modal("show");
        $("#ticketForm").attr("action", "/admin/editTicket");

        $("#idInput").val(id);

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", false);

        $("#modalTitle").text(`Editar ticket: ${nombre}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar ticket");
        $("#btnCancel").text("Cancelar");
    });
});