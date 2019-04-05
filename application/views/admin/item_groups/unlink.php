<div class="container">
    <div class="row">
        <h3>
            <a href="<?= base_url(); ?>admin/view_generic/user" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/tag" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/stocking_place" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/supplier" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
            <a href="<?= base_url(); ?>admin/view_generic/item_group" class="tab_selected"><?= lang('admin_tab_item_groups'); ?></a>
        </h3>
    </div>

    <div class="row">
        <?= lang('admin_unlink_item_group_verify').'"'.$name.'" ?'; ?>
    </div>
    <div class="btn-group row" >
        <a href="<?= base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
        <a href="<?= base_url()."admin/delete_item_group/".$item_group_id;?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
    </div>
</div>