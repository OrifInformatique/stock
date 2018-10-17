<div class="container" id="content">
  <div class="row">
    <h3 class="xs-right">
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_selected"><?php echo $this->lang->line('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_item_groups'); ?></a>
      <a href="#" onclick="loadPage('admin/')" class="tab_unselected"><?php echo $this->lang->line('admin_tab_admin'); ?></a>
    </h3>
  </div>
  <!-- First something more simple <span onclick="minilist()">Utilisateurs</span>, Administration -->

  <div class="row">
    <div class="table-responsive">

      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th><?php echo $this->lang->line('header_suppliers_name'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_address_1'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_address_2'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_NPA'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_city'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_country'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_phone'); ?></th>
            <th><?php echo $this->lang->line('header_suppliers_email'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($suppliers as $supplier) { ?>
          <tr>
            <td>
              <a href="<?php echo base_url('/admin/modify_supplier').'/'.$supplier->supplier_id ?>" style="display:block"><?php echo html_escape($supplier->name); ?></a>
            </td>
            <td><?php echo html_escape($supplier->address_line1); ?></td>
            <td><?php echo html_escape($supplier->address_line2); ?></td>
            <td><?php echo html_escape($supplier->zip); ?></td>
            <td><?php echo html_escape($supplier->city); ?></td>
            <td><?php echo html_escape($supplier->country); ?></td>
            <td><?php echo html_escape($supplier->tel); ?></td>
            <td>
              <?php echo $supplier->email; ?>
              <a href="<?php echo base_url('/admin/delete_supplier').'/'.$supplier->supplier_id ?>" class="close"
                title="<?php echo $this->lang->line('admin_delete_supplier');?>">×</a>
            </td>
          </tr>
          <?php } ?>
        </tbody>

      </table>
    </div>
      <a href="<?php echo base_url(); ?>admin/new_supplier/" class="btn btn-primary"><?php echo $this->lang->line('admin_new');?></a></div>

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
    background:#00bbff;
    border:1px solid #777;
    border-radius:4px 4px 0 0;
    margin-right:1px;
    color:#fff;
    text-decoration:none;
  }
  .tab_selected:hover {
    color: #fff;
  }
</style>
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