<?php
$config = config('\Stock\Config\StockConfig');
?>
<form class="container" method="post" enctype="multipart/form-data">
    <!-- BUTTONS -->
    <div class="row">
        <div class="form-group col-xs-12">
            <button type="submit" class="btn btn-success"><?= lang('MY_application.btn_save'); ?></button>
            <a href="<?= isset($_SESSION['items_list_url']) ? $_SESSION['items_list_url'] : base_url() ?>" class="btn btn-danger"><?= lang('MY_application.btn_cancel');?></a>
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

    <!-- ITEM_COMMON, ITEM NAME AND DESCRIPTION -->
    <div class="row">
        <div class="form-group col-11">
            <?= form_label(lang('stock_lang.item_common'), 'item_common_name'); ?>
            <?= form_input('item_common_name', '', [
                'placeholder' => lang('stock_lang.item_common'),
                'class' => 'form-control', 
                'id' => 'item_common_name',
                'readonly' => 'true',
                'onClick' => "$('#itemCommonBrowse').modal('show');"
                ]); 
            ?>

            <!-- Modal -->
            <div class="modal fade" id="itemCommonBrowse" tabindex="-1" aria-labelledby="itemCommonBrowseLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content col-10">
                        <div class="modal-header">
                            <h5 class="modal-title" id="itemCommonBrowseLabel"><?= lang('stock_lang.item_common'); ?></h5>
                        </div>
                        <div class="form-group search-sticky">
                            <?= form_label(lang('stock_lang.field_search_item_common'), 'search_item_common', ['class' => '']) ?>
                            <?= form_input('search_item_common', '', [
                                'placeholder' => lang('stock_lang.field_search_item_common'),
                                'class' => 'form-control bg-white', 'id' => 'search_item_common'
                                ]); 
                            ?>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover" style="overflow-x: auto;">
                                    <thead>
                                        <tr role="button">
                                            <th scope="col"></th>
                                            <th scope="col"><?= lang('stock_lang.field_item_common_name'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="itemCommonList">
                                        <tr>
                                            <td>
                                                <img src="<?= base_url('uploads/images') . '/' . $config->item_no_image ?>" width="100px" height="100px" alt="">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <?php foreach($item_common_list as $item_common): ?>
                                            <?php if (! is_null($item_common)): ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?= base_url('uploads/images') . '/' . $item_common['image'] ?>" width="100px" height="100px" alt="">
                                                    </td>
                                                    <td><?= $item_common['name']; ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div id="noItemFoundMessage" class="alert alert-info"><?= lang('stock_lang.no_item_common_found'); ?></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal" onclick="$('#itemCommonBrowse').modal('hide');"><?= lang('stock_lang.save_and_quit'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <input type="text" id="name" class="form-control input-bold" name="name"
                        placeholder="<?= lang('MY_application.field_item_name') ?>"
                        value="<?php if(isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
            </div>
            <div class="form-group">
                <input type="text" id="description" class="form-control" name="description"
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
        <div class="row-responsive-2 pl-3 pr-3" style="width: 100%;min-width: 50vw;max-width: 1000px">
            <label for="entity_selector"><?=lang('stock_lang.entity_name')?></label>
            <select class="form-control mb-3" name="fk_entity_id" id="entity_selector" onchange="initStockingPlace(this);initItemGroup(this)">
                <?php foreach ($entities as $entity):?>
                    <option value="<?=$entity['entity_id']?>"  data-tag-name="<?=$entity['shortname']?>" <?=isset($entity_id)&&$entity_id==$entity['entity_id'] ? 'selected': (isset($selected_entity_id) && $selected_entity_id == $entity['entity_id'] ? 'selected' : '')?>><?=$entity['name']?></option>
                <?php endforeach;?>
            </select>
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
                    <select id="item_group_id" name="item_group_id" class="form-control" >
                        <option value="" disabled> -- <?= lang('MY_application.field_group'); ?> -- </option>
                        <?php
                        foreach ($item_groups as $item_group) :?>
                        <option value="<?=$item_group['item_group_id']?>" <?php echo (isset($item_group_id) && $item_group_id == $item_group['item_group_id'] ? 'selected' : $item_group['item_group_id'] == $config->items_default_group) ? 'selected' : '' ?> data-fk_entity="<?=$item_group['fk_entity_id']?>"><?=$item_group['name']?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group col-md-8">
                    <label for="serial_number"><?= lang('MY_application.field_serial_number'); ?>&nbsp;</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control"
                            value="<?php if(isset($serial_number)) {echo set_value('serial_number',$serial_number);} else {echo set_value('serial_number');} ?>" />
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
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
			<select id="stocking_place_id" name="stocking_place_id" class="form-control">
                <option value="" disabled> -- <?= lang('MY_application.field_stocking_place'); ?> -- </option>
                <?php
				foreach ($stocking_places as $stocking_place) {

				?><option value="<?= $stocking_place['stocking_place_id']; ?>" <?php
                    if (isset($stocking_place_id) && $stocking_place_id == $stocking_place['stocking_place_id']) {
                        echo "selected";
                    }
                ?> data-fk_entity="<?=$stocking_place['fk_entity_id']?>"><?= $stocking_place['name']; ?></option><?php
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
                                    break;
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

<!-- SCRIPT -->
<script>
$(document).ready(function() {
    $("#noItemFoundMessage").toggle(false);
    // Refresh the image to prevent display of an old cach image.
    // Changing the src attribute forces browser to update.
    d = new Date();
    $("#picture").attr("src", "<?= base_url($config->images_upload_path.$imagePath); ?>?"+d.getTime());
    
    $("#itemCommonBrowse tr").click(function() {
        $(this).addClass('highlight').siblings().removeClass('highlight');
        var text = $(this).find('td:eq(1)').text();
        $('#item_common_name').val(text).trigger('change');
    });

    $("#search_item_common").on("keyup", function() {
        let value = $(this).val().toLowerCase();
        let found = false; // Flag to check if any item is found
        
        $("#itemCommonList tr").filter(function() {
            let rowText = $(this).text().toLowerCase();
            let isVisible = rowText.indexOf(value) > -1;
            $(this).toggle(isVisible);
            
            if (isVisible) {
                found = true;
            }
        });
        
        // Toggle the message based on whether any item is found
        $("#noItemFoundMessage").toggle(!found);
    });

    $('#item_common_name').on('change', (e) => {
        let name = $('#name');
        let description = $('#description');
        let itemGroup = $('#item_group_id');
        if (e.target.value === "") {
            name.prop('disabled', false);
            description.prop('disabled', false);
            itemGroup.prop('disabled', false);
        } else {
            name.prop('disabled', true);
            description.prop('disabled', true);
            itemGroup.prop('disabled', true);
        }
        console.log(e.target.value);
    });
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

function createInventoryNo() {

    var objectGroupField = document.getElementById('item_group_id');

    var objectGroups = get("item_groups");

    var tagShortName = getFirstTagShortName();
    var buyingDateField = document.getElementById('buying_date');
    var date = new Date(buyingDateField.value).getFullYear();
    var inventoryNumberField = document.getElementById('inventory_prefix');
    var inventoryNumber = "";
    var inventoryIdField = document.getElementById('inventory_id');
    var entityTag=document.querySelector(`option[value='${document.getElementById('entity_selector').value}']`).getAttribute('data-tag-name');
    date = date.toString().slice(2,4);
    if(date == "N"){
        date = "00";
    }
    inventoryNumber = entityTag + "." + objectGroups[objectGroupField.value-1] + tagShortName + date;
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

function initStockingPlace(el){
    const fk_entity_id=el.value;
    document.querySelector('#stocking_place_id').querySelectorAll('option').forEach((element)=>{
        if (element.value===""){
            element.selected=true;
        }
        else if (element.dataset.fk_entity===fk_entity_id){
            element.style.display='unset';
            element.parentElement.value=element.value;
            element.selected=true;
        }
        else {
            element.style.display='none';
        }
    })
}

function initItemGroup(el){
    const fk_entity_id=el.value;
    document.querySelector('#item_group_id').querySelectorAll('option').forEach((element)=>{
        if (element.value===""){
            element.selected=true;
        }
        else if (element.dataset.fk_entity===fk_entity_id){
            element.style.display='unset';
            element.parentElement.value=element.value;
        }
        else {
            element.style.display='none';
        }
        if (element.value==='<?=isset($item_group_id)?$item_group_id:'NONE'?>'){
            element.selected=true;
        }
    });
}

initStockingPlace(document.querySelector('#entity_selector'));
initItemGroup(document.querySelector('#entity_selector'));

change_warranty();

</script>
