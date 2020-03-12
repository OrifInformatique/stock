<?php
if (isset($suppliers)) {
  $update = TRUE;
} else {
  $update = FALSE;
} ?>
<form class="container" method="post">
  <div class="row" >
    <button type="submit" class="btn btn-success"><?= lang('btn_save'); ?></button>
    <a class="btn btn-danger" href="<?= base_url() . "admin/view_suppliers/"; ?>"><?= lang('btn_cancel'); ?></a>    
  </div>
    
  <?php $type = 3; include __DIR__.'/../admin_bar.php';?>
    
  <div class="row alert alert-warning">
    <?php if($update) {
      echo lang('admin_modify');
    } else { 
      echo lang('admin_add');
    } ?>
  </div>
  
  <?php if (!empty(validation_errors())) { ?>
    <div class="alert alert-danger"><?= validation_errors(); ?></div>
  <?php } ?>

  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_name') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_first_adress') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="address_line1" id="address_line1" value="<?php if (isset($address_line1)) {echo set_value('adress_line1',$address_line1);} else {echo set_value('address_line1');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_second_adress') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="address_line2" id="address_line2" value="<?php if (isset($address_line2)) {echo set_value('adress_line2',$address_line2);} else {echo set_value('address_line2');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_postal_code') ?></label>
    <div class="col-sm-10">
      <input type="number" min="1000" class="form-control" name="zip" id="zip" value="<?php if (isset($zip)) {echo set_value('zip',$zip);} else {echo set_value('zip');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_city') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="city" id="city" value="<?php if (isset($city)) {echo set_value('city',$city);} else {echo set_value('city');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_tel') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tel" id="tel" value="<?php if (isset($tel)) {echo set_value('tel',$tel);} else {echo set_value('tel');} ?>" />
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-2 col-form-label"><?= lang('field_email') ?></label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="email" id="email" value="<?php if (isset($email)) {echo set_value('email',$email);} else {echo set_value('email');} ?>" />
    </div>
  </div>
</form>
