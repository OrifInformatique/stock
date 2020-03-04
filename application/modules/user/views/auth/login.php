<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-10 well">
            <?php 
                $attributes = array("class" => "form-horizontal",
                                    "id" => "loginform",
                                    "name" => "loginform");
                echo form_open("user/auth/login", $attributes);
            ?>
            <fieldset>
                <legend><?= lang('title_page_login'); ?></legend>
                
                <!-- Status messages -->
                <?php if(!is_null($this->session->flashdata('message-danger'))){ ?>
                    <div class="alert alert-danger text-center"><?= $this->session->flashdata('message-danger'); ?></div>
                <?php } ?>
                
                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-sm-4">
                            <label for="username" class="control-label"><?= lang('field_username'); ?></label>
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control" id="username" name="username" placeholder="<?= lang('field_username'); ?>" type="text" value="<?= set_value('username'); ?>" />
                            <span class="text-danger"><?= form_error('username'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-sm-4">
                            <label for="password" class="control-label"><?= lang('field_password'); ?></label>
                        </div>
                        <div class="col-sm-8">
                            <input class="form-control" id="password" name="password" placeholder="<?= lang('field_password'); ?>" type="password" value="<?= set_value('password'); ?>" />
                            <span class="text-danger"><?= form_error('password'); ?></span>
                        </div>
                    </div>
                </div>
                                  
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <a id="btn_cancel" class="btn btn-default" href="<?= base_url(); ?>"><?= lang('btn_cancel'); ?></a>
                        <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary" value="<?= lang('btn_login'); ?>" />
                    </div>
                </div>
            </fieldset>
            <?= form_close(); ?>
        </div>
    </div>
</div>
