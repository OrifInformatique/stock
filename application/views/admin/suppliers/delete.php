<div class="container"><h1 style="text-align: center">
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($tags as $tag) { ?>
    <option value="<?php echo $tag->item_tag_id; ?>"<?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="delete">Suppression</option>
    <option value="modify">Modification</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" style="border:none;width:232px;" onchange="changeRegion()">
    <option value="supplier">Fournisseurs</option>
    <option value="user">Utilisateurs</option>
    <option value="tag">Tags</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, Administration</a></h1>

  <div><em>Voulez-vous vraiment supprimer le fournisseur <?php echo $short; ?> (<?php echo $name; ?>) ?</em></div>
<div class="btn-group">
  <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg">Oui</a>
  <a href="<?php echo base_url()."admin/view_suppliers/";?>" class="btn btn-lg">Non</a>
</div>

 </div>