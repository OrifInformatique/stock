<div class="container mb-3">
    <!-- Button to return to the items list -->
    <a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item/index');} ?>"
       class="btn btn-primary mb-2" role="button"><i class="bi bi-arrow-left-circle"></i>&nbsp;<?= lang('MY_application.btn_back_to_list'); ?></a>

    <!-- Administration buttons for authorized users only -->
    <div class="row">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
            <div class="col-12">
                <a href="<?= base_url("item/create/{$entity_id}/{$item_common['item_common_id']}"); ?>" class="btn btn-outline-success mb-2" role="button">
                    <?= lang('My_application.btn_add_subitem'); ?>
                </a>
                <a href="<?= base_url('item_common/modify/' . $item_common['item_common_id']); ?>" class="btn btn-outline-warning mb-2" role="button">
                    <?= lang('MY_application.btn_modify'); ?>
                </a>
                <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                    <a href="<?= base_url('item_common/delete/' . $item_common['item_common_id']); ?>" class="btn btn-outline-danger mb-2" role="button">
                        <?= lang('MY_application.btn_delete_all'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- End of administration buttons -->

    <div class="row">
        <div class="mt-2 col-lg-3 col-md-4 col-sm-6">
            <img id="picture"
                 src="<?= base_url($item_common['image']); ?>"
                 width="100%"
                 alt="<?= lang('MY_application.field_image'); ?>"/>
        </div>
        <div class="mt-2 col">
            <div class="row">
                <div class="col-12">
                    <h3><span class="badge badge-info"><?= esc($item_common['entity']['name']) ?></span><?= ' '.esc($item_common['name']); ?></h3>
                    <p><?= esc($item_common['description']); ?></p>
                </div>
                <div class="col-md-6 col-md-4">
                    <?= lang('MY_application.field_group') . '&nbsp;:<br>'; ?>
                    <?= !is_null($item_common['item_group']) ? esc($item_common['item_group']['name']) : '' ?>
                </div>
                <div class="col-md-6 col-lg-4">
                    <?= lang('MY_application.field_tags') . '&nbsp;:<br>'; ?>
                    <?php if (!empty($item_common['tags'])): ?>
                        <?php foreach ($item_common['tags'] as $tag): ?>
                            <span class="badge badge-dark"><?= esc($tag[0]['name']) ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="col-12 mt-2">
                    <!-- Button to display linked file -->
                    <?php if (!empty($item_common['linked_file'])): ?>
                        <a href="<?= base_url('uploads/files/'.$item_common['linked_file']) ?>" class="btn btn-secondary"  role="button" >
                            <?= lang('MY_application.btn_linked_doc'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
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
                            <?= !is_null($item['condition']) ? $item['condition']['bootstrap_label'] : config('\Stock\Config\StockConfig')->item_no_data; ?>
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
                            <?= !is_null($item['stocking_place']) ? esc($item['stocking_place']['name']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                        </div>

                        <!-- Remarks -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_remarks'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['remarks']) ? $item['remarks'] : config('\Stock\Config\StockConfig')->item_no_data; ?>
                        </div>
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_serial_number'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['serial_number']) ? esc($item['serial_number']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
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
                            <?= !is_null($item['supplier']) ? $item['supplier']['name'] : config('\Stock\Config\StockConfig')->item_no_data; ?>
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
                            <?= !empty($item['warranty_duration']) ? $item['warranty_duration'].' '.lang('MY_application.text_months') : config('\Stock\Config\StockConfig')->item_no_data; ?>
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
                            <?= !empty($item['supplier_ref']) ? esc($item['supplier_ref']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                        </div>

                        <!-- Buying Date -->
                        <div class="col-12 pt-3">
                            <label><?= lang('MY_application.field_buying_date'); ?> :</label>
                        </div>
                        <div class="col-12">
                            <?= !empty($item['buying_date']) ? databaseToShortDate($item['buying_date']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                        </div>
                        <div class="col-12 pt-3">
                        <label><?= lang('MY_application.field_item_warranty') ?> :</label>
                        </div>
                        <div class="col-12">
                            <?php if ($item['warranty_status'] == 1): ?>
                                <span class="badge badge-success">
                            <?php elseif ($item['warranty_status'] == 2): ?>
                                <span class="badge badge-warning" >
                            <?php elseif ($item['warranty_status'] == 3): ?>
                                <span class="badge badge-danger" >
                            <?php else: ?>
                                <span> 
                            <?php endif; ?>
                            <?= lang('MY_application.text_warranty_status.' . $item['warranty_status']); ?>
                            </span>
                        </div>
                    </div>
                </div>

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
