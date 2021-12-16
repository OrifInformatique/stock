<?php
$config = config('\Stock\Config\StockConfig');
?>
<form class="container" method="post" enctype="multipart/form-data">
    <!-- BUTTONS -->
    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-success"><?= lang('MY_application.btn_save'); ?></button>
            <button type="submit" class="btn btn-danger" name="submitCancel"><?= lang('MY_application.btn_cancel');?></button>
        </div>
    </div>

    <!-- ERROR MESSAGES -->
    <div class="row">
    <?php
        if ((isset($errors) && !empty($errors)) || (isset($upload_errors) && !empty($upload_errors))) {
            if ((isset($errors) && !empty($errors)) && (isset($upload_errors) && !empty($upload_errors))) $errors = array_merge($errors, $upload_errors);
            echo '<div class="alert alert-danger">';
            if (isset($errors) && !empty($errors)) {
                echo implode('<br>', array_values($errors));
            }
            echo '</div>';
        }
    ?>
    </div>

    <!-- ITEM NAME AND DESCRIPTION -->
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" class="form-control input-bold" name="name"
                        placeholder="<?= lang('MY_application.field_item_name') ?>"
                        value="<?php if(isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="description"
                        placeholder="<?= lang('MY_application.field_item_description') ?>"
                        value="<?php if(isset($description)) {echo set_value('description',$description);} else {echo set_value('description');} ?>" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="form-group col-xs-7">
                    <input type="text" class="form-control input-bold" name="inventory_prefix"
                           id="inventory_prefix"
                           placeholder="<?php echo lang('MY_application.field_inventory_number') ?>"
                           value="<?php if(isset($inventory_prefix)) {echo set_value('inventory_prefix',$inventory_prefix);} else {echo set_value('inventory_prefix');} ?>" />
                </div>
                <div class="form-group col-xs-5">
                    <input type="text" class="form-control" name="inventory_id"
                           id="inventory_id"
                           value="<?php if(isset($inventory_id)) {echo set_value('inventory_id',$inventory_id);} else {echo set_value('inventory_id');} ?>"
                            disabled />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <input type="button" class="form-control btn btn-primary" name="inventory_number_button"
                           value="<?= lang('MY_application.btn_generate_inventory_nb') ?>" onclick="createInventoryNo()">
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.text_item_detail'); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input name="photoSubmit" type="submit" value="<?= lang('MY_application.field_add_modify_photo')?>" class="btn btn-primary" />
            </div>

            <div class="form-group">
                <?php
                $temp_path = $_SESSION['picture_prefix'].$config->image_picture_suffix.$config->image_tmp_suffix.$config->image_extension;
                if(file_exists($config->images_upload_path.$temp_path)){
                    $imagePath = $temp_path;
                }else if (isset($image) && $image!='') {
                    $imagePath = $image;
                }else{
                    $imagePath = $config->item_no_image;
                }
                ?>
                    <img id="picture"
                         src="<?= base_url($config->images_upload_path.$imagePath); ?>"
                         width="100%"
                         alt="<?= lang('MY_application.field_image'); ?>" />
            </div>

            <div class="form-group">
                <input type="hidden" id="image" name="image" value="<?php if(isset($imagePath)){ echo $imagePath; }?>"/>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="item_group_id"><?= lang('MY_application.field_group'); ?>&nbsp;</label>
                    <?php
                    if (isset($_POST['item_group_id'])) {
                        // A group has allready been selected, keep it selected
                        echo form_dropdown('item_group_id', $item_groups_name, $_POST['item_group_id'], 'class="form-control" id="item_group_id"');
                    } elseif (isset($item_group_id)) {
                        // The item exists, get its group and select it
                        echo form_dropdown('item_group_id', $item_groups_name, $item_group_id, 'class="form-control" id="item_group_id"');
                    } else {
                        // No group selected
                        echo form_dropdown('item_group_id', $item_groups_name, $config->items_default_group, 'class="form-control" id="item_group_id"');
                    }
                    ?>
                </div>
                <div class="form-group col-md-8">
                    <label for="serial_number"><?= lang('MY_application.field_serial_number'); ?>&nbsp;</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control"
                            value="<?php if(isset($serial_number)) {echo set_value('serial_number',$serial_number);} else {echo set_value('serial_number');} ?>" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-xs-12">
                    <label for="remarks"><?= lang('MY_application.field_remarks'); ?></label>
                    <textarea id="remarks" name="remarks" class="form-control"><?php
                        // Don't move the <php> markups or they will be white spaces in textarea
                        if(isset($remarks)) {echo set_value('remarks',$remarks);} else {echo set_value('remarks');}
                    ?></textarea>
                </div>
            </div>
        </div>

        <!-- Button to display linked file -->
        <div class="form-group col-xs-12">
            <label for="linked_file"><?= lang('MY_application.field_linked_file_upload'); ?></label>
            <input type="file" id="linked_file" name="linked_file" accept=".pdf, .doc, .docx" class="form-control-file" />
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.text_item_loan_status'); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="item_condition_id"><?= lang('MY_application.text_item_condition'); ?></label>
            <select id="item_condition_id" name="item_condition_id" class="form-control"><?php
                foreach ($condishes as $item_condition) {
                    ?><option value="<?= $item_condition['item_condition_id']; ?>" <?php
                        if (isset($item_condition_id) && $item_condition_id == $item_condition['item_condition_id']) {
                            echo "selected";
                        }
                    ?> ><?= $item_condition['name']; ?></option><?php
                } ?>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="stocking_place_id"><?= lang('MY_application.field_stocking_place'); ?></label>
			<select id="stocking_place_id" name="stocking_place_id" class="form-control"><?php
				foreach ($stocking_places as $stocking_place) {
				?><option value="<?= $stocking_place['stocking_place_id']; ?>" <?php
                    if (isset($stocking_place_id) && $stocking_place_id == $stocking_place['stocking_place_id']) {
                        echo "selected";
                    }
                ?> ><?= $stocking_place['name']; ?></option><?php
				} ?>
			</select>
        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.text_item_buying_warranty'); ?></p>
        </div>
    </div>
    <div class="row">
        <div class ="col-md-4">
            <div class="form-group">
                <label for="supplier_id"><?= lang('MY_application.field_supplier'); ?></label>
                <select id="supplier_id" name="supplier_id" class="form-control"><?php
                    foreach ($suppliers as $supplier) {
    				?><option value="<?= $supplier['supplier_id']; ?>" <?php
                        if (isset($supplier_id) && $supplier_id == $supplier['supplier_id']) {
                            echo "selected";
                        }
                    ?> ><?= $supplier['name']; ?></option><?php
    				} ?>
                </select>
            </div>
            <div class="form-group">
                <label for="supplier_ref"><?= lang('MY_application.field_supplier_ref'); ?></label>
                <input type="text" id="supplier_ref" name="supplier_ref" class="form-control"
                       value="<?php if(isset($supplier_ref)) {echo set_value('supplier_ref',$supplier_ref);} else {echo set_value('supplier_ref');} ?>" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="buying_price"><?= lang('MY_application.field_buying_price'); ?></label>
                <input type="number" id="buying_price" name="buying_price" class="form-control" min="0" step="0.05"
                       value="<?php if(isset($buying_price)) {echo set_value('buying_price',$buying_price);} else {echo set_value('buying_price');} ?><?= set_value('buying_price'); ?>" />
            </div>
            <div class="form-group">
                <label for="buying_date"><?= lang('MY_application.field_buying_date'); ?></label>
                <input type="date" id="buying_date" name="buying_date" class="form-control"
                       value="<?php if(isset($buying_date)) {echo set_value('buying_date',$buying_date);} else {echo set_value('buying_date', date(config('\Stock\Config\StockConfig')->database_date_format));} ?>" onblur="change_warranty()" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="warranty_duration"><?= lang('MY_application.field_warranty_duration'); ?></label>
                <input type="number" id="warranty_duration" name="warranty_duration" class="form-control" min="0" max="1000"
                       value="<?php if(isset($warranty_duration)) {echo set_value('warranty_duration',$warranty_duration);} else {echo set_value('warranty_duration');} ?>" onblur="change_warranty()" />
            </div>
            <span class="label label-success" id="garantie">Sous garantie</span>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.text_item_tags'); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="checkbox col-xs-12">
			<?php foreach ($item_tags as $item_tag) { ?>
                <label class="checkbox-inline">
                    <input class="tag-checkbox" type="checkbox" name="tag<?= $item_tag['item_tag_id']; ?>" value="<?= $item_tag['item_tag_id']; ?>"
                        <?php
                        // Check the checkbox if tag is assigned to this item
                        if (isset($tag_links)) {
                            foreach ($tag_links as $tag_link) {
                                if ($tag_link['item_tag_id'] == $item_tag['item_tag_id']){
                                    echo 'checked';
                                }
                            }
                        }
                        ?>
                    />

                    <?= $item_tag['name']; ?>
                </label>
			<?php } ?>
        </div>
    </div>
</form>
<script>
$(document).ready(function() {
    // Refresh the image to prevent display of an old cach image.
    // Changing the src attribute forces browser to update.
    d = new Date();
    $("#picture").attr("src", "<?= base_url($config->images_upload_path.$imagePath); ?>?"+d.getTime());
});

function get(objectName){
    switch (objectName) {
        case "item_groups":
            return <?php $array = ""; foreach($item_groups as $item_group) $array .= "'".$item_group['short_name']."',"; echo "[$array]"; ?>;

        case "item_tags":
            return <?php $array = ""; foreach($item_tags as $item_tag) $array .= "'".$item_tag['short_name']."',"; echo "[$array]"; ?>;

        case "INVENTORY_PREFIX":
            return "<?=$config->inventory_prefix; ?>" ;

        case "INVENTORY_NUMBER_CHARS":
            return "<?=$config->inventory_number_chars; ?>" ;

        case "item_id":
            return "<?= $item_id; ?>" ;

    }
}

function change_warranty() {
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
		span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[1]; ?>";
		span_garantie.class = "label label-success";
	}
	else if (remaining_months > 0)
	{
		// Warranty expires soon
		span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[2]; ?>";
		span_garantie.class = "label label-warning";
	}
	else
	{
		// Warranty expired
		span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[3]; ?>";
		span_garantie.class = "label label-danger";
	}
}

function createInventoryNo(){

    var objectGroupField = document.getElementById('item_group_id');

    var objectGroups = get("item_groups");

    var tagShortName = getFirstTagShortName();
    var buyingDateField = document.getElementById('buying_date');
    var date = new Date(buyingDateField.value).getFullYear();
    var inventoryNumberField = document.getElementById('inventory_prefix');
    var inventoryNumber = "";
    var inventoryIdField = document.getElementById('inventory_id');

    date = date.toString().slice(2,4);
    if(date == "N"){
        date = "00";
    }
    inventoryNumber = get("INVENTORY_PREFIX") + "." + objectGroups[objectGroupField.value-1] + tagShortName + date;
    inventoryNumberField.value = inventoryNumber;

    // If inventory_id field is empty, complete it
    if (inventoryIdField.value == "") {
        id = get("item_id");
        inventoryNumberChars = get("INVENTORY_NUMBER_CHARS");
        for(var i = id.length;i < inventoryNumberChars; i++){
            id = "0" + id;
        }
        id = "." + id;

        inventoryIdField.value = id;
    }
}

function getFirstTagShortName(){
    var tags = document.getElementsByClassName('tag-checkbox');
    var firstTagShortName = "";

    // Get an array with every tags shortnames
    var tagsShortNames = get("item_tags");
    for(var i = 0;i < tags.length;i++){
        if(tags[i].checked === true){
            firstTagShortName = tagsShortNames[i];
            break;
        }
    }
    return firstTagShortName;
}

change_warranty();
</script>
