const date = moment();
const day = moment.weekdays(date.day());

//Dias inhabiles
//constitución mexicana
const date2 = moment("06/02/2023", "DD/MM/YYYY");
const day2 = moment.weekdays(date2.day());
//día del trabajo
const day3 = moment.weekdays(date2.day());

let fechaDash = "";
if (day == "Saturday") {
    fechaDash = moment().add("days", 12).format("YYYY/MM/DD");
} else if (day == "Sunday" || day2 == "Monday" || day3 == "Monday") {
    fechaDash = moment().add("days", 11).format("YYYY/MM/DD");
} else {
    fechaDash = moment().add("days", 10).format("YYYY/MM/DD");
}

$.ajax({
    type: "GET",
    url: `/admin/getAlerta`,
    data: { fecha: fechaDash },
    success: function (data) {
        if (
            window.localStorage.getItem("Contratos") !== undefined &&
            window.localStorage.getItem("Contratos")
        ) {
            if (data.length > 0) {
                let i = 0;
                let contratos = "";
                let titulo = "";

                data.map((contrato) => {
                    i++;

                    if (data.length == i) {
                        contratos = contratos + "y " + contrato.contrato;
                    } else {
                        contratos = contratos + contrato.contrato + ", ";
                    }
                });

                if (data.length == 1) {
                    contratos = contratos.replace("y ", "");

                    titulo = `${i} contrato a vencer`;
                    contratos = `El contrato <b>"${contratos}"</b> está a punto de vencer, favor de revisarlo.`;
                } else {
                    contratos = contratos.replace(", y", " y");

                    titulo = `${i} contratos a vencer`;
                    contratos = `Los contratos <b>"${contratos}"</b>, estan a punto de vencer, favor de revisarlos.`;
                }

                Swal.fire({
                    title: titulo,
                    html: contratos,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Quitar alerta",
                    cancelButtonText: "Posponer alerta",
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem("Contratos");
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

$.ajax({
    type: "GET",
    url: `/admin/getTicketsAlerta`,
    success: function (data) {
        if (
            window.localStorage.getItem("Ticket") !== undefined &&
            window.localStorage.getItem("Ticket")
        ) {
            if (data.length > 0) {
                let i = 0;
                let tickets = "";
                let title = "";

                data.map((ticket) => {
                    i++;
                    if (data.length == i) {
                        tickets = tickets + "y " + ticket.status.toLowerCase();
                    } else {
                        tickets = tickets + ticket.status.toLowerCase() + ", ";
                    }
                });
                if (data.length == 1) {
                    tickets = tickets.replace("y ", "");
                    tickets = `El estatus del ticket es <b>"${tickets}"</b> y está a punto de vencer, favor de revisarlo.`;

                    title = `Tienes ${data.length} ticket sin resolver`;
                } else {
                    tickets = tickets.replace(", y", " y");
                    tickets = `El estatus de los tickets son: <b>"${tickets}"</b> y están a punto de vencer, favor de revisarlos.`;

                    title = `Tienes ${data.length} tickets sin resolver`;
                }

                Swal.fire({
                    title: title,
                    html: tickets,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Quitar alerta",
                    cancelButtonText: "Posponer alerta",
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem("Ticket");
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

$.ajax({
    type: "GET",
    url: `/admin/getTicketsAbiertos`,
    success: function (data) {
        if (
            window.localStorage.getItem("Tickets pendientes") !== undefined &&
            window.localStorage.getItem("Tickets pendientes")
        ) {
            if (data > 1) {
                Swal.fire({
                    title: "Tickets abiertos",
                    html: `Tienes ${data} tickets sin atender.`,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Ir a los tickets",
                    cancelButtonText: "Posponer alerta",
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem("Tickets pendientes");
                        window.location.href = "./convenio";
                    }
                });
            } else if (data == 1) {
                Swal.fire({
                    title: "Ticket abierto",
                    html: `Tienes ${data} ticket sin atender.`,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Ir a los tickets",
                    cancelButtonText: "Posponer alerta",
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.removeItem("Tickets pendientes");
                        window.location.href = "./tickets";
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
