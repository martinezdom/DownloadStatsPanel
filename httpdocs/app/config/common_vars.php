<?php
define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"] . "/");
define("SITE_URL", getenv("SITE_URL") ?: "http://downloadstatspanel.local/");
define("IMAGE_PATH", SITE_URL . "layout/backend/images/");
define("TEMPLATE_PATH", DOCUMENT_ROOT . "layout/backend/template/");
define("ADMIN_SLUG", "backend/");
define("ADMIN_URL", SITE_URL . ADMIN_SLUG);
define("ADMIN_PATH", DOCUMENT_ROOT . "layout/" . ADMIN_SLUG);
define("SECTION_PATH", DOCUMENT_ROOT . "layout/" . ADMIN_SLUG . "section/");

$sec = "";
$sub = "";

define("DB_SERVER", getenv("DB_SERVER") ?: "localhost");
define("DB_USER", "root");
define("DB_PASS", "example1234");
define("DB_DATABASE", "download_stats_panel");
define("DB_CHARSET", "utf8mb4");
