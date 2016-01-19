<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">test</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class=""><a href="<?= site_url('home'); ?>">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($this->session->userdata("logged_in")): ?>
                    <li><a href="<?= site_url("authentification/logout") ?>">Logout</a></li>
                <?php else : ?>
                    <li><a href="<?= site_url("authentification/login") ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>