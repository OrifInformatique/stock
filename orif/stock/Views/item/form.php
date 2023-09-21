<?php
$config = config('\Stock\Config\StockConfig');
?>

<div class="container">
    <?= form_open("", [
            'enctype' => 'multipart/form-data'
        ]); 
    ?>
        <!-- Error messages -->
        <?php if (isset($upload_errors) && !empty($upload_errors)): ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger">
                        <?= implode('<br>', array_values($upload_errors)); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Buttons -->
        <div class="row">
            <div class="col-12 mb-3">
                <input type="submit" class="btn btn-success" id="btn_submit" name="btn_submit" value="<?= lang('MY_application.btn_save'); ?>" />
                <?php if (isset($item_common) && !empty($item_common)): ?>
                    <a href="<?= base_url("item_common/view/{$item_common['item_common_id']}"); ?>" class="btn btn-outline-primary"><?= lang('MY_application.btn_cancel'); ?></a>
                <?php else: ?>
                    <a href="<?= base_url(); ?>" class="btn btn-outline-primary"><?= lang('MY_application.btn_cancel'); ?></a>
                <?php endif; ?>
            </div>
        </div>

        <!-- ITEM COMMON -->
        <div class="row">
            <div class="col-12">
                <p class="bg-primary">&nbsp;<?= lang('stock_lang.item_common'); ?></p>
            </div>
        </div>

        <div class="row">
            <!-- Image -->
            <div class="col-12 col-md-4 mb-2">
            <div>
                <?php
                    $temp_path = $_SESSION['picture_prefix'].$config->image_picture_suffix.$config->image_tmp_suffix.$config->image_extension;
                    if (file_exists($config->images_upload_path.$temp_path)) {
                        $imagePath = $temp_path;
                    } else if (isset($item_common['image']) && $item_common['image'] != '') {
                        $imagePath = $item_common['image'];
                    } else {
                        $imagePath = $config->item_no_image;
                    }
                ?>
                <img id="picture"
                    src="<?= base_url($config->images_upload_path.$imagePath); ?>"
                    width="100%"
                    alt="<?= lang('MY_application.field_image'); ?>"/>
                </div>
                <div class="mt-2">
                    <input type="submit" class="btn btn-primary btn-sm" name="btn_submit_photo" id="btn_submit_photo" value="<?= lang('MY_application.field_add_modify_photo') ?>"/>
                </div>
                <div class="form-group">
                    <input type="hidden" id="image" name="image" value="<?= isset($imagePath) ? $imagePath : ''; ?>"/>
                </div>
            </div>

            <div class="col-12 col-md-8">
                <!-- Entities -->
                <div class="row mb-2">
                    <div id="e" class="col-12">
                        <?= form_dropdown('e', $entities, $selected_entity_id, [
                            'id' => 'entities_list',
                            'class' => 'btn-outline-info',
                        ]);?>
                    </div>
                </div>

                <!-- Name -->
                <div class="row mb-2">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_name'), 'item_common_name'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('item_common_name', isset($item_common_name) ? $item_common_name : (isset($item_common['name']) ? $item_common['name'] : ''), [
                                'placeholder' => lang('stock_lang.field_item_common_name'),
                                'class' => 'form-control', 
                                'id' => 'item_common_name'
                            ]); 
                        ?>
                        <span class="text-danger"><?= isset($errors['name']) ? $errors['name']: ''; ?></span>
                    </div>
                </div>
                    
                <!-- Description -->
                <div class="row mb-2">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_description'), 'item_common_description'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('item_common_description', isset($item_common_description) ? $item_common_description : (isset($item_common['description']) ? $item_common['description'] : ''), [
                                'placeholder' => lang('stock_lang.field_item_common_description'),
                                'class' => 'form-control', 
                                'id' => 'item_common_description'
                            ]); 
                        ?>
                        <span class="text-danger"><?= isset($errors['description']) ? $errors['description']: ''; ?></span>
                    </div>
                </div>

                <!-- Item Group -->
                <div class="row mb-2">
                    <div class="col-4">
                        <?= form_label(lang('MY_application.field_group'), 'item_common_group_id'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_dropdown('item_common_item_group_id', $item_groups, isset($item_common_item_group) ? $item_common_item_group : (isset($item_common['item_group_id']) ? $item_common['item_group_id'] : ''), [
                                'class' => 'form-control',
                                'id' => 'item_common_group_id'
                            ]);
                        ?>
                        <span class="text-danger"><?= isset($errors['item_group_id']) ? $errors['item_group_id']: ''; ?></span>
                    </div>
                </div>

                <!-- Item Tags -->
                <div class="row mb-2">
                    <div class="col-4">
                        <?= form_label(lang('MY_application.field_tags'), 'item_tags-multiselect'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_multiselect('item_common_tags[]', $item_tags, isset($item_common_tags) ? $item_common_tags : (isset($item_tag_ids) ? $item_tag_ids : []),'id="item_tags-multiselect" multiple="multiple"'); ?>
                    </div>
                </div>

                <!-- Linked File -->
                <div class="row mb-2">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_linked_file'), 'item_common_linked_file'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('item_common_linked_file', '', [
                            'class' => 'form-control-file',
                            'accept' => '.pdf, .doc, .docx',
                            'id' => 'item_common_linked_file'
                            ], 'file');
                        ?>
                        <span class="text-danger"><?= isset($errors['linked_file']) ? $errors['linked_file']: ''; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item specimen details -->
        <div class="row">
            <div class="col-12">
                <p class="bg-primary">&nbsp;<?= lang('stock_lang.item_specimen_details'); ?></p>
            </div>
        </div>

        <div class="row">
            <!-- Inventory number -->
            <div class="col-md-4">
                <?= form_label(lang('MY_application.field_inventory_number')); ?>

                <div class="row mb-2">
                    <!-- Inventory prefix -->
                    <div class="col-md-8">
                        <?= form_label(lang('MY_application.field_inventory_prefix'), 'inventory_prefix'); ?>
                        <input type="text" class="form-control" name="inventory_prefix"
                            id="inventory_prefix"
                            placeholder="<?= lang('MY_application.field_inventory_prefix') ?>"
                            value="<?= isset($item) ? $item['inventory_prefix'] : set_value('inventory_prefix') ?>" />
                        <span class="text-danger"><?= isset($errors['inventory_prefix']) ? $errors['inventory_prefix']: ''; ?></span>
                    </div>

                    <!-- Inventory id -->
                    <div class="col-md-4">
                        <?= form_label(lang('MY_application.field_inventory_id'), 'inventory_id'); ?>
                        <input type="text" class="form-control" name="inventory_id"
                            id="inventory_id"
                            value="<?php if(isset($inventory_id)) {echo set_value('inventory_id',$inventory_id);} else {echo set_value('inventory_id');} ?>"
                                disabled />
                    </div>
                </div>

                <!-- Generate inventory number -->
                <div class="row mb-2">
                    <div class="col-12">
                        <input type="button" class="form-control btn btn-sm btn-primary" name="inventory_number_button"
                            value="<?= lang('MY_application.btn_generate_inventory_nb') ?>" onclick="createInventoryNo()">
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Serial number -->
                <div class="row mb-2">
                    <div class="col-md-4">
                        <?= form_label(lang('MY_application.field_serial_number'), 'serial_number') ?>
                    </div>
                    <div class="col-md-8">
                        <?= form_input('serial_number', isset($serial_number) ? $serial_number : (isset($item['serial_number']) ? $item['serial_number'] : ''), [
                            'class' => 'form-control'
                        ]) ?>
                    </div>
                </div>

                <!-- Remarks -->
                <div class="row mb-2">
                    <div class="col-md-4">
                        <?= form_label(lang('MY_application.field_remarks'), 'remarks') ?>
                    </div>
                    <div class="col-md-8">
                        <?= form_textarea('remarks', isset($supplier_ref) ? $supplier_ref : (isset($item['remarks']) ? $item['remarks'] : ''), [
                            'class' => 'form-control',
                            'rows' => '2'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Separator -->
            <div class="col-12">
                <div class="border-top border-bottom border-primary mt-3 mb-3"></div>
            </div>

            <!-- Condition -->
            <div class="form-group col-md-6">
                <?= form_label(lang('MY_application.text_item_condition'), 'item_condition_id').form_dropdown('item_condition_id', $conditions, isset($item_condition_id) ? $item_condition_id : (isset($item['item_condition_id']) ? $item['item_condition_id'] : []), [
                        'class' => 'form-control'
                    ]);
                ?>
            </div>

            <!-- Stocking place -->
            <div class="form-group col-md-6">
                <?= form_label(lang('MY_application.field_stocking_place'), 'stocking_place_id').form_dropdown('stocking_place_id', $stocking_places, isset($stocking_place_id) ? $stocking_place_id : (isset($item['stocking_place_id']) ? $item['stocking_place_id'] : []), [
                        'class' => 'form-control'
                    ]);
                ?>
                <span class="text-danger"><?= isset($errors['stocking_place_id']) ? $errors['stocking_place_id']: ''; ?></span>
            </div>
        </div>

        <div class="row">
            <!-- Separator -->
            <div class="col-12">
                <div class="border-top border-bottom border-primary mt-3 mb-3"></div>
            </div>

            <!-- Supplier -->
            <div class ="col-md-4">
                <div class="form-group">
                    <?= form_label(lang('MY_application.field_supplier'), 'supplier_id').form_dropdown('supplier_id', $suppliers, isset($supplier_id) ? $supplier_id : (isset($item['supplier_id']) ? $item['supplier_id'] : []), [
                        'class' => 'form-control'
                    ]); ?>
                </div>
                <div class="form-group">
                    <?= form_label(lang('MY_application.field_supplier_ref'), 'supplier_ref').form_input('supplier_ref', isset($supplier_ref) ? $supplier_ref : (isset($item['supplier_ref']) ? $item['supplier_ref'] : ''), [
                        'class' => 'form-control'
                    ]) ?>
                </div>
            </div>

            <!-- Buying price and buying date -->
            <div class="col-md-4">
                <div class="form-group">
                    <?= form_label(lang('MY_application.field_buying_price'), 'buying_price').form_input('buying_price', isset($buying_price) ? $buying_price : (isset($item['buying_price']) ? $item['buying_price'] : ''), [
                        'class' => 'form-control'
                    ], 'number') ?>
                </div>
                <div class="form-group">
                    <?= form_label(lang('MY_application.field_buying_date'), 'buying_date').form_input('buying_date', isset($buying_date) ? $buying_date : (isset($item['buying_date']) ? $item['buying_date'] : ''), [
                        'class' => 'form-control',
                        'id' => 'buying_date',
                        'onblur' => 'change_warranty()'
                    ], 'date') ?>
                </div>
            </div>

            <!-- Warranty -->
            <div class="col-md-4">
                <div class="form-group">
                    <?= form_label(lang('MY_application.field_warranty_duration'), 'warranty_duration').form_input('warranty_duration', isset($warranty_duration) ? $warranty_duration : (isset($item['warranty_duration']) ? $item['warranty_duration'] : ''), [
                        'class' => 'form-control',
                        'id' => 'warranty_duration',
                        'onblur' => 'change_warranty()'
                    ], 'number') ?>
                </div>
                <span class="badge badge-success" id="garantie">Sous garantie</span>
            </div>
        </div>
    <?= form_close(); ?>
</div>

<!-- SCRIPT -->
<script>
    $(document).ready(function() {
        // Set bootstrap class for the multiselect dropdown list
        let no_filter = "<?= esc(lang('MY_application.field_no_type')); ?>";
        $('#item_tags-multiselect').multiselect({
            nonSelectedText: no_filter,
            buttonWidth: '100%',
            buttonClass: 'text-left form-control',
            numberDisplayed: 10
        });
        $('#entities_list').multiselect({
            nonSelectedText: no_filter,
            buttonWidth: '',
            buttonClass: 'form-control btn-info',
            numberDisplayed: 10
        });

        <?php if (isset($item_common)): ?>
            $('.multiselect').prop('disabled', true);
            $('#btn_submit_photo').prop('disabled', true);
            $('#item_common_name').prop('disabled', true);
            $('#item_common_description').prop('disabled', true);
            $('#item_common_group_id').prop('disabled', true);
            $('#item_common_linked_file').prop('disabled', true);
        <?php endif; ?>

        // Reload the page entirely if entity has been changed
        $('#e ul.multiselect-container input[type=radio]').change(() => {
            let url = location.href;
            let eItems = $("#e .multiselect-container .active input");
            if (eItems.length > 0) {
                url = url.replace(/\/\d+/, `/${eItems[0].value}`);
                location.href = url;
            }
        });

        // Refresh the image to prevent display of an old cach image.
        // Changing the src attribute forces browser to update.
        d = new Date();
        $("#picture").attr("src", "<?= base_url($config->images_upload_path.$imagePath); ?>?"+d.getTime()); 
    });

    function get(objectName) {
        switch (objectName) {
            case "item_groups":
                return <?php $array = ""; foreach($item_groups_list as $item_group) $array .= "'".$item_group['short_name']."',"; echo "[$array]"; ?>;

            case "item_tags":
                return <?php $array = ""; foreach($item_tags_list as $item_tag) $array .= "'".$item_tag['short_name']."',"; echo "[$array]"; ?>;

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

        if (buying_date.getDate() >= current_date.getDate()) remaining_months++;

        if (remaining_months > 3) {
            // Under warranty
            span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[1]; ?>";
            span_garantie.className = "badge badge-success";
        } else if (remaining_months > 0) {
            // Warranty expires soon
            span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[2]; ?>";
            span_garantie.className = "badge badge-warning";
        } else {
            if (!buying_date || !duration) {
                // Undetermined warranty
                span_garantie.innerHTML = "";
                span_garantie.className = "";
            } else {
                // Warranty expired
                span_garantie.innerHTML = "<?= lang('MY_application.text_warranty_status')[3]; ?>";
                span_garantie.className = "badge badge-danger";
            }
        }
    }

    function createInventoryNo() {
        let entities = JSON.parse('<?= json_encode($entities_list); ?>');
        let eItems = $("#e .multiselect-container .active input");
        var objectGroupField = $('#item_common_group_id').val();

        var objectGroups = get("item_groups");

        var tagShortName = getFirstTagShortName();
        var buyingDateField = document.getElementById('buying_date');
        var date = new Date(buyingDateField.value).getFullYear();
        var inventoryNumberField = document.getElementById('inventory_prefix');
        var inventoryNumber = "";
        var inventoryIdField = document.getElementById('inventory_id');
        var entityTag = '';
        $(entities).each((entity) => {
            if (entities[entity].entity_id == eItems[0].value) entityTag = entities[entity].shortname;
        });
        date = date.toString().slice(2,4);
        if(date == "N"){
            date = "00";
        }
        inventoryNumber = entityTag + "." + objectGroups[objectGroupField-1] + tagShortName + date;
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
