<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script type="text/javascript">

	$(document).ready(function(){
		$("#mobile_no_user").inputmask("(999) 999-9999");
//===== Usual validation engine=====//
	$("#step_1").validate({
		rules: {			
			email: {
				required: true,
				email: true
			},			
			
			last_name: {
				lettersspaceonly:true,
				required: true,
			},	
			first_name: {
				lettersspaceonly:true,
				required: true,
			},
			
			 // pass: {                        
                // required: true,
                // loginRegex: true,
                // rangelength: [8, 16]
             // },
//                    
             // confpass: {
              	// required: true,
                // equalTo:'#pass',              		
             // },			
		  	errorClass:'error fl_right'			
		}
	});	
	
	 $.validator.addMethod("loginRegex", function(value, element) {
		        return this.optional(element) || /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/.test(value);
		    }, "Provide atleast 1 Number, 1 Special character,1 Alphabet and between 8 to 16 characters.");
});
</script>
<!-- ########################################################################################### -->
<!-- content -->
<div class="wrapper row6 padtb10">
     	<div class="container">
     		<div class="result_box clearfix mar_top30bot20">
     			<div class="login_block br_green_yellow">
     				<div class="result_search">
	     				<i class="strip login_icon"></i><div class="result_search_text">Registration</div>
     				</div>
     				<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center padding-bottom-15">Taxi Owner Registration</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li class="active"><a href="<?php echo site_url('home/taxi_owner_register')?>">Step 1</a></li>
     						<li class="last" ><a href="<?php echo site_url('home/taxi_owner_registration_step2')?>">Step 2</a></li>
     						<div class="clearfix"></div>
     					</ul>
     				</div>
     				<div class="pad20">
     					<?php
				if($error != "")
				{
					echo "<div class='error1 text-center'>".$error."</div>";
				}			
				if($msg != "" && $msg != "1V1")
				{
					echo "<div class='success text-center'>".$msg."</div>";
				}			
  			?>
	     				<form class="form-horizontal" role="form" name="step_1" id="step_1" action="<?php echo site_url("home/taxi_owner_register"); ?>" method="post">
	        				 
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">First Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" name="first_name" id="first_name" value="<?php echo @$first_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Last Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" id="last_name" name="last_name" value="<?php echo @$last_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Email : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="email" name="email" value="<?php echo @$email; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Mobile Number : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="mobile_no_user" name="mobile_no" value="<?php echo @$mobile_no; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Password : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="pass" name="pass" value="<?php echo @$pass; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Confirm Password : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="confpass" name="confpass" value="<?php echo @$confpass; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
	                       			<input class="btn btn-lg btn-primary"  type="submit" name="submit" value="Next" id="submit" />
	                       			<a class="btn btn-lg btn-primary" href="<?php echo site_url('home');?>">Cancel</a>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<input type="hidden" name="temp_id" id="temp_id" value="<?php echo @$getbardata['temp_id']?>" />
	                       	<input type="hidden" name="user_id" id="user_id" value="" />
	        			</form>
	        			</div>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->