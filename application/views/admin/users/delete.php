<div class="container">
  <h4 class="xs-right">
    <div class="row">
      <?php foreach($users as $user) { 
        if(is_null($user->user_id)) { ?>
      <a href="<?php echo $user->user_id; ?>" class=<?php if ($user_id == $user->user_id) {echo '"tab_selected"'; echo " selected";}else{echo '"tab_unselected"';} ?>>
        <?php echo $user->username; ?>
      </a>
      <?php } } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <?php if(is_null($user->user_id)){ ?>
      <a href="<?php echo base_url(); ?>admin/modify_user/<?php echo $user_id; ?>" class="tab_unselected"><?php echo $this->lang->line('admin_modify'); ?></a>
    <?php } ?>
      <a href="#" class="tab_selected"><?php echo $this->lang->line('admin_delete'); ?></a>
      <a href="<?php echo base_url(); ?>admin/new_user/" class="tab_unselected"><?php echo $this->lang->line('admin_add'); ?></a>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_selected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="<?php echo base_url(); ?>admin/" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </div>
  </h4>
  <?php  if(isset($username)) { ?>
  <div class="row" style="margin-top: 20px;">
    <em><?php echo $this->lang->line('admin_delete_user_verify'); ?>"<?php echo $username; ?>" ?</em>
  </div>
  <div class="btn-group row" style="margin-top: 10px;">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_users/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
    <a href="<?php echo base_url().uri_string()."/d";?>" class="btn btn-warning btn-lg"><?php echo $this->lang->line('admin_desactivate_user'); ?></a>
  </div>
    <?php }else{ ?>
    <div class="row text-danger">
      <?php echo $this->lang->line('admin_error_missing_user'); ?>
    </div><?php } ?>
</div>