$(document).ready(function () {
    let acc = "";

    var table = $("#oficina").DataTable({
        ajax: "/admin/showOficina",
        columns: [
            { data: "codigo_oficina" },
            { data: "ciudad" },
            { data: "mapa" },
            { data: "btn" },
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
            lengthMenu: "Mostrar _MENU_ oficinas",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ninguna oficina",
            infoEmpty:
                "Mostrando oficinas del 0 al 0 de un total de 0 oficinas",
            infoFiltered: "(filtrado de un total de _MAX_ oficinas)",
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
                collapse: {
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ oficinas",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#oficinaForm").on("submit", function (e) {
        e.preventDefault();
        var form = $(this).serialize();
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
            success: function () {
                $("#formModal").modal("hide");
                $("#oficinaForm")[0].reset();
                table.ajax.reload(null, false);
                if (acc == "new") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Oficina añadida</h1>',
                        html: '<p style="font-family: Poppins">La oficina ha sido añadido correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                } else if (acc == "edit") {
                    Swal.fire({
                        icon: "success",
                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Oficina actualizada</h1>',
                        html: '<p style="font-family: Poppins">La oficina ha sido actualizada correctamente</p>',
                        confirmButtonText:
                            '<a style="font-family: Poppins">Aceptar</a>',
                        confirmButtonColor: "#01bbcc",
                    });
                }
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
        $("#alertMessage").text("");
        acc = "new";

        $("#oficinaForm").attr("action", "/admin/addOficina");
        $("#oficinaForm").trigger("reset");
        $("#idInput").val("");

        $("#ciudadInput").prop("readonly", false);
        $("#codigoOficinaInput").prop("readonly", false);
        $("#coordXInput").prop("readonly", false);
        $("#coordYInput").prop("readonly", false);

        $("#modalTitle").text("Añadir oficina");
        $("#btnSubmit").text("Añadir oficina");

        $("#btnSubmit").show();
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".view", function (e) {
        $("#alertMessage").text("");
        acc = "view";
        e.preventDefault();

        var ciudad = $(this).data("ciudad");
        var codigo_oficina = $(this).data("codigo-oficina");
        var coord_x = $(this).data("coord_x");
        var coord_y = $(this).data("coord_y");

        $("#modalTitle").text(`Vista previa de la oficina en ${ciudad}`);

        $("#formModal").modal("show");

        $("#ciudadInput").val(ciudad);
        $("#ciudadInput").prop("readonly", true);

        $("#codigoOficinaInput").val(codigo_oficina);
        $("#codigoOficinaInput").prop("readonly", true);

        $("#coordXInput").val(coord_x);
        $("#coordXInput").prop("readonly", true);

        $("#coordYInput").val(coord_y);
        $("#coordYInput").prop("readonly", true);

        $("#btnCancel").text("Cerrar vista previa");
        $("#btnSubmit").hide();
    });

    $(document).on("click", ".edit", function (e) {
        $("#alertMessage").text("");
        acc = "edit";
        e.preventDefault();
        var id = $(this).data("id");

        var ciudad = $(this).data("ciudad");
        var codigo_oficina = $(this).data("codigo-oficina");
        var coord_x = $(this).data("coord_x");
        var coord_y = $(this).data("coord_y");

        $("#formModal").modal("show");
        $("#oficinaForm").attr("action", "/admin/editOficina");

        $("#idInput").val(id);

        $("#ciudadInput").val(ciudad);
        $("#ciudadInput").prop("readonly", false);

        $("#codigoOficinaInput").val(codigo_oficina);
        $("#codigoOficinaInput").prop("readonly", false);

        $("#coordXInput").val(coord_x);
        $("#coordXInput").prop("readonly", false);

        $("#coordYInput").val(coord_y);
        $("#coordYInput").prop("readonly", false);

        $("#modalTitle").text(`Editar oficina en ${ciudad}`);
        $("#btnSubmit").show();
        $("#btnSubmit").text("Editar oficina");
        $("#btnCancel").text("Cancelar");
    });

    $(document).on("click", ".delete", function (e) {
        $("#alertMessage").text("");
        e.preventDefault();
        var id = $(this).data("id");

        Swal.fire({
            title: '<h1 style="font-family: Poppins; font-weight: 700;">Eliminar oficina</h1>',
            html: '<p style="font-family: Poppins">Necesitas una clave para eliminar la oficina</p>',
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: '<a style="font-family: Poppins">Cancelar</a>',
            cancelButtonColor: "#01bbcc",
            confirmButtonText: '<a style="font-family: Poppins">Eliminar</a>',
            confirmButtonColor: "#dc3545",
            input: "password",
            showLoaderOnConfirm: true,
            preConfirm: (clave) => {
                $.ajax({
                    type: "GET",
                    url: "/admin/showClave",
                    data: { clave: clave },
                    success: function (result) {
                        if (result == "success") {
                            $.post(
                                "/admin/deleteOficina",
                                { id: id },
                                function () {
                                    table.ajax.reload(null, false);
                                    Swal.fire({
                                        icon: "success",
                                        title: '<h1 style="font-family: Poppins; font-weight: 700;">Oficina eliminada</h1>',
                                        html: '<p style="font-family: Poppins">La oficina se ha eliminado correctamente</p>',
                                        confirmButtonText:
                                            '<a style="font-family: Poppins">Aceptar</a>',
                                        confirmButtonColor: "#01bbcc",
                                    });
                                }
                            );
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: '<h1 style="font-family: Poppins; font-weight: 700;">Clave incorrecta</h1>',
                                html: '<p style="font-family: Poppins">La oficina no se ha eliminado porque la clave es incorrecta</p>',
                                confirmButtonText:
                                    '<a style="font-family: Poppins">Aceptar</a>',
                                confirmButtonColor: "#01bbcc",
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                            html: '<p style="font-family: Poppins">La oficina no se ha podido eliminar</p>',
                            confirmButtonText:
                                '<a style="font-family: Poppins">Aceptar</a>',
                            confirmButtonColor: "#01bbcc",
                        });
                    },
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (!result.isConfirmed) {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Cancelado</h1>',
                    html: '<p style="font-family: Poppins">La oficina no se ha eliminado</p>',
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            }
        });
    });
});

let map;

var markers = [];

function clean_markers(arr) {
    for (i in arr) {
        arr[i].setMap(null);
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: {
            lat: 23.6900104,
            lng: -102.0543492,
        },
        zoom: 6,
        gestureHandling: "greedy",
    });

    $(document).on("click", ".view", function (e) {
        clean_markers(markers);

        var lat = $(this).data("coord_x");
        var lng = $(this).data("coord_y");

        var position = new google.maps.LatLng(lat, lng);

        var marker = new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP,
            draggable: false,
        });

        markers.push(marker);

        marker.setMap(map);
    });

    $(document).on("click", ".new", function (e) {
        clean_markers(markers);

        google.maps.event.addListener(map, "click", function (event) {
            let lat_lng = event.latLng.toString();

            lat_lng = lat_lng.replace("(", "");
            lat_lng = lat_lng.replace(")", "");

            var lat_lng_array = lat_lng.split(",");

            var position = new google.maps.LatLng(
                lat_lng_array[0],
                lat_lng_array[1]
            );

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                animation: google.maps.Animation.DROP,
                draggable: false,
            });

            markers.push(marker);
            clean_markers(markers);

            marker.setMap(map);

            $("#coordXInput").val(lat_lng_array[0]);
            $("#coordYInput").val(lat_lng_array[1]);
        });
    });

    $(document).on("click", ".edit", function (e) {
        clean_markers(markers);

        var lat = $(this).data("coord_x");
        var lng = $(this).data("coord_y");

        var position = new google.maps.LatLng(lat, lng);

        var marker = new google.maps.Marker({
            position: position,
            map: map,
            animation: google.maps.Animation.DROP,
            draggable: false,
        });

        markers.push(marker);

        marker.setMap(map);

        google.maps.event.addListener(map, "click", function (event) {
            let lat_lng = event.latLng.toString();

            lat_lng = lat_lng.replace("(", "");
            lat_lng = lat_lng.replace(")", "");

            var lat_lng_array = lat_lng.split(",");

            var position = new google.maps.LatLng(
                lat_lng_array[0],
                lat_lng_array[1]
            );

            var marker = new google.maps.Marker({
                position: position,
                map: map,
                animation: google.maps.Animation.DROP,
                draggable: false,
            });

            markers.push(marker);
            clean_markers(markers);

            marker.setMap(map);

            $("#coordXInput").val(lat_lng_array[0]);
            $("#coordYInput").val(lat_lng_array[1]);
        });
    });
}
window.initMap = initMap;

$(".table").addClass("compact nowrap w-100");
