<div id="item_detail" class="container">
    <!-- BUTTONS -->
    <div class="form-group col-xs-12">
        <a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item');} ?>"
            class="btn btn-primary" role="button"><?php echo $this->lang->line('btn_back_to_list'); ?></a>
    </div>
    
    <!-- ERROR MESSAGE -->
    <div class="alert alert-danger col-xs-12"><p>
        <?php echo $this->lang->line('msg_err_inexistent_item'); ?>
    </p></div>
</div>
