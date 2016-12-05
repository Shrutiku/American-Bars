<style>
	#cke_beer_desc
	{
		width:400px;
	}
</style><link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/js/tiny_mce/tiny_mce.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo front_base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
<script>

 



$(document).ready(function(){	
   $("#beer_phone").inputmask("(999) 999-9999");
	$('#usualValidate').on('submit', function() {
                    CKEDITOR.instances['beer_desc'].updateElement();
            });
	
	$("#usualValidate").validate({
		ignore: false,
	             debug: false,
		rules: {
			beer_name:'required',
			beer_country:'required',
			beer_zipcode:{number:true},
			website:{url:true},
			//beer_type:'required',
			//producer:'required',
			//abv:'required',
			//city_produced:'required',
			status : 'required',
			//beer_state : 'required',
			file_up1: {
				  extension: "jpg|jpeg|gif|png",
			},
			
			video_link: {
				 url:true,
			},
			file_up: {
				  extension: "jpg|jpeg|gif|png"
			}
			////beer_desc:{
                     //  required:true,
           // }
		},		
	});	
});	
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($beer_id==""){ echo 'Add Beer'; } else { echo 'Edit Beer'; }?></h3>
					
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
											 <div class="caption fl_left">&nbsp;</div> 
											
											<div class="fl_right">
																								</div><div class="clear"></div>
											<!-- <div class="tools">
												<a class="collapse" href="javascript:;"></a>
												<a class="config" data-toggle="modal" href="#portlet-config"></a>
												<a class="reload" href="javascript:;"></a>
												<a class="remove" href="javascript:;"></a>
											</div> -->
										</div>
						<div class="portlet-body form">
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addbeer','class'=>'main');
				echo form_open_multipart('beer/add_beer/'.$bars_id,$attributes);
			  ?>
			
			  <input type="hidden" name="beer_slug" id="beer_slug" value="<?php echo @$beer_slug; ?>" />
			  						<div class="control_group">
										<label class="control_label">Beer Name:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input maxlength="100" type="text" placeholder="Beer Name...." class="m_wrap wid360" name="beer_name" id="beer_name" value="<?php echo $beer_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Description:</label>
										<div class="controls">
											<textarea name="beer_desc" id="beer_desc" placeholder="Description..." class="m_wrap span9 wid360 ckeditor" rows="20" cols="100" >
												<?php  echo $beer_desc ;?>
											</textarea>
											<label for="beer_desc" generated="true" class="error" style="display: none;">This field is required.</label>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Type: </label>
										<div class="controls">
											<input type="text" placeholder="Beer Type...." class="m_wrap wid360" name="beer_type" id="beer_type" value="<?php echo $beer_type; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">ABV :</label>
										<div class="controls" >
											<input type="text" placeholder="ABV...." class="m_wrap wid360" name="abv" id="abv" autocomplete="off" value="<?php echo $abv; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Brewed By :</label>
										<div class="controls">
											<input type="text" placeholder="Brewed By...." class="m_wrap wid360" name="producer" id="producer" autocomplete="off" value="<?php echo $producer; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Address :</label>
										<div class="controls">
											
											<input type="text" placeholder="Address...." class="m_wrap wid360" name="beer_address" id="beer_address" autocomplete="off" value="<?php echo $beer_address; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
							  
									<div class="control_group">
										<label class="control_label">City Produced :</label>
										<div class="controls">
											
											<input type="text" placeholder="City Produced...." class="m_wrap wid360" name="city_produced" id="city_produced" autocomplete="off" value="<?php echo $city_produced; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">State :</label>
										<div class="controls">
											
											<input type="text" placeholder="State...." class="m_wrap wid360" name="beer_state" id="beer_state" autocomplete="off" value="<?php echo $beer_state; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Country : <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											
											<input type="text" placeholder="Country...." class="m_wrap wid360" name="beer_country" id="beer_country" autocomplete="off" value="<?php echo $beer_country; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  <div class="control_group">
										<label class="control_label">Postal Code :</label>
										<div class="controls">
											
											<input type="text" placeholder="Postal Code...." class="m_wrap wid360" name="beer_zipcode" id="beer_zipcode" autocomplete="off" value="<?php echo $beer_zipcode; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
							  
							  
							   <div class="control_group">
										<label class="control_label">Phone :</label>
										<div class="controls">
											
											<input type="text" placeholder="Phone...." class="m_wrap wid360" name="beer_phone" id="beer_phone" autocomplete="off" value="<?php echo $beer_phone; ?>">
										</div>										
										<div class="clear"></div>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Website :</label>
										<div class="controls">
											
											<input type="text" placeholder="Website...." class="m_wrap wid360" name="beer_website" id="beer_website" autocomplete="off" value="<?php echo $beer_website; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control-group">
											<label class="control-label">Beer Image:</label>
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
												<input type="hidden" name="prev_beer_image" id="prev_beer_image" value="<?php echo $prev_beer_image; ?>" />
									  </div>
										<?php if(($prev_beer_image!='' && file_exists(base_path().'upload/beer_thumb/'.$prev_beer_image))){ ?>
											<!-- <div class="control-group" style="clear:both">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative margin-left-10">
														<img src="<?php echo front_base_url().'upload/beer_thumb/'.$prev_beer_image ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>beer/removeimage/<?php echo $beer_id.'/'.$prev_beer_image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										<div class="clear"></div>
									</div>
									
									<div class="control_group" id="upload_video_type" >
													<label class="control_label">Upload Type :</label>
													<div class="controls">
														<label class="radio">
															<input type="radio" name="upload_type"  accept="image/*" id="image" value="image" <?php echo $upload_type=='image'?'checked="checked"':''; ?> />Image 
														</label>
														<label class="radio">
															<input type="radio" name="upload_type" id="video" value="video" <?php echo $upload_type=='video'?'checked="checked"':''; ?> />Video
														</label>
													</div>
													<div class="clear"></div>
													<label style="display: none;" for="upload_type" generated="true" class="error">This field is required.</label>
								   </div>
								   
								   
								  <div class="control-group" style="display: <?php if($upload_type=='image'){?>block<?php } else {?>none<?php } ?>;" id="see_image">
											<label class="control-label">Image:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="file_up1" id="file_up1" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="prev_beer_image1" id="prev_beer_image1" value="<?php echo $prev_beer_image1; ?>" />
												</div>
										<?php if(($prev_beer_image1!='' && file_exists(base_path().'upload/beer_thumb/'.$prev_beer_image1))){ ?>
											<!-- <div class="control-group" style="clear:both"> -->
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2 position-relative margin-left-10">
														<img src="<?php echo front_base_url().'upload/beer_thumb/'.$prev_beer_image1 ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>beer/removeimage1/<?php echo $beer_id.'/'.$prev_beer_image1.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
										<div class="clear"></div>
									</div> 
									
									<div class="control_group" style="display: <?php if($upload_type=='video'){?>block<?php } else {?>none<?php } ?>;" id="see_video">
										<label class="control_label">Video Link :</label>
										<div class="controls">
											<input type="text" placeholder="Link" class="m_wrap wid360" name="video_link" id="video_link" value="<?php echo $video_link; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<?php /*?><div class="control_group">
										<label class="control_label">Image :</label>
										<div class="controls wid400">
											<input type="file" name="file_up" id="file_up" />
											<input type="hidden" name="prev_beer_image" id="prev_beer_image" value="<?php echo $prev_beer_image ?>" />
										</div>
										<div class="controls wid400">
											<?php if($prev_beer_image!='' && file_exists(base_path().'upload/beer_thumb/'.$prev_beer_image)){?>
												<img src="<?php echo front_base_url().'upload/beer_thumb/'.$prev_beer_image ?>"  width="50"  height="50"/>
											<?php } ?>
										</div>										
										<div class="clear"></div>
									</div><?php */?>
									
									
									
									
									
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="beer_meta_title" id="beer_meta_title" value="<?php echo $beer_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="beer_meta_keyword" id="beer_meta_keyword" value="<?php echo $beer_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="beer_meta_description" cols="10" rows="4" name="beer_meta_description" class="wid360 m_wrap"><?php echo $beer_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="pending" <?php echo ($status=='pending')?'selected="selected"':''; ?> >Pending</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
									
								
							 <input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
							<input type="hidden" name="beer_id" id="beer_id" value="<?php echo $beer_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($beer_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_beer')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>beer/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>beer/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_beer')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>beer/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>beer/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
					<?php } ?>
					
					
					
					
							</div>
							</form>		
						</div>
						
					</div>
				</div>
			</div>
		</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	
		$("input[name=upload_type]").change(function(){
			
			if($(this).val()=='image')
			{
				//$("#see_hide").css("display", "none");
				$("#see_image").slideDown();
				$("#see_video").slideUp();
				//$("#imagedisp").css("display", "none");
					
			}
			else
			{
				$("#see_video").slideDown();
				$("#see_image").slideUp();
				// $("#upload_video_type").slideUp('normal',function(){$("#upload_image_type").slideDown('normal')});
// 				
// 				
					// $("input[name=video_type]").attr('checked', false);
					// $("#custom_url").val('');
					// $("#prev_upload_video").val('');
					// $("#video_upload").css("display", "none");
					// $("#see_hide").css("display", "block");
					// $("#custom_type").css("display", "none");
				
				
			}
			
});
});
</script>