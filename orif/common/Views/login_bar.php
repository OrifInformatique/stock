<?php
/**
 * A view containing a login bar with application logo, title
 * and links for login/logout/change password/user administration functionnalities.
 * The links are related with the "user" module. They depend of the user access level.
 * 
 * This part of page is included in all pages in the BaseController display_view method.
 *
 * @author      Orif (ViDi, HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
?>

<div id="login-bar" class="container" >
  <div class="row xs-center">
    <div class="col-sm-5 col-md-3">
      <a href="<?php echo base_url(); ?>" ><img class="img-fluid" src="<?php echo base_url("images/logo.png"); ?>" ></a>
    </div>
    <div class="col-sm-7 col-md-6">
      <h1><a href="<?php echo base_url(); ?>" class="text-dark text-decoration-none"><?php echo lang('common_lang.app_title'); ?></a></h1>
    </div>
    <div class="col-sm-12 col-md-3 text-right" >
      <div class="nav flex-column">
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) { ?>
          
          <!-- ADMIN ACCESS ONLY -->
          <?php if ($_SESSION['user_access'] >= config('\User\Config\UserConfig')->access_lvl_admin) { ?>
              <a href="<?php echo base_url("user/admin/list_user"); ?>" ><?php echo lang('common_lang.btn_admin'); ?></a><br />
          <?php } ?>
          <!-- END OF ADMIN ACCESS -->

          <!-- Logged in, display a "change password" button -->
          <a href="<?php echo base_url("user/auth/change_password"); ?>" ><?php echo lang('common_lang.btn_change_my_password'); ?></a>
          <!-- and a "logout" button -->
          <a href="<?php echo base_url("user/auth/logout"); ?>" ><?php echo lang('common_lang.btn_logout'); ?></a><br />

        <?php } else { ?>
          <!-- Not logged in, display a "login" button -->
          <a href="<?php echo base_url("user/auth/login"); ?>" ><?php echo lang('common_lang.btn_login'); ?></a>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<hr />
