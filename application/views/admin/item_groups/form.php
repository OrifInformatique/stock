<div class="container"><h1 style="text-align: center">
<?php 

if (isset($groups)) {
  $update_group = TRUE;
} else {
  $update_group = FALSE;
}

// This part of the GeoLine is for Update
if(isset($groups)) { ?>
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($groups as $group) { ?>
    <option value="<?php echo $group->item_group_id; ?>"<?php if ($item_group_id == $group->item_group_id) {echo " selected";} ?>>"<?php echo $group->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" <?php } 
  else // This one is for Create 
    { ?><a class="line-through" href="<?php echo base_url(); ?>admin/view_groups"><span class="action">Ajout</span>, </a>
  <select onchange="changeNew()" <?php } ?>id="regions" style="border:none;width:205px;">
    <option value="item_group">Groupes d'objets</option>
	<option value="tag">tags</option>
    <option value="user">Utilisateurs</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="supplier">Fournisseurs</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, <span class="word-administration">Administration</span></a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

  <form class="container" method="post">
   <div class="form-group">
      <label for="name">Identifiant:</label>
      <input class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo $name;} else {echo set_value('name');} ?>" />
    </div>

    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
    <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_item_groups/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
  </form>

  <script src="<?php echo base_url(); ?>assets/js/geoline.js"></script>
</div>