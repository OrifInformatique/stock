<div id="item_detail" class="container">
    <!-- BUTTONS -->
	<a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item');} ?>"
       class="btn btn-primary" role="button"><?= lang('MY_application.btn_back_to_list'); ?></a>

    <!-- *** ADMIN *** -->
	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered) { ?>
    	<a href="<?= base_url('item/modify/'.$item['item_id']); ?>" class="btn btn-warning" role="button"><?= lang('MY_application.btn_modify'); ?></a>
        <?php if($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) { ?>
    	   <a href="<?= base_url('item/delete/'.$item['item_id']); ?>" class="btn btn-danger" role="button"><?= lang('MY_application.btn_delete'); ?></a>
        <?php } ?>
	<?php } ?>
    <!-- *** END OF ADMIN *** -->

    <!-- ITEM NAME AND DESCRIPTION -->
	<div class="row">
        <div class="col-md-8"><h3><?= htmlspecialchars($item['name']); ?></h3></div>
        <div class="col-md-4">
            <h4 class="text-right"><?= lang('MY_application.field_inventory_number_abr').' : '.htmlspecialchars($item['inventory_number']); ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8"><p><?= htmlspecialchars($item['description']); ?></p></div>
    </div>
    <?php if ($item['current_loan']['is_late']) { ?>
    <div class="row">
        <div class="col-12"><div class="alert alert-danger"><?= htmlspecialchars(lang('MY_application.msg_item_loan_late')); ?></div></div>
    </div>
    <?php } ?>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-12">
            <p class="bg-primary">&nbsp;<?= htmlspecialchars(lang('MY_application.text_item_detail')); ?></p>
        </div>
        <div class="col-md-4">
            <img id="picture"
                 src="<?= base_url($item['image']); ?>"
                 width="100%"
                 alt="<?= lang('MY_application.field_image'); ?>" />
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-3">
                    <label><?= htmlspecialchars(lang('MY_application.field_group')); ?></label>
                </div>
                <div class="col-sm-9">
                    <?php if(!is_null($item['item_group'])){echo htmlspecialchars($item['item_group']['name']);} ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label><?= htmlspecialchars(lang('MY_application.field_serial_number')); ?></label>
                </div>
                <div class="col-sm-9">
                    <?= htmlspecialchars($item['serial_number']); ?>
                </div>
            </div>

            <label><?= htmlspecialchars(lang('MY_application.field_remarks')); ?></label>
            <p><?= htmlspecialchars($item['remarks']); ?></p>

            <!-- Button to display linked file -->
            <?php
            if (!empty($item['linked_file'])) {
                echo '<a href="'.base_url('uploads/files/'.$item['linked_file']).'" '.
                        'class="btn btn-default"  role="button" >'
                        .lang('MY_application.btn_linked_doc').
                     '</a>';
            }
            else {
                echo '<a href="#" '.
                     'class="btn btn-default disabled"  role="button" >'
                         .lang('MY_application.btn_linked_doc').
                     '</a>';
            }
            ?>
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-12 mt-2">
            <p class="bg-primary">&nbsp;<?= htmlspecialchars(lang('MY_application.text_item_loan_status')); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="row"><div class="col-12">
                <!-- Item condition -->
                <?php if(!is_null($item['item_condition'])){echo $item['item_condition']['bootstrap_label'];}?>
                <!-- Loan status -->
                <?= $item['current_loan']['bootstrap_label']; ?>
            </div></div>

            <?php if (array_key_exists('loan_id', $item['current_loan'])) { ?>
                <!-- Current loan -->
                <div class="row"><div class="col-12">
                    <?= htmlspecialchars($item['current_loan']['item_localisation']); ?><br />
                </div></div>
                <div class="row">
                    <div class="col-6">
                        <label><?= lang('MY_application.field_loan_date'); ?> :&nbsp;</label>
                    </div>
                    <div class="col-6">
                        <?php if(!empty($item['current_loan']['date'])){
                            echo databaseToShortDate($item['current_loan']['date']);
                        }?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label><?= lang('MY_application.field_loan_planned_return'); ?> :&nbsp;</label>
                    </div>
                    <div class="col-6">
                        <?php if(!empty($item['current_loan']['planned_return_date'])){
                            echo databaseToShortDate($item['current_loan']['planned_return_date']);
                        } else {
                            echo lang('MY_application.text_none');
                        }?>
                    </div>
                </div>
            <?php } ?>
            <div class="row"><div class="col-12">

                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered) {
                    //Button to create new loan -->                
                    echo '<a href="'.base_url('/item/create_loan/'.$item['item_id']).'" '.
                         'class="btn btn-primary"  role="button" >'.
                         lang('MY_application.btn_create_loan').'</a>';

                    // Button to display loans history -->
                    echo '<a href="'.base_url('/item/loans/'.$item['item_id']).'" '.
                        'class="btn btn-default"  role="button" >'.
                        lang('MY_application.btn_loans_history').
                    '   </a>';
                }?>
            </div></div>
        </div>
        <div class="col-md-8">
            <!-- Stocking place -->
            <div class="row">
                <div class="col-sm-4">
                    <label><?= htmlspecialchars(lang('MY_application.field_stocking_place')); ?> :</label>
                </div>
                <div class="col-sm-8">
                    <?php if(!is_null($item['stocking_place'])){echo htmlspecialchars($item['stocking_place']['name']);} ?>
                </div>
            </div>
            <!-- Inventory control -->
            <div class="row">
                <div class="col-sm-4">
                    <label><?= htmlspecialchars(lang('MY_application.field_last_inventory_control')); ?> :</label>
                </div>
                <div class="col-sm-8">
                    <?php if(!is_null($item['last_inventory_control'])) {
                        echo databaseToShortDate($item['last_inventory_control']['date']);
                        echo ', ';
                        if (!is_null($item['last_inventory_control']['controller'])) {
                            echo htmlspecialchars($item['last_inventory_control']['controller']['username']);
                        }
                        if(!is_null($item['last_inventory_control']['remarks'])) {
                            echo '</br >'.htmlspecialchars($item['last_inventory_control']['remarks']);
                        }
                    } else {
                        echo htmlspecialchars(lang('MY_application.text_none'));
                    } ?>
                </div>
            </div>
            <div class="row"><div class="col-12">
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= config('User\Config\UserConfig')->access_lvl_registered) {
                    // Button to create new inventory control
                    echo '<a href="'.base_url('/item/create_inventory_control/'.$item['item_id']).
                            '" class="btn btn-primary"  role="button" >'.
                            lang('MY_application.btn_create_inventory_control').'</a>';

                    // Button for controls history 
                    echo '<a href="'.base_url('/item/inventory_controls/'.$item['item_id']).
                        '" class="btn btn-default"  role="button" >'.
                        lang('MY_application.btn_inventory_control_history').'</a>';
                }?>
            </div></div>
        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-12 mt-2">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.text_item_buying_warranty'); ?></p>
        </div>
        <div class="col-md-4">
            <label><?= lang('MY_application.field_supplier'); ?> :&nbsp;</label>
            <?php if(!is_null($item['supplier'])){echo $item['supplier']['name'];} ?><br />
            <label><?= lang('MY_application.field_supplier_ref'); ?> :&nbsp;</label>
            <?= htmlspecialchars($item['supplier_ref']); ?>
        </div>
        <div class="col-md-4">
            <label><?= lang('MY_application.field_buying_price'); ?> :&nbsp;</label>
            <?= $item['buying_price']; ?><br />

            <label><?= lang('MY_application.field_buying_date'); ?> :&nbsp;</label>
            <?php
            if (!empty($item['buying_date']))
            {
                echo databaseToShortDate($item['buying_date']);
            }
            ?>
        </div>
        <div class="col-md-4">
            <label><?= lang('MY_application.field_warranty_duration'); ?> :&nbsp;</label>
            <?php if (!empty($item['warranty_duration'])) {
                      echo $item['warranty_duration'].' '.lang('MY_application.text_months');} ?><br />

            <?php //CHANGE LABEL COLOR BASED ON WARRANTY STATUS
            if ($item['warranty_status'] == 1) {
                echo '<span class="badge badge-success" >';} // UNDER WARRANTY
            elseif ($item['warranty_status'] == 2) {
                echo '<span class="badge badge-warning" >';} // WARRANTY EXPIRES SOON
            elseif ($item['warranty_status'] == 3) {
                echo '<span class="badge badge-danger" >';}  // WARRANTY EXPIRED
            else {echo '<span>';}
                echo lang('MY_application.text_warranty_status.' . $item['warranty_status']); ?>
            </span>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= lang('MY_application.field_tags'); ?></p>
        </div>
        <div class="col-md-12">
            <?php
            if (!empty($item['tags']))
            {
                foreach($item['tags'] as $tag)
                {
                    echo '<span class="badge badge-dark">'.$tag[0]['name']."</span>\n";
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    // Refresh the image to prevent display of an old cach image.
    // Changing the src attribute forces browser to update.
    d = new Date();
    $("#picture").attr("src", "<?= base_url($item['image']); ?>?"+d.getTime());
});
</script>
