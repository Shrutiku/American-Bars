<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_reset").validate({
		rules: {
			
			rpassword: {
				required: true,
                 	loginRegex: true,
                        rangelength: [8, 16],
			},
			confirm_password: {
				required: true,
				rangelength: [8, 16],
				equalTo: "#rpassword",
			},		
				
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
	     				<div class="result_search_text">Reset Password</div>
     				</div>
  				 <?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      <?php if($msg!=""){
                      	if($msg=="success") 
						{
							echo "<div class='success text-center'>".PASSWORD_CHANGE_SUCCESS."</div>";
						}
						
						
						
                        }  ?>
		  			<div class="padtb15">
		  				<?php $attributes = array('id'=>'frm_reset','name'=>'frm_reset');
							echo form_open('home/reset_password/'.base64_encode($user_id),$attributes); ?>	
		  					<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">New Password :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="password" class="form-control form-pad" id="rpassword" name="rpassword">
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
									<button class="btn btn-lg btn-primary">Save</button>
								</div>
	                       		<div class="clearfix"></div>
	                       	</div>
		  				</form>
	        		</div>
     			</div>
     		</div>
   		</div>
   	</div>
<!-- ************************************************************************ -->