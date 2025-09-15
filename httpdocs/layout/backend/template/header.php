<?php if (isset($_SESSION['userLoggedIn'])) { ?>
    <div class="header__logo" title="Inicio">
        <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=home" ?>">
            <img src="<?php echo SITE_URL . "layout/backend/images/logo.png" ?>" alt="Logotipo de la página" class="header__logo-img" />
        </a>
    </div>
    <nav>
        <button class="header__mobile-btn">
            <i class="bi bi-list"></i>
        </button>
        <ul class="header__menu">
            <li title="Inicio">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=home" ?>">
                    <i class="header__menu-icon bi bi-house<?php echo ($sec === 'home') ? ' header__menu-icon--active' : ''; ?>"></i>  
                </a>
            </li>
            <li title="Documentos">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=documents" ?>">
                    <i class="header__menu-icon bi bi-book<?php echo ($sec === 'documents') ? ' header__menu-icon--active' : ''; ?>"></i>
                </a>
            </li>
            <li title="Descargas">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=downloads" ?>">
                    <i class="header__menu-icon bi bi-download<?php echo ($sec === 'downloads') ? ' header__menu-icon--active' : ''; ?>"></i>
                </a>
            </li>
            <li title="Comparar">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=compare" ?>">
                    <i class="header__menu-icon bi bi-grid<?php echo ($sec === 'compare') ? ' header__menu-icon--active' : ''; ?>"></i>
                </a>
            </li>
            <li title="Perfil">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?sec=profile" ?>">
                    <i class="header__menu-icon bi bi-person<?php echo ($sec === 'profile') ? ' header__menu-icon--active' : ''; ?>"></i>
                </a>
            </li>
            <li class="header--item--logout" title="Cerrar sesión">
                <a href="<?php echo SITE_URL . "layout/backend/index.php?logout" ?>">
                    <i class="header__menu-icon header__menu-icon--logout bi bi-escape"></i>
                </a>
            </li>
        </ul>
    </nav>
<?php } else { ?>
    <div class="header__logo">
        <img src="<?php echo SITE_URL . 'layout/backend/images/logo.png' ?>"
            alt="Logotipo de la página"
            class="header__logo-img" />
    </div>
<?php } ?>