<?php
function updatePassword()
{
    global $link;
    if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $_SESSION['form_data'] = [
            'current_password' => $current_password,
            'new_password' => $new_password,
            'confirm_password' => $confirm_password
        ];
        if (password_verify($current_password, $_SESSION['password'])) {
            if ($new_password === $confirm_password) {
                if (!isStrongPassword($new_password)) {
                    $_SESSION['error_message_profile'] = "La contraseña debe tener al menos 3 letras, 3 cifras y 1 carácter especial.";
                    header("Location: " . SITE_URL . "layout/backend/index.php?sec=profile&sub=edit");
                    exit;
                }
                $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
                $userId = $_SESSION['id'];
                $sql = "UPDATE users SET password = '$hashedPassword' WHERE id = '$userId'";
                $result = mysqli_query($link, $sql);
                if ($result) {
                    unset($_SESSION['form_data']);
                    $_SESSION['password'] = $hashedPassword;
                    $_SESSION['success_message'] = "Contraseña cambiada correctamente";
                    header("Location: " . SITE_URL . "layout/backend/index.php?sec=profile");
                    exit;
                }
            } else {
                $_SESSION['error_message_profile'] = "Las contraseñas no coinciden";
                header("Location: " . SITE_URL . "layout/backend/index.php?sec=profile&sub=edit");
                exit;
            }
        } else {
            $_SESSION['error_message_profile'] = "La contraseña actual no es correcta";
            header("Location: " . SITE_URL . "layout/backend/index.php?sec=profile&sub=edit");
            exit;
        }
    }
}

function isStrongPassword($password) {
    $letters = preg_match_all('/[a-zA-Z]/', $password);
    $digits = preg_match_all('/\d/', $password);
    $special = preg_match('/[^a-zA-Z\d]/', $password);

    return $letters >= 3 && $digits >= 3 && $special >= 1;
}