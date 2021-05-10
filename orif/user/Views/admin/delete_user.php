<?php
/**
 * View delete_user
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
?>
<div id="page-content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if(isset($_SESSION['user_id'])&&$_SESSION['user_id'] != $user['id']){ ?>
                    <div>
                        <h1><?= lang('user_lang.user').' "'.esc($user['username']).'"' ?></h1>
                        <h4><?= lang('user_lang.what_to_do')?></h4>
                        <div class = "alert alert-info" ><?= lang('user_lang.user_delete_explanation')?></div>
                        <?php if ($user['archive']) { ?>
                            <div class = "alert alert-warning" ><?= lang('user_lang.user_allready_disabled')?></div>
                        <?php } ?>
                    </div>
                    <div class="text-right">
                        <a href="<?= base_url('user/admin/list_user'); ?>" class="btn btn-default">
                            <?= lang('common_lang.btn_cancel'); ?>
                        </a>
                        <?php if (!$user['archive']) { ?>
                        <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-primary">
                            <?= lang('user_lang.btn_disable_user'); ?>
                        </a>
                        <?php } ?>
                        <a href="<?= base_url(uri_string().'/2'); ?>" class="btn btn-danger">
                            <?= lang('user_lang.btn_hard_delete_user'); ?>
                        </a>
                    </div>
                <?php } else { ?>
                    <div>
                        <h1><?= lang('user_lang.user').' "'.esc($user['username']).'"' ?></h1>
                        <div class = "alert alert-danger" ><?= lang('user_lang.user_delete_himself')?></div>
                    </div>
                    <div class="text-right">
                        <a href="<?= base_url('user/admin/list_user'); ?>" class="btn btn-secondary">
                            <?= lang('common_lang.btn_back'); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
