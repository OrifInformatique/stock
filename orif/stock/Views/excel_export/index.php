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
        <div class="form-group pl-2">
            <label><?=lang('stock_lang.lbl_filter_to_use')?></label>
            <select class="form-control pl-2 export-filter" onchange="selectFilter(this)">
                <?php foreach ($filters as $filter): ?>
                <option value="<?=$filter['value']?>"><?=$filter['name']?></option>
                <?php endforeach;?>
            </select>
            <div class="form_group entity_container">
                <label><?=lang('stock_lang.entity_name')?></label>
                <select class="form-control pl-2 entity-selector" id="entity_id" name="entity_id" onchange="checkEntityItems()">
                    <?php foreach ($entities as $entity): ?>
                        <option value="<?=$entity['entity_id']?>"><?=$entity['name']?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group item_group_container d-none">
                <label><?=lang('stock_lang.btn_item_groups')?></label>
                <select class="form-control pl-2 item_groups_selector" id="item_group_id" name="item_group_id">
                    <?php foreach ($item_groups as $item_group): ?>
                        <option value="<?=$item_group['item_group_id']?>"><?=$item_group['name']?></option>
                    <?php endforeach;?>
                </select>
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
    }

    function selectFilter(element) {
        if(element.value==="1") {
            document.querySelector('.entity_container').classList.remove('d-none');
            document.querySelector('.item_group_container').classList.add('d-none');
        } else {
            document.querySelector('.entity_container').classList.add('d-none');
            document.querySelector('.item_group_container').classList.remove('d-none');
        }
    }

    selectFilter(document.querySelector('.export-filter'));
    async function submitRequest() {
        const loaderContainer = document.querySelector('.loaderContainer');
        loaderContainer.querySelector('#loader').style.animation = 'rotate 1s ease-in-out infinite'
        loaderContainer.classList.remove('d-none');
        let id_entity = document.querySelector('.entity_container select');
        let group_id = document.querySelector('.item_group_container select');
        let formData = new FormData;
        if (id_entity.parentElement.classList.contains('d-none')) {
            formData.append('group_id', group_id.value);
        } else if (group_id.parentElement.classList.contains('d-none')) {
            formData.append('id_entity', id_entity.value);

        }
        let rep = await fetch('<?=base_url("stock/export_excel")?>', {
            method: 'POST',
            body: formData,
        });
        let datas = await rep.json();
        datas = datas.excel_datas;
        let link = document.createElement('a');
        let filename = '';
        if (document.querySelector('.export-filter').nextElementSibling.classList.contains('d-none')) {
            let selectvalue = document.querySelector('.export-filter').nextElementSibling.nextElementSibling.querySelector('select').value;
            document.querySelector('.export-filter').nextElementSibling.nextElementSibling.querySelectorAll(' select > option').forEach((option) => {
                if (option.value === selectvalue) {
                    filename += option.innerText.trim().toLocaleLowerCase();
                }
            });
        } else {
            let selectvalue = document.querySelector('.export-filter').nextElementSibling.querySelector('select').value;
            document.querySelector('.export-filter').nextElementSibling.querySelectorAll(' select > option').forEach((option) => {
                if (option.value === selectvalue) {
                    filename += option.innerText.trim().toLocaleLowerCase();
                }
            });
        }
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
