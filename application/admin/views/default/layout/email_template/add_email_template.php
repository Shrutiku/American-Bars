<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />

<!-- Content begins -->
<div id="content" class="page_content">
    <!-- Main content -->
    <div class="container_fluid">
	<div class="row_fluid">
					<div class="span12">
						<h3 class="page_title">
							 Manage Email Template
							
						</h3>
						
					</div>
		</div>


			<?php  
		if($error != "") {
			
			if($error == 'insert') {?>
			<div class="success_msg">
					
					<p>	<?php echo UPDATE_RECORD;?>.</p>
				</div>
			<?php }
		
			if($error != "insert"){	?>
			<div class="error_msg">
					
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
									<span class="hidden-480">Edit email template</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
									
                       <div class="tab-content" >
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
			
            <?php
					$attributes = array('name'=>'frm_email_template','class'=>'form-horizontal');
					echo form_open('email_template/add_email_template',$attributes);
			  ?>
			  
                    <div class="widget">
                        <div class="control_group">
					<label class="control_label">From Address :<span class="req">*</span></label>
                        <div class="controls">
							<input type="text" name="from_address" id="from_address" value="<?php echo $from_address; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						 <div class="control_group">
					<label class="control_label">Reply Address: </label>
                            <div class="controls">
							<input type="text" name="reply_address" id="reply_address" value="<?php echo $reply_address; ?>" class="required m_wrap wid360"/>
							</div><div class="clear"></div>
                        </div>
						
						<div class="control_group">
					<label class="control_label">Subject :<span class="req">*</span></label>
                           <div class="controls">
							<input type="text" name="subject" id="subject" value="<?php echo $subject; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control_group">
					<label class="control_label">Message :<span class="req">*</span></label></div>
                           <div class="controls">
							<textarea class="span12  m_wrap wid400 required" name="message" cols="" style="height: 200px;" id="message"><?php echo $message; ?></textarea>
							</div>
							<div class="clear"></div>
                        </div>
						
						<input type="hidden" name="email_template_id" id="email_template_id" value="<?php echo $email_template_id; ?>" />
						 <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
						 
						  <input type="hidden" name="sort_type" id="sort_type" value="<?php echo $sort_type; ?>" />
						  <input type="hidden" name="sort_by" id="sort_by" value="<?php echo $sort_by; ?>" />
						 
							<div class="form_action">
						<input type="submit" name="submit" value="Update"  class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel"  class="btn red fl_left" onClick="document.location.href='<?php echo base_url(); ?>email_template/list_email_template'" />
						</div>
        
   
					  
					  	 <table border="0" cellpadding="2" cellspacing="2" style="margin-left:10px; width: 98%">
               
               <tr><td align="left" valign="middle" height="70" colspan="3" style="font-size:18px; font-weight:bold;">Email Tag<br />
<span style="font-size:12px; font-weight:normal;">(copy paste the tags with braces into the message part)</span> </td></tr>

               <tr>
               <td align="left" valign="top" style="font-weight:bold;">Welcome Email</td>
               <td align="center" valign="top">:</td>
               <td align="left" valign="top">{user_name}, {email}</td>
               </tr>

               <tr>
               <td align="left" valign="top" style="font-weight:bold;">New User Join</td>
               <td align="center" valign="top">:</td>
               <td align="left" valign="top">{user_name}, {email}, {password}, {login_link}</td>
               </tr>
               
               <tr>
               <td align="left" valign="top" style="font-weight:bold;">Forgot Password</td>
               <td align="center" valign="top">:</td>
               <td align="left" valign="top">{user_name}, {email}, {password}, {login_link}</td>
               </tr>

              <tr>
               <td align="left" valign="top" style="font-weight:bold;">Other HTML Tags</td>
               <td align="center" valign="top">:</td>
               <td align="left" valign="top">{break}</td>
               </tr>

               </table>
			   			
                  
					
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
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugins/ckeditor/ckeditor.js"></script>  
<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
	<script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/plugins/bootstrap-toggle-buttons/static/js/jquery.toggle.buttons.js"></script>
	<script src="<?php echo base_url().getThemeName(); ?>/scripts/form-components.js"></script>   
<script>
		jQuery(document).ready(function() {       
		   
		   FormComponents.init();
		});
	</script>
<!-- Content ends -->     