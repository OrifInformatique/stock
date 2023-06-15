<div class="container">
    <?php
    $item_page = base_url('item/view/'.$item['item_id']);
    if (isset($_SESSION['user_access'])) {
        $registered_access = $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered;
    } else {
        $registered_access = false;
    }
    ?>

    <!-- BUTTONS -->
	<a href="<?= $item_page ?>" class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_object'); ?></a>

    <!-- ITEM NAME AND DESCRIPTION -->
	<a style="color:inherit;" href="<?= $item_page; ?>">
    <div class="row">
        <div class="col-md-4"><h3><?= $item['inventory_number']; ?></h3></div>
        <div class="col-md-7"><h3><?= $item['name']; ?></h3></div>
        <div class="col-md-1"><h6 class="text-right">ID <?= $item['item_id']; ?></h6></div>
    </div>
    <div class="row">
        <div class="col-md-12"><p><?= $item['description']; ?></p></div>
    </div>
	</a>

    <!-- LOANS LIST -->
	<?php if(empty($loans)) { ?>
	<em style="font-size:1.5em;" class="text-warning"><?= lang('MY_application.msg_no_loan'); ?></em>
	<?php } else { ?>
        <div class="col-lg-12 col-sm-12 table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= lang('MY_application.header_loan_date'); ?></th>
                        <th><?= lang('MY_application.header_loan_planned_return'); ?></th>
                        <th><?= lang('MY_application.header_loan_real_return'); ?></th>
                        <th><?= lang('MY_application.header_loan_localisation'); ?></th>
                        <th><?= lang('MY_application.header_loan_by_user'); ?></th>
                        <th colspan="2"><?= lang('MY_application.header_loan_to_user'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($loans as $loan) { ?>
                    <tr><div style="width:100%;height:100%">
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
                        <td><?php if (isset($loan['loan_to_user'])) {echo $loan['loan_to_user']['username'];} ?>
                        <td><?php if (isset($loan['borrower_email'])) { ?>
                            <a href="mailto:<?= $loan['borrower_email']; ?>"><?= $loan['borrower_email']; ?></a>
                        <?php } ?>

                        <!-- DELETE ACCESS RESTRICTED FOR ADMINISTRATORS ONLY -->
						<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) { ?>
				        <a href="<?= base_url('/item/delete_loan/'.$loan['loan_id']); ?>" class="close" title="Supprimer le prêt">×</a><?php } ?></td>
                    </div></a></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
	<?php } ?>
<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $registered_access) { ?>
	<a href="<?= base_url('item/create_loan/'.$item['item_id']); ?>" class="btn btn-primary"><?= lang('MY_application.btn_new') ?></a>
<?php } ?>
</div>
