<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_item_group/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
  
  <?php $type = 4; include __DIR__.'/../admin_bar.php';?>
  
  <div class="row">
    <table class="table table-striped table-hover">
      <tbody>
        <?php foreach ($item_groups as $item_group) { ?>
        <tr>
          <td>
            <a href="<?= base_url(); ?>admin/modify_item_group/<?= $item_group->item_group_id; ?>"><?= html_escape($item_group->name); ?></a>
            <span class=".text-center"><?= html_escape($item_group->short_name); ?></span>
            <a href="<?= base_url(); ?>admin/delete_item_group/<?= $item_group->item_group_id; ?>" class="close"
              title="<?= lang('admin_delete_item_group');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>