<div class="container">
    <div class="d-none alert alert-warning" id="no_items" role="alert">
        <?= lang('stock_lang.entity_has_no_items'); ?>
    </div>
    <?php if (!is_null($entities) && count($entities) == 0): ?>
        <div class="alert alert-warning" role="alert">
            <?= lang('stock_lang.no_entity'); ?>
        </div>
    <?php endif; ?>
    <?php if (!(is_null($entities) && is_null($item_groups))): ?>
        <h2><?=lang('stock_lang.title_excel_export')?></h2>
        <form action="javascript:void(0)" onsubmit="submitRequest()">
        <!-- <form method="post"> -->
            <div class="form-group pl-2">
                <div class="form_group entity_container mt-3">
                    <?= form_label(lang('stock_lang.entity_name'), 'entity_id').form_dropdown('entity_id', $entities, [], [
                        'id' => 'entity_id',
                        'class' => 'form-control pl-2 entity-selector'
                    ]) ?>
                </div>
                <div id="item_groups_div" class="form-group item_group_container mt-3"></div>
                <div class="mt-3">
                    <?= form_label(lang('stock_lang.group_by')); ?>
                    <div class="form-check">
                        <?= form_radio('by_item_common', config('\Stock\Config\StockConfig')->group_by_item_common, true, ['class' => 'form-check-input', 'id' => 'by_item_common']).form_label(lang('stock_lang.item_common'), 'by_item_common', ['class' => 'form-check-label']) ?>
                    </div>
                    <div class="form-check">
                        <?= form_radio('by_item_common', config('\Stock\Config\StockConfig')->group_by_item, false, ['class' => 'form-check-input', 'id' => 'by_item']).form_label(lang('MY_application.header_item_name'), 'by_item', ['class' => 'form-check-label']) ?>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end align-items-center form-group mt-2 pl-2 pr-4">
                <a href="<?=base_url()?>" class="mr-3" style="max-width: 100px" ><?=lang('common_lang.btn_cancel')?></a>
                <input type="submit" id="btn_submit" class="form-control btn btn-primary" value="<?=lang('stock_lang.btn_export')?>" style="max-width: 100px" />
            </div>
        </form>
        <div class="loaderContainer d-none">
            <svg id="loader" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
            </svg>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            <?= lang('stock_lang.no_entity_excel_export'); ?>
        </div>
        <div class="row justify-content-end align-items-center form-group">
            <a href="<?=base_url()?>" class="btn btn-primary mr-3" style="max-width: 100px" ><?=lang('common_lang.btn_back')?></a>
        </div>
    <?php endif; ?>
</div>
<script>
    window.onload = () => {
        checkEntityItems();
        get_item_groups_div_by_entity();
    }

    $('#entity_id').on('change', () => {
        get_item_groups_div_by_entity();
    });

    async function get_item_groups_div_by_entity() {
        let entityId = $('#entity_id').val();
        let url = `<?= base_url("/stock/export_excel/get_item_groups_div")?>/${entityId}`;

        await $.ajax({
            url: url,
            type: 'get',
            success: (response) => {
                let result = JSON.parse(response);
                $('#item_groups_div').html(result);
            }
        });
    }

    async function submitRequest() {
        const loaderContainer = document.querySelector('.loaderContainer');
        loaderContainer.querySelector('#loader').style.animation = 'rotate 1s ease-in-out infinite'
        loaderContainer.classList.remove('d-none');
        let entity_id = $('#entity_id').val();
        let group_id = $('#item_group_id').val();
        let formData = new FormData;
        
        formData.append('group_id', group_id);
        formData.append('entity_id', entity_id);

        let rep = await fetch('<?=base_url("stock/export_excel")?>', {
            method: 'POST',
            body: formData,
        });

        console.log(await rep);

        let datas = await rep.json();
        datas = datas.excel_datas;
        let link = document.createElement('a');
        let filename = $('#entity_id option:selected').text().trim().toLocaleLowerCase();
        console.log(filename);

        filename=filename.replace(' ','');
        filename+=(new Date()).toLocaleDateString();
        link.setAttribute('download',filename+'.xlsx');
        link.setAttribute('href','data: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,'+datas);
        link.click();
        loaderContainer.classList.add('d-none');
        loaderContainer.querySelector('#loader').style.animation='';
    }

    async function checkEntityItems() {
        let entityId = document.getElementById("entity_id").value;
        let url = `<?= base_url('stock/item/has_items/true'); ?>/${entityId}`;
        let response = await fetch(url, {method: 'POST'});
        let alert = document.getElementById('no_items');
        let submitButton = document.getElementById('btn_submit');
        const json = await response.json();

        if (json.has_items) {
            alert.classList.add('d-none');
            submitButton.disabled = false;
        } else {
            alert.classList.remove('d-none');
            submitButton.disabled = true;
        }
    }
</script>
