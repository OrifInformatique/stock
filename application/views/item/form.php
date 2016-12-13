<em><?php echo validation_errors(); ?></em>

<form class="container" method="post">
    <!-- ITEM NAME AND DESCRIPTION -->
    <div class="row">
        <div class="col-md-4"><h3><input type="text" name="noinv" placeholder="Numéro d'inventaire" /></h3></div>
        <div class="col-md-7"><h3><input type="text" name="item_name" placeholder="Nom de l'objet" /></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $future_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><input type="text" name="description" placeholder="Description de l'objet" /></p></div>
    </div>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_detail'); ?></p>
        </div>
        <div class="col-md-4">
			<input type="file" name="photo" accept="image/*" />
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $this->lang->line('field_group'); ?> :&nbsp;</label>
                    <select><?php foreach ($item_groups as $item_group) { ?>
					<option value="<?php echo $item_group->item_group_id; ?>"><?php echo $item_group->name; ?></option>
					<?php } ?></select>
                </div>
                <div class="col-md-8">
                    <label for="serial_number"><?php echo $this->lang->line('field_serial_number'); ?> :&nbsp;</label>
                    <input type="text" id="serial_number" name="serial_number" />
                </div>
            </div>

            <label for="remarks"><?php echo $this->lang->line('field_remarks'); ?></label>
            <p><textarea id="remarks" name="remarks"></textarea></p>

            <!-- Button to display linked file -->
            <?php
            /*if (!empty($item->linked_file)) {
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
            }*/
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
            /*if(!is_null($item->item_condition))
            {
                if ($item->item_condition_id == 10) {
                    echo '<span class="label label-success" >';} // ITEM AVAILABLE
                elseif ($item->item_condition_id == 20) {
                    echo '<span class="label label-warning" >';} // ITEM LOANED
                elseif ($item->item_condition_id == 30) {
                    echo '<span class="label label-warning" >';} // ITEM DEFECTIVE
                elseif ($item->item_condition_id == 40) {
                    echo '<span class="label label-danger" >';}  // NO MORE ITEM
                else {echo '<div>';}

                echo $item->item_condition->name.'</span><br />';
            }*/ ?>

            <label><?php echo $this->lang->line('field_stocking_place'); ?> :</label>
			<select>
				<?php foreach ($stocking_places as $stocking_place) { ?>
				<option value="<?php echo $stocking_place->stocking_place_id; ?>"><?php echo $stocking_place->name; ?></option>
				<?php } ?>
			</select>
            <?php /*if(!is_null($item->stocking_place)){echo $item->stocking_place->name;}*/ ?>
        </div>
        <div class="col-md-4">
            <label for="current_loan"><?php echo $this->lang->line('field_current_loan'); ?> :&nbsp;</label>
            <input type="text" id="current_loan" name="current_loan" /><br />

            <label for="loan_date"><?php echo $this->lang->line('field_loan_date'); ?> :&nbsp;</label>
			<input type="date" id="loan_date" name="loan_date" /><br />

            <label for="loan_planned_return"><?php echo $this->lang->line('field_loan_planned_return'); ?> :&nbsp;</label>
			<input type="date" id="loan_planned_return" name="loan_planned_return" /><br />
            <?php
            /*if(!is_null($item->current_loan))
            {
                if(!empty($item->current_loan->planned_return_date))
                {
                    echo nice_date($item->current_loan->planned_return_date, $this->lang->line('date_format_short'));
                }
            }*/
            ?>
        </div>
        <div class="col-md-3">

            <!-- Button to display loans history -->
            <?php
            /*echo '<a href="'.base_url('/item/loans/'.$item->item_id).'" '.
                    'class="btn btn-default"  role="button" >'
                    .$this->lang->line('btn_loans_history').
                 '</a>';*/
			echo '<a href="#" '.
                    'class="btn btn-default"  role="button" >'
                    .$this->lang->line('btn_loans_history').
                 '</a>';
            ?>
        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_buying_warranty'); ?></p>
        </div>
        <div class="col-md-4">
            <label><?php echo $this->lang->line('field_supplier'); ?> :&nbsp;</label>
            <select><?php foreach ($suppliers as $supplier) { ?>
				<option value="<?php echo $supplier->supplier_id; ?>"><?php echo $supplier->name; ?></option>
				<?php } ?></select><br />
            <label for="supplier_ref"><?php echo $this->lang->line('field_supplier_ref'); ?> :&nbsp;</label>
            <input type="text" id="supplier_ref" name="supplier_ref" />
        </div>
        <div class="col-md-4">
            <label for="buying_price"><?php echo $this->lang->line('field_buying_price'); ?> :&nbsp;</label>
            <input type="number" id="buying_price" name="buying_price" min="0" step="0.05" /><br />

            <label for="buying_date"><?php echo $this->lang->line('field_buying_date'); ?> :&nbsp;</label>
            <input type="date" id="buying_date" name="buying_date" value="<?php echo date('Y-m-d'); ?>" onblur="change_warranty()" /><br />
        </div>
        <div class="col-md-4">
            <label for="warranty_duration"><?php echo $this->lang->line('field_warranty_duration'); ?> :&nbsp;</label>
            <input type="number" id="warranty_duration" name="warranty_duration" min="0" max="1000" value="24" onblur="change_warranty()" /> mois<br />

            <?php //CHANGE LABEL COLOR BASED ON WARRANTY STATUS
			//En garantie

			/*
            if ($item->warranty_status == 1) {
                echo '<span class="label label-success" >';} // UNDER WARRANTY
            elseif ($item->warranty_status == 2) {
                echo '<span class="label label-warning" >';} // WARRANTY EXPIRES SOON
            elseif ($item->warranty_status == 3) {
                echo '<span class="label label-danger" >';}  // WARRANTY EXPIRED
            else {echo '<span>';}

                echo $this->lang->line('text_warranty_status')[$item->warranty_status];*/ ?>
            <span class="label label-success" id="garantie">Sous garantie</span>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_tags'); ?></p>
        </div>
        <div class="col-md-12">
            <?php
            /*if (!empty($item->tags))
            {
                foreach($item->tags as $tag)
                {
                    echo '<span class="label label-default">'.$tag."</span>\n";
                }
            }*/
            ?>
			<?php foreach ($item_tags as $item_tag) { ?>
			<label class="checkbox-inline"><input type="checkbox" /> <?php echo $item_tag->name; ?></label>
			<?php } ?>
        </div>
    </div>

	<button type="submit" class="btn btn-primary">Sauvegarder</button>
</form>

<script>
function change_warranty()
{
	var buying_date = new Date(document.getElementById('buying_date').value);
	console.log(buying_date.getFullYear() + "uie" + buying_date.getMonth() + "uie" + buying_date.getDate());
	var duration = +document.getElementById('warranty_duration').value;
	var span_garantie = document.getElementById('garantie');

	//Get remaining months (ceil)
	var current_date = new Date();

	var remaining_months = (buying_date.getFullYear() * 12 + buying_date.getMonth()) + duration - (current_date.getFullYear() * 12 + current_date.getMonth());

	if (buying_date.getDate() >= current_date.getDate())
		remaining_months++;

	console.log(remaining_months);

	if (remaining_months > 3)
	{
		//En garatie
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[1]; ?>";
		span_garantie.className = "label label-success";
	}
	else if (remaining_months > 0)
	{
		//Garantie proche de l'expiration
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[2]; ?>";
		span_garantie.className = "label label-warning";
	}
	else
	{
		//Garantie expirée
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[3]; ?>";
		span_garantie.className = "label label-danger";
	}
}
</script>
