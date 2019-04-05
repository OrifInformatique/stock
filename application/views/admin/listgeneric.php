<div class="container" id="content">
    <div class="row">
        <a href="<?php
            $link = base_url("admin/form_generic/{$current_menu}");
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
                    <?php foreach($current_items as $current_item) { ?>
                        <tr class="row">
                            <?php foreach($current_item as $part_name => $part) { ?>
                                <td><?php echo $part; ?></td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>