<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.validate.js"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		
	    $.validator.addMethod("password_valid", function( value, element,param ) {
        return this.optional(element) || value.length >= 8 && /\d/.test(value) && /[a-z]/i.test(value);
    }, "Your password must be contain at least one number and one character.");
//===== Usual validation engine=====//
	$("#frm_signup").validate({
		rules: {
			first_name : "required",
			last_name : "required",
			user_name : "required",
			email: {
				required: true,
				email: true
			},
			
			password: {
				required:true,
				minlength:8,
			    password_valid:true,
			},
  			confirm_password: {
				required:true,
				minlength:8,
		        equalTo: "#password"
			},				
		  	errorClass:'error fl_right'		
		}
	});
	
	});
	
	</script>

<!-- ########################################################################################### -->
<!-- content -->
			<?php
				if($error != "")
				{
					echo "<div class='error1 text-center'>".$error."</div>";
				}			
				if($msg != "")
				{
					echo "<div class='success text-center'>".$msg."</div>";
				}			
  			?>
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				<div class="pad20">
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</h1>
	     				<form id="frm_signup" class="form-horizontal" role="form" action="<?php echo site_url("home/signup"); ?>" method="post">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">First Name :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="first_name" name="first_name" value="<?php echo $first_name; ?>" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Last Name :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="last_name" name="last_name" value="<?php echo $last_name; ?>" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" name="email" value="<?php echo $email; ?>" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">User Name :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="user_name" name="user_name" value="<?php echo $user_name; ?>" />
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="password" name="password">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>							
	                     	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Confirm Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="confirm_password" name="confirm_password">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
									<button class="btn btn-lg btn-primary">Register</button>
									<a href="<?php echo site_url("home"); ?>" class="btn btn-lg btn-primary">Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	        			</form>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<?php /*?><div class="wrapper row3 padtb20">
  <div id="container" class="clear">
  	<div class="row">
  		<h1 class="pagetitle">New User Please Signup...!</h1>
  		<div class="registerbox">
  			<h2 class="subtitle">New User</h2>
  			
  			<?php
  			if($error != "")
			{
				echo "<div class='error text-center'>".$error."</div>";
			}
			
			if($msg != "")
			{
				echo "<div class='success text-center'>".$msg."</div>";
			}
			
  			?>
  			<div class="padtb15">
  				
  				 <?php 
                       $attributes = array('id'=>'frm_signup','name'=>'frm_signup');
                       echo form_open('signup',$attributes);
                  ?>
  					<div class="form-control-div">
						<div class="form-sub-control-left">
				 			<label class="label-group">First Name :<span class="aestrik">*</span> </label>
				 			<!-- <div class="input-group"> -->
								<input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" placeholder="First Name" class="input wrap br_silver large"/>
				   			<!-- </div> -->
                    		<!-- <label class="error fl_right"> Error display here... </label> -->
                    	</div>
                    	<div class="form-sub-control-right">
				 			<label class="label-group">Last Name :<span class="aestrik">*</span> </label>
				 			<!-- <div class="input-group"> -->
								<input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $last_name; ?>" class="input wrap br_silver large"/>
				   			<!-- </div> -->
                    	</div>
                    	<div class="clear"></div>
					</div>
				
					<div class="form-control-div">
						<div class="form-sub-control-left">
				 			<label class="label-group">Email :<span class="aestrik">*</span> </label>
				 			<!-- <div class="input-group"> -->
								<input type="text" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email" class="input wrap br_silver large"/>
				   			<!-- </div> -->
                    	</div>
                    	<div class="form-sub-control-right">
				 			<label class="label-group">Password :<span class="aestrik">*</span> </label>
				 			<!-- <div class="input-group"> -->
								<input type="password" id="password" name="password" class="input wrap br_silver large"/>
				   			<!-- </div> -->
                    	</div>
                    	<div class="clear"></div>
					</div>
					
					<div class="form-control-div">
						<div>
				 			<label class="label-group">About user :<span class="aestrik">*</span> </label>
				 			<!-- <div class="input-group"> -->
								
								<textarea id="about_user" name="about_user" placeholder="Email" class="input wrap br_silver wd780"><?php echo $about_user; ?></textarea>
				   			<!-- </div> -->
                    	</div>
                    	
                    	<div class="clear"></div>
					</div>
					
					<div class="form-control-div text-center padtb15">
						<input  type="checkbox" id="agree" name="agree" value="1" <?php if($agree ==1){?> checked = "checked" <?php } ?> /><label class="cheklabel">I Confirm That I Agree With The <a href="#" class="red">Terms Of Service</a>,<a href="#" class="red"> Policy</a>, And <a href="#" class="red"> Cookie Policy</a></label>
					</div>
					<div class="form-control-div text-center">
						<button type="submit" name="b1" class="button">Register</button>
					</div>
  				</form>
  			</div>
  		</div>
  	</div>
  	
  	
  </div>
</div><?php */?>
<!-- ########################################################################################### -->