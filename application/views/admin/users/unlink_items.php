<div class="container">
    <div class="row">
        <h3>
            <a href="<?= base_url(); ?>admin/view_users" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
            <a href="<?= base_url(); ?>admin/view_tags" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
            <a href="<?= base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
            <a href="<?= base_url(); ?>admin/view_suppliers" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
            <a href="<?= base_url(); ?>admin/view_item_groups" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
        </h3>
    </div>

    <div class="row">
        <div class="row">
          <?= lang('admin_unlink_user_items_verify').'"'.$username.'" ?'; ?>
        </div>

        <div class="btn-group row">
            <a class="btn btn-danger btn-lg" href="<?php echo base_url().uri_string()."/confirmed"; ?>"><?php echo $this->lang->line('text_yes'); ?></a>
            <a class="btn btn-lg" href="<?php echo base_url()."admin/delete_user/".$user_id; ?>"><?php echo $this->lang->line('text_no'); ?></a>
        </div>
    </div>
</div>