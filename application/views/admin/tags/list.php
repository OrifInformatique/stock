<div class="container" id="content">
  <div class="row">
    <h3 class="xs-right">
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_selected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  <div class="row">
    <table class="table table-striped table-hover">
      <tbody>
        <?php foreach ($tags as $tag) { ?>
        <tr>
          <td>
            <a href="<?php echo base_url(); ?>admin/modify_tag/<?php echo $tag->item_tag_id; ?>"><?php echo html_escape($tag->name); ?></a>
            <span class=".text-center"><?php echo html_escape($tag->short_name); ?></span>
            <a href="<?php echo base_url(); ?>admin/delete_tag/<?php echo $tag->item_tag_id; ?>" class="close"
              title="<?php echo $this->lang->line('admin_delete_tag');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <a href="<?php echo base_url(); ?>admin/new_tag/" class="btn btn-primary"><?php echo $this->lang->line('admin_new');?></a>
  </div>
</div>
<script type="text/javascript">
    // Required on each page so that it does load no matter where the user is
    function loadPage(endOfPageString) {
        var targetPart = $('#content');
        if(endOfPageString == undefined || endOfPageString == null) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?php echo base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>