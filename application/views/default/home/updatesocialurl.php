<?php //echo $google_plus_link;?>
<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<div class="margin-top-50 bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip social_url"></i> Update social URL</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
     					
					
					
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<!-- <form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('bar/add_event/'.base64_encode($getbar['bar_id'])); ?>"> -->
						
						 <?php 
                       $attributes = array('id'=>'form','name'=>'add_event');
                       echo form_open_multipart('home/socialmedialink',$attributes);
                  ?>
						<input type="hidden" name="event_id" id="event_id" value="" />
     				
		     			<div class="text-center pad_t15b20">
	                       	
	                       	
	                       	  <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Facebook Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="facebook_link" name="facebook_link" value="<?php echo $facebook_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Twitter Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="twitter_link" name="twitter_link" value="<?php echo $twitter_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Linkedin Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="linkedin_link" name="linkedin_link" value="<?php echo $linkedin_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       		<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Instagram Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="instagram_link" name="instagram_link" value="<?php echo $instagram_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Google Plus Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="google_plus_link" name="google_plus_link" value="<?php echo $google_plus_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Dribble Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="dribble_link" name="dribble_link" value="<?php echo $dribble_link;?>">
	                       		</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Pinterest Url :</label>
	        				 	</div>
	                       		<div class="input_box col-sm-7">
	                           		<input type="text" class="form-control form-pad" id="pinterest_link" name="pinterest_link" value="<?php echo $pinterest_link;?>">
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
			facebook_link: {
				url: true,
			},
			twitter_link: {
				url: true,
			},			
			linkedin_link: {
				url: true,
			},
			google_plus_link: {
				url: true,
			},
			instagram_link: {
				url: true,
			},
			dribble_link: {
				url: true,
			},
			pinterest_link: {
				url: true,
			},				
		  	errorClass:'error fl_right'			
		},
				
		submitHandler: function(form){
			
		$(form).ajaxSubmit({
			
		type: "POST",
		   		 dataType : 'json',
				 beforeSubmit: function() 
				 {
		       		//$('#dvLoading').fadeIn('slow');
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
							$.growlUI('Your record update successfully .');
						
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
    });
    
    
  
</script>


  
</script>

