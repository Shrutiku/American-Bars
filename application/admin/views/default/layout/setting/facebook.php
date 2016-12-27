<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			facebook_application_id:'required',
			facebook_login_enable:'required',
			facebook_access_token:'required',
			facebook_api_key:'required',
			facebook_secret_key:'required',
			facebook_user_autopost:'required',
			facebook_wall_post:'required',
			facebook_url:'required',
}
	});

});</script>
<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Facebook Setting
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_FACEBOOK_UPDATE;?>.</p>
				</div>
			<?php }
		
			if($error != "update"){	?>
			<div class="error_red">
					
						<?php echo $error;?>
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
									<span class="hidden-480">facebook Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/facebook_setting',$attributes);
			  ?>

                        <div class="control_group">
							<label class="control_label">Facebook Application Id<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="facebook_application_id" id="facebook_application_id" value="<?php echo $facebook_application_id; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                       
                        <div class="control_group">
							<label class="control_label">Facebook Login Enable<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="facebook_login_enable" id="facebook_login_enable" value="<?php echo $facebook_login_enable; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    
						<div class="control_group">
							<label class="control_label">Facebook Access Token<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="facebook_access_token" id="facebook_access_token" value="<?php echo $facebook_access_token; ?>" class="required m_wrap wid360 "/>
							</div>
							<div class="clear"></div>
							</div>
							
							<div class="control_group">
							<label class="control_label">Facebook Api Key<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="facebook_api_key" id="facebook_api_key" value="<?php echo $facebook_api_key; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							 <div class="control_group">
							<label class="control_label">Facebook Secret Key<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="facebook_secret_key" id="facebook_secret_key" value="<?php echo $facebook_secret_key; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                       
                        <div class="control_group">
							<label class="control_label">Facebook User Autopost<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="facebook_user_autopost" id="facebook_user_autopost" value="<?php echo $facebook_user_autopost; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    
						<div class="control_group">
							<label class="control_label">Facebook Wall Post<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="facebook_wall_post" id="facebook_wall_post" value="<?php echo $facebook_wall_post; ?>" class="required m_wrap wid360 "/>
							</div>
							<div class="clear"></div>
							</div>
							
							<div class="control_group">
							<label class="control_label">Facebook Url<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="facebook_url" id="facebook_url" value="<?php echo $facebook_url; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							<input type="hidden" name="facebook_setting_id" id="facebook_setting_id" value="<?php echo $facebook_setting_id; ?>" />
				 		<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
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