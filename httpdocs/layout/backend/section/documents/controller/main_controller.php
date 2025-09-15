<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/main_config.php';
include_once DOCUMENT_ROOT . "layout/backend/section/documents/functions/main.php";
include_once DOCUMENT_ROOT . "layout/backend/section/downloads/functions/main.php";
if (isset($_GET['sec']) && $_GET['sec'] == 'documents' && isset($_GET['sub']) && is_numeric($_GET['sub'])) {
    $id = $_GET['sub'];
    $document = getDocuments($id);
    if (!$document) {
        $_SESSION['error_message_documents'] = "El documento con ID $id no existe.";
        header("Location: " . SITE_URL . "layout/backend/index.php?sec=documents");
        exit;
    }
    $numDownloads = getDownloads($id);
    $placeName = $document['place_id'] != null ? getPlaceNameByPlaceId($document['place_id']) : '';
    $cityName = $document['city_id'] != null ? getCityNameByCityId($document['city_id']) : '';
    $downloads = getDownloads($id);
    $topDay = getDayWithMostDownloadsByDocumentId($id);

    if ($topDay && isset($topDay['day'])) {
        $downloadsFromTopDay = getDownloadsByDayAndDocumentId($topDay['day'], $id);
    } else {
        $downloadsFromTopDay = [];
    }
    $downloadsByDate = getDownloadsByDateRange($id);
    $downloadsByMonth = getDownloadsByMonth($id);
} else {
    if (isset($_GET['order_by']) && isset($_GET['order_dir'])) {
        $orderBy = $_GET['order_by'];
        $orderDir = $_GET['order_dir'];
    } else {
        $orderBy = 'date';
        $orderDir = 'DESC';
    }
    $documentsFormatted = getDocumentListFormattedToTable($orderDir, null, $orderBy);
    $documentList = getDocuments();
    $downloadList = getDownloads();
    $cities = getAllCities();
    $places = getAllPlaces();

    if (isset($_GET['sec']) && $_GET['sec'] == 'documents' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $code = trim($_POST['code'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $city_id = $_POST['city'] ?? null;
        $place_id = $_POST['place'] ?? null;
        $description = trim($_POST['description'] ?? '');

        if ($code === '') {
            $_SESSION['error_message_documents'] = "El código es obligatorio.";
            header("Location: " . SITE_URL . "layout/backend/index.php?sec=documents");
            exit;
        }

        addDocument($code, $date, $place_id, $city_id, $description);

        $_SESSION['success_message_documents'] = "Documento añadido correctamente.";
        header("Location: " . SITE_URL . "layout/backend/index.php?sec=documents");
        exit;
    }
}
