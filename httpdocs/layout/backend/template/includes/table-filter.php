<?php if (isset($sec) && $sec == 'documents') { ?>
    <section class="search-section">
        <select name="cell" id="cell" class="select">
            <option value="id" class="option">Id</option>
            <option value="code" class="option" selected>Código</option>
            <option value="date" class="option">Fecha</option>
            <option value="place" class="option">Lugar</option>
            <option value="city" class="option">Población</option>
        </select>
        <input type="text" name="search-input" id="search-input" class="search-input">
    </section>

<?php } else if ($sec == 'downloads') { ?>
    <section class="search-section">
        <select name="cell" id="cell" class="select">
            <option value="id" class="option">Id</option>
            <option value="code" class="option" selected>Documento</option>
            <option value="date" class="option">Fecha</option>
        </select>
        <input type="text" name="search-input" id="search-input" class="search-input">
    </section>
<?php } ?>