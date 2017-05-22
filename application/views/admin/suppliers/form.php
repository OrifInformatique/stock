<div class="container"><h1 style="text-align: center">
<?php 

if (isset($suppliers)) {
  $update_supplier = TRUE;
} else {
  $update_supplier = FALSE;
}

// This part of the GeoLine is for Update
if(isset($suppliers)) { ?>
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($suppliers as $supplier) { ?>
    <option value="<?php echo $supplier->supplier_id; ?>"<?php if ($supplier_id == $supplier->supplier_id) {echo " selected";} ?>>"<?php echo $supplier->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="modify">Modification</option>
    <option value="delete">Suppression</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" <?php } 
  else // This one is for Create 
    { ?><a class="line-through" href="<?php echo base_url(); ?>admin/view_suppliers"><span class="action">Ajout</span>, </a>
  <select onchange="changeNew()" <?php } ?>id="regions" style="border:none;width:205px;">
    <option value="supplier">Fournisseurs</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="tag">Tags</option>
    <option value="user">Utilisateurs</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, <span class="word-administration">Administration</span></a></h1>

  <em><?php echo validation_errors(); if (isset($upload_errors)) {echo $upload_errors;} ?></em>

  <form class="container" method="post">
   <div class="form-group">
      <label for="name">Identifiant:</label>
      <input class="form-control" name="name" id="name" value="<?php if (isset($name)) {echo $name;} else {echo set_value('name');} ?>" />
    </div>

   <div class="form-group">
      <label for="address_line1">Adresse 1:</label>
      <input class="form-control" name="address_line1" id="address_line1" value="<?php if (isset($address_line1)) {echo $address_line1;} else {echo set_value('address_line1');} ?>" />
    </div>
	
   <div class="form-group">
      <label for="address_line2">Adresse 2:</label>
      <input class="form-control" name="address_line2" id="address_line2" value="<?php if (isset($address_line2)) {echo $address_line2;} else {echo set_value('address_line2');} ?>" />
    </div>

   <div class="form-group">
      <label for="zip">NPA:</label>
      <input class="form-control" name="zip" id="zip" value="<?php if (isset($zip)) {echo $zip;} else {echo set_value('zip');} ?>" />
    </div>
	
   <div class="form-group">
      <label for="city">Ville:</label>
      <input class="form-control" name="city" id="city" value="<?php if (isset($city)) {echo $city;} else {echo set_value('city');} ?>" />
    </div>

   <div class="form-group">
      <label for="country">Pays:</label>
      <input class="form-control" name="country" id="country" value="<?php if (isset($country)) {echo $country;} else {echo set_value('country');} ?>" />
    </div>
	
   <div class="form-group">
      <label for="tel">Tel:</label>
      <input class="form-control" name="tel" id="tel" value="<?php if (isset($tel)) {echo $tel;} else {echo set_value('tel');} ?>" />
    </div>

   <div class="form-group">
      <label for="email">Mail:</label>
      <input class="form-control" name="email" id="email" value="<?php if (isset($email)) {echo $email;} else {echo set_value('email');} ?>" />
    </div>	
	
    <button type="submit" class="btn btn-primary"><?php echo $this->lang->line('btn_submit'); ?></button>
    <a class="btn btn-primary" href="<?php echo base_url() . "admin/view_suppliers/"; ?>"><?php echo $this->lang->line('btn_cancel'); ?></a>
  </form>

  <script src="<?php echo base_url(); ?>assets/js/geoline.js"></script>
</div>