<div id="item_detail" class="container">
    <!-- BUTTONS -->
    <div class="form-group col-xs-12">
        <a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item');} ?>"
            class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_list'); ?></a>
    </div>

    <!-- ERROR MESSAGE -->
    <div class="alert alert-danger col-xs-12"><p>
        <?= lang('MY_application.msg_err_inexistent_item'); ?>
    </p></div>
</div>
