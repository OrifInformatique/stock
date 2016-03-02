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

            <button type="button"><?php echo $this->lang->line('btn_linked_doc'); ?></button>
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_loan_status'); ?></p>
        </div>
        <div class="col-md-4">
            <?php //CHANGE TEXT COLOR BASED ON ITEM CONDITION
            if(!is_null($item->item_condition))
            {
                if ($item->item_condition_id == 10) {
                    echo '<div class="text-success bg-success" >';} // ITEM AVAILABLE
                elseif ($item->item_condition_id == 20) {
                    echo '<div class="text-warning bg-warning" >';} // ITEM LOANED
                elseif ($item->item_condition_id == 30) {
                    echo '<div class="text-warning bg-warning" >';} // ITEM DEFECTIVE
                elseif ($item->item_condition_id == 40) {
                    echo '<div class="text-danger bg-danger" >';}   // NO MORE ITEM
                else {echo '<div>';}

                echo $item->item_condition->name.'</div>';
            } ?>

            <label><?php echo $this->lang->line('field_stocking_place'); ?> :</label>
            <?php if(!is_null($item->stocking_place)){echo $item->stocking_place->name;} ?>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_current_loan'); ?> :&nbsp;</label>
            <?php if(!is_null($item->current_loan)){echo $item->current_loan->item_localisation;} ?><br />
            <label><?php echo $this->lang->line('field_loan_date'); ?> :&nbsp;</label>
            <?php if(!is_null($item->current_loan)){echo $item->current_loan->date;} ?><br />
            <label><?php echo $this->lang->line('field_loan_planned_return'); ?> :&nbsp;</label>
            <?php if(!is_null($item->current_loan)){echo $item->current_loan->planned_return_date;} ?><br />
        </div>
        <div class="col-md-3">
            <button type="button"><?php echo $this->lang->line('btn_loans_history'); ?></button>
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
            <?php echo $item->buying_date; ?>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_warranty_duration'); ?> :&nbsp;</label>
            <?php if (!empty($item->warranty_duration)) {
                      echo $item->warranty_duration.' '.$this->lang->line('text_months');} ?><br />
            
            <?php //CHANGE TEXT COLOR BASED ON WARRANTY STATUS
            if ($item->warranty_status == 1) {
                echo '<div class="text-success bg-success" >';} // UNDER WARRANTY
            elseif ($item->warranty_status == 2) {
                echo '<div class="text-warning bg-warning" >';} // WARRANTY EXPIRES SOON
            elseif ($item->warranty_status == 3) {
                echo '<div class="text-danger bg-danger" >';}   // WARRANTY EXPIRED
            else {echo '<div>';}

            echo $this->lang->line('text_warranty_status')[$item->warranty_status]; ?>
            </div>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_tags'); ?></p>
        </div>
        <div class="col-md-12">
            TAGS A DEFINIR
        </div>
    </div>
</div>