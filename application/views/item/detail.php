<div id="item_detail" class="container">
    <!-- BUTTONS -->
	<a href="<?php if (isset($_SESSION['items_list_url'])) {echo $_SESSION['items_list_url'];} else {echo base_url('/item');} ?>"
       class="btn btn-primary" role="button"><?= $this->lang->line('btn_back_to_list'); ?></a>

    <!-- *** ADMIN *** -->
	<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
    	<a href="<?= base_url('item/modify/'.$item->item_id); ?>" class="btn btn-warning" role="button"><?= $this->lang->line('btn_modify'); ?></a>
        <?php if($_SESSION['user_access'] >= ACCESS_LVL_ADMIN) { ?>
    	   <a href="<?= base_url('item/delete/'.$item->item_id); ?>" class="btn btn-danger" role="button"><?= $this->lang->line('btn_delete'); ?></a>
        <?php } ?>
	<?php } ?>
    <!-- *** END OF ADMIN *** -->

    <!-- ITEM NAME AND DESCRIPTION -->
	<div class="row">
        <div class="col-md-8"><h3><?= html_escape($item->name); ?></h3></div>
        <div class="col-md-4">
            <h4 class="text-right"><?= $this->lang->line('field_inventory_number_abr').' : '.html_escape($item->inventory_number_complete); ?></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8"><p><?= html_escape($item->description); ?></p></div>
        <div class="col-md-4"></div>
    </div>

    <!-- ITEM DETAILS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= html_escape($this->lang->line('text_item_detail')); ?></p>
        </div>
        <div class="col-md-4">
            <img src="<?= base_url('uploads/images/'.$item->image); ?>"
                 width="100%"
                 alt="<?= $this->lang->line('field_image'); ?>" />
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-sm-3">
                    <label><?= html_escape($this->lang->line('field_group')); ?></label>
                </div>
                <div class="col-sm-9">
                    <?php if(!is_null($item->item_group)){echo html_escape($item->item_group->name);} ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label><?= html_escape($this->lang->line('field_serial_number')); ?></label>
                </div>
                <div class="col-sm-9">
                    <?= html_escape($item->serial_number); ?>
                </div>
            </div>

            <label><?= html_escape($this->lang->line('field_remarks')); ?></label>
            <p><?= html_escape($item->remarks); ?></p>

            <!-- Button to display linked file -->
            <?php
            if (!empty($item->linked_file)) {
                echo '<a href="'.base_url('uploads/files/'.$item->linked_file).'" '.
                        'class="btn btn-default"  role="button" >'
                        .$this->lang->line('btn_linked_doc').
                     '</a>';
            }
            else {
                echo '<a href="#" '.
                     'class="btn btn-default disabled"  role="button" >'
                         .$this->lang->line('btn_linked_doc').
                     '</a>';
            }
            ?>
        </div>
    </div>

    <!-- ITEM STATUS, LOAN STATUS AND HISTORY -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= html_escape($this->lang->line('text_item_loan_status')); ?></p>
        </div>
        <div class="col-md-4">
            <div class="row"><div class="col-xs-12">
                <!-- Item condition -->
                <?php if(!is_null($item->item_condition)){echo $item->item_condition->bootstrap_label;}?>
            </div></div>
            <div class="row"><div class="col-xs-12">
                <!-- Loan status -->
                <?= $item->loan_bootstrap_label; ?>
            </div></div>
            <?php if (!is_null($item->current_loan)) { ?>
                <!-- Current loan -->
                <div class="row"><div class="col-xs-12">
                    <?= html_escape($item->current_loan->item_localisation); ?><br />
                </div></div>
                <div class="row">
                    <div class="col-xs-6">
                        <label><?= $this->lang->line('field_loan_date'); ?> :&nbsp;</label>
                    </div>
                    <div class="col-xs-6">
                        <?php if(!empty($item->current_loan->date)){echo nice_date($item->current_loan->date, $this->lang->line('date_format_short'));}?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <label><?= $this->lang->line('field_loan_planned_return'); ?> :&nbsp;</label>
                    </div>
                    <div class="col-xs-6">
                        <?php if(!empty($item->current_loan->planned_return_date)){echo nice_date($item->current_loan->planned_return_date, $this->lang->line('date_format_short'));}?>
                    </div>
                </div>
            <?php } ?>
            <div class="row"><div class="col-xs-12">
                <!-- Button to display loans history -->
                <?= '<a href="'.base_url('/item/loans/'.$item->item_id).'" '.
                    'class="btn btn-default"  role="button" >'.
                    $this->lang->line('btn_loans_history').
                    '</a>';?>

                <!-- Button to create new loan -->
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { 
                    echo '<a href="'.base_url('/item/create-loan/'.$item->item_id).'" '.
                         'class="btn btn-primary"  role="button" >'.
                         $this->lang->line('btn_create_loan').'</a>';
                }?>
            </div></div>
        </div>
        <div class="col-md-8">
            <!-- Stocking place -->
            <div class="row">
                <div class="col-sm-4">
                    <label><?= html_escape($this->lang->line('field_stocking_place')); ?> :</label>
                </div>
                <div class="col-sm-8">
                    <?php if(!is_null($item->stocking_place)){echo html_escape($item->stocking_place->name);} ?>
                </div>
            </div>
            <!-- Inventory control -->
            <div class="row">
                <div class="col-sm-4">
                    <label><?= html_escape($this->lang->line('field_last_inventory_control')); ?> :</label>
                </div>
                <div class="col-sm-8">
                    <?php if(!is_null($item->last_inventory_control)) {
                        echo nice_date($item->last_inventory_control->date,
                                       $this->lang->line('date_format_short'));
                        echo ', '.html_escape($item->last_inventory_control->controller->username);
                        if(!is_null($item->last_inventory_control->remarks)) {
                            echo '</br >'.html_escape($item->last_inventory_control->remarks);
                        }
                    } else {
                        echo html_escape($this->lang->line('text_none'));
                    } ?>
                </div>
            </div>
            <div class="row"><div class="col-xs-12">
                <!-- Button for controls history -->
                <?= '<br /><a href="'.base_url('/item/inventory_controls/'.$item->item_id).
                     '" class="btn btn-default"  role="button" >'.
                     $this->lang->line('btn_inventory_control_history').'</a>'; ?>

                <!-- Button to create new inventory control -->
                <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { 
                    echo '<a href="'.base_url('/item/create_inventory_control/'.$item->item_id).
                         '" class="btn btn-primary"  role="button" >'.
                         $this->lang->line('btn_create_inventory_control').'</a>';
                }?>
            </div></div>
        </div>
    </div>

    <!-- ITEM SUPPLIER, BUYING AND WARRANTY INFORMATIONS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= $this->lang->line('text_item_buying_warranty'); ?></p>
        </div>
        <div class="col-md-4">
            <label><?= $this->lang->line('field_supplier'); ?> :&nbsp;</label>
            <?php if(!is_null($item->supplier)){echo $item->supplier->name;} ?><br />
            <label><?= $this->lang->line('field_supplier_ref'); ?> :&nbsp;</label>
            <?= html_escape($item->supplier_ref); ?>
        </div>
        <div class="col-md-4">
            <label><?= $this->lang->line('field_buying_price'); ?> :&nbsp;</label>
            <?= $item->buying_price; ?><br />

            <label><?= $this->lang->line('field_buying_date'); ?> :&nbsp;</label>
            <?php
            if (!empty($item->buying_date))
            {
                echo nice_date($item->buying_date, $this->lang->line('date_format_short'));
            }
            ?>
        </div>
        <div class="col-md-4">
            <label><?= $this->lang->line('field_warranty_duration'); ?> :&nbsp;</label>
            <?php if (!empty($item->warranty_duration)) {
                      echo $item->warranty_duration.' '.$this->lang->line('text_months');} ?><br />

            <?php //CHANGE LABEL COLOR BASED ON WARRANTY STATUS
            if ($item->warranty_status == 1) {
                echo '<span class="label label-success" >';} // UNDER WARRANTY
            elseif ($item->warranty_status == 2) {
                echo '<span class="label label-warning" >';} // WARRANTY EXPIRES SOON
            elseif ($item->warranty_status == 3) {
                echo '<span class="label label-danger" >';}  // WARRANTY EXPIRED
            else {echo '<span>';}

                echo $this->lang->line('text_warranty_status')[$item->warranty_status]; ?>
            </span>
        </div>
    </div>

    <!-- ITEM TAGS -->
    <div class="row">
        <div class="col-md-12">
            <p class="bg-primary">&nbsp;<?= $this->lang->line('field_tags'); ?></p>
        </div>
        <div class="col-md-12">
            <?php
            if (!empty($item->tags))
            {
                foreach($item->tags as $tag)
                {
                    echo '<span class="label label-default">'.$tag."</span>\n";
                }
            }
            ?>
        </div>
    </div>
</div>
