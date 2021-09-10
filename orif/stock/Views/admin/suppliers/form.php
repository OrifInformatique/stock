<?php
$validation=\Config\Services::validation();

if (isset($tags))
  $update = TRUE;
else 
  $update = FALSE;
?>
<form class="container" method="post">
  <div class="row alert alert-warning">
    <?php 
    if($update) 
      echo lang('stock_lang.admin_modify');
    else 
      echo lang('stock_lang.admin_add');
    ?>
  </div>
  
  <div class="row">
    <div class="form-input row">
      <div class="col-sm-3">
        <label for="short_name"><?= lang('stock_lang.field_short_name') ?></label>
        <input type="text" maxlength="<?= config("\Stock\Config\StockConfig")->tag_short_max_length ?>" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
        <span class="text-danger"><?= $validation->showError('short_name'); ?></span>
      </div>
      <div class="col-sm-9">
        <label for="name"><?= lang('stock_lang.field_name') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
        <span class="text-danger"><?= $validation->showError('name'); ?></span>
      </div>
    </div>
  </div>

  <!-- FORM BUTTONS -->
  <div class="row">
    <div class="col text-right">
      <a class="btn btn-default" href="<?= base_url('stock/admin/view_tags'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
      <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
    </div>
  </div>
</form>
