<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Download Stats Panel</title>
<link rel="icon" type="image/x-icon" href="<?php echo SITE_URL . "layout/backend/images/icons/favicon.ico" ?>" />
<link rel="stylesheet" href="<?php echo SITE_URL . "layout/backend/style/main.css" ?>">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<?php if (isset($_SESSION['userLoggedIn'])) { ?>
    <script src="<?php echo SITE_URL ?>layout/backend/js/main.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <?php if ($sec == 'profile' && $sub == 'edit') { ?>
        <script src="<?php echo SITE_URL ?>layout/backend/js/change_password_validator.js"></script>
    <?php } ?>
    <?php if ($sec != 'profile') { ?>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php } ?>
    <?php if ($sec == 'documents' || $sec == 'downloads') { ?>
        <script src="<?php echo SITE_URL ?>layout/backend/js/search.js"></script>
    <?php } ?>
    <?php if ($sec == 'downloads') { ?>
        <script src="<?php echo SITE_URL ?>layout/backend/js/range_validator.js"></script>
    <?php } ?>
    <?php if ($sec == 'documents' || $sec == 'home' || $sec == 'downloads' || $sec == 'compare') { ?>
        <script src="<?php echo SITE_URL ?>layout/backend/js/chart.js"></script>
    <?php } ?>
    <?php if ($sec == 'compare') { ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="<?php echo SITE_URL ?>layout/backend/js/compare.js"></script>
    <?php } ?>
    <?php if ($sec == 'documents') { ?>
        <script src="<?php echo SITE_URL ?>layout/backend/js/add_document_validator.js"></script>
    <?php } ?>
<?php } else { ?>
    <script>
        const SITE_URL = "<?php echo SITE_URL; ?>"
    </script>
    <script src="<?php echo SITE_URL ?>layout/backend/js/login_validator.js"></script>
<?php } ?>