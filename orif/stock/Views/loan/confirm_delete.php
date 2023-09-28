<?php
/**
 * View delete_user
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
?>
<div id="page-content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div>
                    <h3><?= lang('stock_lang.title_delete_loan') ?></h3>
                    <h4><?= esc($inventory_number).' - '.esc($item_common['name']); ?></h4>
                    <h4><?= lang('user_lang.what_to_do'); ?></h4>
                    <div class = "alert alert-warning" ><?= lang('stock_lang.loan_delete_explanation'); ?></div>
                </div>
                <div class="text-right">
                    <a href="<?= base_url("item/loans/{$loan['item_id']}"); ?>" class="btn btn-default">
                        <?= lang('common_lang.btn_cancel'); ?>
                    </a>
                    <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-danger">
                        <?= lang('stock_lang.btn_delete_loan'); ?>
                    </a>                             
                </div>
            </div>
        </div>
    </div>
</div>

