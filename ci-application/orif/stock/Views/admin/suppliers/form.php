<?php
$validation=\Config\Services::validation();

if (isset($supplier))
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
    <div class="col-sm-6 pl-0">
      <label for="name"><?= lang('stock_lang.field_name') ?></label>
      <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($supplier['name'])) {echo set_value('name',$supplier['name']);} else {echo set_value('name');} ?>" />
      <span class="text-danger"><?= $validation->showError('name'); ?></span>
    </div>
  </div>
  <div class="row pt-3">
    <div class="col-sm-6 pl-0">
      <label for="address_line1"><?= lang('stock_lang.field_first_address_line') ?></label>
      <input type="text" class="form-control" name="address_line1" id="address_line1" value="<?php if (isset($supplier['address_line1'])) {echo set_value('address_line1',$supplier['address_line1']);} else {echo set_value('address_line1');} ?>" />
      <span class="text-danger"><?= $validation->showError('address_line1'); ?></span>
    </div>
    <div class="col-sm-6 pr-0">
      <label for="address_line2"><?= lang('stock_lang.field_second_address_line') ?></label>
      <input type="text" class="form-control" name="address_line2" id="address_line2" value="<?php if (isset($supplier['address_line2'])) {echo set_value('address_line2',$supplier['address_line2']);} else {echo set_value('address_line2');} ?>" />
      <span class="text-danger"><?= $validation->showError('address_line2'); ?></span>
    </div>
  </div>
  <div class="row pt-3">
    <div class="col-sm-2 pl-0">
      <label for="zip"><?= lang('stock_lang.field_zip') ?></label>
      <input type="text" class="form-control" name="zip" id="zip" value="<?php if (isset($supplier['zip'])) {echo set_value('zip',$supplier['zip']);} else {echo set_value('zip');} ?>" />
      <span class="text-danger"><?= $validation->showError('zip'); ?></span>
    </div>
    <div class="col-sm-10 pr-0">
      <label for="city"><?= lang('stock_lang.field_city') ?></label>
      <input type="text" class="form-control" name="city" id="city" value="<?php if (isset($supplier['city'])) {echo set_value('city',$supplier['city']);} else {echo set_value('city');} ?>" />
      <span class="text-danger"><?= $validation->showError('city'); ?></span>
    </div>
  </div>
  <div class="row pt-3">
    <div class="col-sm-6 pl-0">
      <label for="country"><?= lang('stock_lang.field_country') ?></label>
      <input type="text" class="form-control" name="country" id="country" value="<?php if (isset($supplier['country'])) {echo set_value('country',$supplier['country']);} else {echo set_value('country');} ?>" />
      <span class="text-danger"><?= $validation->showError('country'); ?></span>
    </div>
  </div>
  <div class="row pt-3">
    <div class="col-sm-6 pl-0">
      <label for="tel"><?= lang('stock_lang.field_tel') ?></label>
      <input type="text" class="form-control" name="tel" id="tel" value="<?php if (isset($supplier['tel'])) {echo set_value('tel',$supplier['tel']);} else {echo set_value('tel');} ?>" />
      <span class="text-danger"><?= $validation->showError('tel'); ?></span>
    </div>
    <div class="col-sm-6 pr-0">
      <label for="email"><?= lang('stock_lang.field_email') ?></label>
      <input type="text" class="form-control" name="email" id="email" value="<?php if (isset($supplier['email'])) {echo set_value('email',$supplier['email']);} else {echo set_value('email');} ?>" />
      <span class="text-danger"><?= $validation->showError('email'); ?></span>
    </div>
  </div>

<!-- ACTIVATE / DISABLE EXISTING STOCKING_PLACE -->
<?php if ($update): ?>
    <div class="row pt-3">
      <?php if ( ! is_null($supplier['archive'])): ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/reactivate_supplier/' . $supplier['supplier_id']) ?>">
            <?= lang('stock_lang.reactivate_supplier') ?>
          </a>
        </div>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_supplier/' . $supplier['supplier_id']) ?>" class="text-danger">
            <?= lang('stock_lang.hard_delete_supplier') ?>
          </a>
        </div>
      <?php else: ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_supplier/' . $supplier['supplier_id']) ?>" class="text-danger">
            <?= lang('stock_lang.delete_supplier') ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- FORM BUTTONS -->
  <div class="row">
    <div class="col text-right pt-3 pl-0 pr-0">
      <a class="btn btn-secondary" href="<?= base_url('stock/admin/view_suppliers'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
      <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
    </div>
  </div>
</form>
