<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url().getThemeName(); ?>/js/ui/jquery-ui.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
  	<script type="text/javascript" src="<?php echo front_base_url().getThemeName(); ?>/assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js" ></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName(); ?>/assets/plugins/chosen-bootstrap/chosen/chosen.css" />
	<script type="text/javascript" src="<?php echo base_url()?>/ckeditor/ckeditor.js"></script>
	<!-- END PAGE LEVEL STYLES -->
	<style>
	#cke_description
	{
		width:400px;
	}
</style>
<script>
$('#usualValidate').on('submit', function() {
                    CKEDITOR.instances['ingredients'].updateElement();
            });
$(document).ready(function(){	
// $("#color").chosen();
			// $("#size").chosen();
	
 $('#color').tagsInput({
            width: '360px',
            'onAddTag': function () {
                //alert(1);
            },
        });
        
         $('#size').tagsInput({
             width: '360px',
            'onAddTag': function () {
                //alert(1);
            },
        });

	
	$("#usualValidate").validate({
		ignore : [],  
		rules: {
			
			description:'required',
			
				'photo_image[]':{
						  required: function() { return $("#image_count").val() == 0 ? true:false; },
						 accept: "jpg|jpeg|png|bmp"
						},
			<?php if($store_id==''){?>
			file_up:{required:true,  extension: "jpg|jpeg|gif|png"},
			<?php } ?>
			quantity:'required',
			price:'required',
			'color[]':'required',
			'size[]':'required',
			status : 'required'
			
			
		},
		
	});
	
	
	

	
});	
	


</script>

<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title"><?php if($store_id==""){ echo 'Add Store'; } else { echo 'Edit Store'; }?></h3>
					
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
							<div class="caption"><i class="icon-comments"></i><span style="float: right"><a class="btn black " href="<?php echo site_url('adbstore')?>">Back</a></span></div>
							
						</div>
						<div class="portlet-body form">
							<div class="content">
								<?php
				$attributes = array('id'=>'usualValidate','name'=>'frm_addnews','class'=>'main');
				echo form_open_multipart('store/add_store',$attributes);
			  ?>
			
			  
			  						<div class="control_group">
										<label class="control_label">Product Name :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text"  placeholder="Product Name...." class="m_wrap wid360" name="product_name" id="product_name" value="<?php echo $product_name; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									<div class="control_group">
										<label class="control_label">Description:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<textarea name="description" id="description" placeholder="Description..." class="m_wrap span9 wid360 ckeditor" rows="20" cols="100" data-error-container="#editor1_error"><?php  echo $description ;?></textarea>
											<div id="editor1_error"></div>
										</div>										
										<div class="clear"></div>
										<label for="description" generated="true" style="display: none;" class="error">This field is required.</label>
							  </div>
									<div class="control_group">
										<label class="control_label">Quantity :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Quantity...." class="m_wrap wid360" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									
								<?php /*	<div class="control-group">
											<label class="control-label">Main Product Image</label>
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
												<input type="hidden" name="pre_profile_image" id="pre_profile_image" value="<?php echo $image ?>" />
												</div>
											</div> 
										<?php if(($image!='' && file_exists(base_path().'upload/product_thumb/'.$image))){ ?>
											<br /><br />
											<div class="control-group">
												<label class="control-label"></label>
												<div class="controls">
													<div class="span2">
														<img src="<?php echo front_base_url().'upload/product_thumb/'.$image ?>" width="50"  height="50" />
														<!-- <a href="<?php echo base_url(); ?>adbstore/removeimage/<?php echo $store_id.'/'.$image.'/'.$limit.'/'.$offset.'/'.$redirect_page.'/'.$option.'/'.$keyword; ?>" id="remove" name="remove">Remove image</a> -->														
													</div>
												</div>
											</div>
										<?php } ?>
										<div class="clear"></div>
									</div> */  ?>
									<div class="control_group">
										<label class="control_label">Background Color: <i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											
											<input  type="radio" name="back_col" id="back_col" value="white" <?php if($back_col=='white'){?> checked="checked" <?php } else if($back_col==''){ echo 'checked';  } ?> />White
											<input  type="radio" name="back_col" id="back_col" value="black" <?php if($back_col=='black'){?> checked="checked" <?php } ?>/>Black
										</div>
										&nbsp;<label for="size" generated="true" class="error" style="display: none;">This field is required.</label>
										<div class="clear"></div>
									</div>
									<div class="control-group">
												<label class="control-label">Product Images <i style="color: #7D2A1C;">*</i></label>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery!=''){
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($imageGallery as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
													
												<div class="controls" id="pi_<?php echo $im->product_image_id ?>">
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
											<div class="controls">
												<div class="span1">
												<input type="hidden" name="pre_img[]" value="<?php echo $im->product_image_name ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->product_image_id ?>" />
												<img  style="height: 50px; width: 50px;" src="<?php echo front_base_url().'upload/product_thumb/'.$im->product_image_name ?>" />
											</div>
											</div>
											
											<div class="clear"></div>
											
											
												
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
												<!-- <input type="hidden" name="prev_photo_image" id="prev_photo_image" value="<?php echo @$prev_photo_image; ?>" /> -->
												<div class="clear"></div>
											</div><div class="clear"></div>
											
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div><div class="clear"></div>
									
									
									<div class="control_group">
										<label class="control_label">Price :<i style="color: #7D2A1C;">*</i></label>
										<div class="controls">
											<input type="text" placeholder="Price...." class="m_wrap wid360" name="price" id="price" value="<?php echo $price; ?>">
										</div>										
										<div class="clear"></div>
									</div>
									
									<div class="control_group">
										<label class="control_label">Color:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
											<input id="color" name="color[]" type="text" class="m_wrap wid360 tags" value="<?php echo $color;?>" />
											
										</div>										
										<div class="clear"></div>
									</div>		
									
									<div class="control_group">
										<label class="control_label">Size:<i style="color: #7D2A1C;">*</i></label>
										<div class="controls" >
												<input id="size" name="size[]" type="text" class="m_wrap wid360 tags" value="<?php echo $size;?>" />
										
											
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
									
									
									
									
								
							
							<input type="hidden" name="store_id" id="store_id" value="<?php echo $store_id; ?>" />
				 	    <input type="hidden" name="offset" id="offset" value="<?php echo $offset; ?>" />
						 <input type="hidden" name="limit" id="limit" value="<?php echo $limit; ?>" />
						 <input type="hidden" name="option" id="option" value="<?php echo $option; ?>" />
						 <input type="hidden" name="keyword" id="keyword" value="<?php echo $keyword; ?>" />
						
						 
						 <input type="hidden" name="search_option" id="search_option" value="<?php echo $option; ?>" />
					
						 <input type="hidden" name="redirect_page" id="redirect_page" value="<?php echo $redirect_page; ?>"/>
						 <input type="hidden" name="search_keyword" id="search_keyword" value="<?php echo $keyword; ?>" />
							<div class="form_action">
								
								<?php if($store_id==""){ ?>
					
						<input type="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<?php if($redirect_page == 'list_store')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>store/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php }else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>store/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
						<?php }?>
						
						
						
					<?php }else { ?>
						
						<input type="submit" name="submit" value="Update" class="btn green fl_left mar_r_5" />
						
						<?php if($redirect_page == 'list_store')
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>store/<?php echo $redirect_page.'/'.$limit.'/'.$offset?>'" />
						<?php } else
						{?>
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>store/<?php echo $redirect_page.'/'.$limit.'/'.$option.'/'.$keyword.'/'.$offset?>'" />
						
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

<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/jquery.tagsinput.css" />

<script src="<?php echo base_url().getThemeName();?>/js/jquery.tagsinput.js" type="text/javascript"></script>
	<!-- END FOOTER -->
	<script src="<?php echo base_url().getThemeName(); ?>/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url().getThemeName(); ?>/assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script> -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script>
		jQuery(document).ready(function() {      
			$("#color").chosen();
			$("#size").chosen(); 
		  // $(".chosen").each(function () {
            // $(this).chosen({
                // allow_single_deselect: $(this).attr("data-with-deselect") == "1" ? true : false
            // });
        // });
		});
	</script>

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
			url:'<?php echo site_url('adbstore/removeImageAjax') ?>/'+id,
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