<div class="container">
  <h1 class="xs-right">
    <select id="regions" onchange="changeRegion()">
      <option value="item_group">Groupes d'objets</option>
      <option value="user">Utilisateurs</option>
      <option value="tag">Tags</option>
      <option value="stocking_place">Lieux de stockage</option>
      <option value="supplier">Fournisseurs</option>
    </select>
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">, Administration</a>
  </h1>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <table class="table table-striped table-hover">
        <tbody>
          <?php  
          foreach ($item_groups as $item_group) 
          { 
          ?>
          <tr>
            <td>
              <a href="<?php echo base_url(); ?>admin/modify_item_group/<?php echo $item_group->item_group_id; ?>"><?php echo html_escape($item_group->name); ?></a>
              <span class=".text-center"><?php echo html_escape($item_group->short_name); ?></span>
              <a href="<?php echo base_url(); ?>admin/delete_item_group/<?php echo $item_group->item_group_id; ?>" class="close">×</a>
            </td>
          </tr>
          <?php
          } 
          ?>
        </tbody>
      </table><a href="<?php echo base_url(); ?>admin/new_item_group/" class="btn btn-primary">Nouveau…</a>
    </div>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>