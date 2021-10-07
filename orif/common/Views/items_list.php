<?php
   /** @author      Orif, section informatique (ViDi)
     * @link        https://github.com/OrifInformatique
     * @copyright   Copyright (c), Orif (https://www.orif.ch)
     * 
     * Generic view to display items list in a bootstrap table, optionally with links
     * for creating, reading details, updating or deleting items.
     * 
     * @param list_title : String displayed on the top of the list.
     * @param items :      Array of items to display, each item being a subarray with multiple properties.
     * @param columns :    Array of columns to display in the list.
     *                     Key is the name of the corresponding items property in items subarrays.
     *                     Value is the header to display for each column.
     * @param with_deleted : 
     *                     Bool used to display soft deleted items of the list or not (default should be false).
     * @param primary_key_field :
     *                     String containing the name of the primary key of the items.
     *                     Used to construct the links to details/update/delete controllers.
     *                     If not set, "id" is used by default.
     * @param field_display_deleted :
     *                     String displayed before the soft delete checkbox
     * @param btn_create_label :
     *                     Label for the "create" button. If not set, default label is used.
     * @param url_detail : Link to the controller method wich displays item's details.
     *                     If not set, no "detail" link will be displayed.
     * @param url_update : Link to the controller method wich displays a form to update the item.
     *                     If not set, no "update" link will be displayed.
     * @param url_delete : Link to the controller method wich deletes the item.
     *                     If not set, no "delete" link will be displayed.
     * @param url_create : Link to the controller method wich displays a form to create a new item.
     *                     If not set, no "create" button will be displayed.
     * @param url_view   : If not set, no "Display soft deleted" button will be displayed.
     * 
     * EXAMPLE TO CALL THIS VIEW FROM ANY CONTROLLER :
     *   $data['list_title'] = "Test items_list view";
     *   
     *   $data['columns'] = ['name' => 'Name',
     *                       'inventory_nb' => 'Inventory nb',
     *                       'buying_date' => 'Buying date',
     *                       'warranty_duration' => 'Warranty duration'];
     *   $data['items'] = [
     *       ['id' => '1', 'name' => 'Item 1', 'inventory_nb' => 'ITM0001', 'buying_date' => '01/01/2020', 'warranty_duration' => '12 months'],
     *       ['id' => '2', 'name' => 'Item 2', 'inventory_nb' => 'ITM0002', 'buying_date' => '01/02/2020', 'warranty_duration' => '12 months'],
     *       ['id' => '3', 'name' => 'Item 3', 'inventory_nb' => 'ITM0003', 'buying_date' => '01/03/2020', 'warranty_duration' => '12 months']
     *   ];
     *
     *   $data['primary_key_field']  = 'id';
     *   $data['btn_create_label']   = 'Add an item';
     *   $data['with_deleted']       = $with_deleted;
     *   $data['url_detail'] = "items_list/detail/";
     *   $data['url_update'] = "items_list/update/";
     *   $data['url_delete'] = "items_list/delete/";
     *   $data['url_create'] = "items_list/create/";
     *   $data['url_view']   = "items_list";
     *
	 *	 $this->display_view('Common\Views\items_list', $data);
     */

    // If no primary key field name is sent as parameter, suppose it is "id"
    if (!isset($primary_key_field)) {
        $primary_key_field = "id";
    }
    // If no label for create button is sent as parameter, use default label
    if (!isset($btn_create_label)) {
        $btn_create_label = lang('common_lang.btn_add');
    }

    // If no label for display deleted checkbox button is sent as a parameter, use default label
    if (!isset($field_display_deleted)) {
        $field_display_deleted = lang("stock_lang.field_display_deleted_default");
    }

    // If with_deleted variable isn't sent as a parameter, use default
    if (!isset($with_deleted)) {
        $with_deleted = false;
    }
?>

<div class="items_list container">
    <div class="row mb-2">
        <div class="col-sm-8 text-left">
            <!-- Display list title if defined defined -->
            <?= isset($list_title) ? '<h1>'.esc($list_title).'</h1>' : '' ?>
        </div>
        <div class="col-sm-6">
            <!-- Display the "create" button if url_create is defined -->
            <?php if(isset($url_create)) { ?>
                <a class="btn btn-primary" href="<?= site_url(esc($url_create)) ?>"><?= esc($btn_create_label) ?></a>
            <?php } ?>
        </div>
        <div class="col-sm-6 text-right">
            <?php if (isset($url_view)) { ?>
            <label class="btn btn-default form-check-label" for="toggle_deleted">
                <?= lang($field_display_deleted); ?>
            </label>
            <?= form_checkbox('toggle_deleted', '', $with_deleted, [
                'id' => 'toggle_deleted'
            ]); ?>
            <?php } ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <!-- Get columns headers from the "columns" variable -->
                    <?php foreach ($columns as $column): ?>
                        <th scope="col"><?= esc($column) ?></th>
                    <?php endforeach ?>

                    <!-- Add the "action" column (for detail/update/delete links) -->
                    <?php if(isset($url_detail) || isset($url_update) || isset($url_delete)) { ?>
                        <th class="text-right" scope="col"></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="itemList">
                <!-- One table row for each item -->
                <?php foreach ($items as $itemEntity): ?>
                <tr>
                    <!-- Only display item's properties wich are listed in "columns" variable -->
                    <?php foreach ($itemEntity as $propertyKey => $propertyValue): 
                        if (array_key_exists($propertyKey, $columns)) {
                            echo ('<td>'.esc($propertyValue).'</td>');
                        }
                    endforeach ?>
                    
                    <!-- Add the "action" column (for detail/update/delete links) -->
                    <td class="text-right">                        
                        <!-- Bootstrap details icon ("Card text"), redirect to url_detail, adding /primary_key as parameter -->
                        <?php if(isset($url_detail)) { ?>
                            <a href="<?= site_url(esc($url_detail.$itemEntity[$primary_key_field])) ?>">
                                <i class="bi-card-text" style="font-size: 20px;"></i>
                            </a>
                        <?php } ?>

                        <!-- Bootstrap edit icon ("Pencil"), redirect to url_update, adding /primary_key as parameter -->
                        <?php if(isset($url_update)) { ?>
                            <a href="<?= site_url(esc($url_update.$itemEntity[$primary_key_field])) ?>">
                                <i class="bi-pencil" style="font-size: 20px;"></i>
                            </a>
                        <?php } ?>
                        
                        <!-- Bootstrap delete icon ("Trash"), redirect to url_delete, adding /primary_key as parameter -->
                        <?php if(isset($url_delete)) { ?>
                            <a href="<?= site_url(esc($url_delete.$itemEntity[$primary_key_field])) ?>">
                                <i class="bi-trash" style="font-size: 20px;"></i>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- JQuery script to display soft deleted items of the list -->
<script>
$(document).ready(function(){
    $('#toggle_deleted').change(e => {
        let checked = e.currentTarget.checked;
        $.post('<?=base_url();?>/stock/admin/<?= $url_view == null ? "" : $url_view ?>/'+(+checked), {}, data => {
            $('#itemList').empty();
            $('#itemList')[0].innerHTML = $(data).find('#itemList')[0].innerHTML;
        });
    });
});
</script>
