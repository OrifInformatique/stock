<div class="container" id="content">
  <div class="row" style="text-align: center;">
    <h3 class="xs-right">
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
    </h3><br><br>
    <h1 class="alert alert-danger">Cette page devrait être inaccessible.</h1>
  </div>
</div>
<script type="text/javascript">
    function loadPage(endOfPageString) {
        var targetPart = $('#content');
        if(endOfPageString == undefined) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?php echo base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>