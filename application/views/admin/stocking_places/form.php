<?php
if (isset($stocking_places)) {
  $update = TRUE;
} else {
  $update = FALSE;
} ?>
<form class="container" method="post">
  <div class="row" >
    <button type="submit" class="btn btn-success"><?= lang('btn_save'); ?></button>
    <a class="btn btn-danger" href="<?= base_url() . "admin/view_stocking_places/"; ?>"><?= lang('btn_cancel'); ?></a>    
  </div>
    
  <?php $type = 2; include __DIR__.'/../admin_bar.php';?>
    
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
    
  <div class="row">
    <div class="form-input row">
      <div class="col-sm-3">
        <label for="short"><?= lang('field_short_name') ?></label>
        <input type="text" maxlength="<?= STOCKING_SHORT_MAX_LENGHT ?>" class="form-control" name="short" id="short" value="<?php if (isset($short)) {echo set_value('short',$short);} else {echo set_value('short');} ?>" />
      </div>
      <div class="col-sm-9">
        <label for="name"><?= lang('field_long_name') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
      </div>
    </div>
  </div>
</form>
