<div class="container">
	<h3 class="xs-right">
		<?php
			if (isset($users))
			{
				$update_user = TRUE;
			} else {
				$update_user = FALSE;
			} ?>
		<div class="row" style="margin-top: 5px;">
			<a href="<?= base_url(); ?>admin/view_generic/user" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
			<a href="<?= base_url(); ?>admin/view_generic/tag" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
			<a href="<?= base_url(); ?>admin/view_generic/stocking_place" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
			<a href="<?= base_url(); ?>admin/view_generic/supplier" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
			<a href="<?= base_url(); ?>admin/view_generic/item_group" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
		</div>
    <?php if($update_user) { ?>
    <div class="row alert alert-warning">
      <?php echo $this->lang->line('admin_modify'); ?>
    </div>
    <?php } else { ?>
    <div class="row alert">
      <?php echo $this->lang->line('admin_add'); ?>
    </div>
  <?php } ?>
	</h3>
        <?php
            if (!empty(validation_errors()) || !empty($upload_errors)) {
        ?>
	<div class="alert alert-danger">
		<?php
		echo validation_errors();
		if (isset($upload_errors))
			{
				echo $upload_errors;
			}
		?>
	</div>
            <?php } ?><div class="row">
	<form method="post">
		<div class="form-group">
			<label for="username"><?php echo $this->lang->line('field_username') ?></label>
			<input class="form-control" name="username" id="username" value="<?php if (isset($username)) {echo set_value('username',$username);} else {echo set_value('username');} ?>" />
		</div>
		<div class="form-group">
			<label for="lastname"><?php echo $this->lang->line('field_lastname') ?></label>
			<input class="form-control" name="lastname" id="lastname" value="<?php if (isset($lastname)) {echo set_value('lastname',$lastname);} else {echo set_value('lastname');} ?>" />
		</div>
		<div class="form-group">
			<label for="firstname"><?php echo $this->lang->line('field_firstname') ?></label>
			<input class="form-control" name="firstname" id="firstname" value="<?php if (isset($firstname)) {echo set_value('firstname',$firstname);} else {echo set_value('firstname');} ?>" />
		</div>
		<div class="form-group">
			<label for="email"><?php echo $this->lang->line('field_email') ?></label>
			<input class="form-control" name="email" id="email" value="<?php if (isset($email)) {echo set_value('email',$email);} else {echo set_value('email');} ?>" type="email" />
		</div>
		<div class="form-group">
			<label for="user_type_id"><?php echo $this->lang->line('field_status') ?></label>
			<select class="form-control" name="user_type_id">
				<?php foreach ($user_types as $user_type) { ?>
				<option value="<?php echo $user_type->user_type_id; ?>" <?php if(isset($user_type_id) && $user_type_id == $user_type->user_type_id) {echo "selected";} else {echo set_select('user_type_id', $user_type->user_type_id);} ?> ><?php echo $user_type->name; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<label for="pwd"><?php echo $this->lang->line('field_password') ; if ($update_user) { ?> (vide: ne rien changer)<?php } ?> :</label>
			<input class="form-control" name="pwd" id="pwd" type="password" value="<?php echo set_value('pwd'); ?>" placeholder="Au moins 6 caractères" />
		</div>
		<div class="form-group">
			<label for="pwdagain"><?php echo $this->lang->line('field_password_confirm')?></label>
			<input class="form-control" name="pwdagain" id="pwdagain" type="password" value="<?php echo set_value('pwdagain'); ?>" />
		</div>
		<div class="form-group">
			<input name="is_active" type="checkbox" value="TRUE" <?php if(isset($is_active) && $is_active == 1) {echo "checked";} ?> />
			<label style="display: inline-block;" for="is_active">Activé </label>
		</div>
		<button type="submit" class="btn btn-success"><?php echo $this->lang->line('btn_save'); ?></button>
		<a class="btn btn-danger" href="<?php echo base_url() . "admin/view_users/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
	</form>
	</div>
</div>