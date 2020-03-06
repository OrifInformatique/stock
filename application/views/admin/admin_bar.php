<div class="row">
    <h3>
        <a href="#" onclick="loadPage('user/admin/')" class="tab_<?=$type==0?'':'un'?>selected"><?= lang('admin_tab_users'); ?></a>
        <a href="#" onclick="loadPage('admin/view_tags/')" class="tab_<?=$type==1?'':'un'?>selected"><?= lang('admin_tab_tags'); ?></a>
        <a href="#" onclick="loadPage('admin/view_stocking_places/')" class="tab_<?=$type==2?'':'un'?>selected"><?= lang('admin_tab_stocking_places'); ?></a>
        <a href="#" onclick="loadPage('admin/view_suppliers/')" class="tab_<?=$type==3?'':'un'?>selected"><?= lang('admin_tab_suppliers'); ?></a>
        <a href="#" onclick="loadPage('admin/view_item_groups/')" class="tab_<?=$type==4?'':'un'?>selected"><?= lang('admin_tab_item_groups'); ?></a>
    </h3>
</div>
<script type="text/javascript">
    // Required on each page so that it does load no matter where the user is
    function loadPage(endOfPageString) {
        if($('#content').size == 0) {
            return;
        }
        if(endOfPageString == undefined || endOfPageString == null) {
            endOfPageString = "";
        }
        var newUrlForPart = ('<?= base_url(); ?>' + endOfPageString);
        $('#content').load(newUrlForPart + ' #content');
    }
</script>