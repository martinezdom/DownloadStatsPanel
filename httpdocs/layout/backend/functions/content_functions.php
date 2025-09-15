<?php
function active_section($section, $file, $view = "", $controller = null)
{
    if ($section == "") {
        $section = "home";
    }
    $include = null;
    switch ($file) {
        case "sec_main_controller":
            $include = "section/" . $section . "/main.php";
            break;
        case "functions":
            $include = "section/" . $section . "/functions/main.php";
            if (!file_exists($include)) {
                $include = null;
            }
            break;
        case "sec_sub_controller":
            $include = "section/" . $section . "/controller/" . ($controller != null ? $controller : $view);
            break;
        case "view":
            $include = "section/" . $section . "/view/" . $view;
            break;
    }
    return $include;
}
