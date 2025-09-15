<?php
if (isset($_GET['sec'])) {
    $sec = $_GET['sec'];
} else if (isset($_POST['sec'])) {
    $sec = $_POST['sec'];
}
if (isset($_GET['sub'])) {
    $sub = $_GET['sub'];
} else if (isset($_POST['sub'])) {
    $sub = $_POST['sub'];
}