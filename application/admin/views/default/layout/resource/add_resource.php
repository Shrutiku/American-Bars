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
			resource_title:'required',
			resource_category:'required',
			status : 'required',
			resource_desc:{
                        required: function() 
                        {
                           tinyMCE.get('resource_desc').getContent();
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
					<h3 class="page_title"><?php if($resource_id==""){ echo 'Add Resource'; } else { echo 'Edit Resource'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addresource','class'=>'main');
				echo form_open_multipart('resource/add_resource',$attributes);
			  ?> 
			  						<div class="control_group">
										<label class="control_label">Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
												<input type="text" placeholder="Resource Title...." class="m_wrap wid360" name="resource_title" id="resource_title" value="<?php echo $resource_title; ?>">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>									
									
									<div class="control_group">
										<label class="control_label">Description:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="resource_desc" id="resource_desc" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error">
												<?php  echo $resource_desc ;?>
											</textarea>
											<label for="resource_desc" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Website Address :</label>
										<div class="controls">
												<input type="text" placeholder="Website Address...." class="m_wrap wid360" name="website" id="website" value="<?php echo $website; ?>">
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
									</div>	
									
									<div class="control_group">
										<label class="control_label">Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="resource_category" class="m_wrap wid360" name="resource_category">
												<option value="">-Select-</option>
												<option value="beer" <?php if($resource_category =='beer'){?> selected="selected" <?php } ?>> Beer</option>
												<option value="cocktails" <?php if($resource_category =='cocktails'){?> selected="selected" <?php } ?>> Cocktails</option>												
												<option value="education" <?php if($resource_category =='education'){?> selected="selected" <?php } ?>> Education</option>												
												<option value="health" <?php if($resource_category =='health'){?> selected="selected" <?php } ?>> Health </option>												
												<option value="hangovers" <?php if($resource_category =='hangovers'){?> selected="selected" <?php } ?>> History </option>												
												<option value="government" <?php if($resource_category =='government'){?> selected="selected" <?php } ?>> Government </option>												
												<option value="local_lists" <?php if($resource_category =='local_lists'){?> selected="selected" <?php } ?>> Local Lists </option>												
												<option value="science" <?php if($resource_category =='science'){?> selected="selected" <?php } ?>> Science </option>												
												<option value="other" <?php if($resource_category =='other'){?> selected="selected" <?php } ?>> Other </option>												
												<option value="recreation" <?php if($resource_category =='recreation'){?> selected="selected" <?php } ?>> Recreation </option>												
												<option value="video_links" <?php if($resource_category =='video_links'){?> selected="selected" <?php } ?>> Video Links </option>
												<option value="video_links" <?php if($resource_category =='bands_and_musicians'){?> selected="selected" <?php } ?>> Bands and Musicians </option>
												<option value="annual_events" <?php if($resource_category =='annual_events'){?> selected="selected" <?php } ?>> Annual Events</option>
												
											</select>
										</div>										
										<div class="clear"></div>
									</div>														
									
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="resource_meta_title" id="resource_meta_title" value="<?php echo $resource_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="resource_meta_keyword" id="resource_meta_keyword" value="<?php echo $resource_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="resource_meta_description" cols="10" rows="4" name="resource_meta_description" class="wid360 m_wrap"><?php echo $resource_meta_description; ?></textarea>
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
						
    					 <input type="hidden" name="resource_id" id="resource_id" value="<?php echo $resource_id; ?>" />
				 	     <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($resource_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_resource')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>resource/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>resource/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_resource')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>resource/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>resource/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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