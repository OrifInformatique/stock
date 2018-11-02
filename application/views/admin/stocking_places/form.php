<div class="container">
  <h3 class="xs-right">
    <?php
    if (isset($stocking_places)) {
      $update = TRUE;
    } else {
      $update = FALSE;
    } ?>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_selected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </div>
    <?php if($update) { ?>
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
      <?php echo validation_errors(); 
      if (isset($upload_errors)) 
      {
        echo $upload_errors;
      }
      ?>
    </div>
<?php } ?>
    <div class="row">
      <form class="container row" method="post">
        <div class="form-input">
          <label for="short"><?php echo $this->lang->line('field_short_name') ?></label>
          <input type="text" class="form-control" name="short" id="short" value="<?php if (isset($short)) {echo set_value('short',$short);} else {echo set_value('short');} ?>" />
        </div>
        <div class="form-input">
          <label for="name"><?php echo $this->lang->line('field_long_name') ?></label>
          <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
        </div>
        <br />
        <button type="submit" class="btn btn-success"><?php echo $this->lang->line('btn_submit'); ?></button>
        <a class="btn btn-danger" href="<?php echo base_url() . "admin/view_stocking_places/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
