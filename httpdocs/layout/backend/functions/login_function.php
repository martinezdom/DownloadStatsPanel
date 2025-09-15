<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/main_config.php';

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user = validate($_POST['username']);
    $password = validate($_POST['password']);

    $_SESSION['form_data'] = [
        'username' => $user,
        'password' => $password
    ];

    if (!empty($user) && !empty($password)) {
        $stmt = $link->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['last_login'] = date('d/m/Y H:i:s', strtotime($row['last_login']));
                $_SESSION['userLoggedIn'] = true;
                $_SESSION['password'] = $row['password'];

                $currentDateTime = date('Y-m-d H:i:s');
                $updateLastLoginSql = "UPDATE users SET last_login = ? WHERE id = ?";
                $updateStmt = $link->prepare($updateLastLoginSql);
                $updateStmt->bind_param("si", $currentDateTime, $row['id']);
                $updateStmt->execute();
                $updateStmt->close();

                unset($_SESSION['form_data']);
                header("Location: " . SITE_URL . "layout/backend/index.php?sec=home");
                exit;
            } else {
                $_SESSION['error_message_login'] = "Usuario o contraseña incorrectos.";
                header("Location: " . SITE_URL . "layout/backend/login.php");
                exit;
            }
        } else {
            $_SESSION['error_message_login'] = "Usuario o contraseña incorrectos.";
            header("Location: " . SITE_URL . "layout/backend/login.php");
            exit;
        }
        $stmt->close();
    } else {
        $_SESSION['error_message_login'] = "Todos los campos son obligatorios.";
        header("Location: " . SITE_URL . "layout/backend/login.php");
        exit;
    }
}