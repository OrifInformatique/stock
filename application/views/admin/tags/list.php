<div class="container" id="content">
  <div class="row">
  <h3 class="xs-right">
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected">Utilisateurs</a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_selected">Tags</a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected">Lieux de stockage</a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected">Fournisseurs</a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected">Groupes d'objets</a>
      <a href="#" onclick="loadPage('admin/')" class="tab_unselected">Administration</a>
  </h3></div>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->
  <div class="row">
      <table class="table table-striped table-hover">
        <tbody>
          <?php foreach ($tags as $tag) { ?>
          <tr>
            <td>
              <a href="<?php echo base_url(); ?>admin/modify_tag/<?php echo $tag->item_tag_id; ?>"><?php echo html_escape($tag->name); ?></a>
              <span class=".text-center"><?php echo html_escape($tag->short_name); ?></span>
              <a href="<?php echo base_url(); ?>admin/delete_tag/<?php echo $tag->item_tag_id; ?>" class="close"
                title="Supprimer le tag">×</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="<?php echo base_url(); ?>admin/new_tag/" class="btn btn-primary">Nouveau…</a>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>
<style type="text/css">
  .tab_unselected {
    display:block;
    float:left;
    padding:10px 15px;
    background:#0000bb;
    border:1px solid #777;
    border-bottom:none;
    border-radius:4px 4px 0 0;
    margin-right:1px;
    color:#fff;
    text-decoration:none;
  }
  .tab_unselected:hover {
    color: #fff;
  }
  .tab_selected {
    display:block;
    float:left;
    padding:10px 15px;
    background:#00bbbb;
    border:1px solid #777;
    border-bottom:none;
    border-radius:4px 4px 0 0;
    margin-right:1px;
    color:#fff;
    text-decoration:none;
  }
  .tab_selected:hover {
    color: #fff;
  }
</style>