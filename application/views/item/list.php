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
            <?php for ($i = 0; $i < count($items); ++$i) { ?>
                <tr>
                    <td><?php echo $items[$i]->inventory_number; ?></td>
                    <td><?php echo $items[$i]->name; ?></td>
                    <td><?php echo $items[$i]->description; ?></td>
                    <td><?php echo $items[$i]->created_by_user->username; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
</div>