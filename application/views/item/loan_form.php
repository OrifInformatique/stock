<form class="container" method="post" enctype="multipart/form-data">
	<label for="date"><?php echo $this->lang->line('header_loan_date'); ?> :&nbsp;</label>
	<input class="form-control" name="date" type="date" value="<?php echo set_value('date', date('Y-m-d')); ?>" /><br />

	<label for="planned_return_date"><?php echo $this->lang->line('header_loan_planned_return'); ?> :&nbsp;</label>
	<input class="form-control" name="planned_return_date" type="date" /><br />

	<label for="real_return_date"><?php echo $this->lang->line('header_loan_real_return'); ?> :&nbsp;</label>
	<input class="form-control" name="real_return_date" type="date" /><br />

	<label for="item_localisation"><?php echo $this->lang->line('header_loan_localisation'); ?> :&nbsp;</label>
	<input class="form-control" name="item_localisation" /><br />

	<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
</form>
