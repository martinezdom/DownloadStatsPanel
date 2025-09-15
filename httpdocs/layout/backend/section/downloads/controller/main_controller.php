<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/main_config.php';
include_once DOCUMENT_ROOT . "layout/backend/section/downloads/functions/main.php";

$mostDownloadedDocument = getMostDownloadedDocument();
$dateWithMostDownloads = getDateWithMostDownloads();

$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$endDate   = isset($_POST['end_date'])   ? $_POST['end_date']   : null;

if ($startDate && $endDate) {
    $downloadsByDocumentInRange = getDownloadsByDocumentInRange($startDate, $endDate);
} else {
    $downloadsByDocumentInRange = [];
}

$orderDir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'DESC';

$downloadsFormatted = getDownloadsTable($orderDir, null);

?>
