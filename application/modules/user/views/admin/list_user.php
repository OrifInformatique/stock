<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Users List View
 *
 * @author      Orif, section informatique (UlSi, ViDi)
 * @link        https://github.com/OrifInformatique/gestion_questionnaires
 * @copyright   Copyright (c) Orif (http://www.orif.ch)
 */
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="title-section"><?= lang('title_user_list'); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 text-left">
            <a href="<?= base_url('user/admin/save_user'); ?>" class="btn btn-primary">
                <?= lang('btn_add_m'); ?>
            </a>
        </div>
        <div class="col-sm-9 text-right">
            <label class="btn btn-default form-check-label" for="toggle_deleted">
                <?= lang('field_deleted_users_display'); ?>
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
                <th><?= lang('field_user_name'); ?></th>
                <th><?= lang('field_user_usertype'); ?></th>
                <th><?= lang('field_user_active'); ?></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="userslist">
            <?php foreach($users as $user) { ?>
                <tr>
                    <td><a href="<?= base_url('user/admin/save_user/'.$user->id); ?>"><?= $user->username; ?></td>
                    <td><?= $user_types[$user->fk_user_type]; ?></td>
                    <td><?= $this->lang->line($user->archive ? 'no' : 'yes'); ?></td>
                    <td><a href="<?= base_url('user/admin/delete_user/'.$user->id); ?>" class="close">×</td>
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
        $.post('<?=base_url();?>user/admin/list_user/'+(+checked), {}, data => {
            $('#userslist').empty();
            $('#userslist')[0].innerHTML = $(data).find('#userslist')[0].innerHTML;
        });
    });
});
</script>
