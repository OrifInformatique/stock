<div class="container"><h1 style="text-align: center">
<?php 

if (isset($tags)) {
  $update_tag = TRUE;
} else {
  $update_tag = FALSE;
}

// This part of the GeoLine is for Update
if($update_tag) { ?>
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($tags as $tag) { ?>
    <option value="<?php echo $tag->item_tag_id; ?>"<?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" <?php } 
  else { // This one is for Create 
    ?><a class="line-through" href="<?php echo base_url(); ?>admin/view_tags"><span class="action">Ajout</span>, </a>
  <select onchange="changeNew()" <?php
    } ?>
   id="regions" style="border:none;width:103px;"><!--<h1 style="text-align: center"><select id="regions" style="border:none;width:103px;" onchange="changeRegion()">-->

    <option value="tag">Tags</option>
    <option value="user">Utilisateurs</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="supplier">Fournisseurs</option>
    <option value="item_group">Groupes d'objets</option>

</select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, Administration</a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>
<div class="row">
<form class="container" method="post">
<div class="form-input">
<label for="name"><?php if ($update_tag) { ?>Entrer le nouveau nom:<?php } else { ?>Entrer le nom du nouveau tag:<?php } ?></label>
<input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
</div><br />
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
    <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_tags/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
</form>
</div>
</div>

</div>

<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
