<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>user/admin/new_tag/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
  
  <div class="row">
    <h3>
      <a href="#" onclick="loadPage('user/admin/view_users/')" class="tab_unselected"><?= lang('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('user/admin/view_tags/')" class="tab_selected"><?= lang('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('user/admin/view_stocking_places/')" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('user/admin/view_suppliers/')" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('user/admin/view_item_groups/')" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  
  <div class="row">
    <table class="table table-striped table-hover">
      <tbody>
        <?php foreach ($tags as $tag) { ?>
        <tr>
          <td>
            <a href="<?= base_url(); ?>user/admin/modify_tag/<?= $tag->item_tag_id; ?>"><?= html_escape($tag->name); ?></a>
            <span class=".text-center"><?= html_escape($tag->short_name); ?></span>
            <a href="<?= base_url(); ?>user/admin/delete_tag/<?= $tag->item_tag_id; ?>" class="close"
              title="<?= lang('admin_delete_tag');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
    // Required on each page so that it does load no matter where the user is
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