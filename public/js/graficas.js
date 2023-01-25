$(document).ready(function () {
    let chart1 = {};
    let chart2 = {};
    let chart3 = {};
    let chart4 = {};

    // select de filtros
    $(".graficas").hide();
    $(document).on("click", ".filtroInput", function () {
        const filtro = $(this).val();
        if (filtro == "todo") {
            propiedades(
                true,
                false,
                false,
                "#01bbcc",
                "none",
                "none",
                "#fff",
                "#444444",
                "#444444",
                "datos_for",
                "graficas_for"
            );

            $(".datos").show();
            $(".graficas").show();

            graficas();
        } else if (filtro == "datos") {
            propiedades(
                false,
                true,
                false,
                "none",
                "#01bbcc",
                "none",
                "#444444",
                "#fff",
                "#444444",
                "todo_for",
                "graficas_for"
            );

            $(".datos").show();
            $(".graficas").hide();
        } else if (filtro == "graficas") {
            propiedades(
                false,
                false,
                true,
                "none",
                "none",
                "#01bbcc",
                "#444444",
                "#444444",
                "#fff",
                "todo_for",
                "datos_for"
            );

            $(".datos").hide();
            $(".graficas").show();

            graficas();
        }
    });

    $("#contenedor_filtros").hide();
    $(document).on("click", "#filtros", function (e) {
        e.preventDefault();
        $("#contenedor_filtros").toggle();
    });

    const graficas = () => {
        //grafica de lineas de contratos y convenios
        $.ajax({
            type: "GET",
            url: "/admin/getContConvCount",
            success: function (data) {
                const grafica = document.querySelector("#grafica1");
                const etiquetas = [
                    "Enero - 2022",
                    "Febrero - 2022",
                    "Marzo - 2022",
                    "Abril - 2022",
                    "Mayo - 2022",
                    "Junio - 2022",
                    "Julio - 2022",
                    "Agosto - 2022",
                    "Septiembre - 2022",
                    "Octubre - 2022",
                    "Noviembre - 2022",
                    "Diciembre - 2022",
                    "Enero - 2023",
                    "Febrero - 2023",
                    "Marzo - 2023",
                    "Abril - 2023",
                    "Mayo - 2023",
                    "Junio - 2023",
                    "Julio - 2023",
                    "Agosto - 2023",
                    "Septiembre - 2023",
                    "Octubre - 2023",
                    "Noviembre - 2023",
                    "Diciembre - 2023",
                ];

                let totalContData = [];
                let totalConvData = [];

                data.cont.map((item) => {
                    totalContData.push(item.total);
                });
                data.conv.map((item) => {
                    totalConvData.push(item.total);
                });

                const totalConvenios = {
                    label: "Total de convenios por mes",
                    data: totalConvData,
                    backgroundColor: "#6F1AB6",
                    borderColor: "#3D1766",
                    borderWidth: 1,
                };
                const totalContratos = {
                    label: "Total de contratos por mes",
                    data: totalContData,
                    backgroundColor: "#01bbcc",
                    borderColor: "#018591",
                    borderWidth: 1,
                };

                if (Object.keys(chart1).length > 0) {
                    chart1.destroy();
                }
                chart1 = new Chart(grafica, {
                    type: "line",
                    data: {
                        labels: etiquetas,
                        datasets: [totalContratos, totalConvenios],
                    },
                    options: {
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                },
                            ],
                        },
                    },
                });
            },
            error: function (data) {
                console.log(data);
            },
        });

        //grafica de lineas de contratos mensuales y compuestos
        $.ajax({
            type: "GET",
            url: "/admin/getContMensCompCount",
            success: function (data) {
                const grafica2 = document.querySelector("#grafica2");
                const etiquetas2 = [
                    "Enero - 2022",
                    "Febrero - 2022",
                    "Marzo - 2022",
                    "Abril - 2022",
                    "Mayo - 2022",
                    "Junio - 2022",
                    "Julio - 2022",
                    "Agosto - 2022",
                    "Septiembre - 2022",
                    "Octubre - 2022",
                    "Noviembre - 2022",
                    "Diciembre - 2022",
                    "Enero - 2023",
                    "Febrero - 2023",
                    "Marzo - 2023",
                    "Abril - 2023",
                    "Mayo - 2023",
                    "Junio - 2023",
                    "Julio - 2023",
                    "Agosto - 2023",
                    "Septiembre - 2023",
                    "Octubre - 2023",
                    "Noviembre - 2023",
                    "Diciembre - 2023",
                ];

                let totalContMens = [];
                let totalContComp = [];

                data.mens.map((item) => {
                    totalContMens.push(item.total);
                });
                data.comp.map((item) => {
                    totalContComp.push(item.total);
                });

                const totalMensuales = {
                    label: "Total de contratos mensuales por mes",
                    data: totalContMens,
                    backgroundColor: "rgba(163,221,203,0.2)",
                    borderColor: "rgba(163,221,203,1)",
                    borderWidth: 1,
                };
                const totalCompuestos = {
                    label: "Total de contratos compuestos por mes",
                    data: totalContComp,
                    backgroundColor: "rgba(229,112,126,0.2)",
                    borderColor: "rgba(229,112,126,1)",
                    borderWidth: 1,
                };

                if (Object.keys(chart2).length > 0) {
                    chart2.destroy();
                }
                chart2 = new Chart(grafica2, {
                    type: "line",
                    data: {
                        labels: etiquetas2,
                        datasets: [totalMensuales, totalCompuestos],
                    },
                    options: {
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true,
                                    },
                                },
                            ],
                        },
                    },
                });
            },
            error: function (data) {
                console.log(data);
            },
        });

        //grafica de pie de clientes y clientes en formulario
        $.ajax({
            type: "GET",
            url: "/admin/getFormClientCount",
            success: function (data) {
                const grafica3 = document.querySelector("#grafica3");
                const etiquetas3 = ["Clientes", "Formularios"];

                const datosPSClientes = {
                    data: [data.clientes, data.formulario],
                    backgroundColor: [
                        "rgba(163,221,203,0.2)",
                        "rgba(232,233,161,0.2)",
                    ],
                    borderColor: ["rgba(163,221,203,1)", "rgba(232,233,161,1)"],
                    borderWidth: 1,
                };

                if (Object.keys(chart3).length > 0) {
                    chart3.destroy();
                }
                chart3 = new Chart(grafica3, {
                    type: "pie",
                    data: {
                        labels: etiquetas3,
                        datasets: [datosPSClientes],
                    },
                });
            },
            error: function (data) {
                console.log(data);
            },
        });

        //grafica de barras de ps y ps moviles
        $.ajax({
            type: "GET",
            url: "/admin/getPsPmCount",
            success: function (data) {
                const grafica4 = document.querySelector("#grafica4");
                let total = data.ps + data.ps_movil;
                const etiquetas4 = [`PS Totales: ${total}`];

                const totalPS = {
                    label: "Total de PS Golden y Silver",
                    data: [data.ps],
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1,
                };
                const totalPsMovil = {
                    label: "Total de PS móviles",
                    data: [data.ps_movil],
                    backgroundColor: "rgba(255, 159, 64, 0.2)",
                    borderColor: "rgba(255, 159, 64, 1)",
                    borderWidth: 1,
                };

                if (Object.keys(chart4).length > 0) {
                    chart4.destroy();
                }
                chart4 = new Chart(grafica4, {
                    type: "bar",
                    data: {
                        labels: etiquetas4,
                        datasets: [totalPS, totalPsMovil],
                    },
                });
            },
            error: function (data) {
                console.log(data);
            },
        });
    };

    const propiedades = (
        todo_prop,
        datos_prop,
        graficas_prop,
        todo_back,
        datos_back,
        graficas_back,
        todo_color,
        datos_color,
        graficas_color
    ) => {
        $("#todo").prop("checked", todo_prop);
        $("#todo_for").css("background", todo_back);
        $("#todo_for").css("color", todo_color);
        $("#todo_for").css("transition", "all 0.1s");

        $("#datos").prop("checked", datos_prop);
        $("#datos_for").css("background", datos_back);
        $("#datos_for").css("color", datos_color);
        $("#datos_for").css("transition", "all 0.1s");

        $("#graficas").prop("checked", graficas_prop);
        $("#graficas_for").css("background", graficas_back);
        $("#graficas_for").css("color", graficas_color);
        $("#graficas_for").css("transition", "all 0.1s");
    };
});
