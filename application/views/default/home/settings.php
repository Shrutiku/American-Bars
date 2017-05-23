<div class="wrapper row6 padtb10 has-js">
     	<div class="container">
     		<?php  if($this->session->userdata('user_type')!='bar_owner'){ ?><div class="wrapper row4">
   			<div class="carousel slide" id="slider-fixed-banner">
        	<div class="carousel-inner">
          	<div class="active item">
          	  	
          	  									<?php
          	  									
          	  									$userinfo_new = get_user_info(get_authenticateUserID());
          	  									
		          		if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag/'.@$userinfo_new->user_banner))
					{?>
		            	<img src="<?php echo base_url()?>/upload/banner_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            	<?php }  else if($userinfo_new->user_banner!="" && file_exists(base_path().'upload/banner_drag_without/'.@$userinfo_new->user_banner))
					{?>
						<img src="<?php echo base_url()?>/upload/banner_without_drag/<?php echo $userinfo_new->user_banner; ?>" alt="American Dive Bars"/>
		            		
		            		<?php } else {?>
		            		<img src="<?php echo base_url().'default'?>/images/smallbanner1.png" alt="American Dive Bars"/>	
		            			<?php } ?>
         </div>
        </div>
   	</div>
	</div>
  <!-- </div> -->
  <?php }  ?>
  </div><div class="<?php if($this->session->userdata('user_type')=='user'){?>user-top-border<?php } else {?>margin-top-50<?php } ?>">
  		<div class="container">
     		<div class="bg_brown">
     			<?php echo $this->load->view(getThemeName().'/home/dashboard_menu'); ?>
     			<div class="dashboard_detail">
     				<div class="result_search event"><div class="result_search_text"><i class="strip change_pwd"></i> Privacy Setting</div></div>
		     		<div class="dashboard_subblock">
		     			<div>
     						
     					
     					
					
				<div id="list_show" style="display: block;" >	
					<div class="error1 hide1 center" id="cm-err-main1">&nbsp;</div>
					<form name="add_event" id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('user/settings'); ?>">
     				<input type="hidden" name="setting_id" id="setting_id" value="<?php echo @$setting_id; ?>" />
		     			<div class="text-center pad_t15b20">
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">First Name : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$fname==1){?>checked<?php } ?> id="fname" name="fname" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$fname==0){?>checked<?php } ?> id="fname" name="fname" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Last Name : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$lname==1){?>checked<?php } ?> id="lname" name="lname" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$lname==0){?>checked<?php } ?> id="lname" name="lname" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Email : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$email1==1){?>checked<?php } ?> id="email1" name="email1" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$email1==0){?>checked<?php } ?> id="email" name="email1" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Gender : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$gender1==1){?>checked<?php } ?> id="gender1" name="gender1" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$gender1==0){?>checked<?php } ?> id="gender1" name="gender1" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Address : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$address1==1){?>checked<?php } ?> id="address1" name="address1" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$address1==0){?>checked<?php } ?> id="address1" name="address1" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	<!-- <div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Mobile Number : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$mnum==1){?>checked<?php } ?> id="mnum" name="mnum" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$mnum==0){?>checked<?php } ?> id="mnum" name="mnum" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div> -->
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">About : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$abt==1){?>checked<?php } ?> id="abt" name="abt" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$abt==0){?>checked<?php } ?> id="abt" name="abt" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	
	                       	<div class="padtb">
	        				 	<div class="col-sm-3 text-right">
	        				 		<label class="control-label">Album : </label>
	        				 	</div>
	                       		<div class="padb10 col-sm-7">
				     				<div class="radio pull-left" style="margin-top: -4px;">
					     				<label>
					          				<input type="radio" <?php if(@$album==1){?>checked<?php } ?> id="album" name="album" value="1"> Show 
					        			</label>
				        			</div>
				        			<div class="radio pull-left">
					     				<label>
					          				<input type="radio" <?php if(@$album==0){?>checked<?php } ?> id="album" name="album" value="0"> Hide
					        			</label>
				        			</div>
			        				<div class="clearfix"></div>
	        					</div>
	                       		<div class="clearfix"></div>
	                       	</div>
	                       	
	                       	
	                       	<div class="padtb8">
	                       		<div class="col-sm-3"></div>
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
     		</div>
     	<div class="clearfix"></div>
     </div>
   </div>
   </div>
 </div>
<link href="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName();?>/js/jquery_form.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/js/jquery.easing.1.3.js"></script>
    
    <script>
   
    $(document).ready(function(){
    	      
        $('#form').validate(
		{
		rules: {
					
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
						//alert("sdsa");
						$("#setting_id").val(json.id);
						$("#cm-err-main1").hide();
						$("#cm-err-main1").html("");
						$.growlUI('Your setting change successfully .');
						
					}
					$('#dvLoading').fadeOut('slow');
		   		 }
		    });
		  }
		})
		
    });
   
</script>
