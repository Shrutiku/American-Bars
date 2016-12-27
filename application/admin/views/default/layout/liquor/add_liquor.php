<style>
	#cke_liquor_description
	{
		width:600px;
	}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>

<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script>
$('#usualValidate').on('submit', function() {
                    CKEDITOR.instances['liquor_description'].updateElement();
            });
$(document).ready(function(){	
$('#start_date').datetimepicker({
	mask:'9999/19/39 29:59'
});
$('#end_date').datetimepicker({
	mask:'9999/19/39 29:59'
});
$("#usualValidate").validate({
		
		rules: {
			liquor_title:'required',
			//type:'required',
			//proof:'required',
			//address:'required',
			//producer:'required',
			//country:'required',
			// liquor_meta_title : 'required',
			// liquor_meta_keyword : 'required',
			// liquor_meta_description : 'required',
			bar_logo_file: {
				  extension: "jpg|jpeg|gif|png",
			}
			
		},
		
	});
	
});	
	


</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($liquor_id==""){ echo 'Add liquor'; } else { echo 'Edit liquor'; }?></h3>
					
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addliquor','class'=>'main');
				echo form_open_multipart('liquor/add_liquor/'.$bars_id,$attributes);
			  ?>
			
			  <input type="hidden" name="liquor_slug" id="liquor_slug" value="<?php echo @$liquor_slug; ?>" />
			  						<div class="control_group">
										<label class="control_label">Liquor Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input maxlength="100" type="text" placeholder="liquor Title...." class="m_wrap wid360" name="liquor_title" id="liquor_title" value="<?php echo $liquor_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Description:</label>
										<div class="controls">
											<textarea name="liquor_description" id="liquor_description" placeholder="Liquor Description" class="m_wrap span9 wid360 ckeditor" rows="20" cols="100" data-error-container="#editor1_error"><?php  echo $liquor_description ;?></textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
										<label for="liquor_description" generated="true" style="display: none;" class="error">This field is required.</label>
							  </div>
									
									<div class="control_group">
										<label class="control_label">Type: </label>
										<div class="controls">
											<input type="text" placeholder="Type...." class="m_wrap wid360" name="type" id="type" value="<?php echo $type; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Proof: </label>
										<div class="controls">
											<input type="text" placeholder="Proof...." class="m_wrap wid360" name="proof" id="proof" value="<?php echo $proof; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
									<div class="control_group">
										<label class="control_label">Producer:</label>
										<div class="controls">
											<input type="text" placeholder="Producer...." class="m_wrap wid360" name="producer" id="producer" value="<?php echo $producer; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Size: </label>
										<div class="controls">
											<input type="text" placeholder="Size...." class="m_wrap wid360" name="size" id="size" value="<?php echo $size; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Country:</label>
										<div class="controls">
											<input type="text" placeholder="Country...." class="m_wrap wid360" name="country" id="country" value="<?php echo $country; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
								<div class="control-group">
											<label class="control-label">Liquor Image:</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="bar_logo_file" id="bar_logo_file" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>		<div class="clearfix"></div>		
													</div><div class="clear"></div>
												<input type="hidden" name="prev_bar_logo" id="prev_bar_logo" value="<?php echo $prev_bar_logo ?>" />
												<label for="bar_logo_file" generated="true" class="error" style="display: none;">This field is required.</label>												
												</div><!-- <div class="clear"></div> -->
											<!-- </div>  -->
											<div class="controls">
										<?php if(($prev_bar_logo!='' && file_exists(base_path().'upload/liquor_orig/'.$prev_bar_logo))){ ?>
											<!-- <div class="control-group">
												<label class="control-label"></label> -->
												<div class="controls">
													<div class="span2 position-relative margin-left-10">
														<img src="<?php echo front_base_url().'upload/liquor_orig/'.$prev_bar_logo ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>liquor/removeimage/<?php echo $liquor_id.'/'.$prev_bar_logo.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
													</div>
												</div>
											<!-- </div> -->
										<?php } ?>
									</div>
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
												<input type="hidden" name="prev_liquor_image1" id="prev_liquor_image1" value="<?php echo $prev_liquor_image1; ?>" />
												</div>
										<?php if(($prev_liquor_image1!='' && file_exists(base_path().'upload/liquor_thumb/'.$prev_liquor_image1))){ ?>
											<!-- <div class="control-group" style="clear:both"> -->
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2 position-relative margin-left-10">
														<img src="<?php echo front_base_url().'upload/liquor_thumb/'.$prev_liquor_image1 ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>liquor/removeimage1/<?php echo $liquor_id.'/'.$prev_liquor_image1.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove"><i class="comon_icon remove_icon"></i></a>
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
									
									<div class="control_group">
										<label class="control_label">Meta Title: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Title" class="m_wrap wid360" name="liquor_meta_title" id="liquor_meta_title" value="<?php echo $liquor_meta_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Keyword: </label>
										<div class="controls">
											<input type="text" placeholder="Meta Keyword" class="m_wrap wid360" name="liquor_meta_keyword" id="liquor_meta_keyword" value="<?php echo $liquor_meta_keyword; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Meta Description: </label>
										<div class="controls">
											<textarea id="liquor_meta_description" cols="10" rows="4" name="liquor_meta_description" class="wid360 m_wrap"><?php echo $liquor_meta_description; ?></textarea>
										</div>										
										<div class="clear"></div>
									</div>
									
									<!-- <div class="control-group">
											<label class="control-label">liquor Image</label>
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input type="file" accept="image/*" class="default" name="liquor_image" id="liquor_image" /></span>
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="prev_liquor_image" id="prev_liquor_image" value="<?php echo $prev_liquor_image ?>" />
												</div>
											</div> 
										<?php if(($prev_liquor_image!='' && file_exists(base_path().'upload/liquor_thumb/'.$prev_liquor_image))){ ?>
											<div class="control-group" style="clear:both">
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2">
														<img src="<?php echo  front_base_url().'upload/liquor_thumb/'.$prev_liquor_image; ?>" width="50"  height="50" />
														<a href="<?php echo base_url(); ?>liquor/removeimage/<?php echo $liquor_id.'/'.$prev_liquor_image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove">Remove image</a>
													</div>
												</div>
											</div>
										<?php } ?> -->
										<div class="clear"></div>

									
									
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" required id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="pending" <?php echo ($status=='pending')?'selected="selected"':''; ?> >Pending</option>
												<option value="inactive" <?php echo ($status=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>											
										</div>			
										
										<div class="clear"></div>
									</div>								
								
							
						 <input type="hidden" name="liquor_id" id="liquor_id" value="<?php echo $liquor_id; ?>" />
						 <input type="hidden" name="bars_id" id="bars_id" value="<?php echo $bars_id; ?>" />
						 
				 	     <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 <input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($liquor_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_liquor')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>liquor/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>liquor/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_liquor')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>liquor/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>liquor/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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

<script>
	$('#add_row').click(function(){
	  //if(parseInt($('#cntpro').val())<7){
		//	$('#cantADD').hide();
		var cnt=parseInt($('#cntpro').val())+1;
		if($('#cntpro').val() =='NaN')
		{
		    $('#cntpro').val('1');
		    cnt = 1;
		}
		$('#cntpro').val(cnt)
		$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="fileupload fileupload-new" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div><a href="javascript://" class="table_icon btn red" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div>');
		$('#img_'+cnt).slideDown();
		//}else{
		//$('#cantADD').show();	
		//}
			
		});
function removeImageDive(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro').val())-1;
	(parseInt(cnt)<7)?$('#cantADD').hide():'';
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
function removeImageDiveAjax(id)
{
     //   alert("removeImageDiveAjax");
      //  alert(id);
	var r=confirm('Are you sure ,you want to delete this image ?');
	if(r==true)
	{
		$.ajax({
			url:'<?php echo site_url('liquor/removeImageAjax') ?>/'+id,
			success:function(res){
			var cnt=parseInt($('#cnt').val())-1;
           // alert(cnt);
			$('#cntpro').val(cnt);
			$('#pi_'+id).slideUp('normal',function(){	$(this).remove(); });	 
			}
		});	
	}else{
		return false;
	}
	
}	
</script>
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