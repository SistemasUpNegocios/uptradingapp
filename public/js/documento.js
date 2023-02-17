$(document).ready(function () {
    let acc = "";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#documentoForm").on("submit", function (e) {
        e.preventDefault();
        var url = $(this).attr("action");
        $("#alertMessage").text("");

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $("#formModal").modal("hide");
                $("#documentoForm")[0].reset();
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Documento añadido</h1>',
                        html: '<p style="font-family: Poppins">El documento ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Documento actualizado</h1>',
                        html: '<p style="font-family: Poppins">El documento ha sido actualizado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }

                $("#contenedorDocumentos").empty();
                let contDocumentos = `
                    <ol class='ps-3 mt-2'>
                        <li>
                            <div class="ps-2 row align-items-center mb-2">
                                <div class="col-md-6"><p>Presentación Up (uptrading)</p></div>
                                <div class="col-md-6 text-end accion_documentos">
                                    <a href="https://www.canva.com/design/DAFOLoI_efc/rUbvDzBeM71aRgWbszQ34g/view?utm_content=DAFOLoI_efc&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink" class="btn btn-primary btn-lg btn-icon viewup" target="_blank"><i class="bi bi-eye"></i> Visualizar presentación</a>
                                </div>
                            </div>
                        </li>
                `;
                response.map(function (documentos) {
                    contDocumentos += `
                        <li>
                            <div class="ps-2 d-flex justify-content-between align-items-center">
                                <div><p>${documentos.nombre} (${documentos.tipo_documento})</p></div>
                                <div>
                                    <a href="" data-id="${documentos.id}" data-tipo="${documentos.tipo_documento}" data-nombre="${documentos.nombre}" data-documento="${documentos.documento}" type="button" title="Editar documento" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
                                    <a href="" data-id="${documentos.id}" type="button" title="Eliminar documento" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
                                    <a href="../documentos/uptrading/${documentos.documento}" download="${documentos.documento}" title="Descargar ${documentos.nombre}" class="btn btn-secondary btn-sm btn-icon download"><i class="bi bi-download"></i></a>
                                </div>
                            </div>
                        </li>
                    `;
                });
                contDocumentos += "</ol>";
                $("#contenedorDocumentos").append(contDocumentos);
            },
            error: function (jqXHR, exception) {
                var validacion = jqXHR.responseJSON.errors;
                for (let clave in validacion) {
                    $("#alertMessage").append(
                        `<div class="badge bg-danger" style="text-align: left !important;">*${validacion[clave][0]}</div><br>`
                    );
                }
            },
        });
    });

    $(document).on("click", ".new", function (e) {
        $("#documentoForm")[0].reset();

        $("#alertMessage").text("");
        acc = "new";
        $("#documentoForm").attr("action", "/admin/addDocumento");
        $("#idInput").val("");

        $("#nombreInput").prop("readonly", false);
        $("#tipoInput").prop("disabled", false);
        $("#documentoInput").prop("disabled", false);
        $("#documentoInput").prop("required", true);
        $("#documentoInput").removeClass("is-valid");
        $("#documentoInput").removeClass("is-invalid");
        $("#documentoDescModal").addClass("d-none");

        $("#modalTitle").text("Añadir documento");
        $("#btnSubmit").text("Añadir documento");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var tipo = $(this).data("tipo");
        var documento = $(this).data("documento");

        window.open(`../documentos/${tipo}/${documento}`, "_blank");
        console.log(documento);
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");
        $("#idInput").val(id);

        var nombre = $(this).data("nombre");
        var tipo = $(this).data("tipo");

        $("#nombreInput").val(nombre);
        $("#nombreInput").prop("readonly", false);

        $("#tipoInput").val(tipo);
        $("#tipoInput").prop("disabled", false);

        var documento = $(this).data("documento");
        $("#documentoInput").prop("disabled", false);
        $("#documentoInput").prop("required", false);

        if (documento.length > 0) {
            $("#documentoInput").addClass("is-valid");
            $("#documentoInput").removeClass("is-invalid");

            $("#documentoDescModal").attr("download", `${documento}`);
            $("#documentoDescModal").attr(
                "href",
                `../documentos/${tipo}/${documento}`
            );
            $("#documentoDescModal").removeClass("d-none");

            $("#documentoDes").attr("download", `${documento}`);
            $("#documentoDes").attr(
                "href",
                `../documentos/${tipo}/${documento}`
            );
        } else {
            $("#documentoInput").addClass("is-invalid");
            $("#documentoInput").removeClass("is-valid");

            $("#documentoDescModal").addClass("d-none");
        }

        $("#formModal").modal("show");
        $("#documentoForm").attr("action", "/admin/editDocumento");

        $("#modalTitle").text(`Editar documento: ${nombre}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar documento");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");
        var conf;

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar documento</h1>',
            html: '<p style="font-family: Poppins">¿Estás seguro de eliminar este documento? esta opción no se puede deshacer</p>',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#01bbcc",
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#dc3545",
        }).then((result) => {
            if (result.value) {
                $.post(
                    "/admin/deleteDocumento",
                    { id: id },
                    function (response) {
                        $("#contenedorDocumentos").empty();
                        let contDocumentos = `
                            <ol class='ps-3 mt-2'>
                                <li>
                                    <div class="ps-2 row align-items-center mb-2">
                                        <div class="col-md-6"><p>Presentación Up (uptrading)</p></div>
                                        <div class="col-md-6 text-end accion_documentos">
                                            <a href="https://www.canva.com/design/DAFOLoI_efc/rUbvDzBeM71aRgWbszQ34g/view?utm_content=DAFOLoI_efc&utm_campaign=designshare&utm_medium=link&utm_source=publishsharelink" class="btn btn-primary btn-lg btn-icon viewup" target="_blank"><i class="bi bi-eye"></i> Visualizar presentación</a>
                                        </div>
                                    </div>
                                </li>
                        `;
                        response.map(function (documentos) {
                            contDocumentos += `
                                <li>
                                    <div class="ps-2 d-flex justify-content-between align-items-center">
                                        <div><p>${documentos.nombre} (${documentos.tipo_documento})</p></div>
                                        <div>
                                            <a href="" data-id="${documentos.id}" data-tipo="${documentos.tipo_documento}" data-nombre="${documentos.nombre}" data-documento="${documentos.documento}" type="button" title="Editar documento" class="btn btn-success btn-sm btn-icon edit"> <i class="bi bi-pencil"></i></a>
                                            <a href="" data-id="${documentos.id}" type="button" title="Eliminar documento" class="btn btn-danger btn-sm btn-icon delete"> <i class="bi bi-trash"></i></a>
                                            <a href="../documentos/uptrading/${documentos.documento}" download="${documentos.documento}" title="Descargar ${documentos.nombre}" class="btn btn-secondary btn-sm btn-icon download"><i class="bi bi-download"></i></a>
                                        </div>
                                    </div>
                                </li>
                            `;
                        });
                        contDocumentos += "</ol>";
                        $("#contenedorDocumentos").append(contDocumentos);

                        Swal.fire({
                            icon: "success",
                            title: '<h1 style="font-family: Poppins; font-weight: 700;">Documento eliminado</h1>',
                            html: '<p style="font-family: Poppins">El documento se ha eliminado correctamente</p>',
                            confirmButtonText:
                                '<a style="font-family: Poppins">Aceptar</a>',
                            confirmButtonColor: "#01bbcc",
                        });
                    }
                );
            } else {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">El documento no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });

    $("#documentoInput").change(function () {
        let datatarget = $(`.${acc}`).data("documento");

        if ($("#documentoInput")[0].files[0]?.name) {
            $("#documentoInput").removeClass("is-invalid");
            $("#documentoInput").addClass("is-valid");
        } else {
            if (datatarget < 1) {
                $("#documentoInput").removeClass("is-valid");
                $("#documentoInput").addClass("is-invalid");
            }
        }
    });
});
