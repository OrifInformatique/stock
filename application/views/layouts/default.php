<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $template['title']; ?></title>
    <?php echo $template['metadata']; ?>
    <link href="<?php echo base_url('assets/bootstrap/dist/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <?php echo css('style.css') ?>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('home'); ?>">CodeIgniter V : <?php echo CI_VERSION; ?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

            </ul>
        </div>
    </div>
</nav>

<!-- http://www.tech-faq.com/display-messages-using-flashdata-in-codeigniter.html -->
<?php if ($this->session->flashdata('message')): ?>
    <div class="container">
        <div class="alert alert-message alert-success">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    </div>
<?php endif; ?>

<!-- Start Body -->
<?php echo $template['body']; ?>
<!-- END Body -->

<footer class="footer">
    <div class="container">
        <p class="text-center text-muted">Jeffrey Mostroso &copy;2015 - CRUDIGNITER - Tous droits
            réservés</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript
================================================== 
Placed at the end of the document so the pages load faster -->
<?php echo jquery('1.11.3') // embed minified jquery version from google CDN with local failover  ?>
<?php echo js('bootstrap.min.js') ?>

<script>
    <
    !--http
    ://stackoverflow.com/questions/7643308/how-to-automatically-close-alerts-using-twitter-bootstrap -->
    window.setTimeout(function () {
        $(".alert-message").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);
</script>

</body>
</html>


