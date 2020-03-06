<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_tag/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
  
  <?php $type = 1; include __DIR__.'/../admin_bar.php';?>
  
  <div class="row">
    <table class="table table-striped table-hover">
      <tbody>
        <?php foreach ($tags as $tag) { ?>
        <tr>
          <td>
            <a href="<?= base_url(); ?>admin/modify_tag/<?= $tag->item_tag_id; ?>"><?= html_escape($tag->name); ?></a>
            <span class=".text-center"><?= html_escape($tag->short_name); ?></span>
            <a href="<?= base_url(); ?>admin/delete_tag/<?= $tag->item_tag_id; ?>" class="close"
              title="<?= lang('admin_delete_tag');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
