<?php

/**
 * save_user view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
$update = !is_null($user);
$validation = \Config\Services::validation();
?>
<div class="container">
    <!-- TITLE -->
    <div class="row">
        <div class="col">
            <h1 class="title-section"><?= lang('user_lang.title_user_' . ($update ? 'update' : 'new')); ?></h1>
        </div>
    </div>

    <!-- INFORMATION MESSAGE IF USER IS DISABLED -->
    <?php if ($update && $user['archive']) : ?>
        <div class="col-12 alert alert-info">
            <?= lang("user_lang.user_disabled_info"); ?>
        </div>
    <?php endif; ?>

    <!-- FORM OPEN -->
    <?php
    $attributes = array(
        'id' => 'user_form',
        'name' => 'user_form'
    );
    echo form_open(base_url('stock/admin/save_user/' . (isset($user['id']) ? $user['id'] : '')), $attributes, [
        'id' => $user['id'] ?? 0
    ]);
    ?>
    <!-- ERROR MESSAGES -->
    <?php if (!empty($validation->getErrors())) : ?>
        <div class="alert alert-danger" role="alert">
            <?= $validation->listErrors(); ?>
        </div>
    <?php endif; ?>

    <!-- USER FIELDS -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('user_lang.field_username'), 'user_name', ['class' => 'form-label']); ?>
                <?= form_input('user_name', $user_name ?? $user['username'] ?? '', [
                    'maxlength' => config("\User\Config\UserConfig")->username_max_length,
                    'class' => 'form-control', 'id' => 'user_name'
                ]); ?>
            </div>
            <div class="form-group">
                <?= form_label(lang('user_lang.field_email'), 'user_email', ['class' => 'form-label']); ?>
                <?= form_input('user_email', $user['email'] ?? '', [
                    'maxlength' => config('\User\Config\UserConfig')->email_max_length,
                    'class' => 'form-control', 'id' => 'user_email'
                ]); ?>

            </div>
            <div id="entities" class="form-group">
                <?= form_label(lang('stock_lang.entity_name'), 'entities-multiselect') . form_dropdown('entities[]', $entities, isset($user['user_entities']) ? array_column($user['user_entities'], 'fk_entity_id') : [], 'id="entities-multiselect" multiple="multiple"'); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?= form_label(lang('user_lang.field_usertype'), 'user_usertype', ['class' => 'form-label']); ?>
                <?php
                $dropdown_options = ['class' => 'form-control', 'id' => 'user_usertype'];
                if (isset($user) && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user['id']) {
                    $dropdown_options['disabled'] = 'disabled';
                    echo form_hidden('user_usertype', $user_usertype ?? $user['fk_user_type'] ?? "");
                    echo "<div class=\"alert alert-info\">" . lang('user_lang.user_update_usertype_himself') . "</div>";
                }

                ?>
                <?= form_dropdown('user_usertype', $user_types, $user_usertype ?? $user['fk_user_type'] ?? NULL, $dropdown_options); ?>
            </div>
            <div class="form-group">
                <label for="default_entity"><?= lang('stock_lang.default_entity_name') ?></label>
                <p id="no-options-message" class="alert alert-warning" style="display: none;"><?= lang('stock_lang.no_selected_entity'); ?></p>
                <select class="form-control mb-3" name="default_entity" id="default_entity">
                    <?php foreach ($default_entities as $entity) : ?>
                        <?php
                        $selectedId = null;

                        if (isset($user['user_entities'])) {
                            $filtered = array_filter($user['user_entities'], function ($userEntity) {
                                return isset($userEntity['default']) && $userEntity['default'] == true;
                            });

                            $ids = array_column($filtered, 'fk_entity_id');
                            $selectedId = reset($ids);
                        }
                        ?>
                        <option value="<?= $entity['entity_id'] ?>" data-tag-name="<?= $entity['shortname'] ?>" <?= ($selectedId == $entity['entity_id']) ? 'selected' : '' ?>>
                            <?= $entity['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <?php if (!$update) : ?>
        <!-- PASSWORD FIELDS ONLY FOR NEW USERS -->
        <div class="row">
            <div class="col-sm-6 form-group">
                <?= form_label(lang('user_lang.field_password'), 'user_password', ['class' => 'form-label']); ?>
                <?= form_password('user_password', '', [
                    'class' => 'form-control',
                    'id' => 'user_password'
                ]); ?>
            </div>
            <div class="col-sm-6 form-group">
                <?= form_label(lang('user_lang.field_password_confirm'), 'user_password_again', ['class' => 'form-label']); ?>
                <?= form_password('user_password_again', '', [
                    'maxlength' => config('\User\Config\UserConfig')->password_max_length,
                    'class' => 'form-control', 'id' => 'user_password_again'
                ]); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($update) : ?>
        <div class="row">
            <!-- RESET PASSWORD FOR EXISTING USER -->
            <div class="col-12">
                <a href="<?= base_url('user/admin/password_change_user/' . $user['id']); ?>">
                    <?= lang("user_lang.title_user_password_reset"); ?>
                </a>
            </div>

            <!-- ACTIVATE / DISABLE EXISTING USER -->
            <?php if ($user['archive']) : ?>
                <div class="col-12">
                    <a href="<?= base_url('user/admin/reactivate_user/' . $user['id']); ?>">
                        <?= lang("user_lang.user_reactivate"); ?>
                    </a>
                </div>
                <div class="col-12">
                    <a href="<?= base_url('user/admin/delete_user/' . $user['id']); ?>" class="text-danger">
                        <?= lang("user_lang.btn_hard_delete_user"); ?>
                    </a>
                </div>
            <?php else : ?>
                <div class="col-12">
                    <a href="<?= base_url('user/admin/delete_user/' . $user['id']); ?>" class="text-danger">
                        <?= lang("user_lang.user_delete"); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- FORM BUTTONS -->
    <div class="row">
        <div class="col text-right">
            <a class="btn btn-default" href="<?= base_url('user/admin/list_user'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
            <input type="submit" value="<?= lang('common_lang.btn_save') ?>" class="btn btn-primary" name="save">
        </div>
    </div>
    <?= form_close(); ?>
</div>

<script type="text/javascript">
    const select = document.getElementById('default_entity');
    const options = select.querySelectorAll('option');

    const values = [];
    options.forEach((option) => {
        values.push(option.value);
    });

    var no_filter = "<?= htmlspecialchars(lang('MY_application.field_no_filter')); ?>";
    $('#entities-multiselect, #default-entity-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        buttonClass: 'btn btn-outline-primary',
        numberDisplayed: 5
    });

    $('#entities ul.multiselect-container input[type=checkbox]').ready(() => {
        Array.from($('#entities ul.multiselect-container input[type=checkbox]')).forEach((checkbox) => {
            const optionValue = checkbox.value;
            const isChecked = checkbox.checked;

            toggleOptionByValue(select, optionValue, isChecked);

            // Add event listener for checkbox change event
            checkbox.addEventListener('change', (event) => {
                const isChecked = event.target.checked;
                toggleOptionByValue(select, optionValue, isChecked);
            });
        });
    });

    $('#entities ul.multiselect-container input[type=checkbox]').change((event) => {
        toggleOptionByValue(select, event.target.value, event.target.checked);
    });

    function toggleOptionByValue(selectElement, optionValue, show) {
        const options = selectElement.options;
        let selectedOptionIndex = selectElement.selectedIndex;
        let isCurrentSelectedHidden = false;

        // Find the current selected option
        for (let i = 0; i < options.length; i++) {
            if (options[i].selected) {
                selectedOptionIndex = i;
                if (options[i].value === optionValue) {
                    isCurrentSelectedHidden = !show;
                }
                break;
            }
        }

        // Toggle the display of the specified option
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === optionValue) {
                options[i].style.display = show ? 'block' : 'none';
                if (show) {
                    selectedOptionIndex = i; // Update the selected option index when showing the option
                }
                break;
            }
        }

        // Check if there are any visible options
        let hasVisibleOptions = false;
        for (let i = 0; i < options.length; i++) {
            if (options[i].style.display !== 'none') {
                hasVisibleOptions = true;
                break;
            }
        }

        // Display message if no visible options and select the first available option
        const messageElement = document.getElementById('no-options-message'); // Add an element with id="no-options-message" in your HTML to display the message
        if (!hasVisibleOptions) {
            messageElement.style.display = 'block';
            selectElement.selectedIndex = -1; // Deselect all options
        } else {
            messageElement.style.display = 'none';
            selectElement.selectedIndex = selectedOptionIndex; // Update the selected index
        }
    }
</script>