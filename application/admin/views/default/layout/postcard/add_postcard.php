<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script>

$(document).ready(function(){	

	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	$("#usualValidate").validate({		
		rules: {
			postcard_title:'required',
			postcard_category:'required',
			status : 'required'		
		},		
	});	
});
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($postcard_id==""){ echo 'Add Postcard'; } else { echo 'Edit Postcard'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addpostcard','class'=>'main');
				echo form_open_multipart('postcard/add_postcard',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Postcard Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Postcard Title...." class="m_wrap wid360" name="postcard_title" id="postcard_title" value="<?php echo $postcard_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Post Message:</label>
										<div class="controls">
											<textarea name="post_message" id="post_message" placeholder="Post Message..." class="m_wrap span9 wid360" rows="20" cols="100" data-error-container="#editor1_error">
												<?php  echo $post_message ;?>
											</textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Postcard Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="postcard_category" class="m_wrap wid360" name="postcard_category">
												<option value="">-Select-</option>
												<option value="latest_postcard_and_event" <?php if($postcard_category =='latest_postcard_and_event'){?> selected="selected" <?php } ?>> Latest Postcard & Events </option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>	
									
									<div class="control_group">
										<label class="control_label">Card Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<select id="card_type" class="m_wrap wid360" name="card_type">
												<option value="">-Select-</option>
												<option value="latest_postcard_and_event" <?php //if($card_type =='latest_postcard_and_event'){?> selected="selected" <?php //} ?>> Latest Postcard & Events </option>
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
									
									
									
									
								
							
						<input type="hidden" name="postcard_id" id="postcard_id" value="<?php echo $postcard_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						<input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						<input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						<input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($postcard_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_postcard')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>postcard/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>postcard/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_postcard')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>postcard/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>postcard/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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