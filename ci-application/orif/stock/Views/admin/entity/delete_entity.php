<?php
?>
<div class="container">
    <div class="alert alert-info">
        <?=lang('stock_lang.delete_entity_what_to_do')?>
    </div>
    <span class="row justify-content-end pr-2"><a href="<?=base_url('stock/admin/view_entity_list')?>" class="btn mr-2"><?=lang('common_lang.btn_cancel')?></a>
        <?php if (!isset($data['archive'])):?>
        <a href="<?=base_url('stock/admin/delete_entity/1/'.$data['entity_id'])?>" class="nav-link btn btn-primary mr-2"><?=lang('common_lang.btn_disable') ?></a>
        <?php endif;?>
        <a href="<?=base_url('stock/admin/delete_entity/2/'.$data['entity_id'])?>" class="nav-link btn btn-danger mr-2"><?=lang('common_lang.btn_delete')?></a> </span>
</div>
