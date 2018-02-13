<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Copied from Bootstrap model (http://getbootstrap.com/getting-started/) -->
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title><?php
        if (is_null($title) || $title == '') {
            echo $this->lang->line('page_prefix');
        } else {
            echo $this->lang->line('page_prefix').' - '.$title;
        }
    ?></title>

    <!-- Icon -->
    <link rel="shortcut icon" href="<?php echo base_url("assets/images/favicon.ico"); ?>" type="image/x-icon" />

    <!-- Bootstrap  -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" />
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <!-- Bootstrap Multiselect plugin -->
    <script type="text/javascript" src="<?php echo base_url("assets/js/bootstrap-multiselect.js"); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url("assets/css/bootstrap-multiselect.css"); ?>" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Application styles -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/MY_styles.css"); ?>" />
</head>
<body>