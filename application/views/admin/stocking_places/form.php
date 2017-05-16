<div class="container"><h1 style="text-align: center">
<?php 

if (isset($stocking_places)) {
  $update_sp = TRUE;
} else {
  $update_sp = FALSE;
}

// This part of the GeoLine is for Update
if(isset($stocking_places)) { ?>
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($stocking_places as $stocking_place) { ?>
    <option value="<?php echo $stocking_place->stocking_place_id; ?>"<?php if ($stocking_place_id == $stocking_place->stocking_place_id) {echo " selected";} ?>>"<?php echo $stocking_place->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" <?php } 
  else // This one is for Create 
    { ?><a class="line-through" href="<?php echo base_url(); ?>admin/view_stocking_places"><span class="action">Ajout</span>, </a>
  <select onchange="changeNew()" <?php } ?>id="regions" style="border:none;width:205px;">
    <option value="stocking_place">Lieux de stockage</option>
    <option value="tag">Tags</option>
    <option value="user">Utilisateurs</option>
    <option value="supplier">Fournisseurs</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, <span class="word-administration">Administration</span></a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

  <form class="container" method="post">
   <div class="form-group">
      <label for="name">Identifiant:</label>
      <input class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo $name;} else {echo set_value('name');} ?>" />
    </div>

   <div class="form-group">
      <label for="short">Short:</label>
      <input class="form-control" name="short" id="short" value="<?php if (isset($short)) {echo $short;} else {echo set_value('short');} ?>" />
    </div>
	
	
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
    <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_stocking_places/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
  </form>

  <script src="<?php echo base_url(); ?>assets/js/geoline.js"></script>
</div>