<br>
<div class="divitem" style="margin-left: auto; margin-right: auto; width: 500px; padding: 30px">
	Supprimer <?php 
	if ($db == 'item')
		echo "l'élément";
	else
		echo "l'enregistrement"; 
	?> ?<br /><br />
	
	<div class="btn-group">
	<a href="<?php echo base_url().'item/remove_confirmed/'.$db.'/'.$id;?>" target="_parent" class="btn btn-success">Oui</a>
	<a href="<?php echo base_url().'item';?>" target="_parent" class="btn btn-danger">Non</a>
	</div>
</div>