<div class="container">
  
  <div class="row" >
    <h3>
      <a href="<?= base_url(); ?>admin/view_users" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
      <a href="<?= base_url(); ?>admin/view_tags" class="tab_selected"><?= lang('admin_tab_tags'); ?></a>
      <a href="<?= base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="<?= base_url(); ?>admin/view_suppliers" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="<?= base_url(); ?>admin/view_item_groups" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>

  <?php if(isset($name) && $deletion_allowed) { ?>
    <div class="row">
      <?php echo $this->lang->line('admin_delete_tag_verify').'"'.$name.'" ?'; ?>
    </div>
    <div class="btn-group col-xs-12 row" >
      <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
      <a href="<?php echo base_url()."admin/view_tags/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
    </div>
  <?php } else {
    echo $this->lang->line('delete_notok_with_amount').$amount;
    
    if($amount > 1) {
      echo $this->lang->line('delete_notok_items');
    } else {
      echo $this->lang->line('delete_notok_item');
    } 
  } ?>
</div>