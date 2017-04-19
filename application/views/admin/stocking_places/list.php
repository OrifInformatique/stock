<div class="container">
  <h1 style="text-align: center"><select id="regions" style="border:none;width:317px;" onchange="changeRegion()">
    <option value="stocking_place">Lieux de stockage</option>
    <option value="user">Utilisateurs</option>
    <option value="tag">Tags</option>
    <option value="supplier">Fournisseurs</option>
    <option value="item_group">Groupes d'objets</option>
  </select>, Administration</h1>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->
<div class="row">
<div class="col-lg-12 col-sm-12">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>Court</th>
        <th>Long</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($stocking_places as $stocking_place) { ?>
      <tr>
          <td>
            <a href="<?php echo base_url('/admin/modify_stocking_place').'/'.$stocking_place->stocking_place_id ?>" style="display:block"><?php echo $stocking_place->short; ?></a>
          </td>
          <td>
            <?php echo $stocking_place->name; ?>
            <a href="<?php echo base_url('/admin/delete_stocking_place').'/'.$stocking_place->stocking_place_id ?>"
              class="close" title="Supprimer le lieu">×</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<a href="<?php echo base_url(); ?>admin/new_user/" class="btn btn-primary">Nouveau…</a>
</div>
</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
