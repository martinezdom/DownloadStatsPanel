<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/main_config.php';
$totalDocuments = getTotalDocuments();
$totalDownloads = getTotalDownloads();
$lastDocuments = getDocumentListFormattedToTable('DESC', 5);
$lastDownloads = getDownloadsTable('DESC', 5);
$downloadsByCity = totalDownloadsByCity();
?>