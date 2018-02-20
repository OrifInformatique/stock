<div class="container">
    <?php $item_page = base_url('item/view/').$item->item_id; ?>

	<!-- BUTTONS -->
	<a href="<?php echo $item_page ?>" class="btn btn-primary" role="button"><?php echo $this->lang->line('btn_back_to_object'); ?></a>

    <!-- ITEM NAME -->
    <div class="row">
        <h3><?php
            echo $this->lang->line('field_inventory_control').' : ';
            echo $item->name.' ('.$item->inventory_number.')';
        ?></h3>
    </div>

    <!-- INVENTORY CONTROLS LIST -->
	<?php if(empty($inventory_controls)) { ?>
        <h4 class="text-warning">
            <?php echo $this->lang->line('msg_no_inventory_controls'); ?>
        </h4>
	<?php } else { ?>
    	<div class="row">
            <div class="col-lg-12 col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th><?php echo $this->lang->line('field_inventory_control_date'); ?></th>
                            <th><?php echo $this->lang->line('field_inventory_controller'); ?></th>
                            <th><?php echo $this->lang->line('field_remarks'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($inventory_controls as $inventory_control) { ?>
                        <tr>
                            <td><?php echo nice_date($inventory_control->date,
                                           $this->lang->line('date_format_short')); ?></td>
                            <td><?php echo $inventory_control->controller->username; ?></td>
                            <td><?php echo $inventory_control->remarks; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
	<?php } ?>
<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
	<a href="<?php echo base_url('item/create_inventory_control/').$item->item_id; ?>" class="btn btn-primary"><?php echo $this->lang->line('btn_new') ?></a>
<?php } ?>
</div>
