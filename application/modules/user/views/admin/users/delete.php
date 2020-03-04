<div class="container">
  
  <div class="row" >
    <h3>
      <a href="<?= base_url(); ?>user/admin/view_users" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
      <a href="<?= base_url(); ?>user/admin/view_tags" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="<?= base_url(); ?>user/admin/view_stocking_places" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="<?= base_url(); ?>user/admin/view_suppliers" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="<?= base_url(); ?>user/admin/view_item_groups" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  
  <?php if(is_null($action) && $deletion_allowed) { ?>
    <div class="row" >
      <?= lang('admin_delete_user_verify').'"'.$username.'" ?'; ?>
    </div>
    <div class="btn-group row" >
      <a href="<?= base_url().uri_string()."/delete";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
      <a href="<?= base_url()."user/admin/view_users/";?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
      <?php if($is_active) { ?>
        <a href="<?= base_url().uri_string()."/disable";?>" class="btn btn-warning btn-lg"><?= lang('text_disable'); ?></a>
      <?php } ?>
    </div>
  <?php } else { 
    echo '<div class="alert alert-danger">'.lang('delete_user_notok');
    foreach ($linked_objects as $linked_object) {
        echo '['.$linked_object.'] ';
    }
    echo '</div>';
  } ?>
</div>