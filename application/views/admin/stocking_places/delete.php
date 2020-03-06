<div class="container">
    
  <?php $type = 2; include __DIR__.'/../admin_bar.php';?>
  
  <?php if(isset($short) && isset($name) && $deletion_allowed) { ?>
    <div class="row" >
      <?= lang('admin_delete_stocking_place_verify').$short." (".$name.") ?"; ?>
    </div>
    <div class="btn-group row" >
      <a href="<?= base_url().uri_string()."/confirmed";?>" class="btn btn-danger btn-lg"><?= lang('text_yes'); ?></a>
      <a href="<?= base_url()."admin/view_stocking_places/";?>" class="btn btn-lg"><?= lang('text_no'); ?></a>
    </div>
  <?php } else { 
    echo '<div class="alert alert-danger">'.lang('delete_notok_with_amount').$amount;
    
    if($amount > 1) {
      echo lang('delete_notok_items');
    } else {
      echo lang('delete_notok_item');
    }
    
    echo '</div>';
  } ?>
</div>
