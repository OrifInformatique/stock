<div class="container">

    <!-- ITEM NAME AND DESCRIPTION -->
    <div class="row">
        <div class="col-md-4"><h3><?php echo $item->inventory_number; ?></h3></div>
        <div class="col-md-7"><h3><?php echo $item->name; ?></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $item->item_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><?php echo $item->description; ?></p></div>
    </div>

    <!-- LOANS LIST -->
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
                    <tr>
                        <td><?php echo $loan->date; ?></td>
                        <td><?php echo $loan->planned_return_date; ?></td>
                        <td><?php echo $loan->real_return_date; ?></td>
                        <td><?php echo $loan->item_localisation; ?></td>
                        <td><?php echo $loan->loan_by_user->username; ?></td>
                        <td><?php echo $loan->loan_to_user->lastname.' '.
                                       $loan->loan_to_user->firstname; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>