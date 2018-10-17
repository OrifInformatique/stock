<div class="container">
  <h1 class="xs-right">
    <select id="rows" onchange="changeRow()" style="text-align: right;">
      <?php foreach($users as $user) { ?>
      <option value="<?php echo $user->user_id; ?>"<?php if ($user_id == $user->user_id) {echo " selected";} ?>>"<?php echo $user->username; ?>"</option>
      <?php } ?>
    </select>, 
    <select id="actions" onchange="changeAction()">
      <option value="delete">Suppression</option>
      <option value="modify">Modification</option>
      <option value="new">Ajout</option>
    </select>, 
    <select onchange="changeRegion()" id="regions" style="border:none;width:205px;">
      <option value="user"><?php echo $this->lang->line('admin_tab_users'); ?></option>
      <option value="tag"><?php echo $this->lang->line('admin_tab_tags'); ?></option>
      <option value="stocking_place"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></option>
      <option value="supplier"><?php echo $this->lang->line('admin_tab_suppliers'); ?></option>
      <option value="item_group"><?php echo $this->lang->line('admin_tab_item_groups'); ?></option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">
      <span class="word-administration"><?php echo $this->lang->line('admin_tab_admin'); ?></span>
    </a>
  </h1>

  <div>
    <em><?php echo $this->lang->line('admin_delete_user_verify'); ?>"<?php echo $username; ?>" ?</em>
  </div>
  <div class="btn-group">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_users/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
    <?php if($is_active == 1) { ?>
    <a href="<?php echo base_url().uri_string()."/d";?>" class="btn btn-warning btn-lg"><?php echo $this->lang->line('admin_desactivate_user'); ?></a>
    <?php } ?>
  </div>
</div>