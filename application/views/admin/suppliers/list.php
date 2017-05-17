<div class="container">
  <h1 style="text-align: center"><select id="regions" style="border:none;width:232px;" onchange="changeRegion()">
    <option value="supplier">Fournisseurs</option>
    <option value="user">Utilisateurs</option>
    <option value="tag">Tags</option>
    <option value="stocking_place">Lieux de stockage</option>
    <option value="item_group">Groupes d'objets</option>
  </select>, Administration</h1>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->
<div class="row">
<div class="col-lg-12 col-sm-12">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Nom</th>
        <th>Première ligne d'adresse</th>
        <th>Deuxième ligne d'adresse</th>
        <th>NPA</th>
        <th>Ville</th>
        <th>Pays</th>
        <th>Téléphone</th>
        <th>E-mail</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($suppliers as $supplier) { ?>
		    <tr>
          <td>
            <a href="<?php echo base_url('/admin/modify_supplier').'/'.$supplier->supplier_id ?>" style="display:block"><?php echo $supplier->name; ?></a>
          </td>
          <td><?php echo $supplier->address_line1; ?></td>
          <td><?php echo $supplier->address_line2; ?></td>
          <td><?php echo $supplier->zip; ?></td>
          <td><?php echo $supplier->city; ?></td>
          <td><?php echo $supplier->country; ?></td>
          <td><?php echo $supplier->tel; ?></td>
          <td>
            <?php echo $supplier->email; ?>
            <a href="<?php echo base_url('/admin/delete_supplier').'/'.$supplier->supplier_id ?>"
              class="close" title="Supprimer le fournisseur">×</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<a href="<?php echo base_url(); ?>admin/new_supplier/" class="btn btn-primary">Nouveau…</a>
</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
