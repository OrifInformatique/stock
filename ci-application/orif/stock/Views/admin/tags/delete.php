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
                    <h1><?= lang('stock_lang.tag') . ' ' . esc($tag['name']) . ' "'.esc($tag['short_name']).'"' ?></h1>
                    <h4><?= lang('stock_lang.what_to_do')?></h4>
                    <div class = "alert alert-info" ><?= lang('stock_lang.tag_deletion_explanation')?></div>

                    <?php if ( ! is_null($tag['archive'])): ?>
                        <div class = "alert alert-warning" ><?= lang('stock_lang.tag_already_disabled')?></div>
                    <?php endif;?>

                </div>
                <div class="text-right">
                    <a href="<?= base_url('stock/admin/view_tags'); ?>" class="btn btn-secondary">
                        <?= lang('common_lang.btn_cancel'); ?>
                    </a>

                    <?php if (is_null($tag['archive'])): ?>
                        <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-primary">
                            <?= lang('stock_lang.btn_soft_delete_tag'); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url(uri_string().'/2'); ?>" class="btn btn-danger">
                        <?= lang('stock_lang.btn_delete_tag'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
