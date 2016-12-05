<script type="text/javascript">
	$(document).ready(function(){
//===== Usual validation engine=====//
	$("#frm_login").validate({
		rules: {			
			cc_type: {
				required: true,
			},			
			card_number: {
				required: true,
			},
			ex_month: {
				required: true,
			},
			ex_year: {
				required: true,
			},
			cvv: {
				required: true,
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
	     				<i class="strip login_icon"></i><div class="result_search_text">Update Account</div>
     				</div>
     				
     				<div>
     					<div>
     				<h1 class="yellow_title padb10 br_bott_gray text-center">Update Account </h1>
     				
					<?php if($error!=""){ ?>
                        <div class="error text-center"><?php echo $error; ?></div>
                        <?php }?>
                        
                      
     				<div class="pad20">
					<?php $attributes = array('id'=>'frm_login','name'=>'frm_login','class'=>'form-horizontal','rolde'=>'form');
							echo form_open('home/update_creditcard_detail',$attributes); ?>	
	     					
	                       	<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Credit Card Type :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="cc_type" id="cc_type">
		                           		<option value="">SELECT CARD TYPE...</option>
							            <option value="MasterCard">MasterCard</option>
							            <option value="Visa" >Visa</option>
										<option value="Amex" >American Express</option>
				                        <option value="Discover" >Discover</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       
	                       <div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Credit Card Number :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="card_number" name="card_number" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3">
	        				 		<label class="control-label">Expiration Date :</label>
	        				 	</div>
	                       		<div class="col-sm-4">
	                       			<select class="form-control form-pad select" id="ex_month" name="ex_month">
	                       				<option value="">Month</option>
	                       				<option value="01">January</option>
	                       				<option value="02">February</option>
	                       				<option value="03">March</option>
	                       				<option value="04">April</option>
	                       				<option value="05">May</option>
	                       				<option value="06">June</option>
	                       				<option value="07">July</option>
	                       				<option value="08">August</option>
	                       				<option value="09">September</option>
	                       				<option value="10">October</option>
	                       				<option value="11">November</option>
	                       				<option value="12">December</option>
	                       			</select>
	                       		</div>
	                       		<div class="col-sm-3">	
	                       			<select class="form-control form-pad select"  id="ex_year" name="ex_year">
	                       				<option value="">Day</option>
	                       				<?php $dt=date('Y');
										for ($i=$dt; $i <$dt+10 ; $i++) {?> 
										<option value="<?php echo $i ?>"><?php echo $i ?></option>
										<?php } ?>
	                       			</select>
	                       		</div>	
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
	        				 	</div>
	        				 	<div class="clearfix"></div>
	        				 	
	        				<div class="padtb">
	        				 	<div class="col-sm-3">
	        				 		<label class="control-label">Cvv Number :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cvv" name="cvv" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> 	
	                       	</div>
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
	                       		<div class="col-sm-7 mart10">
	                       			<input type="submit" name="step2" id="step2" value="Next" class="btn btn-lg btn-primary"/>
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