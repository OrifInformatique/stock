<div class="container">
  <h1 class="xs-right">
    <select id="regions" onchange="changeRegion()">
      <option value="tag">Tags</option>
      <option value="user">Utilisateurs</option>
      <option value="stocking_place">Lieux de stockage</option>
      <option value="supplier">Fournisseurs</option>
      <option value="item_group">Groupes d'objets</option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">Administration</a>
  </h1>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <table class="table table-striped table-hover">
        <tbody>
          <?php foreach ($tags as $tag) { ?>
          <tr>
            <td>
              <a href="<?php echo base_url(); ?>admin/modify_tag/<?php echo $tag->item_tag_id; ?>"><?php echo html_escape($tag->name); ?></a>
              <span class=".text-center"><?php echo html_escape($tag->short_name); ?></span>
              <a href="<?php echo base_url(); ?>admin/delete_tag/<?php echo $tag->item_tag_id; ?>" class="close">×</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="<?php echo base_url(); ?>admin/new_tag/" class="btn btn-primary">Nouveau…</a>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>