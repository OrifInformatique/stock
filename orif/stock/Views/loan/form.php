<form id="loan_form" class="container" method="post" action="<?= $action_url ?>" enctype="multipart/form-data">
    <!-- ERROR MESSAGES -->
    <div class="row">
    <?php
        if (isset($errors) && !empty($errors)) {
            echo '<div class="alert alert-danger">';
            if (isset($errors) && !empty($errors)) {
                echo implode('<br>', array_values($errors));
            }
            echo '</div>';
        }
    ?>
    </div>
    <!-- HEADERS -->
    <div class="form_title row">
        <!-- ACTION -->
        <div class="col-md-4">
            <h3 class="title">
                <?= $title; ?>
            </h3>
        </div>
        <!-- ITEM COMMON NAME -->
        <div class="col-md-4">
            <h3 class="item_name">
                <?= $item_common['name']; ?>
            </h3>
        </div>

        <!-- ITEM COMMON INVENTORY NUMBER -->
        <div class="col-md-4">
            <h4 class="text-right inventory_nb">
                <?= lang('MY_application.field_inventory_number'). ' : ' .$item['inventory_number']; ?>
            </h4>
        </div>
    </div>
    <!-- FROM INPUTS -->
    <!-- LOANER -->
    <label for="loan_by_user_id"><?= lang('MY_application.header_loan_by_user'); ?> :&nbsp;</label>
    <p id="loan_by_user_id"><?php if (isset($loaner['username'])) echo $loaner['username']; ?></p>
    <!-- BORROWER -->
    <label for="loan_to_user_id"><?= lang('MY_application.header_loan_to_user'); ?> :&nbsp;</label>
    <?php if ($action == 'return'): ?>
        <input class="form-control" name="loan_to_user_id" value="<?php if (isset($borrower['username'])) echo $borrower['username']; ?>" disabled><br />
    <?php else: ?>
        <select class="form-control" name="loan_to_user_id">
            <option value=""></option>
            <?php foreach ($users as $user) { ?>
                <option value="<?= $user['id']; ?>" <?php if(isset($loan_to_user_id) && $user['id'] == $loan_to_user_id) echo 'selected'; ?>><?= $user['username']; ?></option>
            <?php } ?>
        </select><br />
    <?php endif; ?>
    <!-- BORROWER EMAIL -->
    <label for="borrower_email"><?php if ($action != 'return') echo '* '; echo lang('MY_application.field_borrower_email'); ?> :&nbsp;</label>
    <input class="form-control" name="borrower_email" value="<?php if (isset($borrower_email)) echo $borrower_email; ?>"
        <?php if ($action == 'return' || (isset($loan_to_user_id) && !empty($loan_to_user_id))) echo "disabled"; ?>/><br />
    <!-- ITEM LOCALISATION -->
    <label for="item_localisation"><?= lang('MY_application.header_loan_localisation'); ?> :&nbsp;</label>
    <input class="form-control" name="item_localisation" value="<?php if (isset($item_localisation)) echo $item_localisation; ?>"
        <?php if ($action == 'return') echo "disabled"?>/><br />
    <!-- LOAN DATE -->
    <label for="date"><?php if ($action != 'return') echo '* '; echo lang('MY_application.header_loan_date'); ?> :&nbsp;</label>
    <input class="form-control" name="date" type="date" value="<?php if (isset($date)) echo $date; ?>"
        <?php if ($action == 'return') echo "disabled";?>/><br />
    <!-- PLANNED RETURN DATE -->
    <label for="planned_return_date"><?php if ($action != 'return') echo '* '; echo lang('MY_application.header_loan_planned_return'); ?> :&nbsp;</label>
    <input class="form-control" name="planned_return_date" type="date" value="<?php if (isset($planned_return_date)) echo $planned_return_date; ?>"
        <?php if ($action == 'return') echo "disabled"?>/><br />
    <!-- REAL RETURN DATE -->
    <label for="real_return_date"><?php if ($action == 'return') echo '* '; echo lang('MY_application.header_loan_real_return'); ?> :&nbsp;</label>
    <input class="form-control" name="real_return_date" type="date" value="<?php if(isset($real_return_date)) echo $real_return_date; ?>"
        <?php if ($action == 'create' || $action == 'modify' && !isset($real_return_date)) echo 'disabled' ?> /><br />
    <!-- SUBMIT BUTTON -->
    <button type="submit" class="btn btn-success" <?php if ($action != 'return') echo 'onclick="enable_inputs()"'; ?>><?= lang('MY_application.btn_save'); ?></button>
    <a class="btn btn-default" href="<?php if ($action == 'modify') {echo base_url("item/loans/" . $item['item_id']);} else {echo base_url("item_common/view/" . $item['item_common_id']);} ?>">
        <?= lang('MY_application.btn_cancel'); ?></a>
</form>
<script>
    // Get users
    const users = <?= json_encode($users); ?>;

    /**
     * Sets the email according to the currently selected user
     */
    function set_borrower_email() {
        let user_id = $('select[name="loan_to_user_id"]').val();
        let user = users.find(u => u.id == user_id);
        let email = user ? user.email : '';
        $('input[name="borrower_email"]').val(email);

        // If a user is selected, the email field is disabled
        if ($('select[name="loan_to_user_id"]').val()  == "") {
            $('input[name="borrower_email"]').prop("disabled", false);
        } else {
            $('input[name="borrower_email"]').prop("disabled", true);
        }
    }

    /**
     * Enables inputs right before submitting the form
     */
    function enable_inputs () {
        $('input[name="borrower_email"]').prop("disabled", false);
        $('input[name="real_return_date"]').prop("disabled", false);
        $('#loan_form').submit();
    }

    $(document).on('change', 'select', set_borrower_email);
</script>