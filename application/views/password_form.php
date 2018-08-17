<div class="container">
    <div class="row">
        <form id="change_password" method="post">
            <div class="form-group">
                <label for="old_password"><?=$this->lang->line('field_old_password');?></label>
                <input id="old_password" name="old_password" type="password" class="form-control" placeholder="<?=$this->lang->line('field_old_password');?>" value="<?php echo set_value('old_password'); ?>">
                <span class="text-danger"><?php echo form_error('old_password'); ?></span>
            </div>
            <div class="form-group">
                <label for="new_password"><?=$this->lang->line('field_new_password');?></label>
                <input id="new_password" name="new_password" type="password" class="form-control" placeholder="<?=$this->lang->line('field_new_password');?>" value="<?php echo set_value('new_password'); ?>">
                <span class="text-danger"><?php echo form_error('new_password'); ?></span>
            </div>
            <div class="form-group">
                <label for="confirm_password"><?=$this->lang->line('field_password_confirm');?></label>
                <input id="confirm_password" name="confirm_password" type="password" class="form-control" placeholder="<?=$this->lang->line('field_password_confirm');?>" value="<?php echo set_value('confirm_password'); ?>">
                <span class="text-danger"><?php echo form_error('confirm_password'); ?></span>
            </div>
            <div>
                <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="<?php echo $this->lang->line('btn_change_password'); ?>" />
                <a id="btn_cancel" class="btn btn-default" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </form>
        <?php echo $this->session->flashdata('message'); ?>
    </div>
</div>