<div class="container" id="content">
    <div class="row">
        <a href="<?php
            $link = base_url("admin/new_{$current_menu}");
            echo $link;
        ?>" class="btn btn-success">
            <?= $this->lang->line('btn_new'); ?>
        </a>
    </div>

    <div class="row">
        <h3>
            <?php foreach($admin_menus as $admin_menu) { ?>
                <span class="<?php
                    $class = 'tab_unselected';
                    if($admin_menu === $current_menu) {
                        $class = 'tab_selected';
                    }
                    echo $class;
                ?>" onclick="loadPage(<?php echo "'admin/view_generic/{$admin_menu}'"; ?>)"><?php echo $this->lang->line("admin_tab_{$admin_menu}s"); ?></span>
            <?php } ?>
        </h3>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="row">
                        <?php if(!is_null($headers)) {
                        foreach($headers as $header) { ?>
                            <th><?php echo $this->lang->line($header); ?>
                        <?php } ?>
                        <th></th>
                        <?php } ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($current_items as $current_item) {
                        $current_id = -1;
                        if(isset($current_item->user_id)) {
                            $current_id = $current_item->user_id;
                            $temp = [
                                'username' => "<a href='".base_url("admin/modify_user/{$current_id}")."'>{$current_item->username}</a>",
                                'lastname' => $current_item->lastname,
                                'firstname' => $current_item->firstname,
                                'email' => $current_item->email,
                                'status' => $current_item->user_type->name,
                                'is_active' => ($current_item->is_active == 1 ? lang('text_yes') : lang('text_no'))
                            ];
                            $current_item = $temp;
                        } elseif(isset($current_item->item_tag_id)) {
                            $current_id = $current_item->item_tag_id;
                            $temp = [
                                'name' => '<a href=\''.base_url("admin/modify_tag/{$current_id}")."'>{$current_item->name}</a>"
                            ];
                            $current_item = $temp;
                        } elseif(isset($current_item->stocking_place_id)) {
                            $current_id = $current_item->stocking_place_id;
                            $temp = [
                                'short' => '<a href=\''.base_url("admin/modify_stocking_place/{$current_id}")."'>{$current_item->short}</a>",
                                'long' => $current_item->name
                            ];
                            $current_item = $temp;
                        } elseif(isset($current_item->supplier_id)) {
                            $current_id = $current_item->supplier_id;
                            $temp = [
                                'name' => '<a href=\''.base_url("admin/modify_supplier/{$current_id}")."'>{$current_item->name}</a>",
                                'address_line1' => $current_item->address_line1,
                                'address_line2' => $current_item->address_line2,
                                'zip' => $current_item->zip,
                                'city' => $current_item->city,
                                'country' => $current_item->country,
                                'tel' => $current_item->tel,
                                'email' => $current_item->email
                            ];
                            $current_item = $temp;
                        } elseif(isset($current_item->item_group_id)) {
                            $current_id = $current_item->item_group_id;
                            $temp = [
                                'name' => '<a href=\''.base_url("admin/modify_item_group/{$current_id}")."'>{$current_item->name}</a>",
                                'short_name' => $current_item->short_name
                            ];
                            $current_item = $temp;
                        }
                        ?>
                        <tr class="row">
                            <?php
                            foreach($current_item as $part_name => $part) {
                                if(is_string($part) && (strlen($part) === 60 || strlen($part) == 19)) {
                                    continue;
                                }
                                ?>
                                <td><?php echo $part; ?></td>
                            <?php } ?>
                            <td><a href="<?= base_url("/admin/delete_{$current_menu}/{$current_id}"); ?>" class="close">x</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    function loadPage(endOfPageString) {
        if($('#content').size == 0) {
            return;
        }
        if(endOfPageString == undefined || endOfPageString == null) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?= base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>