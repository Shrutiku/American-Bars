<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip update_creditcard"></i> Update Credit Card Info</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
     					
					
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
						 <?php 
                       $attributes = array('id'=>'form','name'=>'add_event');
                       echo form_open_multipart('home/updatecard',$attributes);
                  ?>
						<input type="hidden" name="event_id" id="event_id" value="" />
     				
		     			<div class="text-center pad_t15b20">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
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
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Credit Card Number :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="card_number" name="card_number" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
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
	                       		<div class="col-sm-3 text-right">	
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
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Cvv Number :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="cvv" name="cvv" value="">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div> 	
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right"></div>
	                       		<div class="col-sm-7 mart10 text-left">
	                       			<button type="submit" class="btn btn-lg btn-primary marr_10" >Save</button> 
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	<div class="clearfix"></div>
     		</div>
     			</form>
     			
		     	</div>
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
 </div>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    
    <script>
  
    $(document).ready(function(){
        $('#form').validate({
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
		},
				
		submitHandler: function(form){
			
		$(form).ajaxSubmit({
			
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		$('#dvLoading').fadeIn('slow');
		    	 },
		    	
		    	uploadProgress: function ( event, position, total, percentComplete ) {	
		        },
		    
		    	success : function ( json ) 
		    	{
		    		
					if(json.status == "fail")
					{
						$("#cm-err-main1").show();
						$("#cm-err-main1").html(json.comment_error);
			    		$('#dvLoading').fadeOut('slow');
			    		scrollToDiv('cm-err-main1');
				  		// setTimeout(function () 
						// {
						      // $("#cm-err-main1").fadeOut('slow');
						// }, 3000);
					return false;
					}
			
					else
					{
							$.growlUI('Your credit card update successfully .');
						$(':input','#form')
					 	.not(':button, :submit, :reset, :hidden')
					 	.val('')
					 	//.removeAttr('checked')
					 	.removeAttr('selected');
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
    });
    
    
  
</script>


  
</script>

