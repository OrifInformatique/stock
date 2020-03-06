<div class="container" id="content">
  <div class="row">
    <a href="<?= base_url(); ?>admin/new_supplier/" class="btn btn-success"><?= lang('btn_new'); ?></a>
  </div>
  
  <?php $type = 3; include __DIR__.'/../admin_bar.php';?>
  
  <div class="row">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th><?= lang('header_suppliers_name'); ?></th>
          <th><?= lang('header_suppliers_address_1'); ?></th>
          <th><?= lang('header_suppliers_address_2'); ?></th>
          <th><?= lang('header_suppliers_NPA'); ?></th>
          <th><?= lang('header_suppliers_city'); ?></th>
          <th><?= lang('header_suppliers_country'); ?></th>
          <th><?= lang('header_suppliers_phone'); ?></th>
          <th><?= lang('header_suppliers_email'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($suppliers as $supplier) { ?>
        <tr>
          <td>
            <a href="<?= base_url('/admin/modify_supplier').'/'.$supplier->supplier_id ?>" style="display:block"><?= html_escape($supplier->name); ?></a>
          </td>
          <td><?= html_escape($supplier->address_line1); ?></td>
          <td><?= html_escape($supplier->address_line2); ?></td>
          <td><?= html_escape($supplier->zip); ?></td>
          <td><?= html_escape($supplier->city); ?></td>
          <td><?= html_escape($supplier->country); ?></td>
          <td><?= html_escape($supplier->tel); ?></td>
          <td>
            <?= $supplier->email; ?>
            <a href="<?= base_url('/admin/delete_supplier').'/'.$supplier->supplier_id ?>" class="close"
               title="<?= lang('admin_delete_supplier');?>">×</a>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
