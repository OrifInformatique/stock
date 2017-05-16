<div class="container"><h1 style="text-align: center">
  <select id="rows" onchange="changeRow()" style="text-align: right;">
    <?php foreach($suppliers as $supplier) { ?>
    <option value="<?php echo $supplier->supplier_id; ?>"<?php if ($supplier_id == $supplier->supplier_id) {echo " selected";} ?>>"<?php echo $supplier->name; ?>"</option>
    <?php } ?>
  </select>, <select id="actions" onchange="changeAction()">
    <option value="delete">Suppression</option>
    <option value="modify">Modification</option>
    <option value="new">Ajout</option>
  </select>, <select onchange="changeRegion()" id="regions" style="border:none;width:232px;">
    <option value="supplier">Fournisseurs</option>
    <option value="user">Utilisateurs</option>
    <option value="tag">Tags</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="item_group">Groupes d'objets</option>
  </select><a class="like-normal" href="<?php echo base_url(); ?>admin/">, Administration</a></h1>

  <div><em>Voulez-vous vraiment supprimer le fournisseur <?php echo $name; ?> ?</em></div>
<div class="btn-group">
  <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg">Oui</a>
  <a href="<?php echo base_url()."admin/view_suppliers/";?>" class="btn btn-lg">Non</a>
</div>

 </div>

 <script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>