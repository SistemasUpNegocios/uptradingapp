function verPass() {
    var input = $("#passwordInput");

    var label = $("#textCheck");

    if (input.attr("type") === "password") {
        input.get(0).type = "text";
        label.text("Ocultar contraseña");
    } else {
        input.get(0).type = "password";
        label.text("Mostrar contraseña");
    }
}

// var options = {
//     enableHighAccuracy: true,
//     timeout: 5000,
//     maximumAge: 0,
// };

// if (location.protocol !== 'https:') {
//     // location.replace(`https:${location.href.substring(location.protocol.length)}`);
// } else {
//     $("#correoInput").prop("readonly", true);
//     $("#passwordInput").prop("readonly", true);
// }

// function success(pos) {
//     var crd = pos.coords;

//     var coord_x = crd.latitude;
//     var coord_y = crd.longitude;

//     $.ajaxSetup({
//         headers: {
//             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//         },
//     });

//     $.ajax({
//         type: "POST",
//         url: '/checkLocation',
//         data: {
//             coord_x: coord_x,
//             coord_y: coord_y
//         },
//         success: function (response) {
//             if (response >= 1) {
//                 Swal.fire({
//                     icon: "success",
//                     title: '<h1 style="font-family: Poppins; font-weight: 700;">Ubicación validada</h1>',
//                     html: '<p style="font-family: Poppins">Tu ubicación ha sido validada, puedes ingresar al sistema</p>',
//                     confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
//                     confirmButtonColor: "#01bbcc",
//                 });

//                 $("#correoInput").prop("readonly", false);
//                 $("#passwordInput").prop("readonly", false);
//             } else {
//                 Swal.fire({
//                     icon: "error",
//                     title: '<h1 style="font-family: Poppins; font-weight: 700;">Ubicación fuera de rango</h1>',
//                     html: '<p style="font-family: Poppins">Lo sentimos, te encuentras en una ubicación fuera de rango, no podrás ingresar al sistema</p>',
//                     confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
//                     confirmButtonColor: "#01bbcc",
//                 });

//                 $("#correoInput").prop("readonly", true);
//                 $("#passwordInput").prop("readonly", true);
//             }
//         },
//         error: function () {
//             Swal.fire({
//                 icon: "error",
//                 title: '<h1 style="font-family: Poppins; font-weight: 700;">Oops</h1>',
//                 html: '<p style="font-family: Poppins">Lo sentimos, ocurrió un error al obtener tu ubicación</p>',
//                 confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
//                 confirmButtonColor: "#01bbcc",
//             });

//             $("#correoInput").prop("readonly", true);
//             $("#passwordInput").prop("readonly", true);
//         },
//     });
// }

// function error(err) {
//     Swal.fire({
//         icon: "error",
//         title: '<h1 style="font-family: Poppins; font-weight: 700;">Ubicación no obtenida</h1>',
//         html: '<p style="font-family: Poppins">Lo sentimos, no pudimos obtener tu ubicación, no podrás entrar al sistema</p>',
//         confirmButtonText: '<a style="font-family: Poppins">Aceptar</a>',
//         confirmButtonColor: "#01bbcc",
//     });
//     if (location.protocol !== 'https:') {
//         // location.replace(`https:${location.href.substring(location.protocol.length)}`);
//     } else {
//         $("#correoInput").prop("readonly", true);
//         $("#passwordInput").prop("readonly", true);
//     }
// }

// navigator.geolocation.getCurrentPosition(success, error, options);
