<div class="container">
    <!-- Item common -->
    <div class="row">
        <div class="row col-6">
            <div class="col-12"><h3><?= esc($item_common['name']); ?></h3></div>
            <div class="col-4"><?= lang('stock_lang.field_description') . ':'; ?></div>
            <div class="col-8"><?= esc($item_common['description']); ?></div>
            <div class="col-4"><?= lang('MY_application.field_group') . ':'; ?></div>
            <div class="col-8"><?= !is_null($item_common['item_group']) ? esc($item_common['item_group']['name']) : '' ?></div>
            <div class="col-4"><?= lang('MY_application.field_tags') . ':'; ?></div>
            <div class="col-8">
                <?php if (!empty($item_common['tags'])): ?>
                    <?php foreach($item_common['tags'] as $tag): ?>
                        <span class="badge badge-dark"><?= esc($tag[0]['name']) ?></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="col-4"><?= lang('stock_lang.field_linked_file') . ':'; ?></div>
            <div class="col-8">
                <!-- Button to display linked file -->
                <a href="<?= !empty($item['linked_file']) ? base_url('uploads/files/'.$item['linked_file']) : ''?>" class="btn btn-default pt-0 pl-0 <?= !empty($item['linked_file']) ? '' : 'disabled' ?>"  role="button" >
                    <?= lang('MY_application.btn_linked_doc'); ?>
                </a>
            </div>
        </div>
        <div class="col-4">
            <img id="picture"
                 src="<?= base_url($item_common['image']); ?>"
                 width="100%"
                 alt="<?= lang('MY_application.field_image'); ?>"/>
        </div>
        <div class="col-2">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
                <a href="<?= base_url('item/modify/' . $item_common['item_common_id']); ?>" class="btn btn-success mb-1 w-100" role="button">
                    <?= lang('common_lang.btn_add'); ?>
                </a>
                <a href="<?= base_url('item/modify/' . $item_common['item_common_id']); ?>" class="btn btn-warning mb-1 w-100" role="button">
                    <?= lang('MY_application.btn_modify'); ?>
                </a>
                <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                    <a href="<?= base_url('item/delete/' . $item_common['item_common_id']); ?>" class="btn btn-danger w-100" role="button">
                        <?= lang('MY_application.btn_delete'); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <!-- Item details list -->
    <?php foreach($items as $item): ?>
        <div class="row col-12">
            <div class="col-3">
                <div class="row">
                    <div class="col-12">
                        <h4><?= $item['inventory_number']; ?></h4>
                    </div>
                    <div class="col-12">

                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <!-- Stocking Place -->
                    <div class="col-12">
                        <label><?= lang('MY_application.field_stocking_place'); ?> :</label>
                    </div>
                    <div class="col-12">
                        <?= !is_null($item['stocking_place']) ? esc($item['stocking_place']['name']) : ''; ?>
                    </div>

                    <!-- Remarks -->
                    <div class="col-12 pt-3">
                        <label><?= lang('MY_application.field_remarks'); ?> :</label>
                    </div>
                    <div class="col-12">
                        <?= esc($item['remarks']); ?>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <!-- Supplier -->
                    <div class="col-12">
                        <label><?= lang('MY_application.field_supplier'); ?> :</label>
                    </div>
                    <div class="col-12">
                        <?= !is_null($item['supplier']) ? $item['supplier']['name'] : ''; ?>
                    </div>

                    <!-- Buying Price -->
                    <div class="col-12 pt-3">
                        <label><?= lang('MY_application.field_buying_price'); ?> :</label>
                    </div>
                    <div class="col-12">
                        <?= $item['buying_price']; ?>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row">
                    <!-- Supplier Ref -->
                    <div class="col-12">
                        <label><?= lang('MY_application.field_supplier_ref'); ?> :&nbsp;</label>
                    </div>
                    <div class="col-12">
                        <?= !empty($item['supplier_ref']) ? esc($item['supplier_ref']) : '-'; ?>
                    </div>

                    <!-- Buying Date -->
                    <div class="col-12 pt-3">
                        <label><?= lang('MY_application.field_buying_date'); ?> :</label>
                    </div>
                    <div class="col-12">
                        <?= !empty($item['buying_date']) ? databaseToShortDate($item['buying_date']) : ''; ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
