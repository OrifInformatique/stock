<div class="container">
<div class="row">
<div class="col-lg-12 col-sm-12">
<?php if(empty($items)) { ?>
  <em>Aucun objet à afficher</em>
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
            <td><?php echo $item->created_by_user->username; ?><a href="<?php echo base_url('/item/delete-item').'/'.$item->item_id ?>" class="close" title="Supprimer l'objet">×</a></td>
          </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
<a href="<?php echo base_url(); ?>item/create/" class="btn btn-primary">Nouveau…</a>
</div>
</div>
</div>
