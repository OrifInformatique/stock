<div class="container">
  <h4 class="xs-right">
    <?php 
    if(isset($missing_stocking_place)) {
      if($missing_stocking_place) {
    ?>
    <!-- Section in case of missing stocking place -->
    <div class="alert alert-danger">
      <?php echo $this->lang->line('admin_error_missing_stocking_place'); ?>
    </div>
    <a href="<?php echo base_url(); ?>admin/new_stocking_place/" class="btn btn-primary"><?php echo $this->lang->line('admin_new');?></a>

    <?php
    }} else {
    if (isset($stocking_places)) {
      $update = TRUE;
    } else {
      $update = FALSE;
    }

  // This part of the GeoLine is for Update
    if($update) { 
      ?>
    <div class="row">
      <?php foreach($stocking_places as $stocking_place) { ?>
      <a href="<?php echo $stocking_place->stocking_place_id; ?>" class=<?php if ($stocking_place_id == $stocking_place->stocking_place_id) {echo "tab_selected" ;}else{echo "tab_unselected";} ?>>
        <?php echo $stocking_place->name; ?>
      </a>
      <?php } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="#" class="tab_selected"><?php echo $this->lang->line('admin_modify'); ?></a>
      <a href="<?php echo base_url(); ?>admin/delete_stocking_place/<?php echo $stocking_place_id; ?>" class="tab_unselected"><?php echo $this->lang->line('admin_delete'); ?></a>
      <a href="<?php echo base_url(); ?>admin/new_stocking_place/" class="tab_unselected"><?php echo $this->lang->line('admin_add'); ?></a>
    </div>
    <?php
    } else { 
    ?>
    <div class="row">
    <a href="<?php echo base_url(); ?>admin/view_stocking_places">
      <span class="btn btn-primary"><?php echo $this->lang->line('admin_cancel'); ?></span>
    </a>
    </div><?php } ?>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_selected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="<?php echo base_url(); ?>admin/" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </div>
    </h4>
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
        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
        <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_stocking_places/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
      </form>
    </div>
    <?php } ?>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
