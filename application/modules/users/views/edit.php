<div class="container">

    <div class="page-header">
        <h1>Add new user</h1>
    </div>

    <?php echo form_open(); ?>

    <div class="row">

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Username : ', '', ["class" => "control-label"]); ?>
                <?php echo form_input('username', set_value('username'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

        <div class="col-lg-6">

            <div class="form-group">
                <?php echo form_label('Test : ', '', ["class" => "control-label"]); ?>
                <select class="form-control">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('First name : ', '', ["class" => "control-label"]); ?>
                <?php echo form_input('firstname', set_value('firstname'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Last name : ', '', ["class" => "control-label"]); ?>
                <?php echo form_input('lastname', set_value('lastname'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Email : ', '', ["class" => "control-label"]); ?>
                <?php echo form_input('email', set_value('email'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Email Conf : ', '', ["class" => "control-label"]); ?>
                <?php echo form_input('email', set_value('email'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Password : ', '', ["class" => "control-label"]); ?>
                <?php echo form_password('password', set_value('password'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <?php echo form_label('Password Conf : ', '', ["class" => "control-label"]); ?>
                <?php echo form_password('password', set_value('password'), ["class" => "form-control", "placeholder" => ""]); ?>
            </div>
        </div>

    </div>

    <?php echo form_submit('envoyer', 'Envoyer', ["class" => "btn btn-default"]); ?>

    <?php echo form_close(); ?>
</div>