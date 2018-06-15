<div class="container">
  <h1 class="xs-right">
    <?php 
    if (isset($tags)) {
      $update_tag = TRUE;
    } else {
      $update_tag = FALSE;
    }
  // This part of the GeoLine is for Update
    if($update_tag) { ?>  
      <select id="rows" onchange="changeRow()">
        <?php foreach($tags as $tag) { ?>
        <option value="<?php echo $tag->item_tag_id; ?>"
          <?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"
        </option>
        <?php } ?>
      </select>, 
      <select id="actions" onchange="changeAction()">
        <option value="modify">Modification</option>
        <option value="delete">Suppression</option>
        <option value="new">Ajout</option>
      </select>, 
      <select onchange="changeRegion()" 
      <?php 
  } else { // This one is for Create 
    ?>
      <a class="line-through" href="<?php echo base_url(); ?>admin/view_tags"><span class="action">Ajout</span>, </a>

       <select onchange="changeNew()" <?php } ?> id="regions"><!--<h1 style="text-align: center"><select id="regions" style="border:none;width:103px;" onchange="changeRegion()">-->
        <option value="tag">Tags</option>
        <option value="user">Utilisateurs</option>
        <option value="stocking_place">Lieux de stockage</option>
        <option value="supplier">Fournisseurs</option>
        <option value="item_group">Groupes d'objets</option>
      </select>,
      <a class="like-normal" href="<?php echo base_url(); ?>admin/">Administration</a>
  </h1>
<?php
    if (!empty(validation_errors()) || !empty($upload_errors)) {
?>
  <div class="alert alert-danger">
    <?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?>
  </div>
<?php } ?>
  <div class="row">
    <form class="container" method="post">
      <div class="form-input row">
        <div class="col-sm-3">
            <label for="short_name">
            <?php echo $this->lang->line('field_abbreviation') ?>
            </label>
            <input type="text" maxlength="3" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
        </div>
        <div class="col-sm-9">
            <label for="name">
            <?php echo $this->lang->line('field_tag') ?>
            </label>
            <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
        </div>
    </div>
        <br />
        <button type="submit" class="btn btn-primary">
          <?php echo $this->lang->line('btn_submit'); ?>
        </button>
        <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_tags/"; ?>">
          <?php echo $this->lang->line('btn_cancel'); ?>
        </a> 
      </form>
    </div>
  </div>
  <script src="<?php echo base_url(); ?>assets/js/geoline.js"/>