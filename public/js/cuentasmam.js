$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var table = $("#cuentasmam").DataTable({
        ajax: "/admin/showCuentasMam",
        columns: [
            {
                data: "folio",
            },
            {
                data: "loggin",
            },
            {
                data: "clientenombre",
            },
            {
                data: "btn",
            },
        ],
        responsive: {
            breakpoints: [
                {
                    name: "desktop",
                    width: Infinity,
                },
                {
                    name: "tablet",
                    width: 1024,
                },
                {
                    name: "fablet",
                    width: 768,
                },
                {
                    name: "phone",
                    width: 480,
                },
            ],
        },
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ convenios",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún convenio",
            infoEmpty:
                "Mostrando convenios del 0 al 0 de un total de 0 convenios",
            infoFiltered: "(filtrado de un total de _MAX_ convenios)",
            search: "Buscar:",
            infoThousands: ",",
            loadingRecords: "Cargando...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: ">",
                previous: "<",
            },
            aria: {
                sortAscending:
                    ": Activar para ordenar la columna de manera ascendente",
                sortDescending:
                    ": Activar para ordenar la columna de manera descendente",
            },
            buttons: {
                copy: "Copiar",
                colvis: "Visibilidad",
                collection: "Colección",
                colvisRestore: "Restaurar visibilidad",
                copyKeys:
                    "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br /> <br /> Para cancelar, haga clic en este mensaje o presione escape.",
                copySuccess: {
                    1: "Copiada 1 fila al portapapeles",
                    _: "Copiadas %d fila al portapapeles",
                },
                copyTitle: "Copiar al portapapeles",
                csv: "CSV",
                excel: "Excel",
                pageLength: {
                    "-1": "Mostrar todas las filas",
                    1: "Mostrar 1 fila",
                    _: "Mostrar %d filas",
                },
                pdf: "PDF",
                print: "Imprimir",
            },
            autoFill: {
                cancel: "Cancelar",
                fill: "Rellene todas las celdas con <i>%d</i>",
                fillHorizontal: "Rellenar celdas horizontalmente",
                fillVertical: "Rellenar celdas verticalmentemente",
            },
            decimal: ",",
            searchBuilder: {
                add: "Añadir condición",
                button: {
                    0: "Constructor de búsqueda",
                    _: "Constructor de búsqueda (%d)",
                },
                clearAll: "Borrar todo",
                condition: "Condición",
                conditions: {
                    date: {
                        after: "Despues",
                        before: "Antes",
                        between: "Entre",
                        empty: "Vacío",
                        equals: "Igual a",
                        notBetween: "No entre",
                        notEmpty: "No Vacio",
                        not: "Diferente de",
                    },
                    number: {
                        between: "Entre",
                        empty: "Vacio",
                        equals: "Igual a",
                        gt: "Mayor a",
                        gte: "Mayor o igual a",
                        lt: "Menor que",
                        lte: "Menor o igual que",
                        notBetween: "No entre",
                        notEmpty: "No vacío",
                        not: "Diferente de",
                    },
                    string: {
                        contains: "Contiene",
                        empty: "Vacío",
                        endsWith: "Termina en",
                        equals: "Igual a",
                        notEmpty: "No Vacio",
                        startsWith: "Empieza con",
                        not: "Diferente de",
                    },
                    array: {
                        not: "Diferente de",
                        equals: "Igual",
                        empty: "Vacío",
                        contains: "Contiene",
                        notEmpty: "No Vacío",
                        without: "Sin",
                    },
                },
                data: "Data",
                deleteTitle: "Eliminar regla de filtrado",
                leftTitle: "Criterios anulados",
                logicAnd: "Y",
                logicOr: "O",
                rightTitle: "Criterios de sangría",
                title: {
                    0: "Constructor de búsqueda",
                    _: "Constructor de búsqueda (%d)",
                },
                value: "Valor",
            },
            searchPanes: {
                clearMessage: "Borrar todo",
                collacontratoe: {
                    0: "Paneles de búsqueda",
                    _: "Paneles de búsqueda (%d)",
                },
                count: "{total}",
                countFiltered: "{shown} ({total})",
                emptyPanes: "Sin paneles de búsqueda",
                loadMessage: "Cargando paneles de búsqueda",
                title: "Filtros Activos - %d",
            },
            select: {
                1: "%d fila seleccionada",
                _: "%d filas seleccionadas",
                cells: {
                    1: "1 celda seleccionada",
                    _: "$d celdas seleccionadas",
                },
                columns: {
                    1: "1 columna seleccionada",
                    _: "%d columnas seleccionadas",
                },
            },
            thousands: ".",
            datetime: {
                previous: "Anterior",
                next: "Proximo",
                hours: "Horas",
                minutes: "Minutos",
                seconds: "Segundos",
                unknown: "-",
                amPm: ["am", "pm"],
            },
            editor: {
                close: "Cerrar",
                create: {
                    button: "Nuevo",
                    title: "Crear Nuevo Registro",
                    submit: "Crear",
                },
                edit: {
                    button: "Editar",
                    title: "Editar Registro",
                    submit: "Actualizar",
                },
                remove: {
                    button: "Eliminar",
                    title: "Eliminar Registro",
                    submit: "Eliminar",
                    confirm: {
                        _: "¿Está seguro que desea eliminar %d filas?",
                        1: "¿Está seguro que desea eliminar 1 fila?",
                    },
                },
                error: {
                    system: 'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">Más información&lt;\\/a&gt;).</a>',
                },
                multi: {
                    title: "Múltiples Valores",
                    info: "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                    restore: "Deshacer Cambios",
                    noMulti:
                        "Este registro puede ser editado individualmente, pero no como parte de un grupo.",
                },
            },
            info: "Mostrando de _START_ a _END_ de _TOTAL_ convenios",
        },
        aaSorting: [],
    });

    $("#btnSubmit").on("click", function (e) {
        e.preventDefault();

        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Se está enviando por correo el reporte, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        let id = $("#idInput").val();
        let folio = $("#folioInput").val();
        let cliente = $("#clienteInput").val();
        let correo = $("#correoInput").val();
        let fecha_inicio = $("#fechaInicioInput").val();
        let fecha_fin = $("#fechaFinInput").val();
        let capital = $("#capitalInput").val();
        let balance = $("#balanceInput").val();
        let flotante = $("#flotanteInput").val();
        let retiro = $("#retiroInput").val();

        $.ajax({
            type: "GET",
            data: {
                id,
                folio,
                cliente,
                correo,
                fecha_inicio,
                fecha_fin,
                capital,
                balance,
                flotante,
                retiro,
            },
            url: "/admin/generarCuentaMam",
            success: function (response) {
                Swal.close();
                if (response == "success") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Reporte enviado</h1>',
                        html: '<p style="font-family: Poppins">El reporte MAM ha sido enviado correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                    $("#formModal").modal("hide");
                } else {
                    Swal.fire({
                        icon: "error",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Reporte no enviado</h1>',
                        html: '<p style="font-family: Poppins">El reporte MAM no puedo enviarse</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
            },
            error: function (response) {
                Swal.close();
                console.log(response);
            },
        });

        // window.open(
        //     `/admin/generarCuentaMam?id=${id}&folio=${folio}&cliente=${cliente}&fecha_inicio=${fecha_inicio}&fecha_fin=${fecha_fin}&capital=${capital}&balance=${balance}&flotante=${flotante}&retiro=${retiro}`,
        //     "_blank"
        // );
    });

    $("#cuentaMamFormReporte").on("submit", function (e) {
        e.preventDefault();

        Swal.fire({
            title: '<h2 style="font-family: Poppins;">Se están generando los reportes y enviando por correo, por favor espere...</h2>',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });

        $.ajax({
            type: "POST",
            url: "/admin/enviarReporteMam",
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function () {
                Swal.close();
                $("#formModalReporte").modal("hide");
                Swal.fire({
                    icon: "success",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Reporte enviado</h1>',
                    html: '<p style="font-family: Poppins">El reporte MAM ha sido enviado correctamente</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
            error: function (response) {
                Swal.close();

                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Reporte no enviado</h1>',
                    html: '<p style="font-family: Poppins">El reporte MAM no pudo enviarse</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });

                console.log(response);
            },
        });
    });

    $(document).on("click", ".generar_reporte", function (e) {
        e.preventDefault();
        $("#cuentaMamFormReporte")[0].reset();
        $("#formModalReporte").modal("show");
    });

    $(document).on("click", ".edit", function (e) {
        $("#cuentaMamForm")[0].reset();

        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();

        var id = $(this).data("id");
        var folio = $(this).data("folio");
        var nombrecliente = $(this).data("nombrecliente");
        var correocliente = $(this).data("correocliente");
        var monto = $(this).data("monto");
        var fecha_inicio = $(this).data("fecha_inicio");
        var fecha_fin = $(this).data("fecha_fin");

        $("#idInput").val(id);

        $("#folioInput").val(folio);
        $("#folioInput").prop("readonly", true);

        $("#correoInput").val(correocliente);

        $("#clienteInput").val(nombrecliente);
        $("#clienteInput").prop("readonly", true);

        monto = monto.toString().replace(",", ".");
        monto = parseFloat(monto);
        $("#capitalInput").val(monto.toFixed(2));
        $("#capitalInput").prop("readonly", true);

        $("#fechaInicioInput").val(fecha_inicio);
        $("#fechaInicioInput").prop("readonly", true);

        $("#fechaFinInput").val(fecha_fin);
        $("#fechaFinInput").prop("readonly", true);

        $("#btnCancel").text("Cancelar");
        $("#formModal").modal("show");
    });
});

$(".table").addClass("compact nowrap w-100");
