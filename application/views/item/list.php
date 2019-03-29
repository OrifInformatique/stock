<div class="container">

<!-- *** ADMIN *** -->
<?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
<div class="row bottom-margin">
  <!-- Button for new item -->
  <a href="<?php echo base_url(); ?>item/create/" class="btn btn-success"><?php echo html_escape($this->lang->line('btn_new')); ?></a>
</div>
<?php } ?>
<!-- *** END OF ADMIN *** -->

<!-- FILTERS AND SORT FORM -->
<form id="filters" class="" style="overflow: visible;" method="get" action="<?=base_url("item/index/1")?>">
  <div class="row">
    <!-- FILTERS -->
    <div class="col-sm-8 top-margin">
      <!-- HEADING -->
      <p class="bg-primary">&nbsp;<?php echo html_escape($this->lang->line('text_search_filters')); ?></p>

      <div class="row">
        <!-- TEXT FILTER -->
        <div class="col-xs-12 top-margin">
        <?php
          echo form_label($this->lang->line('field_text_search'), 'text_search');
          echo form_input('ts', $ts, 
                          'id="text_search" class="form-control"
                           placeholder="'.$this->lang->line('field_no_filter').'"');
        ?>
        </div>
      </div>

      <div class="row">
        <!-- TAGS FILTER -->
        <div class="col-sm-8 top-margin">
        <?php
          echo form_label($this->lang->line('field_tags'),
                          'item_conditions-multiselect');
          echo form_dropdown('t[]', $item_tags, $t,
                             'id="item_tags-multiselect" multiple="multiple"');
        ?>
        </div>

        <!-- GROUPS FILTER -->
        <div class="col-sm-4 top-margin">
        <?php
          echo form_label($this->lang->line('field_group'),
                          'item_groups-multiselect');
          echo form_dropdown('g[]', $item_groups, $g,
                             'id="item_groups-multiselect" multiple="multiple"');
        ?>
        </div>
      </div>

      <div class="row">
        <!-- STOCKING PLACES FILTER -->
        <div class="col-sm-8 top-margin">
          <?php
            echo form_label($this->lang->line('field_stocking_place'),
                            'stocking_places-multiselect');
            echo form_dropdown('s[]', $stocking_places, $s,
                               'id="stocking_places-multiselect" multiple="multiple"');
          ?>
        </div>

        <!-- CONDITIONS FILTER -->
        <div class="col-sm-4 top-margin">
        <?php
          echo form_label($this->lang->line('field_item_condition'),
                          'item_conditions-multiselect');
          echo form_dropdown('c[]', $item_conditions, $c,
                             'id="item_conditions-multiselect" multiple="multiple"');
        ?>
        </div>
      </div>
    </div>

    <!-- SORT ORDER -->
    <div class="col-sm-4 top-margin">
      <!-- HEADING -->
      <p class="bg-primary">&nbsp;<?php echo html_escape($this->lang->line('text_sort_order')); ?></p>

      <div class="row">
        <!-- SORT ORDER -->
        <div class="col-xs-12 top-margin">
        <?php
          echo form_label($this->lang->line('field_sort_order'),
                            'sort_order');
          echo form_dropdown('o', $sort_order, $o,
                               'id="sort_order"');
        ?>
        </div>
      </div>
      <div class="row">
        <!-- SORTING ASCENDING / DESCENDING -->
        <div class="col-xs-12 top-margin">
        <?php
          echo form_label($this->lang->line('field_sort_asc_desc'),
                            'sort_asc_desc');
          echo form_dropdown('ad', $sort_asc_desc, $ad,
                               'id="sort_asc_desc"');
        ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- BUTTONS -->
  <div class="row">
    <div class="col-sm-6 col-xs-12 top-margin xs-center">
      <button type="submit" class="btn btn-primary top-margin"><?php echo html_escape($this->lang->line('btn_submit_filters')); ?></button>
      <a href="<?php echo base_url(); ?>item" class="btn btn-default top-margin"><?php echo html_escape($this->lang->line('btn_remove_filters')); ?></a>
    </div>
  </div>

<!-- END OF FILTERS AND SORT FORM -->
</form>

<!-- PAGINATION -->
<div id="pagination_top"><?=$pagination?></div>

<div class="top-margin table-responsive">
  
  <!-- LIST OF ITEMS -->
  <?php if(empty($items)) { ?>
    <em><?php html_escape($this->lang->line('msg_no_item')); ?></em>
  <?php } else { ?>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th><?php echo html_escape($this->lang->line('header_picture')); ?></th>
        <th><?php echo html_escape($this->lang->line('header_status')); ?></th>
        <th><?php echo html_escape($this->lang->line('header_item_name')); ?></th>
        <th nowrap><?php echo html_escape($this->lang->line('header_stocking_place')); ?></th>
        <th nowrap>
        <?php
          echo html_escape($this->lang->line('header_inventory_nb'));
          echo '<br />'.html_escape($this->lang->line('header_serial_nb'));
        ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item) { ?>
  		  <tr>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block">
              <img src="<?php echo base_url('uploads/images/'.$item->image); ?>"
                   width="100px"
                   alt="<?php html_escape($this->lang->line('field_image')); ?>" />
            </a>
          </td>
          <td>
            <?php
              echo $item->item_condition->bootstrap_label;
              echo '<br />'.$item->loan_bootstrap_label;
              if (!is_null($item->current_loan)) {
                echo '<br /><h6>'.$item->current_loan->item_localisation.'</h6>';
              }
            ?>
          </td>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->name); ?></a>
            <h6><?php echo html_escape($item->description); ?></h6>
          </td>
          <td><?php if(!is_null($item->stocking_place)) {
            echo html_escape($item->stocking_place->name);
          } ?></td>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->inventory_number); ?></a>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->serial_number); ?></a>
          </td>
          <td>
            <!-- DELETE ACCESS RESTRICTED FOR ADMINISTRATORS ONLY -->
            <?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['user_access'] >= ACCESS_LVL_ADMIN) { ?>
              <a href="<?php echo base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="<?php echo $this->lang->line('admin_delete_item');?>">×</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
</div>
<div id="pagination_bottom"><?=$pagination?></div>
</div>

<!-- Initialize the Bootstrap Multiselect plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
      var no_filter = "<?php
                        echo html_escape($this->lang->line('field_no_filter'));
                      ?>";

      $('#item_tags-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 10
      });
      $('#item_conditions-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 5
      });
      $('#item_groups-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 5
      });
      $('#stocking_places-multiselect').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 5
      });
      $('#sort_order').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 5
      });
      $('#sort_asc_desc').multiselect({
        nonSelectedText: no_filter,
        buttonWidth: '100%',
        numberDisplayed: 5
      });
    });
</script>
