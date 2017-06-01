<br>
<div class="divitem" style="margin-left: auto; margin-right: auto; width: 500px; padding: 30px">
	Supprimer <?php
	if ($db == 'item')
		echo "l'élément";
	else
		echo "l'enregistrement";
	?> ?<br /><br />

	<div class="btn-group">
	<a href="<?php echo base_url().uri_string()."/confirmed";?>" target="_parent" class="btn btn-success">Oui</a>
	<a href="<?php echo base_url().'item/view/'.$id;?>" target="_parent" class="btn btn-danger">Non</a>
	</div>
</div>
