<?php
$validation=\Config\Services::validation();

if (isset($stocking_place))
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
        <label for="short"><?= lang('stock_lang.field_short_name') ?></label>
        <input type="text" maxlength="<?= config("\Stock\Config\StockConfig")->stocking_short_max_length ?>" class="form-control" name="short" id="short" value="<?php if (isset($stocking_place['short'])) {echo set_value('short',$stocking_place['short']);} else {echo set_value('short');} ?>" />
        <span class="text-danger"><?= $validation->showError('short'); ?></span>
      </div>
      <div class="col-sm-9">
        <label for="name"><?= lang('stock_lang.field_name') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($stocking_place['name'])) {echo set_value('name',$stocking_place['name']);} else {echo set_value('name');} ?>" />
        <span class="text-danger"><?= $validation->showError('name'); ?></span>
      </div>
    </div>
  </div>

  <!-- ACTIVATE / DISABLE EXISTING STOCKING_PLACE -->
  <?php if ($update): ?>
    <div class="row pt-3">
      <?php if ( ! is_null($stocking_place['archive'])): ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/reactivate_stocking_place/' . $stocking_place['stocking_place_id']) ?>">
            <?= lang('stock_lang.reactivate_stocking_place') ?>
          </a>
        </div>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_stocking_place/' . $stocking_place['stocking_place_id']) ?>" class="text-danger">
            <?= lang('stock_lang.hard_delete_stocking_place') ?>
          </a>
        </div>
      <?php else: ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_stocking_place/' . $stocking_place['stocking_place_id']) ?>" class="text-danger">
            <?= lang('stock_lang.delete_stocking_place') ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- FORM BUTTONS -->
  <div class="row">
    <div class="col text-right">
      <a class="btn btn-default" href="<?= base_url('stock/admin/view_stocking_places'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
      <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
    </div>
  </div>
</form>
