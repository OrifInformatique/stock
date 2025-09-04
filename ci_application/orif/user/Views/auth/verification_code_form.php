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
        <div class="col-md-6 col-sm-10 well">
            <legend><?=$title;?></legend>
            <?php if(isset($errorMsg)): ?>
                <div class="alert alert-danger">
                    <?= $errorMsg; ?>
                    <?php if($attemptsLeft = 2): ?>
                        <div>
                            <?= $msg_attemptsLeft;?>
                        </div>
                    <?php endif ?>
                </div>
            <?php endif ?>

            <?php
                $session=\Config\Services::session();  
                $attributes = array("class" => "form-horizontal",
                                    "id" => "verificationCode",
                                    "name" => "verificationCode");
                echo form_open("user/auth/processMailForm", $attributes);
            ?>
            <fieldset>
                <!-- Status messages -->
                <?php if(!is_null($session->getFlashdata('message-danger'))){ ?>
                    <div class="alert alert-danger text-center"><?= $session->getFlashdata('message-danger'); ?></div>
                <?php } ?>
                <div class="alert alert-info">
                    <?= lang('user_lang.user_validation_code'); ?>
                </div>
                <div class="form-group">

                    <input class="form-control" id="user_verification_code" name="user_verification_code" placeholder="<?= lang('user_lang.field_verification_code'); ?>" type="text" value="<?= set_value('username'); ?>" />
                    
                </div>             
                <div class="form-group">
                    <div class="col-sm-12 text-right">
                        <a id="btn_cancel" class="btn btn-secondary" href="<?= base_url(); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
                        <input id="btn_submit" name="btn_submit" type="submit" class="btn btn-primary" value="<?= lang('user_lang.btn_next'); ?>" />
                    </div>
                </div>
                <div>
                    <?= form_hidden('user_email',
                    [
                        'id' => 'user_email',
                        'value' => $userdata['mail'] ?? $azure_mail ?? '',
                    ]); ?>
                <div>

            </fieldset>
            <?= form_close(); ?>
        </div>
    </div>
</div>
