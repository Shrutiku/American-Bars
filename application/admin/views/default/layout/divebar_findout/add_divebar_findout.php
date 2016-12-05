<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script><style type="text/css">
	#cke_83_label{display: none !important;}
</style>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
<script>

$(document).ready(function(){	
	
	
	/// end of editor code///////
	
	
	
	$("#usualValidate").validate({
		 ignore: [],
              debug: false,
		rules: {
			
			divebar_findout_title: {
				required: true,
			},
			
			divebar_findout_description:{
                         required: function() 
                        {
                         CKEDITOR.instances.divebar_findout_description.updateElement();
                        },

                         minlength:4
                   },
		  
			
		}
	});
	
});	
</script>
<script type="text/javascript">

    
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($divebar_findout_id==""){ echo 'Add Divebar Findout'; } else { echo 'Edit Divebar Findout'; }?></h3>
					
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
							<div class="content ">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_adddivebar_findout','class'=>'main');
				echo form_open_multipart('divebar_findout/add_divebar_findout',$attributes);
			  ?>
			  						<div class="control_group">
										<label class="control_label">Divebar Findout Title:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Divebar Findout Title...." class="m_wrap wid360" name="divebar_findout_title" id="divebar_findout_title" value="<?php echo $divebar_findout_title; ?>">
										</div>										
										<div class="clear"></div>
									</div>
			  	
			  						 <div class="control-group">
												<label class="control-label">Description <i style="color: #7D2A1C;">*</i></label>
												
												<?php // print_r($imageGallery);die;
												if($divebardesc!=''){
													$i=0;?>
													<input type="hidden" name="divebardesc" id="divebardesc" value="<?php echo count($divebardesc);?>" />
												<div class="" id="inner">
													<?php foreach($divebardesc as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->divebar_findout_topic_id ?>">
											<div class="controls"> 
                                            
                                             <textarea class="wid360  m_wrap required" name="divebar_findout_description[]" rows="4" cols="10" id="divebar_findout_description"><?php echo $im->divebar_findout_description?></textarea>
                                           
                                             
                                            </div><div class="clear"></div>
											<div class="controls">
											<div class="fileupload fileupload-new" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
											</div>
											<?php 	if($im->image!=''){if(file_exists(base_path().'upload/divebar_thumb/'.$im->image)) {?>
											<div class="controls">
											<div class="span1">
												<img height="70" width="70" src="<?php echo front_base_url().'upload/divebar_thumb/'.$im->image ?>" />
											</div>
											
											</div>
											<?php } } ?>
												
												<input type="hidden" name="pre_img[]" value="<?php echo $im->divebar_findout_description ?>" />
												<input type="hidden" name="pre_img1[]" value="<?php echo $im->image ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->divebar_findout_topic_id ?>" />
											<div class="span3">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row" name="add_row" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red margin-left-10 margin-top-10" onclick="removeImageDiveAjax('<?php echo $im->divebar_findout_topic_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
											</div>
											</div><div class="clear"></div>
											
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro" id="cntpro" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
													<input type="hidden" name="divebardesc" id="divebardesc" value="0" />
														<input type="hidden" name="cntpro" id="cntpro" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner">
											<div class="controls">
													<div class="controls"> 
                                            
                                             <textarea class="wid360  m_wrap required" name="divebar_findout_description[]" rows="4" cols="10" id="divebar_findout_description"></textarea>
                                           
                                             
                                            </div>
														<a href="javascript:void(0);" id="add_row" name="add_row" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
												<div class="clear"></div>
											</div><div class="clear"></div>
											
											<div class="controls">
												<div class="fileupload fileupload-new pull-left" data-provides="fileupload">
													<div class="input-append">
														<div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div>
															<span class="btn btn-file">
															<span class="fileupload-new">Select Image</span>
															<span class="fileupload-exists">Change</span><input   accept="image/*" type="file" class="default" name="photo_image[]" id="photo_image" /></span>
															
															<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
														
														<span for="profile_image" class="help-inline" style="display: none">This field is required.</span>
													</div>
												<input type="hidden" name="prev_photo_image" id="prev_photo_image" value="<?php echo $prev_photo_image; ?>" />
												<div class="clear"></div>
											</div><div class="clear"></div>
											
											
											
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
											<select class="m_wrap wid360" name="active" id="active"> 
												<option value="active" <?php echo ($active=='active')?'selected="selected"':''; ?> >Active</option>
												<option value="inactive" <?php echo ($active=='inactive')?'selected="selected"':''; ?> >Inactive</option>
											</select>
										</div>										
										<div class="clear"></div>
									</div>
								
							</div>	
						<input type="hidden" name="divebar_findout_id" id="divebar_findout_id" value="<?php echo $divebar_findout_id; ?>" />
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php
								if($divebar_findout_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_divebar_findout')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>divebar_findout/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>divebar_findout/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_divebar_findout')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>divebar_findout/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>divebar_findout/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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
		$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="controls"><textarea id="divebar_findout_description_'+cnt+'" cols="10" rows="4" name="divebar_findout_description[]" class="wid360  m_wrap required"></textarea></div><a href="javascript://" class="table_icon btn red margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div><div class="clear"></div><div class="fileupload fileupload-new pull-left" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload"></a></div></div></div><div class="clear"></div>');
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
	var r=confirm('Are you sure ,you want to delete this description ?');
	if(r==true)
	{
		$.ajax({
			url:'<?php echo site_url('divebar_findout/removeImageAjax') ?>/'+id,
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
