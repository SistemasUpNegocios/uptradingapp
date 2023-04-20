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

                $("#memo_lpoaButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_lpoaButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_lpoa").addClass("d-none");
                        $("#memo_lpoaInput").removeClass("d-none");
                        $("#memo_lpoaButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_lpoa").removeClass("d-none");
                        $("#memo_lpoaInput").addClass("d-none");
                        $("#memo_lpoaButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_lpoaInput").val();
                        $("#p_memo_lpoa").text(valorInput);

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

                $("#memo_generar_convenioButton").click(function (e) {
                    e.preventDefault();
                    var textoButton = $("#memo_generar_convenioButton").text();

                    if (textoButton == "Editar") {
                        //Si al darle click al boton, tiene la palabra "EDITAR", oculta el parrafo y muestra un input
                        $("#p_memo_generar_convenio").addClass("d-none");
                        $("#memo_generar_convenioInput").removeClass("d-none");
                        $("#memo_generar_convenioButton").text("Aplicar");
                    } else if (textoButton == "Aplicar") {
                        //Si al darle click al boton, tiene la palabra "APLICAR", oculta el input y muestra el parrafo
                        $("#p_memo_generar_convenio").removeClass("d-none");
                        $("#memo_generar_convenioInput").addClass("d-none");
                        $("#memo_generar_convenioButton").text("Editar");

                        //guarda el texto del input en el parrafo
                        var valorInput = $("#memo_generar_convenioInput").val();
                        $("#p_memo_generar_convenio").text(valorInput);

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

    var checkboxInputCliente = $("#checkboxInputCliente").val();
    if (checkboxInputCliente == "Hecho") {
        $("#checkboxInputCliente").prop("checked", true);
        $("#altaCliente").removeClass("alert-danger");
        $("#altaCliente").addClass("alert-success");
    } else {
        $("#checkboxInputCliente").prop("checked", false);
        $("#altaCliente").addClass("alert-danger");
        $("#altaCliente").removeClass("alert-success");
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

    var checkboxInputLPOA = $("#checkboxInputLPOA").val();
    if (checkboxInputLPOA == "Hecho") {
        $("#checkboxInputLPOA").prop("checked", true);
        $("#lpoa").removeClass("alert-danger");
        $("#lpoa").addClass("alert-success");
    } else {
        $("#checkboxInputLPOA").prop("checked", false);
        $("#lpoa").addClass("alert-danger");
        $("#lpoa").removeClass("alert-success");
    }

    var checkboxInputInstruccionesMAM = $(
        "#checkboxInputInstruccionesMAM"
    ).val();
    if (checkboxInputInstruccionesMAM == "Hecho") {
        $("#checkboxInputInstruccionesMAM").prop("checked", true);
        $("#instrucciones_bancarias_mam").removeClass("alert-danger");
        $("#instrucciones_bancarias_mam").addClass("alert-success");
    } else {
        $("#checkboxInputInstruccionesMAM").prop("checked", false);
        $("#instrucciones_bancarias_mam").addClass("alert-danger");
        $("#instrucciones_bancarias_mam").removeClass("alert-success");
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

    var checkboxInputConvenio = $("#checkboxInputConvenio").val();
    if (checkboxInputConvenio == "Hecho") {
        $("#checkboxInputConvenio").prop("checked", true);
        $("#convenio").removeClass("alert-danger");
        $("#convenio").addClass("alert-success");
    } else {
        $("#checkboxInputConvenio").prop("checked", false);
        $("#convenio").addClass("alert-danger");
        $("#convenio").removeClass("alert-success");
    }

    var checkboxInputReporte = $("#checkboxInputReporte").val();
    if (checkboxInputReporte == "Hecho") {
        $("#checkboxInputReporte").prop("checked", true);
        $("#1erReporte").removeClass("alert-danger");
        $("#1erReporte").addClass("alert-success");
    } else {
        $("#checkboxInputReporte").prop("checked", false);
        $("#1erReporte").addClass("alert-danger");
        $("#1erReporte").removeClass("alert-success");
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

    $("#checkboxInputCliente").change(function () {
        var checkboxInputCliente = $("#checkboxInputCliente").is(":checked");

        if (checkboxInputCliente) {
            $("#altaCliente").removeClass("alert-danger");
            $("#altaCliente").addClass("alert-success");
            $("#checkboxInputCliente").val("Hecho");
        } else {
            $("#altaCliente").addClass("alert-danger");
            $("#altaCliente").removeClass("alert-success");
            $("#checkboxInputCliente").val("Pendiente");
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

    $("#checkboxInputLPOA").change(function () {
        var checkboxInputLPOA = $("#checkboxInputLPOA").is(":checked");

        if (checkboxInputLPOA) {
            $("#lpoa").removeClass("alert-danger");
            $("#lpoa").addClass("alert-success");
            $("#checkboxInputLPOA").val("Hecho");
        } else {
            $("#lpoa").addClass("alert-danger");
            $("#lpoa").removeClass("alert-success");
            $("#checkboxInputLPOA").val("Pendiente");
        }
    });

    $("#checkboxInputInstruccionesMAM").change(function () {
        var checkboxInputInstruccionesMAM = $(
            "#checkboxInputInstruccionesMAM"
        ).is(":checked");

        if (checkboxInputInstruccionesMAM) {
            $("#instrucciones_bancarias_mam").removeClass("alert-danger");
            $("#instrucciones_bancarias_mam").addClass("alert-success");
            $("#checkboxInputInstruccionesMAM").val("Hecho");
        } else {
            $("#instrucciones_bancarias_mam").addClass("alert-danger");
            $("#instrucciones_bancarias_mam").removeClass("alert-success");
            $("#checkboxInputInstruccionesMAM").val("Pendiente");
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

    $("#checkboxInputConvenio").change(function () {
        var checkboxInputConvenio = $("#checkboxInputConvenio").is(":checked");

        if (checkboxInputConvenio) {
            $("#convenio").removeClass("alert-danger");
            $("#convenio").addClass("alert-success");
            $("#checkboxInputConvenio").val("Hecho");
        } else {
            $("#convenio").addClass("alert-danger");
            $("#convenio").removeClass("alert-success");
            $("#checkboxInputConvenio").val("Pendiente");
        }
    });

    $("#checkboxInputReporte").change(function () {
        var checkboxInputReporte = $("#checkboxInputReporte").is(":checked");

        if (checkboxInputReporte) {
            $("#1erReporte").removeClass("alert-danger");
            $("#1erReporte").addClass("alert-success");
            $("#checkboxInputReporte").val("Hecho");
        } else {
            $("#1erReporte").addClass("alert-danger");
            $("#1erReporte").removeClass("alert-success");
            $("#checkboxInputReporte").val("Pendiente");
        }
    });
};
