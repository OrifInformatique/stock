<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_stocking_place/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
    
  <div class="row">
    <h3>
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_selected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>

  <div class="row">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th><?= lang('field_short_name') ?></th>
          <th><?= lang('field_long_name') ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($stocking_places as $stocking_place) { ?>
        <tr>
          <td>
            <a href="<?= base_url('/admin/modify_stocking_place').'/'.$stocking_place->stocking_place_id ?>" style="display:block"><?= html_escape($stocking_place->short); ?></a>
          </td>
          <td>
            <?= html_escape($stocking_place->name); ?>
          </td>
          <td>
            <a href="<?= base_url('/admin/delete_stocking_place').'/'.$stocking_place->stocking_place_id ?>"
              class="close" title="<?= lang('admin_delete_stocking_place');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
    function loadPage(endOfPageString) {
        if($('#content').size == 0) {
            return;
        }
        if(endOfPageString == undefined || endOfPageString == null) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?= base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>