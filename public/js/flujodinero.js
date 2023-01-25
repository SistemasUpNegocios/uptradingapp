$(document).ready(function () {
    let formatearCantidad = new Intl.NumberFormat("es-US", {
        style: "currency",
        currency: "USD",
        minimumFractionDigits: 2,
    });

    let formatearFecha = (fecha) => {
        return fecha.split(" ")[0].split("-").reverse().join("/");
    };

    let mes = formatDate(new Date());
    mes = mes.split("/").reverse().join("-");
    mes = mes.split("-");
    fechaInput = `${mes[0]}-${mes[1]}`;

    $("#fechaInput").val(fechaInput);

    var table = $("#flujoDinero").DataTable({
        ajax: `/admin/showFlujoDinero?fecha=${fechaInput}`,
        columns: [
            {
                data: "contrato",
            },
            {
                data: "fecha",
                render: function (data) {
                    return formatearFecha(data);
                },
            },
            {
                data: "clientenombre",
            },
            {
                data: "psnombre",
            },
            //Swiss a POOL
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "transferencia_swiss_pool") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //Rendimientos
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "rendimientos") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //Renovación
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "renovacion") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //Comisiones
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "comisiones") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //MX a POOL
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "transferencia_mx_pool") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            // Efectivo
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "efectivo") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //CI BANK
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "ci_bank") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
            //HSBC
            {
                data: function (data) {
                    let tipo_pago = data.tipo_pago.split(",");
                    let monto_pago = data.monto_pago.split(",");

                    for (let i = 0; i < tipo_pago.length; i++) {
                        if (tipo_pago[i] == "HSBC") {
                            return formatearCantidad.format(monto_pago[i]);
                        }
                    }
                    return formatearCantidad.format(0);
                },
            },
        ],
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ pagos",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "No se ha registrado ningún pago",
            infoEmpty: "Mostrando pagos del 0 al 0 de un total de 0 pagos",
            infoFiltered: "(filtrado de un total de _MAX_ pagos)",
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
                collage: {
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
            info: "Mostrando de _START_ a _END_ de _TOTAL_ pagos",
        },
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "GET",
        url: `/admin/getTotalMes?fecha=${fechaInput}`,
        success: function (data) {
            $("#contTotal").empty();
            $("#contTotal").html(data);
        },
        error: function (data) {
            console.log(data);
        },
    });

    $(document).on("click", "#mostrarPagos", function (e) {
        e.preventDefault();
        var tabla = $("#flujoDinero");
        let fecha = $("#fechaInput").val();

        $.ajax({
            type: "GET",
            url: `/admin/getTotalMes?fecha=${fecha}`,
            success: function (data) {
                $("#contTotal").empty();
                $("#contTotal").html(data);

                table.destroy();
                tabla.empty();

                tabla.append(`
                <thead>
                    <tr>
                        <th data-priority="0" scope="col">Contrato</th>
                        <th data-priority="0" scope="col">Fecha</th>
                        <th data-priority="0" scope="col">Cliente</th>
                        <th data-priority="0" scope="col">PS</th>
        
                        <th data-priority="0" scope="col">Swissquote a POOL</th>
                        <th data-priority="0" scope="col">Rendimientos</th>
                        <th data-priority="0" scope="col">Renovación</th>
                        <th data-priority="0" scope="col">Comisiones</th>
                        <th data-priority="0" scope="col">MX a POOL</th>
                        <th data-priority="0" scope="col">Efectivo</th>
                        <th data-priority="0" scope="col">CI BANK</th>
                        <th data-priority="0" scope="col">HSBC</th>
                    </tr>
                </thead>
                <tbody id="amortizacionBody">
                </tbody>
                `);

                table = $("#flujoDinero").DataTable({
                    ajax: `/admin/showFlujoDinero?fecha=${fecha}`,
                    columns: [
                        {
                            data: "contrato",
                        },
                        {
                            data: "fecha",
                            render: function (data) {
                                return formatearFecha(data);
                            },
                        },
                        {
                            data: "clientenombre",
                        },
                        {
                            data: "psnombre",
                        },
                        //Swiss a POOL
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (
                                        tipo_pago[i] ==
                                        "transferencia_swiss_pool"
                                    ) {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //Rendimientos
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "rendimientos") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //Renovación
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "renovacion") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //Comisiones
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "comisiones") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //MX a POOL
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (
                                        tipo_pago[i] == "transferencia_mx_pool"
                                    ) {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        // Efectivo
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "efectivo") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //CI BANK
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "ci_bank") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                        //HSBC
                        {
                            data: function (data) {
                                let tipo_pago = data.tipo_pago.split(",");
                                let monto_pago = data.monto_pago.split(",");

                                for (let i = 0; i < tipo_pago.length; i++) {
                                    if (tipo_pago[i] == "HSBC") {
                                        return formatearCantidad.format(
                                            monto_pago[i]
                                        );
                                    }
                                }
                                return formatearCantidad.format(0);
                            },
                        },
                    ],
                    language: {
                        processing: "Procesando...",
                        lengthMenu: "Mostrar _MENU_ pagos",
                        zeroRecords: "No se encontraron resultados",
                        emptyTable: "No se ha registrado ningún pago",
                        infoEmpty:
                            "Mostrando pagos del 0 al 0 de un total de 0 pagos",
                        infoFiltered: "(filtrado de un total de _MAX_ pagos)",
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
                            collage: {
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
                        info: "Mostrando de _START_ a _END_ de _TOTAL_ pagos",
                    },
                });
            },
        });
    });

    $(document).on("click", "#imprimirReporte", function (e) {
        e.preventDefault();
        let fecha = $("#fechaInput").val();
        window.open(`/admin/imprimirReporte?fecha=${fecha}`, "_blank");
    });
});

$(".table").addClass("compact nowrap w-100");
