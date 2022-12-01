$(document).ready(function () {
    $(document).change("#fechaInicioOficinaInput", function () {
        let fecha_inicio = $("#fechaInicioOficinaInput").val();
        let fecha_fin = $("#fechaFinOficinaInput").val();

        if (fecha_inicio.length > 0 && fecha_fin.length > 0) {
            $.ajax({
                type: "GET",
                data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                url: "/admin/getResumenClienteOficina",
                success: function (response) {
                    $("#contenedorResumenOficina").empty();
                    $("#contenedorResumenOficina").html(response);
                },
                error: function (response) {
                    console.log(response);
                },
            });
        } else {
            $("#contVacio").empty();
        }
    });

    $(document).change("#fechaFinOficinaInput", function () {
        let fecha_inicio = $("#fechaInicioOficinaInput").val();
        let fecha_fin = $("#fechaFinOficinaInput").val();

        if (fecha_inicio.length > 0 && fecha_fin.length > 0) {
            $.ajax({
                type: "GET",
                data: { fecha_inicio: fecha_inicio, fecha_fin: fecha_fin },
                url: "/admin/getResumenClienteOficina",
                success: function (response) {
                    $("#contenedorResumenOficina").empty();
                    $("#contenedorResumenOficina").html(response);
                },
                error: function (response) {
                    console.log(response);
                },
            });
        } else {
            $("#contVacio").empty();
        }
    });

    $(document).on("click", "#imprimirPagosClienteOficina", function () {
        let fecha_inicio = $("#fechaInicioOficinaInput").val();
        let fecha_fin = $("#fechaFinOficinaInput").val();
        let id = $(this).data("id");

        window.open(
            `/admin/imprimirResumenClienteOficina?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&oficina=${id}`,
            "_blank"
        );
    });
});
