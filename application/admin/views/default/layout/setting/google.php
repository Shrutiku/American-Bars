<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			google_client_id:'required',
			google_url:'required',
			google_login_enable:'required',
			google_client_secret:'required',
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
							Google Setting
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_GOOGLE_UPDATE;?>.</p>
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
									<span class="hidden-480">Goolgle Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/google_setting',$attributes);
			  ?>
					<!--<div class="control_group">
						<label class="control_label">Google Setting Id<span class="req">*</span></label>
						<div class="clear"></div>
						<div class="controls"><input type="text" name="google_setting_id" id="google_setting_id" value="<?php echo $google_setting_id; ?>" class="required m_wrap wid360"/>
					</div>
						<div class="clear"></div>
                    </div>-->
                       

                        <div class="control_group">
							<label class="control_label">Google Client Id<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="google_client_id" id="google_client_id" value="<?php echo $google_client_id; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                       
                        <div class="control_group">
							<label class="control_label">Google Url<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="google_url" id="google_url" value="<?php echo $google_url; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    
						<div class="control_group">
							<label class="control_label">Google Login Enable<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="google_login_enable" id="google_login_enable" value="<?php echo $google_login_enable; ?>" class="required m_wrap wid360 "/>
							</div>
							<div class="clear"></div>
							</div>
							<div class="control_group">
							<label class="control_label">Google Client Secret<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="google_client_secret" id="google_client_secret" value="<?php echo $google_client_secret; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							<input type="hidden" name="google_setting_id" id="google_setting_id" value="<?php echo $google_setting_id; ?>" />
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