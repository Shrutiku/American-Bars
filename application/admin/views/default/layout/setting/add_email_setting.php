<!-- Content begins -->
<script>$(document).ready(function(){
	$("#validate").validate();

});</script>
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							Email Settings
							
						</h3>
						
					</div>
		</div>

		<?php if($error!=''){?>
		<div class="success_msg">
			
				<p><?php echo $error;?></p>
		</div>
	<?php }?>
	
	<div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
					
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Email Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
									
                       <div class="tab-content" >
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
	
           		  <?php
				$attributes = array('name'=>'frm_email_setting','class'=>'form-horizontal','id'=>'validate');
				echo form_open('email_setting/add_email_setting',$attributes);
			  ?>   <div class="control_group">
													<label class="control-label">Mailer<span class="req">*</span></label>
                           <div class="controls"> 
							<select name="mailer" id="mailer" class="required m_wrap wid360" >
								<option value=""></option>
								<option value="mail" <?php if($mailer=='mail') { ?> selected="selected" <?php } ?> >PHP Mail</option>
								<option value="smtp" <?php if($mailer=='smtp') { ?> selected="selected" <?php } ?> >SMTP</option>
								<option value="sendmail" <?php if($mailer=='sendmail') { ?> selected="selected" <?php } ?> >sendmail</option>	
							</select>
							</div>
							<div class="clear"></div>
                        </div>

                        <div class="control_group">
													<label class="control-label">Send Mail Path</label>
                            <div class="controls">
							<input type="text" name="sendmail_path" id="sendmail_path" value="<?php echo $sendmail_path; ?>" class="required m_wrap wid360" />(if Mailer is sendmail)
							</div>
							<div class="clear"></div>
                        </div>

                        <div class="control_group">
													<label class="control-label">SMTP Port</label>
                           <div class="controls">
							<input type="text" name="smtp_port" id="smtp_port" value="<?php echo $smtp_port; ?>" class="m_wrap wid360"/>(465 or 25 or 587)
							</div>
							<div class="clear"></div>
                        </div>

                       <div class="control_group">
													<label class="control-label">SMTP Host</label>
                            <div class="controls">
							<input type="text" name="smtp_host" id="smtp_host" value="<?php echo $smtp_host; ?>" readonly="readonly" class="m_wrap wid360"/>(if smtp user is gmail then ssl://smtp.googlemail.com)
							</div>
							<div class="clear"></div>
                        </div>

                     	<div class="control_group">
													<label class="control-label">SMTP Email</label>
                            <div class="controls">
							 <input type="text" name="smtp_email" id="smtp_email" value="<?php echo $smtp_email; ?>"  class="m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control_group">
													<label class="control-label">SMTP Password</label>
                            <div class="controls">
							<input type="password" name="smtp_password" id="smtp_password" value="<?php echo $smtp_password; ?>" class="m_wrap wid360" />
							</div>
							<div class="clear"></div>
                        </div>
						
						 <input type="hidden" name="email_setting_id" id="email_setting_id" value="<?php echo $email_setting_id; ?>" />
							<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5"  />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="document.location.href='<?php echo base_url(); ?>admin/list_admin'" />
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