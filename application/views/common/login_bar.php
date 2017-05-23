<div class="container">
  <div class="row">
    <a href="<?php echo base_url(); ?>" style="color:inherit">
      <div class="col-lg-2 col-sm-2">
        <img src="<?php echo base_url("assets/images/logo.jpg"); ?>" >
      </div>
      <div class="col-lg-4 col-sm-4">
        <h1><?php echo $this->lang->line('app_title'); ?></h1>
      </div>
    </a>
    <div class="col-lg-6 col-sm-6">
      <ul class="nav nav-pills pull-right" style="margin-top:20px">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
          <?php /* Admin part, for admins only (only they see, and are allowed) */
        if ($_SESSION['user_access'] >= 8) { ?><li><a href="<?php echo base_url("admin/"); ?>" ><?php echo $this->lang->line('btn_admin'); ?></a></li><?php /* End of the admin-only part */ } ?>
          <li><a href="<?php echo base_url("auth/logout"); ?>" ><?php echo $this->lang->line('btn_logout'); ?></a></li>
        <?php } else { ?>
          <li><a href="<?php echo base_url("auth/login"); ?>" ><?php echo $this->lang->line('btn_login'); ?></a></li>
        <?php } ?>
      </ul>

    </div>
  </div>
</div>
<hr />
