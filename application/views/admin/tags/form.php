<div class="container">
  <h3 class="xs-right">
    <?php 
    if (isset($tags)) {
      $update_tag = TRUE;
    } else {
      $update_tag = FALSE;
    } ?>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_selected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </div>
    <?php if($update_tag) { ?>
    <div class="row alert alert-warning">
      <?php echo $this->lang->line('admin_modify'); ?>
    </div>
    <?php } else { ?>
    <div class="row alert">
      <?php echo $this->lang->line('admin_add'); ?>
    </div>
  <?php } ?>
  </h3>
<?php
    if (!empty(validation_errors()) || !empty($upload_errors)) {
?>
  <div class="alert alert-danger">
    <?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?>
  </div>
<?php } ?>
  <div class="row">
    <form class="container" method="post">
      <div class="form-input row">
        <div class="col-sm-3 row">
            <label for="short_name">
            <?php echo $this->lang->line('field_abbreviation') ?>
            </label>
            <input type="text" maxlength="3" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
        </div>
        <div class="col-sm-9">
            <label for="name">
            <?php echo $this->lang->line('field_tag') ?>
            </label>
            <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
        </div>
    </div>
    <div class="row">
        <br />
        <button type="submit" class="btn btn-success">
          <?php echo $this->lang->line('btn_submit'); ?>
        </button>
        <a class="btn btn-danger" href="<?php echo base_url() . "admin/view_tags/"; ?>">
          <?php echo $this->lang->line('btn_cancel'); ?>
        </a> </div>
      </form>
    </div>
  </div>