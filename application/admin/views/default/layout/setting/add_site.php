<script>$(document).ready(function(){
	$("#usualValidate").validate({
		rules:{
			site_name:'required',
			site_address : 'required',
			//site_version:'required',
			currency_code:'required',
			currency_symbol:'required',
			date_format:'required',
			//time_format:'required',
			//date_time_format:'required',
			//google_map_key:'required',
			//default_longitude:'required',
			//default_latitude:'required',
			amount:{required:true,number:true,},
			managed_account_amount:{required:true,number:true,},
			//poker_coach_price:'required',
			how_it_works_video:
			{
			    required:true,
                url:true,
			},
			//header_text:'required',
			site_email:{
				required:true,
				email:true,
			}

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
							Site Settings
							
						</h3>
						
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
		}
	?>		
     <div class="row_fluid">
					<div class="span12">
						<!-- BEGIN SAMPLE FORM PORTLET-->   
						<div class="portlet box blue tabbable">
				
                   
                        <div class="portlet-title">
								<div class="caption">
									<i class="icon-reorder"></i>
									<span class="hidden-480">Site Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
								
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
											<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addadmin','class'=>'form-horizontal');
				echo form_open('site_setting/add_site_setting',$attributes);
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
							<label class="control_label">Site Name<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="site_name" id="site_name"value="<?php echo $site_name; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                            </div>
                       
                       <div class="control_group">
													<label class="control_label">Address<span class="req">*</span></label>
                            <div class="controls"> <input type="text" name="site_address" id="site_address" value="<?php echo $site_address; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div> 
                    
						<div class="control_group">
													<label class="control_label">Currency Code<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="currency_code" id="currency_code" value="<?php echo $currency_code; ?>" class="m_wrap wid360 "/>
							</div>
							<div class="clear"></div>
							</div>
                      
						
						<div class="control_group">
						<label class="control_label">Currency Symbol<span class="req">*</span></label>
						<div class="clear"></div>
                            <div class="controls"><input type="text" name="currency_symbol" id="currency_symbol" value="<?php echo $currency_symbol; ?>" class="m_wrap wid360"/>
							</div>
							<div class="clear"></div>
							</div>
                       
						
						<div class="control_group">
													<label class="control_label">Date Format<span class="req">*</span></label>
                            <div class="controls">
                            	<select class="m_wrap wid360 required" name="date_format" data-placeholder="Choose a Format" tabindex="1">
															<option value="">--Select Format--</option>
															<option value="d/M/Y" <?php echo $date_format=='d/M/Y'?'selected="selected"':''; ?>>31/Dec/1999</option>
															<option value="Y/d/M" <?php echo $date_format=='Y/d/M'?'selected="selected"':''; ?>>1999/31/Dec</option>
															<option value="Y/M/d" <?php echo $date_format=='Y/M/d'?'selected="selected"':''; ?>>1999/Dec/31</option>
															<option value="d/F/Y" <?php echo $date_format=='d/F/Y'?'selected="selected"':''; ?>>31/December/1999</option>
															<option value="Y/d/F" <?php echo $date_format=='Y/d/F'?'selected="selected"':''; ?>>1999/31/December</option>
															<option value="Y/F/d" <?php echo $date_format=='Y/F/d'?'selected="selected"':''; ?>>1999/December/31</option>
															<option value="d-M-Y" <?php echo $date_format=='d-M-Y'?'selected="selected"':''; ?>>31-Dec-1999</option>
															<option value="Y-d-M" <?php echo $date_format=='Y-d-M'?'selected="selected"':''; ?>>1999-31-Dec</option>
															<option value="Y-M-d" <?php echo $date_format=='Y-M-d'?'selected="selected"':''; ?>>1999-Dec-31</option>
															<option value="d/m/Y" <?php echo $date_format=='d/m/Y'?'selected="selected"':''; ?>>31/12/1999</option>
															<option value="m/d/Y" <?php echo $date_format=='m/d/Y'?'selected="selected"':''; ?>>12/31/1999</option>
															<option value="Y/m/d" <?php echo $date_format=='Y/m/d'?'selected="selected"':''; ?>>1999/31/12</option>
															<option value="d-m-Y" <?php echo $date_format=='d-m-Y'?'selected="selected"':''; ?>>31-12-1999</option>
															<option value="Y-d-m" <?php echo $date_format=='Y-d-m'?'selected="selected"':''; ?>>1999-31-12</option>
															<option value="m-d-Y" <?php echo $date_format=='m-d-Y'?'selected="selected"':''; ?>>12-31-1999</option>
														</select>
                            	
                            	<!-- <input type="text" name="date_format" id="date_format" value="<?php echo $date_format; ?>" class="m_wrap small"/> -->
							</div>
							<div class="clear"></div>
							</div>
                       
						
						<!-- <div class="control_group">
													<label class="control_label">Time Format<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="time_format" id="time_format" value="<?php echo $time_format; ?>" class="m_wrap small"/>
							</div>
							<div class="clear"></div>
							</div> -->
                     

						<!-- <div class="control_group">
													<label class="control_label">Date Time Format<span class="req">*</span></label>
                           <div class="controls"> <input type="text" name="date_time_format" id="date_time_format" value="<?php echo $date_time_format; ?>" class="m_wrap small"/>
							</div>
							<div class="clear"></div>
							</div>
                        -->
						

						<!-- <div class="control_group">
													<label class="control_label">Google Map Key<span class="req">*</span></label>
                           <div class="controls"> <input type="text" name="google_map_key" id="google_map_key" value="<?php echo $google_map_key; ?>" class="m_wrap small"/>
							</div>
							<div class="clear"></div>
							</div>
                     					


						<div class="control_group">
													<label class="control_label">Default Longitude<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="default_longitude" id="default_longitude" value="<?php echo $default_longitude; ?>" class="m_wrap small"/>
							</div>
							<div class="clear"></div>
							</div>
                        
																
						<div class="control_group">
							<label class="control_label">Default Latitude<span class="req">*</span></label>
                            <div class="controls"><input type="text" name="default_latitude" id="default_latitude" value="<?php echo $default_latitude; ?>" class="m_wrap small"/>
							</div>
							<div class="clear"></div>
							</div> -->
                      	
						
						<div class="control_group">
						  <label class="control_label">Site e-mail<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="site_email" id="site_email" value="<?php echo $site_email; ?>" class="m_wrap wid360"/>
						   </div>
						   <div class="clear"></div>
                        </div>
                        
                        <div class="control_group">
						  <label class="control_label">System Conversation e-mail</label>
                           <div class="controls"><input type="text" name="email_conversation" id="email_conversation" value="<?php echo $email_conversation; ?>" class="m_wrap wid360"/>
						   </div>
						   <div class="clear"></div>
                        </div>
                        
                       
                        
                        <div class="control_group">
                          <label class="control_label">Video link<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="how_it_works_video" id="how_it_works_video" value="<?php echo $how_it_works_video; ?>" class="m_wrap wid360"/>
                           </div>
                           <div class="clear"></div>
                        </div>
                         <!-- <div class="control_group">
                          <label class="control_label">Poker Coach Price[$]<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="poker_coach_price" id="poker_coach_price" value="<?php echo $poker_coach_price; ?>" class="m_wrap wid360"/>
                           </div>
                           <div class="clear"></div>
                        </div> -->
                        
                        <div class="control_group">
                          <label class="control_label">Full Mug Bar Registration Amount<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="amount" id="amount" value="<?php echo $amount; ?>" class="m_wrap wid360"/>
                           </div>
                           <div class="clear"></div>
                        </div>
                        
                        <div class="control_group">
                          <label class="control_label">Managed Account Registration Amount<span class="req">*</span></label>
                           <div class="controls"><input type="text" name="managed_account_amount" id="managed_account_amount" value="<?php echo $managed_account_amount; ?>" class="m_wrap wid360"/>
                           </div>
                           <div class="clear"></div>
                        </div>
                      	
                      <input type="hidden" name="site_setting_id" id="site_setting_id" value="<?php echo $site_setting_id; ?>" />
				 		
						<div class="form_action">
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
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