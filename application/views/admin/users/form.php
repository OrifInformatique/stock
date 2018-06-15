<div class="container">
	<h1 class="xs-right">
		<?php 
		if (isset($users)) 
		{
			$update_user = TRUE;
		} else {
			$update_user = FALSE;
		}
// This part of the GeoLine is for Update
		if(isset($users)) 
		{ 
			?>
		<select id="rows" onchange="changeRow()">
			<?php foreach($users as $user) { ?>
			<option value="<?php echo $user->user_id; ?>"<?php if ($user_id == $user->user_id) {echo " selected";} ?>>"<?php echo $user->username; ?>"</option>
			<?php } ?>
		</select>,
		<select id="actions" onchange="changeAction()">
			<option value="modify">Modification</option>
			<option value="delete">Suppression</option>
			<option value="new">Ajout</option>
		</select>, 
		<select onchange="changeRegion()" id="regions">
		<?php
		} else { 
		?>
		<a class="line-through" href="<?php echo base_url(); ?>admin/view_users">
			<span class="action">Ajout</span>, 
		</a>
		<select onchange="changeNew()" id="regions"><?php } ?> 
			<option value="user">Utilisateurs</option>
			<option value="tag">Tags</option>
			<option value="stocking_place">Lieux de stockage</option>
			<option value="supplier">Fournisseurs</option>
			<option value="item_group">Groupes d'objets</option>
		</select>,
		<a class="like-normal" href="<?php echo base_url(); ?>admin/"> 
			<span class="word-administration">Administration</span>
		</a>
	</h1>
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
            <?php } ?>
	<form method="post">
		<div class="form-group">
			<label for="username"><?php echo $this->lang->line('field_username') ?></label>
			<input class="form-control" name="username" id="username" value="<?php if (isset($username)) {echo set_value('username',$username);} else {echo set_value('username');} ?>" />
		</div>
		<div class="form-group">
			<label for="lastname"><?php echo $this->lang->line('field_surname') ?></label>
			<input class="form-control" name="lastname" id="lastname" value="<?php if (isset($lastname)) {echo set_value('lastname',$lastname);} else {echo set_value('lastname');} ?>" />
		</div>
		<div class="form-group">
			<label for="firstname"><?php echo $this->lang->line('field_name') ?></label>
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
			<input name="is_active" type="checkbox" value="TRUE" <?php if(isset($is_active) && $is_active == 1) {echo "checked";} else {echo set_checkbox('is_active', 'TRUE', TRUE);} ?> />
			<label style="display: inline-block;" for="is_active">Activé </label>
		</div>
		<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
		<a class="btn btn-primary" href="<?php echo base_url() . "admin/view_users/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
	</form>
	<script src="<?php echo base_url(); ?>assets/js/geoline.js">
	</script>
</div>