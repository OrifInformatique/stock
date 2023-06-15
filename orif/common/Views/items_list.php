<?php
   /** @author      Orif, section informatique (ViDi, AeDa)
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
     *                     Bool used to display or not the soft deleted items of the list.
     *                     If null, the "Display disabled items" checkbox won't be displayed.
     * @param display_deleted_label :
     *                     String for the label displayed near the soft delete checkbox.
     * @param primary_key_field :
     *                     String containing the name of the primary key of the items.
     *                     Used to construct the links to details/update/delete controllers.
     *                     If not set, "id" is used by default.
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
     * @param url_getView: Link used to dynamically update the view's content with javascript.
     *                     It should call a method wich returns the view's content.
     *                     If not set, the "Display disabled items" checkbox won't be displayed.
     * 
     * EXAMPLE METHOD TO CALL THIS VIEW FROM ANY CONTROLLER :
     * 
     * public function display_items($with_deleted = false) {
     *   $data['list_title'] = "Test items_list view";
     *   
     *   $data['columns'] = ['name' => 'Name',
     *                       'inventory_nb' => 'Inventory nb',
     *                       'buying_date' => 'Buying date',
     *                       'warranty_duration' => 'Warranty duration'];
     * 
     *   // Assume these are active items
     *   $data['items'] = [
     *       ['id' => '1', 'name' => 'Item 1', 'inventory_nb' => 'ITM0001', 'buying_date' => '01/01/2020', 'warranty_duration' => '12 months'],
     *       ['id' => '2', 'name' => 'Item 2', 'inventory_nb' => 'ITM0002', 'buying_date' => '01/02/2020', 'warranty_duration' => '12 months'],
     *       ['id' => '3', 'name' => 'Item 3', 'inventory_nb' => 'ITM0003', 'buying_date' => '01/03/2020', 'warranty_duration' => '12 months']
     *   ];
     * 
     *   if ($with_deleted) {
     *       // Assume these are soft_deleted items
     *       $data['items'] = array_merge($data['items'], [
     *           ['id' => '10', 'name' => 'Item 10', 'inventory_nb' => 'ITM0010', 'buying_date' => '01/01/2020', 'warranty_duration' => '12 months'],
     *           ['id' => '11', 'name' => 'Item 11', 'inventory_nb' => 'ITM0011', 'buying_date' => '01/02/2020', 'warranty_duration' => '12 months'],
     *           ['id' => '12', 'name' => 'Item 12', 'inventory_nb' => 'ITM0012', 'buying_date' => '01/03/2020', 'warranty_duration' => '12 months']
     *       ]);
     *   }
     *
     *   $data['primary_key_field']  = 'id';
     *   $data['btn_create_label']   = 'Add an item';
     *   $data['with_deleted']       = $with_deleted;
     *   $data['url_detail'] = "items_list/detail/";
     *   $data['url_update'] = "items_list/update/";
     *   $data['url_delete'] = "items_list/delete/";
     *   $data['url_create'] = "items_list/create/";
     *   $data['url_getView'] = "items_list/display_items";
     *
	 *	 return $this->display_view('Common\Views\items_list', $data);
     * }
     */

    // If no primary key field name is sent as parameter, suppose it is "id"
    if (!isset($primary_key_field)) {
        $primary_key_field = "id";
    }

    // If no label for create button is sent as parameter, use default label
    if (!isset($btn_create_label)) {
        $btn_create_label = lang('common_lang.btn_add');
    }

    // If no label for display deleted checkbox is sent as parameter, use default label
    if (!isset($display_deleted_label)) {
        $display_deleted_label = lang('common_lang.btn_show_disabled');
    }

    // If no with_deleted variable is sent as parameter, set it to null
    if (!isset($with_deleted)) {
        $with_deleted = null;
    }

    // If no url_getView variable is sent as parameter, set it to null
    if (!isset($url_getView)) {
        $url_getView = null;
    }
?>

<div class="items_list container">
    <div class="row mb-2">
        <div class="text-left col-12">
            <!-- Display list title if defined defined -->
            <?= isset($list_title) ? '<h3>'.esc($list_title).'</h3>' : '' ?>
        </div>
        <div class="col-sm-6 text-left">
            <!-- Display the "create" button if url_create is defined -->
            <?php if(isset($url_create)) { ?>
                <a class="btn btn-primary" href="<?= site_url(esc($url_create)) ?>"><?= esc($btn_create_label) ?></a>
            <?php } ?>
        </div>
        <div class="col-sm-6 text-right">
            <!-- Display the "with_deleted" checkbox if with_deleted and url_getView variables are defined -->
            <?php if (isset($with_deleted) && isset($url_getView)) { ?>
                <label class="btn btn-default form-check-label" for="toggle_deleted">
                    <?= lang($display_deleted_label); ?>
                </label>
                <?= form_checkbox('toggle_deleted', '', $with_deleted, ['id' => 'toggle_deleted']); ?>
            <?php } ?>
        </div>
    </div>

    <div id="itemsList" class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <!-- Get columns headers from the "columns" variable -->
                    <?php foreach ($columns as $column): ?>
                        <th scope="col"><?= $column ?></th>
                    <?php endforeach ?>

                    <!-- Add the "action" column (for detail/update/delete links) -->
                    <?php if(isset($url_detail) || isset($url_update) || isset($url_delete)) { ?>
                        <th class="text-right" scope="col"></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <!-- One table row for each item -->
                <?php foreach ($items as $itemEntity): ?>
                <tr>
                    <!-- Only display item's properties wich are listed in "columns" variable -->
                    <?php foreach ($itemEntity as $propertyKey => $propertyValue): 
                        if (array_key_exists($propertyKey, $columns)) {
                            echo ('<td>'.$propertyValue.'</td>');
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

<!-- JQuery script to refresh items list after user action -->
<script>
$(document).ready(function(){

    // "Display disabled items" checkbox value change
    $('#toggle_deleted').change(e => {
        let checked = e.currentTarget.checked;

        // Get view content corresponding to the new parameters and replace current displayed content
        $.post('<?= base_url($url_getView); ?>/'+(+checked), {}, data => {
            $('#itemsList').empty();
            $('#itemsList')[0].innerHTML = $(data).find('#itemsList')[0].innerHTML;
        });
    });
});
</script>