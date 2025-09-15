<?php
if (count($documents) == 2) {
    $chartClass = 'chart-container chart-container--small';
} else if (count($documents) == 3) {
    $chartClass = 'chart-container chart-container--medium';
} else {
    $chartClass = 'chart-container chart-container--big';
}
?>
<section class="compare-section">
    <h2 class="compare-section__title subtitle">Seleccione los documentos a comparar</h2>
    <form id="compare-form" method="post" action="<?php echo SITE_URL . 'layout/backend/index.php?sec=compare' ?>">
        <div class="compare-section__selects">
            <?php foreach ($selectedDocuments as $i => $selectedId) { ?>
            <div class="compare-section__select-container compare-section__select-container--<?= $i + 1 ?>">
                <label class="compare-section__label">Documento <?= $i + 1 ?></label>
                <select name="documents[]" class="compare-section__select select">
                    <option value="" disabled <?= $selectedId == "" ? "selected" : "" ?>>-- Seleccione --</option>
                    <?php foreach ($documentList as $document) { ?>
                        <option class="option" value="<?= $document['id'] ?>" <?= $document['id'] == $selectedId ? "selected" : "" ?>>
                            <?= $document['code'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <?php } ?>
        </div>
        <div class="compare-section__buttons">
            <button type="button" id="reset-btn" class="button button--secondary">Reset</button>
            <button type="button" id="add-document" class="button button--primary">Añadir</button>
            <button type="submit" id="compare-btn" class="button button--primary">Comparar</button>
            <?php if (count($documents) >= 2) { ?>
                <button type="button" id="export-btn" class="button button--secondary">Exportar</button>
            <?php } ?>
        </div>
    </form>
</section>
<div class="compare-chart__container">
<?php if (count($documents) >= 2) { ?>
    <section>
        <h2 class="chart-header">Descargas</h2>
        <div class="<?php echo $chartClass; ?>">
            <canvas id="downloads-by-selected-documents"></canvas>
        </div>
    </section>
    <script>
        const documents = <?php echo json_encode($documents) ?>;
        const downloadList = <?php echo json_encode($downloadList) ?>;
        renderDownloadsByDocument(documents, downloadList, "downloads-by-selected-documents");
        
        
        </script>
<?php } ?>

<?php if (!empty($downloadsBySelectedDocuments)) { ?>
    <section>
    <h2 class="chart-header">Porcentaje de descargas</h2>
    <div class="<?php echo $chartClass; ?>">
        <canvas id="downloads-percentage-chart"></canvas>
    </div>
</section>
<script>
    const downloadsBySelectedDocuments = <?php echo json_encode($downloadsBySelectedDocuments); ?>;
    console.log(downloadsBySelectedDocuments);
    renderDownloadsPercentageChart(downloadsBySelectedDocuments);
</script>
<?php } ?>

<?php if (!empty($downloadsEvolution)) { ?>
<section>
    <h2 class="chart-header">Evolución temporal de descargas</h2>
    <div class="chart-container chart-container--medium">
        <canvas id="downloads-evolution-chart"></canvas>
    </div>
</section>
<script>
    const downloadsEvolution = <?php echo json_encode($downloadsEvolution); ?>;
    const selectedDocuments = <?php echo json_encode(array_column($documents, 'id')); ?>;
    const documentNames = <?php
        $names = [];
        foreach ($documents as $doc) {
            $names[$doc['id']] = $doc['code'];
        }
        echo json_encode($names);
    ?>;
    renderDownloadsEvolutionChart(downloadsEvolution, selectedDocuments, documentNames);
</script>
<?php } ?>

<?php if (!empty($downloadsByHour)) { ?>
<section>
    <h2 class="chart-header">Descargas por franja horaria</h2>
    <div class="chart-container chart-container--medium">
        <canvas id="downloads-by-hour-chart"></canvas>
    </div>
</section>
<script>
    const downloadsByHour = <?php echo json_encode($downloadsByHour); ?>;
    renderDownloadsByHourChart(downloadsByHour);
</script>
<?php } ?>
</div>