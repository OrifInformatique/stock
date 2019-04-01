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
  <?php } else { ?>
    <div class="alert alert-danger"><?php echo $this->lang->line('delete_notok_with_amount'); ?></div>
    <?php if (!empty($items)) { ?>
      <h2><?= $this->lang->line('admin_delete_objects_list'); ?></h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th><?php echo html_escape($this->lang->line('header_item_name')); ?></th>
            <th nowrap><?php echo html_escape($this->lang->line('header_stocking_place')); ?></th>
            <th nowrap>
            <?php
              echo html_escape($this->lang->line('header_inventory_nb'));
              echo '<br />'.html_escape($this->lang->line('header_serial_nb'));
            ?>
            </th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item) {
            if(empty($item)) continue; ?>
            <tr>
              <td>
                <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->name); ?></a>
                <h6><?php echo html_escape($item->description); ?></h6>
              </td>
              <td><?php echo get_stocking_place($item->stocking_place_id, $stocking_places); ?></td>
              <td>
                <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->inventory_number); ?></a>
                <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->serial_number); ?></a>
              </td>
              <td>
                <!-- No need to check for admin, you need to be one to be here. -->
                <a href="<?php echo base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="<?php echo $this->lang->line('admin_delete_item');?>">×</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <div>
        <a href="<?php echo base_url('admin/unlink_item_group/').$item_group_id; ?>" class="btn btn-danger"><?= $this->lang->line('admin_unlink'); ?></a>
      </div>
    <?php } }
  /**
  * Returns the stocking place's name.
  * @param integer $stocking_place_id
  *   The ID of the stocking place.
  * @param array $stocking_places
  *   The stocking places.
  * @return string
  *   The name of the stocking place.
  */
  function get_stocking_place(?int $stocking_place_id, array $stocking_places) {
    if($stocking_place_id == 0)
      return '';
    foreach ($stocking_places as $stocking_place) {
      if ($stocking_place->stocking_place_id == $stocking_place_id)
        return $stocking_place->name;
    }
  }
  ?>
</div>
