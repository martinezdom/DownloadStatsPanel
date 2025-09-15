<?php
$downloadsByCityCount = count($downloadsByCity);
if ($downloadsByCityCount <= 3) {
    $chartClass = 'chart-container chart-container--small';
} elseif ($downloadsByCityCount <= 20) {
    $chartClass = 'chart-container chart-container--medium';
} else {
    $chartClass = 'chart-container chart-container--big';
}
?>
<section class="home__welcome">
    <h1>¡Bienvenido, <?php echo $_SESSION['username'] ?>!</h1>
    <p><?php echo date('d/m/Y'); ?></p>
</section>

<section class="cards">
    <div class="card">
        <i class="bi bi-file-earmark-text"></i>
        <h3 class="card-title">Total de Documentos</h3>
        <p class="card-text"><a href="index.php?sec=documents" class="card-link"><?php echo $totalDocuments; ?></a></p>
    </div>
    <div class="card">
        <i class="bi bi-cloud-download"></i>
        <h3 class="card-title">Total de Descargas</h3>
        <p class="card-text"><a href="index.php?sec=downloads" class="card-link"><?php echo $totalDownloads; ?></a></p>
    </div>
</section>

<section>
    <div class="table-container table-container--home">
        <table class="table table--home">
            <caption class="table__caption table__caption--home">Últimos documentos</caption>
            <thead class="table__head table__head--home">
                <tr class="table__row--head table__row--head--home">
                    <th class="table__cell--header table__cell--header--home">ID</th>
                    <th class="table__cell--header table__cell--header--home">Código</th>
                    <th class="table__cell--header table__cell--header--home">Fecha de publicación</th>
                    <th class="table__cell--header table__cell--header--home">Lugar</th>
                    <th class="table__cell--header table__cell--header--home">Población</th>
                    <th class="table__cell--header table__cell--header--home">Veces descargado</th>
                </tr>
            </thead>
            <tbody class="table__body table__body--home">
                <?php foreach ($lastDocuments as $row) { ?>
                    <tr class="table__row--body table__row--body--home">
                        <td class="table__cell--body table__cell--body--home" data-label="ID"><?php echo $row['id']; ?></td>
                        <td class="table__cell--body table__cell--body--home" data-label="Código">
                            <a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=documents&sub=' . $row['id'] ?>" class="table__link"><?php echo $row['code']; ?></a>
                        </td>
                        <td class="table__cell--body table__cell--body--home date" data-label="Fecha de publicación"><?php echo $row['date'] ?></td>
                        <td class="table__cell--body table__cell--body--home" data-label="Lugar"><?php echo $row['place_name'] ?></td>
                        <td class="table__cell--body table__cell--body--home" data-label="Población"><?php echo $row['city_name'] ?></td>
                        <td class="table__cell--body table__cell--body--home" data-label="Veces descargado"><?php echo $row['downloads']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="table-container__footer table-container__footer--home">
            <a href="index.php?sec=documents" class="table-container__link table-container__link--home">Ver todos los documentos</a>
        </div>
    </div>
</section>

<section>
    <div class="table-container table-container--home">
        <table class="table table--home">
            <caption class="table__caption table__caption--home">Últimas descargas</caption>
            <thead class="table__head table__head--downloads--home">
                <tr class="table__row--head table__row--head--home">
                    <th class="table__cell--header table__cell--header--home">Documento referente</th>
                    <th class="table__cell--header table__cell--header--home">Fecha de descarga</th>
                </tr>
            </thead>
            <tbody class="table__body table__body--home">
                <?php foreach ($lastDownloads as $row) { ?>
                    <tr class="table__row--body table__row--body--home">
                        <td class="table__cell--body table__cell--body--home" data-label="Documento referente">
                            <a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=documents&sub=' . $row['document_id'] ?>" class="table__link table__link--home"><?php echo $row['code']; ?></a>
                        </td>
                        <td class="table__cell--body table__cell--body--home date-time" data-label="Fecha de descarga"><?php echo $row['date_time'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="table-container__footer table-container__footer--home">
            <a href="index.php?sec=downloads" class="table-container__link table-container__link--home">Ver todas las descargas</a>
        </div>
    </div>
</section>

<section>
    <h2 class="chart-header">Descargas por Población</h2>
    <div class="<?php echo $chartClass; ?>">
        <canvas id="downloads-by-city-chart"></canvas>
    </div>
</section>

<script>
    const downloadsByCity = <?php echo json_encode($downloadsByCity); ?>;
    renderDownloadsByCity(downloadsByCity);
</script>