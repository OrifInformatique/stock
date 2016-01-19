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
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class=""><a href="<?php echo site_url('home'); ?>">Home</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-content">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="http://placehold.it/120x120" alt="Alternate Text"
                                             class="img-responsive"/>
                                        <p class="text-center small">
                                            <a href="#">Change Photo</a></p>
                                    </div>
                                    <div class="col-md-7">
                                        <span>Username</span>
                                        <p class="text-muted">test@email.com</p>
                                        <div class="divider"></div>
                                        <a href="#" class="btn btn-primary btn-sm active">View Profile</a>
                                    </div>
                                </div>
                            </div>
                            <div class="navbar-footer">
                                <div class="navbar-footer-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <a href="#" class="btn btn-default btn-sm">Change Passowrd</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="http://www.jquery2dotnet.com"
                                               class="btn btn-default btn-sm pull-right">Sign Out</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>