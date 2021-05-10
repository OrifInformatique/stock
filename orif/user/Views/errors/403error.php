<?php
/**
 * 403 Access denied error view
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

http_response_code(403);
?>

<div id="message" class="container alert alert-danger">
    <div class="row">
        <div class="col">
            <h2><?= lang('user_lang.code_error_403')?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                <?php if (! empty($message) && $message !== '(null)') : ?>
                    <?= esc($message) ?>
                <?php else : ?>
                    <?= lang('user_lang.msg_err_access_denied_message').'.' ?>
                <?php endif ?>
            </p>
        </div>
    </div>
</div>
<div id="buttons" class="container">
    <div class="row">
        <div class="col text-right">
            <a href="<?=$_SESSION['_ci_previous_url']?>" class="btn btn-secondary" ><?=lang('common_lang.btn_back');?></a>
        </div>
    </div>
</div>
