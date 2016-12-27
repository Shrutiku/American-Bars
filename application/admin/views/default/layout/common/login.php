<!-- Admin Login -->
  <div class="logo"> <a href="javascript://"> <img class="admin-panel-logo" src="<?php echo site_url().'../default/images/americanbars.png';?>"></a> </div>
  <div class="login_content">
   <?php if(isset($msg) && $msg!=''){
	  if($msg=='logout'){ ?>
	  <div class="success_msg"><p><?php echo LOGOUT_SUCCESS;?></p></div>
	  <?php } } ?>
    <?php			 
		$attributes = array('name'=>'frmlogin','id'=>'usualValidate');
		echo form_open('home/login',$attributes);
	?>
      <h3 class="form_title"><?php echo $this->lang->line("login.login_account");?></h3>
	  
      <div class="control-group">
	  <?php if(isset($error) && $error!=''){ ?>
	  <div class="error_red"><?php echo $error;?></div>
	  <?php } ?>
	  
        <div class="controls1">
          <div class="input_icon left"> <i class="icon_user user"></i>
           <input type="text" name="username" value="" id="username" placeholder="Email ID" class="m-wrap"/>
            <div class="error" style="margin:0;"><?php echo form_error('username'); ?> </div> 
          </div>
        </div>
      </div>
      <div class="control-group">
        <div class="controls1">
          <div class="input_icon left"> <i class="icon_user password"></i>
            <input type="password" name="password" placeholder="Password" class="m-wrap" id="password" />
			<div class="error" style="margin:0;"><?php echo form_error('password'); ?> </div> 
          </div>
        </div>
      </div>
      <div class="form_actions clear">
        <input type="submit" class="btn green fl_left" value="Login" name="submit" >
		
        <a href="<?php echo site_url("home/forgot_password"); ?>" class="fl_right" style="color:#000;text-decoration: underline;">Forget Password ?</a>
      </div>
    </form>
  </div>
  <div class="center">
  	<p class="copyright_txt"> <?php
  	
  	echo date('Y');?> &copy; AMERICAN BARS SOFTWARE All rights reserved.. </p>
  </div>
