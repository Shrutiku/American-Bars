<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<script>

$(document).ready(function(){	
$('#start_date').datetimepicker({
	mask:'9999/19/39 29:59'
});
$('#end_date').datetimepicker({
	mask:'9999/19/39 29:59'
});
$("#usualValidate").validate({
		
		rules: {
			title:'required',
			status:'required',
			'photo_image[]':{
						  required: function() { return $("#image_count").val() == 0 ? true:false; },
						 accept: "jpg|jpeg|png|bmp"
						},
		},		
	});	
});	
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($bar_gallery_id==""){ echo 'Add Album'; } else { echo 'Edit Album'; }?></h3>
					
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
							<div class="caption "></div>
							<div class="fl_right" style="margin-top: -30px;">
								<a class="btn black  mar_top15 pad_5" href="<?php echo site_url('album/list_album/'.$limit.'/'.$bar_id)?>"><i class="icon-circle-arrow-left"></i> Back</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addgallery','class'=>'main');
				echo form_open_multipart('album/add_album/'.$bar_gallery_id,$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Gallery Title...." class="m_wrap wid360" name="title" id="title" value="<?php echo @$title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control-group">
												<label class="control-label">Album Images <i style="color: #7D2A1C;">*</i></label>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery!=''){
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($imageGallery as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->bar_image_id ?>">
											<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
											
											
											<div class="span1">
												<input type="hidden" name="pre_img[]" value="<?php echo $im->bar_image_name ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->bar_image_id ?>" />
												<img src="<?php echo front_base_url().'upload/bar_gallery_thumb/'.$im->bar_image_name ?>" />
											</div><div class="clear"></div>
											
											<div class="control_group">
										<label class="control_label">Image Title:</label>
										<div class="controls">
											<input type="text" placeholder="Image Title...." class="m_wrap wid360" name="image_title[]" id="image_title[]" value="<?php echo @$im->image_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
											<div class="span3">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row" name="add_row" class="">Add More</a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red" onclick="removeImageDiveAjax('<?php echo $im->bar_image_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
												
												
											</div>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
													<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner">
											<div class="controls">
												<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input  accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="<?php echo $prev_photo_image; ?>" />
												<div class="clear"></div>
											</div><div class="clear"></div>
											
											
											<div class="control_group">
										<label class="control_label">Image Title:</label>
										<div class="controls">
											<input type="text" placeholder="Image Title...." class="m_wrap wid360" name="image_title[]" id="image_title[]" value="<?php //echo @$title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
											<a href="javascript:void(0);" id="add_row" name="add_row" class="">Add More</a>
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div>
									
									<div class="clear"></div>
												
									
									
									<div class="control_group">
										<label class="control_label">Status:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<select class="m_wrap wid360" name="status" id="status"> 
												<option value="">--Select--</option>
												<option value="active" <?php echo ($status=='Active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($status=='Inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
									
									
									
					
						 <input type="hidden" name="bar_gallery_id" id="bar_gallery_id" value="<?php echo $bar_gallery_id; ?>" />
						 <input type="hidden" name="bar_id" id="bar_id" value="<?php echo $bar_id; ?>" />
				 	     <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($bar_gallery_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_album')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar_gallery/<?php echo $redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar_gallery/<?php echo $redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_album')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar_gallery/<?php echo $redirect_page.'/'.$limit.'/'.$bar_id.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>bar_gallery/<?php echo $redirect_page.'/'.$limit.'/'.$bar_id.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
		$('#inner').append('<div id="img_'+cnt+'" style="display:none;"><div class="row-fluid  margin-top-10" ><div class=""><div class="fileupload fileupload-new" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div></div></div><div class="clear"></div><div class="control_group"><label class="control_label">Image Title:</label><div class="controls"><input type="text" placeholder="Image Title...." class="m_wrap wid360" name="image_title[]" id="image_title[]" value=""></div><div class="clear"></div></div><a href="javascript://" class="table_icon btn red" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div><div class="clear"></div></div>');
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
			url:'<?php echo site_url('bar_gallery/removeImageAjax') ?>/'+id,
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
