<div class="container">
  <h4 class="xs-right">
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_selected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </div>
  </h4>
  <?php  if(isset($username)) { ?>
  <div class="row" style="margin-top: 20px;">
    <em><?php echo $this->lang->line('admin_delete_user_verify').'"'.$username.'" ?'; ?></em>
  </div>
  <div class="btn-group row" style="margin-top: 10px;">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_users/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
    <a href="<?php echo base_url().uri_string()."/d";?>" class="btn btn-warning btn-lg"><?php echo $this->lang->line('admin_desactivate_user'); ?></a>
  </div>
    <?php }else{ ?>
    <div class="row">
      <div class="alert alert-danger">
        <?php echo $this->lang->line('admin_error_missing_user'); ?>
      </div>
      <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_users/"; ?>"><?php echo $this->lang->line('btn_back_to_list'); ?></a>
    </div>
  <?php } ?>
</div>