<div class="container">
  <h3>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_selected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </div>
  </h3>
  <?php if(isset($name) && $deletion_allowed) { ?>
  <div class="row" style="margin-top: 20px;">
    <em><?php echo $this->lang->line('delete_item_group_ok_start').$name.$this->lang->line('delete_item_group_ok_end'); ?></em>
  </div>
  <div class="btn-group row" style="margin-top: 10px;">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_item_groups/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
    <?php } else { ?>
    <em><?php  echo $this->lang->line('delete_notok'); ?></em>
    <?php } ?>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>