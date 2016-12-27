<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			app_id:'required',
			consumer_key:'required',
			consumer_secret:'required',
			email_id:'required',
			password:'required',
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
							Yahoo Settings
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo SITE_YAHOO_UPDATE ;?>.</p>
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
									<span class="hidden-480">Yahoo Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/yahoo_setting',$attributes);
			  ?>
					<!--<div class="control_group">
						<label class="control_label">Google Setting Id<span class="req">*</span></label>
						<div class="clear"></div>
						<div class="controls"><input type="text" name="yahoo_setting_id" id="yahoo_setting_id" value="<?php echo $yahoo_setting_id; ?>" class="required m_wrap wid360"/>
					</div>
						<div class="clear"></div>
                    </div>-->
                       

                        <div class="control_group">
							<label class="control_label">Yahoo App Id <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="app_id" id="app_id" value="<?php echo $app_id; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                       
                        <div class="control_group">
							<label class="control_label">Yahoo Consumer Key<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="consumer_key" id="consumer_key" value="<?php echo $consumer_key; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    
						<div class="control_group">
							<label class="control_label">Yahoo Consumer Secret<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="consumer_secret" id="consumer_secret" value="<?php echo $consumer_secret; ?>" class="required m_wrap wid360 "/>
							</div>
							<div class="clear"></div>
							</div>
							<div class="control_group">
							<label class="control_label">Yahoo Email Id<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="email_id" id="email_id" value="<?php echo $email_id; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							<div class="control_group">
							<label class="control_label">Password<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="password" id="password" value="<?php echo $password; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							<input type="hidden" name="yahoo_setting_id" id="yahoo_setting_id" value="<?php echo $yahoo_setting_id; ?>" />
				 		<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn blue" />
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