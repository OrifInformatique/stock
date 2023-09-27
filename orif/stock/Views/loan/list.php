<div class="container">
    <?php
    $item_page = base_url('item_common/view/'.$item['item_common_id']);
    if (isset($_SESSION['user_access'])) {
        $registered_access = $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered;
    } else {
        $registered_access = false;
    }
    ?>

    <!-- BUTTONS -->
	<a href="<?= $item_page ?>" class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_object'); ?></a>

    <!-- TITLE -->
    <div class="row">
        <div class="col-12"><h3><?= lang('MY_application.text_loans_history'); ?></h3></div>
        <div class="col-12"><p><?= $item['inventory_number'].' - '.$item_common['name']; ?></p></div>
    </div>

    <!-- LOANS LIST -->
    <?php if(empty($loans)) { ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info"><?= lang('MY_application.msg_no_loan'); ?></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= lang('MY_application.header_loan_date'); ?></th>
                        <th><?= lang('MY_application.header_loan_planned_return'); ?></th>
                        <th><?= lang('MY_application.header_loan_real_return'); ?></th>
                        <th><?= lang('MY_application.header_loan_localisation'); ?></th>
                        <th><?= lang('MY_application.header_loan_by_user'); ?></th>
                        <th><?= lang('MY_application.header_loan_to_user'); ?></th>
                        <!-- ADMINISTRATORS COLUMN ONLY -->
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) { ?>
                            <th></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($loans as $loan) { ?>
                    <tr>
                        <td>
                            <?php if ($registered_access) { ?>
                            <a href="<?= base_url('/item/modify_loan/'.$loan['loan_id']) ?>">
                            <?php }
                            echo $loan['date'];
                            if ($registered_access) { ?>
                            </a>
                            <?php } ?>
                        </td>
                        <td><?= $loan['planned_return_date']; ?></td>
                        <td><?= $loan['real_return_date']; ?></td>
                        <td><?= $loan['item_localisation']; ?></td>
                        <td><?= $loan['loan_by_user']['username']; ?></td>
                        <td>
                            <?php if (isset($loan['loan_to_user'])) {echo $loan['loan_to_user']['username'];} ?>
                            <?php if (isset($loan['borrower_email'])) { ?>
                                <a href="mailto:<?= $loan['borrower_email']; ?>"><?= $loan['borrower_email']; ?></a>
                            <?php } ?>
                        </td>

                        <!-- DELETE ACCESS RESTRICTED FOR ADMINISTRATORS ONLY -->
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) { ?>
                            <td><a href="<?= base_url('/item/delete_loan/'.$loan['loan_id']); ?>" class="close" title="Supprimer le prêt">×</a></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <!-- BUTTON TO CREATE NEW LOAN -->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $registered_access) { ?>
        <a href="<?= base_url('item/create_loan/'.$item['item_id']); ?>" class="btn btn-primary"><?= lang('MY_application.btn_new') ?></a>
    <?php } ?>
</div>
