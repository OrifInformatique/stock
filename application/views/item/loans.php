<div class="container">
	<!-- BUTTONS --><?php $item_page = base_url('item/view') . '/' .  $item->item_id; ?>
	<em>
		<a href="<?php echo $item_page; ?>" class="btn" role="button"><?php echo $this->lang->line('btn_back_to_object'); ?></a>
		<a href="<?php echo base_url('modify_loans/') ?>" class="btn" role="button">Modifier</a>
	</em>

    <!-- ITEM NAME AND DESCRIPTION -->
	<a style="color:inherit;" href="<?php echo $item_page; ?>">
    <div class="row">
        <div class="col-md-4"><h3><?php echo $item->inventory_number; ?></h3></div>
        <div class="col-md-7"><h3><?php echo $item->name; ?></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $item->item_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><?php echo $item->description; ?></p></div>
    </div>
	</a>

    <!-- LOANS LIST -->
	<?php if(empty($loans)) { ?>
	<em style="font-size:1.5em;" class="text-warning"><?php echo $this->lang->line('msg_no_loan'); ?></em>
	<?php } else { ?>
	<div class="row">
        <div class="col-lg-12 col-sm-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('header_loan_date'); ?></th>
                        <th><?php echo $this->lang->line('header_loan_planned_return'); ?></th>
                        <th><?php echo $this->lang->line('header_loan_real_return'); ?></th>
                        <th><?php echo $this->lang->line('header_loan_localisation'); ?></th>
                        <th><?php echo $this->lang->line('header_loan_by_user'); ?></th>
                        <th><?php echo $this->lang->line('header_loan_to_user'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($loans as $loan) { ?>
                    <tr><a href="google.com" style="display:inline-block"><div style="width:100%;height:100%">
                        <td><?php echo $loan->date; ?></td>
                        <td><?php echo $loan->planned_return_date; ?></td>
                        <td><?php echo $loan->real_return_date; ?></td>
                        <td><?php echo $loan->item_localisation; ?></td>
                        <td><?php echo $loan->loan_by_user->username; ?></td>
                        <td><?php echo $loan->loan_to_user->lastname.' '.
                                       $loan->loan_to_user->firstname; ?>
				        <a href="<?php echo base_url('/item/delete_loan').'/'.$loan->loan_id ?>" class="close" title="Supprimer le prêt">×</a></td>
                    </div></a></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
	<?php } ?>

	<a href="<?php echo base_url(); ?>item/create-loan/<?php echo $item->item_id; ?>" class="btn btn-primary">Nouveau…</a>
</div>
