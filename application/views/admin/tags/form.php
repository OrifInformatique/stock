<div class="container"><h1 style="text-align: center">
<?php 

if (isset($tags)) {
  $update_tag = TRUE;
} else {
  $update_tag = FALSE;
}

// This part of the GeoLine is for Update
if(isset($tags)) { ?>
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($tags as $tag) { ?>
    <option value="<?php echo $tag->item_tag_id; ?>"<?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" <?php } 
  else // This one is for Create 
    { ?><a class="line-through" href="<?php echo base_url(); ?>admin/view_tags"><span class="action">Ajout</span>, </a>
  <select onchange="changeNew()" <?php } ?>id="regions" style="border:none;width:205px;">
    <option value="tag">Tags</option>
    <option value="user">Utilisateurs</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="supplier">Fournisseurs</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, <span class="word-administration">Administration</span></a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

  <form class="container" method="post">
   <div class="form-group">
      <label for="name">Identifiant:</label>
      <input class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo $name;} else {echo set_value('name');} ?>" />
    </div>

    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
    <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_tags/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
  </form>

  <script src="<?php echo base_url(); ?>assets/js/geoline.js"></script>
</div>