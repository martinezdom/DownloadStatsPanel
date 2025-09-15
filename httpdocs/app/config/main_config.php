<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once "common_vars.php";
include_once "connect_db.php";

foreach (glob(DOCUMENT_ROOT . "layout/backend/functions/*.php") as $file) {
    include_once $file;
}

foreach (glob(DOCUMENT_ROOT . "layout/backend/section/*/controller/*.php") as $file) {
    include_once $file;
}

