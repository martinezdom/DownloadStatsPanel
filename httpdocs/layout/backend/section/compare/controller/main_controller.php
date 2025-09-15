<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/main_config.php';
include_once DOCUMENT_ROOT . "layout/backend/section/documents/functions/main.php";
include_once DOCUMENT_ROOT . "layout/backend/section/downloads/functions/main.php";

$selectedDocuments = isset($_POST['documents']) ? $_POST['documents'] : [];
$documents = [];

if (isset($_GET['sec']) && $_GET['sec'] == 'compare') {
    if ($selectedDocuments) {
        foreach ($selectedDocuments as $documentId) {
            if ($documentId != null) {
                $document = getDocuments($documentId);
                if ($document) {
                    $documents[] = $document;
                }
            }
        }
    }
}

while (count($selectedDocuments) < 2) {
    $selectedDocuments[] = "";
}

if (!empty($documents)) {
    $documentIds = array_column($documents, 'id');
    $downloadsEvolution = getDownloadsEvolutionByDocuments($documentIds);
    $downloadsBySelectedDocuments = getDownloadsByDocumentIds($documentIds);
    $downloadsByHour = getDownloadsByHourForDocuments($documentIds);
}