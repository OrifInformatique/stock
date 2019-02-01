<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-10 well">
            <?php 
                $attributes = array("class" => "form-horizontal",
                                    "id" => "loginform",
                                    "name" => "loginform");
                echo form_open("auth/login", $attributes);
            ?>
            <fieldset>
                <legend><?= $this->lang->line('text_login'); ?></legend>
                
                <input type="hidden" id="login_form" name="login_form" value="login_form">
                
                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-sm-4">
                            <label for="username" class="control-label"><?= $this->lang->line('field_username'); ?></label>
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control" id="username" name="username" placeholder="<?= $this->lang->line('field_username'); ?>" type="text" value="<?= set_value('username'); ?>" />
                            <span class="text-danger"><?= form_error('username'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-sm-4">
                            <label for="password" class="control-label"><?= $this->lang->line('field_password'); ?></label>
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control" id="password" name="password" placeholder="<?= $this->lang->line('field_password'); ?>" type="password" value="<?= set_value('password'); ?>" />
                            <span class="text-danger"><?= form_error('password'); ?></span>
                        </div>
                    </div>
                </div>
                                  
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="<?= $this->lang->line('btn_login'); ?>" />
                        <a id="btn_cancel" class="btn btn-default" href="<?= base_url(); ?>"><?= $this->lang->line('btn_cancel'); ?></a>
                    </div>
                </div>
          </fieldset>
          <?= form_close(); ?>
          
          <!-- Status messages -->
          <div class="alert alert-danger text-center"><?= $this->session->flashdata('message-danger'); ?></div>
        </div>
    </div>
</div>