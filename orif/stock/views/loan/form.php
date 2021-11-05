<form class="container" method="post" enctype="multipart/form-data">
    <label for="date"><?= lang('MY_application.header_loan_date'); ?> :&nbsp;</label>
    <input class="form-control" name="date" type="date" value="<?php if(isset($date)) {echo $date;} else {echo set_value('date', date('Y-m-d'));} ?>" /><br />

    <label for="planned_return_date"><?= lang('MY_application.header_loan_planned_return'); ?> :&nbsp;</label>
    <input class="form-control" name="planned_return_date" type="date" value="<?php if(isset($planned_return_date)) {echo $planned_return_date;} ?>" /><br />

    <label for="real_return_date"><?= lang('MY_application.header_loan_real_return'); ?> :&nbsp;</label>
    <input class="form-control" name="real_return_date" type="date" value="<?php if(isset($real_return_date)) {echo $real_return_date;} else {echo set_value('real_return_date');} ?>" /><br />

    <label for="item_localisation"><?= lang('MY_application.header_loan_localisation'); ?> :&nbsp;</label>
    <input class="form-control" name="item_localisation" value="<?php if(isset($item_localisation)) {echo $item_localisation;} else {echo set_value('item_localisation');} ?>" /><br />

    <button type="submit" class="btn btn-success"><?= lang('MY_application.btn_save'); ?></button>
    <a class="btn btn-default" href="<?= base_url("item/loans/" . $item_id); ?>"><?= lang('MY_application.btn_cancel'); ?></a>
</form>
