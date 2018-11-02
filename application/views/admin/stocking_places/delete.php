<div class="container">
  <h1 class="xs-right">
    <select id="rows" onchange="changeRow()" style="text-align: right;">
      <?php 
      foreach($stocking_places as $stocking_place) {
      ?>
        <option value="<?php echo $stocking_place->stocking_place_id; ?>"
          <?php 
            if ($stocking_place_id == $stocking_place->stocking_place_id) 
            {
              echo " selected";
            } 
          ?>
        >
          "<?php echo $stocking_place->name; ?>"
        </option>
      <?php 
      } 
      ?>
    </select>, 
    <select id="actions" onchange="changeAction()">
      <option value="delete">Suppression</option>
      <option value="modify">Modification</option>
      <option value="new">Ajout</option>
    </select>,

    <select onchange="changeRegion()" id="regions" >
      <option value="stocking_place">Lieux de stockage</option>
      <option value="user">Utilisateurs</option>
      <option value="tag">Tags</option>
      <option value="stocking_place">Fournisseurs</option>
      <option value="item_group">Groupes d'objets</option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">
      <span class="word-administration">Administration</span>
    </a>
  </h1>
  <?php if($deletion_allowed){ ?>
  <div>
    <em><?php echo $this->lang->line('delete_stocking_place_ok_start'); echo $short; echo ' ('; echo $name; echo ')'; echo $this->lang->line('delete_stocking_place_ok_end'); ?></em>
  </div>
  <div class="btn-group">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg">Oui</a>
    <a href="<?php echo base_url()."admin/view_stocking_places/";?>" class="btn btn-lg">Non</a>
  </div>
  <?php } else { ?>
    <div class="alert alert alert-danger">
      <em><?php echo $this->lang->line('delete_stocking_place_notok_start'); echo $short; echo " ("; echo $name; echo ")"; echo $this->lang->line('delete_stocking_place_notok_end'); ?></em>
    </div>
  <?php } ?>
</div>

<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>