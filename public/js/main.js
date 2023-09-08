(function () {
    "use strict";

    const btnSwitch = document.querySelector("#switch");

    btnSwitch.addEventListener("click", () => {
        document.body.classList.toggle("dark");
        btnSwitch.classList.toggle("active_darkmode");

        // Guardamos el modo en localstorage.
        if (document.body.classList.contains("dark")) {
            localStorage.setItem("dark-mode", "true");
        } else {
            localStorage.setItem("dark-mode", "false");
        }
    });

    // Obtenemos el modo actual.
    if (localStorage.getItem("dark-mode") === "true") {
        document.body.classList.add("dark");
        btnSwitch.classList.add("active_darkmode");
    } else {
        document.body.classList.remove("dark");
        btnSwitch.classList.remove("active_darkmode");
    }

    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp",
        success: function (response) {
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioDolar = parseFloat(serie.datos[0].dato);

                $("#valor_dolar_dashboard").text(
                    "$" + precioDolar.toFixed(2) + " USD"
                );

                $("#tipoCambioInputUSDCal").val(precioDolar.toFixed(2));
            }
        },
    });
    //EURO
    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF46410/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
        success: function (response) {
            //Handler de la respuesta
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioEuro = parseFloat(serie.datos[0].dato);

                $("#tipoCambioInputEURCal").val(precioEuro.toFixed(2));
            }
        },
    });
    //FRANCO SUIZO
    $.ajax({
        url: "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF57905/datos/oportuno?token=57389428453f8d1754c30564b6b915070587dc7102dd5fff2f5174edd623c90b",
        jsonp: "callback",
        dataType: "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
        success: function (response) {
            //Handler de la respuesta
            var series = response.bmx.series;
            for (var i in series) {
                var serie = series[i];

                var precioFranco = parseFloat(serie.datos[0].dato);

                $("#tipoCambioInputCHFCal").val(precioFranco.toFixed(2));
            }
        },
    });

    $("#tipoCambioInputUSDCal").on("keyup", function () {
        let usd = $("#dolaresInput").val();
        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = usd * tipo_cambio_usd;
        dolar_peso = dolar_peso.toFixed(2);
        $("#pesosInput").val(dolar_peso);

        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = dolar_peso / tipo_cambio_eur;
        $("#eurosInput").val(euro_peso.toFixed(2));

        let tipo_cambio_francos = $("#tipoCambioInputCHFCal").val();
        let franco_peso = dolar_peso / tipo_cambio_francos;
        $("#francosInput").val(franco_peso.toFixed(2));
    });

    $("#tipoCambioInputEURCal").on("keyup", function () {
        let eur = $("#eurosInput").val();
        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = eur * tipo_cambio_eur;
        euro_peso = euro_peso.toFixed(2);
        $("#pesosInput").val(euro_peso);

        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = euro_peso / tipo_cambio_usd;
        $("#dolaresInput").val(dolar_peso.toFixed(2));

        let tipo_cambio_francos = $("#tipoCambioInputCHFCal").val();
        let franco_peso = euro_peso / tipo_cambio_francos;
        $("#francosInput").val(franco_peso.toFixed(2));
    });

    $("#tipoCambioInputCHFCal").on("keyup", function () {
        let chf = $("#francosInput").val();
        let tipo_cambio_chf = $("#tipoCambioInputCHFCal").val();
        let franco_peso = chf * tipo_cambio_chf;
        franco_peso = franco_peso.toFixed(2);
        $("#pesosInput").val(franco_peso);

        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = franco_peso / tipo_cambio_usd;
        $("#dolaresInput").val(dolar_peso.toFixed(2));

        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = franco_peso / tipo_cambio_eur;
        $("#eurosInput").val(euro_peso.toFixed(2));
    });

    $("#formPreguntas").on("keyup submit", function (e) {
        e.preventDefault();

        let info = $("#buscarPreguntaInput").val();

        if (info.length > 0) {
            $("#buscarIcono").addClass("d-none");
        } else {
            $("#buscarIcono").removeClass("d-none");
        }

        $.get({
            type: "GET",
            url: "/admin/buscarPregunta",
            data: {
                info: info,
            },
            success: function (res) {
                $("#listaPreguntas").empty();
                $("#listaPreguntas").append(res);
            },
            error: function (res) {
                console.log(res);
            },
        });
    });

    $("#dolaresInput").on("keyup", function () {
        let usd = $("#dolaresInput").val();
        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = usd * tipo_cambio_usd;
        dolar_peso = dolar_peso.toFixed(2);
        $("#pesosInput").val(dolar_peso);

        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = dolar_peso / tipo_cambio_eur;
        $("#eurosInput").val(euro_peso.toFixed(2));

        let tipo_cambio_francos = $("#tipoCambioInputCHFCal").val();
        let franco_peso = dolar_peso / tipo_cambio_francos;
        $("#francosInput").val(franco_peso.toFixed(2));
    });

    $("#eurosInput").on("keyup", function () {
        let eur = $("#eurosInput").val();
        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = eur * tipo_cambio_eur;
        euro_peso = euro_peso.toFixed(2);
        $("#pesosInput").val(euro_peso);

        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = euro_peso / tipo_cambio_usd;
        $("#dolaresInput").val(dolar_peso.toFixed(2));

        let tipo_cambio_francos = $("#tipoCambioInputCHFCal").val();
        let franco_peso = euro_peso / tipo_cambio_francos;
        $("#francosInput").val(franco_peso.toFixed(2));
    });

    $("#francosInput").on("keyup", function () {
        let chf = $("#francosInput").val();
        let tipo_cambio_chf = $("#tipoCambioInputCHFCal").val();
        let franco_peso = chf * tipo_cambio_chf;
        franco_peso = franco_peso.toFixed(2);
        $("#pesosInput").val(franco_peso);

        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = franco_peso / tipo_cambio_usd;
        $("#dolaresInput").val(dolar_peso.toFixed(2));

        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = franco_peso / tipo_cambio_eur;
        $("#eurosInput").val(euro_peso.toFixed(2));
    });

    $("#pesosInput").on("keyup", function () {
        let mxn = $("#pesosInput").val();

        let tipo_cambio_usd = $("#tipoCambioInputUSDCal").val();
        let dolar_peso = mxn / tipo_cambio_usd;
        $("#dolaresInput").val(dolar_peso.toFixed(2));

        let tipo_cambio_eur = $("#tipoCambioInputEURCal").val();
        let euro_peso = mxn / tipo_cambio_eur;
        $("#eurosInput").val(euro_peso.toFixed(2));

        let tipo_cambio_francos = $("#tipoCambioInputCHFCal").val();
        let franco_peso = mxn / tipo_cambio_francos;
        $("#francosInput").val(franco_peso.toFixed(2));
    });

    $("#btnReset").on("click", function (e) {
        e.preventDefault();

        $("#dolaresInput").val(0.0);
        $("#eurosInput").val(0.0);
        $("#francosInput").val(0.0);
        $("#pesosInput").val(0.0);
    });

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
        el = el.trim();
        if (all) {
            return [...document.querySelectorAll(el)];
        } else {
            return document.querySelector(el);
        }
    };

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
        if (all) {
            select(el, all).forEach((e) => e.addEventListener(type, listener));
        } else {
            select(el, all).addEventListener(type, listener);
        }
    };

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
        el.addEventListener("scroll", listener);
    };

    /**
     * Sidebar toggle
     */
    if (select(".toggle-sidebar-btn")) {
        on("click", ".toggle-sidebar-btn", function (e) {
            select("body").classList.toggle("toggle-sidebar");
        });
    }

    /**
     * Search bar toggle
     */
    if (select(".search-bar-toggle")) {
        on("click", ".search-bar-toggle", function (e) {
            select(".search-bar").classList.toggle("search-bar-show");
        });
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select("#navbar .scrollto", true);
    const navbarlinksActive = () => {
        let position = window.scrollY + 200;
        navbarlinks.forEach((navbarlink) => {
            if (!navbarlink.hash) return;
            let section = select(navbarlink.hash);
            if (!section) return;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                navbarlink.classList.add("active");
            } else {
                navbarlink.classList.remove("active");
            }
        });
    };
    window.addEventListener("load", navbarlinksActive);
    onscroll(document, navbarlinksActive);

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select("#header");
    if (selectHeader) {
        const headerScrolled = () => {
            if (window.scrollY > 100) {
                selectHeader.classList.add("header-scrolled");
            } else {
                selectHeader.classList.remove("header-scrolled");
            }
        };
        window.addEventListener("load", headerScrolled);
        onscroll(document, headerScrolled);
    }

    /**
     * Back to top button
     */
    let backtotop = select(".back-to-top");
    if (backtotop) {
        const toggleBacktotop = () => {
            if (window.scrollY > 100) {
                backtotop.classList.add("active");
            } else {
                backtotop.classList.remove("active");
            }
        };
        window.addEventListener("load", toggleBacktotop);
        onscroll(document, toggleBacktotop);
    }

    /**
     * Initiate tooltips
     */
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    /**
     * Initiate Bootstrap validation check
     */
    var needsValidation = document.querySelectorAll(".needs-validation");

    Array.prototype.slice.call(needsValidation).forEach(function (form) {
        form.addEventListener(
            "submit",
            function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });

    /**
     * Saludo dashboard
     */

    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? "pm" : "am";
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? "0" + minutes : minutes;
        var strTime = hours + ":" + minutes + " " + ampm;
        return strTime;
    }

    var date = new Date();
    var year = date.getFullYear();
    document.getElementById(
        "copyright"
    ).innerHTML = `&copy; ${year} <strong><span>Up Trading Experts</span></strong>.`;

    function hourLive() {
        var date = new Date();
        var hrs = date.getHours();
        var min = date.getMinutes();
        var diaActual = date.getDay();
        var actualMonth = date.getMonth();
        var actualYear = date.getFullYear();

        var dias = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        var months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];

        var month = months[actualMonth];
        var day = dias[diaActual];

        if (min < 10) {
            min = `0${date.getMinutes()}`;
        }

        var dayMonthYear = `${date.getDate()} de ${month} de ${actualYear}`;

        var greeting = "";

        if (hrs >= 20) greeting = "¡Buenas noches!";
        else if (hrs >= 0 && hrs <= 5) greeting = "¡Buenas noches!";
        else if (hrs >= 6 && hrs <= 12) greeting = "¡Buenos días!";
        else if (hrs >= 12 && hrs <= 19) greeting = "¡Buenas tardes!";

        $("#day").html(`${day} `);
        $("#day").append("<span id='greeting'></span>");
        $("#greeting").html(`| ${greeting}`);
        $("#hour").html(formatAMPM(date));
        $("#date").html(dayMonthYear);
    }

    setInterval(hourLive, 1000);

    var myOffcanvas = document.getElementById("sidebar");
    // var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas);

    $("#btntog").on("click", function () {
        $("#sidebar").toggleClass("activee");
        $("#main").toggleClass("activee2");
    });
})();

function verPass() {
    var input = document.getElementById("password");
    var input2 = document.getElementById("password2");
    var txt = document.getElementById("textomostrar");

    if (input.type === "password") {
        input.type = "text";
        input2.type = "text";
        txt.textContent = "Ocultar contraseñas";
    } else {
        input.type = "password";
        input2.type = "password";
        txt.textContent = "Mostrar contraseñas";
    }
}

// Función para obtener la cantidad de meses entre dos fechas
function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth();
    months += d2.getMonth();
    return months + " meses" <= 0 ? 0 : months + " meses";
}

// Función para agregar un 0 al número y sea compatible
function padTo2Digits(num) {
    return num.toString().padStart(2, "0");
}

// Función para formatear un objeto date a fecha dd/mm/yyyy
function formatDate(date) {
    return [
        padTo2Digits(date.getDate()),
        padTo2Digits(date.getMonth() + 1),
        date.getFullYear(),
    ].join("/");
}

function lastDay(yyyy, mm) {
    return new Date(yyyy, mm + 1, 0);
}

// Función para agregar días a una fecha
Date.prototype.addDays = function (days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
};

// Función para quitar días a una fecha
Date.prototype.outDays = function (days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() - days);
    return date;
};

var numeroALetrasMXN = (function () {
    function Unidades(num) {
        switch (num) {
            case 1:
                return "un";
            case 2:
                return "dos";
            case 3:
                return "tres";
            case 4:
                return "cuatro";
            case 5:
                return "cinco";
            case 6:
                return "seis";
            case 7:
                return "siete";
            case 8:
                return "ocho";
            case 9:
                return "nueve";
        }

        return "";
    } //Unidades()

    function Decenas(num) {
        let decena = Math.floor(num / 10);
        let unidad = num - decena * 10;

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return "diez";
                    case 1:
                        return "once";
                    case 2:
                        return "doce";
                    case 3:
                        return "trece";
                    case 4:
                        return "catorce";
                    case 5:
                        return "quince";
                    default:
                        return "dieci" + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return "veinte";
                    default:
                        return "veinti" + Unidades(unidad);
                }
            case 3:
                return DecenasY("treinta", unidad);
            case 4:
                return DecenasY("cuarenta", unidad);
            case 5:
                return DecenasY("cincuenta", unidad);
            case 6:
                return DecenasY("sesenta", unidad);
            case 7:
                return DecenasY("setenta", unidad);
            case 8:
                return DecenasY("ochenta", unidad);
            case 9:
                return DecenasY("noventa", unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0) return strSin + " y " + Unidades(numUnidades);

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - centenas * 100;

        switch (centenas) {
            case 1:
                if (decenas > 0) return "ciento " + Decenas(decenas);
                return "cien";
            case 2:
                return "doscientos " + Decenas(decenas);
            case 3:
                return "trescientos " + Decenas(decenas);
            case 4:
                return "cuatrocientos " + Decenas(decenas);
            case 5:
                return "quinientos " + Decenas(decenas);
            case 6:
                return "seiscientos " + Decenas(decenas);
            case 7:
                return "setecientos " + Decenas(decenas);
            case 8:
                return "ochocientos " + Decenas(decenas);
            case 9:
                return "novecientos " + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let letras = "";

        if (cientos > 0)
            if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
            else letras = strSingular;

        if (resto > 0) letras += "";

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMiles = Seccion(num, divisor, "mil", "mil");
        let strCentenas = Centenas(resto);

        if (strMiles == "") return strCentenas;

        return strMiles + " " + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMillones = Seccion(num, divisor, "un millón", "millón");
        let strMiles = Miles(resto);

        if (strMillones == "") return strMiles;

        return strMillones + " " + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: Math.round(num * 100) - Math.floor(num) * 100,
            letrasCentavos: "",
            letrasMonedaPlural: currency.plural || "pesos",
            letrasMonedaSingular: currency.singular || "peso",
            letrasMonedaCentavoPlural: currency.centPlural || "centavos",
            letrasMonedaCentavoSingular: currency.centSingular || "centavo",
        };

        if (data.centavos > 0) {
            data.letrasCentavos =
                "con " +
                (function () {
                    if (data.centavos == 1)
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoSingular
                        );
                    else
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoPlural
                        );
                })();
        }

        if (data.enteros == 0)
            return (
                "cero " + data.letrasMonedaPlural + " " + data.letrasCentavos
            );
        if (data.enteros == 1)
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaSingular +
                " " +
                data.letrasCentavos
            );
        else
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaPlural +
                " " +
                data.letrasCentavos
            );
    };
})();

var numeroALetrasUSD = (function () {
    function Unidades(num) {
        switch (num) {
            case 1:
                return "un";
            case 2:
                return "dos";
            case 3:
                return "tres";
            case 4:
                return "cuatro";
            case 5:
                return "cinco";
            case 6:
                return "seis";
            case 7:
                return "siete";
            case 8:
                return "ocho";
            case 9:
                return "nueve";
        }

        return "";
    } //Unidades()

    function Decenas(num) {
        let decena = Math.floor(num / 10);
        let unidad = num - decena * 10;

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return "diez";
                    case 1:
                        return "once";
                    case 2:
                        return "doce";
                    case 3:
                        return "trece";
                    case 4:
                        return "catorce";
                    case 5:
                        return "quince";
                    default:
                        return "dieci" + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return "veinte";
                    default:
                        return "veinti" + Unidades(unidad);
                }
            case 3:
                return DecenasY("treinta", unidad);
            case 4:
                return DecenasY("cuarenta", unidad);
            case 5:
                return DecenasY("cincuenta", unidad);
            case 6:
                return DecenasY("sesenta", unidad);
            case 7:
                return DecenasY("setenta", unidad);
            case 8:
                return DecenasY("ochenta", unidad);
            case 9:
                return DecenasY("noventa", unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0) return strSin + " y " + Unidades(numUnidades);

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - centenas * 100;

        switch (centenas) {
            case 1:
                if (decenas > 0) return "ciento " + Decenas(decenas);
                return "cien";
            case 2:
                return "doscientos " + Decenas(decenas);
            case 3:
                return "trescientos " + Decenas(decenas);
            case 4:
                return "cuatrocientos " + Decenas(decenas);
            case 5:
                return "quinientos " + Decenas(decenas);
            case 6:
                return "seiscientos " + Decenas(decenas);
            case 7:
                return "setecientos " + Decenas(decenas);
            case 8:
                return "ochocientos " + Decenas(decenas);
            case 9:
                return "novecientos " + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let letras = "";

        if (cientos > 0)
            if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
            else letras = strSingular;

        if (resto > 0) letras += "";

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMiles = Seccion(num, divisor, "mil", "mil");
        let strCentenas = Centenas(resto);

        if (strMiles == "") return strCentenas;

        return strMiles + " " + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMillones = Seccion(num, divisor, "un millón", "millón");
        let strMiles = Miles(resto);

        if (strMillones == "") return strMiles;

        return strMillones + " " + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: Math.round(num * 100) - Math.floor(num) * 100,
            letrasCentavos: "",
            letrasMonedaPlural: currency.plural || "dólares",
            letrasMonedaSingular: currency.singular || "dólar",
            letrasMonedaCentavoPlural: currency.centPlural || "centavos",
            letrasMonedaCentavoSingular: currency.centSingular || "centavo",
        };

        if (data.centavos > 0) {
            data.letrasCentavos =
                "con " +
                (function () {
                    if (data.centavos == 1)
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoSingular
                        );
                    else
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoPlural
                        );
                })();
        }

        if (data.enteros == 0)
            return (
                "cero " + data.letrasMonedaPlural + " " + data.letrasCentavos
            );
        if (data.enteros == 1)
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaSingular +
                " " +
                data.letrasCentavos
            );
        else
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaPlural +
                " " +
                data.letrasCentavos
            );
    };
})();

var numeroALetrasEUR = (function () {
    function Unidades(num) {
        switch (num) {
            case 1:
                return "un";
            case 2:
                return "dos";
            case 3:
                return "tres";
            case 4:
                return "cuatro";
            case 5:
                return "cinco";
            case 6:
                return "seis";
            case 7:
                return "siete";
            case 8:
                return "ocho";
            case 9:
                return "nueve";
        }

        return "";
    } //Unidades()

    function Decenas(num) {
        let decena = Math.floor(num / 10);
        let unidad = num - decena * 10;

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return "diez";
                    case 1:
                        return "once";
                    case 2:
                        return "doce";
                    case 3:
                        return "trece";
                    case 4:
                        return "catorce";
                    case 5:
                        return "quince";
                    default:
                        return "dieci" + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return "veinte";
                    default:
                        return "veinti" + Unidades(unidad);
                }
            case 3:
                return DecenasY("treinta", unidad);
            case 4:
                return DecenasY("cuarenta", unidad);
            case 5:
                return DecenasY("cincuenta", unidad);
            case 6:
                return DecenasY("sesenta", unidad);
            case 7:
                return DecenasY("setenta", unidad);
            case 8:
                return DecenasY("ochenta", unidad);
            case 9:
                return DecenasY("noventa", unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0) return strSin + " y " + Unidades(numUnidades);

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - centenas * 100;

        switch (centenas) {
            case 1:
                if (decenas > 0) return "ciento " + Decenas(decenas);
                return "cien";
            case 2:
                return "doscientos " + Decenas(decenas);
            case 3:
                return "trescientos " + Decenas(decenas);
            case 4:
                return "cuatrocientos " + Decenas(decenas);
            case 5:
                return "quinientos " + Decenas(decenas);
            case 6:
                return "seiscientos " + Decenas(decenas);
            case 7:
                return "setecientos " + Decenas(decenas);
            case 8:
                return "ochocientos " + Decenas(decenas);
            case 9:
                return "novecientos " + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let letras = "";

        if (cientos > 0)
            if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
            else letras = strSingular;

        if (resto > 0) letras += "";

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMiles = Seccion(num, divisor, "mil", "mil");
        let strCentenas = Centenas(resto);

        if (strMiles == "") return strCentenas;

        return strMiles + " " + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMillones = Seccion(num, divisor, "un millón", "millón");
        let strMiles = Miles(resto);

        if (strMillones == "") return strMiles;

        return strMillones + " " + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: Math.round(num * 100) - Math.floor(num) * 100,
            letrasCentavos: "",
            letrasMonedaPlural: currency.plural || "euros",
            letrasMonedaSingular: currency.singular || "euro",
            letrasMonedaCentavoPlural: currency.centPlural || "centavos",
            letrasMonedaCentavoSingular: currency.centSingular || "centavo",
        };

        if (data.centavos > 0) {
            data.letrasCentavos =
                "con " +
                (function () {
                    if (data.centavos == 1)
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoSingular
                        );
                    else
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoPlural
                        );
                })();
        }

        if (data.enteros == 0)
            return (
                "cero " + data.letrasMonedaPlural + " " + data.letrasCentavos
            );
        if (data.enteros == 1)
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaSingular +
                " " +
                data.letrasCentavos
            );
        else
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaPlural +
                " " +
                data.letrasCentavos
            );
    };
})();

var numeroALetrasCHF = (function () {
    function Unidades(num) {
        switch (num) {
            case 1:
                return "un";
            case 2:
                return "dos";
            case 3:
                return "tres";
            case 4:
                return "cuatro";
            case 5:
                return "cinco";
            case 6:
                return "seis";
            case 7:
                return "siete";
            case 8:
                return "ocho";
            case 9:
                return "nueve";
        }

        return "";
    } //Unidades()

    function Decenas(num) {
        let decena = Math.floor(num / 10);
        let unidad = num - decena * 10;

        switch (decena) {
            case 1:
                switch (unidad) {
                    case 0:
                        return "diez";
                    case 1:
                        return "once";
                    case 2:
                        return "doce";
                    case 3:
                        return "trece";
                    case 4:
                        return "catorce";
                    case 5:
                        return "quince";
                    default:
                        return "dieci" + Unidades(unidad);
                }
            case 2:
                switch (unidad) {
                    case 0:
                        return "veinte";
                    default:
                        return "veinti" + Unidades(unidad);
                }
            case 3:
                return DecenasY("treinta", unidad);
            case 4:
                return DecenasY("cuarenta", unidad);
            case 5:
                return DecenasY("cincuenta", unidad);
            case 6:
                return DecenasY("sesenta", unidad);
            case 7:
                return DecenasY("setenta", unidad);
            case 8:
                return DecenasY("ochenta", unidad);
            case 9:
                return DecenasY("noventa", unidad);
            case 0:
                return Unidades(unidad);
        }
    } //Unidades()

    function DecenasY(strSin, numUnidades) {
        if (numUnidades > 0) return strSin + " y " + Unidades(numUnidades);

        return strSin;
    } //DecenasY()

    function Centenas(num) {
        let centenas = Math.floor(num / 100);
        let decenas = num - centenas * 100;

        switch (centenas) {
            case 1:
                if (decenas > 0) return "ciento " + Decenas(decenas);
                return "cien";
            case 2:
                return "doscientos " + Decenas(decenas);
            case 3:
                return "trescientos " + Decenas(decenas);
            case 4:
                return "cuatrocientos " + Decenas(decenas);
            case 5:
                return "quinientos " + Decenas(decenas);
            case 6:
                return "seiscientos " + Decenas(decenas);
            case 7:
                return "setecientos " + Decenas(decenas);
            case 8:
                return "ochocientos " + Decenas(decenas);
            case 9:
                return "novecientos " + Decenas(decenas);
        }

        return Decenas(decenas);
    } //Centenas()

    function Seccion(num, divisor, strSingular, strPlural) {
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let letras = "";

        if (cientos > 0)
            if (cientos > 1) letras = Centenas(cientos) + " " + strPlural;
            else letras = strSingular;

        if (resto > 0) letras += "";

        return letras;
    } //Seccion()

    function Miles(num) {
        let divisor = 1000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMiles = Seccion(num, divisor, "mil", "mil");
        let strCentenas = Centenas(resto);

        if (strMiles == "") return strCentenas;

        return strMiles + " " + strCentenas;
    } //Miles()

    function Millones(num) {
        let divisor = 1000000;
        let cientos = Math.floor(num / divisor);
        let resto = num - cientos * divisor;

        let strMillones = Seccion(num, divisor, "un millón", "millón");
        let strMiles = Miles(resto);

        if (strMillones == "") return strMiles;

        return strMillones + " " + strMiles;
    } //Millones()

    return function NumeroALetras(num, currency) {
        currency = currency || {};
        let data = {
            numero: num,
            enteros: Math.floor(num),
            centavos: Math.round(num * 100) - Math.floor(num) * 100,
            letrasCentavos: "",
            letrasMonedaPlural: currency.plural || "francos suizos",
            letrasMonedaSingular: currency.singular || "franco suizo",
            letrasMonedaCentavoPlural: currency.centPlural || "centavos",
            letrasMonedaCentavoSingular: currency.centSingular || "centavo",
        };

        if (data.centavos > 0) {
            data.letrasCentavos =
                "con " +
                (function () {
                    if (data.centavos == 1)
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoSingular
                        );
                    else
                        return (
                            Millones(data.centavos) +
                            " " +
                            data.letrasMonedaCentavoPlural
                        );
                })();
        }

        if (data.enteros == 0)
            return (
                "cero " + data.letrasMonedaPlural + " " + data.letrasCentavos
            );
        if (data.enteros == 1)
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaSingular +
                " " +
                data.letrasCentavos
            );
        else
            return (
                Millones(data.enteros) +
                " " +
                data.letrasMonedaPlural +
                " " +
                data.letrasCentavos
            );
    };
})();

function unsecuredCopyToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
        document.execCommand("copy");
    } catch (err) {
        console.error("Unable to copy to clipboard", err);
    }
    document.body.removeChild(textArea);
}

$(document).ready(function () {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Evento on change para que se agregue el periodo de meses entre dos fechas
    $("#fechaInicioInput, #fechaRenInput").change(function () {
        var date1 = $("#fechaInicioInput").val();
        var date2 = $("#fechaRenInput").val();

        var dateBegin = new Date(date1);
        var dateEnd = new Date(date2);

        if ($("#fechaInicioInput").val() && $("#fechaRenInput").val()) {
            $("#periodoInput").val(monthDiff(dateBegin, dateEnd));
        }
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#busquedaForm").on("submit", function (e) {
        e.preventDefault();
        var url = $(this).attr("action");

        $.ajax({
            type: "POST",
            url: url,
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function (res) {
                $("#busquedaModal").modal("show");
                $("#resultadosBusqueda").html(res);

                var query = $("#query").data("query");

                $("#modalTitleSearch").text(
                    `Resultados de la búsqueda: ${query}`
                );

                $(".copiar").click(function () {
                    var tagID = $(this).data("id");

                    var tag = $(`#${tagID}`).text();

                    if (window.isSecureContext && navigator.clipboard) {
                        navigator.clipboard.writeText(tag);
                    } else {
                        unsecuredCopyToClipboard(tag);
                    }

                    Toast.fire({
                        icon: "success",
                        title: "Copiado al portapapeles",
                    });
                });
            },
            error: function (res) {
                Swal.fire({
                    icon: "error",
                    title: '<h1 style="font-family: Poppins; font-weight: 700;">Sin resultados</h1>',
                    html:
                        '<p style="font-family: Poppins">No hay coincidencias para tu búsqueda: <span class="fw-bolder">' +
                        res.responseText +
                        "</span>. Por favor, intenta de nuevo</p>",
                    confirmButtonText:
                        '<a style="font-family: Poppins">Aceptar</a>',
                    confirmButtonColor: "#01bbcc",
                });
            },
        });
    });
});
