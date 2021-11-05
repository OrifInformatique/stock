<div class="container">
    <div class="row" >
      <?= lang('MY_application.admin_command_clean_images')."?"; ?>
    </div>
    <div class="btn-group row" >
      <a href="<?= base_url("clean_images/delete");?>" class="btn btn-danger btn-lg"><?= lang('MY_application.text_yes'); ?></a>
      <a href="<?= base_url(); ?>" class="btn btn-lg"><?= lang('MY_application.text_no'); ?></a>
    </div>
</div>
