<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>

<script type="text/javascript">
 $(document).ready(function() { 
		   $("#texi_company_phone_number").inputmask("(999) 999-9999");
	});
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			tax_company_name: {
				required: true,
			},			
			tax_cmpn_address: {
				required: true,
			},		
			city:'required',
			state:'required',
			cmpn_zipcode:'required',
			// texi_company_phone_number: {
				// required: true,
			// //	number:true,
			// },		
			taxi_company_website: {
				//required: true,
				url: true,
			},			
			reciew: {
				//required: true,
			},				
			profile_image:{
						 accept: "jpg|jpeg|png|bmp"
						},
		  	errorClass:'error fl_right'			
		}
	});	
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
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Taxi Owner Registration Step 2</h1>
     				<div>
     					<ul class="registration_steplist">
     						<li class=""><a href="<?php echo site_url('home/taxi_owner_register')?>">Step 1</a></li>
     						<li class="last active" ><a href="<?php echo site_url('home/taxi_owner_registration_step2')?>">Step 2</a></li>
     					</ul>
     				</div> <div class="clearfix"></div>
					<?php if($error!=""){ ?>
                        <div class="error text-center mar_top20"><?php echo $error; ?></div>
                        <?php }?>
                        
                      <div class="clearfix"></div>
     				<div class="pad20 mar_top20">
     				<h1 class="yellow_title padb10 br_bott_ text-center"></h1>
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open_multipart('home/taxi_owner_registration_step2',$attributes); ?>	
	        				 <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Company Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" maxlength="40" name="tax_company_name" id="tax_company_name" value="<?php echo @$tax_company_name; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Address : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="tax_cmpn_address" id="tax_cmpn_address" class="form-control form-pad"><?php echo @$tax_cmpn_address; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">City : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="city" id="city" value="<?php echo @$city; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">State : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="state" id="state" value="<?php echo @$state; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Zipcode : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="cmpn_zipcode" id="cmpn_zipcode" value="<?php echo @$cmpn_zipcode; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Phone Number : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" name="texi_company_phone_number" id="texi_company_phone_number" value="<?php echo @$texi_company_phone_number; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Website Address : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad"  name="taxi_company_website" id="taxi_company_website" value="<?php echo @$taxi_company_website; ?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Description : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<textarea rows="5" placeholder="Description" name="reciew" id="reciew" class="form-control form-pad"><?php echo @$reciew; ?></textarea>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Taxi Image : </label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="file" accept="image/*" class="form-control form-pad" id="profile_image" name="profile_image">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
	                       	<div class="padtb8">
	                       		<div class="col-sm-7 mart10">
	                       			<input type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary"/>
	                       			<a class="btn btn-lg btn-primary" href="<?php echo site_url('home/taxi_owner_register')?>">Back</a>
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