<?php
$isDownloadsSection = isset($_GET['sec']) && $_GET['sec'] === 'downloads';
$order_by_selected = isset($_GET['order_by']) ? $_GET['order_by'] : 'date';
$order_dir_selected = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'DESC';
?>

<section>
    <div class="form-container">
        <form method="get" class="order-form">
            <input type="hidden" name="sec" value="<?php echo $isDownloadsSection ? 'downloads' : 'documents'; ?>">
            <label for="order_by" class="order-form__label">Ordenar por:</label>
            <div class="order-form__select-container">
                <select name="order_by" id="order_by" class="select form__select" <?php if ($isDownloadsSection) echo 'disabled'; ?>>
                    <option value="date" <?php if ($order_by_selected == 'date') echo 'selected'; ?>>Fecha</option>
                    <?php if (isset($_GET['sec']) && $_GET['sec'] != 'downloads') { ?>
                        <option value="downloads" <?php if ($order_by_selected == 'downloads') echo 'selected'; ?>>Descargas</option>
                    <?php } ?>
                </select>
                <select name="order_dir" id="order_dir" class="select form__select">
                    <option value="DESC" <?php if ($order_dir_selected == 'DESC') echo 'selected'; ?>>Descendente</option>
                    <option value="ASC" <?php if ($order_dir_selected == 'ASC') echo 'selected'; ?>>Ascendente</option>
                </select>
            </div>
            <button type="submit" class="button button--primary order-form__button">Aplicar</button>
        </form>
    </div>
</section>