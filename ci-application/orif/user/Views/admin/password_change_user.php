<?php
/**
 * password_change_user view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
$validation=\Config\Services::validation();
// Required for config values
?>
<div class="container">
    <?php
        $attributes = array(
            'id' => 'user_change_password_form',
            'name' => 'user_change_password_form'
        );
        echo form_open('user/admin/password_change_user/'.$user['id'], $attributes);
    ?>
    
    <!-- TITLE -->
    <div class="row">
        <div class="col-12">
            <h1 class="title-section"><?= lang('user_lang.title_user_password_reset'); ?></h1>
            <h4><?= lang('user_lang.user')." : ".esc($user['username']) ?></h4>
        </div>
    </div>
    
    <!-- ERROR MESSAGES -->
    <?php foreach ($errors as $error) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php } ?>
    
    <!-- PASSWORD -->    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('user_lang.field_new_password'), 'password_new', ['class' => 'form-label']); ?>
                <?= form_password('password_new', '', [
                    'class' => 'form-control', 'id' => 'password_new',
                    'maxlength' => config('\User\Config\UserConfig')->password_max_length
                ]); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('user_lang.field_password_confirm'), 'password_confirm', ['class' => 'form-label']); ?>
                <?= form_password('password_confirm', '', [
                    'class' => 'form-control', 'id' => 'password_confirm',
                    'maxlength' => config('\User\Config\UserConfig')->password_max_length
                ]); ?>
            </div>
        </div>
    </div>

    <!-- SUBMIT / CANCEL -->
    <div class="row">
        <div class="col-12 text-right">
            <a name="cancel" class="btn btn-secondary" href="<?= base_url('user/admin/list_user'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
            &nbsp;
            <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
