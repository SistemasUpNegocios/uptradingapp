$(document).ready(function () {
    const datos = () => {
        $("#contenedorResumenOficina").empty();
        $("#contenedorResumenOficina").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-dark" role="status"></div>
                    <p class="text-dark">Cargando oficinas<span class="dotting"> </span></p>
                </div>
            `
        );

        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");

        $.ajax({
            type: "GET",
            data: { fecha_inicio: fecha, fecha_fin: fecha },
            url: "/admin/getResumenClienteOficina",
            success: function (response) {
                $("#contenedorResumenOficina").empty();
                $("#contenedorResumenOficina").html(
                    `
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="d-flex">
                                    <div class="horizontal-card-bg-img"></div>
                                    <div class="card-body">
                                        <h5 class="card-title">Foraneos</h5>
                                        <p class="card-text">Presiona el botón para generar un resumen.</p>
                                        <button class="btn btn-sm principal-button" id="foraneos">Crear resumen</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                );
                $("#contenedorResumenOficina").html(response);
            },
            error: function (response) {
                $("#contenedorResumenOficina").empty();
                $("#contenedorResumenOficina").html(
                    `
                        <div class="text-center">
                            <div class="spinner-border text-danger" role="status"></div>
                            <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                        </div>
                    `
                );
            },
        });
        $("#fechaInicioOficinaInput").val(fecha);
        $("#fechaFinOficinaInput").val(fecha);
    };

    datos();

    $(document).change("#fechaInicioOficinaInput", function () {
        $("#contenedorResumenOficina").empty();
        $("#contenedorResumenOficina").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-dark" role="status"></div>
                    <p class="text-dark">Cargando oficinas<span class="dotting"> </span></p>
                </div>
            `
        );

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
                    $("#contenedorResumenOficina").empty();
                    $("#contenedorResumenOficina").html(
                        `
                            <div class="text-center mt-4">
                                <div class="spinner-border text-danger" role="status"></div>
                                <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                            </div>
                        `
                    );
                },
            });
        } else {
            $("#contVacio").empty();
            $("#contenedorResumenOficina").empty();
            $("#contenedorResumenOficina").html(
                `
                    <div class="text-center mt-4">
                        <div class="spinner-border text-danger" role="status"></div>
                        <p class="text-danger">Ingresa una fecha válida<span class="dotting"> </span></p>
                    </div>
                `
            );
        }
    });

    $(document).change("#fechaFinOficinaInput", function () {
        $("#contenedorResumenOficina").empty();
        $("#contenedorResumenOficina").html(
            `
                <div class="text-center mt-4">
                    <div class="spinner-border text-dark" role="status"></div>
                    <p class="text-dark">Cargando oficinas<span class="dotting"> </span></p>
                </div>
            `
        );

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
                    $("#contenedorResumenOficina").empty();
                    $("#contenedorResumenOficina").html(
                        `
                            <div class="text-center mt-4">
                                <div class="spinner-border text-danger" role="status"></div>
                                <p class="text-danger">Ocurrio un problema<span class="dotting"> </span></p>
                            </div>
                        `
                    );
                },
            });
        } else {
            $("#contVacio").empty();
            $("#contenedorResumenOficina").empty();
            $("#contenedorResumenOficina").html(
                `
                    <div class="text-center mt-4">
                        <div class="spinner-border text-danger" role="status"></div>
                        <p class="text-danger">Ingresa una fecha válida<span class="dotting"> </span></p>
                    </div>
                `
            );
        }
    });

    $(document).on("click", "#foraneos", function () {
        let fecha_inicio = $("#fechaInicioOficinaInput").val();
        let fecha_fin = $("#fechaFinOficinaInput").val();

        window.open(
            `/admin/imprimirResumenClienteOficinaForanea?fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}`,
            "_blank"
        );
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
