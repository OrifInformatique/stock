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
          <option value="modify"><?php echo $this->lang->line('admin_modify');?></option>
          <option value="delete"><?php echo $this->lang->line('admin_delete');?></option>
          <option value="new"><?php echo $this->lang->line('admin_add');?></option>
        </select>,
        <select onchange="changeRegion()" 
        <?php 
      } 
      else 
      { // This one is for Create 
      ?>
        <a class="line-through" href="<?php echo base_url(); ?>admin/view_item_groups">
          <span class="action"><?php echo $this->lang->line('admin_add');?></span>, 
        </a>
        <select onchange="changeNew()" 
          <?php
        } 
        ?>
        id="regions" style="border:none;width:297px;">
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
  <div class="alert alert-danger"><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></div>
<?php } ?>
    <div class="row">
      <form class="container" method="post">
        <div class="form-input row">
            <div class="col-sm-3">
                <label for="short_name"><?php echo $this->lang->line('field_abbreviation') ?></label>
                <input type="text" maxlength="2" class="form-control" name="short_name" id="short_name" value="<?php if (isset($short_name)) {echo set_value('short_name',$short_name);} else {echo set_value('short_name');} ?>" />
            </div>
            <div class="col-sm-9">
                <label for="name"><?php echo $this->lang->line('field_surname') ?></label>
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
