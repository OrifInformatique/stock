<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= htmlspecialchars($template['title']); ?></title>
    <?= htmlspecialchars($template['metadata']); ?>
    <link href="<?= base_url('assets/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/jasny-bootstrap/css/jasny-bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/app/css/custom.css'); ?>" rel="stylesheet">
</head>
<body>