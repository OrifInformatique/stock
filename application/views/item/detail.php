<div class="container">
    <!-- BUTTONS -->
	<em>
		<a href="<?php echo base_url(); ?>" class="btn" role="button"><?php echo $this->lang->line('btn_back_to_main'); ?></a>
		<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
		<a href="<?php echo base_url('item/modify/'.$item->item_id); ?>" class="btn" role="button"><?php echo $this->lang->line('btn_modify_item'); ?></a>
		<a href="<?php echo base_url('item/delete/'.$item->item_id); ?>" class="btn" role="button"><?php echo $this->lang->line('btn_delete_item'); ?></a>
		<?php } ?>
	</em>

    <!-- ITEM NAME AND DESCRIPTION -->
    <a style="color:inherit;" href="<?php echo base_url('item/view') . '/' .  $item->item_id; ?>">
	<div class="row">
        <div class="col-md-4"><h3><?php echo $item->inventory_number; ?></h3></div>
        <div class="col-md-7"><h3><?php echo $item->name; ?></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $item->item_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><?php echo $item->description; ?></p></div>
    </div>
	</a>

	<!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_detail'); ?></p>
        </div>
        <div class="col-md-4">
            <img src="<?php echo base_url('uploads/images/'.$item->image); ?>"
                 width="100%"
                 alt="<?php echo $this->lang->line('field_image'); ?>" />
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $this->lang->line('field_group'); ?> :&nbsp;</label>
                    <?php if(!is_null($item->item_group)){echo $item->item_group->name;} ?>
                </div>
                <div class="col-md-8">
                    <label><?php echo $this->lang->line('field_serial_number'); ?> :&nbsp;</label>
                    <?php echo $item->serial_number; ?>
                </div>
            </div>

            <label><?php echo $this->lang->line('field_remarks'); ?></label>
            <p><?php echo $item->remarks; ?></p>

            <!-- Button to display linked file -->
            <?php
            if (!empty($item->linked_file)) {
                echo '<a href="'.base_url('uploads/files/'.$item->linked_file).'" '.
                        'class="btn btn-default"  role="button" >'
                        .$this->lang->line('btn_linked_doc').
                     '</a>';
            }
            else {
                echo '<a href="#" '.
                     'class="btn btn-default disabled"  role="button" >'
                         .$this->lang->line('btn_linked_doc').
                     '</a>';
            }
            ?>
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_loan_status'); ?></p>
        </div>
        <div class="col-md-4">
            <?php //CHANGE LABEL COLOR BASED ON ITEM CONDITION
            if(!is_null($item->item_condition))
            {
								/* Here there is work to do */
								if ($item->item_condition_id == 10) {
									echo '<span class="label label-success">';} // ITEM WORKS
                elseif ($item->item_condition_id == 30) {
                    echo '<span class="label label-warning">';} // ITEM DEFECTIVE
                elseif ($item->item_condition_id == 40) {
                    echo '<span class="label label-danger">';}  // NO MORE ITEM
                else {echo '<div>';}

                echo $item->item_condition->name.'</span><br />';
            } ?>

            <label><?php echo $this->lang->line('field_stocking_place'); ?> :</label>
            <?php if(!is_null($item->stocking_place)){echo $item->stocking_place->name;} ?>
        </div>
        <div class="col-md-4">
						<?php if (is_null($item->current_loan)) { ?>
							<span class="label label-success">Pas de prêt en cours</span>
            <?php } else { ?>
							<span class="label label-warning">En prêt</span><br />
						<label><?php echo $this->lang->line('field_current_loan'); ?> :&nbsp;</label>
            <?php echo $item->current_loan->item_localisation; ?><br />

            <label><?php echo $this->lang->line('field_loan_date'); ?> :&nbsp;</label>
            <?php
                if(!empty($item->current_loan->date))
                {
                    echo nice_date($item->current_loan->date, $this->lang->line('date_format_short'));
                }
            ?>
            <br />

            <label><?php echo $this->lang->line('field_loan_planned_return'); ?> :&nbsp;</label>
            <?php
            if(!is_null($item->current_loan))
            {
                if(!empty($item->current_loan->planned_return_date))
                {
                    echo nice_date($item->current_loan->planned_return_date, $this->lang->line('date_format_short'));
                }
            }
            ?>
						<?php } ?>
        </div>
        <div class="col-md-3">

            <!-- Button to display loans history -->
            <?php
            echo '<a href="'.base_url('/item/loans/'.$item->item_id).'" '.
                    'class="btn btn-default"  role="button" >'
                    .$this->lang->line('btn_loans_history').
                 '</a>';
            ?>
<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
						<!-- Button to create new loan -->
						<?php
            echo '<a href="'.base_url('/item/create-loan/'.$item->item_id).'" '.
                    'class="btn btn-default"  role="button" >'
                    .$this->lang->line('btn_create_loan').
                 '</a>';
            } ?>

        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_buying_warranty'); ?></p>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_supplier'); ?> :&nbsp;</label>
            <?php if(!is_null($item->supplier)){echo $item->supplier->name;} ?><br />
            <label><?php echo $this->lang->line('field_supplier_ref'); ?> :&nbsp;</label>
            <?php echo $item->supplier_ref; ?>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_buying_price'); ?> :&nbsp;</label>
            <?php echo $item->buying_price; ?><br />

            <label><?php echo $this->lang->line('field_buying_date'); ?> :&nbsp;</label>
            <?php
            if (!empty($item->buying_date))
            {
                echo nice_date($item->buying_date, $this->lang->line('date_format_short'));
            }
            ?>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_warranty_duration'); ?> :&nbsp;</label>
            <?php if (!empty($item->warranty_duration)) {
                      echo $item->warranty_duration.' '.$this->lang->line('text_months');} ?><br />

            <?php //CHANGE LABEL COLOR BASED ON WARRANTY STATUS
            if ($item->warranty_status == 1) {
                echo '<span class="label label-success" >';} // UNDER WARRANTY
            elseif ($item->warranty_status == 2) {
                echo '<span class="label label-warning" >';} // WARRANTY EXPIRES SOON
            elseif ($item->warranty_status == 3) {
                echo '<span class="label label-danger" >';}  // WARRANTY EXPIRED
            else {echo '<span>';}

                echo $this->lang->line('text_warranty_status')[$item->warranty_status]; ?>
            </span>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_tags'); ?></p>
        </div>
        <div class="col-md-12">
            <?php
            if (!empty($item->tags))
            {
                foreach($item->tags as $tag)
                {
                    echo '<span class="label label-default">'.$tag."</span>\n";
                }
            }
            ?>
        </div>
    </div>
</div>
