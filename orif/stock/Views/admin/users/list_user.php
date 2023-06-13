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
    <div class="row pb-3">
        <div id="e" class="col-sm-12">
            <?= form_label(lang('stock_lang.entity_name'),'entities_list_label').form_dropdown('e', $entities, isset($_GET["e"]) ? $_GET["e"] : $default_entity,'id="entities_list"');?>
        </div>
    </div>
    <div class="row pb-3">
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
$(document).ready(() => {
    var no_filter = "<?= htmlspecialchars(lang('MY_application.field_no_filter')); ?>";
    $('#entities_list').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        buttonClass: 'btn btn-outline-primary',
        numberDisplayed: 5
    });

    let eFilter = getEFilter();
    let isChecked = $('#toggle_deleted').prop('checked');
    history.pushState(null, "", "<?= base_url("stock/admin/list_user")?>"+ "/"+eFilter+"/"+(+isChecked));

    $('#e ul.multiselect-container input[type=radio]').change(() => {
        eFilter = getEFilter();
        isChecked = $('#toggle_deleted').prop('checked');
        updateUserList(eFilter, isChecked);
    });

    $('#toggle_deleted').change(e => {
        eFilter = getEFilter();
        isChecked = e.currentTarget.checked;
        updateUserList(eFilter, isChecked);
    });
});

function updateUserList(eFilter, isChecked) {
    history.pushState(null, "", "<?= base_url("stock/admin/list_user")?>"+ "/"+eFilter+"/"+(+isChecked));
    $.post('<?=base_url();?>/stock/admin/list_user/'+eFilter+"/"+(+isChecked), {}, data => {
        $('#userslist').empty();
        $('#userslist')[0].innerHTML = $(data).find('#userslist')[0].innerHTML;
    });
}

function getEFilter() {
    e = "";
    eItems = $("#e .multiselect-container .active input");
    if (eItems.length > 0) {
        e = eItems[0].value;
    } else {
        $('#alert_no_entities').removeClass('d-none');
    }

    return e;
}
</script>
