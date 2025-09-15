<?php
$error_message_documents = isset($_SESSION['error_message_documents']) ? $_SESSION['error_message_documents'] : '';
unset($_SESSION['error_message_documents']);

$success_message_documents = isset($_SESSION['success_message_documents']) ? $_SESSION['success_message_documents'] : '';
unset($_SESSION['success_message_documents']);

if (isset($_GET['sub']) && is_numeric($_GET['sub'])) {
    $downloadsCount = count($downloadsByDate);
    if ($downloadsCount <= 3) {
        $chartClass = 'chart-container chart-container--small';
    } elseif ($downloadsCount <= 12) {
        $chartClass = 'chart-container chart-container--medium';
    } else {
        $chartClass = 'chart-container chart-container--big';
    }
?>
    <section class="document__info">
        <div class="document__info-code">
            <h1 class="document__code">
                <i class="document__info-icon bi bi-qr-code"></i>
                Código: <span><?php echo $document['code'] ?></span>
            </h1>
        </div>
        <div class="document__info-details">
            <p class="document__info-item">
                <i class="document__info-icon bi bi-calendar4"></i>
                Fecha: <span class="document__info-date"><?php echo $document['date'] ?></span>
            </p>
            <p class="document__info-item">
                <i class="document__info-icon bi bi-geo"></i>
                Lugar: <span class="document__info-place"><?php echo !empty($placeName) ? $placeName : ''; ?></span>
            </p>
            <p class="document__info-item">
                <i class="document__info-icon bi bi-geo-alt"></i>
                Población: <span class="document__info-city"><?php echo !empty($cityName) ? $cityName : ''; ?></span>
            </p>
            <p class="document__info-item">
                <i class="document__info-icon bi bi-info-circle"></i>
                Descripción: <span class="document__info-description"><?php echo $document['description'] ?></span>
            </p>
        </div>
    </section>
    <?php if ($numDownloads > 0) { ?>
        <section class="cards cards--document">
            <div class="card card--document">
                <i class="bi bi-file-earmark-arrow-down"></i>
                <h3 class="card-title">Total de descargas</h3>
                <p class="card-text"><?php echo $numDownloads ?></p>
            </div>
        </section>

        <section>
            <h2 class="chart-header">Día con más descargas: <span class="date"><?php echo $topDay['day'] ?></span></h2>
            <div id="top-download-day-chart-container" class="chart-container">
                <canvas id="top-download-day-chart"></canvas>
            </div>
        </section>
        <section>
            <h2 class="chart-header">Descargas desde fecha de publicación hasta última descarga</h2>
            <div class="<?php echo $chartClass; ?>">
                <canvas id="downloads-since-publishment-until-last-download-chart"></canvas>
            </div>
        </section>

        <section>
            <h2 class="chart-header">Descargas por mes</h2>
            <div class="chart-container chart-container--medium">
                <canvas id="downloads-by-month-chart"></canvas>
            </div>
        </section>
    <?php } else { ?>
        <p class="message--info">
            <i class="bi bi-info-circle message--info__icon"></i>
            No hay datos de descargas para este documento
        </p>
    <?php } ?>

    <script>
        const downloadsFromTopDay = <?php echo json_encode($downloadsFromTopDay) ?>;
        renderDayWithMostDownloads(downloadsFromTopDay)

        const downloadsByDate = <?php echo json_encode($downloadsByDate) ?>;
        renderDownloadsSincePublishmentDayUntilLastDownload(downloadsByDate)

        const downloadsByMonth = <?php echo json_encode($downloadsByMonth); ?>;
        renderDownloadsByMonth(downloadsByMonth);
    </script>
<?php } else { ?>
    <?php if (!empty($error_message_documents)) { ?>
        <div class="message message--error">
            <span class="message__text"><?php echo $error_message_documents ?></span>
            <button type="button" class="btn-close">x</button>
        </div>
    <?php } else if (!empty($success_message_documents)) { ?>
        <div class="message message--success">
            <span class="message__text"><?php echo $success_message_documents ?></span>
            <button type="button" class="btn-close">x</button>
        </div>
    <?php } ?>
    <?php include_once __DIR__ . '/../../../template/includes/table-order.php'; ?>
    <?php include_once __DIR__ . '/../../../template/includes/table-filter.php'; ?>

    <section>
        <div class="table-container table-container--documents">
            <div class="table-scroll">
                <table class="table table--documents" id="documents-table">
                    <caption class="table__caption table__caption--documents">Listado de documentos</caption>
                    <thead class="table__head table__head--documents">
                        <tr class="table__row--head table__row--head--documents">
                            <th class="table__cell--header table__cell--header--documents">ID</th>
                            <th class="table__cell--header table__cell--header--documents">Código</th>
                            <th class="table__cell--header table__cell--header--documents">Fecha</th>
                            <th class="table__cell--header table__cell--header--documents">Lugar</th>
                            <th class="table__cell--header table__cell--header--documents">Población</th>
                            <th class="table__cell--header table__cell--header--documents">Descargas totales</th>
                            <th class="table__cell--header table__cell--header--documents">Descripción</th>
                        </tr>
                    </thead>
                    <tbody class="table__body table__body--documents">
                        <?php foreach ($documentsFormatted as $row) { ?>
                            <tr class="table__row--body table__row--body--documents">
                                <td class="table__cell--body table__cell--body--documents">
                                    <?php echo $row['id'] . '. ' . $row['code']; ?>
                                </td>
                                <td class="table__cell--body table__cell--body--documents" data-label="ID"><?php echo $row['id'] ?></td>
                                <td class="table__cell--body table__cell--body--documents" data-label="Código">
                                    <a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=documents&sub=' . $row['id'] ?>" class="table__link"><?php echo $row['code']; ?></a>
                                </td>
                                <td class="table__cell--body table__cell--body--documents date" data-label="Fecha"><?php echo $row['date'] ?></td>
                                <td class="table__cell--body table__cell--body--documents" data-label="Lugar"><?php echo $row['place_name'] ?></td>
                                <td class="table__cell--body table__cell--body--documents" data-label="Población"><?php echo $row['city_name'] ?></td>
                                <td class="table__cell--body table__cell--body--documents" data-label="Descargas totales"><?php echo $row['downloads'] ?></td>
                                <td class="table__cell--body table__cell--body--documents" data-label="Descripción"><?php echo $row['description'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section>
        <h2 class="chart-header">Descargas por Documento</h2>
        <div class="chart-container">
            <canvas id="documents-chart"></canvas>
        </div>
    </section>
    <button type="button" class="button button--primary documents-add-button">Añadir Documento</button>
    <section class="form-section documents-form-section hidden">
        <div class="form-container">
            <form action="<?php echo SITE_URL . "layout/backend/index.php?sec=documents" ?>" method="POST" id="add-document-form" class="form" novalidate>
                <div class="form__field">
                    <label for="code" class="form__label">Código:</label>
                    <input type="text" name="code" id="code" class="form__input">
                    <span class="input__error"></span>
                </div>

                <div class="form__field">
                    <label for="date" class="form__label">Fecha:</label>
                    <input type="date" name="date" id="date" class="form__input">
                    <span class="input__error"></span>
                </div>

                <div class="form__field">
                    <label for="city" class="form__label">Población:</label>
                    <select name="city" id="city" class="select form__select">
                        <option value="" class="option">Seleccione una población</option>
                        <?php foreach ($cities as $city) { ?>
                            <option value="<?php echo $city['id'] ?>" class="option"><?php echo $city['name'] ?></option>
                        <?php } ?>
                        <option value="otro" class="option">Otro</option>
                    </select>
                    <span class="input__error"></span>
                </div>

                <div class="form__field hidden">
                    <label for="place" class="form__label">Lugar:</label>
                    <select name="place" id="place" class="select form__select">
                        <option value="" class="option">Seleccione un lugar</option>
                        <?php foreach ($places as $place) { ?>
                            <option value="<?php echo $place['id'] ?>" class="option"><?php echo $place['name'] ?></option>
                        <?php } ?>
                        <option value="otro" class="option">Otro</option>
                    </select>
                    <span class="input__error"></span>
                </div>

                <div class="form__field">
                    <label for="description" class="form__label">Descripción:</label>
                    <textarea name="description" id="description" class="form__textarea"></textarea>
                    <span class="input__error"></span>
                </div>

                <div class="form__actions">
                    <button type="reset" class="button button--secondary form__button">Vaciar</button>
                    <button type="submit" class="button button--primary form__button">Enviar</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        const documents = <?php echo json_encode($documentList); ?>;
        const downloads = <?php echo json_encode($downloadList); ?>;
        renderDownloadsByDocument(documents, downloads);
        const allPlaces = <?php echo json_encode($places); ?>;
    </script>
<?php } ?>