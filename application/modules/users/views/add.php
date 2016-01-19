<div class="row">
    <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                User Form
            </div>
            <div class="panel-body">
                <div id="the-message"></div>

                <?php echo form_open("users/save", ["id" => "form-user", "class" => "form-horizontal"]) ?>
                <div class="form-group">
                    <label for="username" class="col-md-3 col-sm-4 control-label">Username</label>
                    <div class="col-md-9 col-sm-8">
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-md-3 col-sm-4 control-label">Email</label>
                    <div class="col-md-9 col-sm-8">
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-md-3 col-sm-4 control-label">Password</label>
                    <div class="col-md-9 col-sm-8">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirm" class="col-md-3 col-sm-4 control-label">Password Confirm</label>
                    <div class="col-md-9 col-sm-8">
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-3 col-sm-offset-3 col-sm-4">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>