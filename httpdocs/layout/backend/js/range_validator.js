$(document).ready(function () {
    const form = $(".downloads-filter-section__form");
    const start = $('input[name="start_date"]');
    const end = $('input[name="end_date"]');

    function showError(msg) {
        if ($('.message--error').length === 0) {
            const divMsg = $(`<div class="message message--error"><span class="message__text">${msg}</span><button type="button" class="btn-close">x</button></div>`);
            $('.downloads-filter-section__title').after(divMsg);
            timeoutMessages(2);
        }
    }

    function validateRange() {
        const startVal = start.val();
        const endVal = end.val();
        $('.message--error').remove();
        if (startVal && endVal && endVal < startVal) {
            showError('La fecha "Hasta" no puede ser anterior a la fecha "Desde".');
            return false;
        }
        return true;
    }
    
    function validateOnSubmit() {
        const startVal = start.val();
        const endVal = end.val();
        $('.message--error').remove();
        if (!startVal || !endVal) {
            showError("Por favor, selecciona ambas fechas.");
            return false;
        }
        if (endVal < startVal) {
            showError('La fecha "Hasta" no puede ser anterior a la fecha "Desde".');
            return false;
        }
        return true;
    }

    form.on("submit", function (e) {
        if (!validateOnSubmit()) {
            e.preventDefault();
        }
    });

    start.on("change input", function () {
        validateRange();
    });
    end.on("change input", function () {
        validateRange();
    });

    $('button[type="button"]').on("click", function () {
        $('.message--error').remove();
        start.val('');
        end.val('');
        $('.chart-section--downloads').remove();
    });
});