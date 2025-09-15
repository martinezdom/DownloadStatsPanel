$(document).ready(function () {
    $('#login-form').on('submit', function (e) {
        e.preventDefault();

        let isValid = true;

        if (!validateUsername()) {
            isValid = false;
        }

        if (!validatePassword()) {
            isValid = false;
        }

        if (isValid) {
            this.submit();
        }
    });

    $('#username').on('blur', validateUsername);

    $('#password').on('blur', validatePassword);

    $('#username').on('input', validateUsername);

    $('#password').on('input', validatePassword);

    $('button[type="reset"]').on('click', function (e) {
        e.preventDefault();
        $('.input__error').text('');
        $('#username').val('');
        $('#password').val('');
        $('.form-error').remove();
    });

    function validateUsername() {
        const usernameValue = $('#username').val().trim();
        if (usernameValue === '') {
            $('#username').next('.input__error').text('Nombre de usuario obligatorio.').show();
            return false;
        } else if (usernameValue.length > 30) {
            $('#username').next('.input__error').text('El nombre de usuario puede tener un máximo de 30 caracteres.').show();
            return false;
        } else {
            $('#username').next('.input__error').text('');
            return true;
        }
    }

    function validatePassword() {
        const passwordValue = $('#password').val().trim();
        if (passwordValue === '') {
            $('#password').next('.input__error').text('Contraseña obligatoria.').show();
            return false;
        } else if (passwordValue.length < 7) {
            $('#password').next('.input__error').text('La contraseña debe tener al menos 7 caracteres.').show();
            return false;
        } else if (passwordValue.length > 15) {
            $('#password').next('.input__error').text('La contraseña debe tener un máximo de 15 caracteres.').show();
            return false;
        } else {
            $('#password').next('.input__error').text('');
            return true;
        }
    }
});