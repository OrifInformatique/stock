<form class="container" method="post" action="<?= base_url('item/save_loan_return_date/'. $loan['loan_id']); ?>" enctype="multipart/form-data">
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

    <div class="form_title row">
        <!-- Retour du prêt -->
        <div class="col-md-4">
            <h3 class="title">
                <?= $title; ?>
            </h3>
        </div>
        <!-- Nom de l'objet concerné -->
        <div class="col-md-4">
            <h3 class="item_name">
                <?= $item_common['name']; ?>
            </h3>
        </div>

        <!-- Numéro d'inventaire de l'objet concerné -->
        <div class="col-md-4">
            <h4 class="text-right inventory_nb">
                <?= lang('MY_application.field_inventory_number'). ' : ' .$item['inventory_number']; ?>
            </h4>
        </div>
    </div>

    <label for="borrower_email"><?= lang('MY_application.field_borrower_email'); ?> :&nbsp;</label>
    <input class="form-control" name="borrower_email" value="<?= $loan['borrower_email']; ?>" disabled/><br />
    
    <label for="item_localisation"><?= lang('MY_application.header_loan_localisation'); ?> :&nbsp;</label>
    <input class="form-control" name="item_localisation" value="<?= $loan['item_localisation']; ?>" disabled/><br />
    
    <label for="loan_by_user"><?= lang('MY_application.header_loan_by_user'); ?> :&nbsp;</label>
    <input class="form-control" name="loan_by_user" value="<?= $loaner['username']; ?>" disabled/><br />

    <label for="date"><?= lang('MY_application.header_loan_date'); ?> :&nbsp;</label>
    <input class="form-control" name="date" type="date" value="<?= $loan['date']; ?>" disabled/><br />

    <label for="planned_return_date"><?= lang('MY_application.header_loan_planned_return'); ?> :&nbsp;</label>
    <input class="form-control" name="planned_return_date" type="date" value="<?= $loan['planned_return_date']; ?>" disabled/><br />

    <label for="real_return_date"><?= lang('MY_application.header_loan_real_return'); ?> :&nbsp;</label>
    <input class="form-control" name="real_return_date" type="date" value="<?php if(isset($real_return_date)) {echo $real_return_date;} else {echo date('Y-m-d');} ?>" /><br />

    <button type="submit" class="btn btn-success"><?= lang('MY_application.btn_save'); ?></button>
    <a class="btn btn-secondary" href="<?= base_url("item_common/view/" . $item['item_common_id']); ?>"><?= lang('MY_application.btn_cancel'); ?></a>
</form>
