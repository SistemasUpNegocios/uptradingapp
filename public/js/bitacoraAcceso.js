$(document).ready(function () {
    $(".verDetalles").click(function () {
        var id = $(this).data("id");

        $.get({
            url: "/admin/getDetallesBitacora",
            data: {
                id: id
            },
            success: function (res) {
                var fecha_actual = new Date();
                var fecha_salida = new Date(res[0].fecha_salida);

                $("#ip").text(res[0].direccion_ip);
                $("#fe").text(res[0].fecha_entrada);

                if (fecha_actual >= fecha_salida) {
                    $("#fs").text(res[0].fecha_salida);
                } else {
                    $("#fs").html(`<span class="badge bg-success">Sesión aún activa</span>`);
                }
        
                $("#td").text(res[0].dispositivo);
                $("#so").text(res[0].sistema_operativo);
                $("#br").text(res[0].navegador);

                $("#collapseBtn").html(`Desplegar información del usuario &nbsp;<b>${res[0].user_nombre} ${res[0].user_apellidop} ${res[0].user_apellidom}</b>`)
                $("#no").text(res[0].user_nombre);
                $("#ap").text(res[0].user_apellidop);
                $("#am").text(res[0].user_apellidom);
                $("#ce").text(res[0].user_correo);
                $("#pr").text(res[0].user_privilegio);
                $("#imgPerfil").attr("src", `../img/usuarios/${res[0].user_fotoperfil}`);
            },
        });
    });
});
