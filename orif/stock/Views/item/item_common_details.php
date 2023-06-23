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
                <?php if (!empty($item['linked_file'])): ?>
                    <a href="<?= base_url('uploads/files/'.$item['linked_file'])?>" class="btn btn-default pt-0 pl-0"  role="button" >
                        <?= lang('MY_application.btn_linked_doc'); ?>
                    </a>
                <?php else: ?>
                    <a href="#" class="btn btn-default pt-0 pl-0 disabled"  role="button">
                        <?= lang('MY_application.btn_linked_doc'); ?>
                    </a>
                <?php endif; ?>
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
    
</div>