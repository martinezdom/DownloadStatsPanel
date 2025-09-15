<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/app/config/common_vars.php';
session_start();
$error_message_login = isset($_SESSION['error_message_login']) ? $_SESSION['error_message_login'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];
unset($_SESSION['error_message_login']);
if (!empty($error_message_login)) {
  unset($_SESSION['form_data']);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <?php include_once TEMPLATE_PATH . "head.php"; ?>
</head>

<body>
  <header class="header-login">
    <?php include_once TEMPLATE_PATH . "header.php"; ?>
  </header>
  <main>
    <section class="form-section">
      <h1 class="form-section__title">Iniciar sesión</h1>
      <div class="form-container">
        <?php if (!empty($error_message_login)) { ?>
          <div class="form-error"><?php echo $error_message_login ?></div>
        <?php } ?>
        <form id="login-form" action="<?php echo SITE_URL . "layout/backend/functions/login_function.php" ?>" method="post" novalidate class="form">
          <div class="form__field">
            <label for="username" class="form__label">Usuario</label>
            <input
              type="text"
              id="username"
              name="username"
              class="form__input"
              placeholder="Usuario"
              value="<?php echo isset($form_data['username']) ? $form_data['username'] : '' ?>" />
            <span class="input__error"></span>
          </div>
          <div class="form__field">
            <label for="password" class="form__label">Contraseña</label>
            <input
              type="password"
              id="password"
              name="password"
              class="form__input"
              placeholder="********"
              value="<?php echo isset($form_data['password']) ? $form_data['password'] : '' ?>" />
            <span class="input__error"></span>
          </div>
          <div class="form__actions">
            <button type="reset" class="button button--secondary form__button">Vaciar</button>
            <button type="submit" class="button button--primary form__button">Enviar</button>
          </div>
        </form>
      </div>
    </section>
  </main>
  <footer>
    <?php include_once TEMPLATE_PATH . "footer.php"; ?>
  </footer>
</body>

</html>