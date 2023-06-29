<div class="container">
    <?= form_open(base_url("item_common/modify/{$item_common['item_common_id']}"), [
            'enctype' => 'multipart/form-data'
        ]); 
    ?>
        <div class="row">
            <!-- ERROR MESSAGES -->
            <div class="row col-12">
                <?php if (isset($upload_errors) && !empty($upload_errors)): ?>
                    <div class="alert alert-danger">
                        <?= implode('<br>', array_values($upload_errors)); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Buttons -->
            <div class="col-12 mb-3">
                <input type="submit" class="btn btn-success" id="btn_submit" name="btn_submit" value="<?= lang('MY_application.btn_save'); ?>" />
                <a href="<?= base_url("item_common/view/{$item_common['item_common_id']}"); ?>" class="btn btn-danger"><?= lang('MY_application.btn_cancel'); ?></a>
            </div>
            <div class="row col-12 col-md-8">
                <!-- Name -->
                <div class="row col-12">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_name'), 'item_common_name'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('item_common_name', isset($item_common_name) ? $item_common_name : $item_common['name'], [
                                'placeholder' => lang('stock_lang.field_name'),
                                'class' => 'form-control', 
                                'id' => 'item_common_name'
                            ]); 
                        ?>
                        <span class="text-danger"><?= isset($errors['name']) ? $errors['name']: ''; ?></span>
                    </div>
                </div>
                    
                <!-- Description -->
                <div class="row col-12">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_description'), 'item_common_description'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('item_common_description', isset($item_common_description) ? $item_common_description : $item_common['description'], [
                                'placeholder' => lang('stock_lang.field_item_common_name'),
                                'class' => 'form-control', 
                                'id' => 'item_common_description'
                            ]); 
                        ?>
                        <span class="text-danger"><?= isset($errors['description']) ? $errors['description']: ''; ?></span>
                    </div>
                </div>

                <!-- Item Group -->
                <div class="row col-12">
                    <div class="col-4">
                        <?= form_label(lang('MY_application.field_group'), 'item_common_group'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_dropdown('item_common_group', $item_groups, isset($item_common_group) ? $item_common_group : $item_common['item_group_id'], [
                                'class' => 'form-control',
                                'id' => 'item_common_group'
                            ]);
                        ?>
                        <span class="text-danger"><?= isset($errors['item_group_id']) ? $errors['item_group_id']: ''; ?></span>
                    </div>
                </div>

                <!-- Item Tags -->
                <div class="row col-12">
                    <div class="col-4">
                        <?= form_label(lang('MY_application.field_tags'), 'item_tags-multiselect'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_multiselect('item_common_tags[]', $item_tags, isset($item_common_tags) ? $item_common_tags : (!is_null($item_tag_ids) ? $item_tag_ids : []),'id="item_tags-multiselect" multiple="multiple"'); ?>
                    </div>
                </div>

                <!-- Linked File -->
                <div class="row col-12">
                    <div class="col-4">
                        <?= form_label(lang('stock_lang.field_linked_file'), 'item_common_linked_file'); ?>
                    </div>
                    <div class="col-8">
                        <?= form_input('linked_file', '', [
                            'class' => 'form-control-file',
                            'accept' => '.pdf, .doc, .docx',
                            'id' => 'item_common_linked_file'
                            ], 'file');
                        ?>
                        <span class="text-danger"><?= isset($errors['linked_file']) ? $errors['linked_file']: ''; ?></span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="row col-12 col-md-4 mb-3">
                <div class="col-12 mb-1">
                    <input type="submit" class="btn btn-primary w-100" name="btn_submit_photo" id="btn_submit_photo" value="<?= lang('MY_application.field_add_modify_photo') ?>"/>
                </div>
                <div class="col-12">
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
                <div class="form-group">
                    <input type="hidden" id="image" name="image" value="<?php if(isset($imagePath)){ echo $imagePath; }?>"/>
                </div>
            </div>
        </div>
    <?= form_close(); ?>
</div>

<script>
    $(document).ready(function() {
        let no_filter = "<?= esc(lang('MY_application.field_no_filter')); ?>";
        $('#item_tags-multiselect').multiselect({
            nonSelectedText: no_filter,
            buttonWidth: '100%',
            buttonClass: 'text-left form-control',
            numberDisplayed: 10
        });
    });
</script>