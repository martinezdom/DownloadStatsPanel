<?php
function isAuthenticated() {
    return isset($_SESSION['userLoggedIn']);
}

function redirectToLogin() {
    header("Location: " . SITE_URL . "layout/backend/login.php");
    exit;
}

function logout() {
    session_unset();
    session_destroy();
    header("Location: " . SITE_URL . "layout/backend/login.php");
    exit;
}