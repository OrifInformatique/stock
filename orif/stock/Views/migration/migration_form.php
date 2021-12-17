<?php
$session = \Config\Services::session();
$validation = \Config\Services::validation();
?>

<div class="container">
    <?php echo form_open('stock/migrate/toLatest', 'password'); ?>
        <!-- TITLE -->
        <div class="row">
            <div class="col">
                <h1 class="title-section"><?= lang('migrate_lang.title_migration') ?></h1>
            </div>
        </div>

        <!-- ERROR MESSAGES -->
        <?php if ( ! is_null($session->getFlashdata('migration-error'))) : ?>
            <div class="alert alert-danger text-justify" role="alert">
                <?= $session->getFlashdata('migration-error'); ?>
            </div>
        <?php endif ?>

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
                <?= form_submit('send', lang('migrate_lang.btn_migrate'), ['class' => 'btn btn-danger']); ?>
            </div>
        </div>
    <?php form_close(); ?>
</div>