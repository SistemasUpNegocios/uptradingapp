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

// Obtenemos el modo actual.
if (localStorage.getItem("dark-mode") === "true") {
    document.body.classList.add("dark");
} else {
    document.body.classList.remove("dark");
}
