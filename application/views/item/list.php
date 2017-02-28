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
   <div class="col-md-12">
     <i><?php echo $this->lang->line('text_kinds_to_show'); ?></i><br />
 <?php foreach ($item_tags as $item_tag) { ?>
 <label class="checkbox-inline"><input type="checkbox" name="t<?php echo $item_tag->item_tag_id; ?>" value="<?php echo $item_tag->item_tag_id; ?>"
   <?php
       if (isset($_GET['t' . $item_tag->item_tag_id]))
       {
         echo 'checked';
       }
   ?> />
 <?php echo $item_tag->name; ?></label>
 <?php } ?>
 <button type="button" onclick="btn_all()"><?php echo $this->lang->line('btn_all'); ?></button>
 <button type="button" onclick="btn_none()"><?php echo $this->lang->line('btn_none'); ?></button>
   </div>
    <button type="submit"><?php echo $this->lang->line('btn_submit_filters'); ?></button>
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
          } ?><a href="<?php echo base_url('/item/delete-item').'/'.$item->item_id ?>" class="close" title="Supprimer l'objet">×</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
<a href="<?php echo base_url(); ?>item/create/" class="btn btn-primary">Nouveau…</a>
</div>
</div>
</div>

<script>
function btn_all() {
  $("input[type='checkbox']").prop("checked", true);
}

function btn_none() {
  $("input[type='checkbox']").prop("checked", false);
}
</script>
