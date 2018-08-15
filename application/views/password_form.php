<div class="container">
    <div class="row">
        <form id="change_password">
            <div class="form-group">
                <label for="old_password"><?=$this->lang->line('field_old_password');?></label>
                <input id="old_password" name="old_password" type="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="new_password"><?=$this->lang->line('field_new_password');?></label>
                <input id="new_password" name="new_password" type="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="confirm_password"><?=$this->lang->line('field_password_confirm');?></label>
                <input id="confirm_password" name="confirm_password" class="form-control" type="password">
            </div>
            <div>
                <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="<?php echo $this->lang->line('btn_change_password'); ?>" />
                <a id="btn_cancel" class="btn btn-default" href="<?php echo base_url(); ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
            </div>
        </form>
    </div>
</div>