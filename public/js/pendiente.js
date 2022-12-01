$(document).ready(function () {
    const config = {
        search: true,
    };
    dselect(document.querySelector("#psIdInput"), config);

    $(".dropdown-menu .form-control").attr("placeholder", "Buscar...");
    $(".dselect-no-results").text("No se encontraron resultados...");

    var acc = "";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //Cada verificación de casilla, se sube a la BD y actualiza su status correspondiente
    $("#formModal").on("submit", function (e) {
        e.preventDefault();
        var form = $("#pendienteForm")[0];
        var url = $("#pendienteForm").attr("action");

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(form),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $("#formModal").modal("hide");
                $("#pendienteForm")[0].reset();

                $.ajax({
                    type: "POST",
                    url: "/admin/generateList",
                    success: function (response) {
                        $("#contPendientes").empty();
                        $("#contPendientes").html(response);

                        if (acc == "new") {
                            Swal.fire({
                                icon: "success",
                                title: '<h1 style="font-family: Poppins; font-weight: 700;">Lista de pendientes añadida</h1>',
                                html: `<p style="font-family: Poppins">La lista ha sido añadida correctamente</p>`,
                                confirmButtonText:
                                    '<a style="font-family: Poppins">Aceptar</a>',
                                confirmButtonColor: "#01bbcc",
                            });
                        }
                    },
                });
            },
            error: function (data) {
                $("#nomError").show();

                $("#nomError").text(
                    "No es posible generar el checklist, este nombre de cliente ya está en uso"
                );
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#nomError").hide();
        $("#alertMessage").text("");
        acc = "new";

        $("#pendienteForm").attr("action", "/admin/addPendiente");
        $("#idInput").val("");

        $("#nombreInput").prop("readonly", false);

        $("#psIdInput").prop("disabled", false);

        $("#modalTitle").text("Añadir lista de pendientes");
        $("#btnSubmit").text("Añadir lista");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");
        var conf;

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar lista de pendientes</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar esta lista de pendientes? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post(
                    "/admin/deletePendiente",
                    { id: id },
                    function (response) {
                        $("#formModal").modal("hide");
                        $("#pendienteForm")[0].reset();

                        $.ajax({
                            type: "POST",
                            url: "/admin/generateList",
                            success: function (response) {
                                $("#contPendientes").empty();
                                $("#contPendientes").html(response);

                                Swal.fire({
                                    icon: "success",
                                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Lista de pendientes eliminada</h1>',
                                    html: '<p style="font-family: Poppins">La lista de pendientes se ha eliminado correctamente</p>',
                                    confirmButtonText:
                                        '<a style="font-family: Poppins">Aceptar</a>',
                                    confirmButtonColor: "#01bbcc",
                                });
                            },
                        });
                    }
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La lista de pendientes no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $(document).on("click", ".showLista", function (e) {
        e.preventDefault();

        var pendientes = $("#contPendientes");
        var id = $(this).data("id");

        $.ajax({
            type: "GET",
            url: "/admin/showPendientes",
            data: { id: id },
            success: function (response) {
                pendientes.empty();
                pendientes.append(response);

                $(".btn-volver").removeClass("d-none");
                $(".new").addClass("d-none");

                addChecked();
                editChecked();

                $("#memo_introduccionButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_introduccionButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_introduccion").addClass("d-none");
                        $("#memo_introduccionInput").removeClass("d-none");
                        $("#memo_introduccionButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_introduccion").removeClass("d-none");
                        $("#memo_introduccionInput").addClass("d-none");
                        $("#memo_introduccionButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_introduccionInput").val();
                        $("#p_memo_introduccion").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_intencionButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_intencionButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_intencion").addClass("d-none");
                        $("#memo_intencionInput").removeClass("d-none");
                        $("#memo_intencionButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_intencion").removeClass("d-none");
                        $("#memo_intencionInput").addClass("d-none");
                        $("#memo_intencionButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_intencionInput").val();
                        $("#p_memo_intencion").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_formularioButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_formularioButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_formulario").addClass("d-none");
                        $("#memo_formularioInput").removeClass("d-none");
                        $("#memo_formularioButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_formulario").removeClass("d-none");
                        $("#memo_formularioInput").addClass("d-none");
                        $("#memo_formularioButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_formularioInput").val();
                        $("#p_memo_formulario").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_videoconferenciaButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_videoconferenciaButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_videoconferencia").addClass("d-none");
                        $("#memo_videoconferenciaInput").removeClass("d-none");
                        $("#memo_videoconferenciaButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_videoconferencia").removeClass("d-none");
                        $("#memo_videoconferenciaInput").addClass("d-none");
                        $("#memo_videoconferenciaButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_videoconferenciaInput").val();
                        $("#p_memo_videoconferencia").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_aperturaButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_aperturaButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_apertura").addClass("d-none");
                        $("#memo_aperturaInput").removeClass("d-none");
                        $("#memo_aperturaButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_apertura").removeClass("d-none");
                        $("#memo_aperturaInput").addClass("d-none");
                        $("#memo_aperturaButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_aperturaInput").val();
                        $("#p_memo_apertura").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_instruccionesButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_instruccionesButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_instrucciones").addClass("d-none");
                        $("#memo_instruccionesInput").removeClass("d-none");
                        $("#memo_instruccionesButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_instrucciones").removeClass("d-none");
                        $("#memo_instruccionesInput").addClass("d-none");
                        $("#memo_instruccionesButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_instruccionesInput").val();
                        $("#p_memo_instrucciones").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_transferenciaButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_transferenciaButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_transferencia").addClass("d-none");
                        $("#memo_transferenciaInput").removeClass("d-none");
                        $("#memo_transferenciaButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_transferencia").removeClass("d-none");
                        $("#memo_transferenciaInput").addClass("d-none");
                        $("#memo_transferenciaButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_transferenciaInput").val();
                        $("#p_memo_transferencia").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_contratoButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_contratoButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_contrato").addClass("d-none");
                        $("#memo_contratoInput").removeClass("d-none");
                        $("#memo_contratoButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_contrato").removeClass("d-none");
                        $("#memo_contratoInput").addClass("d-none");
                        $("#memo_contratoButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_contratoInput").val();
                        $("#p_memo_contrato").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_mam_poolButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_mam_poolButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_mam_pool").addClass("d-none");
                        $("#memo_mam_poolInput").removeClass("d-none");
                        $("#memo_mam_poolButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_mam_pool").removeClass("d-none");
                        $("#memo_mam_poolInput").addClass("d-none");
                        $("#memo_mam_poolButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_mam_poolInput").val();
                        $("#p_memo_mam_pool").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_tarjeta_swissButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_tarjeta_swissButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_tarjeta_swiss").addClass("d-none");
                        $("#memo_tarjeta_swissInput").removeClass("d-none");
                        $("#memo_tarjeta_swissButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_tarjeta_swiss").removeClass("d-none");
                        $("#memo_tarjeta_swissInput").addClass("d-none");
                        $("#memo_tarjeta_swissButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_tarjeta_swissInput").val();
                        $("#p_memo_tarjeta_swiss").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_tarjeta_uptradingButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_tarjeta_uptradingButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_tarjeta_uptrading").addClass("d-none");
                        $("#memo_tarjeta_uptradingInput").removeClass("d-none");
                        $("#memo_tarjeta_uptradingButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_tarjeta_uptrading").removeClass("d-none");
                        $("#memo_tarjeta_uptradingInput").addClass("d-none");
                        $("#memo_tarjeta_uptradingButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $(
                            "#memo_tarjeta_uptradingInput"
                        ).val();
                        $("#p_memo_tarjeta_uptrading").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                $("#memo_primer_pagoButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_primer_pagoButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_primer_pago").addClass("d-none");
                        $("#memo_primer_pagoInput").removeClass("d-none");
                        $("#memo_primer_pagoButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_primer_pago").removeClass("d-none");
                        $("#memo_primer_pagoInput").addClass("d-none");
                        $("#memo_primer_pagoButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_primer_pagoInput").val();
                        $("#p_memo_primer_pago").text(valorInput);

                        //sube a la BD lo que hay en el input
                        var url = $("#listaForm").attr("action");
                        var form = $("#listaForm")[0];
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: new FormData(form),
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (result) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: "top-end",
                                    showConfirmButton: false,
                                    timer: 2000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener(
                                            "mouseenter",
                                            Swal.stopTimer
                                        );
                                        toast.addEventListener(
                                            "mouseleave",
                                            Swal.resumeTimer
                                        );
                                    },
                                });

                                Toast.fire({
                                    icon: "success",
                                    title: "Pendiente actualizado",
                                });
                            },
                        });
                    }
                });

                //Cada verificación de casilla, se sube a la BD y actualiza su status correspondiente
                $(".form-check-input").on("change", function (e) {
                    e.preventDefault();
                    var form = $("#listaForm")[0];
                    var url = $("#listaForm").attr("action");

                    $.ajax({
                        type: "POST",
                        url: url,
                        data: new FormData(form),
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (result) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "top-end",
                                showConfirmButton: false,
                                timer: 2000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener(
                                        "mouseenter",
                                        Swal.stopTimer
                                    );
                                    toast.addEventListener(
                                        "mouseleave",
                                        Swal.resumeTimer
                                    );
                                },
                            });

                            Toast.fire({
                                icon: "success",
                                title: "Pendiente actualizado",
                            });
                        },
                    });
                });
            },
        });
    });

    $(document).on("click", ".btn-volver", function (e) {
        e.preventDefault();

        var pendientes = $("#contPendientes");
        $.ajax({
            type: "GET",
            url: "/admin/showClientes",
            success: function (response) {
                $(".btn-volver").addClass("d-none");
                $(".new").removeClass("d-none");

                pendientes.empty();

                $.ajax({
                    type: "POST",
                    url: "/admin/generateList",
                    success: function (response) {
                        $("#contPendientes").empty();
                        $("#contPendientes").html(response);
                    },
                });
            },
        });
    });
});

//funcion para ponerle chequed si está "hecho" desde la BD
const addChecked = () => {
    var checkboxInputIntro = $("#checkboxInputIntro").val();
    if (checkboxInputIntro == "Hecho") {
        $("#checkboxInputIntro").prop("checked", true);
        $("#introduccion").removeClass("alert-danger");
        $("#introduccion").addClass("alert-success");
    } else {
        $("#checkboxInputIntro").prop("checked", false);
        $("#introduccion").addClass("alert-danger");
        $("#introduccion").removeClass("alert-success");
    }

    var checkboxInputInversion = $("#checkboxInputInversion").val();
    if (checkboxInputInversion == "Hecho") {
        $("#checkboxInputInversion").prop("checked", true);
        $("#intencion_inversion").removeClass("alert-danger");
        $("#intencion_inversion").addClass("alert-success");
    } else {
        $("#checkboxInputInversion").prop("checked", false);
        $("#intencion_inversion").addClass("alert-danger");
        $("#intencion_inversion").removeClass("alert-success");
    }

    var checkboxInputForm = $("#checkboxInputForm").val();
    if (checkboxInputForm == "Hecho") {
        $("#checkboxInputForm").prop("checked", true);
        $("#formulario").removeClass("alert-danger");
        $("#formulario").addClass("alert-success");
    } else {
        $("#checkboxInputForm").prop("checked", false);
        $("#formulario").addClass("alert-danger");
        $("#formulario").removeClass("alert-success");
    }

    var checkboxInputVideo = $("#checkboxInputVideo").val();
    if (checkboxInputVideo == "Hecho") {
        $("#checkboxInputVideo").prop("checked", true);
        $("#videoconferencia").removeClass("alert-danger");
        $("#videoconferencia").addClass("alert-success");
    } else {
        $("#checkboxInputVideo").prop("checked", false);
        $("#videoconferencia").addClass("alert-danger");
        $("#videoconferencia").removeClass("alert-success");
    }

    var checkboxInputApertura = $("#checkboxInputApertura").val();
    if (checkboxInputApertura == "Hecho") {
        $("#checkboxInputApertura").prop("checked", true);
        $("#apertura").removeClass("alert-danger");
        $("#apertura").addClass("alert-success");
    } else {
        $("#checkboxInputApertura").prop("checked", false);
        $("#apertura").addClass("alert-danger");
        $("#apertura").removeClass("alert-success");
    }

    var checkboxInputInstrucciones = $("#checkboxInputInstrucciones").val();
    if (checkboxInputInstrucciones == "Hecho") {
        $("#checkboxInputInstrucciones").prop("checked", true);
        $("#instrucciones_bancarias").removeClass("alert-danger");
        $("#instrucciones_bancarias").addClass("alert-success");
    } else {
        $("#checkboxInputInstrucciones").prop("checked", false);
        $("#instrucciones_bancarias").addClass("alert-danger");
        $("#instrucciones_bancarias").removeClass("alert-success");
    }

    var checkboxInputTrans = $("#checkboxInputTrans").val();
    if (checkboxInputTrans == "Hecho") {
        $("#checkboxInputTrans").prop("checked", true);
        $("#transferencia").removeClass("alert-danger");
        $("#transferencia").addClass("alert-success");
    } else {
        $("#checkboxInputTrans").prop("checked", false);
        $("#transferencia").addClass("alert-danger");
        $("#transferencia").removeClass("alert-success");
    }

    var checkboxInputContrato = $("#checkboxInputContrato").val();
    if (checkboxInputContrato == "Hecho") {
        $("#checkboxInputContrato").prop("checked", true);
        $("#contrato").removeClass("alert-danger");
        $("#contrato").addClass("alert-success");
    } else {
        $("#checkboxInputContrato").prop("checked", false);
        $("#contrato").addClass("alert-danger");
        $("#contrato").removeClass("alert-success");
    }

    var checkboxInputConectar = $("#checkboxInputConectar").val();
    if (checkboxInputConectar == "Hecho") {
        $("#checkboxInputConectar").prop("checked", true);
        $("#conectar_mam_pool").removeClass("alert-danger");
        $("#conectar_mam_pool").addClass("alert-success");
    } else {
        $("#checkboxInputConectar").prop("checked", false);
        $("#conectar_mam_pool").addClass("alert-danger");
        $("#conectar_mam_pool").removeClass("alert-success");
    }

    var checkboxInputTarjetaSwiss = $("#checkboxInputTarjetaSwiss").val();
    if (checkboxInputTarjetaSwiss == "Hecho") {
        $("#checkboxInputTarjetaSwiss").prop("checked", true);
        $("#tarjetaSwiss").removeClass("alert-danger");
        $("#tarjetaSwiss").addClass("alert-success");
    } else {
        $("#checkboxInputTarjetaSwiss").prop("checked", false);
        $("#tarjetaSwiss").addClass("alert-danger");
        $("#tarjetaSwiss").removeClass("alert-success");
    }

    var checkboxInputTarjetaUp = $("#checkboxInputTarjetaUp").val();
    if (checkboxInputTarjetaUp == "Hecho") {
        $("#checkboxInputTarjetaUp").prop("checked", true);
        $("#tarjetaUp").removeClass("alert-danger");
        $("#tarjetaUp").addClass("alert-success");
    } else {
        $("#checkboxInputTarjetaUp").prop("checked", false);
        $("#tarjetaUp").addClass("alert-danger");
        $("#tarjetaUp").removeClass("alert-success");
    }

    var checkboxInputPago = $("#checkboxInputPago").val();
    if (checkboxInputPago == "Hecho") {
        $("#checkboxInputPago").prop("checked", true);
        $("#1erPago").removeClass("alert-danger");
        $("#1erPago").addClass("alert-success");
    } else {
        $("#checkboxInputPago").prop("checked", false);
        $("#1erPago").addClass("alert-danger");
        $("#1erPago").removeClass("alert-success");
    }
};

//funcion para cambiar clase de la alerta con el evento onchage
const editChecked = () => {
    $("#checkboxInputIntro").change(function () {
        var checkboxInputIntro = $("#checkboxInputIntro").is(":checked");

        if (checkboxInputIntro) {
            $("#introduccion").removeClass("alert-danger");
            $("#introduccion").addClass("alert-success");
            $("#checkboxInputIntro").val("Hecho");
        } else {
            $("#introduccion").addClass("alert-danger");
            $("#introduccion").removeClass("alert-success");
            $("#checkboxInputIntro").val("Pendiente");
        }
    });

    $("#checkboxInputInversion").change(function () {
        var checkboxInputInversion = $("#checkboxInputInversion").is(
            ":checked"
        );

        if (checkboxInputInversion) {
            $("#intencion_inversion").removeClass("alert-danger");
            $("#intencion_inversion").addClass("alert-success");
            $("#checkboxInputInversion").val("Hecho");
        } else {
            $("#intencion_inversion").addClass("alert-danger");
            $("#intencion_inversion").removeClass("alert-success");
            $("#checkboxInputInversion").val("Pendiente");
        }
    });

    $("#checkboxInputForm").change(function () {
        var checkboxInputForm = $("#checkboxInputForm").is(":checked");

        if (checkboxInputForm) {
            $("#formulario").removeClass("alert-danger");
            $("#formulario").addClass("alert-success");
            $("#checkboxInputForm").val("Hecho");
        } else {
            $("#formulario").addClass("alert-danger");
            $("#formulario").removeClass("alert-success");
            $("#checkboxInputForm").val("Pendiente");
        }
    });

    $("#checkboxInputVideo").change(function () {
        var checkboxInputVideo = $("#checkboxInputVideo").is(":checked");

        if (checkboxInputVideo) {
            $("#videoconferencia").removeClass("alert-danger");
            $("#videoconferencia").addClass("alert-success");
            $("#checkboxInputVideo").val("Hecho");
        } else {
            $("#videoconferencia").addClass("alert-danger");
            $("#videoconferencia").removeClass("alert-success");
            $("#checkboxInputVideo").val("Pendiente");
        }
    });

    $("#checkboxInputApertura").change(function () {
        var checkboxInputApertura = $("#checkboxInputApertura").is(":checked");

        if (checkboxInputApertura) {
            $("#apertura").removeClass("alert-danger");
            $("#apertura").addClass("alert-success");
            $("#checkboxInputApertura").val("Hecho");
        } else {
            $("#apertura").addClass("alert-danger");
            $("#apertura").removeClass("alert-success");
            $("#checkboxInputApertura").val("Pendiente");
        }
    });

    $("#checkboxInputInstrucciones").change(function () {
        var checkboxInputInstrucciones = $("#checkboxInputInstrucciones").is(
            ":checked"
        );

        if (checkboxInputInstrucciones) {
            $("#instrucciones_bancarias").removeClass("alert-danger");
            $("#instrucciones_bancarias").addClass("alert-success");
            $("#checkboxInputInstrucciones").val("Hecho");
        } else {
            $("#instrucciones_bancarias").addClass("alert-danger");
            $("#instrucciones_bancarias").removeClass("alert-success");
            $("#checkboxInputInstrucciones").val("Pendiente");
        }
    });

    $("#checkboxInputTrans").change(function () {
        var checkboxInputTrans = $("#checkboxInputTrans").is(":checked");

        if (checkboxInputTrans) {
            $("#transferencia").removeClass("alert-danger");
            $("#transferencia").addClass("alert-success");
            $("#checkboxInputTrans").val("Hecho");
        } else {
            $("#transferencia").addClass("alert-danger");
            $("#transferencia").removeClass("alert-success");
            $("#checkboxInputTrans").val("Pendiente");
        }
    });

    $("#checkboxInputContrato").change(function () {
        var checkboxInputContrato = $("#checkboxInputContrato").is(":checked");

        if (checkboxInputContrato) {
            $("#contrato").removeClass("alert-danger");
            $("#contrato").addClass("alert-success");
            $("#checkboxInputContrato").val("Hecho");
        } else {
            $("#contrato").addClass("alert-danger");
            $("#contrato").removeClass("alert-success");
            $("#checkboxInputContrato").val("Pendiente");
        }
    });

    $("#checkboxInputConectar").change(function () {
        var checkboxInputConectar = $("#checkboxInputConectar").is(":checked");

        if (checkboxInputConectar) {
            $("#conectar_mam_pool").removeClass("alert-danger");
            $("#conectar_mam_pool").addClass("alert-success");
            $("#checkboxInputConectar").val("Hecho");
        } else {
            $("#conectar_mam_pool").addClass("alert-danger");
            $("#conectar_mam_pool").removeClass("alert-success");
            $("#checkboxInputConectar").val("Pendiente");
        }
    });

    $("#checkboxInputTarjetaSwiss").change(function () {
        var checkboxInputTarjetaSwiss = $("#checkboxInputTarjetaSwiss").is(
            ":checked"
        );

        if (checkboxInputTarjetaSwiss) {
            $("#tarjetaSwiss").removeClass("alert-danger");
            $("#tarjetaSwiss").addClass("alert-success");
            $("#checkboxInputTarjetaSwiss").val("Hecho");
        } else {
            $("#tarjetaSwiss").addClass("alert-danger");
            $("#tarjetaSwiss").removeClass("alert-success");
            $("#checkboxInputTarjetaSwiss").val("Pendiente");
        }
    });

    $("#checkboxInputTarjetaUp").change(function () {
        var checkboxInputTarjetaUp = $("#checkboxInputTarjetaUp").is(
            ":checked"
        );

        if (checkboxInputTarjetaUp) {
            $("#tarjetaUp").removeClass("alert-danger");
            $("#tarjetaUp").addClass("alert-success");
            $("#checkboxInputTarjetaUp").val("Hecho");
        } else {
            $("#tarjetaUp").addClass("alert-danger");
            $("#tarjetaUp").removeClass("alert-success");
            $("#checkboxInputTarjetaUp").val("Pendiente");
        }
    });

    $("#checkboxInputPago").change(function () {
        var checkboxInputPago = $("#checkboxInputPago").is(":checked");

        if (checkboxInputPago) {
            $("#1erPago").removeClass("alert-danger");
            $("#1erPago").addClass("alert-success");
            $("#checkboxInputPago").val("Hecho");
        } else {
            $("#1erPago").addClass("alert-danger");
            $("#1erPago").removeClass("alert-success");
            $("#checkboxInputPago").val("Pendiente");
        }
    });
};
