<div class="container mb-3">
    <!-- Button to return to the items list -->
    <a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item/index');} ?>"
       class="btn btn-primary mb-2" role="button"><i class="bi bi-arrow-left-circle"></i>&nbsp;<?= lang('MY_application.btn_back_to_list'); ?></a>

    <!-- Administration buttons for authorized users only -->
    <div class="row">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
            <div class="col-12">
                <a href="<?= base_url("item/create/{$entity_id}/{$item_common['item_common_id']}"); ?>" class="btn btn-outline-success btn-sm mb-2" role="button">
                    <?= lang('My_application.btn_add_subitem'); ?>
                </a>
                <a href="<?= base_url('item_common/modify/' . $item_common['item_common_id']); ?>" class="btn btn-outline-warning btn-sm mb-2" role="button">
                    <?= lang('MY_application.btn_modify'); ?>
                </a>
                <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                    <a href="<?= base_url('item_common/delete/' . $item_common['item_common_id']); ?>" class="btn btn-outline-danger btn-sm mb-2" role="button">
                        <?= lang('MY_application.btn_delete_all'); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <!-- End of administration buttons -->

    <!-- Item_common informations -->
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
</div>

<!-- Related items informations -->
<div class="container mb-3">
    <?php if (isset($items)):
        foreach ($items as $item): ?>
            <div class="row border bg-light rounded mb-2">
                <!-- Administration buttons for authorized users only -->
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && isset($can_modify) && $can_modify && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered): ?>
                    <div class="col-12 mt-2">
                        <a href="<?= base_url('item/modify/' . $item['item_id']); ?>" class="btn btn-outline-warning btn-sm mb-2" role="button">
                            <?= lang('MY_application.btn_modify'); ?>
                        </a>
                        <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin): ?>
                            <a href="<?= base_url('item/delete/' . $item['item_id']); ?>" class="btn btn-outline-danger btn-sm mb-2" role="button">
                                <?= lang('MY_application.btn_delete'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if (isset($item['current_loan']['planned_return_date'])): ?>
                            <!-- Button to return a loan -->              
                            <a href="<?=base_url('/item/return_loan/' . $item['current_loan']['loan_id'])?>"
                                class="btn btn-outline-success btn-sm mb-2"  role="button" >
                                <?= lang('MY_application.btn_return_loan'); ?>
                            </a>
                        <?php else: ?>
                            <!-- Button to create new loan -->              
                            <a href="<?=base_url('/item/create_loan/' . $item['item_id'])?>"
                                class="btn btn-outline-success btn-sm mb-2"  role="button" >
                                <?= lang('MY_application.btn_create_loan'); ?>
                            </a>
                        <?php endif; ?>
                        <!-- Button to display loans history -->
                        <a href="<?=base_url('/item/loans/' . $item['item_id'])?>"
                            class="btn btn-outline-primary btn-sm mb-2"  role="button" >
                            <?= lang('MY_application.btn_loans_history'); ?>
                        </a>
                        <!-- Button to create new inventory control -->              
                        <a href="<?= base_url('/item/create_inventory_control/'.$item['item_id']); ?>"
                            class="btn btn-outline-success btn-sm mb-2"  role="button">
                            <?= lang('MY_application.btn_create_inventory_control'); ?>
                        </a>
                        <!-- Button to display inventory controls history -->
                        <a href="<?= base_url('/item/inventory_controls/'.$item['item_id']); ?>"
                            class="btn btn-outline-primary btn-sm mb-2"  role="button" >
                            <?= lang('MY_application.btn_inventory_control_history'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <!-- End of administration buttons -->

                <!-- Item details -->
                <div class="col-lg-6">
                    <h4><?= $item['inventory_number']; ?></h4>
                    
                    <!-- Item condition -->
                    <?= !is_null($item['condition']) ? $item['condition']['bootstrap_label'] : config('\Stock\Config\StockConfig')->item_no_data; ?>
                    <!-- Loan status -->
                    <?= $item['current_loan']['bootstrap_label']; ?>
                    <!-- Remarks -->
                    <?php if (isset($item['remarks']) && !empty($item['remarks'])): ?>
                        <p class="alert alert-info mt-2" role="alert"><?= $item['remarks']; ?></p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <!-- Stocking place -->
                    <p>
                        <?= lang('MY_application.field_stocking_place').'&nbsp;:<br>'; ?>
                        <?= !empty($item['stocking_place']) ? esc($item['stocking_place']['name']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                    </p>
                    <!-- Serial number -->
                    <p>
                        <?= lang('MY_application.field_serial_number').'&nbsp;:<br>'; ?>
                        <?= !empty($item['serial_number']) ? esc($item['serial_number']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                    </p>
                    <!-- Supplier -->
                    <p>
                        <?php if(!empty($item['supplier'])): ?>
                            <?= lang('MY_application.field_supplier').'&nbsp;:<br>'; ?>
                            <?= $item['supplier']['name']; ?>
                            <?= (!empty($item['supplier_ref']) ? '<br>'.lang('MY_application.field_supplier_ref_abr').' '.esc($item['supplier_ref']) : ''); ?>
                        <?php endif ?>
                    </p>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <!-- Buying Price -->
                    <p>
                        <?= lang('MY_application.field_buying_price').'&nbsp;:<br>'; ?>
                        <?= !empty($item['buying_price']) ? esc($item['buying_price']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                    </p>
                    <!-- Buying Date -->
                    <p>
                        <?= lang('MY_application.field_buying_date').'&nbsp;:<br>'; ?>
                        <?= !empty($item['buying_date']) ? databaseToShortDate($item['buying_date']) : config('\Stock\Config\StockConfig')->item_no_data; ?>
                    </p>
                    <!-- Warranty -->
                    <p>
                        <!-- Warranty duration -->
                        <?= lang('MY_application.field_warranty_duration').'&nbsp;:<br>'; ?>
                        <?= !empty($item['warranty_duration']) ? $item['warranty_duration'].' '.lang('MY_application.text_months') : ''; ?>
                        
                        <!-- Warranty status -->
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
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- No item to display -->
        <div class="row border-top">
            <div class="alert alert-info">
                <?= lang('stock_lang.item_common_no_item'); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
