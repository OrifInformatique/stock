<div class="container">
  
  <div class="row" >
    <h3>
      <a href="<?= base_url(); ?>admin/view_users" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
      <a href="<?= base_url(); ?>admin/view_tags" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="<?= base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="<?= base_url(); ?>admin/view_suppliers" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="<?= base_url(); ?>admin/view_item_groups" class="tab_selected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  
  <?php if(isset($name) && $deletion_allowed) { ?>
    <div class="row" >
      <?= lang('admin_delete_item_group_verify').$name.' ?'; ?>
    </div>
    <div class="btn-group row" >
      <a href="<?= base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
      <a href="<?= base_url()."admin/view_item_groups/";?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
    </div>
  <?php } else { 
    echo lang('delete_notok_with_amount').$amount;
    
    if($amount > 1) {
      echo lang('delete_notok_items');
    } else {
      echo lang('delete_notok_item');
    } 
  } ?>
</div>
