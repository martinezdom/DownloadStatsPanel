$(document).ready(function() {
    const addButton = $('.documents-add-button');
    const formSection = $('.form-section');
    const form = $('#add-document-form');
    const selectPlace = $('select[name="place"]');
    const selectCity = $('select[name="city"]');

    addButton.on('click', function() {
        formSection.toggleClass('hidden');
        if (formSection.hasClass('hidden')) {
            addButton.text('Añadir Documento');
        } else {
            addButton.text('Cancelar');
        }
    });

    selectCity.on('change', function() {
        const cityId = $(this).val();
        const placeField = $('#place').closest('.form__field');
        
        $(this).closest('.form__field').find('.input-other').remove();
        placeField.find('.input-other').remove();
        
        if (cityId && cityId !== 'otro') {
            placeField.removeClass('hidden');
            let options = '<option value="">Seleccione un lugar</option>';
            allPlaces.forEach(function(place) {
                if (place.city_id == cityId) {
                    options += `<option value="${place.id}">${place.name}</option>`;
                }
            });
            options += '<option value="otro">Otro</option>';
            $('#place').html(options);
        } else if (cityId === 'otro') {
            $(this).closest('.form__field').append(
                '<input type="text" name="city_other" class="form__input input-other" placeholder="Especifique la población" required />'
            );
            
            placeField.removeClass('hidden');
            $('#place').html('<option value="otro">Otro</option>');
            placeField.append(
                '<input type="text" name="place_other" class="form__input input-other" placeholder="Especifique el lugar" required />'
            );
        } else {
            placeField.addClass('hidden');
            $('#place').html('<option value="">Seleccione un lugar</option><option value="otro">Otro</option>');
        }
    });

    selectPlace.on('change', function() {
        const formField = $(this).closest('.form__field');
        formField.find('.input-other').remove();
        if ($(this).val() === 'otro') {
            formField.append('<input type="text" name="place_other" class="form__input input-other" placeholder="Especifique el lugar" required />');
        }
    });

    form.on('submit', function(e) {
        let valid = true;
        form.find('.input__error').text('');

        if ($('#code').val().trim() === '') {
            $('#code').next('.input__error').text('El código es obligatorio.');
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });

    selectCity.change();
});