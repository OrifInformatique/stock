<div class="container">
    <div class="row">
        <h3>
            <a href="<?= base_url(); ?>admin/view_generic/user" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/tag" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/stocking_place" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/supplier" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/item_group" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
        </h3>
    </div>

    <div class="row">
        <form method="post">
            <div class="form-group">
                <label for="new_user"><?php echo $this->lang->line('admin_relink_user_loans') ?></label>
                <select class="form-control" name="new_user">
                    <?php
                    $user_index = array_search($user, $new_users);
                    unset($new_users[$user_index]);
                    foreach ($new_users as $new_user) { ?>
                    <option value="<?php echo $new_user->user_id; ?>"><?php echo $new_user->username; ?></option>
                    <?php } ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger btn-lg"><?php echo $this->lang->line('btn_save'); ?></button>
            <a class="btn btn-lg" href="<?php echo base_url()."admin/delete_user/".$user->user_id; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
        </form>
    </div>
</div>