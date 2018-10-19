<div class="container">
  <h4 class="xs-right">
    <div class="row">
      <?php foreach($tags as $tag) {  
        if(is_null($tag->item_tag_id)) { ?>
      <a href="<?php echo $tag->item_tag_id; ?>" class=<?php if ($item_tag_id == $tag->item_tag_id) {echo "tab_selected" ;}else{echo "tab_unselected";} ?>>
        <?php echo $tag->name; ?>
      </a>
      <?php } } ?>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="#" class="tab_unselected"><?php echo $this->lang->line('admin_modify'); ?></a>
      <?php if(is_null($tag->item_tag_id)){ ?>
      <a href="<?php echo base_url(); ?>admin/delete_tag/<?php echo $item_tag_id; ?>" class="tab_selected"><?php echo $this->lang->line('admin_delete'); ?></a>
      <?php } ?>
      <a href="<?php echo base_url(); ?>admin/new_tag/" class="tab_unselected"><?php echo $this->lang->line('admin_add'); ?></a>
    </div>
    <div class="row" style="margin-top: 5px;">
      <a href="<?php echo base_url(); ?>admin/view_users" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_tags" class="tab_selected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_stocking_places" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_suppliers" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="<?php echo base_url(); ?>admin/view_item_groups" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="<?php echo base_url(); ?>admin/" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </div>
  </h4>

  <?php if(isset($name)) { ?>
  <div class="row" style="margin-top: 20px;">
  <em><?php echo $this->lang->line('admin_delete_tag_verify'); ?>"<?php echo $name; ?>" ?</em></div>
  <div class="btn-group col-xs-12 row" style="margin-top: 10px;">
    <a href="<?php echo base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?php echo $this->lang->line('text_yes'); ?></a>
    <a href="<?php echo base_url()."admin/view_tags/";?>" class="btn btn-lg"><?php echo $this->lang->line('text_no'); ?></a>
  </div>
    <?php }else{ ?>
    <div class="row text-danger">
      <?php echo $this->lang->line('admin_error_missing_tag'); ?>
    </div><?php } ?>
</div>
<script src="<?php echo base_url(); ?>assets/js/geoline.js" />
</script>