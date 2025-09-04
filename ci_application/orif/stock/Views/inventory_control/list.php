<div class="container">
    <?php $item_page = base_url('item_common/view/'.$item['item_common_id']); ?>

    <!-- BUTTONS -->
    <a href="<?= $item_page ?>" class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_object'); ?></a>

    <!-- TITLE -->
    <div class="row">
        <div class="col-12"><h3><?= lang('MY_application.text_inventory_controls'); ?></h3></div>
        <div class="col-12"><p><?= $item['inventory_number'].' - '.$item_common['name']; ?></p></div>
    </div>

    <!-- INVENTORY CONTROLS LIST -->
    <?php if(empty($inventory_controls)) { ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info"><?= lang('MY_application.msg_no_inventory_controls'); ?></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th><?= lang('MY_application.field_inventory_control_date'); ?></th>
                        <th><?= lang('MY_application.field_inventory_controller'); ?></th>
                        <th><?= lang('MY_application.field_remarks'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventory_controls as $inventory_control) { ?>
                        <tr>
                            <td><?= databaseToShortDate($inventory_control['date']); ?></td>
                            <td><?= $inventory_control['controller']['username']; ?></td>
                            <td><?= $inventory_control['remarks']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered) { ?>
        <a href="<?= base_url('item/create_inventory_control/'.$item['item_id']); ?>" class="btn btn-primary"><?= lang('MY_application.btn_new') ?></a>
    <?php } ?>
</div>
