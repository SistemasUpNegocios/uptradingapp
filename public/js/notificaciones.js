$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var id;

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

    //peticion para obtener las notificaciones del icono y mostrarlas
    $.get({
        url: "/admin/showNotificaciones",
        success: function (response) {
            eliminarNotificacion();
            if (response.notificaciones.length > 0) {
                var pusher = new Pusher("a92093d5906abb83873a", {
                    cluster: "us2",
                });

                var channel = pusher.subscribe("chat-channel");
                channel.bind("chat-event", function (data) {
                    let notif = data.message.split(": ");
                    let titulo = notif[0];
                    let mensaje = notif[1];

                    Push.create(titulo, {
                        body: mensaje,
                        icon: "../../img/usuarios/" + data.image,
                        timeout: 10000,
                        vibrate: [200, 100],
                        onClick: function () {
                            window.focus();
                            this.close();
                        },
                    });
                });

                var contNotif = `
                    <li class="dropdown-header">
                        <span id="numeroNotif"></span>
                        <a href="/admin/notificacion">
                            <span class="badge rounded-pill bg-primary p-2 ms-2">Ver todo</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                `;
                var i = 0;
                response.notificaciones.map(function (notificacion) {
                    id = notificacion.user_id;

                    contNotif += `
                            <div class="d-flex">
                                <div>
                                    <i class="bi bi-bell-fill pe-2 text-muted" style="font-size: 14px"></i>
                                </div>
                                <div>
                                    <p id="mensajeNotif">
                                        ${notificacion.mensaje}
                                    </p>
                                    <p id="fechaNotif">
                                        ${
                                            response.fecha[i][0].toUpperCase() +
                                            response.fecha[i].substring(1)
                                        }
                                    </p>
                                </div>
                            </div>
                `;
                    i++;
                });
                contNotif += `
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="/admin/notificacion">Ver todas las notificaciones</a>
                    </li>
                `;

                $("#contNotificaciones").append(contNotif);
                if (response.notificacionesCount == 1) {
                    $("#numeroNotif").text(
                        `Tienes ${response.notificacionesCount} notificacion nueva`
                    );
                } else {
                    $("#numeroNotif").text(
                        `Tienes ${response.notificacionesCount} notificaciones nuevas`
                    );
                }
                $("#numeroNotifBadge").text(response.notificacionesCount);
            } else {
                $("#contNotificaciones").empty();
                $("#contNotificaciones").append(`
                    <li class="dropdown-header">
                        <span id="numeroNotif">Tienes 0 notificaciones nuevas</span>
                        <a href="/admin/notificacion"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver todo</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="message-item">
                        <div class="text-center">
                            <p>No tienes ninguna notificaci??n pendiente</p>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer">
                        <a href="/admin/notificacion">Ver todas las notificaciones</a>
                    </li>
            `);
                $("#numeroNotifBadge").text(0);
            }
        },
        error: function (error) {
            console.log(error);
        },
    });

    //evento para eliminar en tiempo real las notificaciones
    const eliminarNotificacion = () => {
        $(".eliminarNotif").click(function (e) {
            e.preventDefault();
            var idNotif = $(this).data("id");
            $.post(
                "/admin/deleteNotificaciones",
                { id: idNotif },
                function (response) {
                    $("#contenedorNotificacion").empty();
                    var i = 0;
                    response.notificaciones.map(function (notificacion) {
                        $("#contenedorNotificacion").append(`
                            <div class="col-1 text-center"><i class="bi bi-chat-text-fill fs-1"></i></div>
                            <div class="col-6">
                                <span class="text-muted">
                                    ${notificacion.mensaje}
                                </span>
                            </div>
                            <div class="col-3 text-center">
                                <span class="text-muted">
                                    ${
                                        response.fecha[i][0].toUpperCase() +
                                        response.fecha[i].substring(1)
                                    }
                                </span>
                            </div>
                            <div class="col-2 text-center">
                                <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-muted">
                                        <i class="bi bi-three-dots"></i>
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item eliminarNotif" href="#" data-id="${
                                        notificacion.id
                                    }">Eliminar</a></li>
                                </ul>
                            </div>
                            <hr style="margin: 1.2rem auto; width: 97%">
                        `);
                        i++;
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Notificaci??n eliminada",
                    });

                    eliminarNotificacion();
                }
            );
        });
    };

    //evento para obtener en tiempo real las notificaciones del icono
    const notificaciones = () => {
        $.get({
            url: "/admin/showNotificaciones",
            success: function (response) {
                var contNotif = `
                        <li class="dropdown-header">
                            <span id="numeroNotif"></span>
                            <a href="/admin/notificacion">
                                <span class="badge rounded-pill bg-primary p-2 ms-2">Ver todo</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="message-item">
                            <div class="text-center">
                    `;
                var i = 0;
                response.notificaciones.map(function (notificacion) {
                    id = notificacion.user_id;

                    contNotif += `
                                <div class="d-flex mt-3">
                                    <div>
                                        <i class="bi bi-bell-fill pe-2 text-muted" style="font-size: 14px"></i>
                                    </div>
                                    <div>
                                        <p id="mensajeNotif">
                                            ${notificacion.mensaje}
                                        </p>
                                        <p id="fechaNotif">
                                            ${
                                                response.fecha[
                                                    i
                                                ][0].toUpperCase() +
                                                response.fecha[i].substring(1)
                                            }
                                    </div>
                                </div>
                    `;
                    i++;
                });
                contNotif += `
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer">
                            <a href="/admin/notificacion">Ver todas las notificaciones</a>
                        </li>
                    `;
                $("#contNotificaciones").empty();
                $("#contNotificaciones").append(contNotif);
                if (response.notificacionesCount == 1) {
                    $("#numeroNotif").text(
                        `Tienes ${response.notificacionesCount} notificacion nueva`
                    );
                } else {
                    $("#numeroNotif").text(
                        `Tienes ${response.notificacionesCount} notificaciones nuevas`
                    );
                }
                $("#numeroNotifBadge").text(response.notificacionesCount);
            },
            error: function (error) {
                console.log(error);
            },
        });
    };

    //Evento para editar las notificaciones
    $("#notificaciones").click(function () {
        $.get({
            data: { id: id, status: "Leida" },
            url: "/admin/editNotificaciones",
            success: function (response) {
                $("#numeroNotif").text("Tienes 0 notificaciones nuevas");
                $("#numeroNotifBadge").text(0);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    setInterval(notificaciones, 30000);
});
