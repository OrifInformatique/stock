<div class="container">
  
  <div class="row" >
    <h3>
      <a href="<?= base_url(); ?>admin/view_users" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
      <a href="<?= base_url(); ?>admin/view_tags" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="<?= base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="<?= base_url(); ?>admin/view_suppliers" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="<?= base_url(); ?>admin/view_item_groups" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  
  <?php if(is_null($action) && $deletion_allowed) { ?>
    <div class="row" >
      <?= lang('admin_delete_user_verify').'"'.$username.'" ?'; ?>
    </div>
    <div class="btn-group row" >
      <a href="<?= base_url().uri_string()."/delete";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
      <a href="<?= base_url()."admin/view_users/";?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
      <?php if($is_active) { ?>
        <a href="<?= base_url().uri_string()."/disable";?>" class="btn btn-warning btn-lg"><?= lang('text_disable'); ?></a>
      <?php } ?>
    </div>
  <?php } else { ?>
    <div class="alert alert-danger"><?= $this->lang->line('delete_user_notok'); ?></div>
    <?php if(!empty($items)) { ?>
      <h2>Objets</h2>
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
                <a href="<?php echo base_url('/item/view/').$item->item_id ?>" style="display:block"><?php echo html_escape($item->name); ?></a>
                <h6><?php echo html_escape($item->description); ?></h6>
              </td>
              <td><?php echo get_stocking_place($item->stocking_place_id, $stocking_places); ?></td>
              <td>
                <a href="<?php echo base_url('/item/view/').$item->item_id ?>">
                  <div><?php echo html_escape($item->inventory_number); ?></div>
                  <div><?php echo html_escape($item->serial_number); ?></div>
                </a>
              </td>
              <td>
                <!-- No need to check for admin, you need to be one to be here. -->
                <a href="<?php echo base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="<?php echo $this->lang->line('admin_delete_item');?>">×</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php if(!empty($loans))
        echo '<hr>';
    } ?>
    <?php if(!empty($loans)) { ?>
      <h2>Prêts</h2>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th><?php echo html_escape($this->lang->line('header_loan_date')); ?></th>
            <th><?php echo html_escape($this->lang->line('header_loan_planned_return')); ?></th>
            <th><?php echo $this->lang->line('header_loan_real_return'); ?></th>
            <th><?php echo $this->lang->line('header_loan_localisation'); ?></th>
            <th><?php echo $this->lang->line('header_loan_by_user'); ?></th>
            <th><?php echo $this->lang->line('header_loan_to_user'); ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($loans as $loan) {
            if(empty($loan)) continue; ?>
            <tr><div style="width:100%;height:100%">
              <td><a href="<?php echo base_url('/item/modify_loan').'/'.$loan->loan_id ?>"><?php echo $loan->date; ?></a></td>
              <td><?php echo $loan->planned_return_date; ?></td>
              <td><?php echo $loan->real_return_date; ?></td>
              <td><?php echo $loan->item_localisation; ?></td>
              <td><?php echo get_user($loan->loan_by_user_id, $users); ?></td>
              <td><?php echo get_user($loan->loan_to_user_id, $users); ?></td>
              <td><a href="<?php echo base_url('/item/delete-loan').'/'.$loan->loan_id ?>" class="close" title="<?php echo $this->lang->line('admin_delete_loan'); ?>">×</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
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
  function get_stocking_place(int $stocking_place_id, array $stocking_places) {
    if($stocking_place_id == 0)
      return '';
    foreach ($stocking_places as $stocking_place) {
      if ($stocking_place->stocking_place_id == $stocking_place_id)
        return $stocking_place->name;
    }
  }
  /**
  * Returns the user's name.
  * @param integer $user_id
  *   The user's ID.
  * @param array $users
  *   The users.
  * @return string
  *   The user's name.
  */
  function get_user(int $user_id, array $users) {
    if($user_id == 0)
      return '';
    foreach ($users as $user) {
      if ($user->user_id == $user_id)
        return $user->username;
    }
  }
  ?>
</div>