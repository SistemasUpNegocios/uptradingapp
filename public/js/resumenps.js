$(document).ready(function () {
    let oficinaID = "";
    let fechaInput = "";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function getOficinas() {
        $.ajax({
            type: "POST",
            url: "/admin/getOficinas",
            success: function (response) {
                $("#titlePage").text("Oficina");
                $("#contOficinas").empty();
                $("#contOficinas").html(response);

                $(".verOficina").click(function (e) {
                    e.preventDefault();

                    var id = $(this).data("id");

                    $.ajax({
                        type: "POST",
                        url: "/admin/getListaPS",
                        data: { id: id },
                        success: function (response) {
                            if (response == "vacío") {
                                alert("vacío");
                            } else {
                                $("#contOficinas").empty();
                                $("#contOficinas").html(response);

                                let mes = formatDate(new Date());
                                mes = mes.split("/").reverse().join("-");
                                mes = mes.split("-");
                                $("#fechaInputOficina").val(
                                    `${mes[0]}-${mes[1]}`
                                );

                                fechaInput = `${mes[0]}-${mes[1]}`;

                                $("#btnVolverOficinas").click(function (e) {
                                    e.preventDefault();
                                    getOficinas();
                                });
                            }
                        },
                        error: function (response) {
                            console.log(response);
                        },
                    });
                });
            },
            error: function (response) {
                alert("no");
            },
        });
    }

    getOficinas();

    $(document).on("click", "#verPs", function () {
        let id = $(this).data("id");
        $.ajax({
            type: "POST",
            url: "/admin/getListaPS",
            data: { id: id },
            success: function (response) {
                if (response == "vacío") {
                    alert("vacío");
                } else {
                    $("#contOficinas").empty();
                    $("#contOficinas").html(response);
                    $("#fechaInputOficina").val(fechaInput);

                    $("#btnVolverOficinas").click(function (e) {
                        e.preventDefault();
                        getOficinas();
                    });
                }
            },
            error: function (response) {
                console.log(response);
            },
        });
    });

    $(document).on("click", ".showLista", function () {
        let id = $(this).data("id");
        let fecha = formatDate(new Date());
        fecha = fecha.split("/").reverse().join("-");
        let mesLetra = new Intl.DateTimeFormat("es-ES", {
            month: "long",
        }).format(new Date(fecha));

        $.ajax({
            type: "GET",
            data: { id: id, fecha: fecha },
            url: "/admin/getResumen",
            success: function (response) {
                $("#contOficinas").empty();
                $("#contOficinas").html(response);
                $("#mesLetra").text(mesLetra);

                let mes = formatDate(new Date());
                mes = mes.split("/").reverse().join("-");
                mes = mes.split("-");
                $("#fechaInput").val(`${mes[0]}-${mes[1]}`);
            },
            error: function (response) {
                console.log(response);
            },
        });
    });

    $(document).on("change", "#fechaInput", function () {
        let id = $(this).data("id");
        let fecha = $("#fechaInput").val();

        let mes = fecha;
        mes = mes.split("-").reverse().join("/");
        mes = formatDate(new Date(`01/${mes}`));
        let mesLetra = new Intl.DateTimeFormat("es-ES", {
            month: "long",
        }).format(new Date(mes));

        $.ajax({
            type: "GET",
            data: { id: id, fecha: fecha },
            url: "/admin/getResumen",
            success: function (response) {
                $("#contOficinas").empty();
                $("#contOficinas").html(response);
                $("#fechaInput").val(fecha);
                $("#mesLetra").text(mesLetra);
            },
            error: function (response) {
                console.log(response);
            },
        });
    });

    $(document).on("click", "#imprimirResumen", function () {
        let id = $(this).data("id");
        let fecha = $("#fechaInput").val();

        window.open(`/admin/imprimirResumen?id=${id}&fecha=${fecha}`, "_blank");
    });

    $(document).on("click", ".verOficina", function () {
        oficinaID = $(this).data("id");
    });

    $(document).on("click", "#imprimirResumenOficina", function () {
        let fecha = $("#fechaInputOficina").val();
        if (fecha == "") {
            Swal.fire({
                icon: "warning",
                title: '<h1 style="font-family: Poppins; font-weight: 700;">Atención!</h1>',
                html: '<p style="font-family: Poppins">Primero debes de seleccionar una fecha.</p>',
                confirmButtonText:
                    '<a style="font-family: Poppins">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });
        } else {
            window.open(
                `/admin/imprimirResumenOficina?id=${oficinaID}&fecha=${fecha}`,
                "_blank"
            );
        }
    });

    $(document).on("change", "#fechaInputOficina", function () {
        fechaInput = $("#fechaInputOficina").val();
    });
});
