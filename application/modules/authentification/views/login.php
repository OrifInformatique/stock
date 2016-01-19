<section class="container">

    <section class="row">

        <?= form_open('', ['role' => 'login']); ?>
        <?php $error = form_error("username", "<p class='text-danger'>", '</p>'); ?>
        <div class="form-group <?= $error ? 'has-error' : '' ?>">
            <?= form_label('Username', 'username', ['class' => 'label-control']); ?>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <?= form_input('username', set_value('username'),
                    ["id" => 'username', "class" => "form-control", "placeholder" => "Enter your username"]); ?>
            </div>
            <?= $error; ?>
        </div>

        <?php $error = form_error("password", "<p class='text-danger'>", '</p>'); ?>
        <div class="form-group <?= $error ? 'has-error' : '' ?>">
            <?= form_label('Password', 'password', ['class' => 'label-control']); ?>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <?= form_password('password', set_value('password'),
                    ["class" => "form-control", "placeholder" => "Enter password"]); ?>
            </div>
            <?= $error; ?>
        </div>

        <div class="form-group">
            <input type="checkbox" name="remember" value="1"/> Remember me
        </div>

        <div class="well center-block" style="max-width:400px">
            <?= form_submit('envoyer', 'Se connecter', ['class' => 'btn btn-primary btn-block']); ?>
            <a href="<?= site_url(); ?>" class="btn btn-default btn-block">Retour à l'accueil</a>
        </div>

        <section>
            <a href="#">Forgot your password ?</a>
        </section>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong>
            seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </p>

        <?= form_close(); ?>
    </section>

</section>