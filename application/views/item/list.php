<div class="container">
<div class="row">
<div class="col-lg-12 col-sm-12">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th><?php echo $this->lang->line('header_inventory_nb'); ?></th>
                <th><?php echo $this->lang->line('header_item_name'); ?></th>
                <th><?php echo $this->lang->line('header_item_description'); ?></th>
                <th><?php echo $this->lang->line('header_item_created_by'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" >
                        <?php echo $item->inventory_number; ?>
                    </a></td>
                    <td><a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" >
                        <?php echo $item->name; ?>
                    </a></td>
                    <td><?php echo $item->description; ?></td>
                    <td><?php echo $item->created_by_user->username; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>