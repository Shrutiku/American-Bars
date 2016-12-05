<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			mode:'required',
			account_sid:'required',
			auth_token:'required',
			api_version:'required',
			number:'required',
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
							Message Settings
							
						</h3>
						
					</div>
		</div>
		<?php  
		if($error != "") {
			if($error == "update") {?>
				<div class="success_msg">
					
						<p><?php echo 'Record Update Successfully';?>.</p>
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
									<span class="hidden-480">Message Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/message_setting',$attributes);
			  ?>
					<div class="control_group">
										<label class="control_label">Mode:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<input type="text" name="mode" id="mode" value="<?php echo $mode; ?>" class="required m_wrap wid360"/>
										</div>										
										<div class="clear"></div>
									</div>
                       <div class="control_group">
							<label class="control_label"> Account Sid  <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="account_sid" id="account_sid" value="<?php echo $account_sid; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							<div class="control_group">
							<label class="control_label"> Auth Token  <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="auth_token" id="auth_token" value="<?php echo $auth_token; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                        <div class="control_group">
							<label class="control_label">Api Version <span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="api_version" id="api_version" value="<?php echo $api_version; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
							
							<div class="control_group">
							<label class="control_label">Number<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="number" id="number" value="<?php echo $number; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                    	<input type="hidden" name="twilio_id" id="twilio_id" value="<?php echo $twilio_id; ?>" />
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