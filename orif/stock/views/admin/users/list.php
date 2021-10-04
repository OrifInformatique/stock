<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_user/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
  
  <div class="row">
    <h3>
      <a href="#" onclick="loadPage('admin/view_users/')" class="tab_selected"><?= lang('admin_tab_users'); ?></a>
      <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_unselected"><?= lang('admin_tab_tags'); ?></a>
      <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_unselected"><?= lang('admin_tab_stocking_places'); ?></a>
      <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_unselected"><?= lang('admin_tab_suppliers'); ?></a>
      <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_unselected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
  </div>
  <div class="row">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr class="row">
                    <th><?= lang('header_username'); ?></th>
                    <th><?= lang('header_lastname'); ?></th>
                    <th><?= lang('header_firstname'); ?></th>
                    <th><?= lang('header_email'); ?></th>
                    <th><?= lang('header_user_type'); ?></th>
                    <th><?= lang('header_is_active'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr class="row">
                        <td>
                                <a href="<?= base_url('/admin/modify_user').'/'.$user->user_id ?>" style="display:block"><?= html_escape($user->username); ?></a>
                        </td>
                        <td><?= html_escape($user->lastname); ?></td>
                        <td><?= html_escape($user->firstname); ?></td>
                        <td><?= $user->email; ?></td>
                        <td><?= $user->user_type->name; ?></td>
                        <td>
                            <?php if ($user->is_active) {echo lang('text_yes');} else {echo lang('text_no');} ?>
                            <a href="<?= base_url('/admin/delete_user').'/'.$user->user_id ?>"
                                        class="close" title="<?= lang('admin_delete_user');?>">×</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
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