<?php
$validation=\Config\Services::validation();
?>

<div class="container">
    <form method="post">
        <!-- TITLE -->
        <div class="row">
            <div class="col">
                <h1 class="title-section"><?= lang('migrate_lang.title_migration') ?></h1>
            </div>
        </div>

        <!-- INFORMATION MESSAGE -->
        <div class="col-12 alert alert-info">
            <?= lang("migrate_lang.warning"); ?>
        </div>

        <div class="col form-group pl-0 pr-0">
            <?= form_label(lang('user_lang.field_password'), 'password', ['class' => 'form-label']); ?>
            <?= form_password('password', '', [
                'class' => 'form-control', 'id' => 'password'
            ]); ?>
            <span class="text-danger"><?= $validation->showError('password'); ?></span>
        </div>

        <!-- FORM BUTTONS -->
        <div class="row">
            <div class="col text-right">
                <a class="btn btn-default" href="<?= base_url() ?>"><?= lang('common_lang.btn_cancel'); ?></a>
                <?= form_submit('send', lang('migrate_lang.btn_send'), ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </form>
</div>