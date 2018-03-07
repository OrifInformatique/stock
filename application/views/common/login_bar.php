<div class="container" >
  <div class="row xs-center">
    <a href="<?php echo base_url(); ?>" style="color:inherit">
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
        <img src="<?php echo base_url("assets/images/logo.jpg"); ?>" >
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h1><?php echo $this->lang->line('app_title'); ?></h1>
      </div>
    </a>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" >
      <div class="nav nav-pills" style="margin-top:20px;">
        <?php
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
          <?php /* Admin part, for admins only (only they see, and are allowed) */
        if ($_SESSION['user_access'] >= 8) { ?><a href="<?php echo base_url("admin/"); ?>" ><?php echo $this->lang->line('btn_admin'); ?></a><br /><?php /* End of the admin-only part */ } ?>
          <a href="<?php echo base_url("auth/logout"); ?>" ><?php echo $this->lang->line('btn_logout'); ?></a>
        <?php } else { ?>
          <a href="<?php echo base_url("auth/login"); ?>" ><?php echo $this->lang->line('btn_login'); ?></a>
        <?php } ?>
      </div>

    </div>
  </div>
</div>
<hr />
