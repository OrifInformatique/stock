<form class="container" method="post">
    <div class="row">
        <h3>
            <?php foreach($admin_menus as $admin_menu) { ?>
                <a class="<?php
                    $class = 'tab_unselected';
                    if($admin_menu === $current_menu) {
                        $class = 'tab_selected';
                    }
                    echo $class;
                ?>" href="<?= base_url("admin/view_generic/{$admin_menu}"); ?>"><?php echo $this->lang->line("admin_tab_{$admin_menu}s"); ?></a>
            <?php } ?>
        </h3>
    </div>

    <div class="row alert alert-warning">
        <?php if($update) {
            echo lang('admin_modify');
        } else {
            echo lang('admin_add');
        } ?>
    </div>

    <?php if (!empty(validation_errors())) { ?>
        <div class="alert alert-danger"><?= validation_errors(); ?></div>
    <?php } ?>

    <form method="post">
        <?php $current_select = 0;
        foreach($fields as $field) { ?>
            <div class="form-group">
                <label for="<?= $field->name; ?>"><?= $field->text; ?></label>
                <?php if(in_array($field->type, ['text','number','password','checkbox','hidden'])) { ?>
                <input type="<?= $field->type; ?>" class="form-control" name="<?= $field->name; ?>" id="<?= $field->name; ?>" value="<?php
                if(isset($field->value)) {
                    echo set_value($field->name, $field->value);
                } else {
                    echo set_value($field->name);
                } ?>" <?php if(isset($field->other)) {
                    echo $field->other;
                } ?> <?php if($field->type === "checkbox" && $field->value == 1) echo "checked"; ?>>
                <?php } elseif ($field->type === "select") { ?>
                <select class="form-control" name="<?= $field->name; ?>" id="<?= $field->name; ?>">
                    <?php foreach($selects[$current_select] as $select) { ?>
                        <option value="<?= $select->value; ?>" <?php if($select->selected) {echo "checked";}; ?>><?= $select->text; ?></option>
                    <?php } ?>
                </select>
                <?php $current_select++;
                } ?>
            </div>
        <?php } ?>

        <div class="row">
            <button type="submit" class="btn btn-success"><?= lang('btn_save'); ?></button>
            <a class="btn btn-danger" href="<?= base_url("admin/view_generic/{$current_menu}"); ?>"><?= lang('btn_cancel'); ?></a>
        </div>
        <input type="hidden" name="category" value="<?= $current_menu; ?>">
    </form>
</form>