<div class="container">
<div class="row">
<div class="col-lg-12 col-sm-12">

  <!-- FILTERS FORM -->
  <form id="filters" method="get">

    <!-- TAGS FILTER -->
    <div class="col-md-12">
    <?php
      echo form_dropdown('t[]', $item_tags, $item_tags_selection,
                         'id="item_tags-multiselect" multiple="multiple"');
    ?>
    </div>

    <!-- CONDITIONS FILTER -->
   <div class="col-md-12">
    <i><?php html_escape($this->lang->line('header_conditions')); ?></i><br />
    <?php foreach ($item_conditions as $item_condition) { ?>
    <label class="checkbox-inline"><input data-condition="a" type="checkbox" name="c<?php echo $item_condition->item_condition_id; ?>" value="<?php echo $item_condition->item_condition_id; ?>"
      <?php
          if (isset($_GET['c' . $item_condition->item_condition_id]))
          {
            echo 'checked';
          }
      ?> />
    <?php echo $item_condition->name; ?></label>
    <?php } ?>
    <button type="button" onclick="$('[data-condition]').attr('checked', false);$('[data-condition]').click()"><?php echo html_escape($this->lang->line('btn_all')); ?></button>
    <button type="button" onclick="$('[data-condition]').attr('checked', false)"><?php echo html_escape($this->lang->line('btn_none')); ?></button>
      </div>

    <!-- GROUPS FILTER -->

    <div class="col-md-12">
     <i><?php html_escape($this->lang->line('header_groups')); ?></i><br />
     <?php foreach ($item_groups as $item_group) { ?>
     <label class="checkbox-inline"><input data-group="a" type="checkbox" name="g<?php echo $item_group->item_group_id; ?>" value="<?php echo $item_group->item_group_id; ?>"
       <?php
           if (isset($_GET['g' . $item_group->item_group_id]))
           {
             echo 'checked';
           }
       ?> />
     <?php echo $item_group->name; ?></label>
     <?php } ?>
     <button type="button" onclick="$('[data-group]').attr('checked', false);$('[data-group]').click()"><?php echo html_escape($this->lang->line('btn_all')); ?></button>
     <button type="button" onclick="$('[data-group]').attr('checked', false)"><?php echo html_escape($this->lang->line('btn_none')); ?></button>
       </div>

     <!-- STOCKING PLACES FILTER -->

     <div class="col-md-12">
      <i><?php echo html_escape($this->lang->line('header_stocking_places')); ?></i><br />
      <?php foreach ($stocking_places as $stocking_place) { ?>
      <label class="checkbox-inline"><input data-place="a" type="checkbox" name="s<?php echo $stocking_place->stocking_place_id; ?>" value="<?php echo $stocking_place->stocking_place_id; ?>"
        <?php
            if (isset($_GET['s' . $stocking_place->stocking_place_id]))
            {
              echo 'checked';
            }
        ?> />
      <?php echo $stocking_place->name; ?></label>
      <?php } ?>
      <button type="button" onclick="$('[data-place]').attr('checked', false);$('[data-place]').click()"><?php echo html_escape($this->lang->line('btn_all')); ?></button>
      <button type="button" onclick="$('[data-place]').attr('checked', false)"><?php echo html_escape($this->lang->line('btn_none')); ?></button>
        </div>
    <button type="submit"><strong><?php echo html_escape($this->lang->line('btn_submit_filters')); ?></strong></button>
  </form>
  <!-- END OF FILTERS -->

  <!-- BUTTON FOR NEW ITEM -->
  <a href="<?php echo base_url(); ?>item/create/" class="btn btn-primary">Nouveau…</a>

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
          <td><?php echo html_escape($item->stocking_place->name); ?></td>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->inventory_number); ?></a>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo html_escape($item->serial_number); ?></a>
          </td>
          <td><?php
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
              <a href="<?php echo base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="Supprimer l'objet">×</a>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>
</div>
</div>

<!-- Initialize the Bootstrap Multiselect plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#item_tags-multiselect').multiselect();
    });
</script>