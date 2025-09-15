<?php
include_once "../../app/config/main_config.php";
if (!isAuthenticated()) {
    redirectToLogin();
}
if (isset($_GET["logout"])) {
    logout();
}
include "config/preload.php";
$functions_file = active_section($sec, "functions");
if ($functions_file && file_exists($functions_file)) {
    include_once $functions_file;
}
include_once active_section($sec, "sec_main_controller");
include_once active_section($sec, "sec_sub_controller", $view, isset($controller) ? $controller : null);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once TEMPLATE_PATH . "head.php"; ?>
</head>

<body>
    <div id="wrapper">
        <header class="header">
            <?php include_once TEMPLATE_PATH . "header.php"; ?>
        </header>
        <main>
            <?php
            render_breadcrumb($sec, isset($sub) ? $sub : null);
            include_once active_section($sec, "view", $view);
            ?>
            <button type="button" class="go-top-bottom-button"></button>
        </main>
        <footer>
            <?php include_once TEMPLATE_PATH . "footer.php"; ?>
        </footer>
    </div>
</body>

</html>