<div class="container">
  <h1 class="xs-right">
    <select id="rows" onchange="changeRow()" style="text-align: right;">
      <?php foreach($tags as $tag) { ?>
      <option value="<?php echo $tag->item_tag_id; ?>"<?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"</option>
      <?php } ?>
    </select>,
    <select id="actions" onchange="changeAction()" style="text-align: right;">
      <option value="delete">Suppression</option>
      <option value="modify">Modification</option>
      <option value="new">Ajout</option>
    </select>,
    <select id="regions" onchange="changeRegion()" style="text-align: right;">
      <option value="tag">Tags</option>
      <option value="user">Utilisateurs</option>
      <option value="stocking_place">Lieux de stockage</option>
      <option value="supplier">Fournisseurs</option>
      <option value="item_group">Groupes d'objets</option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/"">
      <span class="word-administration">Administration</span>
    </a>
  </h1>

  <em>Voulez-vous vraiment supprimer le tag "<?php echo $name; ?>" ?</em>
  <div class="btn-group col-xs-12">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg">Oui</a>
    <a href="<?php echo base_url()."admin/view_tags/";?>" class="btn btn-lg">Non</a>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js" />
</script>