<?php
/**
 * 401 Unauthorized access
 *
 * @author      Orif (ViDi,MoDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

http_response_code(401);
?>

<div id="message" class="wrap container alert alert-danger">
    <div class="row">
        <div class="col">
            <h2><?= lang('user_lang.code_error_401')?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p><?php
                if (! empty($message) && $message !== '(null)') {
                    esc($message);
                } else {            
                    if (ENVIRONMENT != 'production') {
                        echo lang('user_lang.msg_err_azure_unauthorized').' : ';
                        d($Exception);
                    } else {
                        echo lang('user_lang.msg_err_azure_unauthorized').'.';
                    }
                }
            ?></p>
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
