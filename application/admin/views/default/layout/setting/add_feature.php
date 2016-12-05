<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/css/bootstrap-fileupload.css" />
<script src="<?php echo base_url().getThemeName();?>/js/jquery-migrate-1.0.0.js"></script>
<script src="<?php echo base_url().getThemeName();?>/js/bootstrap-fileupload.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.css" />
<script src="<?php echo base_url().getThemeName();?>/datepicker/jquery.datetimepicker.js" type="text/javascript"></script>
<script>

$("#usualValidate").validate({
		
		rules: {
			'fullmug[]':{ required:true},
			'halfmug[]':{ required:true}
			'managedmug[]':{ required:true}
		},	
		 submitHandler: function (form) {
		 	$('#submit').attr('disabled','disabled') ;
		 	$('#submit').val('Processing...') ;
    usualValidate.submit();
		 }		
});	
</script>
<div class="page_content">
			<div class="container_fluid">
				<div class="row_fluid"> 
					<h3 class="page_title">Add Feature</h3>
					
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
				
				<?php  
					if($msg != "") {
						
						if($msg == 'insert') {
							echo '<div class="success_msg"><p>Record has been updated Successfully.</p></div>';
						}
					
						if($msg != "insert"){	
							echo '<div class="success_msg"><p>Record has been updated Successfully</p></div>';	
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
				$attributes = array('id'=>'usualValidate','name'=>'frm_addgallery','class'=>'main');
				echo form_open_multipart('feature/add_feature/',$attributes);
			  ?>
			  <input type="hidden" name="ss" id="ss" value="21" />
			  
									
									<div class="control-group">
												<h6 style="border-bottom: 1px solid #B4CEF8; margin-bottom: 20px; font-size: 20px; padding-bottom: 10px; " class="page_title">Free Listing </h6>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery!=''){
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner">
													<?php foreach($imageGallery as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
											<div id="pi_<?php echo $im->feature_id ?>">		
												
												
											<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap"  name="halfmug[]" id="halfmug[]" value="<?php echo @$im->halfmug; ?>" />
										</div>										
										
									</div>	
									
											<div class="controls">
											<div class="span1">
												<input type="hidden" name="pre_img[]" value="<?php echo $im->halfmug ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->feature_id ?>" />
											</div>
											<div class="">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row" name="add_row" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red" onclick="removeImageDiveAjax('<?php echo $im->feature_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
											</div>
											</div>
											<div class="clear"></div>
											
									
									
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
												<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap" placeholder="Half mug feature...."  name="halfmug[]" id="halfmug[]" value="<?php echo @$im->halfmug; ?>" />
										</div>										
										<div class="clear"></div>
									</div>
												<div class="clear"></div>
											</div>
											<div class="controls">
												<a href="javascript:void(0);" id="add_row" name="add_row" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
											</div>	
											<div class="clear"></div>
								
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div>
									
									
									
									
									
									
									
									<div class="clear"></div>
												<div class="control-group">
												<h6 style="border-bottom: 1px solid #B4CEF8; margin-bottom: 20px; font-size: 20px; padding-bottom: 10px; " class="page_title">Full-Mug (Paid)</h6>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery1!=''){
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery);?>" />
												<div class="" id="inner1">
													<?php foreach($imageGallery1 as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
											<div id="pi_<?php echo $im->feature_id ?>">		
												
												
											<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap"  name="fullmug[]" id="fullmug[]" value="<?php echo @$im->fullmug; ?>" />
										</div>										
									</div>	
									
											<div class="controls">
											<div class="span1">
												<input type="hidden" name="pre_img[]" value="<?php echo $im->fullmug ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->feature_id ?>" />
											</div>
											<div class="">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row1" name="add_row1" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red" onclick="removeImageDiveAjax('<?php echo $im->feature_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
											</div>
											</div>
											<div class="clear"></div>
											
									
									
												</div><div class="clear"></div>
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro1" id="cntpro1" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
													<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro1" id="cntpro1" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner1">
											<div class="controls">
												<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap" placeholder="Full mug feature...."  name="fullmug[]" id="fullmug[]" value="<?php echo @$im->fullmug; ?>" />
										</div>										
										<div class="clear"></div>
									</div>
												<div class="clear"></div>
											</div>
											<div class="controls">
												<a href="javascript:void(0);" id="add_row1" name="add_row1" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
											</div>	
											<div class="clear"></div>
								
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div>
									<div class="clear"></div>
									
									
									
									
									
									
									
									
									<div class="control-group">
												<h6 style="border-bottom: 1px solid #B4CEF8; margin-bottom: 20px; font-size: 20px; padding-bottom: 10px; " class="page_title">Managed Bar (Paid)</h6>
												
												<?php // print_r($imageGallery);die;
												if($imageGallery2!=''){
													$i=0;?>
													<input type="hidden" name="image_count" id="image_count" value="<?php echo count($imageGallery2);?>" />
												<div class="" id="inner2">
													<?php foreach($imageGallery2 as $im){
														
													//if($im->image_name!='' && file_exists(base_path().'/upload/Product/'.$im->image_name)){	
													?>
											<div id="pi_<?php echo $im->feature_id ?>">		
												
												
											<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap"  name="managedmug[]" id="managedmug[]" value="<?php echo @$im->managedmug; ?>" />
										</div>										
									</div>	
									
											<div class="controls">
											<div class="span1">
												<input type="hidden" name="pre_img[]" value="<?php echo $im->managedmug ?>" />
												<input type="hidden" name="image_id[]" value="<?php echo $im->feature_id ?>" />
											</div>
											<div class="">
												<?php if($i==0){ ?>
												<a href="javascript:void(0);" id="add_row2" name="add_row2" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
												<?php }else{ ?>
												<a href="javascript://" style="margin-left: 10px;" class="table_icon btn red" onclick="removeImageDiveAjax('<?php echo $im->feature_id ?>')"><i class="comon_icon delete_icon"></i></a>
												<?php } ?>
												
											</div>
											</div>
											<div class="clear"></div>
											
									
									
												</div><div class="clear"></div>
											
												
												<?php $i++;  /*}*/ } ?>
												</div>
												<input type="hidden" name="cntpro2" id="cntpro2" value="<?php echo $i; ?>" />
												<span class="controls" style="display: none;color: #B94A48;" class="help-inline" id="cantADD">You can upload maximim 7 images.</span>
												<?php  }else{ ?>
													<input type="hidden" name="image_count" id="image_count" value="0" />
														<input type="hidden" name="cntpro2" id="cntpro2" value="0" />	
												<div class="controls" id="main">
												<div class="control-group">
											<div id="inner2">
											<div class="controls">
												<div class="control_group">
										<div class="controls">
											<input type="text" class="wid360 m_wrap" placeholder="Managed Bar feature...."  name="managedmug[]" id="managedmug[]" value="<?php echo @$im->managedmug; ?>" />
										</div>										
										<div class="clear"></div>
									</div>
												<div class="clear"></div>
											</div>
											<div class="controls">
												<a href="javascript:void(0);" id="add_row2" name="add_row2" class="btn blue table_icon margin-left-10"><i class="comon_icon addmore_icon"></i></a>
											</div>	
											<div class="clear"></div>
								
											
									</div>	
									<div class="clear"></div>
									</div>
											
												</div>
										<?php } ?>
									</div><div class="clear"></div>
					
						 <input type="hidden" name="bar_gallery_id" id="bar_gallery_id" value="<?php echo @$feature_id; ?>" />
							<div class="form_action">
								
					
						<input type="submit" id="submit" name="submit" value="Submit" class="btn green fl_left mar_r_5" />
						<input type="button" name="Cancel" value="Cancel" class="btn red  fl_left" onClick="location.href='<?php echo base_url(); ?>feature/add_feature'" />
					
					
					
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
		//$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="fileupload fileupload-new pull-left" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div>');
		$('#inner').append('<div id="img_'+cnt+'" style="display:none; margin-top:10px;"><div class="controls"><input type="text" placeholder="Half mug feature...." class="m_wrap wid360" name="halfmug[]" id="halfmug[]" value=""  /></div><div class="controls"><div class="span3"><a style="margin-left:10px; margin-top:0px;" href="javascript://" class="table_icon btn red" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div><div class="clear"></div></div></div><div class="clear"></div></div></div>');
		$('#img_'+cnt).slideDown();
			
		});
		
		$('#add_row1').click(function(){
	  //if(parseInt($('#cntpro').val())<7){
		//	$('#cantADD').hide();
		var cnt=parseInt($('#cntpro1').val())+1;
		if($('#cntpro1').val() =='NaN')
		{
		    $('#cntpro1').val('1');
		    cnt = 1;
		}
		$('#cntpro1').val(cnt)
		//$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="fileupload fileupload-new pull-left" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div>');
		$('#inner1').append('<div id="img1_'+cnt+'" style="display:none; margin-top:10px;"><div class="controls"><input type="text" placeholder="Full mug feature...." class="m_wrap wid360" name="fullmug[]" id="fullmug[]" value=""  /></div><div class="controls"><div class="span3"><a style="margin-left:10px; margin-top:0px;" href="javascript://" class="table_icon btn red" onclick="removeImageDive1(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div><div class="clear"></div></div></div><div class="clear"></div></div></div>');
		$('#img1_'+cnt).slideDown();
			
		});
		
		$('#add_row2').click(function(){
	  //if(parseInt($('#cntpro').val())<7){
		//	$('#cantADD').hide();
		var cnt=parseInt($('#cntpro2').val())+1;
		if($('#cntpro2').val() =='NaN')
		{
		    $('#cntpro2').val('1');
		    cnt = 1;
		}
		$('#cntpro2').val(cnt)
		//$('#inner').append('<div class="row-fluid  margin-top-10" id="img_'+cnt+'" style="display:none;"><div class=""><div class="fileupload fileupload-new pull-left" data-provides="fileupload"><div class="uneditable-input"><i class="icon-file fileupload-exists"></i><span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" class="default"  accept="image/*" name="photo_image[]" id="photo_image_'+cnt+'" /></span><a href="javascript://" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a></div><a href="javascript://" class="table_icon btn red margin-top-10 margin-left-10" onclick="removeImageDive(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div></div><div class="clear"></div>');
		$('#inner2').append('<div id="img2_'+cnt+'" style="display:none; margin-top:10px;"><div class="controls"><input type="text" placeholder="Managed Bar feature...." class="m_wrap wid360" name="managedmug[]" id="managedmug[]" value=""  /></div><div class="controls"><div class="span3"><a style="margin-left:10px; margin-top:0px;" href="javascript://" class="table_icon btn red" onclick="removeImageDive2(\''+cnt+'\')"><i class="comon_icon delete_icon"></i></a></div></div><div class="clear"></div></div></div><div class="clear"></div></div></div>');
		$('#img2_'+cnt).slideDown();
			
		});
function removeImageDive(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro').val())-1;
	//(parseInt(cnt)<7)?$('#cantADD').hide():'';
		$('#cntpro').val(cnt);
		$('#img_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	
	function removeImageDive1(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro1').val())-1;
	//(parseInt(cnt)<7)?$('#cantADD1').hide():'';
		$('#cntpro1').val(cnt);
		$('#img1_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
	function removeImageDive2(id)
	{
	   // alert("removeImageDive");    
	   // alert(id);
		var cnt=parseInt($('#cntpro2').val())-1;
//	(parseInt(cnt)<7)?$('#cantADD1').hide():'';
		$('#cntpro2').val(cnt);
		$('#img2_'+id).slideUp('normal',function(){	$(this).remove(); });
	}
function removeImageDiveAjax(id)
{
     //   alert("removeImageDiveAjax");
      //  alert(id);
	var r=confirm('Are you sure ,you want to delete this feature ?');
	if(r==true)
	{
		$.ajax({
			url:'<?php echo site_url('feature/removefeature') ?>/'+id,
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
