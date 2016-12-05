<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			pin:'required',

		}
	});

});
	function get_pin()
	{
		 var res = $.ajax(
	        {						
			   type: 'POST',
			   url: '<?php echo site_url('site_setting/get_pin');?>',
			   data: {id:<?php echo get_authenticateadminID()?>},
			   dataType: 'post', 
			   cache: false,
			   async: false                     
			});	
			
			$(".contentPost_sec").fadeToggle("slow");
	   setTimeout(function() {
		$('.contentPost_sec').fadeToggle("slow");
		}, 5000);
	}

</script>
<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Login Paypal Setting
							
						</h3>
						
					</div>
		</div>
		<div class="contentPost_sec" style="display: none">
	   	<div class="success_msg">
				<p><?php echo "We have send PIN to ".$get_user_master_info->email." via email.";?></p>
			</div>
	   </div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_SETTING_UPDATE;?>.</p>
				</div>
			<?php }
		
			if($error != "update"){	?>
			<div class="error_red">
					
						<?php echo $error;?>
				</div>
				<?php }
		
			if($error == "invalid"){	?>
			<div class="error_red">
					
						<?php echo "You have entered invalid pin.";?>
				</div>
			<?php }
		}
	?>		
     <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				
                   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Login Paypal Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/pin',$attributes);
			  ?>
												<!-- <div class="control_group">
													<label class="control_label">Site online<span class="req">*</span></label>
													<div class="clear"></div>
													<div class="controls"><input type="text" name="site_online" id="site_online" value="<?php echo $site_online; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                       </div>
                        -->

                        <div class="control_group">
							<label class="control_label">Pin<span class="req">*</span></label>
                            <div class="controls"> <input type="password" name="pin" id="pin"value="<?php //echo $pin; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                            
                           
                       <div class="control-group">
							
                              <div class="">
							      <span>Forgot your pin ?. <a onclick="get_pin();" href="javascript://">Click here</a></span>
							     
						       </div>
                           </div>
				 		
						<div class="form_action">
							<div class="control-group">
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="document.location.href='<?php echo base_url(); ?>admin/list_admin'" />
						</div>
						<div class="clear"></div>
						
						</div>
                        </form>
       </div>
       
       </div>
                    </div>
</div>

            
</div>
</div>
</div>
</div>
</div>

<!-- Content ends -->    