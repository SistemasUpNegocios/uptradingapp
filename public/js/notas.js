$(document).ready(function () {
    const config = {
        search: true,
    };
    dselect(document.querySelector("#clienteIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    var $btns = $(".note-link").click(function () {
        if (this.id == "all-category") {
            var $el = $("." + this.id).fadeIn();
            $("#note-full-container > div").not($el).hide();
        }
        if (this.id == "important") {
            var $el = $("." + this.id).fadeIn();
            $("#note-full-container > div").not($el).hide();
        } else {
            var $el = $("." + this.id).fadeIn();
            $("#note-full-container > div").not($el).hide();
        }
        $btns.removeClass("active");
        $(this).addClass("active");
    });

    $("#add-notes").on("click", function (event) {
        $("#addnotesmodal").modal("show");
    });

    $(document).on("click", ".editar", function (e) {
        e.preventDefault();

        let id = $(this).data("id");
        let estatus = $(this).data("estatus");

        $.ajax({
            type: "POST",
            url: "/admin/editNota",
            data: {
                id: id,
                estatus: estatus,
            },
            success: function (response) {
                $("#note-full-container").html(response);
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

    $(document).on("click", ".delete", function (e) {
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar nota</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar esta nota? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/deleteNota", { id: id }, function (response) {
                    $("#note-full-container").html(response);

                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Nota eliminada</h1>',
                        html: '<p style="font-family: Poppins">La nota se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La nota no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $("#formNota").on("submit", function (e) {
        e.preventDefault();
        $("#alertMessage").text("");
        $.ajax({
            type: "POST",
            url: "/admin/addNota",
            data: new FormData(this),
            // dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $("#addnotesmodal").modal("hide");
                $("#formNota")[0].reset();
                $("#note-full-container").html(response);
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Comentario agregado</h1>',
                    html: '<p style="font-family: Poppins">El comentario ha sido agregado correctamente</p>',
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
});
