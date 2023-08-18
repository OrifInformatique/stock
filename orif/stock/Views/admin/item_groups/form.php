<?php
$validation=\Config\Services::validation();

if (isset($item_group))
  $update = TRUE;
else 
  $update = FALSE;
?>
<form class="container" method="post">
  <div class="row alert alert-warning">
    <?php 
    if($update) 
      echo lang('stock_lang.admin_modify');
    else 
      echo lang('stock_lang.admin_add');
    ?>
  </div>
  
  <div class="row">
    <div class="form-input row">
      <div class="col-sm-3">
        <label for="short_name"><?= lang('stock_lang.field_short_name') ?></label>
        <input type="text" maxlength="<?= config("\Stock\Config\StockConfig")->group_short_max_length ?>" class="form-control" name="short_name" id="short_name" value="<?php if (isset($item_group['short_name'])) {echo set_value('short_name',$item_group['short_name']);} else {echo set_value('short_name');} ?>" />
        <span class="text-danger"><?= $validation->showError('short_name'); ?></span>
      </div>
      <div class="col-sm-9">
        <label for="name"><?= lang('stock_lang.field_name') ?></label>
        <input type="text" class="form-control" name="name" id="name" value="<?php if (isset($item_group['name'])) {echo set_value('name',$item_group['name']);} else {echo set_value('name');} ?>" />
        <span class="text-danger"><?= $validation->showError('name'); ?></span>
        <select class="form-control mt-2" id="entity_selector" name="fk_entity_id">
            <?php foreach ($entities as $entity):?>
                <option value="<?=$entity['entity_id']?>" <?=isset($item_group['fk_entity_id'])&&$item_group['fk_entity_id']==$entity['entity_id']?'selected=true':''?>><?=$entity['name']?></option>
            <?php endforeach;?>
        </select>
        <span class="text-danger"><?= $validation->showError('fk_entity_id'); ?></span>
      </div>
    </div>
  </div>

<!-- ACTIVATE / DISABLE EXISTING STOCKING_PLACE -->
<?php if ($update): ?>
    <div class="row pt-3">
      <?php if ( ! is_null($item_group['archive'])): ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/reactivate_item_group/' . $item_group['item_group_id']) ?>">
            <?= lang('stock_lang.reactivate_item_group') ?>
          </a>
        </div>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_item_group/' . $item_group['item_group_id']) ?>" class="text-danger">
            <?= lang('stock_lang.hard_delete_item_group') ?>
          </a>
        </div>
      <?php else: ?>
        <div class="col-12 pl-0 pr-0">
          <a href="<?= base_url('stock/admin/delete_item_group/' . $item_group['item_group_id']) ?>" class="text-danger">
            <?= lang('stock_lang.delete_item_group') ?>
          </a>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <!-- FORM BUTTONS -->
  <div class="row">
    <div class="col text-right">
      <a class="btn btn-default" href="<?= base_url('stock/admin/view_item_groups'); ?>"><?= lang('common_lang.btn_cancel'); ?></a>
      <?= form_submit('save', lang('common_lang.btn_save'), ['class' => 'btn btn-primary']); ?>
    </div>
  </div>
</form>
