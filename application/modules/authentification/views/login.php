<div class="container">

    <header class="page-header">
        <h1>Login</h1>
    </header>

    <?php if (validation_errors()): ?>
        <div class="alert alert-warning">
            <?php echo validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open(); ?>

    <?php echo form_label('Username : ', '', ["class" => "control-label"]); ?>
    <div class="input-group">
        <span class="input-group-addon"><li class="glyphicon glyphicon-user"></li></span>
        <?php echo form_input('username', set_value('username'), ["class" => "form-control", "placeholder" => "Username"]); ?>
    </div>

    <?php echo form_label('Password : ', '', ["class" => "control-label"]); ?>
    <div class="input-group">
        <span class="input-group-addon"><li class="glyphicon glyphicon-lock"></li></span>
        <?php echo form_password('password', set_value('password'), ["class" => "form-control", "placeholder" => "Password"]); ?>
    </div>

    <br/>

    <?php echo form_submit('envoyer', 'Envoyer', ["class" => "btn btn-default"]); ?>

    <?php echo form_close(); ?>

    <br/>

    <div class="well text-center">
        <p>Username : OrifInfo2009</p>
        <p>Password : OrifInfo2009</p>
        <p>
            <a href="<?php echo site_url('main/home') ?>">
                <li class="glyphicon glyphicon-arrow-left"></li>
                Back to Home page</a>
        </p>
    </div>

</div>