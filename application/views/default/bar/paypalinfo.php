<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip update_creditcard"></i> Paypal Setting</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
                        	<ul class="order-option-list">
                            	<li ><a href="<?php echo site_url('bar/all_orders');?>"><i class="strip all_orders"></i>
                                	<p>My Orders</p>
                                </a></li>
                                <li ><a href="<?php echo site_url('bar/product_logo');?>"><i class="strip prod_logo"></i>
                                	<p>Product Logo</p>
                                </a></li>
                                <li ><a href="<?php echo site_url('bar/product_setting');?>"><i class="strip prod_setting"></i>
                                	<p>Product Setting</p>
                                </a></li>
                                <li class="active"><a href="<?php echo site_url('bar/paypal_setting');?>"><i class="strip paypal-setting"></i>
                                	<p>Paypal Setting</p>
                                </a></li>
                                <li><a href="<?php echo site_url('bar/myproduct');?>"><i class="strip my-products"></i>
                                	<p>My Products</p>
                                </a></li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
		     			<div>
     					
					<h4>Paymet from your products will be go in this paypal manager pro account. You can get this credentials from <a target="_blank" href="https://manager.paypal.com"><b>https://manager.paypal.com</b></a>.</h4>
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
						 <?php 
                       $attributes = array('id'=>'form','name'=>'add_event');
                       echo form_open_multipart('bar/paypal_setting',$attributes);
                  ?>
						<input type="hidden" name="event_id" id="event_id" value="" />
     				
		     			<div class="text-center pad_t15b20">
		     				
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Paypal Status : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<select class="select_box" name="site_status" id="site_status"> 
		                           		<option value="">SELECT STATUS</option>
							            <option value="sandbox" <?php echo $site_status=='sandbox' ? 'selected':''; ?>>Sandbox</option>
							            <option value="live" <?php echo $site_status=='live' ? 'selected':''; ?>>Live</option>
		                         	</select>
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Vendor Name : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="vendor" name="vendor" value="<?php echo @$vendor?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	  <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Username : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="paypal_username" name="paypal_username" value="<?php echo @$paypal_username?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Password : <span class="aestrick"> * </span></label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="paypal_password" name="paypal_password" value="<?php echo @$paypal_password?>">
	                       		</div>
	                       			<div class="clearfix"></div>
	        				 		<!-- <input type="password" class="form-control form-pad" id="email" placeholder="New Password" name="email" value="<?php echo @$email; ?>"> -->
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
			paypal_username:'required',
			paypal_password:'required',
			vendor:'required',		
			site_status: {
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
							$.growlUI('Your paypal settings updated successfully .');
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
    });
    
    
  
</script>


  
</script>

