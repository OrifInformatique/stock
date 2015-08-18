<br>
<div class="divitem" style="margin-left: auto; margin-right: auto; width: 500px; padding: 30px">

	<?php
		if(isset($error))
		{ 
			echo '<div style="color:red">';
			echo ($error);
			echo '</div>';
		
		}
	?>
	
	<?php echo form_open_multipart('item/do_upload/'.$item_id);?>

	Choisir une image à téléverser :<br><br>
	
	<input type="file" name="userfile" size="20" />
	
	<br /><br />
	
	<input type="submit" value="Charger" />
	
	</form>

</div>