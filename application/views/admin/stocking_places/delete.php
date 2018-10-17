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
      <option value="delete"><?php echo $this->lang->line('admin_delete');?></option>
      <option value="modify"><?php echo $this->lang->line('admin_modify');?></option>
      <option value="new"><?php echo $this->lang->line('admin_add');?></option>
    </select>,

    <select onchange="changeRegion()" id="regions" >
      <option value="user"><?php echo $this->lang->line('admin_tab_users'); ?></option>
      <option value="tag"><?php echo $this->lang->line('admin_tab_tags'); ?></option>
      <option value="stocking_place"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></option>
      <option value="supplier"><?php echo $this->lang->line('admin_tab_suppliers'); ?></option>
      <option value="item_group"><?php echo $this->lang->line('admin_tab_item_groups'); ?></option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">
      <span class="word-administration"><?php echo $this->lang->line('admin_tab_admin'); ?></span>
    </a>
  </h1>

  <div>
    <em><?php echo $this->lang->line('admin_delete_stocking_place_verify'); echo $short; ?> (<?php echo $name; ?>) ?</em>
  </div>
  <div class="btn-group">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_stocking_places/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>