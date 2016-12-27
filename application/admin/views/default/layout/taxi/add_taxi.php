<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script>

$(document).ready(function(){	

	


	
	$("#usualValidate").validate({
		
		rules: {
			tax_company_name:'required',
			tax_cmpn_address:'required',
			city:'required',
			state:'required',
			cmpn_zipcode:'required',
			file_up: {
				  extension: "jpg|jpeg|gif|png"
			},
			taxi_company_website: {
				  url: true,
			},
			//file_up2: {
			//	  extension: "jpg|jpeg|gif|png"
			//},
			status : 'required',
			//phone_number: {
			//	required: true,
			//	digits: true
			//},
			
			
		},
		
	});
	
	
	

	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($taxi_id==""){ echo 'Add Taxi'; } else { echo 'Edit Taxi'; }?></h3>
					
				</div>
				<div class="row_fluid"> 
				<?php  
					if($error != "") {
						
						if($error == 'insert') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($error != "insert"){	
							echo '<div class="error_red">'.$error.'</div>';	
						}
					}
				?>		
					<div class="portlet blue">
						<div class="portlet-title">
							<div class="caption"></div>
						</div>
						<div class="portlet-body form">
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addtaxi','class'=>'main');
				echo form_open_multipart('taxi/add_taxi',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Company Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" maxlength="40" placeholder="Company Name...." class="m_wrap wid360" name="tax_company_name" id="tax_company_name" value="<?php echo $tax_company_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									<div class="control_group">
										<label class="control_label">Company Address : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="tax_cmpn_address"  id="tax_cmpn_address" placeholder="Address..." class="m_wrap wid360"><?php echo $tax_cmpn_address; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">State : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input name="state"  id="state" placeholder="state..." class="m_wrap wid360" value="<?php echo $state; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">City : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input name="city"  id="city" placeholder="city..." class="m_wrap wid360" value="<?php echo $city; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Zipcode : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input name="cmpn_zipcode"  id="cmpn_zipcode" placeholder="Zipcode..." class="m_wrap wid360" value="<?php echo $cmpn_zipcode; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Company Phone Number:</label>
										<div class="controls">
											<input type="text" maxlength="40" placeholder="Phone Number...." class="m_wrap wid360" name="texi_company_phone_number" id="texi_company_phone_number" value="<?php echo $texi_company_phone_number; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Company Website:</label>
										<div class="controls">
											<input type="text" maxlength="40" placeholder="Taxi Company Website...." class="m_wrap wid360" name="taxi_company_website" id="taxi_company_website" value="<?php echo $taxi_company_website; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Company Description :</label>
										<div class="controls">
											<textarea name="reciew"  id="reciew" placeholder="Description..." class="m_wrap wid360"><?php echo $reciew; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									<?php /*?><div class="control_group">
										<label class="control_label">Image :</label>
										<div class="controls wid400">
											<input type="file" name="file_up" id="file_up" />
											<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $image ?>" />
										</div>
										<div class="controls wid400">
											<?php if($image!='' && file_exists(base_path().'upload/taxi_owner_thumb/'.$image)){?>
												<img src="<?php echo front_base_url().'upload/taxi_owner_thumb/'.$image ?>"  width="50"  height="50"/>
											<?php } ?>
										</div>										
										<div class="clear"></div>
									</div><?php */?>
									
									<div class="control-group">
											<label class="control-label"> Image</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input accept="image/*" type="file" class="default" name="file_up" id="file_up" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $image ?>" />
												</div>
											<div class="controls"> 
										<?php if(($image!='' && file_exists(base_path().'upload/user_thumb/'.$image))){ ?>
											<!-- <br /><br />
											<div class="control-group">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative">
														<img src="<?php echo front_base_url().'upload/user_thumb/'.$image ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>taxi_owner/removeimage/<?php echo $taxi_id.'/'.$image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a> -->														
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										</div>
										<div class="clear"></div>
									
										</div>
									</div>
									
									<!-- <div class="control_group">
										<label class="control_label">taxi_owner Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="taxi_owner_type" id="taxi_owner_type"> 
												<option value="">--Select--</option>
												<option value="taxi_owner" <?php echo ($taxi_owner_type=='taxi_owner')?'selected="selected"':''; ?>>taxi_owner</option>
												<option value="grinder" <?php echo ($taxi_owner_type=='grinder')?'selected="selected"':''; ?>>Grinder</option>
												<option value="poker_expert" <?php echo ($taxi_owner_type=='poker_expert')?'selected="selected"':''; ?>>Poker Expert</option>
												<option value="poker_coach" <?php echo ($taxi_owner_type=='poker_coach')?'selected="selected"':''; ?>>Poker Coach</option>
												<option value="poker_shark" <?php echo ($taxi_owner_type=='poker_shark')?'selected="selected"':''; ?>>Poker Shark</option>
												
											</select>
										</div>										
										<div class="clear"></div>
									</div> -->
										
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="taxi_meta_title" id="taxi_meta_title" value="<?php echo $taxi_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="taxi_meta_keyword" id="taxi_meta_keyword" value="<?php echo $taxi_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="taxi_meta_description" cols="10" rows="4" name="taxi_meta_description" class="wid360 m_wrap"><?php echo $taxi_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
								<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="active" id="active"> 
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
								
							
							<input type="hidden" name="taxi_id" id="taxi_id" value="<?php echo $taxi_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($taxi_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_taxi')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>taxi/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>taxi/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_taxi')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>taxi/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>taxi/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
					<?php } ?>
					
					
					
					</form>		
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>