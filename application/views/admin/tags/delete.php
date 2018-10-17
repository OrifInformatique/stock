<div class="container">
  <h1 class="xs-right">
    <select id="rows" onchange="changeRow()" style="text-align: right;">
      <?php foreach($tags as $tag) { ?>
      <option value="<?php echo $tag->item_tag_id; ?>"<?php if ($item_tag_id == $tag->item_tag_id) {echo " selected";} ?>>"<?php echo $tag->name; ?>"</option>
      <?php } ?>
    </select>,
    <select id="actions" onchange="changeAction()" style="text-align: right;">
      <option value="delete"><?php echo $this->lang->line('admin_delete'); ?></option>
      <option value="modify"><?php echo $this->lang->line('admin_modify'); ?></option>
      <option value="new"><?php echo $this->lang->line('admin_add'); ?></option>
    </select>,
    <select id="regions" onchange="changeRegion()" style="text-align: right;">
      <option value="user"><?php echo $this->lang->line('admin_tab_users'); ?></option>
      <option value="tag"><?php echo $this->lang->line('admin_tab_tags'); ?></option>
      <option value="stocking_place"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></option>
      <option value="supplier"><?php echo $this->lang->line('admin_tab_suppliers'); ?></option>
      <option value="item_group"><?php echo $this->lang->line('admin_tab_item_groups'); ?></option>
    </select>,
    <a class="like-normal" href="<?php echo base_url(); ?>admin/"">
      <span class="word-administration"><?php echo $this->lang->line('admin_tab_admin'); ?></span>
    </a>
  </h1>

  <em><?php echo $this->lang->line('admin_delete_tag_verify'); ?>"<?php echo $name; ?>" ?</em>
  <div class="btn-group col-xs-12">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_tags/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js" />
</script>