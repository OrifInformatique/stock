<div class=" container container-fluid">
        <?php if(isset($errors)&&count($errors)>0) {
            echo '<div class="alert alert-danger">';
            foreach ($errors as $error) {
                echo $error . '<br>';
            }
            echo '</div>';
        }
?>
    <?php
    if ($action==0)
        echo '<h2>'.lang('stock_lang.add_entity').'</h2>';
    else
        echo '<h2>'.lang('stock_lang.update_entity').'</h2>';
    ?>
    <form action="<?=base_url('stock/admin/save_entity/'.$action.'/'.(isset($data['entity_id'])?$data['entity_id']:''))?>" method="post">
    <span class="row row-responsive-2">
        <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
        <label for="entity_name"><?=lang('stock_lang.name')?></label>
        <input type="text" id="entity_name" placeholder="<?=lang('stock_lang.name')?>" class="form-control form-text" name="name" value="<?=isset($data)&&isset($data['name'])?$data['name']:''?>">
        </div>
        <div class="col-sm-6" style="max-width: calc(50% - .4rem);">
        <label for="entity_address"><?=lang('stock_lang.address')?></label>
        <input type="text" id="entity_address" placeholder="<?=lang('stock_lang.address')?>" class="form-control form-text " name="address" value="<?=isset($data)&&isset($data['address'])?$data['address']:''?>"></span>
        </div>
    </span>
<span class="row row-responsive-2">
        <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
        <label for="entity_name"><?=lang('stock_lang.zip_code')?></label>
        <input type="text" id="entity_zip_code" placeholder="<?=lang('stock_lang.zip_code')?>" class="form-control form-text" name="zip" value="<?=isset($data)&&isset($data['zip'])?$data['zip']:''?>">
        </div>
        <div class="col-sm-6" style="max-width: calc(50% - .4rem);">
        <label for="entity_address"><?=lang('stock_lang.locality')?></label>
        <input type="text" id="entity_locality" placeholder="<?=lang('stock_lang.locality')?>" class="form-control form-text" name="locality" value="<?=isset($data)&&isset($data['locality'])?$data['locality']:''?>"></span>
        </div>
</span>
<span class="row row-responsive-2">
    <div class="col-sm-6" style="max-width: calc(50% - .4rem)">
        <label for="entity_name"><?=lang('stock_lang.tagname')?></label>
        <input type="text" id="entity_tagname" placeholder="<?=lang('stock_lang.tagname')?>" class="form-control form-text" name="tag" value="<?=isset($data)&&isset($data['shortname'])?$data['shortname']:''?>">
    </div>
    <div class="col-sm-6 text-right align-items-center" style="display: flex;flex-direction: row;justify-content: end;align-items: end!important;padding-right: 2rem;margin-top: 1.2rem">
        <a href="<?=base_url('stock/admin/view_entity_list')?>" class="nav-link"><?=lang('common_lang.btn_cancel')?></a>
        <input type="submit" class="btn btn-primary" value="<?=$action!=0?lang('common_lang.btn_edit'):lang('common_lang.btn_add')?>">
    </div>
</span>
</div>
</form>
