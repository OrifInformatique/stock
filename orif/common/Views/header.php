<?php
/**
 * Header view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Copied from Bootstrap model https://getbootstrap.com/docs/4.6/getting-started/introduction/) -->

    <title><?php
        if (!isset($title) || is_null($title) || $title == '') {
            echo lang('common_lang.page_prefix');
        } else {
            echo lang('common_lang.page_prefix').' - '.$title;
        }
    ?></title>

    <!-- Icon -->
    <link rel="icon" type="image/png" href="<?= base_url("images/favicon.png"); ?>" />
    <link rel="shortcut icon" type="image/png" href="<?= base_url("images/favicon.png"); ?>" />

    <!-- Bootstrap  -->
    <!-- Orif Bootstrap CSS personalized with https://bootstrap.build/app -->
    <link rel="stylesheet" href="<?= base_url("css/bootstrap.min.css"); ?>" />
    <!-- jquery, popper and Bootstrap javascript -->
    <script type="text/javascript" src="<?= base_url("js/jquery.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("js/bootstrap.bundle.min.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("js/bootstrap-multiselect.js"); ?>"></script>
    <link rel="stylesheet" href="<?= base_url("css/bootstrap-multiselect.css"); ?>" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Application styles -->
    <link rel="stylesheet" href="<?= base_url("css/MY_styles.css"); ?>" />
</head>
<body>
    <?php
        if (ENVIRONMENT != 'production') {
            echo '<div class="alert alert-warning text-center">CodeIgniter environment variable is set to '.strtoupper(ENVIRONMENT).'. You can change it in .env file.</div>';
        }
    ?>