<div class="container container-fluid">
    <?php if(isset($errors) && count($errors) > 0) {
        echo '<div class="alert alert-danger">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    } ?>

    <?php
        echo '<h2>' . ($action ? lang('stock_lang.update_entity') : lang('stock_lang.add_entity')) . '</h2>';
    ?>

    <form action="<?= base_url('stock/admin/save_entity' . ($action == 1 ? '/' . $action . '/' . $data['entity_id'] : '')) ?>" method="post">
        <span class="row row-responsive-2">
            <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
                <label for="name"><?=lang('stock_lang.name')?></label>
                <input type="text" id="name" placeholder="<?=lang('stock_lang.name')?>" class="form-control form-text" name="name" value="<?=isset($data) && isset($data['name']) ? $data['name'] : set_value('name')?>">
            </div>
            <div class="col-sm-6" style="max-width: calc(50% - .4rem);">
                <label for="address"><?=lang('stock_lang.field_address')?></label>
                <input type="text" id="address" placeholder="<?=lang('stock_lang.field_address')?>" class="form-control form-text" name="address" value="<?=isset($data) && isset($data['address']) ? $data['address'] : set_value('address')?>">
            </div>
        </span>
        <span class="row row-responsive-2">
            <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
                <label for="zip_code"><?=lang('stock_lang.zip_code')?></label>
                <input type="text" id="zip_code" placeholder="<?=lang('stock_lang.zip_code')?>" class="form-control form-text" name="zip" value="<?=isset($data) && isset($data['zip']) ? $data['zip'] : set_value('zip')?>">
            </div>
            <div class="col-sm-6" style="max-width: calc(50% - .4rem);">
                <label for="locality"><?=lang('stock_lang.locality')?></label>
                <input type="text" id="locality" placeholder="<?=lang('stock_lang.locality')?>" class="form-control form-text" name="locality" value="<?=isset($data) && isset($data['locality']) ? $data['locality'] : set_value('locality')?>">
            </div>
        </span>
        <span class="row row-responsive-2">
            <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
                <label for="tag"><?=lang('stock_lang.tagname')?></label>
                <input type="text" id="tag" placeholder="<?=lang('stock_lang.tagname')?>" class="form-control form-text" name="tag" value="<?=isset($data) && isset($data['shortname']) ? $data['shortname'] : set_value('shortname')?>" maxlength="3">
            </div>
            <div class="col-sm-6 text-right align-items-center" style="display: flex;flex-direction: row;justify-content: end;align-items: end!important;padding-right: 2rem;margin-top: 1.2rem">
                <a href="<?=base_url('stock/admin/view_entity_list')?>" class="nav-link"><?=lang('common_lang.btn_cancel')?></a>
                <?php if(isset($data['archive']) && $data['archive'] != ''): ?>
                    <a href="<?=base_url('stock/admin/reactivate_entity/'.$data['entity_id'])?>" class="btn btn-secondary mr-2"><?=lang('common_lang.btn_reactivate')?></a>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary"><?=$action ? lang('common_lang.btn_edit') : lang('common_lang.btn_add')?></button>
            </div>
        </span>
    </form>
</div>
