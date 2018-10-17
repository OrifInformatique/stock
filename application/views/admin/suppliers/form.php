<div class="container">
  <h1 class="xs-right">
    <?php 

    if (isset($suppliers)) {
      $update = TRUE;
    } else {
      $update = FALSE;
    }

    // This part of the GeoLine is for Update
    if($update) 
    {
      ?>
      <select id="rows" onchange="changeRow()">
        <?php foreach($suppliers as $supplier) { ?>
        <option value="<?php echo $supplier->supplier_id; ?>"
          <?php if ($supplier_id == $supplier->supplier_id) {echo " selected";} ?>
          >"<?php echo $supplier->name; ?>"</option>
          <?php } ?>

        </select>,
        <select id="actions" onchange="changeAction()">
          <option value="modify"><?php echo $this->lang->line('admin_modify'); ?></option>
          <option value="delete"><?php echo $this->lang->line('admin_delete'); ?></option>
          <option value="new"><?php echo $this->lang->line('admin_add'); ?></option>
        </select>,
        <select onchange="changeRegion()" 
        <?php 
      } 
      else 
      { // This one is for Create 
        ?>
        <a class="line-through" href="<?php echo base_url(); ?>admin/view_suppliers">
          <span class="action"><?php echo $this->lang->line('admin_add'); ?></span>,
        </a>
        <select onchange="changeNew()" <?php
      } ?>
      id="regions">
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
?><div class="alert alert-danger"><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></div>
<?php } ?>
  <div class="row">
    <form class="container" method="post">
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_name') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo set_value('name',$name);} else {echo set_value('name');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_first_adress') ?></label>
        <input type="text" class="form-control" name="address_line1" id="address_line1" value="<?php if (isset($address_line1)) {echo set_value('adress_line1',$address_line1);} else {echo set_value('address_line1');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_second_adress') ?></label>
        <input type="text" class="form-control" name="address_line2" id="address_line2" value="<?php if (isset($address_line2)) {echo set_value('adress_line2',$address_line2);} else {echo set_value('address_line2');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_postal_code') ?></label>
        <input type="number" min="1000" class="form-control" name="zip" id="zip" value="<?php if (isset($zip)) {echo set_value('zip',$zip);} else {echo set_value('zip');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_city') ?></label>
        <input type="text" class="form-control" name="city" id="city" value="<?php if (isset($city)) {echo set_value('city',$city);} else {echo set_value('city');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_tel') ?></label>
        <input type="text" class="form-control" name="tel" id="tel" value="<?php if (isset($tel)) {echo set_value('tel',$tel);} else {echo set_value('tel');} ?>" />
      </div>
      <br />
      <div class="form-input">
        <label for="name"><?php echo $this->lang->line('field_email') ?></label>
        <input type="text" class="form-control" name="email" id="email" value="<?php if (isset($email)) {echo set_value('email',$email);} else {echo set_value('email');} ?>" />
      </div>
      <br />
      <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
      <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_suppliers/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
    </form>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>