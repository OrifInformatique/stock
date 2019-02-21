<div class="container">
    <?php $item_page = base_url('item/view/').$item->item_id; ?>

    <!-- BUTTONS -->
    <a href="<?= $item_page ?>" class="btn btn-primary" role="button"><?= lang('btn_back_to_object'); ?></a>

    <!-- ITEM NAME -->
    <div class="row">
        <h3><?php
        echo lang('field_inventory_control').' : ';
        echo $item->name.' ('.$item->inventory_number.')';
        ?></h3>
    </div>

    <!-- INVENTORY CONTROLS LIST -->
    <?php if(empty($inventory_controls)) { ?>
    <h4 class="text-warning">
        <?= lang('msg_no_inventory_controls'); ?>
    </h4>
    <?php } else { ?>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= lang('field_inventory_control_date'); ?></th>
                        <th><?= lang('field_inventory_controller'); ?></th>
                        <th><?= lang('field_remarks'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory_controls as $inventory_control) { ?>
                    <tr>
                        <td><?= databaseToShortDate($inventory_control->date); ?></td>
                        <td><?= $inventory_control->controller->username; ?></td>
                        <td><?= $inventory_control->remarks; ?></td>
                     </tr>
                     <?php } ?>
                 </tbody>
             </table>
         </div>
     </div>
     <?php } ?>
     <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
     <a href="<?= base_url('item/create_inventory_control/').$item->item_id; ?>" class="btn btn-primary"><?= lang('btn_new') ?></a>
     <?php } ?>
 </div>
