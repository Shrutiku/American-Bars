
  <div class="logo"> <a href="javascript://"> <img class="admin-panel-logo" alt="" src="<?php echo site_url().'default/images/logo.png';?>"> </a> </div>
  <div class="login_content">
    <?php			 
		$attributes = array('name'=>'frmlogin','id'=>'usualValidate');
		echo form_open('home/forgot_password',$attributes);
	?>
      <h3 class="form_title">Forgot Password</h3>
	  
      <div class="control-group">
	  <?php if(isset($error) && $error!='' && $error != "success"){ ?>
	  <div class="error_red">
	  	<?php if($error == "record_not_found"){echo "Email Address not found.";}
              else if($error == "Inactive"){echo "Your Account is Inactive.Please contact main Administrator";}
	  	     else { echo $error;}?>
	  	     
	  	     </div>
	  <?php } 
	  if($error=="success"){?>
	  	<div class="success_msg">Your Login details sent to your Email Address.</div>
	  	<?php }?>
        <div class="controls1">
          <div class="input_icon left"> <i class="icon_user user"></i>
           <input type="text" name="email" value="" id="email" placeholder="User name" class="m-wrap"/>
           <?php
           if(form_error('email'))
		   {
           ?>
            <div class="error_red"><?php echo form_error('email'); ?> </div> 
         <?php }?>
          </div>
        </div>
      </div>
      
      <div class="form_actions clear">
        <input type="submit" class="btn green fl_left" value="Submit" name="submit" >
         <a href="<?php echo site_url("home/login"); ?>" class="fl_right" style="color:#000;text-decoration: underline;">Back to Login</a>
      </div>
    </form>
  </div>
  <div class="center">
  	<p class="copyright_txt"> 2013 &copy; Spaculus Software Services. </p>
  </div>
