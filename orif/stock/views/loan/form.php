<form class="container" method="post" enctype="multipart/form-data">
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

    <label for="date"><?= lang('MY_application.header_loan_date'); ?> :&nbsp;</label>
    <input class="form-control" name="date" type="date" value="<?php if(isset($date)) {echo $date;} else {echo set_value('date', date(config('\Stock\Config\StockConfig')->database_date_format));} ?>" /><br />

    <label for="planned_return_date"><?= lang('MY_application.header_loan_planned_return'); ?> :&nbsp;</label>
    <input class="form-control" name="planned_return_date" type="date" value="<?php if(isset($planned_return_date)) {echo $planned_return_date;} ?>" /><br />

    <label for="real_return_date"><?= lang('MY_application.header_loan_real_return'); ?> :&nbsp;</label>
    <input class="form-control" name="real_return_date" type="date" value="<?php if(isset($real_return_date)) {echo $real_return_date;} else {echo set_value('real_return_date');} ?>" /><br />

    <label for="loan_to_user_id"><?= lang('MY_application.field_loan_to_user'); ?> :&nbsp;</label>
    <select class="form-control" name="loan_to_user_id">
        <option value=""></option>
        <?php foreach ($users as $user) { ?>
            <option value="<?= $user['id']; ?>" <?php if(isset($loan_to_user_id) && $user['id'] == $loan_to_user_id) {echo 'selected';} ?>><?= $user['username']; ?></option>
        <?php } ?>
    </select><br />

    <label for="borrower_email"><?= lang('MY_application.field_borrower_email'); ?> :&nbsp;</label>
    <input class="form-control" name="borrower_email" value="<?php if(isset($borrower_email)) {echo $borrower_email;} ?>" /><br />

    <label for="item_localisation"><?= lang('MY_application.header_loan_localisation'); ?> :&nbsp;</label>
    <input class="form-control" name="item_localisation" value="<?php if(isset($item_localisation)) {echo $item_localisation;} else {echo set_value('item_localisation');} ?>" /><br />

    <button type="submit" class="btn btn-success"><?= lang('MY_application.btn_save'); ?></button>
    <a class="btn btn-default" href="<?= base_url("item/loans/" . $item_id); ?>"><?= lang('MY_application.btn_cancel'); ?></a>
</form>
<script>
    const users = <?= json_encode($users); ?>;

    /**
     * Sets the planned return date to the start date + 3 months
     */
    function set_planned_return_date() {
        let start = new Date($('input[name="date"]').val());
        start.setMonth(start.getMonth() + 3);
        let year = start.getFullYear();
        let month = start.getMonth()+1; // Months are zero-indexed
        let day = start.getDate();

        month = month.toString().padStart(2, '0');
        day = day.toString().padStart(2, '0');
        let date = `${year}-${month}-${day}`;
        $('input[name="planned_return_date"]').val(date);
    }
    /**
     * Sets the email according to the currently selected user
     */
    function set_borrower_email() {
        let user_id = $('select[name="loan_to_user_id"]').val();
        let user = users.find(u => u.id == user_id);
        let email = user ? user.email : '';
        $('input[name="borrower_email"]').val(email);
    }

    $(document).ready(() => {
        // Sets the planned return date only if it's empty
        if ('<?= $new_loan; ?>' && !$('input[name="planned_return_date"]').val()) {
            $('input[name="date"]').on('change', set_planned_return_date);

            set_planned_return_date();

            // After a manual change, we just don't do it anymore
            $('input[name="planned_return_date"]').on('change', e => {
                $('input[name="date"]').off('change');
                $('input[name="planned_return_date"]').off('change');
            });
        }

        if (!$('input[name="borrower_email"]').val()) {
            $('select[name="loan_to_user_id"]').on('change', set_borrower_email);

            // After a manual change, we just don't do it anymore
            $('input[name="borrower_email"]').on('change', e => {
                $('select[name="loan_to_user_id"]').off('change');
                $('input[name="borrower_email"]').off('change');
            });
        }
    });
</script>
