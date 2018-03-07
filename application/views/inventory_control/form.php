<form class="container" method="post">
	<h3>
	<?php
		echo $this->lang->line('field_inventory_control').' : ';
		echo $item->name.' ('.$item->inventory_number.')';
	?>
	</h3>

	<label for="controller">
		<?php echo $this->lang->line('field_inventory_controller').' : '; ?>
	</label>
	<input class="form-control" name="controller"
	       value="<?php if(isset($controller)) {echo $controller->username;} ?>" disabled />
	<br />

	<label for="date">
		<?php echo $this->lang->line('field_inventory_control_date').' : '; ?>
	</label>
	<input class="form-control" name="date" type="date"
	       value="<?php if(isset($date)) {echo $date;} ?>" />
	<br />

	<label for="remarks">
		<?php echo $this->lang->line('field_remarks').' : '; ?>
	</label>
	<input class="form-control" name="remarks"
	       value="<?php if(isset($remarks)) {echo $remarks;} ?>" autofocus />
	<br />

	<button type="submit" name="submit" class="btn btn-success">
		<?php echo $this->lang->line('btn_save'); ?>
	</button>
	<a class="btn btn-default" href="<?php echo base_url() . "item/view/" . $item->item_id; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
</form>