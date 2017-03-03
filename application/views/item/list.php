<div class="container">
<div class="row">
<div class="col-lg-12 col-sm-12">
  <button class="btn" type="button" data-toggle="collapse" data-target="#filters"><?php echo $this->lang->line('btn_toggle_filters'); ?></button>
  <form class="collapse<?php
// If filters were set, show the form
if (!empty($_GET)) {
  echo " in";
}
   ?>" id="filters" method="get">

   <!-- TAGS -->

   <div class="col-md-12">
     <i><?php echo $this->lang->line('header_tags'); ?></i><br />
 <?php foreach ($item_tags as $item_tag) { ?>
 <label class="checkbox-inline"><input data-tag="a" type="checkbox" name="t<?php echo $item_tag->item_tag_id; ?>" value="<?php echo $item_tag->item_tag_id; ?>"
   <?php
       if (isset($_GET['t' . $item_tag->item_tag_id]))
       {
         echo 'checked';
       }
   ?> />
 <?php echo $item_tag->name; ?></label>
 <?php } ?>
 <button type="button" onclick="$('[data-tag]').attr('checked', false);$('[data-tag]').click()"><?php echo $this->lang->line('btn_all'); ?></button>
 <button type="button" onclick="$('[data-tag]').attr('checked', false)"><?php echo $this->lang->line('btn_none'); ?></button>
   </div>

   <!-- CONDITIONS -->

   <div class="col-md-12">
    <i><?php echo $this->lang->line('header_conditions'); ?></i><br />
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
    <button type="button" onclick="$('[data-condition]').attr('checked', false);$('[data-condition]').click()"><?php echo $this->lang->line('btn_all'); ?></button>
    <button type="button" onclick="$('[data-condition]').attr('checked', false)"><?php echo $this->lang->line('btn_none'); ?></button>
      </div>

    <!-- GROUPS -->

    <div class="col-md-12">
     <i><?php echo $this->lang->line('header_groups'); ?></i><br />
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
     <button type="button" onclick="$('[data-group]').attr('checked', false);$('[data-group]').click()"><?php echo $this->lang->line('btn_all'); ?></button>
     <button type="button" onclick="$('[data-group]').attr('checked', false)"><?php echo $this->lang->line('btn_none'); ?></button>
       </div>

     <!-- STOCKING PLACES -->

     <div class="col-md-12">
      <i><?php echo $this->lang->line('header_stocking_places'); ?></i><br />
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
      <button type="button" onclick="$('[data-place]').attr('checked', false);$('[data-place]').click()"><?php echo $this->lang->line('btn_all'); ?></button>
      <button type="button" onclick="$('[data-place]').attr('checked', false)"><?php echo $this->lang->line('btn_none'); ?></button>
        </div>
    <button type="submit"><strong><?php echo $this->lang->line('btn_submit_filters'); ?></strong></button>
  </form>
<?php if(empty($items)) { ?>
  <em><?php echo $this->lang->line('msg_no_item'); ?></em>
<?php } else { ?>
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th><?php echo $this->lang->line('header_inventory_nb'); ?></th>
        <th><?php echo $this->lang->line('header_item_name'); ?></th>
        <th><?php echo $this->lang->line('header_item_description'); ?></th>
        <th><?php echo $this->lang->line('header_item_created_by'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item) { ?>
		  <tr>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo $item->inventory_number; ?></a>
          </td>
          <td>
            <a href="<?php echo base_url('/item/view').'/'.$item->item_id ?>" style="display:block"><?php echo $item->name; ?></a>
          </td>
            <td><?php echo $item->description; ?></td>
          <td><?php
          if (is_null($item->created_by_user_id)) {
            echo "<i>Anonymous</i>";
          } else {
            echo $item->created_by_user->username;
          } ?><a href="<?php echo base_url('/item/delete').'/'.$item->item_id ?>" class="close" title="Supprimer l'objet">×</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
<a href="<?php echo base_url(); ?>item/create/" class="btn btn-primary">Nouveau…</a>
</div>
</div>
</div>
