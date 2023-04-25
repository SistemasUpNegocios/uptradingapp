$(document).ready(function () {
    const date_convenio = moment();
    const day_convenio = moment.weekdays(date_convenio.day());

    //Dias inhabiles
    //constitución mexicana
    const date_convenio2 = moment("06/02/2023", "DD/MM/YYYY");
    const day2_convenio = moment.weekdays(date_convenio2.day());
    //día del trabajo
    const day3_convenio = moment.weekdays(date_convenio2.day());

    let fechaDash_convenio = "";
    if (day_convenio == "Saturday") {
        fechaDash_convenio = moment().add("days", 12).format("YYYY/MM/DD");
    } else if (
        day_convenio == "Sunday" ||
        day2_convenio == "Monday" ||
        day3_convenio == "Monday"
    ) {
        fechaDash_convenio = moment().add("days", 11).format("YYYY/MM/DD");
    } else {
        fechaDash_convenio = moment().add("days", 10).format("YYYY/MM/DD");
    }

    $.ajax({
        type: "GET",
        url: `/admin/getAlertaConvenio`,
        success: function (data) {
            if (
                window.localStorage.getItem("Convenios") !== undefined &&
                window.localStorage.getItem("Convenios")
            ) {
                if (data > 1) {
                    Swal.fire({
                        title: "Convenios pendientes",
                        html: `Hay ${data} convenios pendientes de activación.`,
                        icon: "warning",
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Ir a los convenios",
                        cancelButtonText: "Posponer alerta",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            localStorage.removeItem("Convenios");
                            window.location.href = "./convenio";
                        }
                    });
                } else if ((data = 1)) {
                    Swal.fire({
                        title: "Convenio pendiente",
                        html: `Hay ${data} convenio pendiente de activación.`,
                        icon: "warning",
                        showCloseButton: true,
                        showCancelButton: true,
                        confirmButtonText: "Ir a los convenios",
                        cancelButtonText: "Posponer alerta",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            localStorage.removeItem("Convenios");
                            window.location.href = "./convenio";
                        }
                    });
                }
            }
        },
        error: function (data) {
            console.log("Error:", data);
            localStorage.clear();
        },
    });
});
