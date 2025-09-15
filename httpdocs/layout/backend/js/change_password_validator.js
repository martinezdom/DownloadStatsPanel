$(document).ready(function () {
    const messageList = {
        required: 'Este campo es obligatorio',
        passwordLength: 'La contraseña debe tener entre 7 y 15 caracteres',
        passwordMismatch: 'Las contraseñas no coinciden',
        passwordStrength: 'La contraseña es demasiado débil',
    };

    $('#change-password-form').on('submit', function (e) {
        e.preventDefault();

        const isValidCurrent = validateCurrentPassword();
        const isValidNew = validatePassword();
        const isValidConfirm = validateConfirmPassword();

        if (isValidCurrent && isValidNew && isValidConfirm) {
            this.submit();
        }
    });

    $('#current-password').on('blur input', validateCurrentPassword);
    $('#new-password').on('blur input', validatePassword);
    $('#confirm-password').on('blur input', validateConfirmPassword);

    $('button[type="reset"]').on('click', function (e) {
        e.preventDefault();
        $('.input__error').text('');
        $('#current-password').val('');
        $('#new-password').val('');
        $('#confirm-password').val('');
        $('.form-error').remove();
    });

    function validateCurrentPassword() {
        const currentPasswordValue = $('#current-password').val().trim();
        if (currentPasswordValue === '') {
            return showError('#current-password', 'required');
        } else if (currentPasswordValue.length < 4 || currentPasswordValue.length > 15) {
            return showError('#current-password', 'length');
        } else {
            return clearError('#current-password');
        }
    }

    function validatePassword() {
        const newPasswordValue = $('#new-password').val().trim();
        if (newPasswordValue === '') {
            return showError('#new-password', 'required');
        } else if (newPasswordValue.length < 4 || newPasswordValue.length > 15) {
            return showError('#new-password', 'length');
        } else if (!isStrongPassword(newPasswordValue)) {
            return showError('#new-password', 'strength');
        } else {
            validateConfirmPassword();
            return clearError('#new-password');
        }
    }

    function validateConfirmPassword() {
        const newPasswordValue = $('#new-password').val().trim();
        const confirmPasswordValue = $('#confirm-password').val().trim();
        if (confirmPasswordValue === '') {
            return showError('#confirm-password', 'required');
        } else if (confirmPasswordValue.length < 4 || confirmPasswordValue.length > 15) {
            return showError('#confirm-password', 'length');
        } else if (confirmPasswordValue !== newPasswordValue) {
            return showError('#confirm-password', 'mismatch');
        } else if (!isStrongPassword(confirmPasswordValue)) {
            return showError('#confirm-password', 'strength');
        } else {
        return clearError('#confirm-password');
    }
}

    function isStrongPassword(password) {
        const letters = (password.match(/[a-zA-Z]/g) || []).length;
        const digits = (password.match(/\d/g) || []).length;
        const special = (password.match(/[^a-zA-Z\d]/g) || []).length;
        return letters >= 3 && digits >= 3 && special >= 1;
    }

    function showError(id, type) {
        if (type === 'required') {
            $(id).next('.input__error').text(messageList.required).show();
        } else if (type === 'length') {
            $(id).next('.input__error').text(messageList.passwordLength).show();
        } else if (type === 'mismatch') {
            $(id).next('.input__error').text(messageList.passwordMismatch).show();
        } else if (type === 'strength') {
            $(id).next('.input__error').text(messageList.passwordStrength).show();
        }
        return false;
    }

    function clearError(id) {
        $(id).next('.input__error').text('');
        return true;
    }
});