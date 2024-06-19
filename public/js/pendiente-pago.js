$(document).ready(function () {
    const config = {
        search: true,
    };

    dselect(document.querySelector("#clienteIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    $("#clienteIdInput").change(function () {
        var id = $("#clienteIdInput").val();
        $("#data").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-dark" role="status"></div>
                    <p class="text-dark">Cargando información<span class="dotting"> </span></p>
                </div>
            `
        );
        $.ajax({
            type: "GET",
            data: {
                id: id,
            },
            url: "/admin/showPendientePago",
            success: function (response) {
                $("#data").html(response);
            },
            error: function (response) {
                $("#data").html(
                    `
                        <div class="text-center mt-4">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un error, comunicate con sistemas</p>
                        </div>
                    `
                );
            },
        });
    });

    $(document).on("click", "#generarVaciado", function () {
        let id = $(this).data("id");
        window.open(`/admin/generarExcel?id=${id}`);
    });
});
