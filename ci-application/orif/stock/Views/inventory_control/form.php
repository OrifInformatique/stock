<form class="container" method="post">
	<h3>
	<?php
		echo lang('MY_application.field_inventory_control').' : ';
		echo $item_common['name'].' ('.$item['inventory_number'].')';
	?>
	</h3>

	<label for="controller">
		<?php echo lang('MY_application.field_inventory_controller').' : '; ?>
	</label>
	<input class="form-control" name="controller"
	       value="<?php if(isset($controller)) {echo $controller['username'];} ?>" disabled />
	<br />

	<label for="date">
		<?php echo lang('MY_application.field_inventory_control_date').' : '; ?>
	</label>
	<input class="form-control" name="date" type="date"
	       value="<?php if(isset($date)) {echo $date;} ?>" />
	<br />

	<label for="remarks">
		<?php echo lang('MY_application.field_remarks').' : '; ?>
	</label>
	<input class="form-control" name="remarks"
	       value="<?php if(isset($remarks)) {echo $remarks;} ?>" autofocus />
	<br />

	<button type="submit" name="submit" class="btn btn-success">
		<?php echo lang('MY_application.btn_save'); ?>
	</button>
	<a class="btn btn-secondary" href="<?php echo base_url("item_common/view/".$item['item_common_id']); ?>"><?php echo lang('MY_application.btn_cancel'); ?></a>
</form>
