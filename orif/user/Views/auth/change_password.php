<?php
/**
 * change_password view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */


?>
<div class="container">
    <div class="row">
        <div class="col-md-10 well">
            <?php
            $validation=\Config\Services::validation();
            $attributes = array("class" => "form-horizontal",
                                "id" => "change_password",
                                "name" => "change_password");
            echo form_open("user/auth/change_password", $attributes);
            ?>
            <fieldset>
                <legend><?= lang('user_lang.page_my_password_change'); ?></legend>

                <!-- ERROR MESSAGES -->
                <?php foreach ($errors as $error) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php } ?>
                
                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-md-4">
                            <label for="old_password" class="control-label"><?= lang('user_lang.field_old_password'); ?></label>
                        </div>
                        <div class="col-md-8">
                            <input id="old_password" name="old_password" type="password" class="form-control" placeholder="<?= lang('user_lang.field_old_password'); ?>" value="<?= set_value('old_password'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-md-4">
                            <label for="new_password" class="control-label"><?= lang('user_lang.field_new_password'); ?></label>
                        </div>
                        <div class="col-md-8">
                            <input id="new_password" name="new_password" type="password" class="form-control" placeholder="<?= lang('user_lang.field_new_password'); ?>" value="<?= set_value('new_password'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row colbox">
                        <div class="col-md-4">
                            <label for="confirm_password" class="control-label"><?= lang('user_lang.field_password_confirm'); ?></label>
                        </div>
                        <div class="col-md-8">
                            <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="<?= lang('user_lang.field_password_confirm'); ?>" value="<?= set_value('confirm_password'); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12 text-right">
                        <a id="btn_cancel" class="btn btn-secondary" href="<?= base_url(); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
                        <input id="btn_change_password" name="btn_change_password" type="submit" class="btn btn-primary" value="<?= lang('common_lang.btn_save'); ?>" />
                    </div>
                </div>
            </fieldset>
            <?= form_close(); ?>
        </div>
    </div>
</div>
