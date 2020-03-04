<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
?>
<div id="page-content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if($_SESSION['user_id'] != $user->id){ ?>
                    <div>
                        <h1><?= lang('user').' "'.$user->username.'"' ?></h1>
                        <h4><?= lang('what_to_do')?></h4>
                        <div class = "alert alert-info" ><?= lang('user_delete_explanation')?></div>
                        <?php if ($user->archive) { ?>
                            <div class = "alert alert-warning" ><?= lang('user_allready_disabled')?></div>
                        <?php } ?>
                    </div>
                    <div class="text-right">
                        <a href="<?= base_url('user/admin/list_user'); ?>" class="btn btn-default">
                            <?= lang('btn_cancel'); ?>
                        </a>
                        <?php if (!$user->archive) { ?>
                        <a href="<?= base_url(uri_string().'/1'); ?>" class="btn btn-primary">
                            <?= lang('btn_disable'); ?>
                        </a>
                        <?php } ?>
                        <a href="<?= base_url(uri_string().'/2'); ?>" class="btn btn-danger">
                            <?= lang('btn_hard_delete'); ?>
                        </a>
                    </div>
                <?php } else { ?>
                    <div>
                        <h1><?= lang('user').' "'.$user->username.'"' ?></h1>
                        <div class = "alert alert-danger" ><?= lang('user_delete_himself')?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
