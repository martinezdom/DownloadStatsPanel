<?php
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']);

$error_message_profile = isset($_SESSION['error_message_profile']) ? $_SESSION['error_message_profile'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error_message_profile']);
if (!empty($error_message_profile)) {
    unset($_SESSION['form_data']);
}
?>

<?php if (!empty($success_message)) { ?>
    <div class="message message--success">
        <span class="message__text"><?php echo $success_message ?></span>
        <button type="button" class="btn-close">x</button>
    </div>
<?php } ?>

<section class="form-section">
    <h1 class="title form-section__title"><?php echo isset($_GET['sub']) && $_GET['sub'] == 'edit' ? $_SESSION['username'] : "¡Hola " . $_SESSION['username'] . "!" ?></h1>
    <p class="subtitle form-section__subtitle"><?php echo isset($_GET['sub']) && $_GET['sub'] == 'edit' ? "Rellene el formulario para cambiar su contraseña" : "Aquí puede consultar su información" ?></p>

    <div class="form-container">
        <?php if (isset($_GET['sub']) && $_GET['sub'] == 'edit') { ?>
            <form action="<?php echo SITE_URL . "layout/backend/section/profile/controller/main_controller.php" ?>" method="POST" id="change-password-form" class="form">
                <?php if (!empty($error_message_profile)) { ?>
                    <div class="form-error"><?php echo $error_message_profile ?></div>
                <?php } ?>
                <div class="form__field">
                    <label for="current_password" class="form__label">Contraseña actual:</label>
                    <input type="password" name="current_password" id="current-password" class="form__input" value="<?php echo $form_data['current_password'] ?? '' ?>" required>
                    <span class="input__error"></span>
                </div>

                <div class="form__field">
                    <label for="new_password" class="form__label">Nueva contraseña:</label>
                    <input type="password" name="new_password" id="new-password" class="form__input" value="<?php echo $form_data['new_password'] ?? '' ?>" required>
                    <span class="input__error"></span>
                    <span id="password-requirements" class="password-requirements">
                        Debe tener <b>3 letras</b>, <b>3 cifras</b> y <b>1 carácter especial</b>.
                    </span>
                </div>

                <div class="form__field">
                    <label for="confirm_password" class="form__label">Confirmar nueva contraseña:</label>
                    <input type="password" name="confirm_password" id="confirm-password" class="form__input" value="<?php echo $form_data['confirm_password'] ?? '' ?>" required>
                    <span class="input__error"></span>
                </div>

                <div class="form__actions">
                    <button type="reset" class="button button--secondary form__button">Vaciar</button>
                    <button type="submit" class="button button--primary form__button">Enviar</button>
                </div>
            </form>
        <?php } else { ?>
            <div class="form__field">
                <label class="form__label">Usuario:</label>
                <div class="form__static-value"><?php echo $_SESSION['username'] ?></div>
            </div>

            <div class="form__field">
                <label class="form__label">Email:</label>
                <div class="form__static-value"><?php echo $_SESSION['email'] ?></div>
            </div>

            <div class="form__field">
                <label class="form__label">Último acceso:</label>
                <div class="form__static-value"><?php echo $_SESSION['last_login'] ?></div>
            </div>

            <div class="form__actions">
                <a href="<?php echo SITE_URL . 'layout/backend/index.php?sec=profile&sub=edit' ?>" class="button button--primary form__button">
                    Cambiar contraseña
                </a>
            </div>
        <?php } ?>
    </div>
</section>