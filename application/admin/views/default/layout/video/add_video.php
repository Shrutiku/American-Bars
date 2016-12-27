<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script>

$(document).ready(function(){
	$("#usualValidate").validate({
		
		rules: {
			video_title:'required',
			video_desc:'required',
			video_category_id:'required',
			video_price:'required',
			video_type:'required',
			pre_file_up_video:'required',
			
			pre_video_preview:'required',
			status : 'required'
			
			
		},
		
	});
	});
</script>		
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($video_id==""){ echo 'Add Video'; } else { echo 'Edit Video'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addvideo','class'=>'main');
				echo form_open_multipart('video/add_video',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Video Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Video Title...." class="m_wrap wid360" name="video_title" id="video_title" value="<?php echo $video_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Video Description :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="video_desc"  id="video_desc" placeholder="Video Description..." class="m_wrap wid360"><?php echo $video_desc; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Category:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="video_category_id" id="video_category_id"> 
												<option value="">--Select--</option>
												<?php if($category){
													foreach ($category as $cat) {
												?>
													<option value="<?php echo $cat->category_id; ?>" <?php echo ($cat->category_id==$video_category_id)?'selected="selected"':''; ?> ><?php echo $cat->category_name; ?></option>
												<?php		
													}
												} ?>
												
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Video Price :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Video Price...." class="m_wrap wid360" name="video_price" id="video_price" autocomplete="off" value="<?php echo $video_price; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Video Type:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="video_type" id="video_type"> 
												<option value="">--Select--</option>
												<option value="free" <?php echo ($video_type=='free')?'selected="selected"':''; ?> >Free</option>
												<option value="paid" <?php echo ($video_type=='paid')?'selected="selected"':''; ?> >Paid</option>
												<!--<option value="membership_plan" <?php echo ($video_type=='membership_plan')?'selected="selected"':''; ?> > Membership Plan</option>-->
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Video Image :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="file_up" id="file_up" />
											<input type="hidden" name="pre_video_image" id="pre_video_image" value="<?php echo $image ?>" />
										</div>
										<div class="controls wid400">
											<?php if($image!='' && file_exists(base_path().'upload/video_image/'.$image)){?>
												<img src="<?php echo front_base_url().'upload/video_image/'.$image ?>"  width="50"  height="50"/>
											<?php } ?>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Video :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="file_up_video" id="file_up_video" />
											<input type="hidden" name="pre_file_up_video" id="pre_file_up_video" value="<?php echo $video_file_name ?>" />
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Video Preview :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls wid400">
											<input type="file" name="video_preview" id="video_preview" />
											<input type="hidden" name="pre_video_preview" id="pre_video_preview" value="<?php echo $video_preview ?>" />
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
								
							</div>	
							<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($video_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_video')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>video/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>video/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_video')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>video/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>video/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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