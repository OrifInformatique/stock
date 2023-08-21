<div class="container">
    <div class="row pb-3">
        <div id="e" class="col-sm-12">
            <?= form_label(lang('stock_lang.entity_name'), 'entities_list_label') . form_dropdown('e', $entities, isset($_GET["e"]) ? $_GET["e"] : $default_entity, 'id="entities_list"'); ?>
        </div>
    </div>
</div>

<script>
    var currentUrl = '<?= base_url($url_getView); ?>';
    currentUrl = currentUrl.replace(/(\d+)$/, '');

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
        history.pushState(null, "", currentUrl + eFilter + "/" + (+isChecked));
        updateItemsList(eFilter, isChecked);

        $('#e ul.multiselect-container input[type=radio]').on('change', (e) => {
            e.stopImmediatePropagation();
            eFilter = getEFilter();
            isChecked = $('#toggle_deleted').prop('checked');
            updateItemsList(eFilter, isChecked);
        });

        $('#toggle_deleted').on('change', (e) => {
            e.stopImmediatePropagation();
            eFilter = getEFilter();
            isChecked = e.currentTarget.checked;
            updateItemsList(eFilter, isChecked);
        });
    });

    function updateItemsList(eFilter, isChecked) {
        history.pushState(null, "", currentUrl + eFilter + "/" + (+isChecked));
        $.post(currentUrl + eFilter + "/" + (+isChecked), {}, data => {
            $('#itemsList').empty();

            // When length value is at 82, the result contains 82 spaces in a string (it counts tabs from the tbody even if it's empty)
            if ($(data).find('#itemsList tbody')[0].innerHTML.length === 82) {
                let message = '<div class="col-12 alert alert-info text-center">' + <?= json_encode(lang('stock_lang.entity_has_no_elements')) ?> + '</div>';
                $('#itemsList')[0].innerHTML = message;
            } else {
                $('#itemsList')[0].innerHTML = $(data).find('#itemsList')[0].innerHTML;
            }
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