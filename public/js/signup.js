function verPass() {
    var input = $('#passwordInput');
    var input2 = $('#passwordConfirmationInput');

    var label = $('#textCheck');

    if (input.attr('type') === "password") {
        input.get(0).type = 'text';
        input2.get(0).type = 'text';
        label.text('Ocultar contraseñas');
    } else {
        input.get(0).type = 'password';
        input2.get(0).type = 'password';
        label.text('Mostrar contraseñas');
    }
}
