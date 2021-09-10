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
                    <h4><?= lang('stock_lang.really_delete')?></h4>
                    <div class = "alert alert-info" ><?= lang('stock_lang.tag_deletion_explanation')?></div>
                </div>
                <div class="text-right">
                    <a href="<?= base_url('stock/admin/view_tags'); ?>" class="btn btn-default">
                        <?= lang('common_lang.btn_cancel'); ?>
                    </a>
                    <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-primary">
                        <?= lang('stock_lang.btn_soft_delete_tag'); ?>
                    </a>
                    <a href="<?= base_url(uri_string().'/2'); ?>" class="btn btn-danger">
                        <?= lang('stock_lang.btn_delete_tag'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
