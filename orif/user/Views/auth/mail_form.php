<?php
/**
 * login view
 *
 * @author      Orif (ViDi,MoDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
?>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-sm-10">
            <legend><?= lang('user_lang.title_register_account'); ?></legend>
            <?php
                $session=\Config\Services::session();
                $attributes = array("class" => "form-horizontal",
                                    "id" => "mail_form",
                                    "name" => "mail_form");
                echo form_open("user/auth/processMailForm", $attributes);
            ?>
            <fieldset>
                <!-- Status messages -->
                <?php if(!is_null($session->getFlashdata('message-danger'))){ ?>
                    <div class="alert alert-danger text-center"><?= $session->getFlashdata('message-danger'); ?></div>
                <?php } ?>
                <div class="alert alert-info">
                    <?= lang('user_lang.user_first_azure_connexion'); ?>
                </div>
                <div class="form-group">
                    <?= form_label(lang('user_lang.field_email'), 'user_email', ['class' => 'form-label']); ?>
                    <?= form_input('user_email', $correspondingEmail ?? $user_email ?? '', [
                        'maxlength' => config('\User\Config\UserConfig')->email_max_length,
                        'class' => 'form-control',
                        'id' => 'user_email'
                    ]); ?>
                </div>
                                  
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <a id="btn_cancel" class="btn btn-secondary" href="<?= base_url(); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
                        <input id="btn_login" name="btn_login" type="submit" class="btn btn-primary" value="<?= lang('user_lang.btn_next'); ?>" />
                    </div>
                </div>
                <div>
                    <?= form_hidden('azure_mail',
                    [
                        'id' => 'azure_mail',
                        'value' => $userdata['mail'] ?? $azure_mail ?? '',
                    ]); ?>
                <div>

                </div>
            </fieldset>
            <?= form_close(); ?>
        </div>
    </div>
</div>
