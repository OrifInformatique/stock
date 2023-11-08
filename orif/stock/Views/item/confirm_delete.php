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
                    <h3><?= esc($inventory_number).' - '.esc($item_common['name']); ?></h3>
                    <h4><?= lang('user_lang.what_to_do'); ?></h4>
                    <div class = "alert alert-warning" ><?= lang('stock_lang.item_delete_explanation'); ?></div>
                </div>
                <div class="text-right">
                    <a href="<?= base_url("item_common/view/{$item_common['item_common_id']}"); ?>" class="btn btn-default">
                        <?= lang('common_lang.btn_cancel'); ?>
                    </a>
                    <button class="btn btn-danger"  data-toggle="modal" data-target="#confirmDeleteItemCommon">
                        <?= lang('stock_lang.btn_delete_item'); ?>
                    </button>
                </div>
                <div class="modal fade" id="confirmDeleteItemCommon" tabindex="-1" aria-labelledby="lblConfirmDeleteItemCommon" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" style="margin: 0 auto;"><?= lang('stock_lang.really_want_to_delete_item'); ?></h2>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger text-center"><?= lang('stock_lang.hard_delete_item_explanation'); ?></div>
                            </div>
                            <div class="modal-footer justify-content-right">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('common_lang.btn_cancel'); ?></button>
                                <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-danger">
                                    <?= lang('stock_lang.btn_delete_item'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

