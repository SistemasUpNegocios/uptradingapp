let fechaDash = moment().add("days", 375).format("YYYY/MM/DD");

$.ajax({
    type: "GET",
    url: `/admin/getAlerta`,
    data: { fecha: fechaDash },
    success: function (data) {
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
        contratos = contratos.replace(", y", " y");

        if (
            window.localStorage.getItem("Contratos") !== undefined &&
            window.localStorage.getItem("Contratos")
        ) {
            if (data.length > 0) {
                if (i == 1) {
                    titulo = `${i} contrato a vencer`;
                    contratos = `El contrato <b>"${contratos}"</b> está a punto de vencer, favor de revisarlo.`;
                } else if (i >= 2) {
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
