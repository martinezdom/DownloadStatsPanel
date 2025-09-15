<?php
include_once __DIR__ . '/../../../template/includes/table-order.php';
include_once __DIR__ . '/../../../template/includes/table-filter.php';
?>

<section>
    <div class="table-container table-container--downloads">
        <div class="table-scroll">
            <table class="table table--downloads" id="downloads-table">
                <caption class="table__caption table__caption--downloads">Listado de descargas</caption>
                <thead class="table__head table__head--downloads">
                    <tr class="table__row--head table__row--head--downloads">
                        <th class="table__cell--header table__cell--header--downloads">ID</th>
                        <th class="table__cell--header table__cell--header--downloads">Documento</th>
                        <th class="table__cell--header table__cell--header--downloads">Fecha</th>
                    </tr>
                </thead>
                <tbody class="table__body table__body--downloads">
                    <?php foreach ($downloadsFormatted as $row) { ?>
                        <tr class="table__row--body table__row--body--downloads">
                            <td class="table__cell--body table__cell--body--downloads">
                                <?php echo $row['id'] . '. ' . $row['code']; ?>
                            </td>
                            <td class="table__cell--body table__cell--body--downloads" data-label="ID"><?php echo $row['id'] ?></td>
                            <td class="table__cell--body table__cell--body--downloads" data-label="Documento">
                                <a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=documents&sub=' . $row['document_id'] ?>" class="table__link table__link--downloads"><?php echo $row['code']; ?></a>
                            </td>
                            <td class="table__cell--body table__cell--body--downloads date-time" data-label="Fecha"><?php echo $row['date_time'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<section class="cards">
    <div class="card">
        <i class="bi bi-calendar4"></i>
        <h3 class="card-title">Día con más descargas</h3>
        <p class="card-text date"><?php echo $dateWithMostDownloads['date']; ?></p>
        <h3 class="card-subtitle">Total</h3>
        <p class="card-text"><?php echo $dateWithMostDownloads['total']; ?></p>
    </div>
    <div class="card">
        <i class="bi bi-file-earmark-arrow-down"></i>
        <h3 class="card-title">Documento más descargado</h3>
        <p class="card-text"><a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=documents&sub=' . $mostDownloadedDocument['document_id']; ?>" class="card-link"><?php echo $mostDownloadedDocument['document_code']; ?></a></p>
        <h3 class="card-subtitle">Total</h3>
        <p class="card-text"><?php echo $mostDownloadedDocument['total']; ?></p>
    </div>
</section>
<section class="downloads-filter-section">
    <h2 class="subtitle downloads-filter-section__title">Seleccione un rango...</h2>
    <form class="downloads-filter-section__form" method="post" action="<?php echo SITE_URL . 'layout/backend/index.php?sec=downloads' ?>">
        <div class="downloads-filter-section__input-container">
            <div class="downloads-filter-section__input-container--start">
                <label for="start_date" class="downloads-filter-section__label">Desde</label>
                <input type="date" class="select downloads-filter-section__input" name="start_date" value="<?php echo $startDate; ?>">
            </div>
            <div class="downloads-filter-section__input-container--end">
                <label for="end_date" class="downloads-filter-section__label">Hasta</label>
                <input type="date" class="select downloads-filter-section__input" name="end_date" value="<?php echo $endDate; ?>">
            </div>
        </div>
        <div class="downloads-filter-section__actions">
            <button type="button" class="button button--secondary downloads-filter-section__button">Reset</button>
            <button type="submit" class="button button--primary downloads-filter-section__button">Filtrar</button>
        </div>
    </form>
</section>

<?php if ($startDate && $endDate) { ?>
    <section class="chart-section chart-section--downloads">
        <h2 class="chart-header">Descargas desde <span class="date"><?php echo $startDate ?></span> hasta <span class="date"><?php echo $endDate ?></span></h2>
        <div class="chart-container">
            <?php if (count($downloadsByDocumentInRange) == 0) { ?>
                <p class="chart-text">No hay descargas en este rango de fechas</p>
            <?php } else { ?>
                <canvas id="downloads-by-document-range-chart"></canvas>
            <?php } ?>
        </div>
    </section>
<?php } ?>
<?php if (count($downloadsByDocumentInRange) > 0) { ?>
    <script>
        const downloadsByDocumentInRange = <?php echo json_encode($downloadsByDocumentInRange); ?>;
        renderDownloadsByDocumentRange(downloadsByDocumentInRange);
    </script>
<?php } ?>