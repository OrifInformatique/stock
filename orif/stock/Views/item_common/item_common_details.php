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
                    <?php foreach ($item_common['tags'] as $tag): ?>
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
                <a href="<?= base_url('item/create/' . $item_common['item_common_id']); ?>" class="btn btn-success mb-1 w-100" role="button">
                    <?= lang('common_lang.btn_add'); ?>
                </a>
                <a href="<?= base_url('item_common/modify/' . $item_common['item_common_id']); ?>" class="btn btn-warning mb-1 w-100" role="button">
                    <?= lang('MY_application.btn_modify'); ?>
                </a>
                <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                    <a href="<?= base_url('item_common/delete/' . $item_common['item_common_id']); ?>" class="btn btn-danger w-100" role="button">
                        <?= lang('MY_application.btn_delete'); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Item details list -->
    <?php if (isset($items)): ?>
        <?php foreach ($items as $item): ?>
            <hr>
            <div class="row col-12">
                <div class="col-6">
                    <h4><?= $item['inventory_number']; ?></h4>
                </div>
                <div class="col-6 text-right">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
                        <a href="<?= base_url('item/modify/' . $item['item_id']); ?>" class="btn btn-warning" role="button">
                            <?= lang('MY_application.btn_modify'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                        <a href="<?= base_url('item/delete/' . $item['item_id']); ?>" class="btn btn-danger" role="button">
                            <?= lang('MY_application.btn_delete'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-3">
                    <div class="row">
                        <!-- Item condition -->
                        <div class="col-12">
                            <label><?= lang('MY_application.field_item_condition'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !is_null($item['condition']) ? $item['condition']['bootstrap_label'] : '-'; ?>
                        </div>

                        <!-- Loan status -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_item_loan'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= $item['current_loan']['bootstrap_label']; ?>
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
                            <?= !is_null($item['stocking_place']) ? esc($item['stocking_place']['name']) : '-'; ?>
                        </div>

                        <!-- Remarks -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_remarks'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['remarks']) ? $item['remarks'] : '-'; ?>
                        </div>
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_serial_number'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['serial_number']) ? esc($item['serial_number']) : '-'; ?>
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
                            <?= !is_null($item['supplier']) ? $item['supplier']['name'] : '-'; ?>
                        </div>

                        <!-- Buying Price -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_buying_price'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= $item['buying_price']; ?>
                        </div>
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_warranty_duration'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['warranty_duration']) ? $item['warranty_duration'].' '.lang('MY_application.text_months') : '-' ?>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="row">
                        <!-- Supplier Ref -->
                        <div class="col-12">
                            <label><?= lang('MY_application.field_supplier_ref'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['supplier_ref']) ? esc($item['supplier_ref']) : '-'; ?>
                        </div>

                        <!-- Buying Date -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_buying_date'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['buying_date']) ? databaseToShortDate($item['buying_date']) : '-'; ?>
                        </div>
                        <div class="col-12 pt-3">
                        <label><?= lang('MY_application.field_item_warranty') ?> :</label>
                        </div>
                        <div class="col-12">
                            <?php 
                                if ($item['warranty_status'] == 1):
                                    echo '<span class="badge badge-success" >'; // UNDER WARRANTY
                                elseif ($item['warranty_status'] == 2):
                                    echo '<span class="badge badge-warning" >'; // WARRANTY EXPIRES SOON
                                elseif ($item['warranty_status'] == 3):
                                    echo '<span class="badge badge-danger" >';  // WARRANTY EXPIRED
                                else: 
                                    echo '<span>' . lang('MY_application.text_warranty_status.' . $item['warranty_status']); 
                                endif;
                            ?>
                            </span>
                        </div>
                    </div>
                </div>

                <?php if ($item): ?>
                <?php else: ?>
                <?php endif ?>

                <!-- Loans and controls -->
                <div class="row col-12 pt-3">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
                        <!-- Button to create new loan -->              
                        <div class="col-3">
                            <a href="<?=base_url('/item/create_loan/' . $item['item_id'])?>"
                                class="btn btn-primary w-100"  role="button" >
                                <?= lang('MY_application.btn_create_loan'); ?>
                            </a>
                        </div>

                        <!-- Button to display loans history -->
                        <div class="col-3">
                            <a href="<?=base_url('/item/loans/' . $item['item_id'])?>"
                                class="btn btn-default"  role="button" >
                                <?= lang('MY_application.btn_loans_history'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
                        <!-- Button to create new inventory control -->
                        <div class="col-3">
                            <a href="<?= base_url('/item/create_inventory_control/'.$item['item_id']); ?>"
                                class="btn btn-primary w-100"  role="button">
                                <?= lang('MY_application.btn_create_inventory_control'); ?>
                            </a>
                        </div>

                        <!-- Button for controls history -->
                        <div class="col-3">
                            <a href="<?= base_url('/item/inventory_controls/'.$item['item_id']); ?>"
                                class="btn btn-default"  role="button" >
                                <?= lang('MY_application.btn_inventory_control_history'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <hr>
        <div class="alert alert-info">
            <?= lang('stock_lang.item_common_no_item'); ?>
        </div>
    <?php endif; ?>
</div>
