<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script>

$(document).ready(function(){	

	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});


	
	$("#usualValidate").validate({
		ignore: [],
              debug: false,
		rules: {
			job_title:'required',
			job_category:'required',
			status : 'required'	,
			
			job_desc:{
                        required: function() 
                        {
                           tinyMCE.get('job_desc').getContent();
						   tinyMCE.triggerSave();
                        },
                        minlength:3
                   }		
		},
		
	});
	
	
	

	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($job_id==""){ echo 'Add Jobs'; } else { echo 'Edit Jobs'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addjob','class'=>'main');
				echo form_open_multipart('job/add_job',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Jobs Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Jobs Title...." class="m_wrap wid360" name="job_title" id="job_title" value="<?php echo $job_title; ?>">
										</div>				
																
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Description:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="job_desc" id="job_desc" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error"><?php  echo $job_desc ;?></textarea>
										<label for="job_desc" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Jobs Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="job_category" class="m_wrap wid360" name="job_category">
												<option value="">-Select-</option>
												<option value="bands_and_music" <?php if($job_category =='bands_and_music'){?> selected="selected" <?php } ?>> Bands and Music </option>
												<option value="equipment" <?php if($job_category =='equipment'){?> selected="selected" <?php } ?>> Equipment </option>
												<option value="employment" <?php if($job_category =='employment'){?> selected="selected" <?php } ?>> Employment </option>
												<option value="entertainment" <?php if($job_category =='entertainment'){?> selected="selected" <?php } ?>> Entertainment </option>
												<option value="party_planners" <?php if($job_category =='party_planners'){?> selected="selected" <?php } ?>> Party Planners </option>
												<option value="bars" <?php if($job_category =='bars'){?> selected="selected" <?php } ?>> Bars </option>
												<option value="late_night_bars" <?php if($job_category =='late_night_bars'){?> selected="selected" <?php } ?>> Late Night Bars </option>
												<option value="distribution_companies" <?php if($job_category =='distribution_companies'){?> selected="selected" <?php } ?>> Distribution Companies </option>
												<option value="advertising" <?php if($job_category =='employment'){?> selected="selected" <?php } ?>> Advertising </option>
												<option value="website_design" <?php if($job_category =='website_design'){?> selected="selected" <?php } ?>> Website Design </option>
												<option value="events" <?php if($job_category =='events'){?> selected="selected" <?php } ?>> Events </option>
												<option value="real_estate" <?php if($job_category =='real_estate'){?> selected="selected" <?php } ?>> Real Estate </option>
												<option value="business_opportunities" <?php if($job_category =='business_opportunities'){?> selected="selected" <?php } ?>> Business Opportunities </option>
												<option value="general" <?php if($job_category =='general'){?> selected="selected" <?php } ?>> General </option>
												<option value="merchandising" <?php if($job_category =='merchandising'){?> selected="selected" <?php } ?>> Merchandising </option>									
											</select>
										</div>										
										<div class="clear"></div>
									</div>									
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
								
							
							<input type="hidden" name="job_id" id="job_id" value="<?php echo $job_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($job_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_job')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>job/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>job/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_job')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>job/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>job/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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