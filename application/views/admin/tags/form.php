<?php
if (isset($tags)) {
  $update = TRUE;
} else {
  $update = FALSE;
} ?>
<form class="container" method="post">
  <div class="row" >
    <button type="submit" class="btn btn-success"><?= lang('btn_save'); ?></button>
    <a class="btn btn-danger" href="<?= base_url() . "admin/view_tags/"; ?>"><?= lang('btn_cancel'); ?></a>    
  </div>
    
  <div class="row" >
    <h3>
      <a href="<?= base_url(); ?>admin/view_generic/user" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
      <a href="<?= base_url(); ?>admin/view_generic/tag" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="<?= base_url(); ?>admin/view_generic/stocking_place" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="<?= base_url(); ?>admin/view_generic/supplier" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="<?= base_url(); ?>admin/view_generic/item_group" class="tab_selected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
    
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
        <label for="short_name"><?= lang('field_abbreviation') ?></label>
        <input type="text" maxlength="3" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
      </div>
      <div class="col-sm-9">
        <label for="name"><?= lang('field_tag') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
      </div>
    </div>
  </div>
</form>
