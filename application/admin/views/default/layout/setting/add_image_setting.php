<script>$(document).ready(function(){
	$("#imagesetting").validate({
		rules:{
			user_width:'required',
			user_height:'required',
			image_width:'required',
			image_height:'required',
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
							Image Settings
							
						</h3>
						
					</div>
		</div>

	<?php  
		if($error != "") {
			
			if($error == "update") {?>
			<div class="success_msg">
					
					<P><?php echo IMAGE_SETTING_UPDATE;?></P>
			</div>		

			<?php }
		
			if($error != "update"){?>	
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
									<span class="hidden-480">Image Setting</span>
								</div>
							</div>
                            <div class="portlet-body form">
								<div class="tabbable portlet-tabs">
									
                       <div class="tab-content" style="margin:0 !important">
										<div id="portlet_tab1" class="tab-pane active">
											<!-- BEGIN FORM-->
			<?php
				$attributes = array('id'=>'imagesetting','name'=>'frm_addimagesetting','class'=>'form-horizontal');
				echo form_open('image_setting/add_image_setting',$attributes);
			  ?>
                <div class="control-group">
													<label class="control-label">User Width<span class="req">*</span></label>
                            <div class="controls">
							   <input type="text" name="user_width" id="user_width" value="<?php echo $user_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>

                 
                        <div class="control-group">
													<label class="control-label">User Height<span class="req">*</span></label>
                             <div class="controls"> 
							<input type="text" name="user_height" id="user_height"value="<?php echo $user_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>

                        <div class="control-group">
													<label class="control-label">Image Width<span class="req">*</span></label>
                           <div class="controls">
							<input type="text" name="image_width" id="image_width" value="<?php echo $image_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Image Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="image_height" id="image_height" value="<?php echo $image_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Beer Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="beer_width" id="beer_width" value="<?php echo $beer_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Beer Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="beer_height" id="beer_height" value="<?php echo $beer_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Event Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="event_width" id="event_width" value="<?php echo $event_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Event Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="event_height" id="event_height" value="<?php echo $event_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Photo Gallery Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="photo_gallery_width" id="photo_gallery_width" value="<?php echo $photo_gallery_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Photo Gallery Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="photo_gallery_height" id="photo_gallery_height" value="<?php echo $photo_gallery_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Cocktail Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="cocktail_width" id="cocktail_width" value="<?php echo $cocktail_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Cocktail Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="cocktail_height" id="cocktail_height" value="<?php echo $cocktail_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Banner Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="banner_width" id="banner_width" value="<?php echo $banner_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Banner Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="banner_height" id="banner_height" value="<?php echo $banner_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Comment Image Width<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="comment_image_width" id="comment_image_width" value="<?php echo $comment_image_width; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<div class="control-group">
							<label class="control-label">Comment Image Height<span class="req">*</span></label>
                            <div class="controls">
							<input type="text" name="comment_image_height" id="comment_image_height" value="<?php echo $comment_image_height; ?>" class="required m_wrap wid360"/>
							</div>
							<div class="clear"></div>
                        </div>
						
						<input type="hidden" name="image_setting_id" id="image_setting_id" value="<?php echo $image_setting_id; ?>" />
				 		
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