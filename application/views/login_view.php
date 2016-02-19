<div class="container">
     <div class="row">
          <div class="col-lg-6 col-sm-6">
               <h1><?php echo $this->lang->line('app_title'); ?></h1>
          </div>
          <div class="col-lg-6 col-sm-6">
               
               <ul class="nav nav-pills pull-right" style="margin-top:20px">
                    <li class="active"><a href="#"><?php echo $this->lang->line('btn_login'); ?></a></li>
                    <li><a href="#"><?php echo $this->lang->line('btn_signup'); ?></a></li>
               </ul>
               
          </div>
     </div>
</div>
<hr/>

<div class="container">
     <div class="row">
          <div class="col-lg-4 col-sm-4 well">
          <?php 
          $attributes = array("class" => "form-horizontal", "id" => "loginform", "name" => "loginform");
          echo form_open("auth/login", $attributes);?>
          <fieldset>
               <legend><?php echo $this->lang->line('text_login'); ?></legend>
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
                    <label for="username" class="control-label"><?php echo $this->lang->line('field_username'); ?></label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="username" name="username" placeholder="<?php echo $this->lang->line('field_username'); ?>" type="text" value="<?php echo set_value('username'); ?>" />
                    <span class="text-danger"><?php echo form_error('username'); ?></span>
               </div>
               </div>
               </div>
               
               <div class="form-group">
               <div class="row colbox">
               <div class="col-lg-4 col-sm-4">
               <label for="password" class="control-label"><?php echo $this->lang->line('field_password'); ?></label>
               </div>
               <div class="col-lg-8 col-sm-8">
                    <input class="form-control" id="password" name="password" placeholder="<?php echo $this->lang->line('field_password'); ?>" type="password" value="<?php echo set_value('password'); ?>" />
                    <span class="text-danger"><?php echo form_error('password'); ?></span>
               </div>
               </div>
               </div>
                              
               <div class="form-group">
               <div class="col-lg-12 col-sm-12 text-center">
                    <input id="btn_login" name="btn_login" type="submit" class="btn btn-default" value="<?php echo $this->lang->line('btn_login'); ?>" />
                    <input id="btn_cancel" name="btn_cancel" type="reset" class="btn btn-default" value="<?php echo $this->lang->line('btn_cancel'); ?>" />
               </div>
               </div>
          </fieldset>
          <?php echo form_close(); ?>
          <?php echo $this->session->flashdata('message'); ?>
          </div>
     </div>
</div>