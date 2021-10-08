<?php
/**
 * View delete_tag
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
                    <h1><?= lang('stock_lang.stocking_place') . ' ' . esc($stocking_place['name']) . ' "'.esc($stocking_place['short']).'"' ?></h1>
                    <h4><?= lang('stock_lang.what_to_do')?></h4>
                    <div class = "alert alert-info" ><?= lang('stock_lang.stocking_place_deletion_explanation')?></div>

                    <?php if ( ! is_null($stocking_place['archive'])): ?>
                        <div class = "alert alert-warning" ><?= lang('stock_lang.stocking_place_already_disabled')?></div>
                    <?php endif;?>

                </div>
                <div class="text-right">
                    <a href="<?= base_url('stock/admin/view_stocking_places'); ?>" class="btn btn-default">
                        <?= lang('common_lang.btn_cancel'); ?>
                    </a>

                    <?php if (is_null($stocking_place['archive'])): ?>
                        <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-primary">
                            <?= lang('stock_lang.btn_soft_delete_stocking_place'); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url(uri_string().'/2'); ?>" class="btn btn-danger">
                        <?= lang('stock_lang.btn_delete_stocking_place'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
