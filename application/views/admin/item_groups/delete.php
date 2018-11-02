<div class="container">
  <h4>
    <div class="row">
      <?php if(isset($item_group_id)) { 
        foreach($item_groups as $item_group) { ?>
      <a href="<?php echo $item_group->item_group_id; ?>" class=<?php if ($item_group_id == $item_group->item_group_id) {echo "tab_selected" ;}else{echo "tab_unselected";} ?>>
        <?php echo $item_group->name; ?>
      </a>
      <?php } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/modify_stocking_place/<?php echo $item_group_id; ?>" class="tab_unselected"><?php echo $this->lang->line('admin_modify'); ?></a>
      <a href="#" class="tab_selected"><?php echo $this->lang->line('admin_delete'); ?></a>
      <a href="<?php echo base_url(); ?>admin/new_stocking_place/" class="tab_unselected"><?php echo $this->lang->line('admin_add'); ?></a>
    <?php } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_selected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="<?php echo base_url(); ?>admin/" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </div>
  </h4>
  <?php if(isset($name) && $deletion_allowed) { ?>
  <div class="row" style="margin-top: 20px;">
    <em><?php echo $this->lang->line('delete_item_group_ok_start').$name.$this->lang->line('delete_item_group_ok_end'); ?></em>
  </div>
  <div class="btn-group row" style="margin-top: 10px;">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_item_groups/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
    <?php } else { ?>
    <em><?php  echo $this->lang->line('delete_item_group_notok_start').$name.$this->lang->line('delete_item_group_notok_end'); ?></em>
    <?php } ?>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>