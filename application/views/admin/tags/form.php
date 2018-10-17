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
        <option value="modify"><?php echo $this->lang->line('admin_modify'); ?></option>
        <option value="delete"><?php echo $this->lang->line('admin_delete'); ?></option>
        <option value="new"><?php echo $this->lang->line('admin_add'); ?></option>
      </select>, 
      <select onchange="changeRegion()" 
      <?php 
  } else { // This one is for Create 
    ?>
      <a class="line-through" href="<?php echo base_url(); ?>admin/view_tags"><span class="action"><?php echo $this->lang->line('admin_add'); ?></span>, </a>

       <select onchange="changeNew()" <?php } ?> id="regions"><!--<h1 style="text-align: center"><select id="regions" style="border:none;width:103px;" onchange="changeRegion()">-->
        <option value="user"><?php echo $this->lang->line('admin_tab_users'); ?></option>
        <option value="tag"><?php echo $this->lang->line('admin_tab_tags'); ?></option>
        <option value="stocking_place"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></option>
        <option value="supplier"><?php echo $this->lang->line('admin_tab_suppliers'); ?></option>
        <option value="item_group"><?php echo $this->lang->line('admin_tab_item_groups'); ?></option>
      </select>,
      <a class="like-normal" href="<?php echo base_url(); ?>admin/"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
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