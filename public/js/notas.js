$(document).ready(function () {
    $("body").addClass("ocultar_scroll");

    let id = 0;
    let titulo = "";

    //Abrir modal para ver la nota completa
    $(document).on("click", ".card_nota, .boton_archivado", function (e) {
        e.preventDefault();

        let drop_img_asignar = e.target.classList.contains("drop_img_asignar");
        let dropdown_item = e.target.classList.contains("dropdown-item");
        let imagen_asignado = e.target.classList.contains("imagen_asignado");
        let nombre_asignado = e.target.classList.contains("nombre_asignado");
        let imagen_sin_asignar =
            e.target.classList.contains("imagen_sin_asignar");
        let nombre_sin_asignar =
            e.target.classList.contains("nombre_sin_asignar");
        let icono_sin_asignar =
            e.target.classList.contains("icono_sin_asignar");

        if (
            !drop_img_asignar &&
            !dropdown_item &&
            !imagen_asignado &&
            !nombre_asignado &&
            !imagen_sin_asignar &&
            !nombre_sin_asignar &&
            !icono_sin_asignar
        ) {
            $("#cardModal").modal("show");
        }

        $(".modal_cont_archivada").addClass("d-none");
        $(".modal_cont_archivada_filtros").addClass("d-none");

        //recuperación de datos
        id = $(this).data("id");
        titulo = $(this).data("titulo");
        let descripcion = $(this).data("descripcion");
        let estatus = $(this).data("estatus");
        let fecha_creacion = $(this).data("fecha_creacion");
        let fecha_actualizacion = $(this).data("fecha_actualizacion");
        let fecha_terminacion = $(this).data("fecha_actualizacion");
        let nombre = $(this).data("nombre");
        let foto_perfil = $(this).data("foto_perfil");
        let fecha_limite = $(this).data("fecha_limite");
        let historial = $(this).data("historial");
        let tiempo_tardado = moment(fecha_creacion).fromNow();
        let asignado_a = $(this).data("asignado_a");
        let contribucion = $(this).data("contribucion");
        let contribucion_texto = "";

        //formato de datos y fechas
        tiempo_tardado = tiempo_tardado.substring(5, tiempo_tardado.length);
        fecha_creacion = moment(fecha_creacion).format("lll");
        fecha_actualizacion = moment(fecha_actualizacion).format("lll");
        fecha_terminacion = `el ${moment(fecha_terminacion).format("LLL")}`;
        let fecha_limite_texto = `El límite es ${moment(fecha_limite).format(
            "lll"
        )} hrs.`;
        foto_perfil = `../img/usuarios/${foto_perfil}`;
        nombre = nombre.toLowerCase();
        nombre = nombre.charAt(0).toUpperCase() + nombre.slice(1);
        historial = historial.split(",");
        historial = historial.reverse();
        contribucion = contribucion.split(",");
        let contribucion_cantidad = contribucion.length / 2;

        //condicionales y ciclos para mostrar elementos
        if (descripcion == "") {
            descripcion = "Haz clic para añadir una descripción...";
        }

        if (estatus == "Terminada") {
            $(".modal_cont_terminada").removeClass("d-none");
            $(".modal_cont_terminada_filtros").removeClass("d-none");

            $(".col_terminada_tiempo").removeClass("d-none");
            $(".col_terminada_contribuir").removeClass("d-none");

            $(".modal_cont_asignado").addClass("d-none");
            $(".modal_cont_asignado_filtros").addClass("d-none");
        } else {
            $(".modal_cont_terminada").addClass("d-none");
            $(".modal_cont_terminada_filtros").addClass("d-none");

            $(".col_terminada_tiempo").addClass("d-none");
            $(".col_terminada_contribuir").addClass("d-none");

            $(".modal_cont_asignado").removeClass("d-none");
            $(".modal_cont_asignado_filtros").removeClass("d-none");
        }

        if (fecha_limite == "") {
            $(".fecha-limite label span").text("Fecha Límite");
            $(".fecha-limite").removeClass("fecha_limite_pasada");
        } else {
            let fechaActual = moment();
            let fechaSeleccionada = moment(fecha_limite);

            if (fechaSeleccionada.isBefore(fechaActual)) {
                $(".fecha-limite").addClass("fecha_limite_pasada");
            } else {
                $(".fecha-limite").removeClass("fecha_limite_pasada");
            }
            $(".fecha-limite label span").text(fecha_limite_texto);
        }

        if (contribucion_cantidad == 1) {
            contribucion_texto = "1 persona contribuyó";
        } else {
            contribucion_texto = `${contribucion_cantidad} personas contribuyeron`;
        }

        $("#modal_historial").empty();
        let persona_term = "";
        for (let i = 0; i < historial.length; i += 2) {
            let icono = "";
            let div_icono = "";
            let fecha = historial[i];
            let accion = historial[i + 1];
            let persona = accion.substring(0, accion.indexOf(" "));

            if ("Ana" == persona) {
                persona = "Ana Karen";
                accion = accion.replace(
                    "Ana karen",
                    "<b class='accion_b'>Ana Karen</b>"
                );
            } else {
                accion = accion.replace(
                    persona,
                    `<b class='accion_b'>${persona}</b>`
                );
            }

            if (accion.indexOf("creó") != -1) {
                icono = "bi bi-plus-lg";
                div_icono = "div_historial_icono_crear";
            } else if (accion.indexOf("editó") != -1) {
                icono = "bi bi-pencil-fill";
                div_icono = "div_historial_icono_editar";
            } else if (accion.indexOf("terminó") != -1) {
                icono = "bi bi-check-lg";
                div_icono = "div_historial_icono_terminar";

                if (persona_term == "") {
                    persona_term = persona;
                }
                $("#modal_terminada_por").text(persona_term);
            } else if (accion.indexOf("movió") != -1) {
                icono = "bi bi-arrows-move";
                div_icono = "div_historial_icono_mover";
            } else if (accion.indexOf("archivó") != -1) {
                icono = "bi bi-archive-fill";
                div_icono = "div_historial_icono_archivar";
            } else if (
                accion.indexOf("estableció") != -1 ||
                accion.indexOf("cambió") != -1 ||
                accion.indexOf("retiró") != -1
            ) {
                icono = "bi bi-calendar-minus";
                div_icono = "div_historial_icono_fecha";
            } else if (accion.indexOf("→") != -1) {
                icono = "bi bi-arrow-right";
                div_icono = "div_historial_icono_asignar";
            } else if (accion.indexOf("desasignó") != -1) {
                icono = "bi bi-arrow-left";
                div_icono = "div_historial_icono_asignar";
            }

            $("#modal_historial").append(
                `
                    <div class="div_historial">
                        <div class="div_historial_icono ${div_icono}">
                            <i class="${icono}"></i>
                        </div>
                        <div>
                            <p>${fecha}</p>
                            <p>${accion}</p>
                        </div>
                    </div>
                `
            );
        }

        $("#imagenes_contribucion").empty();
        for (let i = 0; i < contribucion.length; i += 2) {
            const img = contribucion[i];
            const nombre = contribucion[i + 1];

            $("#imagenes_contribucion").append(
                `
                    <img src="../img/usuarios/${img}" alt="Foto contribuyó" title="${nombre}">
                `
            );
        }

        //peticiones
        $.ajax({
            type: "GET",
            url: "/admin/notas/obtenerUsuariosAsignados",
            data: {
                id: asignado_a,
            },
            success: function (response) {
                if (response.usuario_asignado.length > 0) {
                    for (const usuario of response.usuario_asignado) {
                        let nombre = usuario.nombre.toLowerCase();
                        nombre = nombre
                            .split(" ")
                            .map(
                                (word) =>
                                    word.charAt(0).toUpperCase() + word.slice(1)
                            )
                            .join(" ");

                        $(".texto_asignado").text("Asignar a");
                        $(".modal_asignado_a span").text(nombre);
                        $(".div_asignado_a .img_asignado").attr(
                            "src",
                            `../img/usuarios/${usuario.foto_perfil}`
                        );

                        $(".hr_modal_asignado").removeClass("d-none");
                        $(".modal_asignado_a_1").removeClass("d-none");
                        $(".modal_asignado_a_1 span").text(nombre);
                        $(".modal_asignado_a_1 img").attr(
                            "src",
                            `../img/usuarios/${usuario.foto_perfil}`
                        );
                    }
                } else {
                    $(".texto_asignado").text("");
                    $(".modal_asignado_a span").text("Sin asignar");
                    $(".div_asignado_a .img_asignado").attr(
                        "src",
                        "../img/signo.png"
                    );

                    $(".hr_modal_asignado").addClass("d-none");
                    $(".modal_asignado_a_1").addClass("d-none");
                    $(".modal_asignado_a_1 span").text();
                    $(".modal_asignado_a_1 img").attr(
                        "src",
                        "../img/signo.png"
                    );
                }

                $(".contenedor_usuarios_asignados").empty();
                if (response.usuarios_a_asignar.length > 0) {
                    for (const usuario of response.usuarios_a_asignar) {
                        let nombre = usuario.nombre.toLowerCase();
                        nombre = nombre
                            .split(" ")
                            .map(
                                (word) =>
                                    word.charAt(0).toUpperCase() + word.slice(1)
                            )
                            .join(" ");

                        $(".contenedor_usuarios_asignados").append(`
                            <li class="dropdown-item modal_asignado_a_2" data-id="${usuario.id}">
                                <img src="../img/usuarios/${usuario.foto_perfil}" alt="Foto de ${nombre}" class="me-1 imagen_asignado">
                                <span class="nombre_asignado">${nombre}</span>
                            </li>
                        `);
                    }
                } else {
                    $(".hr_modal_asignado").addClass("d-none");
                }
            },
            error: function () {
                console.error("Error");
            },
        });

        //Llenado de datos del modal si ya está terminada
        $("#modal_terminada").text(fecha_terminacion);
        $("#modal_archivada").text(fecha_terminacion);
        $("#cantidad_contribucion").text(contribucion_texto);

        //Llenado de datos del modal en general
        $("#modal_titulo").text(titulo);
        $("#modal_descripcion").text(descripcion);
        $("#modal_user").text(nombre.toUpperCase());
        $("#modal_estatus").text(`Tarea: ${estatus}`);
        $("#modal_fecha_creacion").text(`${fecha_creacion} hrs.`);
        $("#modal_fecha_actualizacion").text(`${fecha_actualizacion} hrs.`);
        $("#tiempo_en_terminar").text(tiempo_tardado);
    });

    //Crear nueva nota con estatus abierta
    $(document).on(
        "blur click",
        "#titulo_abiertas_nuevo, .nota_nueva_abierta i",
        function (e) {
            e.preventDefault();

            if (e.type == "click") {
                $("#card_nota_nueva_abierta").removeClass("d-none");
                $("#titulo_abiertas_nuevo").focus();
            } else if (e.type == "focusout") {
                let titulo_nuevo = $("#titulo_abiertas_nuevo").text();
                if (titulo_nuevo == "") {
                    $("#card_nota_nueva_abierta").addClass("d-none");
                } else {
                    $.ajax({
                        type: "GET",
                        url: "/admin/notas/addNota",
                        data: {
                            titulo: titulo_nuevo,
                            estatus: "Abierta",
                        },
                        success: function (response) {
                            $("#row_nota_completa").html(response);
                            inicializarSortable();
                        },
                        error: function () {
                            console.error("Error");
                        },
                    });
                }
            }
        }
    );

    //Crear nueva nota con estatus en progreso
    $(document).on(
        "blur click",
        "#titulo_progreso_nuevo, .nota_nueva_progreso i",
        function (e) {
            e.preventDefault();

            if (e.type == "click") {
                $("#card_nota_nueva_progreso").removeClass("d-none");
                $("#titulo_progreso_nuevo").focus();
            } else if (e.type == "focusout") {
                let titulo_nuevo = $("#titulo_progreso_nuevo").text();
                if (titulo_nuevo == "") {
                    $("#card_nota_nueva_progreso").addClass("d-none");
                } else {
                    $.ajax({
                        type: "GET",
                        url: "/admin/notas/addNota",
                        data: {
                            titulo: titulo_nuevo,
                            estatus: "En progreso",
                        },
                        success: function (response) {
                            $("#row_nota_completa").html(response);
                            inicializarSortable();
                        },
                        error: function () {
                            console.error("Error");
                        },
                    });
                }
            }
        }
    );

    //Editar titulo de la nota
    $(document).on("blur", "#modal_titulo", function (e) {
        e.preventDefault();

        let modal_titulo = $(this).text();
        if (modal_titulo != "" && modal_titulo != titulo) {
            titulo = modal_titulo;
            $.ajax({
                type: "GET",
                url: "/admin/notas/editNota",
                data: {
                    id,
                    titulo,
                    campo: "titulo",
                },
                success: function (response) {
                    $("#row_nota_completa").html(response);
                    inicializarSortable();
                },
                error: function () {
                    console.error("Error");
                },
            });
        } else {
            $(this).text(titulo);
        }
    });

    //Editar parrafo de la nota
    $(document).on("blur click", "#modal_descripcion", function (e) {
        e.preventDefault();

        let descripcion = $(this).text();
        if (e.type == "click") {
            if (descripcion == "Haz clic para añadir una descripción...") {
                $(this).text("");
            }
        } else if (e.type == "focusout") {
            $.ajax({
                type: "GET",
                url: "/admin/notas/editNota",
                data: {
                    id,
                    descripcion,
                    campo: "descripción",
                },
                success: function (response) {
                    $("#row_nota_completa").html(response);
                    inicializarSortable();
                },
                error: function () {
                    console.error("Error");
                },
            });

            if (descripcion == "") {
                $(this).text("Haz clic para añadir una descripción...");
            }
        }
    });

    //Finalizar nota
    $(document).on("click", ".modal_finalizar", function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                estatus: "Terminada",
                campo: "estatus",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                $("#cardModal").modal("hide");
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Archivar nota
    $(document).on("click", ".modal_archivar", function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                archivada: "si",
                campo: "archivada",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                $("#cardModal").modal("hide");
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Ver notas archivadas
    $(document).on("click", ".boton_archivado", function (e) {
        $("#cardModalArchivadas").modal("hide");
        $(".modal_cont_terminada").addClass("d-none");
        $(".modal_cont_asignado").addClass("d-none");
        $(".modal_cont_terminada_filtros ").addClass("d-none");
        $(".modal_cont_asignado_filtros").addClass("d-none");
        $(".modal_cont_archivada").removeClass("d-none");
        $(".modal_cont_archivada_filtros").removeClass("d-none");

        let historial = $(this).data("historial");
        historial = historial.split(",");
        historial = historial.reverse();

        for (let i = 0; i < historial.length; i += 2) {
            const accion = historial[i + 1];

            if (accion.indexOf("archivó") != -1) {
                let nombre = accion.substring(0, accion.indexOf("archivó"));
                $("#modal_archivado_por").text(nombre);
            }
        }
    });

    //Restaurar nota
    $(document).on("click", ".modal_restaurar", function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                estatus: "En progreso",
                campo: "estatus",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                $("#cardModal").modal("hide");
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Eliminar nota
    $(document).on("click", ".modal_eliminar", function (e) {
        e.preventDefault();

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar nota</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar la nota? Esta opción no se puede deshacer.</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#dc3545",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#757575",
        }).then((result) => {
            if (result.value) {
                $.post("/admin/notas/deleteNota", { id: id }, function (data) {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Nota eliminada</h1>',
                        html: '<p style="font-family: Poppins">La nota se ha eliminado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });

                    $("#row_nota_completa").html(data);
                    $("#cardModal").modal("hide");
                    inicializarSortable();
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

    //Asignar nota
    $(document).on("click", ".modal_asignado_a_2", function (e) {
        e.preventDefault();

        let asignado_a = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                asignado_a,
                campo: "asignar a",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                $("#cardModal").modal("hide");
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Desasignar nota
    $(document).on("click", ".modal_asignado_a_1", function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                campo: "desasignar",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                $("#cardModal").modal("hide");
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Activar o desactivar el scroll de la tarjeta dependiendo si hay contenido o no
    $(document).on("mouseover", ".col_card", function () {
        var scrollHeight = $(this).prop("scrollHeight");
        var clientHeight = $(this).height();

        if (scrollHeight > clientHeight) {
            $(this).removeClass("sin_scroll");
        } else {
            $(this).addClass("sin_scroll");
        }
    });

    //Mostrar imagen de "sin asignar" al hacer hacer click en la etiqueta img
    $(document).on("click", ".img_signo_sin", function () {
        $(this).toggleClass("d-none");
    });

    //Seleccionar fecha límite
    const fechaLimite = () => {
        flatpickr("#fechaLimite", {
            enableTime: true,
            time_24hr: true,
            dateFormat: "Y-m-d H:i",
            clickOpens: true,
            locale: "es",
            theme: "material_blue",
            allowInput: true,
            onClose: function (selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    let fechaActual = moment();
                    let fechaSeleccionada = moment(
                        selectedDates[0],
                        "DD-MM-YYYY HH:mm"
                    );

                    if (!fechaSeleccionada.isAfter(fechaActual, "minute")) {
                        $(".fecha-limite").addClass("fecha_limite_pasada");
                    } else {
                        $(".fecha-limite").removeClass("fecha_limite_pasada");
                    }

                    let fecha = `El límite es ${fechaSeleccionada.format(
                        "lll"
                    )} hrs.`;
                    $(".fecha-limite label span").text(fecha);

                    $.ajax({
                        type: "GET",
                        url: "/admin/notas/editNota",
                        data: {
                            id,
                            fecha_limite:
                                fechaSeleccionada.format("YYYY-MM-DD HH:mm"),
                            campo: "fecha limite",
                        },
                        success: function (response) {
                            $("#row_nota_completa").html(response);
                            inicializarSortable();
                        },
                        error: function () {
                            console.error("Error");
                        },
                    });
                }
            },
        });

        $(".flatpickr-calendar").append(
            '<button id="limpiarFecha" class="btn btn-outline-danger btn-sm mt-1 mb-1">Limpiar</button>'
        );
    };
    fechaLimite();

    // Limpiar fecha
    $(document).on("click", "#limpiarFecha", function () {
        flatpickr("#fechaLimite").clear();
        $(".fecha-limite").removeClass("fecha_limite_pasada");
        $(".fecha-limite label span").text("Fecha Límite");
        fechaLimite();

        $.ajax({
            type: "GET",
            url: "/admin/notas/editNota",
            data: {
                id,
                fecha_limite: "",
                campo: "fecha limite",
            },
            success: function (response) {
                $("#row_nota_completa").html(response);
                inicializarSortable();
            },
            error: function () {
                console.error("Error");
            },
        });
    });

    //Editar estatus de la nota arrastrando la tarjeta
    const inicializarSortable = () => {
        $("#col_abiertas, #col_progreso, #col_terminada")
            .sortable({
                connectWith: ".col_card",
                stop: function (event, ui) {
                    const id_nota = ui.item.data("id");
                    const estatus = ui.item
                        .closest(".col_card")
                        .data("columna");
                    const posicion = ui.item.index() + 1;
                    const columna = ui.item.closest(".columna_nota").data("id");

                    // $.ajax({
                    //     type: "GET",
                    //     url: "/admin/notas/editNota",
                    //     data: {
                    //         id: id_nota,
                    //         estatus: estatus,
                    //         campo: "estatus",
                    //         // arrastre: "si",
                    //     },
                    //     success: function (response) {
                    //         $("#row_nota_completa").html(response);
                    //         inicializarSortable();
                    //     },
                    //     error: function () {
                    //         console.error("Error");
                    //     },
                    // });
                },
            })
            .disableSelection();
    };
    inicializarSortable();
});
