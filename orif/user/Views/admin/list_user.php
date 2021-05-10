<?php
/**
 * Users List View
 *
 * @author      Orif, section informatique (UlSi, ViDi, HeMa)
 * @link        https://github.com/OrifInformatique/gestion_questionnaires
 * @copyright   Copyright (c) Orif (http://www.orif.ch)
 */
helper("form");
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="title-section"><?= lang('user_lang.title_user_list'); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-left">
            <a href="<?= base_url('user/admin/save_user'); ?>" class="btn btn-primary">
                <?= lang('common_lang.btn_new_m'); ?>
            </a>
        </div>
        <div class="col-sm-9 text-right">
            <label class="btn btn-default form-check-label" for="toggle_deleted">
                <?= lang('user_lang.field_deleted_users_display'); ?>
            </label>
            <?= form_checkbox('toggle_deleted', '', $with_deleted, [
                'id' => 'toggle_deleted'
            ]); ?>
        </div>
    </div>
    <div class="row mt-2">
        <table class="table table-hover">
        <thead>
            <tr>
                <th><?= lang('user_lang.field_username'); ?></th>
                <th><?= lang('user_lang.field_email'); ?></th>
                <th><?= lang('user_lang.field_usertype'); ?></th>
                <th><?= lang('user_lang.field_user_active'); ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="userslist">
            <?php foreach($users as $user) { ?>
                <tr>
                    <td><a href="<?= base_url('user/admin/save_user/'.$user['id']); ?>"><?= esc($user['username']); ?></td>
                    <td><?= esc($user['email']); ?></td>
                    <td><?= $user_types[$user['fk_user_type']]; ?></td>
                    <td><?= lang($user['archive'] ? 'common_lang.no' : 'common_lang.yes'); ?></td>
                    <td><a href="<?= base_url('user/admin/delete_user/'.$user['id']); ?>" class="close">×</td>
                </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#toggle_deleted').change(e => {
        let checked = e.currentTarget.checked;
        $.post('<?=base_url();?>/user/admin/list_user/'+(+checked), {}, data => {
            $('#userslist').empty();
            $('#userslist')[0].innerHTML = $(data).find('#userslist')[0].innerHTML;
        });
    });
});
</script>
