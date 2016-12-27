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
			term_title:'required',
			status : 'required'	,
			description:{
                         required: function() 
                        {
                           tinyMCE.get('description').getContent();
						   tinyMCE.triggerSave();
                        },

                         minlength:3
                   },
                   
           term_usage:{
                         required: function() 
                        {
                           tinyMCE.get('term_usage').getContent();
						   tinyMCE.triggerSave();
                        },

                         minlength:3
                   },		
		},		
	});	
});
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($term_id==""){ echo 'Add Dive Bar Term'; } else { echo 'Edit Dive Bar Term'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addterm','class'=>'main');
				echo form_open_multipart('term/add_term',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Term Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Term Title...." class="m_wrap wid360" name="term_title" id="term_title" value="<?php echo $term_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Description:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="description" id="description" placeholder="Description..." class="m_wrap span9 wid360" rows="20" cols="100">
												<?php  echo $description ;?>
											</textarea>
											<label for="description" generated="true" class="error" style="display: none;">This field is required.</label>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Term Usage:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="term_usage" id="term_usage" placeholder="Term Usage" class="m_wrap span9 wid360" rows="20" cols="100">
												<?php  echo $term_usage;?>
											</textarea>
												<label for="term_usage" generated="true" class="error" style="display: none;">This field is required.</label>
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
									
									
									
									
								
							
							<input type="hidden" name="term_id" id="term_id" value="<?php echo $term_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($term_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_term')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>term/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>term/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_term')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>term/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>term/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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