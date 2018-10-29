<div class="container">
  <h4>
    <?php 
    if(isset($missing_item_group)){
      if($missing_item_group){
    ?>
    <!-- Section in case of missing item group -->
    <div class="alert alert-danger">
      <?php echo $this->lang->line('admin_error_missing_item_group'); ?>
    </div>
    <a href="<?php echo base_url(); ?>admin/new_item_group/" class="btn btn-primary"><?php echo $this->lang->line('admin_new'); ?></a>

    <?php
    }} else {

    if (isset($item_groups)) {
      $update = TRUE;
    } else {
      $update = FALSE;
    }

// This part of the GeoLine is for Update
    if($update) 
    { 
      ?>
    <div class="row">
      <?php foreach($item_groups as $item_group) { ?>
      <a href="<?php echo $item_group->item_group_id; ?>" class=<?php if ($item_group_id == $item_group->item_group_id) {echo "tab_selected" ;}else{echo "tab_unselected";} ?>>
        <?php echo $item_group->name; ?>
      </a>
      <?php } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="#" class="tab_selected"><?php echo $this->lang->line('admin_modify'); ?></a>
      <a href="<?php echo base_url(); ?>admin/delete_item_group/<?php echo $item_group_id; ?>" class="tab_unselected"><?php echo $this->lang->line('admin_delete'); ?></a>
      <a href="<?php echo base_url(); ?>admin/new_stocking_place/" class="tab_unselected"><?php echo $this->lang->line('admin_add'); ?></a>
    </div>
        <?php 
      } else { // This one is for Create 
      ?>
    <div class="row">
    <a href="<?php echo base_url(); ?>admin/view_item_groups">
      <span class="btn btn-primary"><?php echo $this->lang->line('admin_cancel'); ?></span>
    </a>
    </div>
    <?php } ?>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_selected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="<?php echo base_url(); ?>admin/" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </div>
  </h4>
<?php
    if (!empty(validation_errors()) || !empty($upload_errors)) {
?>
  <div class="alert alert-danger"><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></div>
<?php } ?>
    <div class="row">
      <form class="container row" method="post">
        <div class="form-input row">
            <div class="col-sm-3">
                <label for="short_name"><?php echo $this->lang->line('field_abbreviation') ?></label>
                <input type="text" maxlength="2" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
            </div>
            <div class="col-sm-9">
                <label for="name"><?php echo $this->lang->line('field_surname') ?></label>
                <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
            </div>
        </div>
        <br />
        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
        <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_item_groups/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
      </form>
    </div>
  <?php } ?>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
