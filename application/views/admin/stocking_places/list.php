<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_stocking_place/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
    
  <?php $type = 2; include __DIR__.'/../admin_bar.php';?>
  
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
