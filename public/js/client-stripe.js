var transaccion = $("#transaccion");
transaccion.hide();

var terminal = StripeTerminal.create({
    onFetchConnectionToken: fetchConnectionToken,
    onUnexpectedReaderDisconnect: unexpectedDisconnect,
});

function unexpectedDisconnect() {
    // In this function, your app should notify the user that the reader disconnected.
    // You can also include a way to attempt to reconnect to a reader.
    console.log("Disconnected from reader");
}

function fetchConnectionToken() {
    // Do not cache or hardcode the ConnectionToken. The SDK manages the ConnectionToken's lifecycle.
    return fetch("/admin/connectionToken", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            return data.secret;
        });
}

var discoveredReaders;
var paymentIntentId;

// Handler for a "Discover readers" button
function discoverReaderHandler() {
    var alertDiscover = $("#alertDiscover");
    //Prueba con terminal simulada
    var config = { simulated: true };
    //Prueba con terminal real
    // var config = { simulated: false, location: "tml_ErAkXQ6uz3djd8" };
    //REAL
    // var config = { simulated: false, location: "tml_EXUIRQmTaZkBkY" };
    terminal.discoverReaders(config).then(function (discoverResult) {
        if (discoverResult.error) {
            console.log("Failed to discover: ", discoverResult.error);
        } else if (discoverResult.discoveredReaders.length === 0) {
            console.log("No available readers.");
            Swal.fire({
                icon: "error",
                title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Terminal no encontrada</h2>',
                html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">No hay ninguna terminal disponible, consulta con sistemas</p>',
                confirmButtonText: '<a style="font-family: Roboto">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });

            alertDiscover.removeClass("alert-info");
            alertDiscover.addClass("alert-danger");
            alertDiscover.html(
                `<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                  Terminal no encontrada, consulta con sistemas
                </div>`
            );
        } else {
            discoveredReaders = discoverResult.discoveredReaders;
            // log("terminal.discoverReaders", discoveredReaders);

            // Swal.fire({
            //     icon: "success",
            //     title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Terminal encontrada</h2>',
            //     html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">Hay una terminal disponible para conectar</p>',
            //     confirmButtonText: '<a style="font-family: Roboto">Aceptar</a>',
            //     confirmButtonColor: "#01bbcc",
            // });

            alertDiscover.removeClass("alert-info");
            alertDiscover.addClass("alert-success");
            alertDiscover.html(
                `<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                  Terminal disponible
                </div>`
            );
            connectReaderHandler(discoveredReaders);
        }
    });
}

function prueba() {
    alert("Prueba");
}

// Handler for a "Connect Reader" button
function connectReaderHandler(discoveredReaders) {
    var alertConnect = $("#alertConnect");
    // Just select the first reader here.
    var selectedReader = discoveredReaders[0];
    terminal.connectReader(selectedReader).then(function (connectResult) {
        if (connectResult.error) {
            console.log("Failed to connect: ", connectResult.error);

            alertConnect.removeClass("alert-info");
            alertConnect.addClass("alert-danger");
            alertConnect.html(
                `<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                  Terminal no disponible para conectar <a onClick="window.location.reload();" style="font-family: Roboto; cursor: pointer; text-decoration: underline;">Intentar de nuevo</a>
                </div>`
            );
            Swal.fire({
                icon: "error",
                title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Terminal no conectada</h2>',
                html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">Asegúrate que la terminal esté encendida y conectada a la misma red que este dispositivo, si el problema persiste, consulta a sistemas</p>',
                confirmButtonText:
                    '<a onClick="window.location.reload();" style="font-family: Roboto">Intentar de nuevo</a>',
                confirmButtonColor: "#01bbcc",
            });
        } else {
            console.log("Connected to reader: ", connectResult.reader.label);
            // log("terminal.connectReader", connectResult);
            Swal.fire({
                icon: "success",
                title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Terminal conectada</h2>',
                html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">¡La terminal está conectada! puedes comenzar a realizar transacciones!</p>',
                confirmButtonText: '<a style="font-family: Roboto">Aceptar</a>',
                confirmButtonColor: "#01bbcc",
            });
            alertConnect.removeClass("alert-info");
            alertConnect.addClass("alert-success");
            alertConnect.html(
                `<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                  Terminal conectada
                </div>`
            );
            transaccion.show();
        }
    });
}

function fetchPaymentIntentClientSecret(amount) {
    const bodyContent = JSON.stringify({ amount: amount });
    return fetch("/admin/createPaymentIntent", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        body: bodyContent,
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            return data.client_secret;
        });
}

function collectPayment(amount) {
    fetchPaymentIntentClientSecret(amount).then(function (client_secret) {
        terminal.setSimulatorConfiguration({
            testCardNumber: "4242424242424242",
        });
        Swal.fire({
            icon: "info",
            title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Realiza el pago</h2>',
            html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">Realiza el pago en la terminal física</p>',
            confirmButtonText: '<a style="font-family: Roboto">Aceptar</a>',
            confirmButtonColor: "#01bbcc",
        });
        terminal.collectPaymentMethod(client_secret).then(function (result) {
            if (result.error) {
                // Placeholder for handling result.error
                console.log(result.error);
            } else {
                //DESPUÉS DE HACER EL PAGO
                terminal
                    .processPayment(result.paymentIntent)
                    .then(function (result) {
                        if (result.error) {
                            console.log(result.error);
                            console.log(result.error.code);
                            if (result.error.code === "card_declined") {
                                Swal.fire({
                                    icon: "error",
                                    title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Pago declinado</h2>',
                                    html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">La tarjeta ha sido declinada, intenta con un método de pago diferente</p>',
                                    confirmButtonText:
                                        '<a style="font-family: Roboto">Aceptar</a>',
                                    confirmButtonColor: "#01bbcc",
                                });
                            }
                        } else if (result.paymentIntent) {
                            paymentIntentId = result.paymentIntent.id;
                            Swal.fire({
                                icon: "success",
                                title: '<h2 style="color: #595959; font-size: 30px; margin-bottom: 0px; font-weight: 600; letter-spacing: -0.05rem; line-height: 1.3; font-family: Roboto">Pago realizado</h2>',
                                html: '<p style="font-family: Roboto; color: #545454; margin-bottom: 0px; font-size: 18px; font-weight: 400;">¡El pago ha sido realizado con éxito!</p>',
                                confirmButtonText:
                                    '<a style="font-family: Roboto">Aceptar</a>',
                                confirmButtonColor: "#01bbcc",
                            });
                            capture(paymentIntentId);
                        }
                    });
            }
        });
    });
}

function capture(paymentIntentId) {
    return fetch("/admin/capturePaymentIntent", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        body: JSON.stringify({ payment_intent_id: paymentIntentId }),
    })
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            // log("server.capture", data);
        });
}

discoverReaderHandler();

// const discoverButton = document.getElementById("discover-button");
// discoverButton.addEventListener("click", async (event) => {
//   discoverReaderHandler();
// });

// const connectButton = document.getElementById("connect-button");
// connectButton.addEventListener("click", async (event) => {
//     connectReaderHandler(discoveredReaders);
// });

const collectButton = document.getElementById("collect-button");
collectButton.addEventListener("click", async (event) => {
    amount = document.getElementById("amount-input").value;
    var transaccion = amount.toString();

    var decimales = transaccion.indexOf(".");

    if (decimales < 0) {
        transaccion += "00";
        // console.log(transaccion);
    } else if (decimales >= 0) {
        //separa
        var arrayTransaccion = transaccion.split(".");
        var transaccionSinDecimales = transaccion.substring(
            decimales + 1,
            decimales + 3
        );

        if (arrayTransaccion[1].length >= 2) {
            //si escriben varios numeros depues del punto, solamente se agarran los 2 primeros digitos
            transaccion = arrayTransaccion[0] + transaccionSinDecimales;
            console.log(transaccion);
        } else if (arrayTransaccion[1].length == 1) {
            //si lo mandan con solamente un digito despues del punto, se le agrega un 0
            transaccion = arrayTransaccion[0] + transaccionSinDecimales + "0";
            console.log(transaccion);
        } else if (arrayTransaccion[1].length == 0) {
            //si lo mandan con solamente un . y nada despues de el, se le agregan dos 0
            transaccion = arrayTransaccion[0] + transaccionSinDecimales + "00";
        }
    }
    collectPayment(transaccion);
});

// const captureButton = document.getElementById("capture-button");
// captureButton.addEventListener("click", async (event) => {
//     capture(paymentIntentId);
// });

function formatJson(message) {
    var lines = message.split("\n");
    var json = "";
    var lineNumberFixedWidth = stringLengthOfInt(lines.length);
    for (var i = 1; i <= lines.length; i += 1) {
        line = i + padSpaces(i, lineNumberFixedWidth) + lines[i - 1];
        json = json + line + "\n";
    }
    return json;
}
