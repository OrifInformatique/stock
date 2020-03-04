<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// Required for config values
?>
<div class="container">
    <?php
        $attributes = array(
            'id' => 'user_change_password_form',
            'name' => 'user_change_password_form'
        );
        echo form_open('user/admin/password_change_user/'.$user->id, $attributes);
    ?>
    
    <!-- TITLE -->
    <div class="row">
        <div class="col-12">
            <h1 class="title-section"><?= lang('title_user_password_reset'); ?></h1>
            <h4><?= lang('user')." : ".$user->username ?></h4>
        </div>
    </div>
    
    <!-- ERRORS -->
    <div class="row">
        <div class="col-12">
            <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
        </div>
    </div>
    
    <!-- PASSWORD -->    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('field_new_password'), 'user_password_new', ['class' => 'form-label']); ?>
                <?= form_password('user_password_new', '', [
                    'class' => 'form-control', 'id' => 'user_password_new',
                    'maxlength' => $this->config->item('password_max_length')
                ]); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('field_password_confirm'), 'user_password_again', ['class' => 'form-label']); ?>
                <?= form_password('user_password_again', '', [
                    'class' => 'form-control', 'id' => 'user_password_new',
                    'maxlength' => $this->config->item('password_max_length')
                ]); ?>
            </div>
        </div>
    </div>

    <!-- SUBMIT / CANCEL -->
    <div class="row">
        <div class="col-12 text-right">
            <a name="cancel" class="btn btn-default" href="<?= base_url('user/admin/list_user'); ?>"><?= lang('btn_cancel'); ?></a>
            &nbsp;
            <?= form_submit('save', lang('btn_save'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
