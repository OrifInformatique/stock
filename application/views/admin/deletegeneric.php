<div class="container">
    <div class="row">
        <h3>
            <?php foreach($admin_menus as $admin_menu) { ?>
                <a class="<?php
                    $class = 'tab_unselected';
                    if($admin_menu === $current_menu) {
                        $class = 'tab_selected';
                    }
                    echo $class;
                ?>" href="<?= base_url("admin/view_generic/{$admin_menu}"); ?>"><?php echo $this->lang->line("admin_tab_{$admin_menu}s"); ?></a>
            <?php } ?>
        </h3>
    </div>

    <?php if($deletion_allowed) { ?>
        <div class="row" >
          <?= lang("admin_delete_{$current_menu}_verify").'"'.$name.'" ?'; ?>
        </div>
        <div class="btn-group row" >
          <a href="<?= base_url().uri_string()."/delete";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
          <a href="<?= base_url()."admin/view_users/";?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
          <?php if($current_menu === 'user' && $is_active) { ?>
            <a href="<?= base_url().uri_string()."/disable";?>" class="btn btn-warning btn-lg"><?= lang('text_disable'); ?></a>
          <?php } ?>
        </div>
    <?php } else {

        if($current_menu === 'user' && $is_active) { ?>
        <a href="<?= base_url().uri_string()."/disable";?>" class="btn btn-warning">
            <?= lang('text_disable'); ?>
        </a>
        <?php } ?>

        <div class="alert alert-danger"><?= $this->lang->line('delete_notok_with_amount'); ?></div>
        <?php if(!empty($linked_items)) { ?>
            <h2><?= $this->lang->line('admin_delete_objects_list'); ?></h2>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php foreach($header_items as $header_item) { ?>
                        <th><?= $header_item; ?></th>
                        <?php } ?>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($linked_items as $linked_item) { ?>
                    <tr>
                        <?php foreach($linked_item as $item_part) { ?>
                            <td><?= $item_part; ?></td>
                        <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <a href="<?php
                if($current_menu == 'user') {
                    echo base_url('admin/unlink_user_items/').$current_id;
                } else {
                    echo base_url('admin/unlink_').$current_menu.'/'.$current_id;
                }
                ?>" class="btn btn-danger"><?= $this->lang->line('admin_unlink'); ?></a>
            </div>

            <?php if(!empty($linked_loans)) {
                echo "<hr>";
            } }

        if(!empty($linked_loans)) { ?>
            <h2><?= $this->lang->line('admin_delete_loans_list'); ?></h2>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <?php foreach($header_loans as $header_loan) { ?>
                        <th><?= $header_loan?></th>
                        <?php } ?>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($linked_loans as $linked_loan) { ?>
                        <tr>
                            <?php foreach($linked_loan as $loan_part) { ?>
                                <td><?= $loan_part; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div>
                <a href="<?php echo base_url('admin/unlink_user_loans/').$current_id; ?>" class="btn btn-danger"><?= $this->lang->line('admin_unlink'); ?></a>
            </div>
        <?php } ?>
    <?php } ?>
</div>