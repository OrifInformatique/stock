<div id="item_detail" class="container">
    <!-- BUTTONS -->
    <a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item');} ?>"
        class="btn btn-primary" role="button"><?php echo $this->lang->line('btn_back_to_list'); ?></a>
    <!-- ERROR MESSAGE -->
    <div class="row alert alert-danger"><div class="col-md-8"><p>
        <?php echo $this->lang->line('msg_err_id_inexisting'); ?>
    </p></div></div>
</div>