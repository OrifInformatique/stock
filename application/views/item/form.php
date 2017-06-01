<em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

<form class="container" method="post" enctype="multipart/form-data">
    <!-- ITEM buying_price AND DESCRIPTION -->
    <div class="row">
        <div class="col-md-4"><h3><input type="text" name="inventory_number" placeholder="Numéro d'inventaire" value="<?php if(isset($inventory_number)) {echo $inventory_number;} else {echo set_value('inventory_number');} ?>" /></h3></div>
        <div class="col-md-7"><h3><input type="text" name="name" placeholder="Nom de l'objet" value="<?php if(isset($name)) {echo $name;} else {echo set_value('name');} ?>" /></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?php echo $item_id; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><input type="text" class="form-control" name="description" placeholder="Description de l'objet" value="<?php if(isset($description)) {echo $description;} else {echo set_value('description');} ?>" /></p></div>
    </div>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_detail'); ?></p>
        </div>
        <div class="col-md-4">
          Ajoutez une image (hauteur et largeur max. 550px):
			    <input type="file" name="photo" accept="image/*" />
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4">
                    <label><?php echo $this->lang->line('field_group'); ?> :&nbsp;</label>
                    <select name="item_group_id"><?php foreach ($item_groups as $item_group) { ?>
					<option value="<?php echo $item_group->item_group_id; ?>" <?php if (isset($item_group_id)) {if( $item_group_id == $item_group->item_group_id) {echo "selected";}} else {echo set_select('item_group_id', $item_group->item_group_id);} ?>><?php echo $item_group->name; ?></option>
					<?php } ?></select>
                </div>
                <div class="col-md-8">
                    <label for="serial_number"><?php echo $this->lang->line('field_serial_number'); ?> :&nbsp;</label>
                    <input type="text" id="serial_number" name="serial_number" value="<?php if(isset($buying_price)) {echo $buying_price;} else {echo set_value('buying_price');} ?>" />
                </div>
            </div>

            <label for="remarks"><?php echo $this->lang->line('field_remarks'); ?></label>
            <p><textarea id="remarks" name="remarks" value="<?php if(isset($remarks)) {echo $remarks;} else {echo set_value('remarks');} ?>"></textarea></p>

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
            <label><?php echo $this->lang->line('text_item_condition'); ?> :</label> <select name="item_condition_id"><?php foreach ($condishes as $item_condition) { ?>
            <option value="<?php echo $item_condition->item_condition_id; ?>" <?php if (isset($item_condition_id)) {if( $item_condition_id == $item_condition->item_condition_id) {echo "selected";}} else {echo set_select('item_condition_id', $item_condition->item_condition_id);} ?>><?php echo $item_condition->name; ?></option>
            <?php } ?></select><br />

            <label><?php echo $this->lang->line('field_stocking_place'); ?> :</label>
			<select name="stocking_place_id">
				<?php foreach ($stocking_places as $stocking_place) { ?>
				<option value="<?php echo $stocking_place->stocking_place_id; ?>" <?php if (isset($stocking_place_id)) {if( $stocking_place_id == $stocking_place->stocking_place_id) {echo "selected";}} else {echo set_select('stocking_place_id', $stocking_place->stocking_place_id);} ?>><?php echo $stocking_place->name; ?></option>
				<?php } ?>
			</select>
            <?php /*if(!is_null($item->stocking_place)){echo $item->stocking_place->buying_price;}*/ ?>
        </div>
        <div class="col-md-7">
        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?php echo $this->lang->line('text_item_buying_warranty'); ?></p>
        </div>
        <div class="col-md-4">
            <label for="supplier_id"><?php echo $this->lang->line('field_supplier'); ?> :&nbsp;</label>
            <select name="supplier_id"><?php foreach ($suppliers as $supplier) { ?>
				<option value="<?php echo $supplier->supplier_id; ?>" <?php if (isset($supplier_id)) {if( $supplier_id == $supplier->supplier_id) {echo "selected";}} else {echo set_select('stocking_place_id', $supplier->supplier_id);} ?>><?php echo $supplier->name; ?></option>
				<?php } ?></select><br />
            <label for="supplier_ref"><?php echo $this->lang->line('field_supplier_ref'); ?> :&nbsp;</label>
            <input type="text" id="supplier_ref" name="supplier_ref" value="<?php if(isset($supplier_ref)) {echo $supplier_ref;} else {echo set_value('supplier_ref');} ?>" />
        </div>
        <div class="col-md-4">
            <label for="buying_price"><?php echo $this->lang->line('field_buying_price'); ?> :&nbsp;</label>
            <input type="number" id="buying_price" name="buying_price" min="0" step="0.05" value="<?php if(isset($buying_price)) {echo $buying_price;} else {echo set_value('buying_price');} ?><?php echo set_value('buying_price'); ?>" /><br />

            <label for="buying_date"><?php echo $this->lang->line('field_buying_date'); ?> :&nbsp;</label>
            <input type="date" id="buying_date" name="buying_date" value="<?php if(isset($buying_date)) {echo $buying_date;} else {echo set_value('buying_date', date('Y-m-d'));} ?>" onblur="change_warranty()" /><br />
        </div>
        <div class="col-md-4">
            <label for="warranty_duration"><?php echo $this->lang->line('field_warranty_duration'); ?> :&nbsp;</label>
            <input type="number" id="warranty_duration" name="warranty_duration" min="0" max="1000" value="<?php if(isset($warranty_duration)) {echo $warranty_duration;} else {echo set_value('warranty_duration');} ?>" onblur="change_warranty()" /> mois<br />

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
			<label class="checkbox-inline"><input type="checkbox" name="tag<?php echo $item_tag->item_tag_id; ?>" value="<?php echo $item_tag->item_tag_id; ?>"
        <?php
        if (isset($tag_links))
        {
          foreach ($tag_links as $tag_link)
          {
            if ($tag_link->item_tag_id == $item_tag->item_tag_id)
            {
              echo 'checked';
            }
          }
        }
        else
        {
          echo set_checkbox('tag' . $item_tag->item_tag_id, "true");
        }
        ?> />
      <?php echo $item_tag->name; ?></label>
			<?php } ?>
        </div>
    </div>

	<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
  <a class="btn btn-primary" href="<?php echo base_url(); if(isset($modify)) {echo "item/view/" . $item_id;} ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
</form>

<script>
function change_warranty()
{
	var buying_date = new Date(document.getElementById('buying_date').value);
	var duration = +document.getElementById('warranty_duration').value;
	var span_garantie = document.getElementById('garantie');

	//Get remaining months (ceil)
	var current_date = new Date();

	var remaining_months = (buying_date.getFullYear() * 12 + buying_date.getMonth()) + duration - (current_date.getFullYear() * 12 + current_date.getMonth());

	if (buying_date.getDate() >= current_date.getDate())
		remaining_months++;

	if (remaining_months > 3)
	{
		// Under warranty
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[1]; ?>";
		span_garantie.class = "label label-success";
	}
	else if (remaining_months > 0)
	{
		// Warranty expires soon
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[2]; ?>";
		span_garantie.class = "label label-warning";
	}
	else
	{
		// Warranty expired
		span_garantie.innerHTML = "<?php echo $this->lang->line('text_warranty_status')[3]; ?>";
		span_garantie.class = "label label-danger";
	}
}
</script>
