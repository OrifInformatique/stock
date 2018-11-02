<div class="container">
  <h1>
    <select id="rows" onchange="changeRow()">
      <?php foreach($item_groups as $item_group) { ?>
      <option value="<?php echo $item_group->item_group_id; ?>"<?php if ($item_group_id == $item_group->item_group_id) {echo " selected";} ?>>"<?php echo $item_group->name; ?>"</option>
      <?php } ?>
    </select>, 
    <select id="actions" onchange="changeAction()">
      <option value="delete">Suppression</option>
      <option value="modify">Modification</option>
      <option value="new">Ajout</option>
    </select>, 
    <select onchange="changeRegion()" id="regions">
      <option value="item_group">Groupes d'objets</option>
      <option value="user">Utilisateurs</option>
      <option value="tag">Tags</option>
      <option value="stocking_place">Lieux de stockage</option>
      <option value="supplier">Fournisseurs</option>
    </select>
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">, 
      <span class="word-administration">Administration</span>
    </a>
  </h1>
  <?php if($deletion_allowed) { ?>
  <div>
    <em><?php echo $this->lang->line('delete_item_group_ok_start'); echo $name; echo $this->lang->line('delete_item_group_ok_end'); ?></em>
  </div>
  <div class="btn-group">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg">Oui</a>
    <a href="<?php echo base_url()."admin/view_item_groups/";?>" class="btn btn-lg">Non</a>
  </div>
<?php } else { ?>
  <div class="alert alert alert-danger">
    <em><?php echo $this->lang->line('delete_item_group_notok_start'); echo $name; echo $this->lang->line('delete_item_group_notok_end'); ?></em>
  </div>
<?php } ?>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>