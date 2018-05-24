<div class="container">
  <h1>
    <?php 

    if (isset($item_groups)) {
      $update = TRUE;
    } else {
      $update = FALSE;
    }

// This part of the GeoLine is for Update
    if(isset($item_groups)) 
    { 
      ?>
      <select id="rows" onchange="changeRow()" style="text-align: right;">
        <?php 
        foreach($item_groups as $item_group) 
          { ?>
            <option value="<?php echo $item_group->item_group_id; ?>"<?php if ($item_group_id == $item_group->item_group_id) {echo " selected";} ?> >"<?php echo $item_group->name; ?>"</option>
            <?php 
          } 
          ?>
        </select>,
        <select id="actions" onchange="changeAction()">
          <option value="modify">Modification</option>
          <option value="delete">Suppression</option>
          <option value="new">Ajout</option>
        </select>,
        <select onchange="changeRegion()" 
        <?php 
      } 
      else 
      { // This one is for Create 
      ?>
        <a class="line-through" href="<?php echo base_url(); ?>admin/view_item_groups">
          <span class="action">Ajout</span>, 
        </a>
        <select onchange="changeNew()" 
          <?php
        } 
        ?>
        id="regions" style="border:none;width:297px;">
        <option value="item_group">Groupes d'objets</option>
        <option value="user">Utilisateurs</option>
        <option value="tag">Tags</option>
        <option value="stocking_place">Lieux de stockage</option>
        <option value="supplier">Fournisseurs</option>
      </select>,
      <a class="like-normal" href="<?php echo base_url(); ?>admin/">Administration</a>
  </h1>
  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>
    <div class="row">
      <form class="container" method="post">
        <div class="form-input row">
            <div class="col-sm-3">
                <label for="short_name">Abrévation:</label>
                <input type="text" maxlength="2" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
            </div>
            <div class="col-sm-9">
                <label for="name">Nom:</label>
                <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
            </div>
        </div>
        <br />
        <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
        <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_item_groups/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
