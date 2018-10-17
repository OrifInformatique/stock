<div class="container">
  <h1>
    <select id="rows" onchange="changeRow()">
      <?php foreach($item_groups as $item_group) { ?>
      <option value="<?php echo $item_group->item_group_id; ?>"<?php if ($item_group_id == $item_group->item_group_id) {echo " selected";} ?>>"<?php echo $item_group->name; ?>"</option>
      <?php } ?>
    </select>, 
    <select id="actions" onchange="changeAction()">
      <option value="delete"><?php echo $this->lang->line('admin_delete');?></option>
      <option value="modify"><?php echo $this->lang->line('admin_modify');?></option>
      <option value="new"><?php echo $this->lang->line('admin_add');?></option>
    </select>, 
    <select onchange="changeRegion()" id="regions">
      <option value="user"><?php echo $this->lang->line('admin_tab_users'); ?></option>
      <option value="tag"><?php echo $this->lang->line('admin_tab_tags'); ?></option>
      <option value="stocking_place"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></option>
      <option value="supplier"><?php echo $this->lang->line('admin_tab_suppliers'); ?></option>
      <option value="item_group"><?php echo $this->lang->line('admin_tab_item_groups'); ?></option>
    </select>
    <a class="like-normal" href="<?php echo base_url(); ?>admin/">, 
      <span class="word-administration"><?php echo $this->lang->line('admin_tab_admin'); ?></span>
    </a>
  </h1>
  <div>
    <em><?php echo $this->lang->line('admin_delete_item_group_verify'); echo '"'.$name.'"'; ?> ?</em>
  </div>
  <div class="btn-group">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_item_groups/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js">
</script>